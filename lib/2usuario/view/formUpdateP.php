<?php
session_start();
$usuario = $_SESSION['Usuario'];
$id_usuario = $usuario['ID_USUARIO'];
?>
<style>
    label.error {
        font-weight: bold;
        color: red;
        padding: 2px 8px;
        margin-top: 2px;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">

        <form class="form-horizontal" id="frm_CambioClave">
            <fieldset>
                <legend>Cambio de contraseña</legend>
                <div class="form-group">
                    <label for="txtcontraante" class="col-sm-2 control-label">usuario</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="txtident" id="txtident" placeholder="Ingrese el Usuario" >
                        <input type="hidden" name="txtid_user" id="txtid_user">
                    </div>
                </div>
                <div class="form-group">
                    <label for="txtnuevacontra" class="col-sm-2 control-label">Nueva Contraseña</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="txtnuevacontra" id="txtnuevacontra" placeholder="Ingrese la nueva contraseña">
                    </div>
                </div>
                <div class="form-group">
                    <label for="txtconfircontra" class="col-sm-2 control-label">Confirmación Contraseña</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="txtconfircontra" id="txtconfircontra" placeholder="Ingrese la confirmacion de la contraseña" onchange="ValidatePass('txtnuevacontra', 'txtconfircontra', '')">
                        <input type="hidden" id="txt_validaPass" name="txt_validaPass" value="" class="form-control">  
                        <div id="error" style="font-size: 15px; color: red"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-6">
                        <button type="submit" class="btn btn-primary" name="btnGuardarClave" id="btnGuardarClave">Guardar</button>
                        <button type="reset" class="btn btn-default" name="btnCancelarClave" id="btnCancelarClave">Cancelar</button>
                    </div>
                </div>
            </fieldset>
        </form>
        <div id="messageSeguridad"></div>
        <div id="validP">
            <ul class="list-group">
                <li class="list-group-item" id="1"><img src="img/questiondata.png" height="30" width="30"> Las contraseñas coinciden ?</li>
                <li class="list-group-item" id="2"></li>
                <li class="list-group-item" id="3"><img src="img/questiondata.png" height="30" width="30"> La contraseña tiene caracteres especiales ?</li>
                <li class="list-group-item" id="4"><img src="img/questiondata.png" height="30" width="30"> La contraseña tiene letras mayusculas ?</li>
                <li class="list-group-item" id="5"><img src="img/questiondata.png" height="30" width="30"> La contraseña tiene letras minusculas ?</li>
                <li class="list-group-item" id="6"><img src="img/questiondata.png" height="30" width="30"> La contraseña tiene letras ?</li>
                <li class="list-group-item" id="7"><img src="img/questiondata.png" height="30" width="30"> La contraseña tiene numeros ?</li>
                <li class="list-group-item" id="8"><img src="img/questiondata.png" height="30" width="30"> La contraseña tiene espacios ?</li>
                <li class="list-group-item" id="9"><img src="img/questiondata.png" height="30" width="30"> La nueva contraseña tiene la longitud solicitada ?</li>
            </ul>
        </div>
    </div>
</div>
<script>


    $('#frm_CambioClave').validate({
        rules: {
            txtident: {required: true},
            txtnuevacontra: {required: true},
            txtconfircontra: {required: true}
        },
        messages: {
            txtident: {required: 'Ingrese la contraseña anterior.'},
            txtnuevacontra: {required: 'Ingrese la nueva contraseña.'},
            txtconfircontra: {required: 'Ingrese la confirmacion de la contraseña.'}
        },
        debug: true,
        invalidHandler: function () {
            alert("Hay información en el formulario sin diligenciar por favor completarla");
        },
        submitHandler: function (form) {
            var usuario = $("#txtident").val();
            var valida = JsonDataUserMail(usuario);
            $("#txtid_user").val(valida.usuario_id);
                UpdatePw();
            }        
    });
    $(function () {//
        $("#txtident").popover({placement: 'right', html: true, trigger: 'clic', title: '<b>Numero de Identificacion :</b> ', content: '<p>Señor Usuario,<br>Ingrese el numero de identificacion del usuario.</p>'});
        $("#txtnuevacontra").popover({placement: 'right', html: true, trigger: 'clic', title: '<b>Nueva Contraseña :</b> ', content: '<p>Señor Usuario,<br>Ingrese la nueva contraseña acorde a los parametros de seguridad enuniciados en la parte de abajo.</p>'});
        $("#txtconfircontra").popover({placement: 'right', html: true, trigger: 'clic', title: '<b>Confirmación Contraseña :</b> ', content: '<p>Señor Usuario,<br>Confirme la nueva contraseña ingresada.</p>'});
    });
</script>