function CargaDatosEmpresaAD(idempresa){ 
    $("#loading").removeClass('d-none');
    $.get(ws + "DatosEmpresaAD/" + idempresa, function(data){
        var empresa = JSON.parse(data).empresa;
        
        if(empresa.length>0){            
            $('#txtnombre').val(empresa[0].nombreempresa);
            $('#txtrfc').val(empresa[0].RFC);
            //$('#txtdireccion').val(empresa[0].direccion);
            $("#txtcorreo").val(empresa[0].correo);
            //$("#txttelefono").val(empresa[0].telefono);
            $("#txtcontrasena").val(empresa[0].password);
            $("#txtvigencia").val(empresa[0].vigencia);

            $("#txtcalle").val(empresa[0].calle);
            $("#txtcolonia").val(empresa[0].colonia);
            $("#txtnumext").val(empresa[0].num_ext);
            $("#txtnumint").val(empresa[0].num_int);
            $("#txtcodigopostal").val(empresa[0].codigopostal);
            $("#txtmunicipio").val(empresa[0].municipio);
            $("#txtciudad").val(empresa[0].ciudad);
            $("#txtestado").val(empresa[0].estado);
            $("#txttelefono").val(empresa[0].telefono);

            $("#loading").addClass('d-none');
           /* $("#txtidentificador").val(usuario[0].identificador);
            document.getElementById("txtcorreo").disabled = true;
            
            if(usuario[0].verificacel == 0){
                document.getElementById("msg_verificacion").innerHTML = "Verifique su telefono movil para poder recibir notificaciones.";
                document.getElementById("link_verificacion").innerHTML = " Click aqui."; 
            }   */

            //$('#chEst').prop("checked", (usuario[0].status==1 ? true : false) );

            //$("#txtstatus2").val(usuario[0].status);
            //$("#txttipo2").val(usuario[0].tipo);
        }else{
            $("#loading").addClass('d-none');
            alert("No se encontro la empresa");
        }
    });    

}

function DivFacturacion(){
    $("#FormEditaEmpresa").addClass('d-none');
    $("#div_renovacion").addClass('d-none');
    $("#div_datosfacturacion").removeClass('d-none');
}

function DivRenovacion(){
    $("#FormEditaEmpresa").addClass('d-none');
    $("#div_datosfacturacion").addClass('d-none');
    $("#div_renovacion").removeClass('d-none');
}

function Cancelar(){
    $("#div_datosfacturacion").addClass('d-none');
    $("#div_renovacion").addClass('d-none');   
    $("#FormEditaEmpresa").removeClass('d-none');
}

function GuardaDatosFacturacion(){

    $("#loading").removeClass('d-none');
    var objeto = new Object();
   
    objeto.idempresa = idempresaglobal;
    objeto.calle = document.getElementById("txtcalle").value;
    objeto.colonia = document.getElementById("txtcolonia").value;
    objeto.num_ext = document.getElementById("txtnumext").value;
    objeto.num_int = document.getElementById("txtnumint").value;
    objeto.codigopostal = document.getElementById("txtcodigopostal").value;
    objeto.municipio = document.getElementById("txtmunicipio").value;
    objeto.ciudad = document.getElementById("txtciudad").value;
    objeto.estado = document.getElementById("txtestado").value;
    objeto.telefono = document.getElementById("txttelefono").value;

    if(DatosVacios() == false){
        $.post(ws + "DatosFacturacion", {objeto: objeto}, function(data){
            var resp = data;
            if(resp > 0){
                $("#loading").addClass('d-none');
                swal("¡Datos Facturacion!", "Datos de facturacion guardados correctamente.", "success");
            }else{
                $("#loading").addClass('d-none');
                swal("¡Datos Facturacion!", "Error desconocido, favor de comunicarse a sistemas.", "error");
            }
        });        
    }else{
        $("#loading").addClass('d-none');
        swal("¡Campos Vacios!", "Favor de llenar todos los campos obligatorios(*).", "warning");
    }
    
}

