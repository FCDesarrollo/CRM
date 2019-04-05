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

		<h4 class="tx-gray-800">Proceso Fiscal</h4>    
    	<p class="mg-b-30"></p>	

		<div class="row justify-content-around">
	        <div class="col-sm-6 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Pag_Provisio)==0) ? 'disabled' : ''; ?>>Pagos Provicionales</button>
			</div>
	        <div class="col-sm-6 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Pag_Mens)==0) ? 'disabled' : ''; ?>>Pagos Mensuales</button>
			</div>
			<div class="col-sm-6 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Decla_Anual)==0) ? 'disabled' : ''; ?>>Declaraciones Anuales</button>            
	        </div>
			<div class="col-sm-6 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Exped_Fis)==0) ? 'disabled' : ''; ?>>Expedientes Fiscales</button>            
	        </div>
		</div>

	</div>

	<div class="br-section-wrapper" id="divdinamico">
		
	</div>	
</div>