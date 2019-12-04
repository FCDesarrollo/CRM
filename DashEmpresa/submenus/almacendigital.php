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

		<h4 class="tx-gray-800">ALMACEN DIGITAL OPERACIONES</h4>    
    	<p class="mg-b-30"></p>	

		<div class="row justify-content-around">
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Compras)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalOpe, SubCompras, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Compras</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Ventas)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalOpe, SubVentas, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Ventas</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Pagos)==0) ? 'disabled' : ''; ?>  onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalOpe, SubPagos, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Pagos</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Cobros)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalOpe, SubCobros, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Cobros</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Produccion)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalOpe, SubProduccion, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Produccion</button>
			</div>									
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Inventarios)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuAlmacenDigitalOpe, SubInventarios, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Inventarios</button>
			</div>			
		</div>
		


	</div>

	<div class="br-section-wrapper pd-t-15" id="divdinamico">
		
	</div>

</div>
