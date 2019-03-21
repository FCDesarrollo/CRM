<div id="vincularempresa" class="modal"  >
	<div class="modal-dialog modalSelect3">
		<div class="modal-content">
			<div class="modal-header">			
                <h5 class="modal-title">Agregar los datos para vincular empresa</h5>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
            <div class="modal-body">
                <form id="FormVincu" action="" method="post" required="required">
                    <div class="control-group">
                        <label class="control-label" for="basicinput">RFC de la empresa</label>
                        <div class="controls">
                            <input type="text" id="txtrfc" name="rfc" placeholder="Empresa" required="required">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="basicinput">Password de la empresa</label>
                        <div class="controls">
                            <input type="text" id="txtpass" name="password" placeholder="Password" required="required">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="basicinput">Perfil:</label>
                        <div class="controls">
                        <select id="seleperfil" tabindex="1" data-placeholder="Select here.." >
                                                                
                        </select>
                        </div>
                    </div>
                    <hr>
                    <button type="button" onclick="VinculacionEmpresa(txtrfc.value, txtpass.value, '<?php echo $_SESSION['idusuario']; ?>',seleperfil.value);" class="btn btn-primary">Guardar Vinculación</button>
                </form>                    
            </div>
        </div>
    </div>
</div>

