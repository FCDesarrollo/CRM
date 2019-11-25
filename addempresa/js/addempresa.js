var codigoEmpresa = 0;
$('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');

      if (e.type === 'keyup') {
            if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
        if( $this.val() === '' ) {
            label.removeClass('active highlight'); 
            } else {
            label.removeClass('highlight');   
            }   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
            label.removeClass('highlight'); 
            } 
      else if( $this.val() !== '' ) {
            label.addClass('highlight');
            }
    }

});

$('.tab a').on('click', function (e) {
  
  e.preventDefault();
  
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();
  
  $(target).fadeIn(600);
  
});

function CancelarAddVin(){
  window.location='../usuario.php';
}

function LimpiarDatos(){
  $("#btn_datos").addClass("disabled");
}

function ValidarDatos(){   

    $("#loading").removeClass('d-none');
//    var correo = document.getElementById("txtcorreo").value;
    var archivoC = document.getElementById("archivoCer").value;
    var archivoK = document.getElementById("archivoKey").value;
    var pwd = document.getElementById("txtContrasena").value;

    //var form = $("#FormGuardarEmpresa").serialize();

    if(archivoC != "" && archivoK != "" && pwd != ""){
          
      var archivoKey = document.getElementById("archivoKey").files[0];
      var archivoCer = document.getElementById("archivoCer").files[0];
      var parametros = new FormData();
      parametros.append("archivoCer", archivoCer);
      parametros.append("archivoKey", archivoKey);


      $.ajax({
          type: 'POST',
          url: 'valida_archivos.php',
          data: parametros,
          contentType: false,
          processData: false,
          success: function(response){  
              respuesta = response;
              respuesta = respuesta.replace("/", "");
              respuesta = respuesta.replace("[", "");
              respuesta = respuesta.replace("]", "");
              var array = respuesta.split(",");   
              //if (array[0] === 'true' && array[1] === 'true' && array[2] === 'true' && array[3] === 'true' ){
              if (array[0] === 'true' && array[1] === 'true' && array[2] === 'true'){

                $.ajax({
                    type: 'POST',
                    url: 'http://apicr.atwebpages.com/documentos/leerarchivos.php',
                    data:{
                        password: document.getElementById("txtContrasena").value,
                        key: document.getElementById("archivoKey").files[0].name,
                        cer: document.getElementById("archivoCer").files[0].name,
                        carpeta: "archivos",
                        //carpeta: document.getElementById("txtRFC").value,
                    },
                    cache: false,
                    error: function(data) {
                      console.log("error");
                       alert("error\n", data);
                      swal(data, { 
                          icon: "info",
                          buttons: false,
                          timer: 3000,
                      });  
                    },
                    success: function(data) { 
                        var datos = JSON.parse(data);
                        
                        if (datos['pareja']['result'] == 1 && datos['ArregloCertificado']['result'] == 1 && datos['Arreglofecha']['result'] == 1 && datos['KeyPemR']['result'] == 1){
                          
                          $("#loading").addClass('d-none');
                          $("#btn_datos").removeClass("disabled");
                          $("#btn_datos").get(0).click();
                          var fechaCer = datos['Arreglofecha']['fecha'].split(" ");

                          fecha = Date();                                                        

                          var fechauno = new Date(fecha);
                          var fechados = new Date(fechaCer);

                          fecha = fechauno.getDate() + "-" + convertMonth(fechauno.getMonth()+1) + "-" + fechauno.getFullYear();
                          
                          //if (fechauno.getTime() < fechados.getTime()){                                  
                          var fec1 = fecha.split("-");
                          var fec2 = fechaCer[0].split("-");                          
                          fec1[1] = fec1[1].toLowerCase();
                          fec2[1] = fec2[1].toLowerCase();
                          var months = ["ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic"];
                          fec1[1] = months.indexOf(fec1[1]);                          
                          fec2[1] = months.indexOf(fec2[1]);
                          var f1 = new Date(parseInt(fec1[2]), fec1[1] + 1, parseInt(fec1[0])); //31 de diciembre de 2015
                          var f2 = new Date(parseInt(fec2[2]), fec2[1] + 1, parseInt(fec2[0]));

                          //if (fecha < fechaCer[0]){
                          if (f1 < f2){
                              rfcCert = datos['ArregloCertificado']['datos'].replace('"', "");                                
                              //var array = rfcCert.split(",");    
                              var array = rfcCert.split("="); 
                              var array2  = array[3].split(",");  
                              //document.getElementById("txtNombre").value = "";
                              $("#txtempresa").val(array2[0].trim());
                              $("#txtempresa").addClass('disabled');
                              //document.getElementById("txtRFC").value = "";                                                                 
                              if (typeof(array[7]) != 'undefined') {
                                  var rfc = array[7];
                                  if (rfc != ""){
                                      var rfcCorrecto = rfcValido(rfc.trim());                                  
                                      if (rfcCorrecto){                            
                                          $("#txtrfc").val(rfc.trim());
                                          $("#txtrfc").addClass('disabled');
                                          //$("#txtvigencia").val(formatDate(new Date(fechaCer)));
                                          var Vigencia = fec2[2] + "-" + (fec2[1] + 1) + "-" + fec2[0];
                                          $("#txtvigencia").val(Vigencia);
//                                            $("#txtvigencia").val(fechaCer[0]);
//                                            curlCarpetas();
                                      }else{
                                        $("#loading").addClass('d-none');
                                        swal("RFC es incorrecto", { 
                                            icon: "info",
                                            buttons: false,
                                            timer: 3000,
                                        });                                          
                                      }
                                  }
                              }else{
                                $("#loading").addClass('d-none');
                                swal("Este es un certificado, se requiere la FIEL.", { 
                                    icon: "info",
                                    buttons: false,
                                    timer: 3000,
                                });
                              }
                          }else{
                            $("#btn_registro").get(0).click();
                            LimpiarDatos();
                            $("#loading").addClass('d-none');
                            swal("El certificado está vencido " + fechaCer, { 
                                icon: "info",
                                buttons: false,
                                timer: 3000,
                            });
                          }                      
                      }else if(datos['KeyPemR']['result'] == 0){                  
                        $("#loading").addClass('d-none');
                        swal(datos['KeyPemR']['error'], { 
                            icon: "info",
                            buttons: false,
                            timer: 3000,
                        });
                      }else if(datos['pareja']['result'] == 0){                  
                        $("#loading").addClass('d-none');
                        swal(datos['pareja']['error'], { 
                            icon: "info",
                            buttons: false,
                            timer: 3000,
                        });                          
                      }else if(datos['Arreglofecha']['result'] == 0){
                        $("#loading").addClass('d-none');
                        swal(datos['Arreglofecha']['error'], { 
                            icon: "info",
                            buttons: false,
                            timer: 3000,
                        });                          
                      }else if(datos['ArregloCertificado']['result'] == 0){
                        $("#loading").addClass('d-none');
                        swal(datos['ArregloCertificado']['error'], { 
                            icon: "info",
                            buttons: false,
                            timer: 3000,
                        });                          
                      } 
                    }
                });

              }else if (array[0] === 'false'){
                  $("#loading").addClass('d-none');
                  swal("No se pudo conectar con el servidor", { 
                      icon: "info",
                      buttons: false,
                      timer: 3000,
                  });                  
              }else if(array[1] === 'false'){
                  $("#loading").addClass('d-none');
                  swal("No se pudo subir el archivo .key", { 
                      icon: "info",
                      buttons: false,
                      timer: 3000,
                  });                  
              }else if(array[2] === 'false'){
                  $("#loading").addClass('d-none');
                  swal("No se pudo subir el archivo .Cer", { 
                      icon: "info",
                      buttons: false,
                      timer: 3000,
                  });                  
              }
          }, 
          error: function (data) {  
              $("#loading").addClass('d-none');            
              swal("Ha ocurrido un error al subir los archivos", { 
                  icon: "info",
                  buttons: false,
                  timer: 3000,
              });              
          }  
             
      });   

    }else{
        $("#loading").addClass('d-none');
        if(archivoC == ""){
            swal("¡Certificado!", "Debe seleccionar un certificado valido.","info");
        }else if(archivoK == ""){
            swal("¡Archivo Key!","Debe seleccionar el arhivo .key","info");
        }else if(pwd == ""){
            swal("¡FIEL!","Introducir la contraseña FIEL","info");
        }
    }
}

