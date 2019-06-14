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

                   <br><br><br><br><br><br>
                   <table class='table table-bordered table-hover'>

                   <thead>
                   <tr>
                   <th colspan='4' style='border: 2px solid #ff8c00; border-radius: 5px;' class='titulo borde'><center>Periodo Conciliación</center></th>
                   </tr>
                   </thead>

                   <tr class='letraBl'>        
                   <td colspan='1'><b>Desde</b> :<div class='input-group date' id='InicioSeg'  style='width:200px'> <input type='text' id='txtInicioFactura' name='txtInicioFactura' class='form-control data' readonly required='true' />
                   <span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></span></div></td>

                   <td colspan='1'><b>Hasta</b> :<div class='input-group date' id='InicioSeg'  style='width:200px'> <input type='text' id='txtFinFactura' name='txtFinFactura' class='form-control data' readonly required='true'/>
                   <span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></span></div></td>   

                   <td colspan='1'><b>IVA %</b> :<div class='input-group date'   style='width:200px'> <input type='text' name='txt_iva' id='txt_iva' maxlength='3' onkeypress='return numeros(event)' class='input-xlarge data' style='width: 100px;' required>
                   </div></td> 



                   </tr>

                   <tr class='letraBl'>        

                   <td colspan='1'><b>Subtotal Conciliación (Sin IVA): </b> :<div class='input-group date'  style='width:200px'> <input type='text' name='txt_subtotal_facturar' id='txt_subtotal_facturar'  class='input-xlarge data' style='width: 250px;' disabled='disabled' >
                   </div></td>

                   <td colspan='1'><b>Subtotal Ubicacion Concilación: </b> :<div class='input-group date'  style='width:200px'> <input type='text' name='txt_ubicacion' id='txt_ubicacion'  class='input-xlarge data' style='width: 250px;' disabled='disabled' >
                   </div></td> 

                   <td colspan='1'><b>IVA Conciliación: </b> :<div class='input-group date'  style='width:200px'> <input type='text' name='txt_tot_iva' id='txt_tot_iva'  class='input-xlarge data' style='width: 250px;' disabled='disabled' >
                   </div></td> 


                   <td colspan='1'><b>Total Conciliación: </b> :<div class='date'  style='width:200px'> <input type='text' name='txt_tot_factura' id='txt_tot_factura'  class='input-xlarge data' style='width: 250px;' disabled='disabled' >
                   </div></td> 

                   </tr>

                   <tr>
                   <td colspan='4' style='border: 2px solid #ff8c00; border-radius: 5px; background-color: #333333;'><center><input type='button' class='btn btn-success' value='Ver Detalle OT' onclick='DetalleFacturar()'>
                   <input type='button' class='btn btn-success' id='btn_generar' value='Generar Consolidado' onclick='GenerarFactura(1)'>
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
                $tabla .= "<legend></legend>";
                $tabla .= $filtro;
                $tabla .= "<fieldset>";
                return $tabla;
    }


            function DetalleFacturar($data) {

                $obj_bd = new BD();
                $tabla = "";
                $fechaFacturaMes = $data['txtInicioFactura'];
                $fechaFacturaFin = $data['txtFinFactura'];
                $iva = $data['txt_iva'];

                $tabla .= "<style>
                .ui-dialog-titlebar-close {
                    visibility: hidden;
                }
                </style>";
                $tabla .= "<fieldset>";

                $tabla .= '<div class="table-responsive">';
                $tabla .= '<table cellpadding="0" class="table table-bordered table-hover" cellspacing="0" border="0" id="example">
                <thead>
                <tr class="fondo letraN">
                <th>Orden Trabajo</th>  
                <th class="">Subestación</th>
                <th class="">Proyecto</th>
                <th class="">Subtotal OT(Sin IVA)</th>                
                <th class="">Ubicacion OT</th>
                <th class="">IVA '.$iva.'%</th>
                <th class="">Total OT</th>

                <th class="">Subtotal Conciliación (Sin IVA)</th>
                <th class="">Porcentaje Conciliación</th>
                <th class="">Ubicacion Conciliación</th>
                <th class="">IVA '.$iva.'%</th>
                <th class="">Total a Conciliación</th>
                <th class="">No. Acta</th>
                </tr>
                </thead>
                <tbody>';



                $sql = "CALL SP_factura('1','','','','','','','','".$data['txtInicioFactura'] ."','".$data['txtFinFactura'] ."','','','','','','','','','','','','');";

                $resultado = $obj_bd->EjecutaConsulta($sql);
                $num_actividades = $obj_bd->Filas($sql);
                if ($num_actividades > 0) {
                    while ($row = $obj_bd->FuncionFetch($resultado)) {

                        ////////////////////////////////////
                        // DATOS GENERALES DE PRESUPUESTO //
                        ////////////////////////////////////
                        //consulta para sumar solo las labores que tengan levantamiento
                        $sqlUbi = " SELECT sum(pt.presupuesto_valorporcentaje)*0.03 as porcentaje
                        FROM pt_presupuesto pt
                        JOIN pt_detalle_actividad da ON pt.detalleactividad_id=da.detalleactividad_id
                        JOIN cf_subactividad sb ON da.subactividad_id=sb.subactividad_id
                        AND sb.subactividad_id=1
                        AND pt.presupuesto_estado=1
                        WHERE pt.detallepresupuesto_id=" . $row['detallepresupuesto_id'] . ";";

                        $resUbi = $obj_bd->EjecutaConsulta($sqlUbi);
                        $rowUbi = $obj_bd->FuncionFetch($resUbi);
                        $ubicacion = $rowUbi['porcentaje'];

                        /*CALCULAMOS EL INCREMENTO DE PAGO A 90 DIAS*/
                        $dias_pre = ($row['detallepresupuesto_total']+$ubicacion)*0.015;

                        $parcial_pre = $row['detallepresupuesto_total']+$ubicacion+$dias_pre;

                        /*CALCULAMOS EL VALOR DEL IVA*/
                        $iva_pre = ($parcial_pre*$iva)/100;

                        /*CALCULAMOS EL TOTAL*/
                        $total_pre = $parcial_pre+$iva_pre;
                        


                        ///////////////////////////////
                        //DATOS DE LAS ACTAS DEL MES //
                        ///////////////////////////////
                        
                        /*CONSULTA QUE DEVUELVE EL VALOR DEL SUBTOTAL DE LAS ACTAS*/    
                        $sqlSub_actas = "CALL SP_factura('20','','','','','','','','" . $fechaFacturaMes . "','" . $fechaFacturaFin . "','','','','','','','','','','" . $row['detallepresupuesto_id'] . "','','')";

                        $resSub_actas = $obj_bd->EjecutaConsulta($sqlSub_actas);
                        $rowSub_actas = $obj_bd->FuncionFetch($resSub_actas);
                        $sub_actas = $rowSub_actas['total_porc'];

                        //validar numero de acta
                        // CONSULTA //
                        $sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
                        $resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
                        $row_actas = $obj_bd->FuncionFetch($resultado_actas);
                        $new_acta = $row_actas['factura_actanum'];

                        $new_acta = $new_acta + 1;

                        /*COLSULTA QUE DEVUELVE EL VALOR DEL INCREMENTO POR UBICACION, SI APLICA*/
                        $sqlUbi_actas = "CALL SP_factura('18','','','','','','','','" . $fechaFacturaMes . "','" . $fechaFacturaFin . "','','','','','','','','','','" . $row['detallepresupuesto_id'] . "','','')";

                        $resUbi_actas = $obj_bd->EjecutaConsulta($sqlUbi_actas);
                        $rowUbi_actas = $obj_bd->FuncionFetch($resUbi_actas);
                        $ubicacion_actas = $rowUbi_actas['ubicacion'];



                        //////////////
                        // CALCULOS //
                        //////////////

                        /*CALCULAR EL PORCENTAJE DE CUMPLIMIENTO*/
                        $cumplimiento = ($sub_actas/$row['detallepresupuesto_total'])*100;

                        /*CALCULA EL VALOR DEL INCREMENTO POR 90 DIAS DE ACTAS*/
                        $dias_actas = ($sub_actas+$ubicacion_actas)*0.015;

                        /*CALCULA EL VALOR DEL IVA DE LAS ACTAS*/
                        $iva_actas = (($sub_actas+$ubicacion_actas+$dias_actas)*$iva)/100;
                        
                        /*CALCULA EL VALOR PARCIAL DEL SUBTOTAL, LA UBICACION Y EL INCREMENTO DE DIAS*/
                        $parcial_actas = $sub_actas+$ubicacion_actas+$dias_actas;
                        
                        /*CALCULA EL VALOR TOTAL DEL ACTA*/
                        $total_actas = $parcial_actas+$iva_actas;

                        

                        //////////////////
                        // MOSTAR DATOS //
                        //////////////////
                        $urlEdit = '"lib/5fct/view/formDetalleOt.php","detalle_factura","' . $row['detallepresupuesto_id'] . '"';
                        $tabla .= "<tr class='letraBl'>
                        <td><button class='btn btn-primary letraBl'  onclick='loadingFunctions(" . $urlEdit . ")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> " . utf8_encode($row['ordentrabajo_num']) . "</button></td> 
                        <td class='success'>" . utf8_encode($row['subestacion_nombre']) . "</td>                                                     
                        <td class='success'>" . utf8_encode($row['ordentrabajo_obs']) . "</td>                                                     
                        <td class='success'>" . "$" . number_format($row['detallepresupuesto_total'], 0, ',', '.') . "</td>                                                     
                        <td class='success'>" . "$" . number_format($ubicacion, 0, ',', '.') . "</td>                                                     
                        <td class='success'>" . "$" . number_format($iva_pre, 0, ',', '.') . "</td>                                                     
                        <td class='success'>" . "$" . number_format($total_pre, 0, ',', '.') . "</td>       


                        <td class='warning'>" . "$" . number_format($sub_actas, 0, ',', '.') . "</td>      
                        <td class='warning'>" . number_format($cumplimiento, 0, ',', '.') . "%" . "</td>";

                        $tabla .= " 
                        <td class='warning'>" . "$" . number_format($ubicacion_actas, 0, ',', '.') . "</td>
                        <td class='warning' title='Este valor contiene 1.5 por incremento 90 dias'>" . "$" . number_format($iva_actas, 0, ',', '.') . "</td>
                        <td class='warning' title='Este valor contiene 1.5 por incremento 90 dias'>" . "$" . number_format($total_actas, 0, ',', '.') . "</td>
                        <td class='warning'>" . $new_acta . "</td>
                        </tr>";

                //calcular valores totales
                // $total_subtotal = $total_subtotal + $total;
                        $total_subtotal = $total_subtotal + $sub_actas;
                        $total_iva = $total_iva + $iva_actas;
                        $total_ubicacion = $total_ubicacion + $ubicacion_actas;
                        $total_afacturar = $total_afacturar + $total_actas;
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
                $fechaFacturaMes = $data['txtInicioFactura'];
                $fechaFacturaFin = $data['txtFinFactura'];


                $tabla .= "<style>
                .ui-dialog-titlebar-close {
                    visibility: hidden;
                }
                </style>";
                $tabla .= "<fieldset style='color:black;'>";
                $tabla .= "<legend class='titulo'>Actividades a Facturar</legend>";
                $tabla .= '<div class="table-responsive">';
                $tabla .= '<form id="actividades_facturar">';
                $tabla .= '<table cellpadding="0" class="table table-bordered table-hover" cellspacing="0" border="0" id="example">
                <thead>
                <tr class="fondo letraN">
                <th>Item</th>
                <th>Labor</th> 
                <th>Modulo</th>
                <th>Actividad</th>
                <th>Cantidad Conciliación</th>
                <th>Valor Conciliación</th> 
                <th>Acción</th>                           
                </tr>
                </thead>
                <tbody>';

                $sql = "CALL SP_factura('5','','','','','','','','" . $fechaFacturaMes . "','" . $fechaFacturaFin . "','','','','','','','','','','" . trim($data['detallepresupuesto_id']) . "','','');";

                $resultado = $obj_bd->EjecutaConsulta($sql);
                $valor_porcentaje = 0;

                
        while ($row = $obj_bd->FuncionFetch($resultado)) {

                    //validar numero de acta
                    //
                    // CONSULTA //
                $sql_actas = "CALL SP_factura('16','','','','','','','','','','','','','','','','','','','','" . $row['ordentrabajo_id'] . "','')";
                $resultado_actas = $obj_bd->EjecutaConsulta($sql_actas);
                $row_actas = $obj_bd->FuncionFetch($resultado_actas);
                $new_acta = $row_actas['factura_actanum'];

                        $new_acta = $new_acta;



                    $obs = '"' . preg_replace("/\s+/", " ", utf8_encode($row['presupuesto_obs'])) . '"';

                    $sql_av = "CALL SP_factura('19','','','','','','','','" . $fechaFacturaMes . "','" . $fechaFacturaFin . "','','','','','','','','','','" . $row['presupuesto_id'] . "','','')";
                    $resultado_av = $obj_bd->EjecutaConsulta($sql_av);
                    $data_av = $obj_bd->FuncionFetch($resultado_av);

                    $cantidad = $data_av['seguimiento_avance'];
           /**
            * [$valor_porcentaje description]
            * @var [type]
            */
           $valor_porcentaje = $cantidad * $row['actividad_valorservicio'];
           $tot_facturar = $tot_facturar + $valor_porcentaje;

           $tabla .= "
           <tr>
           <td><input type='hidden' id='valor_string" . $row['presupuesto_id'] . "' name='valor_cal_sub_" . $row['presupuesto_id'] . "' value='".round($valor_porcentaje)."'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'></td>
           
           <td><input type='hidden' id='ot_id_" . $row['presupuesto_id'] . "' name='ot_id_" . $row['presupuesto_id'] . "' value='".$row['ordentrabajo_id']."'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'></td>
           
           <td><input type='hidden' id='pre_id_" . $row['presupuesto_id'] . "' name='pre_id_" . $row['presupuesto_id'] . "' value='".$row['presupuesto_id']."'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'></td>
           
           <td><input type='hidden' id='dpre_id_" . $row['presupuesto_id'] . "' name='dpre_id_" . $row['presupuesto_id'] . "' value='".$row['detallepresupuesto_id']."'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'></td>
           
           <td><input type='hidden' id='mod_id_" . $row['presupuesto_id'] . "' name='mod_id_" . $row['presupuesto_id'] . "' value='".$row['modulo_id']."'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'></td>

           <td><input type='hidden' id='bar_id_" . $row['presupuesto_id'] . "' name='bar_id_" . $row['presupuesto_id'] . "' value='".$row['baremoactividad_id']."'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'></td>
           </tr> 

           <tr> 
           <td>" . utf8_encode($row['tipobaremo_sigla']) . "-" . trim($row['baremo_item']) . "</td>                     
           <td>" . utf8_encode($row['labor_descripcion']) . "</td>                     
           <td>" . utf8_encode($row['modulo_descripcion']) . "</td>                     
           <td>" . utf8_encode($row['actividad_descripcion']) . "</td>";  
            
		/////////////////////////////////////////////////////////////////////////////////
		// CONSULTA ENTRE FECHAS PARA BLOQUEAR EL BOTON Y MOSTAR LOS SALDOS PENDIENTES // 
		/////////////////////////////////////////////////////////////////////////////////
          $sql_exi = "call SP_facturacion('3', '', '', '', '', '', '', '', '" . $fechaFacturaMes . "', '" . $fechaFacturaFin . "', '', '', '', '', '', '', '', '', '', '" . $row['presupuesto_id'] . "', '".$row['ordentrabajo_id']."', '');";

          $res_exi = $obj_bd-> EjecutaConsulta($sql_exi);
          $filas = $obj_bd-> Filas($sql_exi);

          if ($filas > 0) {

          		$sql_pend = "call SP_facturacion('4', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '" . $row['presupuesto_id'] . "', '".$row['ordentrabajo_id']."', '');";

	          	$res_pend = $obj_bd-> EjecutaConsulta($sql_pend);
	          	$filas1 = $obj_bd-> Filas($sql_exi);
	          	$row_pend = $obj_bd->FuncionFetch($res_pend);

	          	if ($row_pend['factura_porcentajependiente'] != 0) {

	          		$valor_porcentaje = $row_pend['factura_valorpendiente'];

            		$tabla .= "<td><input type='text' style='text-align:center' id='porc_sub_" . $row['presupuesto_id'] . "' name='porc_sub_" . $row['presupuesto_id'] . "' maxlength='6' value='" . $row_pend['factura_porcentajependiente'] . "' placeholder='Numero' style='width:60px' class='a_txt_porc ing_datos' onkeypress='return decimales(event)' onblur='CalValorPorcPresupuestoSub(this.value," . $row['presupuesto_id'] . "," . $row['actividad_valorservicio'] . ", ".$new_acta.",".'1'.");'></td>
          
           			<td><input type='hidden' style='text-align:center' id='valor_cal_sub_" . $row['presupuesto_id'] . "' name='valor_cal_sub_" . $row['presupuesto_id'] . "' value='" . round($valor_porcentaje, 0) . "'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'>
						<input type='text' style='text-align:center' id='valor_cal_sub1_" . $row['presupuesto_id'] . "' name='valor_cal_sub_" . $row['presupuesto_id'] . "' value='" . number_format((float)$valor_porcentaje, 0, ',', '.') . "'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'>
           			</td>
                       
        			<td><input type='button' id='consolidar_" . $row['presupuesto_id'] . "' value='Consolidar' class='btn btn-warning letraBl disabled' style = '' onclick='actualizar_conciliacion(" . $row_pend['factura_id'] . ");'></td>";
            	}else{

            		$valor_porcentaje = 0;

            		$tabla .= "<td><input type='text' style='text-align:center' id='porc_sub_" . $row['presupuesto_id'] . "' name='porc_sub_" . $row['presupuesto_id'] . "' maxlength='6' value='" . $row_pend['factura_porcentajependiente']. "' placeholder='Numero' style='width:60px' class='a_txt_porc ing_datos' onkeypress='return decimales(event)' disabled='true' onblur='CalValorPorcPresupuestoSub(this.value," . $row['presupuesto_id'] . "," . $row['actividad_valorservicio'] . ", ".$new_acta.",".'1'.");'></td>
          
           			<td><input type='hidden' style='text-align:center' id='valor_cal_sub_" . $row['presupuesto_id'] . "' name='valor_cal_sub_" . $row['presupuesto_id'] . "' value='" . round($valor_porcentaje, 0) . "'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'>
						<input type='text' style='text-align:center' id='valor_cal_sub1_" . $row['presupuesto_id'] . "' name='valor_cal_sub_" . $row['presupuesto_id'] . "' value='" . number_format((float)$valor_porcentaje, 0, ',', '.') . "'  style='width:100px' disabled='true' class='input-medium a_valor_cal'>
           			</td>
                       
        			<td><input type='button' id='consolidar_" . $row['presupuesto_id'] . "' value='".$filas1."' class='btn btn-danger letraBl disabled' style = 'display:none' onclick='agregar_conciliacion(" . $row['presupuesto_id'] . ",".$cantidad.",".$valor_porcentaje.",".$new_acta.");'></td>";
            	}

          }else{

            $tabla .= "<td><input type='text' style='text-align:center' id='porc_sub_" . $row['presupuesto_id'] . "' name='porc_sub_" . $row['presupuesto_id'] . "' maxlength='6' value='" . $cantidad . "' placeholder='Numero' style='width:60px' class='a_txt_porc ing_datos' onkeypress='return decimales(event)' onblur='CalValorPorcPresupuestoSub(this.value," . $row['presupuesto_id'] . "," . $row['actividad_valorservicio'] . ", ".$new_acta.",".'1'.");'></td>
          
           <td><input type='hidden' style='text-align:center' id='valor_cal_sub_" . $row['presupuesto_id'] . "' name='valor_cal_sub_" . $row['presupuesto_id'] . "' value='" . round($valor_porcentaje, 0) . "'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'>
				<input type='text' style='text-align:center' id='valor_cal_sub1_" . $row['presupuesto_id'] . "' name='valor_cal_sub_" . $row['presupuesto_id'] . "' value='" . number_format((float)$valor_porcentaje, 0, ',', '.') . "'  style='width:100px' disabled='disabled' class='input-medium a_valor_cal'>
           </td>

            <td><input type='button' id='consolidar_" . $row['presupuesto_id'] . "' value='Consolidar' class='btn btn-danger letraBl' onclick='agregar_conciliacion(" . $row['presupuesto_id'] . ",".$cantidad.",".$valor_porcentaje.",".$new_acta.");'></td>";
          }
       }

        // $tabla .= "<tr><th colspan='7' class='success'><center>Total Facturar (Sin IVA): $" . number_format($tot_facturar, 0, ',', '.') . "</center></th></tr></tbody>
       $tabla .= "</table></form>
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

            $sql_update_factura = "CALL SP_factura('14','','','','','','','" . trim($factura_id) . "','','','','','','','','" . round($total) . "','" . round($total_facturar) . "','" . round($insert_valor_pendiente) . "','" . round($total_iva) . "','" . round($cal_ubicacion_fact) . "','" . round($iva_facturar) . "','" . round($sub_incremento) . "');";

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
        $tabla .= "<br><br><br><br>";
        $tabla .= "<fieldset class='letraBl'>";
        $tabla .= "<legend class='titulo'>Ordenes Consolidadas</legend>";

        $tabla .= "<br>";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table cellpadding="0" class="table table-bordered table-hover" cellspacing="0" border="0" id="example">
        <thead>
        <tr class="fondo letraN">                              
        <th>OT</th>  
        <th>Subestación</th>  
        <th>Proyecto</th>
        <th>Subtotal sin IVA</th>                                                        
        <th>Incremento Ubicación</th>
        <th>Incremento Pago 90 dias</th>
        <th>Subtotal + incrementos</th>
        <th>IVA</th>
        <th>Total + IVA</th>
        <th>Gestor</th>
        <th>Fecha Acta</th>
        <th>No. Acta</th>                                                  
        </tr>
        </thead>
        <tbody>';

        

        $tabla .= "</tbody>
        </table>
        </div>
        <script>$('#example').DataTable();</script>";
        $tabla .= "<fieldset>";
        return $tabla;
    }

    /** 
    * @Author: Daniel Rueda
    * @Email: sneider.rueda@gmail.com
    * @Date: 2019-05-10
    * @Desc:  Agregar registros base de datos para actas
    */

    function agregar_conciliacion($post){

        /*
        DECLARAMOS EL USUARIO
         */
        $id_usuario = $_SESSION['Usuario']['usuario_id'];

        /*
        DELCARAMOS EL OBJETO DE LA BASE DE DATOS
         */
        $obj_bd = new BD();        

        /*
        DECLARAMOS LAS VARIABLES
         */
        $iva = $post['iva'];
        $detallepresupuesto_id = $post['detallepresupuesto_id'];
        $presupuesto_id = $post['presupuesto_id'];
        $porcentaje = $post['porcentaje'];
        $valor_labor = $post['valor_labor'];
        $ot = $post['ot'];
        $cantidad = $post['cantidad'];
        $valor_subtotal = $post['valor_subtotal'];
        $acta = $post['acta'];
        $fechaFacturaMes = $post['txtInicioFactura'];
        $fechaFacturaFin = $post['txtFinFactura'];
        $ot_id = $post['id_ot'];
        $modulo_id = $post['modulo_id'];
        $baremoactividad_id = $post['baremoactividad_id'];



        $acta = $acta + 1;
        $porcentaje_pendiente = $cantidad - $porcentaje;
        $valor_pendiente = round($valor_subtotal - $valor_labor);

        


        $sql = "SELECT count(presupuesto_id) as cuenta
        FROM pt_presupuesto
        WHERE detallepresupuesto_id = " . $detallepresupuesto_id . "
        and baremoactividad_id = " . $baremoactividad_id . "
        and modulo_id = " . $modulo_id . "
        and presupuesto_estado = 1;";

        $resultado = $obj_bd->EjecutaConsulta($sql);
        $row = $obj_bd->FuncionFetch($resultado);

        $cuenta = $row['cuenta'];

        if ($cuenta == 2){


            $sql1 = "SELECT sa.subactividad_descripcion
            from cf_subactividad sa
            join pt_detalle_actividad da on sa.subactividad_id = da.subactividad_id
            join pt_presupuesto pt on da.detalleactividad_id = pt.detalleactividad_id
            and pt.presupuesto_estado = 1
            and pt.presupuesto_id = ".$presupuesto_id .";";

            $resultado1 = $obj_bd->EjecutaConsulta($sql1);
            $row1 = $obj_bd->FuncionFetch($resultado1);

            $desc = utf8_encode($row1['subactividad_descripcion']);

            // return $desc;

            if($desc == "DISEÑO"){
                /*
                INSERTAR EN LA BASE DE DATOS                
                */
               
                $sql = "CALL SP_facturacion('1','','','','','','','','".$fechaFacturaMes."','".$fechaFacturaFin."','','".$porcentaje."','".$cantidad."','".$porcentaje_pendiente."','".$id_usuario."','','".$valor_labor."','".$valor_pendiente."','".$valor_subtotal."','".$presupuesto_id."','".$ot_id."','".$acta."');";

                $consulta = $obj_bd->EjecutaConsulta($sql);
                $row3 = $obj_bd->FuncionFetch($consulta);


               $presupuesto_id1 = $presupuesto_id - 1;

               // envia los datos duplicados para poder sumarlos
               
               $sql = "CALL SP_factura('10','','','','','','','','".$fechaFacturaMes."','".$fechaFacturaFin."','','0','0','0','".$id_usuario."','','0','0','0','".$presupuesto_id."','".$ot_id."','".$acta."');";

               $consulta = $obj_bd->EjecutaConsulta($sql);
               $row2 = $obj_bd->FuncionFetch($consulta);

               $sql = "CALL SP_factura('10','','','','','','','','".$fechaFacturaMes."','".$fechaFacturaFin."','','".$porcentaje."','".$cantidad."','".$porcentaje_pendiente."','".$id_usuario."','','".$valor_labor."','".$valor_pendiente."','".$valor_subtotal."','".$presupuesto_id1."','".$ot_id."','".$acta."');";

                $consulta = $obj_bd->EjecutaConsulta($sql);
                $row1 = $obj_bd->FuncionFetch($consulta);


                if ($row1>0){

                    return 1;

                }else{

                    return 0;

                }

            }else{

                /*
                INSERTAR EN LA BASE DE DATOS para facturacion
                */
               
                $sql = "CALL SP_facturacion('1','','','','','','','','".$fechaFacturaMes."','".$fechaFacturaFin."','','".$porcentaje."','".$cantidad."','".$porcentaje_pendiente."','".$id_usuario."','','".$valor_labor."','".$valor_pendiente."','".$valor_subtotal."','".$presupuesto_id."','".$ot_id."','".$acta."');";

                $consulta = $obj_bd->EjecutaConsulta($sql);
                $row2 = $obj_bd->FuncionFetch($consulta);


                // para excel
                
                $sql = "CALL SP_factura('10','','','','','','','','".$fechaFacturaMes."','".$fechaFacturaFin."','','".$porcentaje."','".$cantidad."','".$porcentaje_pendiente."','".$id_usuario."','','".$valor_labor."','".$valor_pendiente."','".$valor_subtotal."','".$presupuesto_id."','".$ot_id."','".$acta."');";

                $consulta = $obj_bd->EjecutaConsulta($sql);
                $row1 = $obj_bd->FuncionFetch($consulta);

                if ($row1>0){

                    return 1;

                }else{

                    return 0;

                }
            }
        }
    }
}// CIERRE CLASE

