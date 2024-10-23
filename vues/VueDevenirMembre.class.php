<?php
/**
 * @brief Class VueDevenirMembre
 * @author Cristina Mahneke
 * @version 1.0
 * @update 2016-02-06
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueDevenirMembre extends Vue {
     /**
    * @var array $msgErreurs Tous les messages d'erreurs liés aux requêtes du formulaire d'ajout
    * @access private
    */
    private $msgErreurs;
  /**
    * @var string $msgAjout les erreurs d'ajout/exceptions s'il y a lieu
    * @access private
    */
    private $msgAjout;
/**
    * @brief Constructeur. Initialise les propriétés communes de la classe mère
    * @access public
    * @return voids
    */
    function __construct() {
        
        $this->titrePage = "MontréArt - Devenez Membre";
        $this->descriptionPage = "Cette page affiche le formulaire pour que les utilisateurs puissent s'enregistrer en tant que membres";
    }  
    
    /**
    * @brief Méthode qui affecte des valeurs aux propriétés privées
    * @param array $msgErreurs
    * @access public
    * @return void
    */
    public function setData($msgErreurs, $msgAjout) {
       
        $this->msgErreurs = $msgErreurs;
        $this->msgAjout = $msgAjout;
    }
    

    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
        
        if (isset($_SESSION["idUsager"])) {
            echo "<p class='msgAccesNonAuthorise'>Vous êtes déjà un membre enregistré</p>";
        }
        else {
         //Si l'ajout est complété avec succès...
        if (isset($_POST["boutonAjoutUtilisateur"]) && $this->msgErreurs == null) {
            
             echo '<div id="div_bgform" style="display: block;">
                <div id="div_form" style="display: block; background:#ffffff; width: 300px; border: 2px solid #F8F274; border-radius: 15px; padding: 20px 0px 20px 50px;">
                      
                       <form id="formLoginNouveau" method="post" name="formLoginNouveau">
                        <h3>Vous êtes maintenant inscrit, bienvienue à MontréArt!</h3>
                        
                        <input type="text" class="inputLogin" id="userNouveau" name="userNouveau" value="'.$_POST["nomUsager"].'" readonly>
                        <input type="password" class="inputLogin" id="passNouveau" name="passNouveau" value="'.$_POST["motPasse"].'" readonly>
                        <input type="hidden" id="grainSelNouveau" name="grainSelNouveau" value="'.$_SESSION["grainSel"].'">
                          <script>
                            var user = document.getElementById("userNouveau").value;
                            var pass = document.getElementById("passNouveau").value;
                            var grainSel = document.getElementById("grainSelNouveau").value;
                        </script>
                        <button type="button" class="boutonMoyenne" onclick="loginNouveauUsager(user, pass, grainSel)">Continuer</button>
                        
                    </form>
                    
                </div>
            </div>';
            
            $msgAjout = "<div style='color:green' class='erreur'>Enregistrement complété !</div>";
            $_POST["nomUsager"] = "";
            $_POST["motPasse"] = "";
            $_POST["prenom"] = "";
            $_POST["nom"] = "";
            $_POST["courriel"] = "";
            $_POST["descriptionProfil"] = "";
            
        }
        else if (isset($this->msgErreurs["errRequeteAjout"])) {
            $msgAjout = $this->msgErreurs["errRequeteAjout"];
        }
        else {
            $msgAjout = "";
        }
    ?>
    <div class="form_ajout">
        <h2>Devenez membre de MontréArt !</h2>
        <h3>Profitez des avantages tels que :</h3>
        <ul>
            <li>Une section membre personalisée</li>
            <li>Enregistrez vos oeuvres d'art préferées</li>
            <li>Gagnez des points et échangez-les contre des récompenses</li>
            <li>Offres et rabais intéressants, juste pour nos membres !</li>

        </ul>
        <form method="post" name="formAjoutUtilisateur" onsubmit="return validerFormAjoutUtilisateur();" action="?r=devenir_membre" enctype="multipart/form-data">
             <input type='text' class="inputDevMembre" name='nomUsager' id='nomUsager' value="<?php echo $_POST["nomUsager"]; ?>" placeholder="Choisissez un nom d'usager"/>  
            <br> <span  id="erreurNomUsager" class="erreur"><?php if (isset($this->msgErreurs["errNomUsager"])) {echo $this->msgErreurs["errNomUsager"];} ?></span><br>

            <input type='password' class="inputDevMembre" name='motPasse' id='motPasse' value="<?php echo $_POST["motPasse"]; ?>" placeholder="Choisissez un mot de passe"/>

            <br> <span  id="erreurMotPasse" class="erreur"><?php if (isset($this->msgErreurs["errMotPasse"])) {echo $this->msgErreurs["errMotPasse"];} ?></span><br>

            <input type='text' class="inputDevMembre" name='prenom' id='prenom' value="<?php echo $_POST["prenom"]; ?>" placeholder="Votre prénom (obligatoire)"/>

             <br> <span  id="erreurPrenom" class="erreur"><?php if (isset($this->msgErreurs["errPrenom"])) {echo $this->msgErreurs["errPrenom"];} ?></span><br>

            <input type='text' class="inputDevMembre" name='nom' id='nom' value="<?php echo $_POST["nom"]; ?>" placeholder="Nom de Famille (obligatoire)"/>

            <br> <span  id="erreurNom" class="erreur"><?php if (isset($this->msgErreurs["errNom"])) {echo $this->msgErreurs["errNom"];} ?></span><br>

            <input type='text' class="inputDevMembre" name='courriel' id='courriel' value="<?php echo $_POST["courriel"]; ?>" placeholder="Courriel (obligatoire)"/>

             <br> <span  id="erreurCourriel" class="erreur"><?php if (isset($this->msgErreurs["errCourriel"])) {echo $this->msgErreurs["errCourriel"];} ?></span><br>

            <textarea name='descriptionProfil' placeholder="Description"><?php echo $_POST["descriptionProfil"]; ?></textarea>


            <h3>Téléversez votre photo profil</h3>
            <input type="file" name="fileToUpload" id="fileToUpload" class="inputDevMembre">
            <br> <span  id="erreurCourriel" class="erreur"><?php if (isset($this->msgErreurs["errPhoto"])) {echo $this->msgErreurs["errPhoto"];} ?></span><br>
            <input class="boutonMoyenne" type='submit' name='boutonAjoutUtilisateur' value='Envoyer'>
        </form>
        <span class="erreur"></span>
        <span id="msg"><?PHP echo $msgAjout; ?></span>
    </div>
  <?php
        }
    }
}