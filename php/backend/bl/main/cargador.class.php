<?php
    header('Content-Type: text/html; charset=ISO-8859-1'); //Forzar la codificación a ISO-8859-1.
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/bl/codificador.class.php");
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/dal/conectividad.class.php"); //Se carga la referencia a la clase de conectividad.
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/config.php"); //Se carga la referencia de los atributos de configuraci�n.
    
    class cargador
        {
            private $Modulo = '';
            private $lreq = '';
            private $idUsuario = 0;
            private $Usuario = '';
            private $Clave = '';
                                    
            public function __construct()
                {
                    /*
                     * Este constructor solo valida que la informacion obtenida por el metodo GET
                     * sea valida para la ejecucion del codigo.
                     */
                    if(isset($_GET['modulo'])){$this->Modulo = $_GET['modulo'];}                            
                    if(isset($_GET['lreq'])){$this->lreq = $_GET['lreq'];}                            
                    if(isset($_GET['usuario'])){$this->Usuario = $_GET['usuario'];}
                    if(isset($_GET['clave'])){$this->Clave = $_GET['clave'];}                            
                    }
            
            public function setCredenciales($idUsuario, $Usuario, $Nivel, $Clave)
                {
                    /*
                     * Esta funcion obtiene las credenciales del usuario (ID, Nombre, Nivel)
                     * y transfiere a las variables de control de sesion.
                     */
                    if(!isset($_SESSION))
                        {
                            //En caso de no existir el array de variables, se infiere que la sesion no fue iniciada.
                            session_name('ecole');
                            session_start();
                            }                    
                             
                    $_SESSION['idusuario'] = $idUsuario;
                    $_SESSION['usuario'] = $Usuario;
                    $_SESSION['nivel'] = $Nivel;
                    $_SESSION['clave'] = $Clave;
                    
                    }

            public function getCredenciales()
                {
                    /*
                     * Esta funcion obtiene las credenciales del usuario (ID, Nombre, Nivel)
                     * y envia el valor de permiso concedido.
                     */
                    if(!isset($_SESSION))
                        {
                            //En caso de no existir el array de variables, se infiere que la sesion no fue iniciada.
                            session_name('ecole');
                            session_start();
                            } 
                    
                    if(isset($_SESSION['idusuario'])&&isset($_SESSION['usuario'])&&isset($_SESSION['nivel'])&&isset($_SESSION['clave']))
                        {
                            return true; //Se asigna el valor de confirmacion de permiso.
                            }
                            
                    return false; //Si fallo la verificacion, se indica la denegacion de permiso.                            
                    }
                                        
            public function getModulo()
                {
                    //Esta funcion retorna el nombre del modulo almacenado.
                    return $this->Modulo;
                    }

            public function getlreq()
                {
                    //Esta funcion retorna el valor de control sobre requerimiento de login.
                    return $this->lreq;
                    }

            public function getURLModulo($Modulo)
                {
                    /*
                     * Esta funcion obtiene la URL del modulo para redireccionar en la carga
                     * de la pagina
                     */
                    global $username, $password, $servername, $dbname;
                                        
                    $conexion = new mySQL_conexion($username, $password, $servername, $dbname);
                    
                    $consulta = 'SELECT *FROM catModulos WHERE Modulo="'.$Modulo.'" AND Status=0';
                    $dsModulos = $conexion->conectar($consulta);
                    $drModulos = @mysql_fetch_array($dsModulos,MYSQL_ASSOC);

                    if($drModulos)
                        {
                            /*
                             * Al localizarse el registro correspondiente, se envia la URL
                             * al manejador del constructor de la UI.
                             */                            
                            return $drModulos['URL'];
                            }
                    
                    return ''; //En caso contrario se envia el valor de fallo.
                    }
                                        
            public function getidUsuario($Usuario, $Clave)
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
                            $this->setCredenciales($drUsuarios['idUsuario'], $drUsuarios['Usuario'], $drUsuarios['Nivel'], $Clave);  
                            return $drUsuarios['idUsuario'];
                            }
                    
                    return 0; //En caso contrario se envia el valor de fallo.                    
                    }
                    
            public function validarCredenciales($idUsuario, $Modulo)
                {
                    /*
                     * Esta funcion valida que el usuario tenga permisos sobre el modulo
                     * al que se estan validando las credenciales de uso. Si existe se
                     * retorna la URL almacenada. En caso contrario se envia cadena
                     * vacia.
                     */
                    global $username, $password, $servername, $dbname;
                    
                    $conexion = new mySQL_conexion($username, $password, $servername, $dbname);
                    $consulta = 'SELECT *FROM (opRelPerUsr INNER JOIN catModulos ON opRelPerUsr.idModulo = catModulos.idModulo) WHERE idUsuario="'.$idUsuario.'" AND Modulo="'.$Modulo.'" AND opRelPerUsr.Status=0';
                    $dsPermisos = $conexion->conectar($consulta);
                    $drPermisos = @mysql_fetch_array($dsPermisos,MYSQL_ASSOC);
                    
                    if($drPermisos)
                        {
                            /*
                             * Al localizarse el registro correspondiente, se envia la URL
                             * al manejador del constructor de la UI.
                             */
                            return $drPermisos['URL'];
                            }
                            
                    return ''; //En caso contrario se envia el valor de fallo.                            
                    }

            public function UIResponse()
                {
                    /*
                     * Esta funcion crea el contenido de la interfaz de usuario pasada la verificacion.
                     */
                    if($this->lreq == '1')
                        {
                            /*
                             * Si el modulo requiere de una validacion de ingreso por medio de usuario
                             * y clave, se generan los controles de UILogin.
                             */
                            if($this->getCredenciales())
                                {
                                    /*
                                     * Si el usuario ha validado preaviamente su existencia en el sistema,
                                     * sus credenciales son llamadas para validar su operacion.
                                     */
                                    $this->idUsuario = $this->getidUsuario($_SESSION['usuario'], $_SESSION['clave']);
                                    }
                             else
                                {
                                    /*
                                     * Si el usuario no cuenta aun con credenciales, se procede a la carga
                                     * de estas en sistema.
                                     */                                    
                                    $this->idUsuario = $this->getidUsuario($this->Usuario, $this->Clave);
                                    }                                   
                            
                            if($this->idUsuario != 0)
                                {
                                    /*
                                     * Si se ha localizado un usuario con los datos proporcionados por la interfaz
                                     * de login, se procede a la validacion de credenciales sobre el modulo.
                                     */
                                    $URL = $this->validarCredenciales($this->idUsuario, $this->Modulo); //Se obtiene la URL del modulo en el servidor.
                                    
                                    if($URL == '')
                                        {
                                            /*
                                             * Si la validacion de credenciales no arroja una URL valida para la carga del modulo,
                                             * se notifica al usuario que no esta autorizado.
                                             */
                                            include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/frontend/notificaciones/noAutorizado.php");
                                            }
                                    else
                                        {
                                            
                                            /*
                                             * En caso contrario, se redirecciona a la URL obtenida.
                                             */                                            
                                            include_once ($_SERVER['DOCUMENT_ROOT'].$URL);
                                            }                                            
                                    }
                            else
                                {
                                    /*
                                     * Si los datos proporcionados por el usuario no arrojan un ID,
                                     * se invoca de nuevo el formulario de inicio de sesion.
                                     */
                                    
                                    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/frontend/main/login.php");
                                    }                            
                            }
                    else
                        {
                            /*
                             * En caso que se solicite un ingreso a modulo sin validacion,
                             * se carga la interfaz sin login.
                             */
                            $URL = $this->getURLModulo($this->Modulo);
                            
                            if($URL == '')
                                {
                                    /*
                                     * En caso de no contar con una URL valida, se redirecciona a una pagina de ERROR 404
                                     */
                                    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/frontend/notificaciones/noAutorizado.php");
                                    }
                            else
                                {
                                    /*
                                     * En caso contrario, se envia al modulo indicado.
                                     */
                                    include_once ($_SERVER['DOCUMENT_ROOT'].$URL);
                                    }                                    
                            }                            
                    }                    
            }

    $cargador = new cargador();
            
    echo    '<html>
                <head>
                    <div id="infogen" style="display:none;">
                        <input id="Modulo" type="text" value="'.$cargador->getModulo().'">
                        <input id="lreq" type="text" value="'.$cargador->getlreq().'">
                    </div>
                </head>
                <body>';
            
                $cargador->UIResponse();
            
    echo        '</body>
            </html>';            
?>