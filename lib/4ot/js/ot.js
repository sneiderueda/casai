/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function gritPresupuestoOT() {
    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'gritPresupuestoOT'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });

}

function ListActividadesPresupuestoOT(detallepresupuesto_id) {

    var cadena = "";
    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'ListActividadesPresupuestoOT',
            detallepresupuesto_id: detallepresupuesto_id

        },
        success: function (retu) {
            $("#ActividadesPresupuestoAsignadasOT").html(retu);
            $("#ActividadesPresupuestoAsignadasOT").css("display", "block");
            $("#ActividadesPresupuestoOT").css("display", "none");
        }

    });
}


function SaveOT() {
    var parametros = '';
    var xml = "";
    var detallepresupuesto_id = $("#detallepresupuesto_id").val();
    var ot_id = $("#ot_id").val();
    var txt_num_orden = $("#txt_num_orden").val();
    var txt_orden_gom = $("#txt_orden_gom").val();
    var txt_contratista = $("#txt_contratista").val();
    var txt_detalle = $("#txt_detalle").val();
    var txtFechaEmision = $("#txtFechaEmision").val();
    var txtPresInicioOT = $("#txtPresInicioOT").val();
    var txtPresFinOT = $("#txtPresFinOT").val();
    var txt_orden_presupuestal = $("#txt_orden_presupuestal").val();
    var txt_pep = $("#txt_pep").val();


    if (txt_num_orden == "") {
        alert("Por favor ingrese el numero de la orden");
        return false;
    }
    if (txt_contratista == "") {
        alert("Por favor ingrese el nombre del contratista");
        return false;
    }
    if (txtFechaEmision == "") {
        alert("Por favor ingrese la fecha de emision de la OT");
        return false;
    }
    if (txt_detalle == "") {
        alert("Por favor ingrese el detalle del proyecto.");
        return false;
    }
   /* if (txtPresInicioOT == "") {
        alert("Por favor ingrese la fecha de inicio de la orden de trabajo");
        return false;
    }*/

    parametros = {
        'opcion': 'SaveOT',
        detallepresupuesto_id: detallepresupuesto_id,
        ot_id: ot_id,
        txt_num_orden: txt_num_orden,
        txt_orden_gom: txt_orden_gom,
        txt_contratista: txt_contratista,
        txt_detalle: txt_detalle,
        txtFechaEmision: txtFechaEmision,
        txtPresInicioOT: txtPresInicioOT,
        txtPresFinOT: txtPresFinOT,
        txt_orden_presupuestal: txt_orden_presupuestal,
        txt_pep: txt_pep
    };
    $.ajax({
        type: 'post',
        url: 'lib/4ot/controlador/CT_ot.php',
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
                var insert_ot_id = $(xml).find('ot_id').text();
                //ListActividadesPresupuestoOT(detallepresupuesto_id);                
                loadingOT('lib/4ot/view/formOT.php', 'contenido', detallepresupuesto_id, insert_ot_id);
                parametros = "";


            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                gritPresupuestoOT();
                return false;
            }

        }
    });
}
function loadingOT(url, div, data, ot) {
    var retorno;

    $.ajax({
        type: "POST",
        url: url,
        data: {
            data: data,
            ot: ot
        },
        async: false,
        success: function (retu) {
            retorno = retu;
        }
    });

    $("#" + div + "").html(retorno);

}

function JsonDetalleOT(detallepresupuesto_id) {

    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'JsonDetalleOT',
            detallepresupuesto_id: detallepresupuesto_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    if (jsondata.ordentrabajo_id != null && jsondata.ordentrabajo_id != "null") {
        $("#ot_id").val(jsondata.ordentrabajo_id);
        $("#txt_num_orden").val(jsondata.ordentrabajo_num);
        $("#txt_orden_gom").val(jsondata.ordentrabajo_gom);
        $("#txt_contratista").val(jsondata.ordentrabajo_contratista);
        $("#txt_detalle").val(jsondata.ordentrabajo_obs);
        $("#txtFechaEmision").val(jsondata.ordentrabajo_fechaemision);
        $("#txtPresInicioOT").val(jsondata.ordentrabajo_fechaini);
        $("#txtPresFinOT").val(jsondata.ordentrabajo_fechafin);
        $("#txt_orden_presupuestal").val(jsondata.ordentrabajo_ordenpresupuestal);
        $("#txt_pep").val(jsondata.ordentrabajo_pep);
    }


}

function DivProgramarOT(prusupuesto_id,ot_id) {

    var data;
    $("#programar_OT").html("");

    $.ajax({
        type: "POST",
        url: 'lib/4ot/view/formEditProg.php',
        data: {
            prusupuesto_id: prusupuesto_id,
            ot_id : ot_id
        },
        async: false,
        success: function (retu) {
            data = retu;
        }

    });

    $("#programar_OT").html(data);
    $("#programar_OT").dialog({
        width: '800',
        height: '1000',
        hide: "scale",
        title: 'Orden de trabajo interna',
        position: 'top',
        modal: true,
        //position: [280,280],
        create: function (event) {
            $(event.target).parent().css({top: 300, left: 300});
        },
        buttons: {
            "Cerrar": function ()
            {
                $(this).dialog('close');
                $(this).dialog('destroy');
                $("#programar_OT").html('');
            }
        }
    });
}

function SaveProgramaOT(presupuesto_id) {

    var slAreaOT = $("#slAreaOT").val();
    var slIngOT = $("#slIngOT").val();
    var txtInicioOT = $("#txtInicioOT").val();
    var txtHoraIni = $("#txtHoraIni").val();
    var txtFnicioOT = $("#txtFnicioOT").val();
    var txtHoraFin = $("#txtHoraFin").val();
    var txt_vehiculo = $("#txt_vehiculo").val();
    var txt_obs_programacion = $("#txt_obs_programacion").val();
    var txt_ot = $('#txt_ot').val();

    var arregloIngenieros = new Array();
    $('input[name^="idAddIngenieroPg"]').each(function () {
        arregloIngenieros.push($(this).val());
    });
    var ing = arregloIngenieros;

    /*Encargados*/
    var num_registros = $('#tb_encargados >tbody >tr').length;
    /*
     if (num_registros == 0) {
     alert("Favor agregar por lo menos un responsable a la actividad");
     return false;
     }
     */

    var arregloEncargados = new Array();
    $('input[name^="idAddEncargadoPg"]').each(function () {
        arregloEncargados.push($(this).val());
    });
    var enc = arregloEncargados;

    var arregloEncargadosArea = new Array();
    $('input[name^="idAddEncargadoAreaPg"]').each(function () {
        arregloEncargadosArea.push($(this).val());
    });
    var enc_area = arregloEncargadosArea;
    /**/

    var data;
    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        data: {
            opcion: 'SaveProgramaOT',
            presupuesto_id: presupuesto_id,
            slAreaOT: slAreaOT,
            slIngOT: slIngOT,
            txtInicioOT: txtInicioOT,
            txtHoraIni: txtHoraIni,
            txtFnicioOT: txtFnicioOT,
            txtHoraFin: txtHoraFin,
            listaIngenieros: ing,
            listaEncargados: enc,
            listaEncargadosArea: enc_area,
            txt_obs_programacion: txt_obs_programacion,
            txt_vehiculo: txt_vehiculo,
            txt_add_encargado: num_registros,
            txt_ot : txt_ot

        },
        async: false,
        success: function (retu) {
            data = retu;
        }
    });

    if (data == '1' || data == 1)
    {
        alert('Información guardada correctamente.');
        $("#programar_OT").dialog('close');
        $("#programar_OT").dialog('destroy');
        $("#programar_OT").html('');
        return false;

    } else {

        alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
        return false;
    }
}

