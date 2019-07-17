//variables globales
var u_btn_sel=1;

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
									    	$("#bitacora").removeClass("d-none");
									    	//$("#t-lotes").removeClass("d-none");	         								         	
							         	}else{				

							         		$.post(ws + "VerificarLote",{idempresa: idempresa, idusuario: idusuario, tipodocto: tipodocto, movtos: movtos}, function(data){
        										var lote = data;
        										movimientos = lote;

        										if(tipodocto == 3){
        											document.getElementById("col3").innerHTML = "Folio-Serie";
        											document.getElementById("p_info").innerHTML = "Tipo de Documento: Remision";
        										}else if(tipodocto == 2){
        											document.getElementById("col3").innerHTML = "Litros";
        											document.getElementById("p_info").innerHTML = "Tipo de Documento: Consumo Diesel";
        										}

												$("#bitacora").addClass("d-none");
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

				//console.log(ArrayDimencional[0]);



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
											
										}else if(doctos[0].idconce == 2){
											var cod = fechag+doctos[0].idconce+ArrayDimencional[0][m]['litros']+ArrayDimencional[0][m]['unidad'];
										}
										
										if(cod == codigo){
											ArrayDimencional[0][m]['codigo'] = codigo;
											ArrayDimencional[0][m]['span'] = idspan;											
										}


					        			
					        		}
						        	
						        	
						        	
								}						
						     }

						     
						     //RegistrarDoctos(idempresa, idusuario, codigo, idlote[0].id, doctos[0].idconce, doctos, idspan, arraymovtos2);
						     RegistrarDoctos(idempresa, idusuario, codigo, idlote[0].id, doctos[0].idconce, ArrayDimencional, idspan);

						     fileInput.value = "";
				     
				    //  		 $('#col6').addClass('d-none');
						     
							 // fileInput.value = "";
							 // swal("Recepcion Lotes","Se han cargado correctamente los datos.","success");
							 // $('#loading').addClass('d-none');

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
	                
	    
	    //movimientos = "";
    }	

}

function RegistrarDoctos(idempresa, idusuario, codigo, idlote, tipodocto, doctos, idspan){

 	$.post(ws + "RegistrarDoctos",{idempresa: idempresa, idusuario: idusuario, codigo: codigo, IDlotes: idlote, tipodocto: tipodocto, doctos: doctos, span: idspan}, function(data){
      
        var $bandera = 0;
        
    	for (x in data) {

        	//if(data[0].id > 0){
					//$.post(ws + "RegistrarMovtos", {idempresa: idempresa, idusuario: idusuario, IDdocto: data[0].id, IDlote: idlote, tipodocto: tipodocto, codigo: data[0].codigo, movtos: arraymovtos2}, function(data2){
					//	do{
					//    	$bandera = data2[0].id;		    	    
				    //	}while($bandera	== 0)					    
				   	//	if(data2[0].id > 0){}
				   	//});
        	//}  
				 
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
	         			<span class='pd-l-5'>"+(nLotes[j].tipo == 3 ? "Remision" : "Consumo Diesel")+"</span> \
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
		         			<span class='pd-l-5'>"+(nLotes[j].tipo == 3 ? "Remision" : "Consumo Diesel")+"</span> \
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
		
		if(doctos.length > 0){
			//swal("Exito","Si hay registros","success");

			$("#DoctosDet tbody").children().remove();	
			$("#bitacora").addClass("d-none");
     		$("#carga-movtos").removeClass("d-none");
												
			if(Tipo == 3){
				document.getElementById("col3").innerHTML = "Folio-Serie";
				document.getElementById("p_info").innerHTML = "Tipo de Documento: Remision";
			}else if(Tipo == 2){
				document.getElementById("col3").innerHTML = "Litros";
				document.getElementById("p_info").innerHTML = "Tipo de Documento: Consumo Diesel";
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
	         			<span class='pd-l-5'>"+(Tipo == 3 ? doctos[x].folio+"-"+doctos[x].serie : doctos[x].campoextra1)+"</span> \
	         		</td> \
	         		<td class='text-right'> \
						<span class='pd-l-5'>$"+doctos[x].total+"</span> \
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
			}else{
				document.getElementById("col_m4").innerHTML = "Kilometros";
				document.getElementById("col_m5").innerHTML = "Horometros";
				document.getElementById("col_m6").innerHTML = "Unidad";
				
				document.getElementById("movto_p_info").innerHTML = "Tipo de Documento: Consumo Diesel";
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
		         			<span class='pd-l-5'>"+(Tipo == 3 ? movtos[j].subtotal : movtos[j].kilometros)+"</span> \
		         		</td> \
		         		<td class='sorting_2'> \
		         			<span class='pd-l-5'>"+(Tipo == 3 ? movtos[j].descuento : movtos[j].horometro)+"</span> \
		         		</td> \
		         		<td class=''> \
		         			<span class='pd-l-5'>"+(Tipo == 3 ? movtos[j].iva : movtos[j].unidad)+"</span> \
		         		</td> \
		         		<td class='sorting_2'> \
		         			<span class='pd-l-5'>"+movtos[j].total+"</span> \
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
	    }
	}else{
		swal("Seleccione plantilla","Debe seleccionar una plantilla.","error");
	}
}



/*function fileValidation(idusuario, idempresa){

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
} */



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






