/* 
 Autor:Jennifer.cabiativa@gmail.com
 */

function SelectPerfil() {
    var retorno;
    var id_perfil_area = $("#select_perfil").val();
    var nom_perfil = $("#select_perfil option:selected").html();


    if (id_perfil_area == "" || id_perfil_area == null) {
        alert("Seleccione un perfil para ingresar al sistema");
    } else {

        var array = id_perfil_area.split('_');
        var id_perfil = array[0];
        var id_area = array[1];

        $.ajax({
            type: "POST",
            url: 'lib/2usuario/controlador/CT_2usuario.php',
            data: {
                opcion: 'ChangeSession',
                perfil: id_perfil,
                id_area: id_area,
                nom_perfil: nom_perfil
            },
            async: false,
            success: function (data) {
                retorno = data;
            }
        });
        if (retorno == 1) {
            location.href = 'aplicacion.php';
        } else {

           // location.href = 'aplicacion.php';
            
             alert("Ocurrio un error comuniquese con el administrador del sistema");
             
        }
    }
}

function DataProfileUser(usuario, control) {
    var retorno = "";
    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        data: {
            opcion: 'DataProfileUser',
            usuario: usuario
        },
        async: false,
        success: function (data) {
            retorno = data;
        }
    });
    $("#" + control + "").html(retorno);
}

function gritusuario() {
    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        async: false,
        data: {
            opcion: 'gritusuario'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });


}

function StateUpdate(usuario_id, estado) {

    var confrimar = '';


    if (estado == 1) {
        confrimar = confirm("Esta seguro que desea activar el usuario.");
    } else if (estado == 0) {
        confrimar = confirm("Esta seguro que desea inactivar el usuario.");
    }

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/2usuario/controlador/CT_2usuario.php',
            data: {
                opcion: 'StateUpdate',
                usuario_id: usuario_id,
                estado: estado

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Información guardada correctamente.');
            gritusuario();
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function user(correo) {
    $("#txt_user").val(correo);
}

function saveUser(user_id) {
    var param = "";
    var parametros = '';

    if ($("#txt_validaPass").val() != "1" && user_id == "0") {
        alert("Favor validar la contraseña");
        return false;
    }

    $('.data').each(function () {

        var elem_form = this;
        param += '"' + elem_form.id + '":"' + elem_form.value + '",';
    });

    var length = param.length;
    param = param.slice(0, length - 1);

//    alert('param : ' + param);
//    return false;


    parametros = {
        'opcion': 'saveUser',
        txt_names: $("#txt_names").val(),
        txt_surnames: $("#txt_surnames").val(),
        txt_cc: $("#txt_cc").val(),
        txt_mail: $("#txt_mail").val(),
        txt_dir: $("#txt_dir").val(),
        txt_tel: $("#txt_tel").val(),
        txt_phone: $("#txt_phone").val(),
        txt_cargo: $("#txt_cargo").val(),
        txt_profession: $("#txt_profession").val(),
        txt_tp: $("#txt_tp").val(),
        txt_pass: $("#txt_pass").val(),
        user_id: user_id
    };

    $.ajax({
        type: 'post',
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        dataType: 'xml',
        async: false,
        data: parametros,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1)
            {
                var id_user_create = $(xml).find('id_user_create').text();
                alert('Señor usuario (a), la informacion se almacenó exitosamente');
                param = "";
                $('#TabDataUser a[href="#datePermissions"]').tab('show');
                loadingFunctions('lib/2usuario/view/formPermission.php', 'datePermissions', id_user_create);
                loadingFunctions('lib/2usuario/view/formDataUser.php', 'dateUser', id_user_create);
                //listPaginas('solicitud_datos_predio', 'lib/solicitud/vista/formSolDatosPredio.php');


            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                param = "";
            }

        }
    });

}

function JsonDataUser(id_user_create) {

    var jsondata;
    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        async: false,
        data: {
            opcion: 'JsonDataUser',
            id_user_create: id_user_create
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    return jsondata;
}

function ValidaMailUser(mail_user) {


    var data;
    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        data: {
            opcion: 'ValidaMailUser',
            mail_user: mail_user

        },
        async: false,
        success: function (retu) {
            data = retu;
        }
    });

    if (data == '1' || data == 1)
    {
        alert('Este correo ya se encuentra registrado en el sistema, favor validar');
        $("#txt_mail").val('');
        return false;

    }
}

