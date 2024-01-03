<?php

//vms.php

class vms
{
	public $base_url = 'http://localhost/pvisitas/';
	public $connect;
	public $query;
	public $statement;

	function vms()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=pvisitas", "root", "");
		session_start();
	}

	function execute($data = null)
	{
		$this->statement = $this->connect->prepare($this->query);
		if($data)
		{
			$this->statement->execute($data);
		}
		else
		{
			$this->statement->execute();
		}		
	}

	function row_count()
	{
		return $this->statement->rowCount();
	}

	function statement_result()
	{
		return $this->statement->fetchAll();
	}

	function get_result()
	{
		return $this->connect->query($this->query, PDO::FETCH_ASSOC);
	}

	function is_login()
	{
		if(isset($_SESSION['admin_id']))
		{
			return true;
		}
		return false;
	}

	function is_master_user()
	{
		if(isset($_SESSION['admin_type']))
		{
			if($_SESSION["admin_type"] == 'Master')
			{
				return true;
			}
			return false;
		}
		return false;
	}

	function clean_input($string)
	{
	  	$string = trim($string);
	  	$string = stripslashes($string);
	  	$string = htmlspecialchars($string);
	  	return $string;
	}

	function get_datetime()
	{		
	date_default_timezone_set('America/Lima'); // Establecer la zona horaria de Perú

    return date("Y-m-d h:i:s A"); // Obtener la fecha y hora actual en la zona horaria de Perú
	}

	

	function load_department()
	{
		$this->query = "
		SELECT * FROM tabla_oficinas 
		ORDER BY oficina_nombre ASC
		";
		$result = $this->get_result();
		$output = '';
		foreach($result as $row)
		{
			$output .= '<option value="'.$row["oficina_nombre"].'" data-person="'.$row["oficina_personal"].'">'.$row["oficina_nombre"].'</option>';
		}
		return $output;
	}

	function Get_profile_image()
	{
		$this->query = "
		SELECT admin_profile FROM tabla_admin 
		WHERE admin_id = '".$_SESSION["admin_id"]."'
		";

		$result = $this->get_result();

		foreach($result as $row)
		{
			return $row['admin_profile'];
		}
	}

	function Get_total_today_visitor()
	{
		$this->query = "
		SELECT * FROM tabla_visitas 
		WHERE DATE(visita_entrada) = DATE(NOW())
		";

		if(!$this->is_master_user())
		{
			$this->query .= " AND visita_registradapor ='".$_SESSION["admin_id"]."'";
		}

		$this->execute();
		return $this->row_count();
	}

	function Get_total_yesterday_visitor()
	{
		$this->query = "
		SELECT * FROM tabla_visitas 
		WHERE DATE(visita_entrada) = DATE(NOW()) - INTERVAL 1 DAY
		";
		if(!$this->is_master_user())
		{
			$this->query .= " AND visita_registradapor ='".$_SESSION["admin_id"]."'";
		}
		$this->execute();
		return $this->row_count();
	}

	function Get_last_seven_day_total_visitor()
	{
		$this->query = "
		SELECT * FROM tabla_visitas 
		WHERE DATE(visita_entrada) >= DATE(NOW()) - INTERVAL 7 DAY
		";
		if(!$this->is_master_user())
		{
			$this->query .= " AND visita_registradapor ='".$_SESSION["admin_id"]."'";
		}
		$this->execute();
		return $this->row_count();
	}

	function Get_total_visitor()
	{
		$this->query = "
		SELECT * FROM tabla_visitas 
		";
		if(!$this->is_master_user())
		{
			$this->query .= " WHERE visita_registradapor ='".$_SESSION["admin_id"]."'";
		}
		$this->execute();
		return $this->row_count();
	}

	function Get_profile_name()
	{
		$this->query = "
		SELECT admin_name FROM tabla_admin 
		WHERE admin_id = '".$_SESSION["admin_id"]."'
		";

		$result = $this->get_result();

		foreach($result as $row)
		{
			return $row['admin_name'];
		}
	}




}


?>