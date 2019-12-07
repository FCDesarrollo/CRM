function ContinuarCarga(idusuario, idempresa){
	LeerArchivo(idusuario, idempresa);
}

function LeerArchivo(idusuario, idempresa){
	//console.log(usuario.empresas());
    $('#loading').removeClass('d-none');

	$("#t-Movtos tbody").children().remove();	

	$("#bitacora").removeClass("d-none");

	$("#carga-movtos").addClass("d-none");


    var fileInput = document.getElementById('files');
    var archivo = document.getElementById("files").files[0];
    var filePath = fileInput.value;
	var allowedExtensions = /(.xlsm|.xlsm)$/i;

	

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
				        	tipodocto = respuesta1[0].tipodocto;
				        	tipodoctodet = respuesta1[0].tipodoctodet;

				        	if (tipodoctodet != "Error" && tipodocto != "Error") {

				        		$.post(ws + "VerificarClave",{clave: tipodocto, idempresa: idempresaglobal, idmenu: idmenuglobal, idsubmenu: idsubmenuglobal}, function(data){
				        			var clave = data;
//				        			console.log(clave);
//				        			console.log(clave.length);
				        			if(clave.length > 0){




								    $.ajax({
								     	async:false,
								        url: '../submenus/leer_plantilla.php',
								        type: 'POST',
								        data: {plantilla: plantilla, validacion: 2},
								        success: function (responseAJAX) {
								         	var movtos = JSON.parse(responseAJAX);
								         	
								         	if(movtos[0].fecha == "Vacio"){					         	
								         		swal("Documento","El documento no tiene movimientos registrados.","error");
										    	$("#carga-movtos").addClass("d-none");
										    	$("#bitacora").removeClass("d-none");	
								         	}else{							        		
								        		//Validacion Catalogos
												$.post(ws + "ChecarCatalogos",{array: movtos, idempresa: idempresa}, function(val){
													respuestacatalogos = val;
													movtos = respuestacatalogos[0];
													if(respuestacatalogos[1]['status'] == 0){

										         		var tClass = "odd";

										         		$.post(ws + "VerificarLote",{idempresa: idempresa, idusuario: idusuario, tipodocto: tipodocto, movtos: movtos}, function(data){
			        										var lote = data;
			        										var elemento;
			        										movimientos = lote;

			        										if(tipodocto == 3){
			        											document.getElementById("col3").innerHTML = "Folio-Serie";
			        											document.getElementById("col4").innerHTML = "Total";
			        											document.getElementById("p_info").innerHTML = "Tipo de Documento: Remision";
			        											elemento1 = "";
			        											elemento2 = "total";
			        										}else if(tipodocto == 2){
			        											document.getElementById("col3").innerHTML = "Litros";
			        											document.getElementById("col4").innerHTML = "Total";
			        											document.getElementById("p_info").innerHTML = "Tipo de Documento: Consumo Diesel";
			        											elemento1 = "cantidad";
			        											elemento2 = "total";
			        										}else if(tipodocto == 4){
			        											document.getElementById("col3").innerHTML = "Cantidad";
																document.getElementById("col4").innerHTML = "Unidad";
			        											document.getElementById("p_info").innerHTML = "Tipo de Documento: Entrada de Materia Prima";
			        											elemento1 = "cantidad";
			        											elemento2 = "unidad";
			        										}else if(tipodocto == 5){
			        											document.getElementById("col3").innerHTML = "Cantidad";
			        											document.getElementById("col4").innerHTML = "Unidad";
			        											document.getElementById("p_info").innerHTML = "Tipo de Documento: Salida de Materia Prima";
			        											elemento1 = "cantidad";
			        											elemento2 = "unidad";
			        										}

															$("#bitacora").addClass("d-none");
											         		$("#carga-movtos").removeClass("d-none");
															$("#t-Movtos tbody").children().remove();
															
															var folioserie;
												         	for (x in movtos) {						
												         		folioserie = movtos[x].folio+(movtos[x].serie == null ? "" : "-"+movtos[x].serie);
												         		document.getElementById("t-Movtos").innerHTML +=
												         		"<tr id='row"+x+"' role='row' class='"+tClass+"' > \
													         		<td class='sorting_2'> \
													         			<span class='pd-l-5'>"+movtos[x].fecha+"</span> \
													         		</td> \
													         		<td> \
													         			<span class='pd-l-5'>"+movtos[x].nombreconcepto+"</span> \
													         		</td> \
													         		<td class='sorting_2'> \
													         			<span class='pd-l-5'>"+(movtos[x].idconce == 3 ? folioserie : movtos[x][elemento1])+"</span> \
													         		</td> \
													         		<td class='text-right'> \
																		<span class='pd-l-5'>"+movtos[x][elemento2]+"</span> \
													         		</td> \
													         		<td class='sorting_2'> \
																		<span class='pd-l-5' id='error_"+x+"'>"+(lote[x].estatus == "True" ? (lote[x].procesado == 1 ? "Procesado." : "Registro Duplicado.") : "")+"</span> \
																		<input type='hidden' id='estatus_"+x+"' value='"+lote[x].estatus+"'> \
													         		</td> \
													         		<td class='wd-10 text-center'> \
													         			<span class='pd-l-5'> \
													         				<a href='#' class='btn btn-outline-danger btn-icon mg-r-5' id='eliminaL"+x+"' name='eliminaL"+x+"' onclick='EliminaFila("+x+");' title='Eliminar de la lista'> \
																				<div><i class='fa fa-minus-circle'></i></div> \
																			</a> \
																			<a href='#' class='btn btn-danger btn-icon mg-r-5 mg-r-5 "+(lote[x].estatus == "False" ? "d-none" : (lote[x].procesado == 1 ? "d-none" : ""))+"' id='eliminaR"+x+"' onclick='EliminaDocto("+lote[x].iddocto+","+idempresa+","+x+");' title='Eliminar de la base de datoss'> \
																				<div><i class='fa fa-trash'></i></div> \
																			</a> \
																		</span> \
																	</td> \
																	<td class='d-none'> \
																		<input type='hidden' id='movto"+x+"' value='"+lote[x].codigo+"'> \
																	</td> \
																</tr>";								         		
												         		if(tClass == "odd") { tClass = "even";	}else{ tClass = "odd"; }						         		
												         	}
												        });

										         	}else{						

														$("#CatalogosModal").modal();
														var n2 = 0;
														var n3 = 0;
														var coleccion2 = [];
														var coleccion3 = [];
														productos = 0;
														clientesproveedores = 0;
														conceptos = 0;
														sucursales = 0;
														for (j in respuestacatalogos[0]) {
															if(respuestacatalogos[0][j].productoreg == 1 && coleccion2.indexOf(respuestacatalogos[0][j].codigoproducto) == -1){
																coleccion2[n2] = respuestacatalogos[0][j].codigoproducto;
																productos = productos + 1;
																n2 = n2 + 1;
															}
															if(respuestacatalogos[0][j].clienprovreg == 1){														
																if(respuestacatalogos[0][j].rfc == "XAXX010101000" && coleccion3.indexOf(respuestacatalogos[0][j].codigocliprov) == -1){
																	coleccion3[n3] =respuestacatalogos[0][j].codigocliprov;
																	coleccion2[n2] =respuestacatalogos[0][j].rfc;
																	clientesproveedores = clientesproveedores + 1;
																	n3 = n3 + 1;
																	n2 = n2 + 1;
																}else if(coleccion2.indexOf(respuestacatalogos[0][j].rfc) == -1){
																	coleccion2[n2] =respuestacatalogos[0][j].rfc;
																	clientesproveedores = clientesproveedores + 1;
																	n2 = n2 + 1;
																}
															} 
															if(respuestacatalogos[0][j].conceptoreg == 1 && coleccion2.indexOf(respuestacatalogos[0][j].codigoconcepto) == -1){
																coleccion2[n2] =respuestacatalogos[0][j].codigoconcepto;
																conceptos = conceptos + 1;
																n2 = n2 + 1;										
															}
															if(respuestacatalogos[0][j].sucursalreg == 1 && coleccion2.indexOf(respuestacatalogos[0][j].sucursal) == -1){
																coleccion2[n2] =respuestacatalogos[0][j].sucursal;
																sucursales = sucursales + 1;
																n2 = n2 + 1;										
															}															
														}

														if(productos == 0){
															$("#fila1").addClass('d-none');	
														}else{
															$("#fila1").removeClass('d-none');	
															document.getElementById("elemento1").innerHTML = productos;
														}
														if(clientesproveedores == 0){
															$("#fila2").addClass('d-none');	
														}else{
															$("#fila2").removeClass('d-none');	
															document.getElementById("elemento2").innerHTML = clientesproveedores;
														}
														if(conceptos == 0){
															$("#fila3").addClass('d-none');	
														}else{
															$("#fila3").removeClass('d-none');	
															document.getElementById("elemento3").innerHTML = conceptos;
														}
														if(sucursales == 0){
															$("#fila4").addClass('d-none');	
														}else{
															//$("#fila4").removeClass('d-none');
															//document.getElementById("elemento4").innerHTML = sucursales;
															$("#CatalogosModal").modal("hide");
															swal("¡Sucursales!","Existen sucursales que no han sido dadas de alta.","warning");
														}
														

													}
												});
											}
											
								        }
								    });

				        			}else{
				        				fileInput.value = "";
				        				swal("¡Plantilla!","El archivo no es valido para este apartado.","warning");
				        				
				        			}
								});

				        	}else{                
                				$('#loading').addClass('d-none');				        			
				        		if(tipodocto == "Error" || tipodoctodet == "Error"){			        
				        			swal("Archivo Incorrecto","Documento no valido, favor de subir el correcto.","error");
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

		//fileInput.value = "";
	}
    
}

function SubirArchivo(idusuario, idempresa){

	$('#loading').removeClass('d-none');

	var fileInput = document.getElementById('files');                
    var filas = $("#t-Movtos").find("tr");
    var numero_filas = filas.length;
    var archivo = document.getElementById("files").files[0];
    
    var movimientos;    
    

    var filePath = fileInput.value;    
	var allowedExtensions = /(.xlsm|.xlsm)$/i;
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
			 	
				var ArrayDimencional = new Array (2) 
				ArrayDimencional[0] = doctos;
				ArrayDimencional[1] = movimientos;

				var arraydoctos = doctos;
				var arraymovtos = movimientos;

			   	if(doctos[0].fecha != "Vacio"){	
				
					//var arraymovtos = movimientos;				
			        //$.post(ws + "RegistrarLote",{idempresa: idempresa, idusuario: idusuario, tipodocto: doctos[0].idconce}, function(resp){
						//var idlote = resp;				
						
						//if(idlote[0].id > 0){
							 
						     for(i=1; i<numero_filas; i++){
						        var celdas = $(filas[i]).find("td");
						        var codigo = $(celdas[6]).find("input")[0].value;
						        //var tipodocto = codigo.substr(8,1);			        
						       	var idinput = $(celdas[4]).find("input")[0].id;
						       	var idspan = $(celdas[4]).find("span")[0].id;
						       	var btnEF = $(celdas[5]).find("a")[0].name;
						       	var btnER = $(celdas[5]).find("a")[1].id;

						       	$("#"+btnEF).css("display", "none");	
				       			$(celdas[5]).addClass('d-none');
				
						        if($(celdas[4]).find("input")[0].value == "False"){
						         	document.getElementById(idinput).value = "True";
						         	//var arraymovtos2 = arraymovtos;						         	
									
									for(m=0; m < arraydoctos.length; m++){
										var Fec = arraydoctos[m]['fecha'];
										Fec = Fec.split("-");
										var fechag = Fec[0]+Fec[1]+Fec[2];

										if(doctos[0].idconce == 3){											
											var cod = fechag+doctos[0].idconce+arraydoctos[m]['folio'];
										}else if(doctos[0].idconce == 2){											
											var cod = fechag+doctos[0].idconce+arraydoctos[m]['cantidad']+arraydoctos[m]['unidad'];
										}else if(doctos[0].idconce == 4){
											var cod = fechag+doctos[0].idconce+arraydoctos[m]['cantidad']+arraydoctos[m]['unidad']+arraydoctos[m]['total'];
										}else if(doctos[0].idconce == 5){
											var cod = fechag+doctos[0].idconce+arraydoctos[m]['cantidad']+arraydoctos[m]['unidad'];
										}

										if(cod == codigo && arraydoctos[m]['codigo'] == ""){
											arraydoctos[m]['codigo'] = codigo;
											arraydoctos[m]['span'] = idspan;											
											break;							
										}										
										
					        		}						        	
								}								
						     }
				
							
						     //RegistrarDoctos(idempresa, idusuario, codigo, idlote[0].id, doctos[0].idconce, ArrayDimencional, idspan);
						     RegistrarDoctos(idempresa, idusuario, codigo, doctos[0].idconce, arraydoctos, arraymovtos, idspan);

						     fileInput.value = "";

						//}else{                
	                	//	$('#loading').addClass('d-none');						
						//	swal("¡Error desconocido!","Recargue la pagina, si el problema continua, reportar a sistemas.","error");
						//}

			    	//}); 

				}else{                
	                $('#loading').addClass('d-none');					
					swal("Documento","Documento no tiene movimientos.","error")
				}

	        } //fin succsess

	    });	//fin ajax	                
	    
    }	

}

