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

		<h4 class="tx-gray-800">Almacen Digital</h4>    
    	<p class="mg-b-30"></p>	

		<div class="row justify-content-around">
	        <div class="col-sm-6 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Noti_Autoridades)==0) ? 'disabled' : ''; ?> >Notificaciones de Autoridades</button>
			</div>
	        <div class="col-sm-6 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Expe_Digi)==0) ? 'disabled' : ''; ?>  onclick="CargaContenidoInbox(ModBandejaEntrada, MenuAlmacenDigital, SubExpedientesDigitales, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Expedientes Digitales</button>
			</div>
		</div>


	</div>

	<div class="br-section-wrapper" id="divdinamico">
		
	</div>

</div>