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
$section = $PHPWord->createSection(array("marginLeft" => 1000, "marginRight" => 1000, "marginTop" => 1000, "marginBottom" => 1000));



//Add footer
//$footer = $section->createFooter();
//$footer->addPreserveText('Page {PAGE} of {NUMPAGES}.', array('align' => 'center'));
// Add header
$header = $section->createHeader();
$table = $header->addTable();
//$pag=$header->addPreserveText('Page {PAGE} of {NUMPAGES}.');
//estilo de letra
$PHPWord->addParagraphStyle('p2Style', array('align' => 'center', 'spaceAfter' => 0));
$fontStyle = array('bold' => true, 'alignment' => 'center', 'align' => 'center');
$fontStyle2 = array('alignment' => 'center');
$fontStyle_header = array('bold' => true, 'align' => 'center', name => 'Verdana', 'size' => 8);
$fontStyle1 = array('bold' => true, 'align' => 'center', 'underline' => 'single');
$styleTable = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 1);
/**/

                            ////////////////////////
                        ///////////////////////////////
                        //  // DATOS ENCABEZADO   // //
                        ///////////////////////////////
                            ////////////////////////
$table->addRow();
$table->addCell(3000, array('vMerge' => 'restart', 'valign' => 'center'))->addImage('../../../img/logo.jpg', array('width' => 85, 'height' => 40, 'align' => 'center', 'valign' => 'center'));
$table->addCell(13000, array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'edefef'))->addText('Orden de trabajo interna', array('bold' => true, 'align' => 'center', name => 'Verdana', 'size' => 10), 'p2Style');

$table->addCell(4000)->addPreserveText(utf8_decode('RG03-IO775          Versión 1             Pagina {PAGE} de {NUMPAGES}         18/07/2017'), $fontStyle_header, 'p2Style');

//table 1
// // Add table
$PHPWord->addTableStyle('Descripcion', $styleTable);
$table = $header->addTable('Descripcion');
// Add row
$table->addRow(1);
// Add cells
$table->addCell(2000, $styleCell)->addText('No. ORDEN INTERNA', $fontStyle, 'p2Style');
$table->addCell(2800, $styleCell)->addText(utf8_decode('FECHA DE EMISIÓN'), $fontStyle, 'p2Style');
$table->addCell(1500, $styleCell)->addText('CLIENTE', $fontStyle, 'p2Style');
$table->addCell(2800, $styleCell)->addText('FECHA DE INICIO', $fontStyle, 'p2Style');
$table->addCell(2000, $styleCell)->addText('S/E', $fontStyle, 'p2Style');
$table->addCell(2000, $styleCell)->addText('PRESUPUESTO', $fontStyle, 'p2Style');


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
$fontStyle_texto = array('name' => 'Arial', 'size' => 10, 'bold' => false, 'align' => 'center', 'borderBottomColor' => '000000');
/**/

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


    $table->addRow();
    $table->addCell(2000)->addText(utf8_encode($row1['ordentrabajo_num']), $fontStyle, 'p2Style');
    // $table_des->addCell(1800)->addText(utf8_encode($row1['ordentrabajo_GOM']));
    $table->addCell(2800)->addText(utf8_encode($row1['ordentrabajo_fechaemision']), $fontStyle2, 'p2Style');
    $table->addCell(1500)->addText(utf8_encode($row1['cliente_descripcion']), $fontStyle2, 'p2Style');
    $table->addCell(2800)->addText(utf8_encode($row1['ordentrabajo_fechaini']), $fontStyle2, 'p2Style');
    $table->addCell(2000)->addText($row1['subestacion_nombre'], $fontStyle2, 'p2Style');
    $table->addCell(2000)->addText("$" . number_format($total_final_OT, 0, ',', '.') . " Antes de IVA", $fontStyle, 'p2Style');

}
// $header->addTextBreak(1);


                            /////////////////////
                         ///////////////////////////
                         // // DATOS DOCUMENTO // //
                         ///////////////////////////
                            /////////////////////

///////////////////
// TABLA RESUMEN //
///////////////////
$section->addTextBreak(1);
$section->addText(utf8_decode('RESUMEN: '), $fontStyle);
$section->addTextBreak(1);


