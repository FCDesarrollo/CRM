<?php
session_start();    
    if (isset($_POST["idempresalog"])) {
        $_SESSION['idempresalog'] = $_POST["idempresalog"];
        $_SESSION['RFCEmpresa'] = $_POST["rfcempresa"];
        $_SESSION['idperfil'] = $_POST["idperfil"];
    }else{
        $_SESSION['idempresalog'] = 0;
        echo "<script> window.location='../../usuario.php' </script>";
        //exit();         
    }




?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bracket Plus">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://bracketplus.themepixels.me/img/bracketplus-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://bracketplus.themepixels.me">
    <meta property="og:title" content="Bracket Plus">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://bracketplus.themepixels.me/img/bracketplus-social.png">
    <meta property="og:image:secure_url" content="http://bracketplus.themepixels.me/img/bracketplus-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>CRM</title>

  </head>
  <body>
    <script>
    // similar behavior as an HTTP redirect
    //window.location.replace("app/index.html");
    window.location.replace("empuser/");
    </script>
  </body>
</html>