function gritClient() {
    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        async: false,
        data: {
            opcion: 'gritClient'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });


}

function JsonPermission(id_user_create) {

    var jsondata;
    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        async: false,
        data: {
            opcion: 'JsonPermission',
            usuario: id_user_create
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    return jsondata;
}

function ListProfile(control) {
    var retorno = "";

    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        data: {
            opcion: 'ListProfile'
        },
        async: false,
        success: function (data) {
            retorno += data;

        }
    });

    $("#" + control + "").html(retorno);

}

function DeleteAreaUser(persona, area) {
    var retorno;
    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        data: {
            opcion: 'DeleteAreaUser',
            id_persona: persona,
            area: area
        },
        async: false,
        success: function (data) {
            retorno = data;
        }
    });

    if (retorno == 1) {
        alert("Se elimino correctamente");
        $("#tra_" + area + "").remove();
    } else if (retorno == 2) {
        alert("No puede eliminar porque se encuentra en uso");
    }
}

function DeleteProfileAreaUser(persona, area, profile_id) {
    var retorno;
    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        data: {
            opcion: 'DeleteProfileAreaUser',
            id_persona: persona,
            area_id: area,
            profile_id: profile_id
        },
        async: false,
        success: function (data) {
            retorno = data;
        }
    });

    return retorno;
}

function ListArea(control) {
    var retorno = "";

    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        data: {
            opcion: 'ListArea'
        },
        async: false,
        success: function (data) {
            retorno += data;

        }
    });

    $("#" + control + "").html(retorno);

}

function AddAreaUser() {


    var area_nombre = $("#area option:selected").html();
    var area_id = $("#area").val();

    if (area_id == null || area_id == "") {
        alert("Seleccione un area");
    } else {

        var text = '-Seleccione-';
        if ($("#area_" + area_id + "").length == 0) {
            var html = "<tr id='tra_" + area_id + "'>" +
                    "<td id='area_" + area_id + "'>" + area_nombre + "<input type='hidden' name='area_env[]' id='area_envde' value='" + area_id + "'></td>" +
                    "<td id='profile_" + area_id + "'><select multiple='multiple' id='sel_profile_" + area_id + "' name='sel_profile_" + area_id + "[]'></select></td>" +
                    "<td id='elim_" + area_id + "'><input type='button' name='elim' value='Eliminar fila' onclick='DeleteAreaUserTr(" + area_id + ")'></td>" +
                    "</tr>" +
                    "<script>ListProfile('sel_profile_" + area_id + "');" +
                    '$("#sel_profile_' + area_id + ' option:contains(' + text + ')").remove();' +
                    "$('#sel_profile_" + area_id + "').multiSelect();</script>";
            $("#seccio_agregados_body").append(html);

            //

        } else {
            alert("Ya agrego este departamento");
        }
    }

}

function DeleteAreaUserTr(area_id) {
    var confirma = confirm("Esta seguro de realizar esta accion");
    if (confirma) {
        $("#tra_" + area_id + "").remove();
    } else {
        return false;
    }
}

function EditUserPermission(user_id) {

    var retorno;
    var data = new FormData();

    var arre_areas = [];
    $('input[name^="area_env"]').each(function () {
        arre_areas.push($(this).val());
    });

    for (var i = 0; i < arre_areas.length; i++) {
        data.append('area_profiles_' + arre_areas[i], $("#sel_profile_" + arre_areas[i] + "").val());
    }
    data.append('arreglo_areas', arre_areas);
    data.append('opcion', 'EditUserPermission');
    data.append('usuario', user_id);

    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        async: false,
        contentType: false,
        data: data,
        processData: false,
        cache: false,
        success: function (retu) {
            retorno = retu;
        }
    });
    if (retorno == 1) {
        alert("Se modifico correctamente el usuario");
        // VerFormEditUsuario(user_id);
    } else if (retorno == 3) {
        alert("No se logro modificar el usuario");
        return false;
    }
}


