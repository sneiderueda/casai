<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MD_reporte
 *
 * @author user
 */
include '../../0connection/BD_config.php';
include '../../0connection/connection.php';
include '../../0connection/BD.php';
date_default_timezone_set('America/Bogota');
session_start();

class MD_reporte {

    //put your code here
    function td_resumenAsignadasLb($data) {

        $obj_bd = new BD();
        $tabla = "";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table id="tb_resumenlb" cellpadding="0" class="table table-hover" cellspacing="0" border="0" >
                    <thead>
                        <tr>                              
                            <th>No. OT</th>  
                            <th>Presupuesto</th>  
                            <th>Subestacion</th>                                                        
                            <th class="success" >No. Labores</th>                                                        
                            <th class="success" >% Asignado</th>                                                        
                            <th class="success" >Val. Asignado</th>                                                                                                                                            
                            <th class="warning">% Avance</th>                                                                                                                                            
                            <th class="warning">Val. Avance</th>                                                                                                                                            
                            <th class="danger">% Tiempo Transcurrido OT</th>                                                                                                                                            
                        </tr>
                    </thead>
                    <tbody>';
        if ($data['id_contrato'] == "" && $data['year'] == "TODO") {
            $sql = "CALL SP_RplaboresAsignadas('1','')";
        } else {
            if ($data['id_contrato'] != "" && $data['year'] != "TODO") {
                $filtro = "dp.contrato_id=" . $data['id_contrato'] . " and  date_format( pt.presupuesto_fechamodifico,'%Y') =" . $data['year'];
            } else if ($data['id_contrato'] != "" && $data['year'] == "TODO") {
                $filtro = "dp.contrato_id=" . $data['id_contrato'];
            } else if ($data['id_contrato'] == "" && $data['year'] != "TODO") {
                $filtro = " date_format( pt.presupuesto_fechamodifico,'%Y') =" . $data['year'];
            }
            $sql = "SELECT  dp.detallepresupuesto_id,
                                ot.ordentrabajo_num,
                                ot.ordentrabajo_fechaini,
                                ot.ordentrabajo_fechafin,        
                                DATEDIFF( NOW(), ot.ordentrabajo_fechaini) as valor_1,
                                DATEDIFF( ot.ordentrabajo_fechafin, ot.ordentrabajo_fechaini) as valor_2,  
                                ROUND((( DATEDIFF( NOW(), ot.ordentrabajo_fechaini)/DATEDIFF( ot.ordentrabajo_fechafin, ot.ordentrabajo_fechaini))*100 ), 1 )AS porcentaje_tiempo,
                                dp.detallepresupuesto_nombre,
                                sbe.subestacion_nombre,
                                md.modulo_descripcion,
                                ROUND(sum(pt.presupuesto_porcentaje),1)as porcentaje,        
                                sum(pt.presupuesto_valorporcentaje) as valor_total,
                                (round((sum(pt.presupuesto_valorporcentaje)*1)/dp.detallepresupuesto_total,1) *100) as porcentaje_asignado,
                                date_format( ot.ordentrabajo_fechaini,'%Y') as year,
                                dp.contrato_id,
                                COUNT(*) Total
                            FROM pt_presupuesto pt
                            JOIN pt_orden_trabajo ot ON pt.detallepresupuesto_id=ot.detallepresupuesto_id
                            JOIN cf_modulo md ON pt.modulo_id=md.modulo_id
                            JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
                            JOIN dt_subestacion sbe ON dp.subestacion_id=sbe.subestacion_id
                                 AND pt.presupuesto_estado=1
                                 AND ot.ordentrabajo_estado=1
                                 AND dp.detallepresupuesto_estado <>0
                                 AND pt.presupuesto_encargado is not null
                                 AND $filtro
                         group by dp.detallepresupuesto_id
                           HAVING COUNT(*) >= 1";
        }

        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            /* traer porcentaje y valor avance */
            $porcentaje_avc = "";
            $total_avc = "";
            $sql_avc = "CALL SP_RplaboresAsignadas('2','" . $row['detallepresupuesto_id'] . "')";
            $resultado_avc = $obj_bd->EjecutaConsulta($sql_avc);
            $row_avc = $obj_bd->FuncionFetch($resultado_avc);
            $porcentaje_avc = $row_avc['_total_porcentaje'];
            $total_avc = $row_avc['_total_avance'];

            $tabla .= "<tr id='" . $row['detallepresupuesto_id'] . "'>                
                <td>" . $row['ordentrabajo_num'] . "</td>                                
                <td>" . utf8_encode($row['detallepresupuesto_nombre']) . "</td>                
                <td>" . utf8_encode($row['subestacion_nombre']) . "</td>                
                <td class='success' >" . $row['total'] . "</td>                
                <td class='success' >" . $row['porcentaje_asignado'] . "</td>                                                                                                   
                <td class='success' >" . number_format((float) $row['valor_total'], 0, ',', '.') . "</td>                                             
                <td class='warning'>" . round($porcentaje_avc, 2) . "</td>                                              
                <td class='warning'>" . number_format((float) $total_avc, 0, ',', '.') . "</td>    
                <td class='danger' >" . $row['porcentaje_tiempo'] . "</td>   
               </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>
                    $('#tb_resumenlb').DataTable(
                   {'order': [[ 0, 'desc' ]]});
                 

                        $(document).ready(function() {
                            var table = $('#tb_resumenlb').DataTable();

                            $('#tb_resumenlb tbody').on( 'click', 'tr', function () {
                                $(this).toggleClass('selected');
                                    var detallepresupuesto_id=$(this).closest('tr').attr('id');
                                    DataDetalleLabores(detallepresupuesto_id);
                                     FiltrarCalendatioLabor(detallepresupuesto_id);
                            } );

                         } );

                   </script>";

        return $tabla;
    }