function CrearEmpresa(){

  $("#loading").removeClass('d-none');
  if(codigoEmpresa != 0){    
    validaCodigoEmp();
  }else{

    var archivoC = document.getElementById("archivoCer").value;
    var archivoK = document.getElementById("archivoKey").value;
    var pwd = document.getElementById("txtContrasena").value;
    var empresa = document.getElementById("txtempresa").value;
    var rfc = document.getElementById("txtrfc").value;
    var correo = document.getElementById("txtcorreo").value;
    //var direccion = document.getElementById("txtdireccion").value;
    //var telefono = document.getElementById("txttelefono").value;
    //var cp = document.getElementById("txtcp").value;

    if(archivoC != "" && archivoK != "" && pwd != "" && empresa != "" && rfc != "" && correo != ""){

      $.ajax({                        
          data: {correo: correo},
          type: 'POST',            
          url: '../login/validarcorreo/validaEmpresa.php',
          success:function(response){
              resultado = JSON.parse(response);
              estatusCorreo = resultado[0];
              codigo = resultado[1];
              if (estatusCorreo == true) {
                codigoEmpresa = codigo;
                validaCodigoEmp();           
                
                  //$("#myModal").modal("show");
                  //$("#codigo").val(codigo);
              }else if (estatusCorreo == false){
                  $("#loading").addClass('d-none');
                  swal("¡Correo Electronico!", "Ocurrió un problema al mandar el correo.","error");
              }   
              
          }
      }); 

    }else{
      $("#loading").addClass('d-none');
      if(archivoC == ""){
          swal("¡Certificado!", "Debe seleccionar un certificado valido.","info");
      }else if(archivoK == ""){
          swal("¡Archivo Key!","Debe seleccionar el arhivo .key","info");
      }else if(pwd == ""){
          swal("¡FIEL!","Introducir la contraseña FIEL","info");
      }else if(empresa == ""){
          swal("¡Empresa!", "Nombre de la empresa no puede estar vacio.","info");
      }else if(rfc == ""){
          swal("RFC!", "Favor de introducir el RFC de la empresa.","info");
      }else if(correo == ""){
          swal("¡Correo Electronico!", "Favor de introducir un correo electronico valido.","info");
      /*}else if(direccion == ""){
          swal("¡Direccion!", "Campo requerido..","info");
      }else if(telefono == ""){
          swal("¡Telefono!", "Campo requerido.","info"); 
      }else if(cp == ""){
          swal("¡Codigo Postal!", "Campo requerido.","info");*/
      }
    }
  
  }

}

