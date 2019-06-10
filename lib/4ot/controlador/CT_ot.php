<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../modelo/MD_ot.php';

$opcion = $_POST['opcion'];
$obj_ot = new MD_ot();


if ($opcion == 'gritPresupuestoOT') {
    $retorno = $obj_ot->gritPresupuestoOT($_POST);
    echo $retorno;
}

if ($opcion == 'gritEjecutarOT') {
    $retorno = $obj_ot->gritEjecutarOT($_POST);
    echo $retorno;
}

if ($opcion == 'ListActividadesPresupuestoOT') {
    $retorno = $obj_ot->ListActividadesPresupuestoOT($_POST);
    echo $retorno;
}
if ($opcion == 'SaveOT') {
     $resultado = $obj_ot->SaveOT($_POST);
    echo $resultado;
}

if ($opcion == 'JsonDetalleOT') {
     $resultado = $obj_ot->JsonDetalleOT($_POST);
    echo $resultado;
}
if ($opcion == 'SaveProgramaOT') {
    $retorno = $obj_ot->SaveProgramaOT($_POST);
    echo $retorno;
}

if ($opcion == 'JsonPresupuesto') {
    $retorno = $obj_ot->JsonPresupuesto($_POST);
    echo $retorno;
}
if ($opcion == 'JsonTecnicosPresupuesto') {
    $retorno = $obj_ot->JsonTecnicosPresupuesto($_POST);
    echo $retorno;
}

if ($opcion == 'SaveSeguimientoAct') {
    $retorno = $obj_ot->SaveSeguimientoAct($_FILES, $_POST);
    echo $retorno;
}
if ($opcion == 'ListSeguimientoPresup') {
    $retorno = $obj_ot->ListSeguimientoPresup($_POST);
    echo $retorno;
}
if ($opcion == 'DeleteSeguimientoActi') {
    $retorno = $obj_ot->DeleteSeguimientoActi($_POST);
    echo $retorno;
}

if ($opcion == 'JsonSeguimiento') {
     $resultado = $obj_ot->JsonSeguimiento($_POST);
    echo $resultado;
}

if ($opcion == 'ListSoporteSeguimiento') {
    $array = array();
    $retorno = $obj_ot->ListSoporteSeguimiento($_POST);
    $i = 0;
    while ($r = mysqli_fetch_array($retorno)) {
        $array[$i]["soporteseguimiento_id"] = $r['soporteseguimiento_id'];
        $array[$i]["soporte_id"] = $r['soporte_id'];
        $array[$i]["soporte_nombre"] = $r['soporte_nombre'];
        $array[$i]["soporte_tipo"] = $r['soporte_tipo'];        
        $i++;
    }
    $datos["datos"] = $array;
    echo json_encode($datos);      
}

if ($opcion == 'DeleteDocSeguimiento') {
    $retorno = $obj_ot->DeleteDocSeguimiento($_POST);
    echo $retorno;
}

if ($opcion == 'UpdateObsDocsSeguimiento') {
    $retorno = $obj_ot->UpdateObsDocsSeguimiento($_FILES, $_POST);
    echo $retorno;
}

if ($opcion == 'SaveDescargo') {
    $retorno = $obj_ot->SaveDescargo($_POST);
    echo $retorno;
}
if ($opcion == 'JsonDescargoOT') {
     $resultado = $obj_ot->JsonDescargoOT($_POST);
    echo $resultado;
}
if ($opcion == 'gritGestionAct') {
    $retorno = $obj_ot->gritGestionAct($_POST);
    echo $retorno;
}
if ($opcion == 'JsonDetalleActividad') {
     $resultado = $obj_ot->JsonDetalleActividad($_POST);
    echo $resultado;
}

if ($opcion == 'SumActividadesLevantaiento') {
     $resultado = $obj_ot->SumActividadesLevantaiento($_POST);
    echo $resultado;
}

if ($opcion == 'SaveIncremento') {
    $retorno = $obj_ot->SaveIncremento($_POST);
    echo $retorno;
}
if ($opcion == 'JsonEncargadosPresupuesto') {
    $retorno = $obj_ot->JsonEncargadosPresupuesto($_POST);
    echo $retorno;
}
if ($opcion == 'ListActividadesReportar') {
    $retorno = $obj_ot->ListActividadesReportar($_POST);
    echo $retorno;
}

if ($opcion == 'SaveSeguimientoBloqueLabores') {
    $retorno = $obj_ot->SaveSeguimientoBloqueLabores($_FILES, $_POST);
    echo $retorno;
}

if ($opcion == 'ValidarArrayPresupuesto') {
    $retorno = $obj_ot->ValidarArrayPresupuesto($_POST);
    echo $retorno;
}

if ($opcion == 'cargar_normas') {
    $retorno = $obj_ot->cargar_normas($_POST);
    echo $retorno;
}

if ($opcion == 'agregar_normas') {
    $retorno = $obj_ot->agregar_normas($_POST);
    echo $retorno;
}

if ($opcion == 'quitar_normas') {
    $retorno = $obj_ot->quitar_normas($_POST);
    echo $retorno;
}

if ($opcion == 'alcancesBaremados') {
    $retorno = $obj_ot->alcancesBaremados($_POST);
    echo $retorno;
}

if ($opcion == 'entregablesBaremados') {
    $retorno = $obj_ot->entregablesBaremados($_POST);
    echo $retorno;
}

if ($opcion == 'normatividad') {
    $retorno = $obj_ot->normatividad($_POST);
    echo $retorno;
}