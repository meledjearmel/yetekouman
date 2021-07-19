<?php


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functs' . DIRECTORY_SEPARATOR . 'Const.php';
require_once FUNCTIONS;

start();


if (!isset($_SESSION['auth'])) {
    header('Location: ../');
}

if (isset($_GET['atr'])) {
    $query = hget('atr');

    $id = recupArtId($query);

    if ($id) {
        delArticle($id, $pdo);
    }

    header('location: ../publications');
}