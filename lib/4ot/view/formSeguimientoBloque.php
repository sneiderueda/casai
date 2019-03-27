<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$param_labores_reportar_presupuesto_id = htmlspecialchars(strip_tags(trim($_POST['param_labores_reportar_presupuesto_id'])));

/* Covertir porcentaje */

setlocale(LC_ALL, "es_ES");

$hoy = date("m/d/Y");
$hora = date("g:i A");
?>


<!DOCTYPE html>

<html lang="en">


    </br>
    <button name="btnList" id="btnList" class="btn btn-default" type="button" onclick="gritEjecutarOT()">Mostrar listado</button>
    </br>
    </br>
    <fieldset>
        <input type="hidden" class="form-control" id="id_presupuesto" name="id_presupuesto" value="<?php echo $param_labores_reportar_presupuesto_id; ?>">  

        <legend>Detalle de las Actividades a Reportar</legend>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">      
                <div id="data_presupuestos"></div>
            </div>
        </div>


        <form id="frm_DataSeguimientoBloque" class="form-horizontal">    


            <legend>Ejecución y reporte de avance de la OT</legend>
            <div id="Seg_data">

                <div class="form-group">
                    <label for="slc_EstadoSeg" class="col-sm-3 control-label">Porcentaje de Avance</label>
                    <div class="col-sm-5">
                        <input type="hidden" id="porc_av" name="porc_av"  value="<?php echo $presupuesto_porcentaje; ?>" style="width:50px" class="input-medium" onkeypress="return decimales(event)" onblur="validarPorcentajeAvcIng('<?php echo $presupuesto_porcentaje; ?>');">                
                        <input type="text" id="porc_av_cal" name="porc_av_cal" style="width:50px" class="input-medium" onkeypress="return decimales(event)" onblur="validarPorcentajeAvcIng('<?php echo $presupuesto_porcentaje; ?>');" required="required">                
                    </div>
                </div>

                <div class="form-group">
                    <label for="slc_EstadoSeg" class="col-sm-3 control-label">Estado de la Actividad:</label>
                    <div class="col-sm-5">
                        <select class="form-control" id="slc_estado_actividad" name="slc_estado_actividad" style="width:200px" required="required">
                            <option value="">-Seleccione-</option>                                                    
                            <option value="PROGRAMADA">Programada</option>
                            <option value="PENDIENTE">Pendiente</option>
                            <option value="RECHAZADA">Rechazada</option>
                            <option value="RESUELTA">Resuelta</option>
                        </select>                    
                    </div>
                </div>

                <!--Fecha inicio-->
                <div class="form-group">
                    <label for="lb_inicio" class="col-sm-3 control-label">Inicio Ejecucion:</label>
                    <div class="col-sm-5 input-group date" id="InicioSeg"  style="width:200px">                
                        <input type='text' id="txtInicioSeg" name="txtInicioSeg" class="form-control data" readonly  required="required"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
                    </div>
                </div>

                <!--Hora inicio-->
                <div class="form-group">
                    <label for="lb_inicio_hora" class="col-sm-3 control-label">Hora Inicio Ejecucion:</label>      
                    <div id="datetimepickerSeg" class="col-sm-5 input-group date" style="width:200px">
                        <input data-format="hh:mm:ss" type="text" name="txtHoraIniSeg" id="txtHoraIniSeg" readonly></input>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>                                    
                    </div>          
                </div>

                <!--Fecha fin-->
                <div class="form-group">
                    <label for="lb_fin" class="col-sm-3 control-label">Fin Ejecucion:</label>
                    <div class="col-sm-5 input-group date" id="FinSeg" style="width:200px">                
                        <input type='text' id="txtFnicioSeg" name="txtFnicioSeg" class="col-sm-5 input-group date form-control data" readonly />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
                    </div>
                </div>

                <!--Hora Fin-->
                <div class="form-group">
                    <label for="lb_inicio_hora" class="col-sm-3 control-label">Hora Fin Ejecucion:</label>      
                    <div id="datetimepickerSegFin" class="col-sm-5 input-group date" style="width:200px">
                        <input data-format="hh:mm:ss" type="text" name="txtHoraFinSeg" id="txtHoraFinSeg" readonly></input>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>                                    
                    </div>          
                </div>

                <!--Objetivo-->
                <div class="form-group">
                    <label for="lb_obs" class="col-sm-3 control-label">Trazabilidad:</label>
                    <div class="col-sm-5">  
                        <textarea class="form-control"  id="txt_Obs_seg" name="txt_Obs_seg"rows="5" cols="40" placeholder="Reportar los hitos importantes de la ejecución del levantamiento y/o diseño" ></textarea>
                    </div>  
                </div>


                <table border="0" cellpadding="0" cellspacing="0" class="table table-hover" align="center">

                    <td colspan="3" align="center"> 

                        <div id="sec_reg_tabla"  > 
                            <table class="table table-bordered table-striped"  style="font-size:11.5px">
                                <thead>
                                    <tr>
                                        <th colspan="3" align="center"><b> Adjuntar Documentos </b>
                                            <input type="hidden" name="id_inicial_v" id="id_inicial_v" value="1"></th>
                                    </tr>
                                    <tr>
                                        <th>Opcion</th>
                                        <th>Documento</th>
                                </tr>
                                </thead>
                                <tbody id="table-adj-docu">
                                </tbody>
                            </table>

                        </div>
                        <div id="secc_consul_doc_tabla"> 
                        </div> 

                        <div id="seccion_documentos_btn">
                            <button type="button" name="btnAdd" id="btnAdd" class="btn btn-default btn-xs"  onclick="AddSoporteSeguimiento()"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Adicionar</button></div>
                    </td>
                </table>
                <!--Botones guaradr-->
                <div class="form-group" id="btn_presupuesto_detalle">
                    <div class="col-sm-offset-4 col-sm-4">
                        <button id="btoGuardarSeguimiento" name="btoGuardarSeguimiento" class="btn btn-primary" type="submit" >Guardar</button>                                    
                    </div>
                </div>
            </div>
        </form>




    </fieldset>

    <div id="dialog_arch" style="position: relative;"></div>
