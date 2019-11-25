function VincularUsuario(){
	var archivoC = document.getElementById("archivoCer").value;
    var archivoK = document.getElementById("archivoKey").value;
    var pwd = document.getElementById("txtContrasena").value;
    var idusuario = document.getElementById("txtidusuario").value;

    //var form = $("#FormGuardarEmpresa").serialize();

    $("#loading").removeClass('d-none');

	var archivoKey = document.getElementById("archivoKey").files[0];
  	var archivoCer = document.getElementById("archivoCer").files[0];
  	var parametros = new FormData();
  	parametros.append("archivoCer", archivoCer);
  	parametros.append("archivoKey", archivoKey);
  	if(archivoC != "" && archivoK != "" && pwd != ""){
		$.ajax({
		      type: 'POST',
		      url: '../valida_archivos.php',
		      data: parametros,
		      contentType: false,
		      processData: false,
		      success: function(response){  
		          respuesta = response;
		          respuesta = respuesta.replace("/", "");
		          respuesta = respuesta.replace("[", "");
		          respuesta = respuesta.replace("]", "");
		          var array = respuesta.split(",");   
		          if (array[0] === 'true' && array[1] === 'true' && array[2] === 'true'){   
					    $.ajax({
					        type: 'POST',
					        url: 'http://apicr.atwebpages.com/documentos/leerarchivos.php',
					        data:{
					            password: document.getElementById("txtContrasena").value,
					            key: document.getElementById("archivoKey").files[0].name,
					            cer: document.getElementById("archivoCer").files[0].name,
					            carpeta: "archivos",
					        },
					        cache: false,
					        success: function(data) { 
					            var datos = JSON.parse(data);
					            
					            if (datos['pareja']['result'] == 1 && datos['ArregloCertificado']['result'] == 1 && datos['Arreglofecha']['result'] == 1 && datos['KeyPemR']['result'] == 1){
					              
					              var fechaCer = datos['Arreglofecha']['fecha'].split(" ");

					              fecha = Date();                                                        

					              var fechauno = new Date(fecha);
					              var fechados = new Date(fechaCer);

					              fecha = fechauno.getDate() + "-" + convertMonth(fechauno.getMonth()+1) + "-" + fechauno.getFullYear();
					              
					              //if (fechauno.getTime() < fechados.getTime()){                                  
					              var fec1 = fecha.split("-");
					              var fec2 = fechaCer[0].split("-");                          
					              fec1[1] = fec1[1].toLowerCase();
					              fec2[1] = fec2[1].toLowerCase();
					              var months = ["ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic"];
					              fec1[1] = months.indexOf(fec1[1]);                          
					              fec2[1] = months.indexOf(fec2[1]);
					              var f1 = new Date(parseInt(fec1[2]), fec1[1] + 1, parseInt(fec1[0])); //31 de diciembre de 2015
					              var f2 = new Date(parseInt(fec2[2]), fec2[1] + 1, parseInt(fec2[0]));

					              //if (fecha < fechaCer[0]){
					              if (f1 < f2){
					                  rfcCert = datos['ArregloCertificado']['datos'].replace('"', "");                                

					                  var array = rfcCert.split("="); 
					                  var array2  = array[3].split(",");  
					                  
					                  if (typeof(array[7]) != 'undefined') {
					                      var rfc = array[7];
					                      if (rfc != ""){ 
					                      	VincularUsuarioEmpresa(idusuario, rfc);                
					                      }
					                  }else{
					                    $("#loading").addClass('d-none');
					                    swal("Este es un certificado, se requiere la FIEL.", { 
					                        icon: "info",
					                        buttons: false,
					                        timer: 3000,
					                    });
					                  }
					              }else{
					                $("#loading").addClass('d-none');
					                swal("El certificado está vencido " + fechaCer, { 
					                    icon: "info",
					                    buttons: false,
					                    timer: 3000,
					                });
					              }                      
					          }else if(datos['KeyPemR']['result'] == 0){                  
					            $("#loading").addClass('d-none');
					            swal(datos['KeyPemR']['error'], { 
					                icon: "info",
					                buttons: false,
					                timer: 3000,
					            });
					          }else if(datos['pareja']['result'] == 0){                  
					            $("#loading").addClass('d-none');
					            swal(datos['pareja']['error'], { 
					                icon: "info",
					                buttons: false,
					                timer: 3000,
					            });                          
					          }else if(datos['Arreglofecha']['result'] == 0){
					            $("#loading").addClass('d-none');
					            $("#loading").addClass('d-none');
					            swal(datos['Arreglofecha']['error'], { 
					                icon: "info",
					                buttons: false,
					                timer: 3000,
					            });                          
					          }else if(datos['ArregloCertificado']['result'] == 0){
					            $("#loading").addClass('d-none');
					            swal(datos['ArregloCertificado']['error'], { 
					                icon: "info",
					                buttons: false,
					                timer: 3000,
					            });                          
					          } 
					        }
					    });



		        }else if (array[0] === 'false'){
		                  $("#loading").addClass('d-none');
		                  swal("No se pudo conectar con el servidor", { 
		                      icon: "info",
		                      buttons: false,
		                      timer: 3000,
		                  });                  
		              }else if(array[1] === 'false'){
		                  $("#loading").addClass('d-none');
		                  swal("No se pudo subir el archivo .key", { 
		                      icon: "info",
		                      buttons: false,
		                      timer: 3000,
		                  });                  
		              }else if(array[2] === 'false'){
		                  $("#loading").addClass('d-none');
		                  swal("No se pudo subir el archivo .Cer", { 
		                      icon: "info",
		                      buttons: false,
		                      timer: 3000,
		                  });                  
		              }
		          }, 
		          error: function (data) {  
		              $("#loading").addClass('d-none');            
		              swal("Ha ocurrido un error al subir los archivos", { 
		                  icon: "info",
		                  buttons: false,
		                  timer: 3000,
		              });              
		          }  
		             
	     });   

     }else{
        if(archivoC == ""){
            swal("¡Certificado!", "Debe seleccionar un certificado valido.","info");
        }else if(archivoK == ""){
            swal("¡Archivo Key!","Debe seleccionar el arhivo .key","info");
        }else if(pwd == ""){
            swal("¡FIEL!","Introducir la contraseña FIEL","info");
        }     	
     }
}

