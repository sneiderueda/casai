<?php

/* 
Autor:jennifer.cabiativa@gmail.com
 */

session_start();

$usuario = $_SESSION['Usuario'];
$user_id_create= htmlspecialchars(strip_tags(trim($_POST['data'])));
//$user_id_create: es el id del usuario creado o a editar de la lista de usuarios para el login

//echo '<pre>';
//var_dump($_SESSION['Usuario']);
//echo '</pre>';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
    </head>
    <script>

        //Inicialzar el primer tab 
        $(document).ready(function () {

		    loadingFunctions('lib/2usuario/view/formDataUser.php','dateUser','<?php echo $user_id_create ?>');			
        });

        //editar areas
        $('#TabDataUser a[href="#datePermissions"]').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
             loadingFunctions('lib/2usuario/view/formPermission.php','datePermissions','<?php echo $user_id_create ?>');            
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
    <body>
        

        <div id="DivDataUser">
         
            <ul class="nav nav-tabs" role="tablist" id="TabDataUser">
                <li role="presentation" class="active"><a href="#dateUser" aria-controls="dateUser" role="tab" data-toggle="tab">Datos Generales</a></li>
                <li role="presentation"><a href="#datePermissions" aria-controls="datePermissions" role="tab" data-toggle="tab">Permisos</a></li>                
 
            </ul>
            </br>
            <button name="btnListUser" id="btnListUser" class="btn btn-default" type="button" onclick="gritusuario()">Volver</button>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="dateUser"></div>
                <div role="tabpanel" class="tab-pane fade" id="datePermissions"></div>                
            </div>
            
        </div>

    </body>
</html>

