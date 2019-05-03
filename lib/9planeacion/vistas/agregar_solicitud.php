<!DOCTYPE html>

<html lang="es">

<form id="frm_DataPresupuesto" class="form-horizontal">

	<input type="hidden" class="form-control" id="detallepresupuesto_id" name="detallepresupuesto_id">
	<input type="hidden" class="form-control" id="total_presupuesto_incremento" name="total_presupuesto_incremento">
	<input type="hidden" name="modulo_inicial" id="modulo_inicial" value="1"></th>


<br><br><br><br><br><br><br>
	<fieldset style="color: black">
		<legend class="titulo">Agregar solicitud</legend>

	

		<!-- Subestacion-->
		<div class="form-group">
			<label for="lb_sub" class="col-sm-4 control-label">Subestacion:</label>
			<div class="col-sm-5">
				<select id="slSubestacion" name="slSubestacion" class="form-control" required="true" onchange="AddSubestacion(this.value);">
				</select>
			</div>
		</div>

		<!-- Gestor-->
            								<div class="form-group">
            									<label for="lb_gestor" class="col-sm-4 control-label">Gestor Proyecto:</label>
            									<div class="col-sm-5">
            										<select id="slGestor" name="slGestor" class="form-control" required="true" onblur="enviar(this.value)">
            										</select>
            									</div>
            								</div>

<!--Objetivo-->
            								<div class="form-group">
            									<label for="lb_objetivo" class="col-sm-4 control-label">Objeto OT:</label>
            									<div class="col-sm-5">
            										<textarea class="form-control" id="txt_Objetivo" name="txt_Objetivo" rows="5" cols="40" placeholder="Objetivo del Proyecto"></textarea>
            									</div>
            								</div>





		<!-- FUNCIONES  -->
		<script type="text/javascript">
			var detallepresupuesto_id = '<?php echo $detallepresupuesto_id ?>';
			var jsonlsMd = ListModulo('slModulo');
    //console.log(jsonlsMd);
    var retorno = "<option value=''>-Seleccione-</option>";
    var retorno = "<option value='nuevo'>Nuevo Módulo</option>";
    $.each(jsonlsMd.MODULO, function(key, data) {

    	retorno += '<option value="' + data.modulo_id + '">' + data.modulo_descripcion + '</option>';

    });
    //$("#slModulo").append('<option value="'+data.modulo_id+'">'+data.modulo_descripcion+'</option>');
    $("#slModulo").html(retorno);

    ListContratClien('slCliente_pret');
    ListSubestacion('slSubestacion');
    ListGestor('slGestor');
    ListTipBaremo('slTipActividad');
    ListarPmCodensa('slPmCodensa');


    if (detallepresupuesto_id != 0) {
    	ListActividadesPresupuesto('<?php echo $detallepresupuesto_id ?>');
    	JsonDetallePresupuesto('<?php echo $detallepresupuesto_id ?>');
    	check();
    }
</script>

<!-- FUNCIONES DE FECHA Y HORA -->
<script type="text/javascript">
	$(function() {
		$('#PresInicio').datetimepicker({
            //viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2016'

        });
		$('#PresFin').datetimepicker({
            //  viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2016'
        });

		$('#PresInicioAct').datetimepicker({
            // viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2016'

        });
		$('#PresFinAct').datetimepicker({
            //viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2016'
        });

		$.notifyDefaults({
			type: 'success',
			allow_dismiss: false
		});
		$.notify('Total Presupuesto con incremento: ' + $("#total_presupuesto_incremento").val());
	});
</script>
</html>