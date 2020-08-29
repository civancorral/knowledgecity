<?php
// Para mostrar los Errores
error_reporting(E_ALL);
 
// Zona Horaria por Default
date_default_timezone_set('America/Mazatlan');
 
// variables used for jwt
$key = "ciic1221";
$iss = "http://localhost/knowledgecity/";
$aud = "http://localhost/knowledgecity/";
$iat = 1598508369;
$nbf = 1357000000;
?>