function saveClient(client_id) {
    var param = "";
    var parametros = '';


    $('.data').each(function () {

        var elem_form = this;
        param += '"' + elem_form.id + '":"' + elem_form.value + '",';
    });

    var length = param.length;
    param = param.slice(0, length - 1);

//    alert('param : ' + param);
//    return false;

    /*"txt_name":"cliente","txt_PID":"123","txtInicio":"2017-11-20","txtFin":"2017-11-20","txt_numero":"31232","txt_valor":"1233"*/
    parametros = {
        'opcion': 'saveClient',
//        'data_json': '{' + param + '}',
        txt_name: $("#txt_name").val(),
        txt_PID: $("#txt_PID").val(),
        txtInicio: $("#txtInicio").val(),
        txtFin: $("#txtFin").val(),
        txt_numero: $("#txt_numero").val(),
        txt_valor: $("#txt_valor").val(),
        client_id: client_id
    };

    $.ajax({
        type: 'post',
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        dataType: 'xml',
        async: false,
        data: parametros,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1)
            {
                alert('Señor usuario (a), la informacion se almacenó exitosamente');
                param = "";
                var cliente_id = $(xml).find('cliente_id').text();
                loadingFunctions('lib/2usuario/view/formEditClient.php', 'contenido', cliente_id);

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                param = "";
            }

        }
    });

}

function JsonDataClient(cliente_id) {

    var jsondata;
    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        async: false,
        data: {
            opcion: 'JsonDataClient',
            cliente_id: cliente_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    return jsondata;
}

function StateUpdateClient(cliente_id, estado) {

    var confrimar = '';


    if (estado == 1) {
        confrimar = confirm("Esta seguro que desea activar el cliente.");
    } else if (estado == 0) {
        confrimar = confirm("Esta seguro que desea inactivar el cliente.");
    }

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/2usuario/controlador/CT_2usuario.php',
            data: {
                opcion: 'StateUpdateClient',
                cliente_id: cliente_id,
                estado: estado

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Información guardada correctamente.');
            gritClient();
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function ListContractsClient(cliente_id) {

    var cadena = "";
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        async: false,
        data: {
            opcion: 'ListContractsClient',
            cliente_id: cliente_id
        },
        success: function (datos) {
            $.each(datos.datos, function (i, item) {

                var contrato_id = item.contrato_id;
                var contrato_fechainicio = item.contrato_fechainicio;
                var contrato_fechafin = item.contrato_fechafin;
                var contrato_numero = item.contrato_numero;
                var contrato_valor = item.contrato_valor;

                cadena = '<tr id="tr_contarto_' + contrato_id + '">' +
                        '<td><input type="button" name="elim_secc" value="Eliminar" class="btn btn-danger" onclick="StateUpdateContract(' + contrato_id + ',0,' + cliente_id + ')"></td>' +
                        '<td>' + contrato_fechainicio + '</td>' +
                        '<td>' + contrato_fechafin + '</td>' +
                        '<td>' + contrato_numero + '</td>' +
                        '<td>' + contrato_valor + '</td>' +
                        '</tr>';
                $("#Contratos").append(cadena);

            });
        }
    });
}

function StateUpdateContract(contrato_id, estado, cliente_id) {

    var confrimar = '';

    confrimar = confirm("Esta seguro que desea eliminar el contrato.");

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/2usuario/controlador/CT_2usuario.php',
            data: {
                opcion: 'StateUpdateContract',
                contrato_id: contrato_id,
                estado: estado

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Información guardada correctamente.');
            loadingFunctions('lib/2usuario/view/formEditClient.php', 'contenido', cliente_id);
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function ListClient(control) {
    var retorno = "";

    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        data: {
            opcion: 'ListClient'
        },
        async: false,
        success: function (data) {
            retorno += data;

        }
    });

    $("#" + control + "").html(retorno);

}
function ListContrato(control) {

    var cliente = $("#slCliente").val();
    if (cliente == "") {
        alert("Favor seleccione el cliente.");
        return false;
    }
    var retorno = "";

    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        data: {
            opcion: 'ListContrato',
            cliente: cliente
        },
        async: false,
        success: function (data) {
            retorno += data;

        }
    });

    $("#" + control + "").html(retorno);

}
function ListUserArea(control, area_id) {

    var retorno = "";

    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        data: {
            opcion: 'ListUserArea',
            area_id: area_id
        },
        async: false,
        success: function (data) {
            retorno += data;

        }
    });

    $("#" + control + "").html(retorno);

}

