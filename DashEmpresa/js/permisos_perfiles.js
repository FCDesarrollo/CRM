
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
                        <td style='display:none;'>"+ datos[x].idmenu+"</td> \
                        <td style='display:none;'>"+ datos[x].idsubmenu+"</td> \
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
                CargaPermisosUsuario(IDUSER, idempresa)
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
                
            }else{
                
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
