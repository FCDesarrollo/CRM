<?php
session_start();  
    if($_SESSION["idusuario"] == "" && $_SESSION["idempresalog"])
    {
        //Si no hay sesión activa, lo direccionamos al index.php (inicio de sesión) 
      session_destroy(); echo "<script> window.location='index.php' </script>";
      exit(); 
    } 
?>

<div class="br-sideleft overflow-y-auto">
      <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
      <div class="br-sideleft-menu">
        <a href="index.html" class="br-menu-link active">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">INICIO</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-email-outline tx-24"></i>
            <span class="menu-item-label"> MENSAJES</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
       
<?php
    
    class PermisosUser{
        const cBloqueado = 0;
        const cLectura = 1;
        const cLecYEsc = 2;
        const cTodo = 3;
        
        var $sWs; 
        var $cIDEmpresa;
        var $cIDUsuario;
        var $data;
        public function cModulos($cIDEmpresa, $cIDUsuario)
        {
            //$this->sWs = "http://localhost/ApiConsultorMX/miconsultor/public/";
            $this->sWs = "http://apicrm.dublock.com/";
            $this->cIDEmpresa = $cIDEmpresa;
            $this->cIDUsuario = $cIDUsuario;
            
            $this->data = array("idempresa" => $this->cIDEmpresa, "idusuario" => $this->cIDUsuario);
            $resultado = CallAPI("GET", $this->sWs ."PermisoModulos", $this->data);   
            $array = json_decode($resultado, true);
            foreach($array as $value) {
                $Modulo = json_decode(CallAPI("GET", $this->sWs ."NombreModulo",
                    array("idmodulo" => $value['idmodulo'])), true);
                
                    $PerMod = $value['tipopermiso'];
                    
                echo '<div class="br-menu-item">';
                echo '<span style="color: #87c846;" class="menu-item-label">'.$Modulo[0]['nombre_modulo'].'</span>';
                echo '</div>';
                
                $this->data2 = array("idempresa" => $this->cIDEmpresa, "idusuario" => $this->cIDUsuario, "idmodulo" => $value['idmodulo']);
                $resultado2 = CallAPI("GET", $this->sWs ."PermisoMenus", $this->data2);    
                $array2 = json_decode($resultado2, true);
                foreach($array2 as $value2) {
                      $PerMenu= ($PerMod == 0) ? 0 : $value2['tipopermiso'];
                      $Menu = json_decode(CallAPI("GET", $this->sWs ."NombreMenu",
                      array("idmenu" => $value2['idmenu'])), true);
                      $stBloq = ($PerMenu == 0) ? " style='pointer-events:none; '" : "" ;
                      echo '<a href="#"' .$stBloq. ' class="br-menu-link">';
                      echo '<div class="br-menu-item">';
                      echo '<i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>';
                      echo '<span class="menu-item-label">' .$Menu[0]['nombre_menu']. '</span>';
                      echo '<i class="menu-item-arrow fa fa-angle-down"></i>';
                      echo '</div>';
                      echo '</a>';
                      $this->data3 = array("idempresa" => $this->cIDEmpresa, "idusuario" => $this->cIDUsuario, "idmenu" => $value2['idmenu']);
                      $resultado3 = CallAPI("GET", $this->sWs ."PermisoSubMenus", $this->data3);    
                      $array3 = json_decode($resultado3, true);
                      echo '<ul class="br-menu-sub nav flex-column">';
                      foreach($array3 as $value3) {
                        $PerSubMenu= ($PerMenu == 0) ? 0 : $value3['tipopermiso'];
                        $stBloq = ($PerSubMenu == 0) ? " style='pointer-events:none; '" : "" ;
                       
                        $SubMenu = json_decode(CallAPI("GET", $this->sWs ."NombreSubMenu",
                        array("idsubmenu" => $value3['idsubmenu'])), true);

                          echo '<li class="nav-item"><a' .$stBloq. ' href="accordion.html" class="nav-link">'.$SubMenu[0]['nombre_submenu'].'</a></li>';
                      }
                      echo '</ul>';
                  
                }
              }  
            }
            
        }
function CallAPI($method, $url, $data = false)
{
   
    $curl = curl_init();
    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
   // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    curl_close($curl);
    return $result;

}

    $a = new PermisosUser();
    $a->cModulos($_SESSION['idempresalog'], $_SESSION['idusuario']);
   
?>
        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
            <span class="menu-item-label">ADMINISTRAR</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a  class="nav-link">Empresa</a></li>
          <li class="nav-item"><a href="#" onclick="loadDiv('../divsadministrar/divadmusuarios.php');" class="nav-link">Usuarios</a></li>
          <li class="nav-item"><a href="#" onclick="loadDiv('../divsadministrar/divadmperfiles.php');" class="nav-link">Perfiles</a></li>
          <li class="nav-item"><a href="form-wizards.html" class="nav-link">Form Wizards</a></li>
          <li class="nav-item"><a href="form-editor-code.html" class="nav-link">Code Editor</a></li>
          <li class="nav-item"><a href="form-editor-text.html" class="nav-link">Text Editor</a></li>
        </ul>
        <a href="pages.html" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-chatbubble-working tx-22"></i>
            <span class="menu-item-label">AYUDA</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="background.html" class="nav-link">Vídeos</a></li>
          <li class="nav-item"><a href="background.html" class="nav-link">Noticias Fiscales</a></li>
          <li class="nav-item"><a href="background.html" class="nav-link">Cartas Técnicas</a></li>
        </ul>
        <a href="layouts.html" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-book-outline tx-22"></i>
            <span class="menu-item-label">Layouts</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <a href="sitemap.html" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-list-outline tx-22"></i>
            <span class="menu-item-label">Sitemap</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
      </div><!-- br-sideleft-menu -->      

      <br>
    </div><!-- br-sideleft -->

