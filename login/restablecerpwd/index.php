<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restabler Contraseña</title>

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>      -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"> 


</head>
<body>
    
    <?php include("../../varglobales.php"); ?>

    <div class="container-fluid">
    <input type="hidden" name="idusuario" id="idusuario" value='<?php echo $_GET["user"]; ?>' />
    <div class="container">
        <h3 id="Titulo" align="center">Restablecer Contraseña</h3>
    </div>  
    <hr></hr>
    </div>


    <div class="container mostrardiv">  
        <!-- AQUI SE CARGA UN ARCHIVO PHP DEPENDIENDO DE LA ACCION -->
    </div>


    <script src="js/restablecerpwd.js"></script>  
    <!-- NOTIFICACIONES MODAL -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <?php
        if($_GET){
            if(isset($_GET['user'])){    
                echo "<script> $('.mostrardiv').load('cambiodepwd.php'); </script>";
            }elseif(isset($_GET['ecod'])){
                echo "<script> document.getElementById('Titulo').innerHTML ='Reenvio de Codigo de Verificacion'; </script>";
                echo "<script> vEcod = ".$_GET['ecod']." </script>";
                echo "<script> $('.mostrardiv').load('reenviarcodigo.php'); </script>";
            }elseif(isset($_GET['id'])){
                echo "<script> $('.mostrardiv').load('cambiodepwd.php'); </script>";
            }
        }else{
            echo "<script> $('.mostrardiv').load('enviodelink.php'); </script>";
        }          
    ?>  

</body>
</html>