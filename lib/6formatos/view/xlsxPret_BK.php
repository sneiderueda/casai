<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

/** Include PHPExcel */
require_once 'phpexcel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

//*******************************************************************

/*
 * 1. encabezado
SELECT DP.detallepresupuesto_id,
CT.contrato_numero,
SB.subestacion_nombre,
DP.detallepresupuesto_objeto,
DP.detallepresupuesto_alcance
FROM dt_detalle_presupuesto DP
JOIN dt_contrato CT ON DP.contrato_id=CT.contrato_id
JOIN dt_subestacion SB ON DP.subestacion_id=SB.subestacion_id
AND DP.detallepresupuesto_estado=3;
  
 
 * 2 detalle del presupuesto
SELECT PT.presupuesto_id,
BA.baremoactividad_id,
	   MD.modulo_descripcion,
       concat(BM.baremo_item, ' ', LB.labor_descripcion) AS labor,
		ac.actividad_id,
		ac.actividad_descripcion,
		ac.actividad_GOM,
		PT.detalleactividad_id,
		-- sb.subactividad_descripcion,
		PT.presupuesto_porcentaje,
		PT.presupuesto_valorporcentaje
FROM pt_presupuesto PT
JOIN cf_modulo MD ON PT.modulo_id=MD.modulo_id
JOIN pt_baremo_actividad BA ON BA.baremoactividad_id=PT.baremoactividad_id
JOIN pt_baremo BM ON PT.baremo_id=BM.baremo_id
JOIN cf_labor LB ON BM.labor_id=LB.labor_id 
JOIN cf_actividad ac ON ac.actividad_id=BA.actividad_id
-- JOIN pt_detalle_actividad da ON PT.detalleactividad_id=da.detalleactividad_id OR PT.detalleactividad_id=0
-- JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id		   
WHERE PT.detallepresupuesto_id=1
AND PT.presupuesto_estado=1;


 * 3. validar si tiene subactividades
* 		 SELECT pt.presupuesto_id,
                               pt.baremoactividad_id,
               pt.detalleactividad_id,								
                               sb.subactividad_descripcion,
               pt.presupuesto_porcentaje,
               pt.presupuesto_valorporcentaje				
          FROM pt_presupuesto pt
                  JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
                  JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
                  JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id		   
                   AND da.detalleactividad_estado=1
                   AND pt.baremoactividad_id=_baremoactividad_id
                       AND pt.detallepresupuesto_id=1
                       AND pt.modulo_id=_modulo_id
                       AND pt.presupuesto_estado=1;
 *  
*/
// Seteo del Encabezado y pie de pagina
//pie de pagina mfvargas
//agregado por mfvargas

/*
$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
$objDrawing->setName('logo');
$objDrawing->setPath('../logo.png');
$objDrawing->setWidth(400);
$objDrawing->setHeight(95);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&H AQUI COLOCA LO QUE QUIERAS Q SE VEA EN EL ENCAENCABEZADO' . '&RDia &D Hora &T');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&C&H AQUI COLOCAS LO Q QUIERAS Q SE VEA EN EL PIE DE PAGINA'  . '&RPag &P de &N');
*/


/*
$logo = new PHPExcel_Worksheet_HeaderFooterDrawing();
$logo->setName('Logo');
$logo->setPath(DOCUMENT_ROOT . '/public/logo.jpg'); //Path is OK & tested under PHP
$logo->setHeight(38); //If image is larger/smaller than that, image will be proportionally resized
$sheet->getHeaderFooter()->addImage($logo, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
*/


//$objPHPExcel->getActiveSheet() ->getHeaderFooter()->setOddFooter('&R Página &P de &N');
//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . 'Abajo izquierda' . '&RAbajo derecha');


//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L Izquierda');


//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&B' . 'Logo.png' . '&CORDEN DE TRABAJO'. '&RPagina &P de &N');



$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
$objDrawing->setName('PHPExcel_logo');
$objDrawing->setPath('./logo1.jpg');
$objDrawing->setHeight(36);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_RIGHT);



//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L Izquierda');
	
/*$objPHPExcel->getActiveSheet()
    ->getHeaderFooter()->setEvenFooter('&R&F Pagina &P de &N');*/
//agregado por mfvargas
//*******************************************************************


// Ajustar propiedades del documento
$objPHPExcel->getProperties()->setCreator("Casai")
							 ->setLastModifiedBy("Casai")
							 ->setTitle("Presupuesto")
							 ->setSubject("_")
							 ->setDescription("_")
							 ->setKeywords("presupuesto")
							 ->setCategory("excel");

