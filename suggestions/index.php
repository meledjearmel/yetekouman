<?php $title = 'Suggestions News';?>
<?php $style = '../css/suggests.css';?>
<?php $javascript = '../js/suggests.js';?>

<?php require_once '../pages/header.php';?>

<?php homeRedirect($user->type) ?>

    <section id="sugg-msg-page" class="sugg-msg-page sugg-dnone">

        <div class="sugg-msg-bloc">

            <div class="sugg-msg-view">

                <div class="sugg-view-head">
                    <div class="sugg-head-named">
                        <div class="sugg-named-init">
                            <span></span>
                        </div>
                        <span class="sugg-named-name"></span>
                    </div>
                    <span id="sugg-msg-close" class="sugg-head-closed"><i title="Fermer la boite" class="far fa-window-close"></i></span>
                </div>

                <div class="sugg-view-body">
                    <div class="sugg-body-obj-date">
                        <div class="sugg-body-obj">
                            <span class="sugg-obj-title">Objet:&nbsp;</span>
                            <span class="sugg-obj-content"></span>
                        </div>
                        <span class="sugg-date sugg-body-date"></span>
                    </div>
                    <div class="sugg-body-content">
                        <span></span>
                    </div>
                </div>

               <!-- <div class="sugg-answered">
                    <span id="answer">Repondre</span>
                </div> -->
                
            </div>

        </div>

    </section>

    <section class="sugg-bloc-page">

        <div id="suggest" class="sugg-champ">
        <?php
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
        </div>

    </section>

<?php require_once '../pages/footer.php'; unset($_SESSION['query']);?>