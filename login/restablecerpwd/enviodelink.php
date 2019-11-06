<div class="row">
  <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-body" id="validacion">
          <div class="text-center">
          <h3><i class="fa fa-lock fa-4x"></i></h3>
          <h2 class="text-center">¿Olvidaste tu contraseña?</h2>
          <p>Ingresa tu correo electronico o numero de telefono.</p>
          <div class="panel-body">    
            <form id="register-form" role="form" autocomplete="off" class="form" method="post">    
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                  <input id="email" name="email" onkeyup="limpia()" placeholder="Correo Electronico o Celular" class="form-control"  type="email">
                </div>
              </div>
              <div class="form-group">      
                <input name="recover-submit" onclick="ValidaCorreo_Res()" class="btn btn-lg btn-primary btn-block" value="Restablercer" type="button">         
              </div>                                                    
            </form>    
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-3"></div>
  </div>