//  <!--****************************** inicia el contenido*******************-->  
include("conectar.php");
$n=$_SESSION['cliente'];
$pid=$_SESSION['pid'];
$totaliz=0;
/*$n=2;
$pid=81;*/
//-------------------informacion base sobre la ot--------------------
 $query = "SELECT tituloot, `not`, descripcionproyecto, DATE_FORMAT( fechafin,  '%d-%m-%Y' ) AS fechafin, NOMBRESUBESTACION, DATE_FORMAT( fechacreacion, '%Y' ) AS fechacreacion, DATE_FORMAT( fechaemision,  '%d-%m-%Y' ) AS fechaemision, NOMBRESUBESTACION, DATE_FORMAT( fechainicio,  '%d-%m-%Y' ) AS fechainicio, DATE_FORMAT( fechacreacion,  '%Y' ) AS fecha, acta FROM c".$n."indice, c".$n."subestaciones WHERE pid =".$pid." AND c".$n."subestaciones.ID = c".$n."indice.subestacion";
$respuesta = mysql_query($query);
$t = mysql_fetch_assoc($respuesta);
$totalRows_Recordset = mysql_num_rows($respuesta);
$t['acta']--;
//------consultamos el ipc por cliente
 $consultax="SELECT ipc FROM costos WHERE ano=".$t['fechacreacion']." AND idcliente=".$n."";
$costo=mysql_query($consultax);
$valorcosto=mysql_fetch_assoc($costo);
$k=$valorcosto['ipc'];/**/
//------mostrar detalle modulos 
$leli='<table border="1" cellspacing="0" cellpadding="0">
<th>Módulo</th>
<th>Subactividad</th>
<th>Total</th>
';
///////////////////////////////////////////////////////////////////////////////////////////////////
$bnm=0;
//-------selecciona los modulos
 $query_Recordset11 = "SELECT c".$n."nmodulos.dnmodulo as modulo, c".$n."indexots".$pid.".id, c".$n."indexots".$pid.".tipo, c".$n."indexots".$pid.".labor, c".$n."indexots".$pid.".observaciones FROM c".$n."nmodulos, c".$n."indexots".$pid." WHERE c".$n."nmodulos.id=c".$n."indexots".$pid.".idmodulo ORDER BY c".$n."nmodulos.dnmodulo, c".$n."indexots".$pid.".labor ASC";
// $query_Recordset;
$Recordset11 = mysql_query($query_Recordset11);
$q1 = mysql_fetch_assoc($Recordset11);
$totalRows_Recordsetq = mysql_num_rows($Recordset11);

$tparcial[$bnm][1]=0;
$fwd=0;//suma de todos los modulos
$totalmodulo=0;//suma de todas las labores
$validador=$q1['modulo'];
$asdfg=0;
$x=0;
do
{
	if($Recordset11!=NULL)
	{
		if($validador!=$q1['modulo'])
		{
			$tmodulo[$bnm]=$totalmodulo;
			$validador=$q1['modulo'];
			$totalmodulo=0;
			$bnm++;
			$tparcial[$bnm][1]=0;
		}
	
		//consulta ots para mostrar las cantidades
		 $query_Recordset12 = "SELECT cantidad, estadolabor, acta FROM c".$n."ots".$pid." WHERE id=".$q1['id']."";
		$Recordset12 = mysql_query($query_Recordset12);
		$r1 = mysql_fetch_assoc($Recordset12);
		$totalRows_Recordset = mysql_num_rows($Recordset12);

		// consulta subactividades
		$query_Recordset24 = "SELECT actividades.actividades, subactividades.subactividades, c".$n.$q1['tipo']."general.vr2008 FROM c".$n.$q1['tipo'].	"general, actividades, subactividades WHERE c".$n.$q1['tipo']."general.actividades=actividades.identificacion AND c".$n.$q1['tipo']."general.subactividades=subactividades.identificacion AND c".$n.$q1['tipo']."general.".$q1['tipo']."labores=$q1[labor]";
		$Recordset24 = mysql_query($query_Recordset24);
		//$row_Recordset2 = mysql_fetch_assoc($Recordset2);
		$totalRows_Recordset24 = mysql_num_rows($Recordset24);	
		//calcula el total de las subactividades en una labor
		$y=0;
		
		while ($row_Recordset24 = mysql_fetch_assoc($Recordset24))
		{
			if($row_Recordset24!=NULL)
			{
				
				for($x=1;$x<=$t['acta'];$x++)
				{
					if($r1['acta']==$x && $r1['estadolabor']==7)
					{/*
						$consultax1="SELECT DATE_FORMAT( fcreacion,  '%Y' ) AS ano FROM c".$n."indicea WHERE acta=".($x)." AND c".$n."indicea.not='".$t['not']."'";
						$costo1=mysql_query($consultax1);
						$zf=mysql_fetch_assoc($costo1);
						 */
						//1.echo
						$consultax="SELECT ipc FROM costos WHERE ano=".$t['fechacreacion']." AND idcliente=".$n."";
						$costo=mysql_query($consultax);
						$valorcosto=mysql_fetch_assoc($costo);
						
						$tparcial[$bnm][$x]=round($r1['cantidad']*round($row_Recordset24['vr2008']*$k))+$tparcial[$bnm][$x];
					}
				}
				$y=round($r1['cantidad']*$row_Recordset24['vr2008'])+$y;
				$r1 = mysql_fetch_assoc($Recordset12);
			}
		}
		$totalmodulo=$y+$totalmodulo;
	}
}
while($q1 = mysql_fetch_assoc($Recordset11));
$tmodulo[$bnm]=$totalmodulo;


