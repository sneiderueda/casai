<?php

include '../../0connection/BD_config.php';
include '../../0connection/connection.php';
include '../../0connection/BD.php';

$opc = filter_var($_REQUEST['opc'], FILTER_SANITIZE_STRING);
if ($opc == 0) {
    $obj_bd = new BD();
    $arreglo_retorno = array();
    $sql = "CALL SP_RplaboresAsignadas('5','','','','','')";
    $resul = $obj_bd->EjecutaConsulta($sql);


    $num_rows_list_events_diary = $obj_bd->Filas($sql);
    if ($num_rows_list_events_diary != 0) {
        $area = "";
        $i = 0;

        while ($row = $obj_bd->FuncionFetch($resul)) {
            if ($row['area_nombre'] == 'CIVIL') {
                $area = "event-success";
            } else if ($row['area_nombre'] == 'MECANICA') {
                $area = "event-info";
            } else if ($row['area_nombre'] == 'ELECTRICA') {
                $area = "event-important";
            } else if ($row['area_nombre'] == 'CIVIL MECANICO') {
                $area = "event-danger";
            } else if ($row['area_nombre'] == 'ELECTROMECANICO') {
                $area = "event-warning";
            } else if ($row['area_nombre'] == 'CIVIL Y ELECTROMECANICO') {
                $area = "event-light";
            } else if ($row['area_nombre'] == 'OTRO') {
                $area = "event-dark";
            } else if ($row['area_nombre'] == 'NINGUNO') {
                $area = "event-primary";
            } else if ($row['area_nombre'] == 'PLANIFICACION Y CONTROL') {
                $area = "event-secondary";
            } else if ($row['area_nombre'] == 'HSEQ') {
                $area = "event-dismissible";
            } else if ($row['area_nombre'] == 'RRHH') {
                $area = "event-dismissible";
            } else if ($row['area_nombre'] == 'LLTT') {
                $area = "event-dismissible";
            } else if ($row['area_nombre'] == 'FACTURACION') {
                $area = "event-dismissible";
            } else if ($row['area_nombre'] == 'COMPRAS Y LOGÍSTICA ') {
                $area = "event-dismissible";
            } else if ($row['area_nombre'] == 'GESTIÓN DOCUMENTAL') {
                $area = "event-dismissible";
            }

            date_default_timezone_set('America/Bogota');
            $fecha_mic_ini = strtotime(substr($row['fecha_inicio'], 6, 4) . "-" . substr($row['fecha_inicio'], 3, 2) . "-" . substr($row['fecha_inicio'], 0, 2) . " " . substr($row['fecha_inicio'], 10, 6)) * 1000;
            $fecha_mic_fin = strtotime(substr($row['fecha_fin'], 6, 4) . "-" . substr($row['fecha_fin'], 3, 2) . "-" . substr($row['fecha_fin'], 0, 2) . " " . substr($row['fecha_fin'], 10, 6)) * 1000;
            $datos[$i] = array(
                "start" => $fecha_mic_ini,
                "end" => $fecha_mic_fin,
                "class" => $area,
                "url" => 'lib/8reportes/view/viewSeguimientoCalendario.php?id=' . $row['presupuesto_id'],
                "title" => "OT # " . $row['ordentrabajo_num'] . " Area " . $row['area_nombre'] . " Labor " . $row['labor'],
                "id" => $row['detallepresupuesto_id']
            );
            $i++;
        }
        echo json_encode(
                array(
                    "success" => 1,
                    "result" => $datos
                )
        );
    } else {
        echo "No hay datos";
    }
} else {
    $obj_bd = new BD();
    $arreglo_retorno = array();
    $sql = "CALL SP_RplaboresAsignadas('6','".$opc."','','','','')";
    $resul = $obj_bd->EjecutaConsulta($sql);


    $num_rows_list_events_diary = $obj_bd->Filas($sql);
    if ($num_rows_list_events_diary != 0) {
        $area = "";
        $i = 0;

        while ($row = $obj_bd->FuncionFetch($resul)) {
            if ($row['area_nombre'] == 'CIVIL') {
                $area = "event-success";
            } else if ($row['area_nombre'] == 'MECANICA') {
                $area = "event-info";
            } else if ($row['area_nombre'] == 'ELECTRICA') {
                $area = "event-important";
            } else if ($row['area_nombre'] == 'CIVIL MECANICO') {
                $area = "event-danger";
            } else if ($row['area_nombre'] == 'ELECTROMECANICO') {
                $area = "event-warning";
            } else if ($row['area_nombre'] == 'CIVIL Y ELECTROMECANICO') {
                $area = "event-light";
            } else if ($row['area_nombre'] == 'OTRO') {
                $area = "event-dark";
            } else if ($row['area_nombre'] == 'NINGUNO') {
                $area = "event-primary";
            } else if ($row['area_nombre'] == 'PLANIFICACION Y CONTROL') {
                $area = "event-secondary";
            } else if ($row['area_nombre'] == 'HSEQ') {
                $area = "event-dismissible";
            } else if ($row['area_nombre'] == 'RRHH') {
                $area = "event-dismissible";
            } else if ($row['area_nombre'] == 'LLTT') {
                $area = "event-dismissible";
            } else if ($row['area_nombre'] == 'FACTURACION') {
                $area = "event-dismissible";
            } else if ($row['area_nombre'] == 'COMPRAS Y LOGÍSTICA ') {
                $area = "event-dismissible";
            } else if ($row['area_nombre'] == 'GESTIÓN DOCUMENTAL') {
                $area = "event-dismissible";
            }

            date_default_timezone_set('America/Bogota');
            $fecha_mic_ini = strtotime(substr($row['fecha_inicio'], 6, 4) . "-" . substr($row['fecha_inicio'], 3, 2) . "-" . substr($row['fecha_inicio'], 0, 2) . " " . substr($row['fecha_inicio'], 10, 6)) * 1000;
            $fecha_mic_fin = strtotime(substr($row['fecha_fin'], 6, 4) . "-" . substr($row['fecha_fin'], 3, 2) . "-" . substr($row['fecha_fin'], 0, 2) . " " . substr($row['fecha_fin'], 10, 6)) * 1000;
            $datos[$i] = array(
                "start" => $fecha_mic_ini,
                "end" => $fecha_mic_fin,
                "class" => $area,
                "url" => 'lib/8reportes/view/viewSeguimientoCalendario.php?id=' . $row['presupuesto_id'],
                "title" => " Area " . $row['area_nombre'] . " Labor " . $row['labor']." Modulo ". $row['modulo_descripcion'],
                "id" => $row['detallepresupuesto_id']
            );
            $i++;
        }
        echo json_encode(
                array(
                    "success" => 1,
                    "result" => $datos
                )
        );
    } else {
        echo "No hay datos";
    }
}
?>
