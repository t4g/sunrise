<?php

$autoloader = 'composed/autoload.php';

if ( !class_exists( '\Sunrise' ) ) {

    if(!is_file($autoloader)) die("Error: This project hasn't been composed yet.");
    $loader = require $autoloader;

}