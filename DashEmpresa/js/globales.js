
function loadDiv(lNameForm){    
    $('.br-mainpanel').load(lNameForm);

     if(lNameForm == "../submenus/recepcionlotes.php"){
        asyncCall(); //Espera 2 segundos para mandar llamar la funcion de CargarLotes
     }
}	

function resolveAfter2Seconds() {
  return new Promise(resolve => {
    setTimeout(() => {
      resolve('Cargado');
    }, 2000);
  });
}

async function asyncCall() {  
    var result = await resolveAfter2Seconds();  
    CargarLotes();
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