function validaCodigoEmp(){
    $("#loading").addClass('d-none');
    swal("Introduzca el código de confirmación que ha sido enviado a su correo", {
      icon: "warning",
      content: "input",
    })
    .then((value) => {
      if(value == codigoEmpresa){
              curlCarpetas()
      }else{
          swal("El codigo de verificacion es incorrecto, ingrese un codigo valido.", {
            icon: "error",
            content: "input",
          })
          .then((value) => {
            if(value == codigoEmpresa){
                curlCarpetas()
            }
          });
      }
      
    });   
}

var objeto = new Object();
function curlCarpetas(){
    //var parametros = new FormData($("#FormGuardarEmpresa")[0]);
    $("#loading").removeClass('d-none');
    var archivoKey = document.getElementById("archivoKey").files[0];
    var archivoCer = document.getElementById("archivoCer").files[0];
    var empresa = document.getElementById("txtempresa").value;
    var rfc = document.getElementById("txtrfc").value;
    var pwd = document.getElementById("txtContrasena").value;
    var correo = document.getElementById("txtcorreo").value;
    //var direccion = document.getElementById("txtdireccion").value;
    //var telefono = document.getElementById("txttelefono").value;
    //var cp = document.getElementById("txtcp").value;
    var vigencia = document.getElementById("txtvigencia").value;

    var fechaReg = new Date();     
    var fechaR = fechaReg.getFullYear() + "/" + (fechaReg.getMonth() + 1) + "/" + fechaReg.getDate();    
    
    $.get(ws + "BDDisponible", function(data){
    //console.log(ws + "BDDisponible");
        var resultado = JSON.parse(data).basedatos;             
        if (resultado.length > 0){
            var id = resultado[0].id;           
            
            objeto.idempresa = 0;
            objeto.nombreempresa = empresa;
            objeto.rutaempresa = resultado[0].nombre;
            objeto.RFC = rfc;
            //objeto.direccion = direccion;
            //objeto.telefono = telefono;
            //objeto.codigopostal = cp;   
            objeto.fecharegistro = fechaR;               
            objeto.status = 1;
            objeto.password = pwd;
            objeto.empresaBD = resultado[0].nombre;  
            objeto.correo = correo;
            objeto.vigencia = vigencia;    

            $.post(ws + "AsignaBD",  { id: id, rfc: rfc }, function(data){ 
              var asigna = JSON.parse(data).registro;                       
              if(typeof(asigna[0].rfc) == 'undefined') { 
                  ResgistraEmpresa();                  
              }else{
                  //alert("No se pudo asignar base de datos");
                  $("#loading").addClass('d-none');
                  //swal("¡Empresa!","Ya existe la empresa que intenta registrar.","warning");
                  swal("Ya existe la empresa que intenta registrar.", { 
                      icon: "info", 
                      timer: 5000,
                  })
                  .then(() => {
                      window.location='../usuario.php';
                  });                   
                  //window.location='../../usuario.php';
                  //eliminarCurl();                                
              }
            }); 
        } else {
            //eliminarCurl();
//            alert("No hay hay base de datos disponible");
            $("#loading").addClass('d-none');
            swal("¡Registro de Empresa!","No hay base de datos disponible, comunicarse a sistemas.","warning");
        }                  
    });        

/*        //url: 'modal/ajax/curlArchivos_ajax.php',
  */
}

