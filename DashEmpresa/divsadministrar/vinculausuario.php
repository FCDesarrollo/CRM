        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mb-md-4">Vinculacion de Usuarios</h6>
        <p class="mg-b-10"></p>            
        
        <form id="FormVinculaUsuario" action="" method="post">
            <div class="form-layout form-layout-3">
                <div class="row no-gutters">

                  <input type="hidden" name="identificador" id="txtidentificador">
                  <input type="hidden" name="cel" id="txtcelular">
                  <input type="hidden" name="nombre_empresa" id="txtnombre_empresa">

                  <div class="col-md-6">
                    <div class="form-group bd-t-0-force">
                        <label class="form-control-label">Correo Electronico: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="correo" id="txtcorreo" placeholder="Correo Electronico">
                    </div>
                  </div><!-- col-8 -->
                  <div class="col-md-6 mg-t--1 mg-md-t-0">
                    <div class="form-group mg-md-l--1">
                      <label class="form-control-label" tabindex="-1" aria-hidden="true">Asignar Perfil: <span class="tx-danger">*</span></label>
                      <select class="form-control select2" id="_Perfil" name="user_perfil">
                      
                      </select>                    
                    </div>
                  </div> 
                </div><!-- row -->
                <div class="form-layout-footer bd pd-20 bd-t-0 d-flex justify-content-end">                                            
                  <button type="button" class="btn btn-info m-1" onclick="VinculaUsuario()">Vincular Usuario</button>
                  <!--<button type="button" class="btn btn-secondary m-1" onclick="CargaListaUsuarios()">Cancelar</button>-->
                </div><!-- form-group -->
            </div>
        </form>