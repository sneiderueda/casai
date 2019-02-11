<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MD_fct
 *
 * @author jennifer.cabiativa
 */
include '../../0connection/BD_config.php';
include '../../0connection/connection.php';
include '../../0connection/BD.php';

session_start();

class MD_fct {

    function GenerarPeriodoFactura() {


        $obj_bd = new BD();
        $tabla = "";
        $concat = "'";
        $filtro = "<script>
                        $(function() {
                           $('#txtInicioFactura').datetimepicker({                        
                               format: 'YYYY-MM-DD',
                               minDate: '01-01-2017',                        
                               changeMonth: true,
                               changeYear: true                               
                           });

                           $('#txtFinFactura').datetimepicker({
                               format: 'YYYY-MM-DD',
                               minDate: '01-01-2017',                        
                               changeMonth: true,
                               changeYear: true                        
                           });

                       });
                   </script>
       <table class='table table-bordered table-striped'>
            
            <thead>
                <tr>
                    <th colspan='4'><center>Perdiodo de Factura</center></th>
                </tr>
            </thead>

            <tr>        
                <td colspan='1'><b>Desde</b> :<div class='input-group date' id='InicioSeg'  style='width:200px'> <input type='text' id='txtInicioFactura' name='txtInicioFactura' class='form-control data' readonly required='true' />
                <span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></span></div></td>

                <td colspan='1'><b>Hasta</b> :<div class='input-group date' id='InicioSeg'  style='width:200px'> <input type='text' id='txtFinFactura' name='txtFinFactura' class='form-control data' readonly required='true'/>
                <span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></span></div></td>   
                
                <td colspan='1'><b>IVA %</b> :<div class='input-group date'   style='width:200px'> <input type='text' name='txt_iva' id='txt_iva' maxlength='3' onkeypress='return numeros(event)' class='input-xlarge data' style='width: 100px;' required='true'>
               </div></td> 
               

                
            </tr>

            <tr>        
               
                <td colspan='1'><b>Subtotal a Factura (Sin IVA): </b> :<div class='input-group date'  style='width:200px'> <input type='text' name='txt_subtotal_facturar' id='txt_subtotal_facturar'  class='input-xlarge data' style='width: 250px;' disabled='disabled' >
               </div></td>
               
                <td colspan='1'><b>Total del IVA: </b> :<div class='input-group date'  style='width:200px'> <input type='text' name='txt_tot_iva' id='txt_tot_iva'  class='input-xlarge data' style='width: 250px;' disabled='disabled' >
               </div></td> 
               
                <td colspan='1'><b>Total Ubicacion: </b> :<div class='input-group date'  style='width:200px'> <input type='text' name='txt_ubicacion' id='txt_ubicacion'  class='input-xlarge data' style='width: 250px;' disabled='disabled' >
               </div></td> 
               
                <td colspan='1'><b>Total a Facturar: </b> :<div class='input-group date'  style='width:200px'> <input type='text' name='txt_tot_factura' id='txt_tot_factura'  class='input-xlarge data' style='width: 250px;' disabled='disabled' >
               </div></td> 
                
            </tr>

            <tr>
                <td colspan='4'><center><input type='button' class='btn btn-success' value='Ver Detalle' onclick='DetalleFacturar()'>
                                        <input type='button' class='btn btn-success' id='btn_generar' value='Generar Avances' onclick='GenerarFactura(1)'>
                                        <input type='button' class='btn btn-success' id='btn_generar' value='Generar Actas' onclick='GenerarActas()'>
                                        <input type='button' class='btn btn-success' id='btn_cerrar' value='Aprobar Actas' onclick='SaveFactura()'>
                                </center>
                </td>
            </tr>
        
       </table>";

        //<input type='button' class='btn btn-success' id='btn_cerrar' value='Cerrar Factura' onclick='SaveFactura()'></center></td>

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<legend>Generar Factura</legend>";
        $tabla .= $filtro;
        $tabla .= "<fieldset>";
        return $tabla;
    }

