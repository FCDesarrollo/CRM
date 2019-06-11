<?php
  session_start();
  if($_SESSION['RFCEmpresa'] == ""){
    $_SESSION['idempresalog'] = 0;    
    echo "<script> window.location='../../../../usuario.php' </script>";
    exit();
  }
?>		

<div class="br-pagebody pd-x-0 d-none">
    <div class="card bd-0 shadow-base">
      <table class="table mg-b-0" id="t-lotes">
        <thead>
          	<tr>                
            	<th class="tx-10-force tx-mont tx-medium">Archivo(s)</th>
            	<th></th>            
            	<th class="tx-10-force tx-mont tx-medium">Cargar Archivo</th>
         	</tr>
        </thead>
        <tbody>
			<tr>				
	            <td class="valign-middle">	              
	                <a href="../lotes/Remision.xlsx" id="DescargarP" download class="nav-link">PlantillaProduccion.xlsx</a>
	            </td>
	            <td></td>
	         	<td>
					<div class="row">

					 	
				        <div class="col-sm-12 mg-t-20 mg-sm-t-0 justify-content-end">
							<label class="custom-file">
							  <input type="file" id="file" name="archivo" onchange="return fileValidation()" class="custom-file-input">
							  <span class="custom-file-control">Seleccionar...</span>
							</label>
						</div>
				    <!--   <div class="col-sm-4 mg-t-20 mg-sm-t-0">	          
				            <button class="btn btn-outline-primary btn-block mg-b-10" onclick="ProcesarPlantilla()">Procesar Archivo</button>
						</div>-->
					</div>
	        	</td> 
	        </tr>
        </tbody> 
      </table>
    </div>
</div>

<div id="carga-movtos" class="d-none">
	<div class="row justify-content-end">
	    <div class="col-sm-3 mg-b-5 mg-sm-t-0">	          
	        <button class="btn btn-primary btn-block mg-t-10">Cargar</button>
		</div>
	    <div class="col-sm-3 mg-b-5 mg-sm-t-0">	          
	        <button class="btn btn-danger btn-block mg-t-10" onclick="CancelaCarga()">Cancelar</button>
		</div>		
	</div>

	<table class="table display responsive nowrap dataTable no-footer dtr-inline collapsed" id="t-Movtos">
	    <thead>
	      	<tr>
	        	<th class="tx-10-force tx-mont tx-medium">Fecha</th>
	        	<th class="tx-10-force tx-mont tx-medium">Cod.Producto</th>
	        	<th class="tx-10-force tx-mont tx-medium">Total</th>
	        	<th class="tx-10-force tx-mont tx-medium">Estatus</th>
	        	<th class="tx-10-force tx-mont tx-medium">Descripcion</th>
	     	</tr>
	    </thead>
	    <tbody>

	    </tbody>
	</table>
</div>
		