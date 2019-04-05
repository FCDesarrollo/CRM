<?php
	session_start();
	if($_SESSION['RFCEmpresa'] == ""){
		$_SESSION['idempresalog'] = 0;		
		echo "<script> window.location='../../../../usuario.php' </script>";
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
		
		<h4 class="tx-gray-800">Contabilidad</h4>    
    	<p class="mg-b-30"></p>		

		<div class="row justify-content-around">
	        <div class="col-lg-6 col-md-4 col-sm-6">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Esta_Financieros)==0) ? 'disabled' : ''; ?> onclick="CargaContenido(1, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Estados Financieros</button>
			</div>
	        <div class="col-lg-6 col-md-4 col-sm-6">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Conta_Electr)==0) ? 'disabled' : ''; ?> onclick="CargaContenido(2, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Contabilidad Electronica</button>
			</div>
			<div class="col-lg-6 col-md-4 col-sm-6">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Exped_Admnis)==0) ? 'disabled' : ''; ?> onclick="CargaContenido(3, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Expedientes Administrativos</button>            
	        </div>
			<div class="col-lg-6 col-md-4 col-sm-6">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Exped_Conta)==0) ? 'disabled' : ''; ?> onclick="CargaContenido(4, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Expedientes Contables</button>
	        </div>
		</div>
	</div>

	<div class="br-section-wrapper" id="divdinamico">
		

	</div>







</div>