function JsonPresupuesto(presupuesto_id,ot_id) {

    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'JsonPresupuesto',
            presupuesto_id: presupuesto_id,
            ot_id : ot_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    console.log(ot_id);
    return jsondata;
}

function JsonTecnicosPresupuesto(presupuesto_id) {

    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'JsonTecnicosPresupuesto',
            presupuesto_id: presupuesto_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    return jsondata;
}

function JsonEncargadosPresupuesto(presupuesto_id) {

    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'JsonEncargadosPresupuesto',
            presupuesto_id: presupuesto_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    return jsondata;
}

function MostrarResponsablesTb(id_presupuesto) {
    var jsondata;
    var i;
    var responsable = "";

    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'JsonEncargadosPresupuesto',
            presupuesto_id: id_presupuesto
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    for (i = 0; i < jsondata.registros; i++) {
        responsable += jsondata.encargados[i].usuario_nombre + ' ' + jsondata.encargados[i].usuario_apellidos + '</br>';
    }

    $("#" + id_presupuesto + " td.Responsable").html(responsable);
}

function gritEjecutarOT() {
    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'gritEjecutarOT'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });

}

function loadingSeguimientos(url, div, baremo_id, ordentrabajo_id, presupuesto_id, tipobaremo_id, presupuesto_progestado, presupuesto_porcentaje, id_seguimiento) {
    var retorno;

    $.ajax({
        type: "POST",
        url: url,
        data: {
            baremo_id: baremo_id,
            ordentrabajo_id: ordentrabajo_id,
            presupuesto_id: presupuesto_id,
            tipobaremo_id: tipobaremo_id,
            presupuesto_progestado: presupuesto_progestado,
            presupuesto_porcentaje: presupuesto_porcentaje,
            id_seguimiento: id_seguimiento
        },
        async: false,
        success: function (retu) {
            retorno = retu;
        }
    });

    $("#" + div + "").html(retorno);
    if (id_seguimiento == "") {
        $("#Json_seg").css("display", "none");
        $("#Seg_data").css("display", "block");
    } else {
        $("#Json_seg").css("display", "block");
        $("#Seg_data").css("display", "none");
    }

}
function DivSeguimientoJson(seguimiento_id) {
    if (seguimiento_id == "") {
        $("#Json_seg").css("display", "none");
        $("#Seg_data").css("display", "block");
        $("#id_seguimiento").val("");
    } else {
        $("#Json_seg").css("display", "block");
        $("#Seg_data").css("display", "none");
    }

}

function AddSoporteSeguimiento() {

    var inicial = parseInt($("#id_inicial_v").val());
    //var id_actual_v=$("#id_actual_v").val(total);
    var input = '<input type="file" class="archivo_doc_req" name="archivo_' + inicial + '" id="archivo_' + inicial + '" >';
    var elimine = '<button type="button" name="btn_eliminar_doc" id="btn_eliminar_doc" class="btn btn-danger btn-xs" onclick="eliminardoc(' + inicial + ')"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>Eliminar</button>';
    var content = "<tr id='tr_" + inicial + "'><td>" + elimine + "</td><td>" + input + "</td></tr>";

    $("#table-adj-docu").append(content);
    var total = inicial + 1;

    $("#id_inicial_v").val(total);
}

function AddSoporteSeguimientoModificado() {

    var inicial = parseInt($("#id_inicial_js").val());
    //var id_actual_v=$("#id_actual_v").val(total);
    var input = '<input type="file" class="archivo_doc_req_mod" name="archivo_' + inicial + '" id="archivo_' + inicial + '" >';
    var elimine = '<button type="button" name="btn_eliminar_doc_js" id="btn_eliminar_doc_js" class="btn btn-danger btn-xs" onclick="eliminardoc(' + inicial + ')"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>Eliminar</button>';
    var content = "<tr id='tr_" + inicial + "'><td>" + elimine + "</td><td>" + input + "</td></tr>";

    $("#table-adj-docu_js").append(content);
    var total = inicial + 1;

    $("#id_inicial_js").val(total);
}

function eliminardoc(inicial) {
    var confrimar = confirm("Esta seguro que desea eliminar el archivo");
    if (confrimar)
    {
        $("#tr_" + inicial).remove();

    }
}

