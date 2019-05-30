<?php
define('CHARSET', 'UTF-8');
require_once '../../../components/PHPWord/PHPWord.php';
require_once '../../0connection/BD_config.php';
require_once '../../0connection/connection.php';
require_once '../../0connection/BD.php';
$hoy = date("d/m/Y");
setlocale(LC_ALL, "es_ES");
$fecha_emisionOt = "";

$obj_bd = new BD();
$det_pret = $_GET['er'];



// New Word Document

//$phpWord->getCompatibility()->setOoxmlVersion(15);
$PHPWord = new PHPWord();

// New portrait section
$section = $PHPWord->createSection();

//Add footer
//$footer = $section->createFooter();
//$footer->addPreserveText('Page {PAGE} of {NUMPAGES}.', array('align' => 'center'));
// Add header
$header = $section->createHeader();
$table = $header->addTable();
//$pag=$header->addPreserveText('Page {PAGE} of {NUMPAGES}.');
//estilo de letra
$PHPWord->addParagraphStyle('p2Style', array('align' => 'center', 'spaceAfter' => 0));
$fontStyle = array('bold' => true, 'alignment' => 'center');
$fontStyle2 = array('alignment' => 'center');
$fontStyle_header = array('bold' => true, 'align' => 'center', name => 'Verdana', 'size' => 8);
$fontStyle1 = array('bold' => true, 'align' => 'center', 'underline' => 'single');
/**/


$table->addRow();
$table->addCell(4000, array('vMerge' => 'restart', 'valign' => 'center'))->addImage('../../../img/logonew.jpg', array('width' => 85, 'height' => 40, 'align' => 'center', 'valign' => 'center'));
$table->addCell(13000, array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'edefef'))->addText('Orden de trabajo ', array('bold' => true, 'align' => 'center', name => 'Verdana', 'size' => 10), 'p2Style');
$table->addCell(4000)->addPreserveText(utf8_decode('RG03-IO775          Versión 1             Pagina {PAGE} de {NUMPAGES}         18/07/2017'), $fontStyle_header, 'p2Style');
$header->addTextBreak(1);

// Define table style arrays
$styleTable = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 1);
$styleTableRa = array('borderSize' => 2, 'borderColor' => 'e0e0e0', 'cellMargin' => 1);
$styleFirstRow = array('borderBottomSize' => 5, 'borderBottomColor' => '000000', 'bgColor' => 'ffff99');
$styleFirstRowRa1 = array('borderBottomSize' => 6, 'borderBottomColor' => 'c0c0c0', 'bgColor' => 'c0c0c0');
$styleFirstRow1 = array('borderBottomSize' => 2, 'borderBottomColor' => 'e0e0e0', 'bgColor' => 'c5c5c5');


// Define cell style arrays
$styleCell = array('valign' => 'center');
$styleCellBTLR = array('valign' => 'center', 'textDirection' => PHPWord_Style_Cell::TEXT_DIR_BTLR);

/* estilos de parrafo y letra */
$paragraphOptions = array('spaceBefore' => 0, 'spaceAfter' => 0, 'align' => 'both');
$paragraphOptionsleft = array('spaceBefore' => 0, 'spaceAfter' => 0, 'align' => 'left');
$firmas = array('spaceBefore' => 0, 'spaceAfter' => 0, 'align' => 'center');
$fontStyle_texto = array('name' => 'Arial', 'size' => 10, 'bold' => false, 'align' => 'center');
/**/

//table 1
// Add table
$PHPWord->addTableStyle('Descripcion', $styleTable);
$table_des = $section->addTable('Descripcion');
// Add row
$table_des->addRow(1);
// Add cells
$table_des->addCell(2000, $styleCell)->addText('No. ORDEN', $fontStyle, 'p2Style');
$table_des->addCell(2800, $styleCell)->addText(utf8_decode('FECHA DE EMISIÓN'), $fontStyle, 'p2Style');
$table_des->addCell(1500, $styleCell)->addText('CONTRATISTA', $fontStyle, 'p2Style');
$table_des->addCell(2800, $styleCell)->addText('FECHA DE INICIO', $fontStyle, 'p2Style');
$table_des->addCell(2000, $styleCell)->addText('S/E', $fontStyle, 'p2Style');
$table_des->addCell(2000, $styleCell)->addText('PRESUPUESTO', $fontStyle, 'p2Style');

