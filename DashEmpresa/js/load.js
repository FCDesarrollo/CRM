//Constantes para los modulos
const ModContabilidad = 1;
const ModBandejaEntrada = 2;
//Constantes para los menus
const MenuContabilidad = 1;
const MenuProcesoFiscal = 2;
const MenuFinanzas = 3;
const MenuCompras = 4;
const MenuAlmacenDigital = 5;
const MenuRecepcionLotes = 6;
//Constantes para los submenus
const SubEstadosFinancieros = 1;
const SubContabilidadElectronica = 2;
const SubExpedientesAdmin = 3;
const SubExpedientesContables = 4;
const SubPagosProvicionales = 5;
const SubPagosMensuales = 6;
const SubDeclaracionesAnuales = 7;
const SubExpedientesFiscales = 8;
const SubIndicadoresFinancieros = 9;
const SubAsesorFlujoEfectivo = 10;
const SubAnalisisProyecto = 11;
const SubRequerimientos = 12;
const SubAutorizaciones = 13;
const SubRecepcionCompras = 14;
const SubNotificacionesAutoridades = 15;
const SubExpedientesDigitales = 16;
const SubProcesoProduccion = 17;
const SubProcesoCompras = 18;
const SubProcesoVenta = 19;


function CargaDatosEmpresa(idusuario, idempresalog) {

    idempresaglobal = idempresalog;
    idusuarioglobal = idusuario;

    $.get(ws + "DatosUsuario/" + idusuario, function(data) {
        var usuario = JSON.parse(data).usuario;
        if (usuario.length > 0) {
            document.getElementById('nUsuario').innerHTML = usuario[0].nombre;
        }
    });
    $.get(ws + "DatosEmpresaAD/" + idempresalog, function(data) {
        var empresa = JSON.parse(data).empresa;
        if (empresa.length > 0) {
            document.getElementById('nEmpresa').innerHTML = empresa[0].nombreempresa;
        }
    });

}


function CargaContenido(idmodulo, idmenu, idsubmenu, RFCEmpresa) {

    $('#loading').removeClass('d-none');
    if (idmodulo == 2) {
        $('#divdinamico').load('../submenus/contenidosInbox2.php');
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
                    document.getElementById("t-Archivos").innerHTML +=
                        "<tr> \
                        <td class='valign-middle'> \
                          <label class='ckbox mg-b-0'> \
                            <input type='checkbox' name='" + submenu + "' id='" + nombrearchivo + "'><span></span> \
                          </label> \
                        </td> \
                        <td> \
                          <a id='link_" + nombrearchivo + "' href='" + array2[x].link + "' target='_blank'><i class='fa fa-file-pdf-o tx-22 tx-danger lh-0 valign-middle'></i> \
                          <span id='span_" + nombrearchivo + "' class='pd-l-5'>" + array2[x].nombre + "</span></a> \
                        </td> \
                        <td class='hidden-xs-down'>" + array2[x].fecha + "</td> \
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

function DescargarArchivos() {

    var filas = $("#t-Archivos").find("tr");
    var ruta = "../submenus/temporales/";
    for (i = 1; i < filas.length; i++) { //Recorre las filas 1 a 1]    
        celdas = $(filas[i]).find("input"); //devolverá las celdas de una fila
        var name = celdas[0].id;
        var href = $('#link_' + name).attr('href');
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
        $('#divdinamico').load('../submenus/contenidosInbox2.php');
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

function cerrarArchivos() {
    $('#selectRubros').find('option').remove();
    document.getElementById("FormSubirArchivos").reset();
    $('#SubirArchivosInbox').modal('hide');
}

function SubirArchivos() {
    cargarRubros("selectRubros");
    $('#SubirArchivosInbox').modal('show')
}

function cargarRubros(nameSelec) {
    selectPer = document.getElementById(nameSelec);
    $.get(ws + "RubrosGen", function(data) {
        var rubros = JSON.parse(data).rubros;
        for (var x in rubros) {
            option = document.createElement("option");
            option.value = rubros[x].id;
            option.text = rubros[x].nombre;
            selectPer.appendChild(option);
        }
    });
}

function cargarArchivos() {
    var nomArchivos = [];
    var archivos = $('#archivos')[0].files;
    var rfc = $('#txtRFC').val();
    var archivosList = new FormData();
    var contador = archivos.length;
    var idUsuario = document.getElementById("idUsuarioArch").value;
    var observaciones = document.getElementById("comentarios").value;
    var e = document.getElementById("selectRubros");
    var idRubro = e.options[e.selectedIndex].value;
    archivosList.append('file-0', rfc + '/Entrada/AlmacenDigital/ExpedientesDigitales/');

    jQuery.each(jQuery('#archivos')[0].files, function(i, file) {
        i++;
        archivosList.append('file-' + i, file);
    });

    jQuery.ajax({
        url: '../submenus/cargarArchivos.php',
        data: archivosList,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            var len = response.length;
            if (response.length > 0) {
                for (var i = 0; i < len; i++) {
                    nomArchivos.push({ name: response[i].nombre });
                }
                $.post(ws + "CargaArchivos", { rfc: rfc, idUsuario: idUsuario, idRubro: idRubro, observaciones: observaciones, nomArchivos: nomArchivos }, function(response) {
                    //$.post(ws + "CargaArchivos",{ people:people}, function(response){  
                    alert(response);
                });
            }

        }
    });

}
//    return CorreosValidos;    
//}

// function AbrirPDF(RutaArchivo, Archivo){

//     //console.log(RutaArchivo);
//     //console.log(Archivo);
//     $.ajax({
//          url: '../../cargapdf.php',
//          type: 'POST',        
//          data: {ruta: RutaArchivo, ArchivoPDF: Archivo},
//          success:function(respuestaAjax){
//             console.log(respuestaAjax);
//             //document.getElementById("pdfvista").setAttribute("src", respuestaAjax);
//          }
//     });

// }