
var per;
var _NombresSubM;
var _NombresMenus;

function CargaDatosEmpresa(idusuario, idempresalog, idperfil, pwd) {

    idempresaglobal = idempresalog;
    idusuarioglobal = idusuario;

    $.get(ws + "SubMenus", function(resSubMenus){
        _NombresSubM = resSubMenus;      

        $.get(ws + "Menus", function(resMenus){
            _NombresMenus = resMenus;
        
            $.get(ws + "DatosUsuario/" + idusuario, function(data) {
                var usuario = JSON.parse(data).usuario;
                if (usuario.length > 0) {
                    var nombre_completo = usuario[0].nombre + " " + usuario[0].apellidop + " " + usuario[0].apellidom;
                    document.getElementById('nUsuario').innerText = nombre_completo;            

                    tipousuarioglobal = usuario[0].tipo;
             
                    $.get(ws + "DatosEmpresaAD/" + idempresalog, function(data) {
                        var empresa = JSON.parse(data).empresa;
                        if (empresa.length > 0) {
                            document.getElementById('nEmpresa').innerHTML = empresa[0].nombreempresa;

                            datosuser = new Usuario(empresa[0].RFC, usuario[0].correo, pwd);
                            datosuser.nombre_empresa = empresa[0].nombreempresa;

                            $.get(ws + "DatosStorage", { rfcempresa: empresa[0].RFC }, function(data) {
                                var datos = JSON.parse(data);
                                datosuser.server = datos[0].server;
                                datosuser.user_storage = datos[0].usuario_storage;
                                datosuser.pwd_storage = datos[0].password_storage;
                            });
                            
                            $.get(ws + "DatosPerfil", {idempresa: idempresaglobal, idusuario: idusuarioglobal}, function(data){
                                var datos = JSON.parse(data);                                   
                                var perfil = datos[0].nombre;                 
                                datosuser.idperfil = datos[0].idperfil;
                                document.getElementById('nUsuario_per').innerText = perfil;
                            });                                       

                        }
                    });

                    var idmod = 0;
                    var idmen = 0;
                    var idsub = 0;
                    var url_p = window.location.href;   
                    var url = new URL(url_p); 
                    if(url_p.includes("mod")==true){
                        idmod = url.searchParams.get("mod");
                        if(url_p.includes("men")==true){
                            idmen = url.searchParams.get("men");
                            if(url_p.includes("sub")==true){
                                idsub = url.searchParams.get("sub");
                            }                        
                        }

                        var parametros = {
                            "mod" : idmod,
                            "men" : idmen,
                            "sub" : idsub
                        };

                        

                        $.ajax({
                            data:  parametros,
                            url: '../empuser/redireccionamiento.php',
                            type:  'post', //método de envio
                            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                                var respuesta = JSON.parse(response); 
                                var ruta = respuesta["ruta"];
                                var mod = respuesta["mod"];
                                var men = respuesta["men"];
                                var sub = respuesta["sub"];
                                //loadDiv(ruta, mod, men, sub);
                                loadDiv(ruta,mod,men,sub);
                            }
                        });                            
                    }            
                } 

            });
        });                
    });

  


}


