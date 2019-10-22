
<div id="SubirArchivosInbox" class="modal" data-backdrop="static" data-keyboard="false" >
	<div class="modal-dialog modalSelect3" style="max-width: 575px;">
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
                                <div class="row">
                                    <div class="col-8">
                                        <label>Archivos Seleccionados:</label>        
                                    </div>
                                    <div class="col-4">
                                        <!--<label id="numero_archivos">0</label>
                                        <a href="#" id="numero_archivos" class="btn btn-outline-dark btn-icon rounded-circle mg-r-5"><div><i></i></div></a>-->

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-sm-6 col-8 pd-r-5">
                                        <label for="archivosInbox" class="custom-file">
                                            <input type="file" id="archivos" name="archivos[]" multiple="" accept="image/png, .jpeg, .jpg, .docx, .pdf" class="custom-file-input" onchange="CountArc()">
                                            <span class="custom-file-control custom-file-control-primary" id="span_select">Seleccionar..</span>
                                        </label>                                        
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-4 pd-0">

                                        <div class="btn-group" rel="popover" role="group" aria-label="Basic example">
                                            <button type="button" id="numero_archivos" class="btn btn-secondary pd-x-15 active">0</button>
                                        </div>                                        
                                    </div>
                                </div>                                
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-6 col-md-6">
                            <div class="control-group">
                                <div class='form-group'>    
                                <label>Fecha del Documento: </label>
                                
                                <div class="input-group">
                                  <span class="input-group-addon" onclick="Calendario()"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                                  <input id="datepicker" onclick="Calendario()" type="text" class="form-control" placeholder="YYYY/MM/DD">
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

                </form>                    
            </div>

            <div class="modal-footer">
                  <button type="button" onclick="cargarArchivos()" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Continuar</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>


<div id="ListaDetalle" class="modal" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modalSelect3">
        <div class="modal-content">
            <div class="modal-header">          
                <h5 class="modal-title"></h5>   
                <!--<button type="button" class="close" data-dismiss="modal" onclick="cerrarArchivos()">&times;</button>-->
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card bd-0 shadow-base">     
                  <table class="table table-bordered mg-b-0" id="t-ListaDetalle">
                    <thead>
                        <tr>                
                            <th class="tx-10-force tx-mont tx-medium">Archivo</th>
                            <th class="tx-10-force tx-mont tx-medium">Cargado</th>
                            <th class="tx-10-force tx-mont tx-medium">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody> 
                  </table>        
                </div>                   
            </div>
        </div>
    </div>
</div>

