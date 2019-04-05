<?php 
	
	//$RFC = $_POST['RFCEmpresa'];
	//$SubMenu = $_POST['SubMenu'];
	
	//$Archivo = $_POST['ArchivoPDF'];
	//$url = $_POST['ruta'];
	//$url = $url.$Archivo;
	//echo $url;

	$url ="../../nextclouddata/admindublock/files/PruebaSincro/EmpresaNueva/Contabilidad/Contabilidad/ContabilidadElectronica/PDFNUEVO.pdf";
     $content = file_get_contents($url);

     header('Content-Type: application/pdf');
     header('Content-Length: ' . strlen($content));
     header('Content-Disposition: inline; filename="PDFNUEVO.pdf"');
     header('Cache-Control: private, max-age=0, must-revalidate');
     header('Pragma: public');
     ini_set('zlib.output_compression','0');

     die($content);

       

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

 
 ?>