<?php

    $nom = "vinculacion";
    $certificado = $_FILES["archivoCerV"];    
    $llave = $_FILES["archivoKeyV"]; 

    $fileCert = $certificado["tmp_name"];
    $remote_fileCer = $nom.'/'.$certificado["name"];
    $fileKey = $llave["tmp_name"];
    $remote_fileKey = $nom.'/'.$llave["name"];

    // Conexión
    $ftp_server = "apicr.atwebpages.com";
    $conn_id = ftp_connect($ftp_server);
    
    // login con usuario y contraseña
    $ftp_user_name = "2974867_admin";
    $ftp_user_pass = "Dublock19";
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
    
    
    ftp_pasv($conn_id, true);
    if ($login_result===true){
        $conexion = true;  
        $pushd = ftp_pwd($conn_id);
        if ($pushd !== false && @ftp_chdir($conn_id, $nom)){
            if(ftp_chdir($conn_id, $pushd) == true){
                echo "El directorio ya existe";
                $statusCarpeta = false;
                $statusCertificado = false;
                $statusLlave = false;
            }           
        } else{
            if (ftp_mkdir($conn_id, $nom)) {
                if (ftp_chmod($conn_id, 0777, $nom) !== false){
                    $statusCarpeta = true;                        
                    if($certificado["type"] == "application/x-x509-ca-cert" && $llave["type"] == "application/octet-stream"){
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
                    }else {
                        if (ftp_rmdir($conn_id, $nom)) {
                            echo "Se ha eliminado correctamente el directorio $nom\n";
                        } else {
                            echo "Hubo un problema al eliminar el directorio $nom\n";
                        }
                        echo "Los archivos no corresponden a tipo certificado o llave";
                    }                                        
                }
            } else {
                //echo "Ocurrio un problema al crear a carpeta $nom\n";
                $statusCarpeta = false;     
            } 
        }                 
        //echo json_encode($conexion);
        
    }else{
        $conexion = False;
        //echo json_encode($conexion);
    }
    ftp_close($conn_id);

    $archivos=array($conexion,$statusCarpeta,$statusCertificado,$statusLlave);
    //print_r($archivos);
    print_r(json_encode($archivos));
    return json_encode($archivos);
    //var_dump(json_encode($archivos));
    //prueba
?>