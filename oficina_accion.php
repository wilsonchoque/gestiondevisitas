<?php

//oficina_accion.php

include('vms.php');

$visitor = new vms();

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('oficina_nombre', 'oficina_personal');

		$output = array();

		$main_query = "
		SELECT * FROM tabla_oficinas ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE oficina_nombre LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR oficina_personal LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY oficina_id DESC ';
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
			$sub_array[] = html_entity_decode($row["oficina_nombre"]);
			$sub_array[] = html_entity_decode($row["oficina_personal"]);
			$sub_array[] = '
			<div align="center">
			<button type="button" name="edit_button" class="btn btn-warning btn-sm edit_button" data-id="'.$row["oficina_id"].'"><i class="fas fa-edit"></i></button>
			&nbsp;
			<button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="'.$row["oficina_id"].'"><i class="fas fa-times"></i></button>
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
		$error = '';

		$success = '';

		$data = array(
			':oficina_nombre'	=>	$_POST["oficina_nombre"]
		);

		$visitor->query = "
		SELECT * FROM tabla_oficinas 
		WHERE oficina_nombre = :oficina_nombre
		";

		$visitor->execute($data);

		if($visitor->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Department Already Exists</div>';
		}
		else
		{
			$oficina_personal = implode(", ", $_POST["oficina_personal"]);

			$data = array(
				':oficina_nombre'		=>	$visitor->clean_input($_POST["oficina_nombre"]),
				':oficina_personal'	=>	$visitor->clean_input($oficina_personal),
				':oficina_creada'	=>	$visitor->get_datetime()
			);

			$visitor->query = "
			INSERT INTO tabla_oficinas 
			(oficina_nombre, oficina_personal, oficina_creada) 
			VALUES (:oficina_nombre, :oficina_personal, :oficina_creada)
			";

			$visitor->execute($data);

			$success = '<div class="alert alert-success">Oficina Agregada</div>';
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_single')
	{
		$visitor->query = "
		SELECT * FROM tabla_oficinas 
		WHERE oficina_id = '".$_POST["oficina_id"]."'
		";

		$result = $visitor->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['oficina_nombre'] = $row['oficina_nombre'];
			$data['oficina_personal'] = $row['oficina_personal'];
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':oficina_nombre'	=>	$_POST["oficina_nombre"],
			':oficina_id'	=>	$_POST['hidden_id']
		);

		$visitor->query = "
		SELECT * FROM tabla_oficinas 
		WHERE oficina_nombre = :oficina_nombre 
		AND oficina_id != :oficina_id
		";

		$visitor->execute($data);

		if($visitor->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">La Oficina ya existe</div>';
		}
		else
		{
			$oficina_personal = implode(", ", $_POST["oficina_personal"]);

			$data = array(
				':oficina_nombre'		=>	$visitor->clean_input($_POST["oficina_nombre"]),
				':oficina_personal'	=>	$visitor->clean_input($oficina_personal)
			);

			$visitor->query = "
			UPDATE tabla_oficinas 
			SET oficina_nombre = :oficina_nombre, 
			oficina_personal = :oficina_personal  
			WHERE oficina_id = '".$_POST['hidden_id']."'
			";

			$visitor->execute($data);

			$success = '<div class="alert alert-success">Oficina Actualizada</div>';
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'delete')
	{
		$visitor->query = "
		DELETE FROM tabla_oficinas 
		WHERE oficina_id = '".$_POST["id"]."'
		";

		$visitor->execute();

		echo '<div class="alert alert-success">Oficina Eliminada</div>';
	}
}

?>