<?php
session_start();
$usuario = $_SESSION['Usuario'];


if ($usuario['usuario_correo'] != NULL || $usuario['usuario_correo'] != '') {
    if ($usuario['N_PERFILES'] > 1) {        
        ?>

        <html>
            <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" href="sources/css/bootstrap-3.3.5-dist/css/bootstrap.css">
                <link rel="stylesheet" href="sources/css/rol.css">
                <script src="sources/jquery/jquery-2.1.4.js"></script>
                <script type="text/javascript" src="lib/2usuario/js/usuario.js"></script>
                <title>CASAI</title> 
            </head>

            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="box">
                            <div class="box-icon">
                                <span class="fa fa-4x fa-html5"></span>
                            </div>
                            <div class="info">
                                <h4 class="text-center">SELECCION DE PERFIL</h4>
                                <p>En este espacio ud puede seleccionar el perfil con el que desea ingresar al sistema de CASAI, por favor seleccione el perfil:</p>
                                <select class="form-control input-lg" id="select_perfil">

                                </select>
                                <br>
                                <a href="lib/SingOff.php" class="btn btn-danger">Cerrar sesion</a>
                                <input type="button" class="btn btn-primary" value="Ingresar al sistema" onclick="SelectPerfil()">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>            
                </div>
            </div>

            <script>
                DataProfileUser(<?php echo $usuario['usuario_id']; ?>, 'select_perfil');
            </script>
        </html>
        <?php
    } else {
        header('Location: aplicacion.php');
    }
} else {
    header('Location: index.php');
}
?>