/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function CallMenu() {

    var retorno;
    $.ajax({
        type: "POST",
        url: 'lib/1config/controlador/CT_1config.php',
        async: false,
        data: {
            opcion: "CallMenu"
        },
        success: function (retu) {
            retorno = retu;

        }

    });
    $("#menu_sistema").html(retorno);
}

function loadingFunctions(url, div, data) {
    var retorno;

    $.ajax({
        type: "POST",
        url: url,
        data: {
            data: data
        },
        async: false,
        success: function (retu) {
            retorno = retu;
        }
    });

    $("#" + div + "").html(retorno);

}


