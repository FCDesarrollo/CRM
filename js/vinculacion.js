function Vincularlog(){
    //$("#titleuser").text(sNaUse);
    loadlistPErfilGen(1, "seleperfil"); 
    $('#vincularempresa').modal('show')
}

function loadlistPErfilGen(lIDUser, nameSelec){
    selectPer = document.getElementById(nameSelec);
    //document.getElementById("loadMod").options.length = 0;
    //console.log(ws + "Modulos",{idusuario: lIDUser });
    $.get(ws + "Perfiles",{idusuario: lIDUser }, function(data){
        var perfiles = JSON.parse(data).perfiles;
        for(var x in perfiles)
        {
            option = document.createElement("option");
            option.value = perfiles[x].idperfil;
            option.text = perfiles[x].nombre;
            selectPer.appendChild(option);
        }            
    });
}

function VinculacionEmpresa(vRfc, vContra, vIDUser, vIDPerfil){
    $.post(ws + "VinculaEmpresa", {rfc: vRfc, contra: vContra, idusuario: vIDUser, idperfil: vIDPerfil}, function(data){
        if(data>0){
            CargaListaEmpresas(vIDUser);
            $('#vincularempresa').modal('hide');  
        }else{;
            alert("Ocurrio un error al guardar el Permiso");
        }
    });
}