<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../modelo/MD_baremos.php';

$opcion = $_POST['opcion'];
$obj_baremo = new MD_baremos();


if ($opcion == 'gritBaremos') {
    $retorno = $obj_baremo->gritBaremos($_POST);
    echo $retorno;
}

if ($opcion == 'InfoBaremos') {
    $retorno = $obj_baremo->InfoBaremos($_POST);
    echo $retorno;
}

if ($opcion == 'ListTipBaremo') {
    (string) $resultado = $obj_baremo->ListTipBaremo($_POST);
    echo $resultado;
}

if ($opcion == 'SaveLaborBaremo') {
  //  $a_data = json_decode($_POST['data_json'], true);
 //   (string) $resultado = $obj_baremo->SaveLaborBaremo($a_data, $_POST);
    (string) $resultado = $obj_baremo->SaveLaborBaremo($_POST);
    echo $resultado;
}

if ($opcion == 'AddActividadBaremo') {
    (string) $resultado = $obj_baremo->AddActividadBaremo($_POST);
    echo $resultado;
}

if ($opcion == 'gritAlcance') {
    $retorno = $obj_baremo->gritAlcance($_POST);
    echo $retorno;
}

if ($opcion == 'StateUpdateAlcance') {
    $retorno = $obj_baremo->StateUpdateAlcance($_POST);
    echo $retorno;
}

if ($opcion == 'JsonDataAlcance') {
    $retorno = $obj_baremo->JsonDataAlcance($_POST);
    echo $retorno;
}

if ($opcion == 'SaveAlcance') {
    (string) $resultado = $obj_baremo->SaveAlcance($_POST);
    echo $resultado;
}


if ($opcion == 'gritEntregable') {
    $retorno = $obj_baremo->gritEntregable($_POST);
    echo $retorno;
}


if ($opcion == 'StateUpdateEntregable') {
    $retorno = $obj_baremo->StateUpdateEntregable($_POST);
    echo $retorno;
}

if ($opcion == 'JsonDataEntregable') {
    $retorno = $obj_baremo->JsonDataEntregable($_POST);
    echo $retorno;
}

if ($opcion == 'SaveEntregable') {
    (string) $resultado = $obj_baremo->SaveEntregable($_POST);
    echo $resultado;
}

if ($opcion == 'SaveSubactividad') {
    (string) $resultado = $obj_baremo->SaveSubactividad($_POST);
    echo $resultado;
}

if ($opcion == 'JsonBaremoClientTip') {
    $retorno = $obj_baremo->JsonBaremoClientTip($_POST);
    echo $retorno;
}
if ($opcion == 'JsonActividad') {
    $retorno = $obj_baremo->JsonActividad($_POST);
    echo $retorno;
}

if ($opcion == 'JsonValorPorc') {
    $retorno = $obj_baremo->JsonValorPorc($_POST);
    echo $retorno;
}

if ($opcion == 'ListSubactividadesBm') {
    $retorno = $obj_baremo->ListSubactividadesBm($_POST);
    echo $retorno;
}

if ($opcion == 'DeleteSubactividadBaremo') {
    $retorno = $obj_baremo->DeleteSubactividadBaremo($_POST);
    echo $retorno;
}
if ($opcion == 'SelectAlcance') {
    (string) $retorno = $obj_baremo->SelectAlcance($_POST);
    echo $retorno;
}

if ($opcion == 'SelectEntregable') {
    (string) $retorno = $obj_baremo->SelectEntregable($_POST);
    echo $retorno;
}

if ($opcion == 'SaveAlcanceSubactividad') {
    (string) $resultado = $obj_baremo->SaveAlcanceSubactividad($_POST);
    echo $resultado;
}

if ($opcion == 'ListAlcanceSubactividades') {

    $retorno = $obj_baremo->ListAlcanceSubactividades($_POST);
    echo $retorno;
}

if ($opcion == 'DeleteSubactividadAlcance') {
    $retorno = $obj_baremo->DeleteSubactividadAlcance($_POST);
    echo $retorno;
}

if ($opcion == 'ListEntregableSubactividades') {

    $retorno = $obj_baremo->ListEntregableSubactividades($_POST);
    echo $retorno;
}

if ($opcion == 'DeleteSubactividadEntregable') {
    $retorno = $obj_baremo->DeleteSubactividadEntregable($_POST);
    echo $retorno;
}

if ($opcion == 'SaveEntregableSubactividad') {
    (string) $resultado = $obj_baremo->SaveEntregableSubactividad($_POST);
    echo $resultado;
}

if ($opcion == 'ListActividadesBaremo') {

    $retorno = $obj_baremo->ListActividadesBaremo($_POST);
    echo $retorno;
}

if ($opcion == 'DeleteBaremo') {
    $retorno = $obj_baremo->DeleteBaremo($_POST);
    echo $retorno;
}
if ($opcion == 'JsonBaremoId') {
    $retorno = $obj_baremo->JsonBaremoId($_POST);
    echo $retorno;
}
if ($opcion == 'JsonActividadId') {
    $retorno = $obj_baremo->JsonActividadId($_POST);
    echo $retorno;
}

if ($opcion == 'UpdateActividadBaremo') {
    (string) $resultado = $obj_baremo->UpdateActividadBaremo($_POST);
    echo $resultado;
}
if ($opcion == 'DeleteBaremoActividad') {
    $retorno = $obj_baremo->DeleteBaremoActividad($_POST);
    echo $retorno;
}
if ($opcion == 'LsBaremoFiltro') {
    $retorno = $obj_baremo->LsBaremoFiltro($_POST);
    echo $retorno;
}

if ($opcion == 'ListAlcanceAociadosActividad') {

    $retorno = $obj_baremo->ListAlcanceAociadosActividad($_POST);
    echo $retorno;
}

if ($opcion == 'ListEntregablesAociadosActividad') {

    $retorno = $obj_baremo->ListEntregablesAociadosActividad($_POST);
    echo $retorno;
}