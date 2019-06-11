function RecepcionLotes(idmodulo, idmenu, idsubmenu){

	//$('#divdinamico').load('../submenus/contenidoslotes.php');
	//$('#divdinamico').load('../submenus/contenidoslotes.php');



}

function ProcesarPlantilla(){
	var archivo = document.getElementById("file").files[0];
	//console.log(archivo);
	//console.log(archivo['name']);
	archivo = archivo['name'];
	if(archivo != ""){
	     $.ajax({
	     	async:false,
	        url: '../submenus/leer_plantilla.php',
	        type: 'POST',
	        data: {plantilla: archivo},
	        success: function (response) {
	         	
	          	//console.log(response);

	        }
	     });
	 }else{
	 	swal('Seleccionar Archivo',"Debe seleccionar un archivo para procesarlo.","error");
	 }

}



function LeerArchivo(idusuario, idempresa){

    $('#loading').removeClass('d-none');


	$("#t-Movtos tbody").children().remove();	
	$("#carga-movtos").addClass("d-none");

    var fileInput = document.getElementById('files');
    var archivo = document.getElementById("files").files[0];
    var filePath = fileInput.value;
	var allowedExtensions = /(.xlsx|.xls)$/i;
    if(!allowedExtensions.exec(filePath)){
    	if(filePath == ''){            
            $('#loading').addClass('d-none');    		
    		swal("Seleccione Archivo","Debe seleccionar un archivo.","warning");
    	}else{
            $('#loading').addClass('d-none');    		
    		swal("Documento no valido","El archivo debe ser el mismo que se descago previamente.","error");	
    	} 	
        
        fileInput.value = "";
    }else{    
    
	    var archivosList = new FormData();
	    jQuery.each(jQuery('#files')[0].files, function(i, file) {  
	       i++;      
	       archivosList.append('file-'+i, file);
	       archivosList.append('file-'+i, file);
	    });
	    

	    jQuery.ajax({
	        url: '../submenus/subir_archivo.php',
	        data: archivosList,        
	        contentType: false,
	        processData: false,
	        type: 'POST',
	        success: function (response) {
	        	var resp = JSON.parse(response);     
	        	//console.log(resp['Estatus']);   	
	        	if(resp['Estatus'] == "True"){

					var fechamov = "";
					var codprod = "";
					var cantidad = "";
					var neto = "";
					var descuento = "";
					var iva = "";
					var total = "";  	

					var plantilla = archivo["name"]; 	
				     $.ajax({
				     	async:false,
				        url: '../submenus/leer_plantilla.php',
				        type: 'POST',        
				        data: {plantilla: plantilla, validacion: 1},
				        success: function (response) {
				        	var respuesta1 = JSON.parse(response);
				        	
				        	var tipodocto = respuesta1[0].tipodocto;
				        	var tipodoctodet = respuesta1[0].tipodoctodet;


				        	if (tipodoctodet != "Error" && tipodocto != "Error") {	


							    $.ajax({
							     	async:false,
							        url: '../submenus/leer_plantilla.php',
							        type: 'POST',
							        data: {plantilla: plantilla, validacion: 2},
							        success: function (responseAJAX) {
							         	var movtos = JSON.parse(responseAJAX);
							         	
							         	var tClass = "odd";
							         	if(movtos[0].fecha == "Vacio"){					         	
							         		swal("Documento","El documento no tiene movimientos registrados.","error");
									    	$("#carga-movtos").addClass("d-none");
									    	//$("#t-lotes").removeClass("d-none");	         								         	
							         	}else{				

							         		$.post(ws + "VerificarLote",{idempresa: idempresa, idusuario: idusuario, tipodocto: tipodocto, movtos: movtos}, function(data){
        										var lote = data;
        										movimientos = lote;

        										if(tipodocto == 3){
        											document.getElementById("col3").innerHTML = "Folio-Serie";
        										}else if(tipodocto == 2){
        											document.getElementById("col3").innerHTML = "Litros";
        										}


								         		$("#carga-movtos").removeClass("d-none");
												$("#t-Movtos tbody").children().remove();			        

									         	for (x in movtos) {
									         		//for(y in movtos[x]){								         		
										         		document.getElementById("t-Movtos").innerHTML +=
										         		"<tr id='row"+x+"' role='row' class='"+tClass+"' > \
											         		<td class='sorting_2'> \
											         			<span class='pd-l-5'>"+movtos[x].fecha+"</span> \
											         		</td> \
											         		<td> \
											         			<span class='pd-l-5'>"+movtos[x].concepto+"</span> \
											         		</td> \
											         		<td class='sorting_2'> \
											         			<span class='pd-l-5'>"+(movtos[x].idconce == 3 ? movtos[x].folio+"-"+movtos[x].serie : movtos[x].litros)+"</span> \
											         		</td> \
											         		<td class='text-right'> \
																<span class='pd-l-5'>$"+(movtos[x].idconce == 3 ? movtos[x].total : movtos[x].importe)+"</span> \
											         		</td> \
											         		<td class='sorting_2'> \
																<span class='pd-l-5'>"+(lote[x].estatus == "True" ? "Registro duplicado" : "OK")+"</span> \
																<input type='hidden' id='estatus_"+x+"' value='"+lote[x].estatus+"'> \
											         		</td> \
											         		<td class='wd-10'> \
											         			<span class='pd-l-5'> \
											         				<a href='#' class='btn btn-outline-danger btn-icon mg-r-5' name='eliminaL' onclick='EliminaFila("+x+");' title='Eliminar de la lista'> \
																		<div><i class='fa fa-minus-circle'></i></div> \
																	</a> \
																	<a href='#' class='btn btn-danger btn-icon mg-r-5 mg-r-5' id='eliminaR"+x+"' onclick='EliminaRegistro("+idusuario+","+idempresa+");' title='Eliminar de la base de datos'> \
																		<div><i class='fa fa-trash'></i></div> \
																	</a> \
																</span> \
															</td> \
															<td class='d-none'> \
																<input type='hidden' id='movto"+x+"' value='"+lote[x].codigo+"'> \
															</td> \
														</tr>";
									         		//}								         		
									         		if(tClass == "odd") { tClass = "even";	}else{ tClass = "odd"; }						         		
									         	}
									        });

							         	}
						       			//fileInput.value = "";			
							        }
							    });



				        	}else{                
                				$('#loading').addClass('d-none');				        			
				        		if(tipodocto == "Error" || tipodoctodet == "Error"){			        
				        			swal("Archivo Incorrecto","Documento no valido, favor de subir el correcto.","error");
				        		//}else if(fecha == "Error"){
				        		//	swal("Fecha del Documento","Fecha del documento no puede estar vacio o es incorrecta.","error");
				        		//}else if(folio == "Error"){
				        		//	swal("Folio del Documento","Folio del documento no puede estar vacio.","error");
				        		}else{
				        			swal("Error Desconocido","Reportar a sistemas.","error");
				        		}			        		
				        	}
				        }
				    });  
					$('#loading').addClass('d-none');
	        	}else{
                    $('#loading').addClass('d-none');	        		
	        		swal("Documento","El Documento no pudo ser leido, refresque la pagina e intente de nuevo.","warning");
	        	}
	        	
	        }

	    });  
		
	}
    
}



