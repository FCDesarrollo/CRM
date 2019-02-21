<?php
    $nom = $_POST["rfc"];
    $certificado = $_FILES["archivoCer"];    
    $llave = $_FILES["archivoKey"]; 

    $fileCert = $certificado["tmp_name"];
    $remote_fileCer = $nom.'/'.$certificado["name"];
    $fileKey = $llave["tmp_name"];
    $remote_fileKey = $nom.'/'.$llave["name"];

    /*foreach ($certificado as $key => $value) {
        echo $key." ".$value."   ->";
    }*/

    // set up basic connection
    $ftp_server = "ftp.dublock.com";
    $conn_id = ftp_connect($ftp_server);
    
    // login with username and password
    $ftp_user_name = "crmadmin@cloud.dublock.com";
    $ftp_user_pass = "4u1B6nyy3W";
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

    if (file_exists($nom)) {            
        echo "El directorio ya existe";
    }else{
        // try to create the directory $dir
        if (ftp_mkdir($conn_id, $nom)) {
            echo "Carpeta $nom creada con exito\n";        
        } else {
            echo "Ocurrio un problema al crear a carpeta $nom\n";
        }   
        // upload a file
        if($certificado["type"] == "application/x-x509-ca-cert" && $llave["type"] == "application/octet-stream"){
            if (ftp_put($conn_id, $remote_fileCer, $fileCert, FTP_ASCII)) {
                echo "Archivo $fileCert guardado con extio\n";
            } else {
                echo "Ocurrio un problema con el archivo $fileCert\n";
            }
            if (ftp_put($conn_id, $remote_fileKey, $fileKey, FTP_ASCII)) {
                echo "Archivo $fileKey guardado con extio\n";
            } else {
                echo "Ocurrio un problema con el archivo $fileKey\n";
            }
        }else {
            if (ftp_rmdir($conn_id, $nom)) {
                echo "Se ha eliminado correctamente el directorio $nom\n";
            } else {
                echo "Hubo un problema al eliminar el directorio $nom\n";
            }
            echo "Los archivos no corresponden a     tipo certificado o llave";
        }

        $command = 'cd..';

        if (ftp_exec($conn_id, $command)) {
            echo "$command executed successfully\n";
        } else {
            echo "could not execute $command\n";
        }

        $salida = shell_exec('mkdir dir1');
        echo $salida;

        //$password = "FRANCO144B";
        //$salida  = scandir('/files');
        //$salida = shell_exec('openssl.exe pkcs8 -inform DER -in '.$remote_fileKey.' -out '.$remote_fileKey.'.pem -passin pass:'.$password.' 2>&1');
        //$salida = shell_exec('mkdir dir1');
        /*$command = "mkdir dir1";
        $resultado = ftp_exec($conn_id, $command);
        echo $resultado;
*/
        $password = "FRANCO144B"; //$_POST["txtContra"];
        //$nombreKey = $fileKey; //"C:/xampp/htdocs/script/00001000000407734879.cer"; //$_FILES["archivoCer"];   
        
        $command = 'openssl.exe pkcs8 -inform DER -in "'.$remote_fileKey.'" -out "'.$remote_fileKey.'.pem" -passin pass:"'.$password.'" 2>&1';

        if (ftp_exec($conn_id, $command)) {
            echo "$command executed successfully\n";
        } else {
            echo "could not execute $command\n";
        }

        $salida = shell_exec('mkdir dir1');
        echo $salida; /*
        $command = "ls";
        $command = 'openssl pkcs8 -inform DER -in "'.$remote_fileKey.'" -out "'.$remote_fileKey.'.pem" -passin pass:"'.$password.'" 2>&1';
        $resultado = ftp_exec($conn_id, $command, strlen("SITE EXEC"));
        echo $resultado;
        /*if (ftp_exec($conn_id, $command)) {
            echo "$command executed successfully\n";
        } else {
            echo "could not execute $command\n";
        }
        /*
        //Elimina archivos y carpeta
        if (ftp_delete($conn_id, $remote_fileCer)) {
            echo "$remote_fileCer deleted successful\n";
        } else {
            echo "could not delete $remote_fileCer\n";
        }

        if (ftp_delete($conn_id, $remote_fileKey)) {
            echo "$remote_fileCer deleted successful\n";
        } else {
            echo "could not delete $remote_fileCer\n";
        }
        if (ftp_rmdir($conn_id, $nom)) {
            echo "Se ha eliminado correctamente el directorio $nom\n";
        } else {
            echo "Hubo un problema al eliminar el directorio $nom\n";
        }
        */
    }

    // close the connection
    ftp_close($conn_id);
?>