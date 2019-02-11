<?php

/* 
Autir:jennifer.cabiativa@gmail.com
 */

include '../modelo/MD_2usuario.php';
include '../../0connection/BD_config.php';
$opcion = $_POST['opcion'];
$obj_2usuario = new MD_2usuario();

if ($opcion == 'recuperarPass') {
    $retorno = $obj_2usuario->recuperarPass($_POST);
    echo $retorno;
}

if ($opcion == 'Log') {
    $retorno = $obj_2usuario->Login($_POST);
    echo $retorno;
}

if ($opcion == 'ChangeSession') {
    $retorno = $obj_2usuario->ChangeSession($_POST);
    echo $retorno;
}

if ($opcion == 'DataProfileUser') {
    $retorno = $obj_2usuario->DataProfileUser($_POST);
    echo $retorno;
}

if ($opcion == 'gritusuario') {
    $retorno = $obj_2usuario->gritusuario($_POST);
    echo $retorno;
}

if ($opcion == 'StateUpdate') {
    $retorno = $obj_2usuario->StateUpdate($_POST);
    echo $retorno;
}

if ($opcion == 'saveUser') {   
    (string) $resultado = $obj_2usuario->saveUser($_POST);
    echo $resultado;
}
    
if ($opcion == 'JsonDataUser') {
    $retorno = $obj_2usuario->JsonDataUser($_POST);
    echo $retorno;
}

if ($opcion == 'ValidaMailUser') {
    $retorno = $obj_2usuario->ValidaMailUser($_POST);
    echo $retorno;
}

if ($opcion == 'gritClient') {
    $retorno = $obj_2usuario->gritClient($_POST);
    echo $retorno;
}

if ($opcion == 'JsonPermission') {
    $retorno = $obj_2usuario->JsonPermission($_POST);
    echo $retorno;
}

if ($opcion == 'ListProfile') {
    (string) $resultado = $obj_2usuario->ListProfile($_POST);
    echo $resultado;
}
if ($opcion == 'DeleteAreaUser') {
    $retorno = $obj_2usuario->DeleteAreaUser($_POST);
    echo $retorno;
}

if ($opcion == 'DeleteProfileAreaUser') {
    $retorno = $obj_2usuario->DeleteProfileAreaUser($_POST);
    echo $retorno;
}

if ($opcion == 'ListArea') {
    (string) $resultado = $obj_2usuario->ListArea($_POST);
    echo $resultado;
}

if ($opcion == 'EditUserPermission') {
    $retorno = $obj_2usuario->EditUserPermission($_POST);
    echo $retorno;
}

if ($opcion == 'saveClient') {    
    //$a_data = json_decode($_POST['data_json'], true);
    (string) $resultado = $obj_2usuario->saveClient($_POST);
    echo $resultado;
}

if ($opcion == 'JsonDataClient') {
    $retorno = $obj_2usuario->JsonDataClient($_POST);
    echo $retorno;
}

if ($opcion == 'StateUpdateClient') {
    $retorno = $obj_2usuario->StateUpdateClient($_POST);
    echo $retorno;
}

if ($opcion == 'ListContractsClient') {//Listar los contratos activos de un cliente
    $array = array();
    $retorno = $obj_2usuario->ListContractsClient($_POST);
    $i = 0;
    while ($r = mysqli_fetch_array($retorno)) {
        $array[$i]["contrato_id"] = $r['contrato_id'];
        $array[$i]["contrato_fechainicio"] = $r['contrato_fechainicio'];
        $array[$i]["contrato_fechafin"] = $r['contrato_fechafin'];
        $array[$i]["contrato_numero"] = $r['contrato_numero'];
        $array[$i]["contrato_valor"] = $r['contrato_valor'];        
        $i++;
    }
    $datos["datos"] = $array;
    echo json_encode($datos);
}

if ($opcion == 'StateUpdateContract') {
    $retorno = $obj_2usuario->StateUpdateContract($_POST);
    echo $retorno;
}

if ($opcion == 'ListClient') {
    (string) $resultado = $obj_2usuario->ListClient($_POST);
    echo $resultado;
}
if ($opcion == 'ListContrato') {
    (string) $resultado = $obj_2usuario->ListContrato($_POST);
    echo $resultado;
}
if ($opcion == 'ListUserArea') {
    (string) $resultado = $obj_2usuario->ListUserArea($_POST);
    echo $resultado;
}
if ($opcion == 'JsonDataUserMail') {
    $retorno = $obj_2usuario->JsonDataUserMail($_POST);
    echo $retorno;
}

if ($opcion == 'UpdatePw') {
    $retorno = $obj_2usuario->UpdatePw($_POST);
    echo $retorno;
}
