<!-- -------------------------------------------------------------
//TEST UNITAIRE REQUETE SELECTIONNER UTILISATEUR PAR SON NOM USAGER
<div id="contenu">
-->
<h2>Test unitaire - selectionner utilisateur par son nom usager et mot de passe</h2>
<div id="contenu">
<?php
$nomUsager = 'dlachambre';
$motPasse = 'dl12345';

$utilisateur = new Utilisateur();
$utilisateurRequis = $utilisateur->getUtilisateurByNomUsager($nomUsager, $motPasse);
echo "<h3>informations sur l'utilisateur</h3>";
echo "<details>";
echo '<summary>Utilisateur::getUtilisateurByNomUsager($nomUsager = ' . $nomUsager . ', $motPasse= ' . $motPasse . ')</summary>';
var_dump($utilisateurRequis);
echo "</details>";



//$photo = new Photo();
//$photosOeuvre = $photo->getPhotosByOeuvre($idOeuvre);
//echo "<h3>photos associées à l'oeuvre</h3>";
//echo "<details>";
//echo '<summary>Photo::getPhotosByOeuvre($idOeuvre = ' . $idOeuvre . ')</summary>';
//var_dump($photosOeuvre);
//echo "</details>";
?>
</div>