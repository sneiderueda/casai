/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function gritBaremos() {
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'gritBaremos'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });


}

function ListTipBaremo(control) {
    var retorno = "";

    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        data: {
            opcion: 'ListTipBaremo'
        },
        async: false,
        success: function (data) {
            retorno += data;

        }
    });

    $("#" + control + "").html(retorno);

}

function SaveLaborBaremo() {

    var param = "";
    var parametros = '';
    var bm_id = $("#bm_id").val();
    var slCliente = $("#slCliente").val();
    var slContrato = $("#slContrato").val();
    var slTip = $("#slTip").val();
    var txt_item = $("#txt_item").val();
    var txt_labor = $("#txt_labor").val();
    var txt_medida = $("#txt_medida").val();
    var txt_servicioTot = $("#txt_servicioTot").val();
    var txt_totalAct = $("#txt_totalAct").val();
    var txt_totalSinIva = $("#txt_totalSinIva").val();

    if ($("#slCliente").val() == "") {
        alert("Seleccione el Cliente");
        return false;
    }
    if ($("#slContrato").val() == "") {
        alert("Seleccione un contrato del cliente.");
        return false;
    }
    if ($("#slTip").val() == "") {
        alert("Seleccione el tipo de Baremo");
        return false;
    }
    if ($("#txt_item").val() == "") {
        alert("Registre el ITEM del Baremo");
        return false;
    }

    if ($("#txt_servicioTot").val() == "") {
        alert("Ingrese el Total de la Unidad de Servicio");
        return false;
    }

    if ($("#txt_totalAct").val() == "") {
        alert("Ingrese el Total de las Actividades");
        return false;
    }

    if ($("#txt_totalSinIva").val() == "") {
        alert("Ingrese el Total sin IVA");
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
        'opcion': 'SaveLaborBaremo',
       //'data_json': '{' + param + '}',
        bm_id: bm_id,
        slCliente: slCliente,
        slContrato: slContrato,
        slTip: slTip,
        txt_item: txt_item,
        txt_labor: txt_labor,
        txt_medida: txt_medida,
        txt_servicioTot: txt_servicioTot,
        txt_totalAct: txt_totalAct,
        txt_totalSinIva: txt_totalSinIva
    };

    $.ajax({
        type: 'post',
        url: 'lib/1config/controlador/CT_baremos.php',
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

                $("#txt_act").prop('required', false);
                $("#txt_servicioAct").prop('required', false);
                //$("#txt_act_valor").prop('required', false);

                param = "";
                $("#div_baremo").css("display", "block");
                $("#btn_saveLaborBaremo").css("display", "none");
                bm_id = $(xml).find('baremo_id').text();
                $("#bm_id").val(bm_id);

                //loadingFunctions('lib/2usuario/view/formEditClient.php', 'contenido', cliente_id);

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                $("#div_baremo").css("display", "none");
                $("#btn_saveLaborBaremo").css("display", "block");
                $("#bm_id").val("");
                param = "";
            }

        }
    });

}

function AddActividadBaremo() {

    var cadena = '';
    var parametros = '';
    var num_actBm = parseInt($("#txt_actBm").val());

    //Campos de la seccion de actividades
    var txt_act = $("#txt_act").val();
    var txt_servicioAct = $("#txt_servicioAct").val();
    var txt_act_valor = $("#txt_act_valor").val();
    var txt_gom = $("#txt_gom").val();
    var act_id = $("#act_id").val();
    var bm_id = $("#bm_id").val();
    var slContrato = $("#slContrato").val();


    if (txt_act == "") {
        alert("Favor ingrese la descripcion de la actividad");
        return false;
    }
    if (txt_servicioAct == "") {
        alert("Favor ingrese el costo de la actividad en unidad de servicio");
        return false;
    }
    if (txt_act_valor == "") {
        alert("Favor ingrese el costo total de la actividad sin IVA");
        return false;
    }



    parametros = {
        'opcion': 'AddActividadBaremo',
        txt_act: txt_act,
        txt_servicioAct: txt_servicioAct,
        txt_act_valor: txt_act_valor,
        txt_gom: txt_gom,
        act_id: act_id,
        bm_id: bm_id,
        slContrato: slContrato
    };

    $.ajax({
        type: 'post',
        url: 'lib/1config/controlador/CT_baremos.php',
        dataType: 'xml',
        async: false,
        data: parametros,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1)
            {
                // alert('Señor usuario (a), la informacion se almacenó exitosamente');
                param = "";
                ListActividadesBaremo(bm_id);
                $("#act_id").val("");
                $("#txt_gom").val("");
                $("#txt_servicioAct").val("");
                $("#txt_act_valor").val("");
                $("#txt_act").val("");

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            }

        }
    });

}

