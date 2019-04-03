<div id="vincularempresa" class="modal"  >
	<div class="modal-dialog modalSelect3">
		<div class="modal-content">
			<div class="modal-header">			
                <h5 class="modal-title">Agregar los datos para vincular empresa</h5>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
            <div class="modal-body">
                <form id="FormVincu" action="" method="post" required="required">
                <div class='form-group'>
                            <label for='archivoCerV'>FIEL .Cer</label>
                            <input type="file" name="archivoCerV" id="archivoCerV">
                        </div>
                        <div class='form-group'>
                            <label for='archivoKeyV'>FIEL .Key</label>
                            <input type="file" name="archivoKeyV" id="archivoKeyV">
                        </div>
                        <div class='form-group'>
                            <label for='txtContrasenaV'>Contraseña FIEL</label>
                            <input type="passwordV" class="form-control" id="txtContrasenaV" name="passwordV" placeholder="Contraseña" required="required"/>
                            <div class='invalid-feedback'> Campo Requerido. </div>
                        </div>
                    <div class="control-group">
                        <label class="control-label" for="basicinput">Perfil:</label>
                        <div class="controls">
                        <select id="seleperfil" tabindex="1" data-placeholder="Select here.." >
                                                                
                        </select>
                        </div>
                    </div>
                    <hr>
                    <button type="button" onclick="VinculacionEmpresa()" class="btn btn-primary">Guardar Vinculación</button>
                </form>                    
            </div>
        </div>
    </div>
</div>

