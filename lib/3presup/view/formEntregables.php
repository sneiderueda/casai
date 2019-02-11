
<!DOCTYPE html>

<?php
$detalleactividad_id = $_POST['detallepresupuesto_id'];
$presupuesto_id = $_POST['presupuesto_id'];
?>
<html lang="en">


    <script>
        ListEntregablesAociadosActividad('<?php echo $detalleactividad_id ?>','<?php echo $presupuesto_id ?>');
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
            <input type="hidden" class="form-control data" id="detalleactividad_id" name="detalleactividad_id" value="<?php echo $detalleactividad_id; ?>">    
            <fieldset>            


                </br>
                <!--Lista de subactividades-->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">      
                        <div id="Alcances_tb"></div>      
                    </div>
                </div>



            </fieldset>



    </div>
</html>