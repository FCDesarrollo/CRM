<?php  
	Include ("../empuser/permisosuser.php");
	$RFC = $_POST['RFCEmpresa'];
	$datosserver = $_POST['datosserver'];
	$server = $datosserver['server'];
	$user = $datosserver['user_storage'];
	$pass = $datosserver['pwd_storage'];

	if(isset($_POST['modulo'])){
		$modulo = $_POST['modulo'];
		$menu = $_POST['menu'];
		$submenu = $_POST['submenu'];
		
		$idsubmenu = $_POST['idsubmenu'];
		$tipodoc = "COMPROBANTES";
		$sta = 1;
		$sws = "http://apicrm.dublock.com/public/";
		/*$ftp_server = "ftp.dublock.com";
		$conn_id = ftp_connect($ftp_server);
		$sws = "http://apicrm.dublock.com/public/";
		// login con usuario y contraseña
		$ftp_user_name = "crmadmin@cloud.dublock.com";
		$ftp_user_pass = "4u1B6nyy3W";

			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

		ftp_pasv($conn_id, true);
	
		if ($login_result===true){*/
			$datos = array("rfc" => $RFC, "idsubmenu" => $idsubmenu, "tipodocumento" => $tipodoc,"status" => $sta);
			$resultado = CallAPI("POST", $sws ."archivosBitacora", $datos);
			$x=0;
			if(!empty($resultado)){
			
			$documentos = json_decode($resultado, true);
			
			$findme = ".pdf";
			
			foreach($documentos as $value) {
				$tipodoc=$value['tipodocumento'];
				$car = '/pdfs/relacion';
				$complerut = substr(strtoupper($tipodoc),0,3)."/".substr($value['ejercicio'],2,2).
							"/".strtoupper(sprintf("%02d",$value['periodo'])).$car;
							
				//print_r($complerut);
				$link = $RFC."/".$modulo."/".$menu."/".$submenu."/".$complerut."/".$value['nombrearchivoE'].$findme;
				//print_r($link);
				$link = getlink($link, $server, $user, $pass);
				//print_r($link);
				if ($link != "") {
					
					//$fecha=date("d/m/y h:i:s", ftp_mdtm($conn_id, "/CRM/".$RFC.
							//	"/".$modulo."/".$menu."/".$submenu."/".$complerut."/".$value['archivo']));
							$fecha =  substr($value['fechamodificacion'],0,10);	
					$data[$x] = array("nombre" => $value['nombrearchivoE'],"link" => $link,
									"fecha" => $fecha,"agente" => $value['agente'], "servicio" => $value['servicio']);		        
					//print_r($data[$x]);
					$x = $x + 1;
					
				}
			
					
			}
		    /*$archivos = ftp_nlist($conn_id, "/PruebaSincro/".$RFC."/".$modulo."/".$menu."/".$submenu."/".$complerut); //Devuelve un array con los nombres de ficheros

				$lista=array_reverse($archivos); //Invierte orden del array (ordena array)

				//$data = array();

				while ($item=array_pop($lista)) { //Se leen todos los ficheros y directorios del directorio
				
					$pos = strpos($item, $findme);
				
					if($pos == true){
						//$tamano=number_format(((ftp_size($conn_id, "/PruebaSincro/".$RFC."/".$modulo."/".$menu."/".$submenu."/".$item))/1024),2)." Kb";

						$fecha=date("d/m/y h:i:s", ftp_mdtm($conn_id, "/PruebaSincro/".$RFC.
							"/".$modulo."/".$menu."/".$submenu."/".$complerut."/".$item));
						$link = $RFC."/".$modulo."/".$menu."/".$submenu."/".$complerut."/".$item;


						$link = getlink($link);

						$data[$x] = array("nombre" => $value['nombrearchivo'],"link" => $link,"fecha" => $fecha,"agente" => 'ADMINISTRADOR');		        

						$x = $x + 1;	        
					}
					
				}*/
			} 

			if($x == 0){
				$data[0] = array("nombre" => "Vacio","link" => "Vacio","fecha" => "Vacio", "agente" => "vacio");			
			}

			//ftp_close($conn_id);

		    $conexion = true;
		/*}else{
		    $conexion = False;
		    $data[0] = array("nombre" => "Vacio","link" => "Vacio","fecha" => "Vacio","agente" => "vacio");
		}*/


		echo json_encode($data);
	}else if(isset($_POST['archivos'])){
		//$rfc = $_POST['RFCEmpresa'];
		/*$datosserver = $_POST['datosserver'];
		$server = $datosserver['server'];
		$user = $datosserver['user_storage'];
		$pass = $datosserver['pwd_storage'];*/
		for ($i=0; $i < count($_POST['archivos']); $i++) { 
			$item = $_POST['archivos'][$i]['documento'];			
			$link = $RFC."/Entrada/AlmacenDigital/ExpedientesDigitales/".$item;
			$link = getlink($link, $server, $user, $pass);		
			$array[$i] = array("id" => $_POST['archivos'][$i]['id'], "documento" => $item, "estatus" => $_POST['archivos'][$i]['estatus'], "fechaprocesado" => $_POST['archivos'][$i]['fechaprocesado'], "link" => $link);
		}
		echo json_encode($array);
		//print_r($array);
		//return $array;
	}



	function getlink($link, $server, $user, $pass){
		   $ch = curl_init();

		   	curl_setopt($ch, CURLOPT_URL, "https://".$user.":".$pass."@".$server."/ocs/v2.php/apps/files_sharing/api/v1/shares");
		   	curl_setopt($ch, CURLOPT_VERBOSE, 1);
		   
		   	curl_setopt($ch, CURLOPT_USERPWD, "".$user.":".$pass."");
		  	// $contenido = "path=CRM/EmpresaNueva/BDDADMW.pdf&shareType=3"
		   	curl_setopt($ch, CURLOPT_POSTFIELDS, "path=CRM/".$link."&shareType=3");

		   	curl_setopt($ch, CURLOPT_HTTPHEADER, array('OCS-APIRequest:true'));
		   	curl_setopt($ch, CURLOPT_HEADER, true);
		   	// Max timeout in seconds to complete http request  
		   	//curl_setopt($ch, CURLOPT_TIMEOUT, 60);

		   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);


		    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

		   	// Set the request as a POST FIELD for curl.
		   	//curl_setopt($ch, CURLOPT_POSTFIELDS, $COMANDO);
		   	// Get response from the server.
		   	$httpResponse = curl_exec($ch);

		    $httpResponse = explode("\n\r\n", $httpResponse);

		    $body = $httpResponse[1];
		  
		   	$Respuesta= simplexml_load_string($body);
		   	//print_r((string)$Respuesta[0]->data->url);
		   	
		   	$url = ((string)$Respuesta[0]->data->url);
		   	curl_close($ch);

		   	return $url;

	}

?>