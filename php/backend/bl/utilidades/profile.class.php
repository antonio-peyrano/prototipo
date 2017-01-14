<?php
    header('Content-Type: text/html; charset=ISO-8859-1'); //Forzar la codificación a ISO-8859-1.
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/bl/codificador.class.php");
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/dal/conectividad.class.php"); //Se carga la referencia a la clase de conectividad.
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/config.php"); //Se carga la referencia de los atributos de configuraci�n.
    
    class profile
        {
            private $idUsuario="";
            private $Usuario = "";
            private $Clave = "";
            private $Nivel = "";
            
            public function __construct()
                {
                    if(isset($_GET['usuario'])){$this->Usuario=$_GET['usuario'];}
                    if(isset($_GET['clave'])){$this->Clave=$_GET['clave'];}
                    }
                    
            public function getProfile($Usuario, $Clave)
                {
                    /*
                     * Esta funcion valida los datos proporcionados por medio del formulario
                     * de ingreso, en caso de localizarse un usuario valido, se retorna su ID.
                     */
                    global $username, $password, $servername, $dbname;
                    
                    $objCodificador = new codificador();
                    $conexion = new mySQL_conexion($username, $password, $servername, $dbname);
                    
                    $consulta = 'SELECT *FROM (catUsuarios INNER JOIN catNiveles ON catUsuarios.idNivel = catNiveles.idNivel) WHERE Usuario="'.$Usuario.'" AND Clave="'.$objCodificador->encrypt($Clave, "ouroboros").'" AND catUsuarios.Status=0';
                    $dsUsuarios = $conexion->conectar($consulta);
                    $drUsuarios = @mysql_fetch_array($dsUsuarios,MYSQL_ASSOC);
                    
                    if($drUsuarios)
                        {
                            /*
                             * Al localizarse el registro correspondiente, se envia la URL
                             * al manejador del constructor de la UI.
                             */
                            $this->setidUsuario($drUsuarios['idUsuario']);
                            $this->setNivel($drUsuarios['Nivel']);
                            return true;
                            }
                    
                    return false; //En caso contrario se envia el valor de fallo.                    
                    }
                                        
            public function getidUsuario()
                {
                    return $this->idUsuario;
                    }

            public function setidUsuario($idUsuario)
                {
                    $this->idUsuario = $idUsuario;
                    }
                    
            public function getUsuario()
                {
                    return $this->Usuario;
                    }

            public function setUsuario($Usuario)
                {
                    $this->Usuario = $Usuario;
                    }
                                        
            public function getClave()
                {
                    return $this->Clave;
                    }

            public function setClave($Clave)
                {
                    $this->Clave = $Clave;
                    }
                                        
            public function getNivel()
                {
                    return $this->Nivel;
                    }

            public function setNivel($Nivel)
                {
                    $this->Nivel = $Nivel;
                    }                    
                    
            public function drawUI()
                {
                    if($this->getProfile($this->getUsuario(),$this->getClave()))
                        {
                            $HTML =     '<table class="profileUser">
                                            <tr><td>Bienvendio </td><td>'.$this->getUsuario().'</td></tr>                                            
                                        </table>';                            
                            }
                    else
                        {
                            $HTML = '';                            
                            }
                    
                    return $HTML;
                    }
            }

    $objProfile = new profile();
    echo $objProfile->drawUI();            
?>