
var ModulosArray = "";
var MenusArray = "";
var SubMenusArray = "";
var NombreModulo = "";
var NombreMenu = "";
var NombreSubMenu = "";
var DescripcionModulo = "";


// function DatosUsuarioUser(){
//     $("table tbody tr").click( function(){
//         //loadDiv('../divsadministrar/divadmeditarusuario.php');
//         loadDiv('../divsadministrar/divadmpermisos.php');
//         var sIDUser = $(this).find("td").eq(0).text();  
//         IDUSER= sIDUser;
//         $.get(ws + "DatosUsuario/" + sIDUser, function(data){
//             var usuario = JSON.parse(data).usuario;
//             if(usuario.length>0){
//                 $('#txtidusuario').val(usuario[0].idusuario);
//                 $('#txtnombre').val(usuario[0].nombre);
//                 $('#txtapellidop').val(usuario[0].apellidop);
//                 $('#txtapellidom').val(usuario[0].apellidom);
//                 $("#txtcelular").val(usuario[0].cel);
//                 $("#txtcorreo").val(usuario[0].correo);
//                 $("#txtcontrasena").val(usuario[0].password);
//                 $('#chEst').prop("checked", (usuario[0].status==1 ? true : false) );
//                 $("#txtstatus2").val(usuario[0].status);
//                 $("#txttipo2").val(usuario[0].tipo);

//                 //loadlistEmpresas(usuario[0].idusuario, usuario[0].tipo, "EmpVinUser");
//                 //permisoUser(usuario[0].idusuario);
//                 CargaPermisosUsuario(usuario[0].idusuario,idempresa);
//             }else{
//                 alert("No se encontro el usuario");
//             }
//         });
//     });
// }

// function GuardaUsuariolog(){
//     $("#txtidusuario").val(IDUSER);
//     $("#txtstatus2").val( $('#chEst').is(":checked") ? "1" : "0" );
//     $.post(ws + "GuardaUsuario", $("#FormGuardarUsuario").serialize(), function(data){
//         if(data>0){
//             loadDiv('../divsadministrar/divadmusuarios.php');
//         }else{
//             alert("Ocurrio un error al guardar el usuario");
//         }
//     }); 
//     //document.getElementById("#FormGuardaEmpresa").reset();
// }


// function EliminaUserlog(idempresa){
//     $("table tbody tr").click( function(){
//         var sIDUser = $(this).find("td").eq(0).text(); 
//         if(sIDUser>0){
//             $.post(ws + "EliminarUsuario",{ idusuario: sIDUser, idcliente : sIDUser }, function(data, status){
//                 if(data>0){
//                     loadDiv('../divsadministrar/divadmusuarios.php');
//                 }else{
//                     alert("Ocurrio un error al eliminar el usuario");
//                 }
//             });
//         }                      
//     });    
// }

function SavePerfilEmpresa(sIDPerfil, sIDEmpresa){
    //var sIDPerfil = document.getElementById("txtnombreperfil2").value;
    var snombre = document.getElementById("txtnombreperfil2").value;  
    var sdes = document.getElementById("txtdesPerfil2").value;
    $.post(ws + "GuardaPerfilEmpresa", {idperfil: sIDPerfil, idempresa: sIDEmpresa,nombre: snombre,desc: sdes}, function(data){
        if(data>0){
            sIDPerfil =  data;
            var filas = $("#t-ModulosPer").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
            for(i=1; i<filas.length; i++){ //Recorre las filas 1 a 1
                var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
                var idmodPer = $(celdas[0]).text();
                sPermiso = ($("#radio_s"+idmodPer).is(':checked')) ? 1 : 0;
                $.post(ws + "ModulosPerfil", {id: 0, idempresa: sIDEmpresa, idperfil: sIDPerfil, idmodulo: idmodPer, tipopermiso: sPermiso}, function(data){
                    if(data>0){
    
                    }
                });
            }
           
            var filas = $("#t-Menus").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
            for(i=1; i<filas.length; i++){ //Recorre las filas 1 a 1
                var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
                var idmodPer = $(celdas[0]).text();
                var idmenuPer = $(celdas[1]).text();
                console.log(sIDEmpresa);
                sPermiso = ($("#rmenu_s"+idmenuPer).is(':checked')) ? 1 : 0;
                $.post(ws + "MenuPerfil", {id: 0, idempresa: sIDEmpresa, idperfil: sIDPerfil, 
                                idmodulo: idmodPer,idmenu: idmenuPer, tipopermiso: sPermiso}, function(data){
                    if(data>0){
    
                    }
                });
            }
        
            var filas = $("#t-SubMenus").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
            for(i=1; i<filas.length; i++){ //Recorre las filas 1 a 1
                var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
                var idmenuPer = $(celdas[0]).text();
                var idSubMenuPer = $(celdas[1]).text();
                sPermiso= document.getElementById("SelPermisos_"+idSubMenuPer).value;
                sNotificaEmail = ($("#email"+idSubMenuPer).is(':checked')) ? 1 : 0;
                sNotificaSms = ($("#sms"+idSubMenuPer).is(':checked')) ? 2 : 0;
                sNotificacion = parseInt(sNotificaEmail) + parseInt(sNotificaSms)
                $.post(ws + "SubMenuPerfil", {id: 0, idempresa: sIDEmpresa, idperfil: sIDPerfil, 
                    idmenu: idmenuPer,idsubmenu: idSubMenuPer, tipopermiso: sPermiso, notificaciones: sNotificacion}, function(data){
                if(data>0){

                }
                });
            }
            CargaListaPerfiles();
        }else{
            alert("Ocurrio un error al guardar el perfil");
        }
    }); 
    
    
}

