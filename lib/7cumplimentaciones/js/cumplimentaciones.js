
function gritCumplimentaciones() {
    $.ajax({
        type: "POST",
        url: 'lib/7cumplimentaciones/controlador/CT_cumplimentaciones.php',
        async: false,
        data: {
            opcion: 'gritCumplimentaciones'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });
}


function ListTipDescargo(control) {

    var retorno = "";

    $.ajax({
        type: "POST",
        url: 'lib/7cumplimentaciones/controlador/CT_cumplimentaciones.php',
        data: {
            opcion: 'ListTipDescargo'
        },
        async: false,
        success: function (data) {
            retorno += data;

        }
    });

    $("#" + control + "").html(retorno);
}

function AddTypeDescargo(value) {


    if (value == '0') {

        var typedescargo;
        $("#div_subestacion").html("");

        $.ajax({
            type: "POST",
            url: 'lib/7cumplimentaciones/view/formCreateDescargo.php',
            data: {
                dato: ''
            },
            async: false,
            success: function (retu) {
                typedescargo = retu;
            }

        });

        $("#div_typedescargo").html(typedescargo);
        $("#div_typedescargo").dialog({
            width: '500',
            height: '400',
            hide: "scale",
            title: 'Cargar tipo descargo',
            position: 'top',
            modal: true,
            create: function (event) {
                $(event.target).parent().css({top: 100, left: 280});
            },
            buttons: {
                "Cerrar": function ()
                {
                    $(this).dialog('close');
                    $(this).dialog('destroy');
                    $("#div_typedescargo").html("");
                }
            }
        });
    } else {

        var retorno = "";

        $.ajax({
            type: "POST",
            url: 'lib/7cumplimentaciones/controlador/CT_cumplimentaciones.php',
            data: {
                opcion: 'ListIngDescargo',
                tipodescargo_id: value
            },
            async: false,
            success: function (data) {
                retorno += data;

            }
        });

        $("#slc_usr_ingenieros").html(retorno);
    }
}

function saveTipoDescargo() {
    var parametros = '';
    var txt_descripcion = $("#txt_descripcion").val();

    if (txt_descripcion == "") {
        alert("Ingrese el nombre del descargo");
        return false;
    }

    parametros = {
        'opcion': 'saveTipoDescargo',
        txt_descripcion: txt_descripcion
    };

    $.ajax({
        type: 'post',
        url: 'lib/7cumplimentaciones/controlador/CT_cumplimentaciones.php',
        dataType: 'xml',
        async: false,
        data: parametros,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1)
            {
                //alert('Señor usuario (a), la informacion se almacenó exitosamente');            
                var id = $(xml).find('descargo_id').text();
                $("#div_typedescargo").dialog('close');
                $("#div_typedescargo").dialog('destroy');
                $("#div_typedescargo").html("");
                ListTipDescargo('sltipoDescargo');
                $("#sltipoDescargo").val(id);
                AddTypeDescargo(id);

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                return false;
            }

        }
    });
}

function saveCumplimentacion() {

    /*Cargar soporte cumplimentacion*/
    var extensiones_permitidas = new Array(".jpg", ".pdf", ".png", ".jpeg");
    var frm_add_visita_program = document.getElementById("frm_CreateCumplimentacion");
    var data = new FormData(frm_add_visita_program);
    var inputFileImage;
    var file;
    var retorno;
    /**/
    inputFileImage = document.getElementById("docSoporteCumplimentacion");
    var extension_archivo = (inputFileImage.value.substring(inputFileImage.value.lastIndexOf("."))).toLowerCase();
    var permitida = false;
    for (var i = 0; i < extensiones_permitidas.length; i++) {
        if (extensiones_permitidas[i] == extension_archivo) {
            permitida = true;
            break;
        }
    }


    var txt_descargo = $("#txtDescargo").val();
    var sltipoDescargo = $("#sltipoDescargo").val();
    var slSubestacion = $("#slSubestacion").val();
    var txtDateInicio = $("#txtDateInicio").val();
    var txtDateFinal = $("#txtDateFinal").val();
    var slc_jornada = $("#slc_jornada").val();
    var slGestor = $("#slGestor").val();
    var txt_apertura_ope = $("#txt_apertura_ope").val();
    var txtDateApertura = $("#txtDateApertura").val();
    var txt_cierre_ope = $("#txt_cierre_ope").val();
    var txtDateCierre = $("#txtDateCierre").val();
    var txt_obs = $("#txt_obs").val();


    var arregloIngenieros = new Array();
    $('input[name^="idAddIngeniero"]').each(function () {
        arregloIngenieros.push($(this).val());
    });
    var ing = arregloIngenieros;

    if (permitida) {
        file = inputFileImage.files[0];
        var sizeByte = file.size;
        var siezekiloByte = parseInt(sizeByte / 1024);
        if (siezekiloByte <= 5120) {
            /**/
            data.append('opcion', 'saveCumplimentacion');
            data.append('txt_descargo', txt_descargo);
            data.append('sltipoDescargo', sltipoDescargo);
            data.append('slSubestacion', slSubestacion);
            data.append('ing', ing);
            data.append('txtDateInicio', txtDateInicio);
            data.append('txtDateFinal', txtDateFinal);
            data.append('slc_jornada', slc_jornada);
            data.append('slGestor', slGestor);
            data.append('txt_apertura_ope', txt_apertura_ope);
            data.append('txtDateApertura', txtDateApertura);
            data.append('txt_cierre_ope', txt_cierre_ope);
            data.append('txtDateCierre', txtDateCierre);
            data.append('txt_obs', txt_obs);
            data.append('archivo', file);

            $.ajax({
                type: 'POST',
                url: 'lib/7cumplimentaciones/controlador/CT_cumplimentaciones.php',
                contentType: false,
                async: false,
                data: data,
                processData: false,
                cache: false

            }).done(function (response) {
                retorno = response;
            });

            if (retorno == 1) {
                alert("Se ha guardado el descargo exitosamente.");
            } else if (retorno == 2) {
                alert("Se ha presentado un error guardando los daros.");
            }

        } else {
            alert("El archivo supera el peso especificado");
        }

    } else {
        alert("Revise la extension del archivo (solo se perimte archivos con extension " + extensiones_permitidas.join() + ")");
    }

}


