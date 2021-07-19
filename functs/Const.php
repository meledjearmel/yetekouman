<?php

define('ROOT', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
define('FUNCTIONS', ROOT . DS . 'functs' . DS . 'functions.php');
define('DataBase', ROOT . DS . 'functs' . DS . 'PDO.php');
// define('Day', ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']);
define('Month', ['Jan', 'Fev', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', "Dec"]);
define('SecureLogin', 'yetekouman');
define('SecurePass', '12345678');



function auth()
{
    return (object) $_SESSION['auth'];
}

function is_connectErrors()
{
    if(isset($_SESSION['errors']['connect'])){
        return true;
    }
    return false;
}

function is_inscriptErrors()
{
    if (isset($_SESSION['errors']['inscript'])) {
        return true;
    }
    return false;
}

function is_fieldErrors(string $field)
{
    if (isset($_SESSION['errors']['inscript'][$field])) {
    return true;
    }
    return false;
}

function errors()
{
    if (is_inscriptErrors()) {
        $data = (object) $_SESSION['errors']['inscript'];
    } else {
        $data = (object) $_SESSION['errors']['connect'];
    }
    return $data;
}

function datas()
{
    $data = (object) $_SESSION['errors']['datas'];
    return $data;
}
