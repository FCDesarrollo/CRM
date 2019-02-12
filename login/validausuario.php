<form id="FormValidacion" class="login100-form validate-form" method="post">									
    <span class="login100-form-title p-b-34">Verificacion de Usuario</span>    
    <div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Correo Electronico">
        <input id="correo" class="input100" type="text" name="correo" placeholder="Correo Electronico">
        <span class="focus-input100"></span>
    </div>
    <div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Codigo de Verificacion">
        <input class="input100" id="identificador" type="text" name="identificador" placeholder="Codigo de Verificacion">
        <span class="focus-input100"></span>
    </div>    
    <div class="container-login100-form-btn">
        <button type="button" class="login100-form-btn" style="background:red !important;" onclick="Validar();">Enviar Codigo</button>
    </div>
    <div class="w-full text-center p-t-27 p-b-239">
        <a href="restablecerpwd/index.php?ecod=1" class="txt2" style="color: black !important;">¿No recibiste el correo con el codigo de verificacion?</a>						
    </div>
</form>
<div class="login100-more" style="background-image: url('images/bg-01.jpg');"></div>

<script>

    function Validar()
    {
		$.post(ws + "ObtenerUsuarioNuevo", $("#FormValidacion").serialize(), function(data){ 
			var usuario = JSON.parse(data).usuario;  
			if(usuario.length>0){  			
				var id = usuario[0].idusuario;			
				var identificador = usuario[0].identificador;
				$.post(ws + "VerificaUsuario", { idusuario: id, identificador: identificador }, function(data){				
					if(data>0){
                        $('#Alertas').addClass('alert alert-success');        
                        document.getElementById("Alertas").innerHTML = "¡Cuenta verificada correctamente!"; 						
						//$('#ModalValidacion').modal('hide');
					}else{
                        $('#Alertas').addClass('alert alert-danger');        
                        document.getElementById("Alertas").innerHTML = "Codigo de Verificacion incorrecto."; 						
					}}).done(function(){ 
						//$('#myModal').modal('show');											
					});
            }else{
                $('#Alertas').addClass('alert alert-danger');        
                document.getElementById("Alertas").innerHTML = "Correo electronico no registrado."; 	
			}					
        });        
    }  

</script>