<?php
/**
 * Description of MD_presup
 *
 * @author jennifer
 */
include '../../0connection/BD_config.php';
include '../../0connection/connection.php';
include '../../0connection/BD.php';

session_start();

class MD_presup {



    function gritPresupuesto() {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
        .ui-dialog-titlebar-close {
            visibility: hidden
        }
        </style>";
        $tabla .= "<fieldset style='color:black'>";
        $tabla .= "<legend>Presupuestos Registrados</legend>";
        $url = "'lib/3presup/view/formEditPresup.php','contenido','0'";

        $tabla .= '<button name="btnAdd" id="btnAdd" class="btn btn-success" type="button" onclick="loadingFunctions(' . $url . ')"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></span<strong> Generar Presupuesto</strong></button>';
        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
        <thead>
        <tr>                              
        <th>No.</th>  
        <th>Estado</th>  
        <th>Cliente</th>
        <th>Subestacion</th>                                                  
        <th>Fecha Inicio</th>                                                        
        <th>Presupuesto</th>                                                    
        <th>Total + Incremento</th>     
        <th>Acción</th>
        </tr>
        </thead>
        <tbody>';

        $sql = "CALL SP_dtdetallepresupuesto('1','','','','','','','','','','','','','','','','','')";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            if ($row['detallepresupuesto_estado'] == "1") {
                $estado = "Registrado";
            }
            if ($row['detallepresupuesto_estado'] == '2') {
                $estado = "Pendiente";
            }
            if ($row['detallepresupuesto_estado'] == '3') {
                $estado = "Guardado";
            }
            if ($row['detallepresupuesto_estado'] == '4') {
                $estado = "Finalizado";
            }
            $urlEdit = '"lib/3presup/view/formEditPresup.php","contenido","' . $row['detallepresupuesto_id'] . '"';
            $tabla .= "<tr>                
            <td>" . $row['detallepresupuesto_id'] . "</td>                     
            <td>" . $estado . "</td>                     
            <td>" . $row['cliente_descripcion'] . "</td>                
            <td>" . utf8_encode($row['subestacion_nombre']) . "</td>                
            <td>" . $row['detallepresupuesto_fechaini'] . "</td>                
            <td>" . utf8_encode($row['detallepresupuesto_nombre']) . "</td>                                                                                                   
            <td>" . number_format((float) $row['total_presupuesto_incremento'], 0, ',', '.') . "</td>                                             
            <td><button class='btn btn-primary'  onclick='loadingFunctions(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Editar  </button>";
            if ($estado == "Registrado" || $estado == "Pendiente") {
                $tabla .= "<button class='btn btn-danger'  onclick='DeleteDetallePresupuesto(" . $row['detallepresupuesto_id'] . ",0)'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>Eliminar</button>";
            }
            $tabla .= "</td> 
            </tr>";
        }

        $tabla .= "</tbody>
        </table>
        </div>
        <script>$('#example').DataTable(
        {'order': [[ 0, 'desc' ]]});</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function ListSubestacion() {
        $obj_bd = new BD();

        $sql = "CALL SP_dtsubestacion('1','','','','','','','','','','','','','');";

        $resul = $obj_bd->EjecutaConsulta($sql);
        $retorno .= "<option value=''>-Seleccione-</option>";
        $retorno .= "<option value='0'>Nueva subestación</option>";
        while ($row = $obj_bd->FuncionFetch($resul)) {

            $retorno .= "<option value='" . $row['subestacion_id'] . "'>" . utf8_encode($row['subestacion_nombre']) . " </option>";
        }
        return $retorno;
    }

    public function ListContratClien() {
        $obj_bd = new BD();

        $sql = "CALL SP_dtCliente('6','','','','','','');";

        $resul = $obj_bd->EjecutaConsulta($sql);
        $retorno .= "<option value=''>-Seleccione-</option>";

        while ($row = $obj_bd->FuncionFetch($resul)) {

            $retorno .= "<option value='" . $row['contrato_id'] . "'>" . utf8_encode($row['cliente_descripcion']) . "-" . $row['contrato_numero'] . " </option>";
        }
        return $retorno;
    }

    public function saveSubestacion($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];


        //INSERTAR - ACTUALIZAMOS     
        $sql = "CALL SP_dtsubestacion('2','','" . trim(utf8_decode($data['slIva'])) . "','" . trim(utf8_decode($data['txt_cod'])) . "','','" . trim(utf8_decode($data['txt_fax'])) . "','','','" . trim(utf8_decode($data['txt_hicom'])) . "','" . trim(utf8_decode($data['txt_nombre'])) . "','" . trim(utf8_decode($data['txt_tel'])) . "','" . $id_usuario . "','','" . trim(utf8_decode($data['txt_ubicacion'])) . "');";

        $res = $obj_bd->EjecutaConsulta($sql);
        if (!$res)
            die('Invalid query ->' . mysqli_errno() . '->' . $res);

        $array = $obj_bd->FuncionFetch($res);
        $subestacion_id = $array['subestacion_id_insert'];



