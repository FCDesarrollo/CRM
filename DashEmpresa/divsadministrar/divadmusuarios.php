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
        <div id="datatable1_wrapper" class="dataTables_wrapper no-footer">
            <table id="ListaUsuarioslog" class="table display responsive nowrap dataTable no-footer dtr-inline collapsed" role="grid" aria-describedby="datatable1_info">
                <thead>   
                    <thead>
                        <tr>
                            <th>Nombre Usuario</th>
                            <th>Estatus</th>
                            <th><em class="fa fa-cog"></em>Acciones</th>
                        </tr>   
                    </thead> 
                </thead>
            </table>
        </div>
    </div>

        

<script>
    var idempresa ='<?php echo $_SESSION["idempresalog"]; ?>';
	$.get(ws + "ListaUsuarios/" + idempresa, function(data){
		var usuarios = JSON.parse(data).usuarios;
        var VinDes; //Variable para saber si esta vinculado o desvinculado el usuario de la empresa.
        for(var x in usuarios){

            if(usuarios[x].iduser != idusuarioglobal){

                VinDes = (usuarios[x].vinculado == 1 ? 'fa fa-unlink' : 'fa fa-link');
                document.getElementById("ListaUsuarioslog").innerHTML += 
    					"<tbody> \
    						<tr role='row' class='odd'> \
                                <td style='display:none;'>"+usuarios[x].iduser+"</td> \
    							<td style='padding-top: 20px;padding-bottom: 20px;'>"+ usuarios[x].nombre + " " + usuarios[x].apellidop + " " + usuarios[x].apellidom +"</td> \
                                <td value='"+usuarios[x].vinculado+"' style='padding-top: 20px;padding-bottom: 20px;'>"+(usuarios[x].vinculado == 0 ? 'Desvinculado' : 'Vinculado')+"</td> \
    							<td> \
                                    <a onclick='DatosUsuarioUser();' value='"+usuarios[x].iduser+"' title='Editar Permisos' class='btn btn-outline-primary btn-icon rounded-circle'><div><i class='fa fa-pencil' style='color: black;'></i></div></a> \
                                    <a onclick='VinDesEmp();' title='"+(usuarios[x].vinculado == 1 ? "Desvincular" : "Vincular")+"' class='btn btn-warning btn-icon rounded-circle'><div><i class='"+VinDes+"' style='color: white;'></i></div></a> \
                                    <a onclick='EliminaUserlog("+idempresa+");' title='Eliminar Usuario' value='"+usuarios[x].iduser+"' class='btn btn-danger btn-icon rounded-circle'><div><i class='fa fa-trash' style='color: white;'></i></div></a> \
    							</td> \
    						</tr> \
    					</tbody>";  
                console.log(usuarios[x].vinculado); 
            
            }
        }  
        $('#loading').addClass('d-none');          
    });
    


//     function permisoUser(idusuario){ 
        
//         $("#ListaPermisoslog tr").remove();
//         $('#ListaPermisoslog tbody').html("");
//         $.get(ws + "PermisosUsuario",{ idempresa: idempresa, idusuario : idusuario }, function(data){
//             var permisos = JSON.parse(data).permisos;
//             for(var x in permisos)
//             {
//                 var tr = "<tr>";
//                 tr = tr + "<td style='display:none;'>" + permisos[x].idperfil + "</td>";
//                 tr = tr + "<td style='display:none;'>" + permisos[x].idmodulo + "</td>";
//                 tr = tr + "<td>" + permisos[x].nombre + "</td>";
//                 tr = tr + "<td>" + nameModulos[permisos[x].idmodulo] + "</td>";
//                 tr = tr + "<td><select onChange='updatePermisoUser(" + idusuario +", value);' data-placeholder='Select here..' >" +
//                     " <option value='0' " + (permisos[x].tipopermiso == pBloqueado ? 'selected' : '') + ">Bloqueado</option>" +
//                     " <option value='1' " + (permisos[x].tipopermiso == pLectura ? 'selected' : '') + ">Lectura</option>" +
//                     " <option value='2' " + (permisos[x].tipopermiso == pLecYEsc ? 'selected' : '') + ">Lectura y Escritura</option>" +
//                     " <option value='3' " + (permisos[x].tipopermiso == pTodo ? 'selected' : '') + ">Todo</option>" +
//                     " </select> </td>"; 
//             // tr = tr + "<td>"+ namePermisos[permisos[x].tipopermiso] + "</td>";
//                 //tr = tr + "<td>" + namePermisos[permisos[x].tipopermiso] +"</td>";
//                 tr = tr + "</tr>";
//                 $('#ListaPermisoslog tbody').append(tr);
//                 //document.ready = document.getElementById(idusuario + permisos[x].idmodulo).value = '2';
//             }
//         }); 
//     }

//     function updatePermisoUser(siduser, inPermiso){
//     //var divalert = document.getElementById("alertSave");
//     $("table tbody tr").click(function() {
//         var sidModulo = $(this).find("td").eq(1).text();
//         if(siduser>0){
//             $.post(ws + "updatePermisoUsuario",{ idempresa: idempresa, idusuario: siduser, idmodulo: sidModulo, tipopermiso: inPermiso }, function(data){
//                 if(data>0){
//                    /* divalert.style.display='block';
//                     setTimeout(function() { 
//                         $('#alertSave').fadeOut('fast'); 
//                     }, 2000);*/
//                 }else{
//                     alert("Ocurrio un error al eliminar el usuario");
//                 }
//             });
//         }
       
        
//     });
// }
</script>