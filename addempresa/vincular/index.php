<!DOCTYPE html>
<html lang="en">
<head>
  <title>Vinculacion</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/addempresa.css">
  <link rel="stylesheet" href="css/vinempresa.css">

</head>
  <body>
    <div id="loading" class="d-none"></div>
    <?php include("../../varglobales.php"); ?>
    <div class="form">
      <h1>VINCULAR A EMPRESA</h1>              


      <div class="tab-content">
  <!-- FORMULARIO PARA AGREGAR LOS SELLOS DE LA EMPRESA -->                      
        <input type="hidden" id="txtidusuario" value="<?php echo $_GET['id_user']; ?>">
        
        <p class="p-label">Archivo .Cer</p>           
        <div class="field-wrap">
          <input type="file" id="archivoCer" accept=".cer">
        </div>

        <p class="p-label">Archivo .Key</p>             
        <div class="field-wrap">
          <input type="file" id="archivoKey" accept=".key">
        </div>        

        <p class="p-label">Contraseña FIEL</p>
        <div class="field-wrap">
          <input type="password" id="txtContrasena" autocomplete="off"/>
        </div>

        <div class="row pdt-30">
          <div class="col-6">
            <button onclick="VincularUsuario()" class="button button-block"/>Vincular</button>              
          </div>
          <div class="col-6">
            <button class="button-red button-block" onclick="CancelarVin()" />Cancelar</button> 
          </div>
        </div> 
        <div></div>
                    
      </div><!-- tab-content -->
      
    </div> <!-- /form -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>    
    <script src="../js/addempresa.js"></script>
    <script src="js/vinempresa.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  </body>
  


</html>