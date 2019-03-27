/*function agregarInputDocumentos() { //inicio

	var inicial = parseInt($("#id_inicial_v").val());


	var input = '<input type="file" multiple class="archivo_doc_req" name="archivo' + inicial + '" id="archivo" >';
	var elimine = '<button type="button" name="btn_eliminar_doc" id="btn_eliminar_doc" class="btn btn-danger btn-xs" onclick="eliminardoc(' + inicial + ')"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Eliminar</button>';
	var content = "<tr id='tr_" + inicial + "'><td>" + input + "</td><td>" + elimine + "</td></tr>";


	$("#table-adj-docu").append(content);

	var total = inicial + 1;

	$("#id_inicial_v").val(total);

} //fin agregarInputDocumentos*/

function guardarDocumentos() { //inicio

	var detallepresupuesto_id = $('#detallepresupuesto_id').val();
	var inicial = $('#id_inicial_v').val();
	var archivos = document.getElementById("archivos");
	var file = archivos.files;
	var data = new FormData();
	data.append('opcion','guardarDocumentos');
	data.append('id', detallepresupuesto_id);
	data.append('inicial', inicial);

	

	for (var i = 0; i < file.length; i++) {
	data.append('archivo'+i,file[i]);
	}

	

	var url = "lib/3presup/controlador/CT_presup.php";
	
	$.ajax({
		url: url,
		type: 'post',
		data: data,
		contentType: false,
		processData: false,
		cache: false
	})
	.done(function(retorno) {

		if (retorno==1) {
			console.log("Documento Guardado");
			console.log("success");
		}else{
			console.log("El documento no se guardo, intente más tarde");
		};
		console.log(retorno);
		console.log("success");
	})
	.fail(function() {
		console.log("error");
	});

	
} //fin guardarDocumentos