<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Permisos del Usuario</h4>
        <p class="mg-b-0">Configuracion de permisos para el usuario.</p>
      </div>
<div class="br-pagebody">
<div class="br-section-wrapper">

    <form id="FormGuardarUsuario" action="" method="post">

        <input type="hidden" name="idusuario" id="txtidusuario" />                            

        <div class="control-group">
            <label class="control-label">Nombre</label>
            <div class="controls">
                <input type="text" class="form-control" name="nombre" id="txtnombre" placeholder="Nombre(s)" required="required">		
            </div>
        </div>  
        <div class="controls">
            <label class="control-label">Apellido Paterno</label>
            <input type="text" class="form-control" name="apellidop" id="txtapellidop" placeholder="Apellido Paterno" required="required">	
        </div>      
        <div class="control-group">
            <label class="control-label">Apellido Materno</label>
            <input type="text" class="form-control" name="apellidom" id="txtapellidom" placeholder="Apellido Materno" required="required">	
        </div>
        <div class="control-group">
            <label class="control-label">Telefono</label>
            <input type="text" class="form-control" name="cel" id="txtcelular" placeholder="Telefono" required="required">	
        </div>                                                        
        <div class="control-group">
            <label class="control-label">Correo</label>
            <input type="text" class="form-control" name="correo" id="txtcorreo" placeholder="Correo Electronico" required="required">	
        </div>
        <div class="control-group">            
            <input type="hidden" class="form-control" name="password" id="txtcontrasena" placeholder="Contraseña" required="required">	     
        </div>    
        
        <div class="control-group mg-t-20">
            <label class="control-label" for="basicinput">Activo</label>
            <input type="hidden" name="status" id="txtstatus2" /> 
            <input type="hidden" name="tipo" id="txttipo2" />
            <input class="checkbox" type="checkbox" id="chEst"> 
        </div>       
        
        <div class="control-group mg-t-20">
            <button type="button" onclick="GuardaUsuariolog();" class="btn btn-outline-primary">Guardar</button>  
            <button type="button" onclick="EliminarUsuariolog(txtidusuario.value, txtnombre.value);" class="btn btn-outline-danger">Eliminar</button>
            <button type="button" class="btn btn-outline-teal">Cambiar Perfil</button>
        </div>           
        
    </form>

    <hr><hr>

    <div id="accordion" class="accordion mg-t-20" role="tablist" aria-multiselectable="true">
    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Permisos del Usuario</h6>
    <p class="mg-b-25 mg-lg-b-30">Configure los permisos del usuario.</p>

    <div class="card">
        <div class="card-header" role="tab" id="heading2">
        <h6 class="mg-b-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"
            aria-expanded="true" aria-controls="collapseTwo" class="tx-gray-800 transition">
            Lista de Modulos
            </a>
        </h6>
        </div><!-- card-header -->

        <div id="collapse2" class="collapse show" role="tabpanel" aria-labelledby="heading2">
        <div class="card-block pd-20">
        <div class="bd bd-gray-300 rounded table-responsive">
        <table class="table table-bordered" id="t-Modulos">            
            <thead>
                <tr>
                    <th>Modulos</th>
                    <th>Descripción</th>
                    <th align='center'>Permisos</th>
                </tr>                
            </thead>
        </table>
        </div>
        </div>
        </div>
    </div><!-- card -->

    <div class="card">
        <div class="card-header" role="tab" id="heading3">
        <h6 class="mg-b-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3" class="tx-gray-800 transition">
            Lista de Menus
            </a>
        </h6>
        </div><!-- card-header -->

        <div id="collapse3" class="collapse hide" role="tabpanel" aria-labelledby="heading3">
            <div class="card-block pd-20">
                <div class="bd bd-gray-300 rounded table-responsive">
                <table class="table table-bordered" id="t-Menus">            
                    <thead>
                        <tr>
                            <th>Menus</th>
                            <th>Modulo</th>
                            <th align='center'>Permisos</th>
                        </tr>                
                    </thead>
                    
                </table>
                </div>            
            </div>
        </div>
    </div><!-- card -->



    <div class="card">
        <div class="card-header" role="tab" id="heading4">
        <h6 class="mg-b-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapse4" class="tx-gray-800 transition">
            Lista de Sub-Menus
            </a>
        </h6>
        </div><!-- card-header -->

        <div id="collapse4" class="collapse hide" role="tabpanel" aria-labelledby="heading4">
            <div class="card-block pd-20">
                <div class="bd bd-gray-300 rounded table-responsive">
                    <table class="table table-bordered" id="t-SubMenus">            
                        <thead>
                            <tr>
                                <th class="d-none"></th>
                                <th>SubMenus</th>
                                <th>Menu</th>
                                <th align='center'>Permisos</th>
                            </tr>                
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- card -->    

    
    <!-- ADD MORE CARD HERE -->
    </div><!-- accordion -->
</div>
</div>

<script>
    window.onload = function() {
        //CargaPermisosUsuario(4,1);
    };

    

</script>