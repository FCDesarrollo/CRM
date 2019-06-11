
    <?php
    # definimos la carpeta destino
    $carpetaDestino="archivostemp/";

    # si hay algun archivo que subir
    //if(isset($_FILES["archivo"]) && $_FILES["archivo"]["name"][0])
    if(isset($_FILES["file-1"]))
    {
 		//echo $_FILES["file-1"]["tmp_name"];
        # recorremos todos los arhivos que se han subido
        //for($i=0;$i<count($_FILES["file-1"]["name"]);$i++)
        //{  
 
            # si exsite la carpeta o se ha creado
            if(file_exists($carpetaDestino) || @mkdir($carpetaDestino))
            {
                $origen=$_FILES["file-1"]["tmp_name"];
                $destino=$carpetaDestino.$_FILES["file-1"]["name"];

                # movemos el archivo
                if(@move_uploaded_file($origen, $destino))
                {
                    //echo "<br>".$_FILES["archivo"]["name"][$i]." movido correctamente";
                    $status = array("Estatus" => "True");
                    echo json_encode($status);
                }else{
                	$status = array("Estatus" => "False");
                	echo json_encode($status);
                    //echo "<br>No se ha podido mover el archivo: ".$_FILES["archivo"]["name"][$i];
                }
            }else{
                //echo "<br>No se ha podido crear la carpeta: ".$carpetaDestino;
            }
         
        //}
    }else{
         //$status = array("Estatus" => "NoRecibio");
         //echo json_encode($status);
    	echo "No llego";
    }
    return;
    ?>
 