function VincularUsuarioEmpresa(idusuario, rfc){
	//$("#loading").addClass('d-none');  

	var perfil = 1;

	$.get(ws + "DatosEmpresa", {rfcempresa: rfc}, function(data){
		var empresa = JSON.parse(data).empresa;
		if(empresa.length > 0){

		    $.get(ws + "DatosUsuario/" + idusuario, function(data) {
		        var usuario = JSON.parse(data).usuario;
		        if (usuario.length > 0) {
		            var nombre_completo = usuario[0].nombre + " " + usuario[0].apellidop + " " + usuario[0].apellidom;

                $.get(ws + "ListaEmpresas", { idusuario: idusuario, tipo: usuario[0].tipo }, function(data){
                    var empresas = JSON.parse(data).empresas;
                    var emp_vin = 0;
                    for (var i = 0; i < empresas.length; i++) {
                        if(empresas[i].idempresa == empresa[0].idempresa){
                            emp_vin = 1;
                            break;
                        }
                    }
                    if(emp_vin == 1){
                        $("#loading").addClass('d-none');
                        swal("¡Usuario Vinculado!", "El usuario ya ha sido vinculado a esta empresa.", "warning");
                    }else{
					    $.post(ws + "VinculacionUsuarios", {idempresa: empresa[0].idempresa, idusuario: idusuario, user_perfil: perfil}, function(data){
					        if(data>0){
					            
					            $.ajax({                        
					                data: {
					                	vinculacion: 1,
					                	usuario: nombre_completo,
					                	empresa: empresa[0].nombreempresa,
					                	correo: empresa[0].correo
					                },
					                type: 'POST',           
					                url: '../../login/validarcorreo/valida.php',
					                success:function(response){     
					                    $("#loading").addClass('d-none');   
					                    swal({
					                      title: "Usuario Vinculado",
					                      text: "Has sido vinculado correctamente.",
					                      icon: "success",
					                      timer: 5000,
					                    })          
					                    .then((value) => {
					                    	window.location='../../usuario.php';
	//				                        $('#divdinamico').load('../divsadministrar/divadmusuarios.php');                        
					                    });
					                }
					            }); 

					        }                                
					    }); 
                    }		            
				});



				}
			});


		}else{
			$("#loading").addClass('d-none');
			swal("¡Empresa!","La empresa a la que intenta vincularse, no ha sido registrada.","error");
		}

	});

	
}
function CancelarVin(){
  window.location='../../usuario.php';
}