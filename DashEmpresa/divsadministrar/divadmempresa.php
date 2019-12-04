<?php
	session_start(); 
?>
<!--
<div class="pd-sm-x-30 pd-t-30">
    <h4 class="tx-gray-800 mg-b-5">Editar Perfil</h4> 
    <p class="mg-b-0"></p>
</div>		-->	
<div class="br-pagebody pd-l-0 pd-r-0">
	<div id="loading"></div>
	<div class="br-section-wrapper" id="divdinamico">


		
		<div class="row">
			<!--<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 d-inline-flex align-items-end">
				<h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mb-md-4">Datos de la empresa</h6>		
			</div> -->
			
		
			<div class="col-12 d-inline-flex justify-content-end">
				<a onclick="DivFacturacion()" class="btn btn-outline-dark btn-oblong tx-11 tx-uppercase tx-mont tx-medium tx-spacing-1 pd-x-30 bd-2 mg-r-10">Datos Facturacion</a>							
				<a onclick="DivRenovacion()" class="btn btn-outline-warning btn-oblong tx-11 tx-uppercase tx-mont tx-medium tx-spacing-1 pd-x-30 bd-2">Renovar Certificado</a>					
			</div>
					
				
			
		</div>
		
		<!--<p class="mg-b-10"><span class="tx-danger" id="msg_verificacion"> </span><a href="#" id="link_verificacion" onclick="ValidarCelular()"> </a></p>-->
		
		
		<form id="FormEditaEmpresa" action="" method="post">
			<div class="form-layout form-layout-3">
				<h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-t-10 mg-b-10">Datos de la empresa.</h6>
	            <div class="row no-gutters">

	              <input type="hidden" name="idusuario" id="txtidempresa" value="<?php echo $_SESSION["idempresalog"]; ?>" />
				  <input type="hidden" name="identificador" id="txtidentificador">

	              <div class="col-md-6">
	                <div class="form-group">
	                	<label class="form-control-label">Nombre Empresa: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="nombre" id="txtnombre" placeholder="Nombre Empresa" disabled>
	                </div>
	              </div><!-- col-4 -->
	              <div class="col-md-6 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
											<label class="form-control-label">RFC: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="rfc" id="txtrfc" placeholder="RFC" disabled>
	                </div>
	              </div><!-- col-4 -->
	              <!--<div class="col-md-6 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
	                	<label class="form-control-label">Dirección: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="direcion" id="txtdireccion" placeholder="Dirección" disabled>
	                </div>
	              </div> col-4 -->
	              <div class="col-md-6">
	                <div class="form-group bd-t-0-force">
	                	<label class="form-control-label">Correo Electronico: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="correo" id="txtcorreo" placeholder="Correo Electronico" disabled>
	                </div>
	              </div><!-- col-8 -->
	             <!-- <div class="col-md-4 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
	                	<label class="form-control-label">Telefono: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="telefono" id="txttelefono" placeholder="telefono" disabled>
	                </div>
	              </div> col-4 -->	     
	              <!--<div class="col-md-4 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
	                	<label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="password" name="password" id="txtcontrasena" placeholder="Contraseña" disabled>
	                </div>
	              </div> col-4 -->
	              <div class="col-md-6 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
						<label class="form-control-label">Vigencia Certificado: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="vigencia" id="txtvigencia" disabled>						
	                </div>
	              </div><!-- col-4 -->
	            </div><!-- row -->
	           <!-- <div class="form-layout-footer bd pd-20 bd-t-0 d-flex justify-content-center">      		            			      
	              <button type="button" class="btn btn-info" onclick="">Guardar</button>
	              <button class="btn btn-secondary">Cancelar</button>				
	            </div>-->
	        </div>
		</form>

