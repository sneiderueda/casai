/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function gritPresupuesto() {
    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        async: false,
        data: {
            opcion: 'gritPresupuesto'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });

}

function ListSubestacion(control) {
    var retorno = "";

    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        data: {
            opcion: 'ListSubestacion'
        },
        async: false,
        success: function (data) {
            retorno += data;

        }
    });

    $("#" + control + "").html(retorno);

}

function ListContratClien(control) {
    var retorno = "";

    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        data: {
            opcion: 'ListContratClien'
        },
        async: false,
        success: function (data) {
            retorno += data;

        }
    });

    $("#" + control + "").html(retorno);

}

function AddSubestacion(value) {


    if (value == '0') {

        var datasubestacion;
        $("#div_subestacion").html("");

        $.ajax({
            type: "POST",
            url: 'lib/3presup/view/formdataSubestacion.php',
            data: {
                dato: ''
            },
            async: false,
            success: function (retu) {
                datasubestacion = retu;
            }

        });

        $("#div_subestacion").html(datasubestacion);
        $("#div_subestacion").dialog({
            width: '500',
            height: '530',
            hide: "scale",
            title: 'Cargar Subestaciones',
            position: 'top',
            modal: true,
            create: function (event) {
                $(event.target).parent().css({top: 100, left: 280});
            },
            buttons: {
//                "Cerrar": function ()
//                {
//                    $(this).dialog('close');
//                    $(this).dialog('destroy');
//                    $("#div_subestacion").html("");
//                    //$("#dialog_tramite1").dialog('close');
//                }
            }
        });
    }
}

function saveSubestacion() {
    var parametros = '';
    var subestacion_id = $("#subestacion_id").val();
    var txt_cod = $("#txt_cod_subestacion").val();
    var txt_nombre = $("#txt_nombre_subestacion").val();
    var txt_hicom = $("#txt_hicom").val();
    var txt_ubicacion = $("#txt_ubicacion").val();
    var txt_tel = $("#txt_tel_subestacion").val();
    var txt_fax = $("#txt_fax").val();
    var slIva = $("#slIva_subestacion").val();

    if (txt_cod == "") {
        alert("Ingrese el codigo de la Subestacion");
        return false;
    }
    if (txt_nombre == "") {
        alert("Ingrese el nombre de la subestacion");
        return false;
    }

    parametros = {
        'opcion': 'saveSubestacion',
        subestacion_id: subestacion_id,
        txt_cod: txt_cod,
        txt_nombre: txt_nombre,
        txt_hicom: txt_hicom,
        txt_ubicacion: txt_ubicacion,
        txt_tel: txt_tel,
        txt_fax: txt_fax,
        slIva: slIva
    };

    $.ajax({
        type: 'post',
        url: 'lib/3presup/controlador/CT_presup.php',
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
                ListSubestacion('slSubestacion');
                $("#div_subestacion").dialog('close');
                $("#div_subestacion").dialog('destroy');
                $("#div_subestacion").html("");

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                return false;
            }

        }
    });
}


function JsonSubestacion(cod_sub) {

    var jsondata;


    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        async: false,
        data: {
            opcion: 'JsonSubestacion',
            cod_sub: cod_sub
        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    if (jsondata.subestacion_id == null || jsondata.subestacion_id == "" || jsondata.subestacion_id == " ") {
        //   console.log('no existe');
    } else {
        $("#subestacion_id").val(jsondata.subestacion_id);
        $("#txt_cod_subestacion").val(jsondata.subestacion_codigo);
        $("#txt_nombre_subestacion").val(jsondata.subestacion_nombre);
        $("#txt_hicom").val(jsondata.subestacion_hicom);
        $("#txt_ubicacion").val(jsondata.subestacion_ubicacion);
        $("#txt_tel_subestacion").val(jsondata.subestacion_telefono);
        $("#txt_fax").val(jsondata.subestacion_fax);
        $("#slIva_subestacion").val(jsondata.subestacion_aplicaiva);
        //return jsondata;
    }

}

function ListModulo(control) {
    var retorno;

    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        data: {
            opcion: 'ListModulo'
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

function AddModulo(modulo) {

    if (modulo == "nuevo") {
        $("#txt_modulo").css("display", "block");
        $("#AtrasModulo").css("display", "block");
        $("#slModulo").css("display", "none");
    } else {
        $("#slModulo").css("display", "block");
        $("#txt_modulo").css("display", "none");
        $("#AtrasModulo").css("display", "none");
    }
}

function ListGestor(control) {
    var retorno = "";

    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        data: {
            opcion: 'ListGestor'
        },
        async: false,
        success: function (data) {
            retorno += data;

        }
    });

    $("#" + control + "").html(retorno);

}


function ListarPmCodensa(control) {
    var retorno = "";

    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        data: {
            opcion: 'ListarPmCodensa'
        },
        async: false,
        success: function (data) {
            retorno += data;

        }
    });

    $("#" + control + "").html(retorno);

}


