<?php
//Mettre les fichiers requis pour les tests ici.

require_once "../var.init.php";
require_once "../modeles/Oeuvre.class.php";
require_once "../modeles/Categorie.class.php";
require_once "../modeles/Arrondissement.class.php";
require_once "../modeles/Artiste.class.php";
require_once "../modeles/Commentaire.class.php";
require_once "../modeles/Photo.class.php";
require_once "../modeles/Utilisateur.class.php";
require_once "../modeles/Membre.class.php";
require_once "../config/parametresBDD.php";
require_once "../lib/BDD/BaseDeDonnees.class.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
    <head>
		<title>Tests unitaires</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="../css/styles.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    </head>
    <body>
<?php
        
//inclusion de tous les fichiers test.
foreach(glob('./*.*') as $nomFichier){
    if ($nomFichier != "./gabarit.test.php" && $nomFichier != "./index.php") {
        require_once ($nomFichier);
    }
}

?>
	</body>
</html>