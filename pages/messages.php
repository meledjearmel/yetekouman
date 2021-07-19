<?php

require_once '../functs/Const.php';
require_once FUNCTIONS;

start();

$user = auth();

if (isset($_SESSION['query'])) {
    $ref = sessionGet('query');
    $getUser = recupId($ref, $pdo);
}

if (isset($getUser) && $getUser) {
    $msg = exitsMsg($user->id, $getUser->id, $pdo);
} else {
    $msg = exitsMsg($user->id, -1, $pdo);
}

if ($msg === 1) {
?>
    <div class="msg-container-group">
        <?php
        $messages = recupMsg($user->id, $getUser->id, $pdo);
        foreach ($messages as $message) {
        ?>
            <div class="msg-container <?= ($user->id == $message->from) ? 'msg-content-from' : 'msg-content-to'; ?>">
                <div class="msg-content-pending">
                    <span><?= $message->content; ?></span>
                    <span class="msg-content-date">
                        <span><?= substr($message->time, 0, 5); ?></span>
                        <?php if($user->id == $message->from){
                            if ($message->read == 0) {
                                $readClass = 'msg-content-send';
                            } else {
                                $readClass = 'msg-content-read';
                            }
                            echo '&nbsp;<span class="'.$readClass.'"><i class="fa fa-check"></i><i class="fa fa-check"></i></span>';
                        } else {
                            echo '';
                        }
                     ?>
                    </span>
                </div>
            </div>
        <?php
        } ?>
    </div>
<?php
} else {
?>
    <h1 style="color: grey; width:100%;text-align:center;position:absolute;top:50%;transform:translate(0, -50%)">Aucun message</h1>
<?php
}
?>