function EliminarPerfilEmpresaTable(sIDEmpresa){
    $("table tbody tr").click( function(){
        var sIDPerfil = $(this).find("td").eq(0).text(); 
        if(sIDPerfil>0){
            $.post(ws + "EliminarPerfilEmpresa",{ idperfil: sIDPerfil, idempresa : sIDEmpresa}, function(data, status){
                if(data>0){
                    CargaListaPerfiles();
                }else{
                    alert("Ocurrio un error al eliminar el perfil");
                }
            });
        }                      
    }); 
}

function DatosPerfil(dIDEmpresa){
    $("table tbody tr").click( function(){
        $('#divdinamico2').load('../divsadministrar/divadmeditarperfil.php'); 
        var sid = $(this).find("td").eq(0).text();
        $.get(ws + "DatosPerfilEmpresa",{idperfil: sid, idempresa: dIDEmpresa}, function(data){
            var perfil = JSON.parse(data).perfil;
            if(perfil.length>0){ 
                $("#txtidperfilE").val(perfil[0].idperfil);
                $("#txtnombreperfil2E").val(perfil[0].nombre);
                $("#txtdesPerfil2E").val(perfil[0].descripcion);    

               if(perfil[0].status == 0){
                    $("#chEst").attr("checked", false);
               }else{
                    $("#chEst").attr("checked", true);
               }
              EditModulosPerfil(dIDEmpresa, perfil[0].idperfil);
               
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
                alert("No se encontro el Perfil");
            }
        });  

        
        /*document.getElementById("chEst").disabled = true;
        console.log($(this).find("td").eq(0).text());
        console.log($(this).find("td").eq(1).text());
        console.log($(this).find("td").eq(2).text());*/
       // PermisosPerfil
       

    });

}

//----------PERMISOS DE LOS MODULOS DEL PERFIL
function EditModulosPerfil(eIdempresa, eIdperfil){

    $.get(ws + "Modulos", function(datos){    
        ModulosArray = datos;
        $.get(ws + "PermisosModPerfil", { idempresa: eIdempresa, idperfil : eIdperfil }, function(data){
            if(data != ""){                
                for(var x in data){
                    var permiso = data[x].tipopermiso;                       
                            for (var i = 0; i < ModulosArray.length; i+=1) {
                                if(ModulosArray[i].idmodulo === data[x].idmodulo){
                                    NombreModulo = ModulosArray[i].nombre_modulo;
                                    DescripcionModulo = ModulosArray[i].descripcion;
                                    break;
                                }
                            }
                               
                            document.getElementById("t-ModulosPer").innerHTML += 
                            "<tbody> \
                                <tr> \
                                    <td role='row'>"+NombreModulo+"</td> \
                                    <td>"+DescripcionModulo+"</td> \
                                    <td> \
                                        <div class='row mg-t-10'> \
                                            <div class='col-lg-6'> \
                                            <label class='rdiobox rdiobox-success'> \
                                                <input id='radio_s"+data[x].idmodulo+"' value='1' name='rdio_"+data[x].idmodulo+"' onchange='' type='radio' > \
                                                <span>Si</span> \
                                            </label> \
                                            </div> \
                                            <div class='col-lg-6'> \
                                            <label class='rdiobox rdiobox-danger'> \
                                                <input id='radio_n"+data[x].idmodulo+"' value='0' name='rdio_"+data[x].idmodulo+"' onchange='' type='radio' > \
                                                <span>No</span> \
                                            </label> \
                                            </div> \
                                        </div> \
                                    </td> \
                                </tr> \
                            </tbody>";

                            if(permiso != 0){                            
                                $("#radio_s"+data[x].idmodulo).attr('checked', true); 
                                EditMenusPerfil(eIdempresa, data[x].idmodulo);                               
                            }else{                        
                                $("#radio_n"+data[x].idmodulo).attr('checked', true);
                            }
                }
            }else{
                //$('#accordion').addClass('d-none');
            }
        });        
    });

}

