<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
date_default_timezone_set('Europe/London');

/** Include PHPExcel */
require_once '../../../components/phpexcel/Classes/PHPExcel.php';
//require_once '../../../components/com_excel/Classes/PHPExcel.php';
require_once '../../0connection/BD_config.php';
require_once '../../0connection/connection.php';
require_once '../../0connection/BD.php';
$array_total_presupuesto = 0;

//session_start();
$obj_bd = new BD();

$det_pret = $_GET['er'];
$hoy = date("d/m/Y");
$dato_fecha = explode("/", $hoy);
//$hoy = date("l jS \of F Y");
$year = $dato_fecha[2];
$version = utf8_encode('Version 3');
//$year = "2017";
// Create new object
$objPHPExcel = new PHPExcel();
$objDrawing = new PHPExcel_Worksheet_Drawing();
/**/

//variables 

/**/

// Ajustar propiedades del documento
$objPHPExcel->getProperties()->setCreator("Casai")
        ->setLastModifiedBy("Casai")
        ->setTitle("Presupuesto")
        ->setSubject("_")
        ->setDescription("_")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("excel");
/**/

/* CABEZERA DEL REPORTE */
//logo del reporte
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../../../img/logo.jpg');
$objDrawing->setHeight(40);
$objDrawing->setCoordinates('A1');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


// ANCHO DE LAS COLUMNAS
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(45);


//ALTO DE LAS FILAS
$objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(100);

