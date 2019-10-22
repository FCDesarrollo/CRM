<div id="Modal_FiltroB" class="modal" data-backdrop="static" data-keyboard="false" >
	<div class="modal-dialog modalSelect3" style="max-width: 575px;">
		<div class="modal-content">
			<div class="modal-header">			
                <h5 class="modal-title">Filtro Avanzado Expedientes Contables</h5>	
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
			</div>
            <div class="modal-body" >   
                <div class="row">          
                    <div class="col-lg-7 col-md-7" >
                        <div class="control-group">
                            <div class='form-group'>    
                            <label class="control-label">Por Ejercicio:</label>
                               <select id="FilEjercicio" class="form-control select2"></select>                      
                            </div>
                        </div>
                    </div>   

                    <div class="col-lg-7 col-md-7">
                        <div class="control-group">
                            <div class='form-group'>    
                            <label class="control-label">Por Periodo:</label>
                               <select id="FilPeriodo" class="form-control select2"></select>                      
                            </div>
                        </div>
                    </div>                                                 
                </div>                

                <div class="row">
                    <div class="col-lg-10 col-md-10">
                        <div class="control-group">
                            <div class='form-group'>   
                                <label class="control-label">Por Servicio:</label>
                                <select id="FilServicio" class="form-control select2"></select>                  
                            </div>
                        </div>        
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <div class="control-group">
                            <div class='form-group'>    
                                <label class="control-label">Por Agente:</label>
                                    <select id="FilAgente" class="form-control select2"></select>                  
                            </div>                                                      
                        </div>
                    </div>                           
                          
                </div>
            </div>

            <div class="modal-footer">
                  <button type="button" onclick="Filtrar()" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Continuar</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>