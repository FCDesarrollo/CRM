var modulo;
var menu;
var submenu;


function ExpDigitales(idmodulo, idmenu, idsubmenu, RFCEmpresa){
    modulo = idmodulo;
    menu = idmenu;
    submenu = idsubmenu;

    idmoduloglobal = idmodulo;
    idmenuglobal = idmenu;
    //idsubmenuglobal = idsubmenu;
    
    URL_Asigna_SubM(idsubmenu); //AGREGA EL ID DEL SUBMENU POSICIONADO A LA URL

	$('#loading').removeClass('d-none');

	$('#divdinamico').load('../submenus/alm_expedientesdigitales.php');

    $("#t-ExpDigitales tbody").children().remove();    

    $.get(ws + "DatosAlmacen", {rfcempresa: datosuser.rfcempresa, idmenu: idmenu, idsubmenu: idsubmenu}, function(data){
        var datos = JSON.parse(data);
        
        if(datos.length > 0){            
            var n = 0;
            for (var i = 0; i < (datos.length > lotes_x_pag ? lotes_x_pag : datos.length); i++) {

                document.getElementById("t-ExpDigitales").innerHTML +=
                "<tr> \
                    <td>"+datos[i].fechadocto+"</td> \
                    <td>"+datos[i].usuario+"</td> \
                    <td>"+datos[i].sucursal+"</td> \
                    <td>Registros: "+datos[i].totalregistros+" Cargados: "+datos[i].totalcargados+" Procesados: "+datos[i].procesados+"</td> \
                    <td> \
                      <a href='#' data-toggle='dropdown' class='btn pd-y-3 tx-gray-500 hover-info'><i class='icon ion-more'></i></a> \
                      <div class='dropdown-menu dropdown-menu-right pd-10'> \
                        <nav class='nav nav-style-1 flex-column'> \
                          <a href='#' onclick='DocumentosALM("+datos[i].id+")' class='nav-link'>Ver Documentos</a> \
                        </nav> \
                      </div> \
                    </td> \
                </tr>";            
                n=n+1;
            }
            if(n != 0){                
                LlenaPaginador(datos.length, datos, "t-ExpDigitales");
            }
            $('#loading').addClass('d-none');   
        }else{
            document.getElementById("t-ExpDigitales").innerHTML +=
                "<tr> \
                    <td> \
                      <i class='fa fa-exclamation tx-22 tx-danger lh-0 valign-middle'></i> \
                      <span class='pd-l-5'>No hay archivos disponibles</span> \
                    </td> \
                </tr>";
            $('#datatable1_paginate').addClass('d-none');            
            $('#loading').addClass('d-none');   
        }
        

    });	


}

function DocumentosALM(idalm){

    $("#t-ArchivosALM tbody").children().remove();    
    $("#loading").removeClass("d-none");    
    $("#expalm").addClass("d-none");    
    $("#ArchivosALM").removeClass("d-none");

    var storage = new Object();
    storage.server = datosuser.server;
    storage.user_storage = datosuser.user_storage;
    storage.pwd_storage = datosuser.pwd_storage;
    //console.log(storage);


    $.get(ws + "ArchivosAlmacen", {idempresa: idempresaglobal, idalmacen: idalm}, function(data){
        var datos = JSON.parse(data);
        
        if(datos.length > 0){      

            var datosadw = "";
            for (var i = 0; i < datos.length; i++) {
                datosadw = datos[i].conceptoadw + "-" + datos[i].folioadw + (datos[i].serieadw != null ? "-" + datos[i].serieadw : "");
                document.getElementById("t-ArchivosALM").innerHTML +=
                "<tr> \
                    <td> \
                        <label class='ckbox mg-b-0'> \
                            <input type='checkbox' id='check_"+datos[i].id+"'><span></span> \
                        </label> \
                    </td> \
                    <td><a href='"+datos[i].download+"' target='_blank'>"+datos[i].documento+"</a></td> \
                    <td>"+datosadw+"</td> \
                    <td>"+datos[i].agente+"</td> \
                    <td>"+(datos[i].fechaprocesado == null ? "YYYY-MM-DD" : datos[i].fechaprocesado)+"</td> \
                    <td> \
                      <a href='#' data-toggle='dropdown' class='btn pd-y-3 tx-gray-500 hover-info'><i class='icon ion-more'></i></a> \
                      <div class='dropdown-menu dropdown-menu-right pd-10'> \
                        <nav class='nav nav-style-1 flex-column'> \
                          <a href='"+datos[i].download+"' target='_blank' class='nav-link'>Ver</a> \
                          <a href='"+datos[i].download+"/download' target='_blank' class='nav-link'>Descargar</a> \
                          <a href='#' onclick='CompartirArchivoALM("+datos[i].id+")' class='nav-link'>Compartir</a> \
                          <a href='#' onclick='EliminarArchivoALM("+datos[i].id+","+datos[i].idalmdigital+")' class='nav-link'>Eliminar</a> \
                        </nav> \
                      </div> \
                    </td> \
                </tr>";            

            }
            $('#loading').addClass('d-none'); 
            btnregresar = 2;

        }else{
            $('#loading').addClass('d-none');
            btnregresar = 2;
        }        

    });

          
    
}

