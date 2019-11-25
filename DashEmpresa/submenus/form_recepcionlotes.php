		<div class="row justify-content-around">
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Compras)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesCompras, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Compras</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Ventas)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesVentas, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Ventas</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Pagos)==0) ? 'disabled' : ''; ?>  onclick="ExpDigitales(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesPagos, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Pagos</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Cobros)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesCobros, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Cobros</button>
			</div>
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Produccion)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesProduccion, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Produccion</button>
			</div>									
	        <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10 act_title" <?= ($perMod->SubMenu_Permiso(SubMen_Lotes_Inventarios)==0) ? 'disabled' : ''; ?> onclick="ExpDigitales(ModBandejaEntrada, MenuRecepcionLotes, Sub_LotesInventarios, '<?php echo $_SESSION['RFCEmpresa']; ?>')">Inventarios</button>
			</div>			
		</div>