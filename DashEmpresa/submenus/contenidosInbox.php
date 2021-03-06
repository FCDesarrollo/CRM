<?php
  session_start();
  if($_SESSION['RFCEmpresa'] == ""){
    $_SESSION['idempresalog'] = 0;    
    echo "<script> window.location='../../../../usuario.php' </script>";
        exit(); 
  }

?>


<div class="d-flex align-items-center justify-content-start mg-b-20 mg-sm-b-30">

        <!--<button id="showSubLeft" class="btn btn-secondary mg-r-10 hidden-lg-up"><i class="fa fa-navicon"></i></button>-->

        <!-- START: DISPLAYED FOR MOBILE ONLY 
        <div class="dropdown hidden-sm-up">
          <a href="#" class="btn btn-outline-secondary" data-toggle="dropdown"><i class="icon ion-more"></i></a>
          <div class="dropdown-menu pd-10">
            <nav class="nav nav-style-1 flex-column">
              <a href="" class="nav-link">Share</a>
              <a href="" class="nav-link">Download</a>
              <div class="dropdown-divider"></div>
              <a href="" class="nav-link">Edit</a>
              <a href="" class="nav-link">Delete</a>
            </nav>
          </div>dropdown-menu 
        </div> dropdown -->
        <!-- END: DISPLAYED FOR MOBILE ONLY -->

        <div class="btn-group hidden-xs-down">
          <a href="#" class="btn btn-outline-info" onclick="CompartirArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')">Compartir</a>
          <a href="#" class="btn btn-outline-info" onclick="DescargarArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')">Descargar</a>
          <a href="#" class="btn btn-outline-info" onclick="SubirArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')">Cargar archivos</a>
        </div><!-- btn-group
        <div class="btn-group mg-l-10 hidden-xs-down">
          <a href="#" class="btn btn-outline-info">Edit</a>
          <a href="#" class="btn btn-outline-info">Delete</a>
        </div> btn-group 

        <div class="btn-group mg-l-auto hidden-sm-down">
          <a href="#" class="btn btn-outline-info active">All</a>
          <a href="#" class="btn btn-outline-info">Images</a>
          <a href="#" class="btn btn-outline-info">Videos</a>
          <a href="#" class="btn btn-outline-info">Documents</a>
          <a href="#" class="btn btn-outline-info">Audio</a>
        </div>btn-group -->

        <!-- START: DISPLAYED FOR MOBILE ONLY 
        <div class="dropdown mg-l-auto hidden-md-up">
          <a href="#" class="btn btn-outline-secondary" data-toggle="dropdown">All <i class="fa fa-angle-down mg-l-5"></i></a>
          <div class="dropdown-menu dropdown-menu-right pd-10">
            <nav class="nav nav-style-1 flex-column">
              <a href="" class="nav-link">All</a>
              <a href="" class="nav-link">Images</a>
              <a href="" class="nav-link">Videos</a>
              <a href="" class="nav-link">Documents</a>
              <a href="" class="nav-link">Audio</a>
            </nav>
          </div>dropdown-menu 
        </div> dropdown -->
        <!-- END: DISPLAYED FOR MOBILE ONLY -->

      </div>