function SavePresupuesto() {
    var xml = '';
    var detallepresupuesto_id = $("#detallepresupuesto_id").val();
    var txt_presupuesto = $("#txt_presupuesto").val();
    var slCliente = $("#slCliente_pret").val();
    var slSubestacion = $("#slSubestacion").val();
    var slModulo = $("#slModulo").val();
    var txt_modulo = $("#txt_modulo").val();
    var slGestor = $("#slGestor").val();
    var txt_alcance = $("#txt_alcance").val();
    var txt_Objetivo = $("#txt_Objetivo").val();
    var txtPresFin = $("#txtPresFin").val();
    var txtPresInicio = $("#txtPresInicio").val();
    var txt_gestorCodensa = $("#slPmCodensa").val();

    
    //consolelog (txt_gestorCodensa);
    //VALIDAR CAMPOS VACIOS
    if (txt_presupuesto == "") {
        alert("Por favor ingrese nombre del presupuesto");
        return false;
    }
    if (slCliente == "") {
        alert("Por favor seleccione un cliente");
        return false;
    }
    if (slSubestacion == "") {
        alert("Por favor seleccione una subestacion");
        return false;
    }
    if (slGestor == "") {
        alert("Por favor seleccione un Gestor.");
        return false;
    }
    if (txt_alcance == "") {
        alert("Por favor ingrese el alcance del presupuesto");
        return false;
    }
    if (txt_Objetivo == "") {
        alert("Por favor ingrese el objeto del presupuesto");
        return false;
    }
    if (txt_gestorCodensa == "") {
        alert("Por favor ingrese el nombre del PM Codensa");
        return false;
    }

    //ENVIO DATOS A CONTROLADOR
    $.ajax({
        type: 'post',
        url: 'lib/3presup/controlador/CT_presup.php',
        dataType: 'xml',
        async: false,
        data: {
            'opcion': 'SavePresupuesto',
            'detallepresupuesto_id': detallepresupuesto_id,
            'txt_presupuesto': txt_presupuesto,
            'slCliente': slCliente,
            'slSubestacion': slSubestacion,
            'slModulo': slModulo,
            'txt_modulo': txt_modulo,
            'slGestor': slGestor,
            'txt_alcance': txt_alcance,
            'txt_Objetivo': txt_Objetivo,
            'txtPresFin': txtPresFin,
            'txtPresInicio': txtPresInicio,
            'txt_gestorCodensa': txt_gestorCodensa
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1)
            {

                alert('Señor usuario (a), la informacion se almacenó exitosamente');

                $("#div_Add_actividades").css("display", "block");
                $("#btn_presupuesto_detalle").css("display", "none");
                detallepresupuesto_id = $(xml).find('detallepresupuesto_id').text();
                $("#detallepresupuesto_id").val(detallepresupuesto_id);
                return false;

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                gritPresupuesto();
                return false;
            }

        }
    });
}

function dataBaremoItemPresupuesto(item) {

    var tipoBaremo = $("#slTipActividad").val();
    var cliente_contrato = $("#slCliente_pret").val();
    
    if (tipoBaremo == "") {
        alert("Favor seleccione un tipo de Actividad");
        $("#search_item").val('');
        return false;
    }
    var cadena = "";
    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        async: false,
        data: {
            opcion: 'dataBaremoItemPresupuesto',
            item: item,
            tipoBaremo: tipoBaremo,
            cliente_contrato:cliente_contrato

        },
        success: function (retu) {
            if (retu == "0") {
                alert("No ha actividades asociadas al ITEM " + item);
                $("#search_item").val("");
                $("#desc_labor").html("");
                $("#valor_labor").html("");
                $("#contenido_labor").css("display", "none");
                $("#ActividadesPresupuesto").html("");

            } else {

                $("#ActividadesPresupuesto").html(retu);
                $("#ActividadesPresupuestoAsignadas").css("display", "none");
                $("#ActividadesPresupuesto").css("display", "block");
            }



        }

    });
}