function SaveSeguimientoAct(mostrar) {

    var baremo_id = $("#baremo_id").val();
    var ordentrabajo_id = $("#ordentrabajo_id").val();
    var presupuesto_id = $("#presupuesto_id").val();
    var tipobaremo_id = $("#tipobaremo_id").val();
    var slc_estado_actividad = $("#slc_estado_actividad").val();
    var porc_av = $("#porc_av").val();
    var txtInicioSeg = $("#txtInicioSeg").val();
    var txtHoraIniSeg = $("#txtHoraIniSeg").val();
    var txtFnicioSeg = $("#txtFnicioSeg").val();
    var txtHoraFinSeg = $("#txtHoraFinSeg").val();
    var txt_Obs_seg = $("#txt_Obs_seg").val();
    var num_seg = $("#num_seg").val();
    var presupuesto_porcentaje = $("#presupuesto_porcentaje").val();
    var id_seguimiento = $("#id_seguimiento").val();
    var txt_revision = $("#txt_revision").val();


    var extensiones_permitidas = new Array(".jpg", ".pdf", ".png", ".dwg", ".xlsx", ".docx", ".jpeg");
    var formElement = document.getElementById("frm_DataSeguimientoOT");
    var data = new FormData(formElement);
    var inputFileImage;
    var file;
    var id_cambiante;
    var id_cambiante2;
    var errores = 0;
    var espaciovacio = 0;
    var i = '';
    var cadena;
    
    $(".archivo_doc_req").each(function (index) {
        id_cambiante = $(this).attr("id");
        id_cambiante2 = $(this).attr("id");
        cadena += "-" + id_cambiante2;
        inputFileImage = document.getElementById(id_cambiante);
        var extension = (inputFileImage.value.substring(inputFileImage.value.lastIndexOf("."))).toLowerCase();
        var permitida = false;

        if (extension == "" || extension == " " || extension == null) {

            espaciovacio = espaciovacio + 1;
        }

        for (i = 0; i <= extensiones_permitidas.length; i++) {

            if (extensiones_permitidas[i] == extension) {
                permitida = true;
                break;
            }
        }
        if (permitida) {
            file = inputFileImage.files[0];
            data.append(id_cambiante, file);
            id_cambiante = "";
            inputFileImage = "";
            file = "";
        } else {

            errores = errores + 1;
        }
    });

    if (espaciovacio != 0) {
        alert("Por favor elimine opción de - adicionar archivo - si no va cargar otro documento.");
        return false;
    }

    if (errores == 0) {

        data.append('opcion', 'SaveSeguimientoAct');
        data.append('baremo_id', baremo_id);
        data.append('ordentrabajo_id', ordentrabajo_id);
        data.append('presupuesto_id', presupuesto_id);
        data.append('tipobaremo_id', tipobaremo_id);
        data.append('porc_av', porc_av);
        data.append('slc_estado_actividad', slc_estado_actividad);
        data.append('txtInicioSeg', txtInicioSeg);
        data.append('txtHoraIniSeg', txtHoraIniSeg);
        data.append('txtFnicioSeg', txtFnicioSeg);
        data.append('txtHoraFinSeg', txtHoraFinSeg);
        data.append('txt_Obs_seg', txt_Obs_seg);
        data.append('num_seg', num_seg);
        data.append('txt_revision', txt_revision);


        var url = "lib/4ot/controlador/CT_ot.php";
        var retorno_docs;
        $.ajax({
            url: url,
            type: 'POST',
            contentType: false,
            data: data,
            async: false,
            processData: false,
            cache: false
        }).done(function (retu) {
            retorno_docs = retu;
        });


        if (retorno_docs == 1 || retorno_docs == 3) {

            alert("Registro almacenado satisfactoriamente");
            if (mostrar == "1") {
                loadingSeguimientos('lib/4ot/view/formSeguimientoGest.php', 'contenido', baremo_id, ordentrabajo_id, presupuesto_id, tipobaremo_id, slc_estado_actividad, presupuesto_porcentaje, id_seguimiento);
            } else {
                loadingSeguimientos('lib/4ot/view/formSeguimiento.php', 'contenido', baremo_id, ordentrabajo_id, presupuesto_id, tipobaremo_id, slc_estado_actividad, presupuesto_porcentaje, id_seguimiento);
            }

            // ListSeguimientoPresup(presupuesto_id, slc_estado_actividad, presupuesto_porcentaje);
        } else if (retorno_docs == 2) {
            alert("Ocurrio algun error al tratar de ingresar los documentos comuniquese con soporte tecnico");

        }

    } else if (errores != 0) {
        alert("Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join() + "\n O revise que todos los documentos esten anexos ");

    }
}

function ListSeguimientoPresup(presupuesto_id, estado_act, presupuesto_porcentaje, view) {

    $.ajax({
        type: "POST",
        url: "lib/4ot/controlador/CT_ot.php",
        async: false,
        data: {
            opcion: 'ListSeguimientoPresup',
            presupuesto_id: presupuesto_id,
            estado_act: estado_act,
            presupuesto_porcentaje: presupuesto_porcentaje,
            view: view

        },
        success: function (retu) {
            $("#Seguimiento_actividad").html(retu);

        }

    });
}

function DeleteSeguimientoActi(seguimiento_id, presupuesto_id, estado_act, presupuesto_porcentaje, view) {

    var confrimar = '';

    confrimar = confirm("Esta seguro que desea eliminar el seguimiento de la actividad.");

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: "lib/4ot/controlador/CT_ot.php",
            data: {
                opcion: 'DeleteSeguimientoActi',
                seguimiento_id: seguimiento_id

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Información guardada correctamente.');
            ListSeguimientoPresup(presupuesto_id, estado_act, presupuesto_porcentaje, view);
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function validarPorcentajeAvcIng(porc_act) {
    var insert_porc = $("#porc_av_cal").val();
    var conv_porc = '';

    if (insert_porc > 100) {
        alert("El porcentaje de avance no puede ser mayor que el 100%");
        $("#porc_av_cal").val(0);
    }

    //Convertir porcentaje de actividad en porcentaje
    conv_porc = parseFloat((porc_act * insert_porc) / 100);
    if (conv_porc == porc_act) {
        $("#slc_estado_actividad").val('RESUELTA');
    }
    if (conv_porc < porc_act) {
        $("#slc_estado_actividad").val('PENDIENTE');
    }

    $("#porc_av").val(conv_porc);

}

function validarPorcentajeAvc(porc_act) {
    var insert_porc = $("#porc_av_cal").val();
    var conv_porc = '';

    if (insert_porc > 100) {
        alert("El porcentaje de avance no puede ser mayor que el 100%");
        $("#porc_av_cal").val(0);
    }

    //Convertir porcentaje de actividad en porcentaje
    conv_porc = parseFloat((porc_act * insert_porc) / 100);
    if (conv_porc == porc_act) {
        $("#slc_estado_actividad").val('FINALIZADA');
    }
    if (conv_porc < porc_act) {
        $("#slc_estado_actividad").val('PENDIENTE');
    }

    $("#porc_av").val(conv_porc);
}

function JsonSeguimiento(seguimiento_id, pres_porc) {

    var jsondata;
    var cal_porc;

    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'JsonSeguimiento',
            seguimiento_id: seguimiento_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    cal_porc = parseFloat((jsondata.seguimiento_avance * 100) / pres_porc);
    $("#porc_avJS").val(cal_porc);
    $("#txtInicioSegJS").val(jsondata.seguimiento_fechaini);
    $("#txtHoraIniSegJS").val(jsondata.seguimiento_horaini);
    $("#txtFnicioSegJS").val(jsondata.seguimiento_fechafin);
    $("#txtHoraFinSegJS").val(jsondata.seguimiento_horafin);
    $("#txt_Obs_segJS").val(jsondata.seguimiento_obs);
    $("#txt_revisionJS").val(jsondata.seguimiento_revision);

}

function ListSoporteSeguimiento(seguimiento_id, presupuesto_estado_act) {
    var cadena = "";
    $("#table-adj-docu_js").html('');
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'ListSoporteSeguimiento',
            seguimiento_id: seguimiento_id
        },
        success: function (datos) {
            $.each(datos.datos, function (i, item) {
                var concat = "'";
                var soporteseguimiento_id = item.soporteseguimiento_id;
                var soporte_id = item.soporte_id;
                var soporte_nombre = item.soporte_nombre;
                var soporte_tipo = item.soporte_tipo;


                cadena = '<tr id="tr_' + soporteseguimiento_id + '">' +
                        '<td>';

                if (presupuesto_estado_act != "FINALIZADA" || presupuesto_estado_act != "FACTURADA") {

                    cadena += '<button type="button" name="btn_eliminar_docJS" id="btn_eliminar_docJS" class="btn btn-default btn-xs" onclick="DeleteDocSeguimiento(' + soporteseguimiento_id + ',' + seguimiento_id + ',' + concat + presupuesto_estado_act + concat + ')"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>Eliminar</button>';
                }
                if (soporte_tipo == "image/jpeg" || soporte_tipo == "image/png" || soporte_tipo == "application/pdf") {
                    cadena += '<a type="button" href="lib/docs/' + soporte_nombre + '" target="_blank"><button type="button" name="btn_ver_doc_desc" id="btn_ver_doc_desc" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>Ver</button></a>';
                    // cadena += '<button type="button" name="btn_ver_doc" id="btn_ver_doc" class="btn btn-default btn-xs" onclick="VerDoc(' + concat + soporte_nombre + concat + ',' + concat + soporte_tipo + concat + ')"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>Ver</button>';
                } else {
                    cadena += '<a href="lib/docs/' + soporte_nombre + '"><button type="button" name="btn_ver_doc_desc" id="btn_ver_doc_desc" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>Ver</button></a>';
                }
                // cadena += '<a><button type="button" name="btn_ver_doc" id="btn_ver_doc" class="btn btn-default btn-xs" onclick="VerDoc(' + concat + soporte_nombre + concat + ',' + concat + soporte_tipo + concat + ')"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>Ver</button></a>' +
                // cadena += '<button type="button" name="btn_ver_doc" id="btn_ver_doc" class="btn btn-default btn-xs" onclick="VerDoc(' + concat + soporte_nombre + concat + ',' + concat + soporte_tipo + concat + ')"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>Ver</button>' +
                cadena += '</td><td>' + soporte_nombre + '</td>' +
                        '</tr>';
                $("#table-adj-docu_js").append(cadena);

            });
            var nFilas = $("#table-adj-docu_js tr").length;
            $("#id_inicial_js").val(nFilas + 1);

        }

    });
}