//----------PERMISOS DE LOS MENUS DEL PERFIL
function EditMenusPerfil(midempresa, midmodulo){
    $.get(ws + "Menus", function(datos){    
        MenusArray = datos;    
        $.get(ws + "PermisosMenusPerfil",{ idempresa: midempresa, idmodulo : midmodulo }, function(datosMenu){                                
                for(var x in datosMenu){                    
                    
                    for (var i = 0; i < ModulosArray.length; i+=1) {
                        if(ModulosArray[i].idmodulo === midmodulo){
                            NombreModulo = ModulosArray[i].nombre_modulo;                           
                            break;
                        }
                    }

                    for (var j = 0; j < MenusArray.length; j+=1) {
                        if(MenusArray[j].idmenu === datosMenu[x].idmenu){
                            NombreMenu = MenusArray[j].nombre_menu;                           
                            break;
                        }
                    }            
                    document.getElementById("t-MenusPer").innerHTML += 
                        "<tbody> \
                            <tr> \
                                <td role='row'>"+NombreMenu+"</td> \
                                <td>"+NombreModulo+"</td> \
                                <td> \
                                    <div class='row mg-t-10'> \
                                        <div class='col-lg-6'> \
                                        <label class='rdiobox rdiobox-success'> \
                                            <input id='rmenu_s"+datosMenu[x].idmenu+"' value='1' name='rmenu_"+datosMenu[x].idmenu+"' onchange='' type='radio' > \
                                            <span>Si</span> \
                                        </label> \
                                        </div> \
                                        <div class='col-lg-6'> \
                                        <label class='rdiobox rdiobox-danger'> \
                                            <input id='rmenu_n"+datosMenu[x].idmenu+"' value='0' name='rmenu_"+datosMenu[x].idmenu+"' onchange='' type='radio' > \
                                            <span>No</span> \
                                        </label> \
                                        </div> \
                                    </div> \
                                </td> \
                            </tr> \
                        </tbody>"; 
                    
                    if(datosMenu[x].tipopermiso != 0){                            
                        $("#rmenu_s"+datosMenu[x].idmenu).attr('checked', true);
                        EditSubMenuPerfil(midempresa, datosMenu[x].idmenu);                                                        
                    }else{                        
                        $("#rmenu_n"+datosMenu[x].idmenu).attr('checked', true);
                    }
                }
        });    
    });
}

//----------PERMISOS DE LOS SUBMENUS PERFIL
function EditSubMenuPerfil(sidempresa, sidmenu){
    $.get(ws + "SubMenus", function(datos){    
        SubMenusArray = datos;    
        $.get(ws + "PermisoSubMenusPerfil",{idempresa: sidempresa,  idmenu : sidmenu}, function(SubMenu){                                
                
                for(var x in SubMenu){                    
                    
                    for (var i = 0; i < MenusArray.length; i+=1) {
                        if(MenusArray[i].idmenu === SubMenu[x].idmenu){
                            NombreMenu = MenusArray[i].nombre_menu;                           
                            break;
                        }
                    }

                    for (var j = 0; j < SubMenusArray.length; j+=1) {
                        if(SubMenusArray[j].idsubmenu === SubMenu[x].idsubmenu){
                            NombreSubMenu = SubMenusArray[j].nombre_submenu;                           
                            break;
                        }
                    }     

                    document.getElementById("t-SubMenusPer").innerHTML += 
                        "<tbody> \
                            <tr> \
                                <td class='d-none'>"+sidmenu+"</td>\
                                <td role='row'>"+NombreSubMenu+"</td> \
                                <td>"+NombreMenu+"</td> \
                                <td> \
                                    <select onclick='' class='form-control select2' id='SelPermisos_"+SubMenu[x].idsubmenu+"' data-placeholder='Tipo de Permiso'> \
                                        <option value='0' "+ (SubMenu[x].tipopermiso == pBloqueado ? 'selected' : '') +">Bloqueado</option> \
                                        <option value='1' "+ (SubMenu[x].tipopermiso == pLectura ? 'selected' : '') +">Lectura</option> \
                                        <option value='2' "+ (SubMenu[x].tipopermiso == pLecYEsc ? 'selected' : '') +">Lectura y Escritura</option> \
                                        <option value='3' "+ (SubMenu[x].tipopermiso == pTodo ? 'selected' : '') +">Todos</option> \
                                    </select>\
                                </td> \
                                <td> \
                                    <div class='row mg-t-10'> \
                                        <div class='col-lg-6'> \
                                            <label class='ckbox'><input id='email"+SubMenu[x].idsubmenu+"' onclick='' type='checkbox'><span>Email</span></label> \
                                        </div> \
                                        <div class='col-lg-6'> \
                                            <label class='ckbox'><input id='sms"+SubMenu[x].idsubmenu+"' onclick='' type='checkbox'><span>SMS</span></label> \
                                        </div> \
                                    </div> \
                                </td> \
                            </tr> \
                        </tbody>";


                    switch(SubMenu[x].notificaciones) {
                        case 1:
                            $("#email"+SubMenu[x].idsubmenu).attr("checked", true);
                            break;
                        case 2:
                            $("#sms"+SubMenu[x].idsubmenu).attr("checked", true);
                            break;
                        case 3:
                            $("#email"+SubMenu[x].idsubmenu).attr("checked", true);
                            $("#sms"+SubMenu[x].idsubmenu).attr("checked", true);
                            break;                        
                    }


                }
        });    
    });

}


