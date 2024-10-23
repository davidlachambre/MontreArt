<!-- -------------------------------------------------------------
//TEST UNITAIRE FONCTIONALITÉ AFFICHAGE D'UNE OEUVRE
<div id="contenu">
-->
<h2>Test unitaire - affichage d'une oeuvre</h2>
<div id="contenu">
<?php
$idOeuvre = 3;
$langue = "FR";

$oeuvre = new Oeuvre();
$oeuvreAffichee = $oeuvre->getOeuvreById($idOeuvre, $langue);
echo "<h3>informations sur l'oeuvre</h3>";
echo "<details>";
echo '<summary>Oeuvre::getOeuvreById($idOeuvre = ' . $idOeuvre . ', $langue = ' . $langue . ')</summary>';
var_dump($oeuvreAffichee);
echo "</details>";

$commentaire = new Commentaire();
$commentairesOeuvre = $commentaire->getCommentairesByOeuvre($idOeuvre, $langue);
echo "<h3>commentaires sur l'oeuvre</h3>";
echo "<details>";
echo '<summary>Commentaire::getCommentairesByOeuvre = ' . $idOeuvre . ', $langue = ' . $langue . ')</summary>';
var_dump($commentairesOeuvre);
echo "</details>";

$photo = new Photo();
$photosOeuvre = $photo->getPhotosByOeuvre($idOeuvre);
echo "<h3>photos associées à l'oeuvre</h3>";
echo "<details>";
echo '<summary>Photo::getPhotosByOeuvre($idOeuvre = ' . $idOeuvre . ')</summary>';
var_dump($photosOeuvre);
echo "</details>";
?>
</div>








