function CargaDatosEmpresaAD(idempresa){ 
    $.get(ws + "DatosEmpresaAD/" + idempresa, function(data){
        var empresa = JSON.parse(data).empresa;
        if(empresa.length>0){            
            $('#txtnombre').val(empresa[0].nombreempresa);
            $('#txtrfc').val(empresa[0].RFC);
            $('#txtdireccion').val(empresa[0].direccion);
            $("#txtcorreo").val(empresa[0].correo);
            $("#txttelefono").val(empresa[0].telefono);
            $("#txtcontrasena").val(empresa[0].password);
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
            alert("No se encontro la empresa");
        }
    });    

}