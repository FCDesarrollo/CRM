
<form id="FormValidacion" name="FormValidacion" class="login100-form" method="POST" action="../session.php">									
    <input type="hidden" name="tipo" id="tipo" />
    <input type="hidden" name="idusuario" id="idusuario" />
    <input type="hidden" name="idempresa" id="txtIdEmpresa" />
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
    <div id="AlertaCodigo" class="container-login100-form-btn">
        <button  type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span id="btnAlerta" aria-hidden="true"></span>
        </button>                        
    </div>     
    <div class="w-full text-center p-t-27 p-b-239">
        <a href="restablecerpwd/index.php?ecod=1" class="txt2" style="color: black !important;">¿No recibiste el correo con el codigo de verificacion?</a>						
    </div>   
</form>
<div class="login100-more" style="background-image: url('images/bg-01.jpg');"></div>

<script>

    var correo = "";
    var tipo = "";
    var idusuario = "";

    function Validar()
    {        
        $('#AlertaCodigo').removeClass('alert alert-danger');
        document.getElementById("AlertaCodigo").innerHTML = ""; 						
		$.post(ws + "ObtenerUsuarioNuevo", $("#FormValidacion").serialize(), function(data){             
            var usuario = JSON.parse(data).usuario;              
			if(usuario.length>0){  			                
				var id = usuario[0].idusuario;			
                var identificador = usuario[0].identificador;
				$.post(ws + "VerificaUsuario", { idusuario: id, identificador: identificador }, function(data){				
					if(data>0){                        
                        $('#tipo').val(1);
                        $('#idusuario').val(id);                        
                        $('#txtIdEmpresa').val(0);
                        $('#AlertaCodigo').addClass('alert alert-success');        
                        document.getElementById("AlertaCodigo").innerHTML = "¡Cuenta verificada correctamente!, por favor espere lo estamos redireccionando..."; 						
						setTimeout ('$("#FormValidacion").submit();', 3000); 
					}else{                    
                        $('#AlertaCodigo').addClass('alert alert-danger');        
                        document.getElementById("AlertaCodigo").innerHTML = "Codigo de Verificacion incorrecto."; 						
					}}).done(function(){ 
						
					});
            }else{
                $('#AlertaCodigo').addClass('alert alert-danger');        
                document.getElementById("AlertaCodigo").innerHTML = "Codigo de Verificacion incorreto."; 	
			}					
        });        
    }  

    // function IniciarSession(idusuario,correo,tipo){
    //     console.log(correo);
    //     console.log(tipo);
    //     console.log(idusuario);
    //     $.ajax({                        
    //         data: { 
    //                 'correo': correo,
    //                 'idusuario': idusuario, 
    //                 'tipo': tipo, 
    //               },
    //         type: 'POST',
    //         url: '../session.php',            
    //         success:function(response){
    //             console.log("no redirecciono");
    //              //El session redireccionara.   
    //         }
    //     });          
    // }

</script>