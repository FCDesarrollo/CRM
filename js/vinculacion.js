function Vincularlog(){
    //$("#titleuser").text(sNaUse);
    loadlistPErfilGen(1, "seleperfil"); 
    $('#vincularempresa').modal('show')
}

function loadlistPErfilGen(lIDUser, nameSelec){
    selectPer = document.getElementById(nameSelec);
    //document.getElementById("loadMod").options.length = 0;
    //console.log(ws + "Modulos",{idusuario: lIDUser });
    $.get(ws + "Perfiles",{idusuario: lIDUser }, function(data){
        var perfiles = JSON.parse(data).perfiles;
        for(var x in perfiles)
        {
            option = document.createElement("option");
            option.value = perfiles[x].idperfil;
            option.text = perfiles[x].nombre;
            selectPer.appendChild(option);
        }            
    });
}

function VinculacionEmpresa(){
    var parametros = new FormData($("#FormVincu")[0]);
    usuarioId = document.getElementById("idusuariolog").value;
    var e = document.getElementById("seleperfil");
    var perfil = e.options[e.selectedIndex].value;
    $.ajax({
        type: 'POST',
        url: 'ajax/vinculacion_archivos.php',
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
                carpeta = "vinculacion";
                $.ajax({
                    type: 'POST',
                    url: 'http://apicr.atwebpages.com/documentos/leerarchivos.php',
                    data:{
                        password: document.getElementById("txtContrasenaV").value,
                        key:document.getElementById("archivoKeyV").files[0].name,
                        cer:document.getElementById("archivoCerV").files[0].name,
                        carpeta: carpeta,
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
                                rfcC = array[7];
                                if (array[7] != "" && array2[0].trim() != "") {                                    
                                    $.post(ws + "ProfileVinculacion",{ idusuario: usuarioId, rfc:rfcC, idperfil:perfil }, function(data){                                         
                                        if(data>0){                                                                                          
                                            alert("Se ha vinculado empresa correctamente.!");   
                                            document.getElementById("FormVincu").reset();
                                            $('#vincularempresa').modal('hide'); 
                                        }else{
                                            alert("No se ha podido vincular empresa.!");  
                                        }
                                    });  
                                }    
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
        }, 
        error: function (data) {
            alert("Ha ocurrido un error al subir los archivos");
        }  
           
    });
}

