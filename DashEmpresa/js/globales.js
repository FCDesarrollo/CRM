
function loadDiv(lNameForm){    
    $('.br-mainpanel').load(lNameForm);
}	

function CambiarEmpresa(){
	var idempresa = 0;
	
    $.ajax({                        
        data: { idempresa: idempresa },
        type: 'POST',
        url: '../../sessiones_usuario.php',            
        success:function(response){
    	   	window.location='../../usuario.php';
        }
    }); 
}

function CerrarSession(){
	var idempresa = 0;
	var usuario21 = "";
    $.ajax({                        
        data: { idempresa: idempresa, usuario21: usuario21 },
        type: 'POST',
        url: '../../sessiones_usuario.php',            
        success:function(response){
    	   	window.location='../../login/index.php';
        }
    });
}
