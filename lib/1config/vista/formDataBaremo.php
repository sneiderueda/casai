<?php
/*
  Autor:jennifer.cabiativa@gmail.com
 */


$baremo_id = htmlspecialchars(strip_tags(trim($_POST['data'])));
?>

<script type="text/javascript">
    var bm = '<?php echo $baremo_id ?>';

    ListTipBaremo('slTip');
    ListClient('slCliente');


    if (bm != 0) {
       
        ListActividadesBaremo('<?php echo $baremo_id ?>');
        JsonBaremoId('<?php echo $baremo_id ?>');
        
    }

</script>

</br>
<button name="btnListUser" id="btnListUser" class="btn btn-default" type="button" onclick="gritBaremos()">Mostrar listado</button>
</br>
</br>
<form id="frm_DataBaremo" class="form-horizontal">    
    <input type="hidden" class="form-control data" id="bm_id" name="bm_id">                
    <input type="hidden" class="form-control data" id="contrato_id" name="contrato_id">                
    <fieldset>
        <legend>Datos Baremo</legend>

        <!-- Cliente-->
        <div class="form-group">
            <label for="lb_cliente" class="col-sm-3 control-label">Cliente:</label>
            <div class="col-sm-5">                
                <select id="slCliente" name="slCliente" class="form-control data" required="true"  onblur="ListContrato('slContrato')">
                </select>
            </div>
        </div>
        
        <!-- Contrato-->
        <div class="form-group">
            <label for="lb_cliente" class="col-sm-3 control-label">Contrato:</label>
            <div class="col-sm-5">                
                <select id="slContrato" name="slContrato" class="form-control data" required="true">
                </select>
            </div>
        </div>

        <!-- Tipo de Baremo-->
        <div class="form-group">
            <label for="lb_tipo" class="col-sm-3 control-label">Tipo Labor:</label>
            <div class="col-sm-5">                
                <select id="slTip" name="slTip" class="form-control data" required="true">
                </select>
            </div>
        </div>

        <!-- Item del Baremo-->
        <div class="form-group">
            <label for="lb_item" class="col-sm-3 control-label">Numero Labor:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_item" name="txt_item" placeholder="Item del Baremo" required="true" onblur="aMayusculas(this.value, this.id);
                        JsonBaremoClientTip(this.value);">                
            </div>
        </div>

        <!--labor-->
        <div class="form-group">
            <label for="lb_labor" class="col-sm-3 control-label">Labor:</label>
            <div class="col-sm-5">  
                <textarea class="form-control data"  id="txt_labor" name="txt_labor"rows="5" cols="40" placeholder="Descripcion de la Labor" ></textarea>
<!--                <input type="text" class="form-control data" id="txt_labor" name="txt_labor" placeholder="Descripcion de la Labor" >                -->
            </div>
        </div>

        <!--unidad de medida-->
        <div class="form-group">
            <label for="lb_medida" class="col-sm-3 control-label">Unidad de medida:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_medida" name="txt_medida" placeholder="Unidad de Medida">                
            </div>
        </div>

        <!--Costo unidad de servicio-->
        <div class="form-group">
            <label for="lb_servicioTot" class="col-sm-3 control-label">Costo Unidad Servicio:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_servicioTot" name="txt_servicioTot" placeholder="Costo Unidad de Servicio" required="true" >                
            </div>
        </div>

        <!--Costo de la actividad-->
        <div class="form-group">
            <label for="lb_total" class="col-sm-3 control-label">Suma de los Costos Asociados a la Labor ($):</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_totalAct" name="txt_totalAct" placeholder="Costo Total de Actividades" required="true" onkeypress="return numeros(event)">                
            </div>
        </div>

        <!--Valor sin Iva-->
        <div class="form-group">
            <label for="lb_totalSinIva" class="col-sm-3 control-label">Valor Antes IVA ($):</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_totalSinIva" name="txt_totalSinIva" placeholder="Costo Total sin IVA" required="true" onkeypress="return numeros(event)">                
            </div>
        </div>

        <!--Botones guaradr labor y baremo-->
        <div class="form-group" id="btn_saveLaborBaremo">
            <div class="col-sm-offset-4 col-sm-4">
                <button id="btoGuardar" name="btoGuardar" class="btn btn-primary" type="submit" onclick="SaveLaborBaremo()" >Guardar</button>                
                <button type="button" class="btn btn-default" name="btnCancelar" id="btnCancelar" onclick="gritBaremos();">Cancelar</button>
            </div>
        </div>

        <div id="div_baremo" style="display: none">
            <input type="hidden" class="form-control" id="act_id" name="act_id">  
            <legend>Datos de las Actividades</legend>

            <!--Descripcion-->
            <div class="form-group">
                <label for="lb_act" class="col-sm-3 control-label">Actividad:</label>
                <div class="col-sm-5">    
                    <textarea id="txt_act" name="txt_act" rows="5" cols="40" placeholder="Descripcion de la Actividad" required="true" style="width: 363px; height: 92px;"></textarea>