function RegistrarDoctos(idempresa, idusuario, codigo, tipodocto, doctos, movtos, idspan){

//	var rfc = "EmpresaNueva";
//	var usuario = "kiqearamburo@gmail.com";
//	var password = "";


 	$.post(ws + "LoteCargado",{idempresa: idempresa, idusuario: idusuario, tipodocto: tipodocto, documentos: doctos, movimientos: movtos, span: idspan, conexion: 1}, function(data){
//	$.post(ws + "LoteCargado",{rfcempresa: rfc, usuario: usuario, pwd: password, tipodocto: tipodocto, movimientos: movtos}, function(data){
      
        var bandera = 0;
        
    	for (x in data) {
				 
        	if(data[x].error > 0){
				document.getElementById(data[x].span).innerHTML = data[x].error_det;
				document.getElementById(data[x].span).style.color = "red";
        	}else{
        		if(data[x].estatus != 0){
	        		if(data[x].estatus == 1){
		        		document.getElementById(data[x].span).innerHTML = "Cargado.";
		        		document.getElementById(data[x].span).style.color = "green";
	        		}else if(data[x].estatus == 2){
		        		document.getElementById(data[x].span).innerHTML = "Actualizado.";
		        		document.getElementById(data[x].span).style.color = "dodgerblue";
	        		}/*else if(data[x].estatus == 3){
		        		document.getElementById(data[x].span).innerHTML = "Duplicado en plantilla.";
		        		document.getElementById(data[x].span).style.color = "red";	        			
	        		}*/
	        	}

        	}			
      	
        }   

 		 $('#col6').addClass('d-none');
		 swal("Recepcion Lotes","Se han cargado correctamente los datos.","success");
		 $('#loading').addClass('d-none');        
        
    });	    

}
function RegistrarMovtos(idempresa, idusuario, iddocto, idlote, tipodocto, codigo, arraymovtos2){
	$.post(ws + "RegistrarMovtos", {idempresa: idempresa, idusuario: idusuario, IDdocto: iddocto, IDlote: idlote, tipodocto: tipodocto, codigo: codigo, movtos: arraymovtos2}, function(data){
   		if(data[0].id > 0){
   			
   		}else{
			
   		}
   	});	
}
function numreg(idempresa, tipodocto, idlote, numero_doc){
 	$.post(ws + "UpdateLote",{idempresa: idempresa, idusuario: idusuario, idlote: idlote, tipodocto: tipodocto, numero_doc: numero_doc}, function(data){
             
    });		
}



