//FUNCIONES PARA LA VENTANA DE FILTRO AVANZADO.
var pestaña = "";

function FiltroAvanzado(Ventana) {
    pestaña = Ventana;
    if (Ventana == 'ExpedientesDigitales') {
        LlenarFormFiltro();
        $('#Modal_FiltroA').modal('show');
    }
    if (Ventana == 'ExpedientesContables') {
        Carga_Meses();
        Carga_ejercicios();
        Carga_serviciosbit();
        Carga_Agentesbit();
        $('#Modal_FiltroB').modal('show');
    }
}

function DataPickerView(iddatepicker){
	
    $('#'+iddatepicker).datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      numberOfMonths: 1,
      dateFormat: 'yy-mm-dd',
      dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
    });

    document.getElementById('ui-datepicker-div').style.setProperty('z-index', '9999', 'important');

}

function LlenarFormFiltro() {
    var datos = new Object();
    datos.rfcempresa = datosuser.rfcempresa;
    datos.usuario = datosuser.usuario;
    datos.pwd = datosuser.pwd;

    $('#FiltroUsuario option').remove();
    $('#FiltroRubro option').remove();
    $('#FiltroSucursal option').remove();
    document.getElementById("datepicker_ini").value = "";
    document.getElementById("datepicker_fin").value = "";

    $.get(ws + "DatosFiltroAvanzado", { datos }, function(response) {
        var respuesta = JSON.parse(response);

        selectUse = document.getElementById("FiltroUsuario");
        selectRub = document.getElementById("FiltroRubro");
        selectSuc = document.getElementById("FiltroSucursal");

        option = document.createElement("option");
        option.value = 0;
        option.text = "Todos";
        selectUse.appendChild(option);

        option2 = document.createElement("option");
        option2.value = 0;
        option2.text = "Todos";
        selectRub.appendChild(option2);

        option3 = document.createElement("option");
        option3.value = 0;
        option3.text = "Todos";
        selectSuc.appendChild(option3);

        for (u in respuesta["usuarios"]) {
            option = document.createElement("option");
            option.value = respuesta["usuarios"][u].idusuario;
            option.text = respuesta["usuarios"][u].nombre;
            selectUse.appendChild(option);
        }

        for (r in respuesta["rubros"]) {
            option = document.createElement("option");
            option.value = respuesta["rubros"][r].clave;
            option.text = respuesta["rubros"][r].nombre;
            selectRub.appendChild(option);
        }

        for (s in respuesta["sucursales"]) {
            option = document.createElement("option");
            option.value = respuesta["sucursales"][s].idsucursal;
            option.text = respuesta["sucursales"][s].sucursal;
            selectSuc.appendChild(option);
        }

    });
}

