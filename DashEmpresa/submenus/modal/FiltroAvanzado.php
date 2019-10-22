<div id="Modal_FiltroA" class="modal" data-backdrop="static" data-keyboard="false" >
	<div class="modal-dialog modalSelect3" style="max-width: 575px;">
		<div class="modal-content">
			<div class="modal-header">			
                <h5 class="modal-title">Filtro Avanzado</h5>	
                <button type="button" class="close" data-dismiss="modal" onclick="cerrarArchivos()">&times;</button>
			</div>
            <div class="modal-body">
                    
                
                <div class="row">
                    
                    <div class="col-lg-6 col-md-6">
                        <div class="control-group">
                            <div class='form-group'>    
                            <label>Fecha: </label>                                
                            <div class="input-group">
                              <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                              <input id="datepicker_ini" onmousedown="DataPickerView(this.id)" onclick="DataPickerView(this.id)" type="text" class="form-control" placeholder="YYYY-MM-DD">
                            </div>                     
                            </div>
                        </div>
                    </div>                            
                    
                    <div class="col-lg-6 col-md-6">
                        <div class="control-group">
                            <div class='form-group'>    
                            <label>Al: </label>                                
                            <div class="input-group">
                              <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                              <input id="datepicker_fin" onmousedown="DataPickerView(this.id)" onclick="DataPickerView(this.id)" type="text" class="form-control" placeholder="YYYY-MM-DD">
                            </div>                     
                            </div>
                        </div>
                    </div>
                                           
                </div>                

                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="control-group">
                            <div class='form-group'>   
                                <label class="control-label">Por Usuario:</label>
                                <select id="FiltroUsuario" class="form-control select2"></select>                  
                            </div>
                        </div>        
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="control-group">
                            <div class='form-group'>    
                                <label class="control-label">Por Rubro:</label>
                                    <select id="FiltroRubro" class="form-control select2"></select>                  
                            </div>                                                      
                        </div>
                    </div>                           
                          
                </div>

                <div class="row">    
                    <div class="col-lg-6 col-md-6">
                        <div class="control-group">
                            <div class='form-group'>    
                                <label class="control-label">Por Sucursal:</label>
                                    <select id="FiltroSucursal" class="form-control select2"></select>                  
                            </div>                                                      
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="control-group">
                            <div class='form-group'>    
                                <label class="control-label">En Orden</label>
                                    <select id="FiltroOrden" class="form-control select2">
                                        <option value="DESC">Descendente</option>
                                        <option value="ASC">Ascendente</option>                                        
                                    </select>                  
                            </div>                                                      
                        </div>
                    </div>                                                     
                </div>                


                <!--<div class="row">
                    <div class="col-12">
                        <div class='form-group d-flex justify-content-end'>    
                            <button type="button" class="btn btn-primary">Continuar</button>
                            <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Cerrar</button>
                        </div>    
                    </div>
                </div>-->

                
            </div>

            <div class="modal-footer">
                  <button type="button" onclick="Filtrar()" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Continuar</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>