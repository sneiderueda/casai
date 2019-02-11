<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MD_baremos
 *
 * @author jennifer
 */
include '../../0connection/BD_config.php';
include '../../0connection/connection.php';
include '../../0connection/BD.php';

session_start();

class MD_baremos {

    function gritBaremos() {
        $hoy = date("j, n, Y");
        $spli = explode(",", $hoy);
        $año = $spli[2];
        $obj_bd = new BD();
        $tabla = "";
        $filtro = "<script>ListTipBaremo('tipo_bm');</script>
            <table class='table table-bordered table-striped'>
                <thead>
                    <tr>
                        <th colspan='4'><center>Filtro busqueda</center></th>
                </tr>
                </thead>
                <tr>
                    <td><b>Tipo Baremo</b> :<select id='tipo_bm' style='width: 200px;'></select></td>
                    <td><b>Nùmero Labor</b>: <input type='text' name='txt_item' id='txt_item' class='input-xlarge data' style='width: 400px;' onblur='aMayusculas(this.value, this.id)'></td>                    
                </tr>    
                <tr>
                    <td colspan='4'><center><input type='button' class='btn btn-success' value='Buscar' onclick='LsBaremoFiltro()'></center></td>
                </tr>
            </table>";


        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        // $tabla .= "<legend>Baremos Registrados</legend>";
        $url = "'lib/1config/vista/formDataBaremo.php','contenido','0'";
        $tabla .= '<button name="btnAddBaremo" id="btnAddBaremo" class="btn btn-default" type="button" onclick="loadingFunctions(' . $url . ')">Crear</button>';
        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= $filtro;
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>                              
                            <th>Cliente</th>  
                            <th>Nùmero-año</th>  
                            <th>Tipo Labor</th>
                            <th>Nùmero Labor</th>                                                        
                            <th>Total sin IVA ' . $año . '</th>                                                        
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_ptBaremo('1','','','','','','','','','','','','','','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {


            $urlEdit = '"lib/1config/vista/formDataBaremo.php","contenido","' . $row['baremo_id'] . '"';
            $tabla .= "<tr>                
                <td>" . utf8_encode($row['cliente_descripcion'] . " " . $row['usuario_nombre']) . "</td>                     
                <td>" . utf8_encode($row['contrato_numero']). "</td>                     
                <td>" . $row['tipobaremo_descripcion'] . "</td>                
                <td>" . $row['baremo_item'] . "</td>                     
                <td>" . number_format((float)$row['baremo_totalsiniva'], 0, ',', '.') . "</td>                                             
                <td><button class='btn btn-default'  onclick='loadingFunctions(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Editar  </button>
                    <button class='btn btn-danger'  onclick='DeleteBaremo(" . $row['baremo_id'] . ")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>Eliminar  </button>                    
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

    public function ListTipBaremo() {
        $obj_bd = new BD();

        $sql = "CALL SP_cfTipobaremo('1','','','','','','','','');";

        $resul = $obj_bd->EjecutaConsulta($sql);
        $retorno .= "<option value=''>-Seleccione-</option>";
        while ($row = $obj_bd->FuncionFetch($resul)) {

            $retorno .= "<option value='" . $row['tipobaremo_id'] . "'>" . utf8_encode($row['tipobaremo_descripcion']) . " - " . utf8_encode($row['tipobaremo_sigla']) . "</option>";
        }
        return $retorno;
    }

    public function SaveLaborBaremo($post) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        $bm_id = $post['bm_id'];


        //consultar si existe la labor
        $sql = "CALL SP_cflabor('1','','" . trim(utf8_decode($post['txt_labor'])) . "','','','','" . trim($post['txt_medida']) . "','','');";

        $res = $obj_bd->EjecutaConsulta($sql);
        if (!$res)
            die('Invalid query ->' . mysqli_errno() . '->' . $res);

        $array = $obj_bd->FuncionFetch($res);
        $labor_id = $array['labor_id'];

        if ($labor_id == "") {

            //Insertamos la labor
            $sql_insert = "CALL SP_cflabor('2','','" . trim(utf8_decode($post['txt_labor'])) . "','','','','" . $post['txt_medida'] . "','','');";
            $res_insert = $obj_bd->EjecutaConsulta($sql_insert);
            if (!$res_insert)
                die('Invalid query ->' . mysqli_errno() . '->' . $res_insert);

            $array = $obj_bd->FuncionFetch($res_insert);
            $labor_id = $array['insert_labor_id'];
        }
        //Insertar el baremo    
        $valor_sinPuntos = str_replace('.', '', $post['txt_totalSinIva']);
        $valor_sinPuntos_totalActividad = str_replace('.', '', $post['txt_totalAct']);

        $sql_baremo = "CALL SP_ptBaremo('2','','" . $post['slContrato'] . "','','','" . $post['txt_item'] . "','" . $valor_sinPuntos . "','" . $post['txt_medida'] . "','" . $id_usuario . "','','" . $post['txt_servicioTot'] . "','" . $valor_sinPuntos_totalActividad . "','" . $post['slCliente'] . "'," . $labor_id . ",'" . $post['slTip'] . "');";
        $res_baremo = $obj_bd->EjecutaConsulta($sql_baremo);
        if (!$res_baremo)
            die('Invalid query ->' . mysqli_errno() . '->' . $res_baremo);

        $array_baremo = $obj_bd->FuncionFetch($res_baremo);
        $baremo_id = $array_baremo['baremo_id_insert'];


        if ($baremo_id == 0 || $baremo_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<baremo_id>" . $baremo_id . "</baremo_id>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function AddActividadBaremo($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        $act_id = $data['act_id'];
        $bm_id = $data['bm_id'];


        //consultar si existe la actividad
        $sql = "CALL SP_cfactividad('1','','" . trim(utf8_decode($data['txt_act'])) . "','". trim($data['slContrato'])."','','','','" . trim($data['txt_servicioAct']) . "','','','" . trim($data['txt_act_valor']) . "');";

        $res = $obj_bd->EjecutaConsulta($sql);
        if (!$res)
            die('Invalid query ->' . mysqli_errno() . '->' . $res);

        $array = $obj_bd->FuncionFetch($res);
        $actividad_id = $array['actividad_id'];

        if ($actividad_id == "") {

            //Insertamos la actividad                
            $sql_insert = "CALL SP_cfactividad('2','','" . trim(utf8_decode($data['txt_act'])) . "','". trim($data['slContrato'])."','','','" . trim($data['txt_gom']) . "','" . trim($data['txt_servicioAct']) . "','" . $id_usuario . "','','" . trim($data['txt_act_valor']) . "');";
            $res_insert = $obj_bd->EjecutaConsulta($sql_insert);
            if (!$res_insert)
                die('Invalid query ->' . mysqli_errno() . '->' . $res_insert);

            $array = $obj_bd->FuncionFetch($res_insert);
            $actividad_id = $array['insert_actividad_id'];
        }

        if ($bm_id == "") {
            $xml = "<resultado>2</resultado>";
        }

        //Consultar si la actividad no esta asociada al baremo
        $sql_bm_act = "CALL PS_ptBaremoactividad('1','','". trim($data['slContrato'])."','','','','','" . $actividad_id . "','" . $bm_id . "');";

        $res_bm_act = $obj_bd->EjecutaConsulta($sql_bm_act);
        if (!$res_bm_act)
            die('Invalid query ->' . mysqli_errno() . '->' . $res_bm_act);

        $array_bm_act = $obj_bd->FuncionFetch($res_bm_act);
        $baremoactividad_id = $array_bm_act['baremoactividad_id'];

        if ($baremoactividad_id == "") {

            //Insertar actividad - baremo
            $sql_bm_act_ins = "CALL PS_ptBaremoactividad('2','','". trim($data['slContrato'])."','','','" . $id_usuario . "','','" . $actividad_id . "','" . $bm_id . "');";
            $res_baremo_act_ins = $obj_bd->EjecutaConsulta($sql_bm_act_ins);
            if (!$res_baremo_act_ins)
                die('Invalid query ->' . mysqli_errno() . '->' . $res_baremo_act_ins);

            $array_baremo_act_ins = $obj_bd->FuncionFetch($res_baremo_act_ins);
            $baremoactividad_id = $array_baremo_act_ins['baremoactividad_id_insert'];
        }


        if ($baremoactividad_id == 0 || $baremoactividad_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<baremoactividad_id>" . $baremoactividad_id . "</baremoactividad_id>";
            $xml .= "<actividad_id>" . $actividad_id . "</actividad_id>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    function gritAlcance() {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<legend>Alcance Baremado</legend>";
        $url = "'lib/1config/vista/formDataAlcance.php','contenido','0'";
        $tabla .= '<button name="btnAddBaremo" id="btnAddBaremo" class="btn btn-default" type="button" onclick="loadingFunctions(' . $url . ')">Agregar</button>';
        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                            <th>Acción</th>  
                            <th>Descripcion</th>                                                                                     
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_cfalcance('1','','','','','','','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {


            $urlEdit = '"lib/1config/vista/formDataAlcance.php","contenido","' . $row['alcance_id'] . '"';
            $tabla .= "<tr>
                <td><button class='btn btn-default'  onclick='loadingFunctions(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Editar</button>
                    <button class='btn btn-default'  onclick='StateUpdateAlcance(" . $row['alcance_id'] . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Eliminar</button>
                </td> 
                <td>" . utf8_encode($row['alcance_descripcion']) . "</td>                                                     
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable();</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function StateUpdateAlcance($post) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $SqlUpdate = "CALL SP_cfalcance('3','" . $post['alcance_id'] . "','','0','','','','" . $id_usuario . "');";

        $result = $obj_bd->EjecutaConsulta($SqlUpdate);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function JsonDataAlcance($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_cfalcance('4','" . $data['alcance_id'] . "','','','','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['alcance_descripcion'] = utf8_encode($array['alcance_descripcion']);
        $arreglo_retorno['alcance_id'] = $array['alcance_id'];

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function SaveAlcance($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        $alc_id = $data['alc_id'];

        if ($alc_id == "") {

            //INSERTAMOS EL ALCANCE
            $sql = "CALL SP_cfalcance('2','" . $alc_id . "','" . trim(utf8_decode($data['descp'])) . "','','','','" . $id_usuario . "','');";

            $res = $obj_bd->EjecutaConsulta($sql);
            if (!$res)
                die('Invalid query ->' . mysqli_errno() . '->' . $res);

            $array = $obj_bd->FuncionFetch($res);
            $alcance_id = $array['alcance_id_insert'];
        }else {

            //ACTUALIZAMOS LA DESCRIPCION
            $sql = "CALL SP_cfalcance('5','" . $alc_id . "','" . trim(utf8_decode($data['descp'])) . "','','','','','" . $id_usuario . "');";

            $res = $obj_bd->EjecutaConsulta($sql);
            if (!$res)
                die('Invalid query ->' . mysqli_errno() . '->' . $res);

            $alcance_id = $alc_id;
        }


        if ($alcance_id == 0 || $alcance_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<alcance_id>" . $alcance_id . "</alcance_id>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    function gritEntregable() {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<legend>Entregable Baremados</legend>";
        $url = "'lib/1config/vista/formDataEntregable.php','contenido','0'";
        $tabla .= '<button name="btnAdd" id="btnAdd" class="btn btn-default" type="button" onclick="loadingFunctions(' . $url . ')">Crear</button>';
        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                            <th>Acción</th>  
                            <th>Descripcion</th>                                                                                     
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_cfentregable('1','','','','','','','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {


            $urlEdit = '"lib/1config/vista/formDataEntregable.php","contenido","' . $row['entregable_id'] . '"';
            $tabla .= "<tr>
                <td><button class='btn btn-default'  onclick='loadingFunctions(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Editar</button>
                    <button class='btn btn-default'  onclick='StateUpdateEntregable(" . $row['entregable_id'] . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Eliminar</button>
                </td> 
                <td>" . utf8_encode($row['entregable_descripcion']) . "</td>                                                     
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable();</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function StateUpdateEntregable($post) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $SqlUpdate = "CALL SP_cfentregable('3','" . $post['entregable_id'] . "','','0','','','','" . $id_usuario . "');";

        $result = $obj_bd->EjecutaConsulta($SqlUpdate);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function JsonDataEntregable($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_cfentregable('4','" . $data['entregable_id'] . "','','','','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['entregable_descripcion'] = $array['entregable_descripcion'];
        $arreglo_retorno['entregable_id'] = $array['entregable_id'];

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function SaveEntregable($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        $ent_id = $data['ent_id'];

        if ($ent_id == "") {

            //INSERTAMOS EL ENTREGABLE
            $sql = "CALL SP_cfentregable('2','" . $ent_id . "','" . trim(utf8_decode($data['descp'])) . "','','','','" . $id_usuario . "','');";

            $res = $obj_bd->EjecutaConsulta($sql);
            if (!$res)
                die('Invalid query ->' . mysqli_errno() . '->' . $res);

            $array = $obj_bd->FuncionFetch($res);
            $entregable_id = $array['entregable_id_insert'];
        }else {

            //ACTUALIZAMOS LA DESCRIPCION
            $sql = "CALL SP_cfentregable('5','" . $ent_id . "','" . trim(utf8_decode($data['descp'])) . "','','','','','" . $id_usuario . "');";

            $res = $obj_bd->EjecutaConsulta($sql);
            if (!$res)
                die('Invalid query ->' . mysqli_errno() . '->' . $res);

            $entregable_id = $ent_id;
        }


        if ($entregable_id == 0 || $entregable_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<entregable_id>" . $entregable_id . "</entregable_id>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function SaveSubactividad($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        $sub_id = $data['sub_id'];
        $act_id = $data['act_id'];
        $txt_sub = $data['txt_sub'];
        $txt_porc_sub = $data['txt_porc_sub'];
        $txt_totalSinIvaSub = $data['txt_totalSinIvaSub'];
        $baremoactividad_id = $data['baremoactividad_id'];
        $contrato_id = $data['contrato_id'];

        if ($sub_id == "") {

            //INSERTAMOS LA SUBACTIVIDAD
            $sql = "CALL SP_cfsubactividad('2','','" . trim(utf8_decode($txt_sub)) . "','','','','" . $id_usuario . "','');";

            $res = $obj_bd->EjecutaConsulta($sql);
            if (!$res)
                die('Invalid query ->' . mysqli_errno() . '->' . $res);

            $array = $obj_bd->FuncionFetch($res);
            $subactividad_id = $array['subactividad_id_insert'];
        }else {

            //ACTUALIZAMOS LA DESCRIPCION
            $sql = "CALL SP_cfsubactividad('3','','" . trim(utf8_decode($txt_sub)) . "','','','','','" . $id_usuario . "');";

            $res = $obj_bd->EjecutaConsulta($sql);
            if (!$res)
                die('Invalid query ->' . mysqli_errno() . '->' . $res);

            $subactividad_id = $sub_id;
        }

        //SUBACTIVIDAD - ACTIVIDAD
        $sql_sa = "CALL SP_ptdetalleactividad('2','','" . $txt_totalSinIvaSub . "','".$contrato_id."','','','','" . $txt_porc_sub . "','" . $id_usuario . "','','" . $act_id . "','" . $baremoactividad_id . "','" . $subactividad_id . "');";

        $res_sa = $obj_bd->EjecutaConsulta($sql_sa);
        if (!$res_sa)
            die('Invalid query ->' . mysqli_errno() . '->' . $res_sa);

        $array = $obj_bd->FuncionFetch($res_sa);
        $detalleactividad_id = $array['detalleactividad_id_insert'];


        if ($detalleactividad_id == 0 || $detalleactividad_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<detalleactividad_id>" . $detalleactividad_id . "</detalleactividad_id>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function JsonBaremoClientTip($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_ptBaremo('3','','".$data['slContrato'] ."','','','" . $data['item'] . "','','','','','','','" . $data['cliente_id'] . "','','" . $data['tipobaremo_id'] . "');";


        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['labor_id'] = $array['labor_id'];
        $arreglo_retorno['labor_descripcion'] = $array['labor_descripcion'];
        $arreglo_retorno['baremo_id'] = $array['baremo_id'];
        $arreglo_retorno['baremo_item'] = $array['baremo_item'];
        $arreglo_retorno['baremo_totalsinIva'] = number_format((float)$array['baremo_totalsiniva'], 0, ',', '.');
        $arreglo_retorno['baremo_unidadservicio'] = $array['baremo_unidadservicio'];
        $arreglo_retorno['baremo_valorservicio'] = $array['baremo_valorservicio'];
        $arreglo_retorno['baremo_valortotalAct'] = number_format((float)$array['baremo_valortotalact'], 0, ',', '.');

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function JsonActividad($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_cfactividad('3','','" . trim(utf8_decode($data['activity_description'])) . "','','','','','','','','');";


        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['actividad_id'] = $array['actividad_id'];
        $arreglo_retorno['actividad_GOM'] = $array['actividad_gom'];
        $arreglo_retorno['actividad_unidadservicio'] = $array['actividad_unidadservicio'];
        $arreglo_retorno['actividad_valorservicio'] = $array['actividad_valorservicio'];

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function JsonValorPorc($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_ptdetalleactividad('3','','','','','','','','','','" . $data['actividad_id'] . "','" . $data['baremoactividad_id'] . "','');";


        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['porcentaje'] = $array['porcentaje'];

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function ListSubactividadesBm($data) {
//        $obj_bd = new BD();
//        $sql = "CALL SP_ptdetalleactividad('1','','','','','','','','','','" . $data['actividad_id'] . "','" . $data['baremoactividad_id'] . "','');";
//
//        $resul = $obj_bd->EjecutaConsulta($sql);
//
//        return $resul;
        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<legend>Subactividades</legend>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                           <th>Alcances</th> 
                           <th>Entregables</th>
                           <th>Subactividad</th>
                           <th>Porcentaje</th> 
                           <th>Costo sin IVA</th>                                                        
                           <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_ptdetalleactividad('1','','','','','','','','','','" . $data['actividad_id'] . "','" . $data['baremoactividad_id'] . "','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            $tabla .= "<tr> 
                <td><input type='button' name='edit_alcance' value='Editar' class='btn btn-primary' onclick='divConfigAlcanceEntregable(1," . $row['detalleactividad_id'] . "," . $data['contrato_id'] . ")'></td>
                <td><input type='button' name='edit_entregable' value='Editar' class='btn btn-primary' onclick='divConfigAlcanceEntregable(2," . $row['detalleactividad_id'] . "," . $data['contrato_id'] . ")'></td>
                <td>" . utf8_encode($row['subactividad_descripcion']) . "</td> 
                <td>" . $row['detallesubactividad_porc'] . "</td>                                                                     
                <td>" . number_format((float)$row['detallesubactividad_costosiniva'], 0, ',', '.') . "</td>                                                                                     
                <td><input type='button' name='elim' value='Eliminar' class='btn btn-danger' onclick='DeleteSubactividadBaremo(" . $data['baremoactividad_id'] . "," . $data['actividad_id'] . "," . $row['detalleactividad_id'] . ")'>
                </td>
            </tr>";
        }

        $sql_DC = "CALL SP_ptdetalleactividad('7','','','','','','','','','','" . $data['actividad_id'] . "','','');";
        $resultado_dc = $obj_bd->EjecutaConsulta($sql_DC);
        $row_actividad= $obj_bd->FuncionFetch($resultado_dc);
        $actividad_valordecimal=$row_actividad['actividad_valordecimal'];
        
        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable(); $('#valor_actividad_decimal').val(".$actividad_valordecimal.");</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function DeleteSubactividadBaremo($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql = "CALL SP_ptdetalleactividad('4','" . $data['detalleactividad_id'] . "','','','','','','','','" . $id_usuario . "','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function SelectAlcance($data) {
        $obj_bd = new BD();
        $contador = $data['cont'];
        $mensaje = "";
        $combo = " <option value=''> Seleccione</option>";
        $sql = "CALL SP_cfalcance('1','','','','','','','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        $num_filas = $obj_bd->Filas($sql);
        if ($num_filas > 0) {


            while ($row = $obj_bd->FuncionFetch($resultado)) {
                $Id = $row['alcance_id'];
                $alcance_descripcion = $row['alcance_descripcion'];
                $combo .= " <option value='" . $Id . "'>  " . utf8_encode($alcance_descripcion) . "</option>";
            }
        } else {
            $mensaje = "No Existe";
        }
        return $combo;
    }

    public function SaveAlcanceSubactividad($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];


        //consultar si existe la actividad
        $sql = "CALL SP_ptalcancesubactividad('2','','" . $data['contrato_id'] . "','','','" . $id_usuario . "','','" . $data['combobox_al'] . "','" . $data['detalleactividad_id'] . "');";

        $res = $obj_bd->EjecutaConsulta($sql);
        if (!$res)
            die('Invalid query ->' . mysqli_errno() . '->' . $res);

        $array = $obj_bd->FuncionFetch($res);
        $alcancesubactividad_id = $array['alcancesubactividad_id_insert'];


        if ($alcancesubactividad_id == 0 || $alcancesubactividad_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<alcancesubactividad_id>" . $alcancesubactividad_id . "</alcancesubactividad_id>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function ListAlcanceSubactividades($data) {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<legend>Alcances Asociados</legend>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                           <th>Descripción</th>
                           <th>Código</th> 
                            <th>Acción</th>                                                                                                                                                                                                                                 
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_ptalcancesubactividad('1','','','','','','','".$data['data_cont']."','" . $data['detalleactividad_id'] . "');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            $tabla .= "<tr> 
                <td>" . utf8_encode($row['alcance_descripcion']) . "</td> 
                <td>" . $row['alcance_id'] . "</td>                                                                     
                    <td><input type='button' name='elim_secc' value='Eliminar' class='btn btn-danger' onclick='DeleteSubactividadAlcance(" . $row['alcancesubactividad_id'] . "," . $data['detalleactividad_id'] . ")'></td>
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable();</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function DeleteSubactividadAlcance($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql_delete = "CALL SP_ptalcancesubactividad('3','" . $data['alcancesubactividad_id'] . "','','','','','" . $id_usuario . "','','');";

        $result_delete = $obj_bd->EjecutaConsulta($sql_delete);

        if (!$result_delete) {
            return 0;
        } else {
            return 1;
        }
    }

    public function SelectEntregable($data) {
        $obj_bd = new BD();
        $contador = $data['cont'];
        $mensaje = "";
        $combo = " <option value=''> Seleccione</option>";
        $sql = "CALL SP_cfentregable('1','','','','','','','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        $num_filas = $obj_bd->Filas($sql);
        if ($num_filas > 0) {


            while ($row = $obj_bd->FuncionFetch($resultado)) {
                $Id = $row['entregable_id'];
                $entregable_descripcion = $row['entregable_descripcion'];
                $combo .= " <option value='" . $Id . "'>  " . utf8_encode($entregable_descripcion) . "</option>";
            }
        } else {
            $mensaje = "No Existe";
        }
        return $combo;
    }

    public function ListEntregableSubactividades($data) {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<legend>Entregables Asociados</legend>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                           <th>Descripción</th>
                           <th>Código</th> 
                            <th>Acción</th>                                                                                                                                                                                                                                 
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_ptentregablesubactividad('1','','','','','','','','" . $data['detalleactividad_id'] . "');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            $tabla .= "<tr> 
                <td>" . utf8_encode($row['entregable_descripcion']) . "</td> 
                <td>" . $row['entregable_id'] . "</td>                                                                     
                    <td><input type='button' name='elim_ent' value='Eliminar' class='btn btn-danger' onclick='DeleteSubactividadEntregable(" . $row['entregablesubactividad_id'] . "," . $data['detalleactividad_id'] . ")'></td>
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable();</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function DeleteSubactividadEntregable($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql_delete = "CALL SP_ptentregablesubactividad('3','" . $data['entregablesubactividad_id'] . "','','','','','" . $id_usuario . "','','');";

        $result_delete = $obj_bd->EjecutaConsulta($sql_delete);

        if (!$result_delete) {
            return 0;
        } else {
            return 1;
        }
    }

    public function SaveEntregableSubactividad($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];


        //consultar si existe la actividad
        $sql = "CALL SP_ptentregablesubactividad('2','','" . $data['contrato_id'] . "','','','" . $id_usuario . "','','" . $data['combobox_ent'] . "','" . $data['detalleactividad_id'] . "');";

        $res = $obj_bd->EjecutaConsulta($sql);
        if (!$res)
            die('Invalid query ->' . mysqli_errno() . '->' . $res);

        $array = $obj_bd->FuncionFetch($res);
        $entregablesubactividad_id = $array['entregablesubactividad_id_insert'];


        if ($entregablesubactividad_id == 0 || $entregablesubactividad_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<entregablesubactividad_id>" . $entregablesubactividad_id . "</entregablesubactividad_id>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function ListActividadesBaremo($data) {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<legend>Actividades Asociadas</legend>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                           <th>Actividad</th>
                           <th>Costo Actividad Antes de IVA</th> 
                            <th>Acción</th>                                                                                                                                                                                                                                 
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL PS_ptBaremoactividad('3','','','','','','','','" . $data['baremo_id'] . "');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            $tabla .= "<tr> 
                <td>" . utf8_encode($row['actividad_descripcion']) . "</td>                     
                <td>" . number_format((float)$row['actividad_valorservicio'], 0, ',', '.') . "</td>                                                                     
                <td><img src='img/b_edit.png'  title='Editar Actividad' width='20' height='20' id='Edit' style='cursor:pointer' border='0' onclick='JsonActividadId(" . $row['actividad_id'] . ")'>
                   <img src='img/carge.png' id='arbol' title='Cargar Subactividades' width='20' height='20' style='cursor:pointer' border='0' onclick='DivSubactividades(" . $row['actividad_id'] . "," . $row['actividad_valorservicio'] . "," . $row['baremoactividad_id'] . ");'> 
                   <img src='img/borrar.jpg'  title='Eliminar Actividad' width='20' height='20' id='Elim' style='cursor:pointer' border='0' onclick='DeleteBaremoActividad(" . $row['baremoactividad_id'] . "," . $data['baremo_id'] . ")'>
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

    public function DeleteBaremo($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql = "CALL SP_ptBaremo('4','" . $data['baremo_id'] . "','','','','','','','','" . $id_usuario . "','','','','','');";

        $result_delete = $obj_bd->EjecutaConsulta($sql);

        if (!$result_delete) {
            return 0;
        } else {
            return 1;
        }
    }

    public function JsonBaremoId($data) {

        $arreglo_retorno1 = array();

        $obj_bd = new BD();
        $sql = "CALL SP_ptBaremo('5','" . $data['baremo_id'] . "','','','','','','','','','','','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno1['labor_id'] = $array['labor_id'];
        $arreglo_retorno1['labor_descripcion'] = trim(utf8_encode($array['labor_descripcion']));
        $arreglo_retorno1['baremo_id'] = $array['baremo_id'];
        $arreglo_retorno1['contrato_id'] = $array['contrato_id'];
        $arreglo_retorno1['baremo_item'] = $array['baremo_item'];
        $arreglo_retorno1['baremo_totalsinIva'] = number_format((float)$array['baremo_totalsiniva'], 0, ',', '.');
        $arreglo_retorno1['baremo_unidadservicio'] = $array['baremo_unidadservicio'];
        $arreglo_retorno1['baremo_valorservicio'] = $array['baremo_valorservicio'];
        $arreglo_retorno1['baremo_valortotalact'] = number_format((float)$array['baremo_valortotalact'], 0, ',', '.');
        $arreglo_retorno1['cliente_id'] = $array['cliente_id'];
        $arreglo_retorno1['tipobaremo_id'] = $array['tipobaremo_id'];

        $json = json_encode($arreglo_retorno1);
        return $json;
    }

    public function JsonActividadId($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_cfactividad('4','" . trim(($data['actividad_id'])) . "','','','','','','','','','');";


        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['actividad_id'] = $array['actividad_id'];
        $arreglo_retorno['actividad_descripcion'] = trim(utf8_encode($array['actividad_descripcion']));
        $arreglo_retorno['actividad_gom'] = $array['actividad_gom'];
        $arreglo_retorno['actividad_unidadservicio'] = $array['actividad_unidadservicio'];
        $arreglo_retorno['actividad_valorservicio'] = number_format((float)$array['actividad_valorservicio'], 0, ',', '.');

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function UpdateActividadBaremo($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        $act_id = $data['act_id'];
        $valor_sinPuntos_ValorActividad = str_replace('.', '', $data['txt_act_valor']);
        
        $sql = "CALL SP_cfactividad('5','" . $act_id . "','" . trim(utf8_decode($data['txt_act'])) . "','". trim($data['bm_id'])."','','',
                '" . trim($data['txt_gom']) . "','" . trim($data['txt_servicioAct']) . "','','" . $id_usuario . "','" . trim($valor_sinPuntos_ValorActividad) . "');";

        $res = $obj_bd->EjecutaConsulta($sql);

        if (!$res) {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function DeleteBaremoActividad($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql = "CALL PS_ptBaremoactividad('4','" . $data['baremoactividad_id'] . "','','','','','" . $id_usuario . "','','');";

        $result_delete = $obj_bd->EjecutaConsulta($sql);

        if (!$result_delete) {
            return 0;
        } else {
            return 1;
        }
    }

    function LsBaremoFiltro($data) {

        $obj_bd = new BD();
        $tipo_bm = $data['tipo_bm'];
        $txt_item = $data['txt_item'];
        $filtro1 = "";
        $filtro2 = "";

        if ($tipo_bm != "") {
            $filtro1 = "AND tb.tipobaremo_id=$tipo_bm";
        }

        if ($txt_item != "") {
            $filtro2 = "AND bm.baremo_item LIKE '%" . $txt_item . "%'";
        }

        $tabla = "";
        $filtro = "<script>ListTipBaremo('tipo_bm'); $('#tipo_bm').val(" . $tipo_bm . "); $('#txt_item').val('" . $txt_item . "');</script>
            <table class='table table-bordered table-striped'>
                <thead>
                    <tr>
                        <th colspan='4'><center>Filtro busqueda</center></th>
                </tr>
                </thead>
                <tr>
                    <td><b>Tipo Baremo</b> :<select id='tipo_bm' style='width: 200px;'></select></td>
                    <td><b>Número Labor</b>: <input type='text' name='txt_item' id='txt_item' class='input-xlarge data' style='width: 400px;' onblur='aMayusculas(this.value, this.id)'></td>                    
                </tr>    
                <tr>
                    <td colspan='4'><center><input type='button' class='btn btn-success' value='Buscar' onclick='LsBaremoFiltro()'></center></td>
                </tr>
            </table>";


        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        // $tabla .= "<legend>Baremos Registrados</legend>";
        $url = "'lib/1config/vista/formDataBaremo.php','contenido','0'";
        $tabla .= '<button name="btnAddBaremo" id="btnAddBaremo" class="btn btn-default" type="button" onclick="loadingFunctions(' . $url . ')">Agregar</button>';
        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= $filtro;
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>                              
                            <th>Cliente</th>  
                            <th>Número-año</th>  
                            <th>Tipo</th>
                            <th>Número Labor</th>                                                        
                            <th>Total sin IVA</th>                                                        
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "SELECT bm.baremo_id,
			    bm.baremo_item,
			    bm.baremo_totalsinIva,
			    cl.cliente_descripcion,
			    tb.tipobaremo_descripcion,
                            ct.contrato_numero
                       FROM pt_baremo bm
                       JOIN dt_cliente cl ON bm.cliente_id=cl.cliente_id
                       JOIN cf_tipobaremo tb ON bm.tipobaremo_id=tb.tipobaremo_id
                       JOIN dt_contrato ct ON bm.contrato_id=ct.contrato_id
                       $filtro1
                       $filtro2    
		        AND bm.baremo_estado=1";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {


            $urlEdit = '"lib/1config/vista/formDataBaremo.php","contenido","' . $row['baremo_id'] . '"';
            $tabla .= "<tr>                
                <td>" . utf8_encode($row['cliente_descripcion'] . " " . $row['usuario_nombre']) . "</td>                     
                <td>" . $row['contrato_numero'] . "</td>                
                <td>" . $row['tipobaremo_descripcion'] . "</td>                
                <td>" . $row['baremo_item'] . "</td>                     
                <td>" . number_format((float)$row['baremo_totalsiniva'], 0, ',', '.') . "</td>                                             
                <td><button class='btn btn-default'  onclick='loadingFunctions(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Editar  </button>
                    <button class='btn btn-danger'  onclick='DeleteBaremo(" . $row['baremo_id'] . ")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>Eliminar  </button>                    
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

    public function ListAlcanceAociadosActividad($data) {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                           <th>Descripción</th> 
                            <th>Agregar</th>                                                                                                                                                                                                                                 
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_ptalcancesubactividad('1','','','','','','','','" . $data['detalleactividad_id'] . "');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        $sql_presupuesto = "CALL SP_ptpresupuesto('10','" . trim($data['presupuesto_id']) . "','','','','','','','','','','','','','','','','','','','','');";

        $resultado_presupuesto = $obj_bd->EjecutaConsulta($sql_presupuesto);
        $array = $obj_bd->FuncionFetch($resultado_presupuesto);
        $alcances = $array['presupuesto_alcances'];
        $array_alcances = explode(",", $alcances);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            $tabla .= "<tr> 
                            <td>" . utf8_encode($row['alcance_descripcion']) . "</td>                                                                    
                            <td><input type='checkbox' value='" . $row['alcance_id'] . "' id='" . $row['alcance_id'] . "' name='Add[]' /><br/></td>                                                                                         
                       </tr>";

            //chekear los alcances
            for ($i = 0; $i < count($array_alcances); $i++) {
                if ($array_alcances[$i] == $row['alcance_id']) {

                    $tabla .= "<script> $('#" . $row['alcance_id'] . "').attr('checked', 'checked');</script>";
                } else {
                    
                }
            }
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                                         
                    <script>$('#example').DataTable();</script>";
        $tabla .= "<fieldset><button class='btn btn-success' onclick='UpdateAlcancesPresupuesto(" . $data['presupuesto_id'] . ")'>Guardar</button> ";
        return $tabla;
    }

    public function ListEntregablesAociadosActividad($data) {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                           <th>Descripción</th> 
                            <th>Agregar</th>                                                                                                                                                                                                                                 
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_ptentregablesubactividad('4','','','','','','','','" . $data['detalleactividad_id'] . "');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        $sql_presupuesto = "CALL SP_ptpresupuesto('10','" . trim($data['presupuesto_id']) . "','','','','','','','','','','','','','','','','','','','','');";

        $resultado_presupuesto = $obj_bd->EjecutaConsulta($sql_presupuesto);
        $array = $obj_bd->FuncionFetch($resultado_presupuesto);
        $entregables = $array['presupuesto_entregables'];
        $array_entregables = explode(",", $entregables);

        while ($row_ent = $obj_bd->FuncionFetch($resultado)) {

            $tabla .= "<tr> 
                            <td>" . utf8_encode($row_ent['entregable_descripcion']) . "</td>                                                                    
                            <td><input type='checkbox' value='" . $row_ent['entregable_id'] . "' id='ent_" . $row_ent['entregable_id'] . "' name='Add_ent[]' /><br/></td>                                                                                         
                       </tr>";

            //chekear los alcances
            for ($i = 0; $i < count($array_entregables); $i++) {
                if ($array_entregables[$i] == $row_ent['entregable_id']) {

                    $tabla .= "<script> $('#ent_" . $row_ent['entregable_id'] . "').attr('checked', 'checked');</script>";
                } else {
                    
                }
            }
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                                         
                    <script>$('#example').DataTable();</script>";
        $tabla .= "<fieldset><button class='btn btn-success' onclick='UpdateEntregablesPresupuesto(" . $data['presupuesto_id'] . ")'>Guardar</button> ";
        return $tabla;
    }

    function InfoBaremos() {

        $obj_bd = new BD();
        $tabla = "";


        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";

        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>                              
                            <th>Tipo Actividad</th>                              
                            <th>Item</th>                                                        
                            <th>Labor</th>                                                        
                            <th>Cliente</th>
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_ptBaremo('7','','','','','','','','','','','','','','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            $tabla .= "<tr>                
                <td>" . utf8_encode($row['tipobaremo_descripcion']) . " </td>                     
                <td>" . $row['item'] . "</td>                
                <td>" . utf8_encode($row['labor_descripcion']) . "</td>                     
                <td>" . utf8_encode($row['cliente_descripcion']) . "</td>                                             
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable();</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

}
