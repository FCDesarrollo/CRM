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
	<div class="br-section-wrapper pd-b-0">

		<h4 class="tx-gray-800">AUTORIZACIONES Y COMPRAS</h4>    
    	<p class="mg-b-30"></p>	

		<div class="row">
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Requerimientos)==0) ? 'disabled' : ''; ?>>Requerimientos de compra</button>
			</div>
	        <!--<div class="col-sm-4 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Autorizaciones)==0) ? 'disabled' : ''; ?>>Autorizaciones</button>
			</div>-->
			<div class="col-sm-4 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Recep_Compras)==0) ? 'disabled' : ''; ?>>Recepcion de Compras</button>            
	        </div>
		</div>


	</div>

	<div class="br-section-wrapper" id="divdinamico">
		
	</div>

</div>