function EliminarArchivoALM(idarchivo, idalmacen, link){
    var objeto = new Object();
    objeto.rfcempresa = datosuser.rfcempresa;
    objeto.usuario = datosuser.usuario;
    objeto.pwd = datosuser.pwd;
    objeto.idarchivo = idarchivo;
    objeto.idalmacen = idalmacen;

    $("#loading").removeClass('d-none');

    $.get(ws + "SubMenuPermiso", {idempresa: idempresaglobal, idusuario: idusuarioglobal}, function(data){
        var subper = data;
        
        for (var i = 0; i < subper.length; i++) {
            if(subper[i].idsubmenu == idsubmenuglobal){
                var tipopermiso = subper[i].tipopermiso;
                break;
            }
        } 
        $("#loading").addClass('d-none');
//    var tipopermiso = VerificaPermisoSubMenu(idempresaglobal, idusuarioglobal, idsubmenuglobal);
        if(tipopermiso == 3){
            swal("¿Estas seguro de deseas eliminar el archivo?", {
              buttons: {
                Continuar: "Continuar",
                cancel: "Cancelar",    
              },
            })
            .then((value) => {
              switch (value) { 
                case "Cancelar":          
                  break;
                case "Continuar":
                     $("#loading").removeClass('d-none');
                     $.post(ws + "EliminaArchivoAlmacen", {objeto}, function(data){
                        var respuesta = JSON.parse(data);
                        if(respuesta["error"] == 0){
                            if(respuesta["eliminado"] == 0){

                                var parametros = {
                                    "rfcempresa" : datosuser.rfcempresa,
                                    "u_storage" : datosuser.user_storage,
                                    "p_storage" : datosuser.pwd_storage,
                                    "archivo" : respuesta["archivo"],
                                    "idmenu": menu,
                                    "idsubmenu" : idsubmenuglobal
                                };
                                $.ajax({
                                        data:  parametros, //datos que se envian a traves de ajax
                                        url:   '../submenus/EliminarArchivos_Storage.php', //archivo que recibe la peticion
                                        type:  'post', //método de envio
                                        beforeSend: function () {
                                                //$("#resultado").html("Procesando, espere por favor...");
                                        },
                                        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                                            $("#loading").addClass('d-none');
                                            swal("El archivo fue eliminado correctamente", {
                                              icon: "success",
                                            })
                                            .then((value) => {
                                              switch (respuesta["totalregistros"]) {                     
                                                case 0:
                                                  ExpDigitales(modulo, menu, submenu, datosuser.rfcempresa);
                                                  break;                     
                                                default:
                                                  DocumentosALM(idalmacen);
                                              }
                                            });                                          
                                        }
                                });                        
                                
                            }else{
                                $("#loading").addClass('d-none');
                                swal("¡Error!","El archivo ya ha sido procesado y no puede ser eliminado.","error");
                            }                                     
                        }else{
                            $("#loading").addClass('d-none');
                            swal("¡Error!","Hubo un error al intentar eliminar el archivo.","error");
                        }
                    });
                    break;
              }
            }); 

        }else{
            swal("¡Denegado!","No cuentas con los permisos suficientes para realizar esta accion.","warning");
        }
   
     });

}

function cerrarArchivos(){   
    //$('#selectRubros').find('option').remove();
    document.getElementById("FormSubirArchivos").reset();  
    $('#SubirArchivosInbox').modal('hide');
}
function SubirArchivos(){
    //$('#selectRubros option').remove();
    $('#selectSucursales option').remove();
    document.getElementById("comentarios").value = "";
    document.getElementById("datepicker").value = ""; 
    document.getElementById("numero_archivos").innerHTML = 0;
    cargarSucursales("selectSucursales");
    //cargarRubros("selectRubros");
        
//    $('#SubirArchivosInbox').modal('show');
}

function CountArc(){
    var archivos = $('#archivos')[0].files;
    document.getElementById("numero_archivos").innerHTML = archivos.length;

}


$("#numero_archivos").click(function(evento){

    var contenido = "";
    $('[rel=popover]').popover({
        title: "Expedientes Digitales",
        html: true,
        content: function () {
            var contenido = "";
            var j = 0;
            jQuery.each(jQuery('#archivos')[0].files, function(i, file) {  
                i++;                
                contenido = contenido + file["name"] + '<br />';               
                j = j + 1;
            });    
            if(j > 0){
                return contenido;    
            }else{
                contenido = "No hay archivos seleccionados."
                return contenido;
            }   
        }
    });     

    
}); 

