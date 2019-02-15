<?php
    $nom = $_POST["rfc"];
    $certificado = $_FILES["archivoCer"];    
    $llave = $_FILES["archivoKey"]; 

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

    // try to create the directory $dir
    if (ftp_mkdir($conn_id, $nom)) {
        echo "successfully created $nom\n";        
//        echo " successfully created $nom\n";
    } else {
        echo "There was a problem while creating $nom\n";
    }

    $file = $certificado["tmp_name"];
    $remote_file = $nom.'/'.$certificado["name"];

    // upload a file
    if($certificado["type"] == "application/x-x509-ca-cert"){
        if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
            echo "successfully uploaded $file\n";
        } else {
            echo "There was a problem while uploading $file\n";
        }
    }

    $file = $llave["tmp_name"];
    $remote_file = $nom.'/'.$llave["name"];


    if($llave["type"] == "application/octet-stream"){
        if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
            echo "successfully uploaded $file\n";
        } else {
            echo "There was a problem while uploading $file\n";
        }
    }
    

    // close the connection
    ftp_close($conn_id);
?>