<?php
session_start();  
    if($_SESSION["usuario21"] == "")
    {
      session_destroy(); 
      echo "<script> swal('Hubo un problema', 'La session finalizado. Favor de introducir sus datos de acceso nuevamente..', 'error'); </script>";
      echo "<script> window.location='index.php/Login' </script>";
      exit(); 
    } 
?>

<div class="br-pagebody pd-l-0 pd-r-0">
	<div class="br-section-wrapper">
		
		<h4 class="tx-gray-800">Administracion de Usuarios</h4>    
    	<p class="mg-b-30"></p>		

		<div class="row justify-content-around">
	        <div class="col-lg-6 col-md-4 col-sm-6">	          
	            <button class="btn btn-outline-primary btn-block mg-b-10" onclick="CargaListaUsuarios()">Lista de Usuarios</button>
			</div>
	        <div class="col-lg-6 col-md-4 col-sm-6">
	            <button class="btn btn-outline-primary btn-block mg-b-10" onclick="NuevoUsuario()">Crear Usuario</button>
			</div>
		</div>

	</div>

	<div class="br-section-wrapper pd-t-0" id="divdinamico">
		
	</div>


</div>