<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$detallepresupuesto_id = htmlspecialchars(strip_tags(trim($_POST['detallepresupuesto_id'])));
?>

<script>
    var detallepresupuesto_id = '<?php echo $detallepresupuesto_id ?>';
    var dataIncremento = JsonDetallePresupuestoIncremento(detallepresupuesto_id);

    $("#txt_totalPresupuesto").val(number_format(dataIncremento.detallepresupuesto_total, 0, ',', '.'));

    var total_incremento_presupuesto = Math.round(parseFloat(dataIncremento.detallepresupuesto_total) + parseFloat(dataIncremento.detallepresupuesto_valorincremento));
    $("#txt_totalPresupuestoIncremento").val(number_format(total_incremento_presupuesto, 0, ',', '.'));

    if (dataIncremento.detallepresupuesto_tipoincremento == "3") {// presupuesto con varios incrementos



        $("#txt_porc_incremento_total").val(dataIncremento.detallepresupuesto_porcentincremento);
        $("#slc_tipo_incremento").val("");
        $("#txt_total_Incrementos").val(number_format(dataIncremento.detallepresupuesto_valorincremento, 0, ',', '.'));
        /*MOSTRAR CAMPOS*/
        $("#tableMoreIncremento").css('display', 'block');
        $("#total_incrementos").css('display', 'block');
        $("#total_porcentaje").css('display', 'block');
        var JsonIncrementor = JsonDetallePresupuestoIncrementos(detallepresupuesto_id);

        if (JsonIncrementor.registros == 0 || JsonIncrementor.registros == "0") {
            $("#tableMoreIncremento").css("display", "none");
        } else {
            var concat = "'";

            $.each(JsonIncrementor.incrementos, function (key, data_incremento) {
                table_incrementos = '<tr id="tr_incremento_add_' + data_incremento.incrementopresupuesto_idtipo + '">' +
                        '<td><button type="button" name="btn_eliminar_inc_' + data_incremento.incrementopresupuesto_idtipo + '" id="btn_eliminar_inc_' + data_incremento.incrementopresupuesto_idtipo +
                        '" class="btn btn-default btn-xs" onclick="deltableIncremento(' + data_incremento.incrementopresupuesto_idtipo + ',' + concat + data_incremento.incrementopresupuesto_porcentaje +
                        concat + ',' + concat + data_incremento.incrementopresupuesto_valor_formato + concat + ');contadorFilasTablaGeneral(' + concat +
                        'incrementoAddTR' + concat + ',' + concat + 'txt_add_incremento' + concat +
                        ');"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>Eliminar</button></td>' +
                        '<td>' + data_incremento.incrementopresupuesto_tipo + '</td>' +
                        '<td>' + data_incremento.incrementopresupuesto_porcentaje + '</td>' +
                        '<td>' + data_incremento.incrementopresupuesto_valor_formato + '</td>' +
                        '<input type="hidden" name="idAddIncremento[]" id="idAddIncremento" value="' + data_incremento.incrementopresupuesto_idtipo + '">' +
                        '<input type="hidden" name="txt_porc_incremento_array[]" id="txt_porc_incremento_array" value="' + data_incremento.incrementopresupuesto_porcentaje + '">' +
                        '<input type="hidden" name="txt_totalIncremento_array[]" id="txt_totalIncremento_array" value="' + data_incremento.incrementopresupuesto_valor_formato + '">' +
                        '<input type="hidden" name="txt_lb_incremento_array[]" id="txt_lb_incremento_array" value="' +  data_incremento.incrementopresupuesto_tipo + '">' +
                        '</tr>';

                $("#incrementoAddTR").append(table_incrementos);
            });
        }




    } else {

        //$("#txt_totalPresupuesto").val( dataIncremento.detallepresupuesto_total);
        $("#txt_porc_incremento").val(dataIncremento.detallepresupuesto_porcentincremento);
        $("#slc_tipo_incremento").val(dataIncremento.detallepresupuesto_tipoincremento);
        $("#txt_totalIncremento").val(number_format(dataIncremento.detallepresupuesto_valorincremento, 0, ',', '.'));


    }


