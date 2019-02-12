<?php
//if( isset($_POST["correo"]) ){ 
session_start();    
   
    $_SESSION['usuario21'] = $_POST["correo"];
    $_SESSION['idusuario'] = $_POST["idusuario"];
    $_SESSION['tipo'] = $_POST["tipo"];    
    $_SESSION['idempresalog'] = $_POST["idempresa"];
    
    if($_SESSION['idempresalog'] != 0){
        $IdEm = isset($_GET['em']) ? $_GET['em'] : 0 ;
      header("Location: DashEmpresa/gestordearchivos/visorpdf.php?em=$IdEm'&nar=ResultadosDiarios310119.pdf"); 
    }

    if($_POST["tipo"] == 4){
        echo "<script> 
        window.location='AdminBoost/admin.php' </script>";
    }else if($_POST["tipo"] == 2){
        echo "<script> window.location='AdminBoost/message.html' </script>";
      // echo "<script>
     //       window.location='form.php'
       // </script>";
    }else if($_POST["tipo"] == 1){
        echo "<script> window.location='usuario.php' </script>";
       // echo "<script> window.location='form.php' </script>";
    }else if($_POST["tipo"] == 3){
        echo "<script> window.location='usuario.php' </script>";
    }else{
        //echo "<script> alert('confirmar su cuenta'); </script>";
    }
      

/*session_start();
//variables precargadas
$usuario	= "admin";
$clave		= "admin";
//recibiendo valores de index.phh
$login		= $_POST["login"];
$passwd		= $_POST["passwd"];
if (($usuario==$login) && ($clave==$passwd)) {
	$_session["usuario"]=$usuario;
	echo "<script> window.location='home.php'
	</script>";	
}
else{
	echo "<script> alert('Datos Invalidos');
		window.location='index.php'
	</script>";
}*/
?>