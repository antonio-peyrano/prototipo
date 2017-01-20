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
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/bl/codificador.class.php");
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/dal/conectividad.class.php"); //Se carga la referencia a la clase de conectividad.
    include_once ($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/config.php"); //Se carga la referencia de los atributos de configuracion.
    
    class usuarios
        {
            /*
             * Esta clase contiene los atributos y procedimientos vinculados con el comportamiento
             * y funcionalidades de la interfaz del modulo de usuarios.
             */
            
            //ATRIBUTOS APLICABLES AL MODULO catUsuarios.php
            private $Condicionales = "";
            private $Sufijo = "usr_";
            private $Usuario = "";
            private $Correo = "";
            private $Consulta = "SELECT idUsuario, Nivel, Usuario, Clave, Correo, catUsuarios.Status FROM catUsuarios INNER JOIN catNiveles ON catNiveles.idNivel = catUsuarios.idNivel WHERE catUsuarios.Status=0";
            //FIN DE DECLARACION DE ATRIBUTOS APLICABLES AL MODULO catUsuarios.php
            
            //ATRIBUTOS APLICABLES AL MODULO opUsuarios.php
            private $idUsuario = 0;
            private $cntView = 0;
            private $claveCod = "";
            //FIN DE DECLARACION DE ATRIBUTOS APLICABLES AL MODULO opUsuarios.php
            
            public function __construct()
                {
                    //Declaracion de constructor (VACIO)
                    }

            //PROCEDIMIENTOS APLICABLES AL MODULO catUsuarios.php
            public function getUsuario()
                {
                    /*
                     * Esta funcion retorna el valor de nombre de usuario.
                     */
                    return $this->Usuario;
                    }

            public function getCorreo()
                {
                    /*
                     * Esta funcion retorna el valor de correo del usuario.
                     */
                    return $this->Correo;
                    }

            public function getConsulta()
                {
                    /*
                     * Esta funcion retorna el valor de la cadena de consulta.
                     */
                    return $this->Consulta;
                    }

            public function getSufijo()
                {
                    /*
                     * Esta funcion retorna el valor de sufijo para la interfaz.
                     */
                    return $this->Sufijo;
                    }
                                
            public function setCatParametros($Usuario, $Correo)
                {
                    /*
                     * Esta funcion obtiene de la interaccion del usuario, los parametros
                     * para establecer los criterios de busqueda.
                     */
                    $this->Usuario = $Usuario;
                    $this->Correo = $Correo;
                    }  

            public function evaluaCondicion()
                {
                    /*
                     * Esta funcion evalua si la condicion de busqueda cumple con las caracteristica
                     * solicitadas por el usuario.
                     */
                    $this->Condicionales = "";
                    
                    if(!empty($this->getUsuario()))
                        {
                            $this->Condicionales = ' AND Usuario LIKE \'%'.$this->getUsuario().'%\'';
                            }
                            
                    if(!empty($this->getCorreo()))
                        {                       
                            $this->Condicionales= $this->Condicionales.' AND Correo LIKE \'%'.$this->getCorreo().'%\'';
                            }

                    return $this->Condicionales;                            
                    }                    
            //FIN DE DECLARACION DE PROCEDIMIENTOS APLICABLES AL MODULO catUsuarios.php
            
            //PROCEDIMIENTOS APLICABLES AL MODULO opUsuarios.php
            public function getNiveles()
                {
                    /*
                     * Esta funcion obtiene la tupla de registros sobre el catalogo de niveles.
                     */
                    global $username, $password, $servername, $dbname;
                    
                    $objConexion= new mySQL_conexion($username, $password, $servername, $dbname); //Se crea el objeto de la clase a instanciar.
                    $Consulta= 'SELECT idNivel, Nivel FROM catNiveles WHERE Status=0'; //Se establece el modelo de consulta de datos.
                    $dsNiveles = $objConexion -> conectar($Consulta); //Se ejecuta la consulta.
                    return $dsNiveles;
                    }

            public function getRegistro($idRegistro)
                {
                    /*
                     * Esta funci�n obtiene el dataset del registro de usuario apartir del ID proporcionado.
                     */
                    global $username, $password, $servername, $dbname;
                    
                    $objConexion= new mySQL_conexion($username, $password, $servername, $dbname); //Se crea el objeto de la clase a instanciar.
                    $Consulta= 'SELECT idUsuario, catUsuarios.idNivel, Usuario, Clave, Correo, Pregunta, Respuesta, catUsuarios.Status FROM catUsuarios INNER JOIN catNiveles ON catNiveles.idNivel = catUsuarios.idNivel WHERE idUsuario='.$idRegistro; //Se establece el modelo de consulta de datos.
                    $dsUsuario = $objConexion -> conectar($Consulta); //Se ejecuta la consulta.
                    
                    $RegUsuario = @mysql_fetch_array($dsUsuario, MYSQL_ASSOC);//Llamada a la funcion de carga de registro de usuario.
                    return $RegUsuario;
                    }                    

            public function setOpParametros($idUsuario, $CntView)
                {
                    /*
                     * Esta funcion obtiene de la interaccion del usuario, los parametros
                     * para establecer los criterios de carga y gestion del registro.
                     */
                    $this->idUsuario = $idUsuario;
                    $this->CntView = $CntView;
                    }

            public function controlBotones($Width, $Height, $cntView)
                {
                    /*
                     * Esta funcion controla los botones que deberan verse en la pantalla deacuerdo con la accion solicitada por el
                     * usuario en la ventana previa.
                     * Si es una edicion, los botones borrar y guardar deben verse.
                     * Si es una creacion solo el boton guardar debe visualizarse.
                     */
                    
                    $botonera = '';
                    $btnVolver_V =    '<img align= "right" onmouseover="bigImg(this)" onmouseout="normalImg(this)" src= "./img/grids/volver.png" width= "'.$Width.'" height= "'.$Height.'" alt= "Volver" id="'.$this->Sufijo.'Volver" title= "Volver"/>';
                    $btnBorrar_V =    '<img align= "right" onmouseover="bigImg(this)" onmouseout="normalImg(this)" src= "./img/grids/erase.png" width= "'.$Width.'" height= "'.$Height.'" alt= "Borrar" id="'.$this->Sufijo.'Borrar" title= "Borrar"/>';
                    $btnGuardar_V =   '<img align= "right" class="btnConfirm" onmouseover="bigImg(this)" onmouseout="normalImg(this)" src= "./img/grids/save.png" width= "'.$Width.'" height= "'.$Height.'" alt= "Guardar" id="'.$this->Sufijo.'Guardar" title= "Guardar"/>';
                    $btnGuardar_H =   '<img align= "right" class="btnConfirm" onmouseover="bigImg(this)" onmouseout="normalImg(this)" src= "./img/grids/save.png" width= "'.$Width.'" height= "'.$Height.'" alt= "Guardar" id="'.$this->Sufijo.'Guardar" title= "Guardar" style="display:none;"/>';
                    $btnEditar_V =    '<img align= "right" onmouseover="bigImg(this)" onmouseout="normalImg(this)" src= "./img/grids/edit.png" width= "'.$Width.'" height= "'.$Height.'" alt= "Editar" id="'.$this->Sufijo.'Editar" title= "Editar"/>';
                        	
                    if(($cntView == 0)||($cntView == 2))
                        {
                            //CASO: CREACION O EDICION DE REGISTRO.
                            $botonera .= $btnGuardar_V.$btnVolver_V;
                            }
                    else
                        {
                            if($cntView == 1)
                                {
                                    //CASO: VISUALIZACION CON OPCION PARA EDICION O BORRADO.
                                    $botonera .= $btnEditar_V.$btnBorrar_V.$btnGuardar_H.$btnVolver_V;
                                    }
                            }
                            
                    return $botonera;
                    }                    
            
            public function cargarPreguntas($habCampos, $Pregunta)
                {
                    /*
                     * Esta funcion crea un combobox con las preguntas posibles que puede seleccionar el usuario,
                     * tomando en cuenta para la carga si el usuario ha seleccionado previamente una pregunta.
                     */
                    
                    $HTML = '<select id= "Pregunta" '.$habCampos.' >';
                        	
                    if("" == $Pregunta)
                        {
                            $HTML .= '<option value= "Seleccione" selected="selected">Seleccione</option>';
                            }
                    else
                        {
                            $HTML .= '<option value= "Seleccione">Seleccione</option>';
                            }
                    if("Su primera mascota" == $Pregunta)
                        {
                            $HTML .= '<option value= "Su primera mascota" selected="selected">Su primera mascota</option>';
                            }
                    else
                        {
                            $HTML .= '<option value= "Su primera mascota">Su primera mascota</option>';
                            }
                    if("Su comida favorita" == $Pregunta)
                        {
                            $HTML .= '<option value= "Su comida favorita" selected="selected">Su comida favorita</option>';
                            }
                    else
                        {
                            $HTML .= '<option value= "Su comida favorita">Su comida favorita</option>';
                            }
                    if("Su pasatiempo favorito" == $Pregunta)
                        {
                            $HTML .= '<option value= "Su pasatiempo favorito" selected="selected">Su pasatiempo favorito</option>';
                            }
                    else
                        {
                            $HTML .= '<option value= "Su pasatiempo favorito">Su pasatiempo favorito</option>';
                            }
                    if("Su pelicula favorita" == $Pregunta)
                        {
                            $HTML .= '<option value= "Su pelicula favorita" selected="selected">Su pelicula favorita</option>';
                            }
                    else
                        {
                            $HTML .= '<option value= "Su pelicula favorita">Su pelicula favorita</option>';
                            }
                        	
                    $HTML .= '</select>';
                        	
                    return $HTML;
                    }            
            //FIN DE DECLARACION DE PROCEDIMIENTOS APLICABLES AL MODULO opUsuarios.php
            
            //PROCEDIMIENTOS APLICABLES AL MODULO opPermisos.php
            public function getPermisos($idUsuario)
                {
                    /*
                     * Esta funcion obtiene la tupla de registros sobre los modulos asociados al usuario.
                     */
                    global $username, $password, $servername, $dbname;
                    
                    $objConexion = new mySQL_conexion($username, $password, $servername, $dbname); //Se crea el objeto de la clase a instanciar.
                    $Consulta = 'SELECT *FROM ((catModulos INNER JOIN opRelPerUsr ON opRelPerUsr.idModulo = catModulos.idModulo) INNER JOIN catUsuarios ON catUsuarios.idUsuario = opRelPerUsr.idUsuario) WHERE opRelPerUsr.Status=0 AND opRelPerUsr.idUsuario='.$idUsuario; //Se establece el modelo de consulta de datos.
                    $dsPerUsr = $objConexion -> conectar($Consulta); //Se ejecuta la consulta.
                    return $dsPerUsr;
                    }

            public function getModulos()
                {
                    /*
                     * Esta funcion obtiene la tupla de registros sobre el catalogo de modulos.
                     */
                    global $username, $password, $servername, $dbname;
                    
                    $objConexion = new mySQL_conexion($username, $password, $servername, $dbname); //Se crea el objeto de la clase a instanciar.
                    $Consulta = 'SELECT *FROM catModulos WHERE Status=0'; //Se establece el modelo de consulta de datos.
                    $dsModulos = $objConexion -> conectar($Consulta); //Se ejecuta la consulta.
                    return $dsModulos;
                    }

            public function listaModulos($habCampos, $idUsuario)
                {
                    /*
                     * Esta funcion genera el codigo HTML que corresponde a los checkbox asociados a los
                     * modulos disponibles en sistema. Seleccionando aquellos que han sido previamente
                     * asociados al usuario.
                     */
                    global $username, $password, $servername, $dbname;
                    
                    $HTML = '';
                    
                    $objConexion = new mySQL_conexion($username, $password, $servername, $dbname); //Se crea el objeto de la clase a instanciar.
                    
                    $dsModulos = $this->getModulos();                    
                    $regModulos = @mysql_fetch_array($dsModulos, MYSQL_ASSOC);
                    
                    while($regModulos)
                        {
                            //MIENTRAS EXISTAN MODULOS POR VERIFICAR.
                            $dsPermisos = $this->getPermisos($idUsuario);
                            $regPermisos = @mysql_fetch_array($dsPermisos, MYSQL_ASSOC);
                            
                            $checkState = '';
                                                        
                            while($regPermisos)
                                {
                                    //MIENTRAS EXISTAN PERMISOS POR VERIFICAR.
                                    if($regModulos['idModulo'] == $regPermisos['idModulo'])
                                        {
                                            //AL ENCONTRAR COINCIDENCIA, SE MARCA EN LA LISTA.
                                            $checkState = 'checked';
                                            }                                            
                                    $regPermisos = @mysql_fetch_array($dsPermisos, MYSQL_ASSOC);
                                    }
                                    
                            $HTML .= '<input type="checkbox" class="check" id="modulos[]" name="modulos[]" '.$habCampos.' value="'.$regModulos['idModulo'].'" '.$checkState.'>'.$regModulos['Modulo'].' ';                                    
                            $regModulos = @mysql_fetch_array($dsModulos, MYSQL_ASSOC);
                            }
                    return $HTML;
                    }                    
            //FIN DE DECLARACION DE PROCEDIMIENTOS APLICABLES AL MODULO opPermisos.php
            }
?>