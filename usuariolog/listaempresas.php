<?php
session_start();  
    //Si no hay sesión activa, lo direccionamos al index.php (inicio de sesión) 
    if($_SESSION["usuario21"] == "")
    {        
      session_destroy(); echo "<script> window.location='index.php' </script>";
      exit(); 
    } 
?>


<!-- <div class="container">
    <div class="listaempresas">
        <form id="FormListEmp" action="DashEmpresa/" method="POST">
            <input type="hidden" name="idusuariolog" id="idusuariolog" value="<?php //echo $_SESSION['idusuario']; ?>" />    
            <input type="hidden" name="idempresalog" id="idempresalog" />
            <div class="btn-group btn-group-justified btn-group-emp" role="group" aria-label="..."> 
                <div class="btn-group btn-listemp" role="group">
                    <button onclick="Vincularlog();" type="button" class="btn btn-primary">Vincular</button>
                </div>
                <div class="btn-group btn-listemp" role="group">
                    <button type="button" onclick="Desvincula()" class="btn btn-default">Desvincular</button>
                </div>
            </div>        
            <div class="form-group"> 
                <label for="sel2">Lista de Empresas:</label>
                <select multiple class="form-control" ondblclick="AbreEmpresa()" id="sel2"></select>
            </div>
        </form>
    </div>
</div> -->

<div id="DesvinculaModal" class="modal fade">
	<div class="modal-dialog modalSelect3">
		<div class="modal-content">
			<div class="modal-body"> 
                <label>¿Desea Desvincular la empresa seleccionada?</label>
                <div class="btn-group btn-group-justified btn-group-emp"> 
                    <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $_SESSION['idusuario']; ?>" />    
                    <div class="btn-group btn-listemp" role="group">
                        <button type="button" onclick="DesvinculaEmpresa()" class="btn btn-danger btn-listemp">Desvincular</button>
                    </div>
                    <div class="btn-group btn-listemp" role="group">    
                        <button type="button" id="cerrar" data-dismiss="modal" class="btn btn-secondary btn-listemp">Cerrar</button>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div> 



<script>
    function Desvincula(){
        var select = document.getElementById("sel2");
        var select2 = $("#idusuario").value;
        if(select.selectedIndex!=-1){         
             $('#DesvinculaModal').modal('show');
         }else{
             alert("Debe seleccionar una empresa.");
         }                
    }
</script>