function CargarLotes(idmodulo, idmenu, idsubmenu){

	$('#divdinamico').load('../submenus/form_recepcionlotes.php');

	$("#t-Bitacora tbody").children().remove();
	
	$("#loading").removeClass("d-none");	

	idmoduloglobal = idmodulo;
	idmenuglobal = idmenu;
	
	URL_Asigna_SubM(idsubmenu); //AGREGA EL ID DEL SUBMENU POSICIONADO A LA URL

	var inicio = 1; 
	
	$.get(ws + "ConsultarLotes",{idempresa: idempresaglobal}, function(Response){
		var nLotes = Response;

		if(nLotes.length > 0){

			LlenaPaginador(nLotes.length, nLotes, "t-Bitacora");

			var tClass = "odd";

			for (var j = 0; j < (nLotes.length > 5 ? lotes_x_pag : nLotes.length); j++) {

				document.getElementById("t-Bitacora").innerHTML +=
					"<tr id='rowb"+j+"' role='row' class='"+tClass+"' > \
		         		<td class='sorting_2'> \
		         			<span class='pd-l-5'>"+nLotes[j].fechadecarga+"</span> \
		         		</td> \
		         		<td class=''> \
		         			<span class='pd-l-5'>"+nLotes[j].usuario+"</span> \
		         		</td> \
		         		<td class='sorting_2'> \
		         			<span class='pd-l-5'>"+nLotes[j].tipodet+"</span> \
		         		</td> \
		         		<td class=''> \
		         			<span class='pd-l-5'>"+nLotes[j].sucursal+"</span> \
		         		</td> \
		         		<td class='sorting_2'> \
		         			<span class='pd-l-5'>Registros: "+nLotes[j].totalregistros+" Cargados: "+nLotes[j].totalcargados+" Error: "+nLotes[j].cError+"</span> \
		         		</td> \
		         		<td class=''> \
		         			<span class='pd-l-5'>Procesados "+nLotes[j].procesados+" de "+nLotes[j].totalcargados+"</span> \
		         		</td> \
                        <td class='dropdown text-center sorting_2'> \
                          <a href='#' data-toggle='dropdown' class='btn pd-y-3 tx-gray-500 hover-info'><i class='icon ion-more'></i></a> \
                          <div class='dropdown-menu dropdown-menu-right pd-10'> \
                            <nav class='nav nav-style-1 flex-column'> \
                              <a href='#' onclick='MostrarDoctos("+nLotes[j].id+","+nLotes[j].tipo+")' class='nav-link'>Nivel de Documentos</a> \
                              <a href='#' onclick='MostrarMovtos("+nLotes[j].id+","+nLotes[j].tipo+")' class='nav-link'>Nivel de Movimientos</a> \
                              <a href='#' onclick='EliminaRegistro("+nLotes[j].id+")' class='nav-link'>Eliminar Lote</a> \
                            </nav> \
                          </div> \
                        </td> \
					 </tr>"; 
					 
					 if(tClass == "odd") { tClass = "even";	}else{ tClass = "odd"; }

			}

			$("#loading").addClass("d-none");

		}else{
            document.getElementById("t-Bitacora").innerHTML +=
                  "<tr> \
                    <td> \
                      <i class='fa fa-exclamation tx-22 tx-danger lh-0 valign-middle'></i> \
                      <span class='pd-l-5'>No hay registros disponibles</span> \
                    </td> \
                    <td></td> \
                    <td></td> \
                    <td></td> \
                    <td></td> \
                    <td></td> \
                    <td></td> \
                  </tr>"; 
			$("#datatable1_paginate").addClass("d-none");
			$("#loading").addClass("d-none");
		}

				
		
	});    
}

