        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mb-md-4">Crear Nuevo Usuario</h6>
        <p class="mg-b-10">Registro de nuevos usuarios</p>
        
        <form id="FormAgregarUsuario" action="" method="post">
            <div class="form-layout form-layout-3">
                <div class="row no-gutters">

                  <input type="hidden" name="idusuario" id="txtidusuario" />
                  <input type="hidden" name="identificador" id="txtidentificador">
                  <input type="hidden" name="status" id="txtstatus">

                  <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="nombre" id="txtnombre" placeholder="Nombre(s)">
                    </div>
                  </div><!-- col-4 -->
                  <div class="col-md-4 mg-t--1 mg-md-t-0">
                    <div class="form-group mg-md-l--1">
                        <label class="form-control-label">Apellido Paterno: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="apellidop" id="txtapellidop" placeholder="Apellido Paterno">
                    </div>
                  </div><!-- col-4 -->
                  <div class="col-md-4 mg-t--1 mg-md-t-0">
                    <div class="form-group mg-md-l--1">
                        <label class="form-control-label">Apellido Materno: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="apellidom" id="txtapellidom" placeholder="Apellido Materno">
                    </div>
                  </div><!-- col-4 -->
                  <div class="col-md-4">
                    <div class="form-group bd-t-0-force">
                        <label class="form-control-label">Correo Electronico: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="correo" id="txtcorreo" onblur="ValidaCorreo(this.value)" placeholder="Correo Electronico">
                    </div>
                  </div><!-- col-8 -->
                  <div class="col-md-4 mg-t--1 mg-md-t-0">
                    <div class="form-group mg-md-l--1">
                        <label class="form-control-label">Telefono Celular: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="cel" id="txtcelular" placeholder="Celular">
                    </div>
                  </div><!-- col-4 -->       
                  <div class="col-md-4 mg-t--1 mg-md-t-0">
                    <div class="form-group mg-md-l--1">
                        <label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="password" name="password" id="txtcontrasena" placeholder="Contraseña">
                    </div>
                  </div><!-- col-4 -->
                </div><!-- row -->
                <div class="form-layout-footer bd pd-20 bd-t-0 d-flex justify-content-end">                                            
                  <button type="button" class="btn btn-info m-1" id="btnagregauser" onclick="AgregarUsuario()">Agregar Usuario</button>
                  <button type="button" class="btn btn-secondary m-1" onclick="CargaListaUsuarios()">Cancelar</button>
                </div><!-- form-group -->
            </div>
        </form>