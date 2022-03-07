<?php
    $errormsg = '';
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);
    
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'MisMatch');
    define('DB_USER', 'root');
    define('DB_PASS', 'Timecill1970');
    
    require_once('DBConnection.php');
    $dbh = new DBConnection();
    $con = $dbh->getCon();
    
?>