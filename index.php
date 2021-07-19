<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'functs' . DIRECTORY_SEPARATOR . 'Const.php';
	if (!empty($_POST)) {
		if (isset($_POST['nom'])) {
			
			require_once 'functs/inscript.php';

		} else {
			
			require_once 'functs/connect.php';

		}
	}

	if (isset($_SESSION['auth'])) {
    	header('Location: dashboard');
	}

	if (is_connectErrors() || is_inscriptErrors()) {
		$errors = errors();
		if(is_inscriptErrors()){
			$datas = datas();
		}
	}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="refresh" content="1000">
	<title>Yetekouman</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/home.css">
	<link rel="stylesheet" href="css/fonts.css">
</head>
<body>
	<main>
		<div class="header">
			<div class="title">
				<h1>Yetekouman</h1>
			</div>
			<div class="logged">
				<form action="" method="post">
					<input class="<?= is_connectErrors() ? 'error-field' : '';?>" type="text" autocomplete="off" name="login" id="login" placeholder="Email ou nom d'utilisateur" value="<?= is_connectErrors() ? $errors->login : '';?>">
					<input class="<?= is_connectErrors() ? 'error-field' : '';?>" type="password" autocomplete="off" name="pass" id="pass" placeholder="Mot de passe" value="<?= is_connectErrors() ? $errors->pass : '';?>">
					<button type="submit" class="btn">SE CONNECTER</button>
				</form>
				<small class="errors-msg-cnt"><?= is_connectErrors() ? $errors->messages : '';?></small>
			</div>
		</div>
		<div class="body">
			<div class="condition">
				<div class="img-cond">

				</div>
				<div class="text-cond">
					<div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus sed velit, possimus aliquid, aspernatur aliquam officiis. Fuga vero nihil sequi earum sed, fugiat aperiam sit hic recusandae asperiores illo dolore!</div>
					<div>Ipsa veritatis blanditiis laboriosam voluptate aliquam sunt cupiditate, illum obcaecati tempora, atque minus corrupti laudantium eum enim, voluptates dolorum error non corporis consequuntur magnam aut, placeat facere recusandae aperiam! Dignissimos.</div>
				</div>
			</div>
			<div class="register-bloc">
				<h3>Inscrivez vous</h3>
				<form action="" method="post">
					<div class="">
						<div class="form-input">
							<label for="nom">Nom :</label>
							<input type="text" name="nom" autocomplete="off" id="nom" placeholder="Ex: Meledje" maxlength="35" value="<?= is_inscriptErrors() ? $datas->nom : '';?>">
							<small class="errors-msg-ins"><?= is_fieldErrors('nom') ? $errors->nom : '';?></small>
						</div>
						<div class="form-input">
							<label for="prenom">Prenom(s) :</label>
							<input type="text" name="prenom" autocomplete="off" id="prenom" placeholder="Ex: Armel" maxlength="35" value="<?= is_inscriptErrors() ? $datas->prenom : '';?>">
							<small class="errors-msg-ins"><?= is_fieldErrors('prenom') ? $errors->prenom : '';?></small>
						</div>
						<div class="form-input">
							<label for="nomUtilisateur">Nom d'utilisateur :</label>
							<span class="concate">
								<input type="text" name="nomUtilisateur" autocomplete="off" id="nomUtilisateur" maxlength="26" placeholder="Ex: meledjearmel"  value="<?= is_inscriptErrors() ? $datas->pseudo : '';?>">
								<span id="email" class="addMail">
									<p>@ida.ci</p>
								</span>
							</span>
							<small class="errors-msg-ins"><?= is_fieldErrors('pseudo') ? $errors->pseudo : '';?></small>
						</div>
						<div class="form-input">
							<label for="numero">Numero de telephone :</label>
							<input type="tel" name="numero" autocomplete="off" id="numero" maxlength="8" min="8" placeholder="Ex: 87614613" value="<?= is_inscriptErrors() ? $datas->contact : '';?>">
							<small class="errors-msg-ins"><?= is_fieldErrors('contact') ? $errors->contact : '';?></small>
						</div>
						<div class="form-input">
							<label for="password">Mot de passe :</label>
							<input type="password" autocomplete="off" name="password" id="password" placeholder="Entrez un mot de passe" value="<?= is_inscriptErrors() ? $datas->password : '';?>">
							<small class="errors-msg-ins"><?=is_fieldErrors('password') ? $errors->password : '';?></small>
						</div>
						<div class="form-input">
							<label for="passwordConfirm">Confirmez le mot de passe :</label>
							<input type="password" autocomplete="off" name="passwordConfirm" id="passwordConfirm" placeholder="Confirmez mot de passe" value="<?= is_inscriptErrors() ? $datas->passConf : '';?>">
							<small class="errors-msg-ins"><?= is_fieldErrors('passConf') ? $errors->passConf : '';?></small>
						</div>
						<div class="sent">
							<button class="btn">S'INSCRIRE</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</main>

	<script type="text/javascript" src="js/main.js"></script>
</body>

</html>
<?php unset($_SESSION['errors']);