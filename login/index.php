
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<?php include("../varglobales.php"); ?>
	<?php include("registro.php"); ?>
	<div class="limiter">
		<div class="container-login100">
			<!--<div class="wrap-login100" id="recargable">-->
			<div id="recargable">
				<!--<form id="FormLogin" class="login100-form validate-form" action="../session.php" method="post">-->
				<form id="FormLogin" class="validate-form" action="../session.php" method="post">
					<input type="hidden" name="tipo" id="txttipo" />
					<input type="hidden" name="idusuario" id="txtIdCliente" />
					<input type="hidden" name="idempresa" id="txtIdEmpresa" value="<?php echo isset($_GET['em']) ? $_GET['em'] : 0 ?>"/>				
					<input type="hidden" name="namear" id="txtnamear" value="<?php echo isset($_GET['nar']) ? $_GET['nar'] : "" ?>"/>
					<span class="login100-form-title p-b-34">Cuenta de Ingreso</span>
					
					<!--<div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Introduzca su correo">-->
					<div class="wrap-input100 wd-100 validate-input m-b-20" data-validate="Introduzca su correo">
						<input id="txtUsuario" class="input100" type="text" name="correo" placeholder="Correo Electronico">
						<span class="focus-input100"></span>
					</div>
					<!--<div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Introduzca su contraseña">-->
					<div class="wrap-input100 wd-100 validate-input m-b-20" data-validate="Introduzca su contraseña">	
						<input class="input100" id="txtContra" type="password" name="contra" placeholder="Contraseña">
						<span class="focus-input100"></span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="button" class="login100-form-btn" onclick="Login();">Iniciar</button>
					</div>

					<div class="w-full text-center p-t-27 p-b-239">
						<a href="#RegistroModal" id="registro" data-toggle="modal" class="txt3">Registrate</a>	
						<span class="txt1"> / </span><a href="restablecerpwd/" class="txt2">Olvidaste tu Contraseña?</a>						
					</div>
 						
				</form>

				<div class="login100-more d-none" style="background-image: url('images/bg-01.jpg');"></div>
			</div>
		</div>
	
	</div>

	

	<div id="dropDownSelect1"></div>
<!--===============================================================================================-->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="js/usuarios.js" type="text/javascript"></script> 
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

	<script src="../js/crearusuario.js"></script>	

	<script src="../DashEmpresa/class/usuario.js"></script>
</body>

</html>

<script>
	$(document).keypress(function (e) {
	    if (e.which == 13) {
	        Login();
	    }
	});	

	var ident = "";
	var mailglobal = "";


</script>

<?php

	session_destroy();
	if(isset($_GET['id'])){
		echo "<script>";
		echo "ident = ".$_GET['id'].";";
		echo "ValidaLink();";
		echo "</script>";
	}
?>