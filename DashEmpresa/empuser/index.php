<?php

session_start();  
    // $user = $_SESSION['idusuario'];
    // $user1 = $_SESSION['usuario21'];
    // $user2 = $_SESSION['tipo'];
    if (isset($_SESSION["usuario21"]))
    {
      if($_SESSION["usuario21"] == "" && $_SESSION['idempresalog'] == "")
      {
          //Si no hay sesión activa, lo direccionamos al index.php (inicio de sesión) 
        session_destroy(); echo "<script> window.location='../../index.php' </script>";
        exit(); 
        
      }else if($_SESSION['idempresalog'] == 0){
          echo "<script> window.location='../../usuario.php' </script>";
      } 
    }else{      
        session_destroy(); echo "<script> window.location='../../index.php' </script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Meta para cargar pagina desde servidor -->
    <meta http-equiv="Expires" content="0"> 
    <meta http-equiv="Last-Modified" content="0"> 
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate"> 
    <meta http-equiv="Pragma" content="no-cache">

    <!--<link rel="icon" type="../img/iconpage.ico" href="../img/iconpage.ico" />-->
    <link rel="icon" type="image/png" href="../../login/images/icons/favicon.ico"/>


    <!-- Twitter -->
    <!--<meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bracket">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/bracket/img/bracket-social.png"> -->

    <!-- Facebook -->
    <!--<meta property="og:url" content="http://themepixels.me/bracket">
    <meta property="og:title" content="Bracket">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/bracket/img/bracket-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/bracket/img/bracket-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600"> -->

    <!-- Meta -->
    <!-- vendor css -->
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
    <link href="../lib/highlightjs/github.css" rel="stylesheet">
    <link href="../lib/datatables/jquery.dataTables.css" rel="stylesheet">
    <!--<link href="../lib/datatables/jquery.dataTables.js" rel="stylesheet"> -->
    <link href="../lib/select2/css/select2.min.css" rel="stylesheet">



    <!-- Bracket CSS -->
    <link rel="stylesheet" href="../css/bracket.css">


    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>C R M</title>

    <!-- vendor css -->
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
    <!--<link href="../lib/rickshaw/rickshaw.min.css" rel="stylesheet">
    <link href="../lib/chartist/chartist.css" rel="stylesheet"> -->

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="../css/bracket.css">
    <link rel="stylesheet" href="../css/estilos.css"> 

  </head> 

  <body onload="CargaDatosEmpresa('<?php echo $_SESSION['idusuario']; ?>','<?php echo $_SESSION['idempresalog']; ?>', '<?php echo $_SESSION['idperfil']; ?>','<?php echo $_SESSION['pwd']; ?>')">
    <div id="precarga"></div>
    <?php include("../../varglobales.php"); ?>
    <?php //include("PHPAltiria.php"); ?>
    <?php include("permisosuser.php"); ?>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <div class="br-logo justify-content-center"><a href="../empuser/"><span>[</span>C R M<span>]</span></a></div>
    <?php 
      include("menulateral.php"); 
      include("../submenus/modal/subirArchivos.php");
      include("cambiarempresa.php");
    ?>
    

    <!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <div class="br-header">
      <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
        <!-- Carga Nombre Empresa -->
        <a href="" class="nav-link nav-link-profile d-flex" style="align-items: center;" data-toggle="dropdown">
          <span class="logged-name hidden-sm-down" id="nEmpresa"></span>              
        </a>            

      <!-- BOTON SEARCH  -->
     <!--   <div class="input-group hidden-xs-down wd-170 transition">
          <input id="searchbox" type="text" class="form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-secondary" type="button"><i class="fa fa-search"></i></button>
          </span>          
        </div> input-group -->
      </div><!-- br-header-left -->


      <div class="br-header-right">
        <nav class="nav">

          <div class="dropdown">       

            <a href="#" class="nav-link pd-x-7 pos-relative">
              <!--<i class="icon ion-refresh tx-24" onclick="RefrescarPag()"></i>-->
              <i class="icon ion-refresh tx-24" onclick="RefrescarPag()"></i>
              <!-- start: if statement -->
             <!-- <span class="square-8 bg-danger pos-absolute t-15 r-0 rounded-circle"></span>
               end: if statement -->
            </a>
          </div><!-- dropdown -->
          
          <div class="dropdown">
            <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
              <i class="icon ion-ios-bell-outline tx-24"></i>
              <!-- start: if statement -->
              <span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle"></span>
              <!-- end: if statement -->
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-300 pd-0-force">
              <div class="d-flex align-items-center justify-content-between pd-y-10 pd-x-20 bd-b bd-gray-200">
                <label class="tx-12 tx-info tx-uppercase tx-semibold tx-spacing-2 mg-b-0">Notificaciones</label>
                <a href="" class="tx-11">Marcar como leído</a>
              </div><!-- d-flex -->

              <div class="media-list">
                <!-- loop starts here -->
                <a href="" class="media-list-link read">
                  <div class="media pd-x-20 pd-y-15">
                    <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                    <div class="media-body">
                      <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Suzzeth Bungaos</strong> tagged you and 18 others in a post.</p>
                      <span class="tx-12">October 03, 2017 8:45am</span>
                    </div>
                  </div><!-- media -->
                </a>
                <div class="pd-y-10 tx-center bd-t">
                  <a href="" class="tx-12"><i class="fa fa-angle-down mg-r-5"></i> Ver todas las notificaciones</a>
                </div>
              </div><!-- media-list -->
            </div><!-- dropdown-menu -->
          </div><!-- dropdown  hidden-sm-down-->
          <div class="dropdown">
            <div class="pd-l-5 pd-r-5" style="display: grid;">
              <!--<span class="nav-link nav-link-profile logged-name pd-0" id="nUsuario"></span>-->
              <span class="nav-link nav-link-profile logged-name pd-b-0" id="nUsuario"></span>
              <span class="logged-name d-flex justify-content-center" id="nUsuario_per"></span>
                                          
            </div>
          </div>
          <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
            
              
              
              <img src="http://via.placeholder.com/64x64" class="wd-32 rounded-circle" alt="">
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-200">
              <ul class="list-unstyled user-profile-nav">
                
                <li><a href="#" onclick="loadDiv('../divs/editarperfil.php',0,0,0)"><i class="icon ion-ios-person"></i> Editar perfil</a></li>
                <!--<li><a href=""><i class="icon ion-ios-gear"></i> Settings</a></li>
                <li><a href=""><i class="icon ion-ios-download"></i> Downloads</a></li>
                <li><a href=""><i class="icon ion-ios-star"></i> Favorites</a></li>
                <li><a href="#" onclick="CambiarEmpresa()"><i class="icon ion-ios-folder"></i> Cambiar Empresa</a></li>-->
                <li><a href="#" onclick="EnlistarEmpresas()"><i class="icon fa fa-building"></i> Cambiar Empresa</a></li>
                <li><a href="#" onclick="CerrarSession()"><i class="icon ion-power"></i> Cerrar Sesion</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->

        </nav>
        <div class="navicon-right d-none">
          <a id="btnRightMenu" href="" class="pos-relative">
            <i class="icon ion-ios-chatboxes-outline"></i>
            <!-- start: if statement -->
            <span class="square-8 bg-danger pos-absolute t-10 r--5 rounded-circle"></span>
            <!-- end: if statement -->
          </a>
        </div><!-- navicon-right -->
      </div><!-- br-header-right -->
    </div><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <div class="br-sideright">
      <ul class="nav nav-tabs sidebar-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" role="tab" href="#contacts"><i class="icon ion-ios-contact-outline tx-24"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" href="#attachments"><i class="icon ion-ios-folder-outline tx-22"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" href="#calendar"><i class="icon ion-ios-calendar-outline tx-24"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" href="#settings"><i class="icon ion-ios-gear-outline tx-24"></i></a>
        </li>
      </ul><!-- sidebar-tabs -->

      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane pos-absolute a-0 mg-t-60 overflow-y-auto active" id="contacts" role="tabpanel">
          <label class="sidebar-label pd-x-25 mg-t-25">Online Contacts</label>
          <div class="contact-list pd-x-10">
            <a href="" class="contact-list-link new">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-success"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0">Marilyn Tarter</p>
                  <span class="tx-12 op-5 d-inline-block">Clemson, CA</span>
                </div>
                <span class="tx-info tx-12"><span class="square-8 bg-info rounded-circle"></span> 1 new</span>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-success"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0 ">Belinda Connor</p>
                  <span class="tx-12 op-5 d-inline-block">Fort Kent, ME</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link new">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-success"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0">Britanny Cevallos</p>
                  <span class="tx-12 op-5 d-inline-block">Shiboygan Falls, WI</span>
                </div>
                <span class="tx-info tx-12"><span class="square-8 bg-info rounded-circle"></span> 3 new</span>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link new">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-success"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0">Brandon Lawrence</p>
                  <span class="tx-12 op-5 d-inline-block">Snohomish, WA</span>
                </div>
                <span class="tx-info tx-12"><span class="square-8 bg-info rounded-circle"></span> 1 new</span>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-success"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0">Andrew Wiggins</p>
                  <span class="tx-12 op-5 d-inline-block">Springfield, MA</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-success"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0">Theodore Gristen</p>
                  <span class="tx-12 op-5 d-inline-block">Nashville, TN</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-success"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0">Deborah Miner</p>
                  <span class="tx-12 op-5 d-inline-block">North Shore, CA</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
          </div><!-- contact-list -->


          <label class="sidebar-label pd-x-25 mg-t-25">Offline Contacts</label>
          <div class="contact-list pd-x-10">
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-gray-500"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0">Marilyn Tarter</p>
                  <span class="tx-12 op-5 d-inline-block">Clemson, CA</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-gray-500"></div>
                </div>
                <div class="mg-l-10">
                  <p class="mg-b-0">Belinda Connor</p>
                  <span class="tx-12 op-5 d-inline-block">Fort Kent, ME</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-gray-500"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0">Britanny Cevallos</p>
                  <span class="tx-12 op-5 d-inline-block">Shiboygan Falls, WI</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-gray-500"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0">Brandon Lawrence</p>
                  <span class="tx-12 op-5 d-inline-block">Snohomish, WA</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-gray-500"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0">Andrew Wiggins</p>
                  <span class="tx-12 op-5 d-inline-block">Springfield, MA</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-gray-500"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0">Theodore Gristen</p>
                  <span class="tx-12 op-5 d-inline-block">Nashville, TN</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                  <div class="contact-status-indicator bg-gray-500"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0">Deborah Miner</p>
                  <span class="tx-12 op-5 d-inline-block">North Shore, CA</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
          </div><!-- contact-list -->

        </div><!-- #contacts -->


        <div class="tab-pane pos-absolute a-0 mg-t-60 overflow-y-auto" id="attachments" role="tabpanel">
          <label class="sidebar-label pd-x-25 mg-t-25">Recent Attachments</label>
          <div class="media-file-list">
            <div class="media">
              <div class="pd-10 bg-primary wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="fa fa-file-image-o tx-28 tx-white"></i>
              </div>
              <div class="media-body">
                <p class="mg-b-0 tx-13">IMG_43445</p>
                <p class="mg-b-0 tx-12 op-5">JPG Image</p>
                <p class="mg-b-0 tx-12 op-5">1.2mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-purple wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="fa fa-file-video-o tx-28 tx-white"></i>
              </div>
              <div class="media-body">
                <p class="mg-b-0 tx-13">VID_6543</p>
                <p class="mg-b-0 tx-12 op-5">MP4 Video</p>
                <p class="mg-b-0 tx-12 op-5">24.8mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-success wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="fa fa-file-word-o tx-28 tx-white"></i>
              </div>
              <div class="media-body">
                <p class="mg-b-0 tx-13">Tax_Form</p>
                <p class="mg-b-0 tx-12 op-5">Word Document</p>
                <p class="mg-b-0 tx-12 op-5">5.5mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-warning wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="fa fa-file-pdf-o tx-28 tx-white"></i>
              </div>
              <div class="media-body">
                <p class="mg-b-0 tx-13">Getting_Started</p>
                <p class="mg-b-0 tx-12 op-5">PDF Document</p>
                <p class="mg-b-0 tx-12 op-5">12.7mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-warning wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="fa fa-file-pdf-o tx-28 tx-white"></i>
              </div>
              <div class="media-body">
                <p class="mg-b-0 tx-13">Introduction</p>
                <p class="mg-b-0 tx-12 op-5">PDF Document</p>
                <p class="mg-b-0 tx-12 op-5">7.7mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-primary wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="fa fa-file-image-o tx-28 tx-white"></i>
              </div>
              <div class="media-body">
                <p class="mg-b-0 tx-13">IMG_43420</p>
                <p class="mg-b-0 tx-12 op-5">JPG Image</p>
                <p class="mg-b-0 tx-12 op-5">2.2mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-primary wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="fa fa-file-image-o tx-28 tx-white"></i>
              </div>
              <div class="media-body">
                <p class="mg-b-0 tx-13">IMG_43447</p>
                <p class="mg-b-0 tx-12 op-5">JPG Image</p>
                <p class="mg-b-0 tx-12 op-5">3.2mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-purple wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="fa fa-file-video-o tx-28 tx-white"></i>
              </div>
              <div class="media-body">
                <p class="mg-b-0 tx-13">VID_6545</p>
                <p class="mg-b-0 tx-12 op-5">AVI Video</p>
                <p class="mg-b-0 tx-12 op-5">14.8mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-success wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="fa fa-file-word-o tx-28 tx-white"></i>
              </div>
              <div class="media-body">
                <p class="mg-b-0 tx-13">Secret_Document</p>
                <p class="mg-b-0 tx-12 op-5">Word Document</p>
                <p class="mg-b-0 tx-12 op-5">4.5mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
          </div><!-- media-list -->
        </div><!-- #history -->
        <div class="tab-pane pos-absolute a-0 mg-t-60 overflow-y-auto" id="calendar" role="tabpanel">
          <label class="sidebar-label pd-x-25 mg-t-25">Time &amp; Date</label>
          <div class="pd-x-25">
            <h2 id="brTime" class="tx-white tx-lato mg-b-5"></h2>
            <h6 id="brDate" class="tx-white tx-light op-3"></h6>
          </div>

          <label class="sidebar-label pd-x-25 mg-t-25">Events Calendar</label>
          <div class="datepicker sidebar-datepicker"></div>


          <label class="sidebar-label pd-x-25 mg-t-25">Event Today</label>
          <div class="pd-x-25">
            <div class="list-group sidebar-event-list mg-b-20">
              <div class="list-group-item">
                <div>
                  <h6 class="tx-white tx-13 mg-b-5 tx-normal">Roven's 32th Birthday</h6>
                  <p class="mg-b-0 tx-white tx-12 op-2">2:30PM</p>
                </div>
                <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
              </div><!-- list-group-item -->
              <div class="list-group-item">
                <div>
                  <h6 class="tx-white tx-13 mg-b-5 tx-normal">Regular Workout Schedule</h6>
                  <p class="mg-b-0 tx-white tx-12 op-2">7:30PM</p>
                </div>
                <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
              </div><!-- list-group-item -->
            </div><!-- list-group -->

            <a href="" class="btn btn-block btn-outline-secondary tx-uppercase tx-11 tx-spacing-2">+ Add Event</a>
            <br>
          </div>

        </div>
        <div class="tab-pane pos-absolute a-0 mg-t-60 overflow-y-auto" id="settings" role="tabpanel">
          <label class="sidebar-label pd-x-25 mg-t-25">Quick Settings</label>

          <div class="pd-y-20 pd-x-25 tx-white">
            <h6 class="tx-13 tx-normal">Sound Notification</h6>
            <p class="op-5 tx-13">Play an alert sound everytime there is a new notification.</p>
            <div class="pos-relative">
              <input type="checkbox" name="checkbox" class="switch-button" checked>
            </div>
          </div>

          <div class="pd-y-20 pd-x-25 tx-white">
            <h6 class="tx-13 tx-normal">2 Steps Verification</h6>
            <p class="op-5 tx-13">Sign in using a two step verification by sending a verification code to your phone.</p>
            <div class="pos-relative">
              <input type="checkbox" name="checkbox2" class="switch-button">
            </div>
          </div>

          <div class="pd-y-20 pd-x-25 tx-white">
            <h6 class="tx-13 tx-normal">Location Services</h6>
            <p class="op-5 tx-13">Allowing us to access your location</p>
            <div class="pos-relative">
              <input type="checkbox" name="checkbox3" class="switch-button">
            </div>
          </div>

          <div class="pd-y-20 pd-x-25 tx-white">
            <h6 class="tx-13 tx-normal">Newsletter Subscription</h6>
            <p class="op-5 tx-13">Enables you to send us news and updates send straight to your email.</p>
            <div class="pos-relative">
              <input type="checkbox" name="checkbox4" class="switch-button" checked>
            </div>
          </div>

          <div class="pd-y-20 pd-x-25 tx-white">
            <h6 class="tx-13 tx-normal">Your email</h6>
            <div class="pos-relative">
              <input type="email" name="email" class="form-control form-control-inverse transition pd-y-10" value="janedoe@domain.com">
            </div>
          </div>

          <div class="pd-y-20 pd-x-25">
            <h6 class="tx-13 tx-normal tx-white mg-b-20">More Settings</h6>
            <a href="" class="btn btn-block btn-outline-secondary tx-uppercase tx-11 tx-spacing-2">Account Settings</a>
            <a href="" class="btn btn-block btn-outline-secondary tx-uppercase tx-11 tx-spacing-2">Privacy Settings</a>
          </div>

        </div>
      </div><!-- tab-content -->
    </div><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    
    <div class="br-mainpanel">  
      
        <!-- AQUI SE CARGA UN ARCHIVO PHP DEPENDIENDO DE LA ACCION -->
    </div>


    <script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>
    <script src="../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="../lib/moment/moment.js"></script>
    <script src="../lib/jquery-ui/jquery-ui.js"></script>
    <script src="../lib/jquery-switchbutton/jquery.switchButton.js"></script>
    <script src="../lib/peity/jquery.peity.js"></script>
    <!--<script src="../lib/chartist/chartist.js"></script>-->
    <script src="../lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
    <script src="../lib/d3/d3.js"></script>
    <!--<script src="../lib/rickshaw/rickshaw.min.js"></script>-->

    <!-- NOTIFICACIONES MODAL -->
    <!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
    <script src="../js/sweetalert.min.js"></script>

    <script src="../js/bracket.js"></script>
    <script src="../js/ResizeSensor.js"></script>
    <!--<script src="../js/dashboard.js"></script>-->
    <script src="../js/load.js"></script>
    <script src="../js/globales.js"></script>
    <script src="../js/paginador.js"></script>

    
    
    <script src="../js/permisos_user.js"></script>
    
    <script src="../js/permisos_perfiles.js" ></script>
    <script src="../js/usuarios.js"></script>
    <script src="../js/submenus.js"></script>
    <script src="../js/empresa.js"></script>
    <script src="../js/recepcionlotes.js"></script>
    <script src="../js/almacendigital.js"></script>
    <script src="../js/FiltroAvanzado.js"></script>

    <!-- Clases -->
    <script src="../class/usuario.js"></script>
    
    <script>
           


      function openPDF(){
          window.open('../archivospdf/ResultadosDiarios310119.pdf','_blank');
      }
      
      function enviarReporte(){
        $.post("../../login/validarcorreo/valida.php",
              {
                      //parametros
                      destinatarios: "arturo.gallegos@dublock.com",
                      mensaje: "http://localhost/crm/DashEmpresa/gestordearchivos/visorpdf.php?em=2nar=ResultadosDiarios310119.pdf" + 
                                "<br/>http://localhost/crm/DashEmpresa/archivospdf/ResultadosDiarios310119.pdf",
                      asunto: "Correo Prueba Expediente",

                  },
                  function(data,status){                  
                  });
      }
      $(function(){
        'use strict'

        // FOR DEMO ONLY
        // menu collapsed by default during first page load or refresh with screen
        // having a size between 992px and 1299px. This is intended on this page only
        // for better viewing of widgets demo.
        $(window).resize(function(){
          minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
          if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
            // show only the icons and hide left menu label by default
            $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
            $('body').addClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideUp();
          } else if(window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
            $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
            $('body').removeClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideDown();
          }
        }
      });
    </script>

<?php
  
  if(isset($_GET["mod"])){
   // include("redireccionamiento.php");
  }
  
?>


  </body>
</html>
