<?php
/**
 * @brief Class VueSoumission
 * @author David Lachambre
 * @author Cristina Mahneke
 * @version 1.0
 * @update 2015-12-16
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueSoumission extends Vue {
    
    /**
    * @var array $oeuvresBDD Toutes les oeuvres de la BDD.
    * @access private
    */
    private $oeuvresBDD;
    
    /**
    * @var array $arrondissementsBDD Tous les arrondissements de la BDD.
    * @access private
    */
    private $arrondissementsBDD;
    
    /**
    * @var array $categoriesBDD Toutes les catégories de la BDD.
    * @access private
    */
    private $categoriesBDD;
    
      /**
    * @var array $oeuvreASoumettre Oeuvre qui a ete soumis par l'usager.
    * @access private
    */
    private $oeuvreASoumettre;
    
     /**
    * @var array $msgErreurs Tous les messages d'erreurs liés à la tentative de insertion d'une oeuvre.
    * @access private
    */
    private $msgErreurs;
    
    function __construct() {
        $this->titrePage = "MontréArt - Soumission";
        $this->descriptionPage = "La page de soumission d'une oeuvre du site MontréArt";
    }
    
    /**
    * @brief Méthode qui affecte des valeurs aux propriétés privées
    * @param array $oeuvresBDD
    * @param array $arrondissementsBDD
    * @param array $categoriesBDD
    * @access public
    * @return void
    */
    public function setData($oeuvresBDD, $arrondissementsBDD, $categoriesBDD, $msgErreurs) {
        $this->oeuvresBDD = $oeuvresBDD;
        $this->arrondissementsBDD = $arrondissementsBDD;
        $this->categoriesBDD = $categoriesBDD;
        $this->msgErreurs = $msgErreurs;
    }
    
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {

        //AJOUT  OEUVRE

        //Si l'ajout est complété avec succès...
        if (isset($_POST["boutonAjoutOeuvre"]) && empty($this->msgErreurs)) {
            $msgAjout = "<div style='color:green' class='erreur'>Ajout complété !</div>";
            $_POST["titreAjout"] = "";
            $_POST["prenomArtisteAjout"] = "";
            $_POST["nomArtisteAjout"] = "";
            $_POST["adresseAjout"] = "";
            $_POST["descriptionAjout"] = "";
            $_POST["selectArrondissement"] = "";
            $_POST["selectCategorie"] = "";
        }
        else if (isset($this->msgErreurs["errRequeteAjout"])) {
            $msgAjout = $this->msgErreurs["errRequeteAjout"];
        }
        else {
            $msgAjout = "";
        }
    ?>
       
        
        <main>
            
            <h2 id="ContribuezAMontreart">Contribuez à Montréart!</h2>
            <p class="noIndent">Vous avez trouvé une oeuvre, qui, selon vous, devrait être sur notre site?</p>
            <p class="noIndent">Veuillez remplir le formulaire ci-dessous avec les informations de l'oeuvre en question.
            Toute contribution sera sujette à une approbation de la part d'un administrateur.</p>

               
            <form method="POST" name="formAjoutOeuvre" onsubmit="return valideAjoutOeuvre(false);" action="?r=soumission" enctype="multipart/form-data" >
                <input type='text' class="inputSoumission" name='titreAjout' id='titreAjout' placeholder="Titre de l'oeuvre" value="<?php echo  $_POST["titreAjout"]; ?>"/>
                <span  id="erreurTitreOeuvre" class="erreur"><?php if (isset($this->msgErreurs["errTitre"])) {echo $this->msgErreurs["errTitre"];} ?></span>                 

                <input type='text' class="inputSoumission" name='prenomArtisteAjout' id='prenomArtisteAjout' value="<?php echo  $_POST["prenomArtisteAjout"]; ?>" placeholder="Prénom de l'artiste"/>

                <input type='text' class="inputSoumission" name='nomArtisteAjout' id='nomArtisteAjout' value="<?php echo $_POST["nomArtisteAjout"]; ?>" placeholder="Nom de l'artiste "/>

                <input type='text' class="inputSoumission" name='adresseAjout' id='adresseAjout' value="<?php echo $_POST["adresseAjout"]; ?>" placeholder="Adresse "/>
                <br>  <span class="erreur" id="erreurAdresseOeuvre"><?php if (isset($this->msgErreurs["errAdresse"])) {echo $this->msgErreurs["errAdresse"];} ?></span><br>

                <textarea name='descriptionAjout' class="inputSoumission descriptionAjoutSoumission" id='descriptionAjout' placeholder="Description "><?php echo $_POST["descriptionAjout"]; ?></textarea>
                <br>  <span class="erreur" id="erreurDescription"><?php if (isset($this->msgErreurs["errDescription"])) {echo $this->msgErreurs["errDescription"];} ?></span><br>

                <select name="selectArrondissement"  id="selectArrondissement" class="selectSoumission">
                    <option value="">Choisir un arrondissement</option>
                    <?php
                        foreach ($this->arrondissementsBDD as $arrondissement) {
                            if ($arrondissement["idArrondissement"] == $_POST["selectArrondissement"]) {
                                $selection = "selected";
                            }
                            else {
                                $selection = "";
                            }
                            echo "<option value='".$arrondissement["idArrondissement"]."'".$selection.">".$arrondissement["nomArrondissement"];
                        }

                    ?>
                </select>
                <br>  <span class="erreur" id="erreurSelectArrondissement"><?php if (isset($this->msgErreurs["errArrondissement"])) {echo $this->msgErreurs["errArrondissement"];} ?></span><br>
                <select name="selectCategorie"  id="selectCategorie" class="selectSoumission">
                    <option value="">Choisir une catégorie</option>
                    <?php
                        foreach ($this->categoriesBDD as $categorie) {
                            if ($categorie["idCategorie"] == $_POST["selectCategorie"]) {
                                $selection = "selected";
                            }
                            else {
                                $selection = "";
                            }
                            echo "<option value='".$categorie["idCategorie"]."'".$selection.">".$categorie["nomCategorie$this->langue"];
                        }
                    ?>
                </select>   
                <br><span class="erreur" id="erreurSelectCategorie"><?php if (isset($this->msgErreurs["errCategorie"])) {echo $this->msgErreurs["errCategorie"];} ?></span><br>
                <h3 class="televersionTexteSoumission">Téléversez l'image de l'oeuvre</h3>
                <input type="file" name="fileToUpload" id="fileToUpload" class="fileToUploadSoumission">
               <span id="erreurPhoto" class="erreur"><?php if (isset($this->msgErreurs["errPhoto"])) {echo $this->msgErreurs["errPhoto"];} ?></span><br>
                <input class="boutonMoyenne" id="boutonAjouterSoumission" type='submit' name='boutonAjoutOeuvre' value='Ajouter'>
            </form>
            <span class="msgUser" id="msgAjout">
            <?php
            echo $msgAjout;
            ?>  
            </span>
            
        </main>

    <?php
    }
}
    
?>