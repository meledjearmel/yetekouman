<?php
require_once 'Const.php';
require_once DataBase;

function start()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function pushing(array $array)
{
    array_push($_SESSION['errors']['inscript'], $array);
}

function urlVerify(string $hash)
{
    $URI = explode('/', $_SERVER['REQUEST_URI']);
    if (in_array($hash, $URI)) {
        header('location: ../'.$hash);
    }
}

function urlink (string $hash)
{
    $URI = explode('/', $_SERVER['REQUEST_URI']);
    if (in_array($hash, $URI)) {
        return true;
    }
    return false;
}

function homeRedirect($typeId)
{
    if ($typeId != 1) {
        if ($typeId == 2) {
            if (urlink('publications')) {
                header('location: ../dashboard');
            }
        } else {
            header('location: ../dashboard');
        }
    }
}

function dateWithSlash(string $date)
{
    $date = explode('-', $date);
    echo $date[2].'/'.$date[1].'/'.$date[0];
}

function dateHuman(string $date)
{
    $date = explode('-', $date);
    $i = str_replace('0','',$date[1]);
    $mois = Month[$i];

    echo $date[2].' '.$mois.'. '.$date[0];
}

function get(string $text): string
{
    return htmlspecialchars($_POST[$text]);
}

function hget(string $text): string
{
    return htmlspecialchars($_GET[$text]);
}

function sessionGet(string $text): string
{
    return htmlspecialchars($_SESSION[$text]);
}

function online($id, PDO $pdo)
{
    $req = $pdo->prepare('UPDATE utilisateurs SET `line` = 1 WHERE id = ?;');
    $req->execute([$id]);

}

function offline($id, PDO $pdo)
{
    $req = $pdo->prepare('UPDATE utilisateurs SET `line` = 0 WHERE id = ?;');
    $req->execute([$id]);
}

function set(string $name, string $value)
{
    $_SESSION['auth'] = [
        $name => $value,
    ];
}

function selectUser(string $login, PDO $pdo)
{

    $req = $pdo->prepare('SELECT * FROM utilisateurs WHERE pseudo = ? OR email = ? LIMIT 1;');
    $req->execute([$login, $login]);
    $data = $req->fetch();
    $req->closeCursor();

    return $data;

}

function getUser(string $login, PDO $pdo)
{

    $req = $pdo->prepare('SELECT id,nom,prenom,contact,`line`,`type` FROM utilisateurs WHERE pseudo = ? OR email = ? LIMIT 1;');
    $req->execute([$login, $login]);
    $data = $req->fetch();
    $req->closeCursor();

    return $data;

}


function selectAllUsers(PDO $pdo)
{

    $req = $pdo->query('SELECT id,nom,prenom,contact,`line`,`type` FROM utilisateurs ORDER BY prenom ASC;');
    $datas = $req->fetchAll();

    $req->closeCursor();

    if ($datas) {
        foreach ($datas as $data) {
            $prenoms = explode(' ', $data->prenom);
            $data->prenom = $prenoms[0];
        }
    }

    return (object) $datas;

}

function sendIncriptNotifyToDevs(PDO $pdo, $nom, $prenom, $contact)
{   
    $i = 0;
    $req = $pdo->query('SELECT id FROM utilisateurs');
    $match = $req->fetchAll();

    $req->closeCursor();

    foreach ($match as $value) {
        $i++;
    }
    $salut = (date('H') > 12) ? 'Bonjour' : 'Bonsoir';
    $content = $salut.' cher developpeur(s) de Yetekouman, nous avons encore un nouveau inscrit sur la plateforme.<br>Nom : '.$nom.'<br>Prenom : '.$prenom.'<br>Contact : '.$contact.'<br>Nous lui avons souhaitez une bonne arrive sur notre plateforme.<br>Aujourd\'hui notre plateforme compte <div class="member-count">'.$i.'</div> membre(s)';

    sendSuggest($pdo,true,$content,'1','0');
}

