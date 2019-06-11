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
	<div class="d-none" id="loading"></div>

	<div class="br-section-wrapper pd-b-0">

		<h4 class="tx-gray-800">Recepcion por Lotes</h4>    
    	<p class="mg-b-30"></p>	
		
		<!--<div class="row">					
			<div class="col-md-4">
				<select class="form-control select2" id="plantillas" data-placeholder="Seleccione una plantilla" tabindex="-1" aria-hidden="true">
		            <option label="Seleccione una plantilla"></option>
		            <option value="1">Remisiones</option>
		            <option value="2">Consumos Diesel</option>
		            
		        </select>		               			
		        <div class="d-none">
		        	<a href="../lotes/Remision.xlsx" id="link_1" download></a>	
		        	<a href="../lotes/Remision.xlsx" id="link_2" download></a>	
		        </div>		        
			</div>

		    <div class="col-md-8">					
		    	<div class="row">
			       	<div class="col-md-6 col-sm-6 col-6 mg-md-t-0 mg-sm-t-15 mg-t-10">	          
			            <button class="btn btn-outline-primary btn-block mg-b-10" onclick="DescargarPlantilla()">Descargar</button>
					</div>
		    		<div class="col-md-4 col-sm-4 col-4 mg-md-t-0 mg-sm-t-15 mg-t-10">	          
						<label class="custom-file">
				       	  <input type="file" id="files" name="archivo[]" class="custom-file-input" onchange="LeerArchivo('<?php echo $_SESSION['idusuario']; ?>','<?php echo $_SESSION['idempresalog']; ?>');">
						  <span class="custom-file-control">Seleccionar..</span>										  
						</label>				        
					</div>					
		    		<!--<div class="col-md-4 col-sm-4 col-4 mg-md-t-0 mg-sm-t-15 mg-t-10">	          
				        <button class="btn btn-outline-success btn-block mg-b-10" onclick="SubirArchivo('<?php echo $_SESSION['idusuario']; ?>','<?php echo $_SESSION['idempresalog']; ?>');">Subir</button>
					</div>	-->				
				<!--</div>
			</div>        									
		</div> -->

	    <div class="card bd-0 shadow-base">
		
	      <table class="table table-bordered mg-b-0" id="t-lotes">
	        <thead>
	          	<tr>                
	            	<th class="tx-10-force tx-mont tx-medium">Descargas</th>	            	            
	            	<th class="tx-10-force tx-mont tx-medium">Procesamiento</th>
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
						            <!--<option value="China">China</option>
						            <option value="Japan">Japan</option> -->
						        </select>		               			
						        <div class="d-none">
						        	<a href="../lotes/Remision.xlsx" id="link_1" download></a>	
						        	<a href="../lotes/ConsumoDiesel.xlsx" id="link_2" download></a>	
						        </div>		        
							</div>       				    
						    	
					       	<div class="col-md-5 col-sm-12 col-12 mg-md-t-0 mg-sm-t-15 mg-t-10">	          
					            <button class="btn btn-outline-primary btn-block mg-b-10" onclick="DescargarPlantilla()">Descargar</button>
							</div>
						    		<!--<div class="col-md-4 col-sm-4 col-4 mg-md-t-0 mg-sm-t-15 mg-t-10">	          
										<label class="custom-file">
								       	  <input type="file" id="files" name="archivo[]" class="custom-file-input" onchange="LeerArchivo('<?php echo $_SESSION['idusuario']; ?>','<?php echo $_SESSION['idempresalog']; ?>');">
										  <span class="custom-file-control">Seleccionar..</span>										  
										</label>				        
									</div>					
						    		<div class="col-md-4 col-sm-4 col-4 mg-md-t-0 mg-sm-t-15 mg-t-10">	          
								        <button class="btn btn-outline-success btn-block mg-b-10" onclick="SubirArchivo('<?php echo $_SESSION['idusuario']; ?>','<?php echo $_SESSION['idempresalog']; ?>');">Subir</button>
									</div>	-->				
								
							
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




	
		<!--<div class="row justify-content-around d-none"> 
	        <div class="col-sm-6 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" onclick="RecepcionLotes(ModBandejaEntrada, MenuRecepcionLotes, SubProcesoProduccion)" <?= ($perMod->SubMenu_Permiso(SubMen_Proce_Produc)==0) ? 'disabled' : ''; ?>>Descargar Plantillas</button>
			</div>
	        <div class="col-sm-6 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Proce_Compras)==0) ? 'disabled' : ''; ?>>Procesar Plantilla</button>
			</div>
			<div class="col-sm-4 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Proce_Ventas)==0) ? 'disabled' : ''; ?>>Proceso de Ventas</button>            
	        </div>
		</div> -->


	</div>

	<div class="br-section-wrapper" id="divdinamico">
		<div id="carga-movtos" class="d-none">



			<!--<div class="form-layout form-layout-1 mg-b-5 pd-y-5 pd-x-15">
				<div class="row no-gutters mg-t-10">
	              <div class="col-md-6 col-sm-6">
	                <div class="form-group">
	                  <label class="form-control-label">Documento:</label>
	                  <input class="form-control" type="text" id="tipodoc" disabled>
	                </div>
	              </div>
	              <div class="col-md-2 col-sm-2">
	                <div class="form-group">
	                  <label class="form-control-label">Fecha Docto:</label>
	                  <input class="form-control" type="text" id="fechadoc" disabled>
	                </div>
	              </div>
	              <div class="col-md-2 col-sm-2" >
	                <div class="form-group">
	                  <label class="form-control-label">Folio:</label>
	                  <input class="form-control" type="text" id="foliodoc" disabled>
	                </div>
	              </div>
	              <div class="col-md-2 col-sm-2">
	                <div class="form-group">
	                  <label class="form-control-label">Serie:</label>
	                  <input class="form-control" type="text" id="seriedoc" disabled>
	                </div>
	              </div>
	            </div>
			</div> -->


			<table class="table display responsive nowrap dataTable no-footer dtr-inline" id="t-Movtos">
			    <thead>
			      	<tr>
			        	<th class="tx-10-force tx-mont wd-10" id="col1">Fecha</th>
			        	<th class="tx-10-force tx-mont tx-medium" id="col2">Concepto</th>
			        	<!--<th class="tx-10-force tx-mont tx-medium d-md-none">RFC</th>-->
			        	<th class="tx-10-force tx-mont tx-medium" id="col3"></th>
			        	<th class="tx-10-force tx-mont tx-medium" id="col4">Total</th>
			        	<th class="tx-10-force tx-mont tx-medium" id="col5">Detalle</th>
			        	<th class="tx-10-force tx-mont tx-medium" id="col6">Acciones</th>
			        	<th class="d-none"></th> <!-- se asigna codigo para procesar -->
			     	</tr>
			    </thead>
			    <tbody>

			    </tbody>
			</table>

			<div class="row justify-content-end">
		    <!--   	<div class="col-sm-3 mg-t-20 mg-sm-t-0">	          
		            <button class="btn btn-outline-primary btn-block mg-b-10" onclick="SubirArchivo('<?php echo $_SESSION['idusuario']; ?>','<?php echo $_SESSION['idempresalog']; ?>');">Cargar</button>
				</div>	-->
	    		<div class="col-sm-3 mg-t-20 mg-sm-t-0">	          
			        <button class="btn btn-outline-danger btn-block mg-b-10" onclick="CancelaCarga()">Cancelar</button>
				</div>
			</div>			

			<!--<div class="row justify-content-end">
			    
			    <div class="col-sm-3 mg-b-5 mg-sm-t-0">	          
			        <button class="btn btn-outline-danger btn-block mg-t-10" onclick="CancelaCarga()">Cancelar</button>
				</div>		
			</div>-->

		</div>		
	</div>

</div>
										         				