<?php
/*
  Autor:jennifer.cabiativa@gmail.com
 */


  $cliente_id = htmlspecialchars(strip_tags(trim($_POST['data'])));
?>

<script>
    //traer data del usuario
    var cliente_id =<?php echo $cliente_id; ?>;
    if (cliente_id != "0") {

        //mostrar los datos del usuario
        var GetJsonDataClient = JsonDataClient(cliente_id);
        $("#txt_name").val(GetJsonDataClient.cliente_descripcion);
        $("#txt_PID").val(GetJsonDataClient.cliente_pid);
    }

    //Mostrar los contratos activos de los cliente
    ListContractsClient(<?php echo $cliente_id; ?>);
    
    var htmlMessage = '<div class="alert alert-warning alert-dismissible" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">X</span></button>' +
            '<h4>Aviso!</h4>' +
            'Hay información en el formulario sin diligenciar por favor completarla' +
            '</div>';
    $('#frm_DataGeneral').validate({
        rules: {
            txt_name: {required: true},
            txt_PID: {required: true}

        },
        messages: {
        },
        debug: true,
        invalidHandler: function() {

            //alert('Hay información en el formulario sin diligenciar por favor completarla');
            $("#messageDataUser").html(htmlMessage);
            return false;
        },
        submitHandler: function(form) {
            saveClient(<?php echo $cliente_id; ?>);
        }
    });

</script>
</br>
<button name="btnListUser" id="btnListUser" class="btn btn-default" type="button" onclick="gritClient()">Volver</button>
</br>
</br>
<form id="frm_DataGeneral" class="form-horizontal">    
    <fieldset>
        <legend>Datos Cliente</legend>

        <!--descripcion del cliente-->
        <div class="form-group">
            <label for="lb_name" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_name" name="txt_name" placeholder="Nombre del Cliente" required="true">                
            </div>
        </div>

        <!--PID-->
        <div class="form-group">
            <label for="lb_PID" class="col-sm-3 control-label">NIT:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_PID" name="txt_PID" placeholder="NIT del Cliente" required="true">                
            </div>
        </div>

        <legend>Contrato</legend>

        <!--Fecha inicio contrato-->
        <div class="form-group">
            <label for="lb_inicio" class="col-sm-3 control-label">Inicio Contrato:</label>
            <div class="col-sm-5 input-group date" id='Inicio'>                
                <input type='text' id="txtInicio" name="txtInicio" class="form-control data" readonly />
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
            </div>
        </div>

        <!--Fecha fin contrato-->
        <div class="form-group">
            <label for="lb_fin" class="col-sm-3 control-label">Fin Contrato:</label>
            <div class="col-sm-5 input-group date" id='Fin'>                
                <input type='text' id="txtFin" name="txtFnicio" class="form-control data" readonly />
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
            </div>
        </div>

        <!--numero del contrato-->
        <div class="form-group">
            <label for="lb_numero" class="col-sm-3 control-label">Número-año:</label>
            <div class="col-sm-5">
                <input type="text" id="txt_numero" name="txt_numero" class="form-control data" required="true" placeholder="Número del Contrato">                
            </div>
        </div>  


        <!--valor del contarto-->
        <div class="form-group">
            <label for="lb_valor" class="col-sm-3 control-label">Valor:</label>
            <div class="col-sm-5">
                <input type="text" id="txt_valor" name="txt_valor" class="form-control data" required="true" placeholder="Valor Total del Contrato" onblur="aMayusculas(this.value, this.id)">
            </div>
        </div>

        <!--Botones-->
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                <button id="btoGuardar" name="btoGuardar" class="btn btn-primary" type="submit" >Guardar</button>                
                <button type="button" class="btn btn-default" name="btnCancelar" id="btnCancelar" onclick="gritusuario();">Cancelar</button>
            </div>
        </div>
        
        <!--Contratos-->
        <div class="form-group">
            <div id="tableContratos" class="col-sm-offset-2 col-sm-6">

                <table border="0" cellpadding="0" cellspacing="0" class="table table-hover">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>   
                    <td colspan="3" align="center"> 
                        <table class="table table-bordered table-striped" style="font-size:11px">
                            <thead>
                                <tr>
                                    <th>Accion</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Número</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody id="Contratos">
                            </tbody>
                        </table>
                    </td>
                </table>               
            </div>
        </div>


    </fieldset>

</form>

<script type="text/javascript">
    $(function() {
        $('#Inicio').datetimepicker({
//            dateFormat: 'yy-mm-dd',
//            changeMonth: true,
//            changeYear: true
            viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2016'

        });
        $('#Fin').datetimepicker({
            viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2016'
        });

    });


</script>