function CargaModulos(){

//----------MODULOS
    $.get(ws + "Modulos", function(datos){              
        for(var x in datos){
            document.getElementById("t-ModulosPer").innerHTML += 
            "<tbody> \
                <tr> \
                    <td style='display:none;'>"+ datos[x].idmodulo+"</td> \
                    <td role='row'>"+datos[x].nombre_modulo+"</td> \
                    <td>"+datos[x].descripcion+"</td> \
                    <td> \
                        <div class='row mg-t-10'> \
                            <div class='col-lg-6'> \
                            <label class='rdiobox rdiobox-success'> \
                                <input id='radio_s"+datos[x].idmodulo+"' value='1' name='rdio_"+datos[x].idmodulo+"' onclick='BloqueaMenu(this)' type='radio' > \
                                <span>Si</span> \
                            </label> \
                            </div> \
                            <div class='col-lg-6'> \
                            <label class='rdiobox rdiobox-danger'> \
                                <input id='radio_n"+datos[x].idmodulo+"' value='0' name='rdio_"+datos[x].idmodulo+"' onclick='BloqueaMenu(this)' type='radio' > \
                                <span>No</span> \
                            </label> \
                            </div> \
                        </div> \
                    </td> \
                </tr> \
            </tbody>";                      
            $("#radio_n"+datos[x].idmodulo).attr('checked', true);
        }     
    });

}


//---------- MENUS
function CargaMenus(){
    $.get(ws + "Menus", function(datos){    
        for(var x in datos){                                  
            document.getElementById("t-Menus").innerHTML += 
                "<tbody> \
                    <tr> \
                        <td style='display:none;'>"+ datos[x].idmodulo+"</td> \
                        <td style='display:none;'>"+ datos[x].idmenu+"</td> \
                        <td role='row'>"+datos[x].nombre_menu+"</td> \
                        <td>"+datos[x].nombre_modulo+"</td> \
                        <td> \
                            <div class='row mg-t-10'> \
                                <div class='col-lg-6'> \
                                <label class='rdiobox rdiobox-success'> \
                                    <input id='rmenu_s"+datos[x].idmenu+"' value='1' name='rmenu_"+datos[x].idmenu+"'  type='radio' > \
                                    <span>Si</span> \
                                </label> \
                                </div> \
                                <div class='col-lg-6'> \
                                <label class='rdiobox rdiobox-danger'> \
                                    <input id='rmenu_n"+datos[x].idmenu+"' value='0' name='rmenu_"+datos[x].idmenu+"'  type='radio' > \
                                    <span>No</span> \
                                </label> \
                                </div> \
                            </div> \
                        </td> \
                    </tr> \
                </tbody>";                       
                $("#rmenu_n"+datos[x].idmenu).attr('checked', true);
        }   
    });
}


