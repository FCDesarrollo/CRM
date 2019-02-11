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
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="apellidop" id="txtapellidop" placeholder="Apellido Paterno" required="required">	
                    </div>        
					<div class="form-group">
						<input type="text" class="form-control" name="apellidom" id="txtapellidom" placeholder="Apellido Materno" required="required">
                    </div>
					<div class="form-group">
						<input type="text" class="form-control" onkeypress="return soloNumeros(event)"  name="cel" id="txtcelular" placeholder="Telefono" required="required">	                        
                    </div>                                                        
					<div class="form-group">                        
                        <input type="text" class="form-control" onkeyup="ValidaCorreo()" name="correo" id="txtcorreo" placeholder="Correo Electronico" required="required">	
                        <p><span id="demo2"></span></p>    
                    </div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" id="txtcontrasena" placeholder="Contraseña" required="required">
                    </div>    

                    <input type="hidden" name="status" id="txtstatus" />  
                    <input type="hidden" name="identificador" id="identificador" />
                    <!--<div class="form-group">
                        <input type="hidden" name="tipou" id="txttipou"/>
                        <input class="form-check-input" type="checkbox" id="chAcceso">
                        <label class="form-check-label" for="chAcceso">Usuario De Prueba</label>
                    </div>-->
                    
                    <div id="Alertas" class="">
                        <button  type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span id="btnAlerta" aria-hidden="true"></span>
                        </button>                        
                    </div> 

                    <div class="form-group">
                        <button type="button" name="registrar" onclick="LimpiaElementos(); GuardarUsuario()" class="btn btn-primary btn-lg btn-block">Registrar</button>
                    </div>
                                       
				</form>
            </div>
		</div>
	</div>
</div> 
