<?php
    header('Content-Type: text/html; charset=ISO-8859-1'); //Forzar la codificación a ISO-8859-1.
    include_once($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/bl/main/login.class.php"); //Se carga el archivo de clase.

    $objLogin = new login();
    
    $HTMLBody =     '<html>
                        <head>
                        </head>
                        <body>'
                            .$objLogin->UILogin().
                        '</body>
                    </html>';
    
    echo $HTMLBody;    
?>