//llenar la tabla
$sql1 = "SELECT   OT.ordentrabajo_num,
                OT.ordentrabajo_GOM,
                OT.ordentrabajo_contratista,
                OT.ordentrabajo_fechaemision,
                OT.ordentrabajo_fechaini,
                OT.ordentrabajo_ordenpresupuestal,
                OT.ordentrabajo_pep,
                SB.subestacion_nombre,
                DP.detallepresupuesto_total,
                DP.detallepresupuesto_valorincremento,

                CT.contrato_numero,
                CL.cliente_descripcion,
                OT.ordentrabajo_obs as proyecto,

                DP.detallepresupuesto_alcance,
                DP.detallepresupuesto_objeto,

                DP.detallepresupuesto_fechafin

                FROM dt_detalle_presupuesto DP
                JOIN pt_orden_trabajo OT ON OT.detallepresupuesto_id=DP.detallepresupuesto_id
                JOIN dt_subestacion SB ON DP.subestacion_id=SB.subestacion_id
                JOIN dt_contrato CT ON DP.contrato_id=CT.contrato_id
                JOIN dt_cliente CL ON CT.cliente_id=CL.cliente_id
                AND DP.detallepresupuesto_id=$det_pret";


$resultado1 = $obj_bd->EjecutaConsulta($sql1);

while ($row1 = $obj_bd->FuncionFetch($resultado1)) {
    $orden_trabajo = utf8_encode($row1['ordentrabajo_num']);
    $ordentrabajo_ordenpresupuestal = utf8_encode($row1['ordentrabajo_ordenpresupuestal']);
    $ordentrabajo_pep = utf8_encode($row1['ordentrabajo_pep']);
    $total_final_OT = $row1['detallepresupuesto_total'] + $row1['detallepresupuesto_valorincremento'];
    $table_des->addRow();
    $table_des->addCell(2000)->addText(utf8_encode($row1['ordentrabajo_num']), $fontStyle, 'p2Style');
    // $table_des->addCell(1800)->addText(utf8_encode($row1['ordentrabajo_GOM']));
    $table_des->addCell(2800)->addText(utf8_encode($row1['ordentrabajo_fechaemision']), $fontStyle2, 'p2Style');
    $table_des->addCell(1500)->addText(utf8_encode($row1['ordentrabajo_contratista']), $fontStyle2, 'p2Style');
    $table_des->addCell(2800)->addText(utf8_encode($row1['ordentrabajo_fechaini']), $fontStyle2, 'p2Style');
    $table_des->addCell(2000)->addText($row1['subestacion_nombre'], $fontStyle2, 'p2Style');
    $table_des->addCell(2000)->addText("$" . number_format($total_final_OT, 0, ',', '.') . " Antes de IVA", $fontStyle, 'p2Style');

    $contrato1 = utf8_encode($row1['contrato_numero']);
    $contrato = explode('-', $contrato1);
    $cliente = utf8_encode($row1['cliente_descripcion']);
    $proyecto = utf8_encode($row1['proyecto']);
    $alcance = utf8_encode($row1['detallepresupuesto_alcance']);
    $objeto = utf8_encode($row1['detallepresupuesto_objeto']);
    $subestacion = utf8_encode($row1['subestacion_nombre']);
    $fecha_fin_pre = $row1['detallepresupuesto_fechafin'];
    $fecha_emisionOt = $row1['ordentrabajo_fechaemision'];
    $valo_presupuesto = number_format($row1['detallepresupuesto_total'], 0, ',', '.');
}



$section->addTextBreak(1);
$texto1 = "Mediante el Contrato Marco No. " . $contrato[0] . " " . $cliente . " designa a AC ENERGY para realizar la ingeniería  para los trabajos en la subestación " . $subestacion . ", según el alcance descrito en esta OT, en desarrollo del proyecto, " . $proyecto . ".";
$obj_html = $section->addText(utf8_decode($texto1), $fontStyle_texto, $paragraphOptions);
$section->addTextBreak(1);

//objeto
$section->addText('OBJETO: ', $fontStyle, $paragraphOptions);
$section->addText(utf8_decode($objeto), $fontStyle_texto, $paragraphOptions);
$section->addTextBreak(1);

//alcance
$styleCel2 = array('valign' => 'left');
$section->addText('ALCANCE: ', $fontStyle);




$PHPWord->addTableStyle('alcance', $styleTable);
$table_res = $section->addTable('alcance');
// Add row
$table_res->addRow();
// Add cells
$table_res->addCell(4000, array('gridSpan' => 2))->addText("Existe una orden de trabajo anterior asociada con el alcance de esta OT                       SI _  NO _", $fontStyle_texto, $paragraphOptions);

$section->addTextBreak(1);
$table_res->addRow();
$table_res->addCell(3000)->addText(trim('No. Orden de trabajo: '), $fontStyle_texto, $paragraphOptions);
$table_res->addCell(12000)->addText('', $fontStyle_texto, $paragraphOptions);
$table_res->addRow();
$table_res->addCell(3000)->addText(trim(utf8_decode('Empresa Colaboradora: ')), $fontStyle_texto, $paragraphOptions);
$table_res->addCell(12000)->addText(trim(' AC ENERGY S.A.S.'), $fontStyle_texto, $paragraphOptions);
$section->addTextBreak(1);