//MUESTRA EL LOTE A NIVEL DE DOCUMENTO

function MostrarDoctos(IDLote, Tipo){
	$.get(ws + "ConsultarDoctos",{idempresa: idempresaglobal, idlote: IDLote}, function(Response){
		var doctos = Response;
		var elemento;
		var elemento1;
		
		if(doctos.length > 0){
			//swal("Exito","Si hay registros","success");

			$("#DoctosDet tbody").children().remove();	
			$("#bitacora").addClass("d-none");
     		$("#carga-movtos").removeClass("d-none");
												
			if(Tipo == 3){
				document.getElementById("col3").innerHTML = "Folio-Serie";
				document.getElementById("col4").innerHTML = "Total";
				document.getElementById("p_info").innerHTML = "Tipo de Documento: Remision";
				elemento1 = "total";
			}else if(Tipo == 2){
				document.getElementById("col3").innerHTML = "Litros";
				document.getElementById("col4").innerHTML = "Total";
				document.getElementById("p_info").innerHTML = "Tipo de Documento: Consumo Diesel";
				elemento = "campoextra1";
				elemento1 = "total";
			}else if(Tipo == 4){
				document.getElementById("col3").innerHTML = "Cantidad";
				document.getElementById("col4").innerHTML = "Precio";
				document.getElementById("p_info").innerHTML = "Tipo de Documento: Entradas de Materia Prima";
				elemento = "campoextra1";
				elemento1 = "total";
			}else if(Tipo == 5){
				document.getElementById("col3").innerHTML = "Cantidad";
				document.getElementById("col4").innerHTML = "Almacen";
				document.getElementById("p_info").innerHTML = "Tipo de Documento: Salidas de Materia Prima";
				elemento = "campoextra1";
				elemento1 = "campoextra2";
			}



			var tClass = "odd";
			var folioserie = "";
			for (var x = 0; x < doctos.length; x++) {
				folioserie = (Tipo == 3 ? doctos[x].folio+(doctos[x].serie == null ? "" : "-"+doctos[x].serie) : "");
         		document.getElementById("t-Movtos").innerHTML +=
         		"<tr id='row"+x+"' role='row' class='"+tClass+"' > \
	         		<td class='sorting_2'> \
	         			<span class='pd-l-5'>"+doctos[x].fecha+"</span> \
	         		</td> \
	         		<td> \
	         			<span class='pd-l-5'>"+doctos[x].concepto+"</span> \
	         		</td> \
	         		<td class='sorting_2'> \
	         			<span class='pd-l-5'>"+(Tipo == 3 ? folioserie : doctos[x][elemento])+"</span> \
	         		</td> \
	         		<td class='text-right'> \
						<span class='pd-l-5'>"+doctos[x][elemento1]+"</span> \
	         		</td> \
	         		<td class='sorting_2'> \
						<span class='pd-l-5'>"+(doctos[x].estatus == 0 ? (doctos[x].error == 0 ? "No Procesado" : doctos[x].detalle_error) : (doctos[x].estatus == 1 ? "Procesado." : (doctos[x].estatus == 2 ? "Eliminado por el Usuario." : "")))+"</span> \
						<input type='hidden' id='estatus_"+x+"' value='"+doctos[x].estatus+"'> \
	         		</td> \
	         		<td class='wd-10'> \
	         			<span class='pd-l-5'> \
							<a href='#' class='btn btn-outline-primary btn-icon mg-r-5 mg-r-5' onclick='VerMovtos("+doctos[x].id+","+Tipo+")' title='Ver movimientos'> \
								<div><i class='fa fa-caret-right'></i></div> \
							</a> \
						</span> \
	         			<span class='pd-l-5'> \
							<a href='#' class='btn btn-danger btn-icon mg-r-5 mg-r-5' id='eliminaF"+x+"' onclick='EliminaDocto("+doctos[x].id+","+Tipo+","+x+");' title='Eliminar de la base de datos'> \
								<div><i class='fa fa-trash'></i></div> \
							</a> \
						</span> \
					</td> \
					<td class='d-none'> \
						<input type='hidden' id='movto"+x+"' value='"+doctos[x].codigo+"'> \
					</td> \
				</tr>";

				if(tClass == "odd") { tClass = "even";	}else{ tClass = "odd"; }

			}

		}else{
			$("#bitacora").removeClass("d-none");
     		$("#carga-movtos").addClass("d-none");			
			swal("Listado de Documentos","Hubo un problema y no se pudo obtener los registros.","error");
		}

	}); 
}


