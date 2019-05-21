/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function GenerarPeriodoFactura() {
    $.ajax({
        type: "POST",
        url: 'lib/5fct/controlador/CT_fct.php',
        async: false,
        data: {
            opcion: 'GenerarPeriodoFactura'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });


}
function DetalleFacturar() {
    var txt_iva = $("#txt_iva").val();
    var txtInicioFactura = $("#txtInicioFactura").val();
    var txtFinFactura = $("#txtFinFactura").val();


    if (txtInicioFactura == "") {
        alert("Favor ingresar la fecha DESDE para realizar la consulta");
        return false;
    }
    if (txtFinFactura == "") {
        alert("Favor ingresar la fecha HASTA para realizar la consulta");
        return false;
    }

    if (txt_iva == "") {
        alert("Por Favor ingrese el porcentaje de IVA");
        return false;
    }

    DialogCargandosEtiq('CARGANDO...', 'carga_gif');
    $.ajax({
        type: "POST",
        url: 'lib/5fct/controlador/CT_fct.php',
        async: false,
        data: {
            opcion: 'DetalleFacturar',
            txt_iva: txt_iva,
            txtInicioFactura: txtInicioFactura,
            txtFinFactura: txtFinFactura
        },
        success: function (retu) {
            if (retu == 0) {
                alert("No hay Actividades a facturar");
                $("#detalle_factura").html('');
                $('#btn_generar').attr("disabled", true);
                $('#btn_cerrar').attr("disabled", true);
            } else {
                $("#detalle_factura").html(retu);
                $('#btn_generar').attr("disabled", false);
                $('#btn_cerrar').attr("disabled", false);
            }
            $("#carga_gif").dialog('close');
            $("#carga_gif").dialog('destroy');
            $("#carga_gif").html("");
        }
    });


}

function ListActividadesAfacturar(detallepresupuesto_id) {

    var txtInicioFactura = $("#txtInicioFactura").val();
    var txtFinFactura = $("#txtFinFactura").val();
    var cadena = "";

    $.ajax({
        type: "POST",
        url: 'lib/5fct/controlador/CT_fct.php',
        async: false,
        data: {
            opcion: 'ListActividadesAfacturar',
            detallepresupuesto_id: detallepresupuesto_id,
            txtInicioFactura: txtInicioFactura,
            txtFinFactura: txtFinFactura

        },
        success: function (retu) {
            $("#ActividadesPresupuestoAsignadasOT").html(retu);
            $("#ActividadesPresupuestoAsignadasOT").css("display", "block");
            $("#ActividadesPresupuestoOT").css("display", "none");
        }

    });
}

function ActividadNoFaccturar(id_presupuesto, seguimiento_id, detallepresupuesto_id) {
    if ($('#presupuesto_' + id_presupuesto).is(':checked')) {
        alert('Seleccionado');
    } else {
        //No se factura la actividad
        var confrimar = '';

        confrimar = confirm("¿Esta seguro que desea Devolver esta Actividad a Gestion, y no facturar?");

        if (confrimar)
        {
            var data;
            $("#NoFacturar").html("");

            $.ajax({
                type: "POST",
                url: 'lib/5fct/view/formNoFacturar.php',
                data: {
                    pt: id_presupuesto,
                    sg: seguimiento_id,
                    dp: detallepresupuesto_id
                },
                async: false,
                success: function (retu) {
                    data = retu;
                }

            });

            $("#NoFacturar").html(data);
            $("#NoFacturar").dialog({
                width: '500',
                height: '360',
                hide: "scale",
                title: 'No Facturar Actividad',
                position: 'top',
                modal: true,
                //position: [280,280],
                create: function (event) {
                    $(event.target).parent().css({top: 100, left: 620});
                }
            });
        } else {
            $('#presupuesto_' + id_presupuesto).prop('checked', true);
            return false;
        }
        //alert('no Seleccionado');
    }

}
function cerrarNoFactura(id_presupuesto) {


    $("#NoFacturar").dialog('close');
    $("#NoFacturar").dialog('destroy');
    $("#NoFacturar").html('');
    $('#presupuesto_' + id_presupuesto).prop('checked', true);

}

function SaveActividadNoFacturar() {

    var seguimiento_id = $("#seguimiento_id").val();
    var presupuesto_id = $("#presupuesto_id").val();
    var detallepresupuesto_id = $("#detallepresupuesto_id").val();
    var txt_revision = $("#txt_revision").val();
    var txt_des_act = $("#txt_des_act").val();
    var data;

    if (txt_revision == "") {
        alert("Por favor ingrese los datos de la revision");
        return false;
    }

    if (txt_des_act == "") {
        alert("Por favor ingrese el motivo por el cual esta actividad no se puede facturar.");
        return false;
    }

    $.ajax({
        type: "POST",
        url: 'lib/5fct/controlador/CT_fct.php',
        data: {
            opcion: 'SaveActividadNoFacturar',
            sg: seguimiento_id,
            pt: presupuesto_id,
            txt_revision: txt_revision,
            txt_des_act: txt_des_act

        },
        async: false,
        success: function (retu) {
            data = retu;
        }
    });

    if (data == '1' || data == 1)
    {
        ListActividadesAfacturar(detallepresupuesto_id);

        $("#NoFacturar").dialog('close');
        $("#NoFacturar").dialog('destroy');
        $("#NoFacturar").html('');
        return false;

    } else {
        $('#presupuesto_' + presupuesto_id).prop('checked', true);
        alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
        return false;
    }


}


function SaveFactura() {
    var porcentaje = $("#txt_iva").val();
    var fechaIni = $("#txtInicioFactura").val();
    var fechaFin = $("#txtFinFactura").val();
    var num_factura = $("#txt_num_factura").val();
    var txt_subtotal_facturar = $("#txt_subtotal_facturar").val();
    var txt_tot_iva = $("#txt_tot_iva").val();
    var txt_ubicacion = $("#txt_ubicacion").val();
    var txt_tot_factura = $("#txt_tot_factura").val();

    if (fechaIni == "") {
        alert("Por favor Ingrese la fecha inicio del periodo a facturar.");
        return false;
    }

    if (fechaFin == "") {
        alert("Por Favor ingrese la fecha fin del periodo a facturar");
        return false;
    }

    if (num_factura == "") {
        alert("Por favor ingrese el numero de la factura.");
        return false;
    }

    if (txt_subtotal_facturar == "") {
        alert("Por favor dar clic sobre el boton Ver Detalle para cargar los valores a facturar.");
        return false;
    }

    var confrimar = '';

    confrimar = confirm("¿Esta seguro que desea generar la factura?");

    if (confrimar)
    {
        GenerarFactura(0);

        var data;
        $.ajax({
            type: "POST",
            url: 'lib/5fct/controlador/CT_fct.php',
            async: false,
            data: {
                opcion: 'SaveFactura',
                porcentaje: porcentaje,
                fechaIni: fechaIni,
                fechaFin: fechaFin,
                num_factura: num_factura,
                txt_subtotal_facturar: txt_subtotal_facturar,
                txt_tot_iva: txt_tot_iva,
                txt_ubicacion: txt_ubicacion,
                txt_tot_factura: txt_tot_factura
            },
            success: function (retu) {
                data = retu;
            }
        });
        if (data == '1' || data == 1)
        {
            alert("La factura se Genero correctamente");
            loadingFunctions('lib/5fct/view/formNewFct.php', 'codigo');
            return false;

        } else {
            alert("Se presento error al intentar realizar la operacion, intentar mas tarde");
            return false;
        }
    } else {
        return false;
    }


}


function ListCerradas() {
    $.ajax({
        type: "POST",
        url: 'lib/5fct/controlador/CT_fct.php',
        async: false,
        data: {
            opcion: 'ListCerradas'
        },
        success: function (retu) {
            $("#contenido").html(retu);
        }
    });


}

/** 
* @Author: Daniel Rueda
* @Email: sneider.rueda@gmail.com
* @Date: 2019-05-09
* @Desc:  Agregar registros base de datos para actas
*/

function agregar_conciliacion(actividad_id,cantidad,valor_subtotal,acta){

    /*
    DECLARACIÓN DE VARIABLES
     */
    var iva = $('#txt_iva').val();
    var detallepresupuesto_id = $('#detallepresupuesto_id').val();
    var porcentaje = $('#porc_sub_' + actividad_id).val();
    var valor_labor = $('#valor_string' + actividad_id).val();
    var ot = $('#txt_num_orden').val();
    var txtInicioFactura = $("#txtInicioFactura").val();
    var txtFinFactura = $("#txtFinFactura").val();
    var id_ot = $('#ot_id_' + actividad_id).val();
    var presupuesto_id = $('#pre_id_' + actividad_id).val();
    var modulo_id = $('#mod_id_' + actividad_id).val();
    
    


    /*
    DATOS A ENVIAR AL FUNCION PHP
     */
    var parametros = {
                        'opcion': 'agregar_conciliacion',
                        'iva': iva,
                        'acta' : acta,
                        'detallepresupuesto_id': detallepresupuesto_id,
                        'presupuesto_id': presupuesto_id,
                        'porcentaje': porcentaje,
                        'valor_labor': valor_labor,
                        'ot': ot,
                        'cantidad': cantidad,
                        'valor_subtotal': valor_subtotal,
                        txtInicioFactura: txtInicioFactura,
                        txtFinFactura: txtFinFactura,
                        'id_ot' : id_ot,
                        modulo_id : modulo_id
                    };

    /*
    ENVIO DE DATOS AL PHP
     */
    $.ajax({
        type: "POST",
        url: 'lib/5fct/controlador/CT_fct.php',
        async: false,
        data: parametros,
        success: function (retorno) {
            response=retorno;
        }
    });

    console.log(response);
}// END