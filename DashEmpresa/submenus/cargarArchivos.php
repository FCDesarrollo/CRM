<?php
    header('Content-Type: application/json');

    $contador = 1;
    $contadorArreglo = 0;
    $archivosArray = array();
    $ch = curl_init();  
    $i = 0;      


    //$lista = $_POST["lista"];
    //$archivos = $_POST["archivos"];
    //$directorio =  $archivos["file-0"];
    $directorio =  $_POST["file-0"];
    while (isset($_FILES["file-". $contador]["name"])) {        
        $file = $_FILES["file-". $contador]["name"]; //Obtenemos el nombre original del archivo
        $filename = $_POST["archivo-". $contador];
        $source = $_FILES["file-". $contador]["tmp_name"]; //Obtenemos un nombre temporal del archivo        
        $type = explode(".", $file);
        $target_path = $directorio.'/'.$filename.".".$type[1]; //Indicamos la ruta de destino, así como el nombre del archivo       
        

        //echo $archivos[$contador]["status"];
        //if($_FILES["file-". $contador]['type']=='application/pdf'){
            //if($archivos[$contador]["status"] == 0){        
                $gestor = fopen($source, "r");
                $contenido = fread($gestor, filesize($source));
                fclose($gestor);

                curl_setopt_array($ch,
                    array(
                        CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/admindublock/CRM/'. $target_path,
                        CURLOPT_VERBOSE => 1,
                        CURLOPT_USERPWD => 'admindublock:4u1B6nyy3W',
                        CURLOPT_POSTFIELDS => $contenido,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_BINARYTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => 'PUT',
                    )
                );
                curl_exec($ch);   
            //}
            $archivosArray[$contadorArreglo] =  array(
                "nombre" => $_FILES["file-". $contador]["name"]
            ); 
            $contadorArreglo++;                          
        //}
        $contador++;
    }
    curl_close($ch);
    echo json_encode($archivosArray);
    return json_encode($archivosArray);
?>