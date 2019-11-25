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
	<div class="d-none" id="loading"></div> 
	<div class="br-section-wrapper">
		
		<h4 class="tx-gray-800">Administracion de Usuarios</h4>    
    	<p class="mg-b-30"></p>		

		<div class="row justify-content-around">
	        <div class="col-lg-4 col-md-4 col-sm-4">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Usuarios)==0) ? 'disabled' : ''; ?> onclick="CargaListaUsuarios();">Lista de Usuarios</button>
			</div>
	        <div class="col-lg-4 col-md-4 col-sm-4">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Usuarios) > 1) ? '' : 'disabled'; ?> onclick="NuevoUsuario()">Crear Usuario</button>
			</div>
	        <div class="col-lg-4 col-md-4 col-sm-4">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Usuarios) > 1) ? '' : 'disabled'; ?> onclick="VincularUsuario()">Vincular Usuario</button>
			</div>			
		</div>

	</div>

	<div class="br-section-wrapper pd-t-0" id="divdinamico">
		
	</div>





</div>