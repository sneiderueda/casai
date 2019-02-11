<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../modelo/MD_fct.php';
$opcion = $_POST['opcion'];
$obj_factura = new MD_fct();



if ($opcion == 'GenerarPeriodoFactura') {
    $retorno = $obj_factura->GenerarPeriodoFactura($_POST);
    echo $retorno;
}
if ($opcion == 'DetalleFacturar') {
    $retorno = $obj_factura->DetalleFacturar($_POST);
    echo $retorno;
}

if ($opcion == 'ListActividadesAfacturar') {
    $retorno = $obj_factura->ListActividadesAfacturar($_POST);
    echo $retorno;
}
if ($opcion == 'SaveActividadNoFacturar') {
    $retorno = $obj_factura->SaveActividadNoFacturar($_POST);
    echo $retorno;
}

if ($opcion == 'SaveFactura') {
    $retorno = $obj_factura->SaveFactura($_POST);
    echo $retorno;
}
if ($opcion == 'ListCerradas') {
    $retorno = $obj_factura->ListCerradas($_POST);
    echo $retorno;
}