class UserPermisos{
    constructor() {
        
    }
    cPerModulos(uIDEmpresa, uIDUsuario){
      $.get(ws + "PermisoModulos",{ idempresa: uIDEmpresa, idusuario : uIDUsuario }, function(data){
        var permisos = JSON.parse(data).permisoMod;
        for(var x in permisos)
        {
          console.log(permisos[x].idmodulo);
          $.get(ws + "PermisoMenus",{ idempresa: uIDEmpresa, idusuario : uIDUsuario, idModulo : permisos[x].idmodulo }, function(data){
            var permisosMenu = JSON.parse(data).permisoMenu;
            for(var s in permisosMenu)
            {
              console.log(permisosMenu[s].idmenu);
            }
          });
         
        }
      });
     
    }
}