    function DetalleFacturar($data) {

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
                            <th>Accion</th>  
                            <th class="success">OT</th>                                                                                                                                                                       
                            <th class="success">Proyecto</th>                                                                                                                                                                       
                            <th class="success">Subtotal OT(Sin IVA)</th>                                                                                                                                                                       
                            <th class="success">Ubicacion</th>                                                                                                                                                                       
                            <th class="success">Valor IVA</th>                                                                                                                                                                       
                            <th class="success">Total OT</th>                                                                                                                                                                       
                            <th class="warning">Subtotal Factura (Sin IVA)</th>                                                                                                                                                                       
                            <th class="warning">Porcentaje Facturar</th>                                                                                                                                                                       
                            <th class="warning">Ubicacion Facturar</th>                                                                                                                                                                       
                            <th class="warning">IVA</th>                                                                                                                                                                       
                            <th class="warning">Total a Facturar</th>                                                                                                                                                                       
                            <th class="warning">No Acta</th>                                                                                                                                                                       
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_factura('1','','','','','','','','".$data['txtInicioFactura'] ."','".$data['txtFinFactura'] ."','','','','','','','','','','','','');";

        $resultado = $obj_bd->EjecutaConsulta($sql);
        $num_actividades = $obj_bd->Filas($sql);
        if ($num_actividades > 0) {
            while ($row = $obj_bd->FuncionFetch($resultado)) {

                /* VALIDAR FACTURAS PARCIALES */
                $valor_parciales = 0;
                $sql_parciales = "CALL SP_factura('17','','','','','','','','','','','','','','','','','','','" . $row['detallepresupuesto_id'] . "','','');";
                $resultado_parciales = $obj_bd->EjecutaConsulta($sql_parciales);
                $data_parciales = $obj_bd->FuncionFetch($resultado_parciales);
                $valor_parciales = round($data_parciales['factura_parcial']);
                /**/

                /* suma de actividades parciales y finales */
                $total = $valor_parciales + $row['valor_porc'];
                /**/

                $iva_total = ($row['detallepresupuesto_total'] * $data['txt_iva']) / 100;
                $total_ot = $iva_total + $row['detallepresupuesto_total'] + $row['detallepresupuesto_valorincremento'];

                $porc_facturar = ($total * 100) / $row['detallepresupuesto_total'];
                // $porc_facturar = ($row['valor_porc'] * 100) / $row['detallepresupuesto_total'];
                $sub_fact = $row['detallepresupuesto_total'] + $row['detallepresupuesto_valorincremento'];

                /*validar valores null*/
                if(is_null($row['detallepresupuesto_valorincremento'])){
                    $detallepresupuesto_valorincremento=0;
                }else if($row['detallepresupuesto_valorincremento']==""){
                   $detallepresupuesto_valorincremento=0;                    
                }else{
                    $detallepresupuesto_valorincremento=$row['detallepresupuesto_valorincremento'];
                }
                $urlEdit = '"lib/5fct/view/formDetalleOt.php","detalle_factura","' . $row['detallepresupuesto_id'] . '"';
                $tabla .= "<tr>
                <td><button class='btn btn-default'  onclick='loadingFunctions(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Detalle</button>
              
                </td> 
                <td class='success'>" . utf8_encode($row['ordentrabajo_num']) . "</td>                                                     
                <td class='success'>" . utf8_encode($row['ordentrabajo_obs']) . "</td>                                                     
                <td class='success'>" . "$" . number_format($row['detallepresupuesto_total'], 0, ',', '.') . "</td>                                                     
                <td class='success'>" . "$" . number_format($detallepresupuesto_valorincremento, 0, ',', '.') . "</td>                                                     
                <td class='success'>" . "$" . number_format($iva_total, 0, ',', '.') . "</td>                                                     
                <td class='success'>" . "$" . number_format($total_ot, 0, ',', '.') . "</td>       
                    
                
                <td class='warning'>" . "$" . number_format($total, 0, ',', '.') . "</td>      
                <td class='warning'>" . number_format($porc_facturar, 0, ',', '.') . "%" . "</td>";

                //Validar la ubicacion FINALIZADA
                if ($row['detallepresupuesto_tipoincremento'] == '1') {// actividades de levantamiento
                    $cal_ubicacion_fact = 0;
                    $sql_lev = "CALL SP_factura('2','','','','','','','','','','','','','','','','','','','" . trim($row['detallepresupuesto_id']) . "','','');";

                    $resultado_lev = $obj_bd->EjecutaConsulta($sql_lev);
                    $num_levantamientos = $obj_bd->Filas($sql_lev);

                    if ($num_levantamientos != 0) {
                        $cal_ubicacion_fact = ($num_levantamientos *
                                $row['detallepresupuesto_valorincremento']) / $row['levantamiento_pt'];
                    } else {
                        $cal_ubicacion_fact = 0;
                    }
                } else if ($row['detallepresupuesto_tipoincremento'] == '2') { //validar incremento por presupuesto
                    $cal_ubicacion_fact = 0;
                    $sql_tot_actividades = "CALL SP_factura('3','','','','','','','','','','','','','','','','','','','" . trim($row['detallepresupuesto_id']) . "','','');";

                    $resultado_tot_actividades = $obj_bd->EjecutaConsulta($sql_tot_actividades);
                    $num_actividades_resueltas = $obj_bd->Filas($sql_tot_actividades);
                    if ($num_actividades_resueltas != 0) {
                        $cal_ubicacion_fact = ($num_actividades_resueltas *
                                $row['detallepresupuesto_valorincremento']) / $row['total_actividades'];
                    } else {
                        $cal_ubicacion_fact = 0;
                    }
                } else {
                    $cal_ubicacion_fact = 0;
                }
                //Calcular IVA a facturar
                $iva_facturar = ($total * $data['txt_iva']) / 100;
                $total_facturar = $iva_facturar + $total + $cal_ubicacion_fact;

                //validar numero de acta
                $sql_acta = "CALL SP_factura('4','','','','','','','','','','','','','','','','','','','','" . trim($row['ordentrabajo_id']) . "','');";

                $resultado_acta = $obj_bd->EjecutaConsulta($sql_acta);
                $num_acta = $obj_bd->FuncionFetch($resultado_acta);
                $new_acta = $num_acta['acta'] + 1;

                $tabla .= " 
                <td class='warning'>" . "$" . number_format($cal_ubicacion_fact, 0, ',', '.') . "</td>
                <td class='warning'>" . "$" . number_format($iva_facturar, 0, ',', '.') . "</td>
                <td class='warning'>" . "$" . number_format($total_facturar, 0, ',', '.') . "</td>
                <td class='warning'>" . $new_acta . "</td>
                </tr>";

                //calcular valores totales
                $total_subtotal = $total_subtotal + $total;
                $total_iva = $total_iva + $iva_facturar;
                $total_ubicacion = $total_ubicacion + $cal_ubicacion_fact;
                $total_afacturar = $total_afacturar + $total_facturar;
            }

            //valores totales con formato
            $form_total_subtotal = number_format($total_subtotal, 0, ',', '.');
            $form_total_iva = number_format($total_iva, 0, ',', '.');
            $form_total_ubicacion = number_format($total_ubicacion, 0, ',', '.');
            $form_total_afacturar = number_format($total_afacturar, 0, ',', '.');

            $tabla .= "</tbody>
                        </table>
                        </div>
                        <script>$('#example').DataTable();
                        $('#txt_subtotal_facturar').val('$" . $form_total_subtotal . "');
                        $('#txt_tot_iva').val('$" . $form_total_iva . "');
                        $('#txt_ubicacion').val('$" . $form_total_ubicacion . "');
                        $('#txt_tot_factura').val('$" . $form_total_afacturar . "');
                        </script>";
            $tabla .= "<fieldset>";
            return $tabla;
        } else {
            return 0;
        }
    }

