<?php
session_start();  
    // $user = $_SESSION['idusuario'];
    // $user1 = $_SESSION['usuario21'];
    // $user2 = $_SESSION['tipo'];
    if($_SESSION["usuario21"] == "")
    {
        //Si no hay sesión activa, lo direccionamos al index.php (inicio de sesión) 
      session_destroy(); echo "<script> window.location='index.php' </script>";
      exit(); 
    } 
?>
<div class="br-pagebody">
<div class="br-section-wrapper">

    <form id="FormGuardarPerfil" action="" method="post">
        <h4 class="tx-gray-800 mg-b-5">Crear Perfil</h4>
        <input type="hidden" name="idperfil" id="txtidperfil" />                            

        <div class="control-group">
            <label class="control-label">Nombre Perfil</label>
            <div class="controls">
                <input type="text" class="form-control" name="nombreperfil" id="txtnombreperfil2" placeholder="Nombre" required="required">		
            </div>
        </div>  
        <div class="controls">
            <label class="control-label">Descripción</label>
            <input type="text" class="form-control" name="descripcion" id="txtdesPerfil2" placeholder="Descripción" required="required">	
        </div>        
        

    <div id="accordion" class="accordion mg-t-20" role="tablist" aria-multiselectable="true">
    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Permisos del Perfil</h6>
    <div class="card">
        <div class="card-header" role="tab" id="heading2">
        <h6 class="mg-b-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"
            aria-expanded="true" aria-controls="collapseTwo" class="tx-gray-800 transition">
            Lista de Modulos
            </a>
        </h6>
        </div><!-- card-header -->

        <div id="collapse2" class="collapse show" role="tabpanel" aria-labelledby="heading2">
        <div class="card-block pd-20">
        <div class="bd bd-gray-300 rounded table-responsive">
        <table class="table table-bordered" id="t-ModulosPer">            
            <thead>
                <tr>
                    <th>Modulos</th>
                    <th>Descripción</th>
                    <th align='center'>Permisos</th>
                </tr>                
            </thead>
        </table>
        </div>
        </div>
        </div>
    </div><!-- card -->

    <div class="card">
        <div class="card-header" role="tab" id="heading3">
        <h6 class="mg-b-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3" class="tx-gray-800 transition">
            Lista de Menus
            </a>
        </h6>
        </div><!-- card-header -->

        <div id="collapse3" class="collapse hide" role="tabpanel" aria-labelledby="heading3">
            <div class="card-block pd-20">
                <div class="bd bd-gray-300 rounded table-responsive">
                <table class="table table-bordered" id="t-Menus">            
                    <thead>
                        <tr>
                            <th>Menus</th>
                            <th>Modulo</th>
                            <th align='center'>Permisos</th>
                        </tr>                
                    </thead>
                    
                </table>
                </div>            
            </div>
        </div>
    </div><!-- card -->



    <div class="card">
        <div class="card-header" role="tab" id="heading4">
        <h6 class="mg-b-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapse4" class="tx-gray-800 transition">
            Lista de Sub-Menus
            </a>
        </h6>
        </div><!-- card-header -->

        <div id="collapse4" class="collapse hide" role="tabpanel" aria-labelledby="heading4">
            <div class="card-block pd-20">
                <div class="bd bd-gray-300 rounded table-responsive">
                    <table class="table table-bordered" id="t-SubMenus">            
                        <thead>
                            <tr>
                                <th>SubMenus</th>
                                <th>Menu</th>
                                <th align='center'>Permisos</th>
                            </tr>                
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- card -->    

    
    <!-- ADD MORE CARD HERE -->
    </div><!-- accordion -->
    <div class="control-group mg-t-20">
            <button type="button" onclick="GuardaUsuariolog();" class="btn btn-primary btn-block mg-b-10">Guardar</button>  
        </div>           
        
    </form>
</div>
</div>

<script>
    var sIDEmpresa ='<?php echo $_SESSION["idempresalog"]; ?>';
    var sIDUser= 1;
    CargaModulos();
    CargaMenus();
    CargaSubMenu();
   /* $.get(ws + "Modulos",{idusuario: sIDUser }, function(data){
    var modulos = JSON.parse(data).modulos;
    for(var x in modulos)
    {
        var tr = "<tr>";
        var nameID= "mod" + modulos[x].idmodulo;
        tr = tr + "<td style='display:none;'>" + modulos[x].idmodulo + "</td>";
        tr = tr + "<td>" + modulos[x].nombre_modulo + "</td>";
        tr = tr + "<td><select id='"+ nameID +"' data-placeholder='Select here..' >" +
                " <option value='0' selected>Bloqueado</option>" +
                " <option value='1'>Lectura</option>" +
                " <option value='2'>Lectura y Escritura</option>" +
                " <option value='3'>Todo</option>" +
                " </select> </td>"; 
        tr = tr + "</tr>";

        $('#ListPermisoPerfil tbody').append(tr);
    }            
    });*/
        
    function GuardaPerfilEmpresa(){
        var filas = $("#ListPermisoPerfil").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
        var idmodPer = "";
        var todosPermisos = [];
        var tipopermiso = "";
        for(i=1; i<filas.length; i++){ //Recorre las filas 1 a 1
            var celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
            var idmodPer = $(celdas[0]).text();
            var nameID= "mod" + idmodPer
            var tipopermiso = document.getElementById(nameID).value;
            todosPermisos.push({idmod: idmodPer, permiso: tipopermiso})
        }
        sID="0";
        sIDPerfil= "0";
        sStatus="1";
        snombre = document.getElementById('txtnombreperfil2').value;
        sdes = document.getElementById('txtdesPerfil2').value;
        $.post(ws + "GuardaPerfilEmpresa", {id: sID,idempresa: sIDEmpresa, idperfil:
            sIDPerfil,nombre: snombre,desc: sdes,status: sStatus, todos: todosPermisos}, function(data){
            if(data>0){
                loadDiv('../divsadministrar/divadmperfiles.php');
            }else{
                alert("Ocurrio un error al guardar el perfil");
            }
        }); 
    }
        
</script>