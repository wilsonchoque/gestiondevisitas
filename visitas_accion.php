<?php

//visitas_accion.php

include('vms.php');

$visitor = new vms();

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('tabla_visitas.visita_nombre', 'tabla_visitas.visita_apersona', 'tabla_visitas.visita_aoficina', 'tabla_visitas.visita_entrada', 'tabla_visitas.visita_salida', 'tabla_visitas.visita_estado', 'tabla_admin.admin_name');

		$output = array();

		$main_query = "
		SELECT * FROM tabla_visitas 
		INNER JOIN tabla_admin 
		ON tabla_admin.admin_id = tabla_visitas.visita_registradapor 
		";

		if(!$visitor->is_master_user())
		{
			$main_query .= "
			WHERE tabla_visitas.visita_registradapor = '".$_SESSION["admin_id"]."' 
			";

			if($_POST["from_date"] != '')
			{
				$search_query = "
				AND DATE(tabla_visitas.visita_entrada) BETWEEN '".$_POST["from_date"]."' AND  '".$_POST["to_date"]."' AND ( 
				";
			}
			else
			{
				$search_query = " AND ( ";	
			}
			
		}
		else
		{
			if($_POST["from_date"] != '')
			{
				$search_query = "WHERE DATE(tabla_visitas.visita_entrada) BETWEEN '".$_POST["from_date"]."' AND  '".$_POST["to_date"]."' AND ( ";
			}
			else
			{
				$search_query = "WHERE ";	
			}
		}
		

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'tabla_visitas.visita_nombre LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR tabla_visitas.visita_apersona LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR tabla_visitas.visita_aoficina LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR tabla_visitas.visita_entrada LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR tabla_visitas.visita_salida LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR tabla_visitas.visita_estado LIKE "%'.$_POST["search"]["value"].'%" ';
			
			if($visitor->is_master_user())
			{
				$search_query .= 'OR tabla_admin.admin_name LIKE "%'.$_POST["search"]["value"].'%" ';
				if($_POST["from_date"] != '')
				{
					$search_query .= ') ';
				}
			}
			else
			{
				$search_query .= ') ';
			}
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY tabla_visitas.visita_id DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$visitor->query = $main_query . $search_query . $order_query;

		$visitor->execute();

		$filtered_rows = $visitor->row_count();

		$visitor->query .= $limit_query;

		$result = $visitor->get_result();

		$visitor->query = $main_query;

		$visitor->execute();

		$total_rows = $visitor->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = html_entity_decode($row["visita_nombre"]);
			$sub_array[] = html_entity_decode($row["visita_apersona"]);
			$sub_array[] = $row["visita_aoficina"];
			$sub_array[] = $row["visita_entrada"];
			$sub_array[] = $row["visita_salida"];
			$status = '';
			if($row["visita_estado"] == 'In')
			{
				$status = '<span class="badge badge-success">En Instalaciones</span>';
			}
			else
			{
				$status = '<span class="badge badge-danger">Visita Finalizada</span>';
			}
			$sub_array[] = $status;
			if($visitor->is_master_user())
			{
				$sub_array[] = $row["admin_name"];
			}
			$sub_array[] = '
			<div align="center">
			<button type="button" name="view_button" class="btn btn-primary btn-sm view_button" data-id="'.$row["visita_id"].'"><i class="fas fa-user-slash"></i></button>
			&nbsp;
			<button type="button" name="edit_button" class="btn btn-info btn-sm edit_button" data-id="'.$row["visita_id"].'"><i class="fas fa-user-edit"></i></button>
			&nbsp;
			<button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="'.$row["visita_id"].'"><i class="fas fa-user-times"></i></button>
			</div>
			';
			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);

	}

	if($_POST["action"] == 'Add')
	{
		$data = array(
			':visita_nombre'			=>	$visitor->clean_input($_POST["visita_nombre"]),			
			':visita_dni'	=>	$_POST["visita_dni"],			
			':visita_apersona' =>	$_POST["visita_apersona"],
			':visita_aoficina'	=>	$_POST["visita_aoficina"],
			':visita_motivo' =>	$visitor->clean_input($_POST["visita_motivo"]),
			':visita_entrada'	=>	$visitor->get_datetime(),
			':visita_observaciones'=>	'',
			':visita_salida'		=>	'',
			':visita_estado'		=>	'In',
			':visita_registradapor'		=>	$_SESSION["admin_id"]
		);

		$visitor->query = "
		INSERT INTO tabla_visitas 
		(visita_nombre, visita_dni, visita_apersona, visita_aoficina, visita_motivo, visita_entrada, visita_observaciones, visita_salida, visita_estado, visita_registradapor) 
		VALUES (:visita_nombre, :visita_dni, :visita_apersona, :visita_aoficina, :visita_motivo, :visita_entrada, :visita_observaciones, :visita_salida, :visita_estado, :visita_registradapor)
			";

		$visitor->execute($data);

		echo '<div class="alert alert-success">Visita Registrada</div>';
	}

	if($_POST["action"] == 'fetch_single')
	{
		$visitor->query = "
		SELECT * FROM tabla_visitas 
		WHERE visita_id = '".$_POST["visita_id"]."'
		";

		$result = $visitor->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['visita_nombre'] = $row['visita_nombre'];			
			$data['visita_dni'] = $row['visita_dni'];			
			$data['visita_apersona'] = $row['visita_apersona'];
			$data['visita_aoficina'] = $row['visita_aoficina'];
			$data['visita_motivo'] = $row['visita_motivo'];
			$data['visita_observaciones'] = $row['visita_observaciones'];
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$data = array(
			':visita_nombre'			=>	$visitor->clean_input($_POST["visita_nombre"]),			
			':visita_dni'	=>	$_POST["visita_dni"],			
			':visita_apersona' =>	$_POST["visita_apersona"],
			':visita_aoficina'	=>	$_POST["visita_aoficina"],
			':visita_motivo' =>	$visitor->clean_input($_POST["visita_motivo"]),
		);

		$visitor->query = "
		UPDATE tabla_visitas 
		SET visita_nombre = :visita_nombre,		
		visita_dni = :visita_dni,		 
		visita_apersona = :visita_apersona, 
		visita_aoficina = :visita_aoficina, 
		visita_motivo = :visita_motivo 
		WHERE visita_id = '".$_POST['hidden_id']."'
		";

		$visitor->execute($data);

		echo '<div class="alert alert-success">Visita Actualizada</div>';
	}

	if($_POST["action"] == 'delete')
	{
		$visitor->query = "
		DELETE FROM tabla_visitas 
		WHERE visita_id = '".$_POST["id"]."'
		";

		$visitor->execute();

		echo '<div class="alert alert-success">Visita Eliminada</div>';
	}

	if($_POST["action"] == 'update_outing_detail')
	{
		$data = array(
			':visita_observaciones'	=>	$visitor->clean_input($_POST["visita_observaciones"]),
			':visita_salida'			=>	$visitor->get_datetime(),
			':visita_estado'			=>	'Out'
		);

		$visitor->query = "
		UPDATE tabla_visitas 
		SET visita_observaciones = :visita_observaciones, 
		visita_salida = :visita_salida, 
		visita_estado = :visita_estado 
		WHERE visita_id = '".$_POST["hidden_visita_id"]."'
		";

		$visitor->execute($data);

		echo '<div class="alert alert-success">Vista Actualizada</div>';
	}
}

?>