$alcance = explode(". ", $alcance);
foreach ($alcance as $line) {
    $section->addText(utf8_decode($line), $fontStyle_texto, $paragraphOptions);
    $section->addTextBreak(1);
}


//$texto_alcance=preg_replace('/\<br(\s*)?\/?\>/i', "\n", $alcance);
//$texto_alcance= str_replace('. ','\r\n', $alcance);
//$section->addText(utf8_decode($texto_alcance));
//Plazo de ejecuciÃ³n de la orden:
if ($fecha_fin_pre == "0000-00-00") {
    setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
    $fecha_fin = "EL PRESUPUESTO NO TIENE FECHA DE FINALIZACION";
} else {
    setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
    $fecha_fin = strftime("%d de %B de %Y", strtotime($fecha_fin_pre));
}
$texto2 = "Para la ejecución de los trabajos y entrega formal a CODENSA S.A. ESP, la fecha límite es el día $fecha_fin";
$section->addText(utf8_decode('A. Plazo de ejecución de la orden: '), $fontStyle1);
$section->addText(utf8_decode($texto2), $fontStyle_texto, $paragraphOptions);
$section->addTextBreak(1);
$section->addText(utf8_decode("El cronograma de entregas parciales se muestra a continuación:"), $fontStyle_texto, $paragraphOptions);
//tabla de resumen de actividades

$PHPWord->addTableStyle('resumen', $styleTable, $styleFirstRow);
$table_res = $section->addTable('resumen');
// Add row
$table_res->addRow(50);
// Add cells
$table_res->addCell(2800, $styleCell)->addText(utf8_decode('Módulo'), $fontStyle, 'p2Style');
$table_res->addCell(1800, $styleCell)->addText('Actividad', $fontStyle, 'p2Style');
$table_res->addCell(1500, $styleCell)->addText(utf8_decode('Inicio'), $fontStyle, 'p2Style');
$table_res->addCell(1500, $styleCell)->addText('Fin', $fontStyle, 'p2Style');


$sql2 = "SELECT pt.presupuesto_id,
                        md.modulo_descripcion,
                        pt.presupuesto_fechaini,
                        pt.presupuesto_fechafin
                   FROM pt_presupuesto pt
                   JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
                   JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
                   JOIN cf_modulo md ON pt.modulo_id=md.modulo_id            
                   JOIN cf_labor lb ON bm.labor_id=lb.labor_id
                    AND pt.presupuesto_estado=1
                    AND pt.detallepresupuesto_id=$det_pret
               GROUP BY 
                        pt.presupuesto_obs,
                        pt.baremo_id,
                        pt.tipobaremo_id,
                        pt.detallepresupuesto_id,
                        bm.baremo_item,
                        tb.tipobaremo_descripcion,
                        md.modulo_descripcion";
$resultado2 = $obj_bd->EjecutaConsulta($sql2);
$i = 1;
while ($row2 = $obj_bd->FuncionFetch($resultado2)) {
    $table_res->addRow();

    if ($i % 2 == 0) {
        $table_res->addCell(2800)->addText($row2['modulo_descripcion'], $fontStyle_texto, 'p2Style');
        $table_res->addCell(1800)->addText(utf8_encode('Subactividad'), $fontStyle_texto, 'p2Style');
        $table_res->addCell(1500)->addText(utf8_encode($row2['presupuesto_fechaini']), $fontStyle_texto, 'p2Style');
        $table_res->addCell(1500)->addText(utf8_encode($row2['presupuesto_fechafin']), $fontStyle_texto, 'p2Style');
    } else {
        $table_res->addCell(2800, $styleFirstRow1)->addText($row2['modulo_descripcion'], $fontStyle_texto, 'p2Style');
        $table_res->addCell(1800, $styleFirstRow1)->addText(utf8_encode('Subactividad'), $fontStyle_texto, 'p2Style');
        $table_res->addCell(1500, $styleFirstRow1)->addText(utf8_encode($row2['presupuesto_fechaini']), $fontStyle_texto, 'p2Style');
        $table_res->addCell(1500, $styleFirstRow1)->addText(utf8_encode($row2['presupuesto_fechafin']), $fontStyle_texto, 'p2Style');
    }


    $i = $i + 1;
}

$section->addTextBreak(1);

