


var CorreoExistente = 0;
var FormValidado = 0;
function AgregarUsuario(){
    $("#loading").removeClass('d-none');

	document.getElementById("btnagregauser").disabled = true;
    var IDUsuario = "0";
    var status = "1";
    var Identificador = Math.floor(Math.random() * 1000000);   
    var NombreUsuario = document.getElementById("txtnombre").value;  
    var ApellidoP = document.getElementById("txtapellidop").value;  
    

    $("#txtidusuario").val(IDUsuario);
    $("#txtstatus").val(status);
    $("#txtidentificador").val(Identificador);
    $("#txtidempresa").val(idempresaglobal);

    var default_pwd = "default_"+Identificador;
    
    $("#txtcontrasena").val(default_pwd);

    ValidarForm();

    var form = $("#FormAgregarUsuario").serialize();
    
    if(FormValidado==1){
	    if(CorreoExistente==1){
	        $.post(ws + "GuardaUsuario", form, function(data){
	            if(data>0){
	                EnviarCorreo(form);
                                        
	            }else{
                    $("#loading").addClass('d-none');
	                swal("Usuario", "Ocurrio un error, vuelva a intentar. Si el error continua, favor de comunicarnoslo por correo, en el apartado de Contancto", "error");
	                document.getElementById("btnagregauser").disabled = false;
	            }
	        });
	    }else{
            $("#loading").addClass('d-none');
	    	swal("Correo Electronico", "Ya existe un usuario registrado con este correo electronico.", "error");
	    	document.getElementById("btnagregauser").disabled = false;
	    }
    }else{
        $("#loading").addClass('d-none');
    	document.getElementById("btnagregauser").disabled = false;
    }
}


function EnviarCorreo(form){     
    $.ajax({                        
        data: form,
        type: 'POST',
        url: '../../login/validarcorreo/valida.php',            
        success:function(response){	
            var resp = JSON.parse(response);
            $("#loading").addClass('d-none');
            if(resp[0] == 0){	                	
                swal({
    			  title: "Usuario Registrado",
    			  text: "El Codigo de verificacion ha sido enviado correctamente.",
    			  icon: "success",
    			})			
    			.then((value) => {
    			    $('#divdinamico').load('../divsadministrar/divadmusuarios.php');
                    
    			});
            }else{
                swal({
                  title: "Codigo de verificacion",
                  text: "El codigo de verificacion no pudo ser enviado, comunicarse a sistemas.",
                  icon: "error",
                })          
                .then((value) => {
                    $('#divdinamico').load('../divsadministrar/divadmusuarios.php');                    
                });
            }
        }
    });      

}    

function VinculaUsuario(){

    $("#loading").removeClass('d-none');

    var correo = document.getElementById("txtcorreo").value;
    var perfil = document.getElementById("_Perfil").value;

    if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/.test(correo)){            
        $.post(ws + "ValidarCorreo", { correo: correo }, function(data){  
            var usuario = JSON.parse(data).usuario;
            if(usuario.length>0){ 
                
                $("#txtcelular").val(usuario[0].cel);    
                $("#txtidentificador").val(usuario[0].identificador);
                $("#txtnombre_empresa").val(datosuser.nombre_empresa);
                $.get(ws + "ListaEmpresas", { idusuario: usuario[0].idusuario, tipo: usuario[0].tipo }, function(data){
                    var empresas = JSON.parse(data).empresas;
                    var emp_vin = 0;
                    for (var i = 0; i < empresas.length; i++) {
                        if(empresas[i].idempresa == idempresaglobal){
                            emp_vin = 1;
                            break;
                        }
                    }
                    if(emp_vin == 1){
                        $("#loading").addClass('d-none');
                        swal("¡Usuario Vinculado!", "El usuario ya ha sido vinculado a esta empresa.", "warning");
                    }else{
                        $.post(ws + "VinculacionUsuarios", {idempresa: idempresaglobal, idusuario: usuario[0].idusuario, user_perfil: perfil}, function(data){
                            if(data>0){
                                var form = $("#FormVinculaUsuario").serialize();
                                
                                $.ajax({                        
                                    data: form,
                                    type: 'POST',
                                    url: '../../login/validarcorreo/valida.php',            
                                    success:function(response){     
                                        $("#loading").addClass('d-none');   
                                        var resp = JSON.parse(response);
                                        if(resp[0] == 0){                                        
                                            swal({
                                              title: "Vincula Usuario",
                                              text: "El usuario "+usuario[0].nombre+" "+usuario[0].apellidop+" ha sido vinculado correctamente.",
                                              icon: "success",
                                            })          
                                            .then((value) => {
                                                $('#divdinamico').load('../divsadministrar/divadmusuarios.php');
                                                
                                            });
                                        }else{
                                            swal({
                                              title: "",
                                              text: "El usuario ha sido vinculado correctamente, pero hubo un problema al enviar la notificacion al usuario. Comunicarse a sistemas.",
                                              icon: "error",
                                            })          
                                            .then((value) => {
                                                $('#divdinamico').load('../divsadministrar/divadmusuarios.php');                                                
                                            });                                            
                                        }
                                    }
                                }); 




                            }                                
                        });                        
                    }
                });
                
            }else{ 
                $("#loading").addClass('d-none');               
                swal("¡Usuario!", "No existe un usuario registrado con ese correo electronico.", "error");
            }
        });           
    }else{
        $("#loading").addClass('d-none');
        swal("Correo Electronico", "Favor de introducir un correo electronico valido.", "error");                                             
        
    }       
}


