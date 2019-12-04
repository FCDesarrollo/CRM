<?php
    header('Content-Type: application/json');
    session_start();  
    include("../../addempresa/nombre_carpetas.php");
    $carStr = new CarpetasStorage($_SESSION["idempresalog"], $_SESSION["idusuario"]);
    $carStr->Modulos();
    $carStr->Menus();
    $carStr->SubMenus();

    $Modulos = $carStr->Mod_Nombre();
    $Menus = $carStr->Men_Nombre();
    $SubMenus = $carStr->Sub_Nombre();

    
    $idsubmenu = $_POST["idsubmenu"];
    for ($j=0; $j < count($Menus); $j++) { 
        if($Menus[$j]['idmenu'] == $_POST["idmenu"]){
            $menu = $Menus[$j]['nombre_carpeta'];
            break;
        }
    }

    for ($k=0; $k < count($SubMenus); $k++) { 
        if($SubMenus[$k]['idsubmenu'] == $_POST["idsubmenu"]){
            $submenu = $SubMenus[$k]['nombre_carpeta'];
            break;
        }
    }

    $contador = 1;
    $contadorArreglo = 0;
    $archivosArray = array();
    $ch = curl_init();  
    $i = 0;      


    //$lista = $_POST["lista"];
    //$archivos = $_POST["archivos"];
    //$directorio =  $archivos["file-0"];
    $empresa = $_POST["rfc"];
    //$directorio =  $_POST["file-0"];
    $directorio = $empresa.'/Entrada/'.$menu.'/'.$submenu.'/';
    while (isset($_FILES["file-". $contador]["name"])) {        
        $file = $_FILES["file-". $contador]["name"]; //Obtenemos el nombre original del archivo
        $filename = $_POST["archivo-". $contador];
        $source = $_FILES["file-". $contador]["tmp_name"]; //Obtenemos un nombre temporal del archivo        
        $type = explode(".", $file);
        $target_path = $directorio.'/'.$filename.".".$type[1]; //Indicamos la ruta de destino, así como el nombre del archivo       
        

        //echo $archivos[$contador]["status"];
        //if($_FILES["file-". $contador]['type']=='application/pdf'){
            //if($archivos[$contador]["status"] == 0){        
            if($_FILES["file-". $contador]["error"] == 0){
                $gestor = fopen($source, "r");
                $contenido = fread($gestor, filesize($source));
                fclose($gestor);

                curl_setopt_array($ch,
                    array(
                        CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/'.$empresa.'/CRM/'. $target_path,
                        CURLOPT_VERBOSE => 1,
                        CURLOPT_USERPWD => $_POST["u_storage"].':'.$_POST["p_storage"],
                        CURLOPT_POSTFIELDS => $contenido,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_BINARYTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => 'PUT',
                    )
                );
                curl_exec($ch);   
            //}
                $archivosArray[$contadorArreglo] =  array(
                    "nombre" => $_FILES["file-". $contador]["name"],
                    "idalmacen" => $_POST["idalmacen-". $contador],
                    "idarchivo" => $_POST["idarchivo-". $contador],
                    "error" => 0,
                    "detalle" => "¡Cargado Correctamente!"
                ); 
            }else{
                $archivosArray[$contadorArreglo] =  array(
                    "nombre" => $_FILES["file-". $contador]["name"],
                    "idalmacen" => $_POST["idalmacen-". $contador],
                    "idarchivo" => $_POST["idarchivo-". $contador],
                    "error" => 1,
                    "detalle" => "¡Archivo Dañado!"
                );
            }

            $contadorArreglo++;                          
        //}
        $contador++;
    }
    curl_close($ch);
    echo json_encode($archivosArray);
    return json_encode($archivosArray);
?>