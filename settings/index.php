<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functs' . DIRECTORY_SEPARATOR . 'Const.php';
require_once FUNCTIONS;

if (!empty($_POST)) {
    if ($_POST['username'] == SecureLogin && $_POST['password'] == SecurePass) {
        $_SESSION['adminer'] = 'administrator';
        header('location: ../settings');
    } else {
        $_SESSION['error'] = [
            'username' => $_POST['username'],
            'password' => $_POST['password']
        ];
        header('location: ../settings');
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Yetekouman - Settings</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/scrollbar.css">
    <link rel="stylesheet" href="../css/dash.css">
    <link rel="stylesheet" href="../css/settings.css">
    <link rel="stylesheet" href="../css/all.min.css">
</head>

<body>
    <main>
        <div class="header">
            <div class="title">
                <a class="a-head-main" href="../"><h1>Yetekouman</h1></a>
            </div>
            <div class="logged">
                <?php if (isset($_SESSION['adminer'])) {; ?>
                <ul class="nav">
                    <li class="drl-menu">

                        administrator&nbsp;&nbsp;<i class="fa fa-caret-right"></i>
                        <ul>
                            <li id="disconnect" class="item-menu"><a href="../functs/secureDisconnect.php" style="color: #fff; text-decoration: none;"><i class="fa fa-power-off"></i>&nbsp;<span>Se deconnecter</span></a></li>
                        </ul>
                    </li>

                </ul>
                <?php } ?>
            </div>
        </div>
        <div class="body">
        
            <?php if (!isset($_SESSION['adminer'])) { ?>

            <div class="connection">
                <div>
                    <form action="" method="post">
                        <div class="form-control">
                            <label for="username">Entrer votre nom d'utilisateur</label>
                            <input class="<?= (isset($_SESSION['error'])) ? 'isError': ''; ?>" type="text" name="username" id="username" autocomplete="off" value="<?= (isset($_SESSION['error'])) ? $_SESSION['error']['username'] : ''; ?>">
                        </div>
                        <div class="form-control">
                            <label for="password">Entrer votre mot de passe</label>
                            <input class="<?= (isset($_SESSION['error'])) ? 'isError': ''; ?>" type="password" name="password" id="password" value="<?= (isset($_SESSION['error'])) ? $_SESSION['error']['password'] : ''; ?>">
                        </div>
                        <div class="form-control-btn">
                            <button type="submit">Verifier</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <?php } else { ?>

            <div class="users-field">
                <div class="user-fields">
                    <div class="table">
                        <div class="table-head">
                            <div class="chp-nom">Nom</div>
                            <div class="chp-prenom">Prenom(s)</div>
                            <div class="chp-contact">Contact</div>
                            <div class="chp-titre">Titre</div>
                            <div class="chp-nomination">Nomination</div>
                        </div>
                        <?php $allUsers = selectAllUsers($pdo); ?>

                        <?php if ($allUsers) { ?>
                        <?php foreach ($allUsers as $user) { ?>
                            <div class="table-body">
                                <div class="chp-nom"><?= $user->nom ?></div>
                                <div class="chp-prenom"><?= $user->prenom ?></div>
                                <div class="chp-contact"><?= $user->contact ?></div>
                                <?php
                                    if ($user->type == 0) {
                                        $user->type = 'Normal';
                                    } elseif ($user->type == 1) {
                                        $user->type = 'Delegue';
                                    } elseif ($user->type == 2) {
                                        $user->type = 'Developpeur';
                                    }
                                ?>
                                <div class="chp-titre"><?= $user->type ?></div>
                                <div class="chp-action">
                                    <a href="../functs/secure.php?id=<?php secureId($user->id) ?>&task=2"><div class="<?= ($user->type == 'Developpeur') ? 'isSelect' : '' ?>">Devs</div></a>
                                    <a href="../functs/secure.php?id=<?php secureId($user->id) ?>&task=1"><div class="<?= ($user->type == 'Delegue') ? 'isSelect' : '' ?>">Delegue</div></a>
                                    <a href="../functs/secure.php?id=<?php secureId($user->id) ?>&task=0"><div class="<?= ($user->type == 'Normal') ? 'isSelect' : '' ?>">Normal</div></a>
                                </div>
                            </div>
                        <?php } 
                        }?>
                    </div>
                </div>
            </div>

            <?php } ?>
        </div>
    </main>
</body>
<?php unset($_SESSION['error']); ?>
</html>
