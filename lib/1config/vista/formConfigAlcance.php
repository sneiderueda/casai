
<!DOCTYPE html>

<?php
$detalleactividad_id = $_POST['data_id'];
$data_cont = $_POST['data_cont'];
?>
<html lang="en">


    <script>
        ListAlcanceSubactividades('<?php echo $detalleactividad_id ?>','<?php echo $data_cont ?>');
        SelectAlcance('combobox_al');
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

   
    <div id="Div_Alcance">
        <form id="frm_AlcanceSub" class="form-horizontal">    
            <input type="hidden" class="form-control data" id="detalleactividad_id" name="detalleactividad_id" value="<?php echo $detalleactividad_id; ?>">    
            <input type="hidden" class="form-control data" id="contrato_id" name="contrato_id" value="<?php echo $data_cont; ?>">    
            <fieldset>            

                <!-- subactividades creadas-->
                <div class="form-group">
                    <label for="lb_sub" class="col-sm-1 control-label">Alcances:</label>
                    <div class="col-sm-5">                
                        <select id="combobox_al" name="combobox_al" class="form-control data" style="width:650px">
                        </select><input aling type="button" class="btn" name="agre" value="Agregar" onClick="SaveAlcanceSubactividad();"/>
                        <input aling type="button" class="btn" name="atras" value="Atras" onClick="DivSubactividadesAlcanceEntregable();"/>

                    </div>
                </div>


                </br>
                <!--Lista de subactividades-->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">      
                        <div id="Alcances"></div>      
                    </div>
                </div>



            </fieldset>

        </form>

    </div>
</html>