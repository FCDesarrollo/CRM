
<?php


//Le decimos a PHP que vamos a devolver objetos JSON
//header('Content-type: application/json');

//Importamos la libreria de ActiveRecord y Mailer
//require 'php-activerecord/ActiveRecord.php';
require 'Mailer/PHPMailerAutoload.php';
//require_once __DIR__ . '/config.php';
//require_once __DIR__ . '/../vendor/autoload.php';


//Configuracion de la base de datos
//$usuario_BD = "root";
//$pass_BD = "";
//$host_BD = "localhost";
//$nombre_BD = "dublockc_mcgenerales";
//Configuracion del servidor de correo
//$url_activacion = 'http://localhost/WebConsultorMX/validarcorreo/valida.php';
//$url_activacion = 'http://dublock.com/CRM/login/restablecerpwd/';
$url_activacion = 'http://crm.dublock.com/login/restablecerpwd/';
$url_validacorreo = 'http://crm.dublock.com/login/';
//$url_activacion = 'http://localhost/crm/login/restablecerpwd/';


$mail = new PHPMailer;
$mail->isSMTP();                                      // Activamos SMTP para mailer
//$mail->SMTPDebug = 2;
//$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';                       // Especificamos el host del servidor SMTP
$mail->SMTPAuth = true;                               // Activamos la autenticacion
$mail->Username = 'miconsultormx@gmail.com';       // Correo SMTP
$mail->Password = 'crm@2019';                // Contraseña SMTP
$mail->SMTPSecure = 'tls';                            // Activamos la encriptacion ssl
$mail->Port = 587;                                    // Seleccionamos el puerto del SMTP
$mail->From = 'miconsultormx@gmail.com';
$mail->FromName = 'Mi Consultor MX';                       // Nombre del que envia el correo
$mail->isHTML(true); //Decimos que lo que enviamos es HTML
$mail->CharSet = 'UTF-8';  // Configuramos el charset 

if($_POST){
	$datos = $_POST;
	if(isset($datos['identificador'])){
		CorreoValidacion();
	}else if(isset($datos['rpwd'])){
		RestablecerContraseña();
	}else if(isset($datos['destinatarios'])){
	 	CompartirLinks($datos['destinatarios'], $datos['mensaje']);
	}


	 // if($datos['identificador'] != ""){
	 // 	CorreoValidacion();
	 // }else if($datos['rpwd'] === "1" && $datos['correo'] != ""){
	 // 	RestablecerContraseña();
	 // }else if($datos['destinatarios'] !=""){
	 // 	CompartirLinks($datos['destinatarios'], $datos['mensaje']);
	 // }		
}


//ENVIO DE LINK PARA RESTABLECER CONTRASEÑA
function RestablecerContraseña(){
	$usuario = $_POST;
		
	global $url_activacion;
	//Se guarda en la base de datos y se le envia el correo con el link para activar su cuenta
	try{		
		$destino = $usuario['correo'];
		$idusuario = $usuario['idusuario'];		
		$cliente = $usuario['nombre'] . " " .$usuario['apellidop'];
		$asunto = 'Restablecer Contraseña';	
		$URL = $url_activacion.'?user='.$idusuario.'&rpwd=1';
		
		$mensaje = 'Hola '.$cliente.'.<br> Recibimos una solicitud para restablecer su contraseña.<br>
		<a href="'.$URL.'">Haz click aqui para restablecer tu contraseña.</a>';	
		
		EnviarLink($destino,$asunto,$mensaje);
	}catch(Exception $e){
		//JSON(false,'El correo ya esta registrado');
	}	
}
function EnviarLink($destinatarios,$asunto,$mensaje){

	global $mail;
	//Agregamos a todos los destinatarios
	$mail->addAddress($destinatarios);
	//Añadimos el asunto del mail
	$mail->Subject = $asunto; 
	//Mensaje del email
	$mail->Body    = '<div><b>Mi Consultor MX</b></div><br>'.$mensaje;
	
	//comprobamos si el mail se envio correctamente y devolvemos la respuesta al servidor
	if(!$mail->send()) {
		return false;
	} else {
		return true;
	} 

}

