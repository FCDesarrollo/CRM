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

    $.post(ws + "datosRubrosSubMenu", {Correo: datosuser.usuario, Contra: datosuser.pwd, Idempresa: idempresaglobal, idmenu: idmenu, idsubmenu: idsubmenu}, function(data){
        var myArr = JSON.stringify(data);
        $.get(ws + "DatosAlmacen", {rfcempresa: datosuser.rfcempresa}, function(data){
            var datos = JSON.parse(data);
            
            if(datos.length > 0){            
                var n = 0;
                for (var i = 0; i < (datos.length > lotes_x_pag ? lotes_x_pag : datos.length); i++) {
                    if(myArr.includes(datos[i].claverubro)){

                        document.getElementById("t-ExpDigitales").innerHTML +=
                        "<tr> \
                            <td>"+datos[i].fechadocto+"</td> \
                            <td>"+datos[i].usuario+"</td> \
                            <td>"+datos[i].rubro+"</td> \
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
                }

                //LlenaPaginador(datos.length, datos, "t-ExpDigitales");
                if(n != 0){                
                    LlenaPaginador(i, datos, "t-ExpDigitales");
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

            // $.ajax({
            //     async:true,
            //     url: '../submenus/leer_carpeta.php',
            //     type: 'POST',
            //     data: {RFCEmpresa: datosuser.rfcempresa, datosserver: storage, archivos: datos, idmenu: menu, idsubmenu: submenu},
            //     success: function (responseAJAX) {
            //         var respuesta = JSON.parse(responseAJAX);
                    //console.log(respuesta[0].link);

                    //for (var i = 0; i < (respuesta.length > 5 ? 5 : respuesta.length); i++) {
                    for (var i = 0; i < datos.length; i++) {
                    
                        document.getElementById("t-ArchivosALM").innerHTML +=
                        "<tr> \
                            <td> \
                                <label class='ckbox mg-b-0'> \
                                    <input type='checkbox' id='check_"+datos[i].id+"'><span></span> \
                                </label> \
                            </td> \
                            <td>"+datos[i].documento+"</td> \
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
//                }
//            });
        }else{
            $('#loading').addClass('d-none');
            btnregresar = 2;
        }        

    });

          
    
}

function ShareFileAlm(){

}

function DownFileAlm(){

}

function EliminarArchivoALM(idarchivo, idalmacen, link){
    var objeto = new Object();
    objeto.rfcempresa = datosuser.rfcempresa;
    objeto.usuario = datosuser.usuario;
    objeto.pwd = datosuser.pwd;
    objeto.idarchivo = idarchivo;
    objeto.idalmacen = idalmacen;

    $.get(ws + "SubMenuPermiso", {idempresa: idempresaglobal, idusuario: idusuarioglobal}, function(data){
        var subper = data;
        
        for (var i = 0; i < subper.length; i++) {
            if(subper[i].idsubmenu == idsubmenuglobal){
                var tipopermiso = subper[i].tipopermiso;
                break;
            }
        } 

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
                                swal("¡Error!","El archivo ya ha sido procesado y no puede ser eliminado.","error");
                            }                                     
                        }else{
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
    $('#selectRubros').find('option').remove();
    document.getElementById("FormSubirArchivos").reset();  
    $('#SubirArchivosInbox').modal('hide');
}
function SubirArchivos(){
    $('#selectRubros option').remove();
    $('#selectSucursales option').remove();
    document.getElementById("comentarios").value = "";
    document.getElementById("datepicker").value = ""; 
    document.getElementById("numero_archivos").innerHTML = 0;
    cargarRubros("selectRubros");
        
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
            if(existRubros == 0){
                swal("¡Rubros!", "No se han dado de alta los rubros.", "warning");
                $('#SubirArchivosInbox').modal('hide');
            }else{
                $('#SubirArchivosInbox').modal('show');
            }
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
    var archivosList = new FormData();  
    var contador = archivos.length;       
    //var idUsuario = document.getElementById("idUsuarioArch").value;
    var observaciones = document.getElementById("comentarios").value;
    var fechadocto = document.getElementById("datepicker").value;

    var e = document.getElementById("selectRubros");
    var Rubro = e.options[e.selectedIndex].value;
    var s = document.getElementById("selectSucursales");
    var sucursal = s.options[s.selectedIndex].text;

    if(contador > 0){
        //if(ValidaFecha(fechadocto) == true){
            if(Rubro != ""){
                if(sucursal != ""){

                    var datos = new Object();
                    datos.rfcempresa = datosuser.rfcempresa;
                    datos.usuario = datosuser.usuario;
                    datos.pwd = datosuser.pwd;
                    datos.rubro = Rubro;
                    datos.observaciones = observaciones;
                    datos.sucursal = sucursal;
                    datos.fechadocto = fechadocto;
                    datos.archivos = new Object();
                    
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

                    archivosList.append('rfc', datosuser.rfcempresa);
                    archivosList.append('u_storage', datosuser.user_storage);
                    archivosList.append('p_storage', datosuser.pwd_storage);
                    archivosList.append('idmenu', idmenuglobal);
                    /*archivosList.append('idsubmenu', idsubmenuglobal);
                    archivosList.append('idempresa', idempresaglobal);
                    archivosList.append('idusuario', idusuarioglobal);*/
                    archivosList.append('menu', menu);
                    archivosList.append('submenu', submenu);
                    

                    var j = 0;
                    jQuery.each(jQuery('#archivos')[0].files, function(i, file) {  
                        i++;
                        datos.archivos[j] = file["name"];                        
                        j=j+1;
                        
                    });

                    $('#SubirArchivosInbox').modal('hide');
                    $("#loading").removeClass('d-none');
                    j=1;

                    //Carga los registros
                    $.post(ws + "AlmCargaArchivos", {datos}, function(response){  
                        var respuesta = JSON.parse(response); 
                        //console.log(respuesta);                       
                        if(respuesta.error == 0){
                            jQuery.each(jQuery('#archivos')[0].files, function(k, file) {  
                                k++;
                                for (var i = 0; i < respuesta["archivos"].length; i++) {
                                    //console.log(file["name"]);
                                    if(file["name"] == respuesta["archivos"][i]["archivo"] && respuesta["archivos"][i]["status"] == 0){
                                        archivosList.append('file-'+j, file);                                        
                                        archivosList.append('archivo-'+j, respuesta["archivos"][i]["codigo"]);
                                        archivosList.append('idalmacen-'+j, respuesta["archivos"][i]["idalmacen"]);
                                        archivosList.append('idarchivo-'+j, respuesta["archivos"][i]["idarchivo"]);
                                        j=j+1;                                    
                                    }                                                                        
                                }                                
                            });   

                            //console.log(archivosList);

                            if(j > 1){                                
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
                                        if (response.length > 0) {                        
                                            
                                            //swal("Carga Correcta","Archivos cargados correctamente","success");
                                            var objeto = new Object();
                                            objeto.idempresa = idempresaglobal;
                                            objeto.datos = resp;

                                            $.post(ws + "LinkDescarga", {objeto}, function(data){
                                                ImprimeDetalle(respuesta["archivos"], resp);

                                                $("#loading").addClass('d-none');
                                                
                                                swal("Expedientes Digitales Cargados Correctamente.", { 
                                                    icon: "success",
                                                    buttons: false,
                                                    timer: 3000,
                                                });

                                            });                                           
                                                                                         

                                            
                                            
                                            //ExpDigitales(modulo, menu, submenu, rfc);
                                        }else{
                                            $("#loading").addClass('d-none');
                                            $('#SubirArchivosInbox').modal('show');
                                            swal("¡Hubo un error!","Error al momento de subir los archivos, comunicarse a sistemas.","error");
                                        }                                                 
                                    }
                                }); 
                            }else{
                                $("#loading").addClass('d-none');
                                swal("Archivos(s) no se pueden cargar.","El archivo que intenta subir, ya existe, si desea reemplazar, debera eliminarlo primero.","info");
                            }
                        }else{
                            if(respuesta.error == 1){
                                swal("¡Hubo un error!", "El RFC de la empresa es incorrecto.","info");                
                            }else if(respuesta.error == 2){
                                swal("¡Hubo un error!", "El correo del usuario no existe.","info");                
                            }else if(respuesta.error == 3){
                                swal("¡Hubo un error!", "La contraseña es incorrecta.","info");                
                            }else if(respuesta.error == 4){
                                swal("¡Hubo un error!", "El usuario no cuenta con los permisos suficientes.","info");                
                            }else if(respuesta.error == 21){
                                swal("¡Hubo un error!", "Existe elementos en el catalogo que no han sido dados de alta en el sistema","info");                
                            }
                        }
                    });  
                }else{
                    swal("¡Sucursal!", "Seleccione una sucursal.","info");
                }
            }else{
                swal("¡Rubro!", "Seleccione un rubro.","info");
            }
        //}else{
        //    swal("¡Fecha del Documento!", "La fecha es incorrecta.","info");
        //}
    }else{
        swal("¡Archivo!", "Seleccione un archivo.","info");
    }
}

function ImprimeDetalle(arcDetalle, arcSubidos){
    var mensaje = "";
    var detalle = "";

    //console.log(arcDetalle);
//    console.log(arcSubidos);

    $("#expalm").addClass('d-none');
    $("#DivArchivoDetalle").removeClass('d-none');
    $("#t-ArchivoDetalle tbody").children().remove(); 
    

    for (var i = 0; i < arcSubidos.length; i++) {
        if(arcSubidos[i].error == 0){
            cargado = "Si";
            detalle = "Cargado Correctamente.";

        }else if(arcSubidos[i].error == 1){
            cargado = "No";
            detalle = arcSubidos[i].detalle;

            var objeto = new Object();
            objeto.rfcempresa = datosuser.rfcempresa;
            objeto.usuario = datosuser.usuario;
            objeto.pwd = datosuser.pwd;
            objeto.idarchivo = arcSubidos[i].idarchivo;
            objeto.idalmacen = arcSubidos[i].idalmacen;

            $.post(ws + "EliminaArchivoAlmacen", {objeto}, function(data){

            });
        }/*else if(arcSubidos[i].status == 2){
            cargado = "No";
            detalle = "Nombre del archivo no valido.";
        }*/


        document.getElementById("t-ArchivoDetalle").innerHTML +=
        "<tr> \
            <td>"+arcSubidos[i].nombre+"</td> \
            <td>"+cargado+"</td> \
            <td>"+detalle+"</td> \
        </tr>";            

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

				/*const api = new XMLHttpRequest();
				console.log("Hola");
				api.open('POST', ws + "CargaArchivos", true);
				api.send(miObjeto);
				api.onreadystatechange = function(){
					if(this.status == 200 && this.readyState == 4){
						let datos = JSON.parse(this.responseText);
						console.log(datos);
						$('#SubirArchivosInbox').modal('hide');
					}
				} */