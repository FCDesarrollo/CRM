<div id="NuevaEmpresa" class="modal">
    <div class="modal-dialog modalSelect3">
        <div class="modal-content">            
            <div class="modal-header">
                <h3 id="NuevaEmpresaTitle" class="modal-title">Nueva Empresa</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                
            </div>

            <div class="modal-body">
                <form name="FormGuardarEmpresa" id="FormGuardarEmpresa" action="" method="post" class="was-validated" enctype="multipart/form-data">
                        <input type="hidden" name="idempresa" id="txtIdEmpresa" />
                        <input type="hidden" name="status" id="txtStatus" />
                        <input type="hidden" name="fecharegistro" id="txtfecharegistro" />
                        <input type="hidden" name="empresaBD" id="txtempresaBD" />
                        
                        <div class='form-group'>
                            <label for='txtNombre'>Nombre</label>
                            <input type="text" class="form-control" id="txtNombre" name="nombreEmpresa" placeholder="NOMBRE"/>
                            <div class='invalid-feedback'> Campo Requerido. </div>
                        </div>
                        <div class='form-group'>
                            <label for='txtRFC'>RFC</label>
                            <input type="text" class="form-control" id="txtRFC" name="rfc" placeholder="RFC" />
                            <div class='invalid-feedback'> Campo Requerido. </div>
                        </div>
                        <div class='form-group'>
                            <label for='txtDomicilio'>Direccion</label>
                            <input type="text" class="form-control" id="txtDomicilio" name="direccion" placeholder="Direccion" />
                            <div class='invalid-feedback'> Campo Requerido. </div>
                        </div>
                        <div class='form-group'>
                            <label for='txtTelefono'>Telefono</label>
                            <input type="number" class="form-control" id="txtTelefono" name="telefono" placeholder="Telefono" />
                        </div>
                        <div class='form-group'>
                            <label for='txtCP'>Codigo Postal</label>
                            <input type="number" class="form-control" id="txtCP" name="codigopostal" placeholder="Codigo Postal" />
                            <div class='invalid-feedback'> Campo Requerido. </div>
                        </div>                        
                        <div class='form-group'>
                            <label for='txtContraseña'>Contraseña</label>
                            <input type="password" class="form-control" id="txtContrasena" name="password" placeholder="Contraseña" />
                            <div class='invalid-feedback'> Campo Requerido. </div>
                        </div>
                        <div class='form-group'>
                            <label for='archivoCer'>Certificado</label>
                            <input type="file" name="archivoCer" id="archivoCer">
                        </div>
                        <div class='form-group'>
                            <label for='archivoKey'>Archivo Key</label>
                            <input type="file" name="archivoKey" id="archivoKey">
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><span>Cerrar</span></button>
                <button id="Guardar" onclick="GuardaEmpresa()" type="button" class="btn btn-primary"><span id="spanGuardar">Guardar</span></button>

            </div>
        </div>
    </div>
</div>
<script>

    var IDEMPRESA = "0";
    
    $('#agregarEmpresa').click('show.bs.modal', function(e) {    
        IDEMPLEADO = $(e.relatedTarget).data('idempresa');
        $("#NuevaEmpresaTitle").text("Nueva Empresa");
    });
    function GuardaEmpresa()
    {           
        document.getElementById("Guardar").disabled = true;
        document.getElementById('spanGuardar').innerHTML = 'Procesando...';           
        if (validarCampos() != 0){  
            if(document.getElementById("archivoCer").value == "" || document.getElementById("archivoKey").value == ""){
                alert("Seleccione los archivos");
                document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                document.getElementById('Guardar').disabled = false;
            }
            else{
                document.getElementById("Guardar").disabled = true;
                document.getElementById('spanGuardar').innerHTML = 'Procesando...'; 
                subirArchivos();
            }           

            /*$.get(ws + "BDDisponible", function(data){
                var resultado = JSON.parse(data).basedatos;             
                if (resultado.length > 0){
                    var id = resultado[0].id;                
                    var rfc = document.getElementById("txtRFC").value;
                    var nombre = resultado[0].nombre;   
                    $("#txtempresaBD").val(nombre);
                    $.post(ws + "AsignaBD",  { id: id, rfc: rfc }, function(data){    
                        if(data>0){  
                            ResgistraEmpresa();
                        }else{
                            alert("Ocurrio un problema 1");
                        }
                    });	
                } else {
                    alert("Ocurrio un problema 2");
                }                  
            });/////*/
    }
        //document.getElementById('spanGuardar').innerHTML = 'Guardar';           
        //document.getElementById('Guardar').disabled = true;
    }

    /*function ResgistraEmpresa()
    {                    
        var status = "1";
        var fechaReg = new Date();              
            $("#txtIdEmpresa").val(IDEMPRESA);
            $("#txtStatus").val(status);
            $("#txtfecharegistro").val(fechaReg.getFullYear() + "/" + (fechaReg.getMonth() + 1) + "/" + fechaReg.getDate());    

            $.post(ws + "GuardarEmpresa", $("#FormGuardarEmpresa").serialize(), function(data){
                if(data>0){       
                    $.post(ws + "CrearTablasEmpresa", $("#FormGuardarEmpresa").serialize(), function(result){
                        if(result>0){                                                            
                                $('#NuevaEmpresa').modal('hide');
                                document.getElementById("FormGuardarEmpresa").reset();
                            }else{
                                alert("Ocurrio un error al crear tablas de la empresa");
                            }
                    });      
                }else
                {
                    alert("Ocurrio un error al guardar el empleado 3");
                }
            });
          
    }*/

    function validarCampos(){
        var requerido = 1
        if (document.getElementById("txtNombre").value == ""){
            $('#txtNombre').prop("required", true);
            requerido = 0
        }  
        if (document.getElementById("txtRFC").value == ""){
            $('#txtRFC').prop("required", true);
            requerido = 0
        }
        if (document.getElementById("txtDomicilio").value == ""){
            $('#txtDomicilio').prop("required", true);
            requerido = 0
        }     
        if (document.getElementById("txtCP").value == ""){
            $('#txtCP').prop("required", true);
            requerido = 0
        }
        if (document.getElementById("txtContrasena").value == ""){
            $('#txtContrasena').prop("required", true);
            requerido = 0
        }
        return requerido;
    }
</script>
 <!-- Validacion de Correo --> 
 <script src="modal/js/archivos.js"></script>  
 <style>
    .loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    border-bottom: 16px solid #3498db;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite; /* Safari */
    animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
    }
</style>