<div class="br-pagebody pd-x-0">
        <div class="card bd-0 shadow-base">
          <table class="table mg-b-0 display" cellspacing="0" id="t-Archivos" >
            <thead>
              <tr>
                <th class="wd-5p">
                  <!--<label class="ckbox mg-b-0">
                    <input type="checkbox"><span></span>
                  </label>-->
                </th>
                <th class="tx-10-force tx-mont tx-medium">Nombre</th>
                <th class="tx-10-force tx-mont tx-medium hidden-xs-down">Fecha de modificación</th>
                <th class="wd-5p"></th>
              </tr>
            </thead>
            <tbody id="t-ArchivosBody">
                <!--<tr>
                  <td></td>
                  <td>
                    <i class="icon ion-ios-folder-outline tx-24 tx-warning lh-0 valign-middle"></i>
                    <span class="pd-l-5">No hay archivos disponibles</span>
                  </td>
                  <td>DD/MM/YYYY HH/MM/SS</td>
                </tr>    -->          
            <!--  <tr>
                <td class="valign-middle">
                  <label class="ckbox mg-b-0">
                    <input type="checkbox"><span></span>
                  </label>
                </td>
                <td>
                  <i class="icon ion-ios-folder-outline tx-24 tx-warning lh-0 valign-middle"></i>
                  <span class="pd-l-5">Camera Uploads</span>
                </td>
                <td class="hidden-xs-down">---</td>
                <td class="dropdown">
                  <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i class="icon ion-more"></i></a>
                  <div class="dropdown-menu dropdown-menu-right pd-10">
                    <nav class="nav nav-style-1 flex-column">
                      <a href="" class="nav-link">Info</a>
                      <a href="" class="nav-link">Download</a>
                      <a href="" class="nav-link">Rename</a>
                      <a href="" class="nav-link">Move</a>
                      <a href="" class="nav-link">Copy</a>
                      <a href="" class="nav-link">Delete</a>
                    </nav>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="valign-middle">
                  <label class="ckbox mg-b-0">
                    <input type="checkbox"><span></span>
                  </label>
                </td>
                <td>
                  <i class="icon ion-ios-folder-outline tx-24 tx-warning lh-0 valign-middle"></i>
                  <span class="pd-l-5">My Collections</span>
                </td>
                <td class="hidden-xs-down">---</td>
                <td class="dropdown">
                  <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i class="icon ion-more"></i></a>
                  <div class="dropdown-menu dropdown-menu-right pd-10">
                    <nav class="nav nav-style-1 flex-column">
                      <a href="" class="nav-link">Info</a>
                      <a href="" class="nav-link">Download</a>
                      <a href="" class="nav-link">Rename</a>
                      <a href="" class="nav-link">Move</a>
                      <a href="" class="nav-link">Copy</a>
                      <a href="" class="nav-link">Delete</a>
                    </nav>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="valign-middle">
                  <label class="ckbox mg-b-0">
                    <input type="checkbox"><span></span>
                  </label>
                </td>
                <td>
                  <i class="icon ion-ios-folder-outline tx-24 tx-warning lh-0 valign-middle"></i>
                  <span class="pd-l-5">E-Book</span>
                </td>
                <td class="hidden-xs-down">---</td>
                <td class="dropdown">
                  <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i class="icon ion-more"></i></a>
                  <div class="dropdown-menu dropdown-menu-right pd-10">
                    <nav class="nav nav-style-1 flex-column">
                      <a href="" class="nav-link">Info</a>
                      <a href="" class="nav-link">Download</a>
                      <a href="" class="nav-link">Rename</a>
                      <a href="" class="nav-link">Move</a>
                      <a href="" class="nav-link">Copy</a>
                      <a href="" class="nav-link">Delete</a>
                    </nav>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="valign-middle">
                  <label class="ckbox mg-b-0">
                    <input type="checkbox"><span></span>
                  </label>
                </td>
                <td>
                  <i class="fa fa-file-pdf-o tx-22 tx-danger lh-0 valign-middle"></i>
                  <span class="pd-l-5">MyResume.pdf</span>
                </td>
                <td class="hidden-xs-down">10/11/2017 7:22am</td>
                <td class="dropdown">
                  <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i class="icon ion-more"></i></a>
                  <div class="dropdown-menu dropdown-menu-right pd-10">
                    <nav class="nav nav-style-1 flex-column">
                      <a href="" class="nav-link">Info</a>
                      <a href="" class="nav-link">Download</a>
                      <a href="" class="nav-link">Rename</a>
                      <a href="" class="nav-link">Move</a>
                      <a href="" class="nav-link">Copy</a>
                      <a href="" class="nav-link">Delete</a>
                    </nav>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="valign-middle">
                  <label class="ckbox mg-b-0">
                    <input type="checkbox"><span></span>
                  </label>
                </td>
                <td>
                  <img src="../img/img18.jpg" class="wd-20" alt="">
                  <span class="pd-l-5">23424343.jpg</span>
                </td>
                <td class="hidden-xs-down">10/11/2017 7:22am</td>
                <td class="dropdown">
                  <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i class="icon ion-more"></i></a>
                  <div class="dropdown-menu dropdown-menu-right pd-10">
                    <nav class="nav nav-style-1 flex-column">
                      <a href="" class="nav-link">Info</a>
                      <a href="" class="nav-link">Download</a>
                      <a href="" class="nav-link">Rename</a>
                      <a href="" class="nav-link">Move</a>
                      <a href="" class="nav-link">Copy</a>
                      <a href="" class="nav-link">Delete</a>
                    </nav>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="valign-middle">
                  <label class="ckbox mg-b-0">
                    <input type="checkbox"><span></span>
                  </label>
                </td>
                <td>
                  <i class="icon ion-ios-folder-outline tx-24 tx-warning lh-0 valign-middle"></i>
                  <span class="pd-l-5">Illustrations</span>
                </td>
                <td class="hidden-xs-down">---</td>
                <td class="dropdown">
                  <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i class="icon ion-more"></i></a>
                  <div class="dropdown-menu dropdown-menu-right pd-10">
                    <nav class="nav nav-style-1 flex-column">
                      <a href="" class="nav-link">Info</a>
                      <a href="" class="nav-link">Download</a>
                      <a href="" class="nav-link">Rename</a>
                      <a href="" class="nav-link">Move</a>
                      <a href="" class="nav-link">Copy</a>
                      <a href="" class="nav-link">Delete</a>
                    </nav>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="valign-middle">
                  <label class="ckbox mg-b-0">
                    <input type="checkbox"><span></span>
                  </label>
                </td>
                <td>
                  <i class="icon ion-ios-folder-outline tx-24 tx-warning lh-0 valign-middle"></i>
                  <span class="pd-l-5">Movies</span>
                </td>
                <td class="hidden-xs-down">---</td>
                <td class="dropdown">
                  <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i class="icon ion-more"></i></a>
                  <div class="dropdown-menu dropdown-menu-right pd-10">
                    <nav class="nav nav-style-1 flex-column">
                      <a href="" class="nav-link">Info</a>
                      <a href="" class="nav-link">Download</a>
                      <a href="" class="nav-link">Rename</a>
                      <a href="" class="nav-link">Move</a>
                      <a href="" class="nav-link">Copy</a>
                      <a href="" class="nav-link">Delete</a>
                    </nav>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="valign-middle">
                  <label class="ckbox mg-b-0">
                    <input type="checkbox"><span></span>
                  </label>
                </td>
                <td>
                  <i class="fa fa-file-audio-o tx-22 tx-primary lh-0 valign-middle"></i>
                  <span class="pd-l-5">InTheEnd.mp3</span>
                </td>
                <td class="hidden-xs-down">10/11/2017 3:20am</td>
                <td class="dropdown">
                  <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i class="icon ion-more"></i></a>
                  <div class="dropdown-menu dropdown-menu-right pd-10">
                    <nav class="nav nav-style-1 flex-column">
                      <a href="" class="nav-link">Info</a>
                      <a href="" class="nav-link">Download</a>
                      <a href="" class="nav-link">Rename</a>
                      <a href="" class="nav-link">Move</a>
                      <a href="" class="nav-link">Copy</a>
                      <a href="" class="nav-link">Delete</a>
                    </nav>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="valign-middle">
                  <label class="ckbox mg-b-0">
                    <input type="checkbox"><span></span>
                  </label>
                </td>
                <td>
                  <i class="fa fa-file-audio-o tx-22 tx-primary lh-0 valign-middle"></i>
                  <span class="pd-l-5">Symphony.mp3</span>
                </td>
                <td class="hidden-xs-down">10/11/2017 5:51am</td>
                <td class="dropdown">
                  <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i class="icon ion-more"></i></a>
                  <div class="dropdown-menu dropdown-menu-right pd-10">
                    <nav class="nav nav-style-1 flex-column">
                      <a href="" class="nav-link">Info</a>
                      <a href="" class="nav-link">Download</a>
                      <a href="" class="nav-link">Rename</a>
                      <a href="" class="nav-link">Move</a>
                      <a href="" class="nav-link">Copy</a>
                      <a href="" class="nav-link">Delete</a>
                    </nav>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="valign-middle">
                  <label class="ckbox mg-b-0">
                    <input type="checkbox"><span></span>
                  </label>
                </td>
                <td>
                  <i class="fa fa-file-audio-o tx-22 tx-primary lh-0 valign-middle"></i>
                  <span class="pd-l-5">Clarity.mp3</span>
                </td>
                <td class="hidden-xs-down">10/11/2017 8:22am</td>
                <td class="dropdown">
                  <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i class="icon ion-more"></i></a>
                  <div class="dropdown-menu dropdown-menu-right pd-10">
                    <nav class="nav nav-style-1 flex-column">
                      <a href="" class="nav-link">Info</a>
                      <a href="" class="nav-link">Download</a>
                      <a href="" class="nav-link">Rename</a>
                      <a href="" class="nav-link">Move</a>
                      <a href="" class="nav-link">Copy</a>
                      <a href="" class="nav-link">Delete</a>
                    </nav>
                  </div>
                </td>
              </tr>-->
            </tbody> 
          </table>
        </div>
      </div>

        <div id="pdfvista" class='embed-responsive' style='padding-bottom:150%'>
          <embed src="" type="application/pdf"  height="300px" width="100%" class="responsive">
        </div>        

