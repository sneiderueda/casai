<?php
$dato = $_POST['detallepresupuesto_id'];
?>

<!DOCTYPE html>
<html>
<body>
	<form id="frm_agregarDocumentos" name="frm_agregarDocumentos" class="form-horizontal" encrtype="multipart/form-data" method="POST">  

		<input type="hidden" name="detallepresupuesto_id" id="detallepresupuesto_id" value="<?php echo $dato ?>">

		<div id="sec_reg_tabla"  > 
			<table class="table table-bordered table-striped"  style="font-size:11.5px">
				<thead >
					<tr>
						<th class="col-sm-6">Agregar Documentos</th>
						<th class="col-sm-6">Accion</th>
					</tr>
					<tr>
						<th>
							<input type="file" multiple="multiple" id="archivos" accept=".jpg,.pdf,.png,.dwg,.xlsx,.docx,.jpeg">
						</th>
						<th>
							<button type="button" class="btn btn-primary" onclick="guardarDocumentos()">Guardar</button>
						</th>
					</tr>
					<tr>
						<th>Documentos Agregados</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody id="documentosAgregados">
					<!-- espacio donde se agregan los documentos subidos -->
				</tbody>
			</table>
		</div>
	</form>
</body>
</html>


