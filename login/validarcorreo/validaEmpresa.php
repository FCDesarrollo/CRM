
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
$url_activacion = 'http://dublock.com/CRM/login/restablecerpwd/';
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
	if($datos['rfc'] != "" && $datos['correo']!=""){
		EnviarMailEmpresa($datos['correo']);
	}	
	
}

//Envía correo a empresa
function EnviarMailEmpresa($destinatarios){
	$asunto="Registro de empresa";
    $mensaje="Código de Confirmación para el registro de empresa: ";
    $codigo= rand();
	//EnviarSMS($celular,$identificador);
	global $mail;
	//Agregamos a todos los destinatarios
	$mail->addAddress($destinatarios);
	//Añadimos el asunto del mail
	$mail->Subject = $asunto; 

	//Mensaje del email
	$mail->Body    = '<div><b>Correo de confirmación!</b></div><br>'.$mensaje.'<h3>'.$codigo.'</h3>';
	
	//comprobamos si el mail se envio correctamente y devolvemos la respuesta al servidor
	if(!$mail->send()) {
		$return=array(false, $codigo);
    	print_r(json_encode($return));
		return $return;
	} else {
		$return=array(true, $codigo);
    	print_r(json_encode($return));
		return $return;
	} 

}



?>