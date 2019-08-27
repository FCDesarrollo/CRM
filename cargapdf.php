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
 
   //$link = $_POST['url'].$_POST['archivopdf'];
   // $ch = curl_init();

   // curl_setopt($ch, CURLOPT_URL, "https://admindublock:4u1B6nyy3W@cloud.dublock.com/ocs/v2.php/apps/files_sharing/api/v1/shares");
   // curl_setopt($ch, CURLOPT_VERBOSE, 1);
   
   // curl_setopt($ch, CURLOPT_USERPWD, "admindublock:4u1B6nyy3W");
  
   // curl_setopt($ch, CURLOPT_POSTFIELDS, "path=PruebaSincro/".$link."&shareType=3");
   
   // curl_setopt($ch, CURLOPT_HTTPHEADER, array('OCS-APIRequest:true'));
   // curl_setopt($ch, CURLOPT_HEADER, true);


   // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   // curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

   // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

   // $httpResponse = curl_exec($ch);

   // $httpResponse = explode("\n\r\n", $httpResponse);

   // $body = $httpResponse[1];
   
   // $Respuesta= simplexml_load_string($body);
   	
   	
   // $url = ((string)$Respuesta[0]->data->url);
   // return = $url;

   // curl_close($ch);

?>