$PHPWord->addTableStyle('resumen1', $styleTable);
$table_resumen = $section->addTable('resumen1');



// Add row
$table_resumen->addRow(1);

// Add cells
$table_resumen->addCell(2000, $styleTable)->addText(utf8_decode('Módulo'), $fontStyle, 'p2Style');
$table_resumen->addCell(1000, $styleTable)->addText('Labor', $fontStyle, 'p2Style');
$table_resumen->addCell(2000, $styleTable)->addText(utf8_decode('Jefe Cuadrilla'), $fontStyle, 'p2Style');
$table_resumen->addCell(2000, $styleTable)->addText(utf8_decode('Cuadrilla'), $fontStyle, 'p2Style');
$table_resumen->addCell(2000, $styleTable)->addText(utf8_decode('Fecha Inicio'), $fontStyle, 'p2Style');
$table_resumen->addCell(2000, $styleTable)->addText(utf8_decode('Fecha Fin'), $fontStyle, 'p2Style');
// $table_resumen->addCell(1000, $styleTable)->addText('Total', $fontStyle, 'p2Style');
$table_resumen->addCell(500, $styleTable)->addText('Ejecutado', $fontStyle, 'p2Style');

$sql5 = "SELECT lb.labor_id,
            tb.tipobaremo_sigla,
            bm.baremo_item,
            md.modulo_id,
            md.modulo_descripcion,
            dp.detallepresupuesto_total,
            pt.presupuesto_obs,
            pt.presupuesto_id,
            pt.tipobaremo_id,
            pt.presupuesto_encargado,
            pt.baremo_id,
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
            pt.baremo_id,
            pt.presupuesto_obs,
            pt.tipobaremo_id,
            pt.detallepresupuesto_id,
            bm.baremo_item,
            tb.tipobaremo_descripcion,
            md.modulo_descripcion";

$comb_rows = array('vMerge' => 'restart', 'valign' => 'center');

$resultado5 = $obj_bd->EjecutaConsulta($sql5);
while ($row5 = $obj_bd->FuncionFetch($resultado5)) {

    $total_pt = $row5['detallepresupuesto_total'];
    $total_inc = $row5['detallepresupuesto_valorincremento'];
    $porc_inc = $row5['detallepresupuesto_porcentincremento'];

    $total_actividad = number_format($row5['total_actividad'], 0, ',', '.');


    //tabla de actividades
    $sql4 = "SELECT 
                pt.presupuesto_porcentaje as cantidad,
                ac.actividad_valorservicio,
                pt.presupuesto_valorporcentaje as valorporcentaje,
                pt.presupuesto_id,
                pt.baremoactividad_id, 
                pt.presupuesto_alcances,
                pt.presupuesto_fechaini,
                pt.presupuesto_fechafin,                   
                bm.baremo_item,
                bm.baremo_id,
                tb.tipobaremo_sigla,
                ac.actividad_id,
                ac.actividad_descripcion,
                pt.presupuesto_obs,
                sb.subactividad_descripcion,
                pt.presupuesto_encargado,
                pt.presupuesto_asignadopor,
                pt.presupuesto_valorporcentaje,
                pt.area_id,
                ac.actividad_GOM          
            FROM pt_presupuesto pt
            JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
            JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
            JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
            JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
            JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
            JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
            AND pt.baremo_id=" . $row5['baremo_id'] . "
            AND pt.tipobaremo_id=" . $row5['tipobaremo_id'] . "
            AND pt.modulo_id=" . $row5['modulo_id'] . "
            AND bm.baremo_estado=1
            AND pt.detallepresupuesto_id=$det_pret
            AND pt.presupuesto_estado=1            
            ";
    
    $resultado4 = $obj_bd->EjecutaConsulta($sql4);
    $cantidad = 0;

        
    while ($row4 = $obj_bd->FuncionFetch($resultado4)) {

        if ($row4['cantidad'] != 0) {

            $subactividad = utf8_encode($row4['subactividad_descripcion']);

            $extrae = substr($subactividad,0,3);

            $table_resumen->addRow();
            $table_resumen->addCell(2000)->addText($row5['modulo_descripcion'], null, 'p2Style');
            $table_resumen->addCell(1000)->addText($row4['actividad_gom'] ."\n". $extrae.".", null, 'p2Style');


            ///////////////////////////////////
            // CONSULTA EL JEFE DE CUADRILLA //
            ///////////////////////////////////
            $sql_jefe = "SELECT concat(usu.usuario_nombre,' ',usu.usuario_apellidos) as nombre
                        from dt_usuario usu
                        join pt_perfil_usuario pu on usu.usuario_id = pu.usuario_id
                        and perfilusuario_id = ".$row4['presupuesto_encargado'].";";

            $res_jefe = $obj_bd->EjecutaConsulta($sql_jefe);
            $row_jefe = $obj_bd->FuncionFetch($res_jefe);


            $table_resumen->addCell(2000)->addText($row_jefe['nombre'], $fontStyle_texto, 'p2Style');


            //////////////////////////////////////
            // CONSULTA EL PERSONAL INVILUCRADO //
            //////////////////////////////////////
            $sql_per = "SELECT concat(usu.usuario_nombre,' ',usu.usuario_apellidos) as nombre
                        from cf_tecnico_presupuesto tp
                        join pt_perfil_usuario pu on tp.perfilusuario_id = pu.perfilusuario_id
                        join dt_usuario usu on pu.usuario_id = usu.usuario_id 
                        where presupuesto_id = ".$row4['presupuesto_id'].";";

            $res_per = $obj_bd->EjecutaConsulta($sql_per);
            
            $i = 0;
            while ($row_per = $obj_bd->FuncionFetch($res_per)){
                foreach ($row_per as $key ) {
                    $nom[$i] = $key;
                }$i++;
            }

            $nombre = implode(' / ', $nom);
            $table_resumen->addCell(2000)->addText($nombre, $fontStyle_texto, 'p2Style');
            //$table_act->addCell(1000)->addText(utf8_encode($row4['cantidad']), $fontStyle_texto, $paragraphOptions); -- alinear a la izquierda $paragraphOptions
            unset($nom);


            $table_resumen->addCell(2000)->addText($row4['presupuesto_fechaini'] , $fontStyle_texto, 'p2Style');
            $table_resumen->addCell(2000)->addText($row4['presupuesto_fechafin'], $fontStyle_texto, 'p2Style');

        }
    }
}

