<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../modelo/MD_presup.php';

$opcion = $_POST['opcion'];
$obj_presup = new MD_presup();



if ($opcion == 'gritPresupuesto') {
    $retorno = $obj_presup->gritPresupuesto($_POST);
    echo $retorno;
}

if ($opcion == 'ListSubestacion') {
    (string) $resultado = $obj_presup->ListSubestacion($_POST);
    echo $resultado;
}

if ($opcion == 'ListContratClien') {
    (string) $resultado = $obj_presup->ListContratClien($_POST);
    echo $resultado;
}

if ($opcion == 'saveSubestacion') {
    (string) $resultado = $obj_presup->saveSubestacion($_POST);
    echo $resultado;
}

if ($opcion == 'SavePresupuesto') {
    (string) $resultado = $obj_presup->SavePresupuesto($_POST);
    echo $resultado;
}


if ($opcion == 'JsonSubestacion') {
    $retorno = $obj_presup->JsonSubestacion($_POST);
    echo $retorno;
    
}

if ($opcion == 'ListModulo') {
    (string) $resultado = $obj_presup->ListModulo($_POST);
    echo $resultado;
}

if ($opcion == 'ListGestor') {
    (string) $resultado = $obj_presup->ListGestor($_POST);
    echo $resultado;
}

if ($opcion == 'ListarPmCodensa') {
    (string) $resultado = $obj_presup->ListarPmCodensa($_POST);
    echo $resultado;
}

if ($opcion == 'dataBaremoItemPresupuesto') {
    $retorno = $obj_presup->dataBaremoItemPresupuesto($_POST);
    echo $retorno;
    
}
if ($opcion == 'SaveActividadPresupuesto') {
    (string) $resultado = $obj_presup->SaveActividadPresupuesto($_POST);
    echo $resultado;
}
if ($opcion == 'DeleteDetallePresupuesto') {
    $retorno = $obj_presup->DeleteDetallePresupuesto($_POST);
    echo $retorno;    
}

if ($opcion == 'JsonDetallePresupuesto') {
    $retorno = $obj_presup->JsonDetallePresupuesto($_POST);
    echo $retorno;    
}

if ($opcion == 'ListActividadesPresupuesto') {
    $retorno = $obj_presup->ListActividadesPresupuesto($_POST);
    echo $retorno;    
}

if ($opcion == 'DeletePresupuestoActividad') {
    $retorno = $obj_presup->DeletePresupuestoActividad($_POST);
    echo $retorno;    
}

if ($opcion == 'JsonDetalleActividad') {
    $retorno = $obj_presup->JsonDetalleActividad($_POST);
    echo $retorno;    
}

if ($opcion == 'UpdateDataBaremoPresupuesto') {
    $retorno = $obj_presup->UpdateDataBaremoPresupuesto($_POST);
    echo $retorno;
    
}
if ($opcion == 'UpdateActividadPresupuesto') {
    (string) $resultado = $obj_presup->UpdateActividadPresupuesto($_POST);
    echo $resultado;
}

if ($opcion == 'UpdateAlcancesPresupuesto') {
    (string) $resultado = $obj_presup->UpdateAlcancesPresupuesto($_POST);
    echo $resultado;
}

if ($opcion == 'UpdateEntregablesPresupuesto') {
    (string) $resultado = $obj_presup->UpdateEntregablesPresupuesto($_POST);
    echo $resultado;
}

if ($opcion == 'ListModuloCopiar') {
    (string) $resultado = $obj_presup->ListModuloCopiar($_POST);
    echo $resultado;
}

if ($opcion == 'CopiLabores') {
    (string) $resultado = $obj_presup->CopiLabores($_POST);
    echo $resultado;
}

if ($opcion == 'JsonDetallePresupuestoIncrementos') {
    $retorno = $obj_presup->JsonDetallePresupuestoIncrementos($_POST);
    echo $retorno;    
}

if ($opcion == 'okcheckbox') {
    $retorno = $obj_presup-> okcheckbox($_POST);
    echo $retorno;
}

if ($opcion == 'calcularIncrementos') {
    $retorno = $obj_presup-> calcularIncrementos($_POST);
    echo $retorno;
}

if ($opcion == 'guardarIncrementos') {
    $retorno = $obj_presup-> guardarIncrementos($_POST);
    echo $retorno;
}

if ($opcion == 'guardarDocumentos') {
    $retorno = $obj_presup-> guardarDocumentos($_POST);
    echo $retorno;
}