function Filtrar() {
    $('#Modal_FiltroA').modal('hide');
    $('#loading').removeClass('d-none');

    selectUse = document.getElementById("FiltroUsuario").value;
    selectRub = document.getElementById("FiltroRubro").value;
    selectSuc = document.getElementById("FiltroSucursal").value;
    selectOrd = document.getElementById("FiltroOrden").value;

    var fechaini = document.getElementById("datepicker_ini").value;
    var fechafin = document.getElementById("datepicker_fin").value;

    //var det_fechai = fechaini.split('-');
    //var det_fechaf = fechafin.split('-');

    //fechaini = det_fechai[2] + '-' + det_fechai[1] + '-' + det_fechai[0];
    //fechafin = det_fechaf[2] + '-' + det_fechaf[1] + '-' + det_fechaf[0];
  	

	var datos = new Object();
	datos.rfcempresa = datosuser.rfcempresa;
	datos.usuario = datosuser.usuario;
	datos.pwd = datosuser.pwd;
	datos.fechaini = fechaini;
	datos.fechafin = fechafin;
	datos.idusuario = selectUse;
	datos.claverubro = selectRub;
	datos.idsucursal = selectSuc;
	datos.orden = selectOrd;

	if(fechaini != "" && fechafin != ""){
		$("#t-ExpDigitales tbody").children().remove();
		btnfiltro = true;
	    $.get(ws + "FiltrarDatos", {datos}, function(response){  
	        var respuesta = JSON.parse(response);
	        if(respuesta["error"] == 0){
		        if(respuesta["datos"][0] != null){
		        	            
		            for (var i = 0; i < respuesta["datos"].length; i++) {
		        
		                document.getElementById("t-ExpDigitales").innerHTML +=
		                "<tr> \
		                    <td>"+respuesta["datos"][i].fechadocto+"</td> \
		                    <td>"+respuesta["datos"][i].usuario+"</td> \
		                    <td>"+respuesta["datos"][i].rubro+"</td> \
		                    <td>"+respuesta["datos"][i].sucursal+"</td> \
		                    <td>Registros: "+respuesta["datos"][i].totalregistros+" Cargados: "+respuesta["datos"][i].totalcargados+" Procesados: "+respuesta["datos"][i].procesados+"</td> \
		                    <td> \
		                      <a href='#' data-toggle='dropdown' class='btn pd-y-3 tx-gray-500 hover-info'><i class='icon ion-more'></i></a> \
		                      <div class='dropdown-menu dropdown-menu-right pd-10'> \
		                        <nav class='nav nav-style-1 flex-column'> \
		                          <a href='#' onclick='DocumentosALM(" + respuesta["datos"][i].id + ")' class='nav-link'>Ver Documentos</a> \
		                        </nav> \
		                      </div> \
		                    </td> \
		                </tr>";

                    }
                    $('#loading').addClass('d-none');
                } else {
                    document.getElementById("t-ExpDigitales").innerHTML +=
                        "<tr> \
		                    <td> \
		                      <i class='fa fa-exclamation tx-22 tx-danger lh-0 valign-middle'></i> \
		                      <span class='pd-l-5'>No hay datos disponibles</span> \
		                    </td> \
		                </tr>";
                    $('#loading').addClass('d-none');
                }
            } else {
                $('#loading').addClass('d-none');
                swal("Error de Validacion", "El Rfc de la empresa, usuario o contraseña no son correctos.", "error");
            }
        });

    } else {
        $('#loading').addClass('d-none');
        $('#Modal_FiltroA').modal('show');
        swal("Rango de Fecha", "Debe seleccionar el rango de fechas a consultar.", "info");
    }


}



function Carga_Meses() {
    var array = ["Enero", "Febrero", "Marzo", "Abril",
        "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];
    var select = document.getElementById("FilPeriodo");
    option = document.createElement("option");
    option.value = 0;
    option.text = "Todos";
    select.appendChild(option);
    r = 1
    for (value in array) {
        var option = document.createElement('option');
        option.value = r;
        option.text = array[value];
        select.appendChild(option);
        r++;
    }
}

function Carga_ejercicios() {
    user = datosuser.usuario;
    pass = datosuser.pwd;
    var select = document.getElementById("FilEjercicio");
    $.post(ws + "listaejercicios", { idempresa: idempresaglobal, correo: user, contra: pass }, function(response) {
        if (response != "") {
            for (u in response["ejercicios"]) {
                option = document.createElement("option");
                option.text = response["ejercicios"][u].ejercicio;
                select.appendChild(option);
            }
        }
    });
}

function Carga_serviciosbit() {
    user = datosuser.usuario;
    pass = datosuser.pwd;
    var select = document.getElementById("FilServicio");
    $.post(ws + "listaserviciosbit", { idempresa: idempresaglobal, correo: user, contra: pass }, function(response) {
        if (response != "") {
            for (u in response) {
                option = document.createElement("option");
                option.value = response[u].codigoservicio;
                option.text = response[u].nombreservicio;
                select.appendChild(option);
            }
        }
    });
}

function Carga_Agentesbit() {
    user = datosuser.usuario;
    pass = datosuser.pwd;
    var select = document.getElementById("FilAgente");
    $.post(ws + "listaagentesbit", { idempresa: idempresaglobal, correo: user, contra: pass }, function(response) {
        if (response != "") {
            for (u in response) {
                option = document.createElement("option");
                option.value = response[u].idusuario;
                option.text = response[u].nombre + " " + response[u].apellidop + " " + response[u].apellidom;
                select.appendChild(option);
            }
        }
    });
}