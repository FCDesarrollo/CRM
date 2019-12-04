<?php 

session_start();  

	$statusCertificado= true;
	$statusLlave= true;
	$archivoC= true;
	$archivoCS= true;
	
    include("../../addempresa/nombre_carpetas.php");	
    $carStr = new CarpetasStorage($_SESSION["idempresalog"], $_SESSION["idusuario"]);    
	$carStr->Modulos();
	$carStr->Menus();
	$carStr->SubMenus();
    $carStr->Storage();

    $DatosStorage = $carStr->StorageADM();
    $useradm_storage = $_POST['usuario_storage']; // "admindublock";
    $passadm_storage = $_POST['password_storage']; //"4u1B6nyy3W";
    $server_storage = $_POST['servidor_storage']; //"cloud.dublock.com";
	
//	$useradm_storage = trim($_POST["rfc"]);
	$certificado = $_FILES["archivoCer"];    
	$llave = $_FILES["archivoKey"]; 
	$fileCert = $certificado["tmp_name"];
//	$remote_fileCer = '/'.'CRM/'. $useradm_storage.'/'.$certificado["name"];
	$fileKey = $llave["tmp_name"];
//	$remote_fileKey = '/'.'CRM/'.$useradm_storage.'/'.$llave["name"];
	$archivoTxt = $useradm_storage.".txt";
	$pass = $_POST["password"];
	$local_file = $useradm_storage.".txt"; //useradm_storagebre archivo en nuestro PC
//	$server_file = '/'.'CRM/'.$useradm_storage.'/'.$useradm_storage.".txt"; //useradm_storagebre archivo en FTP



$ch = curl_init();

    $gestor = fopen($fileCert, "r");
    $contenido = fread($gestor, filesize($fileCert));
    fclose($gestor);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://'.$server_storage.'/remote.php/dav/files/'.$useradm_storage.'/CRM/'.$useradm_storage.'/'. $certificado["name"],
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => $useradm_storage.':'.$passadm_storage,
            CURLOPT_POSTFIELDS => $contenido,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            )
    );
    curl_exec($ch);

    $gestor2 = fopen($fileKey, "r");
    $contenido2 = fread($gestor2, filesize($fileKey));
    fclose($gestor2);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://'.$server_storage.'/remote.php/dav/files/'.$useradm_storage.'/CRM/'.$useradm_storage.'/'.$llave["name"],
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => $useradm_storage.':'.$passadm_storage,
            CURLOPT_POSTFIELDS => $contenido2,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            )
    );
    curl_exec($ch);

curl_close($ch);

	// Conexión
	$ftp_server = "ftp.dublock.com";
	$conn_id = ftp_connect($ftp_server);

	// login con usuario y contraseña
	$ftp_user_name = "crmadmin@cloud.dublock.com";
	$ftp_user_pass = "4u1B6nyy3W";

	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

	ftp_pasv($conn_id, true);
	if ($login_result===true){
	    $conexion = true;  
	    $pushd = ftp_pwd($conn_id);
	    if ($pushd !== false && @ftp_chdir($conn_id, $useradm_storage)){
	        if(ftp_chdir($conn_id, $pushd) == true){
	            if($certificado["type"] == "application/x-x509-ca-cert" && $llave["type"] == "application/octet-stream"){
	                echo "El directorio" . $useradm_storage ." no existe";
	                $statusCertificado = false;
	                $statusLlave = false;
	            }
	        }           
	    } else{       
	        if(!file_exists($archivoTxt)){                
	            $mensaje = $pass;
	            if($archivo = fopen($archivoTxt, "a")){                            
	                if(fwrite($archivo, $mensaje)){
	                        $archivoC = true;
	                }
	                fclose($archivo);  
	                $gestor2 = fopen($local_file, "r");
	                    $contenido2 = fread($gestor2, filesize($local_file));
	                    fclose($gestor2);
	                    $ch = curl_init();                
	                    curl_setopt_array($ch,
	                        array(
	                            CURLOPT_URL => 'https://'.$server_storage.'/remote.php/dav/files/'.$useradm_storage.'/CRM/'.$useradm_storage.'/'.$archivoTxt,
	                            CURLOPT_VERBOSE => 1,
	                            CURLOPT_USERPWD => $useradm_storage.':'.$passadm_storage,
	                            CURLOPT_POSTFIELDS => $contenido2,
	                            CURLOPT_RETURNTRANSFER => true,
	                            CURLOPT_BINARYTRANSFER => true,
	                            CURLOPT_CUSTOMREQUEST => 'PUT',
	                        )
	                    );
	                    curl_exec($ch);                           
	                    curl_close($ch);
	            }
	        }else {
	            $archivoC = false; 
	        }
	        if (file_exists($archivoTxt)) { 
	            unlink($archivoTxt);
	        }
	   }                    
	}else{
	    $conexion = False;
	}
	ftp_close($conn_id);


	$archivos=array($conexion,$statusCertificado,$statusLlave,$archivoC,$archivoCS);
	print_r(json_encode($archivos));
	return $archivos;    

?>