        if ($subestacion_id == 0 || $subestacion_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<subestacion_id>" . $subestacion_id . "</subestacion_id>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function SavePresupuesto($data) {
        $xml = "";
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        

        //INSERTAR PRESUPUESTO    
        $alcance = preg_replace("/\s+/", " ", $data['txt_alcance']);
        $objeto = preg_replace("/\s+/", " ", $data['txt_Objetivo']);
        if ($data['detallepresupuesto_id'] != "") {
            $sql_PRES = "CALL SP_dtdetallepresupuesto('6','" . $data['detallepresupuesto_id'] . "','" . trim(utf8_decode($alcance)) . "','','" . trim($data['txtPresInicio']) . "','" . trim($data['txtPresFin']) . "','','','" . $data['slGestor'] . "','" . trim(utf8_decode($data['txt_presupuesto'])) . "','" . trim(utf8_decode($objeto)) . "','','" . $id_usuario . "','','" . $data['slSubestacion'] . "','" . $data['slCliente'] . "','','" . $data['txt_gestorCodensa'] . "');";




        } else {
            $sql_PRES = "CALL SP_dtdetallepresupuesto('2','','" . trim(utf8_decode($alcance)) . "','','" . trim($data['txtPresInicio']) . "','" . trim($data['txtPresFin']) . "','','','" . $data['slGestor'] . "','" . trim(utf8_decode($data['txt_presupuesto'])) . "','" . trim(utf8_decode($objeto)) . "','','" . $id_usuario . "','','" . $data['slSubestacion'] . "','" . $data['slCliente'] . "','','" . trim(utf8_decode($data['txt_gestorCodensa'])) . "');";

        }

        $res_PRES = $obj_bd->EjecutaConsulta($sql_PRES);
        if (!$res_PRES)
            die('Invalid query ->' . mysqli_errno() . '->' . $res_PRES);

        $array = $obj_bd->FuncionFetch($res_PRES);
        $detallepresupuesto_id = $array['detallepresupuesto_id_insert'];

        /*
        Creamos carpetas para guardar archivos de visita tecnica
         */
        $carpeta = $detallepresupuesto_id;
        $ruta = 'C:/Presupuestos/'. $carpeta;
        if (!file_exists($ruta)) {
            mkdir($ruta);
        }

        /* Actualizar baremos a contraato */
        $sql_upd_contrato = "CALL SP_ptpresupuesto('23','" . $data['slCliente'] . "','','','','','','','','','','','','','','','" . $detallepresupuesto_id . "',
        '','','','','');";

        $res_update_contrato = $obj_bd->EjecutaConsulta($sql_upd_contrato);
        if (!$res_update_contrato)
            die('Invalid query ->' . mysqli_errno() . '->' . $res_update_contrato);
        /* Fin Actualizar baremos a contrato */

        if ($detallepresupuesto_id == 0 || $detallepresupuesto_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<detallepresupuesto_id>" . $detallepresupuesto_id . "</detallepresupuesto_id>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function JsonSubestacion($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_dtsubestacion('3','','','" . $data['cod_sub'] . "','','','','','','','','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['subestacion_id'] = $array['subestacion_id'];
        $arreglo_retorno['subestacion_aplicaiva'] = $array['subestacion_aplicaiva'];
        $arreglo_retorno['subestacion_codigo'] = $array['subestacion_codigo'];
        $arreglo_retorno['subestacion_fax'] = $array['subestacion_fax'];
        $arreglo_retorno['subestacion_hicom'] = $array['subestacion_hicom'];
        $arreglo_retorno['subestacion_nombre'] = utf8_encode($array['subestacion_nombre']);
        $arreglo_retorno['subestacion_telefono'] = $array['subestacion_telefono'];
        $arreglo_retorno['subestacion_ubicacion'] = $array['subestacion_ubicacion'];

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function ListModulo() {
        $arreglo_retorno = array();
        $arreglo_modulo = array();
        $obj_bd = new BD();

        $sql = "CALL SP_cfmodulo('1','','','','','','','');";

        $resul = $obj_bd->EjecutaConsulta($sql);
        $i = 0;
        while ($row = $obj_bd->FuncionFetch($resul)) {
            $arreglo_modulo[$i]['modulo_id'] = $row['modulo_id'];
            $arreglo_modulo[$i]['modulo_descripcion'] = utf8_encode($row['modulo_descripcion']);
            $i++;
        }
        $arreglo_retorno['MODULO'] = $arreglo_modulo;
        $json = json_encode($arreglo_retorno);
        return $json;

//        $retorno .= "<option value=''>-Seleccione-</option>";
//        $retorno .= "<option value='nuevo'>Nuevo - Modificar</option>";
//        while ($row = $obj_bd->FuncionFetch($resul)) {
//
//            $retorno .= "<option value='" . $row['modulo_id'] . "'>" . utf8_encode($row['modulo_descripcion']) . " </option>";
//        }
//        return $retorno;
    }

    public function ListGestor() {
        $obj_bd = new BD();

        $sql = "CALL SP_dtusuario('4',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',                    
        ''
    );";

    $resul = $obj_bd->EjecutaConsulta($sql);
    $retorno .= "<option value=''>-Seleccione-</option>";
    while ($row = $obj_bd->FuncionFetch($resul)) {

        $retorno .= "<option value='" . $row['usuario_id'] . "'>" . utf8_encode($row['usuario_apellidos']) . ' ' . utf8_encode($row['usuario_nombre']) . " </option>";
    }
    return $retorno;
}

public function ListarPmCodensa() {
    $obj_bd = new BD();

    $sql = "CALL SP_dtusuario('6',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',                    
    ''
);";

$resul = $obj_bd->EjecutaConsulta($sql);
$retorno .= "<option value=''>-Seleccione-</option>";
while ($row = $obj_bd->FuncionFetch($resul)) {

    $retorno .= "<option value='" . $row['usuario_id'] . "'>" . utf8_encode($row['usuario_apellidos']) . ' ' . utf8_encode($row['usuario_nombre']) . " </option>";


}
return $retorno;
}

public function dataBaremoItemPresupuesto($data) {

    $obj_bd = new BD();
    $tabla = "";

    $tabla .= "<style>
    .ui-dialog-titlebar-close {
        visibility: hidden;
    }
    </style>";
    $tabla .= "<fieldset>";
        // $tabla .= "<legend>Actividades</legend>";
    $tabla .= "<br>";
    $tabla .= '<div class="table-responsive">';
    $tabla .= '<form id="actividad_presupuesto">';
    $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
    <thead>
    <tr>
    <th>Actividad</th>
    <th>Subactividad</th> 
    <th>Alcances</th>
    <th>Entregables</th> 

    <th>Factor</th>
    <th>Valor sin IVA</th>                           
    </tr>
    </thead>
    <tbody id="bm_actividad">';

    $sql = "CALL SP_ptBaremo('6','','','','','" . trim($data['item']) . "','','','','','','','" . trim($data['cliente_contrato']) . "','','" . trim($data['tipoBaremo']) . "');";
    $resultado = $obj_bd->EjecutaConsulta($sql);
    $resultado_num = $obj_bd->Filas($sql);

    if ($resultado_num > 0) {

        while ($row = $obj_bd->FuncionFetch($resultado)) {
            $actividad_valordecimal = $row['actividad_valordecimal'];
            $baremo_id = $row['baremo_id'];
            $labor_descripcion = $row['labor_descripcion'];
            $item = $row['baremo_item'];
            $sigla = $row['tipobaremo_sigla'];
            $labor_valor = $row['baremo_valortotalact'];
            $tabla .= "<script type='text/javascript'>  $('#desc_labor').html('" . $sigla . "-" . $item . ": " . utf8_encode($labor_descripcion) . "'); 
            $('#valor_labor').html('$" . number_format((float) $labor_valor, 0, ',', '.') . "'); 
            $('#contenido_labor').css('display', 'block');
            $('#contenido_labor_valor').css('display', 'block');</script>";


            /* validar si tiene sub actividades */
            $sql_subactividades = "CALL SP_ptdetalleactividad('5','','','','','','','','','','','" . $row['baremoactividad_id'] . "','" . trim($data['cliente_contrato']) . "');";
            $num_sub = $obj_bd->Filas($sql_subactividades);
            if ($num_sub > 0) {
                $resultado_sub = $obj_bd->EjecutaConsulta($sql_subactividades);
                $tabla .= "<tr><td rowspan='3'>" . utf8_encode($row['actividad_descripcion']) . "</td></tr>";
                while ($row_sub = $obj_bd->FuncionFetch($resultado_sub)) {

                    /* alcances */
                    $sql_alcances = "CALL SP_ptalcancesubactividad('1','','','','','','','" . trim($data['cliente_contrato']) . "','" . $row_sub['detalleactividad_id'] . "');";
                    $resultado_alcances = $obj_bd->EjecutaConsulta($sql_alcances);
                    $array_alcances = "";

                    while ($row_alcances = $obj_bd->FuncionFetch($resultado_alcances)) {

                        $array_alcances .= "<input type='checkbox' value='" . $row_alcances['alcance_id'] . "' id='" . $row_alcances['alcance_id'] . "_" . $row_sub['detalleactividad_id'] . "' name='Add_alcances[]' class='input-medium chk_alcance' checked/> " . utf8_encode($row_alcances['alcance_descripcion']) . "</p>";
                    }
                    /**/

                    /* Entregables */
                    $sql_entregables = "CALL SP_ptentregablesubactividad('4','','','','','','','" . trim($data['cliente_contrato']) . "','" . $row_sub['detalleactividad_id'] . "');";
                    $resultado_entregables = $obj_bd->EjecutaConsulta($sql_entregables);
                    $array_entregables = "";
                    while ($row_entregable = $obj_bd->FuncionFetch($resultado_entregables)) {
                        $array_entregables .= "<input type='checkbox' value='" . $row_entregable['entregable_id'] . "' id='" . $row_entregable['entregable_id'] . "_" . $row_sub['detalleactividad_id'] . "' name='Add_entregable[]' checked/> " . utf8_encode($row_entregable['entregable_descripcion']) . "</p>";
                    }
                    /**/

                    $tabla .= "<tr>
                    <td>" . utf8_encode($row_sub['subactividad_descripcion']) . "</td>
                    <td>" . $array_alcances . "</td>
                    <td>" . $array_entregables . "</td>

                    <td><input type='text' id='porc_sub_" . $row_sub['detalleactividad_id'] . "' name='porc_sub_" . $row_sub['detalleactividad_id'] . "' maxlength='6' value='" . $row_sub['detallesubactividad_porc'] . "' placeholder='Numero' style='width:60px' class='input-medium a_txt_porc' onkeypress='return decimales(event)' onblur='CalValorPorcPresupuestoSub(this.value," . $row_sub['detalleactividad_id'] . "," . $actividad_valordecimal . "," . $row_sub['detallesubactividad_porc'] . ");'></td>
                    <td><input type='text' id='valor_cal_sub_" . $row_sub['detalleactividad_id'] . "' name='valor_cal_sub_" . $row_sub['detalleactividad_id'] . "' value='" . number_format((float) $row_sub['detallesubactividad_costosiniva'], 0, ',', '.') . "'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'></td>
                    </tr>
                    <input type='hidden' name='detalleactividad_id[]' id='detalleactividad_id[]' value='" . $row_sub['detalleactividad_id'] . "_" . $row['baremoactividad_id'] . "'>";
                }
            } else {
                $tabla .= "<tr><td rowspan='2'>" . utf8_encode($row['actividad_descripcion']) . "</td></tr>";
                $tabla .= "<tr>
                <td></td>
                <td></td>
                <td></td>
                <td><input type='text' id='porc_act_" . $row['baremoactividad_id'] . "' name='porc_act_" . $row['baremoactividad_id'] . "' maxlength='6' value='1' placeholder='Numero' style='width:60px' class='input-medium a_txt_porc' onkeypress='return decimales(event)' onblur='CalValorPorcPresupuesto(this.value," . $row['baremoactividad_id'] . "," . $actividad_valordecimal . ");'></td>
                <td><input type='text' id='valor_cal_act_" . $row['baremoactividad_id'] . "' name='valor_cal_act_" . $row['baremoactividad_id'] . "' value='" . number_format((float) $row['actividad_valorservicio'], 0, ',', '.') . "'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'></td>                    
                <input type='hidden' name='detalleactividad_id[]' id='detalleactividad_id[]' value='0_" . $row['baremoactividad_id'] . "'>";
            }

            $tabla .= "<input type='hidden' name='baremoactividad_id[]' id='baremoactividad_id[]' value='" . $row['baremoactividad_id'] . "'>                     
            </tr>";
        }

        $tabla .= "</tbody>
        </table></form>
        </div>
        ";
        $tabla .= "<fieldset>";
        $tabla .= '<button name="btnGuardar" id="btnGuardar" class="btn btn-primary" type="button" onclick="SaveActividadPresupuesto(' . $baremo_id . ')">Guardar</button>';
        return $tabla;
    } else {
        return 0;
    }
}

public function SaveActividadPresupuesto($data) {
    $xml = "";
    $obj_bd = new BD();
    $id_usuario = $_SESSION['Usuario']['usuario_id'];

    $array_subactividades = explode(",", $data['param_txt_subactividad_id']);
    $array_valor_procentaje = explode("|", $data['param_valor_porc']);
    $array_baremoactividad_id = explode(",", $data['baremoactividad_id']);
    $array_detalleactividad_id = explode(",", $data['detalleactividad_id']);

    /* DATOS DE LA ACTIVIDAD */
    $baremo_id = $data['baremo_id'];
    $detallepresupuesto_id = $data['detallepresupuesto_id'];
    $slTipActividad = $data['slTipActividad'];
    $slModulo = $data['slModulo'];
    $txt_modulo = $data['txt_modulo'];
    $txt_Obs = $data['txt_Obs'];
    $txt_tot_pres = $data['txt_tot_pres'];

        /*$totalIncrementos= $data['totalIncrementos'];
        $incremento_90dias= $data['incremento_90dias'];
        $incremento_ubicacion= $data['incremento_ubicacion'];
        $check= $data['check'];

        if ($check == 1) {
                 //Eliminar presupuestos anteriores
                //$sql = "CALL SP_dtdetallepresupuesto('10','" . $detallepresupuesto_id . "','','','','','','','','','','','','','','','','');";

                //$result = $obj_bd->EjecutaConsulta($sql);


                $ubicacion1 = str_replace('.', '', $ubicacion);

                $sql1 = "insert into dt_incrementosnueva (incrementosNueva_idtipo,incrementosNueva_tipo,incrementosNueva_porcentaje,incrementosNueva_valor,detallepresupuesto_id) values (1,'Actividades de Levantamento','0.015','". $ubicacion1 ."','". $detallepresupuesto_id ."');";

                $result1 = $obj_bd->EjecutaConsulta($sql1);

            }else{

            }*/
        //validar el modulo
            if ($txt_modulo != "") {

            //INSERTAR MODULO     
                $sql_modulo = "CALL SP_cfmodulo('2','','" . trim(utf8_decode($data['txt_modulo'])) . "','','','','" . $id_usuario . "','');";

                $res_modulo = $obj_bd->EjecutaConsulta($sql_modulo);
                if (!$res_modulo)
                    die('Invalid query ->' . mysqli_errno() . '->' . $res_modulo);

                $array = $obj_bd->FuncionFetch($res_modulo);
                $modulo_id = $array['modulo_id_insert'];
            }else {
                $modulo_id = $slModulo;
            }

            for ($i = 0; $i < count($array_detalleactividad_id); $i++) {

                $baremodetalleactividadactividad_id = explode("_", $array_detalleactividad_id[$i]);
                $porcentaje_actividad_baremo = explode(":", $array_subactividades[$i]);
                $valor_porcentaje_actividad_baremo = explode(":", $array_valor_procentaje[$i]);


                $baremoactividad_id = $baremodetalleactividadactividad_id[1];
                $detalleactividad_id = $baremodetalleactividadactividad_id[0];
                $porc = $porcentaje_actividad_baremo[1];
                $valor_porc = $valor_porcentaje_actividad_baremo[1];
                $valor_sinPuntos = str_replace('.', '', $valor_porc);
                $valor_decimal = str_replace(',', '.', $valor_sinPuntos);

            //alcances
                $arreglo_alcance = "";
                $alcances_exp = explode("|", $data['alcances']);
                for ($a = 0; $a < count($alcances_exp); $a++) {
                    $alcances_detalleactividad_id = explode(":", $alcances_exp[$a]);
                    $valida_detalleactivida = $alcances_detalleactividad_id[1] . "_" . $detalleactividad_id;
                    if ($alcances_detalleactividad_id[0] == $valida_detalleactivida) {
                        $arreglo_alcance .= $alcances_detalleactividad_id[1] . ",";
                    }
                }
                $alcances = substr($arreglo_alcance, 0, -1);
            /* $list_alcacnes = "";
              $sql_alcances = "CALL SP_ptalcancesubactividad('4','','','','','','','','" . $detalleactividad_id . "');";

              $resul_alcances = $obj_bd->EjecutaConsulta($sql_alcances);
              while ($row = $obj_bd->FuncionFetch($resul_alcances)) {

              $list_alcacnes .= "" . $row['alcance_id'] . ",";
              }
              $alcances = trim($list_alcacnes, ','); */

            //entregables
              $arreglo_entregables = "";
              $entregables_exp = explode("|", $data['entregables']);
              for ($e = 0; $e < count($entregables_exp); $e++) {
                $entregable_detalleactividad_id = explode(":", $entregables_exp[$e]);
                $valida_detalleactivida_et = $entregable_detalleactividad_id[1] . "_" . $detalleactividad_id;
                if ($entregable_detalleactividad_id[0] == $valida_detalleactivida_et) {
                    $arreglo_entregables .= $entregable_detalleactividad_id[1] . ",";
                }
            }
            $entregables = substr($arreglo_entregables, 0, -1);
            /* $list_entregables = "";
              $sql_entregables = "CALL SP_ptentregablesubactividad('4','','','','','','','','" . $detalleactividad_id . "');";


              $resul_entregables = $obj_bd->EjecutaConsulta($sql_entregables);
              while ($row = $obj_bd->FuncionFetch($resul_entregables)) {

              $list_entregables .= "" . $row['entregable_id'] . ",";
              }
              $entregables = trim($list_entregables, ','); */

            // echo " validar insert " . $baremoactividad_id . " - " . $detalleactividad_id . " - " . $porc . " - " . $valor_porc;
            //Insertar 
              $obs = preg_replace("/\s+/", " ", utf8_decode($txt_Obs));
              $sql = "CALL SP_ptpresupuesto('2','','" . $alcances . "','','" . $entregables . "','','','','','','" . trim($obs) . "','" . trim($porc) . "','" . $id_usuario . "','','" . $valor_decimal . "','','" . $detallepresupuesto_id . "','" . $baremoactividad_id . "','" . $baremo_id . "','" . $detalleactividad_id . "','" . $modulo_id . "','" . $slTipActividad . "');";
              $res = $obj_bd->EjecutaConsulta($sql);
              if (!$res)
                die('Invalid query ->' . mysqli_errno() . '->' . $res);

            $array = $obj_bd->FuncionFetch($res);
            $presupuesto_id_insert = $array['presupuesto_id_insert'];
        }


        if ($presupuesto_id_insert == 0 || $presupuesto_id_insert == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function DeleteDetallePresupuesto($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql = "CALL SP_dtdetallepresupuesto('3','" . trim($data['detallepresupuesto_id']) . "','','" . $data['estado'] . "','','','','','','','','','','" . $id_usuario . "','','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function JsonDetallePresupuesto($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_dtdetallepresupuesto('4','" . $data['detallepresupuesto_id'] . "','','','','','','','','','','','','','','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);
        $total_final = $array['detallepresupuesto_valorincremento'] + $array['detallepresupuesto_total'];
        $arreglo_retorno['detallepresupuesto_id'] = $array['detallepresupuesto_id'];
        $arreglo_retorno['detallepresupuesto_nombre'] = utf8_encode($array['detallepresupuesto_nombre']);
        $arreglo_retorno['contrato_id'] = $array['contrato_id'];
        $arreglo_retorno['subestacion_id'] = $array['subestacion_id'];
        $arreglo_retorno['detallepresupuesto_gestor'] = $array['detallepresupuesto_gestor'];
        $arreglo_retorno['detallepresupuesto_codensagestor'] = utf8_encode($array['detallepresupuesto_codensagestor']);
        $arreglo_retorno['detallepresupuesto_alcance'] = utf8_encode($array['detallepresupuesto_alcance']);
        $arreglo_retorno['detallepresupuesto_objeto'] = utf8_encode($array['detallepresupuesto_objeto']);
        $arreglo_retorno['baremo_valortotalAct'] = $array['baremo_valortotalact'];
        $arreglo_retorno['detallepresupuesto_fechaini'] = $array['detallepresupuesto_fechaini'];
        $arreglo_retorno['detallepresupuesto_fechafin'] = $array['detallepresupuesto_fechafin'];
        $arreglo_retorno['detallepresupuesto_porcentincremento'] = $array['detallepresupuesto_porcentincremento'];
        $arreglo_retorno['detallepresupuesto_valorincremento'] = $array['detallepresupuesto_valorincremento'];
        $arreglo_retorno['detallepresupuesto_total'] = $array['detallepresupuesto_total'];
        $arreglo_retorno['detallepresupuesto_total_formato'] =number_format((float)$array['detallepresupuesto_total'], 0, ',', '.');
        $arreglo_retorno['detallepresupuesto_incremento_formato'] = number_format((float) $array['detallepresupuesto_valorincremento'], 0, ',', '.');
        $arreglo_retorno['total_final_presupuesto_formato'] =number_format((float) $total_final, 0, ',', '.');
        $arreglo_retorno['detallepresupuesto_tipoincremento'] = $array['detallepresupuesto_tipoincremento'];

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function ListActividadesPresupuesto($data) {

        $obj_bd = new BD();
        $tabla = "";
        $table_name = "'example_buscar'";
        /*                        <tr>
          <th colspan="4"></th>
          <th colspan="2"><input type="text" id="txt_filtro" name="txt_filtro" onkeyup="busTabla(this, '.$table_name.')"/></th>
          </tr> */
          $tabla .= "
          <style>
          .ui-dialog-titlebar-close {
            visibility: hidden;
        }
        </style>";
        $tabla .= "<br><fieldset>";
        $tabla .= "<legend>Alcance Técnico OT</legend>";
        $tabla .= '<div class="row" id="div_copiar">
        <div class="col-sm-4"><select id="sl_copiar_md" name="sl_copiar_md" class="form-control" ></select></div>
        <div class="col-sm-8"><button name="btnAdd" id="btnAdd" class="btn btn-default" type="button" onclick="CopiLabores(' . trim($data['detallepresupuesto_id']) . ')">Copiar y Guardar</button></div>
        </div>';
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<form id="presupuesto_actividades_asoc">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example_buscar">
        <thead>
        <tr>
        <th>Sel</th> 
        <th>Modulo</th>
        <th>Labor</th> 
        <th>Alcance técnico particular</th>                            
        <th>Total</th>
        <th>Valor % Labor </th>
        <th>Accion</th>                           
        </tr>
        </thead>
        <tbody>';

         /*$sql1 = "CALL SP_ptpresupuesto('1','" . trim($data['detallepresupuesto_id']) . "','','','','','','','','','','','','','','','','','','','','');";


        $result = $obj_bd->EjecutaConsulta($sql1);
        $array = $obj_bd->FuncionFetch($result);

*/

        /**
         * Inicio listar actividades del presupuesto
         */

        $sql = "CALL SP_ptpresupuesto('3','','','','','','','','','','','','','','','','" . trim($data['detallepresupuesto_id']) . "','','','','','');";

        $resultado = $obj_bd->EjecutaConsulta($sql);
        while ($row = $obj_bd->FuncionFetch($resultado)) {

            $obs = '"' . preg_replace("/\s+/", " ", utf8_encode($row['presupuesto_obs'])) . '"'; 
            $tabla .= "
            <tr>                      
            <td><input type='checkbox' value='" . $row['presupuesto_id'] . "' id='" . $row['presupuesto_id'] . "' name='chek_copiar[]'  /></td>      
            <td>" . utf8_encode($row['modulo_descripcion']) . "</td>
            <td>" . utf8_encode($row['item'] . " " . $row['labor_descripcion']) . "</td>                     
            <td>" . utf8_encode($row['presupuesto_obs']) . "</td>                                                          
            <td>" . number_format((float) $row['total_actividad'], 0, ',','.') . "</td>";

            //calculamos el porcentaje de la actividad con respecto a el costo total presupuesto
            $totalPorcentajeActividad= ($row['total_actividad'] / $row['detallepresupuesto_total'])*100;

            $tabla .="<td>" . number_format((float) $totalPorcentajeActividad, 0, ',','.') . "%" . "</td>
            <td><input type='button' class='btn btn-primary'  onclick='EditarActividadPresupuesto(" . $row['baremo_id'] . "," . $row['tipobaremo_id'] . "," . $row['detallepresupuesto_id'] . "," . $row['modulo_id'] . ",0," . trim($obs) . ");' value='Editar'/>                     
            <input type='button' class='btn btn-danger'  onclick='DeletePresupuestoActividad(" . $row['baremo_id'] . "," . $row['detallepresupuesto_id'] . "," . $row['modulo_id'] . "," . $obs . ");' value='Eliminar' />       

            </td>
            </tr>";
        }
        //<img src='img/borrar.jpg'  title='Eliminar Actividad' width='20' height='20' id='Elim' style='cursor:pointer' border='0' onclick='DeletePresupuestoActividad(" . $row['baremo_id'] . "," . $row['detallepresupuesto_id'] . "," . $row['modulo_id'] . "," . $obs . ")'>                    
        // <td><img src='img/b_edit.png' id='arbol' title='Editar Actividad' width='20' height='20' style='cursor:pointer' border='0' onclick='EditarActividadPresupuesto(" . $row['baremo_id'] . "," . $row['tipobaremo_id'] . "," . $row['detallepresupuesto_id'] . "," . $row['modulo_id'] . ",0," . trim($obs) . ");'> 
// <img src='img/entregable.png' id='arbol' title='Entregable de la Actividad' width='20' height='20' style='cursor:pointer' border='0' onclick='DivAlcancesEntregables(" . $row['presupuesto_id'] . "," . $row['detallepresupuesto_id'] . ",2);'> 
//<img src='img/config.png' id='arbol' title='Alcences de la Actividad' width='20' height='20' style='cursor:pointer' border='0' onclick='DivAlcancesEntregables(" . $row['presupuesto_id'] . "," . $row['detallepresupuesto_id'] . ",1);'> 
        $tabla .= "</tbody>
        </table></form>
        </div>
        ";
        $tabla .= "<fieldset><script type='text/javascript'>
        ListModuloCopiar('sl_copiar_md');
        </script>";
        $tabla .= '<button name="btnNew" id="btnNew" class="btn btn-basic" type="button" onclick="MostrarNuevaActividad()">Nueva Actividad</button>';
        return $tabla;
    }

//actualizar procedimiento para mostrar automaticamente
    public function DeletePresupuestoActividad($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql = "CALL SP_ptpresupuesto('4','','','','','','','','','','" . trim(utf8_decode($data['obs'])) . "','','','" . $id_usuario . "','','','" . trim($data['detallepresupuesto_id']) . "','','" . trim($data['baremo_id']) . "','','" . trim($data['modulo_id']) . "','');";


        $result = $obj_bd->EjecutaConsulta($sql);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function JsonDetalleActividad($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_ptpresupuesto('7','','','','','','','','','','','','','','','','" . trim($data['detallepresupuesto_id']) . "','','" . trim($data['baremo_id']) . "','','" . trim($data['modulo_id']) . "','" . trim($data['tipobaremo_id']) . "');";


        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['tipobaremo_id'] = $array['tipobaremo_id'];
        $arreglo_retorno['baremo_item'] = utf8_encode($array['baremo_item']);
        $arreglo_retorno['modulo_id'] = $array['modulo_id'];
        $arreglo_retorno['presupuesto_obs'] = utf8_encode($array['presupuesto_obs']);
        $arreglo_retorno['detallepresupuesto_total'] = number_format((float) $array['detallepresupuesto_total'], 0, ',', '.');

        $sql_labor = "CALL SP_ptBaremo('6','','','','','" . trim($array['baremo_item']) . "','','','','','','','" . $array['contrato_id'] . "','','" . trim($array['tipobaremo_id']) . "');";
        $result_labor = $obj_bd->EjecutaConsulta($sql_labor);
        $array_labor = $obj_bd->FuncionFetch($result_labor);
        $arreglo_retorno['labor'] = utf8_encode($array_labor['labor_descripcion']);
        $arreglo_retorno['tipobaremo_sigla'] = utf8_encode($array_labor['tipobaremo_sigla']);

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function UpdateDataBaremoPresupuesto($data) {

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
        $tabla .= '<form id="update_actividad_presupuesto">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
        <thead>
        <tr>';
        if ($data['control'] == "1") {

            $tabla .= '    
            <th>Actividad</th>
            <th>Subactividad</th> 
            <th>Alcances</th>
            <th>Entregables</th> 

            <th>Factor</th>
            <th>Valor sin IVA</th>
            <th>Accion</th>';
        } else {
            $tabla .= '    <th>Actividad</th>
            <th>Subactividad</th> 
            <th>Alcances</th>
            <th>Entregables</th>

            <th>Factor</th>
            <th>Valor sin IVA</th>';
        }

        $tabla .= '</tr>
        </thead>
        <tbody>';

        $sql = "CALL SP_ptpresupuesto('5','','','','','','','','','','" . trim(utf8_decode($data['obs'])) . "','','','','','','" . trim($data['detallepresupuesto_id']) . "','','" . trim($data['baremo_id']) . "','','" . trim($data['modulo_id']) . "','" . trim($data['tipobaremo_id']) . "');";

        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {
            /* traer el valor decimal de la actividad */
            $actividad_valordecimal = $row['actividad_valordecimal'];
            /**/



            /* validar si tiene sub actividades */
            $sql_subactividades = "CALL SP_ptpresupuesto('6','','','','','','','','','','" . trim(utf8_decode($data['obs'])) . "','','','','','','" . trim($data['detallepresupuesto_id']) . "','" . $row['baremoactividad_id'] . "','','','" . trim($data['modulo_id']) . "','');";

            $num_sub = $obj_bd->Filas($sql_subactividades);
            if ($num_sub > 0) {
                $num_sub_tb = $num_sub + 1;
                $tabla .= "<tr>";
                if ($data['control'] == "1") {
                    $tabla .= "
                    <td rowspan='" . $num_sub_tb . "'>" . utf8_encode($row['actividad_descripcion']) . "</td>";
                } else {
                    $tabla .= "<td rowspan='" . $num_sub_tb . "'>" . utf8_encode($row['actividad_descripcion']) . "</td>";
                }
                $tabla .= "</tr>";

                $resultado_sub = $obj_bd->EjecutaConsulta($sql_subactividades);


                while ($row_sub = $obj_bd->FuncionFetch($resultado_sub)) {
                    if ($data['control'] == "1") {
                        /* alcances */
                        $sql_alcances = "CALL SP_ptalcancesubactividad('1','','','','','','','" . $row_sub['contrato_id'] . " ','" . $row_sub['detalleactividad_id'] . "');";
                        $resultado_alcances = $obj_bd->EjecutaConsulta($sql_alcances);
                        $array_alcances = "";
                        $alcances_pt = $row_sub['presupuesto_alcances'];
                        $array_alcances_pt = explode(",", $alcances_pt);

                        while ($row_alcances = $obj_bd->FuncionFetch($resultado_alcances)) {

                            //$array_alcances .= "<input type='checkbox' value='" . $row_alcances['alcance_id'] . "' id='" . $row_alcances['alcance_id'] . "_" . $row_sub['detalleactividad_id'] . "' name='Add_alcances[]' disabled /> " . utf8_encode($row_alcances['alcance_descripcion']) . "</p>";
                            if ($alcances_pt != "") {

                                for ($i = 0; $i < count($array_alcances_pt); $i++) {
                                    if ($array_alcances_pt[$i] == $row_alcances['alcance_id']) {
                                        $array_alcances .= "<input type='checkbox' value='" . $row_alcances['alcance_id'] . "' id='" . $row_alcances['alcance_id'] . "_" . $row_sub['detalleactividad_id'] . "' name='Add_alcances[]' disabled /> " . utf8_encode($row_alcances['alcance_descripcion']) . "</p>";

                                        $array_alcances .= "<script> $('#" . $row_alcances['alcance_id'] . "_" . $row_sub['detalleactividad_id'] . "').attr('checked', 'checked');</script>";
                                    }
                                }
                            }
                        }
                        /**/

                        /* Entregables */
                        $sql_entregables = "CALL SP_ptentregablesubactividad('4','','','','','','','" . $row_sub['contrato_id'] . "','" . $row_sub['detalleactividad_id'] . "');";
                        $resultado_entregables = $obj_bd->EjecutaConsulta($sql_entregables);
                        $array_entregables = "";
                        $entregables_pt = $row_sub['presupuesto_entregables'];
                        $array_entregables_pt = explode(",", $entregables_pt);

                        while ($row_entregable = $obj_bd->FuncionFetch($resultado_entregables)) {
                            //$array_entregables .= "<input type='checkbox' value='" . $row_entregable['entregable_id'] . "' id='" . $row_entregable['entregable_id'] . "_" . $row_sub['detalleactividad_id'] . "' name='Add_entregable[]' disabled/> " . utf8_encode($row_entregable['entregable_descripcion']) . "</p>";

                            if ($entregables_pt != "") {

                                for ($j = 0; $j < count($array_entregables_pt); $j++) {
                                    if ($array_entregables_pt[$j] == $row_entregable['entregable_id']) {
                                        $array_entregables .= "<input type='checkbox' value='" . $row_entregable['entregable_id'] . "' id='" . $row_entregable['entregable_id'] . "_" . $row_sub['detalleactividad_id'] . "' name='Add_entregable[]' disabled/> " . utf8_encode($row_entregable['entregable_descripcion']) . "</p>";
                                        $array_entregables .= "<script> $('#" . $row_entregable['entregable_id'] . "_" . $row_sub['detalleactividad_id'] . "').attr('checked', 'checked');</script>";
                                    }
                                }
                            }
                        }
                        /**/

                        $tabla .= "<tr>  
                        <td> " . utf8_encode($row_sub['subactividad_descripcion']) . "</td>
                        <td>$array_alcances</td>
                        <td>$array_entregables</td>

                        <td><input type='text' id='porc_sub_" . $row_sub['detalleactividad_id'] . "' name='porc_sub_" . $row_sub['detalleactividad_id'] . "' maxlength='6' value='" . $row_sub['presupuesto_porcentaje'] . "' placeholder='Numero' style='width:60px' class='input-medium a_txt_porc' onkeypress='return decimales(event)' disabled='disabled' onblur='CalValorPorcPresupuestoSub(this.value," . $row_sub['detalleactividad_id'] . "," . $actividad_valordecimal . "," . $row_sub['presupuesto_porcentaje'] . ");'></td>
                        <td><input type='text' id='valor_cal_sub_" . $row_sub['detalleactividad_id'] . "' name='valor_cal_sub_" . $row_sub['detalleactividad_id'] . "' value='" . number_format((float) $row_sub['presupuesto_valorporcentaje'], 0, ',', '.') . "'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'></td>";

                        if ($row_sub['presupuesto_porcentaje'] != '0' && $row_sub['presupuesto_porcentaje'] != '') {

                            if ($row_sub['presupuesto_encargado'] != "") {
                                // $tabla .= "<td><img src='img/prog_ok.png' id='arbol' title='Actividad Programada' width='20' height='20' style='cursor:pointer' border='0' onclick='DivProgramarOT(" . $row_sub['presupuesto_id'] . ")'>";
                                $tabla .= "<td><input type='button' id='bto_ok' name='bto_ok' class='btn btn-primary'  value='Programada' onclick='DivProgramarOT(" . $row_sub['presupuesto_id'] . ")'/>";
                                /* REALIZAR DESCARGO */
                                if (utf8_encode($row_sub['subactividad_descripcion']) == "LEVANTAMIENTO") {

                                    // $tabla .= "<img src='img/word2010.png' id='arbol' title='Generar Descargo' width='20' height='20' style='cursor:pointer' border='0' onclick='DivEditDescargo(" . $row_sub['ordentrabajo_id'] . "," . $row_sub['presupuesto_id'] . ")'>";
                                    $tabla .= "<input type='button' id='btoGuardar' name='btoGuardar' class='btn btn-primary' type='submit' value=' Descargo ' onclick='DivEditDescargo(" . $row_sub['ordentrabajo_id'] . "," . $row_sub['presupuesto_id'] . ")'/>";
                                }
                                /**/
                                $tabla . "</td>";
                            } else {
                                //$tabla .= "<td><img src='img/prog_add.png' id='arbol' title='Programar Actividad' width='20' height='20' style='cursor:pointer' border='0' onclick='DivProgramarOT(" . $row_sub['presupuesto_id'] . ")'>";
                                $tabla .= "<td><input type='button' id='bto_no' name='bto_no' class='btn btn-danger'  value='Programar' onclick='DivProgramarOT(" . $row_sub['presupuesto_id'] . ")'/>";
                                $tabla . "</td>";
                            }
                        }

                        $tabla .= "</tr>
                        <input type='hidden' name='detalleactividad_id[]' id='detalleactividad_id[]' value='" . $row_sub['presupuesto_id'] . "_" . $row_sub['detalleactividad_id'] . "_" . $row['baremoactividad_id'] . "'>";
                    } else {
                        /* alcances */
                        $sql_alcances = "CALL SP_ptalcancesubactividad('1','','','','','','','" . $row_sub['contrato_id'] . "','" . $row_sub['detalleactividad_id'] . "');";
                        $resultado_alcances = $obj_bd->EjecutaConsulta($sql_alcances);
                        $array_alcances = "";
                        $alcances_pt = $row_sub['presupuesto_alcances'];
                        $array_alcances_pt = explode(",", $alcances_pt);

                        while ($row_alcances = $obj_bd->FuncionFetch($resultado_alcances)) {

                            $array_alcances .= "<input type='checkbox' value='" . $row_alcances['alcance_id'] . "' id='" . $row_alcances['alcance_id'] . "_" . $row_sub['detalleactividad_id'] . "' name='Add_alcances[]' class='input-medium chk_alcance'/> " . utf8_encode($row_alcances['alcance_descripcion']) . "</p>";
                            if ($alcances_pt != "") {
                                for ($i = 0; $i < count($array_alcances_pt); $i++) {
                                    if ($array_alcances_pt[$i] == $row_alcances['alcance_id']) {
                                        $array_alcances .= "<script> $('#" . $row_alcances['alcance_id'] . "_" . $row_sub['detalleactividad_id'] . "').attr('checked', 'checked');</script>";
                                    }
                                }
                            } else {
                                $array_alcances .= "<script> $('#" . $row_alcances['alcance_id'] . "_" . $row_sub['detalleactividad_id'] . "').attr('checked', 'checked');</script>";
                            }
                        }
                        /**/

                        /* Entregables */
                        $sql_entregables = "CALL SP_ptentregablesubactividad('4','','','','','','','" . $row_sub['contrato_id'] . "','" . $row_sub['detalleactividad_id'] . "');";
                        $resultado_entregables = $obj_bd->EjecutaConsulta($sql_entregables);
                        $array_entregables = "";
                        $entregables_pt = $row_sub['presupuesto_entregables'];
                        $array_entregables_pt = explode(",", $entregables_pt);

                        while ($row_entregable = $obj_bd->FuncionFetch($resultado_entregables)) {
                            $array_entregables .= "<input type='checkbox' value='" . $row_entregable['entregable_id'] . "' id='" . $row_entregable['entregable_id'] . "_" . $row_sub['detalleactividad_id'] . "' name='Add_entregable[]' /> " . utf8_encode($row_entregable['entregable_descripcion']) . "</p>";

                            if ($entregables_pt != "") {

                                for ($j = 0; $j < count($array_entregables_pt); $j++) {
                                    if ($array_entregables_pt[$j] == $row_entregable['entregable_id']) {
                                        $array_entregables .= "<script> $('#" . $row_entregable['entregable_id'] . "_" . $row_sub['detalleactividad_id'] . "').attr('checked', 'checked');</script>";
                                    }
                                }
                            } else {
                                $array_entregables .= "<script> $('#" . $row_entregable['entregable_id'] . "_" . $row_sub['detalleactividad_id'] . "').attr('checked', 'checked');</script>";
                            }
                        }
                        /**/
                        $tabla .= "<tr>
                        <td>" . utf8_encode($row_sub['subactividad_descripcion']) . "</td>
                        <td>" . $array_alcances . "</td>
                        <td>" . $array_entregables . "</td>

                        <td><input type='text' id='porc_sub_" . $row_sub['detalleactividad_id'] . "' name='porc_sub_" . $row_sub['detalleactividad_id'] . "' maxlength='6' value='" . $row_sub['presupuesto_porcentaje'] . "' placeholder='Numero' style='width:60px' class='input-medium a_txt_porc' onkeypress='return decimales(event)' onblur='CalValorPorcPresupuestoSub(this.value," . $row_sub['detalleactividad_id'] . "," . $actividad_valordecimal . "," . $row_sub['presupuesto_porcentaje'] . ");'></td>
                        <td><input type='text' id='valor_cal_sub_" . $row_sub['detalleactividad_id'] . "' name='valor_cal_sub_" . $row_sub['detalleactividad_id'] . "' value='" . number_format((float) $row_sub['presupuesto_valorporcentaje'], 0, ',', '.') . "'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'></td>
                        </tr>
                        <input type='hidden' name='detalleactividad_id[]' id='detalleactividad_id[]' value='" . $row_sub['presupuesto_id'] . "_" . $row_sub['detalleactividad_id'] . "_" . $row['baremoactividad_id'] . "'>";
                    }
                }
            } else {

                if ($data['control'] == "1") {
                    $tabla .= "
                    <tr>       
                    <td rowspan='2'>" . utf8_encode($row['actividad_descripcion']) . "</td>                     
                    </tr>";
                } else {
                    $tabla .= "
                    <tr>                                   
                    <td rowspan='2'>" . utf8_encode($row['actividad_descripcion']) . "</td></tr>";
                }

                if ($data['control'] == "1") {
                    $tabla .= "<td></td>
                    <td></td>
                    <td></td>
                    <td><input type='text' id='porc_act_" . $row['baremoactividad_id'] . "' name='porc_act_" . $row['baremoactividad_id'] . "' maxlength='6' disabled='disabled' value='" . $row['presupuesto_porcentaje'] . "' placeholder='Numero' style='width:60px' class='input-medium a_txt_porc' onkeypress='return decimales(event)' onblur='CalValorPorcPresupuesto(this.value," . $row['baremoactividad_id'] . "," . $actividad_valordecimal . ");'></td>
                    <td><input type='text' id='valor_cal_act_" . $row['baremoactividad_id'] . "' name='valor_cal_act_" . $row['baremoactividad_id'] . "' value='" . number_format((float) $row['presupuesto_valorporcentaje'], 0, ',', '.') . "'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'></td>                    
                    <td><input type='button' id='bto_no' name='bto_no' class='btn btn-danger'  value='Programar' onclick='DivProgramarOT(" . $row['presupuesto_id'] . ")'>                                            
                    <input type='hidden' name='detalleactividad_id[]' id='detalleactividad_id[]' value='" . $row['presupuesto_id'] . "_0_" . $row['baremoactividad_id'] . "'>";
                } else {
                    $tabla .= "<td></td>
                    <td></td>
                    <td></td>
                    <td><input type='text' id='porc_act_" . $row['baremoactividad_id'] . "' name='porc_act_" . $row['baremoactividad_id'] . "' maxlength='6' value='" . $row['presupuesto_porcentaje'] . "' placeholder='Numero' style='width:60px' class='input-medium a_txt_porc' onkeypress='return decimales(event)' onblur='CalValorPorcPresupuesto(this.value," . $row['baremoactividad_id'] . "," . $actividad_valordecimal . ");'></td>
                    <td><input type='text' id='valor_cal_act_" . $row['baremoactividad_id'] . "' name='valor_cal_act_" . $row['baremoactividad_id'] . "' value='" . number_format((float) $row['presupuesto_valorporcentaje'], 0, ',', '.') . "'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'></td>                    
                    <input type='hidden' name='detalleactividad_id[]' id='detalleactividad_id[]' value='" . $row['presupuesto_id'] . "_0_" . $row['baremoactividad_id'] . "'>";
                }
            }

            $tabla .= "<input type='hidden' name='baremoactividad_id[]' id='baremoactividad_id[]' value='" . $row['baremoactividad_id'] . "'>                     
            </tr>";
        }

        $tabla .= "</tbody>
        </table></form>
        </div>
        ";
        $tabla .= "</fieldset>";

        if ($data['control'] == "1") {
            $tabla .= '<button name="btnListActividadesPre" id="btnListActividadesPre" class="btn btn-warning" type="button" onclick="ListActividadesPresupuestoOT(' . trim($data['detallepresupuesto_id']) . ')">Mostrar Actividades</button>';
        } else {
            $tabla .= '<button name="btnGuardar" id="btnGuardar" class="btn btn-primary" type="button" onclick="UpdateActividadPresupuesto(' . $data['baremo_id'] . ')">Guardar</button>';
            $tabla .= '<button name="btnListActividadesPre" id="btnListActividadesPre" class="btn btn-default" type="button" onclick="ListActividadesPresupuesto(' . trim($data['detallepresupuesto_id']) . ')">Mostrar Actividades</button>';
        }

        return $tabla;
    }

    public function UpdateActividadPresupuesto($data) {
        $xml = "";
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        

        $array_subactividades = explode(",", $data['param_txt_subactividad_id']);
        $array_valor_procentaje = explode("|", $data['param_valor_porc']);
        $array_baremoactividad_id = explode(",", $data['baremoactividad_id']);
        $array_detalleactividad_id = explode(",", $data['detalleactividad_id']);

        /* DATOS DE LA ACTIVIDAD */
        $baremo_id = $data['baremo_id'];
        $detallepresupuesto_id = $data['detallepresupuesto_id'];
        $slTipActividad = $data['slTipActividad'];
        $slModulo = $data['slModulo'];
        $txt_modulo = $data['txt_modulo'];
        $txt_Obs = $data['txt_Obs'];
        $txt_tot_pres = $data['txt_tot_pres'];

        //validar el modulo
        if ($txt_modulo != "") {

            //INSERTAR MODULO     
            $sql_modulo = "CALL SP_cfmodulo('2','','" . trim(utf8_decode($data['txt_modulo'])) . "','','','','" . $id_usuario . "','');";

            $res_modulo = $obj_bd->EjecutaConsulta($sql_modulo);
            if (!$res_modulo)
                die('Invalid query ->' . mysqli_errno() . '->' . $res_modulo);

            $array = $obj_bd->FuncionFetch($res_modulo);
            $modulo_id = $array['modulo_id_insert'];
        }else {
            $modulo_id = $slModulo;
        }

        for ($i = 0; $i < count($array_detalleactividad_id); $i++) {

            $baremodetalleactividadactividad_id = explode("_", $array_detalleactividad_id[$i]);
            $porcentaje_actividad_baremo = explode(":", $array_subactividades[$i]);
            $valor_porcentaje_actividad_baremo = explode(":", $array_valor_procentaje[$i]);


            $baremoactividad_id = $baremodetalleactividadactividad_id[2];
            $detalleactividad_id = $baremodetalleactividadactividad_id[1];
            $presupuesto_id = $baremodetalleactividadactividad_id[0];

            $porc = $porcentaje_actividad_baremo[1];
            $valor_porc = $valor_porcentaje_actividad_baremo[1];
            $valor_sinPuntos = str_replace('.', '', $valor_porc);
            $valor_decimal = str_replace(',', '.', round($valor_sinPuntos));

            //alcances
            $arreglo_alcance = "";
            $alcances_exp = explode("|", $data['alcances']);
            for ($a = 0; $a < count($alcances_exp); $a++) {
                $alcances_detalleactividad_id = explode(":", $alcances_exp[$a]);
                $valida_detalleactivida = $alcances_detalleactividad_id[1] . "_" . $detalleactividad_id;
                if ($alcances_detalleactividad_id[0] == $valida_detalleactivida) {
                    $arreglo_alcance .= $alcances_detalleactividad_id[1] . ",";
                }
            }
            $alcances = substr($arreglo_alcance, 0, -1);



            /*
              $list_alcacnes = "";
              $sql_alcances = "CALL SP_ptalcancesubactividad('4','','','','','','','','" . $detalleactividad_id . "');";

              $resul_alcances = $obj_bd->EjecutaConsulta($sql_alcances);
              while ($row = $obj_bd->FuncionFetch($resul_alcances)) {

              $list_alcacnes .= "" . $row['alcance_id'] . ",";
              }
              $alcances = trim($list_alcacnes, ',');
             */


            //entregables
              $arreglo_entregables = "";
              $entregables_exp = explode("|", $data['entregables']);
              for ($e = 0; $e < count($entregables_exp); $e++) {
                $entregable_detalleactividad_id = explode(":", $entregables_exp[$e]);
                $valida_detalleactivida_et = $entregable_detalleactividad_id[1] . "_" . $detalleactividad_id;
                if ($entregable_detalleactividad_id[0] == $valida_detalleactivida_et) {
                    $arreglo_entregables .= $entregable_detalleactividad_id[1] . ",";
                }
            }
            $entregables = substr($arreglo_entregables, 0, -1);


            /* $list_entregables = "";
              $sql_entregables = "CALL SP_ptentregablesubactividad('4','','','','','','','','" . $detalleactividad_id . "');";


              $resul_entregables = $obj_bd->EjecutaConsulta($sql_entregables);
              while ($row = $obj_bd->FuncionFetch($resul_entregables)) {

              $list_entregables .= "" . $row['entregable_id'] . ",";
              }
              $entregables = trim($list_entregables, ',');
             */

            // echo " validar insert " . $baremoactividad_id . " - " . $detalleactividad_id . " - " . $porc . " - " . $valor_porc;
            //Insertar            
              $sql = "CALL SP_ptpresupuesto('8','" . trim($presupuesto_id) . "','" . $alcances . "','','" . $entregables . "','','','','','','" . trim(utf8_decode($txt_Obs)) . "','" . trim($porc) . "','','" . $id_usuario . "','" . $valor_decimal . "','','" . $detallepresupuesto_id . "','" . $baremoactividad_id . "','" . $baremo_id . "','" . $detalleactividad_id . "','" . $modulo_id . "','" . $slTipActividad . "');";
              $res = $obj_bd->EjecutaConsulta($sql);
              if (!$res)
                die('Invalid query ->' . mysqli_errno() . '->' . $res);
        }





        if ($presupuesto_id == 0 || $presupuesto_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function UpdateAlcancesPresupuesto($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        foreach ($data['alcances'] as $key => $value) {
            $arreglo_alcance .= $value . ",";
        }
        $alcances = substr($arreglo_alcance, 0, -1);

        $sql = "CALL SP_ptpresupuesto('13','" . trim($data['presupuesto_id']) . "','" . $alcances . "','','','','','','','','','','','" . $id_usuario . "','','','','','','','','');";
        $result = $obj_bd->EjecutaConsulta($sql);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function UpdateEntregablesPresupuesto($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        foreach ($data['entregables'] as $key => $value) {
            $arreglo .= $value . ",";
        }
        $entregables = substr($arreglo, 0, -1);

        $sql = "CALL SP_ptpresupuesto('14','" . trim($data['presupuesto_id']) . "','','','" . $entregables . "','','','','','','','','','" . $id_usuario . "','','','','','','','','');";
        $result = $obj_bd->EjecutaConsulta($sql);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function ListModuloCopiar() {
        $obj_bd = new BD();

        $sql = "CALL SP_cfmodulo('1','','','','','','','');";

        $resul = $obj_bd->EjecutaConsulta($sql);
//        $i = 0;
//        while ($row = $obj_bd->FuncionFetch($resul)) {
//            $arreglo_modulo[$i]['modulo_id'] = $row['modulo_id'];
//            $arreglo_modulo[$i]['modulo_descripcion'] = utf8_encode($row['modulo_descripcion']);
//            $i++;
//        }
//        $arreglo_retorno['MODULO'] = $arreglo_modulo;
//        $json = json_encode($arreglo_retorno);
//        return $json;

        $retorno .= "<option value=''>-Seleccione modulo para copiar labores-</option>";
        while ($row = $obj_bd->FuncionFetch($resul)) {

            $retorno .= "<option value='" . $row['modulo_id'] . "'>" . utf8_encode($row['modulo_descripcion']) . " </option>";
        }
        return $retorno;
    }

    public function CopiLabores($data) {
        $xml = "";
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        //Labores a copiar
        $arreglo_labores = "";
        $labores_exp = explode("|", $data['param_labores_copiar']);
        for ($a = 0; $a < count($labores_exp); $a++) {

            $sql_labores = "CALL SP_ptpresupuesto('19','" . $labores_exp[$a] . "','','','','','','','','','','','','','','','" . $data['detallepresupuesto_id'] . "','','','','" . $data['modulo_copiar'] . "','');";
            $res_labores = $obj_bd->EjecutaConsulta($sql_labores);
            $data_sql = $obj_bd->FuncionFetch($res_labores);
            $respuesta = $data_sql['inserto'];
            if (!$res_labores)
                die('Invalid query ->' . mysqli_errno() . '->' . $res_labores);
        }

        if ($respuesta == '') {
            $xml = "<resultado>0</resultado>";
        } else if ($respuesta == '1') {// SE COPIO CORRECTAMENTE
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "</respuesta>";
        } else if ($respuesta == '0') {// YA EXISTE LA LABOR
            $xml .= "<respuesta>";
            $xml .= "<resultado>2</resultado>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function JsonDetallePresupuestoIncrementos($data) {

        $arreglo_retorno = array();
        $arreglo_incrementos = array();

        $obj_bd = new BD();
        $sql = "CALL SP_dtdetallepresupuesto('11','" . $data['detallepresupuesto_id'] . "','','','','','','','','','','','','','','','','');";
        $num = $obj_bd->Filas($sql);
        if ($num > 0) {
            $result = $obj_bd->EjecutaConsulta($sql);
            $i = 0;
            while ($array = $obj_bd->FuncionFetch($result)) {
                $arreglo_incrementos[$i]['incrementopresupuesto_id'] = $array['incrementopresupuesto_id'];
                $arreglo_incrementos[$i]['incrementopresupuesto_tipo'] = utf8_encode($array['incrementopresupuesto_tipo']);
                $arreglo_incrementos[$i]['detallepresupuesto_id'] = $array['detallepresupuesto_id'];
                $arreglo_incrementos[$i]['incrementopresupuesto_idtipo'] = $array['incrementopresupuesto_idtipo'];
                $arreglo_incrementos[$i]['incrementopresupuesto_porcentaje'] = $array['incrementopresupuesto_porcentaje'];
                $arreglo_incrementos[$i]['incrementopresupuesto_valor'] = $array['incrementopresupuesto_valor'];
                $arreglo_incrementos[$i]['incrementopresupuesto_valor_formato'] = number_format((float) $array['incrementopresupuesto_valor'], 0, ',', '.');
                $i++;
            }
        }
        $arreglo_retorno['incrementos'] = $arreglo_incrementos;
        $arreglo_retorno['registros'] = $num;


        $json = json_encode($arreglo_retorno);
        return $json;
    }

/******************************************************************************/
    public function calcularIncrementos ($post){//inicio

        if ($post['check'] == "1"){

            $respuesta = array();

            $obj_bd = new BD();

            $sql = "CALL SP_dtdetallepresupuesto('4','" . $post['detallepresupuesto_id'] . "','','','','','','','','','','','','','','','','');";

            $result = $obj_bd->EjecutaConsulta($sql);
            $array = $obj_bd->FuncionFetch($result);

            $total = $array ['detallepresupuesto_total'];


            $sql1 = "CALL SP_dtdetallepresupuesto('12','" . $post['detallepresupuesto_id'] . "','','','','','','','','','','','','','','','','');";

            $resultado = $obj_bd->EjecutaConsulta($sql1);
            $row = $obj_bd->FuncionFetch($resultado);

            $ubicacion = round($row ['porcentaje']);
            $respuesta ['ubicacion'] = $ubicacion;

            $dias = round($row ['dias']*0.015);
            $respuesta ['dias'] = $dias;


            $respuesta ['total'] = $total + $ubicacion + $dias;
            
            $json = json_encode ($respuesta);


            return $json;


        }else{


            $obj_bd = new BD();
            $respuesta = array();

            $sql = "CALL SP_dtdetallepresupuesto('4','" . $post['detallepresupuesto_id'] . "','','','','','','','','','','','','','','','','');";

            $result = $obj_bd->EjecutaConsulta($sql);
            $array = $obj_bd->FuncionFetch($result);

            $total = $array ['detallepresupuesto_total'];
            $dias = $total * 0.015;

            $respuesta ['ubicacion'] = 0;
            $respuesta ['dias'] = round($dias);
            $respuesta ['total'] = round($total + $dias);

            $json = json_encode ($respuesta);


            return $json;
        }
    }//fin

/******************************************************************************/
public function guardarIncrementos ($post){//inicio funcion

    $id_usuario = $_SESSION['Usuario']['usuario_id'];
    $obj_bd = new BD();

    $detallepresupuesto_id = $post['detallepresupuesto_id'];
    $totalIncrementos= $post['totalIncrementos'];
    $dias= str_replace('.','',$post['incremento_90dias']);
    $ubicacion= str_replace('.','',$post['incremento_ubicacion']);
    $check= $post['check'];


    if ($check == 1) {

        $sql = "call SP_incrementosNueva ('1','". $ubicacion ."', '". $dias ."', '". $check ."', '". $detallepresupuesto_id ."');";

        $res = $obj_bd -> EjecutaConsulta($sql);
        $resp = $obj_bd -> FuncionFetch($res);

        $idincrementos = $resp['detallepresupuesto_id_insert'];
        
    }else{

        $sql = "call SP_incrementosNueva ('2','". $ubicacion ."', '". $dias ."', '". $check ."', '". $detallepresupuesto_id ."');";

        $res = $obj_bd -> EjecutaConsulta($sql);
        $resp = $obj_bd -> FuncionFetch($res);

        $idincrementos = $resp['detallepresupuesto_id_insert']; 
    }


    if ($idincrementos > 0) {
        return "Incrementos guardados";
    }else{
        return "No se guardaron los incrementos";
    }
}//fin guardarIncrementos

/******************************************************************************/
public function guardarDocumentos($post){

    //delaramos las variables
    $id_usuario = $_SESSION['Usuario']['usuario_id'];
    $obj_bd = new BD();
    $id = $post['id'];
    $num = count($_FILES);    

    //recorremos los archivos y guardamos en carpeta y base de datos
    for ($i=0; $i < $num; $i++) { 

        //guardamos en la carpeta
        $nombre = $_FILES['archivo'.$i]['name'];
        $tipo = $_FILES['archivo'.$i]['type'];
        $tamanio = $_FILES['archivo'.$i]['size'];
        $tmpUbicacion = $_FILES['archivo'.$i]['tmp_name'];
        $carpeta = 'C:/Presupuestos/'. $id .'/'.$nombre;
        move_uploaded_file($tmpUbicacion, $carpeta);

        //guardamos en la base de datos
        $sql_sopt = "CALL SP_dtsoporte('2','','','','" . trim($nombre) . "','" . trim($tamanio) . "','" . trim($tipo) . "','".$carpeta."','" . $id_usuario . "','');";

        $resultado_sopt = $obj_bd->EjecutaConsulta($sql_sopt);
        $array_sopt = $obj_bd->FuncionFetch($resultado_sopt);
        $soporte_id_insert = $array_sopt['soporte_id_insert'];
    }

    if (!$soporte_id_insert) {
        return 0;
    }else{
        return 1;
    }
}//fin guardarDocumentos

}//Fin de la clase