function ObtenerMovimientos(plantilla){
		movimientos = "";
	$.ajax({
     	async:false,
        url: '../submenus/leer_plantilla.php',
        type: 'POST',
        data: {plantilla: plantilla, validacion: 3},
        success: function (responseAJAX) {
        	movimientos = JSON.parse(responseAJAX);
        	console.log(movimientos);
        }
    });
}


function SubirArchivo(idusuario, idempresa){

	$('#loading').removeClass('d-none');

	var fileInput = document.getElementById('files');                
    var filas = $("#t-Movtos").find("tr");
    var numero_filas = filas.length;
    var archivo = document.getElementById("files").files[0];
    
    var movimientos;    
    
    var filePath = fileInput.value;    
	var allowedExtensions = /(.xlsx|.xls)$/i;
    if(!allowedExtensions.exec(filePath)){
    	if(filePath == ''){            
            $('#loading').addClass('d-none');    		
    		swal("Seleccione Archivo","Debe seleccionar un archivo.","warning");
    	}else{
            $('#loading').addClass('d-none');    		
    		swal("Documento no valido","El archivo debe ser el mismo que se descago previamente.","error");	
    	}
    }else{

    	var plantilla = archivo["name"];  
    
		$.ajax({
	     	async:false,
	        url: '../submenus/leer_plantilla.php',
	        type: 'POST',
	        data: {plantilla: plantilla, validacion: 3},
	        success: function (responseMovtos) {
	        	var respuestamovtos  = JSON.parse(responseMovtos);
	        	movimientos = respuestamovtos;
	        	
	        }
	    });

		
	    $.ajax({
	     	async:false,
	        url: '../submenus/leer_plantilla.php',
	        type: 'POST',
	        data: {plantilla: plantilla, validacion: 2},
	        success: function (responseAJAX) {
	         	var doctos = JSON.parse(responseAJAX);
			 	
			   	if(doctos[0].fecha != "Vacio"){	
				
					var arraymovtos = movimientos;				
			        $.post(ws + "RegistrarLote",{idempresa: idempresa, idusuario: idusuario, tipodocto: doctos[0].idconce}, function(resp){
						var idlote = resp;				
						
						if(idlote[0].id > 0){

						     for(i=1; i<numero_filas; i++){
						        var celdas = $(filas[i]).find("td");
						        var codigo = $(celdas[6]).find("input")[0].value;
						        var tipodocto = codigo.substr(8,1);			        
						       	var idinput = $(celdas[4]).find("input")[0].id;
						      	//console.log(movimientos);
									
						         if($(celdas[4]).find("input")[0].value == "False"){
						         	document.getElementById(idinput).value = "True";
						         	var arraymovtos2 = arraymovtos;
								 	$.post(ws + "RegistrarDoctos",{idempresa: idempresa, idusuario: idusuario, codigo: codigo, IDlotes: idlote[0].id, tipodocto: doctos[0].idconce, doctos: doctos}, function(data){
								        var documento = data;							        
								        
								        if(documento[0].id > 0){
								        	
											$.post(ws + "RegistrarMovtos", {idempresa: idempresa, idusuario: idusuario, IDdocto: documento[0].id, IDlote: idlote[0].id, tipodocto: doctos[0].idconce, codigo: documento[0].codigo, movtos: arraymovtos2}, function(data){
										   		var movtos = data;

										   		if(movtos[0].id > 0){									   			
													//$(celdas[4]).find("span")[0].innerHTML = "Correcto";									   			
										   		}

										   		if(i == numero_filas){
										   			$('#loading').addClass('d-none');
										   			fileInput.value = "";
										   			console.log(i);
										   			swal("Recepcion Lotes","Se han cargado correctamente los datos.","success");
										   		}
										   	});
										   	
								        }

								     });						
				    
									
								 }						
						     }

						}else{                
	                		$('#loading').addClass('d-none');						
							swal("¡Error desconocido!","Recargue la pagina, si el problema continua, reportar a sistemas.","error");
						}

			    	}); 

				}else{                
	                $('#loading').addClass('d-none');					
					swal("Documento","Documento no tiene movimientos.","error")
				}

	        } //fin succsess

	    });	//fin ajax

	                
	    
	    movimientos = "";
    }	





}

