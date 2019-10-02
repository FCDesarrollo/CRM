<div id="SubirArchivosInbox" class="modal" data-backdrop="static" data-keyboard="false" >
	<div class="modal-dialog modalSelect3">
		<div class="modal-content">
			<div class="modal-header">			
                <h5 class="modal-title">Cargar Archivos</h5>	
                <button type="button" class="close" data-dismiss="modal" onclick="cerrarArchivos()">&times;</button>
			</div>
            <div class="modal-body">
                <form id="FormSubirArchivos" action="" method="post" required="required" enctype="multipart/form-data">                        
                        <input type="hidden" name="rfc" id="txtRFC" value='<?php echo $_SESSION['RFCEmpresa']; ?>' />
                        
                        <input type="hidden" name="idUsuarioArch" id="idUsuarioArch" value="<?php echo $_SESSION['idusuario']; ?>" />    
                        <div class='form-group'>
                            <textarea id="comentarios" name="comentarios" class="form-control"  required="required" placeholder="Escribe aquí tus comentarios"></textarea>                        
                        </div>
                        <div class='form-group'>
                            <!--<label for='archivosInbox'>Elegir Archivos</label>-->
                            <input type="file" id="archivos" name="archivos[]" accept="image/png, .jpeg, .jpg, .docx, .pdf" multiple=""  required="required">                
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="basicinput">Rubros:</label>
                            <div class="controls">
                                <select id="selectRubros" tabindex="1"></select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Sucursal:</label>
                            <div class="controls">
                                <select id="selectSucursales" tabindex="1" ></select>
                            </div>
                        </div>                        
                    <hr>
                    <button type="button" onclick="cargarArchivos()" class="btn btn-primary">Cargar</button>
                </form>                    
            </div>
        </div>
    </div>
</div>