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
    }else{

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mi Consultor</title>
    
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    

    <!------ Include the above in your HEAD tag ---------->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>


    <!-- Estilos Propios -->
    <link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen" />
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

   <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">



</head>
<body onload="CargaListaEmpresas('<?php echo $_SESSION['idusuario']; ?>')">

    <?php include("varglobales.php"); ?>
    <?php include("modal/agregar_vincular_empresa.php"); ?>
    <?php include("vincularempresa.php"); ?> 
    
    <div class="container">      
        <div style="margin-top:15px"></div>  
        <div class="row">
            <div class="col-8">
                <form id="FormListEmp" action="DashEmpresa/" method="POST">
                    <input type="hidden" name="idusuariolog" id="idusuariolog" value="<?php echo $_SESSION['idusuario']; ?>" />    
                    <input type="hidden" name="idempresalog" id="idempresalog" /> 
                    <input type="hidden" name="rfcempresa" id="rfcempresa" />
                    <input type="hidden" name="idperfil" id="idperfil"/>
                    <!--<input type="hidden" name="nombreempresalog" id="nombreempresalog" />-->                         
                </form>                                  
            </div>   
            <div class="col-4 text-right">                
                
            </div>  
        </div>  
        <hr>
    </div>
    <div class="container">        
        <div class="row">    
            <div class="col-md-10 col-md-offset-1">            
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-10 col-sm-6 col-md-6 col-lg-6">
                                <h3 class="panel-title"><i class="fa fa-user"></i><span id="usuariolog" style="margin-left: 5px"></span></h3>
                            </div>
                            <div class="col-xs-2 col-sm-6 col-md-6 col-lg-6" style="display: flex; justify-content: flex-end;">
                                <a onclick="AgregarVincularEmpresa('<?php echo $_SESSION['idusuario']; ?>')" title="Agregar ó Vincular Empresa" class='btn btn-outline-primary'>
                                    <i class="fa fa-plus"></i> 
                                    <span class="hidden-xs">Agregar ó Vincular Empresa</span>
                                </a>                                
                                <a onclick="CerrarSession()" title="Cerrar Session" class='btn btn-outline-warning'>
                                    <i class="fa fa-times-circle"></i> 
                                    <span class="hidden-xs">Cerrar Session</span>
                                </a>
                            </div>
                        </div>
                    </div>
                  
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-list" id="lista-empresa">
                            <thead>
                                <tr>
                                    <th style="display:none"></th>
                                    <th>Empresa</th>
                                    <th>RFC</th>
                                    <th>Perfil</th>
                                    <!--<th><em class="fa fa-cog"></em> Acciones</th>-->
                                </tr> 
                            </thead>
                        </table>                
                    </div>

                </div>
            </div>

        </div>
    </div>
        
        
    </div>    
    
    <!-- <div id="DesvinculaModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body"> 
                    <label>¿Desea Desvincular la empresa seleccionada?</label>
                    <div class="btn-group btn-group-justified btn-group-emp"> 
                        <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $_SESSION['idusuario']; ?>" />    
                        <div class="btn-group btn-listemp" role="group">
                            <button type="button" onclick="DesvinculaEmpresa()" class="btn btn-danger btn-listemp">Desvincular</button>
                        </div>
                        <div class="btn-group btn-listemp" role="group">    
                            <button type="button" id="cerrar" data-dismiss="modal" class="btn btn-secondary btn-listemp">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  -->
 

   

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>



    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <script src="https://unpkg.com/tooltip.js"></script>

    <script src="js/app.js"></script> 
    <script src="js/vinculacion.js"></script> 
    <!--<script src="usuarioadmin/usuarioslog.js"></script>   --> 

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
 

    function AbreEmpresa(){
        $("table tbody tr").click( function(){
            var select = $(this).find("td").eq(0).text(); 
            var rfc = $(this).find("td").eq(2).text();      
            gNombreEmpresa = $(this).find("td").eq(1).text();  
            var idper = $(this).find("td").eq(3);
            idper = idper[0]["attributes"][0].value;

            if(select!=""){                 
                $("#idempresalog").val(select);                
                $("#rfcempresa").val(rfc);
                $("#idperfil").val(idper);
                $("#FormListEmp").submit();
            }else{
                alert("Seleccione Empresa");
            }                
        });        
    }

    function CerrarSession(){
        var idempresa = 0;
        var usuario21 = "";
        $.ajax({                        
            data: { idempresa: idempresa, usuario21: usuario21 },
            type: 'POST',
            url: 'sessiones_usuario.php',            
            success:function(response){
                window.location='index.php';
            }
        });       
    }

    // function Desvincula(){
    //     $('body').on('click', '#lista-empresa a', function(){
    //         var btnElimina = $(this).attr('value');
    //         if(btnElimina != ""){                  
    //             $('#DesvinculaModal').modal('show');
    //         }else{                
    //             //$('#DesvinculaModal').modal('hide');
    //         }  
    //     });              
    // }    

    </script>
</body>
</html>