//ALINEAR TEXTO
$objPHPExcel->getActiveSheet()->getStyle("A3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("A4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("A5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("B2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("C3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("F3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("H1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("H3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("B3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//Conbinar celdas
$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
$objPHPExcel->getActiveSheet()->mergeCells('B1:G1');
$objPHPExcel->getActiveSheet()->mergeCells('B2:G2');
$objPHPExcel->getActiveSheet()->mergeCells('D3:E3');
$objPHPExcel->getActiveSheet()->mergeCells('B4:G4');
$objPHPExcel->getActiveSheet()->mergeCells('B5:I5');
$objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
$objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
$objPHPExcel->getActiveSheet()->mergeCells('H1:I2');
$objPHPExcel->getActiveSheet()->mergeCells('D6:E6');

//TIPO DE LETRA
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$ot = "SELECT * FROM pt_orden_trabajo where detallepresupuesto_id=" . $det_pret;
$resultado_ot = $obj_bd->EjecutaConsulta($ot);

$row_ot = $obj_bd->FuncionFetch($resultado_ot);
$num_ot = $row_ot['ordentrabajo_num'];

//Agregar valores a las celdas

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B1', "REGISTRO")
        ->setCellValue('B2', 'PRESUPUESTO')
        ->setCellValue('A3', 'No. CONTRATO:')
        ->setCellValue('C3', 'SUBESTACION:')
        ->setCellValue('F3', 'OT: ' . $num_ot)
        ->setCellValue('A4', 'OBJETO:')
        ->setCellValue('A5', 'ALCANCE:')
        ->setCellValue('A6', 'Módulo')
        ->setCellValue('B6', 'Labor')
        ->setCellValue('C6', 'Actividad')
        ->setCellValue('D6', 'Codigo GOM')
        // ->setCellValue('E6', 'Subactividad')
        ->setCellValue('F6', 'Cantidad')
        ->setCellValue('G6', "Vr. Unitario\n(" . $year . ')')
        ->setCellValue('H3', 'abr-16')
        ->setCellValue('H6', 'Vr. Total')
        ->setCellValue('I6', 'Observaciones')
        ->setCellValue('H1', $version);

$objPHPExcel->setActiveSheetIndex(0);
//cuadrar el alto cuando se usa alt+enter
$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setWrapText(true);

//cuadrar el alto cuando se usa alt+enter
$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setWrapText(true);


/* ENCABEZADO */
$sql_encabezado = "SELECT DP.detallepresupuesto_id,
                        CT.contrato_numero,
                        SB.subestacion_nombre,
                        DP.detallepresupuesto_objeto,
                        DP.detallepresupuesto_alcance,
                        DP.detallepresupuesto_total,
                        DP.detallepresupuesto_valorincremento,
                        DP.detallepresupuesto_porcentincremento
                   FROM dt_detalle_presupuesto DP
                   JOIN dt_contrato CT ON DP.contrato_id=CT.contrato_id
                   JOIN dt_subestacion SB ON DP.subestacion_id=SB.subestacion_id
                    AND DP.detallepresupuesto_estado=3
                    AND DP.detallepresupuesto_id=" . $det_pret;

$resultado = $obj_bd->EjecutaConsulta($sql_encabezado);

while ($row = $obj_bd->FuncionFetch($resultado)) {
    $total_presupuesto = $row['detallepresupuesto_total'];
    $total_incremento = $row['detallepresupuesto_valorincremento'];
    $porc_inc = $row['detallepresupuesto_porcentincremento'];

    $sub = $row['subestacion_nombre'];
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', trim($row['contrato_numero']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', $row['subestacion_nombre']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', utf8_encode($row['detallepresupuesto_objeto']));
    $texto = preg_replace("/\s+/", " ", $row['detallepresupuesto_alcance']);
    $texto_alcance = str_replace('. ', '.' . PHP_EOL, $texto);
    $objPHPExcel->getActiveSheet()->getCell('B5')->setValue(utf8_encode($texto_alcance));
    $objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setWrapText(true);
}



//tipo de relleno, color de fondo y color del texto
$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFill()->getStartColor()->setARGB('0070C0');
$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('I6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('I6')->getFill()->getStartColor()->setARGB('0070C0');
$objPHPExcel->getActiveSheet()->getStyle('I6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('F6:H6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('F6:H6')->getFill()->getStartColor()->setARGB('FCD5B4');
/**/

//CUERPO DEL REPORTE
//1. CAntidad de Modulos

$sql_mod = "SELECT lb.labor_id,
                 md.modulo_descripcion,
                 tb.tipobaremo_sigla,
                 bm.baremo_item,
                 lb.labor_unidmedida,
                 lb.labor_descripcion,
                 pt.baremo_id,
                 pt.tipobaremo_id,
                 pt.detallepresupuesto_id,
                 md.modulo_id,                 
                 pt.presupuesto_obs,
                 sum(presupuesto_valorporcentaje) as total_actividad
            FROM pt_presupuesto pt
            JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
            JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
            JOIN cf_modulo md ON pt.modulo_id=md.modulo_id            
            JOIN cf_labor lb ON bm.labor_id=lb.labor_id
             AND pt.presupuesto_estado=1
             AND pt.detallepresupuesto_id=$det_pret
        GROUP BY pt.baremo_id,
                 pt.tipobaremo_id,
                 pt.detallepresupuesto_id,
                 bm.baremo_item,
                 tb.tipobaremo_descripcion,
                 pt.presupuesto_obs,
                 md.modulo_descripcion
         ORDER BY modulo_descripcion,tb.tipobaremo_sigla,bm.baremo_item asc";

$resultado_modulo = $obj_bd->EjecutaConsulta($sql_mod);
//echo '<pre>';
//var_dump($sql_mod);
//echo '</pre>';
$A = 7;
$A_com = 6;

$B = 7;
$B_com = 6;

$C = 7;
$C_com = 6;

$D = 7;
$E = 7;
$F = 7;
$G = 7;
$H = 7;

$I = 7;
$I_com = 6;

while ($row_mod = $obj_bd->FuncionFetch($resultado_modulo)) {

    $num_act_com = 0;
    $obs = $row_mod['presupuesto_obs'];
    //2. Validar las actividades
    $sql_act = "SELECT pt.presupuesto_porcentaje,
		 	 ac.actividad_valorservicio,
			 pt.presupuesto_valorporcentaje,
			 pt.presupuesto_id,
			 pt.baremoactividad_id,					
			 bm.baremo_item,
                         bm.baremo_id,
			 ac.actividad_id,
			 ac.actividad_descripcion,
                         pt.presupuesto_obs,
			 ac.actividad_GOM			
                    FROM pt_presupuesto pt
                    JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
                    JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
                    JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
                     AND pt.baremo_id=" . $row_mod['baremo_id'] . "
                     AND pt.tipobaremo_id=" . $row_mod['tipobaremo_id'] . "
                     AND pt.modulo_id=" . $row_mod['modulo_id'] . "
                     AND bm.baremo_estado=1
                     AND pt.detallepresupuesto_id=" . $row_mod['detallepresupuesto_id'] . "
                     AND pt.presupuesto_estado=1
                     AND pt.presupuesto_obs='" . $obs . "'
                GROUP BY actividad_id";


//    echo '<pre>';
//    var_dump($sql_act);
//    echo '</pre>';

    $result_act = $obj_bd->EjecutaConsulta($sql_act);
    $num_act = $obj_bd->Filas($sql_act);

    while ($row_act = $obj_bd->FuncionFetch($result_act)) {


        /* 3. CONSULTAR SI LA ACTIVIDAD TIENE SUBACTIVIDADES */
        $sql_sub = " SELECT pt.presupuesto_id,
                        pt.baremoactividad_id,
                        pt.detalleactividad_id,								
                        sb.subactividad_descripcion,
                        pt.presupuesto_porcentaje,
                        pt.presupuesto_valorporcentaje,
                        SUM(pt.presupuesto_porcentaje)	as suma_porcentaje,
                        SUM(pt.presupuesto_valorporcentaje) as suma_valor
                        FROM pt_presupuesto pt
                        JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
                        JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
                        JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id		   
                        AND da.detalleactividad_estado=1
                        AND pt.baremoactividad_id =" . $row_act['baremoactividad_id'] . "
                        AND pt.detallepresupuesto_id=$det_pret
                        AND pt.modulo_id=" . $row_mod['modulo_id'] . "
                        AND pt.presupuesto_estado=1
                        AND pt.presupuesto_obs='" . $obs . "'
                   GROUP BY pt.baremoactividad_id";

//    echo '<pre>';
//    var_dump($sql_sub);
//    echo '</pre>';
        $result_sub = $obj_bd->EjecutaConsulta($sql_sub);
        $num_sub = $obj_bd->Filas($sql_sub);



        if ($num_sub > 0) {//Si tiene subactividades (Se pinta)
            while ($row_sub = $obj_bd->FuncionFetch($result_sub)) {
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D' . $D . ':E' . $E);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $D, $row_act['actividad_gom']);
                // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $E, utf8_encode($row_sub['subactividad_descripcion']));
                //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $F, utf8_encode($row_sub['suma_porcentaje']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $F, $row_sub['suma_porcentaje']);

                $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $G, number_format($row_act['actividad_valorservicio'], 0, ',', ''));
                $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');

                $objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                //$objPHPExcel->getActiveSheet()->setCellValue('H'.$celda, "=ROUND((F".$celda."*G".$celda."),0)");
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $H, '=ROUND((F' . $F . '*G' . $G . '),0)');
                $objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
                //  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $H, "$" . number_format($row_sub['suma_valor']), 0, ',', '.');


                $D = $D + 1;
                $E = $E + 1;
                $F = $F + 1;
                $G = $G + 1;
                $H = $H + 1;

                if ($I_com == 6) {
                    $I_com = $I_com + 1;
                    $C_com = $C_com + 1;
                }
            }

            if ($num_sub == 1) {
                $I_com = $I_com;
                $C_com = $C_com;
            } else {

                $I_com = $I_com + 1;
                $C_com = $C_com + 1;
            }
            //Observaciones - combinar campo 
//            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I' . $I . ':I' . $I_com);
//            $obs = preg_replace("/\s+/", " ", $row_act['presupuesto_obs']);
//            $objPHPExcel->getActiveSheet()->getCell('I' . $I)->setValue(utf8_encode($obs));
//            $objPHPExcel->getActiveSheet()->getStyle('I' . $I)->getAlignment()->setWrapText(true);
            //Actividad
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $C . ':C' . $C_com);
            $act = preg_replace("/\s+/", " ", $row_act['actividad_descripcion']);
            $objPHPExcel->getActiveSheet()->getCell('C' . $C)->setValue(utf8_encode($act));
            $objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getAlignment()->setWrapText(true);

            $I = $I_com + 1;
            $C = $C_com + 1;
            $C_com = $C;
            $I_com = $I;
            $num_act_com = $num_act_com + $num_sub;
        } else {
            if ($I_com == 6) {
                $I_com = $I_com + 1;
                $C_com = $C_com + 1;
            }
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D' . $D . ':E' . $E);
            //GOM
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $D, $row_act['actividad_gom']);


            //CAMPO SUBACTIVIDAD
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $E, '');
            //$objPHPExcel->getActiveSheet()->getCell('E' . $E)->setValue('');
            //CATIDAD
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $F, $row_act['presupuesto_porcentaje']);

            //VR. UNITARIO
            $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $G, number_format($row_act['actividad_valorservicio'], 0, ',', ''));
            $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');

            //VR. TOTAL
            $objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $H, '=ROUND((F' . $F . '*G' . $G . '),0)');
            $objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $H, utf8_encode($row_act['presupuesto_valorporcentaje']));
            //Observaciones - combinar campo           
//            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I' . $I . ':I' . $I_com);
//            $obs = preg_replace("/\s+/", " ", $row_act['presupuesto_obs']);
//            $objPHPExcel->getActiveSheet()->getCell('I' . $I)->setValue(utf8_encode($obs));
//            $objPHPExcel->getActiveSheet()->getStyle('I' . $I)->getAlignment()->setWrapText(true);
            //Actividad
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $C . ':C' . $C_com);
            $act = preg_replace("/\s+/", " ", $row_act['actividad_descripcion']);
            $objPHPExcel->getActiveSheet()->getCell('C' . $C)->setValue(utf8_encode($act));
            $objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getAlignment()->setWrapText(true);

            $D = $D + 1;
            $E = $E + 1;
            $F = $F + 1;
            $G = $G + 1;
            $H = $H + 1;

            $I = $I_com + 1;
            $C = $C_com + 1;
            $C_com = $C;
            $I_com = $I;
            $num_act_com = $num_act;
        }
    }
