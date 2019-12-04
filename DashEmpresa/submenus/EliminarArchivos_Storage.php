<?php
    header('Content-Type: application/json');

    $contador = 1;
    $contadorArreglo = 0;
    $archivosArray = array();
    $ch = curl_init();  
    //$i = 0;

    if(isset($_POST["archivo"])){
        Include ("../empuser/permisosuser.php");
        session_start();
        $perMod = new PermisosUsuario($_SESSION["idempresalog"], $_SESSION["idusuario"]);
        $perMod->Menus();
        $perMod->SubMenus();

        $archivo = $_POST["archivo"];
        $rfcempresa = $_POST["rfcempresa"];
        $men = $perMod->Men_NombreCarpeta($_POST['idmenu']);
        $sub = $perMod->Sub_NombreCarpeta($_POST['idsubmenu']);
        $ruta = "Entrada/".$men."/".$sub;
        /*if($_POST["idsubmenu"] == 23){
            $ruta = "Entrada/AlmacenDigitalOperaciones/Pagos";
        }else if($_POST["idsubmenu"] == 27){
            $ruta = "Entrada/AlmacenDigitalExpedientes/Generales";
        }*/
        //$directorio =  $_POST["file-0"];
        //while (isset($_FILES["file-". $contador]["name"])) {        

            curl_setopt_array($ch,
                array(
                    CURLOPT_URL => 'https://cloud.dublock.com/remote.php/dav/files/'.$rfcempresa.'/CRM/'.$rfcempresa.'/'.$ruta.'/'. $archivo,
                    CURLOPT_VERBOSE => 1,
                    CURLOPT_USERPWD => $_POST['u_storage'].':'.$_POST['p_storage'],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_BINARYTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'DELETE',
                )
            );
            curl_exec($ch);   
        //    $contador++;
        //}
        curl_close($ch);
    }else{
        $archivo = "";
    }
    echo json_encode($archivo);
    return json_encode($archivo);
?>