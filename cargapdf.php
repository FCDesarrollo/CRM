<?php 
	
	//$RFC = $_POST['RFCEmpresa'];
	//$SubMenu = $_POST['SubMenu'];
	
	$Archivo = $_POST['ArchivoPDF'];
	$url = $_POST['ruta'];
	$url = $url.$Archivo;
	echo $url;
	//$url ="../nextclouddata/admindublock/files/PruebaSincro/EmpresaNueva/Contabilidad/BDDADMW.pdf";
	//$url ="../../nextclouddata/admindublock/files/PruebaSincro/".$RFC."/".$SubMenu."/".$Archivo."";
	
    $content = file_get_contents($url);
    echo $content;
    echo "Entro";

    header('Content-Type: application/pdf');
    header('Content-Length: ' . strlen($content));
    header('Content-Disposition: inline; filename='.$Archivo);
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    ini_set('zlib.output_compression','0');

    return $content;
    die($content);

 ?>