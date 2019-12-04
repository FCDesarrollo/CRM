<?php
global $perMod ;
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
const Men_AlmacenDigitalExp = 10;

//VARIABLES GLOBALES DE SUBMENU
    //SUBMENUS DE CONTABILIDAD
    const SubMen_Esta_Financieros = 1;
    const SubMen_Conta_Electr = 2;
    const SubMen_Exped_Admnis = 3;
    const SubMen_Exped_Conta = 4;

    //SUBMENUS DE FISCAL
    const SubMen_Pag_Provisio = 5;
    const SubMen_Pag_Mens = 6;
    const SubMen_Decla_Anual = 7;
    const SubMen_Exped_Fis = 8;

    //SUBMENUS DE FINANZAS
    const SubMen_Indi_Financieros = 9;
    const SubMen_Ase_Efectivo = 10;
    const SubMen_Anali_Proyec = 11;

    //SUBMENUS DE COMPRAS
    const SubMen_Requerimientos = 12;
    const SubMen_Autorizaciones = 13;
    const SubMen_Recep_Compras = 14;

    //SUBMENUS DE ALMACEN DIGITAL OPERACIONES
    const SubMen_Compras = 15;
    const SubMen_Ventas = 16;
    const SubMen_Pagos = 23;
    const SubMen_Cobros = 24;
    const SubMen_Produccion = 25;
    const SubMen_Inventarios = 26;

    //SUBMENUS DE RECEPCION POR LOTES
    const SubMen_Lotes_Compras = 17;
    const SubMen_Lotes_Ventas = 18;
    const SubMen_Lotes_Pagos = 19;
    const SubMen_Lotes_Cobros = 28;
    const SubMen_Lotes_Produccion = 29;
    const SubMen_Lotes_Inventarios = 30;

    //SUBMENUS DE EMPRESA
    const SubMen_Empresa = 20;
    //SUBMENUS DE USUARIOS
    const SubMen_Usuarios = 21;
    //SUBMENUS DE PERFILES
    const SubMen_Perfiles = 22;
    
    //SUBMENUS DE ALMACEN DIGITAL EXPEDIENTES
    const SubMen_Gobierno = 31;
    const SubMen_Bancos = 32;
    const SubMen_RecursosHumanos = 33;
    const SubMen_Clientes = 34;
    const SubMen_Proveedores = 35;
    const SubMen_Constitucion = 36;
    const SubMen_Activos = 37;
    const SubMen_Publicaciones = 38;


class PermisosUsuario
{
    const CONSTANTE = 'valor constante';
    private $_IDEmprsa;
    private $_IDUsuario;
    private $_Modulos;
    private $_Menus;
    private $_SubMenus;
    private $_NombresMOD;
    private $_NombresMEN;
    private $_NombresSUB;
    protected  $_sWs = "http://apicrm.dublock.com/public/";
    //protected  $_sWs = "http://localhost/ApiConsultorMX/miconsultor/public/";
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

    public function user_SubMenus()
    {
        $data2 = array("idempresa" => $this->_IDEmprsa, "idusuario" => $this->_IDUsuario);
        $resultado2 = CallAPI("GET", $this->_sWs ."SubMenuPermiso", $data2);    
        $this->_SubMenus = json_decode($resultado2, true);
    }

    public function Modulos()
    {
        $data2 = "";
        $resultado2 = CallAPI("GET", $this->_sWs ."Modulos");    
        $this->_NombresMOD = json_decode($resultado2, true);
    }      

    public function Menus()
    {
        $data2 = "";
        $resultado2 = CallAPI("GET", $this->_sWs ."Menus");    
        $this->_NombresMEN = json_decode($resultado2, true);
    }

    public function SubMenus()
    {
        $data2 = "";
        $resultado2 = CallAPI("GET", $this->_sWs ."SubMenus");    
        $this->_NombresSUB = json_decode($resultado2, true);
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

    public function SubMenu_Permiso(int $_mIDSubMenu): int
    {
        foreach($this->_SubMenus as $value) {
            if($_mIDSubMenu == $value['idsubmenu']){
                return  $value['tipopermiso'];
            }
        }  
         
    }
 

    public function Mod_Nombre(int $_mIDModulo): string
    {
        foreach($this->_NombresMOD as $value) {
            if($_mIDModulo == $value['idmodulo']){
                return  $value['nombre_modulo'];
            }
        }    
    }    

    public function Men_NombreCarpeta(int $_mIDMenu): string
    {
        foreach($this->_NombresMEN as $value) {
            if($_mIDMenu == $value['idmenu']){
                return  $value['nombre_carpeta'];
            }
        }    
    }

    public function Sub_NombreCarpeta(int $_mIDSubMenu): string
    {
        foreach($this->_NombresSUB as $value) {
            if($_mIDSubMenu == $value['idsubmenu']){
                return  $value['nombre_carpeta'];
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

    function nombremes($mes){
        setlocale(LC_TIME, 'spanish');  
        $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
        return $nombre;
    }
?>