    function DataDetalleLabores($data) {

        $obj_bd = new BD();
        $tabla = "";
        $tabla .= '<div class="table-responsive">';
        $tabla .= '<table id="tb_detalle" cellpadding="0" class="table table-bordered table-hover" cellspacing="0" border="0" >
                    <thead>
                        <tr>                              
                            <th>No. OT</th>  
                            <th>Labor</th>  
                            <th>Modulo</th>  
                            <th>Area</th>  
                            <th>Subactividad</th>                                                        
                            <th>Estado</th>                                                        
                            <th>% Avance</th>                                                        
                            <th>Total Avance</th>                                                                                                                                                                                                              
                            <th>Responsable</th>                                                                                                                                                                                                              
                        </tr>
                    </thead>
                    <tbody>';

        $sql = "CALL SP_RplaboresAsignadas('3','" . $data['id'] . "')";
        $resultado = $obj_bd->EjecutaConsulta($sql);

        while ($row = $obj_bd->FuncionFetch($resultado)) {

            /* traer porcentaje y valor avance */
            $porcentaje_avc = "";
            $total_avc = "";
            $sql_avc = "CALL SP_RplaboresAsignadas('2','" . $row['detallepresupuesto_id'] . "')";
            $resultado_avc = $obj_bd->EjecutaConsulta($sql_avc);
            $row_avc = $obj_bd->FuncionFetch($resultado_avc);
            $porcentaje_avc = $row_avc['_total_porcentaje'];
            $total_avc = $row_avc['_total_avance'];

            $tabla .= "<tr id='" . $row['presupuesto_id'] . "'>                
                <td>" . utf8_encode($row['ordentrabajo_num']) . "</td>                
                <td><b>" . $row['tipobaremo_sigla'] . "-" . $row['baremo_item'] . " </b> " . utf8_encode($row['labor_descripcion']) . "</td>                                
                <td>" . utf8_encode($row['modulo_descripcion']) . "</td>                                
                <td>" . utf8_encode($row['area_nombre']) . "</td>                                
                <td>" . utf8_encode($row['subactividad_descripcion']) . "</td>                
                <td>" . utf8_encode($row['presupuesto_progestado']) . "</td>                                                          
                <td>" . utf8_encode($row['avance_porc']) . "</td>                                                          
                <td>" . number_format((float) $row['valor_avance'], 0, ',', '.') . "</td>  
                <td class='Responsable'>" . utf8_encode($row['responsable']) . "</br><button type='button' class='btn btn-link' onclick='MostrarResponsablesTb(" . $row['presupuesto_id'] . ")'>Ver Mas</button></td>                 
               </tr>";
        }

        $tabla .= "</tbody>
                    </table>
                    </div>
                    <script>
                    

                    $('#tb_detalle').DataTable(
                        {'order': [[ 0, 'desc' ]]});


                            

                    </script>";
        $tabla .= "<fieldset>";

        return $tabla;
    }

