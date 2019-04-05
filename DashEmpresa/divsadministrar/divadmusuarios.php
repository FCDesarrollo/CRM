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
            <div id="datatable1_filter" class="dataTables_filter">
                <label><input type="search" class="" placeholder="Search..." aria-controls="datatable1"></label>
            </div>

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
            <div class="dataTables_info" id="datatable1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
            <div class="dataTables_paginate paging_simple_numbers" id="datatable1_paginate">
                <a class="paginate_button previous disabled" aria-controls="datatable1" data-dt-idx="0" tabindex="0" id="datatable1_previous">Previous</a>
                <span><a class="paginate_button current" aria-controls="datatable1" data-dt-idx="1" tabindex="0">1</a><a class="paginate_button " aria-controls="datatable1" data-dt-idx="2" tabindex="0">2</a><a class="paginate_button " aria-controls="datatable1" data-dt-idx="3" tabindex="0">3</a><a class="paginate_button " aria-controls="datatable1" data-dt-idx="4" tabindex="0">4</a><a class="paginate_button " aria-controls="datatable1" data-dt-idx="5" tabindex="0">5</a><a class="paginate_button " aria-controls="datatable1" data-dt-idx="6" tabindex="0">6</a></span>
                <a class="paginate_button next" aria-controls="datatable1" data-dt-idx="7" tabindex="0" id="datatable1_next">Next</a>
            </div>
        </div>
    </div>

        

<script>
    var idempresa ='<?php echo $_SESSION["idempresalog"]; ?>';
	$.get(ws + "ListaUsuarios/" + idempresa, function(data){
		var usuarios = JSON.parse(data).usuarios;
        for(var x in usuarios)
        {
            document.getElementById("ListaUsuarioslog").innerHTML += 
					"<tbody> \
						<tr role='row' class='odd'> \
                            <td style='display:none;'>"+ usuarios[x].iduser+"</td> \
							<td>"+ usuarios[x].nombre + " " + usuarios[x].apellidop + " " + usuarios[x].apellidom +"</td> \
                            <td >"+ (usuarios[x].status==1 ? "Activo" : "Inactivo") +"</td> \
							<td align='center'> \
								<a onclick='DatosUsuarioUser();' value='"+usuarios[x].iduser+"' class='btn btn-success'><em class='fa fa-pencil'></em></a> \
								<a onclick='EliminaUserlog(" + idempresa +");' value='"+usuarios[x].iduser+"'class='btn btn-danger'><em class='fa fa-trash'></em></a> \
							</td> \
						</tr> \
					</tbody>";   
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