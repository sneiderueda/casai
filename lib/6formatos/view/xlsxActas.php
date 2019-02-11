<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Bogota');
setlocale(LC_ALL, "es_ES");
define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');


/** Include PHPExcel */
require_once '../../../components/phpexcel/Classes/PHPExcel.php';
//require_once '../../../components/com_excel/Classes/PHPExcel.php';
require_once '../../0connection/BD_config.php';
require_once '../../0connection/connection.php';
require_once '../../0connection/BD.php';

//session_start();
$obj_bd = new BD();

$objPHPExcel = new PHPExcel();
$objDrawing = new PHPExcel_Worksheet_Drawing();

$fecha = date("Y-m-d");


$porcentaje = $_GET['er'];
$fechaInicio = $_GET['fh'];
$fechaFin = $_GET['ff'];

$arrayFecha = $obj_bd->obtenerFechaEnLetra($fecha);

$exp_fecha = explode(",", $arrayFecha);
$mes = $exp_fecha[2];
$dia = $exp_fecha[1];
$year = $exp_fecha[3];

$arrayFechaInicio = $obj_bd->obtenerFechaEnLetra($fechaInicio);
//  return $dia . ',' . $num . ',' . $mes . ',' . $anno;
$exp_fechaInicio = explode(",", $arrayFechaInicio);
$mesInicio = $exp_fechaInicio[2];
$diaInicio = $exp_fechaInicio[1];
$yearInicio = $exp_fechaInicio[3];

//fin corte
$arrayFechaFin = $obj_bd->obtenerFechaEnLetra($fechaFin);
$exp_fechaFin = explode(",", $arrayFechaFin);
$mesFin = $exp_fechaFin[2];
$diaFin = $exp_fechaFin[1];
$yearFin = $exp_fechaFin[3];

if ($porcentaje == "") {
    $porcentaje = 0;
}

$alcance = "1. Alcance: Esta acta corresponde al avance de la orden de trabajo, "
        . "de acuerdo con el detalle mostrado en el anexo Acta de avance de obra "
        . "para el mes de " . $mes . " de " . $year . ".";

$dos = "2. Valor total según anexos adjuntos: El valor final del acta se describe a continuación:";
/* validar cuantas OT'S se van a facturar para mostrar el detalle en cada pestaña */
$sql = "CALL SP_factura('1','','','','','','','','','','','','','','','','','','','','','');";

$resultado = $obj_bd->EjecutaConsulta($sql);



