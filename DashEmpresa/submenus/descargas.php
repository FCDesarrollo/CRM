<?php
  header('Content-Type: application/json');
  //$directorio = $empresa.'/Entrada/'.$menu.'/'.$submenu;
  //$directorio = 'CDU071213N20/Entrada/AlmacenDigitalOperaciones/Pagos';
  //$target_path = 'CDU071213N20/Entrada/AlmacenDigitalOperaciones/Pagos/'.$filename.".".$type[1];
  //$target_path = "CDU071213N20/Entrada/AlmacenDigitalOperaciones/Pagos/CDU071213N20_1911_PAG_0001.pdf";
  
  if(isset($_POST["datos"])){
    
    $contadorArreglo = 0;
    $archivosArray = array();  

    $datos = $_POST["datos"];
    for ($i=0; $i < count($datos); $i++) { 
        if($datos[$i]["download"] == null){

          $codigo = $datos[$i]["codigodocumento"];
          $documento = $datos[$i]["documento"];
          $type = explode(".", $documento);
          $target_path = 'REV110524MF3/Entrada/AlmacenDigitalOperaciones/Pagos/'.$codigo.'.'.$type[1];
          $link = getlink($target_path, "cloud.dublock.com", "admindublock", "4u1B6nyy3W");  

          //$datos[$i]["link"] = $link;

          $archivosArray[$contadorArreglo] =  array(
              "idalmacen" => $datos[$i]["idalmdigital"],
              "idarchivo" => $datos[$i]["id"],
              "link" => $link
          );    

          $contadorArreglo = $contadorArreglo + 1;
        }

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
   
   // if($_POST){
   //    $datos = $_POST;
   //    if(isset($datos['url'])){
   //       $url = $datos['url'];
   //       $archivo = $datos['nombre'];   
   //       DescargarPDFs($url, $archivo);
   //    }else{
   //       echo json_encode(false, JSON_FORCE_OBJECT);
   //    }
   // }

   // function DescargarPDFs($url, $archivo){
   //    //$url = 'https://cloud.dublock.com/index.php/s/zFP5CA5aiLLRkop';
   //    $source = file_get_contents($url);
      
   //    $resultado = file_put_contents('../submenus/temporales/'.$archivo.'.pdf', $source);


   //    // header('Content-Description: File Transfer');
   //    // header('Content-Type: application/pdf');
   //    // header('Content-Disposition: attachment; filename='.$archivo);
   //    // header('Content-Transfer-Encoding: binary');
   //    // header('Expires: 0');
   //    // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
   //    // header('Pragma: public');
   //    // $source = file_get_contents($url);
   //    // file_put_contents('../submenus/temporales/'.$archivo.'.pdf', $source);


      
   //    echo json_encode($source, JSON_FORCE_OBJECT);
   // }





    
  //  // Set the curl parameters.
  //  $ch = curl_init();
  // // GET remote.php/dav/files/user/path/to/file
  //  curl_setopt($ch, CURLOPT_URL, "https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/FCC080410C38/Contabilidad/BDDADMW.pdf");

  //  curl_setopt($ch, CURLOPT_VERBOSE, 1);
   
  //  curl_setopt($ch, CURLOPT_USERPWD, "admindublock:4u1B6nyy3W");

  //  //curl_setopt($ch, CURLOPT_POSTFIELDS, "admindublock:4u1B6nyy3W");
   
  //  //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded; charset=UTF-8'));
  //  //curl_setopt($ch, CURLOPT_HEADER, false);
  //  // Max timeout in seconds to complete http request  
  //  //curl_setopt($ch, CURLOPT_TIMEOUT, 60);

  //  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
  //  //curl_setopt($ch, CURLOPT_POST, 1);

  //   //$COMANDO='admindublock:4u1B6nyy3W "remote.php/dav/files/admindublock/PruebaSincro/CarpetaCurl';

  //   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

  //  // Set the request as a POST FIELD for curl.
  //  //curl_setopt($ch, CURLOPT_POSTFIELDS, $COMANDO);

  //  // Get response from the server.
  //  $httpResponse = curl_exec($ch);

  //  $fh = fopen('C:\Users\117875\Downloads\BDDADMW1.pdf', 'w');
  //  $string = $httpResponse;
  //  $write = fputs($fh, $string);
  //  //fwrite($fh, $httpResponse);
  //  fclose($fh);
  //  
   
  //  //var_dump(curl_getinfo($ch, CURLINFO_HTTP_CODE) );

  //  curl_close($ch);
  //  echo "Terminado";
  

?>
