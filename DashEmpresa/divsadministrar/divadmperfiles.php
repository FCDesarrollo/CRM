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
          <div class="table-wrapper">
            <table id="listPerfiles" class="table display responsive nowrap dataTable no-footer dtr-inline collapsed" role="grid" aria-describedby="datatable1_info">
              <thead>
                <tr>
                    <th>Nombre Perfil</th>
                    <th>Descripcion</th>
                    <th>Estatus</th>
                    <th><em class="fa fa-cog"></em>Acciones</th>
                </tr>   
              </thead>
              
            </table>
          </div><!-- table-wrapper -->

<script>
    var sIDEmpresa ='<?php echo $_SESSION["idempresalog"]; ?>'
    if (sIDEmpresa > 0) {
        $.get(ws + "PerfileEmpresa/" + sIDEmpresa, function(data){
            var perfiles = JSON.parse(data).perfiles;
            for(var x in perfiles)
            {
                document.getElementById("listPerfiles").innerHTML += 
                        "<tbody> \
                            <tr role='row' class='odd'> \
                                <td style='display:none;'>"+perfiles[x].idperfil+"</td> \
                                <td>"+perfiles[x].nombre+"</td> \
                                <td >"+perfiles[x].descripcion+"</td> \
                                <td >" + (perfiles[x].status==1 ? "Activo" : "Inactivo") + "</td> \
                                <td align='center'> \
                                    <a  onclick='DatosPerfil(" + sIDEmpresa +");' value='"+perfiles[x].idperfil+"' class='btn btn-success'><em class='fa fa-pencil'></em></a> \
                                    <a  onclick='EliminarPerfilEmpresaTable(" + sIDEmpresa +");' value='"+perfiles[x].idperfil+"'class='btn btn-danger'><em class='fa fa-trash'></em></a> \
                                </td> \
                            </tr> \
                        </tbody>";
                
            }   
            $('#loading').addClass('d-none');         
        });  
    }
    

    
</script>