    public function GfLaboresArea($data) {

        $arreglo_grafica = array();
        $con_val = array();
        $cadena_valores = array();
        $obj_bd = new BD();

        if ($data['id_contrato'] == "" && $data['year'] == "TODO") {
            $sql = "CALL SP_RplaboresAsignadas('4','')";
        } else {
            if ($data['id_contrato'] != "" && $data['year'] != "TODO") {
                $filtro = "dp.contrato_id=" . $data['id_contrato'] . " and  date_format( pt.presupuesto_fechamodifico,'%Y') =" . $data['year'];
            } else if ($data['id_contrato'] != "" && $data['year'] == "TODO") {
                $filtro = "dp.contrato_id=" . $data['id_contrato'];
            } else if ($data['id_contrato'] == "" && $data['year'] != "TODO") {
                $filtro = " date_format( pt.presupuesto_fechamodifico,'%Y') =" . $data['year'];
            }
            $sql = "select  dp.detallepresupuesto_id,
				dp.contrato_id,
				ar.area_nombre,
				pt.presupuesto_progestado,
				pt.presupuesto_fechamodifico,
                                ROUND(SUM(pt.presupuesto_valorporcentaje),2) AS valor_factura,
				MONTH(pt.presupuesto_fechamodifico)  as mes_num,
				CASE MONTH(pt.presupuesto_fechamodifico)
				WHEN 1 THEN '0'
				WHEN 2 THEN '1'
				WHEN 3 THEN '2'
				WHEN 4 THEN '3'
				WHEN 5 THEN '4'
				WHEN 6 THEN '5'
				WHEN 7 THEN '6'
				WHEN 8 THEN '7'
				WHEN 9 THEN '8'
				WHEN 10 THEN '9'
				WHEN 11 THEN '10'
				WHEN 12 THEN '11'            
				END mes,
				date_format( pt.presupuesto_fechamodifico,'%Y') as year,
				COUNT(*) Total
				from pt_presupuesto pt
			JOIN cf_area ar ON pt.area_id=ar.area_id
			JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
                        JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
			where pt.presupuesto_progestado  IN ('FINALIZADA','FACTURA PARCIAL')
                        and ot.ordentrabajo_estado=1
                        and $filtro
		 group by ar.area_nombre, mes
			HAVING count( pt.area_id) >1;";
        }


        $resul = $obj_bd->EjecutaConsulta($sql);
        $nom_area = "";
        $con_val = "";
        /*
          $arreglo_fechas = array('ENERO' => 0,
          'FEBRERO' => 0,
          'MARZO' => 0,
          'ABRIL' => 0,
          'MAYO' => 0,
          'JUNIO' => 0,
          'JULIO' => 0,
          'AGOSTO' => 0,
          'SEPTIEMBRE' => 0,
          'OCTUBRE' => 0,
          'NOVIEMBRE' => 0,
          'DICIEMBRE' => 0);
         */
        $arreglo_fechas = array('0' => 0,
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
            '11' => 0);

        while ($row = $obj_bd->FuncionFetch($resul)) {

            if ($nom_area == $row['area_nombre']) {
                //$mes = trim($row['mes']);
                $mes = trim($row['mes']);
                $valor_mes = $row['valor_factura'];
                $arreglo_fechas[$mes] = $valor_mes;
                $con_val[$mes] = (int) $arreglo_fechas[$mes];
            } else {
                $cadena_valores = "";
                $arreglo_fechas = array('0' => 0,
                    '1' => 0,
                    '2' => 0,
                    '3' => 0,
                    '4' => 0,
                    '5' => 0,
                    '6' => 0,
                    '7' => 0,
                    '8' => 0,
                    '9' => 0,
                    '10' => 0,
                    '11' => 0);

                $nom_area = $row['area_nombre'];
                $mes = trim($row['mes']);
                $valor_mes = $row['valor_factura'];
                $arreglo_fechas[$mes] = $valor_mes;

                while (list($clave, $valor) = each($arreglo_fechas)) {
                    $con_val[$clave] = (int) $valor;
                }
            }

            $cadena_valores = implode(',', $con_val);
            $arreglo_grafica[$row['area_nombre']] = $arreglo_fechas;
        }



        $i = 0;
        $arreglo_entrega = array();

        foreach ($arreglo_grafica as $key => $value) {

            $color = $this->EntregaColor();
            $arreglo_entrega[$i]['label'] = strtoupper($this->normaliza($key));
            $arreglo_entrega[$i]['fill'] = "false";
            $arreglo_entrega[$i]['backgroundColor'] = $color;
            $arreglo_entrega[$i]['borderColor'] = "rgba(0, 99, 132, 0.6)";
            $arreglo_entrega[$i]['data'] = $value;


            $i++;
        }

        // print_r($arreglo_entrega);
        $json = json_encode($arreglo_entrega);
        return $json;
    }

