//variables globales
var u_btn_sel=1;
var productos;
var clientesproveedores;
var conceptos;
var tipodocto;
var tipodoctodet;
var respuestacatalogos;

function ContinuarCarga(idusuario, idempresa){
	LeerArchivo(idusuario, idempresa);
}

function LeerArchivo(idusuario, idempresa){

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
		        											elemento1 = "litros";
		        											elemento2 = "importe";
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
												         			<span class='pd-l-5'>"+movtos[x].concepto+"</span> \
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
													var n2 =  0;
													var coleccion2 = [];
													productos = 0;
													clientesproveedores = 0;
													conceptos = 0;
													sucursales = 0;
													for (j in respuestacatalogos[0]) {
														if(respuestacatalogos[0][j].prodreg == 1 && coleccion2.indexOf(respuestacatalogos[0][j].codigoproducto) == -1){																													
															coleccion2[n2] = respuestacatalogos[0][j].codigoproducto;
															productos = productos + 1;
															n2 = n2 + 1;
														}
														if(respuestacatalogos[0][j].clienprovreg == 1 && coleccion2.indexOf(respuestacatalogos[0][j].rfc) == -1){														
															coleccion2[n2] =respuestacatalogos[0][j].rfc;
															clientesproveedores = clientesproveedores + 1;
															n2 = n2 + 1;
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
														$("#fila4").removeClass('d-none');
														document.getElementById("elemento4").innerHTML = sucursales;
													}
													

												}
											});
										}
										
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

			   	if(doctos[0].fecha != "Vacio"){	
				
					var arraymovtos = movimientos;				
			        $.post(ws + "RegistrarLote",{idempresa: idempresa, idusuario: idusuario, tipodocto: doctos[0].idconce}, function(resp){
						var idlote = resp;				
						
						if(idlote[0].id > 0){
							 
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
						         	var arraymovtos2 = arraymovtos;						         	
									
									for(m=0; m < ArrayDimencional[0].length; m++){
										var Fec = ArrayDimencional[0][m]['fecha'];
										Fec = Fec.split("-");
										var fechag = Fec[0]+Fec[1]+Fec[2];

										if(doctos[0].idconce == 3){											
											var cod = fechag+doctos[0].idconce+ArrayDimencional[0][m]['folio'];
										}else if(doctos[0].idconce == 2){											
											var cod = fechag+doctos[0].idconce+ArrayDimencional[0][m]['litros']+ArrayDimencional[0][m]['unidad'];
										}else if(doctos[0].idconce == 4){
											var cod = fechag+doctos[0].idconce+ArrayDimencional[0][m]['cantidad']+ArrayDimencional[0][m]['unidad']+ArrayDimencional[0][m]['precio'];
										}else if(doctos[0].idconce == 5){
											var cod = fechag+doctos[0].idconce+ArrayDimencional[0][m]['cantidad']+ArrayDimencional[0][m]['unidad'];
										}

										if(cod == codigo && ArrayDimencional[0][m]['codigo'] == ""){
											ArrayDimencional[0][m]['codigo'] = codigo;
											ArrayDimencional[0][m]['span'] = idspan;											
											break;							
										}										
										
					        		}						        	
								}								
						     }
				
						     RegistrarDoctos(idempresa, idusuario, codigo, idlote[0].id, doctos[0].idconce, ArrayDimencional, idspan);

						     fileInput.value = "";

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
	    
    }	

}

