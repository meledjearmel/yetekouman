<?php

require_once '../functs/Const.php';
require_once FUNCTIONS;

start();

$user = auth();

if (isset($_SESSION['query'])) {
    $ref = sessionGet('query');
    $getUser = recupId($ref, $pdo);
}


$userConv = recupUserConvers($user->id, $pdo);
if ($userConv) {
    foreach ($userConv as $userC) {
        $notif = conversNotify($user->id, $userC->id, $pdo)

?>
        <a href="../functs/convers.php?query=<?php secureId($userC->id) ?>" class="msg-cts-bulles <?php if ($getUser && ($getUser->id == $userC->id)) {
                                                                                                        echo 'msg-cts-bulles-active';
                                                                                                    } else {
                                                                                                        echo '';
                                                                                                    } ?>">
            <div class="msg-cts-init">
                <span>
                    <h1><?= substr($userC->prenom, 0, 1); ?><?= substr($userC->nom, 0, 1); ?></h1>
                </span>
            </div>
            <div class="msg-all-infos">
                <div class="msg-cts-infos">
                    <div class="msg-cts-name">
                        <span><?= $userC->prenom ?>&nbsp;<?= $userC->nom ?></span>
                        <?=($notif > 0) ? '<span class="counter">'.$notif.'</span>' : '';?>
                    </div>
                    <?php
                    $convers = recupLastMsg($user->id, $userC->id, $pdo);
                    ?>
                    <div class="msg-cts-content">
                        <span><?= $convers->contenu ?></span>
                    </div>
                    <div class="msg-cts-time">
                        <span><?= substr($convers->heure, 0, 5); ?></span>
                    </div>
                </div>
                <div class="msg-cts-online">
                    <span class="<?= ($userC->line != 0) ? 'online' : 'offline'; ?>"></span>
                </div>
            </div>
            <span style="display: none" class="userId"><?= $userC->id ?></span>
            <form class="userGet" action="" method="get"></form>
        </a>
    <?php }
} else {
    ?>
    <h1 style="color: grey; width:100%;text-align:center;position:absolute;top:50%;transform:translate(0, -50%)">Aucun contact</h1>
<?php
}
