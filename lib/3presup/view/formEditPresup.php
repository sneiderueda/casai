<?php

/*
  Autor:jennifer.cabiativa@gmail.com
  Modificaciones: sneider.rueda@gmail.com
 */


$detallepresupuesto_id = htmlspecialchars(strip_tags(trim($_POST['data'])));
?>

<!DOCTYPE html>

<html lang="es">




<form id="frm_DataPresupuesto" class="form-horizontal">

    <input type="hidden" class="form-control" id="detallepresupuesto_id" name="detallepresupuesto_id">
    <input type="hidden" class="form-control" id="total_presupuesto_incremento" name="total_presupuesto_incremento">

    <fieldset style="color: black">
        <legend class="titulo">Generar Presupuesto</legend>

        <nav class="barraPre fondo letraN">
            <div class="inline">
                <h4>Presupuesto: </h4>
                <button id="btoGuardarPresupuesto" name="btoGuardarPresupuesto" class="btn btn-primary" type="submit" onclick="SavePresupuesto();">Guardar</button>
                <button type="button" class="btn btn-default" name="btnCancelar" id="btnCancelar" onclick="gritPresupuesto();">Cancelar</button>
            </div>

            <div class="inline ">
                <h4>Modulo: </h4>
                <button title="Agregar" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></button>
                <button title="Remover" class="btn btn-danger"><span class="glyphicon glyphicon-minus"></button>
            </div>

            <div class="inline">
                <h4>Labor: </h4>
                <button title="Agregar" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></button>
                <button title="Remover" class="btn btn-danger"><span class="glyphicon glyphicon-minus"></button>
            </div>
        </nav>

        <br>

        <div class="col-sm-6">
            <?php if ($detallepresupuesto_id != 0) { ?>
                <div class="form-group">
                    <label for="slc_Estado" class="col-sm-3 control-label">Estado</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="slc_regimen" name="slc_estado_presupuesto" onclick="DeleteDetallePresupuestoSelect(<?php echo $detallepresupuesto_id; ?>, this.value);">
                            <option value="1">-Seleccione-</option>
                            <option value="2">Pendiente</option>
                            <option value="3">Guardado</option>
                        </select>
                    </div>
                </div>
            <?php } ?>

            <!-- Presupuesto-->
            <div class="form-group">
                <label for="lb_nombre" class="col-sm-3 control-label">Nombre:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="txt_presupuesto" name="txt_presupuesto" placeholder="Nombre de Presupuesto" onblur="aMayusculas(this.value, this.id);">
                </div>
            </div>

            <!-- Cliente-->
            <div class="form-group">
                <label for="lb_cliente" class="col-sm-3 control-label">Cliente:</label>
                <div class="col-sm-8">
                    <select id="slCliente_pret" name="slCliente_pret" class="form-control data" required="true">
                    </select>
                </div>
            </div>


            <!-- Subestacion-->
            <div class="form-group">
                <label for="lb_sub" class="col-sm-3 control-label">Subestacion:</label>
                <div class="col-sm-8">
                    <select id="slSubestacion" name="slSubestacion" class="form-control" required="true" onchange="AddSubestacion(this.value);">
                    </select>
                </div>
            </div>

            <!--Objetivo-->
            <div class="form-group">
                <label for="lb_objetivo" class="col-sm-3 control-label">Objeto OT:</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="txt_Objetivo" name="txt_Objetivo" rows="5" cols="40" placeholder="Objetivo del Proyecto"></textarea>
                </div>
            </div>

            <!--Alcance-->
            <div class="form-group">
                <label for="lb_alcance" class="col-sm-3 control-label">Alcance:</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="txt_alcance" name="txt_alcance" rows="5" cols="40" placeholder="Alcance del Proyecto por Modulos"></textarea>
                </div>
            </div>

            <?php
            if ($detallepresupuesto_id != 0) {
                ?>

                <div class="form-group">
                    <label for="lb_tot_pres" class="col-sm-3 control-label"></label>
                    <div class="col-sm-8">
                        <button id="subirDocumentos" name="subirDocumentos" class="btn btn-warning" type="" onclick="agregarDocumento()" style="color:black"><span class="glyphicon glyphicon-upload"></span><strong> Subir Documentos</strong></button>
                    </div>
                </div>

            <?php
        }
        ?>
        </div>



        <div class="col-sm-6">


            <!-- Gestor-->
            <div class="form-group">
                <label for="lb_gestor" class="col-sm-3 control-label">Gestor Proyecto:</label>
                <div class="col-sm-8">
                    <select id="slGestor" name="slGestor" class="form-control" required="true" onblur="enviar(this.value)">
                    </select>
                </div>
            </div>

            <!-- Gestor-->
            <div class="form-group">
                <label for="lb_PmCodensa" class="col-sm-3 control-label">PM Codensa:</label>
                <div class="col-sm-8">
                    <select id="slPmCodensa" name="slPmCodensa" class="form-control" required="true" onblur="enviar(this.value)">
                    </select>
                </div>
            </div>



            <!--Fecha inicio-->
            <div class="form-group">
                <label for="lb_inicio" class="col-sm-3 control-label">Fecha Inicio Presupuesto:</label>
                <div class="col-sm-8 input-group date" id='PresInicio' style="width:200px">
                    <input type='text' id="txtPresInicio" name="txtPresInicio" class="form-control" readonly />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>

            <!--Fecha fin -->
            <div class="form-group">
                <label for="lb_fin" class="col-sm-3 control-label">Fecha Fin Presupuesto:</label>
                <div class="col-sm-8 input-group date" id='PresFin' style="width:200px">
                    <input type='text' id="txtPresFin" name="txtPresFin" class="form-control" readonly />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>



            <!--TOTAL PRESUPUESTO-->
            <div class="form-group">
                <label for="lb_tot_pres" class="col-sm-3 control-label">Total Presupuesto sin incrementos: $</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control data" id="txt_tot_pres" name="txt_tot_pres" disabled="disabled" value="0" style="width:200px">
                </div>
            </div>


            <?php

            if ($detallepresupuesto_id != 0) {

                ?>


                <!--Porcentaje por ubicación-->
                <div class="form-group">
                    <label for="lb_tot_pres" class="col-sm-3 control-label">Incrementos por ubicación 3%</label>
                    <div class="col-sm-8">
                        <input type="checkbox" id="checkboxUbicacion" name="checkboxUbicacion" style="width: 20px; height: 20px"></input>
                        <input type="hidden" id="check" value="0"></input>
                        <input type="text" class="form-control data" id="incremento_ubicacion" name="txt_tot_pres" disabled="disabled" value="" style="width:179px">
                    </div>
                </div>



                <!-- Porcentaje pago 90 dias -->
                <div class="form-group">
                    <label for="lb_tot_pres" class="col-sm-3 control-label">Pago a 90 dias, 1.5%: $</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control data" id="incremento_90dias" disabled="disabled" value="" style="width:200px">
                    </div>
                </div>

                <!-- Total presupuesto con incrementos -->
                <div class="form-group">
                    <label for="lb_tot_pres" class="col-sm-3 control-label">Total presupuesto con incrementos: $</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control data" id="totalIncrementos" name="txt_tot_pres" disabled value="" style="width:200px">
                    </div>
                </div>

                <div class="form-group">
                    <label for="lb_tot_pres" class="col-sm-3 control-label"></label>
                    <div class="col-sm-8">
                        <button id="calcularIncrementos" name="calcularIncrementos" class="btn btn-success" type="" onclick="guardarIncrementos()" style="color:black"><span class="glyphicon glyphicon-floppy-save"></span><strong> Guardar Incrementos</strong></button>
                    </div>
                </div>


            <?php
        }
        ?>

        </div>



        <!--         Modulo
                    <div class="form-group">
                        <label for="lb_modulo" class="col-sm-3 control-label">Modulo:</label>
                        <div class="col-sm-8">                
                            <select id="slModulo" style="display: block" name="slModulo" class="form-control data" required="true" onchange="AddModulo(this.value);">
                            </select>
                            <input type="text" style="display: none" class="form-control data" id="txt_modulo" name="txt_modulo" placeholder="Nombre del Modulo" onblur="aMayusculas(this.value, this.id);">
                        </div>
                    </div>-->







        <!--Botones guardar-->
        <!-- <div class="form-group" id="btn_presupuesto_detalle">
            <div class="col-sm-offset-5 col-sm-7">
                <button id="btoGuardarPresupuesto" name="btoGuardarPresupuesto" class="btn btn-primary" type="submit" onclick="SavePresupuesto();">Guardar</button>
                <button type="button" class="btn btn-default" name="btnCancelar" id="btnCancelar" onclick="gritPresupuesto();">Cancelar</button>
            </div>
        </div> -->


        <div id="div_Add_actividades" style="display: none">
            <input type="hidden" class="form-control" id="presupuesto_id" name="presupuesto_id">
            <legend>Agregar Actividades</legend>


            <!--Modulo-->
            <div class="form-group">
                <label for="lb_modulo" class="col-sm-3 control-label">Módulo:</label>
                <div class="col-sm-8">
                    <select autofocus="" id="slModulo" stylegit="display: block" name="slModulo" class="form-control data" required="true" onchange="AddModulo(this.value);">
                    </select>
                    <input type="text" style="display: none" class="form-control data" id="txt_modulo" name="txt_modulo" placeholder="Nombre del Modulo" onblur="aMayusculas(this.value, this.id);">
                    <img src='img/atras.png' style="display: none" title='Atras' width='20' height='20' id='AtrasModulo' name='AtrasModulo' style='cursor:pointer' border='0' onclick='AddModulo("")'>
                </div>
            </div>

            <!--Tipo actividad-->
            <div class="form-group">
                <label for="lb_act" class="col-sm-3 control-label">Tipo Labor:</label>
                <div class="col-sm-8">
                    <select id="slTipActividad" name="slTipActividad" class="form-control" required="true">
                    </select>
                </div><img src='img/list.png' id='arbol' title='Listado de Baremos' width='30' height='30' style='cursor:pointer' border='0' onclick='DivInfoBaremos()'>
            </div>


            <!--ITEM-->
            <div class="form-group">
                <label for="lb_gom" class="col-sm-3 control-label">Numero Labor:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="search_item" name="search_item" placeholder="Numero Labor a buscar" onblur="aMayusculas(this.value, this.id);
                                dataBaremoItemPresupuesto(this.value)">
                </div>
            </div>

            <!--DESCRIPCION DE LA LABOR-->
            <div class="form-group" id="contenido_labor" style="display: none">
                <label for="lb_gom" class="col-sm-3 control-label">Labor:</label>
                <div class="col-sm-8" id="desc_labor">
                </div>
            </div>

            <div class="form-group" id="contenido_labor_valor" style="display: none">
                <label for="lb_gom" class="col-sm-3 control-label">Valor:</label>
                <div class="col-sm-8" id="valor_labor">
                </div>
            </div>



            <!--OBSERVACIONES-->
            <div class="form-group">
                <label for="lb_objetivo" class="col-sm-3 control-label">Alcance técnico particular:</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="txt_Obs" name="txt_Obs" rows="5" cols="40" placeholder="Directriz del cliente"></textarea>
                </div>
            </div>



            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-4">
                    <button name="btnListActividadesPre" id="btnListActividadesPre" class="btn btn-default" type="button" onclick="ListActividadesPresupuesto('<?php echo $detallepresupuesto_id ?>')">Atras</button>

                </div>
            </div>


            <!--tabla de la busqueda-->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div id="ActividadesPresupuesto"></div>
                </div>
            </div>

        </div>

        <!--actividades Agregadas-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div id="ActividadesPresupuestoAsignadas"></div>
            </div>
        </div>
    </fieldset>

