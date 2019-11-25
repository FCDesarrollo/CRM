<?php
	$nom = $_POST["rfc"];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://cloud.dublock.com/remote.php/dav/files/admindublock/CRM/'. $nom );
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_USERPWD, 'admindublock:4u1B6nyy3W');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
	$httpResponse = curl_exec($ch);
	curl_close($ch);

	return $nom;

?>