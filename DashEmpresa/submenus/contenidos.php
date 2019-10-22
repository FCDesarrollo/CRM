<?php
  session_start();
  if($_SESSION['RFCEmpresa'] == ""){
    $_SESSION['idempresalog'] = 0;    
    echo "<script> window.location='../../../../usuario.php' </script>";
        exit(); 
  }
  include("modal/FiltroAvanzadoContable.php");
  //include("../submenus/descargas.php");
?>


<div class="d-flex align-items-center justify-content-start mg-b-20 mg-sm-b-30">

  <div class="btn-group hidden-xs-down">
    <a href="#" class="btn btn-outline-info" data-toggle="modal" data-target="#CompartirLinks" onclick="CompartirArchivos('<?php echo $_SESSION['RFCEmpresa']; ?>')">Compartir</a>
    <a href="#" class="btn btn-outline-info" onclick="DescargarArchivosCon()">Descargar</a>

    <a href="#" class="btn btn-outline-info mg-r-5" onclick="FiltroAvanzado('ExpedientesContables')"><i class="icon ion-funnel mg-r-10"></i>Filtro</a>              
    <input id="buscar"  class="form-control is-info" type="text"  placeholder="Escriba algo para filtrar" onkeyup="doSearch('t-Archivos', 'buscar')"/>
  </div>

</div>
<div class="br-pagebody pd-x-0">
        <div class="card bd-0 shadow-base">
          <table class="table mg-b-0" id="t-Archivos">
            <thead>
              <tr>
                <th class="wd-5p"></th>
                <th class="tx-10-force tx-mont tx-medium">Servicio</th>
                <th class="tx-10-force tx-mont tx-medium">Nombre Archivo</th>
                <th class="tx-10-force tx-mont tx-medium hidden-xs-down">Fecha de Corte</th>
                <th class="tx-10-force tx-mont tx-medium hidden-xs-down">Agente</th>
                <th class="wd-5p"></th>
              </tr>
            
            </thead>
             <tbody>

            </tbody> 
          </table>

        </div>
      </div>   
   
        </div><!-- br-section-wrapper -->
      </div> 


<!--MODAL-->
<div class="modal" id="CompartirLinks">
    <div class="modal-dialog" role="document">
      <div class="modal-content bd-0">
        <div class="modal-header pd-y-20 pd-x-25">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Compartir Archivos</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
          </button>
        </div>


        <div class="modal-body pd-25">          
          <p class="mg-b-5" id="iden">Si desea compartir con mas de un destinatario debera separar los destinatarios con un punto y coma(;).</p>        
          <div class="form-group">
            <input type="email" id="destinatarios" class="form-control pd-y-12" placeholder="Introducir Correo(s)">
          </div> 
          <div class="form-group">
              <textarea rows="6" id="textarea_links" class="form-control"></textarea>                        
          </div>
        </div>


        <div class="modal-footer">  
          <button type="button" onclick="EnviarLinks()" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Compartir</button>                
          <button type="button" data-dismiss="modal" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Cancelar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
</div>

<script>
  function doSearch(nomtabla, nominput) {
    const tableReg = document.getElementById(nomtabla);
    const searchText = document.getElementById(nominput).value.toLowerCase();
    let total = 0;
    // Recorremos todas las filas con contenido de la tabla
    for (let i = 1; i < tableReg.rows.length; i++) {
        // Si el td tiene la clase "noSearch" no se busca en su cntenido
        if (tableReg.rows[i].classList.contains("noSearch")) {
            continue;
        }

        let found = false;
        const cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
        // Recorremos todas las celdas
        for (let j = 0; j < cellsOfRow.length && !found; j++) {
            const compareWith = cellsOfRow[j].innerHTML.toLowerCase();
            // Buscamos el texto en el contenido de la celda
            if (searchText.length == 0 || compareWith.indexOf(searchText) > -1) {
                found = true;
                total++;
            }
        }
        if (found) {
            tableReg.rows[i].style.display = '';
        } else {
            // si no ha encontrado ninguna coincidencia, esconde la
            // fila de la tabla
            tableReg.rows[i].style.display = 'none';
        }
    }

}
</script>