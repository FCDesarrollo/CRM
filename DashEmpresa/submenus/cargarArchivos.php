<?php
    header('Content-Type: application/json');

    $contador = 1;
    $contadorArreglo = 0;
    $archivosArray = array();
    $ch = curl_init();        
    $directorio =  $_POST["file-0"];
    while (isset($_FILES["file-". $contador]["name"])) {        
        $filename = $_FILES["file-". $contador]["name"]; //Obtenemos el nombre original del archivo
        $source = $_FILES["file-". $contador]["tmp_name"]; //Obtenemos un nombre temporal del archivo        
        $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo          
        if($_FILES["file-". $contador]['type']=='application/pdf'){
                
            $gestor = fopen($source, "r");
            $contenido = fread($gestor, filesize($source));
            fclose($gestor);

            curl_setopt_array($ch,
                array(
                    CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/PruebaSincro/'. $target_path,
                    CURLOPT_VERBOSE => 1,
                    CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
                    CURLOPT_POSTFIELDS => $contenido,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_BINARYTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'PUT',
                )
            );
            curl_exec($ch);   

            $archivosArray[$contadorArreglo] =  array(
                "nombre" => $_FILES["file-". $contador]["name"]
            ); 
            $contadorArreglo++;                          
        }
        $contador++;
    }
    curl_close($ch);
    echo json_encode($archivosArray);
    return json_encode($archivosArray);
?>