//Constantes para los modulos
const ModContabilidad = 1;
const ModBandejaEntrada = 2;
const ModCuenta = 3;
//Constantes para los menus
const MenuContabilidad = 1;
const MenuProcesoFiscal = 2;
const MenuFinanzas = 3;
const MenuCompras = 4;
const MenuAlmacenDigitalOpe = 5;
const MenuRecepcionLotes = 6;

const MenuEmpresa = 7;
const MenuUsuarios = 8;
const MenuPerfiles = 9;

const MenuAlmacenDigitalExp = 10;

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
const SubCompras = 15;
const SubVentas = 16;
const Sub_LotesCompras = 17;
const Sub_LotesVentas = 18;
const Sub_LotesPagos = 19;
const SubPagos = 23;
const SubCobros = 24;
const SubProduccion = 25;
const SubInventarios = 26;
//const SubGenerales = 27;
const Sub_LotesCobros = 28;
const Sub_LotesProduccion = 29;
const Sub_LotesInventarios = 30;
const SubGobierno = 31;
const SubBancos = 32;
const SubRecursosHumanos = 33;
const SubClientes = 34;
const SubProveedores = 35;
const SubConstitucion = 36;
const SubActivos = 37;
const SubPublicaciones = 38;


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
        case "1":
            CargaContenido(ModContabilidad, MenuContabilidad, SubEstadosFinancieros, datosuser.rfcempresa);
            break;      
        case "2":
            CargaContenido(ModContabilidad, MenuContabilidad, SubContabilidadElectronica, datosuser.rfcempresa);
            break;
        case "3":
            CargaContenido(ModContabilidad, MenuContabilidad, SubExpedientesAdmin, datosuser.rfcempresa);
            break;
        case "4":
            CargaContenido(ModContabilidad, MenuContabilidad, SubExpedientesContables, datosuser.rfcempresa);
            break;          
        case "15": 
        case "16":
        case "23":
        case "24":
        case "25":
        case "26":
        case "27":
            ExpDigitales(idmoduloglobal, idmenuglobal, idsubmenuglobal, datosuser.rfcempresa);
            break;   
        case "17":
        case "18":
        case "19":
        case "28":
        case "29":
        case "30":
            CargarLotes(idmoduloglobal, idmenuglobal, idsubmenuglobal);
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
        history.pushState(null, "", "index.php");
        //window.location.replace(dash);
    } 

    if(idsubmenuglobal != 0){
        asyncCargaSub(idsubmenuglobal);        
    }

    /*if(lNameForm == "../submenus/recepcionlotes.php"){
        asyncCall(); //Espera 2 segundos para mandar llamar la funcion de CargarLotes
    }else if(idsubmenuglobal != 0){
        asyncCargaSub(idsubmenuglobal);        
    }*/

}



function RefrescarPag(){
    if(idsubmenuglobal != 0){
        CargarSubMenu(idsubmenuglobal);
    /*}else if(idsubmenuglobal == 0 && idmenuglobal == 6){
        CargarSubMenu(17); //Recepcion Por Lotes */
    }else{
        location.reload(true);
    }
}

function resolveAfter2Seconds() {
  return new Promise(resolve => {
    setTimeout(() => {
      resolve('Cargado');
    }, 1500);
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
    $('#Modal_CambiarEmpresa').modal('hide');
    $('#loading').removeClass('d-none');
    $.get(ws + "ListaEmpresas", {idusuario: idusuarioglobal, tipo: tipousuarioglobal}, function(data){
        var listaEmp = JSON.parse(data).empresas;
        if(listaEmp.length > 0){
            for (var i = 0; i < listaEmp.length; i++) {
                var id = listaEmp[i].idempresa;
                if(idemp == id){
                    $.ajax({                        
                        data: { reload: true, idempresa: idemp, rfcempresa: listaEmp[i].RFC, idperfil: listaEmp[i].idperfil },
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
        }else if(u_btn_sel > 1){
            $("#expalm").removeClass("d-none");            
            $("#t-ExpDigitales").removeClass("d-none");
        }else{            
            ExpDigitales(modulo, menu, submenu, datosuser.rfcempresa);
        }        
    }
    //Los reseteamos
    btnregresar = 0; 
    btnfiltro = false;
}

function SubMenu_Tittle(){

  for (var i = 0; i < _NombresSubM.length; i++) {
    if(_NombresSubM[i].idsubmenu == idsubmenuglobal){
      document.getElementById("tittle-sub").innerText = _NombresSubM[i].nombre_submenu;    
      break;
    }
  }

}

function VerificaPermisoSubMenu(idempresa, idusuario, idsubmenu){
    $.get(ws + "SubMenuPermiso", {idempresa: idempresa, idusuario: idusuario}, function(data){
        var subper = data;
        
        for (var i = 0; i < subper.length; i++) {
            if(subper[i].idsubmenu == idsubmenu){
                var tipopermiso = subper[i].tipopermiso;
                break;
            }
        }

        return tipopermiso;
    });
}


