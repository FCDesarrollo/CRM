function CambiarContraseña(){
    var idusuario = $("#idusuario").val();
    var newpassword = $("#newpwd").val();
    var confirmapassword = $("#confirmapwd").val();

    if(newpassword != confirmapassword){
        //alert("Las contraseñas no coinciden");
        swal({
          title: "¡Contraseña!",
          text: "Las contraseñas no coinciden.",
          icon: "info",  
          buttons: false,                
          timer: 4500,
        });        
    }else{        
        $.post(ws + "RestablecerContraseña", { idusuario: idusuario, password: newpassword }, function(data){  
            if(data>0){ 
                //alert("Se cambio la contraseña con exito");
                swal({
                  title: "¡Contraseña!",
                  text: "Se cambio la contraseña con exito.",
                  icon: "success",  
                  buttons: false,                
                  timer: 4500,
                })
                .then((value) => {
                  switch (value) {                 
                    default:
                        window.location='../';
                  }
                });                

                
            }else{                
                //alert("Hubo un error, y no se restablecio la contraseña, favor de volver a intentar."); 
                swal({
                  title: "¡Error!",
                  text: "No se pudo restablecer la contraseña, favor de volver a intentar, si el problema continua, comunicarse a sistemas.",
                  icon: "warning",  
                  buttons: false,                
                  timer: 4500,
                });
            }
        }); 
    }

}

var vEcod = 0;
var encript;
function ValidaCorreo_Res(){

    //Validacion del formato de correo y validacion de existencia en bdd
    var correo = $("#email").val();
    if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/.test(correo)){            
        $.post(ws + "ValidarCorreo", { correo: correo }, function(data){  
            var usuario = JSON.parse(data).usuario;
            if(usuario.length>0){ 
                document.getElementById("email").style.borderColor="#ced4da";
                //console.log(usuario[0].tipo);
                if(usuario[0].tipo>0){                    
                    EnviarCorreo_Res(correo,usuario[0].idusuario,usuario[0].nombre,usuario[0].apellidop);
                }else{
                    var pwd = "default_"+usuario[0].identificador;                              
                
                    $.ajax({
                        url: 'encript_pwd.php',
                        type: 'POST',                        
                        data: {pwd: pwd, pwd_user: usuario[0].password},
                    })
                    .done(function(response) {                        
                        encript = response;
                        if(encript == true && vEcod == 0){                        
                            //history.pushState("localhost/crm/", "", "");
                            swal({
                              title: "¡Cuenta no verificada!",
                              text: "Su codigo de verificacion ya ha sido enviado con anterioridad.",
                              icon: "info",  
                              buttons: false,                
                              timer: 4500,
                            })
                            .then((value) => {
                              switch (value) {                 
                                default:
                                    window.location.replace("../?&id="+usuario[0].identificador);
                              }
                            });                             
                            
                        }else{
                            ReenviarCorreo(correo,usuario[0].idusuario,usuario[0].identificador);
                        }                        
                    });

                } 
            }else{                
                document.getElementById("email").style.borderColor="#FF0000";         
                //alert("El correo ingresado o numero telefonico no existen."); 
                swal({
                  title: "¡Correo Electronico!",
                  text: "El correo electronica es incorrecto.",
                  icon: "warning",  
                  buttons: false,                
                  timer: 4500,
                });                         

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
function EnviarCorreo_Res(email,idusuario,nombre,apellidop){ 
    $.ajax({                        
        data: { 'correo': email,
                'idusuario': idusuario, 
                'nombre': nombre, 
                'apellidop': apellidop,
                'rpwd': "1"},
        type: 'POST',
        url: '../validarcorreo/valida.php',            
        success:function(response){
            //alert("Se ha enviado un link a su correo para restablecer su contraseña.");
            swal({
              title: "¡Correo Enviado!",
              text: "Se ha enviado un link a su correo para restablecer su contraseña.",
              icon: "success",  
              buttons: false,                
              timer: 4500,
            })
            .then((value) => {
              switch (value) {                 
                default:
                  window.location='../';
              }
            });                       

            
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
            if(encript == true){                        
                //alert("Codigo de verificacion reenviado correctamente, es necesario establecer una contraseña nueva.");
                swal({
                  title: "Verificacion de cuenta!",
                  text: "Su codigo de verificacion ha sido reenviado, es necesario establecer una nueva contraseña.",
                  icon: "success",  
                  buttons: true,                  
                })
                .then((value) => {
                  switch (value) {                 
                    default:
                      window.location.replace("../?&id="+identificador);
                  }
                });

                
            }else{
                swal({
                  title: "Verificacion de cuenta!",
                  text: "Su codigo de verificacion ha sido reenviado correctamente.",
                  icon: "success",  
                  buttons: true,                  
                })
                .then((value) => {
                  switch (value) {                 
                    default:
                        document.getElementById('Titulo').innerHTML ='¡Cuenta de usuario no verificada!';
                        $("#validacion").load("validacodigoreenviado.php");                    
                  }
                });                
//                alert("Codigo de verificacion reenviado correctamente.");

            }
        }
    });
        
}