    public function ListActividadesAfacturar($data) {

        $obj_bd = new BD();
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<legend>Actividades a Facturar</legend>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<form id="actividades_facturar">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>
                           <th>Item</th>
                           <th>Labor</th> 
                           <th>Modulo</th>
                           <th>Actividad</th>
                           <th>Porcentaje Facturar</th>
                           <th>Valor Porcentaje</th> 
                           <th>Facturar</th>                           
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_factura('5','','','','','','','','','','','','','','','','','','','" . trim($data['detallepresupuesto_id']) . "','','');";

        $resultado = $obj_bd->EjecutaConsulta($sql);
        $valor_porcentaje = 0;
        while ($row = $obj_bd->FuncionFetch($resultado)) {
            /* calcular avance */
            $sql_av = "SELECT seguimiento_avance 
                               FROM pt_seguimiento 
                              WHERE seguimiento_fechacreo=(SELECT MAX(seguimiento_fechacreo) FROM pt_seguimiento WHERE  presupuesto_id=" .  $row['presupuesto_id'] . ")";
            $resultado_av = $obj_bd->EjecutaConsulta($sql_av);
            $data_av = $obj_bd->FuncionFetch($resultado_av);

            $cantidad = $data_av['seguimiento_avance'];
            if ($cantidad == "") {
                $cantidad = 0;
            }
            $valor_porcentaje = $cantidad * $row['actividad_valorservicio'];
            $tot_facturar = $tot_facturar + $valor_porcentaje;
            // $tot_facturar = $tot_facturar + $row['presupuesto_valorporcentaje'];
            $obs = '"' . preg_replace("/\s+/", " ", utf8_encode($row['presupuesto_obs'])) . '"';
            $tabla .= "
                <tr> 
                <td>" . utf8_encode($row['tipobaremo_sigla']) . "-" . trim($row['baremo_item']) . "</td>                     
                <td>" . utf8_encode($row['labor_descripcion']) . "</td>                     
                <td>" . utf8_encode($row['modulo_descripcion']) . "</td>                     
                <td>" . utf8_encode($row['actividad_descripcion']) . "</td>                     
                <td>" . utf8_encode($row['avance']) . "</td>                     
                <td>" . number_format($valor_porcentaje, 0, ',', '.') . "</td>                     
                <td><input type='checkbox' value='" . $row['presupuesto_id'] . "' id='presupuesto_" . $row['presupuesto_id'] . "' name='presupuesto[]' checked='checked' onclick='ActividadNoFaccturar(" . trim($row['presupuesto_id']) . "," . trim($row['seguimiento_id']) . "," . trim($data['detallepresupuesto_id']) . ")'/><br/>
                </td>
                </tr>";
        }

        $tabla .= "<tr><th colspan='7' class='success'><center>Total Facturar (Sin IVA): $" . number_format($tot_facturar, 0, ',', '.') . "</center></th></tr></tbody>
                    </table></form>
                    </div>
                    ";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    public function SaveActividadNoFacturar($post) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $sql = "CALL SP_factura('6','','" . trim($post['txt_revision']) . "',
            '" . utf8_decode(trim($post['txt_des_act'])) . "',
            '','','','','','','','','','','" . $id_usuario . "','','','','','',
            '" . trim($post['sg']) . "','" . trim($post['pt']) . "');";

        $result = $obj_bd->EjecutaConsulta($sql);

        if (!$result) {
            return 0;
        } else {

            //Cambiar estado de la actividad programada
            $sql_estado_prog = "CALL SP_ptpresupuesto('11','" . trim($post['pt']) . "','','','','','','','','RECHAZADA','','','','" . $id_usuario . "','','','','','','','','');";

            $resultado_prog = $obj_bd->EjecutaConsulta($sql_estado_prog);
            if (!$resultado_prog) {
                return 2;
            }

            return 1;
        }
    }

