/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function number_format(number, decimals, dec_point, thousands_sep) {
    var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function puntos(donde, caracter) {
    var pat = /[\*,\+,\(,\),\?,\,$,\[,\],\^]/;
    var valor = donde.value;
    var largo = valor.length;
    var crtr = true;
    if (isNaN(caracter) || pat.test(caracter) == true) {
        if (pat.test(caracter) == true) {
            caracter = "/" + caracter;
        }
        carcter = new RegExp(caracter, "g");
        valor = valor.replace(carcter, "");
        donde.value = valor;
        crtr = false;
    } else {
        var nums = new Array()
        cont = 0
        for (m = 0; m < largo; m++) {
            if (valor.charAt(m) == "." || valor.charAt(m) == " ")
            {
                continue;
            } else {
                nums[cont] = valor.charAt(m)
                cont++
            }
        }
    }
    var cad1 = "", cad2 = "", tres = 0
    if (largo > 3 && crtr == true) {
        for (k = nums.length - 1; k >= 0; k--) {
            cad1 = nums[k]
            cad2 = cad1 + cad2
            tres++
            if ((tres % 3) == 0) {
                if (k != 0) {
                    cad2 = "." + cad2
                }
            }
        }
        donde.value = cad2
    }
}
function letras(e)
{
    tecla = e.which || e.keyCode;
    if (tecla == 8 || tecla == 9)
        return true;
    patron = /[A-Za-z\s]/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}


function NumeroNegativos(id) {

    var size = $('#' + id.id).val().length;
    var key = window.event.keyCode;
    if (key >= 48 && key <= 57 || key == 46 || key == 44) {
        if (size == 0)
        {
            $('#' + id.id).val("-")
        }
        return key;
    } else {
        return false;
    }
}
function numeros(e)
{
    tecla = e.which || e.keyCode;
    if (tecla == 8 || tecla == 9)
        return true;
    patron = /^[0-9]*$/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}
function letrasnumeros(e)
{
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8 || tecla == 32)
        return true; //8 = backspace
    patron = /^[a-zA-Z0-9]*$/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}
function decimales(e)
{
    tecla = e.keyCode || e.which;
    if (tecla == 8 || tecla == 0 || tecla == 9)
        return true;
    patron = /^([0-9])*[.]?[0-9]*$/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}
function QuitaEspacio(e, campo) {
    key = e.keyCode ? e.keyCode : e.which;
    if (key == 32) {
        return false;
    }
}
function aMayusculas(obj, id) {
    obj = obj.toUpperCase();
    document.getElementById(id).value = obj;
}
function valida_correos(obj) {
    var correo_log = obj.value
    if (correo_log != '') {
        re = /^[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(.[a-zA-Z0-9-]+)*(.[a-zA-Z]{2,3})$/
        if (!re.exec(correo_log))
        {
            alert("El correo electrónico ingresado no es valido.")
            $("#" + obj.id + "").val('');

        }
    } else {
        return false;
    }
}


function ValidatePass(clave1_txt, clave2_txt, identificacion) {

    var clave_1 = $("#" + clave1_txt + "").val();
    var clave_2 = $("#" + clave2_txt + "").val();

    var conteo_numeros = 0;
    var conteo_letras = 0;
    var xxx = identificacion;
    var conteo_minusculas = 0;
    var conteo_mayusculas = 0;
    var clave = clave_1;
    var longitud = clave.length;
    var letras_mayusculas = "ABCDEFGHIYJKLMNÑOPQRSTUVWXYZ";
    var letras = "abcdefghiyjklmnñopqrstuvwxyz";
    var numeros = "0123456789";
    var espacios = " ";
    var conteo_espacios = 0;


    var yyy = clave.replace(/\D/g, '');
    var rgxp = new RegExp(yyy, "g");

    if (xxx.match(rgxp))
    {
        var res = xxx.match(rgxp).length;
    } else
    {
        res = 0;
    }

    var expresion_caracteres = /[^\w\s]/gi;

    for (i = 0; i < clave.length; i++) {
        if (numeros.indexOf(clave.charAt(i), 0) != -1) {
            conteo_numeros = conteo_numeros + 1;
        }
    }
    var texto = clave.toLowerCase();
    for (i = 0; i < texto.length; i++) {
        if (letras.indexOf(texto.charAt(i), 0) != -1) {
            conteo_letras = conteo_letras + 1;
        }
    }

    for (i = 0; i < clave.length; i++) {
        if (letras.indexOf(clave.charAt(i), 0) != -1) {
            conteo_minusculas = conteo_minusculas + 1;
        }
    }
    for (i = 0; i < clave.length; i++) {
        if (letras_mayusculas.indexOf(clave.charAt(i), 0) != -1) {
            conteo_mayusculas = conteo_mayusculas + 1;
        }
    }
    for (i = 0; i < clave.length; i++) {
        if (espacios.indexOf(clave.charAt(i), 0) != -1) {
            conteo_espacios = conteo_espacios + 1;
        }
    }

    if (longitud >= 8)
    {
        $("#error").html('');
        if (conteo_espacios == 0) {

            $("#error").html('');
            if (conteo_numeros > 0) {

                $("#error").html('');
                if (conteo_letras > 0) {

                    $("#error").html('');
                    if (conteo_minusculas > 0) {

                        $("#error").html('');
                        if (conteo_mayusculas > 0) {

                            $("#error").html('');
                            if (expresion_caracteres.test(clave)) {

                                $("#error").html('');
                                var reeingreso_clave = clave_2;
                                if (reeingreso_clave == clave) {

                                    $("#error").html('');
                                    $("#txt_validaPass").val("1");

                                    return true;
                                } else {

                                    $("#error").html('Las contraseña no coinciden ');
                                    return false;
                                }

                            } else {

                                $("#error").html('La contraseña debe tener caracteres especiales ');
                                return false;
                            }

                        } else {

                            $("#error").html('La contraseña debe tener letras mayusculas');
                            return false;
                        }

                    } else {

                        $("#error").html('La contraseña debe tener letras minusculas');
                        return false;
                    }

                } else {

                    $("#error").html('La contraseña debe tener letras');
                    return false;
                }

            } else {

                $("#error").html('La contraseña debe tener numeros');
                return false;
            }
        } else {

            $("#error").html('La contraseña no debe contener espacios');
            return false;
        }
    } else {

        $("#error").html('La contraseña debe tener como mínimo 8 caracteres');
        return false;
    }
}


function DialogCargandosEtiq(title, etique) {

    var html = "<center><img src='img/carg.gif'></center>";
    $("#" + etique + "").html(html);
    $("#" + etique + "").dialog({
        width: 300,
        height: 300,
        modal: true,
        position: {
            my: 'top',
            at: 'top+150'
        },
        draggable: true,
        resizable: false,
        title: title
    },
            {
                closeOnEscape: false
            });
}