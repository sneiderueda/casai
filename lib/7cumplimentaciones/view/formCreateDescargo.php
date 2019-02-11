<?php
$dato=$_POST['dato'];
?>
<!DOCTYPE html>

<html lang="en">

<form id="frm_DataBaremo" class="form-horizontal">    
    <input type="hidden" class="form-control data" id="bm_id" name="bm_id">                
    <fieldset>
        <!--Descargo-->
        <div class="form-group">
            <label for="lb_descripcion" class="col-sm-3 control-label">Descripcion:</label>
            <div class="col-sm-5">  
                <textarea class="form-control data"  id="txt_descripcion" name="txt_descripcion" rows="5" cols="40" placeholder="Descripcion del descargo" onblur="aMayusculas(this.value, this.id);"></textarea>
            </div>
        </div>
        <!--Botones Guardar tipo descargo-->
        <div class="form-group" id="btn_saveActBaremo">
            <div class="col-sm-offset-4 col-sm-4">
                <button type="button" name="btnAddAcDescargo" id="btnAddAcDescargo" class="btn btn-default btn-xs" onclick="saveTipoDescargo();"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Guardar</button>
            </div>
        </div>
    </fieldset>
</form>
</html>