var modulo;
var menu;
var submenu;
function ExpDigitales(idmodulo, idmenu, idsubmenu, RFCEmpresa){
    modulo = idmodulo;
    menu = idmenu;
    submenu = idsubmenu;
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

    var storage = new Object();
    storage.server = datosuser.server;
    storage.user_storage = datosuser.user_storage;
    storage.pwd_storage = datosuser.pwd_storage;
    //console.log(storage);


    $.get(ws + "ArchivosAlmacen", {idempresa: idempresaglobal, idalmacen: $idalm}, function(data){
        var datos = JSON.parse(data);
        
        if(datos.length > 0){      

            $.ajax({
                async:true,
                url: '../submenus/leer_carpeta.php',
                type: 'POST',
                data: {RFCEmpresa: datosuser.rfcempresa, datosserver: storage, archivos: datos},
                success: function (responseAJAX) {
                    var respuesta = JSON.parse(responseAJAX);
                    //console.log(respuesta[0].link);

                    for (var i = 0; i < (respuesta.length > 5 ? 5 : respuesta.length); i++) {
                    
                        document.getElementById("t-ArchivosALM").innerHTML +=
                        "<tr> \
                            <td> \
                                <label class='ckbox mg-b-0'> \
                                    <input type='checkbox' id='check_"+respuesta[i].id+"'><span></span> \
                                </label> \
                            </td> \
                            <td>"+respuesta[i].documento+"</td> \
                            <td>"+(respuesta[i].estatus == 1 ? "¡Procesado!" : "¡No Procesado!")+"</td> \
                            <td>"+(respuesta[i].fechaprocesado == null ? "YYYY-MM-DD" : respuesta[i].fechaprocesado)+"</td> \
                            <td> \
                              <a href='#' data-toggle='dropdown' class='btn pd-y-3 tx-gray-500 hover-info'><i class='icon ion-more'></i></a> \
                              <div class='dropdown-menu dropdown-menu-right pd-10'> \
                                <nav class='nav nav-style-1 flex-column'> \
                                  <a href='"+respuesta[i].link+"' target='_blank' class='nav-link'>Ver</a> \
                                  <a href='"+respuesta[i].link+"/download' target='_blank' class='nav-link'>Descargar</a> \
                                  <a href='#' onclick='CompartirArchivoALM("+respuesta[i].id+")' class='nav-link'>Compartir</a> \
                                  <a href='#' onclick='EliminarArchivoALM("+respuesta[i].id+")' class='nav-link'>Eliminar</a> \
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
    $('#selectRubros option').remove();
    $('#selectSucursales option').remove();
    document.getElementById("comentarios").value = "";
    document.getElementById("datepicker").value = "";    
    cargarRubros("selectRubros");
    cargarSucursales("selectSucursales");
    $('#SubirArchivosInbox').modal('show');
}

function cargarRubros(nameSelec){    
    selectPer = document.getElementById(nameSelec);
    $.get(ws + "RubrosGen", {rfcempresa: datosuser.rfcempresa}, function(data){
        var rubros = JSON.parse(data).rubros;
        for(var x in rubros)
        {
            option = document.createElement("option");
            option.value = rubros[x].clave;
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

function Calendario()
{
    $('#datepicker').datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      numberOfMonths: 1,
      dateFormat: 'dd/mm/yy',
      dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
    });

    document.getElementById('ui-datepicker-div').style.setProperty('z-index', '9999', 'important');

}

$("#datepicker").mouseenter(function(evento){

    Calendario();
    /*document.getElementById('ui-datepicker-div').style.setProperty('position', 'fixed');
    document.getElementById('ui-datepicker-div').style.setProperty('display', 'flex');
    document.getElementById('ui-datepicker-div').style.setProperty('top', '244.4px');
    document.getElementById('ui-datepicker-div').style.setProperty('left', '537.733px');*/
    //document.getElementById('ui-datepicker-div').style.setProperty('z-index', '9999', 'important');
    //Calendario();
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
        if(ValidaFecha(fechadocto) == true){
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

                    archivosList.append('file-0', rfc + '/Entrada/AlmacenDigital/ExpedientesDigitales/');   
                    var j = 0;
                    jQuery.each(jQuery('#archivos')[0].files, function(i, file) {  
                        i++;      
                        archivosList.append('file-'+i, file);
                        datos.archivos[j] = file["name"];
                        j=j+1;
                        //console.log(file["name"]);
                    });      

                    $('#SubirArchivosInbox').modal('hide');
                    $("#loading").removeClass('d-none');
                    //console.log(datos);

                    //Carga los registros
                    $.post(ws + "AlmCargaArchivos", {datos}, function(response){  
                        var respuesta = JSON.parse(response);
                        
                        if(respuesta.error == 0){

                            jQuery.ajax({ //ajax para cargar archivos a la nube
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
                                        $("#loading").addClass('d-none');

                                        swal("Carga Correcta","Archivos cargados correctamente","success");

                                        ExpDigitales(modulo, menu, submenu, rfc);
                                    }else{
                                        $('#SubirArchivosInbox').modal('show');
                                    }
                                             
                                }
                            }); 
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
        }else{
            swal("¡Fecha del Documento!", "La fecha es incorrecta.","info");
        }
    }else{
        swal("¡Archivo!", "Seleccione un archivo.","info");
    }



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
      var fechaf = fecha.split("/");
      var day = fechaf[0];
      var month = fechaf[1];
      var year = fechaf[2];
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