    public function SaveFactura($post) {
        $obj_bd = new BD();

        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $porcentaje = $post['porcentaje'];
        $fechaIni = $post['fechaIni'];
        $fechaFin = $post['fechaFin'];

        $num_factura = $post['num_factura'];
        $txt_subtotal_facturar = $post['txt_subtotal_facturar'];
        $txt_tot_iva = $post['txt_tot_iva'];
        $txt_ubicacion = $post['txt_ubicacion'];
        $txt_tot_factura = $post['txt_tot_factura'];

        //guardar la factura generada 
        $arrayFechaFactura = $obj_bd->obtenerFechaEnLetra($fechaIni);
        $exp_fechaFactura = explode(",", $arrayFechaFactura);
        $mesFactura = $exp_fechaFactura[2];
        $yearFactura = $exp_fechaFactura[3];
        $name = 'FACTURA' . $mesFactura . '' . $yearFactura . '.xlsx';
        $tipo_documento = 'application/vnd.openxmlformats-officedocument';

        $sql_sopt = "CALL SP_dtsoporte('2','','','','" . trim($name) . "','','" . trim($tipo_documento) . "','lib/FileFact/$name','" . $id_usuario . "','');";
        $resultado_sopt = $obj_bd->EjecutaConsulta($sql_sopt);
        $array_sopt = $obj_bd->FuncionFetch($resultado_sopt);
        $soporte_id_insert = $array_sopt['soporte_id_insert'];




        /* validar cuantas OT'S se van a facturar para mostrar el detalle en cada pestaña */
        $sql = "CALL SP_factura('1','','','','','','','','','','','','','','','','','','','','','');";

        $resultado = $obj_bd->EjecutaConsulta($sql);
        if (!$resultado)
            return 0;


        while ($row = $obj_bd->FuncionFetch($resultado)) {

            //validar numero de acta
            $sql_acta = "CALL SP_factura('4','','','','','','','','','','','','','','','','','','','','" . trim($row['ordentrabajo_id']) . "','');";

            $resultado_acta_ot = $obj_bd->EjecutaConsulta($sql_acta);
            $num_acta_ot = $obj_bd->FuncionFetch($resultado_acta_ot);
            $new_acta_ot = $num_acta_ot['acta'] + 1;


            /* Registrar la primera parte de la factura */

            /* VALIDAR FACTURAS PARCIALES */
            $valor_parciales = 0;
            $sql_parciales = "CALL SP_factura('17','','','','','','','','','','','','','','','','','','','" . $row['detallepresupuesto_id'] . "','','');";
            $resultado_parciales = $obj_bd->EjecutaConsulta($sql_parciales);
            $data_parciales = $obj_bd->FuncionFetch($resultado_parciales);
            $valor_parciales = round($data_parciales['factura_parcial']);
            /**/

            /* suma de actividades parciales y finales */
            $total = $valor_parciales + $row['valor_porc'];
            /**/

            //Calcular porcentajes de la factura
            $porc_facturar = round(($total * 100) / $row['detallepresupuesto_total']);

            $sql_porc_actual = "CALL SP_factura('12','','','','','','','','','','','',
             '','','','','','','','','" . trim($row['ordentrabajo_id']) . "','');";

            $resultado_porc_actual = $obj_bd->EjecutaConsulta($sql_porc_actual);
            $num_acta_porc = $obj_bd->Filas($sql_porc_actual);

            if ($num_acta_porc > 0) {
                $data_porc = $obj_bd->FuncionFetch($resultado_porc_actual);
                $porcentaje_facturado = $data_porc['factura_porcentajefacturado'];
                $porcentaje_actual = $data_porc['factura_porcentajeactual'];
            } else {
                $porcentaje_facturado = 0;
                $porcentaje_actual = 0;
            }

            $insert_porc_actual = round($porcentaje_actual + $porcentaje_facturado);
            $insert_porc_pendiente = round(100 - ($insert_porc_actual + $porc_facturar));



            $sql_insert_factura = "CALL SP_factura('10','','','','','','','',
                '" . trim($fechaIni) . "',
                '" . trim($fechaFin) . "','" . trim($num_factura) . "',
                '" . trim($insert_porc_actual) . "','" . trim($porc_facturar) . "','" . trim($insert_porc_pendiente) . "',
                '" . $id_usuario . "','','','','','','" . trim($row['ordentrabajo_id']) . "','" . trim($new_acta_ot) . "');";

