<?php
$dato = $_POST['detallepresupuesto_id'];
?>

<!DOCTYPE html>
<html>
<body>
<form id="frm_agregarDocumentos" name="frm_agregarDocumentos" class="form-horizontal" encrtype="multipart/form-data" method="POST">  

	<input type="text" name="detallepresupuesto_id" id="detallepresupuesto_id" value="<?php echo $dato ?>">
	<input type="text" name="id_inicial_v" id="id_inicial_v" value="1">
	

	<div id="sec_reg_tabla"  > 

		<table class="table table-bordered table-striped"  style="font-size:11.5px">

			<thead>
				<tr>
					<th class="col-sm-6">Documento</th>
					<!--<th>Nombre Documento</th>-->
				</tr>
				<tr>
					<th>
						<input type="file" multiple="multiple" id="archivos" accept=".jpg,.pdf,.png,.dwg,.xlsx,.docx,.jpeg">
					</th>
				</tr>
			</thead>

			<tbody id="table-adj-docu">
			</tbody>

		</table>
	</div>
</form>
</body>
</html>


