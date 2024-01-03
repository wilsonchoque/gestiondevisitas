<?php

require('vms.php'); // Asegúrate de incluir el archivo vms.php adecuadamente

$visitor = new vms();

// Realizar la consulta SQL similar a tu código original
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

// Crear instancia de FPDF
require('./fpdf.php');
$pdf = new FPDF();
$pdf->AddPage("L"); // Establecer orientación a paisaje


$pdf->setY(11);
$pdf->setX(10);   
$pdf->Image('logompr.png', 10, 11, 34); // Ajusta las coordenadas para la posición del logo
$pdf->SetFont('Arial', '', 9);   
$pdf->Text(36, 16, utf8_decode('REPORTE DE VISITAS - Gobierno Regional Puno'));  
$pdf->Text(36, 21, utf8_decode('Jr. Deustua 356, Puno'));
$pdf->Text(36, 25, utf8_decode('gobernacion@regionpuno.gob.pe.'));
$pdf->Ln(7);



// Establecer fuente y tamaño para el título
$pdf->SetTextColor(0, 41, 89);
$pdf->Cell(100);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(100, 10, 'INFORME DE VISITAS', 0, 1, 'C');
$pdf->Ln(7);

// Establecer fuente para el contenido
$pdf->SetFillColor(244, 246, 246); // Color de fondo
$pdf->SetTextColor(28, 48, 51); // Color del texto
$pdf->SetDrawColor(163, 163, 163); // Color del borde
$pdf->SetFont('Arial', 'B', 6);

// Establecer fuente para el contenido
$pdf->SetFillColor(244, 246, 246); // Color de fondo
$pdf->SetTextColor(28, 48, 51); // Color del texto
$pdf->SetDrawColor(163, 163, 163); // Color del borde
$pdf->SetFont('Arial', 'B', 6);

// Establecer fuente para el contenido
$pdf->SetFillColor(244, 246, 246); // Color de fondo
$pdf->SetTextColor(28, 48, 51); // Color del texto
$pdf->SetDrawColor(163, 163, 163); // Color del borde
$pdf->SetFont('Arial', 'B', 8);

// Definir encabezados y tamaños de celda correspondientes
$headers = array("Nro" => 7, "VISITANTE" => 55, "DNI" => 15, "OFICINA VISITADA" => 50, "VISITADO" => 55, "MOTIVO" => 25, "INGRESO" => 30, "SALIDA" => 30, "ESTADO" => 15);

// Imprimir encabezados con colores y borde
foreach ($headers as $header => $cellWidth) {
    $pdf->Cell($cellWidth, 10, $header, 1, 0, 'C', true); // Ajustar el tamaño de celda según el valor correspondiente
}
$pdf->Ln();


$pdf->SetFillColor(255, 255, 255); // Restauramos el color de fondo
$pdf->SetTextColor(0, 0, 0); // Restauramos el color de texto

// Agregar los resultados de la consulta a la tabla
foreach ($result as $row) {
    $fieldsToShow = array("visita_id", "visita_nombre", "visita_dni", "visita_aoficina", "visita_apersona", "visita_motivo", "visita_entrada","visita_salida", "visita_estado");
    
    // Ajustar los tamaños de celda para los campos específicos
    $pdf->Cell(7, 8, $row["visita_id"], 1); // Cambiar el tamaño a 30 de ancho y 8 de alto para visita_id
    $pdf->Cell(55, 8, $row["visita_nombre"], 1); // Cambiar el tamaño a 40 de ancho y 8 de alto para visita_nombre
    $pdf->Cell(15, 8, $row["visita_dni"], 1); // Cambiar el tamaño a 30 de ancho y 8 de alto para visita_dni
    $pdf->Cell(50, 8, $row["visita_aoficina"], 1); // Cambiar el tamaño a 40 de ancho y 8 de alto para visita_aoficina
    
    // Utilizar MultiCell para los campos con contenido largo
    $pdf->Cell(55, 8, $row["visita_apersona"], 1); // Cambiar el tamaño a 30 de ancho y 8 de alto para visita_apersona
    
    // Resto de los campos
    $pdf->Cell(25, 8, $row["visita_motivo"], 1); // Cambiar el tamaño a 30 de ancho y 8 de alto para visita_motivo
    $pdf->Cell(30, 8, $row["visita_entrada"], 1); // Cambiar el tamaño a 30 de ancho y 8 de alto para visita_entrada
    $pdf->Cell(30, 8, $row["visita_salida"], 1); // Cambiar el tamaño a 30 de ancho y 8 de alto para visita_salida
    $pdf->Cell(15, 8, $row["visita_estado"], 1); // Cambiar el tamaño a 30 de ancho y 8 de alto para visita_estado
    
    $pdf->Ln();
}


// Agregar espacio entre la tabla de detalles y los datos resumen
$pdf->Ln(10);



// Restaurar el color de fondo y borde para las celdas de números
$pdf->SetFillColor(255, 255, 255); // Color de fondo blanco
$pdf->SetDrawColor(0, 0, 0); // Restaurar el color de borde predeterminado




// Definir el número total de páginas
$pdf->AliasNbPages();

// Agregar los resultados de la consulta a la tabla
foreach ($result as $row) {
    // ... (tu código para mostrar los detalles de cada visita)
    $pdf->Ln();
}

// Footer en todas las páginas
$pdf->SetY(-15);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 10, 'Pagina ' . $pdf->PageNo() . ' de {nb}', 0, 0, 'C'); // Número de página

$pdf->SetY(-15);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Fecha ' . date('d/m/Y H:i:s'), 0, 0, 'R'); // Hora de impresión

// Generar el PDF
$pdf->Output('reporte.pdf', 'I'); // Mostrar el PDF en el navegador con el nombre "reporte.pdf"
exit;



?>