function ValidaCertificado(){
    $("#loading").removeClass('d-none');
    var archivoC = document.getElementById("archivoCer").value;
    var archivoK = document.getElementById("archivoKey").value;
    var pwd = document.getElementById("txtContrasena").value;

    if(archivoC != "" && archivoK != "" && pwd != ""){

        var archivoKey = document.getElementById("archivoKey").files[0];
        var archivoCer = document.getElementById("archivoCer").files[0];
        var parametros = new FormData();
            parametros.append("archivoCer", archivoCer);
            parametros.append("archivoKey", archivoKey);

        $.ajax({
            type: 'POST',
            url: 'valida_archivos.php',
            url: '../../addempresa/valida_archivos.php',
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
                            //carpeta: document.getElementById("txtRFC").value,
                        },
                        cache: false,
                        error: function(data) {
                          //console.log("error");
                           alert("error\n", data);
                          swal(data, { 
                              icon: "info",
                              buttons: false,
                              timer: 3000,
                          });  
                        },
                        success: function(data) { 
                            var datos = JSON.parse(data);
                            
                            if (datos['pareja']['result'] == 1 && datos['ArregloCertificado']['result'] == 1 && datos['Arreglofecha']['result'] == 1 && datos['KeyPemR']['result'] == 1){
                              
                              var fechaCer = datos['Arreglofecha']['fecha'].split(" ");

                              fecha = Date();                                                        

                              var fechauno = new Date(fecha);
                              var fechados = new Date(fechaCer);

                              fecha = fechauno.getDate() + "-" + ConvertirMes(fechauno.getMonth()+1) + "-" + fechauno.getFullYear();
                                     
                              var fec1 = fecha.split("-");
                              var fec2 = fechaCer[0].split("-");  
                         
                              fec1[1] = fec1[1].toLowerCase();
                              fec2[1] = fec2[1].toLowerCase();
                              var months_es = ["ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic"];
                              var months_en = ["jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec"];
                              if(months_es.indexOf(fec2[1]) != -1){
                                fec1[1] = months_es.indexOf(fec1[1]);
                                fec2[1] = months_es.indexOf(fec2[1]);
                              }else{
                                fec1[1] = months_en.indexOf(fec1[1]);
                                fec2[1] = months_en.indexOf(fec2[1]);
                              }
                              
                              var f1 = new Date(parseInt(fec1[2]), fec1[1], parseInt(fec1[0]));
                              var f2 = new Date(parseInt(fec2[2]), fec2[1], parseInt(fec2[0]));


                              if (f1 < f2){
                                  rfcCert = datos['ArregloCertificado']['datos'].replace('"', "");                                

                                  var array = rfcCert.split("="); 
                                  var array2  = array[3].split(",");  

//                                  $("#txtempresa").val(array2[0].trim());
//                                  $("#txtempresa").addClass('disabled');

                                  if (typeof(array[7]) != 'undefined') {
                                      var rfc = array[7];
                                      if (rfc != ""){                                                                                                                
                                            $("#txtrfc").val(rfc.trim());                                          
                                            var m = ((fec2[1] + 1) < 10 ? "0"+(fec2[1] + 1) : (fec2[1] + 1));
                                            var VigenciaNueva = fec2[2] + "-" + m + "-" + fec2[0];
                                            $("#txtvigencianueva").val(VigenciaNueva);                                            
                                            var VigenciaActual = document.getElementById("txtvigencia").value;

                                            console.log(VigenciaNueva);
                                            console.log(VigenciaActual);
                                            if(VigenciaNueva <= VigenciaActual){
                                                $("#loading").addClass('d-none');
                                                swal("¡Certificado no valido!", "El certificado que ingreso tiene una vigencia menor al actual.", "error");
                                            }else{

                                                $.post(ws + "ActualizaVigencia", {idempresa: idempresaglobal, vigencia: VigenciaNueva}, function(data){
                                                    var resp = data;
                                                    if(resp == 1){
                                                        var archivoKey = document.getElementById("archivoKey").files[0];
                                                        var archivoCer = document.getElementById("archivoCer").files[0];
                                                        var pwd = document.getElementById("txtContrasena").value;                                                        
                                                        var parametros = new FormData();    
                                                            parametros.append("archivoCer", archivoCer);
                                                            parametros.append("archivoKey", archivoKey);
                                                            parametros.append("password", pwd);
                                                            parametros.append("servidor_storage", datosuser.server);
                                                            parametros.append("usuario_storage", datosuser.user_storage);
                                                            parametros.append("password_storage", datosuser.pwd_storage);

                                                        $.ajax({
                                                            type: 'POST',//tipo de petición
                                                            url: '../divsadministrar/renueva_certificado.php',
                                                            data: parametros,
                                                            cache: false,
                                                            contentType: false,
                                                            processData: false,
                                                            success: function(response){ 
                                                                var datosCurl = JSON.parse(response);
                                                                if(datosCurl[0] === true && datosCurl[1] === true && datosCurl[2] === true){

                                                                    $("#loading").addClass('d-none');
                                                                    swal("El Certificado ha sido actualizado correctamente.", { 
                                                                        icon: "success",
                                                                        buttons: {
                                                                          Aceptar: "Aceptar",                      
                                                                        },                    
                                                                        timer: 5000,
                                                                    })
                                                                    .then((value) => {
                                                                      switch (value) { 
                                                                        case "Aceptar":
                                                                          loadDiv('../divsadministrar/divadmempresa.php', ModCuenta, MenuEmpresa, 0);
                                                                          break;
                                                                        default:
                                                                          loadDiv('../divsadministrar/divadmempresa.php', ModCuenta, MenuEmpresa, 0);
                                                                          break;
                                                                      }
                                                                    }); 


                                                                }else if (datosCurl[0] === false){                
                                                                    $("#loading").addClass('d-none');
                                                                    swal("¡Renovacion Certificado!", "No se pudo conectar al servidor.","error");
                                                                }else if(datosCurl[1] === false){
                                                                    $("#loading").addClass('d-none');
                                                                    swal("¡Renovacion Certificado!", "Problemas al intentar guardar el archivo .Cer","error");
                                                                }else if(datosCurl[2] === false){
                                                                    $("#loading").addClass('d-none');
                                                                    swal("¡Renovacion Certificado!", "Problemas al intentar guardar el archivo .Key","error");
                                                                }else if(datosCurl[3] === false){
                                                                    $("#loading").addClass('d-none');
                                                                    swal("¡Renovacion Certificado!", "No se pudo generar el archivo .txt","error");
                                                                }        
                                                            },
                                                        });                                                             


                                                    }else{
                                                        swal("¡Certificado no valido!", "El certificado que ingreso tiene una vigencia menor al actual.", "error");
                                                    }
                                                });

                                            }
                                            
                                          
                                      }else{
                                        $("#loading").addClass('d-none');
                                        swal("RFC de la empresa no valido.", { 
                                            icon: "info",
                                            buttons: false,
                                            timer: 3000,
                                        });
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
        $("#loading").addClass('d-none');
        if(archivoC == ""){
            swal("¡Certificado!", "Debe seleccionar un certificado valido.","info");
        }else if(archivoK == ""){
            swal("¡Archivo Key!","Debe seleccionar el arhivo .key","info");
        }else if(pwd == ""){
            swal("¡FIEL!","Introducir la contraseña FIEL","info");
        }
    }        
}

function DatosVacios(){
    var vacio = false;
    var array = Array();
        array[0] = document.getElementById("txtcalle").value;
        array[1] = document.getElementById("txtcolonia").value;
        array[2] = document.getElementById("txtnumext").value;
        array[3] = document.getElementById("txtnumint").value;
        array[4] = document.getElementById("txtcodigopostal").value;
        array[5] = document.getElementById("txtmunicipio").value;
        array[6] = document.getElementById("txtciudad").value;
        array[7] = document.getElementById("txtestado").value;
        array[8] = document.getElementById("txttelefono").value;

    for (var i = 0; i < array.length; i++) {
        if(array[i] == ""){
            if(i != 3 && i != 8){                
                vacio = true;
                break;
            }
        }
    }
    return vacio;
}

function SoloNumeros(id_input){

    $("#"+id_input).keypress(function (tecla) {
      if (tecla.charCode < 48 || tecla.charCode > 57) return false;
    });

}

function ConvertirMes(mes) {
    var meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
    for (var i = 0; i < 12; i++) {          
      if(i == mes-1){
         var valor = meses[i];
         break;
      }
    }
    return valor;
}