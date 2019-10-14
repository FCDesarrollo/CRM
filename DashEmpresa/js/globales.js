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

function loadDiv(lNameForm){    
    $('.br-mainpanel').load(lNameForm);

     if(lNameForm == "../submenus/recepcionlotes.php"){
        asyncCall(); //Espera 2 segundos para mandar llamar la funcion de CargarLotes
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



function CambiarEmpresa(){
	var idempresa = 0;
	
    $.ajax({                        
        data: { idempresa: idempresa },
        type: 'POST',
        url: '../../sessiones_usuario.php',            
        success:function(response){
    	   	window.location='../../usuario.php';
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

function AnteriorPag(){
    var element = document.getElementById("paginador"); 
    var posicion;
    for(var j = 1; j <= element.children.length; j++) {                             
        if ($("#btn_"+j).hasClass('current')){
            posicion = j - 1;
            break;        
        }   
    }       
    Paginador(posicion);
}

function SiguientePag(){
    var element = document.getElementById("paginador"); 
    var posicion;
    for(var j = 1; j <= element.children.length; j++) {                             
        if ($("#btn_"+j).hasClass('current')){
            posicion = j + 1;
            break;        
        }   
    }
    Paginador(posicion);

}

function Paginador(posicion){
    u_btn_sel = posicion; //asignamos valor a la variable global

    var lotes_x_pag = 5;
    
    var inicio = (posicion == 1 ? 0 : posicion - 1) * lotes_x_pag; 
    //var inicio = (posicion - 1) * lotes_x_pag; 
    $("#loading").removeClass("d-none");

    $.get(ws + "Paginador",{idempresa: idempresaglobal, iniciar: inicio, lotespag: lotes_x_pag}, function(Response){
        $("#t-Bitacora tbody").children().remove();
        var nLotes = Response;
        var tClass = "odd";
        var elemento;
        for (var j = 0; j < nLotes.length; j++) {

            document.getElementById("t-Bitacora").innerHTML +=
                "<tr id='rowb"+j+"' role='row' class='"+tClass+"' > \
                    <td class='sorting_2'> \
                        <span class='pd-l-5'>"+nLotes[j].fechadecarga+"</span> \
                    </td> \
                    <td class=''> \
                        <span class='pd-l-5'>"+nLotes[j].usuario+"</span> \
                    </td> \
                    <td class='sorting_2'> \
                        <span class='pd-l-5'>"+nLotes[j].tipodet+"</span> \
                    </td> \
                    <td class=''> \
                        <span class='pd-l-5'>"+nLotes[j].sucursal+"</span> \
                    </td> \
                    <td class='sorting_2'> \
                        <span class='pd-l-5'>Registros: "+nLotes[j].totalregistros+" Cargados: "+nLotes[j].totalcargados+" Error: "+nLotes[j].cError+"</span> \
                    </td> \
                    <td class=''> \
                        <span class='pd-l-5'>Procesados "+nLotes[j].procesados+" de "+nLotes[j].totalcargados+"</span> \
                    </td> \
                    <td class='dropdown text-center'> \
                      <a href='#' data-toggle='dropdown' class='btn pd-y-3 tx-gray-500 hover-info'><i class='icon ion-more'></i></a> \
                      <div class='dropdown-menu dropdown-menu-right pd-10'> \
                        <nav class='nav nav-style-1 flex-column'> \
                          <a href='#' onclick='MostrarDoctos("+nLotes[j].id+","+nLotes[j].tipo+")' class='nav-link'>Nivel de Documentos</a> \
                          <a href='#' onclick='MostrarMovtos("+nLotes[j].id+","+nLotes[j].tipo+")' class='nav-link'>Nivel de Movimientos</a> \
                          <a href='#' onclick='EliminaRegistro("+nLotes[j].id+")' class='nav-link'>Eliminar Lote</a> \
                        </nav> \
                      </div> \
                    </td> \
                 </tr>"; 
                 
                 if(tClass == "odd") { tClass = "even"; }else{ tClass = "odd"; }
                 
        }

        var element = document.getElementById("paginador");
        var hijos = $('#paginador').find('a');
        var flag = 0;
        hijos.removeClass('current');
        var child = element.children.length;
        for(var j = 0; j < element.children.length; j++) {                              
                
            if(j == (posicion-1)){                  
                $("#btn_"+posicion).addClass('current');
                flag = 1;
            }
            
            if(flag == 1){
                break;
            }

        }       


        if(posicion == 1){                                  
            $("#datatable1_previous").addClass('disabled');
            $("#datatable1_next").removeClass('disabled');
            document.getElementById('datatable1_previous').onclick = null;
            document.getElementById('datatable1_next').onclick = SiguientePag;
        }else if((j + 1) == child){
            $("#datatable1_previous").removeClass('disabled');
            $("#datatable1_next").addClass('disabled');
            document.getElementById('datatable1_next').onclick = null;
            document.getElementById('datatable1_previous').onclick = AnteriorPag;
        }else if((j + 1) < child && posicion > 1){
            $("#datatable1_previous").removeClass('disabled');
            $("#datatable1_next").removeClass('disabled');
            document.getElementById('datatable1_previous').onclick = AnteriorPag;
            document.getElementById('datatable1_next').onclick = SiguientePag;
        }       

        $("#loading").addClass("d-none");

    });
}
