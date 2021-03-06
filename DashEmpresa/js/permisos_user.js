
var ModulosArray = "";
var MenusArray = "";
var SubMenusArray = "";
var NombreModulo = "";
var NombreMenu = "";
var NombreSubMenu = "";
var DescripcionModulo = "";

var sNombreUser = "";

var idempresa = 0;
var idusuario = 0; 
var sIDSUB = 0;
var tiponotificacion = 0;

function Mod_Notificacion(checkbox1){

    $('#t-Notificaciones').on('click', '#'+checkbox1, function(event) {
        var cadena = $(this).parents('tr').find('td:first-child').text(),
             separador = ",",
             arreglo = cadena.split(separador);        
        sIDSUB = arreglo[0];
        idempresa = arreglo[1];
        idusuario = arreglo[2];     

        if($('#sms'+sIDSUB).prop('checked') && $('#email'+sIDSUB).prop('checked')) {
            tiponotificacion = 3;
        }else if($('#email'+sIDSUB).prop('checked')){
            tiponotificacion = 1;
        }else if($('#sms'+sIDSUB).prop('checked')){
            tiponotificacion = 2;
        }else{
            tiponotificacion = 0;
        }

        $.post(ws + "ModificaNotificacion", { idempresa: idempresa, idusuario: idusuario, idsubmenu: sIDSUB, tiponotificacion: tiponotificacion }, function(data){
             if(data>0){
                 //console.log("Actualizo");    
             }else{
                 //console.log("No Actualizo");
             }            
         });
        
    });
    
}


function CargaModalNoti(idempresa,idusuario){   
    $("#t-Notificaciones tbody").children().remove();
    $.get(ws + "SubMenus", function(datos){    
     SubMenusArray = datos;

        $.get(ws + "NotificacionesUsuario", { idempresa: idempresa, idusuario : idusuario }, function(data){
            if(data != ""){                
                for(var x in data){

                    for (var j = 0; j < SubMenusArray.length; j+=1) {
                        if(SubMenusArray[j].idsubmenu === data[x].idsubmenu){
                            NombreSubMenu = SubMenusArray[j].nombre_submenu;                           
                            break;
                        }
                    }                    
                        
                    document.getElementById('t-Notificaciones').innerHTML +=
                    "<tbody> \
                        <tr role='row'> \
                            <td class='d-none'>"+data[x].idsubmenu+","+idempresa+","+idusuario+"</td> \
                            <td>"+NombreSubMenu+"</td> \
                            <td> \
                                <div class='row mg-t-10'> \
                                    <div class='col-lg-6'> \
                                        <label class='ckbox'><input id='email"+data[x].idsubmenu+"' onclick='Mod_Notificacion(this.id)' type='checkbox'><span>Email</span></label> \
                                    </div> \
                                    <div class='col-lg-6'> \
                                        <label class='ckbox'><input id='sms"+data[x].idsubmenu+"' onclick='Mod_Notificacion(this.id)' type='checkbox'><span>SMS</span></label> \
                                    </div> \
                                </div> \
                            </td> \
                        </tr> \
                    </tbody>";


                    switch(data[x].notificaciones) {
                        case 1:
                            $("#email"+data[x].idsubmenu).attr("checked", true);
                            break;
                        case 2:
                            $("#sms"+data[x].idsubmenu).attr("checked", true);
                            break;
                        case 3:
                            $("#email"+data[x].idsubmenu).attr("checked", true);
                            $("#sms"+data[x].idsubmenu).attr("checked", true);
                            break;                        
                    }


                }
            }
        });

    });    

}

function ValidarCelular(){
    $('#divdinamico').load('../divs/verificacelular.php');
}

function EnviaCodigo(){

    var celular = $("#txtcelular").val();
    var idusuario = $("#txtidusuario").val();
    var idempresa = $("#txtidempresa").val();

    $.get(ws + "DatosUsuario/" + idusuario, function(data){
        var usuario = JSON.parse(data).usuario;        
        if(usuario[0].cel == celular){
            var identificador = usuario[0].identificador;            

            $.post(ws + "Parametros", function(datos){
                var parametros = JSON.parse(datos).parametros;
                
                if(parametros.length>0){
                    var url = parametros[0].url;
                    var domain_ser = parametros[0].domain_ser;
                    var login = parametros[0].login;
                    var password = parametros[0].password;

                    EnviarSMS(identificador,url,domain_ser,login,password,celular);

                }else{
                    console.log("Parametros no configurados");
                }
            });


        }else{
            swal("Telefono Movil Incorrecto", "Favor de introducir el Telefono Movil con el que se registro.", "error");
        }

    });    
    
}

