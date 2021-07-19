<?php       

require_once '../functs/Const.php';
require_once FUNCTIONS;

start();
            
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
                