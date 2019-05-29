<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$baremo_id = htmlspecialchars(strip_tags(trim($_POST['baremo_id'])));
$ordentrabajo_id = htmlspecialchars(strip_tags(trim($_POST['ordentrabajo_id'])));
$presupuesto_id = htmlspecialchars(strip_tags(trim($_POST['presupuesto_id'])));
$tipobaremo_id = htmlspecialchars(strip_tags(trim($_POST['tipobaremo_id'])));
$presupuesto_porcentaje = htmlspecialchars(strip_tags(trim($_POST['presupuesto_porcentaje'])));
$presupuesto_progestado = htmlspecialchars(strip_tags(trim($_POST['presupuesto_progestado'])));


$id_seguimiento = htmlspecialchars(strip_tags(trim($_POST['id_seguimiento'])));

/* Covertir porcentaje */

setlocale(LC_ALL, "es_ES");

$hoy = date("m/d/Y");
$hora = date("g:i A");
?>


<!DOCTYPE html>

<html lang="en">


    </br>
    <br>
    <br>
    <br>
    <button name="btnList" id="btnList" class="btn fondo letraB" type="button" onclick="gritEjecutarOT()">Mostrar listado</button>
    </br>
    </br>
    <fieldset class="letraBl">
        <input type="hidden" class="form-control" id="baremo_id" name="baremo_id" value="<?php echo $baremo_id; ?>">                
        <input type="hidden" class="form-control" id="ordentrabajo_id" name="ordentrabajo_id" value="<?php echo $ordentrabajo_id; ?>">                
        <input type="hidden" class="form-control" id="presupuesto_id" name="presupuesto_id" value="<?php echo $presupuesto_id; ?>">                
        <input type="hidden" class="form-control" id="tipobaremo_id" name="tipobaremo_id" value="<?php echo $tipobaremo_id; ?>">                
        <input type="hidden" class="form-control" id="num_seg" name="num_seg" value="0">                
        <input type="hidden" class="form-control" id="presupuesto_porcentaje" name="presupuesto_porcentaje" value="<?php echo $presupuesto_porcentaje; ?>">                
        <input type="hidden" class="form-control" id="id_seguimiento" name="id_seguimiento" value="<?php echo $id_seguimiento; ?>">  


        <legend class="titulo">Detalle de la Actividad</legend>

        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div role="tabpanel" class="">
                        <ul class="nav nav-tabs borde_inf" role="tablist" id="agregar_tab">
                            <li role="presentation" id="tab0" class="active"><a href="#seccion0" aria-controls="seccion0" data-toggle="tab" role="tab">Orden Trabajo Interna</a></li>
                            <li role="presentation" id="tab1" class=""><a href="#seccion1" aria-controls="seccion1" data-toggle="tab" role="tab">Reporte Ejecución</a></li>
                            <li role="presentation" id="tab2" class=""><a href="#seccion2" aria-controls="seccion2" data-toggle="tab" role="tab">Grupo de Trabajo</a></li>
                            <li role="presentation" id="tab3" class=""><a href="#seccion3" aria-controls="seccion3" data-toggle="tab" role="tab">Documentos Grupo de Trabajo</a></li>
                        </ul>
                    </div>

                    <div class="tab-content" id="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="seccion0">
                            <br>
                            <br>

                            <form id="frm_DataSeguimientoOT" class="form-horizontal">    

                                <div id="data_presupuesto">

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Subestacion:</label>
                                        <div class="col-sm-5">  
                                            <input type="text" id="txt_subestacion" name="txt_subestacion" disabled="disabled">                
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">OT:</label>
                                        <div class="col-sm-5">  
                                            <input type="text" id="txt_ot" name="txt_ot" disabled="disabled">                
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Objeto:</label>
                                        <div class="col-sm-5" id="objeto">                      
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Alcance:</label>
                                        <div class="col-sm-5" id="alcance">                                     
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Modulo:</label>
                                        <div class="col-sm-5">  
                                            <input type="text" id="txt_modulo" name="txt_modulo" disabled="disabled" style="width:400px">                  
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Labor:</label>
                                        <div class="col-sm-5" id="txt_labor">  

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Actividad:</label>
                                        <div class="col-sm-5" id="actividad">                      
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Alcance técnico particular:</label>
                                        <div class="col-sm-5" id="obs_presupuesto">                      
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Código GOM:</label>
                                        <div class="col-sm-5">  
                                            <input type="text" id="txt_gom" name="txt_gom" disabled="disabled">                
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Cantidad:</label>
                                        <div class="col-sm-5">  
                                            <input type="text" id="txt_cantidad" name="txt_cantidad" disabled="disabled" style="width:50px">                
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Valor:</label>
                                        <div class="col-sm-5">  
                                            <input type="text" id="txt_valor" name="txt_valor" disabled="disabled">                
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="seccion1">
                            <legend class="titulo">Ejecución y reporte de avance de la OT</legend>
                            
                            <form id="frm_DataSeguimientoOT" class="form-horizontal"> 
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

                                    <?php if ($presupuesto_progestado != "RESUELTA" && $presupuesto_progestado != "FACTURADA") { ?>
                                        <!--Botones guaradr-->
                                        <div class="form-group" id="btn_presupuesto_detalle">
                                            <div class="col-sm-offset-4 col-sm-4">
                                                <button id="btoGuardarSeguimiento" name="btoGuardarSeguimiento" class="btn btn-primary" type="submit" >Guardar</button>                                    
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                     

                                <div id="Json_seg" class="form-horizontal" style="display: none">
                                    <div class="form-group">
                                        <label for="slc_EstadoSeg_json" class="col-sm-3 control-label">Cambiar Estado de la Actividad:</label>
                                        <div class="col-sm-5">
                                            <select class="form-control" id="slc_estado_actividadJS" name="slc_estado_actividadJS" style="width:200px" disabled="true" >
                                                <option value="">-Seleccione-</option>                                                    
                                                <option value="PROGRAMADA">Programada</option>
                                                <option value="PENDIENTE">Pendiente</option>
                                                <option value="RECHAZADA">Rechazada</option>
                                                <option value="RESUELTA">Resuelta</option>
                                            </select>                    
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="slc_EstadoSeg" class="col-sm-3 control-label">Porcentaje de Avance</label>
                                        <div class="col-sm-5">
                                            <input type="text" id="porc_avJS" name="porc_avJS" maxlength='3' disabled="true" value="<?php echo $presupuesto_porcentaje; ?>" style="width:50px" class="input-medium" onkeypress="return decimales(event)" onblur="validarPorcentajeAvc('<?php echo $presupuesto_porcentaje; ?>');">                
                                        </div>
                                    </div>


                                    <!--Fecha inicio-->
                                    <div class="form-group">
                                        <label for="lb_inicio" class="col-sm-3 control-label">Inicio Ejecucion:</label>
                                        <div class="col-sm-5 input-group date" id="InicioSeg"  style="width:200px">                
                                            <input type='text' id="txtInicioSegJS" name="txtInicioSegJS" class="form-control data" readonly disabled="true" />
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
                                        </div>
                                    </div>

                                    <!--Hora inicio-->
                                    <div class="form-group">
                                        <label for="lb_inicio_hora" class="col-sm-3 control-label">Hora Inicio Ejecucion:</label>      
                                        <div id="datetimepickerSeg" class="col-sm-5 input-group date" style="width:180px">
                                            <input data-format="hh:mm:ss" type="text" name="txtHoraIniSegJS" id="txtHoraIniSegJS" readonly disabled="true"></input>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>                                    
                                        </div>          
                                    </div>

                                    <!--Fecha fin-->
                                    <div class="form-group">
                                        <label for="lb_fin" class="col-sm-3 control-label">Fin Ejecucion:</label>
                                        <div class="col-sm-5 input-group date" id="FinSeg" style="width:200px">                
                                            <input type='text' id="txtFnicioSegJS" name="txtFnicioSegJS" disabled="true" class="col-sm-5 input-group date form-control data" readonly />
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
                                        </div>
                                    </div>

                                    <!--Hora Fin-->
                                    <div class="form-group">
                                        <label for="lb_inicio_hora" class="col-sm-3 control-label">Hora Fin Ejecucion:</label>      
                                        <div id="datetimepickerSegFin" class="col-sm-5 input-group date" style="width:180px">
                                            <input data-format="hh:mm:ss" type="text" name="txtHoraFinSegJS" id="txtHoraFinSegJS" readonly disabled="true"></input>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>                                    
                                        </div>          
                                    </div>

                                    <!--Objetivo-->
                                    <div class="form-group">
                                        <label for="lb_obs" class="col-sm-3 control-label">Observaciones:</label>
                                        <div class="col-sm-5">  
                                            <textarea class="form-control"  id="txt_Obs_segJS" name="txt_Obs_segJS"rows="5" cols="40" placeholder="Observaciones del Seguimiento" ></textarea>
                                        </div>
                                    </div>

                                    <form id="frm_DataJS_seguimiento">
                                        <table border="0" cellpadding="0" cellspacing="0" class="table table-hover" align="center">

                                            <td colspan="3" align="center"> 

                                                <div id="sec_reg_tabla"  > 
                                                    <table class="table table-bordered table-striped"  style="font-size:11.5px">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="3" align="center"><b>Documentos </b>
                                                                    <input type="hidden" name="id_inicial_js" id="id_inicial_js" ></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Opcion</th>
                                                                <th>Documento</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="table-adj-docu_js">
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div id="secc_consul_doc_tabla_js"> 
                                                </div> 

                                                <?php if ($presupuesto_progestado != "RESUELTA" && $presupuesto_progestado != "FACTURADA") { ?>
                                                    <div id="seccion_documentos_btn_json">
                                                        <button type="button" name="btnAdd_js" id="btnAdd_js" class="btn btn-default btn-xs"  onclick="AddSoporteSeguimientoModificado()"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Adicionar</button></div>
                                                <?php } ?>
                                            </td>
                                        </table>
                                    </form>

                                    <!--Botones guaradr-->
                                    <div class="form-group" id="btn_presupuesto_detalle">
                                        <div class="col-sm-offset-4 col-sm-4">
                                            <?php
                                            if ($presupuesto_progestado != "RESUELTA" && $presupuesto_progestado != "FACTURADA") {
                                                $urlEdit = '"lib/4ot/view/formSeguimiento.php","contenido","' . $baremo_id . '","' . $ordentrabajo_id . '","' . $presupuesto_id . '","' . $tipobaremo_id . '","' . $presupuesto_progestado . '","' . $presupuesto_porcentaje . '",""';
                                                ?>
                                                <button id="btoGuardarSeguimiento" name="btoGuardarSeguimiento" class="btn btn-primary" type="submit" onclick="UpdateObsDocsSeguimiento();" >Modificar</button>                                    
                                                <button id='btoAddSeguimiento' name='btoAddSeguimiento' class='btn btn-primary' type='submit' onclick='loadingSeguimientos(<?php echo $urlEdit; ?>);' >Nuevo Seguimiento</button>                                    
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="seccion2">
                            <!--Seguimientos de la actividad-->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">      
                                    <div id="Seguimiento_actividad"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
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

    var id_seguimiento = $("#id_seguimiento").val();
    var dataPresupuesto = JsonDetalleActividad('<?php echo $presupuesto_id ?>');

    $("#txt_subestacion").val(dataPresupuesto.subestacion_nombre);
    $("#txt_ot").val(dataPresupuesto.ordentrabajo_num);
    $("#objeto").html(dataPresupuesto.detallepresupuesto_objeto);
    $("#alcance").html(dataPresupuesto.detallepresupuesto_alcance);
    $("#txt_modulo").val(dataPresupuesto.modulo_descripcion);
    $("#txt_labor").html(dataPresupuesto.baremo_item + ' - ' + dataPresupuesto.labor_descripcion);
    $("#actividad").html(dataPresupuesto.actividad_descripcion);
    $("#obs_presupuesto").html(dataPresupuesto.presupuesto_obs);
    $("#txt_gom").val(dataPresupuesto.actividad_gom);
    $("#txt_cantidad").val(dataPresupuesto.presupuesto_porcentaje);
    $("#txt_valor").val(dataPresupuesto.presupuesto_valorporcentaje);

    ListSeguimientoPresup('<?php echo $presupuesto_id ?>', '<?php echo $presupuesto_progestado; ?>', '<?php echo $presupuesto_porcentaje; ?>', 1);
    $("#slc_estado_actividad").val('<?php echo $presupuesto_progestado; ?>');

    if (id_seguimiento == "") {

        $("#slc_estado_actividad").val('<?php echo $presupuesto_progestado; ?>');

        $('#frm_DataSeguimientoOT').validate({
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
                    SaveSeguimientoAct();
                }

            }
        });
    } else {
        $("#slc_estado_actividadJS").val('<?php echo $presupuesto_progestado; ?>');
        var DataSeguimiento = JsonSeguimiento('<?php echo $id_seguimiento; ?>', '<?php echo $presupuesto_porcentaje; ?>');
        ListSoporteSeguimiento('<?php echo $id_seguimiento; ?>', '<?php echo $presupuesto_progestado; ?>');

    }
</script>