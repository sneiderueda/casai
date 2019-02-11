<?php
/*
  Autor:jennifer.cabiativa@gmail.com
 */


$presupuesto_id = htmlspecialchars(strip_tags(trim($_POST['pt'])));
$seguimiento_id = htmlspecialchars(strip_tags(trim($_POST['sg'])));
$detallepresupuesto_id = htmlspecialchars(strip_tags(trim($_POST['dp'])));
?>
<html lang="en">


    <style>
        textarea{resize:none;}

        label.error {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }
    </style>


    <div id="Div_NoFacturar">
        <form id="frm_NoFacturar" class="form-horizontal">    
            <input type="hidden" class="form-control data" id="seguimiento_id" name="seguimiento_id" value="<?php echo $seguimiento_id; ?>">    
            <input type="hidden" class="form-control data" id="presupuesto_id" name="presupuesto_id" value="<?php echo $presupuesto_id; ?>">    
            <input type="hidden" class="form-control data" id="detallepresupuesto_id" name="detallepresupuesto_id" value="<?php echo $detallepresupuesto_id; ?>">    
            <fieldset>            
                <div class="form-group">
                    <label for="lb_rieso" class="col-sm-3 control-label">Revisión:</label>                  
                    <div class="col-sm-5">  
                        <input type="text" class="form-control date" onblur="aMayusculas(this.value, this.id);" id="txt_revision" name="txt_revision" style="width:300px" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="lb_descargo_act" class="col-sm-3 control-label">Observaciones:</label>
                    <div class="col-sm-5">  
                        <textarea class="form-control" style="width:300px" id="txt_des_act" name="txt_des_act" rows="5" cols="40" required="true" placeholder="Motivo por el cual esta actividad no se puede facturar." ></textarea>
                    </div>
                </div>




            </fieldset>

        </form>
        <!--Botones guaradr-->
        <div class="form-group">
            <div>

                <center><button id="btoGuardarDescargo" name="btoGuardarDescargo" class="btn btn-primary" type="submit" onclick="SaveActividadNoFacturar();" >No Facturar</button><button id="btoGuardarDescargo" name="btoGuardarDescargo" class="btn btn-danger" type="submit" onclick="cerrarNoFactura('<?php echo $presupuesto_id; ?>');" >Cancelar</button>                </center>

            </div>
        </div>
    </div>
</html>