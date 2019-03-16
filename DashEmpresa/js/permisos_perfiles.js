
function DatosPerfilUser(dIDEmpresa){
    $("table tbody tr").click( function(){
        //loadDiv('../divsadministrar/divadmeditarusuario.php');
        loadDiv('../divsadministrar/divadmpermisosPerfil.php');
        var sIDPerfil = $(this).find("td").eq(0).text();  
        $.get(ws + "DatosUsuario/" + sIDPerfil, function(data){
            var usuario = JSON.parse(data).usuario;
            if(usuario.length>0){
              /*  $('#txtidusuario').val(usuario[0].idusuario);
                $('#txtnombre').val(usuario[0].nombre);
                $('#txtapellidop').val(usuario[0].apellidop);
                $('#txtapellidom').val(usuario[0].apellidom);
                $("#txtcelular").val(usuario[0].cel);
                $("#txtcorreo").val(usuario[0].correo);
                $("#txtcontrasena").val(usuario[0].password);
                $('#chEst').prop("checked", (usuario[0].status==1 ? true : false) );
                $("#txtstatus2").val(usuario[0].status);
                $("#txttipo2").val(usuario[0].tipo);*/

                //loadlistEmpresas(usuario[0].idusuario, usuario[0].tipo, "EmpVinUser");
                //permisoUser(usuario[0].idusuario);
                //console.log(idempresa);
                CargaPermisosUsuario(usuario[0].idusuario,idempresa);
            }else{
                alert("No se encontro el usuario");
            }
        });
    });
}
