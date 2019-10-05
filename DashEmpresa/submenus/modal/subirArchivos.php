
<div id="SubirArchivosInbox" class="modal" data-backdrop="static" data-keyboard="false" >
	<div class="modal-dialog modalSelect3">
		<div class="modal-content">
			<div class="modal-header">			
                <h5 class="modal-title">Cargado de Expedientes Digitales</h5>	
                <button type="button" class="close" data-dismiss="modal" onclick="cerrarArchivos()">&times;</button>
			</div>
            <div class="modal-body">
                <form id="FormSubirArchivos" action="" method="post" required="required" enctype="multipart/form-data">                        
                        <input type="hidden" name="rfc" id="txtRFC" value='<?php echo $_SESSION['RFCEmpresa']; ?>' />
                        <input type="hidden" name="idUsuarioArch" id="idUsuarioArch" value="<?php echo $_SESSION['idusuario']; ?>" />    
                    <div class="row">
                        
                        <div class="col-lg-6 col-md-6">
                            <div class='control-group'>    
                                <div class='form-group'>    
                                <label>Seleccionar Archivos: </label>
                                <label for="archivosInbox" class="custom-file">
                                    <input type="file" id="archivos" name="archivos[]" multiple="" accept="image/png, .jpeg, .jpg, .docx, .pdf" class="custom-file-input">
                                    <span class="custom-file-control custom-file-control-primary">Seleccionar..</span>
                                </label>
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-6 col-md-6">
                            <div class="control-group">
                                <div class='form-group'>    
                                <label>Fecha del Documento: </label>
                                
                                <div class="input-group">
                                  <span class="input-group-addon" onclick="Calendario()"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                                  <input id="datepicker" onclick="Calendario()" type="text" class="form-control" placeholder="DD/MM/YYYY">
                                </div>                     
                                
                                </div>
                            </div>

                        </div>
                                               
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="control-group">
                            <div class='form-group'>   
                            <label class="control-label">Rubros:</label>
                            <select id="selectRubros" class="form-control select2" data-placeholder="Seleccioanar Rubro">

                            </select>                  
                            </div>
                            </div>        
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="control-group">
                            <div class='form-group'>    
                            <label class="control-label">Sucursales:</label>
                            <select id="selectSucursales" class="form-control select2" data-placeholder="Seleccionar Sucursal">

                            </select>                  
                            </div>                                                      
                            </div>
                            <!--<div class="control-group">
                                <label class="control-label">Sucursal:</label>
                                <div class="controls">
                                    <select id="selectSucursales" tabindex="1" ></select>
                                </div>
                            </div>  -->                          
                        </div>                        
                    </div>         

                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="control-group">
                            <div class='form-group'>                                
                                <label class="control-label">Comentarios:</label>
                                <!--<textarea id="comentarios" name="comentarios" class="form-control"  required="required" placeholder="Escribe aquí tus comentarios"></textarea>    -->
                                <textarea rows="3" class="form-control" id="comentarios" name="comentarios" placeholder="Comentarios.."></textarea>
                            </div>
                            
                            </div>       
                        </div>
                    </div>                        
                    <div class='form-group'>    
                        <button type="button" onclick="cargarArchivos()" class="btn btn-primary">Cargar</button>
                    </div>
                </form>                    
            </div>
        </div>
    </div>
</div>