function VerDoc(nombre_doc, tipo) {

    $("#dialog_arch").html('');
    $("#dialog_arch").dialog({
        modal: true,
        title: nombre_doc,
        width: 650,
        height: 650,
        buttons: {
            Close: function () {
                $(this).dialog('close');
            }
        },
        open: function () {

            if (tipo == 'pdf' || tipo == 'PDF' || tipo == 'application/pdf') {

                var object = "<object data=\"{FileName}\" type=\"application/pdf\" width=\"600px\" height=\"600px\">";
                object += "If you are unable to view file, you can download from <a href=\"{FileName}\">here</a>";
                object += " or download <a target = \"_blank\" href = \"http://get.adobe.com/reader/\">Adobe PDF Reader</a> to view the file.";
                object += "</object>";
                object = object.replace(/{FileName}/g, "lib/docs/" + nombre_doc);
                $("#dialog_arch").html(object);
            } else {
                var object = "<img src='lib/docs/" + nombre_doc + "' alt='" + nombre_doc + "'>";
                $("#dialog_arch").html(object);
            }
        }
    });

}

function DeleteDocSeguimiento(soporte_seguimiento_id, seguimiento_id, presupuesto_estado_act) {

    var confrimar = '';

    confrimar = confirm("Esta seguro que desea eliminar el soporte");

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: "lib/4ot/controlador/CT_ot.php",
            data: {
                opcion: 'DeleteDocSeguimiento',
                soporte_seguimiento_id: soporte_seguimiento_id

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Información actualizada correctamente.');
            ListSoporteSeguimiento(seguimiento_id, presupuesto_estado_act);
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function UpdateObsDocsSeguimiento(mostrar) {

    var id_seguimiento = $("#id_seguimiento").val();
    var presupuesto_id = $("#presupuesto_id").val();
    var slc_estado_actividad = $("#slc_estado_actividad").val();
    var presupuesto_porcentaje = $("#presupuesto_porcentaje").val();
    var txt_Obs_seg = $("#txt_Obs_segJS").val();

    var baremo_id = $("#baremo_id").val();
    var ordentrabajo_id = $("#ordentrabajo_id").val();
    var tipobaremo_id = $("#tipobaremo_id").val();

    var extensiones_permitidas = new Array(".jpg", ".pdf", ".png", ".dwg", ".xlsx", ".docx", ".jpeg");
    var formElement = document.getElementById("frm_DataJS_seguimiento");
    var data = new FormData(formElement);
    var inputFileImage;
    var file;
    var id_cambiante;
    var id_cambiante2;
    var errores = 0;
    var espaciovacio = 0;
    var i = '';
    var cadena;
    $(".archivo_doc_req_mod").each(function (index) {
        id_cambiante = $(this).attr("id");
        id_cambiante2 = $(this).attr("id");
        cadena += "-" + id_cambiante2;
        inputFileImage = document.getElementById(id_cambiante);
        var extension = (inputFileImage.value.substring(inputFileImage.value.lastIndexOf("."))).toLowerCase();
        var permitida = false;

        if (extension == "" || extension == " " || extension == null) {

            espaciovacio = espaciovacio + 1;
        }

        for (i = 0; i <= extensiones_permitidas.length; i++) {

            if (extensiones_permitidas[i] == extension) {
                permitida = true;
                break;
            }
        }
        if (permitida) {
            file = inputFileImage.files[0];
            data.append(id_cambiante, file);
            id_cambiante = "";
            inputFileImage = "";
            file = "";
        } else {

            errores = errores + 1;
        }
    });
    if (espaciovacio != 0) {
        alert("Por favor elimine opción de - adicionar archivo - si no va cargar otro documento.");
        return false;
    }

    if (errores == 0) {

        data.append('opcion', 'UpdateObsDocsSeguimiento');
        data.append('id_seguimiento', id_seguimiento);
        data.append('txt_Obs_seg', txt_Obs_seg);



        var url = "lib/4ot/controlador/CT_ot.php";
        var retorno_docs;
        $.ajax({
            url: url,
            type: 'POST',
            contentType: false,
            data: data,
            async: false,
            processData: false,
            cache: false
        }).done(function (retu) {
            retorno_docs = retu;
        });


        if (retorno_docs == 1 || retorno_docs == 3) {

            alert("Registro almacenado satisfactoriamente");
            if (mostrar == "1") {
                loadingSeguimientos('lib/4ot/view/formSeguimientoGest.php', 'contenido', baremo_id, ordentrabajo_id, presupuesto_id, tipobaremo_id, slc_estado_actividad, presupuesto_porcentaje, id_seguimiento);
            } else {
                loadingSeguimientos('lib/4ot/view/formSeguimiento.php', 'contenido', baremo_id, ordentrabajo_id, presupuesto_id, tipobaremo_id, slc_estado_actividad, presupuesto_porcentaje, id_seguimiento);
            }

            //ListSeguimientoPresup(presupuesto_id, slc_estado_actividad, presupuesto_porcentaje);
        } else if (retorno_docs == 2) {
            alert("Ocurrio algun error al tratar de ingresar los documentos comuniquese con soporte tecnico");

        }

    } else if (errores != 0) {
        alert("Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join() + "\n O revise que todos los documentos esten anexos ");

    }
}

function DivEditDescargo(orden_trabajo_id, presupuesto_id) {
    var data;
    $("#Gen_Descargo").html("");

    $.ajax({
        type: "POST",
        url: 'lib/4ot/view/formEditDescargo.php',
        data: {
            orden_trabajo_id: orden_trabajo_id,
            presupuesto_id: presupuesto_id
        },
        async: false,
        success: function (retu) {
            data = retu;
        }

    });

    $("#Gen_Descargo").html(data);
    $("#Gen_Descargo").dialog({
        width: '700px',
        height: '515',
        hide: "515",
        title: 'Generar Descargo',
        position: 'top',
        modal: true,
        //position: [280,280],
        create: function (event) {
            $(event.target).parent().css({top: 100, left: 620});
        },
        buttons: {
            "Cerrar": function ()
            {
                $(this).dialog('close');
                $(this).dialog('destroy');
                $("#Gen_Descargo").html('');
            }
        }
    });
}

function SaveDescargo() {

    var ordentrabajo_id = $("#ordentrabajo_id").val();
    var presupuesto_id = $("#presupuesto_id").val();
    var txt_des_act = $("#txt_des_act").val();
    var tipo_descargo = $('input:radio[name=rd_tipoDescargo]:checked').val();
    var riesgo_disparo = $('input:radio[name=rd_Disparo]:checked').val();
    var anexo = $('input:radio[name=rd_anexo]:checked').val();
    var responsable_codensa = $("#txt_respo_codensa").val();
    var data;

    if (txt_des_act == "") {
        alert("Ingrese la actividad a realizar");
        return false;
    }

    if (responsable_codensa == "") {
        alert("Ingrese el nombre del responsable de CODENSA");
        return false;
    }


    $.ajax({
        type: "POST",
        url: "lib/4ot/controlador/CT_ot.php",
        data: {
            opcion: 'SaveDescargo',
            txt_des_act: txt_des_act,
            tipo_descargo: tipo_descargo,
            riesgo_disparo: riesgo_disparo,
            anexo: anexo,
            responsable_codensa: responsable_codensa,
            ordentrabajo_id: ordentrabajo_id,
            presupuesto_id: presupuesto_id

        },
        async: false,
        success: function (retu) {
            data = retu;
        }
    });

    if (data != '0' || data != 0)
    {
        //alert('Información almacenada correctamente.');
        $("#Gen_Descargo").dialog('close');
        $("#Gen_Descargo").dialog('destroy');
        $("#Gen_Descargo").html('');
        DescargarDescargo(data);
        // ListSoporteSeguimiento(seguimiento_id, presupuesto_estado_act);
        return false;

    } else {

        alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
        return false;
    }


}

function JsonDescargoOT(ordentrabajo_id, presupuesto_id) {

    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'JsonDescargoOT',
            ordentrabajo_id: ordentrabajo_id,
            presupuesto_id: presupuesto_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    return jsondata;
}

function gritGestionAct() {
    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'gritGestionAct'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });

}

function JsonDetalleActividad(presupuesto_id) {

    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/4ot/controlador/CT_ot.php',
        async: false,
        data: {
            opcion: 'JsonDetalleActividad',
            presupuesto_id: presupuesto_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    return jsondata;
}

function DivIncremento(detallepresupuesto_id) {

    var data;
    $("#div_incremento").html("");

    $.ajax({
        type: "POST",
        url: 'lib/4ot/view/formIncremento.php',
        data: {
            detallepresupuesto_id: detallepresupuesto_id
        },
        async: false,
        success: function (retu) {
            data = retu;
        }

    });

    $("#div_incremento").html(data);

    $("#div_incremento").dialog({
        width: '950',
        height: '470',
        hide: "scale",
        title: 'Incremento del presupuesto',
        position: 'top',
        modal: true,
        //position: [280,280],
        create: function (event) {
            $(event.target).parent().css({top: 100, left: 200});
        },
        buttons: {
            "Cerrar": function ()
            {
                $(this).dialog('close');
                $(this).dialog('destroy');
                $("#div_incremento").html('');
            }
        }
    });
}

function JsonDetallePresupuestoIncremento(detallepresupuesto_id) {

    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        async: false,
        data: {
            opcion: 'JsonDetallePresupuesto',
            detallepresupuesto_id: detallepresupuesto_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });
    return jsondata;
}

function JsonDetallePresupuestoIncrementos(detallepresupuesto_id) {

    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        async: false,
        data: {
            opcion: 'JsonDetallePresupuestoIncrementos',
            detallepresupuesto_id: detallepresupuesto_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });
    return jsondata;
}

