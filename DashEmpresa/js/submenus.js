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
}
