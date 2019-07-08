<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MD_cumplimentaciones
 *
 * @author gustavo
 */
include '../../0connection/BD_config.php';
include '../../0connection/connection.php';
include '../../0connection/BD.php';

session_start();

class MD_cumplimentaciones {

    function gritCumplimentaciones() {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= "<br>";
        
        $tabla .= "<fieldset class='letraBl'>";
        $tabla .= "<legend class='titulo'>Cumplimentaciones</legend>";

        $url = "'lib/7cumplimentaciones/view/formCreateCumplimentacion.php','contenido','0'";
        $tabla .= '<button class="btn btn-primary fondo" type="button" onclick="loadingFunctions(' . $url . ')">Agregar</button>';

        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= $filtro;
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>                              
                            <th># Descargo </th>  
                            <th>Tipo</th>
                            <th>Subestacion</th>                                                        
                            <th>Gestor</th>                                                        
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_ptCumplimentaciones('1','','','','','','','','','','','','','','','','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {


            $urlEdit = '"lib/7cumplimentaciones/view/formEditCumplimentacion.php","contenido","' . $row['cumplimentacion_id'] . '"';
            $tabla .= "<tr>                
                <td>" . $row['cumplimentacion_descargo'] . "</td>                     
                <td>" . utf8_encode($row['tipodescargo_descripcion']) . "</td>                
                <td>" . $row['subestacion_nombre'] . " </td>                     
                <td>" . utf8_encode($row['gestor'] ). "</td>                                             
                <td><button class='btn btn-info fondo'  onclick='loadingFunctions(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Editar  </button>                 
                </td> 
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable();</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function ListTipDescargo() {
        $obj_bd = new BD();

        $sql = "CALL SP_ptCumplimentaciones('2','','','','','','','','','','','','','','','','');";

        $resul = $obj_bd->EjecutaConsulta($sql);
        $retorno .= "<option value=''>-Seleccione-</option>";
        $retorno .= "<option value='0'>Crear - Editar</option>";
        while ($row = $obj_bd->FuncionFetch($resul)) {

            $retorno .= "<option value='" . $row['tipodescargo_id'] . "'>" . utf8_encode($row['tipodescargo_descripcion']) . " </option>";
        }
        return $retorno;
    }

    public function saveTipoDescargo($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        $sql = "CALL SP_ptCumplimentaciones('3','" . trim(utf8_decode($data['txt_descripcion'])) . "','" . $id_usuario . "','','','','','','','','','','','','','','');";

        $res = $obj_bd->EjecutaConsulta($sql);
        if (!$res)
            die('Invalid query ->' . mysqli_errno() . '->' . $res);

        $array = $obj_bd->FuncionFetch($res);
        $descargo_id = $array['descargo_id_insert'];



        if ($descargo_id == 0 || $descargo_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<descargo_id>" . $descargo_id . "</descargo_id>";
            $xml .= "</respuesta>";
        }
        return $xml;
    }

    public function saveCumplimentacion($data, $files_data) {
        date_default_timezone_set('America/Bogota');
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $arre_ingenieros = explode(',', $data['ing']);
        //print_r($arre_ingenieros);
        if ($files_data['archivo']['error'] == UPLOAD_ERR_OK) {

            $extension = pathinfo($files_data['archivo']['name'], PATHINFO_EXTENSION);
            $name = 'Descargo_' . trim(utf8_decode($data['txt_descargo'])) . '.' . $extension;
            $tipo_documento = $files_data['archivo']['type'];
            $tamanio_doc = $files_data['archivo']['size'];
            $move_ico = move_uploaded_file($files_data['archivo']['tmp_name'], '../../docs/' . $name);

            if ($move_ico) {
                $sql = "CALL SP_ptCumplimentaciones('4'
                                                    ,''
                                                    ,'" . $id_usuario . "'
                                                    ,''
                                                    ,'" . trim(utf8_decode($data['txtDateApertura'])) . "'
                                                    ,'" . trim(utf8_decode($data['txtDateCierre'])) . "'
                                                    ,'" . trim(utf8_decode($data['txt_descargo'])) . "'
                                                    ,'" . trim(utf8_decode($data['sltipoDescargo'])) . "'
                                                    ,'" . trim(utf8_decode($data['txtDateInicio'])) . "'
                                                    ,'" . trim(utf8_decode($data['txtDateFinal'])) . "'
                                                    ,'" . trim(utf8_decode($data['slc_jornada'])) . "'
                                                    ,'" . trim(utf8_decode($data['slGestor'])) . "'
                                                    ,'" . trim(utf8_decode($data['txt_obs'])) . "'
                                                    ,'" . trim(utf8_decode($data['txt_apertura_ope'])) . "'
                                                    ,'" . trim(utf8_decode($data['txt_cierre_ope'])) . "'
                                                    ,''
                                                    ,'" . trim(utf8_decode($data['slSubestacion'])) . "');";

                $res = $obj_bd->EjecutaConsulta($sql);
                if (!$res)
                    die('Invalid query ->' . mysqli_errno() . '->' . $res);

                $array = $obj_bd->FuncionFetch($res);
                $cumplimentacion_id = $array['cumplimentacion_id_insert'];

                //Validar si ya existe documento
                $sql_sopt_cump = "CALL SP_ptsoporteseguimiento('5','','','','','','','" . $cumplimentacion_id . "','');";
                $resultado_sopt_cum = $obj_bd->EjecutaConsulta($sql_sopt_cump);
                $array_sopt_cum = $obj_bd->FuncionFetch($resultado_sopt_cum);
                $soporte_id = $array_sopt_cum['soporte_id'];

                if ($soporte_id > 0) {
                    //actualizar documentos                     
                    $sql_sopt = "CALL SP_dtsoporte('3','".$soporte_id."','','','" . trim($name) . "','" . trim($tamanio_doc) . "','" . trim($tipo_documento) . "','lib/docs/$name','','" . $id_usuario . "');";
                    $resultado_sopt = $obj_bd->EjecutaConsulta($sql_sopt);
                    $array_sopt = $obj_bd->FuncionFetch($resultado_sopt);                    
                    
                } else {
                    //insertar documento
                    $sql_sopt = "CALL SP_dtsoporte('2','','','','" . trim($name) . "','" . trim($tamanio_doc) . "','" . trim($tipo_documento) . "','lib/docs/$name','" . $id_usuario . "','');";
                    $resultado_sopt = $obj_bd->EjecutaConsulta($sql_sopt);
                    $array_sopt = $obj_bd->FuncionFetch($resultado_sopt);
                    $soporte_id_insert = $array_sopt['soporte_id_insert'];

                    //asociacion del los documentos 
                    $sql_sopt = "CALL SP_ptsoporteseguimiento('4','','','','','" . $id_usuario . "','','" . $cumplimentacion_id . "','" . $soporte_id_insert . "');";
                    $resultado_Asc = $obj_bd->EjecutaConsulta($sql_sopt);
                    if (!$resultado_Asc)
                        die('Invalid query ->' . mysqli_errno() . '->' . $resultado_Asc);
                }

                //insertar ingenieros                                                
                if (!empty($arre_ingenieros)) {
                    //actualizar ingenieros
                    $ing = "CALL SP_ptCumplimentaciones('9'
                                                    ,''
                                                    ,''
                                                    ,'" . $cumplimentacion_id . "'
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,'');";

                    $res_ing = $obj_bd->EjecutaConsulta($ing);
                    if (!$res_ing)
                        die('Invalid query ->' . mysqli_errno() . '->' . $res_ing);

                    foreach ($arre_ingenieros as $key => $value) {

                        $ing = "CALL SP_ptCumplimentaciones('8'
                                                    ,''
                                                    ,'" . $id_usuario . "'
                                                    ,'" . $cumplimentacion_id . "'
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,''
                                                    ,'" . $value . "'
                                                    ,'');";

                        $res_ing = $obj_bd->EjecutaConsulta($ing);
                        if (!$res_ing)
                            die('Invalid query ->' . mysqli_errno() . '->' . $res_ing);
                    }
                    return 1;
                }
            } else {
                return 2;
            }
        } else {
            return 2;
        }
    }

    public function JsonDetalleCumplimentacion($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_ptCumplimentaciones('5','','','" . trim($data['cumplmentacion_id']) . "'
												  ,''
												  ,''
												  ,''
												  ,''
												  ,''
												  ,''
												  ,''
												  ,''
												  ,''
												  ,''
												  ,''
												  ,''
												  ,'');";


        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['cumplimentacion_aperturarp'] = $array['cumplimentacion_aperturarp'];
        $arreglo_retorno['cumplimentacion_cierreapertura'] = $array['cumplimentacion_cierreapertura'];
        $arreglo_retorno['cumplimentacion_descargo'] = utf8_encode($array['cumplimentacion_descargo']);
        $arreglo_retorno['cumplimentacion_estado'] = $array['cumplimentacion_estado'];
        $arreglo_retorno['cumplimentacion_fechacreo'] = $array['cumplimentacion_fechacreo'];
        $arreglo_retorno['cumplimentacion_fechafincod'] = $array['cumplimentacion_fechafincod'];
        $arreglo_retorno['cumplimentacion_fechainicod'] = $array['cumplimentacion_fechainicod'];
        $arreglo_retorno['cumplimentacion_fechamodifico'] = $array['cumplimentacion_fechamodifico'];
        $arreglo_retorno['cumplimentacion_gestor'] = $array['cumplimentacion_gestor'];
        $arreglo_retorno['cumplimentacion_jornada'] = utf8_encode($array['cumplimentacion_jornada']);
        $arreglo_retorno['cumplimentacion_obs'] = utf8_encode($array['cumplimentacion_obs']);
        $arreglo_retorno['cumplimentacion_operadorapertura'] = utf8_encode($array['cumplimentacion_operadorapertura']);
        $arreglo_retorno['cumplimentacion_operariocierre'] = utf8_encode($array['cumplimentacion_operariocierre']);
        $arreglo_retorno['cumplimentacion_usuariocreo'] = $array['cumplimentacion_usuariocreo'];
        $arreglo_retorno['cumplimentacion_usuariomodifico'] = $array['cumplimentacion_usuariomodifico'];
        $arreglo_retorno['ingenieros'] = utf8_encode($array['ingenieros']);
        $arreglo_retorno['tipodescargo_id'] = $array['tipodescargo_id'];
        $arreglo_retorno['subestacion_id'] = $array['subestacion_id'];

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function editCumplimentacion($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        $sql = "CALL SP_ptCumplimentaciones('6','','" . $id_usuario . "'
                                                  ,'" . trim($data['txt_cumplimentacion_id']) . "'
												  ,'" . trim(utf8_decode($data['txt_fechaapertura'])) . "'
												  ,'" . trim(utf8_decode($data['txt_fechacierre'])) . "'
												  ,'" . trim(utf8_decode($data['txt_descargo'])) . "'
												  ,'" . trim(utf8_decode($data['txt_tipodescargo'])) . "'
												  ,'" . trim(utf8_decode($data['txt_fechainicio'])) . "'
												  ,'" . trim(utf8_decode($data['txt_fechafinal'])) . "'
												  ,'" . trim(utf8_decode($data['txt_jornada'])) . "'
												  ,'" . trim(utf8_decode($data['txt_gestor'])) . "'
												  ,'" . trim(utf8_decode($data['txt_observaciones'])) . "'
												  ,'" . trim(utf8_decode($data['txt_opapertura'])) . "'
												  ,'" . trim(utf8_decode($data['txt_opcierre'])) . "'
												  ,'" . trim(utf8_decode($data['txt_ingenieros'])) . "'
												  ,'" . trim($data['txt_subestacion']) . "');";

        $res = $obj_bd->EjecutaConsulta($sql);
        if (!$res)
            die('Invalid query ->' . mysqli_errno() . '->' . $res);

        $array = $obj_bd->FuncionFetch($res);
        $cumplimentacion_id = $array['cumplimentacion_id_insert'];

        if ($cumplimentacion_id == 0 || $cumplimentacion_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<cumplimentacion_id>" . $cumplimentacion_id . "</cumplimentacion_id>";
            $xml .= "</respuesta>";
        }
        return $xml;
    }

    public function ListIngDescargo($data) {
        $obj_bd = new BD();

        $sql = "CALL SP_ptCumplimentaciones('7','','','','','','','" . $data['tipodescargo_id'] . "','','','','','','','','','');";
        $resul = $obj_bd->EjecutaConsulta($sql);
        $row = $obj_bd->FuncionFetch($resul);


        try {

            $sql_ing = "CALL SP_ptperfil_usuario('8','','" . $row['area_id'] . "','','');";
            $resul_ing = $obj_bd->EjecutaConsulta($sql_ing);

            $retorno = "<option value=''>seleccione</option>";
            while ($row = $obj_bd->FuncionFetch($resul_ing)) {
                // if (utf8_encode($row['perfil_nombre']) == "INGENIERO") {
                    $retorno .= "<option value='" . $row['perfilusuario_id'] . "'>" . utf8_encode($row['usuario_apellidos'] . ' ' . $row['usuario_nombre']) . "-" . utf8_encode($row['perfil_nombre']) . "</option>";
                // }
            }
            return $retorno;
        } catch (Exception $ex) {
            return $ex;
        }
    }

}
