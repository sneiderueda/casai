<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');

date_default_timezone_set('America/Bogota');

define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
//date_default_timezone_set('Europe/London');

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
/**/

//variables 
$porcentaje = $_GET['er'];
$fechaFacturaMes = $_GET['fh'];
$fechaFacturaFin = $_GET['ff'];
$abrir = $_GET['ab'];

//Variables de las actas
$codigo_gom = "";
$pep = "";
$orden = "";
$acta = "";
$subtotal_sinIva = "";
$porcentaje_facturado = "";
//Fin variables acta


$arrayFechaFactura = $obj_bd->obtenerFechaEnLetra($fechaFacturaMes);
$exp_fechaFactura = explode(",", $arrayFechaFactura);
$mesFactura = $exp_fechaFactura[2];
$yearFactura = $exp_fechaFactura[3];

//$fechaFacturaMes = '15-03-2015';
/**/

// Ajustar propiedades del documento
$objPHPExcel->getProperties()
->setCreator("Casai")
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




/* validar cuantas OT'S se van a facturar para mostrar el detalle en cada pestaña */
$sql = "CALL SP_factura('1','','','','','','','','" . $fechaFacturaMes . "','" . $fechaFacturaFin . "','','','','','','','','','','','','')";
$resultado = $obj_bd->EjecutaConsulta($sql);



while ($row = $obj_bd->FuncionFetch($resultado)) {
    $objPHPExcel->getSheetCount(); //cuenta las pestañas
    $positionInExcel = 0; //esto es para que ponga la nueva pestaña al principio
    $objPHPExcel->createSheet($positionInExcel); //creamos la pestaña
    //

    $resultado_ubi_acumulada = 0;

// ANCHO DE LAS COLUMNAS
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);


//ALTO DE LAS FILAS
    $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(40);
    $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(40);
    $objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(30);

