
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
//$mail->Host = 'mail.dublock.com';                       // Especificamos el host del servidor SMTP
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;                               // Activamos la autenticacion
$mail->Username = 'miconsultormx@gmail.com';       // Correo SMTP
$mail->Password = 'crm@2020';                // Contraseña SMTP.
//$mail->Username = 'crm@dublock.com';       // Correo SMTP
//$mail->Password = 'dublock2020';                // Contraseña SMTP
$mail->SMTPSecure = 'tls';                            // Activamos la encriptacion ssl
$mail->Port = 587;                                    // Seleccionamos el puerto del SMTP
$mail->From = 'miconsultormx@gmail.com';
$mail->FromName = 'Mi Consultor MX';                       // Nombre del que envia el correo
$mail->isHTML(true); //Decimos que lo que enviamos es HTML
$mail->CharSet = 'UTF-8';  // Configuramos el charset 

if($_POST){
	$datos = $_POST;
	if(isset($datos['identificador'])){
		$resp = CorreoValidacion();
	}else if(isset($datos['rpwd'])){
		$resp = RestablecerContraseña();
	}else if(isset($datos['destinatarios'])){
	 	$resp = CompartirLinks($datos['destinatarios'], $datos['mensaje']);
	}else if(isset($datos['vinculacion'])){
		$resp =  CorreoVinculacion($datos['usuario'], $datos['empresa'], $datos['correo']);
	}

	$resp = json_encode($resp, JSON_UNESCAPED_UNICODE);
	print_r($resp);
	return $resp;
}

//CORREO DE NOTIFICACION PARA LA EMPRESA, CUANDO SE VINCULA UN USUARIO NUEVO
function CorreoVinculacion($usuario, $empresa, $correo){
	$asunto = 'Nuevo Usuario Vinculado';
	$mensaje = '<b>Usuario vinculado correctamente.</b><br><br>
				Datos del registro:<br>
				<b>Usuario: </b>'.$usuario.'.<br>
				<b>Empresa: </b>'.$empresa.'.';	
	
	$resp = EnviarLink($correo,$asunto,$mensaje);

	return $resp;
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
		
		$resp = EnviarLink($destino,$asunto,$mensaje);

		return $resp;
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
		$array = [1, $mail->ErrorInfo];
		return $array;
	}else{ 
		$array = [0, 'Mensaje Enviado Correctamente'];
		return $array;
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
		$array = [1, $mail->ErrorInfo];
		return $array;
	}else{ 
		$array = [0, 'Mensaje Enviado Correctamente'];
		return $array;
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

		//$celular = $usuario['cel'];

		$asunto = 'Confirma tu Cuenta';

		$identificador = $usuario['identificador'];
				
		if(isset($usuario['user_perfil'])){
			if(isset($usuario['nombre_empresa'])){
				$mensaje = 'Usted ha sido vinculado a la empresa '.$usuario['nombre_empresa'].' por un Administrador.';
			}else{
				$URL = $url_validacorreo.'?id='.$usuario["identificador"];
				$mensaje = 'Usted ha sido registrado por un administrador, favor de ingresar a la siguiente direccion para completar su registro. <br><br>Codigo de Verificación: '.$usuario["identificador"].' <br><a href="'.$URL.'">Haz click aqui para completar su registro.</a>';
			}
		}else{
			$mensaje = 'Estimado usuario, su codigo de confirmacion ha sido generado correctamente.<br><br>Codigo de Confirmacion: '.$usuario["identificador"];
		}

		$resp = EnviarMail($destino,$asunto,$mensaje,$identificador);

		return $resp;

	}catch(Exception $e){
		//JSON(false,'El correo ya esta registrado');
	}
}


function EnviarMail($destinatarios,$asunto,$mensaje,$identificador){

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
		$array = [1, $mail->ErrorInfo];
		return $array;
	}else{ 
		$array = [0, 'Mensaje Enviado Correctamente'];
		return $array;
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
