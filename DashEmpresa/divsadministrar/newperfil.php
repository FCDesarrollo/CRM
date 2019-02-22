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
<div id="NuevoPerfil" >
    <div class="body">
        <div class="modal-content">            
            <div class="modal-header">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-t-100 mg-b-10">Nuevo Perfil</h6>             
            </div>

            <div class="modal-body">
                <form id="FormGuardaPerfil" action="" method="post" class="was-validated">
                        <div class='form-group'>
                            <label for='txtnombreperfil'>Nombre</label>
                            <input type="text" class="form-control" id="txtnombreperfil2" name="nombreperfil" placeholder="NOMBRE"/>
                           
                        </div>
                        <div class='form-group'>
                            <label for='txtdesPerfil'>Descripción</label>
                            <input type="text" class="form-control" id="txtdesPerfil2" name="descripcion" placeholder="Descripción" />
                        </div>
                        
                </form>
            <div class="control-group">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-t-100 mg-b-10">Permisos</h6>
            </div>
            <form>
                <div class="module-body table" >
                    <table id="ListPermisoPerfil" hide cellpadding="0" cellspacing="0"  class="table table-bordered	 display"
                        width="100%">
                        <thead>
                            <tr>
                                <th>Nombre Modulo</th>
                                <th>Tipo Permiso</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                <button id="Guardar" onclick="GuardaPerfilEmpresa()" type="button" class="btn btn-primary">GUARDAR</button>
            </div>
            </form>
             
        </div>
            </div>
           
        </div>
    </div>
</div>

<script>
    var sIDEmpresa ='<?php echo $_SESSION["idempresalog"]; ?>';
    var sIDUser= '<?php echo $_SESSION["idusuario"]; ?>';
    $.get(ws + "Modulos",{idusuario: sIDUser }, function(data){
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
    });
        
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