            $res_insert_factura = $obj_bd->EjecutaConsulta($sql_insert_factura);
            if (!$res_insert_factura) {
                return 2;
            }

            $array = $obj_bd->FuncionFetch($res_insert_factura);
            $factura_id = $array['factura_id_insert'];

            //asociacion reporte a las facturas 
            $sql_sopt = "CALL SP_ptsoporteseguimiento('4','" . $factura_id . "','','','','" . $id_usuario . "','','FACTURACION','" . $soporte_id_insert . "');";
            $resultado_Asc = $obj_bd->EjecutaConsulta($sql_sopt);
            if (!$resultado_Asc)
                die('Invalid query ->' . mysqli_errno() . '->' . $resultado_Asc);

            //1. cantidad de Modulos
            $sql_mod = "SELECT lb.labor_id,
                 md.modulo_descripcion,
                 bm.baremo_item,
                 lb.labor_unidmedida,
                 lb.labor_descripcion,
                 pt.baremo_id,
                 pt.tipobaremo_id,
                 pt.detallepresupuesto_id,
                 md.modulo_id,                 
                 pt.presupuesto_obs,
                 sum(presupuesto_valorporcentaje) as total_actividad
            FROM pt_presupuesto pt
            JOIN pt_baremo bm ON pt.baremo_id=bm.baremo_id
            JOIN cf_tipobaremo tb ON pt.tipobaremo_id=tb.tipobaremo_id
            JOIN cf_modulo md ON pt.modulo_id=md.modulo_id            
            JOIN cf_labor lb ON bm.labor_id=lb.labor_id
             AND pt.presupuesto_estado=1
             AND pt.detallepresupuesto_id=" . $row['detallepresupuesto_id'] . "
        GROUP BY pt.baremo_id,
                 pt.tipobaremo_id,
                 pt.detallepresupuesto_id,
                 bm.baremo_item,
                 tb.tipobaremo_descripcion,
                 pt.presupuesto_obs,
                 md.modulo_descripcion";

            $resultado_modulo = $obj_bd->EjecutaConsulta($sql_mod);

