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


/** 
* @Author: Daniel Rueda
* @Email: sneider.rueda@gmail.com
* @Date: 2019-05-09 
* @Desc:  Agregar registros base de datos para actas
*/

if ($opcion == 'agregar_conciliacion') 
{
    $retorno = $obj_factura->agregar_conciliacion($_POST);
    echo $retorno;
}

if ($opcion == 'actualizar_conciliacion') 
{
    $retorno = $obj_factura->actualizar_conciliacion($_POST);
    echo $retorno;
}

if ($opcion == 'listar_conciliacion') 
{
    $retorno = $obj_factura->listar_conciliacion($_POST);
    echo $retorno;
}

if ($opcion == 'guardar_conformidad') 
{
    $retorno = $obj_factura->guardar_conformidad($_POST);
    echo $retorno;
}
