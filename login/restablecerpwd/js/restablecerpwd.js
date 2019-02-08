function CambiarContraseña(){
    var idusuario = $("#idusuario").val();
    var newpassword = $("#newpwd").val();
    var confirmapassword = $("#confirmapwd").val();

    if(newpassword != confirmapassword){
        alert("Las contraseñas no coinciden");
    }else{        
        $.post(ws + "RestablecerContraseña", { idusuario: idusuario, password: newpassword }, function(data){  
            if(data>0){ 
                alert("Se cambio la contraseña con exito");
                //location.href="http://localhost/webconsultormx/";
                window.location='../';
            }else{                
                alert("Hubo un error, y no se restablecio la contraseña, favor de volver a intentar.");          
            }
        }); 
    }

}

function ValidaCorreo(){

    //Validacion del formato de correo y validacion de existencia en bdd
    var correo = $("#email").val();
    if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/.test(correo)){            
        $.post(ws + "ValidarCorreo", { correo: correo }, function(data){  
            var usuario = JSON.parse(data).usuario;
            if(usuario.length>0){ 
                document.getElementById("email").style.borderColor="#ced4da";
                if(usuario[0].tipo>0){
                    //console.log("Enviar Link");
                    EnviarCorreo(correo,usuario[0].idusuario,usuario[0].nombre,usuario[0].apellidop);
                }else{
                    //console.log(usuario[0].tipo);
                    //console.log("ReenviarCorreo");
                    ReenviarCorreo(correo,usuario[0].idusuario,usuario[0].identificador);                    

                } 
            }else{                
                document.getElementById("email").style.borderColor="#FF0000";         
                alert("El correo ingresado o numero telefonico no existen.");          
            }
        });           
    }else{
        document.getElementById("email").style.borderColor="#FF0000";                          
    }        

} 

function limpia(){
    document.getElementById("email").style.borderColor="#ced4da";  
}


/*
    ENVIA EL FORMULARIO CON EL USO DE AJAX PARA EL ENVIO DEL CORREO
    CON EL CODIGO DE VERIFICACION DE LA CUENTA CREADA
*/ 
function EnviarCorreo(email,idusuario,nombre,apellidop){ 
    $.ajax({                        
        data: { 'correo': email,
                'idusuario': idusuario, 
                'nombre': nombre, 
                'apellidop': apellidop,
                'rpwd': "1"},
        type: 'POST',
        url: '../validarcorreo/valida.php',            
        success:function(response){
            alert("Se ha enviado un link a su correo para restablecer su contraseña.");
            window.location='../';
        }
    });      
}   

function ReenviarCorreo(email,idusuario,identificador){

    $.ajax({                        
        data: { 'correo': email,
                'idusuario': idusuario, 
                'identificador': identificador},
        type: 'POST',
        url: '../validarcorreo/valida.php',            
        success:function(response){
            alert("Codigo de verificacion reenviado correctamente.");
            document.getElementById('Titulo').innerHTML ='¡Cuenta de usuario no verificada!';
            $("#validacion").load("validacodigoreenviado.php");
        }
    });
        
}