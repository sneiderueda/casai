<?php

/**
 * Description of MD_2usuario
 *
 * @author jennifer
 */
include '../../0connection/BD_config.php';
include '../../0connection/connection.php';
include '../../0connection/BD.php';
include '../../../components/Components.php';
include '../../../components/Notificaciones.php';

session_start();

class MD_2usuario {

    private $lib = '<script src="../../../sources/jquery/jquery-2.1.4.js"></script>
              <script src="../../../sources/jquery/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
              <link href="../../../sources/css/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet">
              ';

    /*
     * autor: Jennifer Cabiativa     
     * Descripcion: Envio correo recuperar clave
     */

    function recuperarPass($param) {
        /* funciones para enviar correo */
        $component = new Components();
        $notificacion = new Notificaciones();
        /*         * * */
        $obj_bd = new BD();
        /* Validar si existe el usuario */
        $sql_usuario = "CALL SP_validaUsuario('" . trim($param['txtNomUsuario']) . "','1','','');";


        $num_filas_usuario = $obj_bd->Filas($sql_usuario);

        if ($num_filas_usuario > 0) {
            $result_usuario = $obj_bd->EjecutaConsulta($sql_usuario);
            $arreglo_usuario = $obj_bd->FuncionFetch($result_usuario);

            $idusuario = $arreglo_usuario['usuario_id'];
            $identificacion = $arreglo_usuario['usuario_cedula'];
            $nombres = $arreglo_usuario['usuario_nombres'];
            $apellidos = $arreglo_usuario['usuario_apellidos'];
            $correo = $arreglo_usuario['usuario_correo'];
            $activo = $arreglo_usuario['usuario_estado'];



            if ($activo == '1') {
                // Se envia la contraseña por correo
                $cadena = $idusuario . $identificacion . $username . rand(1, 9999999) . date("Ymd");
                $token = sha1($cadena);
                //se actualiza la tabla usuario con el token
                $sql_update_usuario = "UPDATE USUARIO SET TOKEN='" . $token . "',FECHA_TOKEN=CURRENT_TIMESTAMP WHERE ID_USUARIO='" . $idusuario . "'";
                $res_update_usuario = $obj_bd->EjecutaConsulta($sql_update_usuario);
                if ($res_update_usuario) {
                    //$enlace = $_SERVER["SERVER_NAME"].'/restablecer.php?idusuario='.sha1($idusuario.$identificacion).'&ttkn='.$token;/*se deja opcional para probar en el sitio*/
                    $enlace = "http://" . $_SERVER['HTTP_HOST'] . dirname(dirname(dirname(dirname($_SERVER['REQUEST_URI'])))) . '/restablecer.php?hll=' . sha1($idusuario) . '&klm=' . $token; /**/
                }
                /* Envío de correos */
                $plantilla = $notificacion->forgotYourPasword($nombres . ' ' . $apellidos, $enlace, $identificacion);
                $component->sendRsForMail(null, array($correo), null, utf8_decode('Recuperación Contraseña'), $plantilla, null);
                echo $this->lib;
                echo Dialog::Message('Mensaje enviado', 'Llegar&aacute; un correo electr&oacute;nico a su cuenta', true, 2, 'Aceptar');
            } else if ($activo == '0') {
                echo $this->lib;
                echo Dialog::Message('Se&ntilde;or Usuario', 'Usted se encuentra inactivo en el sistema, para ingresar comun&iacute;quese con el administrador!!!', true, 2, 'Aceptar');
            }
        } else {
            echo $this->lib;
            echo Dialog::Message('Se&ntilde;or Usuario', 'Usted no se encuentra registrado en el sistema!!', true, 2, 'Aceptar');
        }
    }

    /*
     * autor: Jennifer Cabiativa     
     * Descripcion: login de la aplicacion
     */

