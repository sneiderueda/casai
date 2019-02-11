<?php
/*
  Autor:jennifer.cabiativa@gmail.com
 */


$entregable_id = htmlspecialchars(strip_tags(trim($_POST['data'])));
?>

</br>
<button name="btnList" id="btnList" class="btn btn-default" type="button" onclick="gritEntregable()">Mostrar listado</button>
</br>
</br>
<form id="frm_DataEntregable" class="form-horizontal">    
    <input type="hidden" class="form-control data" id="ent_id" name="ent_id">                
    <fieldset>
        <legend>Descripcion del Entregable</legend>

        <!--Alcance-->
        <div class="form-group">
            <label for="lb_etregable" class="col-sm-3 control-label">Entregable:</label>
            <div class="col-sm-5">  
                <textarea class="form-control data"  id="txt_entregable" name="txt_entregable"rows="5" cols="40" placeholder="Descripcion del Entregable" ></textarea>
            </div>
        </div>
        
        <!--Botones-->
        <div class="form-group" id="btn_saveLaborBaremo">
            <div class="col-sm-offset-4 col-sm-4">
                <button id="btoGuardar" name="btoGuardar" class="btn btn-primary" type="submit" onclick="SaveEntregable()" >Guardar</button>                
                <button type="button" class="btn btn-default" name="btnCancelar" id="btnCancelar" onclick="gritEntregable();">Cancelar</button>
            </div>
        </div>

    </fieldset>

</form>

<script type="text/javascript">
    var id_entregable =<?php echo $entregable_id; ?>;
    if (id_entregable != "0") {
        
        var jsonDataEntregable = JsonDataEntregable(id_entregable);
        $("#txt_entregable").val(jsonDataEntregable.entregable_descripcion);
        $("#ent_id").val(jsonDataEntregable.entregable_id);

    }

</script>