//MUESTRA EL LOTE A NIVEL DE MOVIMIENTOS
function MostrarMovtos(IDLote, Tipo){
	$.get(ws + "ConsultarMovtosLote",{idempresa: idempresaglobal, id: IDLote}, function(Response){
		var movtos = Response;
		var elemento;
		var elemento1;
		var elemento2;
		var elemento3;

		if(movtos.length > 0){
			
			$("#bitacora").addClass("d-none");
     		$("#nivelmovtos").removeClass("d-none");
			$("#NivelMovtos tbody").children().remove();	


			CabezeraMovtos(Tipo);

			if(Tipo == 3){
				elemento = "subtotal";
				elemento1 = "descuento";
				elemento2 = "iva";
				elemento3 = "total";
				clase2 = "";
				clase3 = "";				
			}else if(Tipo == 2){
				elemento = "kilometros";
				elemento1 = "horometro";
				elemento2 = "unidad";
				elemento3 = "total";
				clase2 = "";
				clase3 = "";
			}else if(Tipo == 4){
				elemento = "almacen";
				elemento1 = "unidad";
				elemento2 = "total";
				clase2 = "";								
				clase3 = "d-none";
			}else if(Tipo == 5){
				elemento = "almacen";
				elemento1 = "unidad";
				clase2 = "d-none";
				clase3 = "d-none";
			}

			var tClass = "odd";
			for (var j = 0; j < movtos.length; j++) {
				document.getElementById("NivelMovtos").innerHTML +=
					"<tr id='rownm"+j+"' role='row' class='"+tClass+"' > \
		         		<td class='sorting_2'> \
		         			<span class='pd-l-5'>"+movtos[j].fechamov+"</span> \
		         		</td> \
		         		<td class=''> \
		         			<span class='pd-l-5'>"+movtos[j].producto+"</span> \
		         		</td> \
		         		<td class='sorting_2'> \
		         			<span class='pd-l-5'>"+movtos[j].cantidad+"</span> \
		         		</td> \
		         		<td class=''> \
		         			<span class='pd-l-5'>"+movtos[j][elemento]+"</span> \
		         		</td> \
		         		<td class='sorting_2'> \
		         			<span class='pd-l-5'>"+movtos[j][elemento1]+"</span> \
		         		</td> \
		         		<td class='"+clase2+"'> \
		         			<span class='pd-l-5'>"+movtos[j][elemento2]+"</span> \
		         		</td> \
		         		<td class='sorting_2 "+clase3+"'> \
		         			<span class='pd-l-5'>"+movtos[j][elemento3]+"</span> \
		         		</td> \
					 </tr>";

					 if(tClass == "odd") { tClass = "even";	}else{ tClass = "odd"; }
			}

		}else{
			swal("Sin Registros","No hay datos","error");
		}

	}); 
}

function CabezeraMovtos(Tipo){
	if(Tipo == 3){
		document.getElementById("col_m4").innerHTML = "Subtotal";
		document.getElementById("col_m5").innerHTML = "Desc.";
		document.getElementById("col_m6").innerHTML = "Iva";				
		document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Remision";
		$("#col_m6").removeClass('d-none');
		$("#col_m7").removeClass('d-none');
	}else if(Tipo == 2){
		document.getElementById("col_m4").innerHTML = "Kilometros";
		document.getElementById("col_m5").innerHTML = "Horometros";
		document.getElementById("col_m6").innerHTML = "Unidad";				
		document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Consumo Diesel";
		$("#col_m6").removeClass('d-none');
		$("#col_m7").removeClass('d-none');
	}else if(Tipo == 4){
		document.getElementById("col_m4").innerHTML = "Almacen";
		document.getElementById("col_m5").innerHTML = "Unidad";
		document.getElementById("col_m6").innerHTML = "Precio";				
		document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Entradas de Materia Prima";
		$("#col_m6").removeClass('d-none');
		$("#col_m7").addClass('d-none');
	}else if(Tipo == 5){
		document.getElementById("col_m4").innerHTML = "Almacen";
		document.getElementById("col_m5").innerHTML = "Unidad";
		document.getElementById("col_m6").innerHTML = "";				
		document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Salidas de Materia Prima";
		$("#col_m6").addClass('d-none');
		$("#col_m7").addClass('d-none');				
	}	
}

function VerMovtos(Iddocto, Tipo){
	$.get(ws + "ConsultarMovtosDocto",{idempresa: idempresaglobal, id: Iddocto}, function(Response){
		var movtos = Response;
		var elemento;
		var elemento1;
		var elemento2;
		var elemento3;


		if(movtos.length > 0){
			
			//$("#t-Movtos").addClass("d-none");
			$("#carga-movtos").addClass("d-none");			
     		$("#nivelmovtos").removeClass("d-none");
			$("#NivelMovtos tbody").children().remove();

			CabezeraMovtos(Tipo);

			if(Tipo == 3){
				elemento = "subtotal";
				elemento1 = "descuento";
				elemento2 = "iva";
				elemento3 = "total";
				clase2 = "";
				clase3 = "";				
				document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Remision con Folio-Serie: "+movtos[0].folio+(movtos[0].serie == null ? "" : "-"+movtos[0].serie);
			}else if(Tipo == 2){
				elemento = "kilometros";
				elemento1 = "horometro";
				elemento2 = "unidad";
				elemento3 = "total";
				clase2 = "";
				clase3 = "";
				document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Consumo Diesel";
			}else if(Tipo == 4){
				elemento = "almacen";
				elemento1 = "unidad";
				elemento2 = "total";
				clase2 = "";								
				clase3 = "d-none";
				document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Entradas de Materia Prima";
			}else if(Tipo == 5){
				elemento = "almacen";
				elemento1 = "unidad";
				clase2 = "d-none";
				clase3 = "d-none";
				document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Salidas de Materia Prima";
			}		
			
			var tClass = "odd";
			for (var j = 0; j < movtos.length; j++) {
				document.getElementById("NivelMovtos").innerHTML +=
					"<tr id='rownm"+j+"' role='row' class='"+tClass+"' > \
		         		<td class='sorting_2'> \
		         			<span class='pd-l-5'>"+movtos[j].fechamov+"</span> \
		         		</td> \
		         		<td class=''> \
		         			<span class='pd-l-5'>"+movtos[j].producto+"</span> \
		         		</td> \
		         		<td class='sorting_2'> \
		         			<span class='pd-l-5'>"+movtos[j].cantidad+"</span> \
		         		</td> \
		         		<td class=''> \
		         			<span class='pd-l-5'>"+movtos[j][elemento]+"</span> \
		         		</td> \
		         		<td class='sorting_2'> \
		         			<span class='pd-l-5'>"+movtos[j][elemento1]+"</span> \
		         		</td> \
		         		<td class='"+clase2+"'> \
		         			<span class='pd-l-5'>"+movtos[j][elemento2]+"</span> \
		         		</td> \
		         		<td class='sorting_2 "+clase3+"'> \
		         			<span class='pd-l-5'>"+movtos[j][elemento3]+"</span> \
		         		</td> \
					 </tr>";

					 if(tClass == "odd") { tClass = "even";	}else{ tClass = "odd"; }
			}
			btnregresar = 1;
		}else{
			swal("Hubo un error","No se encontraron los datos, reportar a sistemas.","error");
		}

	});
}