function TipoIncrementoPresupuesto(detallepresupuesto_id) {

    var tipo = $("#slc_tipo_incremento").val();
    var porcentaje = $("#txt_porc_incremento").val();
    var totalPresupuestop = $("#txt_totalPresupuesto").val();

    var total_incrementop = "";
    var total_incremento_presupuestop = "";

    var totalPresupuesto = totalPresupuestop.replace(/\./g, '');
    var total_incremento = total_incrementop.replace(/\./g, '');
    var total_incremento_presupuesto = total_incremento_presupuestop.replace(/\./g, '');

    if (tipo != 3) {
        if (porcentaje == "") {
            alert("Señor usuario, favor ingresar el porcentaje a incrementar.");
            return false;
        }

        if (porcentaje > 1) {
            alert("El porcentaje no puede ser mayor que 1.");
            $("#txt_porc_incremento").val('');
            $("#slc_tipo_incremento").val('0');
            return false;

        }
    }

    if (tipo == 1) {//incremento por actividades levantamiento

        var sumLevantamiento = "";

        $.ajax({
            type: "POST",
            url: 'lib/4ot/controlador/CT_ot.php',
            async: false,
            data: {
                opcion: 'SumActividadesLevantaiento',
                detallepresupuesto_id: detallepresupuesto_id
            },
            success: function (retu) {
                sumLevantamiento = retu;
            },
            dataType: "json"
        });


        total_incremento = Math.round((sumLevantamiento * porcentaje));
        total_incremento_presupuesto = Math.round(parseFloat(total_incremento) + parseFloat(totalPresupuesto));

        total_incremento = number_format(total_incremento, 0, ',', '.');
        total_incremento_presupuesto = number_format(total_incremento_presupuesto, 0, ',', '.');
        totalPresupuesto = number_format(totalPresupuesto, 0, ',', '.');

        $("#txt_totalPresupuesto").val(totalPresupuesto);
        $("#txt_totalIncremento").val(total_incremento);
        $("#txt_totalPresupuestoIncremento").val(total_incremento_presupuesto);

    } else if (tipo == 2) {//incremento a todo el presupuesto

        /*traer el valor del incremento por levantamiento*/
        var incremento_levantamiento_valor = 0;
        if ($("#tr_incremento_add_1").length > 0) {
            var incremento_levantamiento = document.getElementById('tr_incremento_add_1').getElementsByTagName('td')[3].innerHTML;
            if (incremento_levantamiento != "") {
                incremento_levantamiento_valor = incremento_levantamiento.replace(/\./g, '');
            }
        }

        // var incremento_levantamiento = $("tr_incremento_add_1 td")[0].innerHTML;

        /**/
        var suma_presupuesto_incremento_levantamiento = Math.round(parseFloat(totalPresupuesto) + parseFloat(incremento_levantamiento_valor));
        total_incremento = Math.round(suma_presupuesto_incremento_levantamiento * porcentaje);


        total_incremento_presupuesto = Math.round(parseFloat(total_incremento) + parseFloat(totalPresupuesto));

        total_incremento = number_format(total_incremento, 0, ',', '.');
        total_incremento_presupuesto = number_format(total_incremento_presupuesto, 0, ',', '.');
        totalPresupuesto = number_format(totalPresupuesto, 0, ',', '.');

        $("#txt_totalPresupuesto").val(totalPresupuesto);
        $("#txt_totalIncremento").val(total_incremento);
        $("#txt_totalPresupuestoIncremento").val(total_incremento_presupuesto);

    } else if (tipo == 3) {//Se aplica los dos incrementos


    }

}

