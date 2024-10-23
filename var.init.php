<?php
/**
* Faire l'assignation des variables ici avec les isset() ou !empty()
*/  

//GET
if(empty($_GET['r'])) {
    $_GET['r'] = '';
}
if(empty($_GET['rAjax'])) {
    $_GET['rAjax'] = '';
}
if(empty($_GET['o'])) {
    $_GET['o'] = '';
}
if(empty($_GET['action'])) {
    $_GET['action'] = '';
}

if(empty($_GET['typeRecherche'])) {
    $_GET['typeRecherche'] = '';  
}
if(empty($_GET['keyword'])) {
    $_GET['keyword'] = '';  
}

//POST
if(empty($_POST['titreAjout'])) {
    $_POST['titreAjout'] = '';  
}
if(empty($_POST['prenomArtisteAjout'])) {
    $_POST['prenomArtisteAjout'] = '';  
}
if(empty($_POST['nomArtisteAjout'])) {
    $_POST['nomArtisteAjout'] = '';  
}
if(empty($_POST['adresseAjout'])) {
    $_POST['adresseAjout'] = '';  
}
if(empty($_POST['descriptionAjout'])) {
    $_POST['descriptionAjout'] = '';  
}
if(empty($_POST['selectArrondissement'])) {
    $_POST['selectArrondissement'] = '';  
}
if(empty($_POST['selectCategorie'])) {
    $_POST['selectCategorie'] = '';  
}
if(empty($_POST['titreModif'])) {
    $_POST['titreModif'] = '';  
}
if(empty($_POST['adresseModif'])) {
    $_POST['adresseModif'] = '';  
}
if(empty($_POST['selectCategorieModif'])) {
    $_POST['selectCategorieModif'] = '';  
}
if(empty($_POST['selectArrondissementModif'])) {
    $_POST['selectArrondissementModif'] = '';  
}
if(empty($_POST['descriptionModif'])) {
    $_POST['descriptionModif'] = '';  
}
if(empty($_POST["selectOeuvreSupp"])) {
    $_POST["selectOeuvreSupp"] = '';  
}
if(empty($_POST["categorieFrAjout"])) {
    $_POST["categorieFrAjout"] = '';  
}
if(empty($_POST["motPasse"])) {
    $_POST["motPasse"] = '';  
}
if(empty($_POST["nomUsager"])) {
    $_POST["nomUsager"] = '';  
}
if(empty($_POST["prenom"])) {
    $_POST["prenom"] = '';  
}
if(empty($_POST["nom"])) {
    $_POST["nom"] = '';  
}
if(empty($_POST["courriel"])) {
    $_POST["courriel"] = '';  
}
if(empty($_POST["descriptionProfil"])) {
    $_POST["descriptionProfil"] = '';  
}
if(empty($_POST["categorieEnAjout"])) {
    $_POST["categorieEnAjout"] = '';  
}
?>