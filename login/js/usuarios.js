//var ws = "http://localhost/ApiConsultorMX/miconsultor/public/";
//var ws = "http://apicrm.dublock.com/public/";
var IDUSER="0";
var divuser = document.getElementById("OcultoUser");
var divemp = document.getElementById("OcultoEmp");
var divaltaUser= document.getElementById("altaUser");
function Login()
        {
            
            $.post(ws + "Login", $("#FormLogin").serialize(), function(data){
                
                var usuario = JSON.parse(data).usuario;                
                if(usuario.length>0){                    
                    $("#txtIdCliente").val(usuario[0].idusuario);
                    $("#txttipo").val(usuario[0].tipo);                   
                    if(usuario[0].tipo>0){  
                        $("#FormLogin").submit();
                    }else{                        
                        FormValidacion();                   
                    }                    
                }else{
                    alert("El usuario o contraseña son incorrectos");
                }
            });
        }




    function ListaUsuarios(sIEmpresa)
            {
                
                $('#ListaUsuariosAdmin tbody').html("");
                $.get(ws + "ListaUsuariosAdmin/" + sIEmpresa, function(data){
                    var usuarios = JSON.parse(data).usuarios;
                    for(var x in usuarios)
                    {
                        var lemp = (usuarios[x].nombreempresa==null ? "Sin Empresa" : usuarios[x].nombreempresa)
                        var tr = "<tr>";
                        tr = tr + "<td>" + usuarios[x].idusuario + "</td>";
                        tr = tr + "<td>" + usuarios[x].nombre + "</td>";
                        tr = tr + "<td>" + lemp + "</td>";
                        tr = tr + "<td>" + usuarios[x].cel + "</td>";
                        tr = tr + "<td>" + usuarios[x].correo + "</td>";
                        tr = tr + "<td>" + (usuarios[x].st==1 ? "Activo" : "Inactivo") + "</td>";
                        tr = tr + "<td>" +
                            "<a onclick='DatosUsuario();' class='btn btn-info' style='margin-right:5px;'>Editar</a>" +
                            "<a onclick='EliminarUsuario();' class='btn btn-danger'>Eliminar</a>" +
                            "</td>";
                        tr = tr + "</tr>";
                        $('#ListaUsuariosAdmin tbody').append(tr);
                    }            
                });
            }  

    function ListaUsuariosEmp(sIEmpresa)
    {
        $('#ListaUsuariosEmpresa tbody').html("");
        $.get(ws + "ListaUsuariosAdmin/" + sIEmpresa, function(data){
            var usuarios = JSON.parse(data).usuarios;
            for(var x in usuarios)
            {
                var lemp = (usuarios[x].nombreempresa==null ? "Sin Empresa" : usuarios[x].nombreempresa)
                var tr = "<tr>";
                tr = tr + "<td>" + usuarios[x].idusuario + "</td>";
                tr = tr + "<td>" + usuarios[x].nombre + "</td>";
                tr = tr + "<td>" + lemp + "</td>";
                tr = tr + "<td>" + usuarios[x].cel + "</td>";
                tr = tr + "<td>" + usuarios[x].correo + "</td>";
                tr = tr + "<td>" + (usuarios[x].st==1 ? "Activo" : "Inactivo") + "</td>";
                tr = tr + "<td>" +
                "<a onclick='abreRegistro();' class='btn btn-info' style='margin-right:5px;'>Editar</a>" +  
                "<a onclick='EliminarUsuario();' class='btn btn-danger'>Eliminar</a>" +
                    "</td>";
                tr = tr + "</tr>";
                $('#ListaUsuariosEmpresa tbody').append(tr);
            }            
        });
    } 
    function abreRegistro(){
        DatosUsuario();
        divaltaEmp.style.display = 'none';
        divuserEmp.style.display ='none';
        divaltaUser.style.display= 'block';
        
    }  
    function DatosUsuario(){
        if (divuserEmp.style.display == 'block'){
            sfrmEdit = true;
        }else{
            sfrmEdit = false;
        }
        
        divuser.style.display='none';
        divemp.style.display='none';
       divaltaUser.style.display='block';
        $("table tbody tr").click(function() {
            var sIDUser =$(this).find("td").eq(0).text();
            IDUSER= sIDUser
            $.get(ws + "DatosUsuario/" + sIDUser, function(data){
                var usuario = JSON.parse(data).usuario;
                if(usuario.length>0){
                    $("#txtidusuario").val(usuario[0].idusuario);
                    $("#txtnombre").val(usuario[0].nombre);
                    $("#txtapellidop").val(usuario[0].apellidop);
                    $("#txtapellidom").val(usuario[0].apellidom);
                    $("#txtcelular").val(usuario[0].cel);
                    $("#txtcorreo").val(usuario[0].correo);
                    $("#txtcontrasena").val(usuario[0].password);
                    $('#chEst').prop("checked", (usuario[0].status==1 ? true : false) );
                    $("#txtstatus2").val(usuario[0].status);
                    $("#txttipo2").val(usuario[0].tipo);

                    loadlistEmpresas(usuario[0].idusuario, usuario[0].tipo, "EmpVin");

                }else{
                    alert("No se encontro el usuario");
                }
            });
        });
    }

    function EliminarUsuario(){
        if (divuserEmp.style.display == 'block'){
            sfrmEdit = true;
        }else{
            sfrmEdit = false;
        }
        $("table tbody tr").click(function() {
            var sIDUser =$(this).find("td").eq(0).text();
            var sNameUser=$(this).find("td").eq(2).text();
            if(sIDUser>0){
                var opcion = confirm("¿Esta seguro que desea eliminar el Usuario " + sNameUser + " ?");
                if (opcion == true) {
                    $.post(ws + "EliminarUsuario",{ idusuario: sIDUser, idcliente : sIDUser }, function(data){
                        if(data>0){
                            if (sfrmEdit==true){
                                ListaUsuariosEmp(IDEMPRESA);
                            }else{
                                ListaUsuarios(0);      
                            }
                        }else{
                            alert("Ocurrio un error al eliminar el usuario");
                        }
                    });
                } else {
                    //mensaje = "Has clickado Cancelar";
                }
            }
            
        });
    }

    function EliminarUsuarioForm(sIDUser, sNameUser){
        if (divuserEmp.style.display == 'block'){
            sfrmEdit = true;
        }else{
            sfrmEdit = false;
        }
        if(sIDUser>0){
            var opcion = confirm("¿Esta seguro que desea eliminar el Usuario " + sNameUser + " ?");
            if (opcion == true) {
                $.post(ws + "EliminarUsuario",{ idusuario: sIDUser, idcliente : sIDUser }, function(data){
                    if(data>0){
                        mostrarUser();
                    }else{
                        alert("Ocurrio un error al eliminar el usuario");
                    }
                });
            } else {
                //mensaje = "Has clickado Cancelar";
            }
        }
    }
    function GuardaUsuario(){
        $("#txtidusuario").val(IDUSER);
        $("#txtstatus2").val( $('#chEst').is(":checked") ? "1" : "0" );
        $.post(ws + "GuardaUsuario", $("#FormGuardarUsuario").serialize(), function(data){
            if(data>0){
                if (sfrmEdit==true){
                    ListaUsuariosEmp(IDEMPRESA);
                    divaltaEmp.style.display='block';
                    divuserEmp.style.display='block';
                    divaltaUser.style.display='none';
                }else{
                    ListaUsuarios(0); 
                    divaltaUser.style.display='none';
                    divuser.style.display='block'; 
                }
                 
            }else{
                alert("Ocurrio un error al guardar el usuario");
            }
        }); 
        //document.getElementById("#FormGuardaEmpresa").reset();
    }

    function Vincular(sIDUser, sIDEmp, sTipo, sNaUse ){
        loadlistEmpresas(sIDUser, sTipo, "loadEm");
        $("#titleuser").text(sNaUse); 
        $('#ListEmp').modal('show')
        
        /*if(sIDUser>0){
           // var opcion = confirm("¿Esta seguro que desea desvincular el Usuario " + sNameUser + " de la empresa " + sNameEmp + " ?");
          //  if (opcion == true) {
                $.post(ws + "Desvincular",{ idusuario: sIDUser, idemp : sIDEmp }, function(data){
                    if(data>0){
                        alert("Empresa Desvinculada Correctamente"); 
                        loadlistEmpresas(sIDUser, sTipo);   
                    }else{
                        alert("Ocurrio un error al desvincular la empresa");
                    }
                });
           /// } else {
                //mensaje = "Has clickado Cancelar";
           // }
        }*/
    }

    function DesvincularUser(sIDUser, sIDEmp, sTipo ){
        if(sIDUser>0){
           // var opcion = confirm("¿Esta seguro que desea desvincular el Usuario " + sNameUser + " de la empresa " + sNameEmp + " ?");
          //  if (opcion == true) {
                $.post(ws + "Desvincular",{ idusuario: sIDUser, idemp : sIDEmp }, function(data){
                    if(data>0){
                        alert("Empresa Desvinculada Correctamente"); 
                        loadlistEmpresas(sIDUser, sTipo, "EmpVin");   
                    }else{
                        alert("Ocurrio un error al desvincular la empresa");
                    }
                });
           /// } else {
                //mensaje = "Has clickado Cancelar";
           // }
        }
    }


    function loadlistEmpresas(lIDUser,lTipo, nameID){
        //CARGO LAS EMPRESAS VINCULADAS
        select = document.getElementById(nameID);
        document.getElementById(nameID).options.length = 0;
        $.get(ws + "ListaEmpresas", { idusuario: lIDUser, tipo : lTipo }, function(data){
            var empresas = JSON.parse(data).empresas;
            for(var x in empresas)
            {
                option = document.createElement("option");
                option.value = empresas[x].idempresa;
                option.text = empresas[x].nombreempresa;
                select.appendChild(option);
            }            
        });
    }

    function loadModulosGen(lIDUser, sLisMod){
        //CARGO LAS EMPRESAS VINCULADAS
        selectMod = document.getElementById(sLisMod);
        document.getElementById(sLisMod).options.length = 0;
        option = document.createElement("option");
        option.value = "0";
        option.text = "Seleccionar Modulo";
        selectMod.appendChild(option);
        //console.log(ws + "Modulos",{idusuario: lIDUser });
        $.get(ws + "Modulos",{idusuario: lIDUser }, function(data){
            var modulos = JSON.parse(data).modulos;
            for(var x in modulos)
            {
                option = document.createElement("option");
                option.value = modulos[x].idmodulo;
                option.text = modulos[x].nombre_modulo;
                selectMod.appendChild(option);
            }            
        });
    }

    function DatosModulo(dIDMod){
        var divmod = document.getElementById("divmod");
        if (dIDMod == 0){
            document.getElementById("FormGuardarModulo").reset();
            divmod.style.display ='none';
        }else{
            $.get(ws + "DatosModulo/" + dIDMod, function(data){
                var modulo = JSON.parse(data).modulo;
                if(modulo.length>0){
                    divmod.style.display ='block';
                    $("#txtidmod").val(modulo[0].idmodulo);
                    $("#txtnomMod").val(modulo[0].nombre_modulo);
                    $("#txtdesmod").val(modulo[0].descripcion);
                    $("#dfMod").val(modulo[0].fecha);
                    $('#chst').prop("checked", (modulo[0].status==1 ? true : false) );

                }else{
                    alert("No se encontro el usuario");
                }
            });        
        }
    }

    function loadPerfiles(lIDUser){
        //CARGO LAS EMPRESAS VINCULADAS
        selectPer = document.getElementById("loadPerfil");
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

    function DatosPerfil(dIDPerfil){
        var divperfil = document.getElementById("divperfil");
        if (dIDPerfil == 0){
            document.getElementById("FormGuardarPerfil").reset();
            divperfil.style.display ='none';
        }else{
            $.get(ws + "DatosPerfil/" + dIDPerfil, function(data){
                var perfil = JSON.parse(data).perfil;
                if(perfil.length>0){
                    divperfil.style.display ='block';
                    $("#txtidperfil").val(perfil[0].idperfil);
                    $("#txtnomperfil").val(perfil[0].nombre);
                    $("#txtdesper").val(perfil[0].descripcion);
                    $("#dfPer").val(perfil[0].fecha);
                    $('#chPer').prop("checked", (perfil[0].status==1 ? true : false) );

                    ListaPermisos(dIDPerfil);
                }else{
                    alert("No se encontro el usuario");
                }
            });        
        }
    }

    function ListaPermisos(lIDPer){
        var myTable = document.getElementById("lisPermisos"); 
        var rowCount = myTable.rows.length; 
        for (var x=rowCount-1; x>0; x--) { 
            myTable.deleteRow(x); 
        } 
        $('#lisPermisos tbody').html("");
        $.get(ws + "ListaPermisos/" + lIDPer, function(data){
            var permisos = JSON.parse(data).permisos;
            for(var x in permisos)
            {
                var tr = "<tr>";
                tr = tr + "<td>" + permisos[x].id + "</td>";
                tr = tr + "<td>" + permisos[x].nombre_modulo + "</td>";
                tr = tr + "<td>" + (permisos[x].tipopermiso == 0 ? "BLOQUEADO" : 
                                    permisos[x].tipopermiso == 1 ? "LECTURA" : 
                                    permisos[x].tipopermiso == 2 ? "LECTURA Y ESCRITURA" : "TODO") + "</td>";
                tr = tr + "<td>" +
                    "<a  class='btn btn-info' style='margin-right:5px;' >Editar</a>" +
                    "<a onclick='eliminaPer();' class='btn btn-danger'>Eliminar</a>" +
                    "</td>";
                tr = tr + "</tr>";
                $('#lisPermisos tbody').append(tr);
            }            
        });
    }

    function abrePermisos(sIDUser, sNaPer ){
        loadModulosGen(sIDUser, "loadmodPer");
        $("#titlePerfil").text(sNaPer);
        $('#modpermisos').modal('show')
    }

    function abrePerfil(sIDUser, sNaPer ){
        //loadModulosGen(sIDUser, "loadmodPer");
        $("#txtidAltPer").val(0);
        $("#txtidPerfiAlt").val(0);
        $('#modAltPer').modal('show')
    }

    function GuardaPermiso(pIDModulo, pIDTIpoPer){
        var idperfil = document.getElementById('txtidperfil').value;
        //{idperfil: idperfil, idmodulo: pIDModulo, tipopermiso: pIDTIpoPer}
        $.post(ws + "GuardaPermiso", {idperfil: idperfil, idmodulo: pIDModulo, tipopermiso: pIDTIpoPer}, function(data){
            if(data>0){
                ListaPermisos(idperfil);
            }else{
                alert("Ocurrio un error al guardar el Permiso");
            }
        });
        $('#modpermisos').modal('hide');  
    }

    function eliminaPer(){
        var idper = document.getElementById('txtidperfil').value;
        $("table tbody tr").click(function() {
            var sIDPermiso =$(this).find("td").eq(0).text();
            if(sIDPermiso>0){
                $.post(ws + "EliminaPermiso",{ idpermiso: sIDPermiso}, function(data){
                    if(data>0){
                        ListaPermisos(idper);
                    }else{
                        alert("Ocurrio un error al eliminar el permiso");
                    }
                });
            }
            
        });
    }
   