//    echo '<pre> num_act_com';
//    var_dump($num_act_com);
//    echo '</pre>';
    //LABOR
    if ($B_com == 6) {
        $B_com = $B_com + $num_act_com + 2;
    } else {
        $B_com = $B_com + $num_act_com + 1;
    }

    $CM_I = $B_com - 1;
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I' . $B . ':I' . $CM_I);
    $obs_pt = preg_replace("/\s+/", " ", $row_mod['presupuesto_obs']);
    $objPHPExcel->getActiveSheet()->getCell('I' . $B)->setValue(utf8_encode($obs_pt));
    $objPHPExcel->getActiveSheet()->getStyle('I' . $B)->getAlignment()->setWrapText(true);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B' . $B . ':B' . $B_com);
    //$objPHPExcel->getActiveSheet()->mergeCells('B' . $B . ':B' . $B_com);
    $labor = preg_replace("/\s+/", " ", $row_mod['baremo_item']);
    $sigla = preg_replace("/\s+/", " ", $row_mod['tipobaremo_sigla']);
    $medida = preg_replace("/\s+/", " ", $row_mod['labor_unidmedida']);
    $objPHPExcel->getActiveSheet()->getCell('B' . $B)->setValue(utf8_encode($sigla . "-" . $labor . " " . $row_mod['labor_descripcion'] . " - UNIDAD DE MEDIDA " . $medida));
    $objPHPExcel->getActiveSheet()->getStyle('B' . $B)->getAlignment()->setWrapText(true);

    //MODULO
    if ($A_com == 6) {
        $A_com = $A_com + $num_act_com + 2;
    } else {
        $A_com = $A_com + $num_act_com + 1;
    }
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $A . ':A' . $A_com);
    // $objPHPExcel->getActiveSheet()->mergeCells('A' . $A . ':A' . $A_com);
    $modulo = preg_replace("/\s+/", " ", $row_mod['modulo_descripcion']);
    $objPHPExcel->getActiveSheet()->getCell('A' . $A)->setValue(utf8_encode($modulo));
    $objPHPExcel->getActiveSheet()->getStyle('A' . $A)->getAlignment()->setWrapText(true);

    //SUBTOTAL
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $A_com . ':E' . $A_com);
    $objPHPExcel->getActiveSheet()->getCell('C' . $A_com)->setValue(utf8_encode("Subtotal Labor No " . $row_mod['labor_id']));

    $objPHPExcel->getActiveSheet()->getStyle('C' . $A_com . ':E' . $A_com)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $A_com . ':E' . $A_com)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $A_com . ':E' . $A_com)->getFill()->getStartColor()->setARGB('1F497D');
    $objPHPExcel->getActiveSheet()->getStyle('C' . $A_com . ':E' . $A_com)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

    //TOTAL ACTIVIDAD
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F' . $A_com . ':H' . $A_com);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $A_com)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $A_com, '=SUM(H' . $B . ':H' . $CM_I . ')');
    $objPHPExcel->getActiveSheet()->getStyle('F' . $A_com)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
    $array_total_presupuesto .= '+F' . $A_com;
    //$objPHPExcel->getActiveSheet()->getCell('F' . $A_com)->setValue("$" . number_format($row_mod['total_actividad'], 0, ',', '.'));

    $objPHPExcel->getActiveSheet()->getStyle('F' . $A_com . ':H' . $A_com)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $A_com . ':H' . $A_com)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $A_com . ':H' . $A_com)->getFill()->getStartColor()->setARGB('E26B0A');
    $objPHPExcel->getActiveSheet()->getStyle('F' . $A_com . ':H' . $A_com)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);


    $A = $A_com + 1;
    $A_com = $A;
    $B = $B_com + 1;
    $B_com = $B;
    $sig_fil = $A;

    $D = $sig_fil;
    $E = $sig_fil;
    $F = $sig_fil;
    $G = $sig_fil;
    $H = $sig_fil;
    $C = $sig_fil;
    $I = $sig_fil;
    $C_com = $sig_fil;
    $I_com = $sig_fil;
}

