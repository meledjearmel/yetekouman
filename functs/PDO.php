<?php

    define('HOST', '127.0.0.1');
    define('DB', 'yetekouman');
    define('USER', 'root');
    define('PASS', 'Armel06743632@');

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ];

    try {
        $pdo = new PDO('mysql:host=' . HOST.';dbname='.DB, USER, PASS, $options);
    } catch (Exception $e) {
        die('Erreur');
    }


    
    
    

