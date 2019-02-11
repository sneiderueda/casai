
<!DOCTYPE html>

<?php
$actividad_id = $_POST['actividad_id'];
$actividad_costo = $_POST['costo_actividad'];
$baremoactividad_id = $_POST['baremoactividad_id'];
$resultPorc = $_POST['resultPorc'];
$contrato_id = $_POST['contrato_id'];
?>
<html lang="en">
 <script src="lib/1config/js/baremos.js"></script> 

    <script>


        var porcentaje = '<?php echo $resultPorc ?>';

        ListSubactividadesBm('<?php echo $baremoactividad_id ?>', '<?php echo $actividad_id ?>','<?php echo $contrato_id ?>');

        if (porcentaje == 1 || porcentaje == "1") {
            alert("Ya no se puede asignar  mas subactividades a esta actividad todas las subactividades ya suman el 100%.");
            $("#div_saveLaborBaremo").css("display", "none");
        } else {

            $("#div_saveLaborBaremo").css("display", "block");
        }



    </script>

    <style>
        textarea{resize:none;}

        label.error {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }
    </style>

    <style>
        .custom-combobox {
            position: relative;
            display: inline-block;
        }
        .custom-combobox-toggle {
            position: absolute;
            top: 0;
            bottom: 0;
            margin-left: -1px;
            padding: 0;
            /* support: IE7 */
            height: 1.8em;
            top: 0.1em;
        }
        .custom-combobox-input {
            margin: 0;
            padding: 0.3em;
        }
    </style>
    <div id="configAlcanceEntregable" style="display: none"></div>
    <div id="contenido_subactividad" style="display: block">
        <form id="frm_DataBaremo" class="form-horizontal">    
            <input type="hidden" class="form-control data" id="act_id_sub" name="act_id_sub" value="<?php echo $actividad_id; ?>">                
            <input type="hidden" class="form-control data" id="act_cot" name="act_cot" value="<?php echo $actividad_costo; ?>">                
            <input type="hidden" class="form-control data" id="sub_id" name="sub_id" value="">                
            <input type="hidden" class="form-control data" id="baremoactividad_id" name="baremoactividad_id" value="<?php echo $baremoactividad_id; ?>">                
            <input type="hidden" class="form-control data" id="valor_actividad_decimal" name="valor_actividad_decimal" value="">                
            <input type="hidden" class="form-control data" id="contrato_id" name="contrato_id" value="<?php echo $contrato_id; ?>">                
            <fieldset>            

                <!-- subactividades creadas-->
                <!--                <div class="form-group">
                                    <label for="lb_sub" class="col-sm-3 control-label">Subactividades:</label>
                                    <div class="col-sm-5">                
                                        <select id="combobox" name="combobox" class="form-control data" style="width:300px">
                                        </select><input aling type="button" class="btn" name="agre" value="Ok" onClick="DataProductor('2')"/>
                
                                    </div>
                                </div>-->


                <!-- Descripcion-->

                <div class="form-group">
                    <label for="lb_descSub" class="col-sm-3 control-label">Descripcion:</label>
                    <div class="col-sm-5">                
                        <input type="text" class="form-control data" id="txt_sub" name="txt_sub" placeholder="Descripcion de la Subactividad" required="true" onblur="aMayusculas(this.value, this.id);" >                
                    </div>
                </div>


                <!--Porcentaje de la subactividad-->
                <div class="form-group">
                    <label for="lb_porcentaje" class="col-sm-3 control-label">Porcentaje de la Subactividad:</label>
                    <div class="col-sm-5">                
                        <input type="text"  class="form-control data" maxlength="3" id="txt_porc_sub" name="txt_porc_sub" placeholder="Ingrese el procentaje de la subactividad" required="true" onkeypress="return decimales(event)" onblur="CalValorPorc(this.value);">                
                    </div>
                </div>

                <!--Valor sin Iva-->
                <div class="form-group">
                    <label for="lb_totalSinIvaSub" class="col-sm-3 control-label">Costo Total sin IVA:</label>
                    <div class="col-sm-5">                
                        <input type="text" class="form-control data" id="txt_totalSinIvaSub" name="txt_totalSinIvaSub" placeholder="Costo Total sin IVA" required="true" onkeypress="return numeros(event)" >                
                    </div>
                </div>


                <!--Botones guaradr-->
                <div  id="div_saveLaborBaremo" style="display: none">
                    <div class="col-sm-offset-4 col-sm-4">
                        <button id="btoGuardar" name="btoGuardar" class="btn btn-primary" type="submit" onclick="SaveSubactividad()" >Guardar</button>
                    </div>
                </div>
                </br></br></br>
                <!--Lista de subactividades-->
                <!--                <div class="form-group">
                                    <div id="tableSubactividad" class="col-sm-offset-2 col-sm-6">
                
                                        <table class="table table-bordered table-striped" style="font-size:11px">
                
                                            <thead>
                                                <tr>
                                                    <th>Accion</th>
                                                    <th>Subactividad</th>
                                                    <th>Porcentaje</th>
                                                    <th>Costo sin IVA</th>
                                                    <th>Entregables</th>
                                                    <th>Alcances</th>
                                                </tr>
                                            </thead>
                                            <tbody id="SubactividadBm">
                                            </tbody>
                                        </table>                            
                
                
                
                                    </div>
                                </div>-->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">      
                        <div id="SubactividadBm"></div>      
                    </div>
                </div>
            </fieldset>

        </form>

    </div>
</html>