function CountFilasTabla(id1, id2) {
    var numFilas = $('#' + id1 + ' >tr').length;
    $("#" + id2 + "").val(numFilas);
}

function gritAlcance() {
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'gritAlcance'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });


}

function StateUpdateAlcance(alcance_id) {

    var confrimar = '';

    confrimar = confirm("Esta seguro que desea eliminar el alcance.");

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/1config/controlador/CT_baremos.php',
            data: {
                opcion: 'StateUpdateAlcance',
                alcance_id: alcance_id

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Alcance eliminado correctamente.');
            gritAlcance();
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function JsonDataAlcance(alcance_id) {

    var jsondata;
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'JsonDataAlcance',
            alcance_id: alcance_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    return jsondata;
}


function SaveAlcance() {

    var param = "";
    var parametros = '';
    var alc_id = $("#alc_id").val();
    var descp = $("#txt_alcance").val();

    if ($("#txt_alcance").val() == "") {
        alert("Ingrese la descripcion del alcance");
        return false;
    }


    parametros = {
        'opcion': 'SaveAlcance',
        alc_id: alc_id,
        descp: descp
    };

    $.ajax({
        type: 'post',
        url: 'lib/1config/controlador/CT_baremos.php',
        dataType: 'xml',
        async: false,
        data: parametros,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1) {
                alert('Señor usuario (a), la informacion se almacenó exitosamente');
                gritAlcance();

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            }

        }
    });

}

function gritEntregable() {
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'gritEntregable'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });


}

function StateUpdateEntregable(entregable_id) {

    var confrimar = '';

    confrimar = confirm("Esta seguro que desea eliminar el alcance.");

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/1config/controlador/CT_baremos.php',
            data: {
                opcion: 'StateUpdateEntregable',
                entregable_id: entregable_id

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Entregable eliminado correctamente.');
            gritEntregable();
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function JsonDataEntregable(entregable_id) {

    var jsondata;
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'JsonDataEntregable',
            entregable_id: entregable_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    return jsondata;
}

function SaveEntregable() {

    var param = "";
    var parametros = '';
    var ent_id = $("#ent_id").val();
    var descp = $("#txt_entregable").val();

    if ($("#txt_entregable").val() == "") {
        alert("Ingrese la descripcion del entregable");
        return false;
    }


    parametros = {
        'opcion': 'SaveEntregable',
        ent_id: ent_id,
        descp: descp
    };

    $.ajax({
        type: 'post',
        url: 'lib/1config/controlador/CT_baremos.php',
        dataType: 'xml',
        async: false,
        data: parametros,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1) {
                alert('Señor usuario (a), la informacion se almacenó exitosamente');
                gritEntregable();

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            }

        }
    });

}

function DivSubactividades(actividad_id, costo_actividad, baremoactividad_id) {

    var contrato_id = $("#contrato_id").val();

    //Validar el 100% de la actividad
    var jsondata;
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'JsonValorPorc',
            actividad_id: actividad_id,
            baremoactividad_id: baremoactividad_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    var resultPorc = jsondata.porcentaje;


    var data;
    $("#md_sub").html("");

    $.ajax({
        type: "POST",
        url: 'lib/1config/vista/formDataSubact.php',
        data: {
            actividad_id: actividad_id,
            costo_actividad: costo_actividad,
            baremoactividad_id: baremoactividad_id,
            resultPorc: resultPorc,
            contrato_id: contrato_id
        },
        async: false,
        success: function (retu) {
            data = retu;
            //$("#contenido").html(retu);
        }

    });

    $("#md_sub").html(data);
    $("#md_sub").dialog({
//        show: "fold",
//        title: "Cargar Subactividades",
//        autoOpen: true,
//        hide: "scale",
//        width: 700,
//        modal: true,
//        height: 'auto',
//        position: 'top',

        width: '800',
        height: '600',
        hide: "scale",
        title: 'Cargar Subactividades',
        position: 'top',
        modal: true,
        //position: [280,280],
        create: function (event) {
            $(event.target).parent().css({top: 380, left: 280});
        },
        buttons: {
            "Cerrar": function ()
            {
                $(this).dialog('close');
                $(this).dialog('destroy');
                $("#md_sub").html('');
                //$("#dialog_tramite1").dialog('close');
            }
        }
    });
}

