<?php
    
    class login
        {
            /*
             * Esta clase contiene los atributos y procedimientos para la creacion
             * de la interfaz de login.
             */            
            public function __construct()
                {
                    //Declaracion de constructor (VACIO)
                    }
                    
            public function UILogin()
                {
                    /*
                     * Esta funcion crea la interfaz de usuario para el modulo de
                     * ingreso a la funcionalidad de sistema.
                     */
                    
                    $UILogin =  '<div id="logins" class= "login-div">
                                        <div id="login" class= "login">
                                            <h1 class="cabecera-login">.</h1>
                                            <div name = "login">
                                                <p><input id="usuario" required="required" type="text" value="" placeholder="Usuario o Email"/></p>
                                                <p><input id="clave" required="required" type="password" value="" placeholder="Contrase�a"/></p>
                                                <button id="ingresar" class="button-blue" onclick="validarUsuario(\'./php/backend/bl/main/cargador.class.php\',\'?usuario=\'+document.getElementById(\'usuario\').value.toString()+\'&clave=\'+document.getElementById(\'clave\').value.toString()+\'&modulo=\'+document.getElementById(\'Modulo\').value.toString()+\'&lreq=\'+document.getElementById(\'lreq\').value.toString(),\'escritorio\')"><img src="./img/login.png" width="35" height="35"/>Iniciar Sesion</button>
                                            </div>
                                            <div class="ayuda-login">
                                                <p>�Aun no tiene su cuenta?<a href= "./php/frontend/usraltas/opSolAltUsr.php" target= "_self">De click aqui para registrarse.</a>.</p>
                                                <p>�Olvido su contrase�a?<a href= "./php/frontend/usuarios/opRecordar.php" target= "_self">De click aqui para recuperarla.</a>.</p>
                                            </div>
                                        </div>
                                </div>';
            
                    return $UILogin;
                    }
            }
?>