var existRubros;
function cargarRubros(nameSelec){    
    selectPer = document.getElementById(nameSelec);
    existRubros = 0;
    $.post(ws + "RubrosGen", {rfcempresa: datosuser.rfcempresa, usuario: datosuser.usuario, pwd: datosuser.pwd}, function(data){
        var rubros = JSON.parse(data).rubros;
        if(rubros.length > 0){            
            for(var x in rubros){
                if(idsubmenuglobal == rubros[x].idsubmenu){
                    option = document.createElement("option");
                    option.value = rubros[x].clave;
                    option.text = rubros[x].nombre;
                    selectPer.appendChild(option);                
                    existRubros = 1;
                }
            }
            cargarSucursales("selectSucursales");      
        }
    });
}
var existSucursales;
function cargarSucursales(nameSelec){    
    selectsuc = document.getElementById(nameSelec);
    existSucursales = 0;
    $.post(ws + "CatSucursales", {rfcempresa: datosuser.rfcempresa, usuario: datosuser.usuario, pwd: datosuser.pwd},function(resp){
        var sucursales = JSON.parse(resp).sucursales;
        if(sucursales.length > 0){
            for(var x in sucursales){
                option = document.createElement("option");
                option.value = sucursales[x].idsucursal;
                option.text = sucursales[x].sucursal;
                selectsuc.appendChild(option);
            }            
            existSucursales = 1;
//            if(existRubros == 0){
//                swal("¡Rubros!", "No se han dado de alta los rubros.", "warning");
//                $('#SubirArchivosInbox').modal('hide');
//            }else{
                $('#SubirArchivosInbox').modal('show');
//            }
        }else{
            swal("¡Sucursales!", "No se han dado de alta las sucursales.", "warning");
            $('#SubirArchivosInbox').modal('hide');
        }
    });
}

function Calendario()
{
    $('#datepicker').datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      numberOfMonths: 1,
      dateFormat: 'yy-mm-dd',
      dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
    });

    document.getElementById('ui-datepicker-div').style.setProperty('z-index', '9999', 'important');

}

$("#datepicker").mouseenter(function(evento){
    Calendario();
}); 

