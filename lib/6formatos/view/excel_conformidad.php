<?php
 
///////////////////////
// Include PHPExcel  //
///////////////////////
require_once '../../../components/phpexcel/Classes/PHPExcel.php';
require_once '../../0connection/BD_config.php';
require_once '../../0connection/connection.php';
require_once '../../0connection/BD.php';



///////////////////////////
// PROPIEDADES DEL EXCEL //
///////////////////////////
session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');
date_default_timezone_set('America/Bogota');
define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');


/////////////
// OBJETOS //
/////////////
$obj_bd = new BD();
$objPHPExcel = new PHPExcel();


///////////////////////////////
// PROPIEDADES DEL DOCUMENTO //
///////////////////////////////
$objPHPExcel->getProperties()
->setCreator("Casai")
->setLastModifiedBy("Casai")
->setTitle("Conformidad")
->setSubject("_")
->setDescription("_")
->setKeywords("office 2007 openxml php")
->setCategory("excel");

 
///////////////
// VARIABLES //
///////////////
$num = $_GET['er'];


                                        ///////////////////////////
                                        // CABECERA DEL REPORTE  //
                                        ///////////////////////////
//////////////////////////
//ANCHO DE LAS COLUMNAS //
//////////////////////////
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

////////////////////
// ESTILOS CELDAS //
////////////////////
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->getColor()->setARGB('123D05');

$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()
->getStyle('A1:I1')
->getBorders()
->getAllBorders()
->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->getStartColor()->setARGB('1F497D');
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

/////////////////////////////
// TITULOS CABEZCERA TABLA //
/////////////////////////////
$objPHPExcel->setActiveSheetIndex()
->setCellValue('A1','OT')
->setCellValue('B1', 'SUBESTACION')
->setCellValue('C1', 'MUNICIPIO')
->setCellValue('D1', 'GESTOR')
->setCellValue('E1', 'FECHA CONFORMIDAD')
->setCellValue('F1', 'VALOR')
->setCellValue('G1', 'NO. FACTURA')
->setCellValue('H1', 'FECHA RADICADO')
->setCellValue('I1', 'NO. RADICADO');

                                        ////////////////////////
                                        // CUERPO DEL REPORTE //
                                        ////////////////////////
//////////////
// CONSULTA //
//////////////
$query_conformidad = "CALL SP_conformidad ('1','','','','','".$num."','','','','','','')";
$res_conformidad = $obj_bd->EjecutaConsulta($query_conformidad);
$filas = $obj_bd->Filas($query_conformidad);

$F = 2;

while ($row_conf = $obj_bd->FuncionFetch($res_conformidad))
{
	$objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $F, $row_conf['ordentrabajo_num']);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $F, $row_conf['subestacion_nombre']);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $F, $row_conf['subestacion_ubicacion']);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('D' . $F, utf8_encode($row_conf['nombre_gestor']));
	$objPHPExcel->setActiveSheetIndex()->setCellValue('E' . $F, $row_conf['conformidad_fechaconformidad']);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('F' . $F, $row_conf['conformidad_valor']);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $F, $row_conf['conformidad_factura']);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $F, $row_conf['conformidad_fecharadicado']);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('I' . $F, $row_conf['conformidad_radicado']);

	$objPHPExcel->getActiveSheet()
	->getStyle('A' . $F . ':I' . $F)
	->getBorders()
	->getAllBorders()
	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	
	$F = $F + 1;
}	



										///////////////////
										// GUARDAR EXCEL //
										///////////////////
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Conformidad # ' . $num . '.xlsx"');
header('Cache-Control: max-age=0');
header("Pragma: no-cache");
header("Expires: 0");

$objWriter->save('php://output');

exit;
?>