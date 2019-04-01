<?php
//if( isset($_POST["correo"]) ){ 
	session_start();  

	if(isset($_POST["idempresa"]) && isset($_POST["usuario21"])){
		$_SESSION['idempresalog'] = $_POST["idempresa"];
		$_SESSION['usuario21'] = $_POST['usuario21'];		
	}elseif (isset($_POST["idempresa"])) {
		$_SESSION['idempresalog'] = $_POST["idempresa"];
	}

?>