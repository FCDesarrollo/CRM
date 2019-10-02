function ExpDigitales(idmodulo, idmenu, idsubmenu, RFCEmpresa){
	$('#loading').removeClass('d-none');

	$('#divdinamico').load('../submenus/alm_expedientesdigitales.php');

    $("#t-ExpDigitales tbody").children().remove();    
    //$("#loading").removeClass("d-none");        

    $.get(ws + "DatosAlmacen", {rfcempresa: datosuser.rfcempresa}, function(data){
        var datos = JSON.parse(data);
        
        if(datos.length > 0){            
            for (var i = 0; i < (datos.length > 5 ? 5 : datos.length); i++) {
        
                document.getElementById("t-ExpDigitales").innerHTML +=
                "<tr> \
                    <td>"+datos[i].fechadecarga+"</td> \
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
            $('#loading').addClass('d-none');   
        }
        

    });	
}

function DocumentosALM($idalm){

    $("#t-ArchivosALM tbody").children().remove();    
    $("#loading").removeClass("d-none");    
    $("#expalm").addClass("d-none");    
    $("#ArchivosALM").removeClass("d-none");

    $.get(ws + "ArchivosAlmacen", {idempresa: idempresaglobal, idalmacen: $idalm}, function(data){
        var datos = JSON.parse(data);
        
        if(datos.length > 0){      

            $.ajax({
                async:false,
                url: '../submenus/leer_carpeta.php',
                type: 'POST',
                data: {RFCEmpresa: datosuser.rfcempresa, archivos: datos},
                success: function (responseAJAX) {

                }
            });


            for (var i = 0; i < (datos.length > 5 ? 5 : datos.length); i++) {
        
                document.getElementById("t-ArchivosALM").innerHTML +=
                "<tr> \
                    <td> \
                        <label class='ckbox mg-b-0'> \
                            <input type='checkbox' id='check_"+datos[i].id+"'><span></span> \
                        </label> \
                    </td> \
                    <td>"+datos[i].documento+"</td> \
                    <td>"+(datos[i].estatus == 1 ? "¡Procesado!" : "¡No Procesado!")+"</td> \
                    <td>"+(datos[i].fechaprocesado == null ? "YYYY-MM-DD" : datos[i].fechaprocesado)+"</td> \
                    <td> \
                      <a href='#' data-toggle='dropdown' class='btn pd-y-3 tx-gray-500 hover-info'><i class='icon ion-more'></i></a> \
                      <div class='dropdown-menu dropdown-menu-right pd-10'> \
                        <nav class='nav nav-style-1 flex-column'> \
                          <a href='#' onclick='DescargarArchivoALM("+datos[i].id+")' class='nav-link'>Descargar</a> \
                          <a href='#' onclick='CompartirArchivoALM("+datos[i].id+")' class='nav-link'>Compartir</a> \
                          <a href='#' onclick='EliminarArchivoALM("+datos[i].id+")' class='nav-link'>Eliminar</a> \
                        </nav> \
                      </div> \
                    </td> \
                </tr>";            

            }
            $('#loading').addClass('d-none'); 
            btnregresar = 2;
        }        

    });

          
    
}

function ShareFileAlm(){

}

function DownFileAlm(){

}

function cerrarArchivos(){   
    $('#selectRubros').find('option').remove();
    document.getElementById("FormSubirArchivos").reset();  
    $('#SubirArchivosInbox').modal('hide');
}
function SubirArchivos(){
    cargarRubros("selectRubros");
    cargarSucursales("selectSucursales");
    $('#SubirArchivosInbox').modal('show');
}

function cargarRubros(nameSelec){    
    selectPer = document.getElementById(nameSelec);
    $.get(ws + "RubrosGen", function(data){
        var rubros = JSON.parse(data).rubros;
        for(var x in rubros)
        {
            option = document.createElement("option");
            option.value = rubros[x].id;
            option.text = rubros[x].nombre;
            selectPer.appendChild(option);
        }            
    });
}

function cargarSucursales(nameSelec){    
    selectsuc = document.getElementById(nameSelec);
    $.get(ws + "CatSucursales", {rfcempresa: datosuser.rfcempresa},function(data){
        var sucursales = JSON.parse(data).sucursales;
        for(var x in sucursales){
            option = document.createElement("option");
            option.value = sucursales[x].idsucursal;
            option.text = sucursales[x].sucursal;
            selectsuc.appendChild(option);
        }            
    });
}

function cargarArchivos(){  
    var nomArchivos = [];
    var archivos = $('#archivos')[0].files;
    var rfc = $('#txtRFC').val();        
    var archivosList = new FormData();  
    var contador = archivos.length;       
    var idUsuario = document.getElementById("idUsuarioArch").value;
    var observaciones = document.getElementById("comentarios").value;
    
    var e = document.getElementById("selectRubros");
    var idRubro = e.options[e.selectedIndex].value;
    var s = document.getElementById("selectSucursales");
    var sucursal = s.options[s.selectedIndex].text;

    var datos = new Object();
    datos.rfcempresa = datosuser.rfcempresa;
    datos.usuario = datosuser.usuario;
    datos.pwd = datosuser.pwd;
    datos.idrubro = idRubro;
	datos.observaciones = observaciones;
	datos.sucursal = sucursal;
	datos.archivos = new Object();

    archivosList.append('file-0', rfc + '/Entrada/AlmacenDigital/ExpedientesDigitales/');   
    var j = 0;
    jQuery.each(jQuery('#archivos')[0].files, function(i, file) {  
        i++;      
        archivosList.append('file-'+i, file);
        datos.archivos[j] = file["name"];
        j=j+1;
        //console.log(file["name"]);
    });  
    
    console.log(datos);

    //Carga los registros
	$.post(ws + "AlmCargaArchivos", {datos}, function(response){  


	    /*jQuery.ajax({ //ajax para cargar archivos a la nube
	        url: '../submenus/cargarArchivos.php',
	        data: archivosList,
	        cache: false,
	        contentType: false,
	        processData: false,
	        type: 'POST',
	        dataType: 'json',
	        success: function(response){  
	            var len = response.length;  
	            if (response.length > 0) {
	                for(var i=0; i<len; i++){                    
	                    miObjeto.archivos[i] = response[i].nombre;                
	                }                  
	                


	            }

       			$('#SubirArchivosInbox').modal('hide');
       			swal("Carga Correcta","Archivos cargados correctamente","success");	            
	                     
	        }
	    });*/

	}); 

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