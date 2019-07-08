<?php
session_start();
$usuario = $_SESSION['Usuario'];
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!--        <meta charset="UFT-8">-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CasaI</title>

    <!-- Bootstrap -->

    <link href="sources/css/bootstrap-tour.css" rel="stylesheet">
    <link href="sources/jquery/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet">
    <link href="sources/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="sources/css/modal-inicio.css" rel="stylesheet">
    <link rel="stylesheet" href="sources/css/multi-select.css">
    <link rel="stylesheet" href="sources\css\aplicacion.css">
    <!-- Font Awesome -->
    <link href="sources/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="sources/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" href="sources/css/fileinput.css">
    <link rel="stylesheet" href="sources/css/fileinput.min.css">
    <link rel="stylesheet" type="text/css" href="sources/extensiones/DataTables-1.10.9/media/css/dataTables.bootstrap.css">


</head>

<body class="nav-md">

    <!-- <div class="main_container" style="background: #333333"> -->
        <!-- <div class="col-md-3 left_col" style="background: #333333; border: 1px solid #ff8c00 "> -->
            <!-- <div class="top_col scroll-view" style="background: #333333; display: "> -->

                <!-- <div style=""> -->
                    <!-- <a href="index.php" class="site_title" style="background: #333333"><img src="img/icon.png" width="150" height="80"></a> -->
                    <!-- </div> -->
                        <!-- <div class="top_nav"> -->
                            <!-- <div class="nav_menu" style="background: #333333; border: 1px solid #ff8c00"> -->
                                <!-- <nav class="" role="navigation"> -->
                    <!-- <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars" style="color: #ff8c00"></i></a>
                    </div> -->
                    <!--                            <div class="navbar-static-top">
                                                           <h5><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                   DISEÃ‘O DE SUBESTACIONES Y REDES AT</b></h5>
                                                               </div>-->
                    
            <div class="container fondo barFija">
                <div class="navbar-brand"><span class="h4">CASAI 2.0</span></div>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown-toggle ">
                        <a href="" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <h7><b style="color: #ff8c00"><?php echo utf8_encode($usuario[usuario_apellidos]) . " " . utf8_encode($usuario[usuario_nombre]); ?></h7></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img style="background: #ff8c00" src="img/user.png" alt="">
                            <span class=" fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu pull-right" style="background: #333333; border: 1px solid #ff8c00;">

                            <li><a style="color: #ff8c00;" href="formRol.php">Cambiar sesion</a></li>
                            <li><a style="color: #ff8c00;" href="lib/SingOff.php">Salir</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- </nav> -->
                <!-- </div> -->
                <!-- sidebar menu -->
                
                <div id="sidebar-menu" class="nav navbar-nav navbar-left">

                    <div class="">
                        <!-- mostrar menu-->
                        <div id="menu_sistema"></div>
                    </div>

                </div>
                </div>
            </div>
    
            <br>
            <br>
            <!-- page content -->
            <div class="right_col m-2 fondo1" role="main">
                <div class="contenido" id="codigo">
                </div>

            </div>

        </body>


<!-- jQuery -->
<script src="sources/jquery/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="sources/css/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="sources/jquery/bootstrap-tour.js"></script>
<!-- FastClick -->
<script src="sources/jquery/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="sources/jquery/nprogress/nprogress.js"></script>
<!-- Chart.js -->

<!-- jQuery Smart Wizard -->
<script src="sources/jquery/jquery.smartWizard.js"></script>
<!-- Custom Theme Scripts -->
<script src="sources/jquery/custom.min.js"></script>
<script src="sources/jquery/jquery.multi-select.js"></script>
<script type="text/javascript" language="javascript" src="sources/extensiones/DataTables-1.10.9/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="sources/extensiones/DataTables-1.10.9/media/js/dataTables.bootstrap.js"></script>
<script src="sources/jquery/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script src="sources/jquery/moment.js"></script>
<script src="sources/jquery/jquery.multi-select.js"></script>
<script src="sources/jquery/bootstrap-datetimepicker.js"></script>
<script src="sources/jquery/bootstrap-notify.js"></script>
<script src="sources/jquery/bootstrap-notify.min.js"></script>
<link rel="stylesheet" href="sources/css/bootstrap-datetimepicker.min.css" />
<script src="sources/jquery/bootstrap-datetimepicker.es.js"></script>
<script type="text/javascript" src="sources/jquery/script_autocomplete.js"></script>

<!-- otras librerias-->
<script src="sources/jquery/jquery_validate.js"></script>
<script src="lib/7cumplimentaciones/js/cumplimentaciones.js"></script>
<script src="lib/6formatos/js/formatos.js"></script>
<script src="lib/5fct/js/fct.js"></script>
<script src="lib/4ot/js/ot.js"></script>
<script src="lib/1config/js/menu.js"></script>
<script src="lib/1config/js/Validaciones.js"></script>
<script src="lib/2usuario/js/usuario.js"></script>
<script src="lib/1config/js/baremos.js"></script>
<script src="lib/1config/js/modulos.js"></script>
<script src="lib/3presup/js/presupuesto.js"></script>
<script src="lib/3presup/js/presupuesto_1.js"></script>
<script src="lib/8reportes/js/reportes.js"></script>

<script>
    CallMenu();
//loadingFunctions('lib/1config/vista/home.php');
</script>
</html>