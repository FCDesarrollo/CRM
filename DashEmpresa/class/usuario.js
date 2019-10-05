class Usuario{


	constructor(rfcempresa, usuario, pwd){    

	    this.rfcempresa = rfcempresa;
	    this.usuario = usuario;
	    this.pwd = pwd;

        this.server;
        this.user_storage;
        this.pwd_storage;
	

	}

	/*DatosStorage(){
		
		var r;
    	$.get(ws + "DatosStorage", {rfcempresa: this.rfcempresa}, function(data){
            var datos = JSON.parse(data);
            r = datos;
            
            //this.server = r[0].server;
            //this.user_storage = r[0].usuario_storage;
            //this.pwd_storage = r[0].password_storage;
            
            //console.log(this.server);
            //return r;

            //r[1] = datos[0].server;
            //r[2] = datos[0].server;
            //return r;
        }); 		
    	return r;
		
		
	}*/

}



