<?php
	session_start(); 
?>
		<h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mb-md-4">Verificacion de telefono movil</h6>
		<p class="mg-b-10" id="msg_valida"></p>
		
		<form id="FormValidacionSMS" action="" method="post">
			<div class="form-layout form-layout-3">
	            <div class="row no-gutters">

	              	<input type="hidden" name="idusuario" id="txtidusuario" value="<?php echo $_SESSION["idusuario"]; ?>" />
	              	<input type="hidden" name="idempresa" id="txtidempresa" value="<?php echo $_SESSION["idempresa"]; ?>" />

  	                <div class="col-md-9">
	                	<div class="form-group">
	                		<label class="form-control-label">Telefono Celular: <span class="tx-danger">*</span></label>
	                  		<input class="form-control" type="text" name="cel" id="txtcelular">
	                	</div>
	              	</div><!-- col-4 -->
		            <div class="col-md-3 mg-t--1 mg-md-t-0">
		            	<div class="form-group d-flex justify-content-center">
			            	<button type="button" class="btn btn-primary" id="btncodigo" onclick="EnviaCodigo()">Enviar Codigo</button>
			          	</div>			            
		            </div><!-- form-group -->	              	
		            <div class="col-md-9 mg-t--1 mg-md-t-0">
		                <div class="form-group mg-md-l--1">
							<label class="form-control-label">Codigo de Verificacion: <span class="tx-danger">*</span></label>
		                  	<input class="form-control" type="text" name="identificador" id="txtidentificador" disabled>
		                </div>
	              	</div><!-- col-4 -->  
		            <div class="col-md-3 mg-t--1 mg-md-t-0">
		            	<div class="form-group d-flex justify-content-center">
	                		<button type="button" class="btn btn-success" id="btnidentificador" onclick="VerificaCodigo()" disabled>Verifica Codigo</button>
			          	</div>		<!-- form-group -->	        
		            </div>
            	
            	</div><!-- row -->
	            
	        </div>
		</form>