<!--                    <input type="text" class="form-control" id="txt_act" name="txt_act" placeholder="Descripcion de la Actividad" required="true">                -->
                </div>
            </div>

            <!--GOM-->
            <div class="form-group">
                <label for="lb_gom" class="col-sm-3 control-label">Código GOM:</label>
                <div class="col-sm-5">                
                    <input type="text" class="form-control" id="txt_gom" name="txt_gom" placeholder="Código GOM" onblur="aMayusculas(this.value, this.id);">                
                </div>
            </div>

            <!--unidad de servicio-->
            <div class="form-group">
                <label for="lb_servicio" class="col-sm-3 control-label">Costo de la Actividad en Unidades de Servicio:</label>
                <div class="col-sm-5">                
                    <input type="text" class="form-control" id="txt_servicioAct" name="txt_servicioAct" placeholder="Costo Unidad de servicio" required="true" onkeypress="return numeros(event)">                
                </div>
            </div>

            <!--Valor de la actividad-->
            <div class="form-group">
                <label for="lb_act_valor" class="col-sm-3 control-label">Costo de la Actividad en Pesos Antes de IVA:</label>
                <div class="col-sm-5">                
                    <input type="text" class="form-control" id="txt_act_valor" name="txt_act_valor" placeholder="Valor en Pesos año actual" required="true" onkeypress="return numeros(event)">                
                </div>
            </div>

            <!--Botones Guardar actividades-->
            <div class="form-group" id="btn_saveActBaremo">
                <div class="col-sm-offset-4 col-sm-4">
                    <button type="button" name="btnAddActBaremo" id="btnAddActBaremo" class="btn btn-default btn-xs" onclick="AddActividadBaremo();
                            CountFilasTabla('ActividadBm', 'txt_actBm')"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Adicionar</button>
                </div>
            </div>

            <!--Botones Guardar actividades-->
            <div class="form-group" id="btn_UpdateActBaremo" style="display: none">
                <div class="col-sm-offset-4 col-sm-4">
                    <button type="button" name="btnUpdateActBaremo" id="btnUpdateActBaremo" class="btn btn-default btn-xs" onclick="UpdateActividadBaremo();"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Modificar</button>
                </div>
            </div>
            <!--Actividades Agregadas-->
            <!--            <div class="form-group">
                            <div id="tableActividadBaremo" class="col-sm-offset-2 col-sm-6">
            
                                <table border="0" cellpadding="0" cellspacing="0" class="table table-hover">
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>   
                                    <td colspan="3" align="center"> 
                                        <table class="table table-bordered table-striped" id="tb_actividades"  style="font-size:11px">
            
                                            <thead>
                                                <tr>
                                                    <th>Accion</th>
                                                    <th>Actividad</th>
                                                    <th>Costo sin IVA</th>
                                                </tr>
                                            </thead>
                                            <tbody id="ActividadBm">
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="txt_actBm" id="txt_actBm" value="0"> 
                                    </td>
            
                                </table>                    
                            </div>
                        </div>-->

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">      
                    <div id="ActividadesBm"></div>      
                </div>
            </div>
        </div>








    </fieldset>
    <div id="md_sub"></div>
</form>
