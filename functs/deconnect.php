<?php
require_once 'Const.php';
require_once DataBase;
require_once FUNCTIONS;

start();

if (!isset($_SESSION['auth'])) {
    header('Location: ../');
}

$user = auth();

offline($user->id, $pdo);

unset($_SESSION['auth']);
unset($_SESSION['query']);

header('Location: ../');
