<?php

    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functs' . DIRECTORY_SEPARATOR . 'Const.php';

    require_once FUNCTIONS;

    start();

    if (!empty($_POST)) {

        $nom = get('nom');
        $prenom = get('prenom');
        $pseudo = get('nomUtilisateur');
        $contact = get('numero');
        $email = $pseudo . '@ida.ci';
        $password = get('password');
        $passConf = get('passwordConfirm');
        $errorConst = false;

        $userSelect = selectUser($pseudo, $pdo);

        if (!$userSelect || verifie_nom($nom) || !lenght_nom($nom) || verifie_nom($prenom) || !lenght_nom($prenom) || verifie_username($pseudo) || !lenght_username($pseudo) || !verifie_password($password) || !verifie_phone($contact) || ($password !== $passConf)) {
            $_SESSION['errors']['inscript'] = [];
        }


        if ($userSelect) {

            $pseudoM = [
                'pseudo' => 'Nom d\'utilisateur est deja utilise',
            ];
            pushing($pseudoM);
            $errorConst = true;
            

        }


        if (verifie_nom($nom)) {

            if (!lenght_nom($nom)) {
                $nomM = [
                    'nom' => 'Le nom doit contenir au moins 2 caracteres',
                ];
                pushing($nomM);
                $errorConst = true;
                
            }

        } else {

            $nomM = [
                'nom' => 'Le nom doit contenir de symbole ou chiffre',
            ];
            pushing($nomM);
            $errorConst = true;
            

        }

        if (verifie_nom($prenom)) {

            if (!lenght_nom($prenom)) {
                $prenomM = [
                    'prenom' => 'Le prenom doit contenir au moins 2 caracteres',
                ];
                pushing($prenomM);
                $errorConst = true;
                
            }

        } else {

            $prenomM = [
                'prenom' => 'Le prenom ne doit pas contenir de symbole ou chiffre',
            ];
            pushing($prenomM);
            $errorConst = true;
            

        }

        if (verifie_username($pseudo)) {

            if (!lenght_username($pseudo)) {

                $pseudoM = [
                    'pseudo' => 'Le nom d\'utilisateur doit contenir au moins 4 caracteres',
                ];
                pushing($pseudoM);
                $errorConst = true;
                

            }

        } else {

            $pseudoM = [
                'pseudo' => 'Le format du nom d\'utlisateur est incorect',
            ];
            pushing($pseudoM);
            $errorConst = true;
            

        }

        if (!verifie_password($password)) {

            $passwordM = [
                'password' => 'Le mot de passe doit contenir au moins 8 carateres',
            ];
            pushing($passwordM);
            $errorConst = true;
            

        }

        if (!verifie_phone($contact)) {

            $contactM = [
                'contact' => 'Le numero doit etre de 8 chiffres exactement',
            ];
            pushing($contactM);
            $errorConst = true;
            

        }

        if ($password !== $passConf) {

            $passConfM = [
                'passConf' => 'Les mot de passe sont differents',
            ];
            pushing($passConfM);
            $errorConst = true;
            

        }
        
        if (!$errorConst) {

            inscript($pdo);

        } else {

            $messages = $_SESSION['errors']['inscript'];
            unset($_SESSION['errors']['inscript']);
            foreach ($messages as $errorMsg) {
                foreach ($errorMsg as $key => $value) {
                    
                    $keys[] = $key;
                    $values[] = $value;

                }
            }

            if (Isset($keys) && isset($values)) {
                $_SESSION['errors']['inscript'] = array_combine($keys, $values);
            }

            $_SESSION['errors']['datas'] = [
                'nom' => $nom,
                'prenom' => $prenom,
                'pseudo' => $pseudo,
                'contact' => $contact,
                'password' => $password,
                'passConf' => $passConf,
            ];
        }
    }
