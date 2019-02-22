function CargaDatosEmpresa(idusuario, idempresalog){
    //console.log(idempresalog);
    $.get(ws + "DatosUsuario/" + idusuario, function(data){
        var usuario = JSON.parse(data).usuario;
        if(usuario.length>0){            
            document.getElementById('nUsuario').innerHTML = usuario[0].nombre;
        }
    });  
    $.get(ws + "DatosEmpresaAD/" + idempresalog, function(data){
        var empresa = JSON.parse(data).empresa;
        if(empresa.length>0){            
            document.getElementById('nEmpresa').innerHTML = empresa[0].nombreempresa;
        }
    });  
}