function CalValorPorcPresupuesto(val_porc, baremoactividad_id, actividad_valor) {

//    if (val_porc > 1) {
//        alert("El porcentaje no puede ser mayor que 1.");
//        $("#porc_act_" + baremoactividad_id).val('1');
//        return false;
//
//    }

    var act_cot = Math.round(actividad_valor);

    var val_num_act = parseFloat(act_cot);
    var porc = parseFloat(val_porc);
    var valor = (val_num_act * porc);

    // var formato= valor.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    var formato = valor.toFixed(2);
    var punt = number_format(formato, 2, ',', '.');
    // $("#valor_cal_act_" + baremoactividad_id).val(punt);
    $("#valor_cal_act_" + baremoactividad_id).val(punt);
    //$("#txt_totalSinIvaSub").val(valor);


}

function CalValorPorcPresupuestoSub(val_porc, detalleactividad_id, actividad_valor, detallesubactividad_porc) {

//    if (val_porc > 1) {
//        alert("El porcentaje no puede ser mayor que 1.");
//        $("#porc_sub_" + detalleactividad_id).val(detallesubactividad_porc);
//        return false;
//
//    }

    // var act_cot =  actividad_valor;
    var act_cot = Math.round(actividad_valor);
//console.log(act_cot);
    var val_num_act = parseFloat(act_cot);
    var porc = parseFloat(val_porc);
    //var valor = Math.round((val_num_act * porc),-1);
    var valor = Math.round(val_num_act * porc);
    var formato = valor.toFixed(2);
    // var formato= valor.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    var punt = number_format(formato, 2, ',', '.');

    console.log(valor);
    $("#valor_cal_sub_" + detalleactividad_id).val(punt);
    //  $("#valor_cal_sub_" + detalleactividad_id).val(punt);
    //$("#txt_totalSinIvaSub").val(valor);

}

function DivFechasActiPresupuesto() {

    //$("#md_sub").html(data);
    $("#fechas_acti_presupuesto").dialog({
        width: '400',
        height: '400',
        hide: "scale",
        title: 'Cargar Fechas de la Actividad',
        position: 'top',
        modal: true,
        //position: [280,280],
        create: function (event) {
            $(event.target).parent().css({top: 680, left: 280});
        },
        buttons: {
            "Cerrar": function ()
            {
                $(this).dialog('close');
                $(this).dialog('destroy');
                //$("#fechas_acti_presupuesto").html('');
                //$("#dialog_tramite1").dialog('close');
            }
        }
    });
}

