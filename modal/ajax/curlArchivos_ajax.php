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
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Contabilidad/EstadosFinancieros',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Contabilidad/ContabilidadElectronica',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Contabilidad/ExpedientesAdministrativos',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Contabilidad/ExpedientesContables',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/ProcesoFiscal',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Proceso Fiscal/PagosProvisionales',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Proceso Fiscal/PagosMensuales',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Proceso Fiscal/DeclaracionesAnuales',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Proceso Fiscal/ExpedientesFiscales',
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
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Finanzas/IndicadoresFinancieros',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Finanzas/AsesordeFlujosdeEfectivo',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Contabilidad/Finanzas/AnálisisdeProyectos',
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
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/Compras/Recepcióndecompras',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/AlmacenDigital',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/AlmacenDigital/NotificacionesdeAutoridades',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/AlmacenDigital/ExpedientesDigitales',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/RecepcionporLotes',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/RecepcionporLotes/ProcesodeProduccion',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/RecepcionporLotes/ProcesodeCompras',
            CURLOPT_VERBOSE => 1,
            CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'MKCOL',
        )
    );
    curl_exec($ch);

    curl_setopt_array($ch,
        array(
            CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $nom .'/Entrada/RecepcionporLotes/ProcesodeVentas',
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