function JsonDataUserMail(txtNomUsuario) {

    var jsondata;
    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        async: false,
        data: {
            opcion: 'JsonDataUserMail',
            txtNomUsuario: txtNomUsuario
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    return jsondata;
}

function UpdatePw() {
    var id = $("#txtid_user").val();
    var claveNueva = $("#txtnuevacontra").val();
    if (id == "") {

        alert("El usuario no existe en el sistema.");
        return false;
    }

    $.ajax({
        type: "POST",
        url: 'lib/2usuario/controlador/CT_2usuario.php',
        async: false,
        data: {
            opcion: 'UpdatePw',
            clave: claveNueva,
            id: id
        },
        success: function (response) {
            retorno = response;
        }

    });

    if (retorno == 0) {
        alert("Ocurrio un error al tratar de cambiar la contraseña, por favor comuníquese con el administrador del sistema.");

    } else if (retorno == 1) {
        alert('Se ha almacenado correctamente la nueva contraseña');
        loadingFunctions('lib/2usuario/view/formUpdateP.php', 'codigo', '');

    }
}


function addIngenieroProgramacion()
{
    var cadena = "";
    var concat = "'";
    var id_perfil_usuario = $("#List_slIngOT option:selected").val();
    var text_ingeniero = $("#List_slIngOT option:selected").text();

    if (id_perfil_usuario == '') {
        alert('Señor usuario seleccione una opción de la lista.');

    } else {
        $("#tableMoreIngeniero").css('display', 'block');
        if ($("#tr_ingeniero_asig" + id_perfil_usuario).val() == null)
        {
            cadena = '<tr id="tr_ingeniero_asig' + id_perfil_usuario + '">' +
                    '<td><button type="button" name="btn_eliminar_ing_' + id_perfil_usuario + '" id="btn_eliminar_ing_' + id_perfil_usuario + '" class="btn btn-default btn-xs" onclick="delMoreIngeniero(' + id_perfil_usuario + ');contadorFilasTablaGeneral(' + concat + 'ingenieroAddTR' + concat + ',' + concat + 'txt_add_ingeniero' + concat + ');"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>Eliminar</button></td>' +
                    '<td>' + text_ingeniero +
                    '<input type="hidden" name="idAddIngenieroPg[]" id="idAddIngenieroPg" value="' + id_perfil_usuario + '">' +
                    '</td>' +
                    '</tr>';
            $("#ingenieroAddTR").append(cadena);
        } else
        {
            alert('Señor usuario el ingeniero ya esta adicionado.');
            return false;
        }
    }

}



function addEncargadoProgramacion()
{
    var cadena = "";
    var concat = "'";
    var id_perfil_usuario = $("#slIngOT option:selected").val();
    var text_encargado = $("#slIngOT option:selected").text();
    var text_area = $("#slAreaOT option:selected").text();
    var id_area = $("#slAreaOT option:selected").val();

    if (id_perfil_usuario == '') {
        alert('Señor usuario seleccione una opción de la lista.');

    } else {
        $("#tableMoreEncargado").css('display', 'block');
        if ($("#tr_encargado_asig" + id_perfil_usuario).val() == null)
        {
            cadena = '<tr id="tr_encargado_asig' + id_perfil_usuario + '">' +
                    '<td><button type="button" name="btn_eliminar_enc_' + id_perfil_usuario +
                    '" id="btn_eliminar_enc_' + id_perfil_usuario + '" class="btn btn-default btn-xs" onclick="delMoreEncargado(' + id_perfil_usuario + ');contadorFilasTablaGeneral(' + 
                    concat + 'encargadoAddTR' + concat + ',' + concat + 'txt_add_encargado' + concat + ');"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>Eliminar</button></td>' +
                    '<td>' + text_encargado +
                    '<input type="hidden" name="idAddEncargadoPg[]" id="idAddEncargadoPg" value="' + id_perfil_usuario + '">' +
                    '<input type="hidden" name="idAddEncargadoAreaPg[]" id="idAddEncargadoAreaPg" value="' + id_area + '">' +
                    '</td>' +
                    '<td>'+text_area+'</td>' +
                    '</tr>';
            $("#encargadoAddTR").append(cadena);
        } else
        {
            alert('Señor usuario el ingeniero ya esta adicionado.');
            return false;
        }
    }

}