function ResgistraEmpresa(){    
            
    var idusuario = document.getElementById("txtidusuario").value;
    
    
//        $.post(ws + "GuardarEmpresa", $("#FormGuardarEmpresa").serialize(), function(data){
    $.post(ws + "GuardarEmpresa", {datos: objeto}, function(data){          
        if(data>0){ 
            $.post(ws + "CrearTablasEmpresa", {empresaBD: objeto["empresaBD"]}, function(result){
                if(result>0){
                    $.post(ws + "UsuarioEmpresa",{ idusuario: idusuario, idempresa: data }, function(data){
                        if(data>0){                                       
                            $.post(ws + "UsuarioProfile",{ idusuario: idusuario, empresaBD: objeto["empresaBD"] }, function(data){                                        
                                if(data>0){
                                    CrearCarpetasStorage();                                    
//                                    swal("¡Registro de Empresa!", "La empresa ha sido creada correctamente.","success");            
//                                    window.location='../../usuario.php';
                                }else{
                                    $("#loading").addClass('d-none');
                                    swal("¡Registro de Empresa!", "Hubo un problema al intentar asignar los permisos al usuario.","error");
                                    UsuarioEmpresaEliminar(idusuario);
                                }
                            });                                                        
                        }else{
                            $("#loading").addClass('d-none');
                            swal("¡Registro de Empresa!", "No se pudo vincular el usuario a la empresa, volver a intentar.","error");
                            EliminaTablasEmpresa();
                        }                                                                          
                    
                    }); 
                }else{                                                        
                    $("#loading").addClass('d-none');
                    swal("¡Registro de Empresa!", "Ocurrio un error al crear las tablas de la empresa.","error");
                    EliminaEmpresa(); 
                }
            });      

        }else{    
            $("#loading").addClass('d-none');        
            swal("¡Registro de Empresa!", "Hubo un error al intentar registrar la empresa.","error");            
            AcutalizaAsignaBD(objeto["empresaBD"]);                 
        }
    });          
}

function CrearCarpetasStorage(){
    var archivoKey = document.getElementById("archivoKey").files[0];
    var archivoCer = document.getElementById("archivoCer").files[0];
    var pwd = document.getElementById("txtContrasena").value;
    var rfc = document.getElementById("txtrfc").value;
    var parametros = new FormData();    
        parametros.append("archivoCer", archivoCer);
        parametros.append("archivoKey", archivoKey);
        parametros.append("password", pwd);
        parametros.append("rfc", rfc);

    $.ajax({
        type: 'POST',//tipo de petición
        url: 'Curl_Archivos_Carpetas.php',
        data: parametros,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){ 
            var datosCurl = JSON.parse(response);
            if(datosCurl[0] === true && datosCurl[1] === true && datosCurl[2] === true){
//                swal("¡Registro de Empresa!", "La empresa ha sido creada correctamente.","success");            
                //window.location='../../usuario.php';
                $("#loading").addClass('d-none');
                swal("La empresa ha sido creada correctamente.", { 
                    icon: "success",
                    buttons: {
                      Aceptar: "Aceptar",                      
                    },                    
                    timer: 5000,
                })
                .then((value) => {
                  switch (value) { 
                    case "Aceptar":
                      window.location='../usuario.php';
                      break;
                    default:
                      window.location='../usuario.php';
                      break;
                  }
                }); 


            }else if (datosCurl[0] === false){                
//                alert("No se ha podido conectar con el servidor.");
                $("#loading").addClass('d-none');
                swal("¡Registro de Empresa!", "No se pudo conectar al servidor.","error");
                eliminarCurl();
            }else if(datosCurl[1] === false){
//                alert("Problemas al guardar el archivo .Cer.");
                $("#loading").addClass('d-none');
                swal("¡Registro de Empresa!", "Problemas al intentar guardar el archivo .Cer","error");
                eliminarCurl();
            }else if(datosCurl[2] === false){
//                alert("Problemas al guardar el archivo .Key.");
                $("#loading").addClass('d-none');
                swal("¡Registro de Empresa!", "Problemas al intentar guardar el archivo .Key","error");
                eliminarCurl();
            }else if(datosCurl[3] === false){
                $("#loading").addClass('d-none');
                swal("¡Registro de Empresa!", "No se pudo generar el archivo .txt","error");
//                alert("Problemas al crear el archivo TXT.");
                eliminarCurl();
            }        
        },
    });  
}

