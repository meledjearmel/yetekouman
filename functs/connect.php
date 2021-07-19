<?php

    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functs' . DIRECTORY_SEPARATOR . 'Const.php';

    if (!empty($_POST)) {

        require_once FUNCTIONS;

        $login = get('login');
        $pass = get('pass');

        connect($login, $pass, $pdo);

    }