//total del presupuesto
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getCell('G' . $G)->setValue("Subtotal: ");
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->getColor()->setARGB('000000');



$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getFont()->setSize(11);
//$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//$objPHPExcel->getActiveSheet()->getCell('H' . $H)->setValue("$" . number_format($total_presupuesto, 0, ',', '.'));
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $H, "=" . $array_total_presupuesto);
$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
$H_SUB = $H;
$A = $A_com + 1;
$A_com = $A;
$B = $B_com + 1;
$B_com = $B;
$sig_fil = $A;

$D = $sig_fil;
$E = $sig_fil;
$F = $sig_fil;
$G = $sig_fil;
$H = $sig_fil;
$C = $sig_fil;
$I = $sig_fil;
$C_com = $sig_fil;
$I_com = $sig_fil;

$porcentaje_incremento = $porc_inc * 100;
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getCell('G' . $G)->setValue("Valor Incremento " . $porcentaje_incremento . "%: ");
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->getColor()->setARGB('000000');

$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getFont()->setSize(11);
//$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//$objPHPExcel->getActiveSheet()->getCell('H' . $H)->setValue("$" . number_format($total_presupuesto, 0, ',', '.'));
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $H, "=" . $total_incremento);
$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
$H_IVA = $H;
$A = $A_com + 1;
$A_com = $A;
$B = $B_com + 1;
$B_com = $B;
$sig_fil = $A;

