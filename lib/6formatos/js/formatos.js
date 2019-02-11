/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function DescargarPresupuestoXlsx(detalle_presupuesto) {

    window.location.href = 'lib/6formatos/view/xlsxPret.php?er=' + detalle_presupuesto;
}

function DescargarDescargo(descargo_id) {

    window.location.href = 'lib/6formatos/view/wordDesc.php?er=' + descargo_id;
}

function DescargarPresupuestoWord(detalle_presupuesto) {

    location.href = 'lib/6formatos/view/wordOt.php?er=' + detalle_presupuesto;
}

function GenerarFactura(abrir) {
    var porcentaje = $("#txt_iva").val();
    var fechaIni = $("#txtInicioFactura").val();
    var fechaFin = $("#txtFinFactura").val();

    if (fechaIni == "") {
        alert("Por favor Ingrese la fecha inicio del periodo a facturar.");
        return false;
    }

    if (fechaFin == "") {
        alert("Por Favor ingrese la fecha fin del periodo a facturar");
        return false;
    }
    DialogCargandosEtiq('GENERANDO INFORME', 'carga_gif');
    window.location.href = 'lib/6formatos/view/xlsxFacDetalle.php?er=' + porcentaje + '&fh=' + fechaIni + '&ff=' + fechaFin+ '&ab=' + abrir;
    $("#carga_gif").dialog('close');
    $("#carga_gif").dialog('destroy');
    $("#carga_gif").html("");
}

function GenerarActas() {
    var porcentaje = $("#txt_iva").val();
    var fechaIni = $("#txtInicioFactura").val();
    var fechaFin = $("#txtFinFactura").val();

    if (fechaIni == "") {
        alert("Por favor Ingrese la fecha inicio del periodo a facturar.");
        return false;
    }

    if (fechaFin == "") {
        alert("Por Favor ingrese la fecha fin del periodo a facturar");
        return false;
    }
    window.location.href = 'lib/6formatos/view/xlsxActas.php?er=' + porcentaje + '&fh=' + fechaIni + '&ff=' + fechaFin;
}