while ($row = $obj_bd->FuncionFetch($resultado)) {

    $objPHPExcel->getSheetCount(); //cuenta las pestañas
    $positionInExcel = 0; //esto es para que ponga la nueva pestaña al principio
    $objPHPExcel->createSheet($positionInExcel); //creamos la pestaña


    $Ot_total = "$" . number_format($row['detallepresupuesto_total'], 0, ',', '.');
    $valor_acta = "$" . number_format($row['valor_porc'], 0, ',', '.');

    $text = "A los " . $dia . " días del mes de " . $mes . " se reunieron en las instalaciones de "
            . "CODENSA S.A. E.S.P., los ingenieros " . utf8_encode($row['gestor']) . "  por parte de "
            . "CODENSA S.A. E.S.P. de la Unidad Operativa de Gestión y control AT,"
            . " e Ing. Armando Ciendúa por parte de AC ENERGY, como firma contratista de "
            . "CODENSA S.A. E.S.P, con el objeto de realizar la medición parcial de avance "
            . "de la orden de trabajo para el período comprendido entre el " . $diaInicio . " de "
            . $mesInicio . " de " . $yearInicio . " y el " . $diaFin . " de " . $mesFin . " de " . $yearFin
            . " para el proyecto: " . utf8_encode($row['ordentrabajo_obs']);

    $ubI = "$" . number_format($row['detallepresupuesto_valorincremento'], 0, ',', '.');

    $sum_subtotal = $row['valor_porc'] + $row['detallepresupuesto_valorincremento'];
    $subtotal = "$" . number_format($sum_subtotal, 0, ',', '.');

    $iva_total = ($row['detallepresupuesto_total'] * $porcentaje) / 100;
    $Iva_form = "$" . number_format($iva_total, 0, ',', '.');

    $total = $iva_total + $sum_subtotal;
    $total_form = "$" . number_format($total, 0, ',', '.');

    $cont = "Como constancia de lo anterior, se firma la presente acta el día " . $dia . " de " . $mes . " de " . $year . ".";

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B1', 'Acta de avance Orden de trabajo')
            ->setCellValue('G1', 'RG07-IO775')
            ->setCellValue('G2', 'Versión 1')
            ->setCellValue('G3', $fecha)
            ->setCellValue('A5', 'PROYECTO:')
            ->setCellValue('B5', utf8_encode($row['ordentrabajo_obs']))
            ->setCellValue('A7', 'PEP')
            ->setCellValue('B7', utf8_encode($row['ordentrabajo_pep']))
            ->setCellValue('A8', 'ORDEN PRESUPUESTAL')
            ->setCellValue('B8', utf8_encode($row['ordentrabajo_ordenpresupuestal']))
            ->setCellValue('A9', 'CONTRATISTA')
            ->setCellValue('B9', 'AC ENERGY SAS')
            ->setCellValue('A10', 'SUBESTACIÓN')
            ->setCellValue('B10', utf8_encode($row['subestacion_nombre']))
            ->setCellValue('E7', 'ORDEN DE TRABAJO')
            ->setCellValue('G7', $row['ordentrabajo_num'])
            ->setCellValue('E8', 'ACTA DE AVANCE No.')
            ->setCellValue('E9', 'VALOR TOTAL OT:')
            ->setCellValue('G9', $Ot_total)
            ->setCellValue('E10', 'VALOR DEL ACTA:')
            ->setCellValue('G10', $valor_acta)
            ->setCellValue('A12', $text)
            ->setCellValue('A14', $alcance)
            ->setCellValue('A16', $dos)
            ->setCellValue('B18', 'DETALLE A PAGAR')
            ->setCellValue('B19', 'Valor según acta de avance')
            ->setCellValue('E19', $valor_acta)
            ->setCellValue('B20', 'Ajustes al precio')
            ->setCellValue('E20', $ubI)
            ->setCellValue('B21', 'SUBTOTAL')
            ->setCellValue('E21', $subtotal)
            ->setCellValue('B22', 'IVA ' . $porcentaje . '%')
            ->setCellValue('E22', $Iva_form)
            ->setCellValue('B23', 'TOTAL')
            ->setCellValue('E23', $total_form)
            ->setCellValue('E18', 'VALOR')
            ->setCellValue('A25', '3. Resumen OT:')

            //FIRMAS
            ->setCellValue('A38', utf8_encode($row['gestor']))
            ->setCellValue('A39', 'Gestor de la ingeniería')
            ->setCellValue('A40', 'CODENSA S.A. E.S.P')
            ->setCellValue('E38', 'Ing. Diana Marcela García Pulido')
            ->setCellValue('E39', 'Coordinador operativo del Contrato')
            ->setCellValue('E40', 'CODENSA S.A. E.S.P')
            ->setCellValue('A44', 'Ing. Miguel Vicente Rueda')
            ->setCellValue('A45', 'Gestor del Contrato')
            ->setCellValue('A46', 'CODENSA S.A. E.S.P')
            ->setCellValue('E44', 'Ing. Armando Ciendúa Ciendúa')
            ->setCellValue('E45', 'Representante de la EC')
            ->setCellValue('E46', 'Empresa Colaboradora')

            //ACTAS
            ->setCellValue('B26', 'Acta No.')
            ->setCellValue('C26', 'Valor sin IVA')
            ->setCellValue('E26', '% OT')
            ->setCellValue('A34', $cont);



    // ANCHO DE LAS COLUMNAS
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);


    //ALTO DE LAS FILAS
    $objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(60);
    $objPHPExcel->getActiveSheet()->getRowDimension('14')->setRowHeight(25);

    $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(8);
    $objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(8);
    $objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(8);
    $objPHPExcel->getActiveSheet()->getRowDimension('13')->setRowHeight(8);
    $objPHPExcel->getActiveSheet()->getRowDimension('15')->setRowHeight(8);
    $objPHPExcel->getActiveSheet()->getRowDimension('17')->setRowHeight(8);
    $objPHPExcel->getActiveSheet()->getRowDimension('24')->setRowHeight(8);
    $objPHPExcel->getActiveSheet()->getRowDimension('33')->setRowHeight(8);




    //CONBINAR
    $objPHPExcel->getActiveSheet()->mergeCells('A1:A3');
    $objPHPExcel->getActiveSheet()->mergeCells('B1:F3');
    $objPHPExcel->getActiveSheet()->mergeCells('C26:D26');
    $objPHPExcel->getActiveSheet()->mergeCells('A34:G34');

    //BORDES
    $objPHPExcel->getActiveSheet()
            ->getStyle('A1:G3')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $objPHPExcel->getActiveSheet()->mergeCells('B5:G5');
    //BORDES
    $objPHPExcel->getActiveSheet()
            ->getStyle('A5:G5')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $objPHPExcel->getActiveSheet()->mergeCells('B7:C7');
    $objPHPExcel->getActiveSheet()->mergeCells('B8:C8');
    $objPHPExcel->getActiveSheet()->mergeCells('B9:C9');
    $objPHPExcel->getActiveSheet()->mergeCells('B10:C10');

    //BORDES
    $objPHPExcel->getActiveSheet()
            ->getStyle('A7:C10')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $objPHPExcel->getActiveSheet()->mergeCells('E7:F7');
    $objPHPExcel->getActiveSheet()->mergeCells('E8:F8');
    $objPHPExcel->getActiveSheet()->mergeCells('E9:F9');
    $objPHPExcel->getActiveSheet()->mergeCells('E10:F10');

    //BORDES
    $objPHPExcel->getActiveSheet()
            ->getStyle('E7:G10')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


    $objPHPExcel->getActiveSheet()->mergeCells('A12:G12');
    $objPHPExcel->getActiveSheet()->mergeCells('A14:G14');
    $objPHPExcel->getActiveSheet()->mergeCells('A16:G16');

    $objPHPExcel->getActiveSheet()->mergeCells('B18:D18');
    $objPHPExcel->getActiveSheet()->mergeCells('B19:D19');
    $objPHPExcel->getActiveSheet()->mergeCells('B20:D20');
    $objPHPExcel->getActiveSheet()->mergeCells('B21:D21');
    $objPHPExcel->getActiveSheet()->mergeCells('B22:D22');
    $objPHPExcel->getActiveSheet()->mergeCells('B23:D23');
    $objPHPExcel->getActiveSheet()->mergeCells('E18:F18');
    $objPHPExcel->getActiveSheet()->mergeCells('E19:F19');
    $objPHPExcel->getActiveSheet()->mergeCells('E20:F20');
    $objPHPExcel->getActiveSheet()->mergeCells('E21:F21');
    $objPHPExcel->getActiveSheet()->mergeCells('E22:F22');
    $objPHPExcel->getActiveSheet()->mergeCells('E23:F23');

    //BORDES
    $objPHPExcel->getActiveSheet()
            ->getStyle('B18:F23')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


    //FIRMAS
    $objPHPExcel->getActiveSheet()->mergeCells('A38:C38');
    $objPHPExcel->getActiveSheet()->mergeCells('A39:C39');
    $objPHPExcel->getActiveSheet()->mergeCells('A40:C40');
    //BORDES
    $objPHPExcel->getActiveSheet()
            ->getStyle('A38:C38')
            ->getBorders()
            ->getTop()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


    $objPHPExcel->getActiveSheet()->mergeCells('A44:C44');
    $objPHPExcel->getActiveSheet()->mergeCells('A45:C45');
    $objPHPExcel->getActiveSheet()->mergeCells('A46:C46');
    //BORDES
    $objPHPExcel->getActiveSheet()
            ->getStyle('A44:C44')
            ->getBorders()
            ->getTop()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $objPHPExcel->getActiveSheet()->mergeCells('E38:G38');
    $objPHPExcel->getActiveSheet()->mergeCells('E39:G39');
    $objPHPExcel->getActiveSheet()->mergeCells('E40:G40');
    //BORDES
    $objPHPExcel->getActiveSheet()
            ->getStyle('E38:G38')
            ->getBorders()
            ->getTop()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


    $objPHPExcel->getActiveSheet()->mergeCells('E44:G44');
    $objPHPExcel->getActiveSheet()->mergeCells('E45:G45');
    $objPHPExcel->getActiveSheet()->mergeCells('E46:G46');
    //BORDES
    $objPHPExcel->getActiveSheet()
            ->getStyle('E44:G44')
            ->getBorders()
            ->getTop()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    //ALINEAR TEXTO
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(10);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('B1:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->getStyle('G1:G3')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('G1:G3')->getFont()->setSize(9);
    $objPHPExcel->getActiveSheet()->getStyle('G1:G3')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('G1:G3')->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('G1:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B18:F18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //TAMAO DE LA LETRA
    $objPHPExcel->getActiveSheet()->getStyle('A12:G12')->getFont()->setSize(9);
    $objPHPExcel->getActiveSheet()->getStyle('A14:G14')->getFont()->setSize(9);
    $objPHPExcel->getActiveSheet()->getStyle('A5:G10')->getFont()->setSize(10);


    // alineación vertical de la parte superior de las celdas
    $objPHPExcel->getActiveSheet()->getStyle('A12:G12')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $objPHPExcel->getActiveSheet()->getStyle('A14:G14')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $objPHPExcel->getActiveSheet()->getStyle('B21:B23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    //ajustar el texto
    $objPHPExcel->getActiveSheet()->getStyle('A12:G12')->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('A14:G14')->getAlignment()->setWrapText(true);

    //COLOR DE LAS TABLAS - DETALLES
    $objPHPExcel->getActiveSheet()->getStyle('B18:F18')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B18:F18')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('B18:F18')->getFill()->getStartColor()->setARGB('E5E7E9');

    $objPHPExcel->getActiveSheet()->getStyle('B21:F21')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B21:F21')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('B21:F21')->getFill()->getStartColor()->setARGB('E5E8E8');

    $objPHPExcel->getActiveSheet()->getStyle('B23:F23')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B23:F23')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('B23:F23')->getFill()->getStartColor()->setARGB('E5E7E9');


    $objPHPExcel->getActiveSheet()->getStyle('B26:E26')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B26:E26')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('B26:E26')->getFill()->getStartColor()->setARGB('E5E7E9');
    //VALIDAR SI TIENE ACTAS
    $G = 26;

    $sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','');";
    $resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
    $existe_actas = $obj_bd->Filas($sql_actas);
    if ($existe_actas > 0) {

        $sum_porcentaje = 0;
        $sum_subtotal = 0;
        while ($row_actas = $obj_bd->FuncionFetch($resultado_actas)) {
            $G = $G + 1;
            $objPHPExcel->getActiveSheet()->mergeCells('C' . $G . ':D' . $G);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->setName('Calibri');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->setSize(11);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->getColor()->setARGB('123D05');
            $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getCell('B' . $G)->setValue("ACTA " . $row_actas['factura_actanum']);

            $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getFont()->setName('Calibri');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getFont()->setSize(11);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getFont()->getColor()->setARGB('123D05');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getCell('C' . $G)->setValue("$" . number_format($row_actas['factura_subtotal'], 0, ',', '.'));

            $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getFont()->setName('Calibri');
            $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getFont()->setSize(11);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getFont()->getColor()->setARGB('123D05');
            $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getCell('E' . $G)->setValue($row_actas['factura_porcentajefacturado'] . "%");
            $sum_porcentaje = $sum_porcentaje + $row_actas['factura_porcentajefacturado'];
            $sum_subtotal = $sum_subtotal + $row_actas['factura_subtotal'];
        }

        //totales
        $G = $G + 1;
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $G . ':D' . $G);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('B' . $G)->setValue("TOTAL");
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->getColor()->setARGB('123D05');

        $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('C' . $G)->setValue("$" . number_format($sum_subtotal, 0, ',', '.'));

        $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('E' . $G)->setValue($sum_porcentaje . "%");
    } else {
        //variables de acta
        $subtotal_sinIva = $row['valor_porc'];
        $porc_facturar_actas = ($row['valor_porc'] * 100) / $row['detallepresupuesto_total'];
        $porcentaje_facturado = round($porc_facturar_actas) . "%";

        //validar numero de acta
        $sql_acta = "CALL SP_factura('4','','','','','','','','','','','','','','','','','','','','" . trim($row['ordentrabajo_id']) . "','');";

        $resultado_acta = $obj_bd->EjecutaConsulta($sql_acta);
        $num_acta = $obj_bd->FuncionFetch($resultado_acta);
        $acta = $num_acta['acta'] + 1;

        //Fin de variables de acta

        $G = $G + 1;
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $G . ':D' . $G);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('B' . $G)->setValue("ACTA " . $acta);

        $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('C' . $G)->setValue("$" . number_format($subtotal_sinIva, 0, ',', '.'));

        $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('E' . $G)->setValue($porcentaje_facturado);

        //TOTALES
        $G = $G + 1;
        $objPHPExcel->getActiveSheet()->mergeCells('C' . $G . ':D' . $G);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('B' . $G)->setValue("TOTAL");
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $G)->getFont()->getColor()->setARGB('123D05');

        $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('C' . $G)->setValue("$" . number_format($subtotal_sinIva, 0, ',', '.'));

        $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('E' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('E' . $G)->setValue($porcentaje_facturado);
    }

    $objPHPExcel->getActiveSheet()->getStyle('B'.$G.':E'.$G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$G.':E'.$G)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$G.':E'.$G)->getFill()->getStartColor()->setARGB('E5E7E9');

    //bordes
    $objPHPExcel->getActiveSheet()
            ->getStyle('B26:E' . $G)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



    $titulo = $row['ordentrabajo_num'];
    // Nombre de la hoja
    $objPHPExcel->getActiveSheet()->setTitle($titulo);

    // Establecer el índice de la hoja activa, Hoja que Excel abre como la primera hoja
    $objPHPExcel->setActiveSheetIndex(0);
}
$objPHPExcel->getSheetByName('Worksheet')
        ->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ACTAS.xlsx"');
header('Cache-Control: max-age=0');
header("Pragma: no-cache");
header("Expires: 0");


$objWriter->save('php://output');



exit;
