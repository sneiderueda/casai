<?php

/**
 * Description of MD_1config
 *
 * @author jennifer.cabiativa
 */
include '../../0connection/connection.php';
include '../../0connection/BD.php';
session_start();

class MD_1config {

    public function CallMenu() {

        $html_menu = "";

        $obj_bd = new BD();
        
        session_start();
        

        $usuario = $_SESSION['Usuario'];
        $sql_perfil_usuario = "CALL SP_cfperfil('1','','" . $usuario['ID_PERFIL'] . "','','','','','');";
        $resultado_perfil_usuario = $obj_bd->EjecutaConsulta($sql_perfil_usuario);
        $arreglo_perfil_usr = $obj_bd->FuncionFetch($resultado_perfil_usuario);


        $sql_padres = "SELECT MENU.menu_id,
                              MENU.menu_nombre,
                              MENU.menu_icono
                         FROM cf_menu MENU
                   INNER JOIN pt_menu_perfil MENUP ON MENUP.menu_id = MENU.menu_id
                   INNER JOIN cf_perfil PE ON MENUP.perfil_id = PE.perfil_id
                        WHERE MENU.menu_idpadre = 0
                          AND PE.perfil_id = " . $arreglo_perfil_usr['perfil_id'] . "
                          AND MENU.menu_estado = '1'
                          AND MENUP.menuperfil_estado = '1'
                     ORDER BY MENU.menu_orderurl";
        $resul_padres = $obj_bd->EjecutaConsulta($sql_padres);

        while ($row = $obj_bd->FuncionFetch($resul_padres)) {

            /* aqui llenamos los hijos */
            $sql_verifica_hijos = "SELECT MENU.menu_id,
                                          MENU.menu_nombre,
                                          MENU.menu_URL,
                                          MENU.menu_orderurl                                         
                                     FROM cf_menu MENU          
                                     JOIN pt_menu_perfil MN_PER ON MENU.menu_id=MN_PER.menu_id
                                     JOIN cf_perfil  PER ON MN_PER.perfil_id=PER.perfil_id
                                      AND PER.perfil_id= " . $usuario['ID_PERFIL'] . "
                                      AND MENU.menu_idpadre =  " . $row['menu_id'] . " 
                                      AND MENU.menu_estado = '1' 
                                      AND MN_PER.menuperfil_estado = '1'
                                 ORDER BY MENU.menu_orderurl";
            $resultado_exi_hijos = $obj_bd->Filas($sql_verifica_hijos);
            if ($resultado_exi_hijos > 0) {

                $div_abre = '<ul class="nav navbar-nav" style="background: #333333">
                              <li><a style="color:#ff8c00; background: #333333;" href="#"><i style="color:#ff8c00" class="' . $row['menu_icono'] . '"></i> ' . utf8_encode($row['menu_nombre']) . ' <span style="color:#ff8c00" class="fa fa-chevron-down"></span></a>
                                <ul class="nav" id="collapse_' . $row['menu_id'] . '">
                            ';

                $html_menu .= $div_abre;

                $resultado_hijos = $obj_bd->EjecutaConsulta($sql_verifica_hijos);

                while ($row2 = $obj_bd->FuncionFetch($resultado_hijos)) {
                    $url = "'" . $row2['menu_url'] . "','codigo'";
                    $html_menu .= '<li><a style="color:#ff8c00" href="#333333" onclick="loadingFunctions(' . $url . ')">' . utf8_encode($row2['menu_nombre']) . '</a></li>';
                    //  $html_menu.='<tr><td><a href="#" onclick="loadingFunctions(' . $url . ')"><span class="glyphicon glyphicon-list-alt text-primary"></span> ' . $row2['configmenuname'] . '</a></td></tr>';
                }



                $div_cierra = ' </ul>
                                    </li></ul>
                               ';

                $html_menu .= $div_cierra;
            }
        }
        return $html_menu;
    }

