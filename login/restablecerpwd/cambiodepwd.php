<div class="row">
  <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="panel panel-default">
        <div class="panel-body">
            <div class="text-center">
            <h3><i class="fa fa-lock fa-4x"></i></h3>
            <h2 class="text-center">Ingresar nueva contrarseña</h2>            
            <div class="panel-body">    
                <form id="register-form" role="form" autocomplete="off" class="form" method="post">                  
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input id="newpwd" name="newpwd" placeholder="Nueva Contraseña" class="form-control"  type="password">
                    </div>                  
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input id="confirmapwd" name="confirmapwd" placeholder="Confirmar Contraseña" class="form-control"  type="password">
                    </div>  
                </div>
                <div class="form-group">      
                    <input name="recover-submit" onclick="CambiarContraseña()" class="btn btn-lg btn-success btn-block" value="Enviar" type="button">
                        
                </div>                                                    
                </form>    
               
            </div>
        </div>
        </div>
    </div>
    <div class="col-sm-3"></div>
</div> 