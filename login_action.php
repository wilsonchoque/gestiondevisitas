<?php

//login_action.php

include('vms.php');

$visitor = new vms();

if($_POST["user_email"])
{
	sleep(2);
	$error = '';
	$data = array(
		':admin_email'	=>	$_POST["user_email"]
	);

	$visitor->query = "
		SELECT * FROM tabla_admin 
		WHERE admin_email = :admin_email
	";

	$visitor->execute($data);

	//$statement = $visitor->connect->prepare($query);

	//$statement->execute($data);

	//$total_row = $statement->rowCount();

	$total_row = $visitor->row_count();

	if($total_row == 0)
	{
		$error = 'Correo Incorrecto';
	}
	else
	{
		//$result = $statement->fetchAll();

		$result = $visitor->statement_result();

		foreach($result as $row)
		{
			if($row["admin_status"] == 'Enable')
			{
				if(password_verify($_POST["user_password"], $row["admin_password"]))
				{
					$_SESSION['admin_id'] = $row['admin_id'];
					$_SESSION['admin_type'] = $row['admin_type'];
				}
				else
				{
					$error = 'Contraseña Incorrecta';
				}
			}
			else
			{
				$error = 'Cuenta Desactivada, Contacte al Administrador';
			}
		}
	}

	$output = array(
		'error'		=>	$error
	);

	echo json_encode($output);
}

?>