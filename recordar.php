<!DOCTYPE html>
<html>
    <head>
        <script src="sources/jquery/jquery-2.1.4.js"></script>
        <script type="text/javascript" src="sources/css/bootstrap-3.3.5-dist/js/bootstrap.js"></script>
<!--        <script type="text/javascript" src="js/Validaciones.js"></script>-->
        <link rel="stylesheet" href="sources/css/bootstrap-3.3.5-dist/css/bootstrap.css">
        <link rel="stylesheet" href="sources/css/login7.css">
        <link rel="icon" href="" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Olvidó su contraseña?</title>
    </head>
    <?php
        date_default_timezone_set('America/Bogota');
        $ttk_olvido_clave = hash('sha512', '_s/i*s+f!i%t-o*_f!r&m_@o*l-v.i_*+d;%#(' . date("Ymd") . $_SERVER['REMOTE_ADDR'] . date('H') . '-$%_/+#&');
    ?>
    <script>
        $(function() {
            $("#txtNomUsuario").popover({placement: 'right', html: true, trigger: 'clic', title: 'Usuario: ', content: '<p>Ingrese el usuario proporcionado.<br><b>Nota :</b><br><u>Recuerde que los funcionarios deben realizar el cambio de contraseña con el administrador de la entidad</u></p>'});
        });
    </script>
    <style>
        label.error {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }
    </style>
    <body data-offset="50" data-target=".subnav" data-spy="scroll">
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="#"><img src="img/logo1.png"></a>
                    <a class="brand navbar-right" href="#"><img src="img/logo2.png"></a>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="login-box well">
                        <form method="POST" id="frm_olvido" action="lib/2usuario/controlador/CT_2usuario.php">
                            <legend>Recuperar Contraseña</legend>
                            <div class="form-group">
                                <label for="txtNomUsuario">Correo Electronico</label>
                                <input type="text" name="txtNomUsuario" id="txtNomUsuario" class="form-control" placeholder="ingrese el correo" value='' required="true"/>
                                <input type="hidden" name="opcion" id="opcion" value='recuperarPass'/>                                
                                <input type="hidden" name="ttk_olv_clav" id="ttk_olv_clav" value="<?php echo $ttk_olvido_clave;?>">
                            </div>
                            <div class="form-group">                        
                                <button type="submit" class="btn btn-primary btn-login-submit btn-block m-t-md" id="btnReestablecerContrasena" name="btnReestablecerContrasena">Reestablecer Contraseña</button>                    
                            </div>
                            <div class="form-group">                        
                                <a href="index.php" class="btn btn-info">Regresar</a>
                            </div>
                        </form>
                    </div>
                    <div id="message"></div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <div class="navbar navbar-default navbar-fixed-bottom">
            <div class="container">
                <p class="navbar-text navbar-left">
                <p class="navbar-text navbar-left">
                    <b>
                        AC ENERGY S.A.S<br>
                        Carrera 00 No. 112-82· 
                        Tel:&nbsp; (57 1) 333 0000 - 288 0000<br>
                        Correo electrónico: info@info.com <br>                        
                        Bogotá – Colombia
                    </b>
                </p>
                </p>
            </div>
        </div>
    </body>      
</html>