</script>

<form id="frm_Incremento" class="form-horizontal">
    </br></br>
    <div class="form-group">
        <label for="lb_total_presupuesto" class="col-sm-3 control-label">Total Presupuesto:</label>
        <div class="col-sm-5">                
            <input type="text" class="form-control" id="txt_totalPresupuesto" name="txt_totalPresupuesto" disabled="disabled">
        </div>
    </div>


    <div class="form-group">
        <label for="lb_porcentaje" class="col-sm-3 control-label">Factor Incremento:</label>
        <div class="col-sm-5">                
            <input type='text' id='txt_porc_incremento' name='txt_porc_incremento' maxlength='6' value='' placeholder='00.00' style='width:60px' class='input-medium' onkeypress='return decimales(event)' onblur='TipoIncrementoPresupuesto(<?php echo $detallepresupuesto_id; ?>)'>
        </div>
    </div>

    <div class="form-group">
        <label for="lb_total_presupuesto" class="col-sm-3 control-label">Total Incremento:</label>
        <div class="col-sm-5">                
            <input type="text" class="form-control" id="txt_totalIncremento" name="txt_totalIncremento" disabled="disabled">
        </div>
    </div>


    <div class="form-group">
        <label for="slc_tipo_inc" class="col-sm-3 control-label">Tipo de Incrmento:</label>
        <div class="col-sm-5">
            <select class="form-control" id="slc_tipo_incremento" name="slc_tipo_incremento" onblur="TipoIncrementoPresupuesto(<?php echo $detallepresupuesto_id; ?>);" >
                <option value="">-Seleccione-</option>                        
                <option value="0">Sin Incremento</option>                        
                <option value="1">Actividades de Levantamento</option>
                <option value="2">Total el Presupuesto</option>
            </select>
            <input type="hidden" name="txt_add_incremento" id="txt_add_incremento" value="">
            <button type="button" name="btnAddTecnico" id="btnAddTecnico" class="btn btn-default btn-xs" onclick="addIncrementoPresupuesto();
                    contadorFilasTablaGeneral('incrementoAddTR', 'txt_add_incremento');"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Adicionar</button>&nbsp;
            <div id="tableMoreIncremento" style="display: none;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Acción</th>
                            <th>Tipo</th>
                            <th>Factor</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody id="incrementoAddTR">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group"  style="display: none;" id="total_incrementos">
        <label for="lb_total_presupuesto" class="col-sm-3 control-label">Total Incrementos:</label>
        <div class="col-sm-5">                
            <input type="text" class="form-control" id="txt_total_Incrementos" name="txt_total_Incrementos" value="0" disabled="disabled">
        </div>
    </div>

    <div class="form-group" style="display: none;" id="total_porcentaje" >
        <label for="lb_porcentaje" class="col-sm-3 control-label">Factor total Incrementos:</label>
        <div class="col-sm-5">                
            <input type='text' id='txt_porc_incremento_total' name='txt_porc_incremento_total' maxlength='6' disabled="disabled" value='0' placeholder='00.00' style='width:60px' class='input-medium' onkeypress='return decimales(event)' onblur='TipoIncrementoPresupuesto(<?php echo $detallepresupuesto_id; ?>)'>
        </div>
    </div>

    <div class="form-group">
        <label for="lb_total_presupuesto" class="col-sm-3 control-label">Total Presupuesto + Incremento:</label>
        <div class="col-sm-5">                
            <input type="text" class="form-control" id="txt_totalPresupuestoIncremento" name="txt_totalPresupuestoIncremento" disabled="disabled">
        </div>
    </div>

</form>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-4">
        <button id="btoGuardar" name="btoGuardar" class="btn btn-primary" type="submit" onclick="SaveIncremento(<?php echo $detallepresupuesto_id ?>);" >Guardar</button>                                
    </div>
</div>