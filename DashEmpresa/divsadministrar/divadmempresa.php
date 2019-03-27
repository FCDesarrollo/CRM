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

		<h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mb-md-4">Datos de la empresa</h6>
		<!--<p class="mg-b-10"><span class="tx-danger" id="msg_verificacion"> </span><a href="#" id="link_verificacion" onclick="ValidarCelular()"> </a></p>-->
		
		<form id="FormEditaEmpresa" action="" method="post">
			<div class="form-layout form-layout-3">
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
	              <div class="col-md-6 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
	                	<label class="form-control-label">Dirección: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="direcion" id="txtdireccion" placeholder="Dirección" disabled>
	                </div>
	              </div><!-- col-4 -->
	              <div class="col-md-6">
	                <div class="form-group bd-t-0-force">
	                	<label class="form-control-label">Correo Electronico: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="correo" id="txtcorreo" placeholder="Correo Electronico" disabled>
	                </div>
	              </div><!-- col-8 -->
	              <div class="col-md-4 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
	                	<label class="form-control-label">Telefono: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="text" name="telefono" id="txttelefono" placeholder="telefono" disabled>
	                </div>
	              </div><!-- col-4 -->	     
	              <div class="col-md-4 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
	                	<label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
	                  	<input class="form-control" type="password" name="password" id="txtcontrasena" placeholder="Contraseña" disabled>
	                </div>
	              </div><!-- col-4 -->
	              <div class="col-md-4 mg-t--1 mg-md-t-0">
	                <div class="form-group mg-md-l--1">
									<label class="form-control-label">Fecha de Certificados: <span class="tx-danger">*</span></label>

	                </div>
	              </div><!-- col-4 -->
	            </div><!-- row -->
	            <div class="form-layout-footer bd pd-20 bd-t-0 d-flex justify-content-center">      		            			      
	              <button type="button" class="btn btn-info" onclick="">Guardar</button>
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




	</div>
</div>




	<script>
		CargaDatosEmpresaAD($("#txtidempresa").val());			
	</script>