function cargarArchivos(){  
    var nomArchivos = [];
    var archivos = $('#archivos')[0].files;
    var rfc = $('#txtRFC').val();          
    var contador = archivos.length;       
    //var idUsuario = document.getElementById("idUsuarioArch").value;
    var observaciones = document.getElementById("comentarios").value;
    var fechadocto = document.getElementById("datepicker").value;

//    var e = document.getElementById("selectRubros");
//    var Rubro = e.options[e.selectedIndex].value;
    var s = document.getElementById("selectSucursales");
    var sucursal = s.options[s.selectedIndex].text;

    for (var i = 0; i < _NombresSubM.length; i++) {
        if(_NombresSubM[i]["idsubmenu"] == idsubmenuglobal){
            var submenu = _NombresSubM[i]["nombre_carpeta"];
            break;
        }
    }

    for (var j = 0; j < _NombresMenus.length; j++) {
        if(_NombresMenus[j]["idmenu"] == idmenuglobal){
            var menu = _NombresMenus[j]["nombre_carpeta"];
            break;
        }
    }    

    if(contador > 0){
        // if(Rubro != ""){
            if(sucursal != ""){               

                var archivosList = new FormData();
                archivosList.append('rfc', datosuser.rfcempresa);
                archivosList.append('u_storage', datosuser.user_storage);
                archivosList.append('p_storage', datosuser.pwd_storage);
                archivosList.append('server_storage', datosuser.server);
                archivosList.append('menu', menu);
                archivosList.append('submenu', submenu);
                archivosList.append('fechadocto', fechadocto);
//                archivosList.append('rubro', Rubro);

                var datos = new Object();
                datos.rfcempresa = datosuser.rfcempresa;
                datos.usuario = datosuser.usuario;
                datos.pwd = datosuser.pwd;
                datos.idmenu = idmenuglobal;
                datos.idsubmenu = idsubmenuglobal;
                datos.fechadocto = fechadocto;
//                datos.rubro = Rubro;
                

                $.post(ws + "ExtraerConsecutivo", {datos}, function(response){  
                    var resp = JSON.parse(response);
                    var n = 1;
                    if(resp.error==0){

                        datos.observaciones = observaciones;
                        datos.sucursal = sucursal;                        
                                        
                        jQuery.each(jQuery('#archivos')[0].files, function(i, file) {  
                            i++;
                            archivosList.append('file-'+n, file);                     
                            n=n+1;                            
                        });           
                        archivosList.append('consecutivo', resp.consecutivo);   
                        
                        $('#SubirArchivosInbox').modal('hide');
                        $("#loading").removeClass('d-none');
                                        

                        jQuery.ajax({ //ajax para cargar archivos a la nube
                            url: '../submenus/cargarArchivos.php',
                            data: archivosList,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            dataType: 'json',
                            success: function(response){  
                                var resp = response;  
                                var j = 0;
                                if (resp.length > 0) {  

                                    archivos = new Array();   

                                    for (var i = 0; i < resp.length; i++) {
                                        archivos[j] = new Object();
                                        archivos[j].archivo = resp[i]["archivo"]; 
                                        archivos[j].codigo = resp[i]["codigo"]; 
                                        archivos[j].link = resp[i]["link"];
                                        archivos[j].status = resp[i]["error"];
                                        j= j + 1;
                                    }             

                                    datos.archivos = archivos;  
                            
                                    $.post(ws + "AlmCargaArchivos", {datos}, function(response){  
                                        var respuesta = JSON.parse(response); 

                                         ImprimeDetalle(respuesta["archivos"]);

                                         $("#loading").addClass('d-none');
                                        
                                         swal("Expedientes Digitales Cargados Correctamente.", { 
                                             icon: "success",
                                             buttons: false,
                                             timer: 3000,
                                         });                                    

                                    });                                      
                                                                                 
                                }else{
                                    $("#loading").addClass('d-none');
                                    $('#SubirArchivosInbox').modal('show');
                                    swal("¡Hubo un error!","Error al momento de subir los archivos, comunicarse a sistemas.","error");
                                }                                                 
                            }
                        });                               

                    }else{
                        if(resp.error == 1){
                            swal("¡Hubo un error!", "El RFC de la empresa es incorrecto.","info");                
                        }else if(resp.error == 2){
                            swal("¡Hubo un error!", "El correo del usuario no existe.","info");                
                        }else if(resp.error == 3){
                            swal("¡Hubo un error!", "La contraseña es incorrecta.","info");                
                        }else if(resp.error == 4){
                            swal("¡Hubo un error!", "El usuario no cuenta con los permisos suficientes.","info");                
                        }                        
                    }

                });
            }else{
                swal("¡Sucursal!", "Seleccione una sucursal.","info");
            }
        // }else{
        //     swal("¡Rubro!", "Seleccione un rubro.","info");
        // }
    }else{
        swal("¡Archivo!", "Seleccione un archivo.","info");
    }
}

function ImprimeDetalle(arcSubidos){
    var mensaje = "";
    var detalle = "";

    $("#expalm").addClass('d-none');
    $("#DivArchivoDetalle").removeClass('d-none');
    $("#t-ArchivoDetalle tbody").children().remove(); 
    

    for (var i = 0; i < arcSubidos.length; i++) {
        if(arcSubidos[i].status == 0){
            cargado = "Si";
            detalle = arcSubidos[i].detalle;
            //detalle = "Cargado Correctamente.";
        }else if(arcSubidos[i].status == 1 || arcSubidos[i].status == 2 || arcSubidos[i].status == 3){
            cargado = "No";
            detalle = arcSubidos[i].detalle;
        }

        if(arcSubidos[i].status == 0){
            document.getElementById("t-ArchivoDetalle").innerHTML +=
            "<tr> \
                <td><a href='"+arcSubidos[i].link+"' target='_blank'>"+arcSubidos[i].archivo+"</a></td> \
                <td>"+cargado+"</td> \
                <td>"+detalle+"</td> \
            </tr>";            
        }else{
            document.getElementById("t-ArchivoDetalle").innerHTML +=
            "<tr class='bg-danger'> \
                <td class='tx-black'>"+arcSubidos[i].archivo+"</td> \
                <td class='tx-black'>"+cargado+"</td> \
                <td class='tx-black'>"+detalle+"</td> \
            </tr>";                        
        }


    }

    btnregresar = 2;

}

function ValidaFecha(fecha) {
    var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
    if ((fecha.match(RegExPattern)) && (fecha!='')) {
        if(ExisteFecha(fecha)){                
            return true;
        }else{                
            return false;
        }            
    }else{
        return false;
    }
}

function ExisteFecha(fecha){
      var fechaf = fecha.split("-");
      var day = fechaf[2];
      var month = fechaf[1];
      var year = fechaf[0];
      var date = new Date(year,month,'0');
      if((day-0)>(date.getDate()-0)){
            return false;
      }
      return true;
}

function ShareFiles(tabla){

}

function DownFiles(tabla){

}

function DeleteFiles(tabla){
    
}