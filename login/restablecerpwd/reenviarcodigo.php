<div class="row">
  <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-body" id="validacion">
          <div class="text-center">
          
          <h2 class="text-center">Disculpe las molestias.</h2>
          <p>Introduce el correo electronico con el que te registraste.</p>
          <div class="panel-body">    
            <form id="register-form" role="form" autocomplete="off" class="form" method="post">    
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                  <input id="email" name="email" onkeyup="limpia()" placeholder="Correo Electronico o Celular" class="form-control"  type="email">
                </div>
              </div>
              <div class="form-group">      
                <input name="recover-submit" onclick="ValidaCorreo_Res()" class="btn btn-lg btn-primary btn-block" value="Enviar Codigo" type="button">         
              </div>                                                    
            </form>    
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-3"></div>
  </div>