function SaveIncremento(detallepresupuesto_id) {

    var txt_totalPresupuesto = $("#txt_totalPresupuesto").val();
    var txt_porc_incremento = $("#txt_porc_incremento").val();
    var slc_tipo_incremento = $("#slc_tipo_incremento").val();
    var txt_totalIncremento = $("#txt_totalIncremento").val();
    var txt_totalPresupuestoIncremento = $("#txt_totalPresupuestoIncremento").val();
    var txt_total_Incrementos = $("#txt_total_Incrementos").val();
    var txt_porc_incremento_total = $("#txt_porc_incremento_total").val();
    var data;

    if (slc_tipo_incremento == "") {
        alert("Ingrese si aplica algun tipo de incrememto");
        return false;
    }

    if (txt_porc_incremento == "0") {

        slc_tipo_incremento = "0";
    }


    /*validar si hay mas de 1 incremento*/
    if ($('#incrementoAddTR tr').length != 0) { //si hay varios incrementos agregados

        /*unificar valores porcentaje y valor incremento*/
        txt_porc_incremento = txt_porc_incremento_total;
        slc_tipo_incremento = 3;
        txt_totalIncremento = txt_total_Incrementos;

        //traer arreglos de los incrementos
        var arregloIncrementos = new Array();
        $('input[name^="idAddIncremento"]').each(function () {
            arregloIncrementos.push($(this).val());
        });
        var incrementos = arregloIncrementos;

        //porcentaje
        var arregloIncrementos_porc = new Array();
        $('input[name^="txt_porc_incremento_array"]').each(function () {
            arregloIncrementos_porc.push($(this).val());
        });
        var incrementos_porc = arregloIncrementos_porc;

        //valor
        var arregloIncrementos_valor = new Array();
        $('input[name^="txt_totalIncremento_array"]').each(function () {
            arregloIncrementos_valor.push($(this).val());
        });
        var incrementos_valor = arregloIncrementos_valor;

        var arregloIncrementos_lb = new Array();
        $('input[name^="txt_lb_incremento_array"]').each(function () {
            arregloIncrementos_lb.push($(this).val());
        });
        var incrementos_lb = arregloIncrementos_lb;
        /**/

    }



    $.ajax({
        type: "POST",
        url: "lib/4ot/controlador/CT_ot.php",
        data: {
            opcion: 'SaveIncremento',
            detallepresupuesto_id: detallepresupuesto_id,
            txt_totalPresupuesto: txt_totalPresupuesto,
            txt_porc_incremento: txt_porc_incremento,
            slc_tipo_incremento: slc_tipo_incremento,
            txt_totalIncremento: txt_totalIncremento,
            txt_totalPresupuestoIncremento: txt_totalPresupuestoIncremento,
            listaIncrementos: incrementos,
            listaIncPorcentaje: incrementos_porc,
            listaIncValor: incrementos_valor,
            listaInclb: incrementos_lb

        },
        async: false,
        success: function (retu) {
            data = retu;
        }
    });

    if (data == '1' || data == 1)
    {
        alert('Información almacenada correctamente.');
        $("#div_incremento").dialog('close');
        $("#div_incremento").dialog('destroy');
        $("#div_incremento").html('');
        return false;

    } else {

        alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
        return false;
    }


}