$section->addTextBreak(2);

$PHPWord->addTableStyle('alcance', $styleTable);
$table_res = $section->addTable('alcance');

// Add row
$table_res->addRow();

$sql_ante = "CALL SP_dtanterioresot('3','','','','','','','','" . $det_pret . "');";

$res_ante = $obj_bd->EjecutaConsulta($sql_ante);
$anterior = $obj_bd->FuncionFetch($res_ante);

if ($anterior) {

    // Add cells
    $table_res->addCell(4000, array('gridSpan' => 2))->addText("Existe una orden de trabajo anterior asociada con el alcance de esta OT                       SI X  NO _", $fontStyle_texto, $paragraphOptions);
    $section->addTextBreak(1);

    $table_res->addRow();
    $table_res->addCell(3000)->addText(trim('No. Orden de trabajo: '), $fontStyle_texto, $paragraphOptions);
    $table_res->addCell(12000)->addText(utf8_encode($anterior['anterioresot_descripcion']), $fontStyle_texto, $paragraphOptions);

    $table_res->addRow();
    $table_res->addCell(3000)->addText(trim(utf8_decode('Empresa Colaboradora: ')), $fontStyle_texto, $paragraphOptions);
    $table_res->addCell(12000)->addText(trim(' AC ENERGY S.A.S.'), $fontStyle_texto, $paragraphOptions);
   
}else{
    // Add cells
    $table_res->addCell(4000, array('gridSpan' => 2))->addText("Existe una orden de trabajo anterior asociada con el alcance de esta OT                       SI _  NO X", $fontStyle_texto, $paragraphOptions);
    $section->addTextBreak(1);

    $table_res->addRow();
    $table_res->addCell(3000)->addText(trim('No. Orden de trabajo: '), $fontStyle_texto, $paragraphOptions);
    $table_res->addCell(12000)->addText('', $fontStyle_texto, $paragraphOptions);

    $table_res->addRow();
    $table_res->addCell(3000)->addText(trim(utf8_decode('Empresa Colaboradora: ')), $fontStyle_texto, $paragraphOptions);
    $table_res->addCell(12000)->addText(trim(' AC ENERGY S.A.S.'), $fontStyle_texto, $paragraphOptions);
    
}
$section->addPageBreak();

