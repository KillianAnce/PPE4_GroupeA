<?php

/***************************************************************************************************************
*   Script PHP : bibliothèques de fonctions
*   Ce fichier comporte un ensemble de fonctions utiles à l'exploitation des données de la base
*   Les fonctions définies ici sont génériques, elles peuvent être utilisées pour n'importe quel DOM du site
***************************************************************************************************************/


/**
*   Connexion à la base de données
*   @param $user (Chaîne de caractères) - identifiant SGBD utilisé
**/
function connexion($user) {
    $config = require("config.php");
    try {
        // Création d'une instance PDO
        if ($user == "root") {
            $_db = new PDO("mysql:host=".$config['host'].";dbname=".$config['dbname'].";charset=utf8", $config['user'], $config['pw']);
        }

        // Définition des attributs de l'instance
        $_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        $_db = null;
        echo 'Erreur : ' . $e -> getMessage();
    }

    return ($_db);
}



/**
*   Crée une projection SQL et l'affiche sous forme d'un tableau HTML
*   @param $_db (PDO) - Instance de PDO utilisée
*   @param $requete (Chaîne de caractères) - Requête SQL : projection voulue
**/
function genererProj($_db, $requete) {
    // Instanciation d'une nouvelle requête
    $sql = $_db->query($requete);

    // Création de l'entête
    $total_column = $sql->columnCount();
    echo '<thead><tr id="headerResult">';
    for ($counter = 0; $counter < $total_column; $counter++) {
        $meta = $sql->getColumnMeta($counter);
        echo sprintf('<th data-field="id">%s</th>', $meta['name']);
    }
    echo '</tr></thead>';

    // Génération du contenu
    while ($ligne = $sql -> fetch(PDO::FETCH_ASSOC)) {
        $i = 0;
        echo '<tr>';
        foreach($ligne as $champ) {
            $meta = $sql->getColumnMeta($i);
            echo sprintf('<td class="%s">%s</td>', $meta['name'], $champ);
            $i++;
        }
        echo '</tr>';
    }
    $sql -> closeCursor();
}



/**
*   Alimente le contenu d'une liste déroulante en utilisant les données de la base (un seul champ ne peut être sélectionné)
*   @param $_db (PDO) - Instance de PDO utilisée
*   @param $requete (Chaîne de caractères) - Chaîne contenant la projection SQL à utiliser
*   @param $champ (Chaîne de caractères) - Nom du champ à utiliser
*   @param $entete (Chaîne de caractères) - Entête de la liste déroulante
*   @param $value (entier/chaîne de caractère) - "value" attribuée à chaque <option>. S'il s'agit d'un entier, il sera incrémenté
*   @param $autoSelect (entier/chaîne de caractère) - "value" identifiant l' <option> à sélectionner automatiquement ; affecter "null" si aucune sélection automatique requise
**/
function alimenterCombo($_db, $requete, $champ, $value, $autoSelect) {
    // Instanciation d'une nouvelle requête
    $sql = $_db->query($requete);

    // Création des options de la liste déroulante
    if ( is_numeric($value) ) {
        while( $donnees = $sql->fetch(PDO::FETCH_ASSOC) ) {
            $donnee = $donnees[$champ];

            if ($autoSelect != null && $autoSelect == $value) {
                echo sprintf('<option selected value="%s">%s</option>', $value, $donnee);
            } else {
                echo sprintf('<option value="%s">%s</option>', $value, $donnee);
            }

            $value++;
        }
    } else {
        while( $donnees = $sql->fetch(PDO::FETCH_ASSOC) ) {
            $donnee = $donnees[$champ];

            if ($autoSelect != null && $autoSelect == $value) {
                echo sprintf('<option selected value="%s">%s</option>', $donnee, $donnee);
            } else {
                echo sprintf('<option value="%s">%s</option>', $donnee, $donnee);
            }
        }
    }

    $sql->closeCursor();
}



/**
*   Génération d'un pseudo ("logPseudo") unique lors de l'inscription
*   @param $nomUsr (Chaîne de caractères) - Nom de l'utilisateur (<=> "NomComplet" dans la base)
*   @param $pnomUsr (Chaîne de caractères) - Prénom de l'utilisateur (<=> "logPrenom" dans la base)
*   @param $_db (PDO) - Instance de PDO utilisée
**/
function genererPseudo($nomUsr, $pnomUsr, $_db) {
    $_pseudo = "";
    $sql = "SELECT * FROM login WHERE logPseudo like '$_pseudo'";
    $sql = $_db->query($sql);

    do {
        $_pseudo = substr($nomUsr, 0, 2).substr($pnomUsr, 0, 2).rand(1000, 9999);
    } while ( $retour = $sql->fetch() );

    return $_pseudo;
}

?>
