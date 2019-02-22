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
<div class="br-section-wrapper">
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Lista Perfiles</h6>
          
          <div class="table-wrapper">
            <button onclick="loadDiv('../divsadministrar/newperfil.php');"  class="btn btn-oblong btn-primary">Nuevo</button>
            <div id="datatable1_wrapper" class="dataTables_wrapper no-footer">
                <div class="dataTables_length" id="datatable1_length">
                    <label>
                       
                        <div id="datatable1_filter" class="dataTables_filter"><label>
                            Buscar:
                            <input type="search" class="" placeholder="Search..." aria-controls="datatable1"></label></div>
                        <table id="listPerfiles" class="table display responsive nowrap dataTable no-footer dtr-inline" role="grid" aria-describedby="datatable1_info" style="width: 818px;">
              <thead>
                <tr>
                    <th>Nombre Perfil</th>
                    <th>Descripcion</th>
                    <th>Estatus</th>
                    <th><em class="fa fa-cog"></em>Acciones</th>
                </tr>   
              </thead>
              
            </table><div class="dataTables_info" id="datatable1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div><div class="dataTables_paginate paging_simple_numbers" id="datatable1_paginate">
                <a class="paginate_button previous disabled" aria-controls="datatable1" data-dt-idx="0" tabindex="0" id="datatable1_previous">Previous</a><span>
                <a class="paginate_button current" aria-controls="datatable1" data-dt-idx="1" tabindex="0">1</a>
                <a class="paginate_button " aria-controls="datatable1" data-dt-idx="2" tabindex="0">2</a>
                <a class="paginate_button " aria-controls="datatable1" data-dt-idx="3" tabindex="0">3</a>
                <a class="paginate_button " aria-controls="datatable1" data-dt-idx="4" tabindex="0">4</a>
                <a class="paginate_button " aria-controls="datatable1" data-dt-idx="5" tabindex="0">5</a>
                <a class="paginate_button " aria-controls="datatable1" data-dt-idx="6" tabindex="0">6</a></span>
                <a class="paginate_button next" aria-controls="datatable1" data-dt-idx="7" tabindex="0" id="datatable1_next">Next</a></div></div>
          </div><!-- table-wrapper -->

<script>
    var sIDEmpresa ='<?php echo $_SESSION["idempresalog"]; ?>'
    sIDEmpresa=1;
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
                                    <a  onclick='DatosPerfilesUser(" + sIDEmpresa +");' value='"+perfiles[x].idperfil+"' class='btn btn-success'><em class='fa fa-pencil'></em></a> \
                                    <a  onclick='EliminarPerfilEmpresaTable(" + sIDEmpresa +");' value='"+perfiles[x].idperfil+"'class='btn btn-danger'><em class='fa fa-trash'></em></a> \
                                </td> \
                            </tr> \
                        </tbody>";
                
            }            
        });    
    }
    function EliminarPerfilEmpresaTable(sIDEmpresa){
        $("table tbody tr").click( function(){
            var sIDPerfil = $(this).find("td").eq(0).text(); 
            if(sIDPerfil>0){
                $.post(ws + "EliminarPerfilEmpresa",{ idperfil: sIDPerfil, idempresa : sIDEmpresa}, function(data, status){
                    if(data>0){
                        loadDiv('../divsadministrar/divadmperfiles.php');
                    }else{
                        alert("Ocurrio un error al eliminar el perfil");
                    }
                });
            }                      
        }); 
    }

    
</script>