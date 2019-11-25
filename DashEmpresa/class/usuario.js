class Usuario{


	constructor(rfcempresa, usuario, pwd){    

	    this.rfcempresa = rfcempresa;
	    this.usuario = usuario;
	    this.pwd = pwd;

        this.idperfil;
        
        this.server;
        this.user_storage;
        this.pwd_storage;
        this.nombre_empresa;
	

	}


	/*DatosPerfil(rfc, usuario){
		
    	$.get(ws + "DatosPerfil", {rfcempresa: rfc, usuario: usuario}, function(data){
            var datos = JSON.parse(data);
            for (var i = 0; i <= datos.length; i++) {
                if(datos[i].id == idperfil){
                    var perfil = datos[i].nombre;
                    break;
                }
            }            
            //return perfil;    
            return "Entra";    
        });		
		
	}*/

}