function JsonDetalleCumplimentacion(cumplmentacion_id, control) {

    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/7cumplimentaciones/controlador/CT_cumplimentaciones.php',
        async: false,
        data: {
            opcion: 'JsonDetalleCumplimentacion',
            cumplmentacion_id: cumplmentacion_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });


    $("#txtDateApertura").val(jsondata.cumplimentacion_aperturarp);
    $("#txtDateCierre").val(jsondata.cumplimentacion_cierreapertura);
    $("#txtDescargo").val(jsondata.cumplimentacion_descargo);
    /*     $("#slSubestacion").val(jsondata.cumplimentacion_estado);*/
    $("#slGestor").val(jsondata.cumplimentacion_gestor);
    $("#txtDateFinal").val(jsondata.cumplimentacion_fechafincod);
    $("#txtDateInicio").val(jsondata.cumplimentacion_fechainicod);
    /* $("#txtPresInicio").val(jsondata.cumplimentacion_fechamodifico);*/
    $("#slc_jornada").val(jsondata.cumplimentacion_jornada);
    $("#txt_observaciones").val(jsondata.cumplimentacion_obs);
    $("#txt_apertura").val(jsondata.cumplimentacion_operadorapertura);
    $("#txt_cierre").val(jsondata.cumplimentacion_operariocierre);
    $("#txt_ingenieros").html(jsondata.ingenieros);
    // console.log(jsondata.ingenieros);
    $("#sltipoDescargo").val(jsondata.tipodescargo_id);
    $("#slSubestacion").val(jsondata.subestacion_id);
}


function editCumplimentacion() {
    var parametros = '';
    var txt_fechaapertura = $("#txtDateApertura").val();
    var txt_fechacierre = $("#txtDateCierre").val();
    var txt_descargo = $("#txtDescargo").val();
    var txt_tipodescargo = $("#sltipoDescargo").val();
    var txt_fechainicio = $("#txtDateInicio").val();
    var txt_fechafinal = $("#txtDateFinal").val();
    var txt_jornada = $("#slc_jornada").val();
    var txt_gestor = $("#slGestor").val();
    var txt_observaciones = $("#txt_observaciones").val();
    var txt_opapertura = $("#txt_apertura").val();
    var txt_opcierre = $("#txt_cierre").val();
    var txt_ingenieros = $("#txt_ingenieros").val();
    var txt_subestacion = $("#slSubestacion").val();
    var txt_cumplimentacion_id = $("#txt_cumplimentacion_id").val();

    // console.log(txt_jornada);

    if (txt_fechaapertura == "") {
        alert("Seleccione fecha de apertura");
        return false;
    }
    if (txt_fechacierre == "") {
        alert("Seleccione fecha de cierre");
        return false;
    }
    if (txt_descargo == "") {
        alert("Ingrese descargo");
        return false;
    }

    if (txt_tipodescargo == "") {
        alert("Seleccione tipo descargo");
        return false;
    }

    if (txt_fechainicio == "") {
        alert("Seleccione fecha de inicio");
        return false;
    }
    if (txt_fechafinal == "") {
        alert("Seleccione fecha de finalizacion");
        return false;
    }
    if (txt_gestor == "") {
        alert("Seleccione gestor");
        return false;
    }

    if (txt_opapertura == "") {
        alert("Ingresar operario de apertura");
        return false;
    }

    if (txt_opcierre == "") {
        alert("Ingresar operario de cierre");
        return false;
    }
    // if (txt_ingenieros == "") {
    //     alert("Ingresar ingenieros");
    //     return false;
    // }
    if (txt_subestacion == "") {
        alert("Seleccione subestacion");
        return false;
    }

    parametros = {
        'opcion': 'editCumplimentacion',
        'txt_fechaapertura': txt_fechaapertura,
        'txt_fechacierre': txt_fechacierre,
        'txt_descargo': txt_descargo,
        'txt_tipodescargo': txt_tipodescargo,
        'txt_fechainicio': txt_fechainicio,
        'txt_fechafinal': txt_fechafinal,
        'txt_jornada': txt_jornada,
        'txt_gestor': txt_gestor,
        'txt_observaciones': txt_observaciones,
        'txt_opapertura': txt_opapertura,
        'txt_opcierre': txt_opcierre,
        // 'txt_ingenieros': txt_ingenieros,
        'txt_subestacion': txt_subestacion,
        'txt_cumplimentacion_id': txt_cumplimentacion_id
    };

    $.ajax({
        type: 'post',
        url: 'lib/7cumplimentaciones/controlador/CT_cumplimentaciones.php',
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
                agregarDocumentoCumplimentacion(txt_cumplimentacion_id);
                $("#div_typedescargo").dialog('close');
                $("#div_typedescargo").dialog('destroy');
                $("#div_typedescargo").html("");

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                return false;
            }

        }
    });
}

