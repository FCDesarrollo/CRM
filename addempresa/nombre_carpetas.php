<?php
global $carStr;

class CarpetasStorage{
	protected  $_sWs = "http://apicrm.dublock.com/public/";
	private $_NombresMOD;
	private $_NombresMEN;
	private $_NombresSUB;
    private $_DatosStorage;
    public $n_Mod;	
    public $n_Men;
    public $n_Sub;
    public $Storage;
	function __construct(int $IDComp,int $IDUse){
        $this->_IDEmprsa = $IDComp;
        $this->_IDUsuario = $IDUse;
    }
	public function Modulos(){
	    $data2 = "";
	    $resultado2 = CallAPI("GET", $this->_sWs ."Modulos");
	    $this->_NombresMOD = json_decode($resultado2, true);
        $n_Mod = count($this->_NombresMOD);
	}      

	public function Menus(){
	    $data2 = "";
	    $resultado2 = CallAPI("GET", $this->_sWs ."Menus");    
	    $this->_NombresMEN = json_decode($resultado2, true);
        $n_Men = count($this->_NombresMEN);
	}

	public function SubMenus(){
	    $data2 = "";
	    $resultado2 = CallAPI("GET", $this->_sWs ."SubMenus");    
	    $this->_NombresSUB = json_decode($resultado2, true);
        $n_Sub = count($this->_NombresSUB);
	}  

    public function Storage(){
        $resultado2 = CallAPI("GET", $this->_sWs ."DatosStorageADM");    
        $this->_DatosStorage = json_decode($resultado2, true);
        $Storage = count($this->_DatosStorage);
    }    

    public function Mod_Nombre() {
        /*foreach($this->_NombresMOD as $value) {
            if($_mIDModulo == $value['idmodulo']){
                return  $value['nombre_modulo'];
            }
        }    */
        return $this->_NombresMOD;
    }    

    public function Men_Nombre() {
        /*foreach($this->_NombresMEN as $value) {
            if($_mIDMenu == $value['idmenu']){
                return  $value['nombre_menu'];
            }
        }*/    
        return $this->_NombresMEN;
    }

    public function Sub_Nombre() {
        /*foreach($this->_NombresSUB as $value) {
            if($_mIDSubMenu == $value['idsubmenu']){
                return  $value['nombre_submenu'];
            }
        } */   
        return $this->_NombresSUB;
    }
    public function StorageADM(){
        return $this->_DatosStorage;   
    } 	
}

function CallAPI($method, $url, $data = false){
    $curl = curl_init();
    switch ($method){
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