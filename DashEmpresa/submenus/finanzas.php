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

		<h4 class="tx-gray-800">Finanzas</h4>    
    	<p class="mg-b-30"></p>	

		<div class="row justify-content-around">
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Indi_Financieros)==0) ? 'disabled' : ''; ?>>Indicadores Financieros</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Ase_Efectivo)==0) ? 'disabled' : ''; ?>>Asesor de Flujos de Efectivo</button>
			</div>
			<div class="col-sm-4 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Anali_Proyec)==0) ? 'disabled' : ''; ?>>Analisis de Proyectos</button>            
	        </div>
		</div>


	</div>

	<div class="br-section-wrapper" id="divdinamico">
		
	</div>	
</div>