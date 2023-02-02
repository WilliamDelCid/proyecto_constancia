<?php
require('./librerias/fpdf/fpdf.php');
date_default_timezone_set('America/El_Salvador');
class textFPDF extends FPDF
{
    // ENCABEZADOS
    // function Header()
    // {
    //     // $this->Image(url_base() . '/archivos/imagenes/logotaber.png', 25, 7, 33);
    //     $this->Image(url_base() . '/archivos/imagenes/logotaber.png', 25, 8, 28);
    //     //hasta AQUI
    //     $this->SetFont('times', 'B', 11);
    //     $this->SetTextColor(30, 30, 32);

    //     $this->Text(110, 15, utf8_decode('Tabernaculo Bíblico Bautista "Amigos de Israel"'));
    //     $this->Text(118, 21, utf8_decode('Centro de Desarrollo Infantil Manantiales'));
    //     $this->Titulo();

    //     // $this->SetFont('courier', '', 10);
    //     $this->Text(135, 32, 'Fecha: ' . date('d/m/Y'));

    //     $this->SetFont('Arial', 'B', 12);
    //     // $this->Line(0, 40, 2000, 40);


    // }

    function Header()
    {
        $this->Image(url_base() . '/archivos/imagenes/logotaber.png', 25, 7, 33);

        $this->SetFont('times', 'B', 13);
        $this->SetTextColor(30, 30, 32);

        $this->Text(70, 21, utf8_decode('Tabernáculo Bíblico Bautista "Amigos de Israel"'));
        $this->Text(75, 27, utf8_decode('Centro de Desarrollo Infantil Manantiales'));

        $this->SetFont('Arial', '', 10);
        $this->Text(160, 35, 'Fecha : ' . date('d/m/Y'));

        $this->SetFont('Arial', 'B', 12);
    }

    function Titulo()
    {
        $this->Text(120, 27, utf8_decode('Reporte de Prueba'));
    }

    function fechaFormat($fecha)
    {
        $arr = explode('-', $fecha);
        $newDate = $arr[2] . '/' . $arr[1] . '/' . $arr[0];
        return $newDate;
    }


    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('times', '', 12);
        $this->Image(url_base() . '/archivos/imagenes/separadorT.png', 5, 275, 200);
        $this->Cell(190, 10, utf8_decode('Tabernáculo Bíblico Bautista © ' . date('Y') . ' - UES FMP'), 0, 0, 'C');
        $this->Cell(0, 10, utf8_decode('Página') . $this->PageNo(), 0, 0, 'R');
    }

    // ------------------------------------------------------------
    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data, $setX)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 8 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h, $setX);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h, 'DF');
            //Print the text
            $this->MultiCell($w, 8, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h, $setX)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
            $this->SetX($setX);
        }

        $this->SetX($setX);
    }


    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
    // ----------------------------------------------------------------

}