$wef=0;
///////////////////////////////////////////////////////////////////////////////////////////////////
$query_Recordset = "SELECT c".$n."nmodulos.dnmodulo as modulo, c".$n."indexots".$pid.".id, c".$n."indexots".$pid.".tipo, c".$n."indexots".$pid.".labor, c".$n."indexots".$pid.".observaciones FROM c".$n."nmodulos, c".$n."indexots".$pid." WHERE c".$n."nmodulos.id=c".$n."indexots".$pid.".idmodulo ORDER BY c".$n."nmodulos.dnmodulo, c".$n."indexots".$pid.".labor ASC";
$Recordset = mysql_query($query_Recordset);
$q = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);
$d=$q['modulo'];
$bnm=0;
/*
echo'<!--
<table cellspacing="0" cellpadding="0">
  <tr>
    <td><img width="219" height="31" src="actahtml_clip_image002.png" alt="logo" /></td>
    <td width="719"><p>ACTA DE AVANCE DE OBRA</p>
    <p>MEDICION PARCIAL DE AVANCE DE OBRA CODENSA    SA ESP  </p></td>

  </tr>

  <tr>
    <td colspan="2">DEPARTAMENTO DE    PROYECTOS DE ALTA TENSIÓN</td>
  </tr>
  <tr>
    
    <td colspan="2">CONTRATO NO. 5800008387</td>
  </tr>
  <tr>
    <td colspan="2">Nombre Empresa    Contratista: AC&amp;JM UNION TEMPORAL - NIT: 900214205-7   </td>
  </tr>
  <tr>
    <td colspan="2">Proyecto:   S/E '.$t['NOMBRESUBESTACION'].'</td>
  </tr>
  <tr>
    <td colspan="2">Acta N° 1:  Julio 2011</td>
  </tr>
  <tr>
    <td colspan="2">Periodo    Facturación: Julio 2011</td>
  </tr>
  <tr>
    <td colspan="2">OT: '.$t['not'].'</td>
  </tr>
</table><br />-->';
*/
$tabla1='<table border="1" cellspacing="0" cellpadding="0" class="tabla8">
<thead>';
/*
$tabla1.='
<!--<tr>
 <th class="tdtmod" colspan="3">Modulo: '.$d.'</th>
<th class="tdtpre" colspan="4">Valor Presupuestado $'.number_format($tmodulo[$bnm], 0, ',', '.').'</th>
';
for($x=1;$x<=$t['acta'];$x++)
{
	if($x % 2)
	{
		$class1='class="tdtimpar"';
	}
	else
	{
		$class1='class="tdtpar"';
	}
	$consultay="SELECT DATE_FORMAT( fcreacion,  '%Y' ) AS ano, DATE_FORMAT( fcreacion,  '%M' ) AS mes FROM c".$n."indicea WHERE acta=".($x)." AND c".$n."indicea.not='".$t['not']."'";
	$actas=mysql_query($consultay);
	$arr=mysql_fetch_assoc($actas);
	$tabla1.='<th '.$class1.' colspan="3">Valor Ejecutado Acta '.($x).' $ '.number_format($tparcial[$bnm][$x], 0, ',', '.').'<br /> '.$arr['mes'].' / '.$arr['ano'].'</th>
	<th class="tdtmod" colspan="2">Valor Acumulado</th>
</tr>-->';
}*/
$sqlano="select ano from costos where idcliente=".$n;
$queryano=mysql_query($sqlano);
$arregloano=mysql_fetch_assoc($queryano);
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Módulo')
            ->setCellValue('B1', 'Labor')
            ->setCellValue('C1', 'Actividad')
            ->setCellValue('D1', 'Codigo GOM')
			->setCellValue('E1', 'Vr. '.$arregloano['ano']."\n(antes de iva)")
            ->setCellValue('F1', 'Cantidad')
            ->setCellValue('G1', "Vr. Unitario\n(".$t['fechacreacion'].')')
            ->setCellValue('H1', 'Vr. Total')
            ->setCellValue('I1', 'Observaciones')
			;
