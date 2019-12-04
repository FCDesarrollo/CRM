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

		<h4 class="tx-gray-800">RECEPCION POR LOTES OPERACIONES</h4>    
    	<p class="mg-b-30"></p>	

		<div class="row justify-content-around">
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Compras)==0) ? 'disabled' : ''; ?> onclick="CargarLotes(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesCompras)">Compras</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Ventas)==0) ? 'disabled' : ''; ?> onclick="CargarLotes(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesVentas)">Ventas</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Pagos)==0) ? 'disabled' : ''; ?>  onclick="CargarLotes(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesPagos)">Pagos</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Cobros)==0) ? 'disabled' : ''; ?> onclick="CargarLotes(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesCobros)">Cobros</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Produccion)==0) ? 'disabled' : ''; ?> onclick="CargarLotes(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesProduccion)">Produccion</button>
			</div>									
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Inventarios)==0) ? 'disabled' : ''; ?> onclick="CargarLotes(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesInventarios)">Inventarios</button>
			</div>			
		</div>
		


	</div>

	<div class="br-section-wrapper pd-t-15" id="divdinamico">
		
	</div>

</div>

				         	
<script>
	/*var idmen = ;
	var idsub = ;
	$.post(ws + "datosRubrosSubMenu", {Correo: datosuser.usuario, Contra: datosuser.pwd, Idempresa: idempresaglobal, idmenu: idmenu, idsubmenu: idsubmenu}, function(data){
		var Rubros = JSON.parse(data);



	});*/
</script>