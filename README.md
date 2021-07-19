Yetekouman [v1.0]
- Fonctionalite backend termine
- Vue frontend en amelioration
- Un fichier index.php a ete ajouter aux dossiers img/, js/, functs/, pasges/, css/ pour eviter qu'un utilisateur y acced 
- Structure du projet
        
        Yetekouman/                    ----> Dossier principal ou racine
          |
          ---- css/                    ----> Dossier des fichiers CSS
          |   |
          |   ---- fonts/              ----> Dossier des polices generales de l'application
          |   |
          |   ---- webfonts/           ----> Dossier des polices icons FontAwesome
          |   |
          |   ---- all.min.css         ----> Fichier CSS des icons FontAwesome
          |   |
          |   ---- dash.css            ----> Fichier CSS du deroulant de la deconnection
          |   |
          |   ---- dashboard.css       ----> Fichier CSS de la pages d'acceuil
          |   |
          |   ---- fonts.css           ----> Fichier CSS des polices personnalises
          |   |
          |   ---- home.css            ----> Fichier CSS configuration du bloc principal pour eviter la coloration global
          |   |
          |   ---- main.css            ----> Fichier CSS principal contient les regles touchant toute l'application
          |   |
          |   ---- messages.css        ----> Fichier CSS de la page de message
          |   |
          |   ---- posts.css           ----> Fichier CSS de la page de publication
          |   |
          |   ---- scrollbar.css       ----> Fichier CSS de personnalisation des bar de scroll
          |   |
          |   ---- settings.css        ----> Fichier CSS de la page de parametrage des comptes
          |   |
          |   ---- suggests.css        ----> Fichier CSS de la page de suggestion
          |
          ---- js/                     ----> Dossier des fichiers JS
          |   |
          |   ---- dashboard.js        ----> Fichier JS de la page d'acceuil
          |   |
          |   ---- jquery.min.js       ----> Fichier JS de la bibliotheque jQuery pour l'automatisation minimal
          |   |
          |   ---- main.js             ----> Fichier JS principal contient les scripts touchant toute l'application
          |   |
          |   ---- messages.js         ----> Fichier JS de la page de message
          |   |
          |   ---- posts.js            ----> Fichier JS de la page de publication
          |   |
          |   ---- suggests.js         ----> Fichier JS de la page de suggestion
          |
          ---- img/                    ----> Dossier des images
          |   |
          |   ---- logo.png            ----> Logo de l'application
          |   |
          |   ---- undraw_teacher.svg  ----> Image de la page d'inscription
          |
          ---- db/                     ----> Dossier du fichier SQL
          |   |
          |   ---- yetekouman.sql      ----> Fichier SQl de la Base de Donnee
          |
          ---- functs/                 ----> Dossier des fichier PHP pour la fonctionnalite d'application
          |   |
          |   ---- connect.php         ----> Fichier PHP permettant la connection d'une tiers personne
          |   |
          |   ---- Const.php           ----> Fichier PHP contenant toute les constantes definit dans l'application en plus des des fonctions de retour des sessions ERROR & AUTH
          |   |
          |   ---- convers.php         ----> Fichier PHP permettant la selection d'une conversation
          |   |
          |   ---- deconnect.php       ----> Fichier PHP permettant la deconnection d'une tiers personne
          |   |
          |   ---- deleteArt.php       ----> Fichier PHP permettant la suppression d'un article
          |   |
          |   ---- functions.php       ----> Fichier PHP contenant toute les fonctions faisant tourner l'applications
          |   |
          |   ---- inscript.php        ----> Fichier PHP permettant l'inscription d'une tiers personne
          |   |
          |   ---- PDO.php             ----> Fichier PHP permettant la connection a la Base de Donnee
          |   |
          |   ---- secure.php          ----> Fichier PHP permettant de modifier le titre d'un utlisateur
          |   |
          |   ---- sendDashmsg.php     ----> Fichier PHP permettant d'envoyer un message depuis la page d'acceuil
          |
          ---- pages/                  ----> Dossier PHP des fichier de coupe de page
          |   |
          |   ---- contacts.php        ----> Fichier PHP coupe des contacts pour rafraichissement
          |   |
          |   ---- dashContent.php     ----> Fichier PHP coupe du contenu des article pour rafraichissement
          |   |
          |   ---- footer.php          ----> Fichier PHP pied de page
          |   |
          |   ---- header.php          ----> Fichier PHP tete de page
          |   |
          |   ---- messages.php        ----> Fichier PHP coupe des messages pour rafraichissement
          |   |
          |   ---- msglink.php         ----> Fichier PHP coupe de la bare nav message pour rafraichissement
          |
          ---- dashboard/              ----> Dossier d'entrer a la page d'acceuil
          |   |
          |   ---- index.php           ----> Fichier PHP d'entrer a la page d'acceuil
          |
          ---- messages/               ----> Dossier d'entrer a la page de message
          |   |
          |   ---- index.php           ----> Fichier PHP d'entrer a la page de message
          |
          ---- suggestions/            ----> Dossier d'entrer a la page de suggestion
          |   |
          |   ---- index.php           ----> Fichier PHP d'entrer a la page de suggestion
          |
          ---- publications/           ----> Dossier d'entrer a la page de publication
          |   |
          |   ---- index.php           ----> Fichier PHP d'entrer a la page de publication
          |
          ---- settings/               ----> Dossier d'entrer a la page de configuartion
          |   |
          |   ---- index.php           ----> Fichier PHP d'entrer a la page de configuration
          |
          ---- index.php               ----> Point d'entrer de l'application
              
Log [v0.9] :
    -> Base de Donnee modifie
    -> Vue Acceuil ameliorer : Le generation du code etait difficile du coup jai repris.
    -> Possibilite d'envoyer et de recevoir un message
    -> Bulle compteur sur les messages
    -> Possibilite d'ecrire a une personne depuis la page d'acceuil
    -> Impossible d'ecrire un article si l'utilisateur n'est pas Delegue
    -> Possibilite au Delegue uniquement d'ecrire et de supprimer un article
    -> Possibilite de suggerer des choses au Delegue ou aux Developpeur
    -> Impossible de voir les suggestions si l'utilisateur n'est pas Developpeur
    -> Possibilite de nommer des utilisateur en Normal, Developpeur, ou Delegue
    -> Reception automatique d'un message de bienvenue a l'incription
    -> Reception automatique d'une information au niveau de la suggestion pour un nouveau utilisateur inscrit

New Folder/File [v1.0] :
    -> settings/
        -> index.php
    Cette page a etet creer dans l'intention de donner les titre aux utilisateur sans aller sur phpMyAdmin. Nous avons trois nomination:
            - Normal : Tout etudiant n'ayant pas participer au projet
            - Developpeur : Tout etudiant ayant pris part au projet
            - Delegue : Etudiant etant le deleguer de la classe
    Vue qu'elle est proteger par un nom d'utlisateur et un mot de passe null ne peut modifier son attribut s'il ne les connais pas:
        - Nom d'utilisateur : yetekouman
        - Mot de passe : 12345678



