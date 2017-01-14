<?php
    class logout
        {
            /*
             * Esta clase controla los eventos de cierre de la sesion de usuario
             * en el sistema.
             */
            public function securelogout()
                {
                    /*
                     * Esta funcion genera el evento de cierre seguro, garantizando
                     * que seran destruidos los datos del usuario almacenados en la
                     * cookie del navegador.
                     */
                    session_name('ecole');
                    session_start();
                    session_unset();
                    session_destroy();
                    }
            }

    $objLogout = new logout();
    $objLogout->securelogout();
?>