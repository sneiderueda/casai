<?php
/*
  Autor:jennifer.cabiativa@gmail.com
 */


$alcance_id = htmlspecialchars(strip_tags(trim($_POST['data'])));
?>

</br>
<button name="btnList" id="btnList" class="btn btn-default" type="button" onclick="gritAlcance()">Volver</button>
</br>
</br>
<form id="frm_DataAlcance" class="form-horizontal">    
    <input type="hidden" class="form-control data" id="alc_id" name="alc_id">                
    <fieldset>
        <legend>Alcance Baremado</legend>

        <!--Alcance-->
        <div class="form-group">
            <label for="lb_alcance" class="col-sm-3 control-label">Descripción:</label>
            <div class="col-sm-5">  
                <textarea class="form-control data"  id="txt_alcance" name="txt_alcance"rows="5" cols="40" placeholder="Descripcion del Alcance Baremado" ></textarea>
            </div>
        </div>
        
        <!--Botones-->
        <div class="form-group" id="btn_saveLaborBaremo">
            <div class="col-sm-offset-4 col-sm-4">
                <button id="btoGuardar" name="btoGuardar" class="btn btn-primary" type="submit" onclick="SaveAlcance()" >Guardar</button>                
                <button type="button" class="btn btn-default" name="btnCancelar" id="btnCancelar" onclick="gritAlcance();">Cancelar</button>
            </div>
        </div>

    </fieldset>

</form>

<script type="text/javascript">
    var id_alcance =<?php echo $alcance_id; ?>;
    if (id_alcance != "0") {
        
        var jsonDataAlcance = JsonDataAlcance(id_alcance);
        $("#txt_alcance").val(jsonDataAlcance.alcance_descripcion);
        $("#alc_id").val(jsonDataAlcance.alcance_id);

    }

</script>