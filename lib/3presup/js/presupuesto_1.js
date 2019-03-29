function guardarDocumentos() { //inicio

	// var detallepresupuesto_id = $('#detallepresupuesto_id').val();
	var url = "lib/3presup/controlador/CT_presup.php";

	//Declaramos las variables para el envió de archivos por ajax
	var archivos = document.getElementById("archivos");
	var file = archivos.files;
	var data = new FormData();

	//Se llena el objeto FormData()
	data.append('opcion','guardarDocumentos');
	data.append('id', detallepresupuesto_id);
	

	//Se recorren los archivos y se agregan a la variable data
	for (var i = 0; i < file.length; i++) {
		data.append('archivo'+i,file[i]);
	}
	
	//Envio por ajax
	$.ajax({
		url: url,
		type: 'post',
		data: data,
		contentType: false,
		processData: false,
		cache: false
	})
	//Respuesta de MD_presup.php por medio del controlador
	.done(function(retorno) {

		if (retorno==1) {
			alert("Documentos Guardados");
			$('#archivos').val("");
			mostrarDocumentos();
			console.log("El valor de return es " + retorno);
		}else{
			alert("El documento no se guardo, intente más tarde");
		};
		
	})
	.fail(function() {
		console.log("error");
	});
} //fin guardarDocumentos

/*****************************************************************************/
function mostrarDocumentos() {

	// se definen las variable
	var url = "lib/3presup/controlador/CT_presup.php";
	var parametros = {
		'opcion' : 'mostrarDocumentos',
		'detallepresupuesto_id': detallepresupuesto_id
	};

	// envio por ajax
	$.ajax({
		url: url,
		type: 'POST',
		data: parametros
	})
	.done(function(retorno) {
		$("#documentosAgregados").html(retorno);
	})
	.fail(function() {
		console.log("error");
	});
}//fin mostrarDocumentos

/*****************************************************************************/
function eliminarDocumento(soporte_id){

		// se realiza la confirmacion
		var confirmar = confirm("¿Esta seguro de eliminar el documento?");

		if (confirmar == true) {
		// se definen las variables
		var url = "lib/3presup/controlador/CT_presup.php";
		var parametros = {
			'soporte_id' : soporte_id,
			'id' : detallepresupuesto_id,
			'opcion' : 'eliminarDocumento'
		};
		// envio por ajax
		$.ajax({
			url: url,
			type: 'POST',
			data: parametros,
			async : false
		})
		.done(function(retorno) {
			console.log(retorno);
			mostrarDocumentos();
		})
		.fail(function() {
			console.log("error");
		});	

	}else{
		console.log("Fue cancelado")
	}

}//fin eliminarDocumento

/*****************************************************************************/