//Valor de la orden de trabajo:
$section->addText(utf8_decode('B. Valor de la orden de trabajo:'), $fontStyle1);
$texto3 = "El valor inicial de esta Orden de Trabajo es de COP $ " . number_format($total_final_OT, 0, ',', '.')  . " antes de IVA. Cualquier variación en el alcance acordado en esta Orden de Trabajo con su respectiva valoración económica, deberá ser validada previamente por la División Ingeniera de Redes Alta Tensión de CODENSA S.A. ESP. No se reconocerán después de ejecutadas, actividades ni precios que no hayan sido acordados previamente.";
$section->addText(utf8_decode($texto3), c);
$section->addTextBreak();
$section->addText(utf8_decode("El valor de la OT incluye el incremento del 1.5% según el otrosí No.1 del contrato No. 5700014501."),$fontStyle_texto, $paragraphOptions);



$sql_incremento = "SELECT * 
           FROM dt_incremento_presupuesto 
          WHERE detallepresupuesto_id=$det_pret
                    AND incrementopresupuesto_estado=1";
$existe_incremmentos = $obj_bd->Filas($sql_incremento);
if ($existe_incremmentos > 0) {
    $result_incremento = $obj_bd->EjecutaConsulta($sql_incremento);
    $row6 = $obj_bd->FuncionFetch($result_incremento);

        //$tipo_incremento = $row6["incrementopresupuesto_tipo"];
        //$tipo_incremento1 = $row6["incrementopresupuesto_porcentaje"];

        if ($row6["incrementopresupuesto_tipo"] == "Actividades de Levantamento") {        
            $section->addTextBreak(1);
            $section->addText(utf8_decode('C. Incremento de precio:'), $fontStyle1);
            $section->addText(utf8_decode('De acuerdo con lo establecido en el contrato “Para los trabajos desarrollados en subestaciones o líneas de AT que estén ubicadas fuera de la zona comprendida por el Distrito Capital y las zonas demarcadas en el mapa adjunto como Charquito, Madrid, Chía, Zipaquirá y Sopó se considerará un incremento del  3% en el precio contratado de las Unidades Básicas de servicio (Un. Ser1 para ingeniería de subestaciones y Un. Ser2 para ingeniería de líneas), este incremento solo aplicará para actividades de levantamientos y estudios donde se requiere el desplazamiento del personal a la zona del proyecto en general se excluyen las actividades ejecutadas en la oficina como son la ingeniería de detalle y la elaboración de  planos As Built.”.'), $fontStyle_texto, $paragraphOptions);
            $section->addTextBreak(1);
            $section->addText(utf8_decode('Según lo transcrito anteriormente del Numeral 3.2. INCREMENTO DEL COSTO DE LAS ACTIVIDADES BAREMADAS, del Contrato, el valor de esta Orden de Trabajo tiene un incremento del 3% sobre los valores baremados de levantamiento, debido a que la SE ' . $subestacion . ' se encuentra fuera de la zona demarcada.'), $fontStyle_texto, $paragraphOptions);
            $section->addTextBreak(1);
            $section->addText(utf8_decode('D. Alcance baremado:'), $fontStyle1);
                                    
        }else{
        //Actividades de Levantamento incremento por ubicacion
            //C. Alcance baremado:
            $section->addTextBreak(1);
            $section->addText(utf8_decode('C. Alcance baremado:'), $fontStyle1);
    
    }
    }


        $section->addText(utf8_decode('El valor asociado con los trabajos objeto de esta Orden de trabajo se discrimina a continuación:'), $fontStyle_texto, $paragraphOptions);

//detalle de las actividades
$sql3 = "SELECT lb.labor_id,
                md.modulo_descripcion,
                bm.baremo_item,
                tb.tipobaremo_sigla,
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
       GROUP BY pt.presupuesto_obs,
                pt.baremo_id,
                pt.tipobaremo_id,
                pt.detallepresupuesto_id,
                bm.baremo_item,
                tb.tipobaremo_descripcion,
                md.modulo_descripcion";

$resultado3 = $obj_bd->EjecutaConsulta($sql3);

