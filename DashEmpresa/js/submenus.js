function CargaListaPerfiles(){
	$('#loading').removeClass('d-none');
	$('#divdinamico2').load('../divsadministrar/divadmperfiles.php');
	
}

function NuevoPerfil(){
	$('#loading').removeClass('d-none');
	$('#divdinamico2').load('../divsadministrar/newperfil.php');
	$('#loading').addClass('d-none');
}

function CargaListaUsuarios(){
	$('#loading').removeClass('d-none');
	$('#divdinamico').load('../divsadministrar/divadmusuarios.php');
}

function NuevoUsuario(){
	$('#divdinamico').load('../divsadministrar/divregistrousuarionuevo.php');
	CargarPerfiles();
}

function VincularUsuario(){
	$('#divdinamico').load('../divsadministrar/vinculausuario.php');	
	CargarPerfiles();
}

function CargarPerfiles(){
    $('#loading').removeClass('d-none');
    $('#_Perfil').find('option').remove();
    $.get(ws + "PerfileEmpresa/" + idempresaglobal, function(data){
        var perfiles = JSON.parse(data).perfiles;
        selectPer = document.getElementById("_Perfil");
        for(var x in perfiles){
            option = document.createElement("option");
            option.value = perfiles[x].idperfil;
            option.text = perfiles[x].nombre;
            selectPer.appendChild(option);                    
        }
        selectPer.selectedIndex = x;    
        $('#loading').addClass('d-none');         
    }); 	
}
