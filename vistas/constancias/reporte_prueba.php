<?php
require('textFPDF.php');
date_default_timezone_set('America/El_Salvador');

class PDF extends textFPDF
{

    // SOBREESCRIBIENDO EL METODO PARA QUE SALGA EL ENCABEZADO NUEVAMENTE
    function CheckPageBreak($h, $setX)
    {

        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
            $this->SetX($setX);
            $this->SetFillColor(97, 152, 243);
            $this->SetDrawColor(0, 0, 0);

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(80, 10, 'Producto', 1, 0, 'C', 1);
            $this->Cell(80, 10, 'Cantidad', 1, 1, 'C', 1);

            $this->SetFont('Arial', '', 12);
            $this->SetFillColor(255, 255, 255);
            $this->SetDrawColor(0, 0, 0);
        }


        $this->SetX($setX);
    }
}


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 35);
// $pdf->SetTopMargin(10);
$pdf->SetTopMargin(50);
$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(10);


$pdf->Ln(30);

$pdf->Cell(0, 10, utf8_decode('REPORTE DE PRUEBA '), 0, 0, 'C', 0);


$pdf->Ln(16);



$pdf->SetX(30);
/* ---Titulo de Tabla --- */
$pdf->SetFillColor(97, 152, 243);
$pdf->SetDrawColor(0, 0, 0);

$pdf->Cell(80, 10, 'Producto', 1, 0, 'C', 1);
$pdf->Cell(80, 10, 'Cantidad', 1, 1, 'C', 1);


$pdf->SetWidths(array(80, 80));
// $pdf->SetAligns(array('C', 'L'));
$pdf->SetFont('', '', 12);
$pdf->SetFillColor(255, 255, 255);


for ($i = 0; $i < 40; $i++) {

    $pdf->Row(array(utf8_decode(ucwords(strtolower('Hola Mundo'))), utf8_decode('Hola Mundo')), 30, array('hola'));
}



$pdf->Output("Reporte de Prueba.pdf", "I");
