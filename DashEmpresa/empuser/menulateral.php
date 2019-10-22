<?php  
    if($_SESSION["idusuario"] == "" && $_SESSION["idempresalog"])
    {
        //Si no hay sesión activa, lo direccionamos al index.php (inicio de sesión) 
      session_destroy(); echo "<script> window.location='index.php' </script>";
      exit(); 
    } 
    $perMod = new PermisosUsuario($_SESSION["idempresalog"], $_SESSION["idusuario"]);
    $perMod->user_Modulos();
    $perMod->user_Menus();
    $perMod->user_SubMenus();

?>
<div class="br-sideleft overflow-y-auto">
      <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
      <div class="br-sideleft-menu">
        <a href="" class="br-menu-link active">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">INICIO</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <a href="#" <?= ($perMod->Mod_Permiso(Mod_IncloudCon)==0) ? 'style=pointer-events:none' : ''; ?> class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
            <span class="menu-item-label">InCloud-Contabilidad</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item">
            <a <?= ($perMod->Menu_Permiso(Men_Contabilidad)==0) ? 'style=pointer-events:none' : ''; ?> href="#" class="nav-link" onclick="loadDiv('../submenus/contabilidad.php',<?= Mod_IncloudCon ?>, <?= Men_Contabilidad ?>, 0)">Contabilidad</a>
          </li>
          <li class="nav-item">
            <a <?= ($perMod->Menu_Permiso(Men_Fiscal)==0) ? 'style=pointer-events:none' : ''; ?> href="#" class="nav-link" onclick="loadDiv('../submenus/procesofiscal.php',<?= Mod_IncloudCon ?>, <?= Men_Fiscal ?>, 0)">Cumplimiento Fiscal</a>
          </li>
          <li class="nav-item">
            <a <?= ($perMod->Menu_Permiso(Men_Finanzas)==0) ? 'style=pointer-events:none' : ''; ?> href="#" class="nav-link" onclick="loadDiv('../submenus/finanzas.php',<?= Mod_IncloudCon ?>, <?= Men_Finanzas ?>, 0)">Finanzas</a>
          </li>
        </ul>
        <a href="#" <?= ($perMod->Mod_Permiso(Mod_InboxBandeja)==0) ? 'style=pointer-events:none' : ''; ?> class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-email-outline tx-24"></i>
            <span class="menu-item-label">Inbox-BandejaDeEntrada</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item">
            <a <?= ($perMod->Menu_Permiso(Men_Compras)==0) ? 'style=pointer-events:none' : ''; ?> href="#" class="nav-link" onclick="loadDiv('../submenus/compras.php',<?= Mod_InboxBandeja ?>, <?= Men_Compras ?>, 0)">Compras</a>
          </li>
          <li class="nav-item">
            <a <?= ($perMod->Menu_Permiso(Men_AlmacenDigital)==0) ? 'style=pointer-events:none' : ''; ?> href="#" class="nav-link none-link" onclick="loadDiv('../submenus/almacendigital.php',<?= Mod_InboxBandeja ?>, <?=Men_AlmacenDigital ?>, 0)">Almacen Digital</a>
          </li>
          <li class="nav-item">
            <a <?= ($perMod->Menu_Permiso(Men_RecepLotes)==0) ? 'style=pointer-events:none' : ''; ?> href="#" class="nav-link" onclick="loadDiv('../submenus/recepcionlotes.php',<?= Mod_InboxBandeja ?>, <?= Men_RecepLotes ?>, 0)">Recepción por Lotes</a>
          </li>
        </ul>
        <a href="#" <?= ($perMod->Mod_Permiso(Mod_IndexAdministrar)==0) ? 'style=pointer-events:none' : ''; ?> class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
            <span class="menu-item-label">Index-Administracion</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item">
            <a <?= ($perMod->Menu_Permiso(Men_Empresa)==0) ? 'style=pointer-events:none' : ''; ?> href="#" onclick="loadDiv('../divsadministrar/divadmempresa.php',<?= Mod_IndexAdministrar ?>, <?= Men_Empresa ?>, 0);" class="nav-link">Empresa</a>
          </li>
          <li class="nav-item">
            <a <?= ($perMod->Menu_Permiso(Men_Usuarios)==0) ? 'style=pointer-events:none' : ''; ?> href="#" onclick="loadDiv('../submenus/adm_usuarios.php',<?= Mod_IndexAdministrar ?>, <?= Men_Usuarios ?>, 0);" class="nav-link">Usuarios</a>
          </li>
          <li class="nav-item">
            <a <?= ($perMod->Menu_Permiso(Men_Perfiles)==0) ? 'style=pointer-events:none' : ''; ?> href="#" onclick="loadDiv('../submenus/adm_perfiles.php',<?= Mod_IndexAdministrar ?>, <?= Men_Perfiles ?>, 0);" class="nav-link">Perfiles</a>
          </li>
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
      
      <!--<a href="layouts.html" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-book-outline tx-22"></i>
            <span class="menu-item-label">Layouts</span>
          </div> menu-item 
        </a> br-menu-link -->
        
        <!--<a href="sitemap.html" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-list-outline tx-22"></i>
            <span class="menu-item-label">Sitemap</span>
          </div> menu-item 
        </a> br-menu-link -->




      </div><!-- br-sideleft-menu -->      

      <br>
    </div><!-- br-sideleft -->

