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
                                rfcCert = datos['ArregloCertificado']['rfc'].replace('"', "");
                                var array = rfcCert.split(",");    
                                var array2  = array[1].split("=");  
                                document.getElementById("txtNombre").value = "";
                                $("#txtNombre").val(array2[1]);
                                document.getElementById("txtRFC").value = "";                                
                                $("#txtRFC").val(array[0]);
                                curlCarpetas();
                            }else{
                                alert("El certificado está vencido" . fecha);
                            }                        
                        }else if(datos['KeyPemR']['result'] == 0){
                            alert(datos['KeyPemR']['error']);
                        }else if(datos['pareja']['result'] == 0){
                            alert(datos['pareja']['error']);                    
                        }else if(datos['Arreglofecha']['result'] == 0){
                            alert(datos['Arreglofecha']['error']);
                        }else if(datos['ArregloCertificado']['result'] == 0){
                            alert(datos['ArregloCertificado']['error']);
                        }
                    }
                }); 
            }else if (array[0] === 'false'){
                alert("No se pudo conectar con el servidor");
            }else if(array[1] === 'false'){
                alert("No se pudo crear la carpeta");
            } else if(array[2] === 'false'){
                alert("No se pudo subir el archivo .key");
            } else if(array[3] === 'false'){
                alert("No se pudo subir el archivo .cer");
            }
            
            
            //alert(JSON.parse(response));
            /*console.log(response.lenght);  
            var datos = response.toString();  
            console.log(response);*/                  
            /*if(response != 1){
                console.log(data);
                //Certificados
                /*$.ajax({
                    type: 'POST',//tipo de petición
                    url: 'http://apicr.atwebpages.com/documentos/leerarchivos.php',
                    data:{
                        password: document.getElementById("txtContrasena").value,
                        key:document.getElementById("archivoKey").files[0].name,
                        cer:document.getElementById("archivoCer").files[0].name,
                        carpeta: document.getElementById("txtRFC").value,
                    },
                    cache: false,
                    //contentType: 'json',
                    error: function(data) {
                        console.log("error\n", data);
                    },
                    success: function(data) { 
                        //var contenido = JSON.parse(jsonp);
                        consoñe.log("Aquí");
                        consoñe.log(data);
                    }
                });  
                //////////////////////////////////////////////////////////// 
            //Asigna Base de Datos
            /*$.get(ws + "BDDisponible", function(data){
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
                            alert("Ocurrio un problema 1");
                        }
                    });	
                } else {
                    alert("Ocurrio un problema 2");
                }                  
            });///QUITAR
            }else {
                alert("No se pudo conectar con el servidor de almacenamiento.");
            }*/
        }, 
        error: function (data) {
            console.log(data);
            alert("Ha ocurrido un error al subir los archivos");
        }  
           
    });
}
function ResgistraEmpresa()
    {                    
        var status = "1";
        var fechaReg = new Date();              
            $("#txtIdEmpresa").val(IDEMPRESA);
            $("#txtStatus").val(status);
            $("#txtfecharegistro").val(fechaReg.getFullYear() + "/" + (fechaReg.getMonth() + 1) + "/" + fechaReg.getDate());    

            $.post(ws + "GuardarEmpresa", $("#FormGuardarEmpresa").serialize(), function(data){
                if(data>0){       
                    $.post(ws + "CrearTablasEmpresa", $("#FormGuardarEmpresa").serialize(), function(result){
                        if(result>0){                                                            
                                $('#NuevaEmpresa').modal('hide');
                                document.getElementById('spanGuardar').innerHTML = 'Guardar';           
                                document.getElementById('Guardar').disabled = false;
                                document.getElementById("FormGuardarEmpresa").reset();
                            }else{
                                alert("Ocurrio un error al crear tablas de la empresa");
                            }
                    });      
                }else
                {
                    alert("Ocurrio un error al guardar el empleado 3");
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
            console.log("error\n", response);
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
                        alert("No hay hay base de datos disponible");
                    }                  
                });
            }else if (datosCurl[0] === false) {

            }else if (datosCurl[0] === false) {

            }else if (datosCurl[0] === false){

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