function CargaContenido(idmodulo, idmenu, idsubmenu, RFCEmpresa) {

    URL_Asigna_SubM(idsubmenu);

    $('#loading').removeClass('d-none');
    if (idmodulo == 2) {
        $('#divdinamico').load('../submenus/contenidosInbox2.php');
    }else if (idmodulo == 1) {
        $('#divdinamico').load('../submenus/contenidos.php');
    }

    var ruta = "";
    var modulo = "";
    var menu = "";
    var submenu = "";

    switch (idmodulo) {
        case ModContabilidad:
            modulo = "Contabilidad";
            switch (idmenu) {
                case MenuContabilidad:
                    menu = "Contabilidad";
                    break;
                case MenuProcesoFiscal:
                    menu = "ProcesoFiscal";
                    break;
                case MenuFinanzas:
                    menu = "Finanzas";
                    break;
            }
            break;
        case ModBandejaEntrada:
            modulo = "Entrada";
            switch (idmenu) {
                case MenuCompras:
                    menu = "Compras";
                    break;
                case MenuAlmacenDigital:
                    menu = "AlmacenDigital";
                    break;
                case MenuRecepcionLotes:
                    menu = "RecepcionporLotes";
                    break;
            }
            break;
    }


    switch (idsubmenu) {
        case SubEstadosFinancieros:
            submenu = "EstadosFinancieros";
            break;
        case SubContabilidadElectronica:
            submenu = "ContabilidadElectronica";
            break;
        case SubExpedientesAdmin:
            submenu = "ExpedientesAdministrativos";
            break;
        case SubExpedientesContables:
            submenu = "ExpedientesContables";
            break;
        case SubPagosProvicionales:
            submenu = "PagosProvisionales";
            break;
        case SubPagosMensuales:
            submenu = "PagosMensuales";
            break;
        case SubDeclaracionesAnuales:
            submenu = "DeclaracionesAnuales";
            break;
        case SubExpedientesFiscales:
            submenu = "ExpedientesFiscales";
            break;
        case SubIndicadoresFinancieros:
            submenu = "IndicadoresFinancieros";
            break;
        case SubAsesorFlujoEfectivo:
            submenu = "AsesordeFlujosdeEfectivo";
            break;
        case SubAnalisisProyecto:
            submenu = "AnalisisdeProyectos";
            break;
        case SubRequerimientos:
            submenu = "Requerimientos";
            break;
        case SubAutorizaciones:
            submenu = "Autorizaciones";
            break;
        case SubRecepcionCompras:
            submenu = "Recepcióndecompras";
            break;
        case SubNotificacionesAutoridades:
            submenu = "NotificacionesdeAutoridades";
            break;
        case SubExpedientesDigitales:
            submenu = "ExpedientesDigitales";
            break;
        case SubProcesoProduccion:
            submenu = "ProcesodeProducción";
            break;
        case SubProcesoCompras:
            submenu = "ProcesodeCompras";
            break;
        case SubProcesoVenta:
            submenu = "ProcesodeVentas";
            break;
    }

    var storage = new Object();
    storage.server = datosuser.server;
    storage.user_storage = datosuser.user_storage;
    storage.pwd_storage = datosuser.pwd_storage;
    //ruta = "../../nextclouddata/admindublock/files/PruebaSincro/" + RFCEmpresa + "/" + modulo + "/" + menu + "/" + submenu + "/";
    //ruta = "../../../nextclouddata/admindublock/files/PruebaSincro/"+RFCEmpresa+"/"+modulo+"/"+menu+"/"+submenu+"/";
    //ruta = "../archivospdf/"+RFCEmpresa+"/"+submenu+"";
    
    $.ajax({
        url: '../submenus/leer_carpeta.php',
        type: 'POST',
        data: { modulo: modulo, menu: menu, submenu: submenu, RFCEmpresa: RFCEmpresa, idsubmenu: idsubmenu, datosserver: storage },
        success: function(data) {
            var archivo = "";
            var nombrearchivo = "";
            var array2 = JSON.parse(data);

            if (array2[0].nombre != "Vacio") {

                for (x in array2) {
                    archivo = array2[x].nombre;
                    nombrearchivo = archivo.replace(".pdf", "");
                    nombrearchivo = archivo.replace(/ /gi, "_");

                    document.getElementById("t-Archivos").innerHTML +=
                        "<tr> \
                        <td class='valign-middle'> \
                          <label class='ckbox mg-b-0'> \
                            <input type='checkbox' name='" + submenu + "' id='" + nombrearchivo + "'><span></span> \
                          </label> \
                        </td> \
                        <td>" + array2[x].servicio + "</td> \
                        <td> \
                          <a id='link_" + nombrearchivo + "' href='" + array2[x].link + "' target='_blank'><i class='fa fa-file-pdf-o tx-22 tx-danger lh-0 valign-middle'></i> \
                          <span id='span_" + nombrearchivo + "' class='pd-l-5'>" + nombrearchivo + "</span></a> \
                        </td> \
                        <td class='hidden-xs-down'>" + array2[x].fecha + "</td> \
                        <td class='hidden-xs-down'>" + array2[x].agente + "</td> \
                        <td class='dropdown'> \
                          <a href='#' data-toggle='dropdown' class='btn pd-y-3 tx-gray-500 hover-info'><i class='icon ion-more'></i></a> \
                          <div class='dropdown-menu dropdown-menu-right pd-10'> \
                            <nav class='nav nav-style-1 flex-column'> \
                              <a href='" + array2[x].link + "' target='_blank' class='nav-link'>Abrir</a> \
                              <a href='" + array2[x].link + "/download' id='Descargar_" + nombrearchivo + "' class='nav-link'>Descargar</a> \
                            </nav> \
                          </div> \
                        </td> \
                      </tr>";
                }

                $('#loading').addClass('d-none');

            } else {

                document.getElementById("t-Archivos").innerHTML +=
                    "<tr> \
                        <td></td> \
                        <td> \
                          <i class='fa fa-exclamation tx-22 tx-danger lh-0 valign-middle'></i> \
                          <span class='pd-l-5'>No hay archivos disponibles</span> \
                        </td> \
                        <td> DD/MM/YYYY HH/MM/SS </td> \
                      </tr>";
                $('#loading').addClass('d-none');

            }

        }

    });


}