function CalValorPorc(val_porc) {

    var act_cot = $("#act_cot").val();
    var valor_actividad_decimal = $("#valor_actividad_decimal").val();
    var val_num_act = parseFloat(act_cot);
    var val_num_actividad_dc = parseFloat(valor_actividad_decimal);
    var porc = parseFloat(val_porc);
    var valor = (val_num_actividad_dc * porc);

    $("#txt_totalSinIvaSub").val(Math.round(valor));


}
function SaveSubactividad() {

    var parametros = '';

    var act_id = $("#act_id_sub").val();
    var baremoactividad_id = $("#baremoactividad_id").val();
    var act_cot = $("#act_cot").val();
    var contrato_id = $("#contrato_id").val();


    var sub_id = $("#sub_id").val();
    var txt_sub = $("#txt_sub").val();
    var txt_porc_sub = $("#txt_porc_sub").val();
    var txt_totalSinIvaSub = $("#txt_totalSinIvaSub").val();

    if (act_id == "") {
        alert("No se ha relacionado a una actividad, favor validar");
        return false;
    }

    if (baremoactividad_id == "") {
        alert("No se pudo completar el proceso, favor validar");
        return false;
    }
    if (txt_sub == "") {
        alert("Ingrese la descripcion de la subactividad");
        return false;
    }
    if (txt_porc_sub == "") {
        alert("Ingrese el porcentaje de la subactividad");
        return false;
    }
    if (txt_totalSinIvaSub == "") {
        alert("Ingrese el total de la subactividad");
        return false;
    }


    parametros = {
        'opcion': 'SaveSubactividad',
        sub_id: sub_id,
        act_id: act_id,
        txt_sub: txt_sub,
        txt_porc_sub: txt_porc_sub,
        txt_totalSinIvaSub: txt_totalSinIvaSub,
        baremoactividad_id: baremoactividad_id,
        contrato_id: contrato_id
    };

    $.ajax({
        type: 'post',
        url: 'lib/1config/controlador/CT_baremos.php',
        dataType: 'xml',
        async: false,
        data: parametros,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1) {
                alert('Señor usuario (a), la informacion se almacenó exitosamente');
                ListSubactividadesBm(baremoactividad_id, act_id);
                $("#sub_id").val('');
                $("#txt_sub").val('');
                $("#txt_porc_sub").val('');
                $("#txt_totalSinIvaSub").val('');
//                $("#md_sub").dialog('close');
//                $("#md_sub").dialog('destroy');
//                $("#md_sub").html("");


            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            }

        }
    });

}


function JsonBaremoClientTip(item) {

    var jsondata;
    var cliente_id = $("#slCliente").val();
    var tipobaremo_id = $("#slTip").val();
    var slContrato = $("#slContrato").val();

    if (cliente_id == "") {
        alert("Por favor seleccione el cliente");
        $("#txt_item").val('');
        return false;
    }
    if (tipobaremo_id == "") {
        alert("Por favor seleccione el tipo de baremo");
        $("#txt_item").val('');
        return false;
    }

    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'JsonBaremoClientTip',
            item: item,
            cliente_id: cliente_id,
            tipobaremo_id: tipobaremo_id,
            slContrato: slContrato
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    $("#bm_id").val(jsondata.baremo_id);
    $("#txt_labor").val(jsondata.labor_descripcion);
    $("#txt_totalSinIva").val(jsondata.baremo_totalsinIva);
    $("#txt_medida").val(jsondata.baremo_unidadservicio);
    $("#txt_servicioTot").val(jsondata.baremo_valorservicio);
    $("#txt_totalAct").val(jsondata.baremo_valortotalAct);
    //return jsondata;
}

