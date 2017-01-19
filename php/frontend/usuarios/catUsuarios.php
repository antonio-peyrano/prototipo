<?php
/*
 * Prototipo v1.0.0 Software base para desarrollo de sistemas.
 * PHP v5
 * Autor: Prof. Jesus Antonio Peyrano Luna <antonio.peyrano@live.com.mx>
 * Nota aclaratoria: Este programa se distribuye bajo los terminos y disposiciones
 * definidos en la GPL v3.0, debidamente incluidos en el repositorio original.
 * Cualquier copia y/o redistribucion del presente, debe hacerse con una copia
 * adjunta de la licencia en todo momento.
 * Licencia: http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
    header('Content-Type: text/html; charset=ISO-8859-1'); //Forzar la codificación a ISO-8859-1.
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/bl/codificador.class.php");
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/dal/conectividad.class.php"); //Se carga la referencia a la clase de conectividad.
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/config.php"); //Se carga la referencia de los atributos de configuracion.
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/dal/grid.class.php");
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/bl/usuarios/usuarios.class.php");
    
    class catUsuarios
        {
            /*
             * Esta clase contiene los atributos y procedimientos para la creacion de la interfaz
             * del catalogo de usuarios.
             */
           
            private $Usuario = "";
            private $Correo = "";
            
            public function __construct()
                {
                    /*
                     * Esta funcion constructor, valida los datos recibidos por medio
                     * de la URL.
                     */
                    if(isset($_GET['bususuario']))
                        {
                            $this->Usuario = $_GET['bususuario'];
                            }
                            
                    if(isset($_GET['buscorreo']))
                        {
                            $this->Correo = $_GET['buscorreo']; 
                            }                            
                    }

            public function drawUI()
                {
                    /*
                     * Esta funcion crea el codigo HTML de la interfaz grafica
                     * del catalogo de usuarios.
                     */
                    global $username, $password, $servername, $dbname;
                    
                    $objConexion = new mySQL_conexion($username, $password, $servername, $dbname);
                    $objUsuarios = new usuarios();

                    $objUsuarios->setCatParametros($this->Usuario, $this->Correo);                    
                    $Consulta = $objUsuarios->getConsulta().$objUsuarios->evaluaCondicion();

                    $dsUsuarios = $objConexion -> conectar($Consulta); //Se ejecuta la consulta.
                    $objGridUsuarios = new myGrid($dsUsuarios, 'Catalogo de Usuarios', $objUsuarios->getSufijo(), 'idUsuario');

                    echo'
                            <html>
                                <head>
                                </head>
                                <body>';
                    
                                    echo $objGridUsuarios->headerTable();
                                    echo $objGridUsuarios->bodyTable();
                    
                    echo'
                                </body>
                            </html>';                    
                    }                    
            }
            
    $objCatUsuarios = new catUsuarios();
    $objCatUsuarios->drawUI();            
?>