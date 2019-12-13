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
	
		<div class="row"> 
			<div class="col-lg-10 col-md-10 col-sm-8 col-xs-8"> 
				<h4 class="tx-gray-800 pd-b-10">RECEPCION POR LOTES OPERACIONES</h4>    
			</div>
			<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4"> 
	            <button class="btn btn-secondary btn-block mg-b-10" onclick="DescargarPlantilla()">Plantillas</button>			
			</div>

		</div>	


		<div class="row justify-content-around">
	        <div class="col-sm-4 col-6 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Compras)==0) ? 'disabled' : ''; ?> onclick="CargarLotes(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesCompras)">Compras</button>
			</div>
	        <div class="col-sm-4 col-6 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Ventas)==0) ? 'disabled' : ''; ?> onclick="CargarLotes(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesVentas)">Ventas</button>
			</div>
	        <div class="col-sm-4 col-6 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Pagos)==0) ? 'disabled' : ''; ?>  onclick="CargarLotes(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesPagos)">Pagos</button>
			</div>
	        <div class="col-sm-4 col-6 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Cobros)==0) ? 'disabled' : ''; ?> onclick="CargarLotes(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesCobros)">Cobros</button>
			</div>
	        <div class="col-sm-4 col-6 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Produccion)==0) ? 'disabled' : ''; ?> onclick="CargarLotes(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesProduccion)">Produccion</button>
			</div>									
	        <div class="col-sm-4 col-6 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Inventarios)==0) ? 'disabled' : ''; ?> onclick="CargarLotes(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesInventarios)">Inventarios</button>
			</div>			
		</div>
		


	</div>

	<div class="br-section-wrapper pd-t-15" id="divdinamico">
		
	</div>

		<div class="modal fade" id="_Plantillas">
            <div class="modal-dialog modal-lg mw-100" role="dialog">
              <div class="modal-content wd-xs-400 wd-sm-600 wd-md-600 wd-300 bd-0">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Plantillas disponibles para descarga.</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>


                <div class="modal-body wd-auto pd-25">
					<ul id="ul_descargaplantilla" class="list-group wd-auto">
						
					</ul>  
                </div>


                <div class="modal-footer">                  
					<!--<button type="button" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"></button>-->
                  	<button type="button" data-dismiss="modal" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Cerrar</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
        </div>


</div>