while ($row3 = $obj_bd->FuncionFetch($resultado3)) {

    $section->addTextBreak(1);
    $section->addText(utf8_decode('Módulo: '), $fontStyle, $paragraphOptions);
    $section->addText($row3['modulo_descripcion'], $fontStyle_texto);

    $section->addText(utf8_decode('Actividad: '), $fontStyle, $paragraphOptions);
    $lb_descripcion = utf8_encode($row3['labor_descripcion']);
    $section->addText($row3['tipobaremo_sigla'] . '-' . $row3['baremo_item'] . " " . utf8_decode($lb_descripcion) . " - UNIDAD DE MEDIDA " . utf8_decode($row3['labor_unidmedida']), $fontStyle_texto);

    //tabla
    $PHPWord->addTableStyle('Actividad' . $row3['modulo_id'], $styleTableRa, $styleFirstRowRa1);
    $table_act = $section->addTable('Actividad' . $row3['modulo_id']);
// Add row
    $table_act->addRow();
// Add cells
    $table_act->addCell(2000, $styleCell)->addText(utf8_decode('Actividad'), $fontStyle, 'p2Style');
    $table_act->addCell(1800, $styleCell)->addText(utf8_decode('Código GOM'), $fontStyle, 'p2Style');
    $table_act->addCell(1000, $styleCell)->addText(utf8_decode('Valor'), $fontStyle, 'p2Style');
    $table_act->addCell(1000, $styleCell)->addText('Cant', $fontStyle, 'p2Style');
    $table_act->addCell(1000, $styleCell)->addText('Vr. Total', $fontStyle, 'p2Style');

    //tabla de actividades
    $sql4 = "SELECT 
                    sum(pt.presupuesto_porcentaje) as cantidad,
                    ac.actividad_valorservicio,
                    sum(pt.presupuesto_valorporcentaje) as valorporcentaje,
                    pt.presupuesto_id,
                    pt.baremoactividad_id, 
                    pt.presupuesto_alcances,                 
                    bm.baremo_item,
                    bm.baremo_id,
                    tb.tipobaremo_sigla,
                    ac.actividad_id,
                    ac.actividad_descripcion,
                    pt.presupuesto_obs,
                    ac.actividad_GOM            
                FROM pt_presupuesto pt
                JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
                JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
                JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
                JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
                AND pt.baremo_id=" . $row3['baremo_id'] . "
                AND pt.tipobaremo_id=" . $row3['tipobaremo_id'] . "
                AND pt.modulo_id=" . $row3['modulo_id'] . "
                AND bm.baremo_estado=1
                AND pt.detallepresupuesto_id=$det_pret
                AND pt.presupuesto_estado=1
                group by presupuesto_obs, ac.actividad_id";
//echo '<pre>';
//var_dump($sql4);
//echo '</pre>';
    $resultado4 = $obj_bd->EjecutaConsulta($sql4);
    $suma_servicio = 0;
    while ($row4 = $obj_bd->FuncionFetch($resultado4)) {

        $suma_servicio = $suma_servicio + $row4['actividad_valorservicio'];

        $suma_servicio_t = number_format($suma_servicio, 0, ',', '.');
        $total_actividad = number_format($row3['total_actividad'], 0, ',', '.');
        $valo_servicio = number_format($row4['actividad_valorservicio'], 0, ',', '.');
        $valo_porcentaje = number_format($row4['valorporcentaje'], 0, ',', '.');

        $table_act->addRow();
        $actividad = utf8_encode($row4['actividad_descripcion']);
        $table_act->addCell(2000, array('valign' => 'center'))->addText(utf8_decode($actividad), $fontStyle_texto, 'p2Style');
        $table_act->addCell(1800)->addText(utf8_encode($row4['actividad_gom']), $fontStyle_texto, 'p2Style');
        $table_act->addCell(1000)->addText("$" . $valo_servicio, $fontStyle_texto, 'p2Style');
        //$table_act->addCell(1000)->addText(utf8_encode($row4['cantidad']), $fontStyle_texto, $paragraphOptions); -- alinear a la izquierda $paragraphOptions
        $table_act->addCell(1000)->addText(utf8_encode($row4['cantidad']), $fontStyle_texto, 'p2Style');
        $table_act->addCell(1000)->addText("$" . $valo_porcentaje, $fontStyle_texto, 'p2Style');
    }
    $table_act->addRow();
    $table_act->addCell(4600, $styleFirstRow1)->addText(utf8_encode("Suma de los costos asociados a la labor " . $row3['tipobaremo_sigla'] . '-' . $row3['baremo_item']), $fontStyle, 'p2Style');
    $table_act->addCell(1000, $styleFirstRow1)->addText("", $fontStyle_texto, 'p2Style');
    $table_act->addCell(1000, $styleFirstRow1)->addText("$" . $suma_servicio_t, $fontStyle, 'p2Style');
    $table_act->addCell(1000, $styleFirstRow1)->addText("");
    $table_act->addCell(1000, $styleFirstRow1)->addText("$" . $total_actividad, $fontStyle, 'p2Style');

    $section->addTextBreak(1);

    //Observaciones, y/o Aclaraciones y/o  Lineamientos:
    $section->addText(utf8_decode('Observaciones, y/o Aclaraciones y/o  Lineamientos: '), $fontStyle);
    $obs = utf8_encode($row3['presupuesto_obs']);
    $section->addText(utf8_decode($obs), $fontStyle_texto, $paragraphOptions);
}
$$sql_incremento = "SELECT * 
           FROM dt_incremento_presupuesto 
          WHERE detallepresupuesto_id=$det_pret
                    AND incrementopresupuesto_estado=1";
