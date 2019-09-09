<?php
  session_start();
  if($_SESSION['RFCEmpresa'] == ""){
    $_SESSION['idempresalog'] = 0;    
    echo "<script> window.location='../../../../usuario.php' </script>";
        exit(); 
  }

?>
<!--
<!DOCTYPE html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bracket">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/bracket/img/bracket-social.png">

    
    <meta property="og:url" content="http://themepixels.me/bracket">
    <meta property="og:title" content="Bracket">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/bracket/img/bracket-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/bracket/img/bracket-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">
    
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
    <link href="../lib/highlightjs/github.css" rel="stylesheet">
    <link href="../lib/select2/css/select2.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="../css/bracket.css">
  </head>

  <body>-->

    <!-- ########## START: LEFT PANEL ########## -->
    <!--<div class="br-logo"><a href=""><span>[</span>bracket<span>]</span></a></div>-->
    <!-- ########## END: LEFT PANEL ########## -->

    <div class="btn-group hidden-xs-down">
          <a href="#" class="btn btn-outline-info" onclick="CompartirArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')">Compartir</a>
          <a href="#" class="btn btn-outline-info" onclick="DescargarArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')">Descargar</a>
          <a href="#" class="btn btn-outline-info" onclick="SubirArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')">Cargar archivos</a>
        </div><!-- btn-group -->
    <!-- ########## END: RIGHT PANEL ########## ---> 
    <div class="br-pagebody pd-x-0">
        <div class="card bd-0 shadow-base">
          <table class="mg-b-0 display table table-bordered table-colored table-primary" cellspacing="0" id="t-Archivos" >
            <thead>
              <tr>
                <th class="wd-5p"></th>
                <th class="tx-10-force tx-mont tx-medium">Nombre</th>
                <th class="tx-10-force tx-mont tx-medium hidden-xs-down">Fecha de modificación</th>
                <th class="wd-5p"></th>
              </tr>
            </thead>
            <tbody id="t-ArchivosBody">
              <!--<tr>
                <td class="valign-middle">
                  <label class="ckbox mg-b-0">
                    <input type="checkbox"><span></span>
                  </label>
                </td>
                <td>
                  <i class="icon ion-ios-folder-outline tx-24 tx-warning lh-0 valign-middle"></i>
                  <span class="pd-l-5">Nombre Uploads</span>
                </td>
                <td class="hidden-xs-down">24/08/2019</td>
                <td class="dropdown">
                  <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i class="icon ion-more"></i></a>
                  <div class="dropdown-menu dropdown-menu-right pd-10">
                    <nav class="nav nav-style-1 flex-column">
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

    <!--<script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>
    <script src="../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="../lib/moment/moment.js"></script>
    <script src="../lib/jquery-ui/jquery-ui.js"></script>
    <script src="../lib/jquery-switchbutton/jquery.switchButton.js"></script>
    <script src="../lib/peity/jquery.peity.js"></script>
    <script src="../lib/highlightjs/highlight.pack.js"></script>    
    <script src="../lib/select2/js/select2.min.js"></script>

    <script src="../js/bracket.js"></script>
    <script src="../lib/datatables/jquery.dataTables.js"></script>
    <script src="../lib/datatables-responsive/dataTables.responsive.js"></script>
    <script>
      $(function(){
        'use strict';

        $('#t-Archivos').DataTable({
          responsive: true,
          serverSide: false,
          language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ Registros/Página',
          }
        });
        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
  </body>
</html>-->