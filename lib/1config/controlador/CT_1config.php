<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include '../modelo/MD_1config.php';

$opcion = $_POST['opcion'];
$obj_menu = new MD_1config();

if ($opcion == 'CallMenu') {
    $retorno = $obj_menu->CallMenu();
    echo $retorno; 
}

if ($opcion == 'griModulosSb') {
    $retorno = $obj_menu->griModulosSb($_POST);
    echo $retorno;
}

if ($opcion == 'SaveNewModulo') {
    $retorno = $obj_menu->SaveNewModulo($_POST);
    echo $retorno;
}
if ($opcion == 'SaveModuloSb') {
   (string) $retorno = $obj_menu->SaveModuloSb($_POST);
    echo $retorno;
}

if ($opcion == 'ListTipoModulo') {
    (string) $resultado = $obj_menu->ListTipoModulo();
    echo $resultado;
}
if ($opcion == 'SaveNewTipoModulo') {
   (string) $retorno = $obj_menu->SaveNewTipoModulo($_POST);
    echo $retorno;
}
if ($opcion == 'StateUpdatesubestacionModulo') {
   (string) $retorno = $obj_menu->StateUpdatesubestacionModulo($_POST);
    echo $retorno;
}

if ($opcion == 'DataSubestacionModulos') {
    $retorno = $obj_menu->DataSubestacionModulos($_POST);
    echo $retorno;
}