<?php
  header('Content-Type: application/json');

  $Server = "cloud.dublock.com/nextcloud";
  $RFC = "REV110524MF3";
  $User = "REV110524MF3";
  $Pass = "4u1B6nyy3W";
  
  ini_set('max_input_vars', 3000);

  if(isset($_POST["datos"])){
    
    $contadorArreglo = 0;
    $archivosArray = array();  

    $datos = $_POST["datos"];
    for ($i=0; $i < count($datos); $i++) { 
    //for ($i=0; $i < 5; $i++) {         
        //if($datos[$i]["download"] == null){

          $codigo = $datos[$i]["codigodocumento"];
          $documento = $datos[$i]["documento"];
          $type = explode(".", $documento);
          $target_path = $RFC.'/Entrada/AlmacenDigitalOperaciones/Pagos/'.$codigo.'.'.$type[1];
          $link = getlink($target_path, $Server, $User, $Pass);  

          //$datos[$i]["link"] = $link;

          $archivosArray[$contadorArreglo] =  array(
              "idalmacen" => $datos[$i]["idalmdigital"],
              "idarchivo" => $datos[$i]["id"],
              "link" => $link
          );    

          $contadorArreglo = $contadorArreglo + 1;
        //}

    } 



    echo json_encode($archivosArray);
    return json_encode($archivosArray);
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
