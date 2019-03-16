<?php
	session_start(); 
?>
<!--
<div class="pd-sm-x-30 pd-t-30">
    <h4 class="tx-gray-800 mg-b-5">Editar Perfil</h4> 
    <p class="mg-b-0"></p>
</div>		-->	
<div class="br-pagebody pd-l-0 pd-r-0">
	<div class="br-section-wrapper" id="divdinamico">

		<h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mb-md-4">Datos Personales</h6>
		<p class="mg-b-10"><span class="tx-danger" id="msg_verificacion"> </span><a href="#" id="link_verificacion" onclick="ValidarCelular()"> </a></p>
		
		<form id="FormEditaUsuario" action="" method="post">
			<div class="form-layout form-layout-3">
	            <div class="row no-gutters">

	              <input type="hidden" name="idusuario" id="txtidusuario" value="<?php echo $_SESSION["idusuario"]; ?>" />
				  <input type="hidden" name="identificador" id="txtidentificador">

	              <div class="col-md-6">
	                <div class="form-group">
	                	<label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="nombre" id="txtnombre" placeholder="Nombre(s)">
	                </div>
	              </div><!-- col-4 -->
	              <div class="col-md-6 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
						<label class="form-control-label">Apellido Paterno: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="apellidop" id="txtapellidop" placeholder="Apellido Paterno">
	                </div>
	              </div><!-- col-4 -->
	              <div class="col-md-6 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
	                	<label class="form-control-label">Apellido Materno: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="apellidom" id="txtapellidom" placeholder="Apellido Materno">
	                </div>
	              </div><!-- col-4 -->
	              <div class="col-md-6">
	                <div class="form-group bd-t-0-force">
	                	<label class="form-control-label">Correo Electronico: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="correo" id="txtcorreo" placeholder="Correo Electronico">
	                </div>
	              </div><!-- col-8 -->
	              <div class="col-md-4 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
	                	<label class="form-control-label">Telefono Celular: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="cel" id="txtcelular" placeholder="Celular">
	                </div>
	              </div><!-- col-4 -->	     
	              <div class="col-md-4 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
	                	<label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="password" name="password" id="txtcontrasena" placeholder="Contraseña">
	                </div>
	              </div><!-- col-4 -->
	              <div class="col-md-4 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
						<a href="" data-toggle="modal" onclick="CargaModalNoti('<?php echo $_SESSION['idempresalog']; ?>','<?php echo $_SESSION['idusuario'] ?>')" id="btn-notificaciones" data-target="#NotificacionesModal" class="btn btn-compose btn-with-icon">
						  <div class="ht-40 justify-content-between">						    
						    <span class="icon wd-40"><i class="fa fa-cogs"></i></span>
						    <span class="pd-x-15">Notificaciones</span>
						  </div>
						</a>										
	                </div>
	              </div><!-- col-4 -->
	            </div><!-- row -->
	            <div class="form-layout-footer bd pd-20 bd-t-0 d-flex justify-content-center">      		            			      
	              <button type="button" class="btn btn-info" onclick="EditaUsuario()">Guardar</button>
	              <!--<button class="btn btn-secondary">Cancelar</button>				-->
	            </div><!-- form-group -->
	        </div>
		</form>


		<!--MODAL DE VERIFICACION DE NUMERO TELEFONICO-->
		<div class="modal" id="NotificacionesModal">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content bd-0">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Configuracion de Notificaciones</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>


                <div class="modal-body pd-25">          
                	<p class="mg-b-5" id="iden">En este apartado se enlistan todos los submenus de los cuales podra configurar si desea recibir notificaciones tipo SMS o Email. </p>        
	
					<div class="bd bd-gray-300 rounded table-responsive">
				        <table class="table table-bordered" id="t-Notificaciones">            
				            <thead>
				                <tr>
				                	<th class="d-none"></th>
				                    <th>Sub Menu</th>
				                    <th align="center">Notificaciones</th>
				                </tr>                
				            </thead>

				        </table>
					</div>
    
                </div>


                <div class="modal-footer">                  
                  <button type="button" data-dismiss="modal" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Cerrar</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
        </div>





	

<!-- 
 	    <form id="FormGuardarUsuario" action="" method="post">

	        <input type="hidden" name="idusuario" id="txtidusuario" />                            

	        <div class="control-group">
	            <label class="control-label">Nombre</label>
	            <div class="controls">
	                <input type="text" class="form-control" name="nombre" id="txtnombre" placeholder="Nombre(s)" required="required">		
	            </div>
	        </div>  
	        <div class="controls">
	            <label class="control-label">Apellido Paterno</label>
	            <input type="text" class="form-control" name="apellidop" id="txtapellidop" placeholder="Apellido Paterno" required="required">	
	        </div>      
	        <div class="control-group">
	            <label class="control-label">Apellido Materno</label>
	            <input type="text" class="form-control" name="apellidom" id="txtapellidom" placeholder="Apellido Materno" required="required">	
	        </div>
	        <div class="control-group">
	            <label class="control-label">Telefono</label>
	            <input type="text" class="form-control" name="cel" id="txtcelular" placeholder="Telefono" required="required">	
	        </div>                                                        
	        <div class="control-group">
	            <label class="control-label">Correo</label>
	            <input type="text" class="form-control" name="correo" id="txtcorreo" placeholder="Correo Electronico" required="required">	
	        </div>
	        <div class="control-group">            
	            <input type="hidden" class="form-control" name="password" id="txtcontrasena" placeholder="Contraseña" required="required">	     
	        </div>    
	        
	        <div class="control-group mg-t-20">
	            <label class="control-label" for="basicinput">Activo</label>
	            <input type="hidden" name="status" id="txtstatus2" /> 
	            <input type="hidden" name="tipo" id="txttipo2" />
	            <input class="checkbox" type="checkbox" id="chEst"> 
	        </div>       
	        
	        <div class="control-group mg-t-20">
	            <button type="button" onclick="GuardaUsuariolog();" class="btn btn-outline-primary">Guardar</button>  
	            <button type="button" onclick="EliminarUsuariolog(txtidusuario.value, txtnombre.value);" class="btn btn-outline-danger">Eliminar</button>
	            <button type="button" class="btn btn-outline-teal">Cambiar Perfil</button>
	        </div>           
	        
	    </form>  -->


	</div>
</div>




	<script>
		CargaDatosUsuario($("#txtidusuario").val());			
	</script>