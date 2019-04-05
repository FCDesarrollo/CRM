<?php  

	// $ch = curl_init();
	// curl_setopt($ch, CURLOPT_URL, 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/EmpresaNueva');
	// curl_setopt($ch, CURLOPT_VERBOSE, 1);
	// curl_setopt($ch, CURLOPT_USERPWD, 'admindublock:4u1B6nyy3W');
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PROPFIND');
	// $httpResponse = curl_exec($ch);
	// var_dump($httpResponse);
	// //var_dump(curl_getinfo($ch, CURLINFO_HTTP_CODE) );
	// curl_close($ch);

	
	$RFC = $_POST['RFCEmpresa'];
	$modulo = $_POST['modulo'];
	$menu = $_POST['menu'];
	$submenu = $_POST['submenu'];

	$ftp_server = "ftp.dublock.com";
	$conn_id = ftp_connect($ftp_server);

	// login con usuario y contraseña
	$ftp_user_name = "crmadmin@cloud.dublock.com";
	$ftp_user_pass = "4u1B6nyy3W";

	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

	ftp_pasv($conn_id, true);

	if ($login_result===true){

	    $archivos = ftp_nlist($conn_id, "/PruebaSincro/".$RFC."/".$modulo."/".$menu."/".$submenu); //Devuelve un array con los nombres de ficheros

		$lista=array_reverse($archivos); //Invierte orden del array (ordena array)

		//$data = array();

		$x=0;

		$findme = ".pdf";
		
		while ($item=array_pop($lista)) { //Se leen todos los ficheros y directorios del directorio
		
			$pos = strpos($item, $findme);
		
			if($pos == true){
				$tamano=number_format(((ftp_size($conn_id, "/PruebaSincro/".$RFC."/".$modulo."/".$menu."/".$submenu."/".$item))/1024),2)." Kb";

				$fecha=date("d/m/y h:i:s", ftp_mdtm($conn_id, "/PruebaSincro/".$RFC."/".$modulo."/".$menu."/".$submenu."/".$item));
				
		        //$data = array("nombre" => $item,"tamano" => $tamano,"fecha" => $fecha);
		        //array_push($data[$x], $item, $tamano, $fecha);




		        $data[$x] = array("nombre" => $item,"tamano" => $tamano,"fecha" => $fecha);		        

		        $x = $x + 1;	        
			}
	        

		}

		if($x == 0){
			$data[0] = array("nombre" => "Vacio","tamano" => "Vacio","fecha" => "Vacio");			
		}
	 	//foreach($data as $t){    	

		//	print_r($t['nombre']);    	   	
	 	//}

	    $conexion = true;
	}else{
	    $conexion = False;
	    $data[0] = array("nombre" => "Vacio","tamano" => "Vacio","fecha" => "Vacio");
	}

	ftp_close($conn_id);

	print_r(json_encode($data));
	return json_encode($data);

?>