function eliminarCurl() {
    //var parametros = new FormData($("#FormGuardarEmpresa")[0]);
    var idusuario = document.getElementById("txtidusuario").value;        
    UsuarioEmpresaEliminar(idusuario);

    var archivoKey = document.getElementById("archivoKey").files[0];
    var archivoCer = document.getElementById("archivoCer").files[0];
    var pwd = document.getElementById("txtContrasena").value;
    var rfc = document.getElementById("txtrfc").value;
    var parametros = new FormData();    
        parametros.append("archivoCer", archivoCer);
        parametros.append("archivoKey", archivoKey);
        parametros.append("password", pwd);
        parametros.append("rfc", rfc);

    $.ajax({
        type: 'POST',//tipo de petición
        url: 'Curl_Eliminar_Carpetas.php',
        data:parametros,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){  
          
        },
    });      
}

function EliminaEmpresa() {
    //var rfc = document.getElementById("txtRFC").value;
    $.post(ws + "EliminarRegistro",  { rfc: objeto["RFC"] }, function(data){    
        if(data>0){             
            AcutalizaAsignaBD(objeto["empresaBD"]);
        }
    });     
}
function EliminaTablasEmpresa() {
    //var empresaBD = document.getElementById("txtempresaBD").value;
    $.post(ws + "EliminarTablas",  { empresaBD: objeto["empresaBD"] }, function(data){    
        if(data>0){             
            EliminaEmpresa();
        }
    });     
}

function UsuarioEmpresaEliminar(usuarioId) {
    //var usuarioId = document.getElementById("idusuariolog").value;

    $.post(ws + "EliminarUsuarioEmpresa",  { usuarioId: usuarioId }, function(data){    
        if(data>0){             
            EliminaTablasEmpresa();
        }
    });     
}

function AcutalizaAsignaBD(empresaBD) {
    //var empresaBD = document.getElementById("txtempresaBD").value;
    $.post(ws + "EliminaAsignaBD",  { empresaBD: empresaBD }, function(data){    
        if(data>0){             
            //eliminarCurl();
        }
    });     
}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();


    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    //return [year+"-"+month+"-"+day];
    return [year, month, day].join('-');
}

   function convertMonth(mes) {
        var meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        for (var i = 0; i < 12; i++) {          
          if(i == mes-1){
             var valor = meses[i];
             break;
          }
        }
        return valor;
   }

function rfcValido(rfc, aceptarGenerico = true) {
    const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
    var   validado = rfc.match(re);

    if (!validado)  //Coincide con el formato general del regex?
        return false;

    //Separar el dígito verificador del resto del RFC
    const digitoVerificador = validado.pop(),
          rfcSinDigito      = validado.slice(1).join(''),
          len               = rfcSinDigito.length,

    //Obtener el digito esperado
          diccionario       = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
          indice            = len + 1;
    var   suma,
          digitoEsperado;

    if (len == 12) suma = 0
    else suma = 481; //Ajuste para persona moral

    for(var i=0; i<len; i++)
        suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
    digitoEsperado = 11 - suma % 11;
    if (digitoEsperado == 11) digitoEsperado = 0;
    else if (digitoEsperado == 10) digitoEsperado = "A";

    //El dígito verificador coincide con el esperado?
    // o es un RFC Genérico (ventas a público general)?
    if ((digitoVerificador != digitoEsperado)
     && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
        return false;
    else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
        return false;
    return rfcSinDigito + digitoVerificador;
}