//ALINEAR TEXTO
    $objPHPExcel->getActiveSheet()->getStyle("A3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("C3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("F3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("H1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("H2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("H3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B1:K1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A3:N6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A8:N8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("I7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("L7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//Conbinar celdas
    $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
    $objPHPExcel->getActiveSheet()->mergeCells('B1:K2');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:N6');
    $objPHPExcel->getActiveSheet()->mergeCells('L1:N1');
    $objPHPExcel->getActiveSheet()->mergeCells('L2:N2');
    $objPHPExcel->getActiveSheet()->mergeCells('I7:K7');
    $objPHPExcel->getActiveSheet()->mergeCells('L7:N7');


//TIPO DE LETRA
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(9);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(9);
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);
    
    

    $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setSize(9);
    $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle("L1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    
    $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setSize(9);
    $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle("L2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


    $objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setSize(9);
    $objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->getColor()->setARGB('123D05');
    


    $objPHPExcel->getActiveSheet()->getStyle('I7:N7')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('I7:N7')->getFont()->setSize(9);
    $objPHPExcel->getActiveSheet()->getStyle('I7:N7')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('I7:N7')->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('I7:N7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


    //BORDES
    $objPHPExcel->getActiveSheet()
    ->getStyle('L1:N2')
    ->getBorders()
    ->getAllBorders()
    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $objPHPExcel->getActiveSheet()
    ->getStyle('I7:N7')
    ->getBorders()
    ->getAllBorders()
    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);    



//traer mes de facturacion
    $arrayFecha = $obj_bd->obtenerFechaEnLetra($fechaFacturaMes);
    $exp_fecha = explode(",", $arrayFecha);

    //validar numero de acta
    $sql_acta = "CALL SP_factura('4','','','','','','','','','','','','','','','','','','','','" . trim($row['ordentrabajo_id']) . "','');";

    $resultado_acta_ot = $obj_bd->EjecutaConsulta($sql_acta);
    $num_acta_ot = $obj_bd->FuncionFetch($resultado_acta_ot);
    $new_acta_ot = $num_acta_ot['acta'] + 1;


//Agregar valores a las celdas
    $encabezado = 'MEDICION PARCIAL DE AVANCE DE OBRA CODENSA SA ESP' . PHP_EOL . 'DEPARTAMENTO DE PROYECTOS DE REDES ALTA TENSIÓN' . PHP_EOL . ''
    . 'CONTRATO NO. 5700014501	' . PHP_EOL . 'Nombre Empresa Contratista: AC Energy SAS - NIT: 900114323-9' . PHP_EOL . ''
    . 'Proyecto: ' . utf8_encode($row['ordentrabajo_obs']) . '' . PHP_EOL . 'Acta N° ' . $new_acta_ot . ': ' . $exp_fecha[2] . '' . PHP_EOL . 'Periodo Facturación: ' . $exp_fecha[2] . ' ' .$exp_fecha[3].''. PHP_EOL . '' . $row['ordentrabajo_num'] . '' . PHP_EOL;

    $objPHPExcel->setActiveSheetIndex(1)
    ->setCellValue('B1', "ACTA DE AVANCE DE OBRA ")
    ->setCellValue('A3', $encabezado)
    ->setCellValue('A8', 'Módulo')
    ->setCellValue('B8', 'Labor')
    ->setCellValue('C8', 'Actividad')
    ->setCellValue('D8', 'Codigo GOM')
    ->setCellValue('E8', 'Cantidad')
    ->setCellValue('F8', 'Vr. Unitario')
    ->setCellValue('L1', utf8_encode($row['ordentrabajo_obs']))
    ->setCellValue('L2', 'PAG 1 DE 1')
    ->setCellValue('H3', '2017')
    ->setCellValue('G8', 'Vr. Total')
    ->setCellValue('H8', 'Observaciones')
    ->setCellValue('I7', 'valor ejecutado Acta No. ' . $new_acta_ot . ' ' . $exp_fecha[2])
    ->setCellValue('I8', 'Cantidad')
    ->setCellValue('J8', 'Vr. Ejecutado')
    ->setCellValue('K8', '%')
    ->setCellValue('L7', 'Valor acumulado')
    ->setCellValue('L8', 'Cantidad')
    ->setCellValue('M8', 'Vr. Acumulado')
    ->setCellValue('N8', '%');
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);

    $objPHPExcel->setActiveSheetIndex(1);

//tipo de relleno, color de fondo y color del texto
    $objPHPExcel->getActiveSheet()->getStyle('I7:N7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('I7:N7')->getFill()->getStartColor()->setARGB('FFFF00');

    $objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFill()->getStartColor()->setARGB('FFFFFF');


//CUERPO DEL REPORTE
//1. Cantidad de Modulos

//formato de cabecera presupuesto
    $objPHPExcel->getActiveSheet()->getStyle('A8:N8')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A8:H8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('A8:D8')->getFill()->getStartColor()->setARGB('1F497D');
    $objPHPExcel->getActiveSheet()->getStyle('E8:G8')->getFill()->getStartColor()->setARGB('FCD5B4');
    $objPHPExcel->getActiveSheet()->getStyle('H8')->getFill()->getStartColor()->setARGB('1F497D');
    $objPHPExcel->getActiveSheet()->getStyle('A8:D8')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
    $objPHPExcel->getActiveSheet()->getStyle('H8')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
    


    $sql_mod = "SELECT lb.labor_id,
    md.modulo_descripcion,
    bm.baremo_item,
    lb.labor_unidmedida,
    lb.labor_descripcion,
    tb.tipobaremo_sigla,
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
    AND pt.detallepresupuesto_id=" . $row['detallepresupuesto_id'] . "
    GROUP BY pt.baremo_id,
    pt.tipobaremo_id,
    pt.detallepresupuesto_id,
    bm.baremo_item,
    tb.tipobaremo_descripcion,
    pt.presupuesto_obs,
    md.modulo_descripcion";

    $resultado_modulo = $obj_bd->EjecutaConsulta($sql_mod);

    $A = 9;
    $A_com = 8;

    $B = 9;
    $B_com = 8;

    $C = 9;
    $C_com = 8;

    $D = 9;
    $E = 9;
    $F = 9;
    $G = 9;
    
    $H = 9;
    $H_com = 8;

    $I = 9;
    $I_com = 8;

    $subtotal_facturar = 0;
    $subtotal_acumulado = 0;
    while ($row_mod = $obj_bd->FuncionFetch($resultado_modulo)) {
        $total_facturar_tarea = 0;
        $total_actividad_acumulado = 0;
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
            SUM(pt.presupuesto_porcentaje)  as suma_porcentaje,
            SUM(pt.presupuesto_valorporcentaje) as suma_valor			
            FROM pt_presupuesto pt
            JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
            JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
            JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id		   
            AND da.detalleactividad_estado=1
            AND pt.baremoactividad_id =" . $row_act['baremoactividad_id'] . "
            AND pt.detallepresupuesto_id=" . $row['detallepresupuesto_id'] . "
            AND pt.modulo_id=" . $row_mod['modulo_id'] . "
            AND pt.presupuesto_estado=1
            AND pt.presupuesto_obs='" . $obs . "'";

            $result_sub = $obj_bd->EjecutaConsulta($sql_sub);
            $num_sub = $obj_bd->Filas($sql_sub);



            if ($num_sub > 0) {//Si tiene subactividades (Se pinta)
                while ($row_sub = $obj_bd->FuncionFetch($result_sub)) {

                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $D, $row_act['actividad_gom']);
                    //$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E' . $E, utf8_encode($row_sub['subactividad_descripcion']));
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E' . $E, utf8_encode($row_sub['suma_porcentaje']));
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F' . $F, utf8_encode($row_act['actividad_valorservicio']));
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G' . $G, utf8_encode($row_sub['suma_valor']));
                    // $obs = preg_replace("/\s+/", " ", $row_act['presupuesto_obs']);
                    // $objPHPExcel->getActiveSheet()->getCell('H' . $H)->setValue(utf8_encode($obs));
                    // $objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getAlignment()->setWrapText(true);


                    //VALIDAR AVANCE DE LA ACTIVIDAD PARA FACTURAR
                    $cantidad = 0;
                    $valor_facturar = 0;
                    $sql_act_facturar = "CALL SP_factura('7','','','','','','','','','','','','','','','','','','','" . trim($row_sub['presupuesto_id']) . "','','')";

                    $resultado_act_facturar = $obj_bd->EjecutaConsulta($sql_act_facturar);
                    $actividad_facturar = $obj_bd->Filas($sql_act_facturar);

                    //  if ($actividad_facturar > 0) {
                    $data_facturar = $obj_bd->FuncionFetch($resultado_act_facturar);

                    /* calcular avance */
                    $sql_av = "SELECT seguimiento_avance 
                    FROM pt_seguimiento 
                    WHERE seguimiento_fechacreo=(SELECT MAX(seguimiento_fechacreo) FROM pt_seguimiento WHERE  presupuesto_id=" . trim($row_sub['presupuesto_id']) . ")";
                    $resultado_av = $obj_bd->EjecutaConsulta($sql_av);
                    $data_av = $obj_bd->FuncionFetch($resultado_av);

                    $cantidad = $data_av['seguimiento_avance'];
                    if ($cantidad == "") {
                        $cantidad = 0;
                    }
                    /*
                      $valor_unitario = $data_facturar['actividad_valorservicio'];
                      $valor_porcent_total = $data_facturar['presupuesto_valorporcentaje'];

                      $valor_facturar = round($cantidad * $valor_unitario);
                      $valor_facturar_form = "$" . number_format($valor_facturar, 0, ',', '.');
                      $total_facturar_tarea = $total_facturar_tarea + $valor_facturar;

                      if ($valor_facturar > 0 && $valor_porcent_total > 0) {
                      $porcent_facturar = round(($valor_facturar * 100) / $valor_porcent_total);

                      // $porcent_facturar = round(($valor_facturar / $valor_porcent_total) * 100);
                      } else {
                      $porcent_facturar = 0;
                      }
                     */
                    //cargar campos
                      $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                      $objPHPExcel->getActiveSheet()->getStyle('K' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                      $objPHPExcel->getActiveSheet()->getStyle('K' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                      $objPHPExcel->getActiveSheet()->getStyle('J' . $F)->getNumberFormat()->setFormatCode('$#,##0.00');
                      $objPHPExcel->getActiveSheet()->getStyle('K' . $F)->getNumberFormat()->setFormatCode('0.0%;[Red]-0.0%');
                      $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I' . $F, $cantidad);
                      $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J' . $F, '=F' . $F . '*I' . $F);
                    //$objPHPExcel->setActiveSheetIndex(1)->setCellValue('K' . $F, $valor_facturar_form);
                      $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K' . $F, '=J' . $F . '/G' . $F);
                    //$objPHPExcel->setActiveSheetIndex(1)->setCellValue('L' . $F, $porcent_facturar . "%");
                    //} 

                      /**/

                    //CALCULAR ACUMULADO
                      $sql_act_acumulado = "CALL SP_factura('8','','','','','','','','','','','','','','','','','','','" . trim($row_sub['presupuesto_id']) . "','','')";

                      $resultado_act_acumulado = $obj_bd->EjecutaConsulta($sql_act_acumulado);
                      $actividad_acumulado = $obj_bd->Filas($sql_act_acumulado);
                      $data_acumulado = $obj_bd->FuncionFetch($resultado_act_acumulado);
                      $cantidad_acumulado = 0;
                      if ($data_acumulado['porcetaje_aco'] != "") {


                        $cantidad_acumulado = $data_acumulado['cantidad_aco'] + $cantidad;
                        $total_acumulado = round($data_acumulado['valor_aco'] + $valor_facturar);
                        $porcentaje_valor = $data_acumulado['presupuesto_valorporcentaje'];
                        $porcentaje_acumulado = round(($valor_facturar * 100) / $valor_porcent_total);
                        // $porcentaje_acumulado = round(($total_acumulado / $porcentaje_valor) * 100);
                        $total_acumulado_form = "$" . number_format($total_acumulado, 0, ',', '.');

                        //cargar campos
                        $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('N' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L' . $F, $cantidad_acumulado);
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M' . $F, $total_acumulado_form);
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N' . $F, $porcentaje_acumulado . "%");

                        $total_actividad_acumulado = $total_actividad_acumulado + $total_acumulado;
                    } else {
                        $total_actividad_acumulado = $total_actividad_acumulado + $valor_facturar;
                        //cargar campos
                        $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('N' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getNumberFormat()->setFormatCode('$#,##0.00');
                        $objPHPExcel->getActiveSheet()->getStyle('N' . $F)->getNumberFormat()->setFormatCode('0.0%;[Red]-0.0%');
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L' . $F, $cantidad);
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M' . $F, '=F' . $F . '*I' . $F);
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N' . $F, '=M' . $F . '/G' . $F);
                        // $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N' . $F, $valor_facturar_form);
                        //$objPHPExcel->setActiveSheetIndex(1)->setCellValue('O' . $F, $porcent_facturar . "%");
                    }


                    /**/

                    $D = $D + 1;
                    $E = $E + 1;
                    $F = $F + 1;
                    $G = $G + 1;
                    // $H = $H + 1;

                    if ($I_com == 8) {
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
                // //Observaciones - combinar campo    
                // $objPHPExcel->setActiveSheetIndex(1)->mergeCells('H' . $C . ':H' . $C_com);
                // $obs = preg_replace("/\s+/", " ", $row_act['presupuesto_obs']);
                // $objPHPExcel->getActiveSheet()->getCell('H' . $C)->setValue(utf8_encode($obs));
                // $objPHPExcel->getActiveSheet()->getStyle('H' . $C)->getAlignment()->setWrapText(true);

                //Actividad
                $objPHPExcel->setActiveSheetIndex(1)->mergeCells('C' . $C . ':C' . $C_com);
                $act = preg_replace("/\s+/", " ", $row_act['actividad_descripcion']);
                $objPHPExcel->getActiveSheet()->getCell('C' . $C)->setValue(utf8_encode($act));
                $objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getAlignment()->setWrapText(true);

                $I = $I_com + 1;
                $C = $C_com + 1;
                $C_com = $C;
                $I_com = $I;
                $num_act_com = $num_act_com + $num_sub;
            } else {
                if ($I_com == 8) {
                    $I_com = $I_com + 1;
                    $C_com = $C_com + 1;
                }
                //GOM
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $D, $row_act['actividad_gom']);


                //CAMPO SUBACTIVIDAD
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E' . $E, '');
                //$objPHPExcel->getActiveSheet()->getCell('E' . $E)->setValue('');
                //CATIDAD
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F' . $F, utf8_encode($row_act['presupuesto_porcentaje']));

                //VR. UNITARIO
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G' . $G, utf8_encode($row_act['actividad_valorservicio']));

                //VR. TOTAL
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H' . $H, utf8_encode($row_act['presupuesto_valorporcentaje']));

                // Observaciones - combinar campo           
                $objPHPExcel->setActiveSheetIndex(1)->mergeCells('I' . $I . ':I' . $I_com);
                $obs = preg_replace("/\s+/", " ", $row_act['presupuesto_obs']);
                $objPHPExcel->getActiveSheet()->getCell('H' . $H)->setValue(utf8_encode($obs));
                $objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getAlignment()->setWrapText(true);

                //Actividad
                $objPHPExcel->setActiveSheetIndex(1)->mergeCells('C' . $C . ':C' . $C_com);
                $act = preg_replace("/\s+/", " ", $row_act['actividad_descripcion']);
                $objPHPExcel->getActiveSheet()->getCell('C' . $C)->setValue(utf8_encode($act));
                $objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getAlignment()->setWrapText(true);


                //VALIDAR AVANCE DE LA ACTIVIDAD PARA FACTURAR
                $cantidad = 0;
                $sql_act_facturar = "CALL SP_factura('7','','','','','','','','','','','','','','','','','','','" . trim($row_act['presupuesto_id']) . "','','')";
                $resultado_act_facturar = $obj_bd->EjecutaConsulta($sql_act_facturar);
                $actividad_facturar = $obj_bd->Filas($sql_act_facturar);

                // if ($actividad_facturar > 0) {
                $data_facturar = $obj_bd->FuncionFetch($resultado_act_facturar);

                /* calcular avance */
                $sql_av = "SELECT seguimiento_avance 
                FROM pt_seguimiento 
                WHERE seguimiento_fechacreo=(SELECT MAX(seguimiento_fechacreo) FROM pt_seguimiento WHERE  presupuesto_id=" . trim($row_sub['presupuesto_id']) . ")";
                $resultado_av = $obj_bd->EjecutaConsulta($sql_av);
                $data_av = $obj_bd->FuncionFetch($resultado_av);

                $cantidad = $data_av['seguimiento_avance'];

                if ($cantidad == "") {
                    $cantidad = 0;
                }
                /*
                  $valor_unitario = $data_facturar['actividad_valorservicio'];
                  $valor_porcent_total = $data_facturar['presupuesto_valorporcentaje'];

                  $valor_facturar = round($cantidad * $valor_unitario);
                  $valor_facturar_form = "$" . number_format($valor_facturar, 0, ',', '.');
                  $total_facturar_tarea = $total_facturar_tarea + $valor_facturar;
                  if ($valor_facturar > 0 && $valor_porcent_total > 0) {

                  //$porcent_facturar = round(($valor_facturar / $valor_porcent_total) * 100);
                  $porcent_facturar = round(($valor_facturar * 100) / $valor_porcent_total);
                  } else {
                  $porcent_facturar = 0;
              } */

                //cargar campos
              $objPHPExcel->getActiveSheet()->getStyle('J' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              $objPHPExcel->getActiveSheet()->getStyle('K' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              $objPHPExcel->getActiveSheet()->getStyle('K' . $F)->getNumberFormat()->setFormatCode('$#,##0.00');
              $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getNumberFormat()->setFormatCode('0.0%;[Red]-0.0%');
              $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J' . $F, $cantidad);
              $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K' . $F, '=G' . $F . '*J' . $F);
              $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L' . $F, '=K' . $F . '/H' . $F);
                //$objPHPExcel->setActiveSheetIndex(1)->setCellValue('K' . $F, $valor_facturar_form);
                //$objPHPExcel->getActiveSheet()->setCellValue('B'.($filava+1),'=SUM(B6:B' .$filava .')');    
                //$objPHPExcel->setActiveSheetIndex(1)->setCellValue('L' . $F, $porcent_facturar . "%");
                //  }
                //CALCULAR ACUMULADO
              $sql_act_acumulado = "CALL SP_factura('8','','','','','','','','','','','','','','','','','','','" . trim($row_act['presupuesto_id']) . "','','')";

              $resultado_act_acumulado = $obj_bd->EjecutaConsulta($sql_act_acumulado);
              $actividad_acumulado = $obj_bd->Filas($sql_act_acumulado);
              $data_acumulado = $obj_bd->FuncionFetch($resultado_act_acumulado);
              if ($data_acumulado['porcetaje_aco'] != "") {


                $cantidad_acumulado = $data_acumulado['cantidad_aco'] + $cantidad;
                $total_acumulado = round($data_acumulado['valor_aco'] + $valor_facturar);
                $porcentaje_valor = $data_acumulado['presupuesto_valorporcentaje'];
                $porcentaje_acumulado = round(($total_acumulado / $porcentaje_valor) * 100);
                $total_acumulado_form = "$" . number_format($total_acumulado, 0, ',', '.');

                    //cargar campos
                $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('N' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('O' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M' . $F, $cantidad_acumulado);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N' . $F, $total_acumulado_form);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O' . $F, $porcentaje_acumulado . "%");

                $total_actividad_acumulado = $total_actividad_acumulado + $total_acumulado;
            } else {
                $total_actividad_acumulado = $total_actividad_acumulado + $valor_facturar;
                    //cargar campos
                $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('N' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('O' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('N' . $F)->getNumberFormat()->setFormatCode('$#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle('O' . $F)->getNumberFormat()->setFormatCode('0.0%;[Red]-0.0%');
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M' . $F, $cantidad);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N' . $F, '=G' . $F . '*J' . $F);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O' . $F, '=K' . $F . '/H' . $F);
                    // $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N' . $F, $valor_facturar_form);
                    //$objPHPExcel->setActiveSheetIndex(1)->setCellValue('O' . $F, $porcent_facturar . "%");
            }
            /**/

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

        //HACER LA SUMATORIA DE LOS TOTALES DE LAS ACTIVIDADES EN EL ACTA
    $subtotal_facturar = $subtotal_facturar + $total_facturar_tarea;
    /**/

    /* SUBTOTAL DE LA ACTIVIDADES PARA EL ACUMULADO */
    $subtotal_acumulado = $subtotal_acumulado + $total_actividad_acumulado;
    /**/

        //LABOR
    if ($B_com == 8) {
        $B_com = $B_com + $num_act_com + 2;
    } else {
        $B_com = $B_com + $num_act_com + 1;
    }

    $objPHPExcel->setActiveSheetIndex(1)->mergeCells('B' . $B . ':B' . $B_com);
        //$objPHPExcel->getActiveSheet()->mergeCells('B' . $B . ':B' . $B_com);
    $labor = preg_replace("/\s+/", " ", $row_mod['baremo_item']);
    $sigla = preg_replace("/\s+/", " ", $row_mod['tipobaremo_sigla']);
    $medida = preg_replace("/\s+/", " ", $row_mod['labor_unidmedida']);
    $objPHPExcel->getActiveSheet()->getCell('B' . $B)->setValue(utf8_encode($sigla . "-" .$labor . " " . $row_mod['labor_descripcion'] . " - UNIDAD DE MEDIDA " . $medida));
    $objPHPExcel->getActiveSheet()->getStyle('B' . $B)->getAlignment()->setWrapText(true);

        //MODULO
    if ($A_com == 8) {
        $A_com = $A_com + $num_act_com + 2;
    } else {
        $A_com = $A_com + $num_act_com + 1;
    }
    $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A' . $A . ':A' . $A_com);
        // $objPHPExcel->getActiveSheet()->mergeCells('A' . $A . ':A' . $A_com);
    $modulo = preg_replace("/\s+/", " ", $row_mod['modulo_descripcion']);
    $objPHPExcel->getActiveSheet()->getCell('A' . $A)->setValue(utf8_encode($modulo));
    $objPHPExcel->getActiveSheet()->getStyle('A' . $A)->getAlignment()->setWrapText(true);

        // //OBSERVACIONES
        // if ($A_com == 8) {
        //     $A_com = $A_com + $num_act_com + 2;
        // } else {
        //     $A_com = $A_com + $num_act_com + 1;
        // }
    $objPHPExcel->setActiveSheetIndex(1)->mergeCells('H' . $A . ':H' . $A_com);
        // $objPHPExcel->getActiveSheet()->mergeCells('A' . $A . ':A' . $A_com);
    $modulo = preg_replace("/\s+/", " ", $row_mod['presupuesto_obs']);
    $objPHPExcel->getActiveSheet()->getCell('H' . $A)->setValue(utf8_encode($modulo));
    $objPHPExcel->getActiveSheet()->getStyle('H' . $A)->getAlignment()->setWrapText(true);


        //SUBTOTAL
    $objPHPExcel->setActiveSheetIndex(1)->mergeCells('C' . $A_com . ':D' . $A_com);
    $objPHPExcel->getActiveSheet()->getCell('C' . $A_com)->setValue(utf8_encode("Subtotal Labor No " . $row_mod['labor_id']));

    $objPHPExcel->getActiveSheet()->getStyle('C' . $A_com . ':D' . $A_com)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $A_com . ':D' . $A_com)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $A_com . ':D' . $A_com)->getFill()->getStartColor()->setARGB('1F497D');
    $objPHPExcel->getActiveSheet()->getStyle('C' . $A_com . ':D' . $A_com)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

        //TOTAL ACTIVIDAD
    $objPHPExcel->setActiveSheetIndex(1)->mergeCells('E' . $A_com . ':G' . $A_com);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $A_com)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getCell('E' . $A_com)->setValue("$" . number_format($row_mod['total_actividad'], 0, ',', '.'));

    $objPHPExcel->getActiveSheet()->getStyle('E' . $A_com . ':G' . $A_com)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $A_com . ':G' . $A_com)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $A_com . ':G' . $A_com)->getFill()->getStartColor()->setARGB('E26B0A');
    $objPHPExcel->getActiveSheet()->getStyle('E' . $A_com . ':G' . $A_com)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

        //VALORES A FACTURAR
    if ($row_mod['total_actividad'] > 0) {
        $porcentaje_facturado = round(($total_facturar_tarea / $row_mod['total_actividad']) * 100);
    } else {
        $porcentaje_facturado = 0;
    }
    $sum_agrupada_hasta = (int) $B_com - 1;

    $objPHPExcel->getActiveSheet()->getStyle('I' . $A_com)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        // $objPHPExcel->getActiveSheet()->getCell('k' . $A_com)->setValue("$ " . number_format($total_facturar_tarea, 0, ',', '.'));
    $objPHPExcel->getActiveSheet()->getStyle('J' . $A_com)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $A_com)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $A_com)->getNumberFormat()->setFormatCode('$#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $A_com)->getNumberFormat()->setFormatCode('0.0%;[Red]-0.0%');
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $A_com, '=SUM(J' . $B . ':J' . $sum_agrupada_hasta . ')');
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $A_com, '=SUM(K' . $B . ':K' . $sum_agrupada_hasta . ')');

        //$objPHPExcel->getActiveSheet()->getCell('L' . $A_com)->setValue($porcentaje_facturado . "%");
    $objPHPExcel->getActiveSheet()->getStyle('I' . $A_com . ':N' . $A_com)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $A_com . ':N' . $A_com)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $A_com . ':N' . $A_com)->getFill()->getStartColor()->setARGB('E26B0A');
    $objPHPExcel->getActiveSheet()->getStyle('I' . $A_com . ':N' . $A_com)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

        //CAULCULAR TOTALES DE ACTIVIDADES ACUMULADO
    if ($row_mod['total_actividad'] > 0) {
        $porcentaje_acumulado = round(($total_actividad_acumulado / $row_mod['total_actividad']) * 100);
    } else {
        $porcentaje_acumulado = 0;
    }


    $objPHPExcel->getActiveSheet()->getStyle('M' . $A_com)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('N' . $A_com)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $A_com)->getNumberFormat()->setFormatCode('$#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $A_com)->getNumberFormat()->setFormatCode('0.0%;[Red]-0.0%');
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $A_com, '=SUM(M' . $B . ':M' . $sum_agrupada_hasta . ')');
    $objPHPExcel->getActiveSheet()->setCellValue('N' . $A_com, '=SUM(N' . $B . ':N' . $sum_agrupada_hasta . ')');
        // $objPHPExcel->getActiveSheet()->getCell('N' . $A_com, '=SUM(N' . $B. ':N' . $sum_agrupada_hasta . ')');
        //$objPHPExcel->setActiveSheetIndex(1)->setCellValue('N' . $A_com. '=SUMA(N' . $A_com-$num_sub . ':N' . $A_com-1  .')');
        //$objPHPExcel->getActiveSheet()->getCell('N' . $A_com)->setValue("$ " . $B);
        //$objPHPExcel->getActiveSheet()->getCell('N' . $A_com)->setValue("$ " . number_format($total_actividad_acumulado, 0, ',', '.'));
    $objPHPExcel->getActiveSheet()->getCell('N' . $A_com)->setValue($porcentaje_facturado . "%");

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


$subtotal = $row['detallepresupuesto_total'];
$ubicacion = $row['detallepresupuesto_valorincremento'];
$subtotal2 = $subtotal + $ubicacion;
$iva = ((float) $subtotal2 * (float) $porcentaje) / 100;
$total = (float) $subtotal2 + (float) $iva;


    //calcular ubicacion a facturar resumen del acta
    if ($row['detallepresupuesto_tipoincremento'] == '1') {// actividades de levantamiento
        $cal_ubicacion_fact = 0;
        $sql_lev = "CALL SP_factura('2','','','','','','','','','','','','','','','','','','','" . trim($row['detallepresupuesto_id']) . "','','')";

        $resultado_lev = $obj_bd->EjecutaConsulta($sql_lev);
        $num_levantamientos = $obj_bd->Filas($sql_lev);

        if ($num_levantamientos != 0) {
            $cal_ubicacion_fact = ($num_levantamientos *
                $row['detallepresupuesto_valorincremento']) / $row['levantamiento_pt'];
        } else {
            $cal_ubicacion_fact = 0;
        }
    } else if ($row['detallepresupuesto_tipoincremento'] == '2') { //validar incremento por presupuesto
        $cal_ubicacion_fact = 0;
        $sql_tot_actividades = "CALL SP_factura('3','','','','','','','','','','','','','','','','','','','" . trim($row['detallepresupuesto_id']) . "','','')";

        $resultado_tot_actividades = $obj_bd->EjecutaConsulta($sql_tot_actividades);
        $num_actividades_resueltas = $obj_bd->Filas($sql_tot_actividades);
        if ($num_actividades_resueltas != 0) {
            $cal_ubicacion_fact = ($num_actividades_resueltas *
                $row['detallepresupuesto_valorincremento']) / $row['total_actividades'];
        } else {
            $cal_ubicacion_fact = 0;
        }
    } else {
        $cal_ubicacion_fact = 0;
    }

    $subtotal2_facturar = $cal_ubicacion_fact + $subtotal_facturar;
    $iva_facturar = ((float) $subtotal2_facturar * (float) $porcentaje) / 100;
    $total_facturar = $subtotal2_facturar + $iva_facturar;
    $porcentaje_facturar = round(($subtotal_facturar / $subtotal) * 100);


    /* CALCULOS DEL RESUMEN DEL ACUMULADO */
    $porcentaje_res_acumulado = round(($subtotal_acumulado / $subtotal) * 100);

    /**/


    ////////////////////////////////////////////////////////////////////////////////////////////
    //                                      TOTALES                                           //
    ////////////////////////////////////////////////////////////////////////////////////////////
    
    /////////////////////////////////// LINEA DE SUBTOTAL //////////////////////////////////////
    
    /************************************ PRESUPUESTO *****************************************/
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('F' . $F)->setValue("Subtotal:");
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->getColor()->setARGB('123D05');
    
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getCell('G' . $G)->setValue("$" . number_format($subtotal, 0, ',', '.'));

    //VARIABLES 
    $ini = $F;
    $sub= $G;

    /***************************************ACTA***********************************************/
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('I' . $F)->setValue("Subtotal: ");
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->getColor()->setARGB('123D05');
    
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $sum_agrupada_hasta = (int) $B_com - 1;
    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getNumberFormat()->setFormatCode('$#,##0');
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $F, '=SUM(J8:J' . $sum_agrupada_hasta . ')/2');
    

    /***************************************ACUMULADO **************************************/
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('L' . $F)->setValue("Subtotal: ");
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->getColor()->setARGB('123D05');
    
    $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getNumberFormat()->setFormatCode('$#,##0');
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $F, '=SUM(M8:M' . $sum_agrupada_hasta . ')/2');
   

    ///////////////////////////////////// LINEA DE UBICACIÓN //////////////////////////////////////
    $G = $G + 1;
    $F = $F + 1;

    /************************************ PRESUPUESTO ********************************************/
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('F' . $F)->setValue("Ubicación 3%");
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getCell('G' . $G)->setValue('1'/*"$" . number_format($ubicacion, 0, ',', '.')*/);

    $ubi = $G;
    
    /***************************************ACTA***********************************************/
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('I' . $F)->setValue("Ubicación 3%");
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->getColor()->setARGB('123D05');

    $objPHPExcel->getActiveSheet()->getStyle('J' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $F)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getCell('J' . $F)->setValue("$ " . number_format($cal_ubicacion_fact, 0, ',', '.'));


    /***************************************ACUMULADO **************************************/    
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('L' . $F)->setValue("Ubicación 3%");
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->getColor()->setARGB('123D05');

    $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getCell('M' . $F)->setValue("$ " . number_format($cal_ubicacion_fact, 0, ',', '.'));


    //////////////////////////////////// SUBTOTAL + UBICACION //////////////////////////////////////
    $G = $G + 1;
    $F = $F + 1;

    /************************************* PRESUPUESTO ***************************************/
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('F' . $F)->setValue("Subtotal:");
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getAlignment()->setWrapText(true);
    
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getNumberFormat()->setFormatCode('$#,##0');

    // declaramos la formula
    $form = 'ROUND((G'. $sub .'+G'. $ubi .'),0)';

    $objPHPExcel->getActiveSheet()->setCellValue('G' . $G, '=' . $form);
    
    $subUbi= $G;
    
    /*************************************** ACTA ******************************************/
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('I' . $F)->setValue("Subtotal:");
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getAlignment()->setWrapText(true);
    
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getNumberFormat()->setFormatCode('$#,##0');

    // declaramos la formula
    $form = 'ROUND((J'. $sub .'+J'. $ubi .'),0)';

    $objPHPExcel->getActiveSheet()->setCellValue('J' . $G, '=' . $form);
  
    /************************************** ACUMULADO ***************************************/
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('L' . $F)->setValue("Subtotal:");
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getAlignment()->setWrapText(true);
    
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getNumberFormat()->setFormatCode('$#,##0');

    // declaramos la formula
    $form = 'ROUND((M'. $sub .'+M'. $ubi .'),0)';

    $objPHPExcel->getActiveSheet()->setCellValue('M' . $G, '=' . $form);
    

    /////////////////////////////////// PAGO A 90 DIAS //////////////////////////////////////////
    $G = $G + 1;
    $F = $F + 1;

    /*********************************** PRESUPUESTO *******************************************/
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('F' . $F)->setValue("Pago 90 días (1.5%): ");
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getNumberFormat()->setFormatCode('$#,##0');

        // declaramos la formula
    $form = 'ROUND((G'. $subUbi .'*0.015),0)';

    $objPHPExcel->getActiveSheet()->setCellValue('G' . $G, '=' . $form);

    $dias = $G;


    /*************************************** ACTA *********************************************/
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('I' . $F)->setValue("Pago 90 días (1.5%): ");
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->getColor()->setARGB('123D05');

    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getNumberFormat()->setFormatCode('$#,##0');

        // declaramos la formula
    $form = 'ROUND((J'. $subUbi .'*0.015),0)';

    $objPHPExcel->getActiveSheet()->setCellValue('J' . $G, '=' . $form);

    /************************************** ACUMULADO ********************************************/
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('L' . $F)->setValue("Pago 90 días (1.5%): ");
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->getColor()->setARGB('123D05');

    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getNumberFormat()->setFormatCode('$#,##0');

        // declaramos la formula
    $form = 'ROUND((M'. $subUbi .'*0.015),0)';

    $objPHPExcel->getActiveSheet()->setCellValue('M' . $G, '=' . $form);

    ///////////////////////////////// SUBTOTAL + PAGO A 90 DIAS //////////////////////////////////
    $G = $G + 1;
    $F = $F + 1;

    /*********************************** PRESUPUESTO *******************************************/
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('F' . $F)->setValue("Subtotal + Pago a 90 días: ");
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->getColor()->setARGB('123D05');

    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getNumberFormat()->setFormatCode('$#,##0');

    // declaramos la formula
    $form = 'ROUND((G'. $subUbi .'+G'. $dias .'),0)';

    $objPHPExcel->getActiveSheet()->setCellValue('G' . $G, '=' . $form);

    $subDias = $G;

    
    /***************************************** ACTA *********************************************/
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('I' . $F)->setValue("Subtotal + Pago a 90 días: ");
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->getColor()->setARGB('123D05');

    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getNumberFormat()->setFormatCode('$#,##0');

    // declaramos la formula
    $form = 'ROUND((J'. $subUbi .'+J'. $dias .'),0)';
    
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $G, '=' . $form);

    //PORCENTAJE
    $objPHPExcel->getActiveSheet()->getStyle('K' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $F)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $F, '=(J' . $F . ' /G' . $F . ')');
    $objPHPExcel->getActiveSheet()
    ->getStyle('K' . $F)
    ->getNumberFormat()
    ->applyFromArray([
        "code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE
    ]);

    /************************************** ACUMULADO ********************************************/
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('L' . $F)->setValue("Subtotal + Pago a 90 días: ");
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->getColor()->setARGB('123D05');

    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getNumberFormat()->setFormatCode('$#,##0');

    // declaramos la formula
    $form = 'ROUND((M'. $subUbi .'+M'. $dias .'),0)';

    $objPHPExcel->getActiveSheet()->setCellValue('M' . $G, '=' . $form);


    //////////////////////////////////////////// IVA ////////////////////////////////////////////

    $G = $G + 1;
    $F = $F + 1;

    /*********************************** PRESUPUESTO *******************************************/
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('F' . $F)->setValue("IVA " .$porcentaje."%:");
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->getColor()->setARGB('123D05');

    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getNumberFormat()->setFormatCode('$#,##0');

    // declaramos la formula
    $form = 'ROUND((G'. $subDias .'*'.$porcentaje.')/100,0)';
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $G, '=' . $form);

    $ivaPorc = $G;


    /***************************************** ACTA *********************************************/
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('I' . $F)->setValue("IVA " .$porcentaje."%:");
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $F)->getFont()->getColor()->setARGB('123D05');
    
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getNumberFormat()->setFormatCode('$#,##0');

    // declaramos la formula
    $form = 'ROUND((J'. $subDias .'*'.$porcentaje.')/100,0)';
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $G, '=' . $form);

    /************************************** ACUMULADO ********************************************/
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('L' . $F)->setValue("IVA  " .$porcentaje."%:");
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $F)->getFont()->getColor()->setARGB('123D05');
    
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getNumberFormat()->setFormatCode('$#,##0');

    // declaramos la formula
    $form = 'ROUND((M'. $subDias .'*'.$porcentaje.')/100,0)';
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $G, '=' . $form);


    ////////////////////////////////////////// TOTAL ////////////////////////////////////////////

    $G = $G + 1;
    $F = $F + 1;

    /*********************************** PRESUPUESTO *******************************************/
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('F' . $F)->setValue("Total: ");
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getFont()->getColor()->setARGB('123D05');

    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getNumberFormat()->setFormatCode('$#,##0');

    // declaramos la formula
    $form = 'ROUND((G'. $subDias .'+G'. $ivaPorc .'),0)';
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $G, '=' . $form);    

    $lim = $G;


    /***************************************** ACTA *********************************************/
    


    /************************************** ACUMULADO ********************************************/
    







    //BORDES CUADRO TOTAL PRESUPUESTO

