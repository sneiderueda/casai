/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function griModulosSb() {
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_1config.php',
        async: false,
        data: {
            opcion: 'griModulosSb'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });


}

function addMoreModulos()
{
    var cadena = "";
    var concat = "'";
    var tipomodulo_id = $("#slTipoModulo option:selected").val();
    var txt_tipomodulo = $("#slTipoModulo option:selected").text();
    var id_modulo = $("#slModulo option:selected").val();
    var txt_modulo = $("#slModulo option:selected").text();
    var vol = '';
    var voltaje = $("#txt_voltaje").val();

    if (id_modulo == '') {
        alert('Señor usuario seleccione una opción de la lista.');

    } else {
        if (id_modulo == "nuevo") {
            txt_modulo = $("#txt_modulo").val();

            $.ajax({
                type: 'post',
                url: 'lib/1config/controlador/CT_1config.php',
                dataType: 'xml',
                async: false,
                data: {opcion: 'SaveNewModulo',
                    txt_modulo: txt_modulo},

                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
                },
                success: function (xml) {
                    if ($(xml).find('resultado').text() == 1)
                    {
                        id_modulo = $(xml).find('modulo_id').text();
                        AddModulo("");

                    } else if ($(xml).find('resultado').text() == 0) {
                        alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                        return false;
                    }

                }
            });
        }
        if (tipomodulo_id == "tm_nuevo") {

            txt_tipomodulo = $("#txt_modulo_tipo").val();

            $.ajax({
                type: 'post',
                url: 'lib/1config/controlador/CT_1config.php',
                dataType: 'xml',
                async: false,
                data: {opcion: 'SaveNewTipoModulo',
                    txt_tipomodulo: txt_tipomodulo},

                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
                },
                success: function (xml) {
                    if ($(xml).find('resultado').text() == 1)
                    {
                        tipomodulo_id = $(xml).find('tipoModulo_id').text();
                        AddTipoModulo("");
                        var jsonlstTipoMd = ListTipoModulo('slTipoModulo');
                        var retorno = "<option value=''>-Seleccione-</option>";
                        retorno += "<option value='tm_nuevo'>Nuevo</option>";
                        $.each(jsonlstTipoMd.TIPO_MODULO, function (key, data) {

                            retorno += '<option value="' + data.tipomodulo_id + '">' + data.tipomodulo_descripcion + '</option>';

                        });
                        $("#slTipoModulo").html(retorno);

                    } else if ($(xml).find('resultado').text() == 0) {
                        alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                        return false;
                    }

                }
            });
        }

        $("#tableMoreModulos").css('display', 'block');
        if ($("#tr_modulo_" + id_modulo + "_" + tipomodulo_id + "_" + voltaje).val() == null)
        {
            vol="'"+voltaje+"'";
            cadena = '<tr id="tr_modulo_' + id_modulo + '_' + tipomodulo_id + '_' + voltaje + '">' +
                    '<td><button type="button" name="btn_eliminar_md_'
                    + id_modulo + '" id="btn_eliminar_md_' + id_modulo
                    + '" class="btn btn-default btn-xs" onclick="delMoreModulo('
                    + id_modulo + ','
                    + tipomodulo_id + ','
                    + vol + ');contadorFilasTablaGeneral('
                    + concat + 'ModuloAddTR' + concat + ','
                    + concat + 'txt_add_modulo' + concat
                    + ');"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>Eliminar</button></td>' +
                    '<td>' + txt_tipomodulo +
                    '<td>' + txt_modulo +
                    '<td>' + voltaje +
                    '<input type="hidden" name="idAddModulo[]" id="idAddModulo" value="' + id_modulo + '">' +
                    '<input type="hidden" name="voltajeModulo[]" id="voltajeModulo" value="' + voltaje + '">' +
                    '<input type="hidden" name="AddTipoModuloId[]" id="AddTipoModuloId" value="' + tipomodulo_id + '">' +
                    '</td>' +
                    '</tr>';
            $("#ModuloAddTR").append(cadena);
        } else {
            alert('Señor usuario el ingeniero ya esta adicionado.');
            return false;
        }
    }

}