function addIncrementoPresupuesto()
{
    var cadena = "";
    var concat = "'";
    var id_incremento = $("#slc_tipo_incremento option:selected").val();
    var text_incremento = $("#slc_tipo_incremento option:selected").text();
    var txt_porc_incremento = $("#txt_porc_incremento").val();
    var txt_totalIncremento = $("#txt_totalIncremento").val();
    var contador_total_inc = $("#txt_total_Incrementos").val();
    var txt_totalPresupuestop = $("#txt_totalPresupuesto").val();
    var txt_porc_incremento_totalp = $("#txt_porc_incremento_total").val();
    var total_incremento = txt_totalIncremento.replace(/\./g, '');
    var cont_sin_puntos = contador_total_inc.replace(/\./g, '');
    var txt_totalPresupuesto = txt_totalPresupuestop.replace(/\./g, '');
    var txt_porc_incrementoc = txt_porc_incremento.replace(/\./g, ',');


    if (id_incremento == '') {
        alert('Señor usuario seleccione un incremento de la lista.');

    } else {
        $("#tableMoreIncremento").css('display', 'block');
        $("#total_incrementos").css('display', 'block');
        $("#total_porcentaje").css('display', 'block');

        if ($("#tr_incremento_add_" + id_incremento).val() == null)
        {

            contador_total_inc = parseFloat(total_incremento) + parseFloat(cont_sin_puntos);
            txt_totalPresupuesto = parseFloat(txt_totalPresupuesto) + parseFloat(contador_total_inc);

            txt_porc_incrementoc = parseFloat(txt_porc_incremento_totalp) + parseFloat(txt_porc_incremento);

            contador_total_inc = number_format(contador_total_inc, 0, ',', '.');
            txt_totalPresupuesto = number_format(txt_totalPresupuesto, 0, ',', '.');


            $("#txt_total_Incrementos").val(contador_total_inc);
            $("#txt_totalPresupuestoIncremento").val(txt_totalPresupuesto);
            $("#txt_porc_incremento_total").val(txt_porc_incrementoc.toFixed(2));

            cadena = '<tr id="tr_incremento_add_' + id_incremento + '">' +
                    '<td><button type="button" name="btn_eliminar_inc_' + id_incremento + '" id="btn_eliminar_inc_' + id_incremento +
                    '" class="btn btn-default btn-xs" onclick="deltableIncremento(' + id_incremento + ',' + concat + txt_porc_incremento +
                    concat + ',' + concat + txt_totalIncremento + concat + ');contadorFilasTablaGeneral(' + concat +
                    'incrementoAddTR' + concat + ',' + concat + 'txt_add_incremento' + concat +
                    ');"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>Eliminar</button></td>' +
                    '<td>' + text_incremento + '</td>' +
                    '<td>' + txt_porc_incremento + '</td>' +
                    '<td>' + txt_totalIncremento + '</td>' +
                    '<input type="hidden" name="idAddIncremento[]" id="idAddIncremento" value="' + id_incremento + '">' +
                    '<input type="hidden" name="txt_porc_incremento_array[]" id="txt_porc_incremento_array" value="' + txt_porc_incremento + '">' +
                    '<input type="hidden" name="txt_totalIncremento_array[]" id="txt_totalIncremento_array" value="' + txt_totalIncremento + '">' +
                    '<input type="hidden" name="txt_lb_incremento_array[]" id="txt_lb_incremento_array" value="' + text_incremento + '">' +
                    '</tr>';
            $("#incrementoAddTR").append(cadena);
        } else {
            alert('Señor usuario el incremento ya esta adicionado.');
            return false;
        }
    }

}

function deltableIncremento(param1, param2, param3)
{
    var txt_porc_incremento_total = $("#txt_porc_incremento_total").val();
    var txt_totalPresupuestoIncrementop = $("#txt_totalPresupuestoIncremento").val();
    var txt_total_Incrementosp = $("#txt_total_Incrementos").val();


    var txt_totalPresupuestoIncremento = txt_totalPresupuestoIncrementop.replace(/\./g, '');
    var txt_total_Incrementos = txt_total_Incrementosp.replace(/\./g, '');

    var param3p = param3.replace(/\./g, '');


    txt_totalPresupuestoIncremento = parseFloat(txt_totalPresupuestoIncremento) - parseFloat(param3p);
    txt_total_Incrementos = parseFloat(txt_total_Incrementos) - parseFloat(param3p);

    txt_totalPresupuestoIncremento = number_format(txt_totalPresupuestoIncremento, 0, ',', '.');
    txt_total_Incrementos = number_format(txt_total_Incrementos, 0, ',', '.');

    $("#txt_totalPresupuestoIncremento").val(txt_totalPresupuestoIncremento);
    $("#txt_total_Incrementos").val(txt_total_Incrementos);


    /*porcentaje*/
    txt_porc_incremento_total = parseFloat(txt_porc_incremento_total) - parseFloat(param2);
    $("#txt_porc_incremento_total").val(txt_porc_incremento_total.toFixed(2));

    $("#tr_incremento_add_" + param1).remove();
    return false;
}

function ReportarLabores() {
    var retorno;
    var data;
    var param_labores_reportar_presupuesto_id = new Array();

    $('input[name="chek_reportar[]"]:checked').each(function (key) {
        var elem_form_mtr = this;
        param_labores_reportar_presupuesto_id += elem_form_mtr.value + "|";
    });
    var strlen = param_labores_reportar_presupuesto_id.length;
    param_labores_reportar_presupuesto_id = param_labores_reportar_presupuesto_id.slice(0, strlen - 1);


    /*Validar que se pueda reportar este bloque de labores*/

    $.ajax({
        type: "POST",
        url: "lib/4ot/controlador/CT_ot.php",
        data: {
            opcion: 'ValidarArrayPresupuesto',
            param_labores_reportar_presupuesto_id: param_labores_reportar_presupuesto_id
        },
        async: false,
        success: function (retu) {
            data = retu;
        }
    });

    if (data == '1' || data == 1)
    {

        $.ajax({
            type: "POST",
            url: "lib/4ot/view/formSeguimientoBloque.php",
            data: {
                param_labores_reportar_presupuesto_id: param_labores_reportar_presupuesto_id
            },
            async: false,
            success: function (retu) {
                retorno = retu;
            }
        });

        $("#contenido").html(retorno);

    } else {

        alert("Para reportar varias el seguimiento de varias labores debe tener en cuenta que debe tener la mista OT y área, y la labor no debe estar FINALIZADA o RESUELTA");
        return false;
    }

    /*Fin Validacion*/


}
function ListActividadesReportar() {
    var txt_array_presupuesto_id = $("#id_presupuesto").val();

    $.ajax({
        type: "POST",
        url: "lib/4ot/controlador/CT_ot.php",
        async: false,
        data: {
            opcion: 'ListActividadesReportar',
            txt_array_presupuesto_id: txt_array_presupuesto_id

        },
        success: function (retu) {
            $("#data_presupuestos").html(retu);

        }

    });
}


