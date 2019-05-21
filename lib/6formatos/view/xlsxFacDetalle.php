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

/* 
Include PHPExcel 
*/
require_once '../../../components/phpexcel/Classes/PHPExcel.php';
//require_once '../../../components/com_excel/Classes/PHPExcel.php';
require_once '../../0connection/BD_config.php';
require_once '../../0connection/connection.php';
require_once '../../0connection/BD.php';
/**/


/*
OBJETOS
 */
$obj_bd = new BD();
$objPHPExcel = new PHPExcel();
/**/

/* 
VARIABLES
*/
$porcentaje = $_GET['er'];
$fechaFacturaMes = $_GET['fh'];
$fechaFacturaFin = $_GET['ff'];
$abrir = $_GET['ab'];
/**/

/*
VALIDAR CUANTAS OT'S SE VAN A FACTURAR PARA MOSTRAR EL DETALLE EN CADA PESTAÑA
*/
$sql = "CALL SP_factura('1','','','','','','','','" . $fechaFacturaMes . "','" . $fechaFacturaFin . "','','','','','','','','','','','','')";
$resultado = $obj_bd->EjecutaConsulta($sql);


while ($row = $obj_bd->FuncionFetch($resultado)) {

	//cuenta las pestañas
    $objPHPExcel->getSheetCount(); 
  
    //esto es para que ponga la nueva pestaña al principio
    $positionInExcel = 0; 
  
    //creamos la pestaña
    $objPHPExcel->createSheet($positionInExcel); 

    /*
    OBJETO PARA INSERTAR EL LOGO
     */
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    /**/

    /*
    LOGO DEL REPORTE
    */ 
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $objDrawing->setPath('../../../img/logo.jpg');
    $objDrawing->setHeight(40);
    $objDrawing->setCoordinates('A1');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    /**/

    /*
    VARIABLES
    */
    $codigo_gom = "";
    $pep = "";
    $orden = "";
    $acta = "";
    $subtotal_sinIva = "";
    $porcentaje_facturado = "";
    $resultado_ubi_acumulada = 0;
    $arrayFechaFactura = $obj_bd->obtenerFechaEnLetra($fechaFacturaMes);
    $exp_fechaFactura = explode(",", $arrayFechaFactura);
    $mesFactura = $exp_fechaFactura[2];
    $yearFactura = $exp_fechaFactura[3];
    /**/

    /*
    AJUSTAR PROPIEDADES DEL DOCUMENTO
    */
    $objPHPExcel->getProperties()
    ->setCreator("Casai")
    ->setLastModifiedBy("Casai")
    ->setTitle("Presupuesto")
    ->setSubject("_")
    ->setDescription("_")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("excel");
    /**/


                                            ///////////////////////////
                                            // CABECERA DEL REPORTE  //
                                            ///////////////////////////
  
    /*
    ANCHO DE LAS COLUMNAS
    */
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
    /**/

    /*
    ALTO DE LAS FILAS
    */
    $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(40);
    $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(40);
    $objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(30);
    /**/
  
    /*
    ALINEAR TEXTO
    */
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
    /**/

    /*
    Combinar celdas
    */
    $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
    $objPHPExcel->getActiveSheet()->mergeCells('B1:K2');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:N6');
    $objPHPExcel->getActiveSheet()->mergeCells('L1:N1');
    $objPHPExcel->getActiveSheet()->mergeCells('L2:N2');
    /**/

    /*
    TIPO DE LETRA
    */
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
    /**/

 
                                            ///////////////////////
                                            //CUERPO DEL REPORTE //
                                            ///////////////////////

  	/*
  	FORMATO DE CABECERA PRESUPUESTO
  	*/
  	$objPHPExcel->getActiveSheet()->getStyle('A8:H8')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A8:H8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
  	$objPHPExcel->getActiveSheet()->getStyle('A8:D8')->getFill()->getStartColor()->setARGB('1F497D');
  	$objPHPExcel->getActiveSheet()->getStyle('E8:G8')->getFill()->getStartColor()->setARGB('FCD5B4');
  	$objPHPExcel->getActiveSheet()->getStyle('H8')->getFill()->getStartColor()->setARGB('1F497D');
  	$objPHPExcel->getActiveSheet()->getStyle('A8:D8')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
  	$objPHPExcel->getActiveSheet()->getStyle('H8')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
  	/**/

  	/*
  	TRAER MES DE FACTURACION
  	*/
  	$arrayFecha = $obj_bd->obtenerFechaEnLetra($fechaFacturaMes);
  	$exp_fecha = explode(",", $arrayFecha);
  	/**/

  	/*
  	VALIDAR NUMERO DE ACTA
  	*/
  	$sql_acta = "CALL SP_factura('4','','','','','','','','','','','','','','','','','','','','" . trim($row['ordentrabajo_id']) . "','');";

  	$resultado_acta_ot = $obj_bd->EjecutaConsulta($sql_acta);
  	$num_acta_ot = $obj_bd->FuncionFetch($resultado_acta_ot);
  	$new_acta_ot = $num_acta_ot['acta'];
  	/**/

  	/*
  	AGREGAR VALORES A LAS CELDAS
  	*/
  	$encabezado = 'MEDICION PARCIAL DE AVANCE DE OBRA CODENSA SA ESP' . PHP_EOL . 'DEPARTAMENTO DE PROYECTOS DE REDES ALTA TENSIÓN' . PHP_EOL . ''
  	. 'CONTRATO NO. 5700014501	' . PHP_EOL . 'Nombre Empresa Contratista: AC Energy SAS - NIT: 900114323-9' . PHP_EOL . ''
  	. 'Proyecto: ' . utf8_encode($row['ordentrabajo_obs']) . '' . PHP_EOL . 'Acta N° ' . $new_acta_ot . ': ' . $exp_fecha[2] . '' . PHP_EOL . 'Periodo Facturación: ' . $exp_fecha[2] . ' ' . $exp_fecha[3] . '' . PHP_EOL . '' . $row['ordentrabajo_num'] . '' . PHP_EOL;
  	/**/

  	/*
  	TITULOS CABEZCERA TABLA
  	*/
  	$objPHPExcel->setActiveSheetIndex(1)
  	->setCellValue('A1')
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
  	->setCellValue('H8', 'Observaciones');
  
  	$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);


  	/*
  	CONSULTA MODULOS
   	*/
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
  	GROUP BY md.modulo_descripcion,
  	pt.baremo_id,
  	pt.tipobaremo_id,
  	pt.detallepresupuesto_id,
  	bm.baremo_item,
  	tb.tipobaremo_descripcion,
  	pt.presupuesto_obs";

  	$resultado_modulo = $obj_bd->EjecutaConsulta($sql_mod);
  	/**/

  	/*
  	FILAS
   	*/
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
  	/**/

	$subtotal_facturar = 0;
  	$subtotal_acumulado = 0;


	while ($row_mod = $obj_bd->FuncionFetch($resultado_modulo)) {
	  	
	    $total_facturar_tarea = 0;
	  	$total_actividad_acumulado = 0;
	  	$num_act_com = 0;
	  	$obs = $row_mod['presupuesto_obs'];

	    /*
	    2. CONSULTA ACTIVIDADES
	    */
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
	    /**/  	

	    while ($row_act = $obj_bd->FuncionFetch($result_act)) {

	  		/*
	        3. CONSULTAR SUBACTIVIDADES
	         */
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
	  		AND pt.presupuesto_obs='" . $obs . "';";

	  		$result_sub = $obj_bd->EjecutaConsulta($sql_sub);
	  		$num_sub = $obj_bd->Filas($sql_sub);
	        /**/
		  	
		  	/*
		  	COLUMNAS
		   	*/
		  	$col_I = 8;
		  	$col_J = 9;
		  	$col_K = 10;
		  	/**/

		    if ($num_sub > 0) { //Si tiene subactividades (Se pinta)
		        while ($row_sub = $obj_bd->FuncionFetch($result_sub)) {

	          		$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $D, $row_act['actividad_gom']);
	          		$objPHPExcel->getActiveSheet()->getStyle('D' . $D)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	              

	          		$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E' . $E, utf8_encode($row_sub['suma_porcentaje']));
	          		$objPHPExcel->getActiveSheet()->getStyle('E' . $E)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	          		$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F' . $F, utf8_encode($row_act['actividad_valorservicio']));
	          		$objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getNumberFormat()->setFormatCode('$#,##0');
	          		$objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	              

	          		$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G' . $G, '=E' . $G . '*F' . $G);
	          		$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getNumberFormat()->setFormatCode('$#,##0');
	          		$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		            

	                /*
	                AUMENTO DE FILAS
	                */
	                  $D = $D + 1;
	                  $E = $E + 1;
	                  $F = $F + 1;
	                  $G = $G + 1;
	                  $H = $H + 1;
	                /**/
	                if ($I_com == 8) {
	              	 $I_com = $I_com + 1;
	              	 $C_com = $C_com + 1;
	                }
	            }//FIN WHILE

		            

		      	if ($num_sub == 1) {
		      		$I_com = $I_com;
		      		$C_com = $C_com;
		      	} else {
		      		$I_com = $I_com + 1;
		      		$C_com = $C_com + 1;
		    	}


		        //ACTIVIDAD
			    $objPHPExcel->setActiveSheetIndex(1)->mergeCells('C' . $C . ':C' . $C_com);
			    $act = preg_replace("/\s+/", " ", $row_act['actividad_descripcion']);
			    $objPHPExcel->getActiveSheet()->getCell('C' . $C)->setValue(utf8_encode($act));
			    $objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getAlignment()->setWrapText(true);

			    $I = $I_com + 1;
			    $C = $C_com + 1;
			    $C_com = $C;
			    $I_com = $I;
			    $num_act_com = $num_act_com + $num_sub;
	  		} else {/*FIN SI*/

			  	if ($I_com == 8) {
			  		$I_com = $I_com + 1;
			  		$C_com = $C_com + 1;
			  	}

			    //ACTIVIDAD
			  	$objPHPExcel->setActiveSheetIndex(1)->mergeCells('C' . $C . ':C' . $C_com);
			  	$act = preg_replace("/\s+/", " ", $row_act['actividad_descripcion']);
			  	$objPHPExcel->getActiveSheet()->getCell('C' . $C)->setValue(utf8_encode($act));
			  	$objPHPExcel->getActiveSheet()->getStyle('C' . $C)->getAlignment()->setWrapText(true);
			    
			    //GOM
			  	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $D, $row_act['actividad_gom']);

			    //CAMPO SUBACTIVIDAD
			  	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E' . $E, '');
			    
			    //CATIDAD
			  	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F' . $F, utf8_encode($row_act['presupuesto_porcentaje']));

			    //VR. UNITARIO
			  	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G' . $G, utf8_encode($row_act['actividad_valorservicio']));

			    //VR. TOTAL
			  	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H' . $H, utf8_encode($row_act['presupuesto_valorporcentaje']));

			    // OBSERVACIONES - COMBINAR CAMPO
			  	$objPHPExcel->setActiveSheetIndex(1)->mergeCells('h' . $I . ':h' . $I_com);
			  	$obs = preg_replace("/\s+/", " ", $row_act['presupuesto_obs']);
			  	$objPHPExcel->getActiveSheet()->getCell('H' . $H)->setValue(utf8_encode($obs));
			  	$objPHPExcel->getActiveSheet()->getStyle('H' . $H)->getAlignment()->setWrapText(true);

			
				

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
			}//ELSE
	    }//FIN WHILE

	    
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
		$labor = preg_replace("/\s+/", " ", $row_mod['baremo_item']);
		$sigla = preg_replace("/\s+/", " ", $row_mod['tipobaremo_sigla']);
		$medida = preg_replace("/\s+/", " ", $row_mod['labor_unidmedida']);
		$objPHPExcel->getActiveSheet()->getCell('B' . $B)->setValue(utf8_encode($sigla . "-" . $labor . " " . $row_mod['labor_descripcion'] . " - UNIDAD DE MEDIDA " . $medida));
		$objPHPExcel->getActiveSheet()->getStyle('B' . $B)->getAlignment()->setWrapText(true);

	    //MODULO
	   	if ($A_com == 8) {
	   		$A_com = $A_com + $num_act_com + 2;
	   	} else {
	   		$A_com = $A_com + $num_act_com + 1;
	   	}
	   
	   	$objPHPExcel->setActiveSheetIndex(1)->mergeCells('A' . $A . ':A' . $A_com);
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
	   	$obs = preg_replace("/\s+/", " ", $row_mod['presupuesto_obs']);
	   	$objPHPExcel->getActiveSheet()->getCell('H' . $A)->setValue(utf8_encode($obs));
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
	   	$objPHPExcel->getActiveSheet()->getStyle('E' . $A_com . ':G' . $A_com)->getFont()->setBold(true);
	   	$objPHPExcel->getActiveSheet()->getStyle('E' . $A_com . ':G' . $A_com)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	   	$objPHPExcel->getActiveSheet()->getStyle('E' . $A_com . ':G' . $A_com)->getFill()->getStartColor()->setARGB('E26B0A');
	   	$objPHPExcel->getActiveSheet()->getStyle('E' . $A_com . ':G' . $A_com)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	   	$objPHPExcel->getActiveSheet()->getStyle('E' . $A_com)->getNumberFormat()->setFormatCode('$#,##0');
	   	$sum_agrupada_hasta = (int)$B_com - 1;
	   	$objPHPExcel->getActiveSheet()->setCellValue('E' . $A_com, '=SUM(G' . $B . ':G' . $sum_agrupada_hasta . ')');

									   	//////////////////////////////////
	   									// SUMA VALORES PARCIALES ACTAS //
									   	//////////////////////////////////

	   	// CONSULTA ACTAS //
	   	$sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
		$resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
  		$row_actas = $obj_bd->FuncionFetch($resultado_actas);
  		$stop = $row_actas['factura_actanum'];
  
		// COLUMNAS //
		$col_I = 8;
		$col_J = 9;
		$col_K = 10;

  		for ($i=0; $i < $stop ; $i++) {
	    
			// LETRAS DE LAS COLUMNAS //
		   	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
		   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
		   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);

		   	$sum_agrupada_hasta = (int)$B_com - 1;

		   	// VALORES CELDAS //
		   	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_I, $A_com)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		   	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_J, $A_com)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_K, $A_com)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_J, $A_com)->getNumberFormat()->setFormatCode('$#,##0.00');
		   	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_K, $A_com)->getNumberFormat()->setFormatCode('0.0%;[Red]-0.0%');
		   	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_J,$A_com, '=SUM('. $J . $B . ':'. $J . $sum_agrupada_hasta . ')');
		   	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_K, $A_com, '=SUM('. $K . $B . ':'. $K . $sum_agrupada_hasta . ')');

		   	// ESTILOS CELDAS //		   	
		   	$merge = "$I{$A_com}:$K{$A_com}";
		   	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFont()->setBold(true);
		   	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		   	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFill()->getStartColor()->setARGB('E26B0A');
		   	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

		   	

		   	// CONTADOR COLUMNAS //
		  	$col_I = $col_I + 3;
			$col_J = $col_J + 3;
			$col_K = $col_K + 3;

		}//FIN FOR


	   	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_J , $A_com)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	   	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_K , $A_com)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	   	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_J , $A_com)->getNumberFormat()->setFormatCode('$#,##0.00');
	   	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_K , $A_com)->getNumberFormat()->setFormatCode('0.0%;[Red]-0.0%');

	   	// LETRAS DE LAS COLUMNAS //
		   	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
		   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
		   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);

	   	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_J , $A_com, '=SUM('. $J . $B . ':'. $J . $sum_agrupada_hasta . ')');
	   	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_K , $A_com, '=SUM('. $K . $B . ':'. $K . $sum_agrupada_hasta . ')');

	   	// ESTILOS CELDAS //		   	
		   	$merge = "$I{$A_com}:$K{$A_com}";
		   	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFont()->setBold(true);
		   	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		   	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFill()->getStartColor()->setARGB('E26B0A');
		   	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);



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

	   	
	}// FIN WHILE

											/////////////////////////
											// TABLAS DE LAS ACTAS //
											/////////////////////////
	/*
	FILAS
	*/
	$row7 = 7;
	$row8 = 8;
	$row9 = 9;
	
	/*
	COLUMNAS
	*/
	$col_I = 8;
	$col_J = 9;
	$col_K = 10;
	
	
	// CONSULTA //
	$sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
	$resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
	$row_actas = $obj_bd->FuncionFetch($resultado_actas);
	$stop = $row_actas['factura_actanum'];
	

	for ($i=0; $i < $stop ; $i++) {
		
		// VARIABLES //
		$acta_num = $i + 1; 

		// LETRAS DE LAS COLUMNAS //
	   	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
	   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
	   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);
		
	   	// COMBINACION CELDAS //
	   	$merge = "$I{$row7}:$K{$row7}";
		$objPHPExcel->getActiveSheet()->mergeCells($merge);

		// BORDES //
		$merge = "$I{$row7}:$K{$row7}";
		$objPHPExcel->getActiveSheet()
		->getStyle($merge)
		->getBorders()
		->getAllBorders()
		->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		$com = $A_com - 1;
		$merge = "$I{$row8}:$K{$com}";
		$objPHPExcel->getActiveSheet()
		->getStyle($merge)
		->getBorders()
		->getAllBorders()
		->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
  
		// COLOR CELDAS //
		$merge = "$I{$row7}:$K{$row7}";
		$objPHPExcel->getActiveSheet()->getStyle($merge)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
  		$objPHPExcel->getActiveSheet()->getStyle($merge)->getFill()->getStartColor()->setARGB('FFFF00');		

		// TAMAÑO DE LAS COLUMNAS //
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col_I)->setWidth(25);
  		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col_J)->setWidth(20);
  		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col_K)->setWidth(20);

  		// ALINEACION DE LAS COLUMNAS //
  		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_I, $row7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_I, $row7)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_I, $row8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_J, $row8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_K, $row8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

  		// TIPO DE LETRA //
  		$merge = "$I{$row8}:$K{$row8}";
		$objPHPExcel->getActiveSheet()->getStyle($merge)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($merge)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($merge)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle($merge)->getFont()->getColor()->setARGB('123D05');  		

		// CONSULTA //
		$sql_actas1 = "CALL SP_factura('25','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','".$acta_num."')";

		$resultado_actas1 = $obj_bd->EjecutaConsulta($sql_actas1);
		$row_actas1 = $obj_bd->FuncionFetch($resultado_actas1);

		$fecha_inicio = $row_actas1['fecha_inicio'];
		$fecha_fin = $row_actas1['fecha_fin'];

		$arrayFecha = $obj_bd->obtenerFechaEnLetra($fecha_inicio);
    	$exp_fecha = explode(",", $arrayFecha);
    	$mesFechaInicio = $exp_fecha[2];
    	$yearFechaFin = $exp_fecha[3];


  		// VALORES CELDAS //
	   	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_I, $row7, 'Valor Ejecutado Acta No. '. $acta_num . ' de ' . $mesFechaInicio . ' ' . $yearFechaFin);
	   	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_I, $row8, 'Cantidad');
	   	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_J, $row8, 'Vr. Ejecutado');
	   	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_K, $row8, '%');
		

      	/*
      	CONSULTA MODULOS
      	*/
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
      	GROUP BY md.modulo_descripcion,
      	pt.baremo_id,
      	pt.tipobaremo_id,
      	pt.detallepresupuesto_id,
      	bm.baremo_item,
      	tb.tipobaremo_descripcion,
      	pt.presupuesto_obs";
      	/**/

      	$resultado_modulo = $obj_bd->EjecutaConsulta($sql_mod);

      	/*
    	FILAS
    	*/
	    $row7 = 7;
	    $row8 = 8;
	    $row9 = 9;
	    
	    // VARIABLES //
	    $num = 0;

	    while ($row_mod = $obj_bd->FuncionFetch($resultado_modulo)) {
        
	        $total_facturar_tarea = 0;
	        $total_actividad_acumulado = 0;
	        $num_act_com = 0;
	        $obs = $row_mod['presupuesto_obs'];

	        /*
	        2. CONSULTA ACTIVIDADES
	        */
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
	        /**/    

	        while ($row_act = $obj_bd->FuncionFetch($result_act)) {

            	/*
            	3. CONSULTAR SUBACTIVIDADES
             	*/
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
          		AND pt.presupuesto_obs='" . $obs . "';";

          		$result_sub = $obj_bd->EjecutaConsulta($sql_sub);
          		$num_sub = $obj_bd->Filas($sql_sub);
            	/**/
        
        
            	if ($num_sub > 0) { //Si tiene subactividades (Se pinta)
                	while ($row_sub = $obj_bd->FuncionFetch($result_sub)) {


	                  	$sql_porcentaje = "CALL SP_factura('23','','','','','','','','','','','','','','','','','','','".$row['detallepresupuesto_id']."','" . $row_mod['modulo_id'] . "','".$acta_num."')";

	                  	$result_porcentaje = $obj_bd->EjecutaConsulta($sql_porcentaje);
	                  	$row_porcentaje = $obj_bd->FuncionFetch($result_porcentaje);

	                  	$porcent = $row_porcentaje['suma_porcentajes'];

	                  	if ($porcent == "") {
		                    $porcent = 0;
		                }

                 		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_I, $row9)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_I, $row9, $porcent);

                    	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_J, $row9)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_J, $row9)->getNumberFormat()->setFormatCode('$#,##0.00');
	                    $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_J, $row9, '=F' . $row9 . '*'. $I . $row9);

	                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_K, $row9)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_K, $row9)->getNumberFormat()->setFormatCode('0.0%;[Red]-0.0%');
	                    $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_K, $row9, '=' . $J . $row9 . '/G' . $row9);



			            $row9 = $row9 + 1;
			            $num = $num + 1;
			        }//fin while 3
          
          			// COMPRUEBA SI NO HAY MAS SUBACTIVIDADES
          			if ($num == $num_act) {
            			$row9 = $row9 + 2;
            			$num = 0;
          			}
        		}//fin is
      		}//fin while 2
    	}// fin while 1

		$row9 = 9;
		$num = 1;
		$col_I = $col_I + 3;
		$col_J = $col_J + 3;
		$col_K = $col_K + 3;
	}//FIN FOR

	$col = $col_I;
	$col_letra = $I;

										/////////////////////
										// TABLA ACUMULADO //
										/////////////////////

	// LETRAS DE LAS COLUMNAS //
   	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);
	
   	// COMBINACION CELDAS //
   	$merge = "$I{$row7}:$K{$row7}";
	$objPHPExcel->getActiveSheet()->mergeCells($merge);

	// BORDES //
	$merge = "$I{$row7}:$K{$row7}";
	$objPHPExcel->getActiveSheet()
	->getStyle($merge)
	->getBorders()
	->getAllBorders()
	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	$com = $A_com - 1;
	$merge = "$I{$row8}:$K{$com}";
	$objPHPExcel->getActiveSheet()
	->getStyle($merge)
	->getBorders()
	->getAllBorders()
	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	// COLOR CELDAS //
	$merge = "$I{$row7}:$K{$row7}";
	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFill()->getStartColor()->setARGB('FFFF00');		

	// TAMAÑO DE LAS COLUMNAS //
	$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col_I)->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col_J)->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col_K)->setWidth(20);

	// ALINEACION DE LAS COLUMNAS //
	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_I, $row7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_I, $row7)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_I, $row8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_J, $row8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_K, $row8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// TIPO DE LETRA //
	$merge = "$I{$row8}:$K{$row8}";
	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($merge)->getFont()->getColor()->setARGB('123D05');  		

	// VALORES CELDAS //
   	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_I, $row7, 'Valor Acumulado');
   	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_I, $row8, 'Cantidad');
   	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_J, $row8, 'Vr. Ejecutado');
   	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_K, $row8, '%');

   	/*
  	CONSULTA MODULOS
  	*/
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
  	GROUP BY md.modulo_descripcion,
  	pt.baremo_id,
  	pt.tipobaremo_id,
  	pt.detallepresupuesto_id,
  	bm.baremo_item,
  	tb.tipobaremo_descripcion,
  	pt.presupuesto_obs";
  	/**/

  	$resultado_modulo = $obj_bd->EjecutaConsulta($sql_mod);

  	/*
	FILAS
	*/
    $row7 = 7;
    $row8 = 8;
    $row9 = 9;
    
    // VARIABLES //
    $num = 0;

    while ($row_mod = $obj_bd->FuncionFetch($resultado_modulo)) {
    
        $total_facturar_tarea = 0;
        $total_actividad_acumulado = 0;
        $num_act_com = 0;
        $obs = $row_mod['presupuesto_obs'];

        /*
        2. CONSULTA ACTIVIDADES
        */
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
        /**/    

        while ($row_act = $obj_bd->FuncionFetch($result_act)) {

        	/*
        	3. CONSULTAR SUBACTIVIDADES
         	*/
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
      		AND pt.presupuesto_obs='" . $obs . "';";

      		$result_sub = $obj_bd->EjecutaConsulta($sql_sub);
      		$num_sub = $obj_bd->Filas($sql_sub);
        	/**/
    
    
        	if ($num_sub > 0) { //Si tiene subactividades (Se pinta)
            	while ($row_sub = $obj_bd->FuncionFetch($result_sub)) {

                  	$col_I = 8;
	                $array_total_presupuesto = 0;

	                // CONSULTA //
					$sql_actas1 = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
					$resultado_actas1 = $obj_bd->EjecutaConsulta($sql_actas1);
					$row_actas1 = $obj_bd->FuncionFetch($resultado_actas1);
					$stop1 = $row_actas1['factura_actanum'];
					
					for ($x=0; $x < $stop1 ; $x++) {

		                $I = PHPExcel_Cell::stringFromColumnIndex($col_I);

						$array_total_presupuesto .= '+' . $I . $row9;

						$col_I = $col_I + 3;
					}

	                $col_I = $col;
	                $I = PHPExcel_Cell::stringFromColumnIndex($col_I);

             		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_I, $row9)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_I, $row9, '='. $array_total_presupuesto);

                	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_J, $row9)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_J, $row9)->getNumberFormat()->setFormatCode('$#,##0.00');
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_J, $row9, '=F' . $row9 . '*'. $I . $row9);

                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_K, $row9)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col_K, $row9)->getNumberFormat()->setFormatCode('0.0%;[Red]-0.0%');
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow($col_K, $row9, '=' . $J . $row9 . '/G' . $row9);


		            $row9 = $row9 + 1;
		            $num = $num + 1;
		        }//fin while 3
      
      			// COMPRUEBA SI NO HAY MAS SUBACTIVIDADES
      			if ($num == $num_act) {
        			$row9 = $row9 + 2;
        			$num = 0;
      			}
    		}//fin is
  		}//fin while 2
	}// fin while 1

   	
	
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
	  // $objPHPExcel->getActiveSheet()->getCell('G' . $G)->setValue("$" . number_format($subtotal, 0, ',', '.'));
	$sum_agrupada_hasta = (int)$B_com - 1;
	$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getNumberFormat()->setFormatCode('$#,##0');
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $G, '=SUM(G8:G' . $sum_agrupada_hasta . ')');

	  //VARIABLES
	$ini = $F;
	$sub = $G;

	/***************************************ACTA***********************************************/

	/*
	COLUMNAS
	*/
	$col_I = 8;
	$col_J = 9;
	$col_K = 10;
	
	
	// CONSULTA //
	$sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
	$resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
	$row_actas = $obj_bd->FuncionFetch($resultado_actas);
	$stop = $row_actas['factura_actanum'];
	

	for ($i=0; $i < $stop ; $i++) {
		
		// VARIABLES //
		$acta_num = $i + 1; 

		// LETRAS DE LAS COLUMNAS //
	   	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
	   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
	   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);

		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("Subtotal: ");
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');

		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		$sum_agrupada_hasta = (int)$B_com - 1;
		$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');
		$objPHPExcel->getActiveSheet()->setCellValue($J . $F, '=SUM('.$J.'9:'.$J. $sum_agrupada_hasta . ')/2');

		// AUMENTO COLUMNAS //
		$col_I = $col_I + 3;
		$col_J = $col_J + 3;
		$col_K = $col_K + 3;

	}//FIN FOR

	/***************************************ACUMULADO **************************************/
	// LETRAS DE LAS COLUMNAS //
  	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);


	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue('Subtotal:');
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');

	$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getNumberFormat()->setFormatCode('$#,##0');
	$objPHPExcel->getActiveSheet()->setCellValue($J . $F, '=SUM('.$J.'9:'.$J.$sum_agrupada_hasta . ')/2');


	///////////////////////////////////// LINEA DE UBICACIÓN //////////////////////////////////////
	$G = $G + 1;
	$F = $F + 1;

	/************************************ PRESUPUESTO ********************************************/

	  //consulta para sumar solo las labores que tengan levantamiento
	$sqlUbi = " SELECT sum(pt.presupuesto_valorporcentaje)*0.03 as porcentaje
	FROM pt_presupuesto pt
	JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
	JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
	AND sb.subactividad_id=1
	AND pt.presupuesto_estado=1
	WHERE pt.detallepresupuesto_id=" . $row['detallepresupuesto_id'] . ";";

	$resUbi = $obj_bd->EjecutaConsulta($sqlUbi);
	$rowUbi = $obj_bd->FuncionFetch($resUbi);
	$ubicacion = $rowUbi['porcentaje'];

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
	$objPHPExcel->getActiveSheet()->getStyle('G' . $G)->getNumberFormat()->setFormatCode('$#,##0');
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $G, $ubicacion);

	$ubi = $G;

	/***************************************ACTA***********************************************/

	/*
	COLUMNAS
	*/
	$col_I = 8;
	$col_J = 9;
	$col_K = 10;
	
	
	// CONSULTA //
	$sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
	$resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
	$row_actas = $obj_bd->FuncionFetch($resultado_actas);
	$stop = $row_actas['factura_actanum'];
	
	$acta_ubic = 0;

	for ($i=0; $i < $stop ; $i++) {
		
		$acta_ubic = $acta_ubic + 1;

		// LETRAS DE LAS COLUMNAS //
		$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
		$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
		$K = PHPExcel_Cell::stringFromColumnIndex($col_K);


		$sqlUbi_actas = "CALL SP_factura('18','','','','','','','','" . $fecha_inicio . "','" . $fecha_fin . "','','','','','','','','','','" . $row['detallepresupuesto_id'] . "','','".$acta_ubic."')";

		$resUbi_actas = $obj_bd->EjecutaConsulta($sqlUbi_actas);
		$rowUbi_actas = $obj_bd->FuncionFetch($resUbi_actas);
		$ubicacion_actas = $rowUbi_actas['ubicacion'];

		if ($ubicacion_actas == ""){
			$ubicacion_actas = 0;
		}


		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("Ubicación 3%");
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');

		$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getFont()->getColor()->setARGB('123D05');
		$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getNumberFormat()->setFormatCode('$#,##0');
		$objPHPExcel->getActiveSheet()->setCellValue($J . $F, $ubicacion_actas);

		// AUMENTO COLUMNAS //
		$col_I = $col_I + 3;
		$col_J = $col_J + 3;
		$col_K = $col_K + 3;

	}//FIN FOR


	/***************************ACUMULADO **************************************/
	
	$col_J = 9;
    $array_total_presupuesto = 0;

    // CONSULTA //
	$sql_actas1 = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
	$resultado_actas1 = $obj_bd->EjecutaConsulta($sql_actas1);
	$row_actas1 = $obj_bd->FuncionFetch($resultado_actas1);
	$stop1 = $row_actas1['factura_actanum'];
	
	for ($x=0; $x < $stop1 ; $x++) {

        $J = PHPExcel_Cell::stringFromColumnIndex($col_J);

		$array_total_presupuesto .= '+' . $J . $F;

		$col_J = $col_J + 3;
	}

	// LETRAS DE LAS COLUMNAS //
  	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);

	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("Ubicación 3%");
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');

	$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle($J . $F)->getNumberFormat()->setFormatCode('$#,##0');
	$objPHPExcel->getActiveSheet()->getCell($J . $F)->setValue('='. $array_total_presupuesto);


	///////////////////// SUBTOTAL + UBICACION ///////////////////////////////
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

	// DECLARAMOS LA FORMULA
	$form = '(G' . $sub . '+G' . $ubi . ')';

	$objPHPExcel->getActiveSheet()->setCellValue('G' . $G, '=' . $form);

	$subUbi = $G;

	/*************************************** ACTA ******************************************/
	/*
	COLUMNAS
	*/
	$col_I = 8;
	$col_J = 9;
	$col_K = 10;
	
	
	// CONSULTA //
	$sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
	$resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
	$row_actas = $obj_bd->FuncionFetch($resultado_actas);
	$stop = $row_actas['factura_actanum'];
	

	for ($i=0; $i < $stop ; $i++) {
		
		// LETRAS DE LAS COLUMNAS //
		$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
		$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
		$K = PHPExcel_Cell::stringFromColumnIndex($col_K);

		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("Subtotal:");
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setWrapText(true);

		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');

		// DECLARAMOS LA FORMULA
		$form = '('. $J . $sub . '+'. $J . $ubi . ')';

		$objPHPExcel->getActiveSheet()->setCellValue($J . $G, '=' . $form);
	
		// AUMENTO COLUMNAS //
		$col_I = $col_I + 3;
		$col_J = $col_J + 3;
		$col_K = $col_K + 3;

	}//FIN FOR


	/***************************ACUMULADO **************************************/
	// LETRAS DE LAS COLUMNAS //
  	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);

	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("Subtotal:");
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setWrapText(true);

	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');

	// DECLARAMOS LA FORMULA
	$form = '('. $J . $sub . '+'. $J . $ubi . ')';

	$objPHPExcel->getActiveSheet()->setCellValue($J . $G, '=' . $form);


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
	$form = '(G' . $subUbi . '*0.015)';

	$objPHPExcel->getActiveSheet()->setCellValue('G' . $G, '=' . $form);

	$dias = $G;


	/*************************************** ACTA *********************************************/
	/*
	COLUMNAS
	*/
	$col_I = 8;
	$col_J = 9;
	$col_K = 10;
	
	
	// CONSULTA //
	$sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
	$resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
	$row_actas = $obj_bd->FuncionFetch($resultado_actas);
	$stop = $row_actas['factura_actanum'];
	

	for ($i=0; $i < $stop ; $i++) {
		
		// LETRAS DE LAS COLUMNAS //
		$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
		$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
		$K = PHPExcel_Cell::stringFromColumnIndex($col_K);

		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("Pago 90 días (1.5%): ");
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');

		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');

		  // declaramos la formula
		$form = '('. $J . $subUbi . '*0.015)';

		$objPHPExcel->getActiveSheet()->setCellValue($J . $G, '=' . $form);

		// AUMENTO COLUMNAS //
		$col_I = $col_I + 3;
		$col_J = $col_J + 3;
		$col_K = $col_K + 3;

	}//FIN FOR


	/***************************ACUMULADO **************************************/
	// LETRAS DE LAS COLUMNAS //
  	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);

	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("Pago 90 días (1.5%): ");
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');

	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');

	  // declaramos la formula
	$form = '('. $J . $subUbi . '*0.015)';

	$objPHPExcel->getActiveSheet()->setCellValue($J . $G, '=' . $form);

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
	$form = '(G' . $subUbi . '+G' . $dias . ')';

	$objPHPExcel->getActiveSheet()->setCellValue('G' . $G, '=' . $form);

	$subDias = $G;


	/***************************************** ACTA *********************************************/

	/*
	COLUMNAS
	*/
	$col_I = 8;
	$col_J = 9;
	$col_K = 10;
	
	
	// CONSULTA //
	$sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
	$resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
	$row_actas = $obj_bd->FuncionFetch($resultado_actas);
	$stop = $row_actas['factura_actanum'];
	

	for ($i=0; $i < $stop ; $i++) {
		
		// LETRAS DE LAS COLUMNAS //
		$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
		$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
		$K = PHPExcel_Cell::stringFromColumnIndex($col_K);


		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("Subtotal + Pago a 90 días: ");
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');

		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');

		  // declaramos la formula
		$form = '('. $J . $subUbi . '+' . $J . $dias . ')';

		$objPHPExcel->getActiveSheet()->setCellValue($J . $G, '=' . $form);

		  //PORCENTAJE
		$objPHPExcel->getActiveSheet()->getStyle($K . $F)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($K . $F)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($K . $F)->getFont()->getColor()->setARGB('123D05');
		$objPHPExcel->getActiveSheet()->getStyle($K . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue($K . $F, '=('. $J . $F . ' /G' . $F . ')');
		$objPHPExcel->getActiveSheet()
		->getStyle($K . $F)
		->getNumberFormat()
		->applyFromArray([
			"code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE
		]);

		// AUMENTO COLUMNAS //
		$col_I = $col_I + 3;
		$col_J = $col_J + 3;
		$col_K = $col_K + 3;

	}//FIN FOR


	/***************************ACUMULADO **************************************/
	// LETRAS DE LAS COLUMNAS //
  	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);

	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("Subtotal + Pago a 90 días: ");
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');

	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');

	  // declaramos la formula
	$form = '('. $J . $subUbi . '+' . $J . $dias . ')';

	$objPHPExcel->getActiveSheet()->setCellValue($J . $G, '=' . $form);

	  //PORCENTAJE
	$objPHPExcel->getActiveSheet()->getStyle($K . $F)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($K . $F)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($K . $F)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($K . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->setCellValue($K . $F, '=('. $J . $F . ' /G' . $F . ')');
	$objPHPExcel->getActiveSheet()
	->getStyle($K . $F)
	->getNumberFormat()
	->applyFromArray([
		"code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE
	]);


	//////////////////////////////////////////// IVA ////////////////////////////////////////////

	$G = $G + 1;
	$F = $F + 1;

	/*********************************** PRESUPUESTO *******************************************/
	$objPHPExcel->getActiveSheet()->getStyle('F' . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell('F' . $F)->setValue("IVA " . $porcentaje . "%:");
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
	$form = '(G' . $subDias . '*' . $porcentaje . ')/100';
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $G, '=' . $form);

	$ivaPorc = $G;


	/***************************************** ACTA *********************************************/
	/*
	COLUMNAS
	*/
	$col_I = 8;
	$col_J = 9;
	$col_K = 10;
	
	
	// CONSULTA //
	$sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
	$resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
	$row_actas = $obj_bd->FuncionFetch($resultado_actas);
	$stop = $row_actas['factura_actanum'];
	

	for ($i=0; $i < $stop ; $i++) {
		
		// LETRAS DE LAS COLUMNAS //
		$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
		$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
		$K = PHPExcel_Cell::stringFromColumnIndex($col_K);


		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("IVA " . $porcentaje . "%:");
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');

		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');

		  // declaramos la formula
		$form = '('. $J . $subDias . '*' . $porcentaje . ')/100';
		$objPHPExcel->getActiveSheet()->setCellValue($J . $G, '=' . $form);


		// AUMENTO COLUMNAS //
		$col_I = $col_I + 3;
		$col_J = $col_J + 3;
		$col_K = $col_K + 3;

	}//FIN FOR


	/***************************ACUMULADO **************************************/
	// LETRAS DE LAS COLUMNAS //
  	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);

	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("IVA  " . $porcentaje . "%:");
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');

	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');

	  // declaramos la formula
	$form = '('. $J . $subDias . '*' . $porcentaje . ')/100';
	$objPHPExcel->getActiveSheet()->setCellValue($J . $G, '=' . $form);


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
	$form = '(G' . $subDias . '+G' . $ivaPorc . ')';
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $G, '=' . $form);

	$lim = $G;


	/***************************************** ACTA *********************************************/
	/*
	COLUMNAS
	*/
	$col_I = 8;
	$col_J = 9;
	$col_K = 10;
	
	
	// CONSULTA //
	$sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
	$resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
	$row_actas = $obj_bd->FuncionFetch($resultado_actas);
	$stop = $row_actas['factura_actanum'];
	

	for ($i=0; $i < $stop ; $i++) {
		
		// LETRAS DE LAS COLUMNAS //
		$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
		$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
		$K = PHPExcel_Cell::stringFromColumnIndex($col_K);


		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("Total: ");
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');

		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');

		  // declaramos la formula
		$form = '('. $J . $subDias . '+'. $J . $ivaPorc . ')';
		$objPHPExcel->getActiveSheet()->setCellValue($J . $G, '=' . $form);

		// AUMENTO COLUMNAS //
		$col_I = $col_I + 3;
		$col_J = $col_J + 3;
		$col_K = $col_K + 3;

	}//FIN FOR


	/***************************ACUMULADO **************************************/
	// LETRAS DE LAS COLUMNAS //
  	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);

	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($I . $F)->setValue("Total: ");
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($I . $F)->getFont()->getColor()->setARGB('123D05');

	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');

	  // declaramos la formula
	$form = 'ROUND(('. $J . $subDias . '+'. $J . $ivaPorc . '),0)';
	$objPHPExcel->getActiveSheet()->setCellValue($J . $G, '=' . $form);


	  //////////////////////////////////////////////////////////////////////////////////////////////
	  //                          BORDES CUADRO TOTAL PRESUPUESTO                                 //
	  //////////////////////////////////////////////////////////////////////////////////////////////

	/*********************************** PRESUPUESTO *******************************************/
	$objPHPExcel->getActiveSheet()
	->getStyle('F' . $ini . ':G' . $lim)
	->getBorders()
	->getAllBorders()
	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	/***************************************** ACTA *********************************************/
	/*
	COLUMNAS
	*/
	$col_I = 8;
	$col_J = 9;
	$col_K = 10;
	
	
	// CONSULTA //
	$sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
	$resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
	$row_actas = $obj_bd->FuncionFetch($resultado_actas);
	$stop = $row_actas['factura_actanum'];
	

	for ($i=0; $i < $stop ; $i++) {
		
	// LETRAS DE LAS COLUMNAS //
	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);


	$objPHPExcel->getActiveSheet()
	->getStyle($I . $ini . ':'. $J . $lim)
	->getBorders()
	->getAllBorders()
	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	// AUMENTO COLUMNAS //
		$col_I = $col_I + 3;
		$col_J = $col_J + 3;
		$col_K = $col_K + 3;

	}//FIN FOR


	/***************************ACUMULADO **************************************/
	// LETRAS DE LAS COLUMNAS //
  	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
   	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
   	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);


	$objPHPExcel->getActiveSheet()
	->getStyle($I . $ini . ':'. $J . $lim)
	->getBorders()
	->getAllBorders()
	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


	///////////////////////////////////////////////////////////////////////////
	///                         BORDES TABLA PRINCIPAL                      ///
	///////////////////////////////////////////////////////////////////////////

	$H = $H - 1;

	$objPHPExcel->getActiveSheet()
	->getStyle('A8:H' . $H)
	->getBorders()
	->getAllBorders()
	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	  //CENTRAR TODAS LAS CELDAS VERTICALMENTE
	$objPHPExcel->getActiveSheet()->getStyle('A8:N' . $H)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


	///////////////////////////////////////////////////////////////////////////
	///                             TABLA DE ACTAS                          ///
	///////////////////////////////////////////////////////////////////////////

		
	// LETRAS DE LAS COLUMNAS //
	$I = PHPExcel_Cell::stringFromColumnIndex($col_I);
	$J = PHPExcel_Cell::stringFromColumnIndex($col_J);
	$K = PHPExcel_Cell::stringFromColumnIndex($col_K);

	$G = $H + 12;
	$border_ini = $G;

	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($I . $G)->setValue("ACTAS");
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->getColor()->setARGB('d60823');

	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($J . $G)->setValue("VALOR SIN IVA");
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('d60823');

	$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($K . $G)->setValue("%");
	$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getFont()->getColor()->setARGB('d60823');

	$acIni = $G + 1;

	// CONSULTA //
	$sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
	$resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
	$row_actas = $obj_bd->FuncionFetch($resultado_actas);
	$stop = $row_actas['factura_actanum'];
	
	$acta = 0;

	for ($i=0; $i < $stop ; $i++) {

		$G = $G + 1;
		$acta = $acta + 1;

		$sql_sum_actas = "CALL SP_factura('21','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','".$acta."')";
		$resultado_sum_actas = $obj_bd->EjecutaConsulta($sql_sum_actas);
		$row_sum_actas = $obj_bd->FuncionFetch($resultado_sum_actas);


		$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->getColor()->setARGB('123D05');
		$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getCell($I . $G)->setValue($acta);

		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');
               
		$objPHPExcel->getActiveSheet()->getCell($J . $G)->setValue($row_sum_actas['sum_acta']);

		$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getFont()->setName('Calibri');
		$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getFont()->getColor()->setARGB('123D05');
		$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue($K . $G, '=('. $J . $G . ' /G' . $subDias . ')');
		$objPHPExcel->getActiveSheet()
		->getStyle($K . $G)
		->getNumberFormat()
		->applyFromArray([
			"code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE
		]);
	}//FIN FOR

    //totales
	$G = $G + 1;
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($I . $G)->setValue("TOTAL");
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->getColor()->setARGB('123D05');

	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getNumberFormat()->setFormatCode('$#,##0');

	$G_fin = $G - 1;

    // declaramos la formula
	$form = 'ROUND(SUM('. $J . $acIni . ':'. $J . $G_fin . '),0)';
	$objPHPExcel->getActiveSheet()->setCellValue($J . $G, '=(' . $form . ')');
	

	$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($K . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    // $objPHPExcel->getActiveSheet()->getCell('L' . $G)->setValue($sum_porcentaje . "%");
	$objPHPExcel->getActiveSheet()->setCellValue($K . $G, '=('. $J . $G . ' /G' . $subDias . ')');
	$objPHPExcel->getActiveSheet()
	->getStyle($K . $G)
	->getNumberFormat()
	->applyFromArray([
		"code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE
	]);
	
	
  	//OTROS DATOS

	//VALIDAR SI TIENE ACTAS
	$pep = utf8_encode($row['ordentrabajo_pep']);
	$orden = utf8_encode($row['ordentrabajo_num']);
	$codigo_gom = utf8_encode($row['ordentrabajo_gom']);

	$G = $G + 1;

	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($I . $G)->setValue("CÓDIGO GOM");
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->getColor()->setARGB('123D05');

	$objPHPExcel->getActiveSheet()->mergeCells($J . $G . ':'. $K . $G);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($J . $G)->setValue($codigo_gom);

	$gom = $G;

	//PEP
	$G = $G + 1;
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($I . $G)->setValue("PEP");
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->getColor()->setARGB('123D05');

	$objPHPExcel->getActiveSheet()->mergeCells($J . $G . ':'. $K . $G);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($J . $G)->setValue($pep);

	$pep = $G;

	//ORDEN
	$G = $G + 1;
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($I . $G)->setValue("ORDEN");
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($I . $G)->getFont()->getColor()->setARGB('123D05');

	$objPHPExcel->getActiveSheet()->mergeCells($J . $G . ':'. $K . $G);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setName('Calibri');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->setSize(11);
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getFont()->getColor()->setARGB('123D05');
	$objPHPExcel->getActiveSheet()->getStyle($J . $G)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getCell($J . $G)->setValue($orden);

	$orden = $G;
	
	///////////////////////////////////////////////////////////////////////////
	///                             BORDES TABLA ACTAS                      ///
	///////////////////////////////////////////////////////////////////////////

	$objPHPExcel->getActiveSheet()
	->getStyle($I . $border_ini . ':'. $K . $G)
	->getBorders()
	->getAllBorders()
	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	

	///////////////////////////// NOMBRE DE LA HOJA ///////////////////////////
	$titulo = $row['ordentrabajo_num'];
	$objPHPExcel->getActiveSheet()->setTitle($titulo);


	                          ///////////////////////////
	                          // CREAMOS HOJA DE ACTAS //
	                          ///////////////////////////

	$objPHPExcel->createSheet(2);
	$objPHPExcel->setActiveSheetIndex(2);
	$objPHPExcel->getActiveSheet()->setTitle("ACTA " . $titulo);

	// $G = 2;
	// $sql_conteo = "	SELECT ac.actividad_GOM as gom
	// 				from cf_actividad ac
	// 				where ac.contrato_id = 7;";
	// $resultado_conteo = $obj_bd->EjecutaConsulta($sql_conteo);
	// $num_sub = $obj_bd->Filas($sql_conteo);

	// if ($num_sub > 0) {
 	//   		while ($conteo = $obj_bd->FuncionFetch($resultado_conteo)) {
    		
 	//    		$gom = $conteo['gom'];
	// 		$objPHPExcel->getActiveSheet(2)->getCell('A' . $G)->setValue($gom);

	// 		$sql_cant = "CALL SP_factura('22','','','','','','','','','','','','','','','','','','','','" . trim($gom) . "','')";

	// 	    $resultado_cant = $obj_bd->EjecutaConsulta($sql_cant);
	// 	    $canti = $obj_bd->FuncionFetch($resultado_cant);

	// 	    $canti = $canti['conteo'];

	// 	    $objPHPExcel->getActiveSheet(2)->getCell('B' . $G)->setValue($canti);
			
	// 		$G = $G + 1;
 	//    	}

	// }
	

	// // RESUMEN ASIGNACION POR PERSONA //
	// $sql_usu = "SELECT usuario_id,
	// 			usuario_apellidos, 
	// 			usuario_nombre, 
	// 			usuario_cargo
	// 			FROM dt_usuario;";

	// $resultado_usu = $obj_bd->EjecutaConsulta($sql_usu);

	// $F = 1;

	// $objPHPExcel->getActiveSheet(2)->getCell('A' . $F)->setValue("ID");
	// $objPHPExcel->getActiveSheet(2)->getCell('B' . $F)->setValue("APELLIDO");
	// $objPHPExcel->getActiveSheet(2)->getCell('C' . $F)->setValue("NOMBRE");
	// $objPHPExcel->getActiveSheet(2)->getCell('D' . $F)->setValue("CARGO");
	// $objPHPExcel->getActiveSheet(2)->getCell('E' . $F)->setValue("TOTAL ASIGNADO");

	// $G = 2;

	// while ($usu = $obj_bd->FuncionFetch($resultado_usu)) {

	// 	$id = $usu['usuario_id'];
	// 	$ape = utf8_encode($usu['usuario_apellidos']);
	// 	$nom = utf8_encode($usu['usuario_nombre']);
	// 	$car = utf8_encode($usu['usuario_cargo']);

	// 	$objPHPExcel->getActiveSheet(2)->getCell('A' . $G)->setValue($id);
	// 	$objPHPExcel->getActiveSheet(2)->getCell('B' . $G)->setValue($ape);
	// 	$objPHPExcel->getActiveSheet(2)->getCell('C' . $G)->setValue($nom);
	// 	$objPHPExcel->getActiveSheet(2)->getCell('D' . $G)->setValue($car);

	// 	$sql_tot = "CALL SP_factura('24','','','','','','','','','','','','','','','','','','','','','".$usu['usuario_id']."')";

	// 	$resultado_tot = $obj_bd->EjecutaConsulta($sql_tot);

	// 	$tot = $obj_bd->FuncionFetch($resultado_tot);

	// 	$asig = $tot['totalasig'];

	// 	$objPHPExcel->getActiveSheet(2)->getCell('E' . $G)->setValue($asig);

	// 	$G = $G + 1;

	// }
		

	// Establecer el índice de la hoja activa, Hoja que Excel abre como la primera hoja
    $objPHPExcel->setActiveSheetIndex(0);

}//FIN WHILE



