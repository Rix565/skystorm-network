<?php
    session_start();
    define("HOST","localhost");
    define("DB_NAME","mysite");
    define("USER", "dbuser");
    define("PASS","cayenne56"); 

    try {
        $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME , USER, PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error ! " . $e->getMessage());
        exit;
    }
?>
