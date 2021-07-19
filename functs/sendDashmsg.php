

<?php 

    require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'functs'.DIRECTORY_SEPARATOR.'Const.php';

    require_once FUNCTIONS;

    $isSend = null;

    if (!empty($_POST)) {
        $isSend = sendMsg($pdo);
        header('location: ../dashboard');
    }
?>