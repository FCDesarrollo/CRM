<?php  
$nom = trim($_POST["rfc"]);
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
    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom,
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Contabilidad',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Contabilidad/Estados Financieros',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Contabilidad/Contabilidad electronica',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Contabilidad/Expedientes Administrativos',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Contabilidad/Expedientes Contables',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Proceso Fiscal',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Proceso Fiscal/Pagos Provisionales',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Proceso Fiscal/Pagos Mensuales',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Proceso Fiscal/Declaraciones Anuales',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Proceso Fiscal/Expedientes Fiscales',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Finanzas',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Finanzas/Indicadores Financieros',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Finanzas/Asesor de Flujos de Efectivo',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Finanzas/Análisis de Proyectos',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/Compras',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/Compras/Requerimientos',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/Compras/Autorizaciones',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/Compras/Recepción de compras',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/Almacen Digital',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/Almacen Digital/Notificaciones de Autoridades',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/Almacen Digital/Expedientes Digitales',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/Recepcion por Lotes',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/Recepcion por Lotes/Proceso de Produccion',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/Recepcion por Lotes/Proceso de Compras',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/Recepcion por Lotes/Proceso de Ventas',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    $gestor = fopen($fileCert, "r");
    $contenido = fread($gestor, filesize($fileCert));
    fclose($gestor);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/'. $certificado["name"],
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_POSTFIELDS => $contenido,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            )
    );
    curl_exec($ch);

    $gestor2 = fopen($fileKey, "r");
    $contenido2 = fread($gestor2, filesize($fileKey));
    fclose($gestor2);
    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/'. $llave["name"],
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_POSTFIELDS => $contenido2,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            )
    );
    curl_exec($ch);

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
        if(!file_exists($archivoTxt)){                
            $mensaje = $pass;
            if($archivo = fopen($archivoTxt, "a")){                            
                if(fwrite($archivo, $mensaje)){
                        $archivoC = true;
                }
                fclose($archivo);  
                $gestor2 = fopen($local_file, "r");
                    $contenido2 = fread($gestor2, filesize($local_file));
                    fclose($gestor2);
                    $ch = curl_init();                
                    curl_setopt_array($ch,
                        array(
                            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/'. $archivoTxt,
                            CURLOPT_VERBOSE => 1,
                            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
                            CURLOPT_POSTFIELDS => $contenido2,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_BINARYTRANSFER => true,
                            CURLOPT_CUSTOMREQUEST => 'PUT',
                        )
                    );
                    curl_exec($ch);                           
                    curl_close($ch);
            }
        }else {
            $archivoC = false; 
        }
        if (file_exists($archivoTxt)) { 
            unlink($archivoTxt);
        }
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