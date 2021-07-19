<?php
	
	require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functs' . DIRECTORY_SEPARATOR . 'Const.php';
	require_once FUNCTIONS;

	start();

	if (!isset($_SESSION['auth'])) {
		header('Location: ../');
 	}

	$user = auth();
	$prenoms = explode(' ', $user->prenom);
	$prenom = $prenoms[0];
	$notifs = msgNotify($user->id, $pdo);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title><?=$title?></title>
	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/fonts.css">
	<link rel="stylesheet" href="../css/scrollbar.css">
	<link rel="stylesheet" href="../css/dash.css">
	<link rel="stylesheet" href="../css/all.min.css">
	<?php
if (isset($style)) {
	echo '<link rel="stylesheet" href="' . $style . '">';
}
?>
</head>

<body>
	<main>
		<div class="header">
			<div class="title">
				<h1>Yetekouman</h1>
			</div>
			<div class="logged">
				<ul class="nav">
					<li><a class="a-head-main" href="../dashboard"><i class="fa fa-home"></i>&nbsp;<span>Acceuil</span></a></li>
					<li id="msglink"><a class="a-head-main" href="../messages"><i class="far fa-envelope"></i>&nbsp;<span>Messages</span>&nbsp;<?=($notifs > 0) ? '<span class="counter">'.$notifs.'</span>' : '';?></a></li>
					<?= ($user->type == 1 || $user->type == 2) ? '<li><a class="a-head-main" href="../suggestions"><i class="fa fa-archive"></i>&nbsp;<span>Suggestions</span></a></li>' : '' ?>
					<?= ($user->type == 1) ? '<li><a class="a-head-main" href="../publications"><i class="fa fa-edit"></i>&nbsp;<span>Publications</span></a></li>' : '' ?>
					<li class="drl-menu">
						
						<?=$prenom?>&nbsp;<?=$user->nom?>&nbsp;&nbsp;<i class="fa fa-caret-right"></i>
						<ul>
							<li id="disconnect" class="item-menu"><i class="fa fa-power-off"></i>&nbsp;<span>Se deconnecter</span></li>
						</ul>
					</li>

				</ul>
			</div>
		</div>
		<form id="disc-form" action="../functs/deconnect.php"></form>
		<div class="body">
