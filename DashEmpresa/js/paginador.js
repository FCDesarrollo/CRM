var btn_visibles = 3;
var lotes_x_pag = 10;
var registros_tabla = new Object();
var paginas;
var active;

//Lista de Tablas donde se usa el paginador
var TablaExpDigitales = "t-ExpDigitales";
var TablaRecepcionLotes = "t-Bitacora";

function LlenaPaginador(num_registros, datos, tabla){
    
    $('#datatable1_paginate').removeClass('d-none');

    registros_tabla["tabla"] = tabla;
    registros_tabla["datos"] = datos;

    var total_lotes = num_registros; //(num_registros > 20 ? 20 : num_registros);        
    paginas = Math.ceil(total_lotes / lotes_x_pag);
    active = "current";

    if(paginas == 1){
        $("#datatable1_next").addClass('disabled');
        $("#datatable1_previous").addClass('disabled');
        document.getElementById('datatable1_next').onclick = null;
        document.getElementById('datatable1_previous').onclick = null;
    }
    
    //Elimina paginador
    var element = document.getElementById("paginador");
    while (element.firstChild) {
      element.removeChild(element.firstChild);
    }

    $("#datatable1_paginate").removeClass("d-none");
    
    //Agrega paginador
    for (var x = 1; x <= paginas; x++) {
        var a = document.createElement('a');                
        a.setAttribute("class", "paginate_button "+(x == 1 ? active : "")+"");
        a.setAttribute("onclick", "Paginador("+x+")");
        a.setAttribute("href", "#");
        a.setAttribute("id", "btn_"+x);
        a.setAttribute("value", x);                          
        document.getElementById("paginador").appendChild(a);                
        a.innerHTML = x;

        // if(x >= btn_visibles){
        //     x = x + 1;
        //     var b = document.createElement('a');                
        //     b.setAttribute("class", "paginate_button "+(x == 1 ? active : "")+"");
        //     b.setAttribute("onclick", "Paginador("+x+")");
        //     b.setAttribute("href", "#");
        //     b.setAttribute("id", "btn_"+x);
        //     b.setAttribute("value", x);                          
        //     document.getElementById("paginador").appendChild(b);
        //     b.innerHTML = "...";   
        //     break;         
        // }
    }    
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
    var elemento;
    var inicio = (posicion == 1 ? 0 : posicion - 1) * lotes_x_pag; 
    
    $("#loading").removeClass("d-none");


    LlenarTabla(inicio, lotes_x_pag);

    // if(posicion >= btn_visibles){

    //     //Elimina paginador
    //     var element = document.getElementById("paginador");
    //     while (element.firstChild) {
    //       element.removeChild(element.firstChild);
    //     }            

    //     var btn = posicion;
    //     var btns = btn + btn_visibles;
    
    //     var n = 0;
    //     for (var x = btn; x < btns; x++) {
    //         var a = document.createElement('a');                
    //         a.setAttribute("class", "paginate_button "+(x == btn ? active : "")+"");
    //         a.setAttribute("onclick", "Paginador("+x+")");
    //         a.setAttribute("href", "#");
    //         a.setAttribute("id", "btn_"+x);
    //         a.setAttribute("value", x);                          
    //         document.getElementById("paginador").appendChild(a);                
    //         a.innerHTML = x;
    //     }    

    // }

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
        document.getElementById('datatable1_next').onclick = SiguientePag;
        document.getElementById('datatable1_previous').onclick = null;
    }else if((j + 1) == child){
        $("#datatable1_previous").removeClass('disabled');
        $("#datatable1_next").addClass('disabled');
        document.getElementById('datatable1_next').onclick = null;
        document.getElementById('datatable1_previous').onclick = AnteriorPag;
    }else if((j + 1) < child && posicion > 1){
        $("#datatable1_previous").removeClass('disabled');
        $("#datatable1_next").removeClass('disabled');
        document.getElementById('datatable1_next').onclick = SiguientePag;
        document.getElementById('datatable1_previous').onclick = AnteriorPag;
    }       

    
    // if(posicion >= btn_visibles){

    //     var reg = registros_tabla["datos"].length;
    //     //Elimina paginador
    //     var element = document.getElementById("paginador");
    //     while (element.firstChild) {
    //       element.removeChild(element.firstChild);
    //     }            

    //     var btn = posicion;
    //     var btns = btn + btn_visibles;

    //     console.log("Posicion: "+btn);
    //     console.log("Total Reg: "+reg);
    //     console.log("Numero Pag: "+paginas)
    
    //     var n = 0;
    //     for (var x = btn; x < paginas; x++) {
    //         var a = document.createElement('a');                
    //         a.setAttribute("class", "paginate_button "+(x == btn ? active : "")+"");
    //         a.setAttribute("onclick", "Paginador("+x+")");
    //         a.setAttribute("href", "#");
    //         a.setAttribute("id", "btn_"+x);
    //         a.setAttribute("value", x);                          
    //         document.getElementById("paginador").appendChild(a);                
    //         a.innerHTML = x;

    //         if(n == btn_visibles){
    //             x = x + 1;
    //             var b = document.createElement('a');                
    //             b.setAttribute("class", "paginate_button "+(x == 1 ? active : "")+"");
    //             b.setAttribute("onclick", "Paginador("+x+")");
    //             b.setAttribute("href", "#");
    //             b.setAttribute("id", "btn_"+x);
    //             b.setAttribute("value", x);                          
    //             document.getElementById("paginador").appendChild(b);
    //             b.innerHTML = "...";   
    //             console.log("sale");
    //             break;  

    //         }
    //         console.log("Contador: "+ n);
    //         n = n + 1;
    //     }

    //     if(posicion == paginas){
    //         var a = document.createElement('a');                
    //         a.setAttribute("class", "paginate_button "+ active);
    //         a.setAttribute("onclick", "Paginador("+posicion+")");
    //         a.setAttribute("href", "#");
    //         a.setAttribute("id", "btn_"+posicion);
    //         a.setAttribute("value", posicion);                          
    //         document.getElementById("paginador").appendChild(a);                
    //         a.innerHTML = posicion;            
    //     }

    // }

    $("#loading").addClass("d-none");

}

