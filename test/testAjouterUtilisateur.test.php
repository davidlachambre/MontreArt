<h2>Test unitaire - ajout utilisateur</h2>
<div id="contenu">
<?php

$membre = new Membre();
$droits = 0;
    if (isset($_POST['boutonAjoutUtilisateur'])){
        $membre->AjouterUtilisateur($_POST['nomUsager'], $_POST['motPasse'], $_POST['prenom'], $_POST['nom'], $_POST['courriel'], $_POST['descriptionProfil'], $droits);
    }else{
        echo "Remplissez tous les champs";
    }

?>

    

 <form method="post" name="formTestAjoutUtilisateur" enctype="multipart/form-data">                
                <input type='text' name='nomUsager' value="" placeholder="Choisissez un nom usager"/>  
                <input type='text' name='motPasse' value="" placeholder="Choisissez un mot de passe"/>
                <input type='text' name='prenom' value="" placeholder="Votre prénom (obligatoire)"/>
                <input type='text' name='nom' value="" placeholder="Nom de Famille (obligatoire)"/>
                <input type='text' name='courriel' value="" placeholder="Courriel Electronique (obligatoire)"/>   
                <textarea name='descriptionProfil' placeholder="Description (obligatoire)"></textarea>
                
                <h3 class="televersionTexteGestion">Téléversez votre photo profil</h3>
                    <input type="file" name="photoProfil" id="photoProfil" class="fileToUploadGestion">
                   <span id="erreurPhotoVide" class="erreur"></span><br>
                        <span id="erreurPhotoSize" class="erreur"></span><br>
                        <span id="erreurPhotoType" class="erreur"></span><br>
                    <input class="boutonMoyenne" type='submit' name='boutonAjoutUtilisateur' value='Ajouter'>
                </form>
                <span class="erreur"></span>
                
</div>