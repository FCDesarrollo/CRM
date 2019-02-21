function subirArchivos() {
    var parametros = new FormData($("#FormGuardarEmpresa")[0]);
    $.ajax({
        data:parametros,
        url: "modal/ajax/archivos_ajax.php",
        type: "POST",
        contentType: false,
        processData: false,
        beforesend: function(){

        },
        success: function(request){            
            console.log(request);       
            /*$.get(ws + "BDDisponible", function(data){
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
            });*/
        }, 
        error: function (response) {
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