$objPHPExcel->setActiveSheetIndex(0);
//cuadrar el alto cuando se usa alt+enter
$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setWrapText(true);
//negrita
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
//alineacion vertical y horizontal de la celda
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//autosize o tamaño fijo en la columna
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(52);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(52);
//tipo de relleno, color de fondo y color del texto
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->getStartColor()->setARGB('0070C0');
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('I1')->getFill()->getStartColor()->setARGB('0070C0');
$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('E1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('E1:H1')->getFill()->getStartColor()->setARGB('FCD5B4');


/*
$tabla1.='
<!--';

for($x=1;$x<=$t['acta'];$x++)
{
	if($x % 2)
	{
		$class2='i';
	}
	else
	{
		$i='pa';
	}
	$tabla1.='<th class="tablaw70'.$class2.'">Cantidad</th>
<th class="tablaw110'.$class2.'">Vr. Unitario ('.$t['fechacreacion'].')</th>
<th class="tablaw110'.$class2.'">Vr. Total</th>';
}

$tabla1.='
<th class="tablaw70">Cantidad</th>
<th class="tablaw110">Vr. Total</th>-->
</tr></thead><tbody>';
//2.echo $tabla1;
*/
$vb=0;
$xb=0;
$celda=1;
$totalmodulo=0;
$bnm++;
$no=1;
$inicio=2;
do
{	
	/**/
	//consulta ots para mostrar las cantidades
	$query_Recordset1 = "SELECT cantidad, estadolabor, acta FROM c".$n."ots".$pid." WHERE id=".$q['id']."";
	$Recordset1 = mysql_query($query_Recordset1);
	$r = mysql_fetch_assoc($Recordset1);
	$totalRows_Recordset = mysql_num_rows($Recordset1);

	// consulta subactividades
	$query_Recordset2 = "SELECT actividades.actividades, subactividades.subactividades, c".$n.$q['tipo']."general.vr2008 FROM c".$n.$q['tipo']."general, 	actividades, subactividades WHERE c".$n.$q['tipo']."general.actividades=actividades.identificacion AND c".$n.$q['tipo']."general.subactividades=subactividades.identificacion AND c".$n.$q['tipo']."general.".$q['tipo']."labores=$q[labor]";
	$Recordset2 = mysql_query($query_Recordset2);
	//$row_Recordset2 = mysql_fetch_assoc($Recordset2);
	$totalRows_Recordset2 = mysql_num_rows($Recordset2);

	//consulta titulo de la labor
	$query_Recordset7 = "SELECT ".$q['tipo']."labores FROM c".$n.$q['tipo']."labores WHERE identificacion=$q[labor] "; 
	$Recordset7 = mysql_query($query_Recordset7);
	$row_Recordset7 = mysql_fetch_assoc($Recordset7);
	$totalRows_Recordset7 = mysql_num_rows($Recordset7);
			
	//consulta costos materiales	
	/**/
	$x=0;
	$y=0;
	//echo "<b>Modulo: </b>".$q['modulo']."<br />
	$ftabla[$vb][$xb]=$q['modulo'];
	$xb++;
	if($q['modulo']!=$d)
	{
		$totalmodulo=0;
		
		$d=$q['modulo'];
		
		//$leli.='<tr><td class="tdtmod">Modulo: '.$d.'</td>';
/**/
		$tabla1='<!--<table border="1" cellspacing="0" cellpadding="0" class="tabla8">
 <thead>
<tr>
<th class="tdtmod" colspan="3">Modulo: '.$d.'</th>
<th class="tdtpre" colspan="4">Valor Presupuestado $'.number_format($tmodulo[$bnm], 0, ',', '.').'</th>
';
		for($x=1;$x<=$t['acta'];$x++)
		{
			if($x % 2)
			{
				$class1='class="tdtimpar"';
			}
			else
			{
				$class1='class="tdtpar"';
			}
			$consultay="SELECT DATE_FORMAT( fcreacion,  '%Y' ) AS ano, DATE_FORMAT( fcreacion,  '%M' ) AS mes FROM c".$n."indicea WHERE acta=".($x)." AND c".$n."indicea.not='".$t['not']."'";
			$actas=mysql_query($consultay);
			$arr=mysql_fetch_assoc($actas);
			$tabla1.='<th '.$class1.' colspan="3">Valor Ejecutado Acta '.($x).' $ '.number_format($tparcial[$bnm][$x], 0, ',', '.').'<br /> '.$arr['mes'].' / '.$arr['ano'].'</th>';
		}
		$tabla1.='
<th class="tdtmod" colspan="2">Valor Acumulado</th>
</tr>
<tr class="tabla">
<th class="tablaw210">Labor</th>
<th class="tablaw110">Actividad</th>
<th class="tablaw310">Codigo GOM</th>

<th class="tablaw110p">Vr. 2016<br />(antes de iva)</th>
<th class="tablaw70p">Cantidad</th>
<th class="tablaw110p">Vr. Unitario<br />'.$t['fechacreacion'].'</th>
<th class="tablaw110p">Vr. Total</th>
';

		for($x=1;$x<=$t['acta'];$x++)
		{
			if($x % 2)
			{
				$class2='i';
			}
			else
			{
				$i='pa';
			}
			$tabla1.='<th class="tablaw70'.$class2.'">Cantidad</th>
<th class="tablaw110'.$class2.'">Vr. Unitario ('.$t['fechacreacion'].')</th>
<th class="tablaw110'.$class2.'">Vr. Total</th>';
		}

			$tabla1.='
<th class="tablaw70">Cantidad</th>
<th class="tablaw110">Vr. Total</th>
</tr></thead>--><tbody>';
		//3.echo '<!--</tbody></table><br />-->'.$tabla1;
		$bnm++;
	}
	/*include("tablahtml2.php");*/
	
	
		$query_Recordset21 = "SELECT actividades.actividades, subactividades.subactividades, c".$n."".$q['tipo']."general.vr2008 FROM c".$n."".$q['tipo']."general, actividades, subactividades WHERE c".$n."".$q['tipo']."general.actividades=actividades.identificacion AND c".$n."".$q['tipo']."general.subactividades=subactividades.identificacion AND c".$n."".$q['tipo']."general.".$q['tipo']."labores=$q[labor]";
//$xxml.=$query_Recordset21;
		$Recordset21 = mysql_query($query_Recordset21);
		$row_Recordset21 = mysql_fetch_assoc($Recordset21);
		$totalRows_Recordset21 = mysql_num_rows($Recordset21);
		$ccolumna=$row_Recordset21['actividades'];
		//voy a guardar en un arreglo cuantas filas tengo que unir por actividades iguales
		$aa[0]=0;
		$gg=0;
		do
		{
			//si la columna es igual es una fila mas a unir
			if($ccolumna==$row_Recordset21['actividades'])
			{
				$aa[$gg]++;
			}
			else
			{
				//cuando no son iguales es otra fila por lo tanto sera otra cantidad de filas a unir
				$gg++;
				$aa[$gg]=1;
				$ccolumna=$row_Recordset21['actividades'];
			}
		}
		while ($row_Recordset21 = mysql_fetch_assoc($Recordset21));
		// consulta subactividades
		$query_Recordset21 = "SELECT actividades.actividades, subactividades.subactividades, c".$n."".$q['tipo']."general.vr2008 FROM c".$n."".$q['tipo']."general, actividades, subactividades WHERE c".$n."".$q['tipo']."general.actividades=actividades.identificacion AND c".$n."".$q['tipo']."general.subactividades=subactividades.identificacion AND c".$n."".$q['tipo']."general.".$q['tipo']."labores=$q[labor]";
		$Recordset21 = mysql_query($query_Recordset21);
		$row_Recordset21 = mysql_fetch_assoc($Recordset21);
		$totalRows_Recordset21 = mysql_num_rows($Recordset21);

$gg=0;
$cc=0;//celda numero
$yy=0;//select ingenieros y tecnicos
$xx=0;//suma costos asociados a la labor


/*
$consultax="SELECT ipc FROM costos WHERE ano=".$t['fecha']." AND idcliente=".$n."";
// $consultax;
$costo=mysql_query($consultax);
$valorcosto=mysql_fetch_assoc($costo);
$l=$valorcosto['ipc'];*/
		$clase='class="tabla2"';
		$clase1='class="tablaright"';
		$clase2='class="tablacenter"';
	
		$gg=0;
		$h=0;
		$ww=$aa[$gg];

		do 
		{
			$no++;
			$celda++;
			if($ww==0)
			{
				$gg++;
				$ww=$aa[$gg];
			}
			if($h==0)
			{
				$leli.='<tr><td>'.$d.'</td>';
		//$clase='class="tablafinleft"';
		//$clase1='class="tablafinright"';
		//$clase2='class="tablafincenter"';
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$celda, $d);
				
				$objRichText = new PHPExcel_RichText();

				$objPayable = $objRichText->createTextRun($q['tipo'].'-'.$q['labor'].' ');
				$objPayable->getFont()->setBold(true);
				$objPayable->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_RED ) );

				$objRichText->createText($row_Recordset7[$q['tipo'].'labores']);
				$objPHPExcel->getActiveSheet()->getCell('B'.$celda)->setValue($objRichText);
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$celda, $q['observaciones']);
				
				$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$inicio.':A'.($celda+$totalRows_Recordset21));
				$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$inicio.':B'.($celda+$totalRows_Recordset21));
				$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I'.$inicio.':I'.($celda+$totalRows_Recordset21));
				//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$celda, $d);
				$dats='<td '.$clase.' rowspan="'.($totalRows_Recordset21+1).'">'.$d.'</td><td '.$clase.' rowspan="'.($totalRows_Recordset21+1).'"><span class="rojo">'.$q['tipo'].'-'.$q['labor'].'</span> '.$row_Recordset7[$q['tipo'].'labores'].'<br /></td>';
		$dats1='<td '.$clase.' rowspan="'.($totalRows_Recordset21+1).'">'.$q['observaciones']."&nbsp;".'</td>';
				
		$h++;	
			}
			else
			{
				$dats=$dats1='';
			}
			if($ww==$aa[$gg])
			{
		//$letra+2;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$celda, $row_Recordset21['actividades']);
				$data='<td '.$clase.' rowspan="'.$aa[$gg].'">'.$row_Recordset21['actividades'].'</td>';
				$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$celda.':C'.($celda+$aa[$gg]-1));
				$ww--;

			}
			else
			{
				$data='';
				$ww--;
			}
	
	/*$count=strlen($row_Recordset21['subactividades']);
	if($count>=45)
	{
		$row_Recordset21['subactividades'] = substr($row_Recordset21['subactividades'], 0, 45)."...";
	}*////**/
			if($x!=0)
			{/*
	$consultax1="SELECT DATE_FORMAT( fcreacion,  '%Y' ) AS ano FROM c".$n."indicea WHERE acta=".($x)." AND c".$n."indicea.not='".$t['not']."'";
	$costo1=mysql_query($consultax1);
	$zf=mysql_fetch_assoc($costo1);
	*/
				$consultax="SELECT ipc FROM costos WHERE ano=".$t['fechacreacion']." AND idcliente=".$n."";
				$costo=mysql_query($consultax);
				$valorcosto=mysql_fetch_assoc($costo);
	
				$k=$valorcosto['ipc'];
			}
			//echo date('H:i:s') , " Set document properties" , PHP_EOL;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$celda, $row_Recordset21['subactividades']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$celda, number_format($row_Recordset21['vr2008'], 0, ',', ''));
			$objPHPExcel->getActiveSheet()->getStyle('E'.$celda)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$celda, $r['cantidad']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$celda, number_format(round($row_Recordset21['vr2008']*$k), 0, ',', ''));
			$objPHPExcel->getActiveSheet()->getStyle('G'.$celda)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$celda, "=ROUND((F".$celda."*G".$celda."),0)");
			$objPHPExcel->getActiveSheet()->getStyle('H'.$celda)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
			/*echo '
			<tr>'.$dats.'
			'.$data.'	
			<td '.$clase.'>'.$row_Recordset21['subactividades'].'</td>
			<td '.$clase1.'>$ '.number_format($row_Recordset21['vr2008'], 0, ',', '.').'</td>
			<td '.$clase2.'>'.number_format($r['cantidad'], 3, ',', '.').'</td>
			';*/
			$letra='g';
			/*echo'
			<td '.$clase1.'>$ '.number_format(round($row_Recordset21['vr2008']*$k), 0, ',', '.')./*'>=REDONDEAR(E'.$no.'/0)'</td>';*/
	/*
			echo'
			<td '.$clase1./*'>act$ '.number_format($r['cantidad']*$row_Recordset21['vr2008']*$k, 10, ',', '.').'>=REDONDEAR((f'.$no.'*g'.$no.');0)</td>'.$dats1;*/
		//$totalmodulo=$row_Recordset21['vr2008']+$totalmodulo;
		/*
	//acumulado
	for($x=1;$x<=$t['acta'];$x++)
	{
		$consultax1="SELECT DATE_FORMAT( fcreacion,  '%Y' ) AS ano FROM c".$n."indicea WHERE acta=".($x)." AND c".$n."indicea.not='".$t['not']."'";
		$costo1=mysql_query($consultax1);
		$zf=mysql_fetch_assoc($costo1);
		$consultax="SELECT ipc FROM costos WHERE ano=".$zf['ano']." AND idcliente=".$n."";
		$costo=mysql_query($consultax);
		$valorcosto=mysql_fetch_assoc($costo);
	
		$k=$valorcosto['ipc'];
		//echo $x;
		if($r['estadolabor']==7 && $r['acta']==$x)
		{
			$estado=$r['cantidad'];
			$estado1='$ '.number_format($row_Recordset21['vr2008']*$k, 0, ',', '.');
			$estado2='$ '.number_format($r['cantidad']*$row_Recordset21['vr2008']*$k, 0, ',', '.');
			$tacta[$x]=$r['cantidad']*$row_Recordset21['vr2008']*$k+$tacta[$x];
			$tacta1[$wef]=$tacta[$x];
			//echo '<br />'.$tacta1[$wef];
			$estado3=$r['cantidad']*$row_Recordset21['vr2008']*$k;
			$estado3='$ '.number_format($estado3, 0, ',', '.');
			
		}
		elseif($r['estadolabor']==0)
		{
			//$estado=$r['cantidad'];
			$estado3='$ '.number_format($estado3, 0, ',', '.');
				//echo 'numero de actas '.$t['acta'].', estado '.$r['estadolabor'].', acta '.$r['acta'].', cantidad'.$r['cantidad'].'<br />';
		}
		else
		{
			$estado=$estado1=$estado2.$estado3='&nbsp;';
		}
		echo '<td '.$clase2.'>'.$estado.'</td>
		<td '.$clase1.'>'.$estado1.'</td>
		<td '.$clase1.'>'.$estado2.'</td>';
	}
	if($r['estadolabor']==7 || $r['estadolabor']==0)
	{
		$estado=$r['cantidad'];
			//echo 'numero de actas '.$t['acta'].', estado '.$r['estadolabor'].', acta '.$r['acta'].', cantidad'.$r['cantidad'].'<br />';
	}
	
	echo'<td '.$clase1.'>'.$estado.'</td>';
	
	if($r['estadolabor']!=7 && $r['estadolabor']!=0)
	{
		$clase1='class="tablarightf"';;
	}
	'<!--	
	<td '.$clase1.'>'.$estado3.'</td>
	--></tr>';*/
	
			$xx=round($row_Recordset21['vr2008'])+$xx;
			$yy++;
			$cc++;
			$y=round($r['cantidad']*round($row_Recordset21['vr2008']*$k))+$y;
			$r = mysql_fetch_assoc($Recordset1);
	'class="tdapar"';

			$estado=$estado1=$estado2="";
			$clase1='class="tablaright"';
			
		}
		while ($row_Recordset21 = mysql_fetch_assoc($Recordset21));
		$fin=$no;
		$no++;
		$celda++;
		$ftabla[$vb][$xb]='Subtotal labores No. '.$q['labor'].':';
		$xb++;
		

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$celda, 'Subtotal labores No. '.$q['labor'].':');

		$objPHPExcel->getActiveSheet()->getStyle('C'.$celda.':D'.$celda)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$celda.':D'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$celda.':D'.$celda)->getFill()->getStartColor()->setARGB('1F497D');
		$objPHPExcel->getActiveSheet()->getStyle('C'.$celda.':D'.$celda)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$celda, number_format($xx, 0, ',', ''));
		$objPHPExcel->getActiveSheet()->getStyle('E'.$celda)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
		if($inicio != $fin)
		{
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$celda, '=SUM(H'.$inicio.':H'.$fin.')');
			$objPHPExcel->getActiveSheet()->getStyle('H'.$celda)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
		}
		else
		{
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$celda, '=H'.$fin);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$celda)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
		}
		$ftabla[$vb][$xb]='=H'.$celda;
		$xb++;
		$vb++;
		$xb=0;

		$objPHPExcel->getActiveSheet()->getStyle('E'.$celda.':H'.$celda)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$celda.':H'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$celda.':H'.$celda)->getFill()->getStartColor()->setARGB('E26B0A');
		$objPHPExcel->getActiveSheet()->getStyle('E'.$celda.':H'.$celda)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$inicio.':A'.$celda);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$inicio.':I'.$celda)->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$inicio.':I'.$celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$inicio.':B'.$celda);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I'.$inicio.':I'.$celda);
		
		/*echo '
		<tr>
		<td class="tdtmod">AQUI ESTA:'.$celda.'</td>';
		$leli.='  
		<td>Suma de los costos asociados a la labor '.$q['labor'].':</td>';

		echo'
		<td class="tdtmod">Suma de los costos asociados a la labor '.$q['labor'].':</td>
		<td class="tabla3">$ '.number_format($xx, 0, ',', '.').'</td>
		<td class="tabla3">&nbsp;</td>
		<td class="tabla3">&nbsp;</td>
		<td class="tabla3">=suma(h'.$inicio.':h'.$fin.')'./*.number_format($y, 10, ',', '.').'</td>
		';*/

		/*$leli.='
		<td>=suma(h'.$inicio.':h'.$fin.')'.*//*.number_format($y, 10, ',', '.').'</td></tr>';
*/
		$totaliz.='+H'.$no;
		$inicio=$no+1;
