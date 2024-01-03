<?php

//export.php

include('vms.php');

$visitor = new vms();

$file_name = md5(rand()) . '.csv';
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$file_name");
header("Content-Type: application/csv;");
$file = fopen("php://output", "w");
$header = array("Visitante ID", "Nombre Visitante", "Correo", "DNI Visitante", "Direccion", "Oficina Visitada", "Personal Visitado", "Motivo de Visita", "Hora Ingreso", "Observacion de salida", "Hora Salida", "Estado de Visita", "Registrado Por");
fputcsv($file, $header);

if(isset($_GET["from_date"]) && isset($_GET["to_date"]))
{
	$visitor->query = "
	SELECT * FROM tabla_visitas 
	INNER JOIN tabla_admin 
	ON tabla_admin.admin_id = tabla_visitas.visita_registradapor 
	WHERE DATE(tabla_visitas.visita_entrada) BETWEEN '".$_GET["from_date"]."' AND '".$_GET["to_date"]."' 
	";
	if(!$visitor->is_master_user())
	{
		$visitor->query .= ' AND tabla_visitas.visita_registradapor = "'.$_SESSION["admin_id"].'" ';
	}

}
else
{
	$visitor->query = "
	SELECT * FROM tabla_visitas 
	INNER JOIN tabla_admin 
	ON tabla_admin.admin_id = tabla_visitas.visita_registradapor 
	";
	if(!$visitor->is_master_user())
	{
		$visitor->query .= ' WHERE tabla_visitas.visita_registradapor = "'.$_SESSION["admin_id"].'" ';
	}
}

$visitor->query .= 'ORDER BY tabla_visitas.visita_id DESC';

$result = $visitor->get_result();

foreach($result as $row)
{
	$data = array();
	$data[] = $row["visita_id"];
	$data[] = $row["visita_nombre"];
	$data[] = $row["visita_dni"];
	$data[] = $row["visita_aoficina"];
	$data[] = $row["visita_apersona"];
	$data[] = $row["visita_motivo"];
	$data[] = $row["visita_entrada"];
	$data[] = $row["visita_observaciones"];
	$data[] = $row["visita_salida"];
	$data[] = $row["visita_estado"];
	$data[] = $row["admin_name"];
	fputcsv($file, $data);
}
fclose($file);
exit;

?>