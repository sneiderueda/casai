<?php
/*
  Autor:jennifer.cabiativa@gmail.com
 */


$detallepresupuesto_id = htmlspecialchars(strip_tags(trim($_POST['data'])));
$ot = htmlspecialchars(strip_tags(trim($_POST['ot'])));
?>

<!DOCTYPE html>

<html lang="en">

    </br>
    <button name="btnListPres" id="btnListPres" class="btn btn-default" type="button" onclick="gritPresupuestoOT()">Mostrar listado</button>
    </br>
    </br>
    <form id="frm_DataOrdenTrabajo" class="form-horizontal">    
        <input type="hidden" class="form-control" id="detallepresupuesto_id" name="detallepresupuesto_id">                                    
        <fieldset>
            <legend>Datos Presupuesto</legend>  

            <div class="col-sm-6">
                <!-- Presupuesto-->
                <div class="form-group">
                    <label for="lb_nombre" class="col-sm-3 control-label">Nombre:</label>
                    <div class="col-sm-8">                
                        <input type="text" class="form-control" id="txt_Otpresupuesto" name="txt_Otpresupuesto" disabled="disabled">
                    </div>
                </div>

                <!-- Cliente-->
                <div class="form-group">
                    <label for="lb_cliente" class="col-sm-3 control-label">Cliente:</label>
                    <div class="col-sm-8">                
                        <select id="slCliente_OT" name="slCliente_OT" class="form-control" disabled="disabled">
                        </select>
                    </div>
                </div>

                <!-- Subestacion-->
                <div class="form-group">
                    <label for="lb_sub" class="col-sm-3 control-label">Subestacion:</label>
                    <div class="col-sm-8">                
                        <select id="slSubestacionOT" name="slSubestacionOT" class="form-control"  disabled="disabled">
                        </select>                
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <!-- Subtotal-->
                <div class="form-group">
                    <label for="lb_sub" class="col-sm-3 control-label">Subtotal:</label>
                    <div class="col-sm-8"> 
                        <input type="text" class="form-control" id="subtotal_pt" name="subtotal_pt" disabled="disabled">            
                    </div>
                </div>

                <!-- Valor IVA -->
                <div class="form-group">
                    <label for="lb_sub" class="col-sm-3 control-label">Valor IVA:</label>
                    <div class="col-sm-8"> 
                        <input type="text" class="form-control" id="iva_pt" name="iva_pt" disabled="disabled">                  
                    </div>
                </div>

                <!-- Total-->
                <div class="form-group">
                    <label for="lb_sub" class="col-sm-3 control-label">Total:</label>
                    <div class="col-sm-8"> 
                        <input type="text" class="form-control" id="total_pt" name="total_pt" disabled="disabled">    

                    </div>
                </div>
            </div>



            <input type="hidden" class="form-control" id="ot_id" name="ot_id" value="<?php echo $ot; ?>">    
            <legend>Orden de Trabajo y Cronograma</legend>  

            <div class="col-sm-6">
                <!--NUMERO OT-->
                <div class="form-group">
                    <label for="lb_numero" class="col-sm-3 control-label">No. Orden:</label>
                    <div class="col-sm-8">                
                        <input type="text" class="form-control date" id="txt_num_orden" name="txt_num_orden" placeholder="Numero de la Orden" required="true" onblur="aMayusculas(this.value, this.id);">
                    </div>
                </div>

                <!--ORDEN GOM-->
                <div class="form-group">
                    <label for="lb_numero" class="col-sm-3 control-label">Orden GOM:</label>
                    <div class="col-sm-8">                
                        <input type="text" class="form-control date" id="txt_orden_gom" name="txt_orden_gom" placeholder="Orden GOM" onblur="aMayusculas(this.value, this.id);">
                    </div>
                </div>


                <!--CONTRATISTA-->
                <div class="form-group">
                    <label for="lb_contratista" class="col-sm-3 control-label">Contratista:</label>
                    <div class="col-sm-8">                
                        <input type="text" class="form-control date" id="txt_contratista" name="txt_contratista" placeholder="Nombre del Contratista" required="true" value="AC ENERGY" onblur="aMayusculas(this.value, this.id);">
                    </div>
                </div>


                <!--DETALLE-->
                <div class="form-group">
                    <label for="lb_detalle" class="col-sm-3 control-label">Nombre del proyecto:</label>
                    <div class="col-sm-8">  
                        <textarea class="form-control date"  id="txt_detalle" name="txt_detalle"rows="5" cols="40" required="true" placeholder="Detalle de la Orden de Trabajo" ></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <!--DETALLE-->
                <div class="form-group">
                    <label for="lb_detalle" class="col-sm-3 control-label">Orden Presupuestal:</label>
                    <div class="col-sm-8">  
                        <input type="text" class="form-control date" id="txt_orden_presupuestal" name="txt_orden_presupuestal" placeholder="Orden Presupuestal" onblur="aMayusculas(this.value, this.id);" style="width:300px">
                    </div>
                </div>

                <!--PEP-->
                <div class="form-group">
                    <label for="lb_pep" class="col-sm-3 control-label">PEP:</label>
                    <div class="col-sm-8">  
                        <input type="text" class="form-control date" id="txt_pep" name="txt_pep" placeholder="PEP" onblur="aMayusculas(this.value, this.id);" style="width:300px">
                    </div>
                </div>

                <!--Fecha Emision-->
                <div class="form-group">
                    <label for="lb_emision" class="col-sm-3 control-label">Fecha Emision OT:</label>
                    <div class="col-sm-8 input-group date" id='FechaEmision' style="width:200px" >                
                        <input type='date' id="txtFechaEmision" name="txtFechaEmision"  required="true" class="form-control date"  />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
                    </div>
                </div>

                <!--Fecha Inicio -->
                <div class="form-group">
                    <label for="lb_ini" class="col-sm-3 control-label">Fecha Inicio OT:</label>
                    <div class="col-sm-8 input-group date" id='FechaInicio'  style="width:200px">                
                        <input type="date" id="txtPresInicioOT" name="txtPresInicioOT"  required="true" class="form-control date" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
                    </div>
                </div>

                <!--Fecha fIN -->
                <div class="form-group">
                    <label for="lb_ini" class="col-sm-3 control-label">Fecha Fin OT:</label>
                    <div class="col-sm-8 input-group date" id='FechaFin'  style="width:200px">                
                        <input type="date" id="txtPresFinOT" name="txtPresFinOT"  required="true" class="form-control date" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
                    </div>
                </div>
            </div>


            <!--Botones guaradr-->
            <div class="form-group">
                <div class="col-sm-offset-5 col-sm-7">
                    <button id="btoGuardarOT" name="btoGuardarOT" class="btn btn-primary" type="submit" onclick="SaveOT();" >Guardar</button>                
                    <button type="button" class="btn btn-default" name="btnCancelar" id="btnCancelar" onclick="gritPresupuestoOT();">Cancelar</button>
                </div>
            </div>


            <!--tabla de la busqueda-->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">      
                    <div id="ActividadesPresupuestoOT"></div>      
                </div>
            </div>

            <!--actividades Agregadas-->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">      
                    <div id="ActividadesPresupuestoAsignadasOT"></div>
                </div>
            </div>

            <!--            <legend>Descargar</legend>        
                        <button type="button" class="btn btn-default" name="btnxlsx" id="btnxlsx" onclick="DescargarPresupuestoXlsx();">Reporte Excel</button>
                        <button type="button" class="btn btn-default" name="btnword" id="btnword" onclick="">Reporte Word</button>-->

        </fieldset>
        <div id="programar_OT"></div>
        <div id="Gen_Descargo"></div>
    </form>
</html>
<script type="text/javascript">
    var detallepresupuesto_id = '<?php echo $detallepresupuesto_id; ?>';
    ListContratClien('slCliente_OT');
    ListSubestacion('slSubestacionOT');

    if (detallepresupuesto_id != 0) {
        ListActividadesPresupuestoOT('<?php echo $detallepresupuesto_id; ?>');
        JsonDetallePresupuesto('<?php echo $detallepresupuesto_id; ?>', '1');
        JsonDetalleOT('<?php echo $detallepresupuesto_id; ?>');
    }


    $(function () {
        $('#FechaEmision').datetimepicker({
            // viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2017'

        });

        $('#FechaInicio').datetimepicker({
            // viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2017'

        });
        $('#FechaFin').datetimepicker({
            // viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2017'

        });

    });


</script>