//var ws = "http://localhost/ApiConsultorMX/miconsultor/public/";
//var ws = "http://apicrm.dublock.com/public/";
var divuser = document.getElementById("OcultoUser");
var divemp = document.getElementById("OcultoEmp");
var divaltaEmp= document.getElementById("altaEmp");
var divaltaUser= document.getElementById("altaUser");
var divuserEmp = document.getElementById("OcultoUserEmp");
var IDEMPRESA = "0";
var sfrmEdit = false;
//VARIABLES DE PERMISOS
//const sBloqueado = 0;
//const sLectura = 1;
//const sLecYEsc = 2;
//const sTodo = 3;

//const fInactivo = 0;
//const fUsuario = 1;
//const fPrueba = 2;
//const fAdministrador = 3;

function ListEmpresas(sIdusuario, sTipo)
        {
            var myTable = document.getElementById("ListaEmpresas"); 
            var rowCount = myTable.rows.length; 
            for (var x=rowCount-1; x>0; x--) { 
                myTable.deleteRow(x); 
            } 
            $('#ListaEmpresas tbody').html("");
            $.get(ws + "ListaEmpresas", { idusuario: sIdusuario, tipo : sTipo }, function(data){
                var empresas = JSON.parse(data).empresas;
                for(var x in empresas)
                {
                    var tr = "<tr>";
                    tr = tr + "<td>" + empresas[x].idempresa + "</td>";
                    tr = tr + "<td>" + empresas[x].nombreempresa + "</td>";
                    tr = tr + "<td>" + empresas[x].RFC + "</td>";
                    tr = tr + "<td>" + empresas[x].direccion + "</td>";
                    tr = tr + "<td>" + empresas[x].fecharegistro + "</td>";
                    tr = tr + "<td>" + (empresas[x].status==1 ? "Activo" : "Inactivo") + "</td>";
                    tr = tr + "<td>" +
                        "<a onclick='DatosEmpresa();' class='btn btn-info' style='margin-right:5px;' >Editar</a>" +
                        "<a onclick='EliminarEmpresa();' class='btn btn-danger'>Eliminar</a>" +
                        "</td>";
                    tr = tr + "</tr>";
                    $('#ListaEmpresas tbody').append(tr);
                }            
            });
        }  

function mostrarEmp(){
        if(divemp.style.display == "none"){
            divaltaEmp.style.display='none';
            divuser.style.display='none';
            divaltaUser.style.display= 'none';
            divuserEmp.style.display ='none';
            ListEmpresas(varIDuse,varTipouse);
            divemp.style.display='block';
        }else if(divemp.style.display == "block"){
            divemp.style.display='none';
        }
        
            //document.getElementById('oculto').style.display = 'block';
        }

    function mostrarUser(){
            
            if(divuser.style.display == "none"){
                ListaUsuarios(0);
                divaltaEmp.style.display='none';
                divemp.style.display='none';
                divaltaUser.style.display= 'none';
                divuserEmp.style.display ='none';
                divuser.style.display='block';              
            }else if(divuser.style.display == "block"){
                divuser.style.display='none';
            }
            }     

    function DatosEmpresa(){
        divuser.style.display='none';
        divemp.style.display='none';
        divaltaEmp.style.display='block';
        $("table tbody tr").click(function() {
            var sIDEmp =$(this).find("td").eq(0).text();
            IDEMPRESA = sIDEmp
            $.get(ws + "DatosEmpresaAD/" + sIDEmp, function(data){
                var empresa = JSON.parse(data).empresa;
                if(empresa.length>0){
                    ListaUsuariosEmp(IDEMPRESA);
                    divuserEmp.style.display='block';
 
                    $("#txtIdEmpresa").val(empresa[0].idempresa);
                    $("#txtnombreempresa").val(empresa[0].nombreempresa);
                    $("#txtrfc").val(empresa[0].RFC);
                    $("#txtrutaempresa").val(empresa[0].rutaempresa);
                    $("#txtdireccion").val(empresa[0].direccion);
                    $("#txttelefono").val(empresa[0].telefono);
                    $("#txtcodigopostal").val(empresa[0].codigopostal);
                    $("#txttelefono").val(empresa[0].telefono);
                    $("#txtfecharegistro").val(empresa[0].fecharegistro);
                    $("#txtpassword").val(empresa[0].password);
                    $('#chAcceso').prop("checked", (empresa[0].status==1 ? true : false) );
                }else{
                    alert("No se encontro la Empresa");
                }           
            });
          });
          
       
    }

    function EliminarEmpresa(){
        $("table tbody tr").click(function() {
            var sIDEmp =$(this).find("td").eq(0).text();
            var sNameEmp =$(this).find("td").eq(1).text();
            if(sIDEmp>0){
                var opcion = confirm("¿Esta seguro que desea eliminar la Empresa: " + sNameEmp + " ?");
                if (opcion == true) {
                    $.post(ws + "EliminarEmpresaAD",{ idempresa: sIDEmp, idcliente : sIDEmp }, function(data){
                        if(data>0){
                            ListEmpresas(varIDuse,varTipouse);
                        }else{
                            alert("Ocurrio un error al eliminar la empresa");
                        }
                    });
                } else {
                    //mensaje = "Has clickado Cancelar";
                }
            }
            
        });
    }

    function GuardaEmpresa(){
        $("#idempresa").val(IDEMPRESA);
        $("#txtstatus").val( $('#chAcceso').is(":checked") ? "1" : "0" );
        $.post(ws + "GuardarEmpresaAD", $("#FormGuardaEmpresa").serialize(), function(data){
            if(data>0){
                ListEmpresas(varIDuse,varTipouse);
                divaltaEmp.style.display='none';
                divemp.style.display='block';  
            }else{
                alert("Ocurrio un error al guardar la empresa");
            }
        }); 
        //document.getElementById("#FormGuardaEmpresa").reset();
    }

    