$existe_incremmentos = $obj_bd->Filas($sql_incremento);
if ($existe_incremmentos > 0) {
    $result_incremento = $obj_bd->EjecutaConsulta($sql_incremento);
    $row6 = $obj_bd->FuncionFetch($result_incremento);

        //$tipo_incremento = $row6["incrementopresupuesto_tipo"];
        //$tipo_incremento1 = $row6["incrementopresupuesto_porcentaje"];

        if ($row6["incrementopresupuesto_tipo"] == "Actividades de Levantamento") { 
        //Actividades de Levantamento incremento por ubicacion
    //E. Plan de calidad:
$section->addTextBreak(1);
$section->addText(utf8_decode('E. Plan de calidad:'), $fontStyle1);
$section->addText(utf8_decode('El contratista elaborará los planes de calidad de acuerdo con lo dispuesto en el Sistema de Gestión de calidad (SGS) vigente de CODENSA S.A. ESP'), $fontStyle_texto, $paragraphOptions);

//F. Plan de Descargos por Maniobras:
$section->addTextBreak(1);
$section->addText(utf8_decode('F. Plan de Descargos por Maniobras:'), $fontStyle1);
$section->addText(utf8_decode('El contratista elaborará su plan de maniobras y descargos para los módulos y activos involucrados en el alcance de esta orden trabajo, el cual será presentado para aprobación y programación de CODENSA S.A. ESP Con una anticipación mínima de 15 días calendario.'), $fontStyle_texto, $paragraphOptions);

    //G. Resumen:
$section->addTextBreak(1);
$section->addText(utf8_decode('G. Resumen:'), $fontStyle1);
            }else{
        
//D. Plan de calidad:
$section->addTextBreak(1);
$section->addText(utf8_decode('D. Plan de calidad:'), $fontStyle1);
$section->addText(utf8_decode('El contratista elaborará los planes de calidad de acuerdo con lo dispuesto en el Sistema de Gestión de calidad (SGS) vigente de CODENSA S.A. ESP'), $fontStyle_texto, $paragraphOptions);

//E. Plan de Descargos por Maniobras:
$section->addTextBreak(1);
$section->addText(utf8_decode('E. Plan de Descargos por Maniobras:'), $fontStyle1);
$section->addText(utf8_decode('El contratista elaborará su plan de maniobras y descargos para los módulos y activos involucrados en el alcance de esta orden trabajo, el cual será presentado para aprobación y programación de CODENSA S.A. ESP Con una anticipación mínima de 15 días calendario.'), $fontStyle_texto, $paragraphOptions);

//F. Resumen:
$section->addTextBreak(1);
$section->addText(utf8_decode('F. Resumen:'), $fontStyle1);

            }
        }
    



// tabla resumen
$PHPWord->addTableStyle('resumen1', $styleTable);
$table_res = $section->addTable('resumen1');
// Add row
$table_res->addRow(1);
// Add cells
$table_res->addCell(1000, $styleTable)->addText(utf8_decode('PEP'), $fontStyle, 'p2Style');
$table_res->addCell(1800, $styleTable)->addText(utf8_decode('No. Orden Presupuestal'), $fontStyle, 'p2Style');
$table_res->addCell(2800, $styleTable)->addText(utf8_decode('Módulo'), $fontStyle, 'p2Style');
$table_res->addCell(2000, $styleTable)->addText('Labor', $fontStyle, 'p2Style');
$table_res->addCell(1000, $styleTable)->addText('Total', $fontStyle, 'p2Style');

$sql5 = "SELECT lb.labor_id,
        tb.tipobaremo_sigla,
        bm.baremo_item,
         md.modulo_descripcion,
         dp.detallepresupuesto_total,
         pt.presupuesto_obs,
         sum(presupuesto_valorporcentaje) as total_actividad,
                 dp.detallepresupuesto_valorincremento,
                 dp.detallepresupuesto_porcentincremento
    FROM pt_presupuesto pt
    JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
    JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
    JOIN cf_modulo md ON pt.modulo_id=md.modulo_id            
    JOIN cf_labor lb ON bm.labor_id=lb.labor_id
    JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
     AND pt.presupuesto_estado=1
     AND pt.detallepresupuesto_id=$det_pret
    GROUP BY 
        pt.presupuesto_obs,
        pt.baremo_id,
        pt.tipobaremo_id,
        pt.detallepresupuesto_id,
        bm.baremo_item,
        tb.tipobaremo_descripcion,
        md.modulo_descripcion";

$resultado5 = $obj_bd->EjecutaConsulta($sql5);

