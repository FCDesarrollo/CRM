<?php
  session_start();
  if($_SESSION['RFCEmpresa'] == ""){
    $_SESSION['idempresalog'] = 0;    
    echo "<script> window.location='../../../../usuario.php' </script>";
        exit(); 
  }
  include("modal/FiltroAvanzado.php");
  
?>

<!--<div class="btn-group hidden-xs-down">-->


<div class="br-pagebody pd-x-0">
    
  <div id="expalm"> <!--Expediente Almacen-->
    
          <!--<a href="#" class="btn btn-outline-info" onclick="CompartirArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')">Compartir</a>
          <a href="#" class="btn btn-outline-info" onclick="DescargarArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')">Descargar</a>-->
      <div class="row">
        <div class="col-6">
            
            <h5 id="tittle-sub" class="tx-16 tx-uppercase tx-inverse tx-semibold tx-spacing-1"></h5>
        </div>
        <div class="col-6 d-flex justify-content-end">
          <div class="btn-group pd-b-20">
            <a href="#" class="btn btn-outline-info mg-r-5" onclick="SubirArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')"><i class="fa fa-plus-circle mg-r-10"></i>Nuevo</a>              
          </div>
          <div class="btn-group pd-b-20">
            <a href="#" class="btn btn-outline-info mg-r-5" onclick="FiltroAvanzado('ExpedientesDigitales')"><i class="icon ion-funnel mg-r-10"></i>Filtro</a>              
          </div>              
        </div>
    </div>     
    <div class="card bd-0 shadow-base mg-b-15">
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

    <div class="dataTables_wrapper no-footer">
        <?php
          include("paginador.php");
        ?>
    </div>


  </div>

  <div id="DivArchivoDetalle" class="d-none">
    <div class="row pd-b-15">
      <div class="col-1 d-flex justify-content-center">
        <a href="#" onclick="RegresarPagina()" class="btn btn-outline-danger btn-icon rounded-circle mg-r-5">
          <div>
            <i class="fa fa-arrow-left"></i>
          </div>
        </a>
      </div>
      <div class="col-11 d-flex align-items-center">
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mt-11">
          Resumen detallado de la carga de expedientes digitales.
        </h6>
      </div>
    </div>     
    <div class="card bd-0 shadow-base">
      <table class="table mg-b-0" id="t-ArchivoDetalle">
        <thead>
          <tr>              
            <th class="tx-10-force tx-mont tx-medium">Archivo</th>
            <th class="tx-10-force tx-mont tx-medium">Cargado</th>
            <th class="tx-10-force tx-mont tx-medium">Detalle</th>              
          </tr>
        </thead>
         <tbody>

        </tbody> 
        </table>  
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
      <div class="col-sm-6 d-flex justify-content-end d-none">
        <a href="#" onclick="ShareFiles('t-ArchivosALM')" class="btn btn-outline-teal btn-icon rounded-circle mg-r-5">
          <div>
            <i class="fa fa-share-alt"></i>
          </div>
        </a>
        <a href="#" onclick="DownFiles('t-ArchivosALM')" class="btn btn-outline-secondary btn-icon rounded-circle mg-r-5">
          <div>
            <i class="fa fa-download mg-r-0"></i>
          </div>
        </a>
        <a href="#" onclick="DeleteFiles('t-ArchivosALM')" class="btn btn-outline-danger btn-icon rounded-circle mg-r-5">
          <div>
            <i class="fa fa-trash mg-r-0"></i>
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
              <th class="tx-10-force tx-mont tx-medium">Agente</th>
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

<script>
  SubMenu_Tittle();
</script>