/*
for($x=1;$x<=$t['acta'];$x++)
	{
		if($x %2)
		{
			$class1='class="tdtaimpar"';
		}
		else
		{
			$class1='class="tdtpar"';
		}
		echo '<td '.$class1.'>&nbsp;</td>
		<td '.$class1.'>&nbsp;</td>
		<td '.$class1.'>$ '.number_format($tacta[$x], 0, ',', '.').'</td>';
		$tacta[$x]=0;
	}
		echo '<!--
		<td class="tdtmod">&nbsp;</td>
		<td class="tdtmod">$ '.number_format($tacta1[$wef], 0, ',', '.').'</td>-->
		</tr>';*/
		$wef++;

	
	//echo "Observaciones, y/o Aclaraciones y/o  Lineamientos: ".$q[observaciones]."<br /><br />";
	//$pdf->ezText("<br />Observaciones:<br />", 10,array('justification'=>'center'));
}
while($q = mysql_fetch_assoc($Recordset));
$celda++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$celda, 'Total:');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$celda, "=".$totaliz);
$objPHPExcel->getActiveSheet()->getStyle('H'.$celda)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
//4.echo '</tbody></table><table><tr><td>Total:</td><td>='.$totaliz.'</td></tr></table>';
/*
$bnm=0;
	while(!is_null($tmodulo[$bnm]))
	{
		$acta2=$tmodulo[$bnm]+$acta2;
		//echo $bnm;
		$bnm++;
	}
for($x=1;$x<=$t['acta'];$x++)
{
	$bnm=0;
	while(!is_null($tparcial[$bnm][$x]))
	{
		$acta1[$x]=$tparcial[$bnm][$x]+$acta1[$x];
		//echo $bnm;
		$bnm++;
	}
	$xml.='
	<tr>
	<td width="248">VALOR ACTA '.$x.'</td>
	<td width="117" style="text-align:right">$ '.number_format($acta1[$x], 0, ',','.').'</td>
	<td width="55" style="text-align:right">'.round(($acta1[$x]*100/$acta2), 2).'%</td>
	</tr>';
	$acumulado=$acta1[$x]+$acumulado;
}*/
/*$leli.='
</table>
';*/
//5.echo $leli;
	//echo $acta2;

