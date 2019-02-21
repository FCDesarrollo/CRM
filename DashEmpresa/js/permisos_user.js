
var ModulosArray = "";
var MenusArray = "";
var SubMenusArray = "";
var NombreModulo = "";
var NombreMenu = "";
var NombreSubMenu = "";
var DescripcionModulo = "";


function DatosUsuarioUser(){
    $("table tbody tr").click( function(){
        //loadDiv('../divsadministrar/divadmeditarusuario.php');
        loadDiv('../divsadministrar/divadmpermisos.php');
        var sIDUser = $(this).find("td").eq(0).text();  
        IDUSER= sIDUser;
        $.get(ws + "DatosUsuario/" + sIDUser, function(data){
            var usuario = JSON.parse(data).usuario;
            if(usuario.length>0){
                $('#txtidusuario').val(usuario[0].idusuario);
                $('#txtnombre').val(usuario[0].nombre);
                $('#txtapellidop').val(usuario[0].apellidop);
                $('#txtapellidom').val(usuario[0].apellidom);
                $("#txtcelular").val(usuario[0].cel);
                $("#txtcorreo").val(usuario[0].correo);
                $("#txtcontrasena").val(usuario[0].password);
                $('#chEst').prop("checked", (usuario[0].status==1 ? true : false) );
                $("#txtstatus2").val(usuario[0].status);
                $("#txttipo2").val(usuario[0].tipo);

                //loadlistEmpresas(usuario[0].idusuario, usuario[0].tipo, "EmpVinUser");
                //permisoUser(usuario[0].idusuario);
                CargaPermisosUsuario(usuario[0].idusuario,idempresa);
            }else{
                alert("No se encontro el usuario");
            }
        });
    });
}

function GuardaUsuariolog(){
    $("#txtidusuario").val(IDUSER);
    $("#txtstatus2").val( $('#chEst').is(":checked") ? "1" : "0" );
    $.post(ws + "GuardaUsuario", $("#FormGuardarUsuario").serialize(), function(data){
        if(data>0){
            loadDiv('../divsadministrar/divadmusuarios.php');
        }else{
            alert("Ocurrio un error al guardar el usuario");
        }
    }); 
    //document.getElementById("#FormGuardaEmpresa").reset();
}

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


function CargaPermisosUsuario(idusuario, idempresa){

//----------MODULOS
    $.get(ws + "Modulos", function(datos){    
        ModulosArray = datos;

        $.get(ws + "PermisoModulos",{ idempresa: idempresa, idusuario : idusuario }, function(data){
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

                            document.getElementById("t-Modulos").innerHTML += 
                            "<tbody> \
                                <tr> \
                                    <td role='row'>"+NombreModulo+"</td> \
                                    <td>"+DescripcionModulo+"</td> \
                                    <td> \
                                        <div class='row mg-t-10'> \
                                            <div class='col-lg-6'> \
                                            <label class='rdiobox rdiobox-success'> \
                                                <input id='radio_s"+data[x].idmodulo+"' value='1' name='rdio_"+data[x].idmodulo+"' onchange='UpdatePermisoMod(this)' type='radio' > \
                                                <span>Si</span> \
                                            </label> \
                                            </div> \
                                            <div class='col-lg-6'> \
                                            <label class='rdiobox rdiobox-danger'> \
                                                <input id='radio_n"+data[x].idmodulo+"' value='0' name='rdio_"+data[x].idmodulo+"' onchange='UpdatePermisoMod(this)' type='radio' > \
                                                <span>No</span> \
                                            </label> \
                                            </div> \
                                        </div> \
                                    </td> \
                                </tr> \
                            </tbody>";

                            if(permiso != 0){                            
                                $("#radio_s"+data[x].idmodulo).attr('checked', true); 
                                ListaPermisosMenus(idempresa, idusuario, data[x].idmodulo);                               
                            }else{                        
                                $("#radio_n"+data[x].idmodulo).attr('checked', true);
                            }
                }
            }else{
                $('#accordion').addClass('d-none');
            }
        });        
    });

}


