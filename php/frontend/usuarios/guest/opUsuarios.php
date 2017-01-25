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

    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/bl/utilidades/codificador.class.php"); //Se carga la referencia de la clase para manejo de encriptado.
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/dal/conectividad.class.php"); //Se carga la referencia a la clase de conectividad.
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/config.php"); //Se carga la referencia de los atributos de configuracion.
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/bl/usuarios/usuarios.class.php"); //Se carga la referencia a la clase para manejo de la entidad usuarios.
    
    class opUsuarios
        {
            /*
             * Esta clase contiene los atributos y procedimientos para el despliegue
             * de la interfaz del modulo de edición de registro de usuarios.
             */
            private $cntView = 0;
            private $idUsuario = 0;
            private $ClaveCod = '';
            
            public function __construct()
                {
                    /*
                     * Esta funcion constructor obtiene y evalua los parametros proporcionados
                     * por medio de la URL.
                     */
                    if(isset($_GET['view'])){$this->cntView = $_GET['view'];}
                    if(isset($_GET['id'])){$this->idUsuario = $_GET['id'];}
                    }

            public function getView()
                {
                    /*
                     * Esta funcion retorna el valor obtenido del modo de visualizacion
                     */
                    return $this->cntView;
                    }

            public function getID()
                {
                    /*
                     * Esta funcion retorna el valor obtenido del ID de Usuario.
                     */
                    return $this->idUsuario;
                    }
                    
            public function captchaDraw()
                {
                    /*
                     * Esta funcion genera el codigo HTML que corresponde al
                     * captcha que se utiliza para evitar el spam.
                     */
                    $HTML = '   <div id="cnt-captcha" class="cnt-captcha">
                                    <br>
                                    <div id= "captcha-controll" class= "captcha-controll">
                                        <img id="captcha" align="middle" src="./php/frontend/utilidades/captcha/comp/captcha.php" alt="CAPTCHA Image" width="150px" height="60px"/>
                                    </div>                                
                                    <div id="captcha-refresh" class= "captcha-controll">
                                        <img id="rfrCaptcha" align="middle" src="./img/grids/refresh.png" width="35px" height="35px" title="Actualizar imagen"/>
                                    </div>
                                    <br>
                                    <br>
                                    <div id="captcha-text" style="display:block" align="center">
                                        <input type="text" id="captcha_code" name="captcha_code" size="10" maxlength="6" />
                                    </div>
                                </div>                                
                                ';
                    
                    return $HTML;
                    }                    
                    
            public function drawUI()
                {
                    /*
                     * Esta funcion crea el codigo HTML correspondiente a la interfaz de usuario.
                     */                    
                    
                    $objUsuarios = new usuarios();                    
                    
                    $objUsuarios->getNiveles();
                    $RegUsuario = $objUsuarios->getRegistro($this->getID());
                    
                    $objCodificador = new codificador();
                    
                    $this->ClaveCod = $objCodificador->decrypt($RegUsuario['Clave'],"ouroboros");
                    
                    if(!empty($RegUsuario['idUsuario']))
                        {
                            //CASO: VISUALIZACION DE REGISTRO PARA SU EDICION O BORRADO.
                            if($this->getView() == 1)
                                {
                                    //VISUALIZAR.
                                    $habCampos = 'disabled= "disabled"';
                                    }
                            else
                                {
                                    //CREACION O EDICION.
                                    $habCampos = '';
                                    }                                                                
                            }
                    else
                        {
                            //CASO: CREACION DE NUEVO REGISTRO.
                            $habCampos = '';
                            }                                               
                            
                    $HTMLBody = '   <div id="statsUser" style="display:none">
                                        <table>
                                            <tr><td>idUsuario: </td><td><input id="idUsuario" type="text" value="'.$RegUsuario['idUsuario'].'"></td></tr>
                                            <tr><td>Status: </td><td><input id="Status" type="text" value="'.$RegUsuario['Status'].'"></td></tr>
                                        </table>
                                    </div>
                                    <div id="infoUsuario" style= "width:400px; height:600px;">
                                        <table class="dgTable">
                                            <tr><th class="dgHeader" colspan= 2">Usuario en el Sistema</th></tr>
                                            <tr><td class="dgRowsaltTR" width="100px">Usuario:</td><td class="dgRowsnormTR"><input type= "text" id= "Usuario" required= "required" '.$habCampos.' value= "'.$RegUsuario['Usuario'].'"></td></tr>
                                            <tr><td class="dgRowsaltTR" width="100px">Clave:</td><td class="dgRowsnormTR"><input type= "text" required= "required" id= "Clave" '.$habCampos.' value= "'.$this->ClaveCod.'"></td></tr>
                                            <tr><td class="dgRowsaltTR" width="100px">Correo:</td><td class="dgRowsnormTR"><input type= "text" required= "required" id= "Correo" '.$habCampos.' value= "'.$RegUsuario['Correo'].'"></td></tr>
                                            <tr><td class="dgRowsaltTR" width="100px">Pregunta:</td><td class="dgRowsnormTR">'.$objUsuarios->cargarPreguntas($habCampos, $RegUsuario['Pregunta']).'</td></tr>
                                            <tr><td class="dgRowsaltTR">Respuesta: </td><td class="dgRowsnormTR"><input id= "Respuesta" type= "text" '.$habCampos.' value= "'.$RegUsuario['Respuesta'].'"></td></tr>
                                            <tr><td class="dgRowsaltTR" width="100px">Codigo de Verificacion</td><td class="dgRowsnormTR"><center>'.$this->captchaDraw().'</center></td></tr>                                                    
                                            <tr class="dgHeader" style="text-align:right"><td colspan= "2">'.$objUsuarios->controlBotones("32", "32", $this->getView()).'</td></tr>                                            
                                        </table>                                                                                                                                   
                                    </div>';
                    return $HTMLBody;                                                
                    }                    
            }

    $objOpUsuarios = new opUsuarios();
    

    $HTML = '   <html>
                    <head>
                    </head>
                    <body>
                        <center>'.
                            $objOpUsuarios->drawUI().
                        '</center>
                    </body>
                </html>';
                    
    echo $HTML;        
?>