    public function EntregaColor() {
        $colores = array("#008000",
            "#800080",
            "rgba(0, 99, 132, 0.6)",
            "rgba(211,255,206)",
            "#FFA500",
            "#FF6384",
            "#FA8F13",
            "#FA1332",
            "#133AFA",
            "#13FAEB",
            "#b4b4b4",
            "#7813FB",
            "#1396FB",
            "#DBF02D",
            "#5ed4f1",
            "#794044",
            "#FBEC13",
            "#96FB13",
            "#EFF383",
            "#83F387");
        $clave_aleatoria = array_rand($colores);

        return $colores[$clave_aleatoria];
    }

    function normaliza($cadena) {
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        return utf8_encode($cadena);
    }

    function seguimientoCalendario() { // no se esta usando la funcion para el calendario
        $arreglo_retorno = array();
        $obj_bd = new BD();
        $sql = "CALL SP_RplaboresAsignadas('5','')";
        $resul = $obj_bd->EjecutaConsulta($sql);



        $a = 0;
        $id_color = "";
        while ($row = $obj_bd->FuncionFetch($resul)) {

            if ($row['detallepresupuesto_id'] == $id_color) {
                $color = $color;
            } else {
                $color = $this->EntregaColor();
                $id_color = $row['detallepresupuesto_id'];
            }


            $arreglo_retorno[$a]['id'] = htmlentities($row['detallepresupuesto_id']);
            $arreglo_retorno[$a]['title'] = htmlentities($row['area_nombre']);
            $arreglo_retorno[$a]['backgroundColor'] = $color;
            $arreglo_retorno[$a]['start'] = $row['fecha_inicio'];
            $arreglo_retorno[$a]['end'] = $row['seguimiento_fechafin'];
            $a++;
        }

        // print_r($json);
        $json = json_encode($arreglo_retorno);
        return $json;
    }

