<?php

include '../../0connection/BD_config.php';
include '../../0connection/connection.php';
include '../../0connection/BD.php';

session_start();


        $obj_bd = new BD();

//        $sql = "CALL SP_ptentregablesubactividad('4','','','','','','','','4');";
        $sql = "CALL SP_ptalcancesubactividad('4','','','','','','','','0');";

        $resul = $obj_bd->EjecutaConsulta($sql);
        while ($row = $obj_bd->FuncionFetch($resul)) {

            //$retorno .= "" . $row['entregable_id'] . ",";
            $retorno .= "" . $row['alcance_id'] . ",";
        }
        //echo $retorno;
   echo trim($retorno, ',');
    


?>