</html>
<script type="text/javascript">

    $(function () {
        $('#txtInicioSeg').datepicker({
            //viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2017',
            // dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
                    // maxDate: "D"  

        });
        $('#txtFnicioSeg').datepicker({
            format: 'YYYY-MM-DD',
            minDate: '01-01-2017',
            // dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            maxDate: "D"
        });

        $('#datetimepickerSeg').datetimepicker({
            pickDate: false
        });
        $('#datetimepickerSegFin').datetimepicker({
            pickDate: false
        });
    });

</script>

<script type="text/javascript">
    $('#txtInicioSeg').val('<?php echo $hoy ?>');
    $('#txtFnicioSeg').val('<?php echo $hoy ?>');
    $('#txtHoraIniSeg').val('<?php echo $hora ?>');
    $('#txtHoraFinSeg').val('<?php echo $hora ?>');
    ListActividadesReportar();
    
    $('#frm_DataSeguimientoBloque').validate({
        rules: {
            txtInicioSeg: {required: true},
            txtHoraIniSeg: {required: true},
            txtFnicioSeg: {required: true},
            txtHoraFinSeg: {required: true},
            txt_Obs_seg: {required: true},
            porc_av: {required: true},
            porc_av_cal: {required: false}

        },
        messages: {
        },
        debug: true,
        invalidHandler: function () {

            alert('Hay información en el formulario sin diligenciar por favor completarla');
            //$("#messageDataUser").html(htmlMessage);
            return false;
        },
        submitHandler: function (form) {
            /*Validar fechas ingresadas*/
            var fechaInicial = $("#txtInicioSeg").val();
            var fechaFinal = $("#txtFnicioSeg").val();

            if (fechaInicial > fechaFinal) {
                alert('Señor usuario por favor revise las fechas de ejecución, la fecha inicial no puede ser mayor a la final.');
                return false;
            } else {
                SaveSeguimientoBloqueLabores();
            }

        }
    });

</script>