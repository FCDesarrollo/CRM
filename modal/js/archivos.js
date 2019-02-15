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
        success: function(response){            
            alert(response);       
        }, 
        error: function (response) {
            alert("Ha ocurrido un error al subir los archivos");
        } 

    });
}