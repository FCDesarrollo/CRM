<?php
session_start();  
    if($_SESSION["usuario21"] == "")
    {
      session_destroy(); 
      echo "<script> swal('Hubo un problema', 'La session finalizado. Favor de introducir sus datos de acceso nuevamente..', 'error'); </script>";
      echo "<script> window.location='index.php/Login' </script>";
      exit(); 
	} 
	include("../empuser/permisosuser.php"); 
	$perMod = new PermisosUsuario($_SESSION["idempresalog"], $_SESSION["idusuario"]);
	$perMod->user_SubMenus();
?>		

<div class="br-pagebody pd-l-0 pd-r-0">

	<!-- ¡Efecto Loading! Quitar clase d-none para mostrar, y agregar para ocultar con javascript -->
	<div class="" id="loading"></div>

	<div class="br-section-wrapper pd-b-0">

		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-8">
				<h4 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Recepcion por Lotes</h4>    		
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 d-inline-flex justify-content-end">				
              	<button class="btn btn-outline-primary pd-x-15 pd-y-5 tx-uppercase tx-bold tx-spacing-6 tx-10 d-none">
              		Ir a Catalogos
              	</button>	            
			</div>			
		</div>
		
    	<p class="mg-b-30"></p>	

	    <div class="card bd-0 shadow-base">		
	      <table class="table table-bordered mg-b-0" id="t-lotes">
	        <thead>
	          	<tr>                
	            	<th class="tx-10-force tx-mont tx-medium">Plantillas Dispoibles.</th>	            	            
	            	<th class="tx-10-force tx-mont tx-medium">Recepcion para procesamiento.</th>
	         	</tr>
	        </thead>
	        <tbody>
				<tr class="odd">				
		            <td class="sorting_1">
		            	<div class="row">
							<div class="col-md-7 col-sm-12 col-12 mg-md-t-0 mg-sm-t-15 mg-t-10">
								<select class="form-control select2" id="plantillas" data-placeholder="Seleccione una plantilla" tabindex="-1" aria-hidden="true">
						            <option label="Seleccione una plantilla"></option>
						            <option value="1">Remisiones</option>
						            <option value="2">Consumos Diesel</option>
						            <option value="3">Entradas de Materia Prima</option>
						            <option value="4">Salidas de Materia Prima</option>
						            <!--<option value="China">China</option>
						            <option value="Japan">Japan</option> -->
						        </select>		               			
						        <div class="d-none">
						        	<a href="../lotes/Remision.xlsm" id="link_1" download></a>	
						        	<a href="../lotes/ConsumoDiesel.xlsm" id="link_2" download></a>	
						        	<a href="../lotes/EntradasMateriaPrima.xlsm" id="link_3" download></a>	
						        	<a href="../lotes/SalidaMateriaPrima.xlsm" id="link_4" download></a>	
						        </div>		        
							</div>       				    
						    	
					       	<div class="col-md-5 col-sm-12 col-12 mg-md-t-0 mg-sm-t-15 mg-t-10">	          
					            <button class="btn btn-outline-primary btn-block mg-b-10" onclick="DescargarPlantilla()">Descargar</button>
							</div>								
							
		            	</div>
		            </td>
		         	<td>
						<div class="row">
					        <div class="col-md-7 col-sm-12 col-12 mg-md-t-0 mg-sm-t-15 mg-t-10">
								<label class="custom-file">
						       	  <input type="file" id="files" name="archivo[]" class="custom-file-input" onchange="LeerArchivo('<?php echo $_SESSION['idusuario']; ?>','<?php echo $_SESSION['idempresalog']; ?>');">
								  <span class="custom-file-control">Seleccionar..</span>				  	
								</label>
							</div>					
					       	<div class="col-md-5 col-sm-12 col-12 mg-md-t-0 mg-sm-t-15 mg-t-10">	          
					            <button class="btn btn-outline-primary btn-block mg-b-10" onclick="SubirArchivo('<?php echo $_SESSION['idusuario']; ?>','<?php echo $_SESSION['idempresalog']; ?>');">Cargar</button>
							</div>	
				    		<!--<div class="col-md-6 col-sm-6 col-6 mg-md-t-0 mg-sm-t-15 mg-t-10">	          
						        <button class="btn btn-outline-danger btn-block mg-b-10" onclick="CancelaCarga()">Cancelar</button>
							</div>													-->
						</div>
		        	</td> 
		        </tr>
	        </tbody> 
	      </table>	      
	    </div>
	</div>
	

	<div class="br-section-wrapper" id="divdinamico">
		<div id="bitacora" class="">
			<div class="row justify-content-between">
				<div class="col-lg-10 mg-t-10 mg-b-10 align-self-center">
					<h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Listado de los ultimos lotes cargados.</h6>
				</div>	
				<div class="col-lg-2 mg-t-10 mg-b-10  d-none">
					
					<a href="#" style="width: inherit" class="btn btn-outline-dark">
						<div>Filtrar <i class="fa fa-filter"></i></div>
					</a>					
				</div>
			</div>
			
			<div id="datatable1_wrapper" class="dataTables_wrapper no-footer">
				<!--<div class="dataTables_length" id="datatable1_length">
					<label>
						<select name="datatable1_length" aria-controls="datatable1" class="select2-hidden-accessible" tabindex="-1" aria-hidden="true">
							<option value="10">10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select>
						Ultimos cargas:
						<span class="select2 select2-container select2-container--default" dir="ltr" style="width: 48px;">
							<span class="selection">
								<span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-datatable1_length-0a-container">
									<span class="select2-selection__rendered" id="select2-datatable1_length-0a-container" title="10">10</span>
									<span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
								</span>
							</span>
							<span class="dropdown-wrapper" aria-hidden="true"></span>
						</span> items/page
					</label>
				</div> -->

				<!--<div id="datatable1_filter" class="dataTables_filter">
					Buscar:
					<label>
						<input type="search" class="" aria-controls="datatable1">
					</label>
				</div>		-->		

				<table class="table display responsive nowrap dataTable no-footer dtr-inline" id="t-Bitacora">
				    <thead>
				      	<tr>
				        	<th class="tx-10-force tx-mont wd-10" id="">Fecha</th>
				        	<th class="tx-10-force tx-mont tx-medium" id="">Usuario</th>		        	
				        	<th class="tx-10-force tx-mont tx-medium" id="">Tipo de Documento</th>
				        	<th class="tx-10-force tx-mont tx-medium" id="">Sucursal</th>
				        	<th class="tx-10-force tx-mont tx-medium" id="">Detalles</th>
				        	<th class="tx-10-force tx-mont tx-medium" id="">Registros</th>
				        	<!--<th class="tx-10-force tx-mont tx-medium" id="col5">Estatus</th>-->
				        	<th class="wd-5p text-center"><em class="fa fa-cog"></em></th>
				     	</tr>
				    </thead>
				    <tbody></tbody>
				</table>

				<!--<div class="dataTables_info" id="datatable1_info" role="status" aria-live="polite">
					Showing 1 to 10 of 57 entries
				</div>-->
				 <div class="dataTables_paginate paging_simple_numbers" id="datatable1_paginate">
				 	<a class="paginate_button previous disabled" href="#" aria-controls="datatable1" data-dt-idx="0" tabindex="0"  id="datatable1_previous">Atras</a>
				 	<span id="paginador">
				 		<!--<a href="" class="paginate_button current" aria-controls="datatable1" data-dt-idx="1" tabindex="0">1</a>
				 		<a class="paginate_button " aria-controls="datatable1" data-dt-idx="2" tabindex="0">2</a>
				 		<a class="paginate_button " aria-controls="datatable1" data-dt-idx="3" tabindex="0">3</a>-->
				 	</span>
				 	<a class="paginate_button next" href="#" aria-controls="datatable1" data-dt-idx="7" tabindex="0" onclick="SiguientePag()" id="datatable1_next">Siguiente
				 	</a>
				 </div>

			</div>
		</div>


