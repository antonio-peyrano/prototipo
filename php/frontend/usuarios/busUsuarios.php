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
    header('Content-Type: text/html; charset=ISO-8859-1'); //Forzar la codificaci�n a ISO-8859-1.
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/bl/usuarios/usuarios.class.php");
    
    class busUsuarios
        {
            private $Sufijo = "usr_";
            
            public function __construct()
                {
                    //Declaracion de constructor de clase (VACIO)
                    }
                    
            public function drawUI()
                {
                    $HTML = '<div id= "divBusqueda">
                                <table class="queryTable" colspan= "7">
                                    <tr><td class= "queryRowsnormTR" width ="180">Por nombre de usuario completo o parcial: </td><td class= "queryRowsnormTR" width= "250"><input type= "text" id= "bususuario"></td><td rowspan= "2"><img id="'.$this->Sufijo.'buscar" align= "left" src= "./img/grids/view.png" width= "25" height= "25" alt="Buscar"/></td></tr>
                                    <tr><td class= "queryRowsnormTR">Por correo electr�nico o parcial: </td><td class= "queryRowsnormTR"><input type= "text" id= "buscorreo"></td><td></td></tr>
                                </table>
                            </div>';
                    
                    return $HTML;
                    }                    
            }
                

    $objUsrCtrl = new usrctrl();
            
    if($objUsrCtrl->getCredenciales())
        {
            /*
             * Se valida que el usuario tenga sus credenciales cargadas
             * previo login en el sistema.
             */
            $idUsuario = $objUsrCtrl->getidUsuario($_SESSION['usuario'], $_SESSION['clave']);
            $Modulo = 'Usuarios';
            
            if($objUsrCtrl->validarCredenciales($idUsuario, $Modulo)!='')
                {
                    /*
                     * Se valida que las credenciales autoricen la ejecucion del
                     * modulo solicitado.
                     */
                    $objBusUsuarios = new busUsuarios();

                    echo '  <html>
                                <center>'.$objBusUsuarios->drawUI().'</center><br>';

                    echo '      <div id= "busRes">';
                                    include_once("catUsuarios.php");
                    echo '      </div>
                            </html>';
                    }
            else 
                {
                    /*
                     * En caso que no cuente con credenciales validas, el sistema impedira
                     * la brecha de seguridad.
                     */
                    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/frontend/notificaciones/noAutorizado.php");                    
                    }
            }
    else
        {
            /*
             * En caso que no cuente con credenciales validas, el sistema impedira
             * la brecha de seguridad.
             */
            include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/frontend/notificaciones/noAutorizado.php");
            }                        
?>