function JsonActividad(activity_description) {
    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'JsonActividad',
            activity_description: activity_description
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    $("#act_id").val(jsondata.actividad_id);
    $("#txt_gom").val(jsondata.actividad_GOM);
    $("#txt_servicioAct").val(jsondata.actividad_unidadservicio);
    $("#txt_act_valor").val(jsondata.actividad_valorservicio);

    //return jsondata;    
}

function ListSubactividadesBm(baremoactividad_id, actividad_id, contrato_id) {

    var cadena = '';
    $.ajax({
        type: "POST",
        // dataType: 'json',
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'ListSubactividadesBm',
            baremoactividad_id: baremoactividad_id,
            actividad_id: actividad_id,
            contrato_id: contrato_id
        },
        success: function (retu) {
            $("#SubactividadBm").html(retu);
        }

    });
}

function DeleteSubactividadBaremo(baremoactividad_id, actividad_id, detalleactividad_id) {

    var confrimar = '';

    confrimar = confirm("Esta seguro que desea eliminar la subactividad.");

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/1config/controlador/CT_baremos.php',
            data: {
                opcion: 'DeleteSubactividadBaremo',
                detalleactividad_id: detalleactividad_id

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Información guardada correctamente.');
            ListSubactividadesBm(baremoactividad_id, actividad_id);
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function divConfigAlcanceEntregable(url, data_id, data_cont) {

    if (url == 1) {
        url = 'lib/1config/vista/formConfigAlcance.php';
    } else if (url == 2) {
        url = 'lib/1config/vista/formConfigEntregable.php';
    }
    var data;

    $.ajax({
        type: "POST",
        //url: 'lib/1config/vista/formDataSubact.php',
        url: url,
        data: {
            data_id: data_id,
            data_cont: data_cont
        },
        async: false,
        success: function (retu) {
            data = retu;
            //$("#contenido").html(retu);
        }

    });

    $("#configAlcanceEntregable").html(data);
    $("#configAlcanceEntregable").css("display", "block");
    $("#contenido_subactividad").css("display", "none");
}

function DivSubactividadesAlcanceEntregable() {
    $("#contenido_subactividad").css("display", "block");
    $("#configAlcanceEntregable").css("display", "none");
}

function SelectAlcance(control) {

    var retorno = "";
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        data: {
            opcion: 'SelectAlcance'
        },
        async: false,
        success: function (data) {
            retorno = data;
        }
    });
    $("#" + control + "").html(retorno);
}

function SaveAlcanceSubactividad() {

    var parametros = '';


    var combobox_al = $("#combobox_al").val();
    var detalleactividad_id = $("#detalleactividad_id").val();
    var contrato_id = $("#contrato_id").val();

    if (combobox_al == "") {
        alert("Favor Seleccione un alcance");
        return false;
    }

    parametros = {
        'opcion': 'SaveAlcanceSubactividad',
        combobox_al: combobox_al,
        detalleactividad_id: detalleactividad_id,
        contrato_id: contrato_id
    };

    $.ajax({
        type: 'post',
        url: 'lib/1config/controlador/CT_baremos.php',
        dataType: 'xml',
        async: false,
        data: parametros,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1)
            {
                //listar los alcances de la subactividad
                parametros = "";
                ListAlcanceSubactividades(detalleactividad_id, contrato_id);

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            }

        }
    });
}

function ListAlcanceSubactividades(detalleactividad_id, data_cont) {

    var cadena = "";
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'ListAlcanceSubactividades',
            detalleactividad_id: detalleactividad_id,
            data_cont: data_cont

        },
        success: function (retu) {
            $("#Alcances").html(retu);
        }

    });
}