function ValidarForm(){   
    var nombre, apellidop, apellidom, celular, correo, perfil;
    nombre = document.getElementById("txtnombre").value;    
    apellidop = document.getElementById("txtapellidop").value;
    apellidom = document.getElementById("txtapellidom").value;
    celular = document.getElementById("txtcelular").value;
    correo = document.getElementById("txtcorreo").value;
    perfil = document.getElementById("_Perfil").value;
    //contraseña = document.getElementById("txtcontrasena").value;

    FormValidado = 1;
    

    if(nombre === "" || apellidop === "" || apellidom === "" || celular === "" || correo === "" || perfil === ""){        
        swal("Campos Vacios", "Todos los campos son requeridos.", "error");
        FormValidado = 0;
        return false;
    }
    // En caso de querer validar cadenas con espacios usar: /^[a-zA-Z\s]*$/
    if(!/^[a-zA-Z\s]*$/.test(nombre)){
        swal("Datos Incorrectos", "Introduzca un nombre valido.", "error");       
        FormValidado = 0;  
        return false;
    }
    if(!/^[a-zA-Z\s]*$/.test(apellidop)){               
        swal("Datos Incorrectos", "Apellido Paterno no valido.", "error");
        FormValidado = 0;  
        return false;
    }
    if(!/^[a-zA-Z\s]*$/.test(apellidom)){   
        swal("Datos Incorrectos", "Apellido Materno No Valido.", "error");           
        FormValidado = 0;  
        return false;
    }         

    //Verificar longitud de celular    
    if(celular.length>=10){
        if(celular.length<=15){
            if(!/^([0-9])*$/.test(celular)){           
				swal("Telefono Celular", "Favor de introducir un numero de telefono valido.", "error");                                          
                FormValidado = 0;      
                return false;
            }
        }else{
            swal("Telefono Celular", "Exede la longitud de digitos(15).", "error");                     
            FormValidado = 0;                
            return false;
        }        
    }else{
        swal("Telefono Celular", "Debe de contener al menos 10 digitos.", "error");                            
        FormValidado = 0;
        return false;
    }   


    //Verificar longitud de contraseña
    /*if(contraseña.length<8 || contraseña.length>20){                  
        swal("Contraseña", "La contraseña debe de tener entre 8 y 32 caracteres.", "error");   
        FormValidado = 0;
        return false;
    } */            


}

function ValidaCorreo_Reg(correo){
    if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/.test(correo)){            
        $.post(ws + "ValidarCorreo", { correo: correo }, function(data){  
            var usuario = JSON.parse(data).usuario;
            if(usuario.length>0){ 
                //swal("Correo Electronico", "Ya existe un usuario registrado con este correo electronico.", "error");                                                 
                CorreoExistente = 0; //Existe                                                          
            }else{                
                CorreoExistente = 1; //No Existe                
            }
        });           
    }else{
        swal("Correo Electronico", "Favor de introducir un correo electronico valido.", "error");                                             
        CorreoExistente = 0;
    }	
}