<!--//////////// PARA MOSTRAR LO CARGADO DESDE EL EXCEL Y PARA MOSTRAR A NIVEL DE DOCUMENTO/////////////////// -->

		<div id="carga-movtos" class="d-none">

			<div class="row pd-b-15">
				<div class="col-sm-1">
					<a href="#" onclick="CancelaCarga()" class="btn btn-outline-danger btn-icon rounded-circle mg-r-5">
						<div>
							<i class="fa fa-arrow-left"></i>
						</div>
					</a>
				</div>					
				<div class="col-sm-11 align-self-sm-center">
					<h6 id="p_info"></h6>
				</div>
			</div>	
			<table class="table display responsive nowrap dataTable no-footer dtr-inline" id="t-Movtos">
			    <thead>
			      	<tr>
			        	<th class="tx-10-force tx-mont wd-10" id="col1">Fecha</th>
			        	<th class="tx-10-force tx-mont tx-medium" id="col2">Concepto</th>
			        	<!--<th class="tx-10-force tx-mont tx-medium d-md-none">RFC</th>-->
			        	<th class="tx-10-force tx-mont tx-medium" id="col3"></th>
			        	<th class="tx-10-force tx-mont tx-medium" id="col4"></th>
			        	<!--<th class="tx-10-force tx-mont tx-medium" id="">Sucursal</th>-->
			        	<th class="tx-10-force tx-mont tx-medium" id="col5">Detalle</th>
			        	<th class="text-center" id="col6"><em class="fa fa-cog"></em></th>
			        	<th class="d-none"></th> <!-- se asigna codigo para procesar -->
			     	</tr>
			    </thead>
			    <tbody>

			    </tbody>
			</table>
			<div class="row justify-content-end">
	    		<!--<div class="col-sm-3 mg-t-20 mg-sm-t-0">	          
			        <button class="btn btn-outline-danger btn-block mg-b-10" onclick="CancelaCarga()">Cerrar</button>
				</div>-->
			</div>	
		</div>


