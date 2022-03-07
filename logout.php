<?php

    $title = "Logout";
    require_once('header.php');
    
    // Destruimos la sesión
    unset($_SESSION);
    // Destruimos las variables de sesión
    session_destroy();
    session_unset();
    // Borramos la cookies de sesión si existen
    func::deleteCookies();
    // Redirigimos a index.php
    header('location:index.php');

?>