            $subtotal_facturar = 0;
            $subtotal_acumulado = 0;
            while ($row_mod = $obj_bd->FuncionFetch($resultado_modulo)) {

                $total_facturar_tarea = 0;
                $total_actividad_acumulado = 0;
                $num_act_com = 0;
                $obs = $row_mod['presupuesto_obs'];


                //2. Validar las actividades
                $sql_act = "SELECT pt.presupuesto_porcentaje,
		 	 ac.actividad_valorservicio,
			 pt.presupuesto_valorporcentaje,
			 pt.presupuesto_id,
			 pt.baremoactividad_id,					
			 bm.baremo_item,
                         bm.baremo_id,
			 ac.actividad_id,
			 ac.actividad_descripcion,
                         pt.presupuesto_obs,
			 ac.actividad_GOM,
                         pt.presupuesto_progestado,
                         pt.tipobaremo_id
                    FROM pt_presupuesto pt
                    JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id
                    JOIN pt_baremo bm ON ba.baremo_id=bm.baremo_id
                    JOIN cf_actividad ac ON ac.actividad_id=ba.actividad_id
                     AND pt.baremo_id=" . $row_mod['baremo_id'] . "
                     AND pt.tipobaremo_id=" . $row_mod['tipobaremo_id'] . "
                     AND pt.modulo_id=" . $row_mod['modulo_id'] . "
                     AND bm.baremo_estado=1
                     AND pt.detallepresupuesto_id=" . $row_mod['detallepresupuesto_id'] . "
                     AND pt.presupuesto_estado=1
                     AND pt.presupuesto_obs='" . $obs . "'
                GROUP BY actividad_id";



                $result_act = $obj_bd->EjecutaConsulta($sql_act);
                $num_act = $obj_bd->Filas($sql_act);

                while ($row_act = $obj_bd->FuncionFetch($result_act)) {

                    /* 3. CONSULTAR SI LA ACTIVIDAD TIENE SUBACTIVIDADES */
                    $sql_sub = " SELECT pt.presupuesto_id,
                        pt.baremoactividad_id,
                        pt.detalleactividad_id,								
                        sb.subactividad_descripcion,
                        pt.presupuesto_porcentaje,
                        pt.presupuesto_valorporcentaje,
                        pt.presupuesto_progestado,
                        pt.baremo_id,
                        pt.tipobaremo_id
                        FROM pt_presupuesto pt
                        JOIN pt_baremo_actividad ba ON pt.baremoactividad_id=ba.baremoactividad_id		   
                        JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
                        JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id	
                        WHERE pt.presupuesto_progestado IN ('FINALIZADA','FACTURA PARCIAL') 	
                        AND da.detalleactividad_estado=1
                        AND pt.baremoactividad_id =" . $row_act['baremoactividad_id'] . "
                        AND pt.detallepresupuesto_id=" . $row['detallepresupuesto_id'] . "
                        AND pt.modulo_id=" . $row_mod['modulo_id'] . "
                        AND pt.presupuesto_estado=1
                        AND pt.presupuesto_obs='" . $obs . "'";

                    $result_sub = $obj_bd->EjecutaConsulta($sql_sub);
                    $num_sub = $obj_bd->Filas($sql_sub);

                    if ($num_sub > 0) {//Si tiene subactividades (Se pinta)
                        while ($row_sub = $obj_bd->FuncionFetch($result_sub)) {


                            //VALIDAR AVANCE DE LA ACTIVIDAD PARA FACTURAR
                            $sql_act_facturar = "CALL SP_factura('7','','','','','','','','','',
                                    '','','','','','','','','','" . trim($row_sub['presupuesto_id']) . "','','');";

                            $resultado_act_facturar = $obj_bd->EjecutaConsulta($sql_act_facturar);
                            $actividad_facturar = $obj_bd->Filas($sql_act_facturar);

                            if ($actividad_facturar > 0) {
                                $data_facturar = $obj_bd->FuncionFetch($resultado_act_facturar);

                                $cantidad = $data_facturar['avance'];
                                if ($cantidad == "") {
                                    $cantidad = 0;
                                }

                                $valor_unitario = $data_facturar['actividad_valorservicio'];
                                $valor_porcent_total = $data_facturar['presupuesto_valorporcentaje'];

                                $valor_facturar = $cantidad * $valor_unitario;
                                $valor_facturar_form = "$" . number_format($valor_facturar, 0, ',', '.');
                                $total_facturar_tarea = $total_facturar_tarea + $valor_facturar;

                                if ($valor_facturar > 0) {
                                    $porcent_facturar = ($valor_facturar / $valor_porcent_total) * 100;
                                } else {
                                    $porcent_facturar = 0;
                                }

                                //insertamos detalle de las subactividades
                                $sql_insert_detalle = "CALL SP_factura('11','" . $cantidad . "','" . round($porcent_facturar) . "',
                                    '','" . $id_usuario . "','','" . round($valor_facturar) . "','" . trim($factura_id) . "','','',
                                    '" . trim($row_sub['presupuesto_progestado']) . "','','','','','','',
                                    '','','" . trim($row['detallepresupuesto_id']) . "','" . trim($row_sub['presupuesto_id']) . "','');";

                                $res_insert_detalle = $obj_bd->EjecutaConsulta($sql_insert_detalle);
                                if (!$res_insert_detalle) {
                                    return 3;
                                }

                                $array_detalle = $obj_bd->FuncionFetch($res_insert_detalle);
                                $detallefactura_id = $array_detalle['detallefactura_id_insert'];

                                //Se reporta el seguimiento de la actividad
                                //numero de seguimiento 
                                $sql_num = "CALL SP_ptseguimiento('1','','','','','','','','','','','','','','','','','',
                                 '" . trim($row_sub['presupuesto_id']) . "','');";
                                $resultado_num = $obj_bd->Filas($sql_num);

                                if ($resultado_num == 0) {
                                    $num_seg = 1;
                                } else {
                                    $num_seg = $resultado_num + 1;
                                }


                                $sql = "CALL SP_ptseguimiento('2','FACTURACION','" . trim($cantidad) . "','" . $id_usuario . "','','" . trim($fechaIni) . "',
                                '" . trim($fechaFin) . "','','','','','" . trim($num_seg) . "','SE FACTURO','','" . $id_usuario . "',
                                '','" . trim($row_sub['baremo_id']) . "','" . trim($row['ordentrabajo_id']) . "',
                                '" . trim($row_sub['presupuesto_id']) . "','" . trim($row_sub['tipobaremo_id']) . "');";

                                $resultado_sub = $obj_bd->EjecutaConsulta($sql);
                                $array = $obj_bd->FuncionFetch($resultado_sub);
                                $seguimientoo_id_insert = $array['seguimiento_id_insert'];

                                if (!$resultado_sub) {
                                    return 2;
                                }
                            }
                        }
                    } else {
                        //VALIDAR AVANCE DE LA ACTIVIDAD PARA FACTURAR
                        $sql_act_facturar = "CALL SP_factura('7','','','','','','','','','','',
                         '','','','','','','','','" . trim($row_act['presupuesto_id']) . "','','');";
                        $resultado_act_facturar = $obj_bd->EjecutaConsulta($sql_act_facturar);
                        $actividad_facturar = $obj_bd->Filas($sql_act_facturar);

                        if ($actividad_facturar > 0) {
                            $data_facturar = $obj_bd->FuncionFetch($resultado_act_facturar);

                            $cantidad = $data_facturar['avance'];
                            if ($cantidad == "") {
                                // $cantidad = 0;
                            }

                            $valor_unitario = $data_facturar['actividad_valorservicio'];
                            $valor_porcent_total = $data_facturar['presupuesto_valorporcentaje'];

                            $valor_facturar = round($cantidad * $valor_unitario);
                            $valor_facturar_form = "$" . number_format($valor_facturar, 0, ',', '.');
                            $total_facturar_tarea = $total_facturar_tarea + $valor_facturar;

                            if ($valor_facturar > 0) {
                                $porcent_facturar = ($valor_facturar / $valor_porcent_total) * 100;
                            } else {
                                $porcent_facturar = 0;
                            }

                            //insertamos detalle de las subactividades
                            $sql_insert_detalle = "CALL SP_factura('11','" . $cantidad . "','" . round($porcent_facturar) . "',
                                    '','" . $id_usuario . "','','" . round($valor_facturar) . "','" . trim($factura_id) . "','','',
                                    '" . trim($row_act['presupuesto_progestado']) . "','','','','','','',
                                    '','','" . trim($row['detallepresupuesto_id']) . "','" . trim($row_act['presupuesto_id']) . "','');";

                            $res_insert_detalle = $obj_bd->EjecutaConsulta($sql_insert_detalle);
                            if (!$res_insert_detalle) {
                                return 4;
                            }

                            $array_detalle = $obj_bd->FuncionFetch($res_insert_detalle);
                            $detallefactura_id = $array_detalle['detallefactura_id_insert'];

                            //Se reporta el seguimiento de la actividad
                            //numero de seguimiento 
                            $sql_num_act = "CALL SP_ptseguimiento('1','','','','','','','','','','','','','','','','','',
                                 '" . trim($row_act['presupuesto_id']) . "','');";
                            $resultado_num_act = $obj_bd->Filas($sql_num_act);

                            if ($resultado_num_act == 0) {
                                $num_seg_act = 1;
                            } else {
                                $num_seg_act = $resultado_num_act + 1;
                            }

                            $sql_act = "CALL SP_ptseguimiento('2','FACTURACION','" . trim($cantidad) . "','" . $id_usuario . "','','" . trim($fechaIni) . "',
                                '" . trim($fechaFin) . "','','','','','" . trim($num_seg_act) . "','SE FACTURO','','" . $id_usuario . "',
                                '','" . trim($row_act['baremo_id']) . "','" . trim($row['ordentrabajo_id']) . "',
                                '" . trim($row_act['presupuesto_id']) . "','" . trim($row_act['tipobaremo_id']) . "');";

                            $resultado_act = $obj_bd->EjecutaConsulta($sql_act);
                            $array_act = $obj_bd->FuncionFetch($resultado_act);
                            $seguimientoo_id_insert = $array_act['seguimiento_id_insert'];

                            if (!$resultado_act) {
                                return 2;
                            }
                        }
                    }
                }
                //HACER LA SUMATORIA DE LOS TOTALES DE LAS ACTIVIDADES EN EL ACTA
                $subtotal_facturar = $subtotal_facturar + $total_facturar_tarea;

                /**/
            }


            //total del presupuesto
            $subtotal = $row['detallepresupuesto_total'];
            $ubicacion = $row['detallepresupuesto_valorincremento'];
            $subtotal2 = $subtotal + $ubicacion;
            $iva = ($subtotal2 * $porcentaje) / 100;
            $total_iva = $subtotal2 + $iva;

            //calcular ubicacion a facturar resumen del acta
            if ($row['detallepresupuesto_tipoincremento'] == '1') {// actividades de levantamiento
                $cal_ubicacion_fact = 0;
                $sql_lev = "CALL SP_factura('2','','','','','','','','','','','','','',
                 '','','','','','" . trim($row['detallepresupuesto_id']) . "','','');";

                $resultado_lev = $obj_bd->EjecutaConsulta($sql_lev);
                $num_levantamientos = $obj_bd->Filas($sql_lev);

                if ($num_levantamientos != 0) {
                    $cal_ubicacion_fact = ($num_levantamientos *
                            $row['detallepresupuesto_valorincremento']) / $row['levantamiento_pt'];
                } else {
                    $cal_ubicacion_fact = 0;
                }
            } else if ($row['detallepresupuesto_tipoincremento'] == '2') { //validar incremento por presupuesto
                $cal_ubicacion_fact = 0;
                $sql_tot_actividades = "CALL SP_factura('3','','','','','','','','','','','','','','','','','','','" . trim($row['detallepresupuesto_id']) . "','','');";

                $resultado_tot_actividades = $obj_bd->EjecutaConsulta($sql_tot_actividades);
                $num_actividades_resueltas = $obj_bd->Filas($sql_tot_actividades);
                if ($num_actividades_resueltas != 0) {
                    $cal_ubicacion_fact = ($num_actividades_resueltas *
                            $row['detallepresupuesto_valorincremento']) / $row['total_actividades'];
                } else {
                    $cal_ubicacion_fact = 0;
                }
            } else {
                $cal_ubicacion_fact = 0;
            }


            //Calcular IVA a facturar
            $iva_facturar = ($total * $porcentaje) / 100;
            $total_facturar = $iva_facturar + $total + $cal_ubicacion_fact;
            $sub_incremento = $total + $cal_ubicacion_fact;


            //ACTUALIZAR FACTURA CON LOS NUEVOS VALORES
            //Calcular los valores de la factura
            $sql_val_factura = "CALL SP_factura('12','','','','','','','','','','','',
             '','','','','','','','','" . trim($row['ordentrabajo_id']) . "','');";

            $resultado_val_factura = $obj_bd->EjecutaConsulta($sql_val_factura);

            $data_total_pago = $obj_bd->FuncionFetch($resultado_val_factura);
            $valor_pagado = $data_total_pago['valor_pagado'];

            $insert_valor_pendiente = $total_iva - ($valor_pagado + $total_facturar);

            $sql_update_factura = "CALL SP_factura('14','','','','','','','" . trim($factura_id) . "',
                '',
                '','',
                '','','',
                '','" . round($total) . "','" . round($total_facturar) . "','" . round($insert_valor_pendiente) . "','" . round($total_iva) . "',
                '" . round($cal_ubicacion_fact) . "','" . round($iva_facturar) . "','" . round($sub_incremento) . "');";

            $res_update_factura = $obj_bd->EjecutaConsulta($sql_update_factura);
            if (!$res_update_factura) {
                return 5;
            }
        }

        $sql_estado = "CALL SP_factura('1','','','','','','','','','','','','','','','','','','','','','');";
        $resultado_estado = $obj_bd->EjecutaConsulta($sql_estado);

        while ($row_estado = $obj_bd->FuncionFetch($resultado_estado)) {
            //actualizar estados de las actividades

            $sql_presupuesto_act = "SELECT * FROM pt_presupuesto WHERE detallepresupuesto_id=" . $row_estado['detallepresupuesto_id'];
            $result_presupuesto = $obj_bd->EjecutaConsulta($sql_presupuesto_act);
            while ($row_data_pt = $obj_bd->FuncionFetch($result_presupuesto)) {
                if ($row_data_pt['presupuesto_progestado'] == "FACTURA PARCIAL") {
                    $estado_presupuesto = "PROGRAMADA";
                } else {
                    $estado_presupuesto = "FACTURADA";
                }
                $sql_estado_prog = "CALL SP_ptpresupuesto('11','" . trim($row_data_pt['presupuesto_id']) . "','','','','','','','',
                                       '" . trim($estado_presupuesto) . "','','','','" . $id_usuario . "','','','','','','','','');";

                $resultado_prog = $obj_bd->EjecutaConsulta($sql_estado_prog);
                if (!$resultado_prog) {
                    return 2;
                }
            }
        }

        return 1;
    }

    function ListCerradas() {

        $obj_bd = new BD();
        $id_usuario = $_SESSION['Usuario']['usuario_id'];
        $id_perfil = $_SESSION['Usuario']['ID_PERFIL'];
        $tabla = "";

        $tabla .= "<style>
                .ui-dialog-titlebar-close {
                visibility: hidden;
                }
                </style>";
        $tabla .= "<fieldset>";
        $tabla .= "<legend>Lista de Facturas Cerradas</legend>";

        $tabla .= "<br>";
        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-striped" cellspacing="0" border="0" id="example">
                    <thead>
                        <tr>                              
                            <th>No. Factura</th>  
                            <th>Desde</th>  
                            <th>Hasta</th>
                            <th>Subtotal (Sin IVA)</th>                                                        
                            <th>IVA</th>                                                        
                            <th>Incremento</th>                                                        
                            <th>Total Facturado</th>                                                                                                                                                          
                            <th>Accion</th>                                                                                                                                            
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_factura('15','','','','','','','','','','','','','','','','','','','','','');";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            //Nombre de documento
            $doc = "SELECT sp.soporte_nombre
                    FROM dt_factura ft
                    JOIN pt_soporte_seguimiento seg ON ft.factura_id=seg.id
                    JOIN  dt_soporte sp ON seg.soporte_id=sp.soporte_id
                     AND seg.soporteseguimiento_tipo='FACTURACION'
                     AND ft.factura_numero='" . $row['factura_numero'] . "'
                    group by sp.soporte_nombre";
            $result_doc = $obj_bd->EjecutaConsulta($doc);
            $row_doc = $obj_bd->FuncionFetch($result_doc);
            $nombre_doc = $row_doc['soporte_nombre'];

            $tabla .= "<tr>                
                <td>" . $row['factura_numero'] . "</td>                     
                <td>" . $row['factura_fechainicio'] . "</td>                     
                <td>" . $row['factura_fechafin'] . "</td>                     
                <td>" . "$" . number_format($row['subtotal'], 0, ',', '.') . "</td>                     
                <td>" . "$" . number_format($row['iva'], 0, ',', '.') . "</td>                     
                <td>" . "$" . number_format($row['ubicacion'], 0, ',', '.') . "</td>                     
                <td>" . "$" . number_format($row['total_facturado'], 0, ',', '.') . "</td>                                                                    
                <td><a href='lib/FileFact/" . $nombre_doc . "'><button type='button' name='btn_ver_doc_desc' id='btn_ver_doc_desc' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span>Ver</button></a>";

            $tabla .= "</td> 
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
