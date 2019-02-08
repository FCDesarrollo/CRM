<script src="../js/app.js"></script> 

<div id="RegistroModal" class="modal fade">
	<div class="modal-dialog modalSelect3">
		<div class="modal-content">
			<div class="modal-header">				
				<h4 class="modal-title">Registro</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form id="FormGuardarUsuario" name="FormGuardarUsuario" action="" method="post">
                    
                    <input type="hidden" name="idusuario" id="txtidusuario" />    

					<div class="form-group">
						<input type="text" class="form-control" name="nombre" id="txtnombre" placeholder="Nombre(s)" required="required">		
                        <div class="invalid-feedback">Ingresar Nombre</div>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="apellidop" id="txtapellidop" placeholder="Apellido Paterno" required="required">	
                        <div class="invalid-feedback">Ingresar Apellido Paterno</div>                        
                    </div>        
					<div class="form-group">
						<input type="text" class="form-control" name="apellidom" id="txtapellidom" placeholder="Apellido Materno" required="required">	
                        <div class="invalid-feedback">Ingresar Apellido Materno</div>                        
                    </div>
					<div class="form-group">
						<input type="text" class="form-control" onkeypress="return soloNumeros(event)"  name="cel" id="txtcelular" placeholder="Telefono" required="required">	
                        <div class="invalid-feedback">Ingresar un numero de telefono valido</div>                        
                    </div>                                                        
					<div class="form-group">                        
                        <input type="text" class="form-control" onkeyup="ValidaCorreo()" name="correo" id="txtcorreo" placeholder="Correo Electronico" required="required">	
                        <p><span id="demo2"></span></p>    
                    </div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" id="txtcontrasena" placeholder="Contraseña" required="required">	
                        <div class="invalid-feedback">Ingresar Contraseña</div>                        
                    </div>    

                    <input type="hidden" name="status" id="txtstatus" />  
                    <input type="hidden" name="identificador" id="identificador" />
                    <!--<div class="form-group">
                        <input type="hidden" name="tipou" id="txttipou"/>
                        <input class="form-check-input" type="checkbox" id="chAcceso">
                        <label class="form-check-label" for="chAcceso">Usuario De Prueba</label>
                    </div>-->
                    <div class="form-group">
                        <button type="button" name="registrar" onclick="GuardarUsuario()" class="btn btn-primary btn-lg btn-block">Registrar</button>
                    </div>
				</form>
            </div>
		</div>
	</div>
</div>  