<!-- ///////////////////////////////////DATOS PARA LA FACTURACION/////////////////////////////////////////////// -->		
			<div class="form-layout form-layout-3 d-none" id="div_datosfacturacion">
				
					<h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-t-10 mg-b-10">Datos para facturacion.</h6>
		            <div class="row no-gutters">
	
					  

		              <div class="col-md-6">
		                <div class="form-group">
		                	<label class="form-control-label">Calle: <span class="tx-danger">*</span></label>
		                  	<input onkeyup="this.value=this.value.toUpperCase();" class="form-control" type="text" id="txtcalle">
		                </div>
		              </div>

		              <div class="col-md-6">
		                <div class="form-group">
		                	<label class="form-control-label">Colonia: <span class="tx-danger">*</span></label>
		                  	<input onkeyup="this.value=this.value.toUpperCase();" class="form-control" type="text" id="txtcolonia">
		                </div>
		              </div>


		              <div class="col-md-4">
		                <div class="form-group">
		                	<label class="form-control-label">Num. Ext. <span class="tx-danger">*</span></label>
		                  	<input onkeydown="SoloNumeros(this.id)"  class="form-control" type="text" id="txtnumext">
		                </div>
		              </div>

		              <div class="col-md-4">
		                <div class="form-group">
		                	<label class="form-control-label">Num. Int:</label>
		                  	<input onkeydown="SoloNumeros(this.id)"  class="form-control" type="text" id="txtnumint">
		                </div>
		              </div>

		              <div class="col-md-4">
		                <div class="form-group">
		                	<label class="form-control-label">Codigo Postal: <span class="tx-danger">*</span></label>
		                  	<input onkeydown="SoloNumeros(this.id)" class="form-control" type="text" id="txtcodigopostal">
		                </div>
		              </div>	              

		              <div class="col-md-6">
		                <div class="form-group">
		                	<label class="form-control-label">Municipio: <span class="tx-danger">*</span></label>
		                  	<input onkeyup="this.value=this.value.toUpperCase();" class="form-control" type="text" id="txtmunicipio">
		                </div>
		              </div>	              

		              <div class="col-md-6">
		                <div class="form-group">
		                	<label class="form-control-label">Ciudad: <span class="tx-danger">*</span></label>
		                  	<input onkeyup="this.value=this.value.toUpperCase();" class="form-control" type="text" id="txtciudad">
		                </div>
		              </div>	              

		              <div class="col-md-6">
		                <div class="form-group">
		                	<label class="form-control-label">Estado: <span class="tx-danger">*</span></label>
		                  	<input onkeyup="this.value=this.value.toUpperCase();" class="form-control" type="text" id="txtestado">
		                </div>
		              </div>	              

		              <div class="col-md-6">
		                <div class="form-group">
		                	<label class="form-control-label">Telefono: </label>
		                  	<input onkeydown="SoloNumeros(this.id)"  class="form-control" type="text" id="txttelefono">
		                </div>
		              </div>	              

		              	              	              
		            </div><!-- row -->
		            <div class="form-layout-footer bd pd-20 bd-t-0">	      
		              <button type="button" class="btn btn-info" onclick="GuardaDatosFacturacion()">Guardar</button>
		              <button class="btn btn-secondary" onclick="Cancelar()">Cancelar</button>			
		            </div>

	        	
	        </div>

<!-- ///////////////////////////////////RENOVACION DE CERTIFICADO/////////////////////////////////////////////// -->		
			<div class="form-layout form-layout-3 d-none" id="div_renovacion">
				<h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-t-10 mg-b-10">Renovacion de Certificados.</h6>
	            <div class="row no-gutters">

		            <div class="col-lg-4 col-md-6 col-sm-6">
		                <div class="form-group">
		                	<label class="form-control-label">Archivo .Cer: <span class="tx-danger">*</span></label>
							<label class="custom-file">
					       	  <!--<input type="file" id="file_certificado" class="custom-file-input">-->
					       	  <input type="file" class="custom-file-input" id="archivoCer" accept=".cer">
							  <span class="custom-file-control"></span>				  	
							</label>		                  		                
		              	</div>
		            </div>
	              	<div class="col-lg-4 col-md-6 col-sm-6">
	                	<div class="form-group">


		                	<label class="form-control-label">Archivo .Key: <span class="tx-danger">*</span></label>
							<label class="custom-file">
					       	  <!--<input type="file" id="file_key" class="custom-file-input">-->
					       	  <input type="file" class="custom-file-input" id="archivoKey" accept=".key">
							  <span class="custom-file-control"></span>				  	
							</label>		                  		                
		              	</div>
				    </div>
		            <div class="col-lg-4 col-md-12 col-sm-12">
		                <div class="form-group">
		                	<label class="form-control-label">Contraseña FIEL: <span class="tx-danger">*</span></label>
		                  	<input class="form-control" type="text" id="txtContrasena" placeholder="">
		                </div>
		            </div>
					
					<input type="hidden" id="txtrfc">
		            <input type="hidden" id="txtvigencianueva">
	              	              	              
	            </div><!-- row -->
	            <div class="form-layout-footer bd pd-20 bd-t-0">	      
	              <button type="button" class="btn btn-info" onclick="ValidaCertificado()">Renovar</button>
	              <button class="btn btn-secondary" onclick="Cancelar()">Cancelar</button>			
	            </div>
	        </div>
	        
	

        




	</div>
</div>




	<script>
		CargaDatosEmpresaAD($("#txtidempresa").val());			
	</script>