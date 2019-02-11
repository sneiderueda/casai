<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once ("BD_config.php");

if (MOTOR == 'ORACLE') {

    $conexion = oci_connect(USUARIO, PASSWORD, DNS . "/" . INSTANCIA, 'AL32UTF8');
    if (!$conexion) {
        $m = oci_error();
        echo $m['message'], "\n";
        exit;
    }
} else if (MOTOR == 'MYSQL') {

    $conexion = mysqli_connect(DNS, USUARIO, PASSWORD, BD);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    
    mysqli_select_db($conexion, BD);
}