$objPHPExcel->getActiveSheet()
->getStyle('F'.$ini.':G'.$lim)
->getBorders()
->getAllBorders()
->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 


/**********************RESUMEN A FACTURAR SUBTOTAL ACTAS***************/


    //  $objPHPExcel->getActiveSheet()->getCell('L' . $H)->setValue($porcentaje_facturar . "%");
    //RESUMEN ACUMULADO


    //$objPHPExcel->getActiveSheet()->getCell('O' . $H)->setValue($porcentaje_res_acumulado . "%");


$G = $G + 1;
$H = $H + 1;

    //RESUMEN A FACTURAR UBICACION A FACTURAR ACTA

//eSheet()->getCell('K' . $H)->setValue("$ " . number_format($cal_ubicacion_fact, 0, ',', '.'));


    /* RESUMEN ACUMULADO UBICACION
     */
    // $sql_ubi_acumulada = "CALL SP_factura('9','','','','','','','','','','','','','','','','','','','','" . trim($row['ordentrabajo_id']) . "','');";
    // $result_ubi_acumulada = $obj_bd->EjecutaConsulta($sql_ubi_acumulada);
    // $data_ubicacion_acm = $obj_bd->FuncionFetch($result_ubi_acumulada);

    // $ubicacion_acomulada = $data_ubicacion_acm['ubicacion'];
    // if ($ubicacion_acomulada == "") {
    //     $resultado_ubi_acumulada = 0;
    // }
    // $resultado_ubi_acumulada = $resultado_ubi_acumulada + $cal_ubicacion_fact;
    // $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    // $objPHPExcel->getActiveSheet()->getCell('M' . $G)->setValue("Ubicación 3%");
    // $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setName('Calibri');
    // $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setSize(11);
    // $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setBold(true);
    // $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->getColor()->setARGB('123D05');
    // $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->setName('Calibri');
    // $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->setSize(11);
    // $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->getColor()->setARGB('123D05');
    // $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    // $objPHPExcel->getActiveSheet()->getCell('N' . $H)->setValue("$" . number_format($resultado_ubi_acumulada, 0, ',', '.'));


    // se introduce el campo de % por días en columnas G, J, M
  

    // columna M 
    $sql_ubi_acumulada = "CALL SP_factura('9','','','','','','','','','','','','','','','','','','','','" . trim($row['ordentrabajo_id']) . "','');";
    $result_ubi_acumulada = $obj_bd->EjecutaConsulta($sql_ubi_acumulada);
    $data_ubicacion_acm = $obj_bd->FuncionFetch($result_ubi_acumulada);

    $ubicacion_acomulada = $data_ubicacion_acm['ubicacion'];
    if ($ubicacion_acomulada == "") {
        $resultado_ubi_acumulada = 0;
    }
    $resultado_ubi_acumulada = $resultado_ubi_acumulada + $cal_ubicacion_fact;
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('M' . $G)->setValue("Pago 90 días (1.5%)");
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getCell('N' . $H)->setValue("$" . number_format($resultado_ubi_acumulada, 0, ',', '.'));

    $G = $G + 1;
    $H = $H + 1;

    //RESUMEN A FACTURAR SUBTOTAL A FACTURAR ACTA

    

    /* RESUMEN VALOR ACUMULADO SUBTOTAL */
    $subtotal2_acumulado = $resultado_ubi_acumulada + $subtotal_acumulado;
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('M' . $G)->setValue("Subtotal: ");
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getCell('N' . $H)->setValue("$" . number_format($subtotal2_acumulado, 0, ',', '.'));


    


    //RESUMEN A FACTURAR IVA A FACTURAR ACTA

    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('J' . $G)->setValue("IVA " . $porcentaje . "%: ");
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $H)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $H)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $H)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $H)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getCell('K' . $H)->setValue("$" . number_format($iva_facturar, 0, ',', '.'));

    /* RESUMEN IVA ACUMULADA */
    $iva_acumulada = ((float) $subtotal2_acumulado * (float) $porcentaje) / 100;
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('M' . $G)->setValue("IVA " . $porcentaje . "%: ");
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getCell('N' . $H)->setValue("$" . number_format($iva_acumulada, 0, ',', '.'));
    /**/



    $G = $G + 1;
    $F = $F + 1;

    //RESUMEN A FACTURAR TOTAL A FACTURAR ACTA

    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('J' . $G)->setValue("Total: ");
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $H)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $H)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $H)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $H)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getCell('K' . $H)->setValue("$" . number_format($total_facturar, 0, ',', '.'));

    /* TOTAL ACUMULADO */
    $total_acumulado_resumen = $subtotal2_acumulado + $iva_acumulada;
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('M' . $G)->setValue("Total: ");
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('N' . $H)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getCell('N' . $H)->setValue("$" . number_format($total_acumulado_resumen, 0, ',', '.'));
    /**/

    //BORDES SUBTOTALES
    $H = $H - 3;

    $objPHPExcel->getActiveSheet()
    ->getStyle('A8:N' . $H)
    ->getBorders()
    ->getAllBorders()
    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    //CENTRAR TODAS LAS CELDAS VERTICALMENTE
    $objPHPExcel->getActiveSheet()->getStyle('A8:N' . $H)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    ///////////////////////////////////////////////////////////////////////////////////
    //Actas
    $G = $H + 12;
    $border_ini = $G;
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('J' . $G)->setValue("ACTAS");
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('d60823');

    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('K' . $G)->setValue("VALOR SIN IVA");
    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->getColor()->setARGB('d60823');

    $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('L' . $G)->setValue("%");
    $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->getColor()->setARGB('d60823');


    //VALIDAR SI TIENE ACTAS

    $pep = utf8_encode($row['ordentrabajo_pep']);
    $orden = utf8_encode($row['ordentrabajo_num']);
    $codigo_gom = utf8_encode($row['ordentrabajo_gom']);

    $sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
    $resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
    $existe_actas = $obj_bd->Filas($sql_actas);
    if ($existe_actas > 0) {

        $sum_porcentaje = 0;
        $sum_subtotal = 0;
        while ($row_actas = $obj_bd->FuncionFetch($resultado_actas)) {
            $G = $G + 1;

            $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
            $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
            $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');
            $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getCell('J' . $G)->setValue($row_actas['factura_actanum']);

            $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setName('Calibri');
            $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setSize(11);
            $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->getColor()->setARGB('123D05');
            $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getCell('K' . $G)->setValue("$" . number_format($row_actas['factura_subtotal'], 0, ',', '.'));

            $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setName('Calibri');
            $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setSize(11);
            $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->getColor()->setARGB('123D05');
            $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getCell('L' . $G)->setValue($row_actas['factura_porcentajefacturado'] . "%");
            $sum_porcentaje = $sum_porcentaje + $row_actas['factura_porcentajefacturado'];
            $sum_subtotal = $sum_subtotal + $row_actas['factura_subtotal'];
        }

        //totales
        $G = $G + 1;
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('J' . $G)->setValue("TOTAL");
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');

        $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('K' . $G)->setValue("$" . number_format($sum_subtotal, 0, ',', '.'));

        $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('L' . $G)->setValue($sum_porcentaje . "%");
    } else {
        //variables de acta
        /* VALIDAR FACTURAS PARCIALES */
        $valor_parciales = 0;
        $sql_parciales = "CALL SP_factura('17','','','','','','','','','','','','','','','','','','','" . $row['detallepresupuesto_id'] . "','','')";
        $resultado_parciales = $obj_bd->EjecutaConsulta($sql_parciales);
        $data_parciales = $obj_bd->FuncionFetch($resultado_parciales);
        $valor_parciales = round($data_parciales['factura_parcial']);
        /**/

        /* suma de actividades parciales y finales */
        $total = $valor_parciales + $row['valor_porc'];
        /**/

        $subtotal_sinIva = $row['valor_porc'];
        $porc_facturar_actas = ($total * 100) / $row['detallepresupuesto_total'];
        //$porc_facturar_actas = ($row['valor_porc'] * 100) / $row['detallepresu puesto_total'];
        $porcentaje_facturado = round($porc_facturar_actas) . "%";

        //validar numero de acta
        $sql_acta = "CALL SP_factura('4','','','','','','','','','','','','','','','','','','','','" . trim($row['ordentrabajo_id']) . "','')";

        $resultado_acta = $obj_bd->EjecutaConsulta($sql_acta);
        $num_acta = $obj_bd->FuncionFetch($resultado_acta);
        $acta = $num_acta['acta'] + 1;

        //Fin de variables de acta

        $G = $G + 1;
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('J' . $G)->setValue($acta);

        $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('K' . $G)->setValue("$" . number_format($total, 0, ',', '.'));

        $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('L' . $G)->setValue($porcentaje_facturado);

        //TOTALES
        $G = $G + 1;
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('J' . $G)->setValue("TOTAL");
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');

        $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('K' . $G)->setValue("$" . number_format($total, 0, ',', '.'));

        $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->getColor()->setARGB('123D05');
        $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getCell('L' . $G)->setValue($porcentaje_facturado);
    }

    //OTROS DATOS
    $G = $G + 1;
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('J' . $G)->setValue("CÓDIGO GOM");
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');

    $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('L' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('L' . $G)->setValue($codigo_gom);

    //PEP
    $G = $G + 1;
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('J' . $G)->setValue("PEP");
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');

    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('K' . $G)->setValue($pep);

    //ORDEN
    $G = $G + 1;
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('J' . $G)->setValue("ORDEN");
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $G)->getFont()->getColor()->setARGB('123D05');

    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getFont()->getColor()->setARGB('123D05');
    $objPHPExcel->getActiveSheet()->getStyle('K' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getCell('K' . $G)->setValue($orden);

    //bordes
    $objPHPExcel->getActiveSheet()
    ->getStyle('J' . $border_ini . ':L' . $G)
    ->getBorders()
    ->getAllBorders()
    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $titulo = $row['ordentrabajo_num'];
    /**/
// Nombre de la hoja
    $objPHPExcel->getActiveSheet()->setTitle($titulo);

    // Establecer el índice de la hoja activa, Hoja que Excel abre como la primera hoja
    $objPHPExcel->setActiveSheetIndex(0);
}


