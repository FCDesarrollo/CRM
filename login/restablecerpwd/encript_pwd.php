<?php
	if(isset($_POST)){
		$dato = $_POST;		
		if(password_verify($_POST["pwd"], $_POST["pwd_user"])){
			$respuesta = true;
		}else{
			$respuesta = false;
		}
		//$passwd = password_hash($_POST["pwd"], PASSWORD_BCRYPT);
		print_r($respuesta);
	}
?>