//----------SUB MENUS
function CargaSubMenu(){
    $.get(ws + "SubMenus", function(datos){          
        for(var x in datos){                    
            document.getElementById("t-SubMenus").innerHTML += 
                "<tbody> \
                    <tr> \
                        <td class='d-none'>"+ datos[x].idmenu+"</td> \
                        <td class='d-none'>"+ datos[x].idsubmenu+"</td> \
                        <td role='row'>"+datos[x].nombre_submenu+"</td> \
                        <td>"+datos[x].nombre_menu+"</td> \
                        <td> \
                            <select  class='form-control select2' id='SelPermisos_"+datos[x].idsubmenu+"' data-placeholder='Tipo de Permiso'> \
                                <option value='0' 'selected'>Bloqueado</option> \
                                <option value='1' >Lectura</option> \
                                <option value='2' >Lectura y Escritura</option> \
                                <option value='3' >Todos</option> \
                            </select>\
                        </td> \
                         <td> \
                                <div class='row mg-t-10'> \
                                    <div class='col-lg-6'> \
                                        <label class='ckbox'><input id='email"+ datos[x].idsubmenu+"' type='checkbox'><span>Email</span></label> \
                                    </div> \
                                    <div class='col-lg-6'> \
                                        <label class='ckbox'><input id='sms"+ datos[x].idsubmenu+"'  type='checkbox'><span>SMS</span></label> \
                                    </div> \
                                </div> \
                            </td> \
                    </tr> \
                </tbody>"; 

        }
    });
}


function BloqueaMenu(permiso_modulo){
    var permiso = permiso_modulo.value;
    var id = permiso_modulo.id;
    var x = id.length;
    var cadena = permiso_modulo.id,
        inicio = 7,
        fin    = x,
        bIDModulo = cadena.substring(inicio, fin);
    var filas = $("#t-Menus").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
    for(i=1; i<filas.length; i++){ //Recorre las filas 1 a 1
        
        var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
        var idmodPer = $(celdas[0]).text();
        var idMenu = $(celdas[1]).text();
        if(bIDModulo == idmodPer ){
            if(permiso == 1){
                $("#rmenu_s"+idMenu).prop("checked", true);
            }else{
                $("#rmenu_n"+idMenu).prop("checked", true);
            }
        }
    }
}

function BloqueaSubMenu(permiso_menu){
    var permiso = permiso_menu.value;
    var id = permiso_menu.id;
    var x = id.length;
    var cadena = permiso_menu.id,
        inicio = 7,
        fin    = x,
        bIDMenu = cadena.substring(inicio, fin);
    var filas = $("#t-SubMenus").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
    for(i=1; i<filas.length; i++){ //Recorre las filas 1 a 1
        
        var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
        var idMenu = $(celdas[0]).text();
        var idSubMenu = $(celdas[1]).text();
        if(bIDMenu == idMenu ){
            if(permiso == 1){
                $("#SelPermisos_"+idSubMenu).val('1')
            }else{
                $("#SelPermisos_"+idSubMenu).val('0')
            }
        }
    }
}


// function UpdatePermisoMod(permiso_modulo){
//     var permiso = permiso_modulo.value;
//     var id = permiso_modulo.id;
//     var x = id.length;
//     var cadena = permiso_modulo.id,
//         inicio = 7,
//         fin    = x,
//         idmodulo = cadena.substring(inicio, fin);
//         $.post(ws + "UpdatePermisoModulo",{ idempresa: idempresa, idusuario: IDUSER, idmodulo: idmodulo, tipopermiso: permiso }, function(data){
//             if(data>0){                
//                 $("#t-Modulos tbody").children().remove();
//                 $("#t-Menus tbody").children().remove();
//                 $("#t-SubMenus tbody").children().remove();  
//                 CargaPermisosUsuario(IDUSER, idempresa)
//             }else{
                
//             }
//         });
// }
// function UpdatePermisoMenu(permiso_menu){
//     var permiso = permiso_menu.value;
//     var id = permiso_menu.id;
//     var x = id.length;
//     var cadena = permiso_menu.id,
//         inicio = 7,
//         fin    = x,
//         idmenu = cadena.substring(inicio, fin);   
    
//         $.post(ws + "UpdatePermisoMenu",{ idempresa: idempresa, idusuario: IDUSER, idmenu: idmenu, tipopermiso: permiso }, function(data){
//             if(data>0){
                
//             }else{
                
//             }
//         });        
    
// }
// function UpdatePermisosSubMenu(permiso_submenu){
//     var permiso = permiso_submenu.value;
//     var id = permiso_submenu.id;
//     var x = id.length;
//     var cadena = permiso_submenu.id,
//         inicio = 12,
//         fin    = x,
//         idsubmenu = cadena.substring(inicio, fin);

//         $.post(ws + "UpdatePermisoSubMenu",{ idempresa: idempresa, idusuario: IDUSER, idsubmenu: idsubmenu, tipopermiso: permiso }, function(data){
//             if(data>0){
                
//             }else{
                
//             }
//         });


// }