function DeleteSubactividadAlcance(alcancesubactividad_id, detalleactividad_id) {

    var confrimar = '';

    confrimar = confirm("Esta seguro que desea eliminar el alcance.");

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/1config/controlador/CT_baremos.php',
            data: {
                opcion: 'DeleteSubactividadAlcance',
                alcancesubactividad_id: alcancesubactividad_id

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Se elimino correctamente.');
            divConfigAlcanceEntregable('1', detalleactividad_id);
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function SelectEntregable(control) {

    var retorno = "";
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        data: {
            opcion: 'SelectEntregable'
        },
        async: false,
        success: function (data) {
            retorno = data;
        }
    });
    $("#" + control + "").html(retorno);
}

function ListEntregableSubactividades(detalleactividad_id) {

    var cadena = "";
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'ListEntregableSubactividades',
            detalleactividad_id: detalleactividad_id

        },
        success: function (retu) {
            $("#Entregables").html(retu);
        }

    });
}

function DeleteSubactividadEntregable(entregablesubactividad_id, detalleactividad_id) {

    var confrimar = '';

    confrimar = confirm("Esta seguro que desea eliminar el entregable.");

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/1config/controlador/CT_baremos.php',
            data: {
                opcion: 'DeleteSubactividadEntregable',
                entregablesubactividad_id: entregablesubactividad_id

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Se elimino correctamente.');
            divConfigAlcanceEntregable('2', detalleactividad_id);
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }
}

function SaveEntregableSubactividad() {

    var parametros = '';


    var combobox_ent = $("#combobox_ent").val();
    var detalleactividad_id = $("#detalleactividad_id").val();
    var contrato_id = $("#contrato_id").val();

    if (combobox_ent == "") {
        alert("Favor Seleccione un entregable");
        return false;
    }

    parametros = {
        'opcion': 'SaveEntregableSubactividad',
        combobox_ent: combobox_ent,
        detalleactividad_id: detalleactividad_id,
        contrato_id: contrato_id
    };

    $.ajax({
        type: 'post',
        url: 'lib/1config/controlador/CT_baremos.php',
        dataType: 'xml',
        async: false,
        data: parametros,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1)
            {
                //listar los alcances de la subactividad
                parametros = "";
                ListEntregableSubactividades(detalleactividad_id);

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            }

        }
    });
}

function ListActividadesBaremo(baremo_id) {

    var cadena = "";
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'ListActividadesBaremo',
            baremo_id: baremo_id

        },
        success: function (retu) {
            $("#ActividadesBm").html(retu);
        }

    });
}