function DescargarArchivosCon() {
    var filas = $("#t-Archivos").find("tr");
    //var ruta = "../submenus/temporales/";
    for (i = 1; i < filas.length; i++) { //Recorre las filas 1 a 1]    
        celdas = $(filas[i]).find("input"); //devolverá las celdas de una fila
        var name = celdas[0].id;
        var href = $('#link_' + name).attr('href');
        console.log($('#' + name).prop('checked'));
        if ($('#' + name).prop('checked')) {
            window.open(href + "/download");
        }
    }
}

function CompartirArchivos() {
    var filas = $("#t-Archivos").find("tr");
    document.getElementById("textarea_links").innerHTML = "";
    for (i = 1; i < filas.length; i++) { //Recorre las filas 1 a 1]    
        celdas = $(filas[i]).find("input"); //devolverá las celdas de una fila
        var name = celdas[0].id;
        var href = $('#link_' + name).attr('href');

        //var datos = name+".pdf" + "<br/>"+href+"<br/>";
        if ($('#' + name).prop('checked')) {
            document.getElementById("textarea_links").innerHTML += name + ".pdf \n" + href + "\n\n";
        }
    }
}

function EnviarLinks() {
    var destinatarios;
    var mensaje;
    var verifica = 0;

    destinatarios = document.getElementById("destinatarios").value;
    mensaje = document.getElementById("textarea_links").value;

    if (destinatarios != "") {
        verifica = ValidaCorreos(destinatarios);
        if (verifica != 1) {
            CompartirLinks(destinatarios, mensaje);
        } else {
            swal("Destinatarios", "Correos no validos.", "error");
        }
    } else {
        swal("Destinatario(s)", "Ingrese un destinatario o destinatarios.", "error");
    }

}

function CompartirLinks(destinatarios, mensaje) {

    var correos = destinatarios.replace(";", ",");
    $.ajax({
        url: '../../login/validarcorreo/valida.php',
        type: 'POST',
        data: { destinatarios: correos, mensaje: mensaje },
        success: function(response) {
            var respuesta = response;
            //console.log(respuesta);
            swal("Compartidos", "Archivos compartidos correctamente.", "success");
            $("#CompartirLinks").modal("hide");
        }
    });

}

function ValidaCorreos(correos) {
    var destinatarios = correos.split(";");
    var CorreosValidos = 0;
    for (x = 0; x < destinatarios.length; x++) {
        if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+$/.test(destinatarios[x])) {
            CorreosValidos = 0;
        } else {
            CorreosValidos = 1;
            return CorreosValidos;
        }
    }
}

