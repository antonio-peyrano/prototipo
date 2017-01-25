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
    class index
        {
            /*
             * Esta clase contiene los atributos y procedimientos para la creacion de la interfaz
             * principal del sistema.
             */            
            public function __construct()
                {
                    /*
                     * Declaracion de constructor de clase (VACIO)
                     */
                    }
                    
            public function headItem($id, $onClick, $imgURL, $caption)
                {
                    /*
                     * Esta funcion genera la linea HTML que corresponde a un elemento de la lista de
                     * menu en pantalla.
                     */
                    
                    $item='<li id="'.$id.'"><a href="#" class="desplegable" onclick="'.$onClick.'"><img onmouseover="bigImg(this)" onmouseout="normalImg(this)" src="'.$imgURL.'" width="35" height="35">'.$caption.'</a>';
                    
                    return $item;
                    }

            public function bodyItem($id, $onClick, $imgURL, $caption)
                {
                    /*
                     * Esta funcion genera la linea HTML que corresponde a un elemento de la lista de
                     * menu en pantalla.
                     */
                    
                     $item='<li id="'.$id.'"><a href="#" onclick="'.$onClick.'"><img onmouseover="bigImg(this)" onmouseout="normalImg(this)" src="'.$imgURL.'" width="35" height="35">'.$caption.'</a></li>';
                     
                     return $item;
                    }

            public function setProfile()
                {
                    /*
                     * Esta funcion retorna los datos del perfil del usuario para alimentar
                     * la interfaz, solo con fines visuales.
                     */
                    session_name('ecole');
                    session_start();
                    
                    if(isset($_SESSION['usuario']))
                        {
                            //Si se ha inicializado previamente una sesion.
                            $DIV = '<table class="profileUser">
                                        <tr><td>Bienvenido </td><td>'.$_SESSION['usuario'].'</td></tr>
                                    </table>';
                            }
                    else
                        {
                            //En caso contrario se carga un perfil vacio.
                            $DIV = '';
                            }
                    
                    return $DIV;
                    }
                                        
            private function drawMenu()
                {
                    /*
                     * Esta función dibuja el menu de operaciones de la interfaz principal.
                     */
                                             
                    $menuBody = '<div id="menu-lateral">
                                    <ul class="navegador">'.
                                        $this->headItem("item-cabecera-01", "", "./img/menu/config.png", "Parametros Generales").
                                        '<ul class="subnavegador">'
                                            .$this->bodyItem("item-cuerpo-01", "cargar('./php/backend/bl/main/cargador.class.php','?modulo=Usuarios&lreq=1','escritorio');", "./img/menu/usuarios.png", "Usuarios")                                            
                                            .$this->bodyItem("item-cuerpo-01", "cargar('./php/backend/bl/main/cargador.class.php','?modulo=Clientes&lreq=1','escritorio');", "./img/menu/clientes.png", "Clientes").
                                    '</ul></li></ul>'.
                                    '<ul class="navegador">'.
                                        $this->headItem("item-cabecera-01", "", "./img/menu/contacto.png", "Contacto").
                                        $this->headItem("item-cabecera-03", "validarUsuario('./php/backend/bl/main/logout.php','','escritorio');", "./img/menu/logout.png", "Cerrar Sesion").                                        
                                    '</ul>
                                    <br>
                                    <div id= "profile" class="infousuario">'
                                        .$this->setProfile().
                                    '</div>
                                </div>
                                ';
                         
                        return $menuBody;
                    }                    

            private function HTMLBody()
                {
                    /*
                     * Esta funcion contiene la informaci�n a incluir en el cuerpo del html.
                     */
                    $body = '<div id= "Contenedor" class= "contenedor">'.
                            $this->drawMenu()
                                .'<div class="contenedor-principal">
                                    <div class="area-deslizar"></div>
                                        <a href="#" data-toggle=".contenedor" id="menu-lateral-toggle">
                                            <span class="bar"></span>
                                            <span class="bar"></span>
                                            <span class="bar"></span>
                                        </a>
                                        <div id="escritorio" class="content">
                                        </div>
                                    </div>
                                </div>
                                <section class="contenedor-seccion">
                                </section>
                                <footer>
                                    <div id ="informacion">
                                    <b>Software desarrollado por Peyrano Computacion</b>
                                    </div>
                                </footer>
                                ';
                    return $body;
                    }                    

            private function HTMLHead()
                {
                    /*
                     * Esta funcion contiene la informaci�n a incluir en la cabecera del html.
                     */
                    $head = '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                            <link rel="stylesheet" href="./css/menuStyle.css"></style>
                            <link rel="stylesheet" href="./css/divLogin.css"></style>
                            <link rel="stylesheet" href="./css/jssor.css"></style>
                            <link rel="stylesheet" href="./css/queryStyle.css"></style>
                            <link rel="stylesheet" href="./css/dgstyle.css"></style>
                            <link rel="stylesheet" href="./css/notificaciones.css"></style>
                            <link rel="stylesheet" href="./css/captcha.css"></style>
                            <link rel="stylesheet" href="./css/bootstrap.min.css"/></style>                        
                            <link rel="icon" type="image/png" href="./img/icologo.png" />
                            <title>eCole</title>
                            <script type="text/javascript" src="./js/jquery/jquery-1.9.1.js"></script>
                            <script type="text/javascript" src="./js/jquery/jquery-1.9.1.min.js"></script>
                            <script type="text/javascript" src="./js/bootstrap/bootstrap.min.js" charset="ISO-8859-1"></script>
                            <script type="text/javascript" src="./js/bootstrap/bootbox.js" charset="ISO-8859-1"></script>
                            <script type="text/javascript" src="./js/bootstrap/bootbox.min.js" charset="ISO-8859-1"></script>                            
                            <script type="text/javascript" src="./js/main/jsindex.js" charset="ISO-8859-1"></script>
                            <script type="text/javascript" src="./js/main/jslogin.js" charset="ISO-8859-1"></script>
                            <script type="text/javascript" src="./js/usuarios/jsusuarios.js" charset="ISO-8859-1"></script>';
                    return $head;
                    }                    

            public function drawUI()
                {
                    /*
                     * Esta funcion dibuja los elementos en pantalla que corresponden a la interfaz.
                     */
                    $HTML = '<html lang="es-Es" xmlns="http://www.w3.org/1999/xhtml">
                                <head>'.
                                    $this->HTMLHead()
                                .'</head>
                                <body>'.
                                    $this->HTMLBody()
                                    .'<script type="text/javascript">
                                        document.oncontextmenu = function(){return true;}
                                    </script>
                                </body>
                            </html>';
                    return $HTML;
                    }                    
            }
?>