function EnviarSMS(identificador,url,domain_ser,login,password,celular){

    $.ajax({
        url: '../empuser/PHPAltiria.php',
        type: 'POST',
        data: {identificador: identificador, url: url, dominio: domain_ser, login: login, password: password, cel: celular},
        success:function(response){
            respuesta = response;    
            console.log(respuesta);        
            if(respuesta.indexOf(celular) != -1){    

                swal("Codigo Enviado", "El codigo de verificacion ha sido enviado a su telefono movil correctamente.", "success");    
                document.getElementById("msg_valida").innerHTML = "Introduzca su codigo de verificacion.";
                document.getElementById("btncodigo").disabled = true;
                document.getElementById("txtidentificador").disabled = false;
                document.getElementById("btnidentificador").disabled = false;        

            }
            //else if(respuesta.indexOf('credit') != -1){       
                //la misma plataforma notificara el numero de creditos disponibles
                //swal("Creditos", "Creditos Insuficientes...", "warning");
                
            //}
            else{
                swal("Error", "Hubo un error al intentar enviar su codigo de verificacion.", "error");
            }            
        }
    });
  
}

function VerificaCodigo(){
    var identificador = $("#txtidentificador").val();
    var idusuario = $("#txtidusuario").val();
    var idempresa = $("#txtidempresa").val();

    $.get(ws + "DatosUsuario/" + idusuario, function(data){
        var usuario = JSON.parse(data).usuario;        
        if(usuario[0].identificador == identificador){
            $.post(ws + "VerificaCelular", { idusuario : idusuario, identificador: identificador }, function(datos){
                if(datos>0){
                    swal("Codigo Correcto", "Telefono movil verificado correctamente", "success");
                    loadDiv('../divs/editarperfil.php');
                }                
            });
        }else{
            swal("Codigo Incorrecto", "Favor de introducir el codigo enviado a su telefono movil.", "error");
        }

    });

}

function DatosUsuarioUser(){
    $("table tbody tr").click( function(){
        
        //loadDiv('../divsadministrar/divadmpermisos.php');
        var sIDUser = $(this).find("td").eq(0).text();
        sNombreUser = $(this).find("td").eq(1).text();
        IDUSER= sIDUser;
        
       // PermisosUsuario
        $.get(ws + "DatosUsuario/" + sIDUser, function(data){
            $('#divdinamico').load('../divsadministrar/divadmpermisos.php');            
            var usuario = JSON.parse(data).usuario;
            if(usuario.length>0){                
                CargaPermisosUsuario(usuario[0].idusuario,idempresa);
            }else{
                swal("Error de Usuario", "No se pudo obtener los datos del usuario, favor de recargar la pagina. Si el problema continua, comunicarlo a sistemas.", "error");
            }
        });

    });

}

function VinDesEmp(){ //Vincula o Desvincula usuario de la empresa.
    $("table tbody tr").click( function(){
        var sIDUser = $(this).find("td").eq(0).text();
        var status = $(this).find("td").eq(2);
        status = status[0]["attributes"];
        status = status[0]["value"];
        console.log(status);

        var accion = (status == 1 ? "desvincular" : "vincular");

        status = (status == 1 ? 0 : 1); 

        swal("¿Estas seguro de deseas "+accion+" al usuario?", {
          buttons: {
            aceptar: "Aceptar",
            cancel: "Cancelar",    
          },
        })
        .then((value) => { 
        console.log(value);      
            switch (value) { 
                case "Cancelar":          
                    break;
                case "aceptar":
                    $("#loading").removeClass('d-none');
                    var datos = new Object();
                    datos.idusuario = sIDUser;
                    datos.iduser_vincula = idusuarioglobal;
                    datos.idempresa = idempresaglobal;
                    datos.status = status;

                    $.post(ws + "Desvincular",{ datos: datos }, function(data){
                        if(data>0){
                            CargaListaUsuarios();
                            $("#loading").addClass('d-none');
                        }
                    });
                    break;                
            }   
        });

    });

}

function EliminaUserlog(idempresa){
    $("table tbody tr").click( function(){
        var sIDUser = $(this).find("td").eq(0).text();
        swal("¿Esta seguro que desea eliminar al usuario?", {
          icon: "warning",
          buttons: {
            aceptar: "Aceptar",
            cancel: "Cancelar",    
          },
        })
        .then((value) => {        
            switch (value) { 
                case "Cancelar":                 
                    break;
                case "aceptar":                    
                    if(sIDUser>0){
                        $("#loading").removeClass('d-none');   
                        $.post(ws + "EliminarUsuario",{ idusuario: sIDUser, idempresa: idempresaglobal }, function(data, status){
                            if(data>0){
                                //loadDiv('../divsadministrar/divadmusuarios.php');
                                //$('#divdinamico').load('../divsadministrar/divadmusuarios.php');
                                CargaListaUsuarios();
                                $("#loading").addClass('d-none');   
                            }else{
                                $("#loading").addClass('d-none');   
                                swal("¡Error!","Ocurrio un error al eliminar el usuario", "error");
                            }
                        });
                    } 
                break;
            }   
        });         
                     
    });    

}