/*
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');

// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
*/
$celda++;
$celda++;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$celda, 'PEP');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$celda, 'No. Orden Presupuestal');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$celda, 'Módulo');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$celda, "Labor");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$celda, "Total");

$objPHPExcel->getActiveSheet()->getStyle('A'.$celda.':E'.$celda)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$celda.':D'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A'.$celda.':D'.$celda)->getFill()->getStartColor()->setARGB('0070C0');
$objPHPExcel->getActiveSheet()->getStyle('A'.$celda.':D'.$celda)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('E'.$celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('E'.$celda)->getFill()->getStartColor()->setARGB('FCD5B4');

$objPHPExcel->getActiveSheet()->getStyle('A'.$celda.':E'.$celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$kk=0;
$inicio2=$inicio1=$celda+1;
$j=0;//variable modifcada por mfvargas se encontraba $j=1 , se asigna valor a variable $j=0
if (isset($ftabla[$j][0]))
{
	$modu=$ftabla[$j][0];
  // your code



do
{
	$celda++;
	if($modu==$ftabla[$j][0])
	{
		$kk++;
	}
	else
	{
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$inicio1.':A'.($inicio1+$kk-1));
		$objPHPExcel->getActiveSheet()->getStyle('A'.$inicio1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$inicio1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$kk=1;
		$inicio1=$celda;
		$modu=$ftabla[$j][0];
	}
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$celda, $ftabla[$j][0]);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$celda, $ftabla[$j][1]);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$celda, $ftabla[$j][2]);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$celda)->getNumberFormat()->setFormatCode('"$" #,##0;[Red]("$" #,##0)');
	$j++;
}
while($j!=$vb);
}
$styleThinBlackBorderOutline = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle('A'.($inicio2-1).':E'.$celda)->applyFromArray($styleThinBlackBorderOutline);

/*
echo date('H:i:s') , " Calculated data" , EOL;
for ($col = 'H'; $col != 'I'; ++$col) {
    for($row = 1; $row <= 60; ++$row) {
        if ((!is_null($formula = $objPHPExcel->getActiveSheet()->getCell($col.$row)->getValue())) &&
			($formula[0] == '=')) {
            echo 'Value of ' , $col , $row , ' [' , $formula , ']: ' ,
                               $objPHPExcel->getActiveSheet()->getCell($col.$row)->getCalculatedValue() . EOL;
        }
    }
}

*/
// Rename worksheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

/**/
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
function ob_clean_all () 
{ 
$ob_active = ob_get_length ()!== FALSE; 
while($ob_active) 
{ 
ob_end_clean(); 
$ob_active = ob_get_length ()!== FALSE; 
} 
return FALSE; 
}
ob_clean_all();
$objWriter->save('php://output');
exit;