function DescargarPlantilla(){
	var cod = document.getElementById("plantillas").value;
	if(cod > 0){
		switch (cod) {
		  case "1":
		  	var link = document.getElementById("link_1").getAttribute("href");		  	
		  	location.href = link;
		    break;
		  case "2":
		  	var link = document.getElementById("link_2").getAttribute("href");
		  	location.href = link;		  			   
		    break;	  		  	
	    } 
	}else{
		swal("Seleccione plantilla","Debe seleccionar una plantilla.","error");
	}
}


function EliminaFila(fila){
	$("#row"+fila).remove();
}

function EliminaRegistro(idusuario, idempresa){

}


function fileValidation(idusuario, idempresa){

	CancelaCarga();

    var fileInput = document.getElementById('files');
    var archivo = document.getElementById("files").files[0];
    var filePath = fileInput.value;
    var allowedExtensions = /(.xlsx|.xls)$/i;
    if(!allowedExtensions.exec(filePath)){
        swal("Documento no valido","El archivo debe ser el mismo que se descago previamente.","error");
        fileInput.value = "";
        return false;
    }
}



function CancelaCarga(){
	var fileInput = document.getElementById('files');
	fileInput.value = "";
	$("#t-Movtos tbody").children().remove();	
	$("#carga-movtos").addClass("d-none");

}

function temporal(){
	$.post(ws + "RegistrarLote",{idempresa: idempresa, idusuario: idusuario, fecha: fecha, folio: folio, serie: serie, tipodocto: tipodocto, tipodoctodet:tipodoctodet }, function(data){
        var lote = data;				        
        if(lote[0].iddocto > 0){

	        	$.post(ws + "RegistrarMovtos", {idempresa: idempresa, idusuario: idusuario, iddocto: lote[0].iddocto, datos: respuesta}, function(data){
				   	var movtos = data;
				   	//console.log(movtos);
		         	$("#carga-movtos").removeClass("d-none");
					$("#t-Movtos tbody").children().remove();
					$("#tipodoc").val(tipodoctodet);
					$("#fechadoc").val(fecha);
					$("#foliodoc").val(folio);
					$("#seriedoc").val(serie);
					
					
		         	for (x in movtos) {
		         		for(y in movtos[x]){								         		
			         		document.getElementById("t-Movtos").innerHTML +=
			         		"<tr role='row' class='"+tClass+"'> \
				         		<td> \
				         			<span class='pd-l-5'>"+movtos[x][y].fechamov+"</span> \
				         		</td> \
				         		<td> \
				         			<span class='pd-l-5'>"+movtos[x][y].codprod+"</span> \
				         		</td> \
				         		<td> \
									<span class='pd-l-5'>"+Intl.NumberFormat().format(movtos[x][y].total)+"</span> \
				         		</td> \
				         		<td> \
									<span class='pd-l-5'>"+(movtos[x][y].procesado == "3" ? "No Cargado" : "Cargado")+"</span> \
				         		</td> \
				         		<td> \
									<span class='pd-l-5'>"+(movtos[x][y].procesado == "3" ? "Registro duplicado" : "")+"</span> \
				         		</td> \
			         		</tr>";
		         		}								         		
		         		if(tClass == "odd") { tClass = "even";	}else{ tClass = "odd"; }						         		
		         	}
				});


        }				    
    });	
}