function getJornada() {
    var fecha = $('#txtDateInicio').val();
    var hora = fecha.split(" ");
    var jornada = hora[1].split(":");

    if (jornada[0] > 5 && jornada[0] < 22) {
        $("#slc_jornada").val("1");
    } else {
        $("#slc_jornada").val("2");
    }

}

function addMoreIngeniero()
{
    var cadena = "";
    var concat = "'";
    var id_perfil_usuario = $("#slc_usr_ingenieros option:selected").val();
    var text_ingeniero = $("#slc_usr_ingenieros option:selected").text();

    if (id_perfil_usuario == '') {
        alert('Señor usuario seleccione una opción de la lista.');

    } else {
        $("#tableMoreIngeniero").css('display', 'block');
        if ($("#tr_ingeniero_asig" + id_perfil_usuario).val() == null)
        {
            cadena = '<tr id="tr_ingeniero_asig' + id_perfil_usuario + '">' +
                    '<td><button type="button" name="btn_eliminar_ing_' + id_perfil_usuario + '" id="btn_eliminar_ing_' + id_perfil_usuario + '" class="btn btn-default btn-xs" onclick="delMoreIngeniero(' + id_perfil_usuario + ');contadorFilasTablaGeneral(' + concat + 'ingenieroAddTR' + concat + ',' + concat + 'txt_add_ingeniero' + concat + ');"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>Eliminar</button></td>' +
                    '<td>' + text_ingeniero +
                    '<input type="hidden" name="idAddIngeniero[]" id="idAddIngeniero" value="' + id_perfil_usuario + '">' +
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

function contadorFilasTablaGeneral(id1, id2) {
    var numFilas = $('#' + id1 + ' >tr').length;
    if (numFilas === 0) {
        $("#" + id2 + "").val('');
    } else {
        $("#" + id2 + "").val(numFilas);
    }
}

function delMoreIngeniero(param1)
{
    $("#tr_ingeniero_asig" + param1).remove();
    return false;
}

function clearMoreIngeniero()
{
    $("#tableMoreIngeniero").css('display', 'none');
    $("#ingenieroAddTR").html('');
    $("#txt_add_ingeniero").val('');
    $("#slc_usr_ingenieros").val('');


}

function delMoreEncargado(param1)
{
    $("#tr_encargado_asig" + param1).remove();
    return false;
}

function clearMoreEncargado()
{
    $("#tableMoreEncargado").css('display', 'none');
    $("#encargadoAddTR").html('');
    $("#txt_add_encargado").val('');
    $("#slIngOT").val('');


}

function agregarDocumentoCumplimentacion(id) {
    //declaramos las variables
    var detallepresupuesto_id = id;
    var agregarDocumento;
    
    // mostrarDocumentos();
    //envio por ajax
    $.ajax({
        type: "POST",
        url: 'lib/7cumplimentaciones/view/formAgregarDocumentoCumplimentacion.php',
        data: {
            detallepresupuesto_id: detallepresupuesto_id
        },
        async: false,
        success: function (retu) {
            agregarDocumento = retu;
        }

    });

    //enviamos modal a campo div_agregarDocumento en html
    $("#div_agregarDocumento").html(agregarDocumento);
    $("#div_agregarDocumento").dialog({
        width: '800',
        height: '300',
        hide: "scale",
        title: 'Agregar Documento Cumplimentación',
        position: 'top',
        modal: true,
        create: function (event) {
            $(event.target).parent().css({
                top: 120,
                left: 280
            });
        },
        buttons: 
        {
            // "Guardar": function () {
            //     guardarDocumentosCumplimentacion();
            // },
            "Cerrar": function () {
                $(this).dialog('close');
                $(this).dialog('destroy');
                $("#div_agregarDocumento").html("");
            }
        }
    });
}