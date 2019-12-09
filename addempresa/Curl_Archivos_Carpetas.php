<?php

	include("nombre_carpetas.php");
	//$carStr = new CarpetasStorage($_SESSION["idempresalog"], $_SESSION["idusuario"]);
	$idempresa = 40;
	$idusuario = 2;
	$carStr = new CarpetasStorage($idempresa, $idusuario);
	$carStr->Modulos();
	$carStr->Menus();
	$carStr->SubMenus();
    $carStr->Storage();

    $DatosStorage = $carStr->StorageADM();
	
	$nom = trim($_POST["rfc"]);
	$certificado = $_FILES["archivoCer"];    
	$llave = $_FILES["archivoKey"]; 
	$fileCert = $certificado["tmp_name"];
	$remote_fileCer = '/'.'CRM/'. $nom.'/'.$certificado["name"];
	$fileKey = $llave["tmp_name"];
	$remote_fileKey = '/'.'CRM/'.$nom.'/'.$llave["name"];
	$archivoTxt = $nom.".txt";
	$pass = $_POST["password"];
	$local_file = $nom.".txt"; //Nombre archivo en nuestro PC
	$server_file = '/CRM/'.$nom.'/'.$nom.".txt"; //Nombre archivo en FTP

    $useradm_storage = $DatosStorage[0]['usuario_storage']; // "admindublock";
    $passadm_storage = $DatosStorage[0]['password_storage']; //"4u1B6nyy3W";
    $server_storage = $DatosStorage[0]['servidor_storage']; //"cloud.dublock.com";
    
    $ch = curl_init();
        $userName = $nom;
        $password = $pass;
        $DatosUser = array("userid" => $userName, "password" => $password);
        curl_setopt($ch, CURLOPT_URL, "https://".$useradm_storage.":".$passadm_storage."@".$server_storage."/ocs/v1.php/cloud/users");
        //curl_setopt($ch, CURLOPT_URL, "https://".$user.":".$pass."@".$server."/ocs/v2.php/apps/files_sharing/api/v1/shares");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $DatosUser);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('OCS-APIRequest:true'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
    curl_close($ch);    


	$ch = curl_init();
    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://'.$server_storage.'/remote.php/dav/files/'.$userName.'/CRM',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => $userName.':'.$password,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch); 

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://'.$server_storage.'/remote.php/dav/files/'.$userName.'/CRM/'. $nom,
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => $userName.':'.$password,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);	

    $Modulos = $carStr->Mod_Nombre();
    $Menus = $carStr->Men_Nombre();
    $SubMenus = $carStr->Sub_Nombre();
    for ($i=0; $i < count($Modulos); $i++) { 

	    curl_setopt_array($ch,
	        array(
	            CURLOPT_URL => 'https://'.$server_storage.'/remote.php/dav/files/'.$userName.'/CRM/'. $nom .'/'. $Modulos[$i]['nombre_carpeta'],
	            CURLOPT_VERBOSE => 1,
	            CURLOPT_USERPWD => $userName.':'.$password,
	            CURLOPT_RETURNTRANSFER => true,
	            CURLOPT_CUSTOMREQUEST => 'MKCOL',
	        )
	    );
	    curl_exec($ch);    	

	    for ($j=0; $j < count($Menus); $j++) { 
	    	if($Modulos[$i]['idmodulo'] == $Menus[$j]['idmodulo'] && $Menus[$j]['nombre_carpeta'] != ""){
			    curl_setopt_array($ch,
			        array(
			            CURLOPT_URL => 'https://'.$server_storage.'/remote.php/dav/files/'.$userName.'/CRM/'. $nom .'/'. $Modulos[$i]['nombre_carpeta'] .'/'. $Menus[$j]['nombre_carpeta'],
			            CURLOPT_VERBOSE => 1,
			            CURLOPT_USERPWD => $userName.':'.$password,
			            CURLOPT_RETURNTRANSFER => true,
			            CURLOPT_CUSTOMREQUEST => 'MKCOL',
			        )
			    );
			    curl_exec($ch);

			    for ($k=0; $k < count($SubMenus); $k++) { 
			    	if($Menus[$j]['idmenu'] == $SubMenus[$k]['idmenu'] && $SubMenus[$k]['nombre_carpeta'] != ""){
			    		
					    curl_setopt_array($ch,
					        array(
					            CURLOPT_URL => 'https://'.$server_storage.'/remote.php/dav/files/'.$userName.'/CRM/'. $nom .'/'. $Modulos[$i]['nombre_carpeta'] .'/'. $Menus[$j]['nombre_carpeta'] .'/'. $SubMenus[$k]['nombre_carpeta'],
					            CURLOPT_VERBOSE => 1,
					            CURLOPT_USERPWD => $userName.':'.$password,
					            CURLOPT_RETURNTRANSFER => true,
					            CURLOPT_CUSTOMREQUEST => 'MKCOL',
					        )
					    );
					    curl_exec($ch);
			    	}
			    } 

	    	}
	    }

    }    


    $gestor = fopen($fileCert, "r");
    $contenido = fread($gestor, filesize($fileCert));
    fclose($gestor);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://'.$server_storage.'/remote.php/dav/files/'.$userName.'/CRM/'. $nom .'/'. $certificado["name"],
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => $userName.':'.$password,
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
            CURLOPT_URL => 'https://'.$server_storage.'/remote.php/dav/files/'.$userName.'/CRM/'. $nom .'/'. $llave["name"],
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => $userName.':'.$password,
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
    if ($pushd !== false && @ftp_chdir($conn_id, $nom)){
        if(ftp_chdir($conn_id, $pushd) == true){
            if($certificado["type"] == "application/x-x509-ca-cert" && $llave["type"] == "application/octet-stream"){
                echo "El directorio" . $nom ." no existe";
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
                            CURLOPT_URL => 'https://'.$server_storage.'/remote.php/dav/files/'.$userName.'/CRM/'. $nom .'/'. $archivoTxt,
                            CURLOPT_VERBOSE => 1,
                            CURLOPT_USERPWD => $userName.':'.$password,
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

$statusCertificado= true;
$statusLlave= true;
$archivoC= true;
$archivoCS= true;
$archivos=array($conexion,$statusCertificado,$statusLlave,$archivoC,$archivoCS);
print_r(json_encode($archivos));
return $archivos;


?>