<?php
  session_start();
  if($_SESSION['RFCEmpresa'] == ""){
    $_SESSION['idempresalog'] = 0;    
    echo "<script> window.location='../../../../usuario.php' </script>";
        exit(); 
  }

?>

<!--<div class="btn-group hidden-xs-down">-->


<div class="br-pagebody pd-x-0">
    
  <div id="expalm"> <!--Expediente Almacen-->
    <div class="btn-group pd-b-20">
          <!--<a href="#" class="btn btn-outline-info" onclick="CompartirArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')">Compartir</a>
          <a href="#" class="btn btn-outline-info" onclick="DescargarArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')">Descargar</a>-->
          <a href="#" class="btn btn-outline-info" onclick="SubirArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')"><i class="fa fa-plus-circle mg-r-10"></i>Nuevo</a>

    </div>     
    <div class="card bd-0 shadow-base">
      <table class="mg-b-0 display table table-bordered" cellspacing="0" id="t-ExpDigitales">
        <thead>
          <tr>
            <th class="tx-10-force tx-mont tx-medium">Fecha</th>
            <th class="tx-10-force tx-mont tx-medium">Usuario</th>
            <!--<th class="tx-10-force tx-mont tx-medium hidden-xs-down">Rubro</th>-->
            <th class="tx-10-force tx-mont tx-medium">Rubro</th>
            <th class="tx-10-force tx-mont tx-medium">Sucursal</th>
            <th class="tx-10-force tx-mont tx-medium">Detalle</th>
            <th class="wd-5p text-center"><em class="fa fa-cog"></em></th>
          </tr>
        </thead>
        <!--<tbody id="t-ArchivosBody">-->
        <tbody>
                                   
        </tbody> 
      </table>
    </div>

    <div id="datatable1_wrapper" class="dataTables_wrapper no-footer pd-t-10">
      <div class="dataTables_paginate paging_simple_numbers" id="datatable1_paginate">
        <a class="paginate_button previous disabled" href="#" aria-controls="datatable1" data-dt-idx="0" tabindex="0"  id="datatable1_previous">Atras</a>
        <span id="paginador">
          <!--<a href="" class="paginate_button current" aria-controls="datatable1" data-dt-idx="1" tabindex="0">1</a>
          <a class="paginate_button " aria-controls="datatable1" data-dt-idx="2" tabindex="0">2</a>
          <a class="paginate_button " aria-controls="datatable1" data-dt-idx="3" tabindex="0">3</a>-->
        </span>
        <a class="paginate_button next" href="#" aria-controls="datatable1" data-dt-idx="7" tabindex="0" onclick="SiguientePag()" id="datatable1_next">Siguiente</a>
      </div>  
    </div>
  </div>


 
  <div id="ArchivosALM" class="d-none">
    <div class="row pd-b-15">
      <div class="col-sm-6">
        <a href="#" onclick="RegresarPagina()" class="btn btn-outline-danger btn-icon rounded-circle mg-r-5">
          <div>
            <i class="fa fa-arrow-left"></i>
          </div>
        </a>
      </div>
      <div class="col-sm-6 d-flex justify-content-end">
        <a href="#" onclick="ShareFileAlm()" class="btn btn-outline-success btn-icon rounded-circle mg-r-5">
          <div>
            <i class="fa fa-share-alt"></i>
          </div>
        </a>
        <a href="#" onclick="DownFileAlm()" class="btn btn-outline-success btn-icon rounded-circle mg-r-5">
          <div>
            <i class="fa fa-download mg-r-0"></i>
          </div>
        </a>        
      </div>
      <!--<div class="col-sm-11 align-self-sm-center">
        <h6 id="p_info"></h6>
      </div>-->
    </div>  
    <div class="card bd-0 shadow-base">
        <table class="table mg-b-0" id="t-ArchivosALM">
          <thead>
            <tr>
              <th class="wd-5p"></th>
              <th class="tx-10-force tx-mont tx-medium">Archivo (s)</th>
              <th class="tx-10-force tx-mont tx-medium">Estatus</th>
              <th class="tx-10-force tx-mont tx-medium">Fecha Procesado</th>
              <th class="wd-5p"></th>
            </tr>
          </thead>
           <tbody>

          </tbody> 
        </table>
    </div>
    <div class="row justify-content-end">
        
    </div>
  </div>  
  

</div>

<!--<div id="pdfvista" class='embed-responsive' style='padding-bottom:150%'>
  <embed src="" type="application/pdf"  height="300px" width="100%" class="responsive">
</div> -->