function sendInscriptMsg(PDO $pdo, $username, $nom, $prenom)
{
    $req =  $pdo->prepare('SELECT id FROM utilisateurs WHERE pseudo = ?');
    $req->execute([$username]);
    $match = $req->fetch();

    $req->closeCursor();

    $content = 'Bienvenue <strong>'.$prenom.' '.$nom.'</strong> sur Yetekouman<br>La plateforme estudiantine IDA2<br>Nous developpeurs de la plateforme vous souhaitons de passe un agreable moment sur notre plateforme. Veuillez l\'utiliser a de bon terme.<br>Vous pouvez nous laisser des messages de suggestions a la page d\'acceuil<br>Merci <strong> Yetekouman Bot </strong>';
    sendMsg($pdo, true, $content, $match->id, '0');
}

function inscript(PDO $pdo)
{

    $nom = ucfirst(strtolower(get('nom')));

    $prenom = ucwords(strtolower(get('prenom')));
    $pseudo = strtolower(get('nomUtilisateur'));
    $contact = get('numero');
    $email = $pseudo . '@ida.ci';
    $pass = password_hash(get('password'), PASSWORD_BCRYPT);

    $req = $pdo->prepare('INSERT INTO utilisateurs (nom, prenom, pseudo, email, contact, `password`) VALUES (?, ?, ?, ?, ?, ?)');
    $req->execute([$nom, $prenom, $pseudo, $email, $contact, $pass]);

    $req->closeCursor();

    $req = $pdo->prepare('SELECT id,nom,prenom,contact,`line`,`type` FROM utilisateurs WHERE pseudo = ? LIMIT 1;');
    $req->execute([$pseudo]);
    $data = $req->fetch();

    $req->closeCursor();

    sendIncriptNotifyToDevs($pdo, $nom, $prenom, $contact);
    sendInscriptMsg($pdo, $pseudo, $nom, $prenom);

    $_SESSION['auth'] = $data;

}

function connect(string $login, string $pass, PDO $pdo)
{

    $userSelect = selectUser($login, $pdo);
    if ($userSelect) {
        if (password_verify($pass, $userSelect->password)) {
            $_SESSION['auth'] = getUser($login, $pdo);
            online($userSelect->id, $pdo);
        } else {
            $_SESSION['errors']['connect'] = [
                'messages' => 'Nom d\'utilisateur ou mot de passe errone',
                'login' => $login,
                'pass' => $pass,
            ];
        }
    } else {
        $_SESSION['errors']['connect'] = [
            'messages' => 'Nom d\'utilisateur ou mot de passe errone',
            'login' => $login,
            'pass' => $pass,
        ];
    }

}

function recupUserConvers($from, PDO $pdo)
{
    $req = $pdo->prepare('SELECT * FROM convers WHERE id_from = ? OR id_to = ? ORDER BY id DESC');
    $req->execute([$from, $from]);
    $conversations = $req->fetchAll();
    $req->closeCursor();
    foreach ($conversations as $convers) {
    
            if ($convers->id_from != $from) {
                $data[] = $convers->id_from;
            } else {
                if ($convers->id_to == NULL) {
                    $data[] = 0;
                } else {
                    $data[] = $convers->id_to;
                }
            }
            
    }


        $ids = [];

        foreach ($data as $id) {

            if (!in_array($id, $ids)) {
                array_push($ids, $id);
            }

        }


        foreach ($ids as $id) {
            if ($id != 0) {
                $req = $pdo->prepare('SELECT id, nom, prenom, `line` FROM utilisateurs WHERE id = ?');
                $req->execute([$id]);
                $datas[] = $req->fetch();
                $req->closeCursor();
            } else {

                $data =  [
                    'id' => '0',
                    'nom' => 'Bot',
                    'prenom' => 'Yetekouman',
                    'line' => '1',
                ];

                $datas[] = (object) $data;
            }
            
        }

        return (object) $datas;

    return false;

}