function RegistrarDoctos(idempresa, idusuario, codigo, idlote, tipodocto, doctos, idspan){

 	$.post(ws + "RegistrarDoctos",{idempresa: idempresa, idusuario: idusuario, codigo: codigo, IDlotes: idlote, tipodocto: tipodocto, doctos: doctos, span: idspan}, function(data){
      
        var $bandera = 0;
        
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
	        		}else if(data[x].estatus == 3){
		        		document.getElementById(data[x].span).innerHTML = "Duplicado en plantilla.";
		        		document.getElementById(data[x].span).style.color = "red";	        			
	        		}
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

function Paginador(posicion){
	u_btn_sel = posicion; //asignamos valor a la variable global

	var lotes_x_pag = 5;
	
	var inicio = (posicion == 1 ? 0 : posicion - 1) * lotes_x_pag; 
	//var inicio = (posicion - 1) * lotes_x_pag; 
	$("#loading").removeClass("d-none");

	$.get(ws + "Paginador",{idempresa: idempresaglobal, iniciar: inicio, lotespag: lotes_x_pag}, function(Response){
		$("#t-Bitacora tbody").children().remove();
		var nLotes = Response;
		var tClass = "odd";
		var elemento;
		for (var j = 0; j < nLotes.length; j++) {

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
	         			<span class='pd-l-5'>Registros: "+nLotes[j].totalregistros+" Cargados: "+nLotes[j].totalcargados+" Error: "+nLotes[j].cError+"</span> \
	         		</td> \
	         		<td class='sorting_2'> \
	         			<span class='pd-l-5'>Procesados "+nLotes[j].procesados+" de "+nLotes[j].totalcargados+"</span> \
	         		</td> \
                    <td class='dropdown text-center'> \
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

		var element = document.getElementById("paginador");
		var hijos = $('#paginador').find('a');
 		var flag = 0;
 		hijos.removeClass('current');
		for(var j = 0; j < element.children.length; j++) {								
				
			if(j == (posicion-1)){					
				$("#btn_"+posicion).addClass('current');
				flag = 1;
			}
			
			if(flag == 1){
				break;
			}

		}		

		if(posicion == 1){									
			$("#datatable1_previous").addClass('disabled');
			$("#datatable1_next").removeClass('disabled');
			document.getElementById('datatable1_previous').onclick = null;
			document.getElementById('datatable1_next').onclick = SiguientePag;

		}else if(posicion > 1){
			$("#datatable1_previous").removeClass('disabled');
			document.getElementById('datatable1_previous').onclick = AnteriorPag;
			if((posicion-1) == j){
				$("#datatable1_next").addClass('disabled');
				document.getElementById('datatable1_next').onclick = null;
			}
		}		

		$("#loading").addClass("d-none");

	});
}

function AnteriorPag(){

	var element = document.getElementById("paginador");	
	var posicion;
	for(var j = 1; j <= element.children.length; j++) {								
	    if ($("#btn_"+j).hasClass('current')){

	        posicion = j - 1;
	        break;
        
	    }	
	}	

	Paginador(posicion)
}

function SiguientePag(){

	var element = document.getElementById("paginador");	
	var posicion;
	for(var j = 1; j <= element.children.length; j++) {								
	    if ($("#btn_"+j).hasClass('current')){

	        posicion = j + 1;
	        break;
        
	    }	
	}	

	Paginador(posicion)

}

function CargarLotes(){

	$("#t-Bitacora tbody").children().remove();
	
	$("#loading").removeClass("d-none");			
	
	var inicio = 1; 
	
	$.get(ws + "ConsultarLotes",{idempresa: idempresaglobal}, function(Response){
		var nLotes = Response;

		if(nLotes.length > 0){
			
			var total_lotes = nLotes.length;
			var lotes_x_pag = 5;		
			var paginas = Math.ceil(total_lotes / lotes_x_pag);
			var active = "current";
			
			//Elimina paginador
			var element = document.getElementById("paginador");
			while (element.firstChild) {
			  element.removeChild(element.firstChild);
			}

			//Agrega paginador
			for (var x = 1; x <= paginas; x++) {			

                var a = document.createElement('a');                
                a.setAttribute("class", "paginate_button "+(x == 1 ? active : "")+"");
                a.setAttribute("onclick", "Paginador("+x+")");
                a.setAttribute("href", "#");
				a.setAttribute("id", "btn_"+x);
				a.setAttribute("value", x);				             
                //a.innerHTML="<a href='#' class='paginate_button "+(x == 1 ? active : "")+"' onclick='Paginador("+x+")' aria-controls='datatable1'>"+x+"</a>";
                document.getElementById("paginador").appendChild(a);				
                a.innerHTML = x;
			}

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
		         			<span class='pd-l-5'>Registros: "+nLotes[j].totalregistros+" Cargados: "+nLotes[j].totalcargados+" Error: "+nLotes[j].cError+"</span> \
		         		</td> \
		         		<td class='sorting_2'> \
		         			<span class='pd-l-5'>Procesados "+nLotes[j].procesados+" de "+nLotes[j].totalcargados+"</span> \
		         		</td> \
                        <td class='dropdown text-center'> \
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
			for (var x = 0; x < doctos.length; x++) {

         		document.getElementById("t-Movtos").innerHTML +=
         		"<tr id='row"+x+"' role='row' class='"+tClass+"' > \
	         		<td class='sorting_2'> \
	         			<span class='pd-l-5'>"+doctos[x].fecha+"</span> \
	         		</td> \
	         		<td> \
	         			<span class='pd-l-5'>"+doctos[x].concepto+"</span> \
	         		</td> \
	         		<td class='sorting_2'> \
	         			<span class='pd-l-5'>"+(Tipo == 3 ? doctos[x].folio+"-"+doctos[x].serie : doctos[x][elemento])+"</span> \
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
	$.get(ws + "ConsultarMovtos",{idempresa: idempresaglobal, idlote: IDLote}, function(Response){
		var movtos = Response;
		var elemento;
		var elemento1;
		var elemento2;
		var elemento3;

		if(movtos.length > 0){
			//swal("Exito","Si hay registros","success");
			$("#bitacora").addClass("d-none");
     		$("#nivelmovtos").removeClass("d-none");
			$("#NivelMovtos tbody").children().remove();	

			if(Tipo == 3){
				document.getElementById("col_m4").innerHTML = "Subtotal";
				document.getElementById("col_m5").innerHTML = "Desc.";
				document.getElementById("col_m6").innerHTML = "Iva";				
				document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Remision";
				$("#col_m6").removeClass('d-none');
				$("#col_m7").removeClass('d-none');
				elemento = "subtotal";
				elemento1 = "descuento";
				elemento2 = "iva";
				elemento3 = "total";
				clase2 = "";
				clase3 = "";				
			}else if(Tipo == 2){
				document.getElementById("col_m4").innerHTML = "Kilometros";
				document.getElementById("col_m5").innerHTML = "Horometros";
				document.getElementById("col_m6").innerHTML = "Unidad";				
				document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Consumo Diesel";
				$("#col_m6").removeClass('d-none');
				$("#col_m7").removeClass('d-none');
				elemento = "kilometros";
				elemento1 = "horometro";
				elemento2 = "unidad";
				elemento3 = "total";
				clase2 = "";
				clase3 = "";
			}else if(Tipo == 4){
				document.getElementById("col_m4").innerHTML = "Almacen";
				document.getElementById("col_m5").innerHTML = "Unidad";
				document.getElementById("col_m6").innerHTML = "Precio";				
				document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Entradas de Materia Prima";
				$("#col_m6").removeClass('d-none');
				$("#col_m7").addClass('d-none');
				elemento = "almacen";
				elemento1 = "unidad";
				elemento2 = "total";
				clase2 = "";								
				clase3 = "d-none";
			}else if(Tipo == 5){
				document.getElementById("col_m4").innerHTML = "Almacen";
				document.getElementById("col_m5").innerHTML = "Unidad";
				document.getElementById("col_m6").innerHTML = "";				
				document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Salidas de Materia Prima";
				$("#col_m6").addClass('d-none');
				$("#col_m7").addClass('d-none');				
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

function EliminaFila(fila){
	$("#row"+fila).remove();
}

function EliminaRegistro(IDLote){

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
		  case "3":
		  	var link = document.getElementById("link_3").getAttribute("href");
		  	location.href = link;
		    break;
		  case "4":
		  	var link = document.getElementById("link_4").getAttribute("href");
		  	location.href = link;
		    break;		    		    
	    }
	}else{
		swal("Seleccione plantilla","Debe seleccionar una plantilla.","error");
	}
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
	//var cod = document.getElementById("combocatalogos").value;
	$("#t-Catalogos").removeClass('d-none');
	$("#t-Catalogos tbody").children().remove();


	//if(cod != ""){
		switch (cod) {
		  case "productos":
			document.getElementById("campo_r1").innerHTML = "Codigo del Producto";
			document.getElementById("campo_r2").innerHTML = "Nombre del Producto";
			//$("#campo_r3").addClass('d-none');
			CargaElementos(1);		  		
		    break;
		  case "clientesproveedores":
			document.getElementById("campo_r1").innerHTML = "RFC";
			document.getElementById("campo_r2").innerHTML = "Razon Social";
			//document.getElementById("campo_r3").innerHTML = "Cliente o Proovedor";
			//$("#campo_r3").removeClass('d-none');		  
		  	CargaElementos(2);
		    break;
		  case "conceptos":
			document.getElementById("campo_r1").innerHTML = "Codigo del Concepto";
			document.getElementById("campo_r2").innerHTML = "Nombre del Concepto";
			//document.getElementById("campo_r3").innerHTML = "Cliente o Proovedor";
			//$("#campo_r3").removeClass('d-none');		  
		  	CargaElementos(3);
		    break;		    
		  case "sucursales":
			document.getElementById("campo_r1").innerHTML = "Sucursal";
			//document.getElementById("campo_r2").innerHTML = "Nombre del Concepto";		  
		  	CargaElementos(4);
		    break;		    
	    }
	//}else{
		//swal("Seleccione plantilla","Debe seleccionar una plantilla.","error");
	//}	
}


function CargaElementos(tipoele){
	var num = 1;
	var tClass = "odd";
	var coleccion = [];
	var n = 0;
	var mostrar;

	switch(tipoele){
		case 1:
			mostrar = "prodreg";
			elemento = "codigoproducto";
			elemento2 = "producto"; 
			break;
		case 2:
			mostrar = "clienprovreg";
			elemento = "rfc";
			elemento2 = "razonsocial";
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
 		
// 		if((tipoele == 1 ? respuestacatalogos[0][x].prodreg : respuestacatalogos[0][x].clienprovreg) == 1){
 		
 		if(respuestacatalogos[0][x][mostrar] == 1){
 			
// 			if(coleccion.indexOf((tipoele == 1 ? respuestacatalogos[0][x].producto : respuestacatalogos[0][x].proveedor)) == -1){
			if(coleccion.indexOf(respuestacatalogos[0][x][elemento]) == -1){
	     		document.getElementById("t-Catalogos").innerHTML +=
	     		"<tr role='row' id='rowele_"+n+"' class='"+tClass+"' > \
	         		<td class='sorting_2'> \
	         			<span class='pd-l-5'>"+num+"</span> \
	         		</td> \
	         		<td> \
	         			<span class='pd-l-5'>"+(respuestacatalogos[0][x][elemento])+"</span> \
	         		</td> \
	         		<td class='wd-10 text-center sorting_2'> \
	         			<span class='pd-l-5'> \
	         				<a href='#' class='btn btn-outline-success btn-icon mg-r-5' id='btnreg_"+n+"' onclick='RegistrarElemento("+n+","+tipoele+")' title='Agregar'> \
								<div><i class='fa fa-plus'></i></div> \
							</a> \
						</span> \
					</td> \
					<td> \
						<input class='form-control wd-auto' id='txtcampo1_"+n+"' style='text-transform:uppercase;' type='text' value='"+(respuestacatalogos[0][x][elemento])+"'> \
					</td> \
					<td class='sorting_2' id='td_nombre'> \
						<input class='form-control wd-auto' id='txtcampo2_"+n+"' style='text-transform:uppercase;' type='text' value='"+(respuestacatalogos[0][x][elemento2])+"'></input> \
					</td> \
				</tr>";		
				num = num + 1;						         		
	     		if(tClass == "odd") { tClass = "even";	}else{ tClass = "odd"; }
	     		coleccion[n] = respuestacatalogos[0][x][elemento];
	     		n = n + 1;
	     	}
 		}
 	}

 	if(tipoele == 4){
		$("#campo_r2").addClass('d-none');
		$("#td_nombre").addClass('d-none'); 		
 	}else{
		$("#campo_r2").removeClass('d-none');
		$("#td_nombre").removeClass('d-none'); 		
 	}
}

function RegistrarElemento(posicion, tipo){
	
	var campo1 = document.getElementById("txtcampo1_"+posicion).id;
	var campo2 = document.getElementById("txtcampo2_"+posicion).id;
	//var campo3 = document.getElementById("txtcampo3_"+posicion).id;

	/*var filas = $("#t-Catalogos").find("tr"); //obtengo las filas
    var celda = $(filas[posicion+1]).find("td"); //especifico la fila
    var codigo = $(celda[1]); */

	var fila = $("#rowele_"+posicion).find("td")[1]; //obtengo las filas
    var elemento = $(fila).find("span")[0].innerText; //especifico la fila
    //console.log(celda[0].innerText);    
    //var elemento = codigo[0].innerText;

    /*console.log(posicion);
    console.log(tipo);
    console.log(elemento);*/

	
  	var len = {min:12,max:13};


  	switch(tipo){
  		case 1:
  			tipo = "productos";
  			/*$("#campo_r2").removeClass('d-none');
  			$("#td_nombre").removeClass('d-none');*/
  			break;
  		case 2:
  			tipo = "clientesproveedores";
  			/*$("#campo_r2").removeClass('d-none');
  			$("#td_nombre").removeClass('d-none');*/
  			break;
  		case 3:
  			tipo = "conceptos";
  			/*$("#campo_r2").removeClass('d-none');
  			$("#td_nombre").removeClass('d-none');*/
  			break;
  		case 4:
  			tipo = "sucursales";

  			
  			//document.getElementById(campo2).innerHTML = $("#"+campo1).val(); //solo para brinca la validacion
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




