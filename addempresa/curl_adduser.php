<?php
	// $ch = curl_init();
	// $user ="admindublock";
	// $pass ="4u1B6nyy3W";
	// $server ="cloud.dublock.com";
 //    $userName = "FCC080410C38";
 //    $password = "despacho144B$";
 //    $DatosUser = array("userid" => $userName, "password" => $password);
 //    curl_setopt($ch, CURLOPT_URL, "https://".$user.":".$pass."@".$server."/ocs/v1.php/cloud/users");
 //    //curl_setopt($ch, CURLOPT_URL, "https://".$user.":".$pass."@".$server."/ocs/v2.php/apps/files_sharing/api/v1/shares");
 //    curl_setopt($ch, CURLOPT_POST, 1);
 //    curl_setopt($ch, CURLOPT_POSTFIELDS, $DatosUser);
 //    curl_setopt($ch, CURLOPT_HTTPHEADER, array('OCS-APIRequest:true'));
 //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 //    $response = curl_exec($ch);
	// curl_close($ch);    

 //    $ch = curl_init();
 //    curl_setopt_array($ch,
 //        array(
 //            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/'.$userName.'/CRM',
 //            CURLOPT_VERBOSE => 1,
 //            CURLOPT_USERPWD => $userName.':'.$password,
 //            CURLOPT_RETURNTRANSFER => true,
 //            CURLOPT_CUSTOMREQUEST => 'MKCOL',
 //        )
 //    );
 //    $response2 = curl_exec($ch);	

 //    curl_close($ch);

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
	
	$nom = "FCC080410C38";
	// $certificado = $_FILES["archivoCer"];    
	// $llave = $_FILES["archivoKey"]; 
	// $fileCert = $certificado["tmp_name"];
	// $remote_fileCer = '/'.'CRM/'. $nom.'/'.$certificado["name"];
	// $fileKey = $llave["tmp_name"];
	// $remote_fileKey = '/'.'CRM/'.$nom.'/'.$llave["name"];
	// $archivoTxt = $nom.".txt";
	$pass = "despacho144B$";
//	$local_file = $nom.".txt"; //Nombre archivo en nuestro PC
//	$server_file = '/'.'CRM/'.$nom.'/'.$nom.".txt"; //Nombre archivo en FTP

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
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/'.$userName.'/CRM',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => $userName.':'.$password,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch); 

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/'.$userName.'/CRM/'. $nom,
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => $userName.':'.$password,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);	


?>