    public function Login($data) {


        $obj_bd = new BD();
        $arreglo_usuario = array();


        $clave = hash('sha512', trim($data['text1']));

        $sql_logeo = "CALL SP_validaUsuario('" . trim($data['text2']) . "','2','" . $clave . "','');";

        $resultado_l = $obj_bd->EjecutaConsulta($sql_logeo);

        if ($resultado_l) {
            $arreglo_usuario = $obj_bd->FuncionFetch($resultado_l);

            if ($arreglo_usuario['usuario_estado'] == '0') {
                echo $this->lib;
                echo Dialog::Message('Mensaje de informaci&oacute;n', 'Su usuario se encuentra inactivo, por favor comun&iacute;quese con el administrador del sistema.', true, 2, 'Aceptar');
            } else {
                if ($data['text2'] == $arreglo_usuario['usuario_correo'] && $clave == $arreglo_usuario['usuario_password']) {

                    $sql_perfil_usuario = "CALL SP_ptperfil_usuario('1','" . $arreglo_usuario['usuario_id'] . "','','','');";

                    $cont_perfiles = $obj_bd->Filas($sql_perfil_usuario);


                    session_start();
                    unset($arreglo_usuario[10]);
                    unset($arreglo_usuario['usuario_password']);

                    //echo "INGRESO AL SISTESTEMA";

                    if ($cont_perfiles > 1) {

                        $arreglo_usuario['N_PERFILES'] = $cont_perfiles;
                        $_SESSION['Usuario'] = $arreglo_usuario;
                        header('Location: ../../../formRol.php');
                    } else if ($cont_perfiles == 1) {

                        $resul_perfil = $obj_bd->EjecutaConsulta($sql_perfil_usuario);
                        $arreglo_perfil = $obj_bd->FuncionFetch($resul_perfil);
                        $arreglo_usuario['PERFIL'] = $arreglo_perfil['perfil_nombre'];
                        $arreglo_usuario['ID_PERFIL'] = $arreglo_perfil['perfil_id'];
                        $arreglo_usuario['ID_AREA'] = $arreglo_perfil['area_id'];
                        $arreglo_usuario['N_PERFILES'] = 1;
                        $_SESSION['Usuario'] = $arreglo_usuario;
                        header('Location: ../../../aplicacion.php');
                    }
                } else {
                    echo $this->lib;
                    echo Dialog::Message('Mensaje de informaci&oacute;n', 'Compruebe sus datos.', true, 2, 'Aceptar');
                }
            }
        } else {
            echo $this->lib;
            echo Dialog::Message('Mensaje de informaci&oacute;n', 'Compruebe sus datos.', true, 2, 'Aceptar');
        }
    }

