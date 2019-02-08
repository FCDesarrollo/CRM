
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
            alert("Usuario Registrado Correctamente. El Codigo de verificacion ha sido enviado a su correo.");
            $('#RegistroModal').modal('hide');
            $("#ModalValidacion").modal('show');
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

function ValidarForm(){   
    var nombre, apellidop, apellidom, celular, correo, contraseña;
    nombre = document.getElementById("txtnombre").value;
    apellidop = document.getElementById("txtapellidop").value;
    apellidom = document.getElementById("txtapellidom").value;
    celular = document.getElementById("txtcelular").value;
    correo = document.getElementById("txtcorreo").value;
    contraseña = document.getElementById("txtcontrasena").value;

    document.getElementById("txtcorreo").style.borderColor="#ced4da";  

    FormValidado = 1;

    if(nombre === "" || apellidop === "" || apellidom === "" || celular === "" || correo === "" || contraseña === ""){
        alert("Todos los campos son obligatorios");
        FormValidado = 0;
    }

    // En caso de querer validar cadenas con espacios usar: /^[a-zA-Z\s]*$/
    if(!/^[a-zA-Z\s]*$/.test(nombre)){
        document.getElementById("txtnombre").style.borderColor="#FF0000";  
        document.getElementById("txtnombre").focus();
        FormValidado = 0;  
    }
    if(!/^[a-zA-Z\s]*$/.test(apellidop)){
        document.getElementById("txtapellidop").style.borderColor="#FF0000";  
        document.getElementById("txtapellidop").focus();
        FormValidado = 0;  
    }
    if(!/^[a-zA-Z\s]*$/.test(apellidom)){
        document.getElementById("txtapellidom").style.borderColor="#FF0000";  
        document.getElementById("txtapellidom").focus();
        FormValidado = 0;  
    }         


    //Verificar longitud de celular
    
    if(celular.length>=10){
        if(celular.length<=15){
            if(!/^([0-9])*$/.test(celular)){            
                document.getElementById("txtcelular").style.borderColor="#FF0000";  
                document.getElementById("txtcelular").focus();
                FormValidado = 0;      
                //console.log("no es un numero");
            }
        }else{
            document.getElementById("txtcelular").style.borderColor="#FF0000";  
            document.getElementById("txtcelular").focus();
            FormValidado = 0;      
            //console.log("Deben ser menos de 15 digitos");            
        }        
    }else{
        document.getElementById("txtcelular").style.borderColor="#FF0000";  
        document.getElementById("txtcelular").focus();            
        //console.log("deben de ser 10 digitos");
        FormValidado = 0;
    }   

    //Verificar longitud de contraseña
    if(contraseña.length<8 || contraseña.length>20){
        document.getElementById("txtcontrasena").style.borderColor="#FF0000";  
        document.getElementById("txtcontrasena").focus();            
        FormValidado = 0;
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
                document.getElementById("demo2").innerHTML = "El correo proporcionado ya esta en uso.";
                CorreoExistente = 0; //Existe                                                  
            }else{                
                document.getElementById("txtcorreo").style.borderColor="#ced4da";         
                document.getElementById("demo2").innerHTML = "";
                CorreoExistente = 1; //No Existe                
            }
        });           
    }else{
        document.getElementById("demo2").innerHTML = "Favor de introducir un correo valido.";
        document.getElementById("txtcorreo").style.borderColor="#FF0000";                          
        FormValidado = 0;
    }        

} 