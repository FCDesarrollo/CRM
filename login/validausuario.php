
<form id="FormValidacion" name="FormValidacion" method="POST" action="../session.php">									
    <input type="hidden" name="tipo" id="tipo" />
    <input type="hidden" name="idusuario" id="idusuario" />
    <input type="hidden" name="idempresa" id="txtIdEmpresa" />

    <span class="login100-form-title p-b-34">Verificacion de Usuario</span>     

    <div class="wrap-input100 wd-100 validate-input m-b-20 d-none" id="div_correo" data-validate="Correo Electronico">
        <input id="correo" class="input100" type="text" name="correo" placeholder="Correo Electronico">
        <span class="focus-input100"></span>
    </div>

    <div class="wrap-input100 wd-100 validate-input m-b-20 d-none" id="div_pwd" data-validate="Contraseña">
        <input class="input100" type="password" id="passwd" name="password" placeholder="Contraseña">
        <span class="focus-input100"></span>
    </div>
    <div class="wrap-input100 wd-100 validate-input m-b-20 d-none" id="div_cpwd" data-validate="Confirmar Contraseña">
        <input class="input100" type="password" id="passwd2" name="password2" placeholder="Confirmar Contraseña">
        <span class="focus-input100"></span>
    </div>        
    
    <div class="wrap-input100 wd-100 validate-input m-b-20" data-validate="Codigo de Verificacion">
        <input class="input100" id="identificador" type="text" name="identificador" placeholder="Codigo de Verificacion">
        <span class="focus-input100"></span>
    </div> 
    <div class="container-login100-form-btn">
        <button type="button" class="login100-form-btn" style="background:red !important;" onclick="Validar();">Enviar Datos</button>
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

    if(ident != ""){
        $('#div_pwd').removeClass('d-none');
        $('#div_cpwd').removeClass('d-none');
        //$('#div_correo').addClass('d-none');
    }else{
        $('#correo').val(mailglobal);
    }
    //console.log(mailglobal);
    
    //$('#v_correo').val(mailglobal);
    

    function Validar(){        
        var passwd = document.getElementById("passwd").value;
        var passwd2 = document.getElementById("passwd2").value;
        var flag = 0;

        if(ident == ""){
            passwd = "default";
            passwd2 = "default";
        }else{
            flag = 1;
        }

        if(passwd == passwd2 && passwd != ""){        
            $('#AlertaCodigo').removeClass('alert alert-danger');
            document.getElementById("AlertaCodigo").innerHTML = ""; 						
    		$.post(ws + "ObtenerUsuarioNuevo", $("#FormValidacion").serialize(), function(data){             
                var usuario = JSON.parse(data).usuario;              
    			if(usuario.length>0){  			                
    				var id = usuario[0].idusuario;			
                    var identificador = usuario[0].identificador;
                    $('#correo').val(usuario[0].correo);
    				$.post(ws + "VerificaUsuario", { idusuario: id, identificador: identificador, pwd: passwd, flag: flag }, function(data){				
    					if(data > 0 || data.length > 0){                        
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

        }else{
            $('#AlertaCodigo').addClass('alert alert-danger');        
            document.getElementById("AlertaCodigo").innerHTML = "Las contraseñas no coinciden.";            
        }

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