<!--////////////PARA MOSTRAR A NIVEL DE MOVIMIENTOS/////////////////// -->
		<div id="nivelmovtos" class="d-none">
			<div class="row pd-b-15">
				<div class="col-sm-1">
					<a href="#" onclick="CancelaCarga()" class="btn btn-outline-danger btn-icon rounded-circle mg-r-5">
						<div>
							<i class="fa fa-arrow-left"></i>
						</div>
					</a>
				</div>					
				<div class="col-sm-11 align-self-sm-end">
					<h6 id="movto_p_info"></h6>
				</div>
			</div>			
			<table class="table display responsive nowrap dataTable no-footer dtr-inline" id="NivelMovtos">
			    <thead>
			      	<tr>
			        	<th class="tx-10-force tx-mont wd-10" id="">Fecha</th>
			        	<th class="tx-10-force tx-mont tx-medium" id="">Producto</th>
			        	<th class="tx-10-force tx-mont tx-medium" id="">Cantidad</th>
			        	<th class="tx-10-force tx-mont tx-medium" id="col_m4"></th>		        	
			        	<th class="tx-10-force tx-mont tx-medium" id="col_m5"></th>
			        	<th class="tx-10-force tx-mont tx-medium" id="col_m6"></th>
			        	<th class="tx-10-force tx-mont tx-medium" id="col_m7">Total</th>
			        	<th class="d-none"></th>
			     	</tr>
			    </thead>
			    <tbody>

			    </tbody>
			</table>
			<div class="row justify-content-end">
	    		<!--<div class="col-sm-3 mg-t-20 mg-sm-t-0">	          
			        <button class="btn btn-outline-danger btn-block mg-b-10" onclick="CancelaCarga()">Cerrar</button>
				</div>-->
			</div>	
		</div>	


<!--////////////MODAL PARA ENLISTAR LOS PRODUCTOS O CLIENTES/PROVEEDORES NO REGISTRADOS/////////////////// -->
		<!--MODAL DE VERIFICACION DE NUMERO TELEFONICO-->
		<div class="modal fade" id="CatalogosModal">
            <div class="modal-dialog modal-lg mw-100" role="dialog">
              <div class="modal-content wd-xs-400 wd-sm-600 wd-md-800 wd-900 bd-0">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Catalogos con elementos pendientes por registrar.</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>


                <div class="modal-body wd-auto pd-25">

	            	<div class="row">
						<div class="col-12 bd-gray-300 rounded table-responsive">
					        <table class="table display responsive dtr-inline" id="t-Pendientes">
					            <thead>
					                <tr>
					                	<th>Catalogos</th>					                    
					                    <th >Pendientes</th>
					                </tr>                
					            </thead>
					            <tbody>
									<tr role="row" id="fila1">
						         		<td><span class="pd-l-5"></span><a href="#" onclick="MostrarElementos('productos')">Productos</a></td>
						         		<td><span class="pd-l-5" id="elemento1"></span></td>
						         	</tr>
									<tr role="row" id="fila2">
						         		<td><span class="pd-l-5"></span><a href="#" id="" onclick="MostrarElementos('clientesproveedores')">Clientes/Proveedores</a></td>
						         		<td><span class="pd-l-5" id="elemento2"></span></td>
						         	</tr>					        
									<tr role="row" id="fila3">
						         		<td><span class="pd-l-5"></span><a href="#" onclick="MostrarElementos('conceptos')">Conceptos</a></td>
						         		<td><span class="pd-l-5" id="elemento3"></span></td>
						         	</tr>					         							         	 	
									<tr role="row" id="fila4">
						         		<td><span class="pd-l-5"></span><a href="#" onclick="MostrarElementos('sucursales')">Sucursales</a></td>
						         		<td><span class="pd-l-5" id="elemento4"></span></td>
						         	</tr>						         	
					            </tbody>				            

					        </table>
						</div>						

					</div>

                	<!--<div class="row">                		
                		<div class="col-lg-4 col-md-5 col-sm-6 mg-b-15 text-dark" id="elemento1"></div>
                		<div class="col-lg-4 col-md-5 col-sm-6 mg-b-15 text-dark" id="elemento2"></div>                		
                	</div>	-->				
	
					<div class="bd bd-gray-300 rounded table-responsive">
				        <table class="table table-bordered display responsive dtr-inline d-none" id="t-Catalogos">
				        	<!--<table class="table display responsive nowrap no-footer dtr-inline collapsed d-none" id="t-Catalogos">-->

				            <thead>
				                <tr>
				                	<!--<th>#</th>-->
				                    <th>Elemento</th>
				                    <th class="d-none" id="campo_codigorfc">Codigo</th>
				                    <th id="campo_r1"></th>				                    
				                    <th id="campo_r2"></th>
				                    <!--<th id="campo_r3"></th>-->
				                </tr>                
				            </thead>
				            <tbody>
				            	
				            </tbody>
				        </table>
					</div>
    
                </div>


                <div class="modal-footer">                  
					<!--<button type="button" data-dismiss="modal" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" onclick="LeerArchivo('<?php echo $_SESSION['idusuario']; ?>','<?php echo $_SESSION['idempresalog']; ?>')">Continuar</button>--> 
					<button type="button" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" onclick="MostrarElementos('registrarelementos')">Continuar</button>
                  <button type="button" data-dismiss="modal" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Cerrar</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
        </div>




	</div>
</div>
				         	