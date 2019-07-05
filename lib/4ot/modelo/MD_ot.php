<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MD_ot
 *
 * @author jennifer.cabiativa
 */
include '../../0connection/BD_config.php';
include '../../0connection/connection.php';
include '../../0connection/BD.php';

session_start();

class MD_ot {

    function gritPresupuestoOT() {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<br><br><br><br><fieldset style='color:black'>";
        $tabla .= "<legend class='titulo'>OT Cliente</legend>";
        $url = "'lib/3presup/view/formEditPresup.php','contenido','0'";

        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-hover" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr class="fondo letraN">                              
                            <th>Reporte</th>  
                            <th>No. OT</th> 
                            
                            <!-- <th>Estado</th> --> 
                            <th>Presupuesto</th> 
                            <th>Subestacion</th>                                                        
                            <th>Fecha Inicio OT</th>                                                        
                              
                            <th>Fecha Fin OT</th>  
                            <th>Total Sin IVA</th>
                            <th>Total</th> 
                            <th>OT</th>
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_dtdetallepresupuesto('5','','','','','','','','','','','','','','','','','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

                    
            
            $total = (int) $row['detallepresupuesto_valorincremento'] + (int) $row['detallepresupuesto_total'];
            if ($row['detallepresupuesto_estado'] == '3') {
                $estado = "Aprobado";
            }
            if ($row['detallepresupuesto_estado'] == '4') {
                $estado = "Finalizado";
            }
            $urlEdit = '"lib/4ot/view/formOT.php","contenido","' . $row['detallepresupuesto_id'] . '"';
            $tabla .= "<tr>                
                    <td><img src='img/word2010.png' title='Descargar Presupuesto' width='20' height='20' border='0' onClick='DescargarPresupuestoWord(" . $row['detallepresupuesto_id'] . ")' />
                        <img src='img/report_excel.png' title='Descargar Presupuesto' width='20' height='20' border='0' onClick='DescargarPresupuestoXlsx(" . $row['detallepresupuesto_id'] . ")' />
                        <img src='img/word2010.png' title='Descargar Interna' width='20' height='20' border='0' onClick='DescargarPresupuestoWordInterna(" . $row['detallepresupuesto_id'] . ")' /></td>                     
                <td>" . $row['ordentrabajo_num'] . "</td>                     
                <!-- <td>" . $estado . "</td> -->                    
               <td>" . utf8_encode($row['detallepresupuesto_nombre']) . "</td> 
                <td>" . utf8_encode($row['subestacion_nombre']) . "</td>                
                <td>" . $row['ordentrabajo_fechaini'] . "</td>                
                     
                <td>" . $row['ordentrabajo_fechafin'] . "</td>                                            
                <td>" . number_format((float) $row['detallepresupuesto_total'], 0, ',', '.') . "</td>                                             
                <td>" . number_format((float) $total, 0, ',', '.') . "</td>                                             
                                           
                <td><button class='btn btn-primary fondo'  onclick='loadingFunctions(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Programar  </button>
                    <!-- <button class='btn btn-default'  onclick='DivIncremento(" . $row['detallepresupuesto_id'] . ")'><span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span> Incremento  </button> -->";
            $tabla .= "</td> 
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable({'order': [[ 1, 'desc' ]]});</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function ListActividadesPresupuestoOT($data) {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset class='letraBl'>";
        $tabla .= "<legend class='titulo'>Asignación Responsables del Proyecto</legend>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<form id="presupuesto_actividades_asoc">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-hover" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr class="fondo letraN">
                           <th>Labor</th> 
                           <th>Alcance técnico particular</th>
                           <th>Modulo</th>
                           <th>Total</th> 
                           <th>Accion</th>                           
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_ptpresupuesto('3','','','','','','','','','','','','','','','','" . trim($data['detallepresupuesto_id']) . "','','','','','');";

        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {
            $obs = '"' . preg_replace("/\s+/", " ", utf8_encode($row['presupuesto_obs'])) . '"';
            $tabla .= "
                <tr> 
                <td>" . utf8_encode($row['item'] . " " . $row['labor_descripcion']) . "</td>                     
                <td>" . utf8_encode($row['presupuesto_obs']) . "</td>                     
                <td>" . utf8_encode($row['modulo_descripcion']) . "</td>                     
                <td>" . number_format((float) $row['total_actividad'], 0, ',', '.') . "</td>    
                <td><input type='button' class='btn btn-primary'  onclick='EditarActividadPresupuesto(" . $row['baremo_id'] . "," . $row['tipobaremo_id'] . "," . $row['detallepresupuesto_id'] . "," . $row['modulo_id'] . ",1," . trim($obs) . ");' value='Programar'>                 
                </td>
                </tr>";
        }

        $tabla .= "</tbody>
                    </table></form>
                    </div>
                    ";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function SaveOT($data) {
        $xml = "";
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];


        //INSERTAR OT     
        $sql = "CALL SP_ptordentrabajo('2','" . trim(utf8_decode($data['txtPresFinOT'])) . "','" . trim(utf8_decode($data['txt_contratista'])) . "','','" . trim(utf8_decode($data['txtFechaEmision'])) . "','" . trim(utf8_decode($data['txtPresInicioOT'])) . "','','" . trim(utf8_decode($data['txt_orden_gom'])) . "','" . trim(utf8_decode($data['txt_num_orden'])) . "','" . trim(utf8_decode($data['txt_detalle'])) . "','" . $id_usuario . "','','" . trim($data['detallepresupuesto_id']) . "','" . trim($data['txt_orden_presupuestal']) . "','" . trim($data['txt_pep']) . "');";


        $res = $obj_bd->EjecutaConsulta($sql);
//        if (!$res)
//            die('Invalid query ->' . mysqli_errno() . '->' . $res);

        $array = $obj_bd->FuncionFetch($res);
        $ordentrabajo_id_insert = $array['ordentrabajo_id_insert'];



        if ($ordentrabajo_id_insert == 0 || $ordentrabajo_id_insert == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<ot_id>" . $ordentrabajo_id_insert . "</ot_id>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function JsonDetalleOT($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_ptordentrabajo('1','','','','','','','','','','','','" . trim($data['detallepresupuesto_id']) . "','','');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['ordentrabajo_id'] = $array['ordentrabajo_id'];
        $arreglo_retorno['ordentrabajo_contratista'] = $array['ordentrabajo_contratista'];
        $arreglo_retorno['ordentrabajo_fechaemision'] = $array['ordentrabajo_fechaemision'];
        $arreglo_retorno['ordentrabajo_fechaini'] = $array['ordentrabajo_fechaini'];
        $arreglo_retorno['ordentrabajo_fechafin'] = $array['ordentrabajo_fechafin'];
        $arreglo_retorno['ordentrabajo_gom'] = utf8_encode($array['ordentrabajo_gom']);
        $arreglo_retorno['ordentrabajo_num'] = utf8_encode($array['ordentrabajo_num']);
        $arreglo_retorno['ordentrabajo_obs'] = utf8_encode($array['ordentrabajo_obs']);
        $arreglo_retorno['ordentrabajo_ordenpresupuestal'] = utf8_encode($array['ordentrabajo_ordenpresupuestal']);
        $arreglo_retorno['ordentrabajo_pep'] = utf8_encode($array['ordentrabajo_pep']);

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function SaveProgramaOT($post) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        // $arre_ingenieros = explode(',', $post['listaIngenieros']);
        //validar si hay mas de 1 responsable asignado a la actividad
        $num_responsables = (int) $post['txt_add_encargado'];
        $ot = $post['txt_ot'];

        if ($num_responsables == 1) {
            // 1.  Inactivar otros encargados asociados
            $encargado = "CALL SP_ptpresupuesto('20','" . trim($post['presupuesto_id']) . "','" . $id_usuario . "','','2','','','','','','','','','','','','','','','','','')";

            $res_encargado = $obj_bd->EjecutaConsulta($encargado);
            if (!$res_encargado)
                die('Invalid query ->' . mysqli_errno() . '->' . $res_encargado);



            foreach ($post['listaEncargados'] as $key => $value) {
                foreach ($post['listaEncargadosArea'] as $key_area => $value_area) {
                    //$sql = "CALL SP_ptpresupuesto('9','" . trim($post['presupuesto_id']) . "','" . $post['txt_vehiculo'] . "','" . $post['slIngOT'] . "','" . trim($post['txtHoraIni']) . "','" . trim($post['txtHoraFin']) . "','" . $post['txtInicioOT'] . "','" . $post['txtFnicioOT'] . "','" . $id_usuario . "','PROGRAMADA','" . $post['txt_obs_programacion'] . "','','','" . $id_usuario . "','','" . trim($post['slAreaOT']) . "','','','','','','');";
                    $sql = "CALL SP_ptpresupuesto('9','" . trim($post['presupuesto_id']) . "','"
                            . $post['txt_vehiculo'] . "','" . $value . "','" . trim($post['txtHoraIni']) . "','"
                            . trim($post['txtHoraFin']) . "','" . $post['txtInicioOT'] . "','" . $post['txtFnicioOT'] . "','"
                            . $id_usuario . "','PROGRAMADA','" . $post['txt_obs_programacion'] . "','','','" . $id_usuario . "','','"
                            . trim($value_area) . "','','','','','','');";

                    $result = $obj_bd->EjecutaConsulta($sql);
                }
            }






        } elseif ($num_responsables > 1) {
            $principal = "";
            // 1.  Inactivar otros encargados asociados
            $encargado = "CALL SP_ptpresupuesto('20','" . trim($post['presupuesto_id']) . "','" . $id_usuario . "','','2','','','','','','','','','','','','','','','','','')";

            $res_encargado = $obj_bd->EjecutaConsulta($encargado);
            if (!$res_encargado)
                die('Invalid query ->' . mysqli_errno() . '->' . $res_encargado);



            foreach ($post['listaEncargados'] as $key => $value_enc) {
                //$sql = "CALL SP_ptpresupuesto('9','" . trim($post['presupuesto_id']) . "','" . $post['txt_vehiculo'] . "','" . $post['slIngOT'] . "','" . trim($post['txtHoraIni']) . "','" . trim($post['txtHoraFin']) . "','" . $post['txtInicioOT'] . "','" . $post['txtFnicioOT'] . "','" . $id_usuario . "','PROGRAMADA','" . $post['txt_obs_programacion'] . "','','','" . $id_usuario . "','','" . trim($post['slAreaOT']) . "','','','','','','');";


                if ($principal == "ok") {
                    //insertamos los otros responsables
                    //2. Asignar los nuevos encargados de la actividad
                    $sql_encargado = "CALL SP_ptpresupuesto('16','" . trim($post['presupuesto_id']) . "','" . $id_usuario . "','" . $value_enc . "','2','','','','','','','','','','','','','','','','','')";

                    $result_encargado = $obj_bd->EjecutaConsulta($sql_encargado);
                    if (!$result_encargado)
                        die('Invalid query ->' . mysqli_errno() . '->' . $result_encargado);
                } else {
                    foreach ($post['listaEncargadosArea'] as $key_area => $value_area) {
                        $sql = "CALL SP_ptpresupuesto('9','" . trim($post['presupuesto_id']) . "','"
                                . $post['txt_vehiculo'] . "','" . $value_enc . "','" . trim($post['txtHoraIni']) . "','"
                                . trim($post['txtHoraFin']) . "','" . $post['txtInicioOT'] . "','" . $post['txtFnicioOT'] . "','"
                                . $id_usuario . "','PROGRAMADA','" . $post['txt_obs_programacion'] . "','','','" . $id_usuario . "','','"
                                . trim($value_area) . "','','','','','','')";
                        $result = $obj_bd->EjecutaConsulta($sql);
                        $principal = "ok";
                    }
                }
            }
        }



        if (!$result) {
            return 0;
        } else {

            ////////////////////////////////////
            // GUARDAR CONSECUTIVO OT INTERNA //
            ////////////////////////////////////
            $sql_con = "CALL SP_dtinterna('3','','','','','','','','".$ot."')";
            $res_con = $obj_bd->EjecutaConsulta($sql_con);
            $row_con = $obj_bd->FuncionFetch($res_con);


            $sql_int = "CALL SP_dtinterna('1','','1','','".$value."','','".$post['txtInicioOT']."','".$post['txtFnicioOT']."','".$ot."')";
            $res_int = $obj_bd->EjecutaConsulta($sql_int);
            $filas = $obj_bd->Filas($sql_int);
            $row_int = $obj_bd->FuncionFetch($res_int);

            $con = $row_con['interna_consecutivo'];

             if ($con == "")
            {
            $con = 0;
            }


            if ($filas > 0)
           {
                $consecutivo = $con;

                $sql_int1 = "CALL SP_dtinterna('2','','','".$id_usuario."','".$value."','".$consecutivo."','".$post['txtInicioOT']."','".$post['txtFnicioOT']."','".$ot."')";
                $res_int1 = $obj_bd->EjecutaConsulta($sql_int1);
                $row_int1 = $obj_bd->FuncionFetch($res_int1);

            }else{

                $consecutivo = $con + 1;

                $sql_int2 = "CALL SP_dtinterna('2','','','".$id_usuario."','".$value."','".$consecutivo."','".$post['txtInicioOT']."','".$post['txtFnicioOT']."','".$ot."')";
                $res_int2 = $obj_bd->EjecutaConsulta($sql_int2);
                $row_int2 = $obj_bd->FuncionFetch($res_int2);
            }


            ///////////////////////////////////////
            // ELIMINAR TECNICOS DEL PRESUPUESTO //
            ///////////////////////////////////////
            $sql_dt = "CALL SP_ptpresupuesto('17','" . trim($post['presupuesto_id']) . "','','','','','','','','','','','','','','','','','','','','');";
            $result_dt = $obj_bd->EjecutaConsulta($sql_dt);

            if (!$result_dt) {
                return 0;
            } else {
                if (isset($post['listaIngenieros'])) {
                    foreach ($post['listaIngenieros'] as $key => $value) {

                        $ing = "CALL SP_ptpresupuesto('16','" . trim($post['presupuesto_id']) . "','" . $id_usuario . "','" . $value . "','1','','','','','','','','','','','','','','','','','');";

                        $res_ing = $obj_bd->EjecutaConsulta($ing);
                        if (!$res_ing)
                            die('Invalid query ->' . mysqli_errno() . '->' . $res_ing);
                    }
                }

                return 1;
            }
        }
    }

    public function JsonPresupuesto($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_ptpresupuesto('10','" . trim($data['presupuesto_id']) . "','','','','','','','','','','','','','','','','','','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $sql_con = "CALL SP_dtinterna('3','','','','','','','','".$data['ot_id']."')";
        $res_con = $obj_bd->EjecutaConsulta($sql_con);
        $row_con = $obj_bd->FuncionFetch($res_con);


        $consecutivo =$row_con['interna_consecutivo'];

        if ($consecutivo == "")
        {
            $consecutivo = 0;
        }
        
        $arreglo_retorno['area_id'] = $array['area_id'];
        $arreglo_retorno['ordentrabajo_id'] = $array['ordentrabajo_id'];
        $arreglo_retorno['ordentrabajo_num'] = $array['ordentrabajo_num'];
        $arreglo_retorno['interna_consecutivo'] = $consecutivo;
        $arreglo_retorno['presupuesto_encargado'] = $array['presupuesto_encargado'];
        $arreglo_retorno['presupuesto_fechaini'] = $array['presupuesto_fechaini'];
        $arreglo_retorno['presupuesto_fechafin'] = $array['presupuesto_fechafin'];
        $arreglo_retorno['presupuesto_horaini'] = $array['presupuesto_horaini'];
        $arreglo_retorno['presupuesto_horafin'] = $array['presupuesto_horafin'];
        $arreglo_retorno['presupuesto_programacion_obs'] = utf8_encode($array['presupuesto_programacion_obs']);
        $arreglo_retorno['presupuesto_vehiculo'] = utf8_encode($array['presupuesto_vehiculo']);

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function JsonTecnicosPresupuesto($data) {

        $arreglo_retorno = array();
        $arreglo_tecnicos = array();

        $obj_bd = new BD();
        $sql = "CALL SP_ptpresupuesto('18','" . trim($data['presupuesto_id']) . "','','','','','','','','','','','','','','','','','','','','');";
        $num = $obj_bd->Filas($sql);
        if ($num > 0) {
            $result = $obj_bd->EjecutaConsulta($sql);
            $i = 0;

            while ($array = $obj_bd->FuncionFetch($result)) {


                $arreglo_tecnicos[$i]['perfilusuario_id'] = $array['perfilusuario_id'];
                $arreglo_tecnicos[$i]['usuario_id'] = $array['usuario_id'];
                $arreglo_tecnicos[$i]['tecnico'] = utf8_encode($array['tecnico']);
                $i++;
            }
        }

        $arreglo_retorno['tecnicos'] = $arreglo_tecnicos;
        $arreglo_retorno['registros'] = $num;
        $json = json_encode($arreglo_retorno);
        return $json;
    }

    function gritEjecutarOT() {

        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $id_perfil = $_SESSION['Usuario']['ID_PERFIL'];
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<br><br><br><br><fieldset class='letraBl'>";
        $tabla .= "<legend class='titulo'>Actividades Asignadas</legend>";
        $tabla .= " <button name='btnAdd' id='btnAdd' class='btn btn-default' type='button' onclick='ReportarLabores()'>Reportar Seleccionadas</button>";
        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-hover" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr class="fondo letraN">                              
                            <th>Sel.</th>  
                            <th>No. OT</th>  
                            <th>Estado</th>  
                            <th>Subestacion</th>  
                            <th>Labor</th>  
                            <th>Modulo</th>
                            <th>Area</th>                                                        
                            <th>Actividad</th>                                                        
                            <th>Fecha/Hora Inicio</th>                                                        
                            <th>Fecha/Hora Fin</th>                                                        
                            <th>Asignado Por</th>                                                                                                                
                            <th>Accion</th>                                                                                                                                            
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_ptperfil_usuario('9','" . $id_usuario . "','','" . $id_perfil . "','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {


            $urlEdit = '"lib/4ot/view/formSeguimiento.php","contenido","' . $row['baremo_id'] . '","' . $row['ordentrabajo_id'] . '","' . $row['presupuesto_id'] . '","' . $row['tipobaremo_id'] . '","' . $row['presupuesto_progestado'] . '","' . $row['presupuesto_porcentaje'] . '",""';
            $tabla .= "<tr> 
                <td><input type='checkbox' value='" . $row['presupuesto_id'] . "' id='" . $row['presupuesto_id'] . "' name='chek_reportar[]'  /></td>  
                <td>" . utf8_encode($row['ordentrabajo_num']) . "</td>                     
                <td>" . $row['presupuesto_progestado'] . "</td>                                                    
                <td>" . utf8_encode($row['subestacion_nombre']) . "</td>                                                    
                <td>" . $row['tipo_labor'] . "</td>                                                    
                <td>" . utf8_encode($row['modulo_descripcion']) . "</td>                
                <td>" . utf8_encode($row['area_nombre']) . "</td>                
                <td>" . utf8_encode($row['actividad_descripcion'] . ' ' . $row['subactividad_descripcion']) . "</td>                
                <td>" . $row['presupuesto_fechaini'] . " - " . $row['presupuesto_horaini'] . "</td>                
                <td>" . $row['presupuesto_fechafin'] . " - " . $row['presupuesto_horafin'] . "</td>                                                                         
                <td>" . utf8_encode($row['asigno']) . "</td>                                                 
                <td><button class='btn btn-default'  onclick='loadingSeguimientos(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Reportar  </button>";
            if (utf8_encode($row['subactividad_descripcion']) == "LEVANTAMIENTO") {
                $tabla .= "<button class='btn btn-default'  onclick='DivEditDescargo(" . $row['ordentrabajo_id'] . "," . $row['presupuesto_id'] . ")'><span class='glyphicon glyphicon-book' aria-hidden='true'></span> Descargo  </button>";
            }
            $tabla .= "</td> 
            </tr>";
        }


        // consultar actividades asociadas a mas de un responsable
        $sql_encargados = "CALL SP_ptperfil_usuario('12','" . $id_usuario . "','','" . $id_perfil . "','');";
        $resultado_encargados = $obj_bd->EjecutaConsulta($sql_encargados);

        while ($row = $obj_bd->FuncionFetch($resultado_encargados)) {

            $urlEdit = '"lib/4ot/view/formSeguimiento.php","contenido","' . $row['baremo_id'] . '","' . $row['ordentrabajo_id'] . '","' . $row['presupuesto_id'] . '","' . $row['tipobaremo_id'] . '","' . $row['presupuesto_progestado'] . '","' . $row['presupuesto_porcentaje'] . '",""';
            $tabla .= "<tr>                
                <td>" . utf8_encode($row['ordentrabajo_num']) . "</td>                     
                <td>" . $row['presupuesto_progestado'] . "</td>                                                    
                <td>" . utf8_encode($row['subestacion_nombre']) . "</td>                                                    
                <td>" . $row['tipo_labor'] . "</td>                                                    
                <td>" . utf8_encode($row['modulo_descripcion']) . "</td>                
                <td>" . utf8_encode($row['area_nombre']) . "</td>                
                <td>" . utf8_encode($row['actividad_descripcion'] . ' ' . $row['subactividad_descripcion']) . "</td>                
                <td>" . $row['presupuesto_fechaini'] . " - " . $row['presupuesto_horaini'] . "</td>                
                <td>" . $row['presupuesto_fechafin'] . " - " . $row['presupuesto_horafin'] . "</td>                                                                         
                <td>" . utf8_encode($row['asigno']) . "</td>                                                 
                <td><button class='btn btn-default'  onclick='loadingSeguimientos(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Reportar  </button>";
            /*  if (utf8_encode($row['subactividad_descripcion']) == "LEVANTAMIENTO") {
              $tabla .= "<button class='btn btn-default'  onclick='DivEditDescargo(" . $row['ordentrabajo_id'] . "," . $row['presupuesto_id'] . ")'><span class='glyphicon glyphicon-book' aria-hidden='true'></span> Descargo  </button>";
              } */
            $tabla .= "</td> 
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable({'order': [[ 1, 'desc' ]]});</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    function SaveSeguimientoAct($files_data, $data) {


        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $obj_bd = new BD();

        $baremo_id = $data['baremo_id'];
        $ordentrabajo_id = $data['ordentrabajo_id'];
        $presupuesto_id = $data['presupuesto_id'];
        $tipobaremo_id = $data['tipobaremo_id'];
        $porc_av = $data['porc_av'];
        $slc_estado_actividad = $data['slc_estado_actividad'];
        $txtInicioSeg = $data['txtInicioSeg'];
        $txtHoraIniSeg = $data['txtHoraIniSeg'];
        $txtFnicioSeg = $data['txtFnicioSeg'];
        $txtHoraFinSeg = $data['txtHoraFinSeg'];
        $txt_Obs_seg = $data['txt_Obs_seg'];
        $txt_revision = $data['txt_revision'];
        //$num_seg = $data['num_seg'];
        //numero de seguimiento 
        $sql_num = "CALL SP_ptseguimiento('1','','','','','','','','','','','','','','','','','','" . trim($presupuesto_id) . "','');";
        $resultado_num = $obj_bd->Filas($sql_num);

        if ($resultado_num == 0) {
            $num_seg = 1;
        } else {
            $num_seg = $resultado_num + 1;
        }

        $txtInicioSeg1 = date("Y-m-d", strtotime($txtInicioSeg));
        $txtFnicioSeg1 = date("Y-m-d", strtotime($txtFnicioSeg));
        // $txtFnicioSeg1=date_format($txtFnicioSeg, 'Y-m-d');
        $sql = "CALL SP_ptseguimiento('2','','" . trim($porc_av) . "','" . $id_usuario . "','','" . trim($txtInicioSeg1) . "','" . trim($txtFnicioSeg1) . "','','','" . trim($txtHoraIniSeg) . "','" . trim($txtHoraFinSeg) . "','" . trim($num_seg) . "','" . utf8_decode(trim($txt_Obs_seg)) . "','" . trim($txt_revision) . "','" . $id_usuario . "','','" . trim($baremo_id) . "','" . trim($ordentrabajo_id) . "','" . trim($presupuesto_id) . "','" . trim($tipobaremo_id) . "');";

        $resultado = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($resultado);
        $seguimientoo_id_insert = $array['seguimiento_id_insert'];


        if (!$resultado) {
            return 2;
        } else {

            //Cambiar estado de la actividad programada
            if ($slc_estado_actividad != "") {
                $sql_estado_prog = "CALL SP_ptpresupuesto('11','" . trim($presupuesto_id) . "','','','','','','','','" . trim($slc_estado_actividad) . "','','','','" . $id_usuario . "','','','','','','','','');";

                $resultado_prog = $obj_bd->EjecutaConsulta($sql_estado_prog);
                if (!$resultado_prog) {
                    return 2;
                }
            }
            
            foreach ($files_data as $key => $value) {
                $name = $value['name'];
                $tipo_documento = $value['type'];
                $tamanio_doc = $value['size'];
                //carga de documento
                move_uploaded_file($value['tmp_name'], '../../docs/' . $name);

                //registro de documento en el sistema tabla documento
                $sql_sopt = "CALL SP_dtsoporte('2','','','','" . trim($name) . "','" . trim($tamanio_doc) . "','" . trim($tipo_documento) . "','lib/docs/$name','" . $id_usuario . "','');";

                $resultado_sopt = $obj_bd->EjecutaConsulta($sql_sopt);
                $array_sopt = $obj_bd->FuncionFetch($resultado_sopt);
                $soporte_id_insert = $array_sopt['soporte_id_insert'];

                //asociacion del los documentos 
                $sql_sopt = "CALL SP_ptsoporteseguimiento('2','','','','','" . $id_usuario . "','','" . $seguimientoo_id_insert . "','" . $soporte_id_insert . "');";

                $resultado_Asc = $obj_bd->EjecutaConsulta($sql_sopt);
            }



            if ($resultado_Asc) {

                return 1;
            } else {
                return 3;
            }
        }
    }

    public function ListSeguimientoPresup($data) {

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
        $tabla .= '<form id="Seguimientos_presupuesto">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                           <th>No.</th>
                           <th>Avance (%)</th> 
                           <th>Fecha/Hora Inicio</th>
                           <th>Fecha/Hora Fin</th>
                           <th>Observaciones</th>                                                     
                           <th>Responsable</th>                                                     
                                                                  
                           <th>Accion</th>                                                     
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_ptseguimiento('1','','','','','','','','','','','','','','','','','','" . trim($data['presupuesto_id']) . "','');";

        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            if ($row['seguimiento_avance'] != "0") {
                $conv_porc = ($row['seguimiento_avance'] * 100) / $data['presupuesto_porcentaje'];
            } else {
                $conv_porc = $row['seguimiento_avance'];
            }

            //presupuesto_porcentaje
            $tabla .= "
                <tr> 
                <td>" . utf8_encode($row['seguimiento_num']) . "</td>                     
                <td>" . $conv_porc . "</td>                     
                <td>" . $row['seguimiento_fechaini'] . " - " . $row['seguimiento_horaini'] . "</td>                     
                <td>" . $row['seguimiento_fechafin'] . " - " . $row['seguimiento_horafin'] . "</td>
                <td>" . utf8_encode($row['seguimiento_obs']) . "</td>                  
                <td>" . utf8_encode($row['responsable']) . "</td>                  
                             
                <td>";
            if ($data['view'] == 1) {
                $urlEdit = '"lib/4ot/view/formSeguimiento.php","contenido","' . $row['baremo_id'] . '","' . $row['ordentrabajo_id'] . '","' . $row['presupuesto_id'] . '","' . $row['tipobaremo_id'] . '","' . $data['estado_act'] . '","' . $data['presupuesto_porcentaje'] . '","' . $row['seguimiento_id'] . '"';
            } else if ($data['view'] == 2) {
                $urlEdit = '"lib/4ot/view/formSeguimientoGest.php","contenido","' . $row['baremo_id'] . '","' . $row['ordentrabajo_id'] . '","' . $row['presupuesto_id'] . '","' . $row['tipobaremo_id'] . '","' . $data['estado_act'] . '","' . $data['presupuesto_porcentaje'] . '","' . $row['seguimiento_id'] . '"';
            }

            if ($data['estado_act'] != "RESUELTA") {
                $concat = '"';
                $tabla .= "<img src='img/borrar.jpg'  title='Eliminar Seguimiento' width='20' height='20' id='Elim' style='cursor:pointer' border='0' onclick='DeleteSeguimientoActi(" . $row['seguimiento_id'] . "," . $data['presupuesto_id'] . "," . $concat . $data['estado_act'] . $concat . "," . $data['presupuesto_porcentaje'] . "," . $data['view'] . ")'>";
                $tabla .= "<img src='img/detalle.png'  title='Detalle Seguimiento' width='20' height='20' id='detalle' style='cursor:pointer' border='0' onclick='loadingSeguimientos(" . $urlEdit . ")'>";
            } else {

                $tabla .= "<img src='img/detalle.png'  title='Detalle Seguimiento' width='20' height='20' id='detalle' style='cursor:pointer' border='0' onclick='loadingSeguimientos(" . $urlEdit . ")'>";
            }

            $tabla .= "</td>
                </tr>";
        }

        $tabla .= "</tbody>
                    </table></form>
                    </div>
                    ";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function DeleteSeguimientoActi($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql = "CALL SP_ptseguimiento('3','" . trim($data['seguimiento_id']) . "','','','0','','','','','','','','','','','" . $id_usuario . "','','','','');";


        $result = $obj_bd->EjecutaConsulta($sql);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function JsonSeguimiento($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_ptseguimiento('4','" . trim($data['seguimiento_id']) . "','','','','','','','','','','','','','','','','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['seguimiento_id'] = $array['seguimiento_id'];
        $arreglo_retorno['seguimiento_avance'] = $array['seguimiento_avance'];
        $arreglo_retorno['seguimiento_fechaini'] = $array['seguimiento_fechaini'];
        $arreglo_retorno['seguimiento_fechafin'] = $array['seguimiento_fechafin'];
        $arreglo_retorno['seguimiento_horaini'] = $array['seguimiento_horaini'];
        $arreglo_retorno['seguimiento_horafin'] = $array['seguimiento_horafin'];
        $arreglo_retorno['seguimiento_obs'] = utf8_encode($array['seguimiento_obs']);
        $arreglo_retorno['seguimiento_revision'] = $array['seguimiento_revision'];

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function ListSoporteSeguimiento($data) {
        $obj_bd = new BD();

        $sql = "CALL SP_ptsoporteseguimiento('1','','','','','','','" . $data['seguimiento_id'] . "','');";
        $result = $obj_bd->EjecutaConsulta($sql);

        return $result;
    }

    public function DeleteDocSeguimiento($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql = "CALL SP_ptsoporteseguimiento('3','" . trim($data['soporte_seguimiento_id']) . "','0','','','','" . $id_usuario . "','','');";
        $result = $obj_bd->EjecutaConsulta($sql);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function UpdateObsDocsSeguimiento($files_data, $data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql = "CALL SP_ptseguimiento('5','" . trim($data['id_seguimiento']) . "','','','','','','','','','','','" . utf8_decode(trim($data['txt_Obs_seg'])) . "','','','" . $id_usuario . "','','','','');";
        $result = $obj_bd->EjecutaConsulta($sql);


        if (!$result) {
            return 0;
        } else {
            foreach ($files_data as $key => $value) {
                $name = $value['name'];
                $tipo_documento = $value['type'];
                $tamanio_doc = $value['size'];
                //carga de documento
                move_uploaded_file($value['tmp_name'], '../../docs/' . $name);

                //registro de documento en el sistema tabla documento
                $sql_sopt = "CALL SP_dtsoporte('2','','','','" . trim($name) . "','" . trim($tamanio_doc) . "','" . trim($tipo_documento) . "','lib/docs/$name','" . $id_usuario . "','');";

                $resultado_sopt = $obj_bd->EjecutaConsulta($sql_sopt);
                $array_sopt = $obj_bd->FuncionFetch($resultado_sopt);
                $soporte_id_insert = $array_sopt['soporte_id_insert'];

                //asociacion del los documentos 
                $sql_sopt = "CALL SP_ptsoporteseguimiento('2','','','','','" . $id_usuario . "','','" . trim($data['id_seguimiento']) . "','" . $soporte_id_insert . "');";

                $resultado_Asc = $obj_bd->EjecutaConsulta($sql_sopt);
            }
            if ($resultado_Asc) {

                return 1;
            } else {
                return 3;
            }
        }
    }

    public function SaveDescargo($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql = "CALL SP_ptdescargo('2','','" . utf8_decode(trim($data['txt_des_act'])) . "',
                '" . $id_usuario . "',
                '','" . trim($data['ordentrabajo_id']) . "','" . trim($data['presupuesto_id']) . "',
                '" . utf8_decode(trim($data['tipo_descargo'])) . "','" . utf8_decode(trim($data['riesgo_disparo'])) . "',
                '" . utf8_decode(trim($data['anexo'])) . "',
                '" . utf8_decode(trim($data['responsable_codensa'])) . "');";


        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);
        $descargo_id = $array['descargo_id_insert'];


        if (!$result) {
            return 0;
        } else {
            return $descargo_id;
        }
    }

    public function JsonDescargoOT($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_ptdescargo('1','','','','','" . trim($data['ordentrabajo_id']) . "','" . trim($data['presupuesto_id']) . "','','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['descargo_actividad'] = utf8_encode($array['descargo_actividad']);
        $arreglo_retorno['descargo_tipo'] = $array['descargo_tipo'];
        $arreglo_retorno['descargo_riesgo'] = $array['descargo_riesgo'];
        $arreglo_retorno['descargo_preipoanexo'] = $array['descargo_preipoanexo'];
        $arreglo_retorno['descargo_codensa'] = utf8_encode($array['descargo_codensa']);

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    function cargarEstadoActividad()
    {
        ///////////////
        // VARIABLES //
        ///////////////
        $contenido = '';

        $contenido .= "<br>";
        $contenido .= "<br>";
        $contenido .= "<br>";
        $contenido .= "<br>";
        $contenido .= "<br>";
        $contenido .= "<fieldset class='letraBl'>";
        $contenido .= '<section class="container">
                            <div class="row text-center">
                                <div class="form-group">
                                    <label class="h3">Estado: </label>
                                    <select class="h3 p-4" id="sl_est_act" name="sl_est_act">
                                        <option value="">--Seleccione--</option>
                                        <option value="FACTURA PARCIAL">Factura Parcial</option>
                                        <option value="FINALIZADA">Finalizada</option>
                                        <option value="PROGRAMADA">Programada</option>
                                        <option value="RECHAZADA">Rechazada</option>
                                    </select>
                                    <div>
                                    <button class="fondo p-2 btn btn-primary" onClick="gritGestionAct()">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </fieldset>';
        $contenido .= "<br>";
        $contenido .= "<br>";

        return $contenido;
    }


    function gritGestionAct($post) {

        $obj_bd = new BD();

        //////////////
        //VARIABLES //
        //////////////
        $estado = $post['estado'];
        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $id_perfil = $_SESSION['Usuario']['ID_PERFIL'];
        $id_area = $_SESSION['Usuario']['ID_AREA'];
        // print_r($_SESSION['Usuario']);

        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset class='letraBl'>";
        $tabla .= "<legend class='titulo'>Historial</legend>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-hover" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr class="fondo letraN">                              
                            <th>No. OT</th>  
                            <th>Estado</th> 
                            <th>Subestacion</th> 
                            <th>Modulo</th>
                            <th>Labor</th> 
                            <th>Responsable</th>                       
                            <th>Area</th>                                                        
                            <th>Actividad</th>
                            <th>Fecha/Hora Inicio</th>                                                        
                            <th>Fecha/Hora Fin</th>                                                        
                        <th>Asignado Por</th>                                                       
                            <th>Accion</th>       
                        </tr>
                    </thead>
                    <tbody>';

        if ($estado == 'FACTURA PARCIAL') 
        {
            if ($id_perfil != 1 && $id_perfil != 6 && $id_perfil != 9) {
                if (isset($id_area)) {
                    $sql = "CALL SP_ptperfil_usuario('14','','" . $id_area . "','".$estado."','');";
                } else {
                    $sql = "CALL SP_ptperfil_usuario('13','','','".$estado."','');";
                }
            } else {
                $sql = "CALL SP_ptperfil_usuario('13','','','".$estado."','');";
            }   
        }
        else
        {
            if ($id_perfil != 1 && $id_perfil != 6 && $id_perfil != 9) {
                if (isset($id_area)) {
                    $sql = "CALL SP_ptperfil_usuario('11','','" . $id_area . "','".$estado."','');";
                } else {
                    $sql = "CALL SP_ptperfil_usuario('10','','','".$estado."','');";
                }
            } else {
                $sql = "CALL SP_ptperfil_usuario('10','','','".$estado."','');";
            }
        }


        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

//        $responsables="";    
//        $param= array('presupuesto_id'=>$row['presupuesto_id'] );
//        $data_responsables=$this->JsonEncargadosPresupuesto($param);
//
//        for($i=0; $i<$data_responsables['registros'];$i++){
//            $responsables.=$data_responsables['encargados'][$i]['usuario_nombre'].' '.$data_responsables['encargados'][$i]['usuario_apellidos'];
//            
//        }

            $urlEdit = '"lib/4ot/view/formSeguimientoGest.php","contenido","' . $row['baremo_id'] . '","' . $row['ordentrabajo_id'] . '","' . $row['presupuesto_id'] . '","' . $row['tipobaremo_id'] . '","' . $row['presupuesto_progestado'] . '","' . $row['presupuesto_porcentaje'] . '",""';
            $tabla .= "<tr id='" . $row['presupuesto_id'] . "'>                
                <td>" . utf8_encode($row['ordentrabajo_num']) . "</td>                     
                <td>" . $row['presupuesto_progestado'] . "</td>                                                    
                <td>" . utf8_encode($row['subestacion_nombre']) . "</td>  
                <td>" . utf8_encode($row['modulo_descripcion']) . "</td>   
                <td>" . utf8_encode($row['tipo_labor']) . "</td>  
                <td class='Responsable'>" . utf8_encode($row['responsable']) . "</br><button type='button' class='btn btn-link' onclick='MostrarResponsablesTb(" . $row['presupuesto_id'] . ")'>Ver Mas</button></td>                 
                <td>" . utf8_encode($row['area_nombre']) . "</td>                
                <td>" . utf8_encode($row['actividad_descripcion'] . ' ' . $row['subactividad_descripcion']) . "</td>                
                <td>" . $row['presupuesto_fechaini'] . " - " . $row['presupuesto_horaini'] . "</td>                
                <td>" . $row['presupuesto_fechafin'] . " - " . $row['presupuesto_horafin'] . "</td>                                                                         
                <td>" . utf8_encode($row['asigno']) . "</td>                                                 
                <td>";
                // <button class='btn btn-info fondo'  onclick='loadingSeguimientos(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Reportar  </button>
            if (utf8_encode($row['subactividad_descripcion']) == "LEVANTAMIENTO") {
                $tabla .= "<button class='btn btn-default'  onclick='DivEditDescargo(" . $row['ordentrabajo_id'] . "," . $row['presupuesto_id'] . ")'><span class='glyphicon glyphicon-book' aria-hidden='true'></span> Descargo  </button>";
            }
            $tabla .= "</td> 
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable({'order': [[ 1, 'asc' ]]});</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function JsonDetalleActividad($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_ptpresupuesto('12','" . $data['presupuesto_id'] . "','','','','','','','','','','','','','','','','','','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $array = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['subestacion_nombre'] = utf8_encode($array['subestacion_nombre']);
        $arreglo_retorno['ordentrabajo_num'] = $array['ordentrabajo_num'];
        $arreglo_retorno['detallepresupuesto_objeto'] = utf8_encode($array['detallepresupuesto_objeto']);
        $arreglo_retorno['presupuesto_obs'] = utf8_encode($array['presupuesto_obs']);
        $arreglo_retorno['presupuesto_alcances'] = utf8_encode($array['presupuesto_alcances']);
        $arreglo_retorno['presupuesto_entregables'] = utf8_encode($array['presupuesto_entregables']);
        $arreglo_retorno['presupuesto_programacion_obs'] = utf8_encode($array['presupuesto_programacion_obs']);
        $texto_alcance = str_replace('. ', '. <br><br>', $array['detallepresupuesto_alcance']);
        // $texto_alcance = preg_replace("/./", "****", $array['detallepresupuesto_alcance']);
        $arreglo_retorno['detallepresupuesto_alcance'] = utf8_encode($texto_alcance);

        $arreglo_retorno['modulo_descripcion'] = utf8_encode($array['modulo_descripcion']);
        $arreglo_retorno['labor_descripcion'] = utf8_encode($array['labor_descripcion']);
        $arreglo_retorno['labor_id'] = $array['labor_id'];
        $arreglo_retorno['baremo_item'] = utf8_encode($array['baremo_item']);
        $arreglo_retorno['actividad_descripcion'] = utf8_encode($array['actividad_descripcion']);
        $arreglo_retorno['actividad_gom'] = utf8_encode($array['actividad_gom']);
        $arreglo_retorno['presupuesto_porcentaje'] = utf8_encode($array['presupuesto_porcentaje']);
        $arreglo_retorno['presupuesto_valorporcentaje'] = number_format((float) $array['presupuesto_valorporcentaje'], 0, ',', '.');

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function SumActividadesLevantaiento($data) {

        $total = 0;
        $obj_bd = new BD();
        $sql = "CALL SP_dtdetallepresupuesto('7','" . $data['detallepresupuesto_id'] . "','','','','','','','','','','','','','','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);

        while ($array = $obj_bd->FuncionFetch($result)) {
            $total = $total + $array['presupuesto_valorporcentaje'];
        }

        return $total;
    }

    public function SaveIncremento($data) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];


        if ($data["slc_tipo_incremento"] == "3") {

            $array_incrementos = $data["listaIncrementos"];
            $array_incporc = $data["listaIncPorcentaje"];
            $array_incrementos_valor = $data["listaIncValor"];
            $array_incrementos_lb = $data["listaInclb"];
            //Eliminar presupuestos anteriores
            $sql = "CALL SP_dtdetallepresupuesto('10','" . $data['detallepresupuesto_id'] . "','','','','','','','','','','','','','','','','');";

            $result = $obj_bd->EjecutaConsulta($sql);

            if (!$result) {
                return 0;
            }
            for ($i = 0; $i < count($array_incrementos); $i++) {

                $detallepresupuesto_id = $data['detallepresupuesto_id'];
                $porcentaje = $array_incporc[$i];
                $valor = str_replace('.', '', $array_incrementos_valor[$i]);
                $tipo_incremento = $array_incrementos_lb[$i];
                $tipo_incremento_id = $array_incrementos[$i];

                //llenar la tabla dt_incremento_presupuesto
                $sql = "CALL SP_dtdetallepresupuesto('9','" . $detallepresupuesto_id . "','','" . $tipo_incremento_id . "','','','','','','','','','" . $tipo_incremento . "','" . $id_usuario . "','','','" . $porcentaje . "','" . $valor . "');";

                $result = $obj_bd->EjecutaConsulta($sql);

                if (!$result) {
                    return 0;
                }
            }
        }

        // se inserta los valores normal 
        $valor_sinPuntos = str_replace('.', '', $data['txt_totalIncremento']);
        $sql = "CALL SP_dtdetallepresupuesto('8','" . $data['detallepresupuesto_id'] . "','','','','','','','','','','','" . $data['slc_tipo_incremento'] . "','" . $id_usuario . "','','','" . $data['txt_porc_incremento'] . "','" . $valor_sinPuntos . "');";

        $result = $obj_bd->EjecutaConsulta($sql);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function JsonEncargadosPresupuesto($data) {

        $arreglo_retorno = array();
        $arreglo_encragados = array();

        $obj_bd = new BD();
        $sql = "CALL SP_ptpresupuesto('21','" . trim($data['presupuesto_id']) . "','','','','','','','','','','','','','','','','','','','','');";
        $num = $obj_bd->Filas($sql);
        if ($num > 0) {
            $result = $obj_bd->EjecutaConsulta($sql);
            $i = 0;

            while ($array = $obj_bd->FuncionFetch($result)) {


                $arreglo_encragados[$i]['perfilusuario_id'] = utf8_encode($array['perfilusuario_id']);
                $arreglo_encragados[$i]['area_id'] = utf8_encode($array['area_id']);
                $arreglo_encragados[$i]['usuario_apellidos'] = utf8_encode($array['usuario_apellidos']);
                $arreglo_encragados[$i]['usuario_nombre'] = utf8_encode($array['usuario_nombre']);
                $arreglo_encragados[$i]['perfil_nombre'] = utf8_encode($array['perfil_nombre']);
                $arreglo_encragados[$i]['area_nombre'] = utf8_encode($array['area_nombre']);
                $i++;
            }
        }

        $sql_encargados = "CALL SP_ptpresupuesto('22','" . trim($data['presupuesto_id']) . "','','','','','','','','','','','','','','','','','','','','');";
        $result_encargados = $obj_bd->EjecutaConsulta($sql_encargados);
        $num_encargados = $obj_bd->Filas($sql_encargados);
        while ($array_encargados = $obj_bd->FuncionFetch($result_encargados)) {


            $arreglo_encragados[$i]['perfilusuario_id'] = utf8_encode($array_encargados['perfilusuario_id']);
            $arreglo_encragados[$i]['area_id'] = utf8_encode($array_encargados['area_id']);
            $arreglo_encragados[$i]['usuario_apellidos'] = utf8_encode($array_encargados['usuario_apellidos']);
            $arreglo_encragados[$i]['usuario_nombre'] = utf8_encode($array_encargados['usuario_nombre']);
            $arreglo_encragados[$i]['perfil_nombre'] = utf8_encode($array_encargados['perfil_nombre']);
            $arreglo_encragados[$i]['area_nombre'] = utf8_encode($array_encargados['area_nombre']);
            $i++;
        }

        $arreglo_retorno['encargados'] = $arreglo_encragados;
        $arreglo_retorno['registros'] = $num + $num_encargados;
        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function ListActividadesReportar($data) {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset class='letraBl'>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<form id="Actividades_reportar">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-hover" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr class="fondo letraN">
                           <th>OT</th>
                           <th>Subestacion</th> 
                           <th>Objeto</th>
                           <th>Modulo</th>                                                  
                           <th>Labor</th>                                              
                           <th>Actividad</th>                      
                           <th>Alcance técnico particular</th>
                           <th>Cantidad</th>
                           <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>';


        $array_presupuesto_id = explode("|", $data['txt_array_presupuesto_id']);
        for ($a = 0; $a < count($array_presupuesto_id); $a++) {
            $sql = "CALL SP_ptpresupuesto('12','" . $array_presupuesto_id[$a] . "','','','','','','','','','','','','','','','','','','','','');";
            $resultado = $obj_bd->EjecutaConsulta($sql);

            $array = $obj_bd->FuncionFetch($resultado);
            $texto_alcance = str_replace('. ', '. <br><br>', $array['detallepresupuesto_alcance']);
            $tabla .= "
                <tr> 
                <td>" . $array['ordentrabajo_num'] . "</td>                     
                <td>" . utf8_encode($array['subestacion_nombre']) . "</td>                     
                <td>" . utf8_encode($array['detallepresupuesto_objeto']) . "</td>                     
                                
                <td>" . utf8_encode($array['modulo_descripcion']) . "</td>                     
                <td>" . utf8_encode($array['item']) . "  " . utf8_encode($array['labor_descripcion']) . "</td>                     
                <td>" . utf8_encode($array['actividad_descripcion']) . "</td>                     
                <td>" . utf8_encode($array['presupuesto_obs']) . "</td>                     
                <td>" . utf8_encode($array['presupuesto_porcentaje']) . "</td>                     
                <td>" . number_format((float) $array['presupuesto_valorporcentaje'], 0, ',', '.') . "</td>                                                                
                             
                <td>";

            $tabla .= "</td>
                </tr>";
        }


        $tabla .= "</tbody>
                    </table></form>
                    </div>
                    ";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    function SaveSeguimientoBloqueLabores($files_data, $data) {


        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $obj_bd = new BD();


        $porc_av = $data['porc_av'];
        $slc_estado_actividad = $data['slc_estado_actividad'];
        $txtInicioSeg = $data['txtInicioSeg'];
        $txtHoraIniSeg = $data['txtHoraIniSeg'];
        $txtFnicioSeg = $data['txtFnicioSeg'];
        $txtHoraFinSeg = $data['txtHoraFinSeg'];
        $txt_Obs_seg = $data['txt_Obs_seg'];
        $return_ok = 0;

        /* Arreglo de actividades */
        $array_presupuesto_id = explode("|", $data['txt_array_presupuesto_id']);
        for ($a = 0; $a < count($array_presupuesto_id); $a++) {

            /* Numero de seguimiento */
            $sql_num = "CALL SP_ptseguimiento('1','','','','','','','','','','','','','','','','','','" . trim($array_presupuesto_id[$a]) . "','');";

            $resultado_num = $obj_bd->Filas($sql_num);

            if ($resultado_num == 0) {
                $num_seg = 1;
            } else {
                $num_seg = $resultado_num + 1;
            }
            /* Fin numero de seguimiento */

            /* Traer otros datos */
            $sql_datos = "CALL SP_ptseguimiento('6','','','','','','','','','','','','','','','','','','" . trim($array_presupuesto_id[$a]) . "','');";

            $resultado_num_datos = $obj_bd->Filas($sql_datos);
            if ($resultado_num_datos > 0) {
                $result_datos = $obj_bd->EjecutaConsulta($sql_datos);
                $array_datos = $obj_bd->FuncionFetch($result_datos);
                $baremo_id = $array_datos['baremo_id'];
                $ordentrabajo_id = $array_datos['ordentrabajo_id'];
                $presupuesto_id = $array_datos['presupuesto_id'];
                $tipobaremo_id = $array_datos['tipobaremo_id'];
                $presupuesto_porcentaje = $array_datos['presupuesto_porcentaje'];
            } else {
                $return_ok = 2;
            }
            /* Fin traer datos */

            /* Insertar seguimiento */
            $txtInicioSeg1 = date("Y-m-d", strtotime($txtInicioSeg));
            $txtFnicioSeg1 = date("Y-m-d", strtotime($txtFnicioSeg));

            /* calcular porcentaje de avance de la labor */
            $porc_cal = ($presupuesto_porcentaje * $porc_av) / 100;

            // conv_porc = parseFloat((porc_act * insert_porc) / 100);
            /* fin calculo */

            // $txtFnicioSeg1=date_format($txtFnicioSeg, 'Y-m-d');
            $sql = "CALL SP_ptseguimiento('2','','" . trim($porc_cal) . "','" . $id_usuario . "','','" . trim($txtInicioSeg1) . "','" . trim($txtFnicioSeg1) . "','','','" . trim($txtHoraIniSeg) . "','" . trim($txtHoraFinSeg) . "','" . trim($num_seg) . "','" . utf8_decode(trim($txt_Obs_seg)) . "','','" . $id_usuario . "','','" . trim($baremo_id) . "','" . trim($ordentrabajo_id) . "','" . trim($presupuesto_id) . "','" . trim($tipobaremo_id) . "');";

            $resultado = $obj_bd->EjecutaConsulta($sql);
            $array = $obj_bd->FuncionFetch($resultado);
            $seguimientoo_id_insert = $array['seguimiento_id_insert'];


            if (!$resultado) {
                $return_ok = 2;
            } else {

                //Cambiar estado de la actividad programada
                if ($slc_estado_actividad != "") {
                    $sql_estado_prog = "CALL SP_ptpresupuesto('11','" . trim($presupuesto_id) . "','','','','','','','','" . trim($slc_estado_actividad) . "','','','','" . $id_usuario . "','','','','','','','','');";

                    $resultado_prog = $obj_bd->EjecutaConsulta($sql_estado_prog);
                    if (!$resultado_prog) {
                        $return_ok = 2;
                    }
                }
                foreach ($files_data as $key => $value) {
                    $name = $value['name'];
                    $tipo_documento = $value['type'];
                    $tamanio_doc = $value['size'];
                    //carga de documento
                    move_uploaded_file($value['tmp_name'], '../../docs/' . $name);

                    //registro de documento en el sistema tabla documento
                    $sql_sopt = "CALL SP_dtsoporte('2','','','','" . trim($name) . "','" . trim($tamanio_doc) . "','" . trim($tipo_documento) . "','lib/docs/$name','" . $id_usuario . "','');";

                    $resultado_sopt = $obj_bd->EjecutaConsulta($sql_sopt);
                    $array_sopt = $obj_bd->FuncionFetch($resultado_sopt);
                    $soporte_id_insert = $array_sopt['soporte_id_insert'];

                    //asociacion del los documentos 
                    $sql_sopt = "CALL SP_ptsoporteseguimiento('2','','','','','" . $id_usuario . "','','" . $seguimientoo_id_insert . "','" . $soporte_id_insert . "');";

                    $resultado_Asc = $obj_bd->EjecutaConsulta($sql_sopt);
                }



                if ($resultado_Asc) {
                    $return_ok = 1;
                } else {
                    $return_ok = 3;
                }
            }
            /* Fin insertar seguimiento */
        }
        if ($return_ok = 1) {

            return 1;
        } else {
            return 3;
        }
        /* Fin arreglo actividades */
        //$num_seg = $data['num_seg'];
        //numero de seguimiento 
    }

    public function ValidarArrayPresupuesto($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $arrayPresupuesto = $data['param_labores_reportar_presupuesto_id'];

        $array_consultar = str_replace("|", ",", $arrayPresupuesto);

        $sql_validar = "SELECT  ot.ordentrabajo_id,
                                pt.modulo_id,
                                pt.baremo_id,
                                pt.tipobaremo_id,
                                pt.area_id
                           FROM pt_presupuesto pt
                     INNER JOIN pt_orden_trabajo ot on pt.detallepresupuesto_id=ot.detallepresupuesto_id
                          WHERE pt.presupuesto_id IN(" . $array_consultar . ")
                       GROUP BY ot.ordentrabajo_id,
                                pt.area_id";

        $valida_ok = $obj_bd->Filas($sql_validar);
        if ($valida_ok == 1) {

            /* VALIDAR ESTADOS */
            $estado = "     SELECT  ot.ordentrabajo_id,
                                pt.modulo_id,
                                pt.baremo_id,
                                pt.tipobaremo_id,
                                pt.area_id,pt.presupuesto_progestado
                           FROM pt_presupuesto pt
                     INNER JOIN pt_orden_trabajo ot on pt.detallepresupuesto_id=ot.detallepresupuesto_id
                          WHERE pt.presupuesto_id IN (" . $array_consultar . ")
                            AND pt.presupuesto_progestado   IN  ('FINALIZADA','RESUELTA')
                       GROUP BY ot.ordentrabajo_id,
                                pt.area_id";
            $valida_estados = $obj_bd->Filas($estado);
            if ($valida_estados > 0) {
                return 0;
            } else {
                return 1;
            }
            return 1;
        } else {
            return 0;
        }
    }


    public function cargar_normas ($post){

        /////////////////////
        // LLAMAR CLASE BD //
        /////////////////////
        $obj_bd = new BD();


        ///////////////
        // VARIABLES //
        ///////////////
        $tabla = "";
        $presupuesto_id = $post['presupuesto_id'];


        /////////////
        // PROCESO //
        /////////////

        $tabla .="<style>.ui-dialog-titlebar-close {
            visibility: hidden;
        }</style>";
        $tabla .="<fieldset>";
            $tabla .="<div class='table-responsive'>";
                $tabla .="<form id='presupuesto_actividades_asoc'>";
                    $tabla .="<table cellpadding='0' class='table table-bordered table-hover' border='0' id='tabla_cargarNormas'>";
                        $tabla .="<thead>";
                            $tabla .="<tr class='fondo letraN'>
                                <th>Norma</th>
                                <th>Versión</th>
                                <th>Entidad</th>
                                <th>Ubicación</th>
                                <th>Acción</th>";
                            $tabla .="</tr>";
                        $tabla .="</thead>";

                        $tabla .="<tbody>";

                            /////////////////////
                            // CONSULTA NORMAS //
                            /////////////////////
                            $sql_norma = "CALL SP_cfnormas('1','','','','','','','');";
                            $res_norma = $obj_bd->EjecutaConsulta($sql_norma);

                            while ($row_norma = $obj_bd->FuncionFetch($res_norma)) {

                                $tabla .="<tr>";

                                $sql_norma_con = "CALL SP_cfnormas('3','".$row_norma['normas_id']."','".$presupuesto_id."','','','','','');";
                                $res_norma_con = $obj_bd->EjecutaConsulta($sql_norma_con);
                                $row_norma_con = $obj_bd->FuncionFetch($res_norma_con);

                                $existe = $row_norma_con['_existe'];

                                if ($existe == 0 || $existe == "") {
                                    $tabla .= "<td><button id='btn_agregarNormas_".$row_norma['normas_id']."' class='btn btn-primary' value='".$row_norma['normas_id']."' onclick='agregar_normas(this.value,".$presupuesto_id.");'><span id='spanNormas_".$row_norma['normas_id']."'>Agregar</span></button>
                                        <br>
                                        <button id='btn_quitarNormas_".$row_norma['normas_id']."' class='btn btn-danger hidden' value='".$row_norma['normas_id']."' onclick='quitar_normas(this.value,".$presupuesto_id.");'>Quitar</button>
                                        </td>";
                                }else{
                                    $tabla .= "<td><button id='btn_agregarNormas_".$row_norma['normas_id']."' class='btn btn-success disabled' value='".$row_norma['normas_id']."' onclick='agregar_normas(this.value,".$presupuesto_id.");'><span id='spanNormas_".$row_norma['normas_id']."'>Agregado</span></button>
                                        <br>
                                        <button id='btn_quitarNormas_".$row_norma['normas_id']."' class='btn btn-danger' value='".$row_norma['normas_id']."' onclick='quitar_normas(this.value,".$presupuesto_id.");'>Quitar</button>
                                        </td>";
                                }

                                $tabla .="
                                <td>". utf8_encode($row_norma['normas_descripcion']) ."</td>
                                <td>". utf8_encode($row_norma['normas_version']) ."</td>
                                <td>". utf8_encode($row_norma['normas_entidad']) ."</td>
                                <td><a target = '_blank' href='". utf8_encode($row_norma['normas_ubicacion']) ."'>". utf8_encode($row_norma['normas_ubicacion']) ."</a></td>";

                                $tabla .="</tr>";
                            }

                        $tabla .="</tbody>"; 
                    $tabla .="</table>";
                $tabla .="</form>";
            $tabla .="</div> <script>$('#tabla_cargarNormas').DataTable(
        {'order': [[ 0, 'asc' ]]});</script>";
        $tabla .="</fieldset>";

        return $tabla;

    }//fin funcion

    
    public function agregar_normas($post){

        /////////////////////
        // LLAMAR CLASE BD //
        /////////////////////
        $obj_bd = new BD();


        ///////////////
        // VARIABLES //
        ///////////////
        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $norma_id = $post['norma_id'];
        $presupuesto_id = $post['presupuesto_id'];


        /////////////
        // PROCESO //
        /////////////
        
        $sql_norma = "CALL SP_cfnormas('2','".$norma_id."','".$id_usuario."','".$presupuesto_id."','','','','');";
        $res_norma = $obj_bd->EjecutaConsulta($sql_norma);
        $row_norma = $obj_bd->FuncionFetch($res_norma);

        $insert = $row_norma['_ultimo'];

        if ($insert == 0 || $insert == ""){

            return 0;
    
        }else{

            return 1;

        }

    }


    public function quitar_normas($post){

        /////////////////////
        // LLAMAR CLASE BD //
        /////////////////////
        $obj_bd = new BD();


        ///////////////
        // VARIABLES //
        ///////////////
        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $norma_id = $post['norma_id'];
        $presupuesto_id = $post['presupuesto_id'];


        /////////////
        // PROCESO //
        /////////////
        

        $sql_norma = "CALL SP_cfnormas('5','".$norma_id."','".$id_usuario."','".$presupuesto_id."','','','','');";
        $res_norma = $obj_bd->EjecutaConsulta($sql_norma);
        $row_norma = $obj_bd->FuncionFetch($res_norma);

        $insert = $row_norma['_existe'];
        
        return $insert;

        if ($insert == 0 || $insert == ""){

            return 0;
    
        }else{

            return 1;

        }

    }


    public function alcancesBaremados($post)
    {
        /////////////////////
        // LLAMAR CLASE BD //
        /////////////////////
        $obj_bd = new BD();

        $alcan = explode(',',$post['alcances']);

        $i = 0;

            foreach ($alcan as $key => $value) 
            {
                // $x[$i] = $i.":".$value;

                $sql_alcance = "SELECT alcance_descripcion
                                FROM cf_alcance
                                WHERE alcance_id = ".$value.";";

                $res_alcance = $obj_bd->EjecutaConsulta($sql_alcance);
                $alcance = $obj_bd->FuncionFetch($res_alcance);

                $alcance1[$i] = utf8_encode($alcance['alcance_descripcion']);
                
                $i++;
            };
        

        $alcan = implode(' <br><br>- ', $alcance1);

        return json_encode($alcan);
    }


    public function entregablesBaremados($post)
    {
        /////////////////////
        // LLAMAR CLASE BD //
        /////////////////////
        $obj_bd = new BD();

        $entre = explode(',',$post['entregables']);

        $i = 0;

            foreach ($entre as $key => $value) 
            {
                // $x[$i] = $i.":".$value;

                $sql_entre = "SELECT entregable_descripcion
                                FROM cf_entregable
                                WHERE entregable_id = ".$value.";";

                $res_entre = $obj_bd->EjecutaConsulta($sql_entre);
                $entre = $obj_bd->FuncionFetch($res_entre);

                $entre1[$i] = utf8_encode($entre['entregable_descripcion']);
                
                $i++;
            };
        

        $entregable = implode(' <br><br>- ', $entre1);

        return json_encode($entregable);
    }


    public function normatividad($post)
    {
        /////////////////////
        // LLAMAR CLASE BD //
        /////////////////////
        $obj_bd = new BD();

        $sql_norma_con = "CALL SP_cfnormas('6','','".$post['presupuesto_id']."','','','','','');";
            $res_norma_con = $obj_bd->EjecutaConsulta($sql_norma_con);
            $filas = $obj_bd->Filas($sql_norma_con);

            $i = 0;
            while($row_norma_con = $obj_bd->FuncionFetch($res_norma_con))
            {

                $entre1[$i] = utf8_encode($row_norma_con['normas_descripcion']);
                $i++;
            }

        $norma = implode(' <br><br>- ', $entre1);  
                
        return json_encode($norma);
    }


    public function cargarResueltaActividad()
    {
        $obj_bd = new BD();

        //////////////
        //VARIABLES //
        //////////////
        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $id_perfil = $_SESSION['Usuario']['ID_PERFIL'];
        $id_area = $_SESSION['Usuario']['ID_AREA'];
        // print_r($_SESSION['Usuario']);
        $tabla = "";

        //////////////////
        // DISEÑO TABLA //
        //////////////////
        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset class='letraBl'>";
        $tabla .= "<legend class='titulo'>Historial</legend>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-hover" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr class="fondo letraN">                              
                            <th>No. OT</th>  
                            <th>Estado</th> 
                            <th>Subestacion</th> 
                            <th>Modulo</th>
                            <th>Labor</th> 
                            <th>Responsable</th>                       
                            <th>Area</th>                                                        
                            <th>Actividad</th>
                            <th>Fecha/Hora Inicio</th>                                                        
                            <th>Fecha/Hora Fin</th>                                                        
                        <th>Asignado Por</th>                                                       
                            <th>Accion</th>       
                        </tr>
                    </thead>
                    <tbody>';

        /////////////////
        // DATOS TABLA //
        /////////////////
        if ($id_perfil != 1 && $id_perfil != 6 && $id_perfil != 9) {
            if (isset($id_area)) {
                $sql = "CALL SP_ptperfil_usuario('16','','" . $id_area . "','','');";
            } else {
                $sql = "CALL SP_ptperfil_usuario('15','','','','');";
            }
        } else {
            $sql = "CALL SP_ptperfil_usuario('15','','','','');";
        }
        
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            $urlEdit = '"lib/4ot/view/formSeguimientoGest.php","contenido","' . $row['baremo_id'] . '","' . $row['ordentrabajo_id'] . '","' . $row['presupuesto_id'] . '","' . $row['tipobaremo_id'] . '","' . $row['presupuesto_progestado'] . '","' . $row['presupuesto_porcentaje'] . '",""';
            $tabla .= "<tr id='" . $row['presupuesto_id'] . "'>                
                <td>" . utf8_encode($row['ordentrabajo_num']) . "</td>                     
                <td>" . $row['presupuesto_progestado'] . "</td>                                                    
                <td>" . utf8_encode($row['subestacion_nombre']) . "</td>  
                <td>" . utf8_encode($row['modulo_descripcion']) . "</td>   
                <td>" . utf8_encode($row['tipo_labor']) . "</td>  
                <td class='Responsable'>" . utf8_encode($row['responsable']) . "</br><button type='button' class='btn btn-link' onclick='MostrarResponsablesTb(" . $row['presupuesto_id'] . ")'>Ver Mas</button></td>                 
                <td>" . utf8_encode($row['area_nombre']) . "</td>                
                <td>" . utf8_encode($row['actividad_descripcion'] . ' ' . $row['subactividad_descripcion']) . "</td>                
                <td>" . $row['presupuesto_fechaini'] . " - " . $row['presupuesto_horaini'] . "</td>                
                <td>" . $row['presupuesto_fechafin'] . " - " . $row['presupuesto_horafin'] . "</td>                                                                         
                <td>" . utf8_encode($row['asigno']) . "</td>                                                 
                <td>
                <button class='btn btn-info fondo'  onclick='loadingSeguimientos(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Reportar  </button>";
            if (utf8_encode($row['subactividad_descripcion']) == "LEVANTAMIENTO") {
                $tabla .= "<button class='btn btn-default'  onclick='DivEditDescargo(" . $row['ordentrabajo_id'] . "," . $row['presupuesto_id'] . ")'><span class='glyphicon glyphicon-book' aria-hidden='true'></span> Descargo  </button>";
            }
            $tabla .= "</td> 
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable({'order': [[ 1, 'asc' ]]});</script>";
        $tabla .= "<fieldset>";
        return $tabla;        
    }

    public function cargarActividadesHistorial()
    {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $id_perfil = $_SESSION['Usuario']['ID_PERFIL'];
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<br><br><br><br><fieldset class='letraBl'>";
        $tabla .= "<legend class='titulo'>Actividades Asignadas</legend>";
        $tabla .= " <button name='btnAdd' id='btnAdd' class='btn btn-default' type='button' onclick='ReportarLabores()'>Reportar Seleccionadas</button>";
        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-hover" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr class="fondo letraN">                              
                            <th>Sel.</th>  
                            <th>No. OT</th>  
                            <th>Estado</th>  
                            <th>Subestacion</th>  
                            <th>Labor</th>  
                            <th>Modulo</th>
                            <th>Area</th>                                                        
                            <th>Actividad</th>                                                        
                            <th>Fecha/Hora Inicio</th>                                                        
                            <th>Fecha/Hora Fin</th>                                                        
                            <th>Asignado Por</th>                                                                                                                
                            <th>Accion</th>                                                                                                                                            
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_ptperfil_usuario('17','" . $id_usuario . "','','" . $id_perfil . "','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {


            $urlEdit = '"lib/4ot/view/formSeguimiento.php","contenido","' . $row['baremo_id'] . '","' . $row['ordentrabajo_id'] . '","' . $row['presupuesto_id'] . '","' . $row['tipobaremo_id'] . '","' . $row['presupuesto_progestado'] . '","' . $row['presupuesto_porcentaje'] . '",""';
            $tabla .= "<tr> 
                <td><input type='checkbox' value='" . $row['presupuesto_id'] . "' id='" . $row['presupuesto_id'] . "' name='chek_reportar[]'  /></td>  
                <td>" . utf8_encode($row['ordentrabajo_num']) . "</td>                     
                <td>" . $row['presupuesto_progestado'] . "</td>                                                    
                <td>" . utf8_encode($row['subestacion_nombre']) . "</td>                                                    
                <td>" . $row['tipo_labor'] . "</td>                                                    
                <td>" . utf8_encode($row['modulo_descripcion']) . "</td>                
                <td>" . utf8_encode($row['area_nombre']) . "</td>                
                <td>" . utf8_encode($row['actividad_descripcion'] . ' ' . $row['subactividad_descripcion']) . "</td>                
                <td>" . $row['presupuesto_fechaini'] . " - " . $row['presupuesto_horaini'] . "</td>                
                <td>" . $row['presupuesto_fechafin'] . " - " . $row['presupuesto_horafin'] . "</td>                                                                         
                <td>" . utf8_encode($row['asigno']) . "</td>                                                 
                <td><button class='btn btn-default'  onclick='loadingSeguimientos(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Reportar  </button>";
            if (utf8_encode($row['subactividad_descripcion']) == "LEVANTAMIENTO") {
                $tabla .= "<button class='btn btn-default'  onclick='DivEditDescargo(" . $row['ordentrabajo_id'] . "," . $row['presupuesto_id'] . ")'><span class='glyphicon glyphicon-book' aria-hidden='true'></span> Descargo  </button>";
            }
            $tabla .= "</td> 
            </tr>";
        }


        // consultar actividades asociadas a mas de un responsable
        $sql_encargados = "CALL SP_ptperfil_usuario('18','" . $id_usuario . "','','" . $id_perfil . "','');";
        $resultado_encargados = $obj_bd->EjecutaConsulta($sql_encargados);

        while ($row = $obj_bd->FuncionFetch($resultado_encargados)) {

            $urlEdit = '"lib/4ot/view/formSeguimiento.php","contenido","' . $row['baremo_id'] . '","' . $row['ordentrabajo_id'] . '","' . $row['presupuesto_id'] . '","' . $row['tipobaremo_id'] . '","' . $row['presupuesto_progestado'] . '","' . $row['presupuesto_porcentaje'] . '",""';
            $tabla .= "<tr>                
                <td>" . utf8_encode($row['ordentrabajo_num']) . "</td>                     
                <td>" . $row['presupuesto_progestado'] . "</td>                                                    
                <td>" . utf8_encode($row['subestacion_nombre']) . "</td>                                                    
                <td>" . $row['tipo_labor'] . "</td>                                                    
                <td>" . utf8_encode($row['modulo_descripcion']) . "</td>                
                <td>" . utf8_encode($row['area_nombre']) . "</td>                
                <td>" . utf8_encode($row['actividad_descripcion'] . ' ' . $row['subactividad_descripcion']) . "</td>                
                <td>" . $row['presupuesto_fechaini'] . " - " . $row['presupuesto_horaini'] . "</td>                
                <td>" . $row['presupuesto_fechafin'] . " - " . $row['presupuesto_horafin'] . "</td>                                                                         
                <td>" . utf8_encode($row['asigno']) . "</td>                                                 
                <td><button class='btn btn-default'  onclick='loadingSeguimientos(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Reportar  </button>";
            /*  if (utf8_encode($row['subactividad_descripcion']) == "LEVANTAMIENTO") {
              $tabla .= "<button class='btn btn-default'  onclick='DivEditDescargo(" . $row['ordentrabajo_id'] . "," . $row['presupuesto_id'] . ")'><span class='glyphicon glyphicon-book' aria-hidden='true'></span> Descargo  </button>";
              } */
            $tabla .= "</td> 
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable({'order': [[ 1, 'desc' ]]});</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }
        

} // fin clase
