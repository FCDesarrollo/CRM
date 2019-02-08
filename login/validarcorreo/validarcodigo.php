<div id="ModalValidacion" class="modal fade">
    <div class="modal-dialog modal-login">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Validacion</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form action="" id="FormValidacion" name="FormValidacion" method="post">
                    <div class="form-group">
						<input type="text" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico o Teléfono" required="required">		
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="identificador" placeholder="Codigo de Verificacion" required="required">		
					</div>       
					<div class="form-group">
						<button type="button" onclick="Validar();" class="btn btn-primary btn-lg btn-block login-btn">Enviar</button>
                    </div>                    
				</form>
            </div>
			<div class="modal-footer">
                <a href="restablecerpwd/recuperarpwd.php?ecod=1">¿No recibiste el correo con el codigo de verificacion?</a>
			</div>
		</div>
    </div>
</div>

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
						alert("Usuario validado correctamente.");
						$('#ModalValidacion').modal('hide');
					}else{
						alert("Codigo de Validacion Incorrecto.");
					}}).done(function(){ 
						$('#myModal').modal('show');											
					});
            }else{
				alert("Usuario no registrado");
			}					
        });        
    }  

</script>