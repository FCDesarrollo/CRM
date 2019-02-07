
function AbreEmpresa(){
	var select = document.getElementById("sel2").value;
	
	if(select!=""){
		$("#idempresalog").val(select);
		//console.log(select);
		//console.log($("#idusuariolog").val());
		$("#FormListEmp").submit();
	}else{
		alert("Seleccione Empresa");
	}
	
}

function DesvinculaEmpresa(){
	var select = document.getElementById("sel2");
	var idempresa = select.options[select.selectedIndex].value;
	var idusuario = document.getElementById("idusuario").value;
	
	if(idempresa!=0){
		$.post(ws + "Desvincular", { idusuario: idusuario, idemp: idempresa }, function(data){
			if(data>0){	
				$('#DesvinculaModal').modal('hide');
				CargaListaEmpresas(idusuario);
			}else{
				alert("No se pudo desvincular.");
			}
		});	
	}else{
		alert("¡ERROR!");
	}
}

function CargaListaEmpresas(idusuario){
	
	$.get(ws + "DatosUsuario/" + idusuario, function(data){
		var usuario = JSON.parse(data).usuario;
		if(usuario.length>0)
		{			
			username = usuario[0].nombre.split(" ", 1);
			apellidop = usuario[0].apellidop;
			document.getElementById('usuariolog').innerHTML = username + " " + apellidop;

			$('#listado-empresas').load('usuariolog/listaempresas.php');

			idusuario = usuario[0].idusuario;
			tipo = usuario[0].tipo;

			var listEmp = document.getElementById("sel2");
			
			$.get(ws + "ListaEmpresas", { idusuario: idusuario, tipo: tipo }, function(data){
				var empresas = JSON.parse(data).empresas;
				for(var x in empresas)
				{					
					document.getElementById("sel2").innerHTML += "<option value='"+empresas[x].idempresa+"'>"+empresas[x].nombreempresa+"</option>";
				}
			});		

		}
	});
}
function Activacion($idusuario, $identificador){
	$.post(ws + "VerificaUsuario",  { idusuario: $idusuario, identificador: $identificador }, function(data){    
		if(data>0){  
			alert("Verificacion Correcta.");
		}else{
			alert("Cuenta no Verificada Correctamente");
		}
	}).done(function(){
	
	});  		
}

function RestablecerPWD(correo, tipo){
	//location.href ="http://localhost/webconsultormx/restablecerpwd/recuperarpwd.php";
	location.href ="http://dublock.com/webconsultormx/restablecerpwd/recuperarpwd.php";
}

function ObtenerUsuario($identificador){	
	var id;
	$.post(ws + "ObtenerUsuarioNuevo", { identificador: $identificador }, function(data){
		var usuario = JSON.parse(data).usuario;
		if(usuario.length>0){  			
			id = usuario[0].idusuario;			
		}
	});	
	return id;	
}

function FormValidacion(){
	var correo = $('#txtUsuario').val();
	$('#myModal').modal('hide');
	$('#ModalValidacion').modal('show');
	$("#correo").val(correo);
}