function insertMsg(PDO $pdo, $content = false)
{
    $contenu = ($content) ? $content : nl2br(get('content'));
    $date = date('Y-m-d');
    $heure = date('H:i');

    if (strlen($contenu) <= 0) {
        return false;
    }

    $req = $pdo->prepare('INSERT INTO messages (`date`, heure, contenu) VALUE (?, ?, ?)');
    $req->execute([$date, $heure, $contenu]);

    $id = $pdo->lastInsertId();

    $req->closeCursor();

    return $id;
}

function sendMsg(PDO $pdo, $inscript = false, $content = false, $to = false, $from = false )
{

    $id_from = ($from) ? $from : get('from');
    $id_to = ($to) ? $to : get('to');
    $id_msg = ($inscript) ? insertMsg($pdo, $content) : insertMsg($pdo);

    if (!$id_msg) {
        $_SESSION['errors']['messages'] = [
            'message' => 'Vous ne pouvez pas envoyez un messages vide',
        ];

        return (object) $_SESSION['errors']['messages'];
    }

    if ($inscript) {
        $req = $pdo->prepare('INSERT INTO `convers` (`id_to`, `id_msg`) VALUES (?, ?)');
        $req->execute([$id_to, $id_msg]);
    } else {
        $req = $pdo->prepare('INSERT INTO `convers` (`id_from`, `id_to`, `id_msg`) VALUES (?, ?, ?)');
        $req->execute([$id_from, $id_to, $id_msg]);
    }

    $req->closeCursor();

    urlVerify('messages');

}

function recupMsg($to, $from = false, PDO $pdo)
{
    if ($from == 0)
    {
        $req = $pdo->prepare('SELECT `messages`.`contenu` AS content, `messages`.`heure` AS `time`, `messages`.`lu` AS `read`, `convers`.`id_from` AS `from` FROM `messages` INNER JOIN `convers` ON `messages`.`id` = `convers`.`id` WHERE id_from IS NULL AND id_to = ? ORDER BY messages.id ASC');
        $req->execute([$to]);
    } else {
        $req = $pdo->prepare('SELECT `messages`.`contenu` AS content, `messages`.`heure` AS `time`, `messages`.`lu` AS `read`, `convers`.`id_from` AS `from` FROM `messages` INNER JOIN `convers` ON `messages`.`id` = `convers`.`id` WHERE (id_from = ? AND id_to = ?) OR (id_from = ? AND id_to = ?) ORDER BY messages.id ASC');
        $req->execute([$from, $to, $to, $from]);
    }
    
    $datas = $req->fetchAll();

    $req->closeCursor();

    return (object) $datas;
}

function recupAllMsg($from = false, PDO $pdo)
{
    $from = ($from) ? $from : NULL;

    $req = $pdo->prepare('SELECT `messages`.`contenu` AS content, `messages`.`heure` AS `time`, `messages`.`lu` AS `read`, `convers`.`id_from` AS `from` FROM `messages` INNER JOIN `convers` ON `messages`.`id` = `convers`.`id` WHERE  id_to = ? AND messages.lu = 0 ORDER BY messages.id DESC');
    $req->execute([$from]);
    $datas = $req->fetchAll();

    $req->closeCursor();

    return (object) $datas;
}

function recupLastMsg($to, $from = false, PDO $pdo)
{
    if ($from == 0) {
        $req = $pdo->prepare('SELECT id_msg FROM convers WHERE convers.id_from IS NULL AND convers.id_to = ? ORDER BY id_msg DESC LIMIT 1');
        $req->execute([$to]);
    } else {
        $req = $pdo->prepare('SELECT id_msg FROM convers WHERE (convers.id_from = ? AND convers.id_to = ?) OR (convers.id_from = ? AND convers.id_to = ?) ORDER BY id_msg DESC LIMIT 1');
        $req->execute([$from, $to, $to, $from]);
    }

    $msg = $req->fetch();
    $req->closeCursor();

    $req = $pdo->prepare('SELECT * FROM messages WHERE messages.id = ?  LIMIT 1');
    $req->execute([$msg->id_msg]);
    $datas = $req->fetch();
    $req->closeCursor();

    return (object) $datas;
}

