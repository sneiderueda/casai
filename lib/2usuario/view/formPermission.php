<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$id_user_creo = $_POST['data'];
//echo "algo".$id_user_creo=$_POST['data'];
?>
<script>
    var retornojsonPermission = JsonPermission(<?php echo $id_user_creo; ?>);
    var jsonDataUser = JsonDataUser(<?php echo $id_user_creo; ?>);
    //console.log(retornojsonPermission);
    $("#urs_edit_permission").html("Configurar Permisos del Usuario : " + jsonDataUser.usuario_nombre + " " + jsonDataUser.usuario_apellidos);
    
    if (retornojsonPermission.info != '' || retornojsonPermission.info == null) {
        $.each(retornojsonPermission.info, function (key, data) {

            var text = '-Seleccione-';
            var html = "<tr id='tra_" + data.area_id + "'>" +
                    "<td id='area_" + data.area_id + "'>" + data.area_nombre + "<input type='hidden' name='area_env[]' id='area_env' value='" + data.area_id + "'></td>" +
                    "<td id='profile_" + data.area_id + "'><select multiple='multiple' id='sel_profile_" + data.area_id + "' name='sel_profile_" + data.area_id + "[]'></select></td>" +
                    "<td id='elim_" + data.area_id + "'><input type='button' name='elim' onclick='DeleteAreaUser(" + retornojsonPermission.id_usuario + "," + data.area_id + ")' value='Eliminar fila' ></td>" +
                    "</tr>";
            $("#seccio_agregados_body").append(html);
            ListProfile('sel_profile_' + data.area_id + '');
            $("#sel_profile_" + data.area_id + " option:contains('" + text + "')").remove();


            if (data.perfiles != '' || data.perfiles == null) {

                $.each(data.perfiles, function (key1, data1) {
                    // $("#sel_profile_" + data.area_id + " option").filter("[value='" + data1.perfil_id + "']").attr('disabled', 'disabled');
                    $("#sel_profile_" + data.area_id + " option").filter("[value='" + data1.perfil_id + "']").attr('selected', 'selected');
                });
            } else {

            }

            $('#sel_profile_' + data.area_id + '').multiSelect({
                afterDeselect: function (values) {

                    var valor = values[0];
                    var retorno_elimina = DeleteProfileAreaUser(retornojsonPermission.id_usuario, data.area_id, valor);

                    if (retorno_elimina == 'se_logro') {
                        alert("Se elimino correctamente");
                        // $('#sel_profile_' + data.area_id + '').multiSelect('select', ['' + values + '']);
                    } else {
                        alert("Ocurrio un error al tratar de eliminar el perfil");
                    }

                }
            });

        });
    }


    $('#frm_edt_usuario').validate({
        rules: {

        },
        messages: {
        },
        debug: true,
        invalidHandler: function () {
            alert('Hay información en el formulario sin diligenciar por favor completarla');
            return false;
        },
        submitHandler: function (form) {
            EditUserPermission(<?php echo $id_user_creo; ?>);
        }
    });

</script> 
</br>
<fieldset>
    <legend id="urs_edit_permission"> </legend>
    
    <br>
    <br>
    <form class="form-horizontal" id="frm_edt_usuario" enctype='multipart/form-data'>
        <fieldset>

            <div class="form-group">
                <label for="txtentidadpre" class="col-sm-4 control-label">Agregar Area</label>
                <div class="col-sm-4">
                    <select id="area" name="area">

                    </select>
                    <input type="button" name="agregar_secc" value="+" onclick="AddAreaUser()" class="btn btn-success">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-7">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th colspan="3">Areas agregadas</th>
                            </tr>
                            <tr>
                                <th>Area</th>
                                <th>Perfil</th>
                                <th>Eliminar Area</th>
                            </tr>
                        </thead>
                        <tbody id="seccio_agregados_body">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-4">
                    <button id="btoGuardarProductor" name="btoGuardarProductor" class="btn btn-primary" type="submit" >Modificar</button>
                    <button id="btoCancelarProductor" name="btoCancelarProductor" class="btn btn-default" type="reset" >Borrar</button>
                </div>
            </div>
        </fieldset>
    </form>
</fieldset>
<script>
    ListArea('area');



    //$("#perfil_m").val(retornojson.id_perfil);
</script>

