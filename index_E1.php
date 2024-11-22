<?php
require 'fpdf.php';
class PDF extends FPDF{
    // Cabecera de Página
    function Header(){
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(60);
        // Título
        $this->Cell(70, 10, 'Reporte de Productos', 1, 0, 'C');
        // Salto de Línea
        $this->Ln(20);

        $this->Cell(100, 10, 'Nombre', 1, 0, 'C', 0);
        $this->Cell(45, 10, 'Precio', 1, 0, 'C', 0);
        $this->Cell(45, 10, 'Stock',  1, 1, 'C', 0);
    }
    // Píe de Página
    function Footer(){
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8 
        $this->SetFont('Arial', 'I', 8);
        // Número de Página
        $this->Cell(0, 10, 'Page'.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}
require 'Conexion.php';
$consulta="SELECT * FROM productos";
$resultado= $mysqli->query($consulta);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

while ($row = $resultado->fetch_assoc()){
    $pdf->Cell(100, 10, $row['Nombre'], 1, 0, 'C', 0);
    $pdf->Cell(45, 10, $row['Precio'], 1, 0, 'C', 0);
    $pdf->Cell(45, 10, $row['stock'],  1, 1, 'C', 0);
}
$pdf->Output();
?>