function EliminaFila(fila){
	$("#row"+fila).remove();
}

function EliminaRegistro(IDLote){

	var tipopermiso = VerificaPermisoSubMenu(idempresaglobal, idusuarioglobal, idsubmenuglobal);

	if(tipopermiso == 3){
			swal("¿Estas seguro de deseas eliminar el registro?", {
			  buttons: {
			    Continuar: "Continuar",
			    cancel: "Cancelar",    
			  },
			})
			.then((value) => {
			  switch (value) { 
			    case "Cancelar":
			      
			      break;
			    case "Continuar":
					$.post(ws + "EliminarLote",{idempresa: idempresaglobal, idlote: IDLote}, function(Response){
						var lote = Response;
						if(lote.length > 0){
							swal("Eliminar Lote","No se puede eliminar el lote por que ya existen documentos procesados.","error");
						}else{
							CargarLotes();		
						}
					}); 
			     	break;
			  }
			});
    }else{
    	swal("¡Denegado!","No cuentas con los permisos suficientes para realizar esta accion.","warning");
    }
}

function EliminaDocto(IDDocum, Tipo, Posicion){
	swal("¿Estas seguro de deseas eliminar el documento?", {
	  buttons: {
	    Continuar: "Continuar",
	    cancel: "Cancelar",    
	  },
	})
	.then((value) => {
	  switch (value) { 
	    case "Cancelar":
	      
	      break;
	    case "Continuar":
			$.post(ws + "EliminarDocto",{idempresa: idempresaglobal, iddocto: IDDocum}, function(Response){
				var docto = Response;
				
				if(docto.length > 0){
					if(docto[0].estatus == 2){
						swal("Elimina Documento","El Documento ya habia sido eliminado.","warning");
					}else{
						swal("Eliminar Documento","No se puede eliminar un documento ya procesado.","warning");	
					}
					
				}else{
					swal("Eliminado Correctamente", "El documento se elimino correctamente.", "success");
					//$("#row"+Posicion).remove();
					var filas = $("#t-Movtos").find("tr");
					var celdas = $(filas[Posicion + 1]).find("td");
					$(celdas[4]).find("span")[0].innerText = "Eliminado por el Usuario.";
					$(celdas[4]).find("input")[0].value = 2;

				}
			});
	     	break;
	  }
	});
}


function DescargarPlantilla(){
	var cod = document.getElementById("plantillas").value;
	
	
	if(cod != ""){
		var link = document.getElementById("link_"+cod).getAttribute("href");
		location.href = link;
		/*switch (cod) {
		  case "1":
		  	var link = document.getElementById("link_1").getAttribute("href");
		  	location.href = link;
		    break;
		  case "2":
		  	var link = document.getElementById("link_2").getAttribute("href");
		  	location.href = link;
		    break;
		  case "3":
		  	var link = document.getElementById("link_3").getAttribute("href");
		  	location.href = link;
		    break;
		  case "4":
		  	var link = document.getElementById("link_4").getAttribute("href");
		  	location.href = link;
		    break;		    		    
	    }*/
	}else{
		swal("Seleccionar Rubro","Debe seleccionar el rubro a descargar.","error");
	}
}

function LimpiarInput(){
	var fileInput = document.getElementById('files');
	fileInput.value = "";	
}


function CancelaCarga(){
	var fileInput = document.getElementById('files');
	fileInput.value = "";
	$("#t-Movtos tbody").children().remove();	
	$("#carga-movtos").addClass("d-none");
	$("#nivelmovtos").addClass("d-none");
	$("#bitacora").removeClass("d-none");	

	if(u_btn_sel != 1){
		Paginador(u_btn_sel);
	}else{
		CargarLotes();	
	}
}


function MostrarElementos(cod){
	switch (cod) {
		case "productos":
			document.getElementById("campo_r1").innerHTML = "Codigo del Producto";
			document.getElementById("campo_r2").innerHTML = "Nombre del Producto";
			$("#t-Catalogos").removeClass('d-none');
			$("#t-Catalogos tbody").children().remove();	
			$("#campo_codigorfc").addClass('d-none');			
			cat_actual = cod;
			CargaElementos(1);		  		
		    break;
		case "clientesproveedores":
			$("#campo_codigorfc").removeClass('d-none');
			document.getElementById("campo_r1").innerHTML = "RFC";
			document.getElementById("campo_r2").innerHTML = "Razon Social";				
			$("#t-Catalogos").removeClass('d-none');
			$("#t-Catalogos tbody").children().remove();	  
			cat_actual = cod;
		  	CargaElementos(2);
		    break;
		case "conceptos":
			document.getElementById("campo_r1").innerHTML = "Codigo del Concepto";
			document.getElementById("campo_r2").innerHTML = "Nombre del Concepto";
			$("#campo_codigorfc").addClass('d-none');
			$("#t-Catalogos").removeClass('d-none');
			$("#t-Catalogos tbody").children().remove();	  				
			cat_actual = cod;
		  	CargaElementos(3);
		    break;		    
		case "sucursales":
			document.getElementById("campo_r1").innerHTML = "Sucursal";
			$("#campo_codigorfc").addClass('d-none');
			$("#t-Catalogos").removeClass('d-none');
			$("#t-Catalogos tbody").children().remove();	  				
			cat_actual = cod;
		  	CargaElementos(4);
		    break;		
		case "registrarelementos":
			//cat_actual = "";
			RegistrarElementos();
		  	break;    
    }	
}

