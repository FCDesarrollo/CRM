
// function AbreEmpresa(){
// 	var select = document.getElementById("sel2").value;
	
// 	if(select!=""){
// 		$("#idempresalog").val(select);
// 		//console.log(select);
// 		//console.log($("#idusuariolog").val());
// 		$("#FormListEmp").submit();
// 	}else{
// 		alert("Seleccione Empresa");
// 	}
	
// }

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
			apellidom = usuario[0].apellidom;
			document.getElementById('usuariolog').innerHTML = username + " " + apellidop + " " + apellidom;

			$('#listado-empresas').load('usuariolog/listaempresas.php');

			idusuario = usuario[0].idusuario;
			tipo = usuario[0].tipo;

			//var listEmp = document.getElementById("sel2");
			
			$.get(ws + "ListaEmpresas", { idusuario: idusuario, tipo: tipo }, function(data){
				var empresas = JSON.parse(data).empresas;
				for(var x in empresas)
				{				

					document.getElementById("lista-empresa").innerHTML += 
					"<tbody> \
						<tr> \
							<td style='display:none;'>"+empresas[x].idempresa+"</td> \
							<td> \
								<a href='#' id='btn-abr"+empresas[x].idempresa+"' onclick='AbreEmpresa()' value='"+empresas[x].idempresa+"'> \
									"+empresas[x].nombreempresa+" \
								</a> \
							</td> \
							<td>"+empresas[x].RFC+"</td> \
							<td>"+empresas[x].perfil+"</td> \
						</tr> \
					</tbody>";
					/*document.getElementById("lista-empresa").innerHTML += 
					"<tbody> \
						<tr> \
							<td style='display:none;'>"+empresas[x].idempresa+"</td> \
							<td>"+empresas[x].nombreempresa+"</td> \
							<td class='hidden-xs'>"+empresas[x].RFC+"</td> \
							<td align='center'> \
								<a id='btn-abr"+empresas[x].idempresa+"' onclick='AbreEmpresa()' value='"+empresas[x].idempresa+"' class='btn btn-primary'><em class='fa fa-play-circle'></em></a> \
								<a id='btn-mod"+empresas[x].idempresa+"' value='"+empresas[x].idempresa+"' class='btn btn-default'><em class='fa fa-pencil'></em></a> \
								<a id='btn-eli"+empresas[x].idempresa+"' onclick='Desvincula()' value='"+empresas[x].idempresa+"'class='btn btn-danger'><em class='fa fa-trash'></em></a> \
							</td> \
						</tr> \
					</tbody>";*/
					//document.getElementById("sel2").innerHTML += "<option value='"+empresas[x].idempresa+"'>"+empresas[x].nombreempresa+"</option>";
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


