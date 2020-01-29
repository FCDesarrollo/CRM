
/*
    SE MANDA EL FORMULARIO AL WS PARA LA CREACION DEL USUARIO
*/ 
var CorreoExistente = "";
var FormValidado = 0;
function GuardarUsuario()
{

    var IDUsuario = "0";
    var status = "1";
    var Identificador = Math.floor(Math.random() * 1000000);   
    $("#txtidusuario").val(IDUsuario);
    $("#txtstatus").val(status);
    $("#identificador").val(Identificador);

    ValidarForm();
    
    if(CorreoExistente>0 && CorreoExistente!=0 && FormValidado>0){            
        var form = $("#FormGuardarUsuario").serialize();
        $.post(ws + "GuardaUsuario", $("#FormGuardarUsuario").serialize(), function(data){   
            if(data>0){
                EnviarCorreo(form);
            }else{
                alert("Ocurrio un error, vuelva a intentar. Si el error continua, favor de comunicarnoslo por correo, en el apartado de Contancto");
            }
        });
    }
}  

/*
    ENVIA EL FORMULARIO CON EL USO DE AJAX PARA EL ENVIO DEL CORREO
    CON EL CODIGO DE VERIFICACION DE LA CUENTA CREADA
*/ 
function EnviarCorreo(form){       
    $.ajax({                        
        data: form,
        type: 'POST',
        url: 'validarcorreo/valida.php',            
        success:function(response){
            var resp = JSON.parse(response);
            if(resp[0] == 0){            
                swal("Usuario Registrado Correctamente.!", "El Codigo de verificacion ha sido enviado a su correo.", "success");
                //alert("Usuario Registrado Correctamente. El Codigo de verificacion ha sido enviado a su correo.");
                $('#RegistroModal').modal('hide');
                $('#recargable').load('validausuario.php');
            }else{
                swal("ERROR!", "No se pudo enviar el correo de autenticacion, comunicarse a sistemas.", "error");
            }
            
        }
    });      
}   

/*
    -VERIFICA SI EL CORREO TIENE EL FORMATO CORRECTO
    -VERIFICA SI EXISTE EL CORREO EN BASE DE DATOS 
    -VALIDA SI TODO EL FORMULARIO SE LLENO CORRECTAMENTE 
*/

function soloNumeros(e){
	var key = window.Event ? e.which : e.keyCode;
	return (key >= 48 && key <= 57);
}

function LimpiaElementos(){
    document.getElementById("txtnombre").style.borderColor="#ced4da"; 
    document.getElementById("txtapellidop").style.borderColor="#ced4da"; 
    document.getElementById("txtapellidom").style.borderColor="#ced4da"; 
    document.getElementById("txtcelular").style.borderColor="#ced4da"; 
    //document.getElementById("txtcorreo").style.borderColor="#ced4da"; 
    document.getElementById("txtcontrasena").style.borderColor="#ced4da"; 

    $('#Alertas').removeClass('alert alert-danger');        
    document.getElementById("Alertas").innerHTML = "";    
}

function ValidarForm(){   
    var nombre, apellidop, apellidom, celular, correo, contraseña;
    nombre = document.getElementById("txtnombre").value;
    apellidop = document.getElementById("txtapellidop").value;
    apellidom = document.getElementById("txtapellidom").value;
    celular = document.getElementById("txtcelular").value;
    correo = document.getElementById("txtcorreo").value;
    contraseña = document.getElementById("txtcontrasena").value;

    FormValidado = 1;

    if(nombre === "" || apellidop === "" || apellidom === "" || celular === "" || correo === "" || contraseña === ""){        
        $('#Alertas').addClass('alert alert-danger');        
        document.getElementById("Alertas").innerHTML = "Todos los campos son obligatorios";
        FormValidado = 0;
        return false;
    }
    // En caso de querer validar cadenas con espacios usar: /^[a-zA-Z\s]*$/
    if(!/^[a-zA-Z\s]*$/.test(nombre)){
        document.getElementById("txtnombre").style.borderColor="#FF0000";          
        FormValidado = 0;  
        return false;
    }
    if(!/^[a-zA-Z\s]*$/.test(apellidop)){
        document.getElementById("txtapellidop").style.borderColor="#FF0000";  
        $('#Alertas').addClass('alert alert-danger');        
        document.getElementById("Alertas").innerHTML = "Apellido paterno no valido";                
        FormValidado = 0;  
        return false;
    }
    if(!/^[a-zA-Z\s]*$/.test(apellidom)){
        document.getElementById("txtapellidom").style.borderColor="#FF0000"; 
        $('#Alertas').addClass('alert alert-danger');        
        document.getElementById("Alertas").innerHTML = "Apellido materno no valido";                
        FormValidado = 0;  
        return false;
    }         


    //Verificar longitud de celular
    
    if(celular.length>=10){
        if(celular.length<=15){
            if(!/^([0-9])*$/.test(celular)){            
                document.getElementById("txtcelular").style.borderColor="#FF0000";
                $('#Alertas').addClass('alert alert-danger');        
                document.getElementById("Alertas").innerHTML = "Numero no valido.";                          
                FormValidado = 0;      
                return false;
            }
        }else{
            document.getElementById("txtcelular").style.borderColor="#FF0000";  
            $('#Alertas').addClass('alert alert-danger');        
            document.getElementById("Alertas").innerHTML = "Numero exede la longitud digitos(15).";                    
            FormValidado = 0;                
            return false;
        }        
    }else{
        document.getElementById("txtcelular").style.borderColor="#FF0000";            
        $('#Alertas').addClass('alert alert-danger');        
        document.getElementById("Alertas").innerHTML = "Numero incorrecto, debe contener al menos 10 digitos.";                            
        FormValidado = 0;
        return false;
    }   

    if(CorreoExistente === 0){
        $('#Alertas').addClass('alert alert-danger');        
        document.getElementById("Alertas").innerHTML = "El correo ya esta en uso."; 
        return false;        
    }

    //Verificar longitud de contraseña
    if(contraseña.length<8 || contraseña.length>20){
        document.getElementById("txtcontrasena").style.borderColor="#FF0000";  
        $('#Alertas').addClass('alert alert-danger');        
        document.getElementById("Alertas").innerHTML = "La contraseña debe tener entre 8 y 32 caracteres.";                    
        FormValidado = 0;
        return false;
    }            
}

function ValidaCorreo(){

    //Validacion del formato de correo y validacion de existencia en bdd
    var correo = $("#txtcorreo").val();
    if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/.test(correo)){            
        $.post(ws + "ValidarCorreo", { correo: correo }, function(data){  
            var usuario = JSON.parse(data).usuario;
            if(usuario.length>0){ 
                document.getElementById("txtcorreo").style.borderColor="#FF0000";  
                $('#Alertas').addClass('alert alert-danger');        
                document.getElementById("Alertas").innerHTML = "El correo ya esta en uso.";                                                    
                CorreoExistente = 0; //Existe                                                  
            }else{                
                document.getElementById("txtcorreo").style.borderColor="#ced4da";         
                $('#Alertas').removeClass('alert alert-danger'); 
                document.getElementById("Alertas").innerHTML = "";
                CorreoExistente = 1; //No Existe                
            }
        });           
    }else{
        document.getElementById("txtcorreo").style.borderColor="#FF0000";       
        $('#Alertas').addClass('alert alert-danger');        
        document.getElementById("Alertas").innerHTML = "Favor de introducir un correo valido";                                               
        FormValidado = 0;
    }        

} 