//---------- MENUS
function ListaPermisosMenus(idempresa, idusuario, idmodulo){
    $.get(ws + "Menus", function(datos){    
        MenusArray = datos;    
        $.get(ws + "PermisoMenus",{ idempresa: idempresa, idusuario : idusuario, idmodulo : idmodulo }, function(datosMenu){                                
                for(var x in datosMenu){                    
                    
                    for (var i = 0; i < ModulosArray.length; i+=1) {
                        if(ModulosArray[i].idmodulo === idmodulo){
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
                    document.getElementById("t-Menus").innerHTML += 
                        "<tbody> \
                            <tr> \
                                <td role='row'>"+NombreMenu+"</td> \
                                <td>"+NombreModulo+"</td> \
                                <td> \
                                    <div class='row mg-t-10'> \
                                        <div class='col-lg-6'> \
                                        <label class='rdiobox rdiobox-success'> \
                                            <input id='rmenu_s"+datosMenu[x].idmenu+"' value='1' name='rmenu_"+datosMenu[x].idmenu+"' onchange='UpdatePermisoMenu(this)' type='radio' > \
                                            <span>Si</span> \
                                        </label> \
                                        </div> \
                                        <div class='col-lg-6'> \
                                        <label class='rdiobox rdiobox-danger'> \
                                            <input id='rmenu_n"+datosMenu[x].idmenu+"' value='0' name='rmenu_"+datosMenu[x].idmenu+"' onchange='UpdatePermisoMenu(this)' type='radio' > \
                                            <span>No</span> \
                                        </label> \
                                        </div> \
                                    </div> \
                                </td> \
                            </tr> \
                        </tbody>"; 
                    
                    if(datosMenu[x].tipopermiso != 0){                            
                        $("#rmenu_s"+datosMenu[x].idmenu).attr('checked', true);
                        ListaPermisosSubMenu(idempresa,idusuario,datosMenu[x].idmenu);                                                        
                    }else{                        
                        $("#rmenu_n"+datosMenu[x].idmenu).attr('checked', true);
                    }
                }
        });    
    });
}


//----------SUB MENUS
function ListaPermisosSubMenu(idempresa,idusuario,idmenu){
    $.get(ws + "SubMenus", function(datos){    
        SubMenusArray = datos;    
        $.get(ws + "PermisoSubMenus",{ idempresa: idempresa, idusuario : idusuario, idmenu : idmenu }, function(SubMenu){                                
                
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

                    document.getElementById("t-SubMenus").innerHTML += 
                        "<tbody> \
                            <tr> \
                                <td class='d-none'>"+idmenu+"</td>\
                                <td role='row'>"+NombreSubMenu+"</td> \
                                <td>"+NombreMenu+"</td> \
                                <td> \
                                    <select onchange='UpdatePermisosSubMenu(this)' class='form-control select2' id='SelPermisos_"+SubMenu[x].idsubmenu+"' data-placeholder='Tipo de Permiso'> \
                                        <option value='0' "+ (SubMenu[x].tipopermiso == pBloqueado ? 'selected' : '') +">Bloqueado</option> \
                                        <option value='1' "+ (SubMenu[x].tipopermiso == pLectura ? 'selected' : '') +">Lectura</option> \
                                        <option value='2' "+ (SubMenu[x].tipopermiso == pLecYEsc ? 'selected' : '') +">Lectura y Escritura</option> \
                                        <option value='3' "+ (SubMenu[x].tipopermiso == pTodo ? 'selected' : '') +">Todos</option> \
                                    </select>\
                                </td> \
                            </tr> \
                        </tbody>"; 

                }
        });    
    });
}

function UpdatePermisoMod(permiso_modulo){
    var permiso = permiso_modulo.value;
    var id = permiso_modulo.id;
    var x = id.length;
    var cadena = permiso_modulo.id,
        inicio = 7,
        fin    = x,
        idmodulo = cadena.substring(inicio, fin);
        $.post(ws + "UpdatePermisoModulo",{ idempresa: idempresa, idusuario: IDUSER, idmodulo: idmodulo, tipopermiso: permiso }, function(data){
            if(data>0){                
                $("#t-Modulos tbody").children().remove();
                $("#t-Menus tbody").children().remove();
                $("#t-SubMenus tbody").children().remove();  
                CargaPermisosUsuario(IDUSER, idempresa);
            }else{
                
            }
        });
}
function UpdatePermisoMenu(permiso_menu){
    var permiso = permiso_menu.value;
    var id = permiso_menu.id;
    var x = id.length;
    var cadena = permiso_menu.id,
        inicio = 7,
        fin    = x,
        idmenu = cadena.substring(inicio, fin);   
    
        $.post(ws + "UpdatePermisoMenu",{ idempresa: idempresa, idusuario: IDUSER, idmenu: idmenu, tipopermiso: permiso }, function(data){
            if(data>0){
                if(permiso == 0){                    
                    var filas = $("#t-SubMenus").find("tr");
                    for(i=0; i<filas.length; i++){ //Recorre las filas 1 a 1            
                        var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
                        var idmenu_td = $(celdas[0]).text();
                        if(idmenu == idmenu_td){
                            document.getElementById("t-SubMenus").deleteRow(i);                            
                            filas = $("#t-SubMenus").find("tr");
                            i=i-1;
                        }
                    }
                }else{
                    ListaPermisosSubMenu(idempresa,IDUSER,idmenu); 
                }

            }
        });        
    
}
function UpdatePermisosSubMenu(permiso_submenu){
    var permiso = permiso_submenu.value;
    var id = permiso_submenu.id;
    var x = id.length;
    var cadena = permiso_submenu.id,
        inicio = 12,
        fin    = x,
        idsubmenu = cadena.substring(inicio, fin);

        $.post(ws + "UpdatePermisoSubMenu",{ idempresa: idempresa, idusuario: IDUSER, idsubmenu: idsubmenu, tipopermiso: permiso }, function(data){
            if(data>0){
                
            }else{
                
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
