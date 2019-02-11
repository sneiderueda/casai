<?PHP
//echo $clave= hash('sha512', 'Febrero2017*');
//die();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="sources/css/bootstrap-3.3.5-dist/css/bootstrap.css">
        <link rel="stylesheet" href="sources/css/login7.css">
        <script src="sources/jquery/jquery-2.1.4.js"></script>
        <script type="text/javascript" src="sources/css/bootstrap-3.3.5-dist/js/bootstrap.js"></script>        
        <link rel="icon" href="" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--        <script type="text/javascript" src="lib/Usuario/js/Usuario.js"></script>-->

        <title>CASAI</title>        
    </head>
    <script>
        $(function() {
            $("#text2").popover({placement: 'right', html: true, trigger: 'clic', title: 'Usuario: ', content: '<p>Ingrese el usuario proporcionado</p>'});
            $("#text1").popover({placement: 'right', html: true, trigger: 'clic', title: 'Contraseña: ', content: '<p>Ingrese la clave proporcionada</p>'});
        });
    </script>

    <body data-offset="50" data-target=".subnav" data-spy="scroll">
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="#"><img src="img/logo1.jpg" ></a>
                    <a class="brand navbar-right" href="#"><img src="img/logo2.jpg"></a>
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
        
        <div class="container">

            <div class="row">
                <div class='col-md-3'></div>
                <div class="col-md-6">
                    <div class="card card-container">
                         
                        <div class="login-box well">
                            <form method="POST" id="frm_login" action="lib/2usuario/controlador/CT_2usuario.php">
                                <legend>Iniciar Sesión</legend>
                                <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
                                <div class="form-group">
                                    <label for="txtUsuario">Usuario</label>
                                    <input type="text" name="text2" id="text2" class="form-control" placeholder="Usuario" value='' required="true"/>
                                </div>
                                <div class="form-group">
                                    <label for="txtClave">Contraseña</label>
                                    <input type="password" name="text1" id="text1" class="form-control" placeholder="Contraseña" value='' required="true"/>                                
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="btnIngresar" id="btnIngresar" class="btn btn-default btn-login-submit btn-block m-t-md"><i class="glyphicon glyphicon-user"></i>&nbsp;Ingresar</button>
                                </div>
                                <span class='text-center'><a href="recordar.php" class="text-sm">Olvidó su contraseña?</a></span>

                                <input type="hidden" value="Log" name="opcion"   id="Log"/>  
                                <div id="messageLog"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class='col-md-3'></div>
            </div>

        </div>
        <div class="navbar navbar-default navbar-fixed-bottom">
            <div class="container">
                <p class="navbar-text navbar-left">
                    <b>
                        AC ENERGY S.A.S<br>
                        Carrera 00 No. 112-82· 
                        Tel:&nbsp; (57 1) 333 0000 - 288 0000<br>
                        Correo electrónico: info@info.com <br>                        
                        Bogotá – Colombia
                    </b>
                </p>
            </div>
        </div>
    </body>      
</html>