$D = $sig_fil;
$E = $sig_fil;
$F = $sig_fil;
$G = $sig_fil;
$H = $sig_fil;
$C = $sig_fil;
$I = $sig_fil;
$C_com = $sig_fil;
$I_com = $sig_fil;

$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getCell('G' . $G)->setValue("Total: ");
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->getColor()->setARGB('000000');

$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getFont()->setSize(11);
//$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$suma_total = 'H' . $H_SUB . '+H' . $H_IVA;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $H, "=" . $suma_total);
$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');


$A = $A_com + 2;
$A_com = $A;
$B = $B_com + 2;
$B_com = $B;
$sig_fil = $A;

$D = $sig_fil;
$E = $sig_fil;
$F = $sig_fil;
$G = $sig_fil;
$H = $sig_fil;
$C = $sig_fil;
$I = $sig_fil;
$C_com = $sig_fil;
$I_com = $sig_fil;


//Resumen
$objPHPExcel->getActiveSheet()->getStyle('A' . $A)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('A' . $A)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('A' . $A)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A' . $A)->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('A' . $A)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getCell('A' . $A)->setValue("PEP");

//BORDES
$objPHPExcel->getActiveSheet()
        ->getStyle('A' . $A)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()->getStyle('B' . $B)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('B' . $B)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('B' . $B)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B' . $B)->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('B' . $B)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getCell('B' . $B)->setValue("No. Orden Presupuestal");