function SaveActividadPresupuesto(baremo_id) {

    var detallepresupuesto_id = $("#detallepresupuesto_id").val();
    var slTipActividad = $("#slTipActividad").val();
    var slModulo = $("#slModulo").val();
    var txt_modulo = $("#txt_modulo").val();
    var txt_Obs = $("#txt_Obs").val();
    var txt_tot_pres = $("#txt_tot_pres").val();

    var dml = document.forms['actividad_presupuesto'];
    // var dml_p = document.forms['frm_DataPresupuesto'];
    var len = dml.elements.length;
    // var len_p = dml_p.elements.length;
    var detalleactividad_id = '';
    var baremoactividad_id = '';
//    var txtPresInicioAct = '';
//    var txtPresFinAct = '';
    var param_txt_detalleactividad_id = '';
    var param_txt_subactividad_id = '';
    var param_valor_porc = '';

    var txt_Objetivo_com = txt_Obs.replace("'", "");
    /*INICIAR CON LAS VALIDACIONES*/
    if (baremo_id == "") {
        alert("No hay actividades para agregar al presupuesto");
        return false;
    }
    if (detallepresupuesto_id == "") {
        alert("Favor crear un presupuesto");
        return false;
    }
    if (slTipActividad == "") {
        alert("Favor Seleccione un tipo de actividad");
        return false;
    }

    if (slModulo == "") {

        if (txt_modulo == "") {
            alert("Favor Seleccione un tipo de modulo");
            return false;
        }

    }

    /**/
    for (var i = 0; i < len; i++)
    {
        if (dml.elements[i].name == 'baremoactividad_id[]') {
            baremoactividad_id += dml.elements[i].value + ",";
        }
    }
    var strlen2 = baremoactividad_id.length;
    baremoactividad_id = baremoactividad_id.slice(0, strlen2 - 1);

    /**/
    for (var i = 0; i < len; i++)
    {
        if (dml.elements[i].name == 'detalleactividad_id[]') {
            detalleactividad_id += dml.elements[i].value + ",";
        }
    }
    var strlen1 = detalleactividad_id.length;
    detalleactividad_id = detalleactividad_id.slice(0, strlen1 - 1);



    /*porcentajes de las actividades*/
    $(".a_txt_porc").each(function (key) {

        var elem_form_mtr = this;
        param_txt_subactividad_id += "" + elem_form_mtr.id + ":" + elem_form_mtr.value + ",";

    });

    var strlen3 = param_txt_subactividad_id.length;
    param_txt_subactividad_id = param_txt_subactividad_id.slice(0, strlen3 - 1);



    /*valor de los porcentajes*/
    $('.a_valor_cal').each(function (key) {

        var elem_form_mtr = this;
        param_valor_porc += key + ":" + elem_form_mtr.value + "|";

    });
    var strlen4 = param_valor_porc.length;
    param_valor_porc = param_valor_porc.slice(0, strlen4 - 1);

    /*Alcances*/
    var param_alcances = new Array();
    $('input[name="Add_alcances[]"]:checked').each(function (key) {
        var elem_form_mtr = this;
        param_alcances += elem_form_mtr.id + ":" + elem_form_mtr.value + "|";
    });
    var strlen5 = param_alcances.length;
    param_alcances = param_alcances.slice(0, strlen5 - 1);
    /**/

    /*Entregables*/
    var param_entregables = new Array();
    $('input[name="Add_entregable[]"]:checked').each(function () {
        var elem_form_mtr = this;
        param_entregables += elem_form_mtr.id + ":" + elem_form_mtr.value + "|";
    });
    var strlen6 = param_entregables.length;
    param_entregables = param_entregables.slice(0, strlen6 - 1);
    /**/

    //alert('param_valor_porc{' + param_valor_porc + '}');
    //alert('param_txt_subactividad_id{' + param_txt_subactividad_id + '} - param_valor_porc {' + param_valor_porc + '}');
    // return false;


    var parametros = {
        'opcion': 'SaveActividadPresupuesto',
        'baremo_id': baremo_id,
        'detallepresupuesto_id': detallepresupuesto_id,
        'slTipActividad': slTipActividad,
        'slModulo': slModulo,
        'txt_modulo': txt_modulo,
        'txt_Obs': txt_Objetivo_com,
        'txt_tot_pres': txt_tot_pres,
        'baremoactividad_id': baremoactividad_id,
        'detalleactividad_id': detalleactividad_id,
        'param_txt_subactividad_id': param_txt_subactividad_id,
        'param_valor_porc': param_valor_porc,
        'alcances': param_alcances,
        'entregables': param_entregables
    };

    $.ajax({
        type: 'post',
        url: 'lib/3presup/controlador/CT_presup.php',
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
                $("#slTipActividad").val('');
                $("#search_item").val('');
                $("#slModulo").val('');
                $("#txt_Obs").val('');
                //  $("#txt_tot_pres").val('');
                $("#div_Add_actividades").css("display", "none");
                AddModulo("");
                ListActividadesPresupuesto(detallepresupuesto_id);
                $("#ActividadesPresupuesto").html('');

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                return false;
            }

        }
    });


}