    function griModulosSb() {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<legend>Configuracion de Subestaciones y Modulos</legend>";
        $url = "'lib/1config/vista/formDataModuloSb.php','contenido'";
        $tabla .= '<button name="btnAddModuloSb" id="btnAddModuloSb" class="btn btn-default" type="button" onclick="loadingFunctions(' . $url . ')">Agregar</button>';
        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                            <th>Acción</th>  
                            <th>Subestacion</th>                                         
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_cfmodulo('6','','','','','','','');";

        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {


            $urlEdit = '"lib/1config/vista/formDataModuloSb.php","contenido","' . $row['subestacion_id'] . '"';
            $tabla .= "<tr>
                <td><button class='btn btn-default'  onclick='loadingFunctions(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Editar</button>
                    <button class='btn btn-default'  onclick='StateUpdatesubestacionModulo(" . $row['subestacion_id'] . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Eliminar</button>
                </td> 
                <td>" . utf8_encode($row['subestacion_nombre']) . "</td>                                                     
            </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>$('#example').DataTable();</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function SaveNewModulo($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];


        $sql_modulo = "CALL SP_cfmodulo('2','','" . trim(utf8_decode($data['txt_modulo'])) . "','','','','" . $id_usuario . "','');";

        $res_modulo = $obj_bd->EjecutaConsulta($sql_modulo);
        if (!$res_modulo)
            die('Invalid query ->' . mysqli_errno() . '->' . $res_modulo);

        $array = $obj_bd->FuncionFetch($res_modulo);
        $modulo_id = $array['modulo_id_insert'];


        if ($modulo_id == 0 || $modulo_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<modulo_id>" . $modulo_id . "</modulo_id>";
            $xml .= "</respuesta>";
        }
        return $xml;
    }

    public function SaveModuloSb($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $slSubestacion = $data['slSubestacion'];
        $array_modId = explode(',', $data['id_modulo']);
        $array_voltaje = explode(',', $data['voltaje']);
        $array_id_tipoModulo = explode(',', $data['id_tipoModulo']);

        if (!empty($array_modId)) {
            //Eliminar modulos

            $sql_md = "CALL SP_cfmodulo('9','',
                      '',
                      '" . trim($slSubestacion) . "','',
                      '','" . $id_usuario . "','');";
            $res_mod = $obj_bd->EjecutaConsulta($sql_md);
            if (!$res_mod)
                die('Invalid query ->' . mysqli_errno() . '->' . $res_mod);
            

            for ($j = 0; $j < count($array_modId); $j++) {
                $sql = "CALL SP_cfmodulo('5','',
                      '" . trim($array_modId[$j]) . "',
                      '" . trim($slSubestacion) . "','" . trim($array_id_tipoModulo[$j]) . "',
                      '','" . $id_usuario . "','" . trim($array_voltaje[$j]) . "');";

                $res = $obj_bd->EjecutaConsulta($sql);
                if (!$res)
                    die('Invalid query ->' . mysqli_errno() . '->' . $res);
            }
            return 1;
        }
    }

    public function ListTipoModulo() {
        $arreglo_retorno = array();
        $arreglo_modulo = array();
        $obj_bd = new BD();

        $sql = "CALL SP_cfmodulo('3','','','','','','','');";

        $resul = $obj_bd->EjecutaConsulta($sql);
        $i = 0;
        while ($row = $obj_bd->FuncionFetch($resul)) {
            $arreglo_modulo[$i]['tipomodulo_id'] = $row['tipomodulo_id'];
            $arreglo_modulo[$i]['tipomodulo_descripcion'] = utf8_encode($row['tipomodulo_descripcion']);
            $i++;
        }
        $arreglo_retorno['TIPO_MODULO'] = $arreglo_modulo;
        $json = json_encode($arreglo_retorno);
        return $json;
    }

    public function SaveNewTipoModulo($data) {
        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];


        $sql_modulo = "CALL SP_cfmodulo('4','',
                      '" . trim(utf8_decode($data['txt_tipomodulo'])) . "',
                      '','','','" . $id_usuario . "','');";

        $res_modulo = $obj_bd->EjecutaConsulta($sql_modulo);
        if (!$res_modulo)
            die('Invalid query ->' . mysqli_errno() . '->' . $res_modulo);

        $array = $obj_bd->FuncionFetch($res_modulo);
        $tipoModulo_id = $array['modulo_id_insert'];


        if ($tipoModulo_id == 0 || $tipoModulo_id == '') {
            $xml = "<resultado>0</resultado>";
        } else {
            $xml .= "<respuesta>";
            $xml .= "<resultado>1</resultado>";
            $xml .= "<tipoModulo_id>" . $tipoModulo_id . "</tipoModulo_id>";
            $xml .= "</respuesta>";
        }
        return $xml;
    }

    public function StateUpdatesubestacionModulo($post) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $SqlUpdate = "CALL SP_cfmodulo('8','" . trim(($post['subestacion_id'])) . "',
                      '',
                      '','','','" . $id_usuario . "','');";

        $result = $obj_bd->EjecutaConsulta($SqlUpdate);

        if (!$result) {
            return 0;
        } else {
            return 1;
        }
    }

    public function DataSubestacionModulos($data) {

        $obj_bd = new BD();
        $arreglo = array();
        $sql = "CALL SP_cfmodulo('7','" . trim(($data['subestacion_id'])) . "',
                      '',
                      '','','','','');";

        $result = $obj_bd->EjecutaConsulta($sql);
        $a = 0;
        while ($row = $obj_bd->FuncionFetch($result)) {
            $arreglo[$a]['modulsubestacion_id'] = $row['modulsubestacion_id'];
            $arreglo[$a]['subestacion_id'] = $row['subestacion_id'];
            $arreglo[$a]['subestacion_nombre'] = utf8_encode($row['subestacion_nombre']);
            $arreglo[$a]['tipomodulo_id'] = $row['tipomodulo_id'];
            $arreglo[$a]['tipomodulo_descripcion'] = utf8_encode($row['tipomodulo_descripcion']);
            $arreglo[$a]['modulo_id'] = $row['modulo_id'];
            $arreglo[$a]['modulo_descripcion'] = utf8_encode($row['modulo_descripcion']);
            $arreglo[$a]['modulosubestacion_voltaje'] = $row['modulosubestacion_voltaje'];
            $a++;
        }
        $arreglo_general['SUBESTACION_MODULO'] = $arreglo;


        $json = json_encode($arreglo_general);
        return $json;
    }

}
