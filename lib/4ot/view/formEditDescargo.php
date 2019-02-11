<?php
/*
  Autor:jennifer.cabiativa@gmail.com
 */


$orden_trabajo_id = htmlspecialchars(strip_tags(trim($_POST['orden_trabajo_id'])));
$presupuesto_id = htmlspecialchars(strip_tags(trim($_POST['presupuesto_id'])));
?>



    <script>
        var JSDescargo = JsonDescargoOT('<?php echo $orden_trabajo_id ?>', '<?php echo $presupuesto_id ?>');
        $("#txt_des_act").val(JSDescargo.descargo_actividad);
        $("#txt_respo_codensa").val(JSDescargo.descargo_codensa);

        if (JSDescargo.descargo_tipo == 'Proxi') {
            $("#rd_proxi").attr('checked', true);
        } else {
            $("#rd_vyp").attr('checked', true);
        }
        

        if (JSDescargo.descargo_riesgo == 'No') {
            $("#rd_riesgo_no").attr('checked', true);
        } else if (JSDescargo.descargo_riesgo == 'Si bajo') {
            $("#rd_bajo").attr('checked', true);
        } else if (JSDescargo.descargo_riesgo == 'Si alto') {
            $("#rd_alto").attr('checked', true);
        } else {
            $("#rd_riesgo_no").attr('checked', true);
        }
        
        if(JSDescargo.descargo_preipoanexo=='Si'){
            $("#rd_anexo_si").attr('checked', true);
        }else{
            $("#rd_requiere").attr('checked', true);
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

        <div id="Div_Descargo">
            <form id="frm_descargo" class="form-horizontal">    
                <input type="hidden" class="form-control data" id="ordentrabajo_id" name="ordentrabajo_id" value="<?php echo $orden_trabajo_id; ?>">    
                <input type="hidden" class="form-control data" id="presupuesto_id" name="presupuesto_id" value="<?php echo $presupuesto_id; ?>">    
                <fieldset> 


                    <div class="form-group" style="margin-right: -188px; margin-left: -1px;">
                        <label for="lb_rieso" class="col-sm-3 control-label">Tipo Descargo:</label>                  
                        <div class="col-sm-5">  
                            <input type="radio" name="rd_tipoDescargo" id="rd_proxi" value="Proxi" checked> Proxi &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="rd_tipoDescargo" id="rd_vyp" value="VyP"> VyP
                        </div>
                    </div>

                    <div class="form-group" style="margin-right: -188px; margin-left: -1px;">
                        <label for="lb_rieso" class="col-sm-3 control-label">Riesgo de Disparo:</label>                  
                        <div class="col-sm-5">  
                            <input type="radio" name="rd_Disparo" id="rd_riesgo_no" value="No" checked> No &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="rd_Disparo" id="rd_bajo" value="Si bajo"> Sí, bajo  &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="rd_Disparo" id="rd_alto" value="Si alto"> Sí, alto
                        </div>
                    </div>

                    <div class="form-group" style="margin-right: -188px; margin-left: -1px;">
                        <label for="lb_rieso" class="col-sm-3 control-label">PRE-IPO ANEXO:</label>                  
                        <div class="col-sm-5">  
                            <input type="radio" name="rd_anexo" id="rd_anexo_si" value="Si" checked> Si &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="rd_anexo" id="rd_requiere" value="No requiere"> No requiere  

                        </div>
                    </div>

                    <div class="form-group" style="margin-right: -188px; margin-left: -1px;">
                        <label for="lb_rieso" class="col-sm-3 control-label">Responsable CODENSA:</label>                  
                        <div class="col-sm-5">  
                            <input type="text" class="form-control date" id="txt_respo_codensa" name="txt_respo_codensa" placeholder="NOMBRE" required="true" onblur="aMayusculas(this.value, this.id);">
                        </div>
                    </div>

                    <div class="form-group" style="margin-right: -188px; margin-left: -1px;">
                        <label for="lb_descargo_act" class="col-sm-3 control-label">Actividad a realizar:</label>
                        <div class="col-sm-5">  
                            <textarea class="form-control"  id="txt_des_act" name="txt_des_act" rows="5" cols="40" required="true" placeholder="Actividad a Realizar" ></textarea>
                        </div>
                    </div>


                    <!--Botones guarad-->                   
                    <div class="form-group" style="margin-right: -188px; margin-left: -1px;">
                        <div class="col-sm-offset-4 col-sm-4">
                            <button id="btoGuardarDescargo" name="btoGuardarDescargo" class="btn btn-primary" type="submit" onclick="SaveDescargo();" >Generar Descargo</button>                
                            <!--<button type="button" class="btn btn-default" name="btnCancelar" id="btnCancelar" onclick="gritPresupuestoOT();">Cancelar</button>-->
                        </div>
                    </div>


                </fieldset> 

            </form>
            <!--                    <button id="btoGuardarDescargo" name="btoGuardarDescargo" class="btn btn-primary" type="submit" onclick="DescargarDescargo();" >Word</button> -->
        </div>

