<div id="NuevaEmpresa" class="modal" data-backdrop="static" data-keyboard="false">
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
                        <input type="hidden" name="rutaEmpresa" id="txtrutaEmpresa" />
                        
                        <div class='form-group'>
                            <label for='txtNombre'>Nombre</label>
                            <input type="text" class="form-control" id="txtNombre" name="nombreEmpresa" placeholder="NOMBRE" required="required"/>
                            <div class='invalid-feedback'> Campo Requerido. </div>
                        </div>
                        <div class='form-group'>
                            <label for='txtRFC'>RFC</label>
                            <input type="text" class="form-control" id="txtRFC" name="rfc" placeholder="RFC" required="required"/>
                            <div class='invalid-feedback'> Campo Requerido. </div>
                        </div>
                        <div class='form-group'>
                            <label for='txtDomicilio'>Direccion</label>
                            <input type="text" class="form-control" id="txtDomicilio" name="direccion" placeholder="Direccion" required="required"/>
                            <div class='invalid-feedback'> Campo Requerido. </div>
                        </div>
                        <div class='form-group'>
                            <label for='txtTelefono'>Telefono</label>
                            <input type="number" class="form-control" id="txtTelefono" name="telefono" placeholder="Telefono" required="required"/>
                        </div>
                        <div class='form-group'>
                            <label for='txtCP'>Codigo Postal</label>
                            <input type="number" class="form-control" id="txtCP" name="codigopostal" placeholder="Codigo Postal" required="required"/>
                            <div class='invalid-feedback'> Campo Requerido. </div>
                        </div>           
                        <div class="form-group">    
                            <label for='txtcorreo'>Correo</label>                    
                            <input type="text" class="form-control" name="correo" id="txtcorreo" placeholder="Correo Electronico" required="required">	    
                            <div class='invalid-feedback'> Campo Requerido. </div>
                            <p><span id="demo2"></span></p>    
                        </div>             
                        <div class='form-group'>
                            <label for='archivoCer'>FIEL .Cer</label>
                            <input type="file" name="archivoCer" id="archivoCer">
                        </div>
                        <div class='form-group'>
                            <label for='archivoKey'>FIEL .Key</label>
                            <input type="file" name="archivoKey" id="archivoKey">
                        </div>
                        <div class='form-group'>
                            <label for='txtContraseña'>Contraseña FIEL</label>
                            <input type="password" class="form-control" id="txtContrasena" name="password" placeholder="Contraseña" required="required"/>
                            <div class='invalid-feedback'> Campo Requerido. </div>
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><span>Cerrar</span></button>
                <button id="Guardar"  onclick="Correo()" type="button" class="btn btn-primary"><span id="spanGuardar">Guardar</span></button>
                <!--<button id="Guardar"  onclick="profile()" type="button" class="btn btn-primary"><span id="spanGuardar">Guardar</span></button>-->                
            </div>
        </div>
    </div>
</div>


<div class="container">
  <!-- The Modal -->
  <div class="modal" id="myModal" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Codigo de confirmación</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <input type="hidden" name="codigo" id="codigo" />
            <div class='form-group'>
                <label for='txtCodigo'>Codigo</label>
                <input type="text" class="form-control" id="txtCodigo" name="txtCodigo" placeholder="Codigo"/>
                <div class='invalid-feedback'> Campo Requerido. </div>
            </div>            
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" onclick="GuardaEmpresa()" class="btn btn-danger" >Continuar</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div>
<script>

    /*function profile()
    {   
        usuarioId = document.getElementById("idusuariolog").value;
        empresaBD = "dublockc_empresa01";        
        $.post(ws + "UsuarioProfile",{ idusuario: usuarioId, empresaBD: empresaBD }, function(data){                                        
            if(data>0){    
                alert(data);                                                                                      
                alert("Empresa Registrado Correctamente.!");            
                document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                document.getElementById('Guardar').disabled = false;
                document.getElementById("FormGuardarEmpresa").reset();
                $('#NuevaEmpresa').modal('hide'); 
            }else{
                alert("Empresa Registrado Correctamente pero no se asignaron perfiles!");  
            }
        }); 
    }*/
    var IDEMPRESA = "0";
    
    $('#agregarEmpresa').click('show.bs.modal', function(e) {    
        IDEMPLEADO = $(e.relatedTarget).data('idempresa');
        $("#NuevaEmpresaTitle").text("Nueva Empresa");
    });
    function Correo()
    {   
        var form = $("#FormGuardarEmpresa").serialize();
        $.ajax({                        
        data: form,
        type: 'POST',
        url: 'login/validarcorreo/validaEmpresa.php',            
        success:function(response){
            resultado = JSON.parse(response);
            estatusCorreo = resultado[0];
            codigo = resultado[1];
            if (estatusCorreo == true) {
                alert("Se ha enviado un código de confirmación a su correo, puede demorar algunos segundos.");
                document.getElementById("Guardar").disabled = true;
                document.getElementById('spanGuardar').innerHTML = 'Procesando...'; 
                $("#myModal").modal("show");
                $("#codigo").val(codigo);
            }else if (estatusCorreo == false){
                alert("Ocurrió un problema al mandar el correo");
            }   
            
        }
    });     
    }
    
    function GuardaEmpresa()
    {   
        codigoTxt = document.getElementById("txtCodigo").value;    
        codigo = document.getElementById("codigo").value;
        if (codigo === codigoTxt) {
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
                    $("#myModal").modal("hide");
                    document.getElementById("txtCodigo").value = "";
                    subirArchivos();
                }                       
            }
        }else{
            document.getElementById('spanGuardar').innerHTML = 'Guardar';           
            document.getElementById('Guardar').disabled = false;
            alert("El código es incorrecto");
            $("#codigo").val(codigo);
        }
        
        //document.getElementById('spanGuardar').innerHTML = 'Guardar';           
        //document.getElementById('Guardar').disabled = true;
    }

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