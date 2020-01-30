<?php
	$ruta = "../submenus/";
    session_start();
    include("permisosuser.php");
    $perMod = new PermisosUsuario($_SESSION["idempresalog"], $_SESSION["idusuario"]);
    $perMod->user_Modulos();
    $perMod->user_Menus();
    $perMod->user_SubMenus();

    // $mod = isset($_GET["mod"]) ? $_GET["mod"] : 0;
    // $men = isset($_GET["men"]) ? $_GET["men"] : 0;
    // $sub = isset($_GET["sub"]) ? $_GET["sub"] : 0;

    $mod = isset($_POST["mod"]) ? $_POST["mod"] : 0;
    $men = isset($_POST["men"]) ? $_POST["men"] : 0;
    $sub = isset($_POST["sub"]) ? $_POST["sub"] : 0;    

    $archivo = "";
    switch ($men) {
    	case 1:
    		$archivo = "contabilidad.php";
    		break;    	
    	case 2:
    		$archivo = "procesofiscal.php";
    		break;
    	case 3:
    		$archivo = "finanzas.php";
    		break;
    	case 4:
    		$archivo = "compras.php";
    		break;    		
    	case 5:
    		$archivo = "almacendigital.php";
    		break;
    	case 6:
    		$archivo = "recepcionlotes.php";
    		break;
    	case 7:
    		$archivo = "../divsadministrar/divadmempresa.php";
    		break;
    	case 8:
    		$archivo = "adm_usuarios.php";
    		break;
    	case 9:
    		$archivo = "adm_perfiles.php";
    		break;  	    	    	    	    	
        case 10:
            $archivo = "almacendigitalexpedientes.php";
            break;            
    	default:
    		break;
    }


    if($mod != 0 && $perMod->Mod_Permiso($mod) != 0){
    	if($men != 0 && $perMod->Menu_Permiso($men) != 0){
		    if($sub != 0 && $perMod->SubMenu_Permiso($sub) != 0){

		    }else{
				$sub = 0;    	
		    }
    	}else{
    		$men = 0;
            $sub = 0;
    	}
    }else{
		$mod = 0;
        $men = 0;
        $sub = 0;
    }

   	if($archivo != ""){
   		//echo "<script> loadDiv('".$ruta.$archivo."',".$mod.",".$men.",".$sub.") </script>";	
        $datos = array('ruta' => $ruta.$archivo, 'mod' => $mod, 'men' => $men ,'sub' => $sub);
        echo json_encode($datos);
        return json_encode($datos);
   	}

    

?>