<?php       

require_once '../functs/Const.php';
require_once FUNCTIONS;

start();

$user = auth();


            $suggests = getSuggest($user->type, $pdo);
            if ($suggests) {
                foreach ($suggests as $suggest) {
        ?>
            <div class="sugg-infos">
                <div class="sugg-letter sugg-element">
                    <i class="<?= ($suggest->lu == 0) ? 'fa' : 'far'; ?> fa-envelope"></i>
                </div>
                <div class="sugg-nom sugg-element">
                    <span><?=$suggest->id_from->prenom?>&nbsp;<?=$suggest->id_from->nom?></span>
                </div>
                <div class="sugg-objet sugg-element">
                    <span><?=$suggest->objet?></span>
                </div>
                <div class="sugg-corps sugg-element">
                    <span><?=$suggest->contenu?></span>
                </div>
                <div class="sugg-date sugg-element">
                    <span><?= dateWithSlash($suggest->date) ?>&nbsp;<?= substr($suggest->heure, 0, 5)?></span>
                </div>
            </div>
        <?php
                }
            }
        ?>