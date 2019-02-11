<?php
$dato = $_POST['dato'];
?>

<!DOCTYPE html>

<html lang="en">


    <form id="frm_DataSubestacion" class="form-horizontal">    
        <input type="hidden" class="form-control data" id="subestacion_id" name="subestacion_id">

        <fieldset>            


            <!-- codigo-->
            <div class="form-group">
                <label for="lb_codigo" class="col-sm-3 control-label">Codigo:</label>
                <div class="col-sm-5">                
                    <input type="text" class="form-control data" id="txt_cod_subestacion" name="txt_cod_subestacion" placeholder="Codigo Subestacion" required="true" onblur="aMayusculas(this.value, this.id);JsonSubestacion(this.value);">
                </div>
            </div>

            <!-- Nombre-->
            <div class="form-group">
                <label for="lb_nombre" class="col-sm-3 control-label">Nombre:</label>
                <div class="col-sm-5">                
                    <input type="text" class="form-control data" id="txt_nombre_subestacion" name="txt_nombre_subestacion" placeholder="Nombre Subestacion" style="width:300px" required="true" onblur="aMayusculas(this.value, this.id);">
                </div>
            </div>

            <!-- HICOM-->
            <div class="form-group">
                <label for="lb_hicom" class="col-sm-3 control-label">HICOM:</label>
                <div class="col-sm-5">                
                    <input type="text" class="form-control data" id="txt_hicom" name="txt_hicom" placeholder="HICOM" onblur="aMayusculas(this.value, this.id);">
                </div>
            </div>

            <!-- Ubicacion-->
            <div class="form-group">
                <label for="lb_ubicacion" class="col-sm-3 control-label">Ubicacion:</label>
                <div class="col-sm-5">                
                    <input type="text" class="form-control data" id="txt_ubicacion"  name="txt_ubicacion" placeholder="Direccion Subestacion">
                </div>
            </div>

            <!-- Telefono-->
            <div class="form-group">
                <label for="lb_telefono" class="col-sm-3 control-label">Telefono:</label>
                <div class="col-sm-5">                
                    <input type="text" class="form-control data" id="txt_tel_subestacion" name="txt_tel_subestacion" placeholder="Telefono Subestacion">
                </div>
            </div>

            <!-- Fax-->
            <div class="form-group">
                <label for="lb_fax" class="col-sm-3 control-label">Fax:</label>
                <div class="col-sm-5">                
                    <input type="text" class="form-control data" id="txt_fax" name="txt_fax" placeholder="FAX Subestacion">
                </div>
            </div>

            <div class="form-group">
                <label for="lb_iva_subestacion" class="col-sm-3 control-label">Aplica IVA:</label>
                <div class="col-sm-5">     
                    <select class="form-control" id="slIva_subestacion" name="slIva_subestacion" >
                        <option value="">-Seleccione-</option>
                        <option value="si">Si</option>
                        <option value="no">No</option> 
                    </select>
                </div>
            </div>

            </br>

        </fieldset>

    </form>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">
            <button id="btoGuardar_subestacion" name="btoGuardar_subestacion" class="btn btn-primary" type="submit" onclick="saveSubestacion()" >Guardar</button>
        </div>
    </div>

</html>
