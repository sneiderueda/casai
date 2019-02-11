<?php

require_once '../../../components/PHPWord/PHPWord.php';
require_once '../../0connection/BD_config.php';
require_once '../../0connection/connection.php';
require_once '../../0connection/BD.php';




session_start();

$descargo_id = $_GET['er'];
$obj_bd = new BD();

$PHPWord = new PHPWord();
$document = $PHPWord->loadTemplate('../../../components/PHPWord/Templates/Descargo.docx');

$sql = "SELECT OT.ordentrabajo_obs as proyecto,
                OT.ordentrabajo_num,
                SB.subestacion_nombre,
                MD.modulo_descripcion,
                DS.descargo_actividad,
                PT.presupuesto_fechaini,                
                PT.presupuesto_fechafin,
                PT.presupuesto_horaini,
                PT.presupuesto_horafin,
                CONCAT(USU.usuario_apellidos, ' ', USU.usuario_nombre) as ingeniero,
                USU.usuario_celular,
                DS.descargo_riesgo,
                DS.descargo_tipo,
                DS.descargo_preipoanexo,
                DS.descargo_codensa
            FROM pt_descargo DS
            JOIN pt_orden_trabajo OT ON DS.ordentrabajo_id=OT.ordentrabajo_id
            JOIN pt_presupuesto PT ON DS.presupuesto_id=PT.presupuesto_id
            JOIN dt_detalle_presupuesto DP ON PT.detallepresupuesto_id=DP.detallepresupuesto_id
            JOIN dt_subestacion SB ON DP.subestacion_id=SB.subestacion_id
            JOIN cf_modulo MD ON PT.modulo_id=MD.modulo_id
            JOIN pt_perfil_usuario PE ON PT.presupuesto_encargado=PE.perfilusuario_id
            JOIN dt_usuario USU ON PE.usuario_id=USU.usuario_id           
            AND DS.descargo_id=$descargo_id";
//echo '<pre>';
//var_dump($sql);
//echo '</pre>';
$resultado = $obj_bd->EjecutaConsulta($sql);

while ($row = $obj_bd->FuncionFetch($resultado)) {
    $NOM_PROY = utf8_encode($row['proyecto']);
    $NOM_SUB = utf8_encode($row['subestacion_nombre']);
    $MOD = utf8_encode($row['modulo_descripcion']);
    $DESCARGO = utf8_encode($row['descargo_actividad']);
    $TIPO_DESCARGO = utf8_encode($row['descargo_tipo']);
    $RIESGO_DISPATO = utf8_encode($row['descargo_riesgo']);
    $IPO_ANEXO = utf8_encode($row['descargo_preipoanexo']);
    $ENCARGADO_CODENSA = utf8_encode($row['descargo_codensa']);

    /* tipo descargo */
    if ($TIPO_DESCARGO == 'Proxi') {
        $proxi = "X";
        $vyp = "";
    } else if ($TIPO_DESCARGO == 'VyP') {
        $proxi = "";
        $vyp = "X";
    } else {
        $proxi = "";
        $vyp = "";
    }
    /**/


    /* RIESGO DISPARO */
    if ($RIESGO_DISPATO == 'No') {
        $no = "X";
        $bajo = "";
        $alto = "";
    } else if ($RIESGO_DISPATO == 'Si bajo') {
        $no = "";
        $bajo = "X";
        $alto = "";
    } else if ($RIESGO_DISPATO == 'Si alto') {
        $no = "";
        $bajo = "";
        $alto = "X";
    } else {
        $no = "";
        $bajo = "";
        $alto = "";
    }
    /**/

    /* ANEXO* */
    if ($IPO_ANEXO =='Si') {
        $si_anexo = "X";
        $no_requiere = "";
    } else if ($IPO_ANEXO == 'No requiere') {
        $si_anexo = "";
        $no_requiere = "X";
    } else {
        $si_anexo = "";
        $no_requiere = "";
    }
    /**/

    $encargado = $row['ingeniero'];
    $document->setValue('v1', utf8_decode($NOM_PROY));
    $document->setValue('v2', 'CASAI');
    $document->setValue('v3', $row['ordentrabajo_num']);
    $document->setValue('v4', utf8_decode($NOM_SUB));
    $document->setValue('v5', utf8_decode($MOD));
    $document->setValue('v6', utf8_decode($DESCARGO));
    $document->setValue('v7', "Del ".$row['presupuesto_fechaini']. " hasta ".$row['presupuesto_fechafin']);
    $document->setValue('v8', $row['presupuesto_horaini']." - ".$row['presupuesto_horafin']);
    $document->setValue('v9', $encargado);
    $document->setValue('v10', $row['usuario_celular']);
    $document->setValue('v11', $proxi);
    $document->setValue('v12', $vyp);
    $document->setValue('v13', $no);
    $document->setValue('v14', $bajo);
    $document->setValue('v15', $alto);
    $document->setValue('v16', $si_anexo);
    $document->setValue('v17', $no_requiere);
    $document->setValue('v18', $ENCARGADO_CODENSA);
    
}



$filename = 'Descargo.docx';

$document->save($filename);
$retorno = $filename;


header('Content-Description: File Transfer');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename=' . $retorno);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($retorno));
flush();
readfile($retorno);
unlink($retorno); //
