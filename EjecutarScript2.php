<?php
    class Certificados{

        private  $_path = 'C:/xampp/htdocs/script/';
        public  $_keyPem = 'aaa010101aaa.key';
        public $_cerPem = '00001000000407734879.cer';
        public  $_pfx = '';
        private $_return = array();

		function __construct($pathCertificados = null){
            $this->_path = $pathCertificados;
        }

        private function _estableceError($result, $mensajeError = null, $arrayExtras = null){
            $this->_return = array();
            $this->_return['result'] = $result;
            if($mensajeError != null){
                $this->_return['error'] = $mensajeError;
            }
            if($arrayExtras != null){
                foreach ($arrayExtras as $key => $val){
                    $this->_return[$key] = $val;
                }
            }
        }

        function generaKeyPem($nombreKey, $password){
        
            if (file_exists($nombreKey)) {
                $salida = shell_exec('openssl pkcs8 -inform DER -in '.$nombreKey.' -out '.$nombreKey.'.pem -passin pass:'.$password.' 2>&1');
                if($salida == '' || $salida == false || $salida == null){
                    $this->_keyPem = $nombreKey.'.pem';
                    $this->_estableceError(1);
                    return $this->_return;
                }else if (strpos($salida, 'Error decrypting') !== false) {
                    $this->_estableceError(0, 'Contraseña incorrecta');
                    return $this->_return;
                }else {
                    $this->_estableceError(0, 'No se logro generar el key.pem');
                    return $this->_return;
                }
                
            }else {
                $this->_estableceError(0, 'El archivo requerido no esta disponible');
                return $this->_return;
            }
        }

        function generaCerPem($nombreCer){
		
            $nombreCer = $this->_path.$nombreCer;	
            if (file_exists($nombreCer)) {
                $salida = shell_exec('openssl x509 -inform DER -outform PEM -in '.$nombreCer.' -pubkey -out '.$nombreCer.'.pem 2>&1');
                if (strpos($salida, 'BEGIN PUBLIC KEY') !== false){
                    $this->_cerPem = $nombreCer.'.pem';
                    $this->_estableceError(1);
                    return $this->_return;
                }else {
                    $this->_estableceError(0, 'No se logro generar el cer.pem');
                    return $this->_return;
                }
            }else {
                $this->_estableceError(0, 'El archivo requerido no esta disponible.');
                return $this->_return;
            }
        }

		function getFechaVigencia($nombreCerPem){
            if (file_exists($nombreCerPem)){
                $salida = shell_exec('openssl.exe x509 -inform DER -in '.$nombreCerPem.' -noout -enddate 2>&1');
                $salida = str_replace('notAfter=', '', $salida );
                $info_preg = array();
                $salida = str_replace('  ', ' ', $salida);
                preg_match('#([A-z]{3}) ([0-9]{1,2}) ([0-2][0-9]:[0-5][0-9]:[0-5][0-9]) ([0-9]{4})#',
                $salida,$info_preg);
                if(!empty($info_preg)){
                    //  dia/mes/año:hora
                    $fecha =  $info_preg[2].'-'.$info_preg[1].'-'.$info_preg[4].' '.$info_preg[3];
                    //echo $fecha;
                    $this->_estableceError(1, null, array('fecha' => $fecha));
                    return $this->_return;
                }else {
                    $this->_estableceError(0, 'No se logro obtener la fecha de vigencia del certificado');
                    echo $this->_return;
                }
            }else {
                $this->_estableceError(0, 'El archivo '. $this->_path .' requerido no está disponible');
                return $this->_return;
            }
        }

        function validarCertificado($nombreCerPem){

            if (file_exists($nombreCerPem)){
                $salida = shell_exec('openssl x509 -inform DER -in '.$nombreCerPem.' -noout -subject 2>&1');                
                $salida = str_replace('notBefore=', '', $salida);            
                $info_preg =$salida;
                $info_preg=(explode('/', $salida));
                if(!empty($info_preg)){
                    $this->_estableceError(1, null, array('name' => $info_preg[2], 'rfc' => $info_preg[4], 'ou' => $info_preg[8] ));
                    return $this->_return;
                }else {
                    $this->_estableceError(0, 'No se logro validar el certificado');
                    return $this->_return;
                }
            }else {
                $this->_estableceError(0, 'El archivo requerido no esta disponible');
                return $this->_return;
            }
        }



        function pareja($nombreCerPem, $nombreKeyPem){	
		
            if (file_exists($nombreCerPem) && file_exists($nombreKeyPem)){
                $salidaCer = shell_exec('openssl x509 -noout -modulus -in '.$nombreCerPem.' 2>&1');
                $salidaKey = shell_exec('openssl rsa -noout -modulus -in '.$nombreKeyPem.' 2>&1');
                if($salidaCer == $salidaKey){
                    $this->_estableceError(1);
                    return $this->_return;
                }else {
                    $this->_estableceError(0, 'Los archivos no son pareja');
                    return $this->_return;
                }
            }else {
                $this->_estableceError(0, 'Al menos uno de los archivos requeridos no esta disponible');
                return $this->_return;
            }
        }
        
        
    }

    

    $Certificado = new Certificados();
    $KeyPem =  $Certificado->generaKeyPem('C:/xampp/htdocs/script/CSD_FRANCOCABANILLAS_CONSULTORES_SC_FCC080410C38_20171006_115739.key', 'FRANCO144B');
    $CerPem =  $Certificado->generaCerPem('C:/xampp/htdocs/script/00001000000407734879.cer');
    $pareja =  $Certificado->pareja('C:/xampp/htdocs/script/00001000000407734879.cer.pem','C:/xampp/htdocs/script/CSD_FRANCOCABANILLAS_CONSULTORES_SC_FCC080410C38_20171006_115739.key.pem');
    $Arreglofecha =  $Certificado->getFechaVigencia('C:/xampp/htdocs/script/00001000000407734879.cer');    
    $ArregloCertificado =  $Certificado->validarCertificado('C:/xampp/htdocs/script/00001000000407734879.cer');
    
    /*echo $ArregloCertificado['name'];
    echo $ArregloCertificado['rfc'];
    echo $ArregloCertificado['ou'];*/
    
    print_r ($pareja);

?>