function CompartirLinks($destinatarios, $mensaje){

	global $mail;
	//Agregamos a todos los destinatarios
	//$mail->addAddress($destinatarios);
	$correos = explode(",", $destinatarios);
	$cont = count($correos);	
	for($i=0;$i < $cont; $i++){
		$mail->addAddress($correos[$i]);
	}


	//Añadimos el asunto del mail
	$mail->Subject = "Archivos Compartidos desde MiConsultorMX"; 

	//Mensaje del email
	$mensaje = nl2br($mensaje);
	$mail->Body = '<div><b>¡Archivos Compartidos!</b></div><br>'.$mensaje;
	
	//comprobamos si el mail se envio correctamente y devolvemos la respuesta al servidor
	if(!$mail->send()) {
		return false;
	} else {
		return true;
	} 
}




//ENVIO DEL CODIGO DE VERIFICACION DEL NUEVO USUARIO
function CorreoValidacion(){
	$usuario = $_POST;
		
	global $url_activacion;
	global $url_validacorreo;
	//Se guarda en la base de datos y se le envia el correo con el link para activar su cuenta
	try{		
		$destino = $usuario['correo'];

		$celular = $usuario['cel'];

		$asunto = 'Confirma tu Cuenta';

		$identificador = $usuario['identificador'];
				
		//echo $dato = "<script>ObtenerUsuario($identificador);</script>";
		//echo "<script> iduser = ObtenerUsuario($identificador); </script>";
	
		//$URL = $url_activacion.'?activar=true&id='.$variablephp.'&codigo='.$usuario["identificador"];

		//$mensaje = 'Estimado usuario para poder activar tu cuenta favor de seguir el siguiente link,
		//si no puedes hacer click, favor de copiar y pegarlo en la barra de direcciones de tu navegador.<br><br>
		//<a href="'.$URL.'">'.$URL.'</a>';
		if(isset($usuario['user_perfil'])){
			$URL = $url_validacorreo.'?id='.$usuario["identificador"];
			$mensaje = 'Usted ha sido registrado por un administrador, favor de ingresar a la siguiente direccion para completar su registro. <br><br>Codigo de Verificación: '.$usuario["identificador"].' <br><a href="'.$URL.'">Haz click aqui para completar su registro.</a>';
		}else{
			$mensaje = 'Estimado usuario, su codigo de confirmacion ha sido generado correctamente.<br><br>Codigo de Confirmacion: '.$usuario["identificador"];
		}

		EnviarMail($destino,$asunto,$mensaje,$identificador,$celular);

	

	}catch(Exception $e){
		//JSON(false,'El correo ya esta registrado');
	}
}


function EnviarMail($destinatarios,$asunto,$mensaje,$identificador,$celular){

	//EnviarSMS($celular,$identificador);
	global $mail;
	//Agregamos a todos los destinatarios
	$mail->addAddress($destinatarios);
	//Añadimos el asunto del mail
	$mail->Subject = $asunto; 

	//Mensaje del email
	$mail->Body    = '<div><b>Correo Enviado Exitosamente!</b></div><br><br>'.$mensaje;
	
	//comprobamos si el mail se envio correctamente y devolvemos la respuesta al servidor
	if(!$mail->send()) {
		return false;
	} else {
		return true;
	} 

}


//ENVIO DE SMS ATRAVEZ DE LA PLATAFORMA NEXMO
function EnviarSMS($celular,$identificador){
	
	$basic  = new \Nexmo\Client\Credentials\Basic('6bb7e2b1', 'YLLGfk4FWpmIAPN2');
	$client = new \Nexmo\Client($basic);	

	$message = $client->message()->send([
		'to' => $celular,
		'from' => 'MiConsultorMX',
		'text' => 'Tu Codigo de Verificacion es: ' . $identificador
	]);
}


?>