function SaveSeguimientoBloqueLabores() {

    var slc_estado_actividad = $("#slc_estado_actividad").val();
    var porc_av = $("#porc_av_cal").val();
    var txtInicioSeg = $("#txtInicioSeg").val();
    var txtHoraIniSeg = $("#txtHoraIniSeg").val();
    var txtFnicioSeg = $("#txtFnicioSeg").val();
    var txtHoraFinSeg = $("#txtHoraFinSeg").val();
    var txt_Obs_seg = $("#txt_Obs_seg").val();
    var txt_array_presupuesto_id = $("#id_presupuesto").val();
    // var presupuesto_porcentaje = $("#presupuesto_porcentaje").val();


    var extensiones_permitidas = new Array(".jpg", ".pdf", ".png", ".dwg", ".xlsx", ".docx", ".jpeg");
    var formElement = document.getElementById("frm_DataSeguimientoBloque");
    var data = new FormData(formElement);
    var inputFileImage;
    var file;
    var id_cambiante;
    var id_cambiante2;
    var errores = 0;
    var espaciovacio = 0;
    var i = '';
    var cadena;
    $(".archivo_doc_req").each(function (index) {
        id_cambiante = $(this).attr("id");
        id_cambiante2 = $(this).attr("id");
        cadena += "-" + id_cambiante2;
        inputFileImage = document.getElementById(id_cambiante);
        var extension = (inputFileImage.value.substring(inputFileImage.value.lastIndexOf("."))).toLowerCase();
        var permitida = false;

        if (extension == "" || extension == " " || extension == null) {

            espaciovacio = espaciovacio + 1;
        }

        for (i = 0; i <= extensiones_permitidas.length; i++) {

            if (extensiones_permitidas[i] == extension) {
                permitida = true;
                break;
            }
        }
        if (permitida) {
            file = inputFileImage.files[0];
            data.append(id_cambiante, file);
            id_cambiante = "";
            inputFileImage = "";
            file = "";
        } else {

            errores = errores + 1;
        }
    });
    if (espaciovacio != 0) {
        alert("Por favor elimine opción de - adicionar archivo - si no va cargar otro documento.");
        return false;
    }

    if (errores == 0) {

        data.append('opcion', 'SaveSeguimientoBloqueLabores');
        data.append('porc_av', porc_av);
        data.append('slc_estado_actividad', slc_estado_actividad);
        data.append('txtInicioSeg', txtInicioSeg);
        data.append('txtHoraIniSeg', txtHoraIniSeg);
        data.append('txtFnicioSeg', txtFnicioSeg);
        data.append('txtHoraFinSeg', txtHoraFinSeg);
        data.append('txt_Obs_seg', txt_Obs_seg);
        data.append('txt_array_presupuesto_id', txt_array_presupuesto_id);


        var url = "lib/4ot/controlador/CT_ot.php";
        var retorno_docs;
        $.ajax({
            url: url,
            type: 'POST',
            contentType: false,
            data: data,
            async: false,
            processData: false,
            cache: false
        }).done(function (retu) {
            retorno_docs = retu;
        });


        if (retorno_docs == 1 || retorno_docs == 3) {

            alert("Registro almacenado satisfactoriamente");

        } else if (retorno_docs == 2) {
            alert("Ocurrio algun error al tratar de ingresar los documentos comuniquese con soporte tecnico");

        }

    } else if (errores != 0) {
        alert("Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join() + "\n O revise que todos los documentos esten anexos ");

    }
}

//////////////////////
// CARGAR NORMAS // //
//////////////////////
function cargar_normas (presupuesto_id){

    $.ajax({
        url: 'lib/4ot/controlador/CT_ot.php',
        type: 'POST',
        data: {
            opcion          : 'cargar_normas', 
            presupuesto_id  : presupuesto_id
        },
        async: false,
        success: function (retorno){
            ret = retorno;
        }
    });

    $('#normatividad').html(ret);
}


////////////////////
// GUARDAR NORMAS //
////////////////////
function agregar_normas(norma_id, presupuesto_id){

    // console.log(norma_id);
    // console.log(presupuesto_id);
    $.ajax({
        url: 'lib/4ot/controlador/CT_ot.php',
        type: 'POST',
        data: {
            opcion          :   'agregar_normas',
            norma_id        :   norma_id,
            presupuesto_id  :   presupuesto_id
        },
        async:false,
        success: function(retorno){
            retu = retorno;
        }
    });
    
    if (retu == 0) {

        alert("No fue posible agregar la norma!!!");

    }else{
        
        alert("La norma se agrego con exito");
        $('#btn_agregarNormas_'+norma_id).addClass('disabled');
        $('#btn_agregarNormas_'+norma_id).removeClass('btn-primary');
        $('#btn_agregarNormas_'+norma_id).addClass('btn-success');
        $('#spanNormas_'+norma_id).text('Agregado');
        $('#btn_quitarNormas_'+norma_id).removeClass('hidden');
    }

}

//////////////////
// QUITAR NORMA //
//////////////////
function quitar_normas(norma_id,presupuesto_id){


    $.ajax({
        url: 'lib/4ot/controlador/CT_ot.php',
        type: 'POST',
        data: {
            opcion          :   'quitar_normas',
            norma_id        :   norma_id,
            presupuesto_id  :   presupuesto_id
        },
        async:false,
        success: function(retorno){
            retu = retorno;
        }
    });

    if (retu == 0) {

        alert("No fue posible quitar la norma!!!");

    }else{

    alert("La norma se quito con exito");
    $('#btn_agregarNormas_'+norma_id).removeClass('disabled');
    $('#btn_agregarNormas_'+norma_id).addClass('btn-primary');
    $('#btn_agregarNormas_'+norma_id).removeClass('btn-success');
    $('#spanNormas_'+norma_id).text('Agregar');
    $('#btn_quitarNormas_'+norma_id).addClass('hidden');

    }
    // console.log(presupuesto_id);
    // console.log(retu);
}


////////////////////////
// ALCANCES BAREMADOS //
////////////////////////
function alcancesBaremados(alcances){

    $.ajax({
        url: 'lib/4ot/controlador/CT_ot.php',
        type: 'POST',
        data: {
            opcion       :   'alcancesBaremados',
            alcances      :   alcances
        },
        async:false,
        success: function(retorno){
            retu = retorno;

        },

        dataType: "json"
    });
        // console.log(retu);
        $('#alc_baremado').html('- '+retu);
            
}


///////////////////////////
// ENTREGABLES BAREMADOS //
///////////////////////////
function entregablesBaremados(entregables){

    $.ajax({
        url: 'lib/4ot/controlador/CT_ot.php',
        type: 'POST',
        data: {
            opcion          :   'entregablesBaremados',
            entregables     :   entregables
        },
        async:false,
        success: function(retorno){
            retu = retorno;

        },

        dataType: "json"
    });
        // console.log(retu);
        $('#entregable').html('- '+retu);
            
}


//////////////////
// NORMATIVIDAD //
//////////////////
function normatividad (presupuesto_id){

    $.ajax({
        url: 'lib/4ot/controlador/CT_ot.php',
        type: 'POST',
        data: {
            opcion              :   'normatividad',
            presupuesto_id      :   presupuesto_id
        },
        async:false,
        success: function(retorno){
            retu = retorno;

        },

        dataType: "json"
    });

        console.log(retu);
        $('#normas').html('- '+retu);
}