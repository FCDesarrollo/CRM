function subirArchivos() {
    var parametros = new FormData($("#FormGuardarEmpresa")[0]);
    rfc = document.getElementById("txtRFC").value,
    archivoCer = document.getElementById("archivoKey").files[0].name,
    archivoCer = document.getElementById("archivoCer").files[0].name,

    $.ajax({
        type: 'POST',
        url: 'modal/ajax/archivos_ajax.php',
        data: parametros,
        contentType: false,
        processData: false,
        beforesend: function(){
        },
        success: function(response){  
            respuesta = response;
            respuesta = respuesta.replace("/", "");
            respuesta = respuesta.replace("[", "");
            respuesta = respuesta.replace("]", "");
            var array = respuesta.split(",");   
            if (array[0] === 'true' && array[1] === 'true' && array[2] === 'true' && array[3] === 'true' ){
                //Certificados
                $.ajax({
                    type: 'POST',
                    url: 'http://apicr.atwebpages.com/documentos/leerarchivos.php',
                    data:{
                        password: document.getElementById("txtContrasena").value,
                        key:document.getElementById("archivoKey").files[0].name,
                        cer:document.getElementById("archivoCer").files[0].name,
                        carpeta: document.getElementById("txtRFC").value,
                    },
                    cache: false,
                    error: function(data) {
                       alert("error\n", data);
                    },
                    success: function(data) { 
                        var datos = JSON.parse(data);
                        if (datos['pareja']['result'] == 1 && datos['ArregloCertificado']['result'] == 1 && datos['Arreglofecha']['result'] == 1 && datos['KeyPemR']['result'] == 1){
                            var fechaCer = datos['Arreglofecha']['fecha'];
                            fecha = formatDate(new Date());
                            var fechauno = new Date(fecha);
                            var fechados = new Date(fechaCer);                                                        
                            if (fechauno.getTime() < fechados.getTime()){  
                                rfcCert = datos['ArregloCertificado']['datos'].replace('"', "");                                
                                //var array = rfcCert.split(",");    
                                var array = rfcCert.split("="); 
                                var array2  = array[3].split(",");  
                                document.getElementById("txtNombre").value = "";
                                $("#txtNombre").val(array2[0].trim());
                                document.getElementById("txtRFC").value = "";                                                                 
                                if (typeof(array[7]) != 'undefined') {
                                    var rfc = array[7];
                                    if (rfc != ""){
                                        var rfcCorrecto = rfcValido(rfc.trim());                                  
                                        if (rfcCorrecto){                            
                                            $("#txtRFC").val(rfc);
                                            curlCarpetas();
                                        }else{
                                            alert("RFC Incorrecto");
                                            document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                                            document.getElementById('Guardar').disabled = false;
                                        }
                                    }
                                }
                                else{
                                    alert("Este es un certificado, se requiere la FIEL.");
                                    document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                                    document.getElementById('Guardar').disabled = false; 
                                }
                            }else{
                                alert("El certificado está vencido" . fecha);
                            }                        
                        }else if(datos['KeyPemR']['result'] == 0){   
                            document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                            document.getElementById('Guardar').disabled = false;                         
                            alert(datos['KeyPemR']['error']);
                        }else if(datos['pareja']['result'] == 0){
                            document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                            document.getElementById('Guardar').disabled = false;
                            alert(datos['pareja']['error']);                    
                        }else if(datos['Arreglofecha']['result'] == 0){
                            document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                            document.getElementById('Guardar').disabled = false;
                            alert(datos['Arreglofecha']['error']);
                        }else if(datos['ArregloCertificado']['result'] == 0){
                            document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                            document.getElementById('Guardar').disabled = false;
                            alert(datos['ArregloCertificado']['error']);
                        }
                    }
                }); 
            }else if (array[0] === 'false'){
                document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                document.getElementById('Guardar').disabled = false;
                alert("No se pudo conectar con el servidor");
            }else if(array[1] === 'false'){
                document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                document.getElementById('Guardar').disabled = false;
                alert("No se pudo crear la carpeta");
            } else if(array[2] === 'false'){
                document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                document.getElementById('Guardar').disabled = false;
                alert("No se pudo subir el archivo .key");
            } else if(array[3] === 'false'){
                document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                document.getElementById('Guardar').disabled = false;
                alert("No se pudo subir el archivo .cer");
            }            
        }, 
        error: function (data) {
            document.getElementById('spanGuardar').innerHTML = 'Guardar';           
            document.getElementById('Guardar').disabled = false;
            alert("Ha ocurrido un error al subir los archivos");
        }  
           
    });
}
function ResgistraEmpresa()
    {                    
        var status = "1";        
        var ruta = document.getElementById("txtRFC").value;
        ruta = "dublockc_"+ruta.trim();
        usuarioId = document.getElementById("idusuariolog").value;
        var fechaReg = new Date();              
            $("#txtIdEmpresa").val(IDEMPRESA);
            $("#txtStatus").val(status);
            $("#txtrutaEmpresa").val(ruta);
            $("#txtfecharegistro").val(fechaReg.getFullYear() + "/" + (fechaReg.getMonth() + 1) + "/" + fechaReg.getDate());    
            var empresaBD = document.getElementById("txtempresaBD").value;
            $.post(ws + "GuardarEmpresa", $("#FormGuardarEmpresa").serialize(), function(data){
                if(data>0){ 
                    ///$.post(ws + "CrearTablasEmpresa", $("#FormGuardarEmpresa").serialize(), function(result){
                    $.post(ws + "CrearTablasEmpresa", {empresaBD: empresaBD}, function(result){
                        if(result>0){
                            $.post(ws + "UsuarioEmpresa",{ idusuario: usuarioId, idempresa: data }, function(data){
                                if(data>0){   
                                    idUserPro = document.getElementById("idusuariolog").value;   
                                    alert(document.getElementById("idusuariolog").value);
                                    alert(idUserPro);  
                                    alert(usuarioId);
                                    $.post(ws + "UsuarioProfile",{ idusuario: idUserPro, empresaBD: empresaBD }, function(data){                                        
                                        if(data>0){                                                                                          
                                            alert("Empresa Registrado Correctamente.!");            
                                            document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                                            document.getElementById('Guardar').disabled = false;
                                            document.getElementById("FormGuardarEmpresa").reset();
                                            $('#NuevaEmpresa').modal('hide'); 
                                        }else{
                                            alert("Empresa Registrado Correctamente pero no se asignaron perfiles!");  
                                        }
                                    });                                                        
                                }else{
                                    alert("Se ha registrado la empresa pero no se ha podido vincular a un usuario");
                                }                                                                          
                            
                            });
                        }else{
                            document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                            document.getElementById('Guardar').disabled = false;
                            alert("Ocurrio un error al crear tablas de la empresa.");
                        }
                    });      
                }else
                {
                    document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                    document.getElementById('Guardar').disabled = false;
                    alert("Ocurrio un error al guardar el empleado.");
                }
            });          
    }