function clearMoreModulos() {
    $("#tableMoreModulos").css('display', 'none');
    $("#ModuloAddTR").html('');
    $("#txt_add_modulo").val('');
    $("#slModulo").val('');


}
function delMoreModulo(param1, param2, param3) {
    $("#tr_modulo_" + param1 + "_" + param2 + '_' + param3).remove();
    return false;
}

function SaveModuloSb() {
    var frm_CreateModuloSb = document.getElementById("frm_CreateModuloSb");
    var data = new FormData(frm_CreateModuloSb);
    var retorno;
    var rowModulosSubestacion = $('#ModuloAddTR tr').length;
    //console.log(rowModulosSubestacion);
    if (rowModulosSubestacion == 0) {
        alert('Debe cargar por lo menos un modulo a la subestacion.');
        return false;
    }

    var slSubestacion = $("#slSubestacion").val();

    var arregloTipoModuloSb = new Array();
    $('input[name^="AddTipoModuloId"]').each(function () {
        arregloTipoModuloSb.push($(this).val());
    });
    var id_tipoModulo = arregloTipoModuloSb;


    var arregloModuloSb = new Array();
    $('input[name^="idAddModulo"]').each(function () {
        arregloModuloSb.push($(this).val());
    });
    var id_modulo = arregloModuloSb;

    var arregloVoltajeMd = new Array();
    $('input[name^="voltajeModulo"]').each(function () {
        arregloVoltajeMd.push($(this).val());
    });
    var voltaje = arregloVoltajeMd;

    if (id_modulo == "") {
        alert("Favor agregar algún modulo a la subestación.");
        return false;
    }

    data.append('opcion', 'SaveModuloSb');
    data.append('slSubestacion', slSubestacion);
    data.append('id_modulo', id_modulo);
    data.append('id_tipoModulo', id_tipoModulo);
    data.append('voltaje', voltaje);


    $.ajax({
        type: 'POST',
        url: 'lib/1config/controlador/CT_1config.php',
        contentType: false,
        async: false,
        data: data,
        processData: false,
        cache: false

    }).done(function (response) {
        retorno = response;
    });

    if (retorno == 1) {
        alert("Señor usuario(a). Los datos se guardaron correctamente.");
    } else if (retorno == 2) {
        alert("Se ha presentado un error guardando los daros.");
    }
}

function AddTipoModulo(modulo) {

    if (modulo == "tm_nuevo") {
        $("#txt_modulo_tipo").css("display", "block");
        $("#AtrasModulo_tipo").css("display", "block");
        $("#slTipoModulo").css("display", "none");
    } else {
        $("#slTipoModulo").css("display", "block");
        $("#txt_modulo_tipo").css("display", "none");
        $("#AtrasModulo_tipo").css("display", "none");
    }
}

function ListTipoModulo() {
    var retorno;

    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_1config.php',
        data: {
            opcion: 'ListTipoModulo'
        },
        async: false,
        success: function (data) {
            retorno = data;

        },
        dataType: "json"
    });
    return retorno;
    // $("#" + control + "").html(retorno);

}

function StateUpdatesubestacionModulo(subestacion_id) {

    var confrimar = '';

    confrimar = confirm("Esta seguro que desea eliminar la subestacion.");

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/1config/controlador/CT_1config.php',
            data: {
                opcion: 'StateUpdatesubestacionModulo',
                subestacion_id: subestacion_id

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Se elimino correctamente.');
            griModulosSb();
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}
function DataSubestacionModulos(subestacion_id) {

    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_1config.php',
        async: false,
        data: {
            opcion: 'DataSubestacionModulos',
            subestacion_id: subestacion_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    return jsondata;

}