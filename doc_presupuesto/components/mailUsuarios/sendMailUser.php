<?php
        require_once '../../conexion.php';
        require_once '../../lib_usr.php';
        require_once '../Components.php';
        require_once '../mailUsuarios/sendMailUser.php';
        $components =  new Components($conexion);
        $user = new Tusuario;
        $userLogin = $user->getObjectUser();
        if($userLogin->cod_tipo_sensor==1 && $userLogin->adm_nal == 1 && $userLogin->adm_spr==2)//Lider nacional
            $rs = $components->getAllSeccionales(null,$userLogin->cod_tipo_unidad);
       if($userLogin->cod_tipo_sensor==1 && $userLogin->adm_nal == 0 && $userLogin->adm_spr==2)//lider seccional
            $rs = $components->getAllSeccionales($userLogin->cod_seccional);
?>
 <!----CKeditor-------->
 
         <script type="text/javascript" src="ckeditor.js"></script>
         <script type="text/javascript" src="../../js/submitGenerico.js"></script>
         <script type="text/javascript" src="../../js/jquery.js"></script>
         <!--<script type="text/javascript" src="../../js/jquery-ui-1.8.20.custom.min.js"></script>-->
        
        
        
        <link href="../../css/calendar-tas.css" rel="stylesheet" >
    <!------------->        
<style>
    td{padding: 1px;}
    body{background-color: #fff;}
    textarea{
        resize:none;
    }
</style>
<script>
    CKEDITOR.replace( 'editor1' );
    var args =[];
</script>
<div style="padding: 10px; background-color: #fff; width: 840px; border: 2px solid #D8E3B7;">
<form action="../../procesar.php?opc=612" method="post" id="formMailSend" onsubmit="return Validar();"> 
<table style="width: 830px; font-size: 4mm; color:#357320; background-color: #D8E3B7">
    <tr>
        <td colspan="4" class="formulario_titulo_1">
            Envio de mail masivos
            <input type="hidden" value="<?php echo $userLogin->correo?>" name="userMail">
            <div style="font-size: 3mm; color: #FFF; font-weight: bold; text-align: right; cursor: pointer; width: 50mm; float: right;" onclick="window.parent.limpiar();">X&nbsp;Cerrar</div>
        </td>
    </tr>
    <tr>
        <td colspan="1">
            <p id="seleccione_seccional">Seleccione Seccional</p>
        </td>
        <td>
            <p id="group_email">Grupo de correos a enviar</p>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <!--/* onChange="searchDataByajax(this, 'mails-ica', '../../procesar.php?opc=611', 'cod_seccional');"*/-->
            <div id="list-seccional">
                <select style="width: 200px;" name="codDepto" id="seccional" onchange="actualiza_mail()">
                    <option value="">-Seleccione la Seccional-</option>    
                <?php if($userLogin->cod_tipo_sensor==1 && $userLogin->adm_nal == 1 && $userLogin->adm_spr==2){?>    
                    <option value="all_sec">Todas las seccionales</option>    
                <?php }?>   
                <?php 
                while($row = mysql_fetch_array($rs)):
                    echo '<option value="'.$row["cod_seccional"].'">'.  utf8_encode($row["descripcion"]).'</option>';
                endwhile;
                    
                ?>
            </select>
            </div>
        </td>
        <td>
            <div id="list-sensores">
            </div>
            
        </td>
        <td><div id="carga_combos" style="display:none;"></div></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">
            
        </td>
        <td colspan="2">
            
        </td>
    </tr>
    <tr>
        <td colspan="2">Direcciones de destinatarios</td>
    
        <td align="center">
            <input type="submit" value="enviar-mail">&nbsp;&nbsp;&nbsp;
            <input type="reset" value="cancelar">
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="4">
            <textarea cols="99" rows="5" id="mails-ica"  name="emails"></textarea>
        </td>
    </tr>
</table>
<div style="width: 830px; font-size: 4mm; color:#357320; background-color: #D8E3B7; height: 350px; border-top: 5px solid #FFF;">
    <textarea class="ckeditor" cols="80" id="editor1" name="editor1" rows="10">
        </br><p style="font-weight: 600;">Cordial Saludo</br></br>GRACIAS</br></br><?php echo $userLogin->userName."<br>".$userLogin->correo; ?></p>                
    </textarea>
</div>
</form>    
<script>
    function actualiza_mail(){
       var opcion="searchDataByajax(this, 'mails-ica', '../../ajaxRequest.php?opc=2',$('#seccional').val());"; 
       var select='<select style="width: 200px;" id="sensores" onchange="'+opcion+'">'+
                '<option value="0">-Seleccione-</option>'+
                '<option value="1">Asistente Tecnico</option>'+ //sensores esternos
                '<option value="2">Sensores internos</option>'+//codtiposensor=1 o adm_spr=0
                '<option value="3">Lideres secionales</option>'+ //adm_nalr=1 o adm_spr=2
                '<option value="4">Representantes por Especies</option>'+//Especies Ornamentales
                '<option value="5">Representantes Productores</option>'+ //Representantes Productores
                '<option value="6">Representantes Exportadoras</option>'+ //Representantes Exportadoras
                '<option value="7">Representantes Importadoras</option>'+ //Representantes Importadoras
                '</select>';
    $("#list-sensores").html(select)
    } 
</script>
<div id="respuesta"></div>
<script>
function Validar(){
    var mails= $('#mails-ica').val();
        if(mails.length==0){
            alert("No existen direciones de correo asociadas a esta secional");
            return false;
        }else{
            return true;
        }
    
}
</script>
</div>




