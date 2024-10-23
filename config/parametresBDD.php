<?php

/**
 * @brief    Définit les constantes de configuration de la BDD
 * @author   David Lachambre
 * @version  1.2
 * @update     2016-01-22 
 */

//var_dump($_SERVER);//Pour vérifier quel est le serveur auquel on est connecté.

//Valeurs par défaut.
$serveur = "localhost";
$bdd = "montreart";
$utilisateur = "root";
$pass = "";

if ($_SERVER["SERVER_NAME"] == "montreart.net" || $_SERVER["SERVER_NAME"] == "www.montreart.net") {
    $utilisateur = "administrateur";
    $pass = "Bd2cPCoC";
}
//else if (strpos($_SERVER["HTTP_USER_AGENT"], 'Mac')) {
//    $pass = "root";
//} //Pour le développement sur mac seulement. Doit être commenté sinon l'émulateur d'iphone de Chrome ne peut pas se connecter à la BD.
define("HOTE", $serveur);
define("BDD", $bdd);
define("UTILISATEUR", $utilisateur);
define("PASS", $pass);
?>