$comb_rows = array('vMerge' => 'restart', 'valign' => 'center');
while ($row5 = $obj_bd->FuncionFetch($resultado5)) {

    $total_pt = $row5['detallepresupuesto_total'];
    $total_inc = $row5['detallepresupuesto_valorincremento'];
    $porc_inc = $row5['detallepresupuesto_porcentincremento'];

    $total_actividad = number_format($row5['total_actividad'], 0, ',', '.');

    $table_res->addRow();
    $table_res->addCell(null, $comb_rows)->addText($ordentrabajo_pep, null, $firmas);
    $table_res->addCell(null, $comb_rows)->addText($ordentrabajo_ordenpresupuestal, null, $firmas);
    $table_res->addCell(2800)->addText($row5['modulo_descripcion'], null, 'p2Style');
    $table_res->addCell(2800)->addText(utf8_encode("Subtotal labores No. " . $row5['tipobaremo_sigla'] . '-' . $row5['baremo_item']), null, 'p2Style');
    $table_res->addCell(1000)->addText("$" . $total_actividad, null, 'p2Style');

    $comb_rows = array('vMerge' => 'continue', 'valign' => 'center');
}

$total_pt_frmt = number_format($total_pt, 0, ',', '.');
$total_inc_frmt = number_format($total_inc, 0, ',', '.');

//Subtotal
$table_res->addRow();
$table_res->addCell(7600, array('gridSpan' => 4))->addText(utf8_encode("Subtotal"), $fontStyle, 'p2Style');
$table_res->addCell(1000)->addText("$" . $total_pt_frmt, $fontStyle, 'p2Style');


/* Incrementos */
$sql_incremento = "SELECT * 
           FROM dt_incremento_presupuesto 
          WHERE detallepresupuesto_id=$det_pret
                    AND incrementopresupuesto_estado=1";
$existe_incremmentos = $obj_bd->Filas($sql_incremento);
if ($existe_incremmentos > 0) {
    $result_incremento = $obj_bd->EjecutaConsulta($sql_incremento);
    while ($row6 = $obj_bd->FuncionFetch($result_incremento)) {

        $tipo_incremento = $row6["incrementopresupuesto_idtipo"];
        if ($tipo_incremento == "1" || $tipo_incremento == 1) {//Actividades de Levantamento incremento por ubicacion
            $ubicacion_porcentaje = $row6["incrementopresupuesto_porcentaje"];
            $ubicacion_valor = $row6["incrementopresupuesto_valor"];
        } else if ($tipo_incremento == "2" || $tipo_incremento == 2) {//Total el Presupuesto - increento por pago a 90 dias
            $dias_porcentaje = $row6["incrementopresupuesto_porcentaje"];
            $dias_valor = $row6["incrementopresupuesto_valor"];
        }
    }
} else {
    $sql_incremento_unico = "select * from dt_detalle_presupuesto WHERE detallepresupuesto_id=" . $det_pret;
    $result_incremento_unico = $obj_bd->EjecutaConsulta($sql_incremento_unico);
    $row_incremento_unico = $obj_bd->FuncionFetch($result_incremento_unico);
    $tipo_incremento = $row_incremento_unico["detallepresupuesto_tipoincremento"];

    if ($tipo_incremento == "1" || $tipo_incremento == 1) {//Actividades de Levantamento incremento por ubicacion
        $ubicacion_porcentaje = $row_incremento_unico["detallepresupuesto_porcentincremento"];
        $ubicacion_valor = $row_incremento_unico["detallepresupuesto_valorincremento"];
    } else if ($tipo_incremento == "2" || $tipo_incremento == 2) {//Total el Presupuesto - increento por pago a 90 dias
        $dias_porcentaje = $row_incremento_unico["detallepresupuesto_porcentincremento"];
        $dias_valor = $row_incremento_unico["detallepresupuesto_valorincremento"];
    }
}


$porcentaje_ubicacion = $ubicacion_porcentaje * 100;
$total_final_ubi = number_format($ubicacion_valor, 0, ',', '.');
$table_res->addRow();
$table_res->addCell(2000, array('gridSpan' => 4))->addText(utf8_decode(/*$porcentaje_ubicacion .*/ "3% Incremento por ubicación"), $fontStyle, 'p2Style');
$table_res->addCell(1000)->addText("$" . $total_final_ubi, $fontStyle, 'p2Style');

$porcentaje_dias = $dias_porcentaje * 100;
$total_final_dias = number_format($dias_valor, 0, ',', '.');
$table_res->addRow();
$table_res->addCell(2000, array('gridSpan' => 4))->addText(utf8_decode(/*$porcentaje_dias .*/ "1.5 % Incremento por pago a 90 días"), $fontStyle, 'p2Style');
$table_res->addCell(1000)->addText("$" . $total_final_dias, $fontStyle, 'p2Style');

/* Fin de incrementos */


