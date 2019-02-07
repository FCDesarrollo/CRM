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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mi Consultor</title>
    
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template 
    <link href="css/freelancer.min.css" rel="stylesheet">-->

    <!-- Estilos Propios -->
    <link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen" />

    <script>
        //var ws = "http://localhost/ApiConsultorMX/miconsultor/public/";
        //var ws = "http://apicrm.dublock.com/public/";
    </script>

</head>
<body onload="CargaListaEmpresas('<?php echo $_SESSION['idusuario']; ?>')">

    <?php include("varglobales.php"); ?>
    <?php // include("nav.php"); ?>
    <?php include("vincularempresa.php"); ?>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <h5 id="usuariolog"></h5>
            </div>
        </div>
    </div>
    <div id="listado-empresas">
      <!-- Aqui se carga el listado de empresas del usuario -->       
    </div>
    

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Contact Form JavaScript 
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>-->

    <!-- Custom scripts for this template 
    <script src="js/freelancer.min.js"></script>-->

    <!-- Validacion de Correo --> 
    <script src="js/app.js"></script>   
    <!--<script src="usuarioadmin/usuarioslog.js"></script>   --> 
</body>
</html>
