<?php

$title = 'Accueil';
$style = '../css/dashboard.css';
$javascript = '../js/dashboard.js'

?>

<?php
require_once "../pages/header.php";
?>

<?php 
    if (!empty($_POST)) {
        $error = sendSuggest($pdo);
    }
?>

    <div class="dash-body">

        <div class="dash-slide-board">
            <div class="dash-user-dash">
                <div class="dash-user-ident">
                    <div class="dash-circle-init" title="Yeo Gregoire Christian Lomo (+225) 87614613">
                        <span class="dash-init"><?=substr($user->prenom, 0, 1);?><?=substr($user->nom, 0, 1);?></span>
                    </div>
                    <div class="dash-user-inf">
                        <div class="dash-user-name"><?=$user->nom?></div>
                        <div class="dash-user-name"><?=$user->prenom?></div>
                        <div class="dash-user-contact"><i class="fa fa-phone"></i>&nbsp;&nbsp;(+225)&nbsp;<span><?=$user->contact?></span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dash-page-content">

            <div class="dash-aside-members"></div>

            <div id="dash-content" class="dash-section-main">
                
            <?php
                $articles = getArticles($pdo);
                if ($articles) {
                    foreach ($articles as $article) {
            ?>
                <div class="dash-main-card-info">
                    <div class="dash-main-card-head">
                        <div class="dash-main-circle-init">
                            <span class="dash-main-init">A</span>
                        </div>
                        <div class="dash-main-name">
                            <span><?= $article->source ?></span>
                        </div>
                        <div class="dash-main-hour">
                            <span><?= dateWithSlash($article->date); ?> <?= substr($article->heure, 0, 5)?></span>
                        </div>
                    </div>
                    <div class="dash-main-card-body">
                        <div>
                            <?= $article->contenu ?>
                        </div>
                    </div>
                </div>

            <?php
                    }
                }
            ?>
                
            </div>

            <div class="dash-aside-members">
                <span class="dash-member-title">LISTE DES MEMBRES</span>

                <?php $allUsers = selectAllUsers($pdo); ?>
					<?php if ($allUsers) { ?>
						<?php foreach ($allUsers as $users) { 
							if($users->id == $user->id){
								continue;
                            }?>
                            <div class="dash-member-card">
                                <div>
                                    <div class="dash-card-circle-init" title="Yeo Gregoire Christian Lomo (+225) 87614613">
                                    <span class="dash-card-init"><?=substr($users->prenom, 0, 1);?><?=substr($users->nom, 0, 1);?></span>
                                </div>
                                <div class="dash-member-inf">
                                    <div class="dash-member-name"><?=$users->prenom?>&nbsp;<?=$users->nom?></div>
                                    <div class="dash-member-contact">
                                        <div class="dash-send-msg"><i class="fa fa-envelope"></i></div>
                                        <div class="dash-view-contact"><i class="fa fa-phone"></i></div>
                                    </div>
                                </div>
                                </div>
                                <div class="dash-card-info-send dash-dnone">
                                    <div class="dash-member-contact-view dash-dnone">
                                        <span>(+225)&nbsp;<?=$users->contact?></span>
                                    </div>
                                    <div class="dash-member-msg-send dash-dnone">
                                        <form action="../functs/sendDashmsg.php" method="post">
                                            <input type="text" name="content" placeholder="Ecrivez votre message..." autofocus>
                                            <input type="hidden" name="from" value="<?=$user->id?>">
                                            <input type="hidden" name="to" value="<?=$users->id?>">
                                            <button type="submit"><i class="fa fa-paper-plane"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
				<?php }
					} ?>

            </div>

        </div>

    </div>

    <div class="dash-footer">
        <div class="dash-footer-content">
            <div class="dash-hlink">
                <ul>
                    <a href="../">
                        <li><i class="fa fa-home"></i>&nbsp;<span>Acceuil</span></li>
                    </a>
                    <a href="../messages">
                        <li><i class="far fa-envelope"></i>&nbsp;<span>Messages</span></li>
                    </a>
                    <?= ($user->type == 1 || $user->type == 2) ? '<a href="../suggestions"><li><i class="fa fa-archive"></i>&nbsp;<span>Suggestions</span></li></a>' : '' ?>
                    <?= ($user->type == 1) ? '<a href="../publications"><li><i class="fa fa-edit"></i>&nbsp;<span>Publications</span></li></a>' : '' ?>
                    <a href="">
                        <li id="dash-footer-disc"><i class="fa fa-power-off"></i>&nbsp;<span>Se deconnecter</span></li>
                    </a>
                </ul>
            </div>
            <div class="dash-sugg">
                <form id="dash-form" action="" method="post">
                    <div class="dash-form-sugg">
                        <div class="dash-form-textarea">
                            <textarea class="dash-input" name="content" cols="30" rows="10" placeholder="Suggerer quelque chose au delegue ou aux developpeurs"></textarea>
                        </div>
                        <div class="dash-form-submit">
                            <div class="dash-selected">
                                <select name="to" id="" class="dash-form-select">
                                    <option value="0">Au delegue</option>
                                    <option value="1">Aux developpeurs</option>
                                </select>
                                <input type="hidden" name="from" value="<?=$user->id?>">
                                <i class="fa fa-caret-down"></i>
                            </div>
                            <button>Suggerer&nbsp;<i class="fa fa-paper-plane"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="dash-footer-copy">
            <span>Tout droit reserve yetekouman.com &copy; 2020</span>
        </div>
    </div>

<?php
require_once "../pages/footer.php";
unset($_SESSION['query']);
?>