//BORDES
$objPHPExcel->getActiveSheet()
        ->getStyle('B' . $B)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getCell('C' . $C)->setValue("Módulo ");

//BORDES
$objPHPExcel->getActiveSheet()
        ->getStyle('C' . $C)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()->getStyle('D' . $D)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('D' . $D)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('D' . $D)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D' . $D)->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('D' . $D)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getCell('D' . $D)->setValue("Labor");

//BORDES
$objPHPExcel->getActiveSheet()
        ->getStyle('D' . $D)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getCell('E' . $E)->setValue("Subtotal: ");

//BORDES
$objPHPExcel->getActiveSheet()
        ->getStyle('E' . $E)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$A = $A_com + 1;
$A_com = $A;
$B = $B_com + 1;
$B_com = $B;
$sig_fil = $A;

$D = $sig_fil;
$E = $sig_fil;
$F = $sig_fil;
$G = $sig_fil;
$H = $sig_fil;
$C = $sig_fil;
$I = $sig_fil;
$C_com = $sig_fil;
$I_com = $sig_fil;

$sql_resumen = "SELECT lb.labor_id,
                     md.modulo_descripcion,
                     sum(presupuesto_valorporcentaje) as total_actividad
                FROM pt_presupuesto pt
                JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
                JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
                JOIN cf_modulo md ON pt.modulo_id=md.modulo_id            
                JOIN cf_labor lb ON bm.labor_id=lb.labor_id
                 AND pt.presupuesto_estado=1
                 AND pt.detallepresupuesto_id=$det_pret
            GROUP BY pt.baremo_id,
                    pt.tipobaremo_id,
                    pt.detallepresupuesto_id,
                    bm.baremo_item,
                    tb.tipobaremo_descripcion,
                    md.modulo_descripcion
           ORDER BY modulo_descripcion asc";

