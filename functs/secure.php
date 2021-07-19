<?php


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functs' . DIRECTORY_SEPARATOR . 'Const.php';
require_once FUNCTIONS;

start();


if (!isset($_SESSION['adminer'])) {
    header('Location: ../settings');
}
   
$task = hget('task');
$hash = hget('id');

$id = recupArtId($hash);

if ($id) {
    $req = $pdo->prepare('UPDATE utilisateurs SET `type` = ? WHERE id = ?');
    $req->execute([$task, $id]);
}

header('Location: ../settings');

?>