function RegistrarElementos(){
	var filas = $("#t-Catalogos").find("tr");
	var numero_filas = filas.length;
	var bandera = true;
	var array1 = [];
	
	var j = 0;

	var array = new Array (numero_filas-1);
	
	if(numero_filas > 1){
		
		for (var i = 1; i < numero_filas; i++) {
			if(cat_actual == "sucursales"){
				document.getElementById("txtcampo2_"+j).value = $("#txtcampo1_"+j).val();				
			}
			if($("#txtcampo1_"+j).val() == "" || $("#txtcampo2_"+j).val() == ""){
				bandera = false;
				if(cat_actual == "productos"){
					if($("#txtcampo1_"+j).val() == ""){
						swal("Campo Vacio","Favor de introducir el codigo del producto.","warning");	
					}else if($("#txtcampo2_"+j).val() == ""){
						swal("Campo Vacio","Favor de introducir el nombre del producto.","warning");	
					}			
				}else if(cat_actual == "clientesproveedores"){
					if($("#txtcampo1_"+j).val() == ""){
						swal("Campos Vacios", "Favor de introducir el RFC del cliente o proveedor.","warning");	
					}else if($("#txtcampo2_"+j).val() == ""){
						swal("Campos Vacios", "Favor de introducir la Razon Social del cliente o proveedor.","warning");						
					}
				}else if(cat_actual == "conceptos"){
					if($("#txtcampo1_"+j).val() == ""){
						swal("Campo Vacio","Favor de introducir el codigo del concepto.","warning");	
					}else if($("#txtcampo2_"+j).val() == ""){
						swal("Campo Vacio","Favor de introducir el nombre del concepto.","warning");	
					}			
				}else if(cat_actual == "sucursales"){
					if($("#txtcampo1_"+j).val() == ""){
						swal("Campo Vacio","Favor de introducir la sucursal.","warning");	
					}
				}
				break;		
			}else{
				if(cat_actual == "clientesproveedores"){
					if($("#txtcamporfc_"+j).val() == ""){					
						swal("Campos Vacios", "Favor de introducir el codigo del cliente o proveedor.","warning");					
						bandera = false;
						break;
					}else if($("#txtcamporfc_"+j).val() == "XAXX010101000"){
						swal("Campos Vacios", "El codigo no puede ser el mismo que el RFC Generico.","warning");					
						bandera = false;
						break;
					}
				}
			}

			var fila = $("#rowele_"+j).find("td")[0]; //obtengo las filas	
		    var elemento = $(fila).find("span")[0].innerText; //especifico la fila		    			
			var filarfc = $("#rowele_"+j).find("td")[1];
			var fila1 = $("#rowele_"+j).find("td")[2];
			var fila2 = $("#rowele_"+j).find("td")[3];
			var campo1 = $(fila1).find("input")[0].value;
			var campo2 = $(fila2).find("input")[0].value;
			var camporfc = $(filarfc).find("input")[0].value;

			array[j] = new Array(6);			
			
			array[j][0] = campo1;
			array[j][1] = campo2;
			array[j][2] = tipodocto;
			array[j][3] = tipodoctodet;
			array[j][4] = elemento;
			if(cat_actual == "clientesproveedores"){
				array[j][5] = camporfc;
			}
									
			j = j + 1;
		}


		if(bandera == true){			
					
			$.post(ws + "RegistrarElemento",{idempresa: idempresaglobal, tipo: cat_actual, datos: array}, function(Response){
			
				var respuesta = Response;
				
				for (var j = 0; j < respuesta.length; j++) {
					
					if(respuesta[j]["registrado"] == 1){
						if(cat_actual == "productos"){						
							productos = productos - 1;
							document.getElementById("elemento1").innerHTML = productos;						
						}else if(cat_actual == "clientesproveedores"){						
							clientesproveedores = clientesproveedores - 1;
							document.getElementById("elemento2").innerHTML = clientesproveedores;
						}else if(cat_actual == "conceptos"){
							conceptos = conceptos - 1;
							document.getElementById("elemento3").innerHTML = conceptos;						
						}else if(cat_actual == "sucursales"){
							sucursales = sucursales - 1;
							document.getElementById("elemento4").innerHTML = sucursales;						
						}
						$("#rowele_"+j).remove();
					}
					//swal("Elemento","Elemento registrado correctamente.","success");
				}

				if(productos > 0){
					MostrarElementos("productos");
				}else if(clientesproveedores > 0){
					MostrarElementos("clientesproveedores");
				}else if(conceptos > 0){
					MostrarElementos("conceptos");
				}else if(sucursales > 0){
					MostrarElementos("sucursales");
				}else{
					$("#CatalogosModal").modal("hide");
					LeerArchivo(idusuarioglobal, idempresaglobal); //se ejecuta cuando ya no haya productos pendientes por registrar
				}


			});	
			
		}

	}
}


