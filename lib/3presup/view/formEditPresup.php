<?php

/*
  Autor:jennifer.cabiativa@gmail.com
  Modificaciones: sneider.rueda@gmail.com
 */


  $detallepresupuesto_id = htmlspecialchars(strip_tags(trim($_POST['data'])));
  ?>

  <!DOCTYPE html>

  <html lang="es">

  <form id="frm_DataPresupuesto" class="form-horizontal">

  	<input type="hidden" class="form-control" id="detallepresupuesto_id" name="detallepresupuesto_id">
  	<input type="hidden" class="form-control" id="total_presupuesto_incremento" name="total_presupuesto_incremento">
  	<input type="hidden" name="modulo_inicial" id="modulo_inicial" value="1"></th>

    <br><br><br><br><br>
  	<fieldset style="color: black">
  		<legend class="titulo text-center">Generar Presupuesto</legend>
        <legend class="titulo" style="display: flex; justify-content: space-around;">
            <div class="text-center">
                <label>Total Presupuesto: </label>
                <input id="txt_total" class="text-center" type="text" disabled="disabled">
            </div>
            <div class="text-center">
                <label>No. Labores: </label>
                <label class="text-center"><p id="lbl_labores"></p></label>
            </div>
        </legend>

        <!-- Siguiente div contiene as tabs -->
        <div class="container">
        	<div class="row">
        		<div class="col-md-12 ">
        			<div role="tabpanel" class="">
        				<ul class="nav nav-tabs borde_inf" role="tablist" id="agregar_tab">
        					<li role="presentation" id="tab0" class="active"><a href="#seccion0" aria-controls="seccion0" data-toggle="tab" role="tab">Informacion General</a></li>
        					<li role="presentation" id="tab1" class=""><a href="#seccion1" aria-controls="seccion1" data-toggle="tab" role="tab">Agregar Actividades</a></li>
        					<li role="presentation" id="tab2" class=""><a href="#seccion2" aria-controls="seccion2" data-toggle="tab" role="tab">Actividades Asignadas</a></li>
        				</ul>

        				<div class="tab-content" id="tab-content">

        					<div role="tabpanel" class="tab-pane active" id="seccion0">
        						<br>
        						<br>
        						<nav class="barraPre fondo letraN">
        							<div class="inline ">
        								<h4>Presupuesto: </h4>
        								<button id="btoGuardarPresupuesto" name="btoGuardarPresupuesto" class="btn btn-primary" type="submit" onclick="SavePresupuesto();">Guardar</button>
        								<button type="button" class="btn btn-default" name="btnCancelar" id="btnCancelar" onclick="gritPresupuesto();">Cancelar</button>
        							</div>
        							
        							<div class="inline ">
        								<button name="btnNew" id="btnNew" class="btn btn-info letraBl" type="button" onclick="agregar_actividad();" style="font-weight: bold;">Nueva Actividad</button>
        							</div>

									<?php
        							if ($detallepresupuesto_id != 0) {
        							?>

        							<div class="inline ">
										<button id="subirDocumentos" name="subirDocumentos" class="btn btn-warning" type="" onclick="agregarDocumento()" style="color:black"><span class="glyphicon glyphicon-upload"></span><strong> Subir Documentos</strong></button>
									</div>

        							<!-- <div class="inline ">
										<button id="calcularIncrementos" name="calcularIncrementos" class="btn btn-success" type="" onclick="guardarIncrementos()" style="color:black"><span class="glyphicon glyphicon-floppy-save"></span><strong> Guardar Incrementos</strong></button>
									</div> -->
                                    <div class="inline ">
                                        <button class='btn btn-success'  onclick='DivIncremento("<?php echo $detallepresupuesto_id ?>")' style='color:black'><span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span> Agregar Incrementos </button>
                                    </div>

   									<?php
       								}
      								?>
        						</nav>

        						<br>

        						<article>

        							<div class="col-sm-6">
        								<?php if ($detallepresupuesto_id != 0) { ?>
        									<div class="form-group">
        										<label for="slc_Estado" class="col-sm-3 control-label">Estado</label>
        										<div class="col-sm-8">
        											<select class="form-control" id="slc_regimen" name="slc_estado_presupuesto" onclick="DeleteDetallePresupuestoSelect(<?php echo $detallepresupuesto_id; ?>, this.value);">
        												<option value="1">-Seleccione-</option>
        												<option value="2">Pendiente</option>
        												<option value="3">Guardado</option>
        											</select>
        										</div>
        									</div>
        								<?php } ?>

        								<!-- Presupuesto-->
        								<div class="form-group">
        									<label for="lb_nombre" class="col-sm-3 control-label">Nombre:</label>
        									<div class="col-sm-8">
        										<input type="text" class="form-control" id="txt_presupuesto" name="txt_presupuesto" placeholder="Nombre de Presupuesto" onblur="aMayusculas(this.value, this.id);">
        									</div>
        								</div>

        								<!-- Cliente-->
        								<div class="form-group">
        									<label for="lb_cliente" class="col-sm-3 control-label">Cliente:</label>
        									<div class="col-sm-8">
        										<select id="slCliente_pret" name="slCliente_pret" class="form-control data" required="true">
        										</select>
        									</div>
        								</div>


        								<!-- Subestacion-->
        								<div class="form-group">
        									<label for="lb_sub" class="col-sm-3 control-label">Subestacion:</label>
        									<div class="col-sm-8">
        										<select id="slSubestacion" name="slSubestacion" class="form-control" required="true" onchange="AddSubestacion(this.value);">
        										</select>
        									</div>
        								</div>

        								<!--Objetivo-->
        								<div class="form-group">
        									<label for="lb_objetivo" class="col-sm-3 control-label">Objeto OT:</label>
        									<div class="col-sm-8">
        										<textarea class="form-control" id="txt_Objetivo" name="txt_Objetivo" rows="5" cols="40" placeholder="Objetivo del Proyecto"></textarea>
        									</div>
        								</div>

        								<!--Alcance-->
        								<div class="form-group">
        									<label for="lb_alcance" class="col-sm-3 control-label">Alcance:</label>
        									<div class="col-sm-8">
        										<textarea class="form-control" id="txt_alcance" name="txt_alcance" rows="5" cols="40" placeholder="Alcance del Proyecto por Modulos"></textarea>
        									</div>
        								</div>
        							</div>

        							<div class="col-sm-6">
                                        
                                        <!-- Presupuesto-->
                                        <div class="form-group">
                                            <label for="lb_nombre" class="col-sm-3 control-label">OT anteriores:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="txt_otAnteriores" name="txt_otAnteriores" placeholder="Ot Anteriores" onblur="aMayusculas(this.value, this.id);">
                                            </div>
                                        </div>


        								<!-- Gestor-->
        								<div class="form-group">
        									<label for="lb_gestor" class="col-sm-3 control-label">Gestor Proyecto:</label>
        									<div class="col-sm-8">
        										<select id="slGestor" name="slGestor" class="form-control" required="true" onblur="enviar(this.value)">
        										</select>
        									</div>
        								</div>

        								<!-- Gestor-->
        								<div class="form-group">
        									<label for="lb_PmCodensa" class="col-sm-3 control-label">PM Codensa:</label>
        									<div class="col-sm-8">
        										<select id="slPmCodensa" name="slPmCodensa" class="form-control" required="true" onblur="enviar(this.value)">
        										</select>
        									</div>
        								</div>

        								<!--Fecha inicio-->
        								<div class="form-group">
        									<label for="lb_inicio" class="col-sm-3 control-label">Fecha Inicio Presupuesto:</label>
        									<div class="col-sm-8 input-group date" id='PresInicio' style="width:200px">
        										<input type='text' id="txtPresInicio" name="txtPresInicio" class="form-control" readonly />
        										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        									</div>
        								</div>

        								<!--Fecha fin -->
        								<div class="form-group">
        									<label for="lb_fin" class="col-sm-3 control-label">Fecha Fin Presupuesto:</label>
        									<div class="col-sm-8 input-group date" id='PresFin' style="width:200px">
        										<input type='text' id="txtPresFin" name="txtPresFin" class="form-control" readonly />
        										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        									</div>
        								</div>



        								<!--TOTAL PRESUPUESTO-->
        								<div class="form-group">
        									<label for="lb_tot_pres" class="col-sm-3 control-label">Total Presupuesto sin incrementos: $</label>
        									<div class="col-sm-8">
        										<input type="text" class="form-control data" id="txt_tot_pres" name="txt_tot_pres" disabled="disabled" value="0" style="width:200px">
        									</div>
        								</div>


        								<!-- <?php

        								if ($detallepresupuesto_id != 0) {

        									?>
-->

        									<!--Porcentaje por ubicación-->
        									<!-- <div class="form-group"> 
        										<label for="lb_tot_pres" class="col-sm-3 control-label">Incrementos por ubicación 3%</label>
        										<div class="col-sm-8">
        											<input type="checkbox" id="checkboxUbicacion" name="checkboxUbicacion" style="width: 20px; height: 20px"></input>
        											<input type="hidden" id="check" value="0"></input>
        											<input type="text" class="form-control data" id="incremento_ubicacion" name="txt_tot_pres" disabled="disabled" value="" style="width:179px">
        										</div>
        									</div> -->



        									<!-- Porcentaje pago 90 dias -->
        									<!-- <div class="form-group">
        										<label for="lb_tot_pres" class="col-sm-3 control-label">Pago a 90 dias, 1.5%: $</label>
        										<div class="col-sm-8">
        											<input type="text" class="form-control data" id="incremento_90dias" disabled="disabled" value="" style="width:200px">
        										</div>
        									</div>
-->
        									<!-- Total presupuesto con incrementos -->
        									<!-- <div class="form-group">
        										<label for="lb_tot_pres" class="col-sm-3 control-label">Total presupuesto con incrementos: $</label>
        										<div class="col-sm-8">
        											<input type="text" class="form-control data" id="totalIncrementos" name="txt_tot_pres" disabled value="" style="width:200px">
        										</div>
        									</div>
        								<?php } ?> -->
        							</div>
        						</article>
        					</div>
   
                            <div role="tabpanel" class="tab-pane" id="seccion1">
                            	<div id="div_Add_actividades" class="padding" style="display: none;">
                            		<input type="hidden" class="form-control" id="presupuesto_id" name="presupuesto_id">
                            		<br>
                            		<nav class="barraPre fondo letraN">
                            			<div class="inline ">
                            				<button name="btnListActividadesPre" id="btnListActividadesPre" class="btn btn-default" type="button" onclick="ListActividadesPresupuesto('<?php echo $detallepresupuesto_id ?>')">Cancelar</button>
                            			</div>
                            		</nav>

                            		<legend class="titulo">Agregar Actividades</legend>

                            		<!--Modulo-->
                            		<div class="form-group">
                            			<label for="lb_modulo" class="col-sm-3 control-label">Módulo:</label>
                            			<div class="col-sm-8">
                            				<select autofocus="" id="slModulo" stylegit="display: block" name="slModulo" class="form-control data" required="true" onchange="AddModulo(this.value);">
                            				</select>
                            				<input type="text" style="display: none" class="form-control data" id="txt_modulo" name="txt_modulo" placeholder="Nombre del Modulo" onblur="aMayusculas(this.value, this.id);">
                            				<img src='img/atras.png' style="display: none" title='Atras' width='20' height='20' id='AtrasModulo' name='AtrasModulo' style='cursor:pointer' border='0' onclick='AddModulo("")'>
                            			</div>
                            		</div>

                            		<!--Tipo actividad-->
                            		<div class="form-group">
                            			<label for="lb_act" class="col-sm-3 control-label">Tipo Labor:</label>
                            			<div class="col-sm-8">
                            				<select id="slTipActividad" name="slTipActividad" class="form-control" required="true">
                            				</select>
                            			</div><img src='img/list.png' id='arbol' title='Listado de Baremos' width='30' height='30' style='cursor:pointer' border='0' onclick='DivInfoBaremos()'>
                            		</div>


                            		<!--ITEM-->
                            		<div class="form-group">
                            			<label for="lb_gom" class="col-sm-3 control-label">Numero Labor:</label>
                            			<div class="col-sm-8">
                            				<input type="text" class="form-control" id="search_item" name="search_item" placeholder="Numero Labor a buscar" onblur="aMayusculas(this.value, this.id);
                            				dataBaremoItemPresupuesto(this.value);">
                            			</div>
                            		</div>


                            		<!--DESCRIPCION DE LA LABOR-->
                            		<div class="form-group" id="contenido_labor" style="display: none">
                            			<label for="lb_gom" class="col-sm-3 control-label">Labor:</label>
                            			<div class="col-sm-8" id="desc_labor">
                            			</div>
                            		</div>

                            		<div class="form-group" id="contenido_labor_valor" style="display: none">
                            			<label for="lb_gom" class="col-sm-3 control-label">Valor:</label>
                            			<div class="col-sm-8" id="valor_labor">
                            			</div>
                            		</div>

                            		<!--OBSERVACIONES-->
                            		<div class="form-group">
                            			<label for="lb_objetivo" class="col-sm-3 control-label">Alcance técnico particular:</label>
                            			<div class="col-sm-8">
                            				<textarea class="form-control" id="txt_Obs" name="txt_Obs" rows="5" cols="40" placeholder="Directriz del cliente"></textarea>
                            			</div>
                            		</div>



                            		<!-- <div class="form-group">
                            			<div class="col-sm-offset-4 col-sm-4">
                            			</div>
                            		</div> -->


                            		<!--tabla de la busqueda-->
                            		<div class="row">
                            			<div class="col-xs-12 col-sm-12 col-md-12">
                            				<div id="ActividadesPresupuesto"></div>
                            			</div>
                            		</div>

                            	</div>
                            </div>


                            <!--actividades Agregadas-->
                            <div role="tabpanel" class="tab-pane" id="seccion2">                         
                            	<div class="row padding">
                            		<div class="col-xs-12 col-sm-12 col-md-12">
                            			<div id="ActividadesPresupuestoAsignadas"></div>
                            		</div>
                            	</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>

</form>
<div id="div_alc_ent"></div>
<div id="div_info"></div>

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