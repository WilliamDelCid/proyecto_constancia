<?php
require('WriteTag.php');
date_default_timezone_set('America/Mexico_City');

$pdf = new PDF_WriteTag();
//Orientacion de pagina
$pdf->AddPage('L', 'Letter');
$pdf->SetAutoPageBreak(true, 10);
// imagen Lateral
$pdf->Image(url_base() . '/archivos/imagenes/plantillaPDF-min.png', 10, 0, 56);


// AGREGANDO NUEVOS ESTILOS DE LAS FONTS
$pdf->AddFont('FontsFree-Net-MYRIADPRO-BOLD', '', 'FontsFree-Net-MYRIADPRO-BOLD.php');
$pdf->AddFont('FontsFree-Net-MyriadPro-Light', '', 'FontsFree-Net-MyriadPro-Light.php');
$pdf->AddFont('FontsFree-Net-MYRIADPRO-REGULAR', '', 'FontsFree-Net-MYRIADPRO-REGULAR.php');
$pdf->AddFont('MYRIADPRO-BOLDIT', '', 'MYRIADPRO-BOLDIT.php');

// Declarando el estilo de cada etiqueta
$pdf->SetStyle("p", "arial", "N", 14, "51, 102, 153", -2);
$pdf->SetStyle("normal", "FontsFree-Net-MyriadPro-Light", "", 14, "51, 102, 153");
$pdf->SetStyle("bold", "FontsFree-Net-MYRIADPRO-BOLD", "", 14, "51, 102, 153");
$pdf->SetStyle("bold10", "FontsFree-Net-MYRIADPRO-BOLD", "", 26, "51, 102, 153");
$pdf->SetStyle("regular", "FontsFree-Net-MYRIADPRO-REGULAR", "", 14, "51, 102, 153");
$pdf->SetStyle("regular10", "FontsFree-Net-MYRIADPRO-REGULAR", "", 25, "51, 102, 153");
$pdf->SetLineWidth(0, 7);

$pdf->ln();

// TITULO
$texto = utf8_decode(
    "<p><regular>La </regular><bold>Universidad Autónoma de San Luis Potosí</bold> <regular> a través de la Facultad de Contaduría y Administración, otorga el presente</regular></p>"
);

$pdf->SetXY(77, 35);
$pdf->WriteTag(140, 6, "$texto", 0, "L", 0, 2);

$pdf->Ln(10);

//LETRAS DORADAS
$pdf->SetFont('FontsFree-Net-MYRIADPRO-BOLD', '', 64);
$pdf->SetTextColor(188, 164, 102);
$pdf->SetX(77);
$pdf->Cell(180, 20, 'RECONOCIMIENTO', 0, 1, 'L');


///////////////////////
$tipoParticipacion = "EVALUADOR";
$nombreEvento = "Sistema para consultas de información de DENUE, SCINCE, Inventario Nacional de Vivienda 2016, PyMES y Mapas Digitales";
$fechas = "20 de Marzo de 2018";


$texto1 = utf8_decode(
    "<p><regular10>a: </regular10><bold10>MARÍA GREGORÍA NEÍTEZ LIMA</bold10></p>"

);

$pdf->Ln(10);
$pdf->SetX(77);
$pdf->WriteTag(165, 6, "$texto1", 0, "J", 0, 2);

// texto largo

$texto1 = utf8_decode(
    "<p><regular> Por su participación como $tipoParticipacion de la conferencia </regular><bold>$nombreEvento</bold><regular>, que se llevo a cabo $fechas , en las instalaciones de esta Facultad.</regular></p>"

);

$pdf->Ln(5);
$pdf->SetX(77);
$pdf->WriteTag(187, 6, "$texto1", 0, "J", 0, 2);




$pdf->Ln(10);
$pdf->SetX(77);
$texto2 = utf8_decode(
    "<p><regular>San Luis Potosí, S.L.P., 12 Marzo 2023</regular></p>"
);

$pdf->WriteTag(165, 6, "$texto2", 0, "J", 0, 2);

$pdf->Ln(6);
$pdf->SetX(77);
$pdf->Cell(50, 8, 'Atentamente', 0, 1, 'L', 0);
$pdf->SetX(77);
$pdf->SetFont('MYRIADPRO-BOLDIT', '', 14);
$pdf->Cell(100, 6, utf8_decode('Siempre Autonoma. Por mí patria Educaré.'), 0, 1, 'L', 0);



// ULTIMOO
$pdf->SetFont('FontsFree-Net-MYRIADPRO-BOLD', '', 14);
$pdf->Ln(25);
$pdf->SetX(77);
$pdf->Cell(100, 6, utf8_decode('M.A Hilda Lorena Borjas García'), 0, 1, 'L', 0);
$pdf->SetX(77);
$pdf->SetFont('FontsFree-Net-MYRIADPRO-REGULAR', '', 14);
$pdf->Cell(150, 6, utf8_decode('Directora de la Facultad de Contaduría y Administración.'), 0, 1, 'L', 0);

$pdf->SetFont('FontsFree-Net-MyriadPro-Light', '', 14);
$hoy = getdate();
// $anioActual = explode('/', $fecha);
$pdf->Text(44, 194, $hoy['year']);




$pdf->Image(url_base() . '/archivos/imagenes/qr.png', 226, 170, 45);




$pdf->Output();
