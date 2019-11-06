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

		<h4 class="tx-gray-800">Almacen Digital Expedientes</h4>    
    	<p class="mg-b-30"></p>	

		<div class="row">
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Generales)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalExp, SubGenerales, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Generales</button>
			</div>
	        <!--<div class="col-sm-3 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" disabled>Bancos</button>
			</div>
	        <div class="col-sm-3 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" disabled>Recursos Humanos</button>
			</div>
	        <div class="col-sm-3 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" disabled>Clientes</button>
			</div>-->
		</div>
		<!--<div class="row justify-content-around">
	        <div class="col-sm-3 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" disabled>Proveedores</button>
			</div>									
	        <div class="col-sm-3 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" disabled>Constitucion</button>
			</div>			
	        <div class="col-sm-3 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" disabled>Activos</button>
			</div>
	        <div class="col-sm-3 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" disabled>Publicaciones</button>
			</div>						
		</div> -->

	</div>

	<div class="br-section-wrapper pd-t-15" id="divdinamico">
		
	</div>

</div>