function DeleteDetallePresupuesto(detallepresupuesto_id, estado) {

    var confrimar = '';

    if (estado == 0) {//Eliminar
        confrimar = confirm("Esta seguro que desea eliminar el presupuesto");
    }

    if (estado == 2) {//Pendiente
        confrimar = confirm("Esta seguro que desea dejar pendiente el presupuesto");
    }

    if (estado == 3) {//Aprobado
        confrimar = confirm("Esta seguro que desea aprobar el presupuesto");
    }


    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/3presup/controlador/CT_presup.php',
            data: {
                opcion: 'DeleteDetallePresupuesto',
                detallepresupuesto_id: detallepresupuesto_id,
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
            gritPresupuesto();
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function DeleteDetallePresupuestoSelect(detallepresupuesto_id, estado) {

    var confrimar = '';

    if (estado == 0) {//Eliminar
        confrimar = confirm("Esta seguro que desea eliminar el presupuesto");
    }

    if (estado == 2) {//Pendiente
        confrimar = confirm("Esta seguro que desea dejar pendiente el presupuesto");
    }

    if (estado == 3) {//Aprobado
        confrimar = confirm("Esta seguro que desea aprobar el presupuesto");
    }



    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/3presup/controlador/CT_presup.php',
            data: {
                opcion: 'DeleteDetallePresupuesto',
                detallepresupuesto_id: detallepresupuesto_id,
                estado: estado

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            // alert('Información guardada correctamente.');
            // gritPresupuesto();
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function JsonDetallePresupuesto(detallepresupuesto_id, control) {

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

    if (control == '1') {
        $("#detallepresupuesto_id").val(jsondata.detallepresupuesto_id);
        $("#txt_Otpresupuesto").val(jsondata.detallepresupuesto_nombre);
        $("#slCliente_OT").val(jsondata.contrato_id);
        $("#slSubestacionOT").val(jsondata.subestacion_id);
        $("#subtotal_pt").val("$" + jsondata.detallepresupuesto_total_formato);
        $("#iva_pt").val("$" + jsondata.detallepresupuesto_incremento_formato);
        $("#total_pt").val("$" + jsondata.total_final_presupuesto_formato);

    } else {
        $("#detallepresupuesto_id").val(jsondata.detallepresupuesto_id);
        $("#txt_presupuesto").val(jsondata.detallepresupuesto_nombre);
        $("#slCliente_pret").val(jsondata.contrato_id);
        $("#slSubestacion").val(jsondata.subestacion_id);
        $("#slGestor").val(jsondata.detallepresupuesto_gestor);
        $("#slPmCodensa").val(jsondata.detallepresupuesto_codensagestor);
        $("#txt_alcance").val(jsondata.detallepresupuesto_alcance);
        $("#txt_Objetivo").val(jsondata.detallepresupuesto_objeto);
        $("#txtPresInicio").val(jsondata.detallepresupuesto_fechaini);
        $("#txtPresFin").val(jsondata.detallepresupuesto_fechafin);
          $("#txt_tot_pres").val(jsondata.detallepresupuesto_total_formato);
       // $("#txt_tot_pres").val(jsondata.total_final_presupuesto_formato);
        $("#total_presupuesto_incremento").val(jsondata.total_final_presupuesto_formato);

        if (jsondata.detallepresupuesto_fechaini == "0000-00-00") {
            $("#txtPresInicio").val("");
        }
        if (jsondata.detallepresupuesto_fechafin == "0000-00-00") {
            $("#txtPresFin").val("");
        }

    }

//    $("#div_baremo").css("display", "block");
//    $("#btn_saveLaborBaremo").css("display", "block");
    //return jsondata;
}

function ListActividadesPresupuesto(detallepresupuesto_id) {

    var cadena = "";
    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        async: false,
        data: {
            opcion: 'ListActividadesPresupuesto',
            detallepresupuesto_id: detallepresupuesto_id

        },
        success: function (retu) {
            JsonDetallePresupuesto(detallepresupuesto_id);
            $("#ActividadesPresupuestoAsignadas").html(retu);
            $("#ActividadesPresupuestoAsignadas").css("display", "block");
            $("#ActividadesPresupuesto").css("display", "none");
            $("#slTipActividad").val('');
            $("#search_item").val('');
            $("#slModulo").val('');
            $("#txt_Obs").val('');
            // $("#txt_tot_pres").val('');
            $("#div_Add_actividades").css("display", "none");
            //alert($totalPorcentajeActividad);
        }

    });
}

function MostrarNuevaActividad() {

    $("#div_Add_actividades").css("display", "block");
    $("#div_copiar").css("display", "none");
    $("#desc_labor").html('');
}

function DeletePresupuestoActividad(baremo_id, detallepresupuesto_id, modulo_id, obs) {

    var confrimar = '';

    confrimar = confirm("Esta seguro que desea eliminar la actividad del presupuesto");

    if (confrimar)
    {
        var data;
        $.ajax({
            type: "POST",
            url: 'lib/3presup/controlador/CT_presup.php',
            data: {
                opcion: 'DeletePresupuestoActividad',
                baremo_id: baremo_id,
                detallepresupuesto_id: detallepresupuesto_id,
                modulo_id: modulo_id,
                obs: obs

            },
            async: false,
            success: function (retu) {
                data = retu;
            }
        });

        if (data == '1' || data == 1)
        {
            alert('Información guardada correctamente.');
            ListActividadesPresupuesto(detallepresupuesto_id);
            JsonDetallePresupuesto(detallepresupuesto_id);
            return false;

        } else {

            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }

}

function EditarActividadPresupuesto(baremo_id, tipobaremo_id, detallepresupuesto_id, modulo_id, control, obs) {

    if (control == 1) {
        //$("#div_Add_actividades").css("display", "block");
        $("#ActividadesPresupuestoOT").css("display", "block");

        $("#ActividadesPresupuestoAsignadasOT").css("display", "none");
    } else {
        $("#div_Add_actividades").css("display", "block");
        $("#ActividadesPresupuesto").css("display", "block");

        $("#ActividadesPresupuestoAsignadas").css("display", "none");
    }


    // traer los datos de la actividad
    var jsondata;

    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        async: false,
        data: {
            opcion: 'JsonDetalleActividad',
            baremo_id: baremo_id,
            tipobaremo_id: tipobaremo_id,
            detallepresupuesto_id: detallepresupuesto_id,
            modulo_id: modulo_id


        },
        success: function (retu) {
            jsondata = retu;
        },
        dataType: "json"
    });

    $("#slTipActividad").val(jsondata.tipobaremo_id);
    $("#search_item").val(jsondata.baremo_item);
    $("#slModulo").val(jsondata.modulo_id);
    $("#txt_Obs").val(obs);
    $("#txt_tot_pres").val(jsondata.detallepresupuesto_total);



    //mostra descripcion de la labor
    var search_item = $("#search_item").val();
    if (search_item != "") {

        $('#desc_labor').html(jsondata.tipobaremo_sigla + "-" + jsondata.baremo_item + ": " + jsondata.labor);
        $('#contenido_labor').css('display', 'block');
    }

    // MOSTRAR SUBACTIVIDADES Y ACTIVIDADES DEL BAREMO 

    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        async: false,
        data: {
            opcion: 'UpdateDataBaremoPresupuesto',
            baremo_id: baremo_id,
            tipobaremo_id: tipobaremo_id,
            detallepresupuesto_id: detallepresupuesto_id,
            modulo_id: modulo_id,
            control: control,
            obs: obs

        },
        success: function (retu) {
            if (control == 1) {
                $("#ActividadesPresupuestoOT").html(retu);
            } else {
                $("#ActividadesPresupuesto").html(retu);
            }

        }

    });
}
function UpdateActividadPresupuesto(baremo_id) {

    var detallepresupuesto_id = $("#detallepresupuesto_id").val();
    var slTipActividad = $("#slTipActividad").val();
    var slModulo = $("#slModulo").val();
    var txt_modulo = $("#txt_modulo").val();
    var txt_Obs = $("#txt_Obs").val();
    var txt_tot_pres = $("#txt_tot_pres").val();

    var dml = document.forms['update_actividad_presupuesto'];
    // var dml_p = document.forms['frm_DataPresupuesto'];
    var len = dml.elements.length;
    // var len_p = dml_p.elements.length;
    var detalleactividad_id = '';
    var baremoactividad_id = '';
//    var txtPresInicioAct = '';
//    var txtPresFinAct = '';
    var param_txt_detalleactividad_id = '';
    var param_txt_subactividad_id = '';
    var param_valor_porc = '';

    /*INICIAR CON LAS VALIDACIONES*/
    if (baremo_id == "") {
        alert("No hay actividades para agregar al presupuesto");
        return false;
    }
    if (detallepresupuesto_id == "") {
        alert("Favor crear un presupuesto");
        return false;
    }
    if (slTipActividad == "") {
        alert("Favor Seleccione un tipo de actividad");
        return false;
    }
    if (slModulo == "") {

        if (txt_modulo == "") {
            alert("Favor Seleccione un tipo de actividad");
            return false;
        }

    }


    /**/
    for (var i = 0; i < len; i++)
    {
        if (dml.elements[i].name == 'baremoactividad_id[]') {
            baremoactividad_id += dml.elements[i].value + ",";
        }
    }
    var strlen2 = baremoactividad_id.length;
    baremoactividad_id = baremoactividad_id.slice(0, strlen2 - 1);

    /**/
    for (var i = 0; i < len; i++)
    {
        if (dml.elements[i].name == 'detalleactividad_id[]') {
            detalleactividad_id += dml.elements[i].value + ",";
        }
    }
    var strlen1 = detalleactividad_id.length;
    detalleactividad_id = detalleactividad_id.slice(0, strlen1 - 1);



    /*porcentajes de las actividades*/
    $(".a_txt_porc").each(function (key) {

        var elem_form_mtr = this;
        param_txt_subactividad_id += "" + elem_form_mtr.id + ":" + elem_form_mtr.value + ",";

    });

    var strlen3 = param_txt_subactividad_id.length;
    param_txt_subactividad_id = param_txt_subactividad_id.slice(0, strlen3 - 1);



    /*valor de los porcentajes*/
    $('.a_valor_cal').each(function (key) {

        var elem_form_mtr = this;
        param_valor_porc += key + ":" + elem_form_mtr.value + "|";

    });
    var strlen4 = param_valor_porc.length;
    param_valor_porc = param_valor_porc.slice(0, strlen4 - 1);

//    alert('param_valor_porc{' + param_valor_porc + '}');
//    alert('param_txt_subactividad_id{' + param_txt_subactividad_id + '} - param_valor_porc {' + param_valor_porc + '}');
//     return false;

    /*Alcances*/
    var param_alcances = new Array();
    $('input[name="Add_alcances[]"]:checked').each(function (key) {
        var elem_form_mtr = this;
        param_alcances += elem_form_mtr.id + ":" + elem_form_mtr.value + "|";
    });
    var strlen5 = param_alcances.length;
    param_alcances = param_alcances.slice(0, strlen5 - 1);
    /**/

    /*Entregables*/
    var param_entregables = new Array();
    $('input[name="Add_entregable[]"]:checked').each(function () {
        var elem_form_mtr = this;
        param_entregables += elem_form_mtr.id + ":" + elem_form_mtr.value + "|";
    });
    var strlen6 = param_entregables.length;
    param_entregables = param_entregables.slice(0, strlen6 - 1);
    /**/


    var parametros = {
        'opcion': 'UpdateActividadPresupuesto',
        'baremo_id': baremo_id,
        'detallepresupuesto_id': detallepresupuesto_id,
        'slTipActividad': slTipActividad,
        'slModulo': slModulo,
        'txt_modulo': txt_modulo,
        'txt_Obs': txt_Obs,
        'txt_tot_pres': txt_tot_pres,
        'baremoactividad_id': baremoactividad_id,
        'detalleactividad_id': detalleactividad_id,
        'param_txt_subactividad_id': param_txt_subactividad_id,
        'param_valor_porc': param_valor_porc,
        'alcances': param_alcances,
        'entregables': param_entregables
    };

    $.ajax({
        type: 'post',
        url: 'lib/3presup/controlador/CT_presup.php',
        dataType: 'xml',
        async: false,
        data: parametros,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1)
            {
                alert('Señor usuario (a), la informacion se actualizo exitosamente');
                $("#slTipActividad").val('');
                $("#search_item").val('');
                $("#slModulo").val('');
                $("#txt_Obs").val('');
                $("#txt_tot_pres").val('');
                $("#div_Add_actividades").css("display", "none");
                AddModulo("");
                ListActividadesPresupuesto(detallepresupuesto_id);
                $("#ActividadesPresupuesto").html('');

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                return false;
            }

        }
    });


}

