<?php
	include("nombre_carpetas.php");
	//$carStr = new CarpetasStorage($_SESSION["idempresalog"], $_SESSION["idusuario"]);
	$idempresa = 1;
	$idusuario = 2;
	$carStr = new CarpetasStorage($idempresa, $idusuario);
    $carStr->Storage();
    $DatosStorage = $carStr->StorageADM();

    $useradm_storage = $DatosStorage[0]['usuario_storage'];
    $passadm_storage = $DatosStorage[0]['password_storage'];
    $server_storage = $DatosStorage[0]['servidor_storage'];    

	$nom = $_POST["rfc"];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://'.$server_storage.'/remote.php/dav/files/'.$useradm_storage.'/CRM/'. $nom );
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_USERPWD, $useradm_storage.':'.$passadm_storage);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
	$httpResponse = curl_exec($ch);
	curl_close($ch);

	return $nom;

?>