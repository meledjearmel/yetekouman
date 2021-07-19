<?php
require_once '../functs/Const.php';
require_once FUNCTIONS;

start();

$user = auth();

$notifs = msgNotify($user->id, $pdo);


?>



<a class="a-head-main" href="../messages"><i class="far fa-envelope"></i>&nbsp;<span>Messages</span>&nbsp;<?= ($notifs > 0) ? '<span class="counter">' . $notifs . '</span>' : ''; ?></a>