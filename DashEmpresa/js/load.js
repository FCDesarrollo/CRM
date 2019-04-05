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



function CargaDatosEmpresa(idusuario, idempresalog){   
        

    $.get(ws + "DatosUsuario/" + idusuario, function(data){
        var usuario = JSON.parse(data).usuario;
        if(usuario.length>0){            
            document.getElementById('nUsuario').innerHTML = usuario[0].nombre;
        }
    });  
    $.get(ws + "DatosEmpresaAD/" + idempresalog, function(data){
        var empresa = JSON.parse(data).empresa;
        if(empresa.length>0){            
            document.getElementById('nEmpresa').innerHTML = empresa[0].nombreempresa;
        }
    });  

}


function CargaContenido(idmodulo, idmenu, idsubmenu, RFCEmpresa){

    $('#loading').removeClass('d-none');


    $('#divdinamico').load('../submenus/contenidos.php');
    
    var ruta = "";
    var modulo = "";
    var menu = "";
    var submenu = "";

    switch(idmodulo){
        case ModContabilidad:
            modulo = "Contabilidad";
            switch(idmenu){
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
            modulo = "Bandeja";
            switch(idmenu){
                case MenuCompras:
                    menu = "Compras";
                break;
                case MenuProcesoFiscal:
                    menu = "AlmacenDigital";
                break;
                case MenuRecepcionLotes:
                    menu = "RecepcionporLotes";
                break;
            }    
            break;
    }


    switch(idsubmenu){
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
        case SubAsesorFlujoEfectivo :
            submenu = "AsesordeFlujosdeEfectivo";
            break;
        case SubAnalisisProyecto :
            submenu = "AnalisisdeProyectos";
            break;
        case SubRequerimientos :
            submenu = "Requerimientos";
            break;
        case SubAutorizaciones :
            submenu = "Autorizaciones";
            break;
        case SubRecepcionCompras :
            submenu = "Recepcióndecompras";
            break;
        case SubNotificacionesAutoridades :
            submenu = "NotificacionesdeAutoridades";
            break;
        case SubExpedientesDigitales :
            submenu = "ExpedientesDigitales";
            break;  
        case SubProcesoProduccion :
            submenu = "ProcesodeProducción";
            break;
        case SubProcesoCompras :
            submenu = "ProcesodeCompras";
            break;
        case SubProcesoVenta :
            submenu = "ProcesodeVentas";
            break;
    }


    ruta = "../../nextclouddata/admindublock/files/PruebaSincro/"+RFCEmpresa+"/"+modulo+"/"+menu+"/"+submenu+"/";
    //ruta = "../../../nextclouddata/admindublock/files/PruebaSincro/"+RFCEmpresa+"/"+modulo+"/"+menu+"/"+submenu+"/";
    //ruta = "../archivospdf/"+RFCEmpresa+"/"+submenu+"/";

    $.ajax({
        url: '../submenus/leer_carpeta.php',
        type: 'POST',        
        data: {modulo: modulo, menu: menu, submenu: submenu, RFCEmpresa: RFCEmpresa},
        success:function(data){
            var archivo = "";
            var nombrearchivo = "";
            var array2 = JSON.parse(data);           
            if(array2[0].nombre != "Vacio"){

                for (x in array2) {
                    archivo = array2[x].nombre;
                    nombrearchivo = archivo.replace(".pdf", "");
                    document.getElementById("t-Archivos").innerHTML +=
                      "<tr> \
                        <td class='valign-middle'> \
                          <label class='ckbox mg-b-0'> \
                            <input type='checkbox' name='"+submenu+"' id='"+nombrearchivo+"'><span></span> \
                          </label> \
                        </td> \
                        <td> \
                          <a href='#' onclick=AbrirPDF('"+ruta+"','"+array2[x].nombre+"')><i class='fa fa-file-pdf-o tx-22 tx-danger lh-0 valign-middle'></i> \
                          <span class='pd-l-5'>"+array2[x].nombre+"</span></a> \
                        </td> \
                        <td class='hidden-xs-down'>"+array2[x].fecha+"</td> \
                        <td class='dropdown'> \
                          <a href='#' data-toggle='dropdown' class='btn pd-y-3 tx-gray-500 hover-info'><i class='icon ion-more'></i></a> \
                          <div class='dropdown-menu dropdown-menu-right pd-10'> \
                            <nav class='nav nav-style-1 flex-column'> \
                              <a href='#' onclick='' class='nav-link'>Abrir</a> \
                              <a href='#' onclick='' class='nav-link'>Descargar</a> \
                            </nav> \
                          </div> \
                        </td> \
                      </tr>";             

                }

                $('#loading').addClass('d-none');
                    //document.getElementById("loading").style.display = "none";
                

            }else{

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

function AbrirPDF(RutaArchivo, Archivo){

    //console.log(RutaArchivo);
    //console.log(Archivo);
    $.ajax({
         url: 'http://crm.dublock.com/cargapdf.php',
         type: 'POST',        
         data: {ruta: RutaArchivo, ArchivoPDF: Archivo},
         success:function(data){
            console.log(data);
         }
    });
    
}

function CompartirArchivos(){
    console.log("Compartir");
}

function DescargarArchivos(RFCEmpresa){
    $('#ruta').removeClass('d-none');
    var url = "../../../nextclouddata/admindublock/files/PruebaSincro/"+RFCEmpresa+"/";
    //var url = "../archivospdf/"+RFCEmpresa+"/";

    var checkbox = "";
    var celdas = "";
    var filas = $("#t-Archivos").find("tr");
    for(i=1; i<filas.length; i++){ //Recorre las filas 1 a 1]    
        celdas = $(filas[i]).find("input"); //devolverá las celdas de una fila
        var id = celdas[0].id;
        var name = celdas[0].name;
        //url2 = url+name+"/"+id+".pdf";  
        
        if($('#'+id).prop('checked')){
            /*
            var doc = "download_"+id;
            document.getElementById(doc).click(); */


            var rutanueva = showModalDialog("folderDialog.html","","width:400px;height:400px;resizeable:yes;");

        }
    }
}