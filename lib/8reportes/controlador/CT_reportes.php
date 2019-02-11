<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../modelo/MD_reporte.php';

$opcion = $_POST['opcion'];
$obj_reporte = new MD_reporte();

if ($opcion == 'td_resumenAsignadasLb') {
    $retorno = $obj_reporte->td_resumenAsignadasLb($_POST);
    echo $retorno;
}

if ($opcion == 'DataDetalleLabores') {
    $retorno = $obj_reporte->DataDetalleLabores($_POST);
    echo $retorno;
}
if ($opcion == 'GfLaboresArea') {
    $retorno = $obj_reporte->GfLaboresArea($_POST);
    echo $retorno;
}
if ($opcion == 'ValorFacturaLabores') {
    $retorno = $obj_reporte->ValorFacturaLabores($_POST);
    echo $retorno;
}
if ($opcion == 'seguimientoCalendario') {
    $retorno = $obj_reporte->seguimientoCalendario();
    echo $retorno;
}
if ($opcion == 'VistaSeguimientoCalendario') {    
    $retorno = $obj_reporte->VistaSeguimientoCalendario($_POST);
    echo $retorno;
}