function curlCarpetas(){
    var parametros = new FormData($("#FormGuardarEmpresa")[0]);
    $.ajax({
        type: 'POST',//tipo de petición
        url: 'modal/ajax/curlArchivos_ajax.php',
        data:parametros,
        cache: false,
        contentType: false,
        processData: false,
        error: function(response) {
            var datosCurl = JSON.parse(response);
            if (datosCurl[0] === false){
                alert("No se ha podido conectar con el servidor.");
            } else if(datosCurl[1] === false && datosCurl[2] === false){
                alert("Problemas al guardar el certificado.");
            } else if(datosCurl[2] === false){
                alert("Problemas al guardar el la llave.");
            }else if(datosCurl[3] === false){
                alert("Problemas al crear el archivo TXT.");
            }
        },
        success: function(response){ 
            var datosCurl = JSON.parse(response);
            if(datosCurl[0] === true && datosCurl[1] === true && datosCurl[2] === true){
                $.get(ws + "BDDisponible", function(data){
                //console.log(ws + "BDDisponible");
                var resultado = JSON.parse(data).basedatos;             
                    if (resultado.length > 0){
                        var id = resultado[0].id;           
                        var rfc = document.getElementById("txtRFC").value;
                        var nombre = resultado[0].nombre;   
                        $("#txtempresaBD").val(nombre);
                        $.post(ws + "AsignaBD",  { id: id, rfc: rfc }, function(data){    
                            if(data>0){  
                                ResgistraEmpresa();
                            }else{
                                alert("No se pudo asignar base de datos");
                            }
                        });	
                    } else {
                        document.getElementById('Guardar').disabled = false;
                        document.getElementById('spanGuardar').innerHTML = 'Guardar'; 
                        alert("No hay hay base de datos disponible");
                    }                  
                });
            }else if (datosCurl[0] === false) {
                document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                document.getElementById('Guardar').disabled = false;                    
            }else if (datosCurl[0] === false) {
                document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                document.getElementById('Guardar').disabled = false;
            }else if (datosCurl[0] === false){
                document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                document.getElementById('Guardar').disabled = false;
            }         
        },
    });  
}

function formatDate(date) {
  var monthNames = [
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  ];

  var day = date.getDate();
  var monthIndex = date.getMonth();
  var year = date.getFullYear();

  return day + '-' + monthNames[monthIndex] + '-' + year;
}
function rfcValido(rfc, aceptarGenerico = true) {
    const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
    var   validado = rfc.match(re);

    if (!validado)  //Coincide con el formato general del regex?
        return false;

    //Separar el dígito verificador del resto del RFC
    const digitoVerificador = validado.pop(),
          rfcSinDigito      = validado.slice(1).join(''),
          len               = rfcSinDigito.length,

    //Obtener el digito esperado
          diccionario       = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
          indice            = len + 1;
    var   suma,
          digitoEsperado;

    if (len == 12) suma = 0
    else suma = 481; //Ajuste para persona moral

    for(var i=0; i<len; i++)
        suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
    digitoEsperado = 11 - suma % 11;
    if (digitoEsperado == 11) digitoEsperado = 0;
    else if (digitoEsperado == 10) digitoEsperado = "A";

    //El dígito verificador coincide con el esperado?
    // o es un RFC Genérico (ventas a público general)?
    if ((digitoVerificador != digitoEsperado)
     && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
        return false;
    else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
        return false;
    return rfcSinDigito + digitoVerificador;
}