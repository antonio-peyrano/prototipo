<?php
    header('Content-Type: text/html; charset=ISO-8859-1'); //Forzar la codificación a UTF-8.
    include_once($_SERVER['DOCUMENT_ROOT']."/ecole/php/backend/bl/main/index.class.php"); //Se carga el archivo de clase.
    
    $index = new index(); //Se crea la instancia de objeto index.
    echo $index->drawUI(); //Se ejecuta la funcion para visualizar la UI.
?>