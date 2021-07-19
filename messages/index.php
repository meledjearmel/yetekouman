<?php $title = 'Messages';?>
<?php $style = '../css/messages.css';?>
<?php $javascript = '../js/messages.js';?>

<?php require_once '../pages/header.php';?>

<?php

    $isSend = null;

    if (!empty($_POST)) {
        $isSend = sendMsg($pdo);
    }

    if (isset($_SESSION['query'])) {
        $ref = sessionGet('query');
        $getUser = recupId($ref, $pdo);
        if(isset($getUser) && $getUser) {
            $named = $getUser->prenom . ' ' . $getUser->nom;
        } else {
            $named = 'Aucune conversation';
        }
    } else {
        $named = 'Aucune conversation';
    }

?>
    <div class="msg-box">

       <div style="position: relative" id="contacts" class="msg-contacts">

        <?php 
            $userConv = recupUserConvers($user->id, $pdo);
            if ($userConv) {
                foreach ($userConv as $userC) {
                    $notif = conversNotify($user->id, $userC->id, $pdo)

    ?>
                    <a href="../functs/convers.php?query=<?php secureId($userC->id)?>" class="msg-cts-bulles <?php if ($getUser && ($getUser->id == $userC->id)) {echo 'msg-cts-bulles-active';} else {echo '';}?>">
                        <div class="msg-cts-init">
                            <span>
                                <h1><?=substr($userC->prenom, 0, 1);?><?=substr($userC->nom, 0, 1);?></h1>
                            </span>
                        </div>
                        <div class="msg-all-infos">
                            <div class="msg-cts-infos">
                                <div class="msg-cts-name">
                                    <span><?=$userC->prenom?>&nbsp;<?=$userC->nom?></span>
                                    <?=($notif > 0) ? '<span class="counter">'.$notif.'</span>' : '';?>
                                </div>
                                <?php
$convers = recupLastMsg($user->id, $userC->id, $pdo);
    ?>
                                <div class="msg-cts-content">
                                    <span><?=$convers->contenu?></span>
                                </div>
                                <div class="msg-cts-time">
                                    <span><?=substr($convers->heure, 0, 5);?></span>
                                </div>
                            </div>
                            <div class="msg-cts-online">
                                <span class="<?=($userC->line != 0) ? 'online' : 'offline';?>"></span>
                            </div>
                            </div>
                            <span style="display: none" class="userId"><?=$userC->id?></span>
                            <form class="userGet" action="" method="get"></form>
                    </a>
<?php }

            } else {
                ?>
                <h1 style="color: grey; width:100%;text-align:center;position:absolute;top:50%;transform:translate(0, -50%)">Aucun contact</h1>
                <?php
            }?>
            
           
       </div>

       <div class="msg-conversations">
            <div class="msg-conv-head">
                
            <h1><?=$named?></h1>
            </div>
            <div id="messages" class="msg-conv-body">

              <?php
                    if(isset($getUser) && $getUser) {
                        $msg = exitsMsg($user->id, $getUser->id, $pdo);
                    } else {
                        $msg = exitsMsg($user->id, -1, $pdo);
                    }
                    
                    if ($msg === 1) {
                        ?>
                         <div class="msg-container-group">
                        <?php
                        $messages = recupMsg($user->id, $getUser->id, $pdo);
                        foreach($messages as $message){
                            ?>
                            <div class="msg-container <?=($user->id == $message->from) ? 'msg-content-from' : 'msg-content-to';?>">
                                <div class="msg-content-pending">
                                    <span><?=$message->content;?></span>
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

            </div>
            <div class="msg-conv-footer">
                <form id="msg-form" action="" method="post">
                    <input type="hidden" name="from" value="<?=$user->id?>">
                    <input type="hidden" name="to" value="<?=(isset($getUser) && $getUser) ? $getUser->id : ''?>">
                    <div class="msg-conv-area-text">
                        <textarea class="msg-conv-input" name="content" id="" cols="120" rows="10" placeholder="Ecrivez un message..."></textarea>
                        <?=($isSend != null) ? '<small class=\'errors-msg-msg\'>'.$isSend->message.'</small>' : '';?>
                        <button type="<?=(isset($getUser) && $getUser && $getUser->id != 0) ? 'submit' : 'button'?>" class="msg-btn-send">Envoyer&nbsp;&nbsp;<i class="fa fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
       </div>

    </div>
    <?php unset($_SESSION['errors']); ?>

<?php require_once '../pages/footer.php';?>