<?php  
$nom = $_POST["rfc"];
$certificado = $_FILES["archivoCer"];    
$llave = $_FILES["archivoKey"]; 
$fileCert = $certificado["tmp_name"];
$remote_fileCer = '/'.'PruebaSincro/'. $nom.'/'.$certificado["name"];
$fileKey = $llave["tmp_name"];
$remote_fileKey = '/'.'PruebaSincro/'.$nom.'/'.$llave["name"];
//$archivoTxt = '/'.'PruebaSincro/'.$nom.'/'.$nom.".txt";
$archivoTxt = $nom.".txt";
$pass = $_POST["password"];
$local_file = $nom.".txt"; //Nombre archivo en nuestro PC
$server_file = '/'.'PruebaSincro/'.$nom.'/'.$nom.".txt"; //Nombre archivo en FTP

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom );
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_USERPWD, 'admindublock:4u1B6nyy3W');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'MKCOL');
$httpResponse = curl_exec($ch);
//var_dump($httpResponse);
//var_dump(curl_getinfo($ch, CURLINFO_HTTP_CODE) );
curl_close($ch);

// Conexión
$ftp_server = "ftp.dublock.com";
$conn_id = ftp_connect($ftp_server);

// login con usuario y contraseña
$ftp_user_name = "crmadmin@cloud.dublock.com";
$ftp_user_pass = "4u1B6nyy3W";

$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

ftp_pasv($conn_id, true);
if ($login_result===true){
    $conexion = true;  
    $pushd = ftp_pwd($conn_id);
    if ($pushd !== false && @ftp_chdir($conn_id, $nom)){
        if(ftp_chdir($conn_id, $pushd) == true){
            if($certificado["type"] == "application/x-x509-ca-cert" && $llave["type"] == "application/octet-stream"){
                echo "El directorio" . $nom ." no existe";
                $statusCertificado = false;
                $statusLlave = false;
            }
        }           
    } else{                       
            /*if (ftp_put($conn_id, $remote_fileCer, $fileCert, FTP_BINARY)) {
                $statusCertificado = true;
            } else {
                $statusCertificado = false;
            }
            if (ftp_put($conn_id, $remote_fileKey, $fileKey, FTP_BINARY)) {
                $statusLlave = true;
            } else {
                $statusLlave = false;
            }   
 
            if(!file_exists($archivoTxt))
            {                
                $mensaje = $pass;
                if($archivo = fopen($archivoTxt, "a"))
                {                            
                    if(fwrite($archivo, $mensaje)){
                        $archivoC = true;
                    }
                    fclose($archivo);
                    
                    if (ftp_put($conn_id, $server_file, $local_file, FTP_BINARY)) {
                        $archivoCS = true; 
                    } else {
                        $archivoCS = false; 
                    }
                }
            }else {
                $archivoC = false; 
            }
            if (file_exists($archivoTxt)) { 
                unlink($archivoTxt);
            }*/
   }                    
}else{
    $conexion = False;
}
ftp_close($conn_id);

$statusCertificado= true;
$statusLlave= true;
$archivoC= true;
$archivoCS= true;
$archivos=array($conexion,$statusCertificado,$statusLlave,$archivoC,$archivoCS);
print_r(json_encode($archivos));
return $archivos;

?>