function CargaDatosUsuario(idusuario){ 
    $.get(ws + "DatosUsuario/" + idusuario, function(data){
        var usuario = JSON.parse(data).usuario;
        if(usuario.length>0){            
            $('#txtnombre').val(usuario[0].nombre);
            $('#txtapellidop').val(usuario[0].apellidop);
            $('#txtapellidom').val(usuario[0].apellidom);
            $("#txtcelular").val(usuario[0].cel);
            $("#txtcorreo").val(usuario[0].correo);
            var upwd = usuario[0].password;
            upwd = (upwd.length > 10 ? upwd.substr(0,10) : upwd);
            $("#txtcontrasena").val(upwd);
            $("#txtidentificador").val(usuario[0].identificador);
            document.getElementById("txtcorreo").disabled = true;
            document.getElementById("txtcontrasena").disabled = true;
            document.getElementById("txtcelular").disabled = true;
            
            if(usuario[0].verificacel == 0){
                document.getElementById("msg_verificacion").innerHTML = "Verifique su telefono movil para poder recibir notificaciones.";
                document.getElementById("link_verificacion").innerHTML = " Click aqui."; 
            }   
        }else{
            alert("No se encontro el usuario");
        }
    });    

}

function EditaUsuario(){
    $.post(ws + "GuardaUsuario", $("#FormEditaUsuario").serialize(), function(data){
        if(data>0){
            swal("Guardado", "Datos actualizados correctamente.", "success");
            //loadDiv('../divsadministrar/divadmusuarios.php');
        }else{
            swal("Error", "Hubo un problema y no se guardaron los cambios.", "error");
            //alert("Ocurrio un error al guardar el usuario");
        }
    }); 
    //document.getElementById("#FormGuardaEmpresa").reset();

}

//----------MODULOS
function CargaPermisosUsuario(idusuario, idempresa){

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
                //$('#accordion').addClass('d-none');
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
                                    <select onclick='UpdatePermisosSubMenu(this)' class='form-control select2' id='SelPermisos_"+SubMenu[x].idsubmenu+"' data-placeholder='Tipo de Permiso'> \
                                        <option value='0' "+ (SubMenu[x].tipopermiso == pBloqueado ? 'selected' : '') +">Bloqueado</option> \
                                        <option value='1' "+ (SubMenu[x].tipopermiso == pLectura ? 'selected' : '') +">Lectura</option> \
                                        <option value='2' "+ (SubMenu[x].tipopermiso == pLecYEsc ? 'selected' : '') +">Lectura y Escritura</option> \
                                        <option value='3' "+ (SubMenu[x].tipopermiso == pTodo ? 'selected' : '') +">Todos</option> \
                                    </select>\
                                </td> \
                                <td> \
                                    <div class='row mg-t-10'> \
                                        <div class='col-lg-6'> \
                                            <label class='ckbox'><input id='email"+SubMenu[x].idsubmenu+"' onclick='NotificacionesUser("+SubMenu[x].idsubmenu+","+idusuario+","+idempresa+")' type='checkbox'><span>Email</span></label> \
                                        </div> \
                                        <div class='col-lg-6'> \
                                            <label class='ckbox'><input id='sms"+SubMenu[x].idsubmenu+"' onclick='NotificacionesUser("+SubMenu[x].idsubmenu+","+idusuario+","+idempresa+")' type='checkbox'><span>SMS</span></label> \
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

function NotificacionesUser(idsubmenu, idusuario, idempresa){
   // $('#t-SubMenus').on('click', '#'+checkbox1, function(event) {

        //var idsubmenu = $(this).parents('tr').find('td:first-child').text();    

        if($('#sms'+idsubmenu).prop('checked') && $('#email'+idsubmenu).prop('checked')) {
            tiponotificacion = 3;
        }else if($('#email'+idsubmenu).prop('checked')){
            tiponotificacion = 1;
        }else if($('#sms'+idsubmenu).prop('checked')){
            tiponotificacion = 2;
        }else{
            tiponotificacion = 0;
        }

        $.post(ws + "ModificaNotificacion", { idempresa: idempresa, idusuario: idusuario, idsubmenu: idsubmenu, tiponotificacion: tiponotificacion }, function(data){
            if(data>0){
                //console.log("Actualizo");    
            }else{
                //console.log("No Actualizo");
            }            
        });
        
   // });
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

// function RecargaDiv(div_recarga){
//     var type = div_recarga.id;
//     console.log(type);
//     if(type == "usuarios"){
//         history.pushState(null, "", "?type=1");
//         loadDiv('../divsadministrar/divadmusuarios.php');
//     }else if(type == "perfiles"){
//         history.pushState(null, "", "?type=2");
//         loadDiv('../divsadministrar/divadmperfiles.php');
//     }else{

//     }
    

    
// }
