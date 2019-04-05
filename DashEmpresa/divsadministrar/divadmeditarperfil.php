<?php
session_start();  
    // $user = $_SESSION['idusuario'];
    // $user1 = $_SESSION['usuario21'];
    // $user2 = $_SESSION['tipo'];
    if($_SESSION["usuario21"] == "")
    {
        //Si no hay sesión activa, lo direccionamos al index.php (inicio de sesión) 
      session_destroy(); echo "<script> window.location='index.php' </script>";
      exit(); 
    } 
?>
        <h4 class="tx-gray-800 mg-b-5">Editar Perfil</h4>
        <input type="hidden" name="idperfil" id="txtidperfilE" />                            

        <div class="control-group">
            <label class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1">Nombre Perfil</label>
            <div class="controls">
                <input type="text" class="form-control" name="nombreperfil" id="txtnombreperfil2E" >		
            </div>
        </div>  
        <div class="controls">
            <label class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1">Descripción</label>
            <input type="text" class="form-control" name="descripcion" id="txtdesPerfil2E" >	
        </div>        
        <div class="control-group">
            <div id="activo">
               
            </div>
        </div>   

    <div id="accordion" class="accordion mg-t-20" role="tablist" aria-multiselectable="true">
    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Permisos del Perfil</h6>
    <div class="card">
        <div class="card-header" role="tab" id="heading2">
        <h6 class="mg-b-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"
            aria-expanded="true" aria-controls="collapseTwo" class="tx-gray-800 transition">
            Lista de Modulos
            </a>
        </h6>
        </div><!-- card-header -->

        <div id="collapse2" class="collapse hide" role="tabpanel" aria-labelledby="heading2">
        <div class="card-block pd-20">
        <div class="bd bd-gray-300 rounded table-responsive">
        <table class="table table-bordered" id="t-ModulosPer">            
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
                <table class="table table-bordered" id="t-MenusPer">            
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
                    <table class="table table-bordered" id="t-SubMenusPer">            
                        <thead>
                            <tr>
                                <th class="d-none"></th>
                                <th class="d-none"></th>
                                <th>SubMenus</th>
                                <th>Menu</th>
                                <th align='center'>Permisos</th>
                                <th align='center'>Notificaciones</th>
                            </tr>                
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- card -->    

    <div >
        <button type="button" onclick="SavePerfilEmpresa(nIDPerfil, sIDEmpresa, 1);" class="btn btn-primary btn-block mg-b-10">Guardar</button>   
    </div>
    <!-- ADD MORE CARD HERE -->
    </div><!-- accordion -->
            

<script>
   var sIDEmpresa ='<?php echo $_SESSION["idempresalog"]; ?>';
   var nIDPerfil = 0; 
</script>