/******************************************************************************/
/********************************* RESUMEN ************************************/
/******************************************************************************/

//Conbinar celdas
$objPHPExcel->getActiveSheet()->mergeCells('B2:C4');
$objPHPExcel->getActiveSheet()->mergeCells('D2:P2');
$objPHPExcel->getActiveSheet()->mergeCells('Q2:S2');
$objPHPExcel->getActiveSheet()->mergeCells('D3:P4');
$objPHPExcel->getActiveSheet()->mergeCells('Q3:S4');
$objPHPExcel->getActiveSheet()->mergeCells('B5:S6');

//ANCHO DE LAS COLUMNAS
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(45);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(30);

//TIPO DE LETRA
$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->getColor()->setARGB('123D05');
$objPHPExcel->getActiveSheet()->getStyle('D2:P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->getColor()->setARGB('123D05');
$objPHPExcel->getActiveSheet()->getStyle('D3:P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->getColor()->setARGB('123D05');
$objPHPExcel->getActiveSheet()->getStyle('B5:S6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('Q2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('Q2')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('Q2')->getFont()->getColor()->setARGB('123D05');
$objPHPExcel->getActiveSheet()->getStyle('Q2:S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('Q3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('Q3')->getFont()->setSize(9);
$objPHPExcel->getActiveSheet()->getStyle('Q3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('Q3')->getFont()->getColor()->setARGB('123D05');
$objPHPExcel->getActiveSheet()->getStyle('Q3:S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('D2', "REGISTRO")
->setCellValue('D3', 'RESUMEN FACTURACIÓN')
->setCellValue('B5', 'AC ENERGY SAS')
->setCellValue('Q2', 'Versión')
->setCellValue('Q3', 'DAT:')
->setCellValue('B8', 'PEP')
->setCellValue('C8', 'ORDEN PRESUPUESTAL')
->setCellValue('D8', 'SUBESTACIÓN')
->setCellValue('E8', 'ORDEN')
->setCellValue('F8', 'CÓDIGO GOM')
->setCellValue('G8', 'PROYECTO')
->setCellValue('H8', 'Valor SubTotal OT (antes de IVA)')
->setCellValue('I8', 'UBICACIÓN 3 %')
->setCellValue('J8', 'IVA')
->setCellValue('K8', 'Valor TOTAL OT')
->setCellValue('L8', 'Valor Subtotal a facturar (antes de IVA)')
->setCellValue('M8', '% a Facturar')
->setCellValue('N8', 'Ubicación 3 %')
->setCellValue('O8', 'Valor Subtotal a facturar (antes de IVA) + incremento')
->setCellValue('P8', 'IVA (19%)')
->setCellValue('Q8', 'TOTAL A FACTURAR')
->setCellValue('R8', 'ACTA N° ')
->setCellValue('S8', 'OBSERVACIONES');

$titulo = "RESUMEN";
/**/
// Nombre de la hoja
$objPHPExcel->getActiveSheet()->setTitle($titulo);

// Establecer el índice de la hoja activa, Hoja que Excel abre como la primera hoja
$objPHPExcel->setActiveSheetIndex(0);
$sql_resumen = "CALL SP_factura('1','','','','','','','','" . $fechaFacturaMes . "','" . $fechaFacturaFin . "','','','','','','','','','','','','')";

$resultado_resumen = $obj_bd->EjecutaConsulta($sql_resumen);

$fl = 9;
$n = 0;

while ($resumen = $obj_bd->FuncionFetch($resultado_resumen)) {

    /* VALIDAR FACTURAS PARCIALES */
    $valor_parciales = 0;
    $sql_parciales = "CALL SP_factura('17','','','','','','','','','','','','','','','','','','','" . $resumen['detallepresupuesto_id'] . "','','')";
    $resultado_parciales = $obj_bd->EjecutaConsulta($sql_parciales);
    $data_parciales = $obj_bd->FuncionFetch($resultado_parciales);
    $valor_parciales = round($data_parciales['factura_parcial']);
    /**/

    /* suma de actividades parciales y finales */
    $total = (int) $valor_parciales + (int) $resumen['valor_porc'];
    /**/

    $n = $n + 1;
    $iva_total = ( (int) $resumen['detallepresupuesto_total'] * (int) $porcentaje) / 100;
    $total_ot = $iva_total + $resumen['detallepresupuesto_total'] + $resumen['detallepresupuesto_valorincremento'];

    // $porc_facturar = ($resumen['valor_porc'] * 100) / $resumen['detallepresupuesto_total'];
    $porc_facturar = ($total * 100) / $resumen['detallepresupuesto_total'];
    $SubL = "$" . number_format($total, 0, ',', '.');
    $OtH = "$" . number_format($resumen['detallepresupuesto_total'], 0, ',', '.');
    $ubI = "$" . number_format($resumen['detallepresupuesto_valorincremento'], 0, ',', '.');
    $IvaJ = "$" . number_format($iva_total, 0, ',', '.');
    $totK = "$" . number_format($total_ot, 0, ',', '.');
    $porM = round($porc_facturar) . "%";

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $fl, $n);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $fl, utf8_encode($resumen['ordentrabajo_pep']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $fl, utf8_encode($resumen['ordentrabajo_ordenpresupuestal']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $fl, utf8_encode($resumen['subestacion_nombre']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $fl, utf8_encode($resumen['ordentrabajo_num']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $fl, utf8_encode($resumen['ordentrabajo_gom']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $fl, utf8_encode($resumen['ordentrabajo_obs']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $fl, $OtH);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $fl, $ubI);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $fl, $IvaJ);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $fl, $totK);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $fl, $SubL);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $fl, $porM);


    //Validar la ubicacion FINALIZADA
    if ($resumen['detallepresupuesto_tipoincremento'] == '1') {// actividades de levantamiento
        $cal_ubicacion_fact_res = 0;
        $sql_lev_res = "CALL SP_factura('2','','','','','','','','','','','','','','','','','','','" . trim($resumen['detallepresupuesto_id']) . "','','')";
        $resultado_lev_res = $obj_bd->EjecutaConsulta($sql_lev_res);
        $num_levantamientos_res = $obj_bd->Filas($sql_lev_res);

        if ($num_levantamientos_res != 0) {
            $cal_ubicacion_fact_res = ($num_levantamientos_res *
                $resumen['detallepresupuesto_valorincremento']) / $resumen['levantamiento_pt'];
        } else {
            $cal_ubicacion_fact_res = 0;
        }
    } else if ($resumen['detallepresupuesto_tipoincremento'] == '2') { //validar incremento por presupuesto
        $cal_ubicacion_fact_res = 0;
        $sql_tot_actividades_res = "CALL SP_factura('3','','','','','','','','','','','','','','','','','','','" . trim($resumen['detallepresupuesto_id']) . "','','')";

        $resultado_tot_actividades_res = $obj_bd->EjecutaConsulta($sql_tot_actividades_res);
        $num_actividades_resueltas_res = $obj_bd->Filas($sql_tot_actividades_res);
        if ($num_actividades_resueltas_res != 0) {
            $cal_ubicacion_fact_res = ($num_actividades_resueltas_res *
                $resumen['detallepresupuesto_valorincremento']) / $resumen['total_actividades'];
        } else {
            $cal_ubicacion_fact_res = 0;
        }
    } else {
        $cal_ubicacion_fact_res = 0;
    }

    //Calcular IVA a facturar
    $iva_facturar = ((float) $total * (float) $porcentaje) / 100;
    $total_facturar = $iva_facturar + $total + $cal_ubicacion_fact_res;
    //$total_facturar = $iva_facturar + $resumen['valor_porc'] + $cal_ubicacion_fact_res;
    //validar numero de acta
    $sql_acta = "CALL SP_factura('4','','','','','','','','','','','','','','','','','','','','" . trim($resumen['ordentrabajo_id']) . "','')";

    $resultado_acta = $obj_bd->EjecutaConsulta($sql_acta);
    $num_acta = $obj_bd->FuncionFetch($resultado_acta);
    $new_acta = $num_acta['acta'] + 1;

    //subtotal
    $sub = $total + $cal_ubicacion_fact_res;
    //$sub = $resumen['valor_porc'] + $cal_ubicacion_fact_res;
    $UbiN = "$" . number_format($cal_ubicacion_fact_res, 0, ',', '.');
    $subO = "$" . number_format($sub, 0, ',', '.');
    $ivaP = "$" . number_format($iva_facturar, 0, ',', '.');
    $totalQ = "$" . number_format($total_facturar, 0, ',', '.');

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $fl, $UbiN);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $fl, $subO);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $fl, $ivaP);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $fl, $totalQ);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . $fl, $new_acta);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S' . $fl, utf8_encode($resumen['gestor']));

    $fl = $fl + 1;
}
/* FIN RESUMEN */
//    $objPHPExcel->getSheetByName('Worksheet 1')
//    ->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
//$objPHPExcel->getSheetByName('RESUMEN')
//    ->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);
// Redirect output to a client’s web browser (Excel2007)

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="FACTURA' . $mesFactura . '' . $yearFactura . '.xlsx"');
header('Cache-Control: max-age=0');
header("Pragma: no-cache");
header("Expires: 0");
if ($abrir == '1') {

    $objWriter->save('php://output');
} else if ($abrir == '0') {

    $namexl = 'FACTURA' . $mesFactura . '' . $yearFactura . '.xlsx';
    $objWriter->save('php://output');
    $objWriter->save(str_replace(__FILE__, 'C:/xampp/htdocs/casai/lib/FileFact/' . $namexl, __FILE__));
}


exit;

