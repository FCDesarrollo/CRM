<div class="br-section-wrapper"> 
<h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Editar Usuario</h6>
    <div class="body" >
            <form id="FormGuardarUsuario" action="" method="post">
            <div class="control-group">
                <button type="button" onclick="GuardaUsuariolog();" class="btn btn-primary">Guardar</button>  
                <button type="button" onclick="EliminarUsuariolog(txtidusuario.value, txtnombre.value);" class="btn btn-danger">Eliminar</button>
            </div>  
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
                    
                    <div class="control-group">
                        <label class="control-label" for="basicinput">Activo</label>
                        <input type="hidden" name="status" id="txtstatus2" /> 
                        <input type="hidden" name="tipo" id="txttipo2" />
                        <input class="checkbox" type="checkbox" id="chEst"> 
                    </div>               
                </form>

                <div class="control-group">
                
                    <div>
                    <label class="control-label">Permisos</label>
                    <button type="button" onclick=""class="btn btn-primary">Cambiar Perfil</button>
                    </div>
                    <div id="alertSave" class="alert alert-success" style="display:none;">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Actualizado!</strong> Cambio Guardado Correctamente :) 
                    </div>
                    <form>
                        <div class="module-body table" >
                            <table id="ListaPermisoslog" hide cellpadding="0" cellspacing="0"  class="table table-bordered	 display"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>Perfil</th>
                                        <th>Nombre Modulo</th>
                                        <th>Tipo Permiso</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>     
    </div>
</div>

<script>
    function GuardaUsuariolog(){
        $("#txtidusuario").val(IDUSER);
        $("#txtstatus2").val( $('#chEst').is(":checked") ? "1" : "0" );
        $.post(ws + "GuardaUsuario", $("#FormGuardarUsuario").serialize(), function(data){
            if(data>0){
                loadDiv('../divsadministrar/divadmusuarios.php');
            }else{
                alert("Ocurrio un error al guardar el usuario");
            }
        }); 
        //document.getElementById("#FormGuardaEmpresa").reset();
    }
</script>