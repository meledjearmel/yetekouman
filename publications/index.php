<?php $title = 'Editer une information';?>
<?php $style = '../css/posts.css';?>
<?php $javascript = '../js/posts.js' ?>

<?php define('FROMS', [
	'Administration',
	'Algo Langage & BD',
	'Anglais',
	'Droit',
	'Economie',
	'Mathematiques Financiere',
	'Mathematiques Generale',
	'Merise',
	'Negociation & SE',
	'PHP & VB',
	'SRI / ACS',
	'TEEO',
	'Autres',
])?>

<?php require_once '../pages/header.php';?>
<?php homeRedirect($user->type) ?>
<?php
	if (!empty($_POST)) {
		createArticle($pdo);
	}
?>

	<section class="post-container">
		<div class="post-lasted">

		<?php
			$articles = getArticles($pdo);
			if ($articles) {
				foreach ($articles as $article) {
		?>
			<div class="post-card">
				<div class="post-card-container">
					<div class="post-card-head">
						<div class="post-card-type">
							<span><?= $article->source ?></span>
						</div>
						<div class="post-card-time">
							<span><?= dateHuman($article->date); ?> <?= substr($article->heure, 0, 5)?></span>
						</div>
					</div>
					<div class="post-card-content">
						<span><?= $article->contenu ?></span>
					</div>
				</div>
				<div class="post-card-action">
					<div>
						<span id="post-viewer" class="post-card-view" title="Voir l'article"><i class="fa fa-eye"></i></span>
					</div>
					<div>
						<a href="../functs/deleteArt.php?atr=<?php secureId($article->id)?>"><span id="post-delete" class="post-card-del" title="Supprimer l'article"><i class="fa fa-trash"></i></span></a>
					</div>
				</div>
			</div>
			<hr>

		<?php
				}
			}
		?>

		</div>
		<div class="post-new-edit">
			<form id="post-form" action="" method="post">
				<div class="post-edition">
					<textarea class="post-content" name="content" placeholder="Ecrivez un article"></textarea>
					<div class="post-refer">
						<select name="type" class="post-type">
						<?php foreach (FROMS as $value) {?>
							<option value="<?=$value?>"><?=$value?></option>
						<?php }?>
						</select>
						<button type="submit" class="post-btn-publish">Publier</button>
					</div>
				</div>
			</form>
		</div>
	</section>

<?php require_once '../pages/footer.php'; unset($_SESSION['query']);?>
