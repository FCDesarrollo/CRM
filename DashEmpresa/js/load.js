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


function CargaContenido(idsubmenu, RFCEmpresa){

    $('#loading').removeClass('d-none');

    $('#divdinamico').load('../submenus/contenidos.php');
    
    
    var ruta = "";
    var submenu = "";
    switch(idsubmenu){
        case 1:
            submenu = "EEFF";
            break;
        case 2:
            //submenu = "ContElec";
            submenu = "Contabilidad";
            break;
        case 3:
            submenu = "ExpAdmin";
            break;
        case 4:
            submenu = "ExpCont";
            break;                                                    
    }


    ruta = "../../../nextclouddata/admindublock/files/PruebaSincro/"+RFCEmpresa+"/"+submenu+"/";
    //ruta = "../archivospdf/"+RFCEmpresa+"/"+submenu+"/";

    $.ajax({
        url: '../submenus/leer_carpeta.php',
        type: 'POST',        
        data: {submenu: submenu, RFCEmpresa: RFCEmpresa},
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
                          <a href='"+ruta+array2[x].nombre+"' target='_blank'><i class='fa fa-file-pdf-o tx-22 tx-danger lh-0 valign-middle'></i> \
                          <span class='pd-l-5'>"+array2[x].nombre+"</span></a> \
                        </td> \
                        <td class='hidden-xs-down'>"+array2[x].fecha+"</td> \
                        <td class='dropdown'> \
                          <a href='#' data-toggle='dropdown' class='btn pd-y-3 tx-gray-500 hover-info'><i class='icon ion-more'></i></a> \
                          <div class='dropdown-menu dropdown-menu-right pd-10'> \
                            <nav class='nav nav-style-1 flex-column'> \
                              <a href='"+ruta+array2[x].nombre+"' target='_blank' class='nav-link'>Abrir</a> \
                              <a href='"+ruta+array2[x].nombre+"' download='"+archivo+"' id='download_"+nombrearchivo+"' class='nav-link'>Descargar</a> \
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

function CompartirArchivos(){
    console.log("Compartir");
}

function DescargarArchivos(RFCEmpresa){
    var url = "../../../nextclouddata/admindublock/files/PruebaSincro/"+RFCEmpresa+"/";
    //var url = "../archivospdf/"+RFCEmpresa+"/";

    var checkbox = "";
    var celdas = "";
    var filas = $("#t-Archivos").find("tr");
    for(i=1; i<filas.length; i++){ //Recorre las filas 1 a 1]    
        celdas = $(filas[i]).find("input"); //devolverá las celdas de una fila
        var id = celdas[0].id;
        var name = celdas[0].name;
        url2 = url+name+"/"+id+".pdf";  
        
        if($('#'+id).prop('checked')){
            var doc = "download_"+id;
            document.getElementById(doc).click();
        }
    }
}