function LlenarTabla(inicio, fin){
    num_registros = registros_tabla["datos"].length;
    var datos = registros_tabla["datos"];

    num_registros = ((num_registros - inicio) < 10 ? num_registros : (inicio + lotes_x_pag));

    switch (registros_tabla["tabla"]) {
      case TablaExpDigitales:
            $("#t-ExpDigitales tbody").children().remove();
            for (var i = inicio; i < num_registros; i++) {
        
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

            }
            $('#loading').addClass('d-none'); 
        break;
      case TablaRecepcionLotes:
            $("#t-Bitacora tbody").children().remove();
            var tClass = "odd";
            for (var j = inicio; j < num_registros; j++) {

                document.getElementById("t-Bitacora").innerHTML +=
                    "<tr id='rowb"+j+"' role='row' class='"+tClass+"' > \
                        <td class='sorting_2'> \
                            <span class='pd-l-5'>"+datos[j].fechadecarga+"</span> \
                        </td> \
                        <td class=''> \
                            <span class='pd-l-5'>"+datos[j].usuario+"</span> \
                        </td> \
                        <td class='sorting_2'> \
                            <span class='pd-l-5'>"+datos[j].tipodet+"</span> \
                        </td> \
                        <td class=''> \
                            <span class='pd-l-5'>"+datos[j].sucursal+"</span> \
                        </td> \
                        <td class='sorting_2'> \
                            <span class='pd-l-5'>Registros: "+datos[j].totalregistros+" Cargados: "+datos[j].totalcargados+" Error: "+datos[j].cError+"</span> \
                        </td> \
                        <td class=''> \
                            <span class='pd-l-5'>Procesados "+datos[j].procesados+" de "+datos[j].totalcargados+"</span> \
                        </td> \
                        <td class='dropdown text-center'> \
                          <a href='#' data-toggle='dropdown' class='btn pd-y-3 tx-gray-500 hover-info'><i class='icon ion-more'></i></a> \
                          <div class='dropdown-menu dropdown-menu-right pd-10'> \
                            <nav class='nav nav-style-1 flex-column'> \
                              <a href='#' onclick='MostrarDoctos("+datos[j].id+","+datos[j].tipo+")' class='nav-link'>Nivel de Documentos</a> \
                              <a href='#' onclick='MostrarMovtos("+datos[j].id+","+datos[j].tipo+")' class='nav-link'>Nivel de Movimientos</a> \
                              <a href='#' onclick='EliminaRegistro("+datos[j].id+")' class='nav-link'>Eliminar Lote</a> \
                            </nav> \
                          </div> \
                        </td> \
                     </tr>"; 
                     
                     if(tClass == "odd") { tClass = "even"; }else{ tClass = "odd"; }
                     
            }        
        break;
    }
    
    
}