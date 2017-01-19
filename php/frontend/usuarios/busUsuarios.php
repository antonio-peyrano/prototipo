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
                                    <tr><td class= "queryRowsnormTR">Por correo electrónico o parcial: </td><td class= "queryRowsnormTR"><input type= "text" id= "buscorreo"></td><td></td></tr>
                                </table>
                            </div>';
                    
                    return $HTML;
                    }                    
            }
                

    $objBusUsuarios = new busUsuarios();

    echo '  <html>
                <center>'.$objBusUsuarios->drawUI().'</center><br>';

    echo '      <div id= "busRes">';
                    include_once("catUsuarios.php");
    echo '      </div>
            </html>';
?>