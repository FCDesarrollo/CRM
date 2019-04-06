<?php 
	
	//$RFC = $_POST['RFCEmpresa'];
	//$SubMenu = $_POST['SubMenu'];
	
			
	// $Archivo = $_POST['ArchivoPDF'];
	// $url = $_POST['ruta'].$Archivo;
	

	// //$url ="../../nextclouddata/admindublock/files/PruebaSincro/EmpresaNueva/Contabilidad/Contabilidad/ContabilidadElectronica/PDFNUEVO.pdf";
 //     $content = file_get_contents($url);

 //     header('Content-Type: application/pdf');
 //     header('Content-Length: ' . strlen($content));
 //     header('Content-Disposition: inline; filename="PDFNUEVO.pdf"');
 //     header('Cache-Control: private, max-age=0, must-revalidate');
 //     header('Pragma: public');
 //     ini_set('zlib.output_compression','0');
     
 //     return $content;

 //     die($content);


//ABRIR ARCHIVO PDF
	//$mi_pdf = fopen("ftp://allcrm@crm.dublock.com:4u1B6nyy3W@ftp.dublock.com/nextclouddata/admindublock/files/PruebaSincro/EmpresaNueva/Contabilidad/Contabilidad/ContabilidadElectronica/PDFNUEVO.pdf", "r");
    //if (!$mi_pdf) {
    //    echo "<p>No puedo abrir el archivo para lectura</p>";
    //    exit;
    //}else{
    //	echo "<p>Lo Encontro</p>";
    //}
    //header('Content-type: application/pdf');
  
        
    //fpassthru($mi_pdf); // Esto hace la magia
    //fclose ($mi_pdf);




//OBTENER LINK PARA COMPARTIR METODO CURL

   /*$nombre_fichero = "C:\Users\Arturo Gallegos\Desktop\Servidor\BDDADMW.pdf";
   $gestor = fopen($nombre_fichero, "r");
   $contenido = fread($gestor, filesize($nombre_fichero));
   fclose($gestor);*/
  
   $link = $_POST['url'].$_POST['archivopdf'];
   $ch = curl_init();
   //COMPARTIR ARCHIVO
   //curl -k -X POST -H "OCS-APIRequest:true" "https://admindublock:4u1B6nyy3W@cloud.dublock.com/ocs/v2.php/apps/files_sharing/api/v1/shares" --data "path=PruebaSincro/EmpresaNueva/BDDADMW.pdf&shareType=3"
   
   //SUBIR ARCHIVO
   //curl -u admindublock:4u1B6nyy3W -X PUT -d 'holaaaa' "https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/pru.txt"
   curl_setopt($ch, CURLOPT_URL, "https://admindublock:4u1B6nyy3W@cloud.dublock.com/ocs/v2.php/apps/files_sharing/api/v1/shares");
   curl_setopt($ch, CURLOPT_VERBOSE, 1);
   
   curl_setopt($ch, CURLOPT_USERPWD, "admindublock:4u1B6nyy3W");
  // $contenido = "path=PruebaSincro/EmpresaNueva/BDDADMW.pdf&shareType=3"
   curl_setopt($ch, CURLOPT_POSTFIELDS, "path=PruebaSincro/".$link."&shareType=3");
   //curl_setopt($ch, CURLOPT_POSTFIELDS, "path=PruebaSincro/ResultadosDiarios310119.pdf&shareType=3");


   //curl_setopt($ch, CURLOPT_POSTFIELDS, "admindublock:4u1B6nyy3W");
   
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('OCS-APIRequest:true'));
   curl_setopt($ch, CURLOPT_HEADER, true);
   // Max timeout in seconds to complete http request  
   //curl_setopt($ch, CURLOPT_TIMEOUT, 60);

   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
   //curl_setopt($ch, CURLOPT_POST, 1);

    //$COMANDO='admindublock:4u1B6nyy3W "remote.php/dav/files/admindublock/PruebaSincro/CarpetaCurl';

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

   // Set the request as a POST FIELD for curl.
   //curl_setopt($ch, CURLOPT_POSTFIELDS, $COMANDO);

   // Get response from the server.
   $httpResponse = curl_exec($ch);

   /*$oXML = new SimpleXMLElement($httpResponse);

    foreach($oXML->entry as $oEntry){
        echo $oEntry->title . "\n";
    }*/
    $httpResponse = explode("\n\r\n", $httpResponse);

    $body = $httpResponse[1];
   //var_dump(html_entity_decode($httpResponse));
   	$Respuesta= simplexml_load_string($body);
   	//print_r((string)$Respuesta[0]->data->url);
   	
   	$url = ((string)$Respuesta[0]->data->url);
   	return = $url;


    //foreach($Respuesta as $key => $val){
    //    if($val->url != ""){
            //print_r((string)$val->url);
    //    }
        
    //}
   //print_r($Respuesta[0]->[0]);
  
   curl_close($ch);
   //echo "Terminado";

?>