    public function ChangeSession($data) {
        try {
            session_start();
            $_SESSION['Usuario']['ID_PERFIL'] = $data['perfil'];
            $_SESSION['Usuario']['ID_AREA'] = $data['id_area'];
            $_SESSION['Usuario']['PERFIL'] = trim($data['nom_perfil']);
            return 1;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    function DataProfileUser($data) {

        try {
            $obj_bd = new BD();
            $sql_perfiles = "CALL SP_ptperfil_usuario('1','" . $data['usuario'] . "','','','');";
            $resul_perfiles = $obj_bd->EjecutaConsulta($sql_perfiles);

            $retorno = "<option value=''>seleccione</option>";
            while ($row = $obj_bd->FuncionFetch($resul_perfiles)) {
                $retorno .= "<option value='" . $row['perfil_id']."_".$row['area_id']. "'>" . utf8_encode($row['perfil_nombre']) ."-".utf8_encode($row['area_nombre']). "</option>";
            }
            return $retorno;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    function gritusuario() {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<legend>Usuarios Registrados</legend>";
        $url = "'lib/2usuario/view/formEditUser.php','contenido','0'";
        $tabla .= '<button name="btnAddUser" id="btnAddUser" class="btn btn-default" type="button" onclick="loadingFunctions(' . $url . ')">Crear</button>';
        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                            <th>Acción</th>  
                            <th>Nombre</th>
                            <th>Cedula</th>
                            <th>Correo</th>
                            <th>Cargo</th>                                                 
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_validaUsuario('','3','','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {
            if ($row['usuario_estado'] == "1") {
                $estado = '';
                if ($row['usuario_estado'] == '1') {
                    $estado = '0';
                    $btn = "<button  onclick='StateUpdate(" . $row['usuario_id'] . "," . $estado . ")' class='btn btn-default' ><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>Inactivar</button>";
                } else if ($row['usuario_estado'] == '0') {
                    $estado = '1';
                    $btn = "<button  onclick='StateUpdate(" . $row['usuario_id'] . "," . $estado . ")' class='btn btn-default' ><span class='glyphicon glyphicon-ok' aria-hidden='true'></span>Activar</button>";
                }
                $urlEdit = '"lib/2usuario/view/formEditUser.php","contenido","' . $row['usuario_id'] . '"';
                $tabla .= "<tr>
                <td><button class='btn btn-default'  onclick='loadingFunctions(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Editar  </button>
                    
                </td> 
                <td>" . utf8_encode($row['usuario_apellidos']) . " " . utf8_encode($row['usuario_nombre']) . "</td>                     
                <td>" . $row['usuario_cedula'] . "</td>                
                <td>" . $row['usuario_correo'] . "</td>                             
                <td>" . $row['usuario_cargo'] . "</td>
                <td>" . $btn . "</td>
            </tr>";
            }
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable();</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function StateUpdate($post) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $SqlUpdate = "CALL SP_dtusuario(
                    '1',
                    '" . $post['usuario_id'] . "',
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
                    '" . $post['estado'] . "',
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
                    '" . $id_usuario . "'
                    );";

        $result = $obj_bd->EjecutaConsulta($SqlUpdate);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function saveUser($data) {
        $obj_bd = new BD();
        $clave = hash('sha512', trim($data['txt_pass']));
        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $xml = "";
        $id_user_create = $data['user_id'];

        if ($id_user_create == "0") {
            //Ejecutar proceso Almacenado
            $ejecutaQuery = "CALL SP_dtusuario(
                    '2',
                    '',
                    '',
                    '" . utf8_decode($data['txt_surnames']) . "',
                    '',
                    '',
                    '" . utf8_decode($data['txt_cargo']) . "',
                    '" . $data['txt_cc'] . "',
                    '" . $data['txt_phone'] . "',                    
                    '',
                    '',
                    '',
                    '" . utf8_decode($data['txt_mail']) . "',
                    '',
                    '',
                    '" . $data['txt_dir'] . "',
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
                    '" . utf8_decode($data['txt_names']) . "',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '" . $clave . "',
                    '',
                    '',
                    '" . utf8_decode($data['txt_profession']) . "',
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
                    '" . $data['txt_tel'] . "',
                    '',
                    '" . $data['txt_tp'] . "',
                    '',
                    '" . $id_usuario . "',                    
                    ''
                    )";
            $res = $obj_bd->EjecutaConsulta($ejecutaQuery);
            if (!$res)
                die('Invalid query ->' . mysqli_errno() . '->' . $res);

            $array = $obj_bd->FuncionFetch($res);
            $id_user_create = $array['id_user_create'];
        }else {
            //Modificamos el usuario
            $ejecutaQuery = "CALL SP_dtusuario(
                    '3',
                    '" . $id_user_create . "',
                    '',
                    '" . utf8_decode($data['txt_surnames']) . "',
                    '',
                    '',
                    '" . utf8_decode($data['txt_cargo']) . "',
                    '" . $data['txt_cc'] . "',
                    '" . $data['txt_phone'] . "',                    
                    '',
                    '',
                    '',
                    '" . utf8_decode($data['txt_mail']) . "',
                    '',
                    '',
                    '" . $data['txt_dir'] . "',
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
                    '" . utf8_decode($data['txt_names']) . "',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '" . $clave . "',
                    '',
                    '',
                    '" . utf8_decode($data['txt_profession']) . "',
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
                    '" . $data['txt_tel'] . "',
                    '',
                    '" . $data['txt_tp'] . "',
                    '',
                    '',                    
                    '" . $id_usuario . "'
                    )";

            $res = $obj_bd->EjecutaConsulta($ejecutaQuery);
            if (!$res)
                die('Invalid query ->' . mysqli_errno() . '->' . $res);
        }

        if ($id_user_create == 0 || $id_user_create == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<id_user_create>" . $id_user_create . "</id_user_create>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function JsonDataUser($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_validaUsuario('','4','','" . $data['id_user_create'] . "');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $array_user = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['usuario_apellidos'] = utf8_encode($array_user['usuario_apellidos']);
        $arreglo_retorno['usuario_cargo'] = utf8_encode($array_user['usuario_cargo']);
        $arreglo_retorno['usuario_cedula'] = $array_user['usuario_cedula'];
        $arreglo_retorno['usuario_celular'] = $array_user['usuario_celular'];
        $arreglo_retorno['usuario_correo'] = utf8_encode($array_user['usuario_correo']);
        $arreglo_retorno['usuario_direccion'] = $array_user['usuario_direccion'];
        $arreglo_retorno['usuario_nombre'] = utf8_encode($array_user['usuario_nombre']);
        $arreglo_retorno['usuario_password'] = utf8_encode($array_user['usuario_password']);
        $arreglo_retorno['usuario_profesion'] = utf8_encode($array_user['usuario_profesion']);
        $arreglo_retorno['usuario_telefono'] = $array_user['usuario_telefono'];
        $arreglo_retorno['usuario_tp'] = $array_user['usuario_tp'];

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function ValidaMailUser($param) {


        $obj_bd = new BD();
        /* Validar si existe el usuario */
        $sql_usuario = "CALL SP_validaUsuario('" . trim($param['mail_user']) . "','1','','');";

        $num_filas_usuario = $obj_bd->Filas($sql_usuario);
        if ($num_filas_usuario > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function gritClient() {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<legend>Contratos</legend>";
        $url = "'lib/2usuario/view/formEditClient.php','contenido','0'";
        $tabla .= '<button name="btnAddUser" id="btnAddUser" class="btn btn-default" type="button" onclick="loadingFunctions(' . $url . ')">Crear</button>';
        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                            <th>Acción</th>  
                            <th>Cliente</th>
                            <th>NIT</th>                                                                           
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_dtCliente('1','','','','','','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            $estado = '';
            if ($row['cliente_estado'] == '1') {
                $estado = '0';
                $btn = "<button  onclick='StateUpdateClient(" . $row['cliente_id'] . "," . $estado . ")' class='btn btn-default' ><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>Inactivar</button>";
            } else if ($row['cliente_estado'] == '0') {
                $estado = '1';
                $btn = "<button  onclick='StateUpdateClient(" . $row['cliente_id'] . "," . $estado . ")' class='btn btn-default' ><span class='glyphicon glyphicon-ok' aria-hidden='true'></span>Activar</button>";
            }
            $urlEdit = '"lib/2usuario/view/formEditClient.php","contenido","' . $row['cliente_id'] . '"';
            $tabla .= "<tr>
                <td><button class='btn btn-default'  onclick='loadingFunctions(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Editar  </button>
                    
                </td> 
                <td>" . $row['cliente_descripcion'] . "</td>                     
                <td>" . $row['cliente_pid'] . "</td>                                                
                <td>" . $btn . "</td>
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable();</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function JsonPermission($data) {
        $obj_bd = new BD();
        $arreglo_general = array();

        // MOSTRAR LAS AREAS DEL USUARIO
        $sql = "CALL SP_ptperfil_usuario('2','" . $data['usuario'] . "','','','');";

        $filas = $obj_bd->Filas($sql);


        $resul = $obj_bd->EjecutaConsulta($sql);
        $i = 0;

        while ($row = $obj_bd->FuncionFetch($resul)) {
            $arreglo_perfiles = array();

            //MOSTRAR LOS PERFILES POR AREAS
            $sql_perfiles = "CALL SP_ptperfil_usuario('3','" . $data['usuario'] . "','" . $row['area_id'] . "','','');";

            $resul_profil = $obj_bd->EjecutaConsulta($sql_perfiles);
            $a = 0;
            while ($row1 = $obj_bd->FuncionFetch($resul_profil)) {
                $arreglo_perfiles[$a]['perfil_id'] = $row1['perfil_id'];
                $arreglo_perfiles[$a]['perfil_nombre'] = utf8_encode($row1['perfil_nombre']);
                $a++;
            }
            $a = 0;


            $arreglo_general[$i]['area_id'] = $row['area_id'];
            $arreglo_general[$i]['area_nombre'] = utf8_encode($row['area_nombre']);
            $arreglo_general[$i]['perfiles'] = $arreglo_perfiles;
            $i++;

            $arreglo_perfiles = "";
        }


        $arreglo_retorno['info'] = $arreglo_general;
        $arreglo_retorno['id_usuario'] = $data['usuario'];
        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function ListProfile() {
        $obj_bd = new BD();

        $sql = "CALL SP_ptperfil_usuario('4','','','','');";

        $resul = $obj_bd->EjecutaConsulta($sql);
        $retorno .= "<option value=''>-Seleccione-</option>";
        while ($row = $obj_bd->FuncionFetch($resul)) {

            $retorno .= "<option value='" . $row['perfil_id'] . "'>" . utf8_encode($row['perfil_nombre']) . "</option>";
        }
        return $retorno;
    }

    public function DeleteAreaUser($data) {
        $obj_bd = new BD();
        $sql = "CALL SP_ptperfil_usuario('6','" . $data['id_persona'] . "','" . $data['area'] . "','','');";
        @$resul = $obj_bd->EjecutaConsulta($sql);

        if (!$resul) {
            die('Invalid query ->' . mysqli_errno() . '->' . $resul);
        } else {
            return 1;
        }
    }

    public function DeleteProfileAreaUser($data) {
        $obj_bd = new BD();
        $sql = "CALL SP_ptperfil_usuario('7','" . $data['id_persona'] . "','" . $data['area_id'] . "','" . $data['profile_id'] . "','');";
        @$resul = $obj_bd->EjecutaConsulta($sql);

        if (!$resul) {
            return "no_logro";
        } else {
            return "se_logro";
        }
    }

    public function ListArea() {
        $obj_bd = new BD();

        $sql = "CALL SP_ptperfil_usuario('5','','','','');";

        $resul = $obj_bd->EjecutaConsulta($sql);
        $retorno .= "<option value=''>-Seleccione-</option>";
        while ($row = $obj_bd->FuncionFetch($resul)) {

            $retorno .= "<option value='" . $row['area_id'] . "'>" . utf8_encode($row['area_nombre']) . "</option>";
        }
        return $retorno;
    }

    public function EditUserPermission($data) {


        $obj_bd = new BD();
        $id_usuario_creo_mod = $_SESSION['Usuario']['usuario_id'];
        try {

            $arreglo_areas = explode(',', $data['arreglo_areas']);

            for ($index = 0; $index < count($arreglo_areas); $index++) {

                $sql_existe_area = "SELECT * FROM pt_perfil_usuario WHERE usuario_id=" . $data['usuario'] . " AND area_id= " . $arreglo_areas[$index] . "";

                $existe_area = $obj_bd->Filas($sql_existe_area);
                if ($existe_area > 0) {

                    $resul_existe_area = $obj_bd->EjecutaConsulta($sql_existe_area);
                    $arreglo_existe_area = $obj_bd->FuncionFetch($resul_existe_area);

                    //var_dump($data['area_profiles_' . $arreglo_areas[$index] . '']);


                    if ($data['area_profiles_' . $arreglo_areas[$index] . ''] != "" || $data['area_profiles_' . $arreglo_areas[$index] . ''] != null) {

                        $area = 'area_profiles_' . $arreglo_areas[$index];
                        $arreglo_profile = explode(',', $data[$area]);

                        for ($index1 = 0; $index1 < count($arreglo_profile); $index1++) {

                            $sql_existe_area_profile = "SELECT * FROM pt_perfil_usuario WHERE area_id = " . $arreglo_areas[$index] . " AND perfil_id = " . $arreglo_profile[$index1] . "";
                            $existe_area_profile = $obj_bd->Filas($sql_existe_area_profile);
                            if ($existe_area_profile == 0) {
                                $sql_insert_perfil = "INSERT INTO pt_perfil_usuario(perfilusuario_usuariocreo,area_id,perfil_id,usuario_id)VALUES(" . $id_usuario_creo_mod . "," . $arreglo_areas[$index] . "," . $arreglo_profile[$index1] . "," . $data['usuario'] . ")";
                                $resul_perfil = $obj_bd->EjecutaConsulta($sql_insert_perfil);
                            }
                        }
                    }
                } else if ($existe_area == 0) {

                    if ($data['area_profiles_' . $arreglo_areas[$index] . ''] != "" || $data['area_profiles_' . $arreglo_areas[$index] . ''] != null) {

                        $area = 'area_profiles_' . $arreglo_areas[$index];
                        $arreglo_profile = explode(',', $data[$area]);

                        for ($index1 = 0; $index1 < count($arreglo_profile); $index1++) {


                            $sql_insert_perfil = "INSERT INTO pt_perfil_usuario(perfilusuario_usuariocreo,area_id,perfil_id,usuario_id)VALUES(" . $id_usuario_creo_mod . "," . $arreglo_areas[$index] . "," . $arreglo_profile[$index1] . "," . $data['usuario'] . ")";
                            $resul_perfil = $obj_bd->EjecutaConsulta($sql_insert_perfil);
                        }
                    }
                }
            }

            return 1;
        } catch (Exception $e) {
            return 3;
        }
    }

    public function saveClient($data) {
        $obj_bd = new BD();
        $clave = hash('sha512', trim($data['txt_pass']));

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $xml = "";
        $client_id = $data['client_id'];

        if ($client_id == "0") {

            //Ejecutar proceso Almacenado
            $sql = "CALL SP_dtCliente('2','" . utf8_decode($data['txt_name']) . "','" . $data['txt_PID'] . "','" . $id_usuario . "','','','');";

            $res = $obj_bd->EjecutaConsulta($sql);
            if (!$res)
                die('Invalid query ->' . mysqli_errno() . '->' . $res);

            $array = $obj_bd->FuncionFetch($res);
            $client_id = $array['clien_id'];


            $sql_contrato = "CALL SP_dtcontrato('2','" . $data['txtInicio'] . "','" . $data['txtFin'] . "','" . $data['txt_numero'] . "','" . $id_usuario . "','','" . $data['txt_valor'] . "','" . $client_id . "','','');";
            $res_contrato = $obj_bd->EjecutaConsulta($sql_contrato);
            if (!$res_contrato)
                die('Invalid query ->' . mysqli_errno() . '->' . $res_contrato);

            $array = $obj_bd->FuncionFetch($res_contrato);
            $contrato_id = $array['contrato_id'];
        } else {

            //Actualizar el cliente
            $sql = "CALL SP_dtCliente('5','" . utf8_decode($data['txt_name']) . "','" . $data['txt_PID'] . "','','" . $id_usuario . "','" . $client_id . "','');";
            $res = $obj_bd->EjecutaConsulta($sql);
            if (!$res)
                die('Invalid query ->' . mysqli_errno() . '->' . $res);


            //Validar que el contrato no exista
            $sql = "CALL SP_dtcontrato('3','','','" . $data['txt_numero'] . "','','','','" . $client_id . "','1','');";

            $existe = $obj_bd->Filas($sql);

            if ($existe == 0) {

                // Inserto contrato
                $sql_contrato = "CALL SP_dtcontrato('2','" . $data['txtInicio'] . "','" . $data['txtFin'] . "','" . $data['txt_numero'] . "','" . $id_usuario . "','','" . $data['txt_valor'] . "','" . $client_id . "','','');";
                $res_contrato = $obj_bd->EjecutaConsulta($sql_contrato);
                if (!$res_contrato)
                    die('Invalid query ->' . mysqli_errno() . '->' . $res_contrato);

                $array = $obj_bd->FuncionFetch($res_contrato);
                $contrato_id = $array['contrato_id'];
            }else {

                $res_contrat = $obj_bd->EjecutaConsulta($sql);
                $array_contrat = $obj_bd->FuncionFetch($res_contrat);
                $contrat_id = $array_contrat['contrato_id'];

                //Actualizar contrato
                $sql_contratoUpdate = "CALL SP_dtcontrato('4','" . $data['txtInicio'] . "','" . $data['txtFin'] . "','" . $data['txt_numero'] . "',''," . $id_usuario . ",'" . $data['txt_valor'] . "','','','" . $contrat_id . "');";

                $res_contratoUpdate = $obj_bd->EjecutaConsulta($sql_contratoUpdate);
                if (!$res_contratoUpdate)
                    die('Invalid query ->' . mysqli_errno() . '->' . $res_contratoUpdate);
                // echo "Falló CALL: (" . $mysqli->errno() . ") " . $mysqli->error;

                $contrato_id = $contrat_id;
            }
        }

        if ($contrato_id == 0 || $contrato_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<cliente_id>" . $client_id . "</cliente_id>";
            $xml .= "</respuesta>";
        }


        return $xml;
    }

    public function JsonDataClient($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_dtCliente('3','','','','','" . $data['cliente_id'] . "','');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $array_client = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['cliente_descripcion'] = $array_client['cliente_descripcion'];
        $arreglo_retorno['cliente_pid'] = $array_client['cliente_pid'];

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function StateUpdateClient($post) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql = "CALL SP_dtCliente('4','','','','" . $id_usuario . "','" . $post['cliente_id'] . "','" . $post['estado'] . "');";

        $result = $obj_bd->EjecutaConsulta($sql);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function ListContractsClient($data) {
        $obj_bd = new BD();
        $sql = "CALL SP_dtcontrato('1','','','','','','','" . $data['cliente_id'] . "','1','');";

        $resul = $obj_bd->EjecutaConsulta($sql);

        return $resul;
    }

    public function StateUpdateContract($post) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sqlUpdateCont = "CALL SP_dtcontrato('5','','','',''," . $id_usuario . ",'',''," . $post['estado'] . "," . $post['contrato_id'] . ");";

        $result = $obj_bd->EjecutaConsulta($sqlUpdateCont);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function ListClient() {
        $obj_bd = new BD();

        $sql = "CALL SP_dtCliente('1','','','','','','');";

        $resul = $obj_bd->EjecutaConsulta($sql);
        $retorno .= "<option value=''>-Seleccione-</option>";
        while ($row = $obj_bd->FuncionFetch($resul)) {

            $retorno .= "<option value='" . $row['cliente_id'] . "'>" . utf8_encode($row['cliente_descripcion']) . " </option>";
        }
        return $retorno;
    }
    public function ListContrato($data) {
        $obj_bd = new BD();

        $sql = "CALL SP_dtCliente('7','','','','','" . $data['cliente'] . "','');";

        $resul = $obj_bd->EjecutaConsulta($sql);
        $retorno .= "<option value=''>-Seleccione-</option>";
        while ($row = $obj_bd->FuncionFetch($resul)) {

            $retorno .= "<option value='" . $row['contrato_id'] . "'>" . utf8_encode($row['contrato_numero']) . " </option>";
        }
        return $retorno;
    }

    function ListUserArea($data) {
        try {
            $obj_bd = new BD();
            $sql = "CALL SP_ptperfil_usuario('8','','" . $data['area_id'] . "','','');";
            $resul = $obj_bd->EjecutaConsulta($sql);

            $retorno = "<option value=''>seleccione</option>";
            while ($row = $obj_bd->FuncionFetch($resul)) {
                
                $nombre = $row['usuario_nombre'] . ' ' . $row['usuario_apellidos'] . " / " . utf8_decode($row['perfil_nombre']);

                $retorno .= "<option value='" . $row['perfilusuario_id'] . "'>" . utf8_encode($nombre) . "</option>";
            }
            return $retorno;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function JsonDataUserMail($data) {

        $arreglo_retorno = array();

        $obj_bd = new BD();
        $sql = "CALL SP_validaUsuario('" . trim($data['txtNomUsuario']) . "','1','','')";


        $result = $obj_bd->EjecutaConsulta($sql);
        $array_user = $obj_bd->FuncionFetch($result);

        $arreglo_retorno['usuario_id'] = utf8_encode($array_user['usuario_id']);

        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function UpdatePw($post) {
        $obj_bd = new BD();
        $clave = hash('sha512', trim($post['clave']));
        $usuario = $post['id'];
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        $sql = "CALL SP_dtusuario(
                    '5',
                    '" . $usuario . "',
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
                    '" . $clave . "',
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
                    '" . $id_usuario . "'
                    )";


        $result = $obj_bd->EjecutaConsulta($sql);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

}