function exitsMsg($from, $to, PDO $pdo): int
{  
    $msg = (array) recupMsg($from, $to, $pdo);
    if (!empty($msg)) {
        return 1;
    }
    return 0;
}

function verifie_nom(string $nom)
{
    $regle = '/^[a-z][a-z- \']+[a-z]$/mi';

    $valid = preg_match($regle, $nom);
    if ($valid) {
        return true;
    }
    return false;
}

function verifie_username(string $username)
{
    $regle = '/^[a-z0-9][a-z0-9-_]+[a-z0-9]$/mi';

    $valid = preg_match($regle, $username);
    if ($valid) {
        return true;
    }
    return false;
}

function verifie_password(string $password)
{
    $regle = '/[a-z0-9\' \-#*@_]{8,}$/mi';

    $valid = preg_match($regle, $password);
    if ($valid && strlen($password) > 7) {
        return true;
    }
    return false;
}

function verifie_phone(string $number)
{
    $regle = '/^[0-9]{8}$/mi';

    $valid = preg_match($regle, $number);
    if ($valid) {
        return true;
    }
    return false;
}

function lenght_nom(string $nom)
{
    $lenght = strlen($nom);
    if ($lenght > 1) {
        return true;
    }
    return false;
}

function lenght_username(string $username)
{
    $lenght = strlen($username);
    if ($lenght > 3) {
        return true;
    }
    return false;
}

function secureId($id)
{
    $str = 'e64t2u1k57o8ynea3m9' . $id . 'e64t2u1k57o8ynea3m9';
    echo $str;
}

function recupArtId(string $str)
{
    $regle = '/^(e64t2u1k57o8ynea3m9)[0-9]+(e64t2u1k57o8ynea3m9)$/m';
    if (preg_match($regle, $str)) {
        $id = str_replace('e64t2u1k57o8ynea3m9', '', $str);
        
        return $id;
    }

    return false;
}

function recupId(string $str, PDO $pdo)
{
    $regle = '/^(e64t2u1k57o8ynea3m9)[0-9]+(e64t2u1k57o8ynea3m9)$/m';
    if (preg_match($regle, $str)) {
        $id = str_replace('e64t2u1k57o8ynea3m9', '', $str);
        $req = $pdo->prepare('SELECT id, nom, prenom FROM utilisateurs WHERE id = ? LIMIT 1');
        $req->execute([$id]);
        $user = $req->fetch();
        $req->closeCursor();

        if ($user) {
            return $user;
        } elseif (!$user || $id == 0) {
            $data = [
                'id' => '0',
                'nom' => 'Yetekouman',
                'prenom' => 'Bot',
            ];

            $user = (object) $data;

            return $user;
        }
    }
    return false;
}


function conversNotify($from, $to, PDO $pdo)
{
    $messages = recupMsg($from, $to, $pdo);
    $i = 0;
    foreach ($messages as $message) {
        if ($message->read == 0 && $message->from != $from) {
            $i++;
        }
    }
    return $i;
}

/* ******************************************************************* */
/**
 * Undocumented function
 *
 * @param [type] $from
 * @param PDO $pdo
 * @return void
 */
function msgNotify($from, PDO $pdo)
{
    $messages = recupAllMsg($from, $pdo);
    $i = 0;
    foreach ($messages as $message) {
        if ($message->lu == 0) {
            $i++;
        }
    }
    return $i;
}

/**
 * Undocumented function
 * 
 * @param [type] $form
 * @param [type] $to
 * @param PDO $pdo
 * @return void
 */