</form>
<div id="div_alc_ent"></div>
<div id="div_info"></div>

</html>

<script type="text/javascript">
    var detallepresupuesto_id = '<?php echo $detallepresupuesto_id ?>';
    var jsonlsMd = ListModulo('slModulo');
    //console.log(jsonlsMd);
    var retorno = "<option value=''>-Seleccione-</option>";
    var retorno = "<option value='nuevo'>Nuevo Módulo</option>";
    $.each(jsonlsMd.MODULO, function(key, data) {

        retorno += '<option value="' + data.modulo_id + '">' + data.modulo_descripcion + '</option>';

    });
    //$("#slModulo").append('<option value="'+data.modulo_id+'">'+data.modulo_descripcion+'</option>');
    $("#slModulo").html(retorno);

    ListContratClien('slCliente_pret');
    ListSubestacion('slSubestacion');
    ListGestor('slGestor');
    ListTipBaremo('slTipActividad');
    ListarPmCodensa('slPmCodensa');


    if (detallepresupuesto_id != 0) {
        ListActividadesPresupuesto('<?php echo $detallepresupuesto_id ?>');
        JsonDetallePresupuesto('<?php echo $detallepresupuesto_id ?>');
        check();
    }
</script>
<script type="text/javascript">
    $(function() {
        $('#PresInicio').datetimepicker({
            //viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2016'

        });
        $('#PresFin').datetimepicker({
            //  viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2016'
        });

        $('#PresInicioAct').datetimepicker({
            // viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2016'

        });
        $('#PresFinAct').datetimepicker({
            //viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2016'
        });

        $.notifyDefaults({
            type: 'success',
            allow_dismiss: false
        });
        $.notify('Total Presupuesto con incremento: ' + $("#total_presupuesto_incremento").val());

    });
</script>