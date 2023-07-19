<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // ... código de la clase PDF ...
}

$pdf = new PDF();
$pdf->SetFont('Arial', '', 8);

include "../conexion.php";

// Obtener los parámetros de búsqueda
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';
$nombre = $_GET['nombre'] ?? '';
$dni = $_GET['dni'] ?? '';
$estado = $_GET['estado'] ?? '';

// Construir la consulta SQL
$query = "SELECT Pedido.id_pedido, Pedido.observacion, Pedido.desc_falla, Pedido.fecha, Cliente.nombre AS cliente_nombre, Pedido.estado FROM Pedido INNER JOIN Cliente ON Pedido.id_cliente = Cliente.id_cliente WHERE 1";

if (!empty($fecha_inicio) && !empty($fecha_fin)) {
    $query .= " AND Pedido.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
}

if (!empty($nombre)) {
    $query .= " AND Cliente.nombre LIKE '%$nombre%'";
}

if (!empty($dni)) {
    $query .= " AND Cliente.dni = '$dni'";
}

if (!empty($estado)) {
    $query .= " AND Pedido.estado = '$estado'";
}

$resultado = mysqli_query($conexion, $query);

$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 5, 'Lista de Pedidos', 0, 1, 'C');
$pdf->Ln(8); // Salto de línea adicional después del título
while ($row = mysqli_fetch_assoc($resultado)) {
    // Verifica si es necesario agregar una nueva página (opcional)
    // if ($pdf->GetY() + 10 > $pdf->GetPageHeight() - $pdf->bMargin) {
    //     $pdf->AddPage();
    // }
    // Genera las celdas de la fila de la tabla
    $pdf->Cell(4, 10, $row['id_pedido'], 1, 0, 'C');
    $pdf->Cell(68, 10, $row['observacion'], 1, 0, 'C');
    $pdf->Cell(63, 10, $row['desc_falla'], 1, 0, 'C');
    $pdf->Cell(15, 10, $row['fecha'], 1, 0, 'C');
    $pdf->Cell(23, 10, $row['cliente_nombre'], 1, 0, 'C');
    $pdf->Cell(19, 10, $row['estado'], 1, 0, 'C');
    $pdf->Ln();
}

$pdf->Output();
?>
