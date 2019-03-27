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
			console.log("El valor de return es " + retorno);
		}else{
			alert("El documento no se guardo, intente más tarde");
		};
		
	})
	.fail(function() {
		console.log("error");
	});

	
} //fin guardarDocumentos