$result_resumen = $obj_bd->EjecutaConsulta($sql_resumen);
$s = 1;
while ($row_resumen = $obj_bd->FuncionFetch($result_resumen)) {

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $C, utf8_encode($row_resumen['modulo_descripcion']));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $D, "Subtotal labores No." . utf8_encode($row_resumen['labor_id']));
    $objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $array_valor_subactividad = explode("+", $array_total_presupuesto);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $E, "=" . $array_valor_subactividad[$s]);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');

   // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $E, "$" . number_format($array_valor_subactividad[$s], 0, ',', '.'));

    $objPHPExcel->getActiveSheet()
            ->getStyle('E' . $E)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    //BORDES
    $objPHPExcel->getActiveSheet()
            ->getStyle('D' . $D)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//BORDES
    $objPHPExcel->getActiveSheet()
            ->getStyle('C' . $C)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $A_com = $A_com + 1;
    $B_com = $B_com + 1;
    $sig_fil = $A_com;

    $D = $sig_fil;
    $E = $sig_fil;
    $F = $sig_fil;
    $G = $sig_fil;
    $H = $sig_fil;
    $C = $sig_fil;
    $I = $sig_fil;
    $C_com = $sig_fil;
    $I_com = $sig_fil;
    $s++;
}

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $A . ':A' . $A_com);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B' . $B . ':B' . $B_com);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $C . ':D' . $D);

//BORDES
$objPHPExcel->getActiveSheet()
        ->getStyle('A' . $A . ':A' . $A_com)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//BORDES
$objPHPExcel->getActiveSheet()
        ->getStyle('B' . $B . ':B' . $B_com)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//BORDES
$objPHPExcel->getActiveSheet()
        ->getStyle('C' . $C . ':D' . $D)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//BORDES
$objPHPExcel->getActiveSheet()
        ->getStyle('E' . $E)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


//total del RESUMEN

$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getCell('C' . $C)->setValue("Subtotal: ");

$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//$objPHPExcel->getActiveSheet()->getCell('E' . $E)->setValue("$" . number_format($total_presupuesto, 0, ',', '.'));
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $E, "=" . $array_total_presupuesto);
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');

//TOTAL INCREMENTO IVA
$C = $C + 1;
$D = $D + 1;
$E = $E + 1;

$porcentaje_incremento = $porc_inc * 100;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $C . ':D' . $D);
//bordes
$objPHPExcel->getActiveSheet()
        ->getStyle('C' . $C . ':D' . $D)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()
        ->getStyle('E' . $E)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getCell('C' . $C)->setValue("Valor Incremento " . $porcentaje_incremento . "%: ");

$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getCell('E' . $E)->setValue(number_format($total_incremento, 0, ',', ''));
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');

//VALOR TOTAL
$IVA = $E;
$SUBT = $E - 1;
$C = $C + 1;
$D = $D + 1;
$E = $E + 1;

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $C . ':D' . $D);
//bordes
$objPHPExcel->getActiveSheet()
        ->getStyle('C' . $C . ':D' . $D)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()
        ->getStyle('E' . $E)
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$total_final = $total_presupuesto + $total_incremento;

$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getFont()->getColor()->setARGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getCell('C' . $C)->setValue("Total: ");

$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//$objPHPExcel->getActiveSheet()->getCell('E' . $E)->setValue("$" . number_format($total_final, 0, ',', '.'));
$suma = 'E' . $SUBT . '+E' . $IVA;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $E, "=" . $suma);
$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');

$titulo = "OT-" . $det_pret . " PRESUPUESTO ";
/**/
// Nombre de la hoja
$objPHPExcel->getActiveSheet()->setTitle($titulo);

// Seguridad al archivo xls
//$objPHPExcel->getSecurity()->setLockWindows(true);
//$objPHPExcel->getSecurity()->setLockStructure(true);
//$objPHPExcel->getSecurity()->setWorkbookPassword("casai");
// Set sheet security
//$objPHPExcel->getActiveSheet()->getProtection()->setPassword('casai');
//$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true); 
//$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
//$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
//$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
// Establecer el índice de la hoja activa, Hoja que Excel abre como la primera hoja
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="OT-' . $det_pret . ' PRESUPUESTO ' . $sub . '.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//function ob_clean_all() {
//    $ob_active = ob_get_length() !== FALSE;
//    while ($ob_active) {
//        ob_end_clean();
//        $ob_active = ob_get_length() !== FALSE;
//    }
//    return FALSE;
//}
//
//ob_clean_all();
$objWriter->save('php://output');


exit;