    function VistaSeguimientoCalendario($data) {

        $obj_bd = new BD();


        $sql = "CALL SP_ptseguimiento('1','','','','','','','','','','','','','','','','','','" . trim($data['presupuesto_id']) . "','');";

        if ($obj_bd->Filas($sql) > 0) {
            $resultado = $obj_bd->EjecutaConsulta($sql);
            $i = 0;
            $arreglo_retorno = array();
            $arreglo = array();
            while ($row = $obj_bd->FuncionFetch($resultado)) {

                $arreglo[$i]['seguimiento_num'] = $row['seguimiento_num'];
                $arreglo[$i]['seguimiento_fechaini'] = $row['seguimiento_fechaini'];
                $arreglo[$i]['seguimiento_fechafin'] = $row['seguimiento_fechafin'];
                $arreglo[$i]['seguimiento_horaini'] = $row['seguimiento_horaini'];
                $arreglo[$i]['seguimiento_horafin'] = $row['seguimiento_horafin'];
                $arreglo[$i]['seguimiento_obs'] = utf8_encode($row['seguimiento_obs']);
                $arreglo[$i]['responsable'] = utf8_encode($row['responsable']);
                $i++;
            }
            $arreglo_retorno['dataSeguimiento'] = $arreglo;
            $json = json_encode($arreglo_retorno);
        } else {
            $json = json_encode(0);
        }
        return $json;
    }

    function ValorFacturaLabores($data) {

        $obj_bd = new BD();





        if ($data['id_contrato'] == "" && $data['year'] == "TODO") {
            $sql = "CALL SP_RplaboresAsignadas('7','')";
        } else {
            if ($data['id_contrato'] != "" && $data['year'] != "TODO") {
                $filtro = "dp.contrato_id=" . $data['id_contrato'] . " and  date_format( pt.presupuesto_fechamodifico,'%Y') =" . $data['year'];
            } else if ($data['id_contrato'] != "" && $data['year'] == "TODO") {
                $filtro = "dp.contrato_id=" . $data['id_contrato'];
            } else if ($data['id_contrato'] == "" && $data['year'] != "TODO") {
                $filtro = " date_format( pt.presupuesto_fechamodifico,'%Y') =" . $data['year'];
            }
            $sql = "select  ar.area_nombre,
			 pt.presupuesto_progestado,
			 pt.presupuesto_fechamodifico,
                         sum(pt.presupuesto_valorporcentaje) as factura,
			 MONTH(pt.presupuesto_fechamodifico)  as mes_num,
			 CASE MONTH(pt.presupuesto_fechamodifico)
				 WHEN 1 THEN '0'
				 WHEN 2 THEN '1'
				 WHEN 3 THEN '2'
				 WHEN 4 THEN '3'
				 WHEN 5 THEN '4'
				 WHEN 6 THEN '5'
				 WHEN 7 THEN '6'
				 WHEN 8 THEN '7'
				 WHEN 9 THEN '8'
				 WHEN 10 THEN '9'
				 WHEN 11 THEN '10'
				 WHEN 12 THEN '11'            
                                 END mes,
			 date_format( pt.presupuesto_fechamodifico,'%Y') as year,
			 COUNT(*) Total
			 from pt_presupuesto pt
			JOIN cf_area ar ON pt.area_id=ar.area_id
                        JOIN dt_detalle_presupuesto dp ON pt.detallepresupuesto_id=dp.detallepresupuesto_id
                        JOIN pt_orden_trabajo ot ON dp.detallepresupuesto_id=ot.detallepresupuesto_id
			where pt.presupuesto_progestado  IN ('FINALIZADA','FACTURA PARCIAL')
                        and ot.ordentrabajo_estado=1
                        and $filtro
			group by ar.area_nombre
			HAVING count( pt.area_id) >1";
        }

        // return $sql;

        if ($obj_bd->Filas($sql) > 0) {
            $resultado = $obj_bd->EjecutaConsulta($sql);
            $i = 0;
            $total = 0;
            $arreglo_retorno = array();
            $arreglo = array();
            while ($row = $obj_bd->FuncionFetch($resultado)) {

                $total = $row['factura'] + $total;
                $arreglo[$i]['area_nombre'] = utf8_encode($row['area_nombre']);
                $arreglo[$i]['factura'] = number_format((float) $row['factura'], 0, ',', '.');
                $i++;
            }
            $arreglo_retorno['dataValorlabores'] = $arreglo;
            $arreglo_retorno['valor_total'] = number_format((float) $total, 0, ',', '.');
            $json = json_encode($arreglo_retorno);
        } else {
            $json = json_encode(0);
        }
        return $json;
    }

}