function readNotify($from, $to, PDO $pdo)
{
    if ($to == 0) {
        $req =  $pdo->prepare('UPDATE messages INNER JOIN `convers` ON `messages`.`id` = `convers`.`id` SET `messages`.`lu` = 1  WHERE id_from IS NULL AND id_to = ?');
        $req->execute([$from]);
    } else {
        $req =  $pdo->prepare('UPDATE messages INNER JOIN `convers` ON `messages`.`id` = `convers`.`id` SET `messages`.`lu` = 1  WHERE (id_from = ? AND id_to = ?) OR (id_from = ? AND id_to = ?)');
        $req->execute([$from, $to, $to, $from]);
    }
    $req->closeCursor();
}

function createArticle(PDO $pdo)
{
    $content = nl2br(get('content'));
    $source = get('type');
    $date = date('Y/m/d');
    $heure = date('H:i');
    if (strlen($content) > 0) {
        $req = $pdo->prepare('INSERT INTO articles (contenu, source, `date`, heure) VALUE (?, ?, ?, ?)');
        $req->execute([$content, $source, $date, $heure]);
        $req->closeCursor();

        header('location: ../publications');
    } else {
        $_SESSION['errors']['pub'] = [
            'message' => 'Vous ne pouvez pas envoyez un messages vide',
        ];

        return (object) $_SESSION['errors']['pub'];
    }

}

function getArticles(PDO $pdo)
{
    $req = $pdo->query('SELECT * FROM articles ORDER BY id DESC');
    $datas = $req->fetchAll();

    $req->closeCursor();

    return ($datas) ? (object) $datas : false;
}

function delArticle($id, PDO $pdo)
{
    $req = $pdo->prepare('DELETE FROM `articles` WHERE `id` = ?');
    $req->execute([$id]);

    $req->closeCursor();
}

function sendSuggest(PDO $pdo, $inscrit = false, $content = false, $to = false, $from = false)
{
    $content = ($content) ? $content : ucfirst(nl2br(get('content')));
    if ($inscrit) {
        $object = 'Un nouveau inscrit';
    } else {
        $object = ($to == 0) ? 'Suggestion au delegue' : 'Suggestion aux developpeurs';
    }
    $to = ($to) ? $to : get('to');
    $from = ($from) ? $from : get('from');
    $date = date('Y-m-d');
    $heure = date('H:i');

    if (strlen($content) > 0) {
        if ($inscrit) {
            $req = $pdo->prepare('INSERT INTO suggestions (contenu, `objet`, `date`, heure, `to`) VALUE (?, ?, ?, ?, ?)');
            $req->execute([$content, $object, $date, $heure, $to]);
        } else {
            $req = $pdo->prepare('INSERT INTO suggestions (contenu, `objet`, `date`, heure, id_from, `to`) VALUE (?, ?, ?, ?, ?, ?)');
            $req->execute([$content, $object, $date, $heure, $from, $to]);
        }
        
        $req->closeCursor();

        header('location: ../dashboard');
    } else {
        $_SESSION['errors']['dashSugg'] = [
            'message' => 'Vous ne pouvez pas envoyez un message vide',
        ];

        return (object) $_SESSION['errors']['dashSugg'];
    }
}

function getSuggest($typeId, PDO $pdo)
{
    if ($typeId == 1) {
        $req = $pdo->query('SELECT * FROM suggestions ORDER BY id DESC');
        $datas = $req->fetchAll();
        
        $req->closeCursor();

    } elseif($typeId == 2) {
        $req = $pdo->query('SELECT * FROM suggestions WHERE `to` = 1 ORDER BY id DESC');
        $datas = $req->fetchAll();
        
        $req->closeCursor();

    }
    
    foreach ($datas as $sugg) {
        if ($sugg->id_from != '') {
            $req = $pdo->prepare('SELECT nom, prenom FROM utilisateurs WHERE id = ?');
            $req->execute([$sugg->id_from]);
            $user = $req->fetch();

            $req->closeCursor();
        } else {
            $user = [
                'prenom' => 'Yetekouman',
                'nom' => 'Bot'
            ];
        }
        

        $sugg->id_from = (object) $user;
    }

    return $datas;
}