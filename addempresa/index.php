<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registro</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  

<!--===============================================================================================-->  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/addempresa.css">
</head>
  <body>
  <div id="loading" class="d-none"></div>
    <?php include("../varglobales.php"); ?>
  
    <div class="form">

          <h1>Registro de Empresas</h1>              
      <ul class="tab-group">
            <li class="tab active"><a id="btn_registro" href="#add_sellos">Paso 1</a></li>  
            <li class="tab"><a class="disabled" id="btn_datos" href="#datos_empresa">Paso 2</a></li>
            <!--<li class="tab"><a id="btn_demo" href="#empresa_demo">DEMO</a></li>-->
      </ul>            

      <div class="tab-content">
  <!-- FORMULARIO PARA AGREGAR LOS SELLOS DE LA EMPRESA -->            
        <div id="add_sellos">   
          
            <input type="hidden" id="txtidusuario" value="<?php echo $_GET['id_user']; ?>">
            <p class="p-label">Archivo .Cer</p>           
              <div class="field-wrap">
                <input onblur="LimpiarDatos()" type="file" id="archivoCer" accept=".cer">
              </div>
            <p class="p-label">Archivo .Key</p>             
              <div class="field-wrap">
                <input onblur="LimpiarDatos()" type="file" id="archivoKey" accept=".key">
              </div>                
            <p class="p-label">Contraseña FIEL</p>
            <div class="field-wrap">
              <input type="password" id="txtContrasena" autocomplete="off"/>
            </div>
            <div class="row pdt-30">

              <div class="col-6">
                <button onclick="ValidarDatos()" class="button button-block"/>Validar</button>              
              </div>
              <div class="col-6">
                <button class="button-red button-block" onclick="CancelarAddVin()" />Cancelar</button> 
              </div>
            </div>                            
            
          
        </div>

  <!-- FORMULARIO PARA DATOS DE LA EMPRESA -->            
        <div id="datos_empresa">   
          <h1>Datos de la empresa</h1>
          
          <!--<form action="/" method="post">    -->
            <input type="hidden" id="txtvigencia">          
            <p class="p-label">Nombre de la Empresa</p>
            <div class="field-wrap">
              <input type="text" id="txtempresa" autocomplete="off"/>
            </div>              
            <p class="p-label">RFC</p>
            <div class="field-wrap">
              <input type="text" id="txtrfc" autocomplete="off"/>
            </div>  
            <p class="p-label">Correo Electronico</p>           
            <div class="field-wrap">
              <input type="email" id="txtcorreo" autocomplete="off"/>
            </div>                
            <!--<p class="p-label">Direccion</p>
            <div class="field-wrap">
              <input type="text" id="txtdireccion" autocomplete="off"/>
            </div>
            <p class="p-label">Telefono</p>
            <div class="field-wrap">
              <input type="text" id="txttelefono" autocomplete="off"/>
            </div> 
            <p class="p-label">Codigo Postal</p>
            <div class="field-wrap">
              <input type="text" id="txtcp" autocomplete="off"/>
            </div> -->    
            <div class="row">
              <div class="col-6">
                <button class="button button-block" onclick="CrearEmpresa()" />Crear Empresa</button>
                <!--<button class="button button-block" onclick="CrearCarpetasStorage()" />Crear Carpetas</button>-->
              </div>
              <div class="col-6">
                <button class="button-red button-block" onclick="CancelarAddVin()" />Cancelar</button> 
              </div>
            </div>                                                       
          <!--</form>-->
        </div>
                    
      </div><!-- tab-content -->
      
    </div> <!-- /form -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>    
    <script src="js/addempresa.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    
    <script>
         
    </script>

  </body>
  


</html>