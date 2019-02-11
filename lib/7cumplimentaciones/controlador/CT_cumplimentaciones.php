 <?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../modelo/MD_cumplimentaciones.php';

$opcion = $_POST['opcion'];
$obj_cumplimentacion= new MD_cumplimentaciones();

if ($opcion == 'gritCumplimentaciones') {
    $retorno = $obj_cumplimentacion->gritCumplimentaciones($_POST);
    echo $retorno;
}

if ($opcion == 'ListTipDescargo') {
    $retorno = $obj_cumplimentacion->ListTipDescargo($_POST);
    echo $retorno;
}

if ($opcion == 'saveTipoDescargo') {
    $retorno = $obj_cumplimentacion->saveTipoDescargo($_POST);
    echo $retorno;
}

if ($opcion == 'saveCumplimentacion') {
   (string) $retorno = $obj_cumplimentacion->saveCumplimentacion($_POST,$_FILES);
    echo $retorno;
}

if ($opcion == 'JsonDetalleCumplimentacion') {
    $retorno = $obj_cumplimentacion->JsonDetalleCumplimentacion($_POST);
    echo $retorno;
}

if ($opcion == 'editCumplimentacion') {
    $retorno = $obj_cumplimentacion->editCumplimentacion($_POST);
    echo $retorno;
}

if ($opcion == 'ListIngDescargo') {
    $retorno = $obj_cumplimentacion->ListIngDescargo($_POST);
    echo $retorno;
}
