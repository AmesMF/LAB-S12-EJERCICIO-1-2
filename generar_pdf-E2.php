<?php
require('fpdf.php');
require 'conexion.php';

// Consulta para obtener datos de compras
$consulta = "SELECT 
                p.nombre, 
                p.dni, 
                pr.producto, 
                pr.precio_unitario, 
                pr.cantidad, 
                (pr.precio_unitario * pr.cantidad) AS precio_total
            FROM personas p
            JOIN productos pr ON p.id = pr.id_persona";
$resultado = $mysqli->query($consulta);

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Reporte de Compras', 0, 1, 'C');
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(40, 10, 'Nombre', 1);
        $this->Cell(30, 10, 'DNI', 1);
        $this->Cell(50, 10, 'Producto', 1);
        $this->Cell(30, 10, 'Precio Unit.', 1);
        $this->Cell(20, 10, 'Cantidad', 1);
        $this->Cell(30, 10, 'Total', 1);
        $this->Ln();
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

while ($row = $resultado->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['nombre'], 1);
    $pdf->Cell(30, 10, $row['dni'], 1);
    $pdf->Cell(50, 10, $row['producto'], 1);
    $pdf->Cell(30, 10, $row['precio_unitario'], 1);
    $pdf->Cell(20, 10, $row['cantidad'], 1);
    $pdf->Cell(30, 10, $row['precio_total'], 1);
    $pdf->Ln();
}

$pdf->Output();
?>