//Tottal IVA
/*
  $porcentaje_inc = $porc_inc * 100;
  $table_res->addRow();
  $table_res->addCell(2000, array('gridSpan' => 4))->addText(utf8_encode("Valor IVA " . $porcentaje_inc . "%"), $fontStyle, 'p2Style');
  $table_res->addCell(1000)->addText("$" . $total_inc_frmt, $fontStyle, 'p2Style');
 */

//Total
$total_final = $total_pt + $total_inc;
$total_final_frmt = number_format($total_final, 0, ',', '.');
$table_res->addRow();
$table_res->addCell(2000, array('gridSpan' => 4))->addText(utf8_encode("TOTAL"), $fontStyle, 'p2Style');
$table_res->addCell(1000)->addText("$" . $total_final_frmt, $fontStyle, 'p2Style');

$section->addTextBreak(1);
$fecha_firma = strftime("%d de %B de %Y", strtotime($fecha_emisionOt));
$section->addText(utf8_decode('Para constancia de lo anterior, se firma la presente acta el día ' . $fecha_firma));

$section->addTextBreak(2);
//tabla firmas
$gestor_sql = "SELECT CONCAT(usu.usuario_nombre,' ',usu.usuario_apellidos) AS gestor, dp.detallepresupuesto_codensaGestor
           FROM dt_detalle_presupuesto dp
           JOIN dt_usuario usu ON dp.detallepresupuesto_gestor=usu.usuario_id
           WHERE dp.detallepresupuesto_id=" . $det_pret;



$resultado_gestor = $obj_bd->EjecutaConsulta($gestor_sql);
$data_gestor = $obj_bd->FuncionFetch($resultado_gestor);
//$nombre_gestor= utf8_decode( $data_gestor['gestor']);
$nombre_gestor = utf8_encode(strtolower($data_gestor['gestor']));
$nombre_gestor2 = utf8_encode(strtolower($data_gestor['detallepresupuesto_codensagestor']));



$gestor_sql1 = "SELECT usu.usuario_apellidos AS gestor1
           FROM dt_usuario usu
           WHERE usu.usuario_id =" . $nombre_gestor2;
           

$resultado_gestor1 = $obj_bd->EjecutaConsulta($gestor_sql1);
$data_gestor1 = $obj_bd->FuncionFetch($resultado_gestor1);
//$nombre_gestor= utf8_decode( $data_gestor['gestor']);
$nombre_gestor1 = utf8_encode(strtolower($data_gestor1['gestor1']));



$PHPWord->addTableStyle('firmas', '');
$table_firm = $section->addTable('firmas');
// Add row
$table_firm->addRow(10);
// Add cells
$table_firm->addCell(6000, $styleCell)->addText("_______________________________________\n" .
        utf8_decode("Ing. " . ucwords($nombre_gestor) . "                                    
Gestor de Ingeniería                                       
CODENSA S.A. ESP") . "
", $fontStyle_texto, $firmas);

$table_firm->addCell(2000)->addText("");
$table_firm->addCell(2000)->addText("");

$table_firm->addCell(6000, $styleCell)->addText("_______________________________________\n" .
         utf8_decode("Ing. " . ucwords($nombre_gestor1) . "                                  
         Project Manager                                       
CODENSA S.A ESP") . "", $fontStyle_texto, $firmas);

$table_firm->addRow();
$table_firm->addCell(2000)->addText("");
$table_firm->addCell(2000)->addText("");

$table_firm->addRow();

$table_firm->addCell(6000, $styleCell)->addText("_______________________________________\n" .
        utf8_decode("Ing. Diana Marcela García P                                      
Coordinadora Operativa De Contrato                                       
CODENSA S.A. ESP") . ""
        , $fontStyle_texto, $firmas);

$table_firm->addCell(2000)->addText("");
$table_firm->addCell(2000)->addText("");


$table_firm->addCell(6000)->addText("_______________________________________\n" .
        utf8_decode("Ing. Rodrigo Villamil García                                     
Gestor Administrativo de Contrato                                       
CODENSA S.A ESP") . "", $fontStyle_texto, $firmas);

$table_firm->addRow();
$table_firm->addCell(2000)->addText("");
$table_firm->addCell(2000)->addText("");

$table_firm->addRow();


$table_firm->addCell(6000)->addText("_______________________________________\n" .
        utf8_decode("Ing. Armando Ciendúa C                                      
Director de Proyecto                                           
AC ENERGY S.A.S") . "", $fontStyle_texto, $firmas);


// Save File
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('OT ' . $subestacion . '.docx');
//$objWriter->save('otAprobada.docx');
//$filename = 'otAprobada.docx';
$filename = 'OT ' . $subestacion . '.docx';

$retorno = $filename;

header('Content-Description: File Transfer');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename=' . $retorno);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($retorno));
flush();
readfile($retorno);
unlink($retorno); //
?>