function DeleteBaremo(baremo_id) {

    var confrimar = '';

    confrimar = confirm("Esta seguro que desea eliminar el baremo.");

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/1config/controlador/CT_baremos.php',
            data: {
                opcion: 'DeleteBaremo',
                baremo_id: baremo_id

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Información guardada correctamente.');
            gritBaremos();
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function JsonBaremoId(baremo_id) {

    var jsondata;

    $.ajax({
        type: "POST",
        dataType: "json",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'JsonBaremoId',
            baremo_id: baremo_id
        },
        success: function (retu) {
            jsondata = retu;
        }
        // 
    });
    $("#slCliente").val(jsondata.cliente_id);
//console.log(jsondata);
    ListContrato('slContrato');
    $("#bm_id").val(jsondata.baremo_id);
    $("#contrato_id").val(jsondata.contrato_id);
    $("#slContrato").val(jsondata.contrato_id);
    $("#txt_labor").val(jsondata.labor_descripcion);
    $("#txt_item").val(jsondata.baremo_item);
    $("#txt_totalSinIva").val(jsondata.baremo_totalsinIva);
    $("#txt_medida").val(jsondata.baremo_unidadservicio);
    $("#txt_servicioTot").val(jsondata.baremo_valorservicio);
    $("#txt_totalAct").val(jsondata.baremo_valortotalact);

    $("#slTip").val(jsondata.tipobaremo_id);

    $("#div_baremo").css("display", "block");
    $("#btn_saveLaborBaremo").css("display", "block");
    //return jsondata;
}

function JsonActividadId(actividad_id) {

    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'JsonActividadId',
            actividad_id: actividad_id
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    $("#act_id").val(jsondata.actividad_id);
    $("#txt_act").val(jsondata.actividad_descripcion);
    $("#txt_gom").val(jsondata.actividad_gom);
    $("#txt_servicioAct").val(jsondata.actividad_unidadservicio);
    $("#txt_act_valor").val(jsondata.actividad_valorservicio);



    $("#btn_UpdateActBaremo").css("display", "block");
    $("#btn_saveActBaremo").css("display", "none");
    //return jsondata;
}

function UpdateActividadBaremo() {


    var parametros = '';


    //Campos de la seccion de actividades
    var txt_act = $("#txt_act").val();
    var txt_servicioAct = $("#txt_servicioAct").val();
    var txt_act_valor = $("#txt_act_valor").val();
    var txt_gom = $("#txt_gom").val();
    var act_id = $("#act_id").val();
    var bm_id = $("#bm_id").val();
    var contrato_id = $("#slContrato").val();


    if (txt_act == "") {
        alert("Favor ingrese la descripcion de la actividad");
        $("#txt_act").attr("required", "true");
        //$('#txt_act').prop('required', true);
        return false;
    }
    if (txt_servicioAct == "") {
        alert("Favor ingrese el costo de la actividad en unidad de servicio");
        $("#txt_servicioAct").attr("required", "true");
        //$('#txt_servicioAct').prop('required', true);
        return false;
    }
    if (txt_act_valor == "") {
        alert("Favor ingrese el costo total de la actividad sin IVA");
        //$('#txt_act_valor').prop('required', true);
        $("#txt_act_valor").attr("required", "true");
        return false;
    }



    parametros = {
        'opcion': 'UpdateActividadBaremo',
        txt_act: txt_act,
        txt_servicioAct: txt_servicioAct,
        txt_act_valor: txt_act_valor,
        txt_gom: txt_gom,
        act_id: act_id,
        bm_id: bm_id,
        contrato_id: contrato_id
    };

    $.ajax({
        type: 'post',
        url: 'lib/1config/controlador/CT_baremos.php',
        dataType: 'xml',
        async: false,
        data: parametros,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1)
            {
                // alert('Señor usuario (a), la informacion se almacenó exitosamente');
                param = "";
                JsonBaremoId(bm_id);
                ListActividadesBaremo(bm_id);
                $("#act_id").val("");
                $("#txt_gom").val("");
                $("#txt_servicioAct").val("");
                $("#txt_act_valor").val("");
                $("#txt_act").val("");

                $("#btn_UpdateActBaremo").css("display", "none");
                $("#btn_saveActBaremo").css("display", "block");

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            }

        }
    });

}
function DeleteBaremoActividad(baremoactividad_id, bm_id) {

    var confrimar = '';

    confrimar = confirm("Esta seguro que desea eliminar la actividad del baremo");

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/1config/controlador/CT_baremos.php',
            data: {
                opcion: 'DeleteBaremoActividad',
                baremoactividad_id: baremoactividad_id

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Información guardada correctamente.');
            ListActividadesBaremo(bm_id);
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function LsBaremoFiltro() {
    var tipo_bm = $("#tipo_bm").val();
    var txt_item = $("#txt_item").val();

    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'LsBaremoFiltro',
            tipo_bm: tipo_bm,
            'txt_item': txt_item
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });
}

function ListAlcanceAociadosActividad(detalleactividad_id, presupuesto_id) {

    var cadena = "";
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'ListAlcanceAociadosActividad',
            detalleactividad_id: detalleactividad_id,
            presupuesto_id: presupuesto_id

        },
        success: function (retu) {
            $("#Alcances_tb").html(retu);
        }

    });
}

function ListEntregablesAociadosActividad(detalleactividad_id, presupuesto_id) {

    var cadena = "";
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'ListEntregablesAociadosActividad',
            detalleactividad_id: detalleactividad_id,
            presupuesto_id: presupuesto_id

        },
        success: function (retu) {
            $("#Alcances_tb").html(retu);
        }

    });
}

function InfoBaremos() {
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_baremos.php',
        async: false,
        data: {
            opcion: 'InfoBaremos'
        },
        success: function (retu) {
            $("#bm_tb").html(retu);
        }
    });


}
