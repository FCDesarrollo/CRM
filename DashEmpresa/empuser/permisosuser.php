<?php
//VARIABLES GLOBALES DE MODULO
const Mod_IncloudCon = 1;
const Mod_InboxBandeja = 2;
const Mod_IndexAdministrar = 3;

//VARIABLES GLOBALES DE MENU
const Men_Contabilidad = 1;
const Men_Fiscal = 2;
const Men_Finanzas = 3;
const Men_Compras = 4;
const Men_AlmacenDigital = 5;
const Men_RecepLotes = 6;
const Men_Empresa = 7;
const Men_Usuarios = 8;
const Men_Perfiles = 9;
class PermisosUsuario
{
    const CONSTANTE = 'valor constante';
    private $_IDEmprsa;
    private $_IDUsuario;
    private $_Modulos;
    private $_Menus;
    private $_SubMenus;
   // protected  $_sWs = "http://apicrm.dublock.com/public/";
   protected  $_sWs = "http://localhost/ApiConsultorMX/miconsultor/public/";
    function __construct(int $IDComp,int $IDUse){
        $this->_IDEmprsa = $IDComp;
        $this->_IDUsuario = $IDUse;
    }
    
    public function user_Modulos()
    {
        $data = array("idempresa" => $this->_IDEmprsa, "idusuario" => $this->_IDUsuario);
        $resultado = CallAPI("GET", $this->_sWs ."PermisoModulos", $data);   
        $this->_Modulos = json_decode($resultado, true);
    }

    public function user_Menus()
    {
        $data2 = array("idempresa" => $this->_IDEmprsa, "idusuario" => $this->_IDUsuario);
        $resultado2 = CallAPI("GET", $this->_sWs ."MenusPermiso", $data2);    
        $this->_Menus = json_decode($resultado2, true);
    }

    protected function user_SubMenus()
    {
        $data2 = array("idempresa" => $this->cIDEmpresa, "idusuario" => $this->cIDUsuario);
        $resultado2 = CallAPI("GET", $this->sWs ."SubMenuPermiso", $data2);    
        $this->_SubMenus = json_decode($resultado2, true);
    }

    public function Mod_Permiso(int $_mIDModulo): int
    {
        foreach($this->_Modulos as $value) {
            if($_mIDModulo == $value['idmodulo']){
                return  $value['tipopermiso'];
            }
        }
        
    }

    public function Menu_Permiso(int $_mIDMenu): int
    {
        foreach($this->_Menus as $value) {
            if($_mIDMenu == $value['idmenu']){
                return  $value['tipopermiso'];
            }
        }
        
    }

    
}

function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();
        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        curl_close($curl);
        return $result;

    }
?>