function DivAlcancesEntregables(presupuesto_id, detallepresupuesto_id, control) {

    var data;
    var url = '';
    var titulo = '';

    if (control == 1) {
        url = 'lib/3presup/view/formAlcances.php';
        titulo = 'Alcances Asociados';
    } else if (control == 2) {
        url = 'lib/3presup/view/formEntregables.php';
        titulo = 'Entregables Asociados';
    }
    $("#div_alc_ent").html("");

    $.ajax({
        type: "POST",
        url: url,
        data: {
            detallepresupuesto_id: detallepresupuesto_id,
            presupuesto_id: presupuesto_id
        },
        async: false,
        success: function (retu) {
            data = retu;
        }

    });

    $("#div_alc_ent").html(data);

    $("#div_alc_ent").dialog({
        width: '950',
        height: '470',
        hide: "scale",
        title: titulo,
        position: 'top',
        modal: true,
        //position: [280,280],
        create: function (event) {
            $(event.target).parent().css({top: 100, left: 470});
        },
        buttons: {
            "Cerrar": function ()
            {
                $(this).dialog('close');
                $(this).dialog('destroy');
                $("#div_alc_ent").html('');
            }
        }
    });
}

function UpdateAlcancesPresupuesto(presupuesto_id) {

    var data;
    var checkboxValues = new Array();
    $('input[name="Add[]"]:checked').each(function () {
        checkboxValues.push($(this).val());
    });
    var alcances = checkboxValues;

    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        data: {
            opcion: 'UpdateAlcancesPresupuesto',
            presupuesto_id: presupuesto_id,
            alcances: alcances
        },
        async: false,
        success: function (retu) {
            data = retu;
        }
    });

    if (data == '1' || data == 1)
    {
        alert('Información almacenada correctamente.');
        $("#div_alc_ent").dialog('close');
        $("#div_alc_ent").dialog('destroy');
        $("#div_alc_ent").html('');
        return false;

    } else {
        alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
        return false;
    }

}

