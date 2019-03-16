<?php  
$nom = $_POST["rfc"];
$certificado = $_FILES["archivoCer"];    
$llave = $_FILES["archivoKey"]; 
$fileCert = $certificado["tmp_name"];
$remote_fileCer = '/'.'PruebaSincro/'. $nom.'/'.$certificado["name"];
$fileKey = $llave["tmp_name"];
$remote_fileKey = '/'.'PruebaSincro/'.$nom.'/'.$llave["name"];

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
           
            if (ftp_put($conn_id, $remote_fileCer, $fileCert, FTP_BINARY)) {
                //echo "Archivo $fileCert guardado con extio\n";
                $statusCertificado = true;
            } else {
                //echo "Ocurrio un problema con el archivo $fileCert\n";
                $statusCertificado = false;
            }
            if (ftp_put($conn_id, $remote_fileKey, $fileKey, FTP_BINARY)) {
                //echo "Archivo $fileKey guardado con extio\n";
                $statusLlave = true;
            } else {
                //echo "Ocurrio un problema con el archivo $fileKey\n";
                $statusLlave = false;
            }   
   }                    
}else{
    $conexion = False;
}
ftp_close($conn_id);


$archivos=array($conexion,$statusCertificado,$statusLlave);
print_r(json_encode($archivos));
return $archivos;

?>