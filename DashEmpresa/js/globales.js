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

var datosuser;

//variables globales
var btnregresar=0;
var btnfiltro = false;
var u_btn_sel=1;
var productos;
var clientesproveedores;
var conceptos;
var tipodocto;
var tipodoctodet;
var respuestacatalogos;
var url = ""; 

function CargarSubMenu(idsubmenu){

    switch (idsubmenu) {
        case 1:
            CargaContenido(ModContabilidad, MenuContabilidad, SubEstadosFinancieros, datosuser.rfcempresa);
            break;      
        case 2:
            CargaContenido(ModContabilidad, MenuContabilidad, SubContabilidadElectronica, datosuser.rfcempresa);
            break;
        case 3:
            CargaContenido(ModContabilidad, MenuContabilidad, SubExpedientesAdmin, datosuser.rfcempresa);
            break;
        case 4:
            CargaContenido(ModContabilidad, MenuContabilidad, SubExpedientesContables, datosuser.rfcempresa);
            break;          
        case 5:
            
            break;
        case 6:
            
            break;
        case 7:
            
            break;
        case 8:
            break;
        case 9:
            
            break;                                      
        case 10:
            
            break;
        case 11:
            
            break;            
        case 12:
            
            break;
        case 13:
            
            break;
        case 14:
            
            break;
        case 15:
            
            break;                                                
        case 16:
            ExpDigitales(idmoduloglobal, idmenuglobal, idsubmenuglobal, datosuser.rfcempresa);
            break;   
        case 17:
            CargarLotes();
            break;                                                                     
        default:
            
            break;
    }    
}

function URL_Asigna_SubM(idsubmenu){

    idsubmenuglobal = idsubmenu;    
    if(idsubmenuglobal != 0){        
        
        if(url.indexOf("sub") == -1){            
            url = url + "&sub=" + idsubmenuglobal;                
            history.pushState(dash, "", url);
        }else{
            var currURL = window.location.href;        
            var lista = currURL.split("&");
            url = lista[0]+"&"+lista[1];
            url = url + "&sub=" + idsubmenuglobal;
            history.pushState(dash, "", url);
        }
    }

}

function loadDiv(lNameForm, IDMod, IDMenu, IDSubM){
//function loadDiv(lNameForm){    
    //swal(lNameForm);
    $('.br-mainpanel').load(lNameForm);    
    
    idmoduloglobal = IDMod;
    idmenuglobal = IDMenu;
    idsubmenuglobal = IDSubM;

    if(idmoduloglobal != 0){
        url = "./?mod=" + idmoduloglobal;        
        if(idmenuglobal != 0){
            url = url + "&men=" + idmenuglobal;            
            if(idsubmenuglobal != 0){
                url = url + "&sub=" + idsubmenuglobal;                                
            }
            history.pushState(dash, "", url);
        }        
    }else{
        window.location.replace(dash);
    } 

    if(lNameForm == "../submenus/recepcionlotes.php"){
        asyncCall(); //Espera 2 segundos para mandar llamar la funcion de CargarLotes
    }else if(idsubmenuglobal != 0){
        asyncCargaSub(idsubmenuglobal);        
    }

}



function RefrescarPag(){
    if(idsubmenuglobal != 0){
        CargarSubMenu(idsubmenuglobal);
    }else if(idsubmenuglobal == 0 && idmenuglobal == 6){
        CargarSubMenu(17); //Recepcion Por Lotes
    }else{
        location.reload(true);
    }
}

function resolveAfter2Seconds() {
  return new Promise(resolve => {
    setTimeout(() => {
      resolve('Cargado');
    }, 2000);
  });
}

async function asyncCall() {  
    var result = await resolveAfter2Seconds();  
    CargarLotes();
} 
async function asyncCargaSub(idsubmenu) {  
    var result = await resolveAfter2Seconds();  
    CargarSubMenu(idsubmenu);
}       

function AsignaIDMod(IDMod){
    idmoduloglobal = IDMod;
}

function AsignaIDMenu(IDMenu){
    idmenuglobal = IDMenu;
}

function AsignaIDSubM(IDSubM){
    idsubmenuglobal = IDSubM;
}

function Reload(){
    if(idmoduloglobal != 0){
        history.pushState(dash, "", "./?mod="+ idmoduloglobal +"&men="+ idmenuglobal +"&sub="+ idsubmenuglobal +"");
    }
    
}

function CargarEmpresa(idemp){
    
    $.get(ws + "ListaEmpresas", {idusuario: idusuarioglobal, tipo: tipousuarioglobal}, function(data){
        var listaEmp = JSON.parse(data).empresas;
        if(listaEmp.length > 0){
            for (var i = 0; i < listaEmp.length; i++) {
                var id = listaEmp[i].idempresa;
                if(idemp == id){
                    $.ajax({                        
                        data: { reload: true, idempresa: idemp, rfcempresa: listaEmp[i].RFC },
                        type: 'POST',
                        url: '../../session.php',            
                    })
                    .done(function() {        
                        Reload();
                        location.reload(true);
                    });
                }    
            }
            
        }
    });

    

}

function EnlistarEmpresas(){

    $('#ListaEmpresas').empty();

    $.get(ws + "ListaEmpresas", { idusuario: idusuarioglobal, tipo: tipousuarioglobal }, function(data){
        var empresas = JSON.parse(data).empresas;
        if(empresas.length > 1){
            for (var j = 0; j < empresas.length; j++) {
                var RFC = empresas[j].RFC;
                if(empresas[j].idempresa != idempresaglobal){

                    $("#ListaEmpresas").append("<a href='#'><li class='list-group-item d-flex justify-content-between align-items-center' onclick='CargarEmpresa(" + empresas[j].idempresa + ")'>" + empresas[j].nombreempresa + "<span class='badge badge-primary badge-pill'>0</span></li></a>");
                
                }
            
            }
            $('#Modal_CambiarEmpresa').modal('show');
        }else{
            swal("¡Accion Denegada!","Actualmente no cuenta con mas empresas vinculadas.","info");
        }

    });
}

function CerrarSession(){
	var idempresa = 0;
	var usuario21 = "";
    $.ajax({                        
        data: { idempresa: idempresa, usuario21: usuario21 },
        type: 'POST',
        url: '../../sessiones_usuario.php',            
        success:function(response){
    	   	window.location='../../login/index.php';
        }
    });
}

function RegresarPagina(){
    if(btnregresar == 0){
        CancelaCarga();
    }else if(btnregresar == 1){
        $("#carga-movtos").removeClass("d-none");           
        $("#nivelmovtos").addClass("d-none");
    }else if(btnregresar == 2){
        $("#ArchivosALM").addClass("d-none");
        $("#DivArchivoDetalle").addClass("d-none");     
        if(btnfiltro == true){
            $("#expalm").removeClass("d-none");    
        }else{
            ExpDigitales(modulo, menu, submenu, datosuser.rfcempresa);
        }
        
    }
    //Los reseteamos
    btnregresar = 0; 
    btnfiltro = false;
}