///////////////////////////////////////////////////////////////////////////////
///                                 RESUMEN                                 ///
///////////////////////////////////////////////////////////////////////////////


//ANCHO DE LAS COLUMNAS
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(21);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(25);


//ANCHO DE FILAS
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(10);

//FORMATO
$objPHPExcel->getActiveSheet()->getStyle('B2:V2')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('B2:V2')->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('B2:V2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2:V2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('B2:V2')->getFont()->getColor()->setARGB('123D05');
$objPHPExcel->getActiveSheet()->getStyle('B2:V2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2:V2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2:V2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('B2:V2')->getFill()->getStartColor()->setARGB('FFFF00');
$objPHPExcel->getActiveSheet()
->getStyle('B2:V2')
->getBorders()
->getAllBorders()
->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()->getStyle('K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('K2')->getFill()->getStartColor()->setARGB('D8E4BC');

$objPHPExcel->getActiveSheet()->getStyle('N2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('N2')->getFill()->getStartColor()->setARGB('C0504D');

$objPHPExcel->getActiveSheet()->getStyle('R2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('R2')->getFill()->getStartColor()->setARGB('9BBB59');


$objPHPExcel->setActiveSheetIndex(0)

->setCellValue('B2', 'PEP')
->setCellValue('C2', 'ORDEN PRESUPUESTAL')
->setCellValue('D2', 'SUBESTACIÓN')
->setCellValue('E2', 'ORDEN')
->setCellValue('F2', 'CÓDIGO GOM')
->setCellValue('G2', 'PROYECTO')
->setCellValue('H2', 'Valor SubTotal OT (antes de IVA)')
->setCellValue('I2', 'Ubicación 3 %')
->setCellValue('J2', 'Pago a 90 dias (1.5%)')
->setCellValue('K2', 'Valor Subtotal a facturar (antes de IVA) + incremento + pago a 90 dias (1.5%)')
->setCellValue('L2', 'IVA (' . $porcentaje . '%)')
->setCellValue('M2', 'Valor TOTAL OT (IVA INCLUIDO)')
->setCellValue('N2', 'Valor Subtotal a facturar (antes de IVA)')
->setCellValue('O2', '% a Facturar')
->setCellValue('P2', 'Ubicación 3 %')
->setCellValue('Q2', 'Pago a 90 dias (1.5%)')
->setCellValue('R2', 'Valor Subtotal a facturar (antes de IVA) + incremento + pago a 90 dias (1.5%)')
->setCellValue('S2', 'IVA (' . $porcentaje . '%)')
->setCellValue('T2', 'TOTAL A FACTURAR (IVA INCLUIDO)')
->setCellValue('U2', 'ACTA N° ')
->setCellValue('V2', 'OBSERVACIONES');

$titulo1 = "RESUMEN";
/**/
// Nombre de la hoja
$objPHPExcel->getActiveSheet()->setTitle($titulo1);

// Establecer el índice de la hoja activa, Hoja que Excel abre como la primera hoja
$objPHPExcel->setActiveSheetIndex(0);

$sql_resumen = "CALL SP_factura('1','','','','','','','','" . $fechaFacturaMes . "','" . $fechaFacturaFin . "','','','','','','','','','','','','')";

$resultado_resumen = $obj_bd->EjecutaConsulta($sql_resumen);

$fl = 3;
$s = 1;

while ($resumen = $obj_bd->FuncionFetch($resultado_resumen)) {

	$objPHPExcel->getActiveSheet()->getStyle('A' . $fl . ':V' . $fl)->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $fl . ':V' . $fl)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $fl . ':V' . $fl)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()
	->getStyle('B' . $fl . ':V' . $fl)
	->getBorders()
	->getAllBorders()
	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


	$pep = utf8_encode($resumen['ordentrabajo_pep']);
	$orden = utf8_encode($resumen['ordentrabajo_num']);
	$codigo_gom = utf8_encode($resumen['ordentrabajo_gom']);
	$presupuestal = utf8_encode($resumen['ordentrabajo_ordenpresupuestal']);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $fl, $s);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $fl, $pep);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $fl, $presupuestal);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $fl, utf8_encode($resumen['subestacion_nombre']));

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $fl, $orden);


	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $fl, $codigo_gom);


	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $fl, utf8_encode($resumen['ordentrabajo_obs']));


	/*Traemos el valor total del presupuesto desde la base de datos*/
	$sqlSub="SELECT sum(pt.presupuesto_valorporcentaje) as total
	FROM pt_presupuesto pt
	JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
	JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
	JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
	AND pt.presupuesto_estado=1
	AND pt.detallepresupuesto_id=" . $resumen['detallepresupuesto_id'] . ";";

	$resSub = $obj_bd->EjecutaConsulta($sqlSub);
	$rowSub = $obj_bd->FuncionFetch($resSub);
	$sub_pres = $rowSub['total'];

	/*asignamos el valor recibido de la base de datos a la celda*/
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $fl, $sub_pres);
	$objPHPExcel->getActiveSheet()->getStyle('H' . $fl)->getNumberFormat()->setFormatCode('$#,##0');
	/*Cierre*/



	/*Traemos de la base de datos el valor del % por ubicacion*/    
	$sqlUbi = " SELECT sum(pt.presupuesto_valorporcentaje)*0.03 as porcentaje
	FROM pt_presupuesto pt
	JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
	JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
	AND sb.subactividad_id=1
	AND pt.presupuesto_estado=1
	WHERE pt.detallepresupuesto_id=" . $resumen['detallepresupuesto_id'] . ";";

	$resUbi = $obj_bd->EjecutaConsulta($sqlUbi);
	$rowUbi = $obj_bd->FuncionFetch($resUbi);
	$ubicacion = $rowUbi['porcentaje'];
	/*asignamos el valor recibido de la base de datos a la celda*/
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $fl, $ubicacion);
	$objPHPExcel->getActiveSheet()->getStyle('I' . $fl)->getNumberFormat()->setFormatCode('$#,##0');
	/*Cierre*/


	$formula = 0;
	$formula='SUM(H'.$fl.':I'.$fl.')*0.015';
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $fl, '='.$formula);
	$objPHPExcel->getActiveSheet()->getStyle('J' . $fl)->getNumberFormat()->setFormatCode('$#,##0');


	$formula = 0;
	$formula='SUM(H'.$fl.':J'.$fl.')';
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $fl, '='.$formula);
	$objPHPExcel->getActiveSheet()->getStyle('K' . $fl)->getNumberFormat()->setFormatCode('$#,##0');


	$formula = 0;
	$formula='(K'.$fl.')*'.$porcentaje.'/100';
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $fl, '='.$formula);
	$objPHPExcel->getActiveSheet()->getStyle('L' . $fl)->getNumberFormat()->setFormatCode('$#,##0');


	$formula = 0;
	$formula='K'.$fl.'+L'.$fl;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $fl, '='.$formula);
	$objPHPExcel->getActiveSheet()->getStyle('M' . $fl)->getNumberFormat()->setFormatCode('$#,##0');

	/*CONSULTA PARA EL NUMERO DE ACTAS*/
	$sql_acta = "CALL SP_factura('4','','','','','','','','','','','','','','','','','','','','" . trim($resumen['ordentrabajo_id']) . "','')";

	$resultado_acta = $obj_bd->EjecutaConsulta($sql_acta);
	$num_acta = $obj_bd->FuncionFetch($resultado_acta);
	$new_acta = $num_acta['acta'];


	$objPHPExcel->setActiveSheetIndex(0);

	/*PROCESO PARA CALCULAR EL SUBTOTAL DE LAS ACTAS*/
	$sqlSub_actas = "CALL SP_factura('20','','','','','','','','" . $fechaFacturaMes . "','" . $fechaFacturaFin . "','','','','','','','','','','" . $resumen['detallepresupuesto_id'] . "','','')";

	$resSub_actas = $obj_bd->EjecutaConsulta($sqlSub_actas);
	$rowSub_actas = $obj_bd->FuncionFetch($resSub_actas);
	$sub_actas = $rowSub_actas['total_porc'];

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $fl, $sub_actas);
	$objPHPExcel->getActiveSheet()->getStyle('N' . $fl)->getNumberFormat()->setFormatCode('$#,##0');
	/*CIERRE*/


	/*Traemos el valor por ubicacion del acta*/
	/*Abre*/
	$sqlUbi_actas = "CALL SP_factura('18','','','','','','','','" . $fechaFacturaMes . "','" . $fechaFacturaFin . "','','','','','','','','','','" . $resumen['detallepresupuesto_id'] . "','','')";

	$resUbi_actas = $obj_bd->EjecutaConsulta($sqlUbi_actas);
	$rowUbi_actas = $obj_bd->FuncionFetch($resUbi_actas);
	$ubicacion_actas = $rowUbi_actas['ubicacion'];

	if ($ubicacion_actas == '') {
		$ubicacion_actas = 0;
	}

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $fl, $ubicacion_actas);
	$objPHPExcel->getActiveSheet()->getStyle('P' . $fl)->getNumberFormat()->setFormatCode('$#,##0');
	/*Cierra*/


	$formula = 0;
	$formula='R'.$fl.'/K'.$fl;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $fl, '='.$formula);
	$objPHPExcel->getActiveSheet()
	->getStyle('O' . $fl)
	->getNumberFormat()
	->applyFromArray([
		"code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE
	]);


	$formula = 0;
	$formula='(N'.$fl.'+P'.$fl.')*0.015';
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $fl, '='.$formula);  
	$objPHPExcel->getActiveSheet()->getStyle('Q' . $fl)->getNumberFormat()->setFormatCode('$#,##0');

	$formula = 0;
	$formula='SUM(N'.$fl.'+P'.$fl.'+Q'.$fl.')';
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . $fl, '='.$formula);
	$objPHPExcel->getActiveSheet()->getStyle('R' . $fl)->getNumberFormat()->setFormatCode('$#,##0');

	$formula = 0;
	$formula='(R'.$fl.')*'.$porcentaje.'/100';
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S' . $fl, '='.$formula);
	$objPHPExcel->getActiveSheet()->getStyle('S' . $fl)->getNumberFormat()->setFormatCode('$#,##0');

	$formula = 0;
	$formula='R'.$fl.'+S'.$fl;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T' . $fl, '='.$formula);
	$objPHPExcel->getActiveSheet()->getStyle('T' . $fl)->getNumberFormat()->setFormatCode('$#,##0');

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U' . $fl, $new_acta);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V' . $fl, utf8_encode($resumen['gestor']));


	$fl = $fl + 1;
	$s = $s + 1;

}

/* FIN RESUMEN */


//    $objPHPExcel->getSheetByName('Worksheet 1')
//    ->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
//$objPHPExcel->getSheetByName('RESUMEN')
//    ->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);
// Redirect output to a client’s web browser (Excel2007)

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Consolidado ' . $mesFactura . ' ' . $yearFactura . '.xlsx"');
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