function CargaContenidoInbox(idmodulo, idmenu, idsubmenu, RFCEmpresa) {


    $('#loading').removeClass('d-none');
    if (idmodulo == 2) {
        $('#divdinamico').load('../submenus/alm_expedientesdigitales.php');
    } else if (idmodulo == 1) {
        $('#divdinamico').load('../submenus/contenidos.php');
    }

    var ruta = "";
    var modulo = "";
    var menu = "";
    var submenu = "";

    switch (idmodulo) {
        case ModContabilidad:
            modulo = "Contabilidad";
            switch (idmenu) {
                case MenuContabilidad:
                    menu = "Contabilidad";
                    break;
                case MenuProcesoFiscal:
                    menu = "ProcesoFiscal";
                    break;
                case MenuFinanzas:
                    menu = "Finanzas";
                    break;
            }
            break;
        case ModBandejaEntrada:
            modulo = "Entrada";
            switch (idmenu) {
                case MenuCompras:
                    menu = "Compras";
                    break;
                case MenuAlmacenDigital:
                    menu = "AlmacenDigital";
                    break;
                case MenuRecepcionLotes:
                    menu = "RecepcionporLotes";
                    break;
            }
            break;
    }


    switch (idsubmenu) {
        case SubEstadosFinancieros:
            submenu = "EstadosFinancieros";
            break;
        case SubContabilidadElectronica:
            submenu = "ContabilidadElectronica";
            break;
        case SubExpedientesAdmin:
            submenu = "ExpedientesAdministrativos";
            break;
        case SubExpedientesContables:
            submenu = "ExpedientesContables";
            break;
        case SubPagosProvicionales:
            submenu = "PagosProvisionales";
            break;
        case SubPagosMensuales:
            submenu = "PagosMensuales";
            break;
        case SubDeclaracionesAnuales:
            submenu = "DeclaracionesAnuales";
            break;
        case SubExpedientesFiscales:
            submenu = "ExpedientesFiscales";
            break;
        case SubIndicadoresFinancieros:
            submenu = "IndicadoresFinancieros";
            break;
        case SubAsesorFlujoEfectivo:
            submenu = "AsesordeFlujosdeEfectivo";
            break;
        case SubAnalisisProyecto:
            submenu = "AnalisisdeProyectos";
            break;
        case SubRequerimientos:
            submenu = "Requerimientos";
            break;
        case SubAutorizaciones:
            submenu = "Autorizaciones";
            break;
        case SubRecepcionCompras:
            submenu = "Recepcióndecompras";
            break;
        case SubNotificacionesAutoridades:
            submenu = "NotificacionesdeAutoridades";
            break;
        case SubExpedientesDigitales:
            submenu = "ExpedientesDigitales";
            break;
        case SubProcesoProduccion:
            submenu = "ProcesodeProducción";
            break;
        case SubProcesoCompras:
            submenu = "ProcesodeCompras";
            break;
        case SubProcesoVenta:
            submenu = "ProcesodeVentas";
            break;
    }

    ruta = "../../nextclouddata/admindublock/files/PruebaSincro/" + RFCEmpresa + "/" + modulo + "/" + menu + "/" + submenu + "/";
    //ruta = "../../../nextclouddata/admindublock/files/PruebaSincro/"+RFCEmpresa+"/"+modulo+"/"+menu+"/"+submenu+"/";
    //ruta = "../archivospdf/"+RFCEmpresa+"/"+submenu+"";

    $.ajax({
        url: '../submenus/leer_carpeta.php',
        type: 'POST',
        data: { modulo: modulo, menu: menu, submenu: submenu, RFCEmpresa: RFCEmpresa },
        success: function(data) {
            var archivo = "";
            var nombrearchivo = "";
            var array2 = JSON.parse(data);

            if (array2[0].nombre != "Vacio") {
                for (x in array2) {
                    archivo = array2[x].nombre;
                    nombrearchivo = archivo.replace(".pdf", "");

                    document.getElementById("t-ArchivosBody").innerHTML +=
                        "<tr> \
                        <td class='valign-middle'> \
                          <label class='ckbox mg-b-0'> \
                            <input type='checkbox' name='" + submenu + "' id='" + nombrearchivo + "'><span></span> \
                          </label> \
                        </td> \
                        <td> \
                          <a href='" + array2[x].link + "' target='_blank'><i class='fa fa-file-pdf-o tx-22 tx-danger lh-0 valign-middle'></i> \
                          <span class='pd-l-5'>" + array2[x].nombre + "</span></a> \
                        </td> \
                        <td class='hidden-xs-down'>" + array2[x].fecha + "</td> \
                        <td class='dropdown'> \
                          <a href='#' data-toggle='dropdown' class='btn pd-y-3 tx-gray-500 hover-info'><i class='icon ion-more'></i></a> \
                          <div class='dropdown-menu dropdown-menu-right pd-10'> \
                            <nav class='nav nav-style-1 flex-column'> \
                              <a href='" + array2[x].link + "' target='_blank' class='nav-link'>Abrir</a> \
                              <a href='#' download='' class='nav-link'>Descargar</a> \
                            </nav> \
                          </div> \
                        </td> \
                      </tr>";
                }

                $('#loading').addClass('d-none');
                //document.getElementById("loading").style.display = "none";

            } else {
                /*
                                document.getElementById("t-Archivos").innerHTML +=
                                      "<tr> \
                                        <td></td> \
                                        <td> \
                                          <i class='fa fa-exclamation tx-22 tx-danger lh-0 valign-middle'></i> \
                                          <span class='pd-l-5'>No hay archivos disponibles</span> \
                                        </td> \
                                        <td> DD/MM/YYYY HH/MM/SS </td> \
                                      </tr>";                
                                $('#loading').addClass('d-none');
                */
            }

        }

    });
}




// }