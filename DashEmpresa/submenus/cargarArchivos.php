<?php
    header('Content-Type: application/json');

    $contador = 1;
    $contadorArreglo = 0;
    $archivos = array();
    $ch = curl_init();  
    $i = 0;      

    $menu = $_POST["menu"];
    $submenu = $_POST["submenu"];
    $mod = substr(strtoupper($submenu), 0, 3);

    $empresa = $_POST["rfc"];
    $directorio = $empresa.'/Entrada/'.$menu.'/'.$submenu;

    $fechadocto = $_POST["fechadocto"];
    $string = explode("-", $fechadocto);
    $codfec = substr($string[0], 2).$string[1];        
    $codarchivo = $empresa."_".$codfec."_".$mod."_";
    //$codarchivo = $empresa."_".$codfec."_".$_POST["rubro"]."_";


    $consecutivo = $_POST["consecutivo"];    
    $countreg = $consecutivo;

    while (isset($_FILES["file-". $contador]["name"])) {     

        if(strlen($countreg) == 1){
            $consecutivo = "000".$countreg;
        }elseif (strlen($countreg) == 2){
            $consecutivo = "00".$countreg;
        }elseif (strlen($countreg) == 3){
            $consecutivo = "0".$countreg;
        }else{
            $consecutivo = $countreg;
        }

        $file = $_FILES["file-". $contador]["name"]; //Obtenemos el nombre original del archivo
//        $filename = $_POST["archivo-". $contador];
        $filename = $codarchivo.$consecutivo;
        $source = $_FILES["file-". $contador]["tmp_name"]; //Obtenemos un nombre temporal del archivo        
        $type = explode(".", $file);
        
        $target_path = $directorio.'/'.$filename.".".$type[count($type)-1]; //Indicamos la ruta de destino, así como el nombre del archivo       

        if($_FILES["file-". $contador]["error"] == 0){
            $gestor = fopen($source, "r");
            $contenido = fread($gestor, filesize($source));

            curl_setopt_array($ch,
                array(
                    CURLOPT_URL => 'https://'.$_POST["server_storage"].'/remote.php/dav/files/'.$_POST["u_storage"].'/CRM/'. $target_path,
                    CURLOPT_VERBOSE => 1,
                    CURLOPT_USERPWD => $_POST["u_storage"].':'.$_POST["p_storage"],
                    CURLOPT_POSTFIELDS => $contenido,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_BINARYTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'PUT',
                )
            );
            $resp = curl_exec($ch);   
            fclose($gestor);

            $error_no = curl_errno($ch);

            if($error_no == 0){
                //Generar Link
                $link = getlink($target_path, $_POST["server_storage"], $_POST["u_storage"], $_POST["p_storage"]);

                if($link != ""){

                    $archivos[$contadorArreglo] =  array(
                        "archivo" => $_FILES["file-". $contador]["name"],
                        "codigo" => $filename,
                        "link" => $link,
                        "error" => 0,
                        "detalle" => "¡Cargado Correctamente!",
                        "info" => $resp
                    );

                    $countreg = $countreg + 1;
                }else{
                    $archivos[$contadorArreglo] =  array(
                        "archivo" => $_FILES["file-". $contador]["name"],
                        "codigo" => $filename,
                        "link" => $link,
                        "error" => 3,
                        "detalle" => "¡No se pudo subir el archivo!",
                        "info" => $resp
                    );                    
                }

            }else{
                $archivos[$contadorArreglo] =  array(
                    "archivo" => $_FILES["file-". $contador]["name"],
                    "codigo" => $filename,
                    "link" => "",
                    "error" => 1,
                    "detalle" => "¡No se pudo subir el archivo!",
                    "info" => $resp
                );
            }
 
        }else{
            $archivos[$contadorArreglo] =  array(
                "archivo" => $_FILES["file-". $contador]["name"],
                "codigo" => $filename,
                "link" => "",
                "error" => 2,
                "detalle" => "¡Archivo Dañado!"
            );
        }

        $contadorArreglo++;                          

        $contador++;
    }
    curl_close($ch);
    echo json_encode($archivos);
    return json_encode($archivos);



    function getlink($link, $server, $user, $pass){
       $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, "https://".$user.":".$pass."@".$server."/ocs/v2.php/apps/files_sharing/api/v1/shares");
        curl_setopt($ch, CURLOPT_URL, "https://".$server."/ocs/v2.php/apps/files_sharing/api/v1/shares");
        curl_setopt($ch, CURLOPT_VERBOSE, 1);       
        curl_setopt($ch, CURLOPT_USERPWD, $user.":".$pass);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "path=CRM/".$link."&shareType=3");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('OCS-APIRequest:true'));
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        $httpResponse = curl_exec($ch);
        $httpResponse = explode("\n\r\n", $httpResponse);
        $body = $httpResponse[1];      
        $Respuesta= simplexml_load_string($body);        
        $url = ((string)$Respuesta[0]->data->url);
        curl_close($ch);
        return $url;
    }    
?>