function UpdateEntregablesPresupuesto(presupuesto_id) {

    var data;
    var checkboxValues = new Array();
    $('input[name="Add_ent[]"]:checked').each(function () {
        checkboxValues.push($(this).val());
    });
    var entregables = checkboxValues;

    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        data: {
            opcion: 'UpdateEntregablesPresupuesto',
            presupuesto_id: presupuesto_id,
            entregables: entregables
        },
        async: false,
        success: function (retu) {
            data = retu;
        }
    });

    if (data == '1' || data == 1)
    {
        alert('Información almacenada correctamente.');
        $("#div_alc_ent").dialog('close');
        $("#div_alc_ent").dialog('destroy');
        $("#div_alc_ent").html('');
        return false;

    } else {
        alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
        return false;
    }

}


function DivInfoBaremos() {

    var data;
    var url = '';

    url = 'lib/3presup/view/formInfoBm.php';

    $("#div_info").html("");

    $.ajax({
        type: "POST",
        url: url,
        data: {
        },
        async: false,
        success: function (retu) {
            data = retu;
        }

    });

    $("#div_info").html(data);

    $("#div_info").dialog({
        width: '950',
        height: '470',
        hide: "scale",
        title: "Lista de Baremos Activos",
        position: 'top',
        modal: true,
        //position: [280,280],
        create: function (event) {
            $(event.target).parent().css({top: 100, left: 470});
        },
        buttons: {
            "Cerrar": function ()
            {
                $(this).dialog('close');
                $(this).dialog('destroy');
                $("#div_info").html('');
            }
        }
    });
}

