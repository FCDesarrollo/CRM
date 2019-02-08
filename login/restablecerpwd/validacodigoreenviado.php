<div class="text-center">
          
<h3 class="text-center">Ingrese el codigo enviado a su correo</h3>
<p>Se ha enviado el codigo de verificacion a su correo nuevamente.</p>

<div class="panel-body">    
    <form action="../session.php" id="FormVal" name="FormVal" method="post">
        <input type="hidden" name="idusuario" id="idusuario" />    
        <input type="hidden" name="tipo" id="tipo" />    
        <input type="hidden" name="correo" id="correo" />
        <div class="form-group">
            <input type="text" class="form-control" id="identificador" placeholder="Codigo de Verificacion" required="required">		
        </div>       
        <div class="form-group">
            <button type="button" onclick="Validar();" class="btn btn-primary btn-lg btn-block login-btn">Enviar</button>
        </div>                    
    </form>  
</div>

<script>

    function Validar()
    {
        var identificador = $("#identificador").val();        
		$.post(ws + "ObtenerUsuarioNuevo", { identificador: identificador }, function(data){ 
			var usuario = JSON.parse(data).usuario;  
			if(usuario.length>0){  			
				var id = usuario[0].idusuario;			
                var identificador = usuario[0].identificador;
                var correo = usuario[0].correo;
                var tipo = usuario[0].tipo;               
                                
                $("#correo").val(correo);
                $("#tipo").val("1");  
                $("#idusuario").val(usuario[0].idusuario);

				$.post(ws + "VerificaUsuario", { idusuario: id, identificador: identificador }, function(data){				
					if(data>0){
                        alert("Usuario validado correctamente.");
                        window.location='../';
                        //$("#FormVal").submit();
					}else{
						alert("Codigo de Validacion Incorrecto.");
                    }
                });
            }					
        });        
    }  

</script>