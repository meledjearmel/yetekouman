<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functs' . DIRECTORY_SEPARATOR . 'Const.php';
require_once FUNCTIONS;

start();

if (!isset($_SESSION['auth'])) {
    header('Location: ../');
}
   

if (isset($_GET['query'])) {
    $_SESSION['query'] = hget('query');
}

if (isset($_SESSION['query'])) {
    $user = auth();
    $ref = sessionGet('query');
    $getUser = recupId($ref, $pdo);
    $lastMsg = recupLastMsg($user->id, $getUser->id, $pdo);
    if (!empty($lastMsg)) {
        readNotify($user->id, $getUser->id, $pdo);
    }
}

header('Location: ../messages');


?>
