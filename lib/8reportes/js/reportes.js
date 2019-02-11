/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function td_resumenAsignadasLb(id_contrato, year) {
    $.ajax({
        type: "POST",
        url: 'lib/8reportes/controlador/CT_reportes.php',
        async: false,
        data: {
            opcion: 'td_resumenAsignadasLb',
            id_contrato: id_contrato,
            year: year
        },
        success: function (retu) {
            $("#tb_resumen").html(retu);
        }
    });

}
function DataDetalleLabores(data) {

    $.ajax({
        type: "POST",
        url: 'lib/8reportes/controlador/CT_reportes.php',
        async: false,
        data: {
            opcion: 'DataDetalleLabores',
            id: data
        },
        success: function (retu) {
            $("#td_detalle").html(retu);
        }
    });
}


function graficaLaboresTerminadas(id_contrato, year) {
    $("#canvas").html("");
    if (window.myLine) {
        window.myLine.clear();
        window.myLine.destroy();
    }
    datasets_labores = ajaxLaboresTerminadas(id_contrato, year);

    var config = {
        type: 'bar',
        data: {
            labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
            datasets: datasets_labores
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Labores finalizadas por Área'
            },
            /* tooltips: {
             mode: 'index',
             intersect: false
             },*/
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {


                        /* if (label) {
                         label += ': ';
                         }
                         label += Math.round(tooltipItem.yLabel * 100) / 100;*/
                        var value = tooltipItem.yLabel;
                        value = value.toString();
                        value = value.split(/(?=(?:...)*$)/);

                        // Convert the array to a string and format the output
                        value = value.join(".");

                        return "COP : " + value;
                    }
                }
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Meses'
                        }
                    }],
                yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Dinero'
                        },
                        /*  ticks: {
                         min: 0,
                         max: 100000000,
                         // forces step size to be 5 units
                         stepSize: 100000
                         }*/
                        ticks: {
                            beginAtZero: true,
                            // Return an empty string to draw the tick line but hide the tick label
                            // Return `null` or `undefined` to hide the tick line entirely
                            userCallback: function (value, index, values) {
                                // Convert the number to a string and splite the string every 3 charaters from the end
                                value = value.toString();
                                value = value.split(/(?=(?:...)*$)/);

                                // Convert the array to a string and format the output
                                value = value.join(".");
                                return value;
                            }
                        }
                    }]
            }
        }
    };

    var ctx = document.getElementById('canvas').getContext('2d');

    window.myLine = new Chart(ctx, config);


}

function ajaxLaboresTerminadas(id_contrato, year) {
    var json;

    $.ajax({
        type: "POST",
        url: 'lib/8reportes/controlador/CT_reportes.php',
        async: false,
        dataType: 'json',
        data: {
            opcion: 'GfLaboresArea',
            id_contrato: id_contrato,
            year: year
        },
        success: function (retu) {
            json = retu;
        }
    });

    return json;
}

function CalendarioLaboresRealizadas(date) {

    var jsonSeguimientocalendario = seguimientoCalendario();
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'prevYear,month,agendaWeek,agendaDay,nextYear'
        },
        locale: 'es',

        //defaultDate: '2018-03-12',
        defaultDate: date,
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: jsonSeguimientocalendario
    });
}

function seguimientoCalendario() {
    var json;

    $.ajax({
        type: "POST",
        url: 'lib/8reportes/controlador/CT_reportes.php',
        async: false,
        dataType: 'json',
        data: {
            opcion: 'seguimientoCalendario'
        },
        success: function (retu) {
            json = retu;
        }
    });

    return json;
}


function VistaSeguimientoCalendario(id) {
    var response;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: '../controlador/CT_reportes.php',
        async: false,
        data: {
            opcion: 'VistaSeguimientoCalendario',
            presupuesto_id: id
        },
        success: function (data) {
            response = data;
        }
    });
    return response;


}


function FiltrarCalendatioLabor(opc) {

    var retorno = "";

    if (opc != '') {
        $.ajax({
            type: "POST",
            url: "lib/8reportes/view/Lbcalendario.php",
            data: {
                data: opc
            },
            async: false,
            success: function (data) {
                retorno = data;

            }
        });
        $("#calendario").html(retorno);
    } else {
        alert('Señor usuario, seleccione una labor para mostrar sus respectivas fechas de seguimiento.');
        return false;
    }

}

function ValorFacturaLabores(id_contrato, year) {
    var response;
    $("#data_valor").html("");
    $("#total_labores").html("");
    $.ajax({
        type: "POST",
        dataType: "json",
        url: 'lib/8reportes/controlador/CT_reportes.php',
        async: false,
        data: {
            opcion: 'ValorFacturaLabores',
            id_contrato: id_contrato,
            year: year
        },
        success: function (data) {
            response = data;
        }
    });
    //return response;
    var jsonValor = response;

    //var jsonValor = ValorFacturaLabores('',year);
    var area = "";
    //console.log(jsonValor);
    if (jsonValor == 0) {

        var alertaVacio = '<div class="panel panel-info">' +
                '<div class="panel-heading">No hay datos.</div>' +
                '<div class="panel-body"><h5><center><strong>Señor usuarios, No hay dinero de las labores finalizadas.</strong></center></h5></div>' +
                '</div>';
        $("#tb_valor").html(alertaVacio);
    } else {

        $.each(jsonValor.dataValorlabores, function (key2, data) {


            data_table = "<tr>" +
                    "<td>" + data.area_nombre + "</td>" +
                    "<td>" + data.factura + "</td>" +
                    "</tr>";
            $("#data_valor").append(data_table);


        });

        $("#total_labores").html("Total dinero $" + jsonValor.valor_total);
    }


}

