<?php
/*
  Autor:jennifer.cabiativa@gmail.com
 */


$user_id_create = htmlspecialchars(strip_tags(trim($_POST['data'])));
?>

<script>
    //traer data del usuario
    var id_user_create =<?php echo $user_id_create; ?>;
    if (id_user_create != "0") {

        //mostrar los datos del usuario
        var jsonDataUser = JsonDataUser(id_user_create);
        $("#txt_names").val(jsonDataUser.usuario_nombre);
        $("#txt_surnames").val(jsonDataUser.usuario_apellidos);
        $("#txt_cc").val(jsonDataUser.usuario_cedula);
        $("#txt_mail").val(jsonDataUser.usuario_correo);
        $("#txt_dir").val(jsonDataUser.usuario_direccion);
        $("#txt_phone").val(jsonDataUser.usuario_celular);
        $("#txt_user").val(jsonDataUser.usuario_correo);
        $("#txt_cargo").val(jsonDataUser.usuario_cargo);
        $("#txt_tel").val(jsonDataUser.usuario_telefono);
        $("#txt_profession").val(jsonDataUser.usuario_profesion);
        $("#txt_tp").val(jsonDataUser.usuario_tp);
        
        $('#txt_pass').removeAttr("required");
        $('#txt_confirmPass').removeAttr("required");
        
        //inabilitar campos
        $('#txt_pass').attr('disabled','disabled');
        $('#txt_confirmPass').attr('disabled','disabled');
    }


    var htmlMessage = '<div class="alert alert-warning alert-dismissible" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">X</span></button>' +
            '<h4>Aviso!</h4>' +
            'Hay información en el formulario sin diligenciar por favor completarla' +
            '</div>';
    $('#frm_DataGeneral').validate({
        rules: {
            txt_names: {required: true},
            txt_surnames: {required: true},
            txt_cc: {required: true},
           // txt_mail: {required: true},
          //  txt_dir: {required: true},
         //   txt_phone: {required: true},
            txt_user: {required: true},
            txt_pass: {required: true},
            txt_confirmPass: {required: true}


        },
        messages: {

        },
        debug: true,
        invalidHandler: function () {

            //alert('Hay información en el formulario sin diligenciar por favor completarla');
            $("#messageDataUser").html(htmlMessage);
            return false;
        },
        
        submitHandler: function (form) {
            saveUser(<?php echo $user_id_create; ?>);
        }
    });
    
  </script>
</br>
<form id="frm_DataGeneral" class="form-horizontal">    
    <fieldset>
        <legend>Datos Generales</legend>

        <!--nombres-->
        <div class="form-group">
            <label for="lb_name" class="col-sm-3 control-label">Nombres:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_names" name="txt_names" placeholder="Nombres del Usuario" required="true">                
            </div>
        </div>

        <!--apellidos-->
        <div class="form-group">
            <label for="lb_surnames" class="col-sm-3 control-label">Apellidos:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_surnames" name="txt_surnames" placeholder="Apellidos del Usuario" required="true">                
            </div>
        </div>

        <!--cedula-->
        <div class="form-group">
            <label for="lb_cc" class="col-sm-3 control-label">Cedula:</label>
            <div class="col-sm-5">
                <input type="text" id="txt_cc" name="txt_cc" class="form-control data" required="true" placeholder="Número de Cedula"  onkeypress="return numeros(event)" maxlength="20">
            </div>
        </div>

        <!--correo-->
        <div class="form-group">
            <label for="lb_mail" class="col-sm-3 control-label">Correo Electrónico:</label>
            <div class="col-sm-5">
                <input type="email" id="txt_mail" name="txt_mail" class="form-control data"  placeholder="Correo Electrónico" onblur="valida_correos(this); ValidaMailUser(this.value)" onchange="user(this.value)">                
            </div>
        </div>  


        <!--direccion-->
        <div class="form-group">
            <label for="lb_dir" class="col-sm-3 control-label">Dirección Principal</label>
            <div class="col-sm-5">
                <input type="text" id="txt_dir" name="txt_dir" class="form-control data"  placeholder="Dirección Principal" onblur="aMayusculas(this.value, this.id)">
            </div>
        </div>

        <!--telefono-->
        <div class="form-group">
            <label for="lb_tel" class="col-sm-3 control-label">Telefono:</label>
            <div class="col-sm-5">
                <input type="text" id="txt_tel" name="txt_tel" class="form-control data" placeholder="Número de Contacto" onkeypress="return numeros(event)" maxlength="20">
            </div>
        </div>

        <!--Celular-->
        <div class="form-group">
            <label for="lb_phone" class="col-sm-3 control-label">Celular:</label>
            <div class="col-sm-5">
                <input type="text" id="txt_phone" name="txt_phone" class="form-control data" placeholder="Número Celular de Contacto" onkeypress="return numeros(event)" maxlength="20">
            </div>
        </div>


        <!--cargo-->
        <div class="form-group">
            <label for="lb_cargo" class="col-sm-3 control-label">Cargo:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_cargo" name="txt_cargo" placeholder="Cargo del Usuario" onblur="aMayusculas(this.value, this.id);">                
            </div>
        </div>

        <!--profesion-->
        <div class="form-group">
            <label for="lb_prossion" class="col-sm-3 control-label">Profesion:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_profession" name="txt_profession" placeholder="Profesion del Usuario" onblur="aMayusculas(this.value, this.id);">                
            </div>
        </div>

        <!--tarjeta profesional-->
        <div class="form-group">
            <label for="lb_tp" class="col-sm-3 control-label">Tarjeta Profesional:</label>
            <div class="col-sm-5">                
                <input type="text" id="txt_tp" name="txt_tp" class="form-control data" placeholder="Tarjeta profesional">                        
            </div>           
        </div>          

        <!--usuario-->
        <div class="form-group">
            <label for="lb_usr" class="col-sm-3 control-label">Nombre de usuario:</label>
            <div class="col-sm-5">                
                <input type="text" id="txt_user" name="txt_user" class="form-control" placeholder="Nombre de usuario" required="true" >                        
            </div>            
        </div>

        <!--password-->
        <div class="form-group">
            <label for="lb_password" class="col-sm-3 control-label">Contraseña:</label>
            <div class="col-sm-5">                
                <input type="password" id="txt_pass" name="txt_pass" class="form-control data" placeholder="Contraseña" required="true">                        
            </div>            
        </div>

        <!--profesion-->
        <div class="form-group">
            <label for="lb_confirmPass" class="col-sm-3 control-label">Confirmación Contraseña:</label>
            <div class="col-sm-5">                
                <input type="password" id="txt_confirmPass" name="txt_confirmPass" class="form-control" placeholder="Confirmación Contraseña" required="true" onchange="ValidatePass('txt_pass', 'txt_confirmPass', '')">                        
                <input type="hidden" id="txt_validaPass" name="txt_validaPass" value="" class="form-control">                        
                <div id="error" style="font-size: 15px; color: red"></div>
            </div>            
        </div>

        <!--Botones-->
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                <button id="btoGuardar" name="btoGuardar" class="btn btn-primary" type="submit" >Guardar</button>                
                <button type="button" class="btn btn-default" name="btnCancelar" id="btnCancelar" onclick="gritusuario();">Cancelar</button>
            </div>
        </div>
    </fieldset>

</form>

