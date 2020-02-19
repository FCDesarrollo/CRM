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
	$perMod->SubMenus();
?>

<div class="br-pagebody pd-l-0 pd-r-0">
	<!-- ¡Efecto Loading! Quitar clase d-none para mostrar, y agregar para ocultar con javascript -->
	<div class="d-none" id="loading"></div> 
	
	<div class="br-section-wrapper pd-b-0">

		<h4 class="tx-gray-800">ALMACEN DIGITAL EXPEDIENTES</h4>    
    	<p class="mg-b-30"></p>	

		<div class="row">
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Gobierno)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalExp, SubGobierno, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Gobierno</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Bancos)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalExp, SubBancos, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Bancos</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_RecursosHumanos)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalExp, SubRecursosHumanos, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Recursos Humanos</button>
			</div>
		</div>
		<div class="row justify-content-around">
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Clientes)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalExp, SubClientes, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Clientes</button>
			</div>			
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Proveedores)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalExp, SubProveedores, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Proveedores</button>
			</div>									
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Constitucion)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalExp, SubConstitucion, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Constitucion</button>
			</div>								
		</div>
		<div class="row justify-content-around">
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Activos)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalExp, SubActivos, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Activos</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Publicaciones)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalExp, SubPublicaciones, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Publicaciones</button>
			</div>	
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" <?= ($perMod->SubMenu_Permiso(SubMen_Impuestos)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalExp, SubImpuestos, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Impuestos</button>
			</div>				
		</div>

	</div>

	<div class="br-section-wrapper pd-t-15" id="divdinamico">
		
	</div>

</div>