function CargaElementos(tipoele){
	var num = 1;
	var tClass = "odd";
	var coleccion = [];
	var n = 0;
	var j = 0;
	var mostrar;

	switch(tipoele){
		case 1:
			mostrar = "productoreg";
			elemento = "codigoproducto";
			elemento2 = "producto"; 
			break;
		case 2:
			mostrar = "clienprovreg";
			elemento = "rfc";
			elemento2 = "razonsocial";
			elemento3 = "codigocliprov";
			break;
		case 3:
			mostrar = "conceptoreg";
			elemento = "codigoconcepto";			
			elemento2 = "concepto";
			break;	
		case 4:
			mostrar = "sucursalreg";
			elemento = "sucursal";
			break;					
	}

	

 	for (x in respuestacatalogos[0]) {

 		if(respuestacatalogos[0][x][mostrar] == 1){			

			if(coleccion.indexOf(respuestacatalogos[0][x][elemento]) == -1 && respuestacatalogos[0][x][elemento] != "XAXX010101000"){	
	     		document.getElementById("t-Catalogos").innerHTML +=
	     		"<tr role='row' id='rowele_"+j+"' class='"+tClass+"' > \
	         		<td class='sorting_2'> \
	         			<span class='pd-l-5'>"+(respuestacatalogos[0][x][elemento])+"</span> \
	         		</td> \
					<td class='"+(tipoele == 2 ? "" : "d-none")+"'> \
						<input class='form-control wd-auto' id='txtcamporfc_"+j+"' readonly='readonly' style='text-transform:uppercase;' type='text' value='"+(respuestacatalogos[0][x][elemento])+"'> \
					</td> \
					<td class='sorting_2'> \
						<input class='form-control wd-auto' id='txtcampo1_"+j+"' style='text-transform:uppercase;' type='text' value='"+(respuestacatalogos[0][x][elemento])+"'> \
					</td> \
					<td id='td_nombre' class='"+(tipoele != 4 ? "" : "d-none")+"'> \
						<input class='form-control wd-auto' id='txtcampo2_"+j+"' style='text-transform:uppercase;' type='text' value='"+(respuestacatalogos[0][x][elemento2] != null ? respuestacatalogos[0][x][elemento2] : "")+"'></input> \
					</td> \
				</tr>";		
				coleccion[n] = respuestacatalogos[0][x][elemento];
	     		n = n + 1;
	     		j = j + 1;
	     		if(tClass == "odd") { tClass = "even";	}else{ tClass = "odd"; }
	     	}else if(coleccion.indexOf(respuestacatalogos[0][x][elemento3]) == -1  && respuestacatalogos[0][x][elemento] == "XAXX010101000"){ //para cuando es RFC GENERICO
	     		document.getElementById("t-Catalogos").innerHTML +=
	     		"<tr role='row' id='rowele_"+j+"' class='"+tClass+"' > \
	         		<td class='sorting_2'> \
	         			<span class='pd-l-5'>"+(respuestacatalogos[0][x][elemento])+"</span> \
	         		</td> \
					<td class=''> \
						<input class='form-control wd-auto' id='txtcamporfc_"+j+"' readonly='readonly' style='text-transform:uppercase;' type='text' value='"+(respuestacatalogos[0][x][elemento3])+"'> \
					</td> \
					<td class='sorting_2'> \
						<input class='form-control wd-auto' id='txtcampo1_"+j+"' style='text-transform:uppercase;' type='text' value='"+(respuestacatalogos[0][x][elemento])+"'> \
					</td> \
					<td id='td_nombre' class='"+(tipoele != 4 ? "" : "d-none")+"'> \
						<input class='form-control wd-auto' id='txtcampo2_"+j+"' style='text-transform:uppercase;' type='text' value='"+(respuestacatalogos[0][x][elemento2] != null ? respuestacatalogos[0][x][elemento2] : "")+"'></input> \
					</td> \
				</tr>";	
				coleccion[n] = respuestacatalogos[0][x][elemento3];
				n = n + 1;
				coleccion[n] = respuestacatalogos[0][x][elemento];
	     		n = n + 1;
	     		j = j + 1;
	     		if(tClass == "odd") { tClass = "even";	}else{ tClass = "odd"; }
	     	}
	     	
     		
     		

 		}
 	}

 	if(tipoele == 4){
		$("#campo_r2").addClass('d-none');
		//$("#td_nombre").addClass('d-none'); 		
		$("#campo_codigorfc").addClass('d-none');
 	}else if(tipoele == 2){
		$("#campo_r2").removeClass('d-none');
		//$("#td_nombre").removeClass('d-none');
 		$("#campo_codigorfc").removeClass('d-none');
 		
 	}else{
		$("#campo_r2").removeClass('d-none');
		//$("#td_nombre").removeClass('d-none'); 		
		$("#campo_codigorfc").addClass('d-none');
		
 	}
}

var cat_actual;

function RegistrarElemento(posicion, tipo){
	
	var campo1 = document.getElementById("txtcampo1_"+posicion).id;
	var campo2 = document.getElementById("txtcampo2_"+posicion).id;
	var fila = $("#rowele_"+posicion).find("td")[1]; //obtengo las filas
    var elemento = $(fila).find("span")[0].innerText; //especifico la fila
  	var len = {min:12,max:13};


  	switch(tipo){
  		case 1:
  			tipo = "productos";
  			break;
  		case 2:
  			tipo = "clientesproveedores";
  			break;
  		case 3:
  			tipo = "conceptos";
  			break;
  		case 4:
  			tipo = "sucursales";
  			break;  	
  	}

  	
	
	if($("#"+campo1).val() == "" || ($("#"+campo2).val() == "" && tipo != "sucursales")/*|| (tipo == "productos" ? "" : $("#"+campo3).val() == "")*/){
	
		if(tipo == "productos"){
			if($("#"+campo1).val() == ""){
				swal("Campo Vacio","Favor de introducir el codigo del producto.","warning");	
			}else if($("#"+campo2).val() == ""){
				swal("Campo Vacio","Favor de introducir el nombre del producto.","warning");	
			}			
		}else if(tipo == "clientesproveedores"){
			if($("#"+campo1).val() == ""){
				swal("Campos Vacios", "Favor de introducir el RFC del cliente o proveedor.","warning");		
			}else if($("#"+campo2).val() == ""){
				swal("Campos Vacios", "Favor de introducir la Razon Social del cliente o proveedor.","warning");	
			}
		}else if(tipo == "conceptos"){
			if($("#"+campo1).val() == ""){
				swal("Campo Vacio","Favor de introducir el codigo del concepto.","warning");	
			}else if($("#"+campo2).val() == ""){
				swal("Campo Vacio","Favor de introducir el nombre del concepto.","warning");	
			}			
		}else if(tipo == "sucursales"){
			if($("#"+campo1).val() == ""){
				swal("Campo Vacio","Favor de introducir la sucursal.","warning");	
			}		
		}		
	}else{		
		if(($("#"+campo1).val().length < len.min || $("#"+campo1).val().length > len.max) && tipo == "clientesproveedores"){
			swal("RFC no valido.", "La estructura de la clave de RFC es incorrecta.","warning");
		}else{
			
			var array = [];
			array[0] = $("#"+campo1).val();
			array[1] = $("#"+campo2).val();
			array[2] = tipodocto;	
			array[3] = tipodoctodet;
			array[4] = elemento;		
				
			$.post(ws + "RegistrarElemento",{idempresa: idempresaglobal, tipo: tipo, datos: array}, function(Response){
				if(Response > 0){					
					
					$("#rowele_"+posicion).remove();
					//document.getElementById("btnreg_"+posicion).disabled = true;

					 //$("#btnreg_"+posicion).attr("disabled", "disabled");
					
					if(tipo == "productos"){						
						productos = productos - 1;
						document.getElementById("elemento1").innerHTML = productos;						
					}else if(tipo == "clientesproveedores"){						
						clientesproveedores = clientesproveedores - 1;
						document.getElementById("elemento2").innerHTML = clientesproveedores;
					}else if(tipo == "conceptos"){
						conceptos = conceptos - 1;
						document.getElementById("elemento3").innerHTML = conceptos;						
					}else if(tipo == "sucursales"){
						sucursales = sucursales - 1;
						document.getElementById("elemento4").innerHTML = sucursales;						
					}
					swal("Elemento","Elemento registrado correctamente.","success");
				}else{
					swal("Elemento","Ya existe un elemento registrado.","warning");
				}
			});
		}				
	}
}




