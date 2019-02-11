<?php
/*
  Autor:jennifer.cabiativa@gmail.com
 */


$subestacion_id = htmlspecialchars(strip_tags(trim($_POST['data'])));

?>

<script>
    var subestacion_id = '<?php echo $subestacion_id; ?>';
    ListSubestacion('slSubestacion');

    if (subestacion_id != '') {

        var JsonSubestacionModulos = DataSubestacionModulos(subestacion_id);
        $("#slSubestacion").html(JsonSubestacionModulos.subestacion_id);
         $("#slSubestacion").val(subestacion_id);
        
        $.each(JsonSubestacionModulos.SUBESTACION_MODULO, function (key, data_mod) {
             $("#tableMoreModulos").css('display', 'block');
            var vol = '"' + data_mod.modulosubestacion_voltaje + '"';

            table = "<tr id='tr_modulo_" + data_mod.modulo_id + "_" + data_mod.tipomodulo_id + "_" + data_mod.modulosubestacion_voltaje + "'>" +
                    "<td><button type='button' name='btn_eliminar' id='btn_eliminar' class='btn btn-default btn-xs' onclick='delMoreModulo(" + data_mod.modulo_id + "," + data_mod.tipomodulo_id + "," +  vol  + ")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span>Eliminar</button></td>" +
                    "<td>" + data_mod.tipomodulo_descripcion + "</td>" +
                    "<td>" + data_mod.modulo_descripcion + "</td>" +
                    "<td>" + data_mod.modulosubestacion_voltaje + "</td>" +
                    '<input type="hidden" name="idAddModulo[]" id="idAddModulo[]" value="' + data_mod.modulo_id + '">' +
                    '<input type="hidden" name="voltajeModulo[]" id="voltajeModulo[]" value="' + data_mod.modulosubestacion_voltaje + '">' +
                    '<input type="hidden" name="AddTipoModuloId[]" id="AddTipoModuloId[]" value="' + data_mod.tipomodulo_id + '">' +
                    "</tr>";

            $("#ModuloAddTR").append(table);
        });
    }
    var jsonlsMd = ListModulo('slModulo');
    var retorno = "<option value=''>-Seleccione-</option>";
    retorno += "<option value='nuevo'>Nuevo</option>";
    $.each(jsonlsMd.MODULO, function (key, data) {

        retorno += '<option value="' + data.modulo_id + '">' + data.modulo_descripcion + '</option>';

    });
    $("#slModulo").html(retorno);


    var jsonlstTipoMd = ListTipoModulo('slTipoModulo');
    var retorno = "<option value=''>-Seleccione-</option>";
    retorno += "<option value='tm_nuevo'>Nuevo</option>";
    $.each(jsonlstTipoMd.TIPO_MODULO, function (key, data) {

        retorno += '<option value="' + data.tipomodulo_id + '">' + data.tipomodulo_descripcion + '</option>';

    });
    $("#slTipoModulo").html(retorno);






    $(document).ready(function () {

        $('#frm_CreateModuloSb').validate({

            rules: {
                slSubestacion: {required: true}
              //  slTipoModulo: {required: true},
               // slModulo: {required: true}
            },
            messages: {
                slSubestacion: {required: 'Seleccione la Subestacion'}
              //  slTipoModulo: {required: 'Seleccione tipo Modulo'},
               // slModulo: {required: 'Seleccione el Modulo.'}

            },
            debug: true,
            invalidHandler: function () {
                alert('Hay información en el formulario sin diligenciar por favor completarla');
            },
            submitHandler: function (form) {
                SaveModuloSb();

            }
        });
    });


</script>
<legend>Subestacion - Modulo </legend>

<form class="form-horizontal" name="frm_CreateModuloSb" id="frm_CreateModuloSb" method="POST" enctype='multipart/form-data'>


    <table class="table table-bordered table-striped">


        <tr>
            <td><b>Subestacion:</b></td>
            <td>
                <select id="slSubestacion" name="slSubestacion" class="form-control"  required="true" onchange="AddSubestacion(this.value);"  >
                </select>                                 
            </td>
        </tr>

        <tr>
            <td><b>Tipo Modulo:</b></td>
            <td>
                <select id="slTipoModulo" name="slTipoModulo" class="form-control"   onchange="AddTipoModulo(this.value);"  >
                    <option value="">-Seleccione-</option>
                </select> 
                <br>
                <input type="text" style="display: none" class="form-control data" id="txt_modulo_tipo" name="txt_modulo_tipo" placeholder="Tipo Modulo" onblur="aMayusculas(this.value, this.id);">
                <img src='img/atras.png' style="display: none"  title='Atras' width='20' height='20' id='AtrasModulo_tipo' name='AtrasModulo_tipo' style='cursor:pointer' border='0' onclick='AddTipoModulo("")'>
            </td>
        </tr>

        <tr>
            <td><b>Modulo:</b></td>
            <td>
                <select id="slModulo" style="display: block" name="slModulo" class="form-control data" onchange="AddModulo(this.value);">
                    <option value="">-Seleccione-</option>
                </select> 
                <br>
                <input type="text" style="display: none" class="form-control data" id="txt_modulo" name="txt_modulo" placeholder="Nombre del Modulo" onblur="aMayusculas(this.value, this.id);">
                <img src='img/atras.png' style="display: none"  title='Atras' width='20' height='20' id='AtrasModulo' name='AtrasModulo' style='cursor:pointer' border='0' onclick='AddModulo("")'>
                <input type="text" class="form-control data" id="txt_voltaje" name="txt_voltaje" placeholder="Ingrese el Voltaje" style="width:200px">  
                <br>

                <input type="hidden" name="txt_add_modulo" id="txt_add_modulo" value="">
                <input type="hidden" name="txt_add_voltaje" id="txt_add_voltaje" value="">
                <br>
                <button type="button" name="btnAddModulo" id="btnAddModulo" class="btn btn-default btn-xs" onclick="addMoreModulos();
                        contadorFilasTablaGeneral('ModuloAddTR', 'txt_add_modulo');"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Adicionar</button>&nbsp;
                <button type="button" name="btnCancelTecnico" id="btnCancelTecnico" class="btn btn-default btn-xs" onclick="clearMoreModulos();
                        contadorFilasTablaGeneral('ModuloAddTR', 'txt_add_modulo');"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span>Limpiar</button>
                <div id="tableMoreModulos" style="display: none;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Acción</th>
                                <th>Tipo Modulo</th>
                                <th>Modulo</th>
                                <th>Voltaje</th>
                            </tr>
                        </thead>
                        <tbody id="ModuloAddTR">
                        </tbody>
                    </table>
                </div>
                <div id="controlDataProfesional"></div>
            </td>
        </tr>

        <tr>
            <td colspan="2">
        <center>
            <button type="submit" class="btn btn-primary" name="btnGuardarVisita" id="btnGuardarVisita">Guardar</button>                        

        </center>                        
        </td>
        </tr>

    </table>

</form>