////////////////////////////////
// DETALLE DE LAS ACTIVIDADES //
////////////////////////////////



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
        JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
        JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
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

    ///////////
    //objeto //
    ///////////
    $section->addText('OBJETO: ', $fontStyle, $paragraphOptions);
    $section->addText(utf8_decode($objeto), $fontStyle_texto, $paragraphOptions);
    $section->addTextBreak();

    ////////////
    //alcance //
    ////////////
    $styleCel2 = array('valign' => 'left');
    $section->addText('ALCANCE: ', $fontStyle);

    $alcance = explode(". ", $alcance);
    foreach ($alcance as $line) {
        $section->addText(utf8_decode($line), $fontStyle_texto, $paragraphOptions);
    }
    $section->addTextBreak();

    $section->addText(utf8_decode('Módulo: '), $fontStyle, $paragraphOptions);
    $section->addText($row3['modulo_descripcion'], $fontStyle_texto);

    $section->addText(utf8_decode('Actividad: '), $fontStyle, $paragraphOptions);
    $lb_descripcion = utf8_encode($row3['labor_descripcion']);
    $section->addText($row3['tipobaremo_sigla'] . '-' . $row3['baremo_item'] . " " . utf8_decode($lb_descripcion) . " - UNIDAD DE MEDIDA " . utf8_decode($row3['labor_unidmedida']), $fontStyle_texto);

    //////////////////////
    //TABLA  ACTIVIDADES//
    //////////////////////
    $PHPWord->addTableStyle('Actividad' . $row3['modulo_id'], $styleTableRa, $styleFirstRowRa1);
    $table_act = $section->addTable('Actividad' . $row3['modulo_id']);
    
    // Add row
    $table_act->addRow();
    
    // Add cells
    $table_act->addCell(2000, $styleCell)->addText(utf8_decode('Actividad'), $fontStyle, 'p2Style');
    $table_act->addCell(2000, $styleCell)->addText(utf8_decode('Código/ Área'), $fontStyle, 'p2Style');
    $table_act->addCell(2000, $styleCell)->addText(utf8_decode('Subactividad'), $fontStyle, 'p2Style');
    $table_act->addCell(1000, $styleCell)->addText('Cant.', $fontStyle, 'p2Style');
    $table_act->addCell(2000, $styleCell)->addText(utf8_decode('Líder Cuadrilla'), $fontStyle, 'p2Style');
    $table_act->addCell(5000, $styleCell)->addText(utf8_decode('Cuadrilla'), $fontStyle, 'p2Style');

    //tabla de actividades
    $sql4 = "SELECT 
                pt.presupuesto_porcentaje as cantidad,
                ac.actividad_valorservicio,
                pt.presupuesto_valorporcentaje as valorporcentaje,
                pt.presupuesto_id,
                pt.baremoactividad_id, 
                pt.presupuesto_alcances,
                pt.presupuesto_fechaini,
                pt.presupuesto_fechafin,              
                bm.baremo_item,
                bm.baremo_id,
                tb.tipobaremo_sigla,
                ac.actividad_id,
                ac.actividad_descripcion,
                pt.presupuesto_obs,
                sb.subactividad_descripcion,
                pt.presupuesto_encargado,
                pt.presupuesto_asignadopor,
                pt.area_id,
                ac.actividad_GOM          
            FROM pt_presupuesto pt
            JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
            JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
            JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
            JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
            JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
            JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
            AND pt.baremo_id=" . $row3['baremo_id'] . "
            AND pt.tipobaremo_id=" . $row3['tipobaremo_id'] . "
            AND pt.modulo_id=" . $row3['modulo_id'] . "
            AND bm.baremo_estado=1
            AND pt.detallepresupuesto_id=$det_pret
            AND pt.presupuesto_estado=1            
            ";
    
    $resultado4 = $obj_bd->EjecutaConsulta($sql4);
    $cantidad = 0;

        
    while ($row4 = $obj_bd->FuncionFetch($resultado4)) {

        if ($row4['cantidad'] != 0) {

            $cantidad = $row4['cantidad'];

            if($cantidad == ""){
                $cantidad = 0;            
            }

            $table_act->addRow();
            $actividad = utf8_encode($row4['actividad_descripcion']);
            $table_act->addCell(2000, array('valign' => 'center'))->addText(utf8_decode($actividad), $fontStyle_texto, 'p2Style');
            
            $table_act->addCell(2000, $styleCell)->addText(utf8_decode($row4['actividad_gom']), $fontStyle_texto, 'p2Style');

            $subactividad = utf8_encode($row4['subactividad_descripcion']);
            $table_act->addCell(2000, array('valign' => 'center'))->addText(utf8_decode($subactividad), $fontStyle_texto, 'p2Style');

            $table_act->addCell(1000, array('valign' => 'center'))->addText($cantidad, $fontStyle_texto, 'p2Style');

            ///////////////////////////////////
            // CONSULTA EL JEFE DE CUADRILLA //
            ///////////////////////////////////
            $sql_jefe = "SELECT concat(usu.usuario_nombre,' ',usu.usuario_apellidos) as nombre
                        from dt_usuario usu
                        join pt_perfil_usuario pu on usu.usuario_id = pu.usuario_id
                        and perfilusuario_id = ".$row4['presupuesto_encargado'].";";

            $res_jefe = $obj_bd->EjecutaConsulta($sql_jefe);
            $row_jefe = $obj_bd->FuncionFetch($res_jefe);

            $table_act->addCell(2000)->addText($row_jefe['nombre'], $fontStyle_texto, 'p2Style');


            //////////////////////////////////////
            // CONSULTA EL PERSONAL INVILUCRADO //
            //////////////////////////////////////
            $sql_per = "SELECT concat(usu.usuario_nombre,' ',usu.usuario_apellidos) as nombre
                        from cf_tecnico_presupuesto tp
                        join pt_perfil_usuario pu on tp.perfilusuario_id = pu.perfilusuario_id
                        join dt_usuario usu on pu.usuario_id = usu.usuario_id 
                        where presupuesto_id = ".$row4['presupuesto_id'].";";

            $res_per = $obj_bd->EjecutaConsulta($sql_per);
            
            $i = 0;
            while ($row_per = $obj_bd->FuncionFetch($res_per)){
                foreach ($row_per as $key ) {
                    $nom[$i] = $key;
                }$i++;
            }

            $nombre = implode(' / ', $nom);
            $table_act->addCell(1000)->addText($nombre, $fontStyle_texto, 'p2Style');
            //$table_act->addCell(1000)->addText(utf8_encode($row4['cantidad']), $fontStyle_texto, $paragraphOptions); -- alinear a la izquierda $paragraphOptions
            unset($nom);

            


            //////////////////
            // FECHAS LABOR //
            //////////////////
            $table_act->addRow();
            $table_act->addCell(4600, $styleFirstRow1)->addText(utf8_decode("Fecha Inicio:  "), $fontStyle, 'p2Style');
            $table_act->addCell(2000, array('gridSpan' => 2, 'bgColor' => 'c5c5c5'))->addText($row4['presupuesto_fechaini'], $fontStyle, 'p2Style');

            $table_act->addCell(4600, $styleFirstRow1)->addText(utf8_decode("Fecha Fin:  "), $fontStyle, 'p2Style');
            $table_act->addCell(2000, array('gridSpan' => 2, 'bgColor' => 'c5c5c5'))->addText($row4['presupuesto_fechafin'], $fontStyle, 'p2Style');


            //////////////////////////
            // CONSULTA COORDINADOR //
            //////////////////////////
            $sql_coor = "SELECT concat(usu.usuario_nombre,' ',usu.usuario_apellidos) as nombre
                        from dt_usuario usu
                        join pt_perfil_usuario pu on usu.usuario_id = pu.usuario_id
                        and perfilusuario_id = ".$row4['presupuesto_asignadopor'].";";

            $res_coor = $obj_bd->EjecutaConsulta($sql_coor);
            $row_coor = $obj_bd->FuncionFetch($res_coor);

            $table_act->addRow();
            $table_act->addCell(4600, $styleFirstRow1)->addText(utf8_decode("Coordinador de Área:  "), $fontStyle, 'p2Style');
            $table_act->addCell(2000, array('gridSpan' => 5, 'bgColor' => 'c5c5c5','color'=>'FFFFFF'))->addText($row_coor['nombre'], $fontStyle, 'p2Style');

          

        }
    }

    ///////////////////
    // OBSERVACIONES //
    ///////////////////

    $section->addTextBreak(1);

    //Observaciones, y/o Aclaraciones y/o  Lineamientos:
    $section->addText(utf8_decode('ALCANCE PARTICULAR DEL CLIENTE: '), $fontStyle);
    $obs = utf8_encode($row3['presupuesto_obs']);
    $section->addText(utf8_decode($obs), $fontStyle_texto, $paragraphOptions);
    $section->addTextBreak(1);
    
    //////////////////////
    // ALCANCE BAREMADO //
    //////////////////////

    $sql4 = "SELECT 
                pt.presupuesto_porcentaje as cantidad,
                ac.actividad_valorservicio,
                pt.presupuesto_valorporcentaje as valorporcentaje,
                pt.presupuesto_id,
                pt.presupuesto_alcances,
                pt.presupuesto_entregables,
                pt.baremoactividad_id, 
                pt.presupuesto_alcances,                 
                bm.baremo_item,
                bm.baremo_id,
                tb.tipobaremo_sigla,
                ac.actividad_id,
                ac.actividad_descripcion,
                pt.presupuesto_obs,
                sb.subactividad_descripcion,
                pt.presupuesto_encargado,
                pt.presupuesto_asignadopor,
                pt.area_id,
                ac.actividad_GOM          
            FROM pt_presupuesto pt
            JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
            JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
            JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
            JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
            JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
            JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
            AND pt.baremo_id=" . $row3['baremo_id'] . "
            AND pt.tipobaremo_id=" . $row3['tipobaremo_id'] . "
            AND pt.modulo_id=" . $row3['modulo_id'] . "
            AND bm.baremo_estado=1
            AND pt.detallepresupuesto_id=$det_pret
            AND pt.presupuesto_estado=1            
            ";
    
    $resultado4 = $obj_bd->EjecutaConsulta($sql4);
    
    $section->addTextBreak();
    $section->addText(utf8_decode('ALCANCES BAREMADOS: '), $fontStyle);
        
    while ($row4 = $obj_bd->FuncionFetch($resultado4)) {

        if ($row4['cantidad'] != 0) {

            
            $alcan = explode(',',$row4['presupuesto_alcances']);

            foreach ($alcan as $key => $value) {
                
                $sql_alcance = "SELECT alcance_descripcion
                                FROM cf_alcance
                                WHERE alcance_id = ".$value.";";

                $res_alcance = $obj_bd->EjecutaConsulta($sql_alcance);
                $alcance = $obj_bd->FuncionFetch($res_alcance);

                $alcance1 = $alcance['alcance_descripcion'];

                if ($alcance == ''){
                    $alcance1 = 'No aplica';
                } 


                $section->addText('-' . $row4['actividad_gom'] . '. '. $row4['subactividad_descripcion'] .' -> '. $alcance1 , $fontStyle_texto, $paragraphOptions);
            }
            unset($value);
        }
    }


    ///////////////////////////
    // ENTREGABLES BAREMADOS //
    ///////////////////////////

    $sql4 = "SELECT 
                pt.presupuesto_porcentaje as cantidad,
                ac.actividad_valorservicio,
                pt.presupuesto_valorporcentaje as valorporcentaje,
                pt.presupuesto_id,
                pt.presupuesto_alcances,
                pt.presupuesto_entregables,
                pt.baremoactividad_id, 
                pt.presupuesto_alcances,                 
                bm.baremo_item,
                bm.baremo_id,
                tb.tipobaremo_sigla,
                ac.actividad_id,
                ac.actividad_descripcion,
                pt.presupuesto_obs,
                sb.subactividad_descripcion,
                pt.presupuesto_encargado,
                pt.presupuesto_asignadopor,
                pt.area_id,
                ac.actividad_GOM          
            FROM pt_presupuesto pt
            JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
            JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
            JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
            JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
            JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
            JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
            AND pt.baremo_id=" . $row3['baremo_id'] . "
            AND pt.tipobaremo_id=" . $row3['tipobaremo_id'] . "
            AND pt.modulo_id=" . $row3['modulo_id'] . "
            AND bm.baremo_estado=1
            AND pt.detallepresupuesto_id=$det_pret
            AND pt.presupuesto_estado=1            
            ";
    
    $resultado4 = $obj_bd->EjecutaConsulta($sql4);
    
    $section->addTextBreak();
    $section->addText(utf8_decode('ENTREGABLES BAREMADOS: '), $fontStyle);
        
    while ($row4 = $obj_bd->FuncionFetch($resultado4)) {

        if ($row4['cantidad'] != 0) {
            
            $entre = explode(',',$row4['presupuesto_entregables']);

            foreach ($entre as $key => $value) {
                
                $sql_entre = "SELECT entregable_descripcion
                                FROM cf_entregable
                                WHERE entregable_id = ".$value.";";

                $res_entre = $obj_bd->EjecutaConsulta($sql_entre);
                $entre = $obj_bd->FuncionFetch($res_entre);

                $entre1 = $entre['entregable_descripcion'];

                if ($entre == ''){
                    $entre1 = 'No aplica';
                } 


                $section->addText('-' . $row4['actividad_gom'] . '. '. $row4['subactividad_descripcion'] .' -> '. $entre1 , $fontStyle_texto, $paragraphOptions);
            }
            unset($value);
        }
    }


    ///////////////////////////////
    // OBSERVACIONES COORDINADOR //
    ///////////////////////////////
    
    $sql4 = "SELECT 
                pt.presupuesto_porcentaje as cantidad,
                ac.actividad_valorservicio,
                pt.presupuesto_valorporcentaje as valorporcentaje,
                pt.presupuesto_id,
                pt.presupuesto_alcances,
                pt.presupuesto_entregables,
                pt.presupuesto_programacion_obs,
                pt.baremoactividad_id, 
                pt.presupuesto_alcances,                 
                bm.baremo_item,
                bm.baremo_id,
                tb.tipobaremo_sigla,
                ac.actividad_id,
                ac.actividad_descripcion,
                pt.presupuesto_obs,
                sb.subactividad_descripcion,
                pt.presupuesto_encargado,
                pt.presupuesto_asignadopor,
                pt.area_id,
                ac.actividad_GOM          
            FROM pt_presupuesto pt
            JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
            JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
            JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
            JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
            JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
            JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
            AND pt.baremo_id=" . $row3['baremo_id'] . "
            AND pt.tipobaremo_id=" . $row3['tipobaremo_id'] . "
            AND pt.modulo_id=" . $row3['modulo_id'] . "
            AND bm.baremo_estado=1
            AND pt.detallepresupuesto_id=$det_pret
            AND pt.presupuesto_estado=1            
            ";
    
    $resultado4 = $obj_bd->EjecutaConsulta($sql4);
    
    $section->addTextBreak();
    $section->addText(utf8_decode('OBSERVACIONES COORDINADOR: '), $fontStyle);
        
    while ($row4 = $obj_bd->FuncionFetch($resultado4)) {

        if ($row4['cantidad'] != 0) {
            
            $obser = $row4['presupuesto_programacion_obs'];

            if ($obser == ''){
                $obser = 'No aplica';
            } 


            $section->addText('-' . $row4['actividad_gom'] . '. '. $row4['subactividad_descripcion'] .' -> '. $obser , $fontStyle_texto, $paragraphOptions);
        }
    }


    //////////////////
    // NORMATIVIDAD //
    //////////////////

    $sql4 = "SELECT 
                pt.presupuesto_porcentaje as cantidad,
                ac.actividad_valorservicio,
                pt.presupuesto_valorporcentaje as valorporcentaje,
                pt.presupuesto_id,
                pt.presupuesto_alcances,
                pt.presupuesto_entregables,
                pt.presupuesto_programacion_obs,
                pt.baremoactividad_id, 
                pt.presupuesto_alcances,                 
                bm.baremo_item,
                bm.baremo_id,
                tb.tipobaremo_sigla,
                ac.actividad_id,
                ac.actividad_descripcion,
                pt.presupuesto_obs,
                sb.subactividad_descripcion,
                pt.presupuesto_encargado,
                pt.presupuesto_asignadopor,
                pt.area_id,
                ac.actividad_GOM          
            FROM pt_presupuesto pt
            JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
            JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
            JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
            JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
            JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
            JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
            AND pt.baremo_id=" . $row3['baremo_id'] . "
            AND pt.tipobaremo_id=" . $row3['tipobaremo_id'] . "
            AND pt.modulo_id=" . $row3['modulo_id'] . "
            AND bm.baremo_estado=1
            AND pt.detallepresupuesto_id=$det_pret
            AND pt.presupuesto_estado=1            
            ";
    
    $resultado4 = $obj_bd->EjecutaConsulta($sql4);
    
    $section->addTextBreak();
    $section->addText(utf8_decode('NORMATIVIDAD: '), $fontStyle);

    while ($row4 = $obj_bd->FuncionFetch($resultado4)) {

        if ($row4['cantidad'] != 0) {

            $sql_norma_con = "CALL SP_cfnormas('4','','".$row4['presupuesto_id']."','','','','','');";
            $res_norma_con = $obj_bd->EjecutaConsulta($sql_norma_con);
            
            while($row_norma_con = $obj_bd->FuncionFetch($res_norma_con)){

                $norma = $row_norma_con['normas_descripcion'];

                if ($norma == ''){
                    $norma = 'No aplica';
                } 

                $section->addText('-' . $row4['actividad_gom'] . '. '. $row4['subactividad_descripcion'] .' -> '. $norma , $fontStyle_texto, $paragraphOptions);                
            }
        }
    }    


    $dia = date("d");
    $mes = date("m");
    $año = date("Y");
    $section->addTextBreak();
    $section->addTextBreak();

    $fecha_firma = strftime("%d de %B de %Y", strtotime($fecha_emisionOt));
    $section->addText(utf8_decode('Para constancia de lo anterior, se firma la presente el día ' . $dia . ' del mes '.$mes. ' del año '. $año));

    $section->addTextBreak(2);


    //////////////////
    // TABLA FIRMAS //
    //////////////////
    $PHPWord->addTableStyle('firmas', '');
    $table_firm = $section->addTable('firmas');
    // Add row
    $table_firm->addRow(10);
    // Add cells
    $table_firm->addCell(6000, $styleCell)->addText("_______________________________________\n" .
            utf8_decode("RESPONSABLE CUADRILLA") . "
    ", $fontStyle_texto, $firmas);

    $table_firm->addCell(2000)->addText("");
    $table_firm->addCell(2000)->addText("");

    $table_firm->addCell(6000, $styleCell)->addText("_______________________________________\n" .
             utf8_decode("COORDINADOR AREA CIVIL") . "", $fontStyle_texto, $firmas);

    $table_firm->addRow();
    $table_firm->addCell(2000)->addText("");
    $table_firm->addCell(2000)->addText("");

    $table_firm->addRow();
    $table_firm->addCell(2000)->addText("");
    $table_firm->addCell(2000)->addText("");

    $table_firm->addRow();
    $table_firm->addCell(2000)->addText("");
    $table_firm->addCell(2000)->addText("");

    $table_firm->addRow();

    $table_firm->addCell(6000, $styleCell)->addText("_______________________________________\n" .
            utf8_decode("COORDINADOR AREA ELÉCTRICA") . ""
            , $fontStyle_texto, $firmas);

    $table_firm->addCell(2000)->addText("");
    $table_firm->addCell(2000)->addText("");


    $table_firm->addCell(6000)->addText("_______________________________________\n" .
            utf8_decode("COORDINADOR AREA MECÁNICA") . "", $fontStyle_texto, $firmas);

    $table_firm->addRow();
    $table_firm->addCell(2000)->addText("");
    $table_firm->addCell(2000)->addText("");

    $table_firm->addRow();
    $table_firm->addCell(2000)->addText("");
    $table_firm->addCell(2000)->addText("");

    $table_firm->addRow();
    $table_firm->addCell(2000)->addText("");
    $table_firm->addCell(2000)->addText("");

    $table_firm->addRow();


    $table_firm->addCell(6000)->addText("_______________________________________\n" .
            utf8_decode("SUPERVISOR DE REVISIÓN") . "", $fontStyle_texto, $firmas);

    $section->addPageBreak();
}



///////////////
// SAVE FILE //
///////////////
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