function CopiLabores(detallepresupuesto_id) {

    var modulo_copiar = $("#sl_copiar_md").val();
    var param_labores_copiar = new Array();

    $('input[name="chek_copiar[]"]:checked').each(function (key) {
        var elem_form_mtr = this;
        param_labores_copiar += elem_form_mtr.value + "|";
    });
    var strlen = param_labores_copiar.length;
    param_labores_copiar = param_labores_copiar.slice(0, strlen - 1);

    if (param_labores_copiar == "") {
        alert("No hay labores seleccionadas para copiar.");
        return false;
    }


    if (modulo_copiar == "") {
        alert("Favor seleccione el modulo el cual se van a copiar las labores seleccionadas.");
        return false;
    }

    var parametros = {
        'opcion': 'CopiLabores',
        'detallepresupuesto_id': detallepresupuesto_id,
        'param_labores_copiar': param_labores_copiar,
        'modulo_copiar': modulo_copiar
    };

    $.ajax({
        type: 'post',
        url: 'lib/3presup/controlador/CT_presup.php',
        dataType: 'xml',
        async: false,
        data: parametros,
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error (Petición) { ' + jqXHR + ' - ' + textStatus + ' - ' + errorThrown + ' }');
        },
        success: function (xml) {
            if ($(xml).find('resultado').text() == 1)
            {
                alert('Señor usuario (a), la informacion se almaceno exitosamente');
                $("#slTipActividad").val('');
                $("#search_item").val('');
                $("#slModulo").val('');
                $("#txt_Obs").val('');
                $("#txt_tot_pres").val('');
                $("#div_Add_actividades").css("display", "none");
                AddModulo("");
                ListActividadesPresupuesto(detallepresupuesto_id);
                $("#ActividadesPresupuesto").html('');

            } else if ($(xml).find('resultado').text() == 2) {
                alert('Señor usuario esta actividad ya se encuentra registrada en el presupuesto');
                $("#slTipActividad").val('');
                $("#search_item").val('');
                $("#slModulo").val('');
                $("#txt_Obs").val('');
                $("#txt_tot_pres").val('');
                $("#div_Add_actividades").css("display", "none");
                AddModulo("");
                ListActividadesPresupuesto(detallepresupuesto_id);
                $("#ActividadesPresupuesto").html('');

            } else if ($(xml).find('resultado').text() == 0) {
                alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
                return false;
            }

        }
    });

}

function ListModuloCopiar(control) {
    var retorno;

    $.ajax({
        type: "POST",
        url: 'lib/3presup/controlador/CT_presup.php',
        data: {
            opcion: 'ListModuloCopiar'
        },
        async: false,
        success: function (data) {
            retorno += data;

        }
    });
    $("#" + control + "").html(retorno);

}

function busTabla(camp, tabla_bus)
{
    tabla = $("#" + tabla_bus + "");

    $.uiTableFilter(tabla, camp.value);
}


function calcularIncrementos (){

    var totalAntes = parseFloat($('#txt_tot_pres').val());
    //var numtotalAntes = parseFloat(totalAntes);
    var porcentaje90dias= 0.015;
    

    alert(totalAntes);

   var total90dias = totalAntes * porcentaje90dias;

    $('#incremento_90dias').val(parseFloat(total90dias).toFixed(0));
    
};