<?php
/**
 * @brief Class VueOeuvre
 * @author David Lachambre
 * @version 1.0
 * @update 2015-12-15
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueOeuvre extends Vue {
    
    /**
    * @var array $oeuvre Information sur l'oeuvre
    * @access private
    */
    private $oeuvre;
    
    /**
    * @var array $commentaires Commentaires associés à l'oeuvre
    * @access private
    */
    private $commentaires;
    
    /**
    * @var array $photos Photos associées à l'oeuvre
    * @access private
    */
    private $photos;
    
    
    /**
    * @var array $artistes Artistes associés à l'oeuvre
    * @access private
    */
    private $artistes;
    
    /**
    * @var string $langue Langue d'affichage
    * @access protected
    */
    protected $langue;
    
    /**
    * @var string $msgPhoto Message destiné à l'utilisateur lors de la soumission d'une photo unique
    * @access protected
    */
    protected $msgPhoto;
    
    /**
    * @var string $msgCommentaire Message destiné à l'utilisateur lors de la soumission d'un commentaire
    * @access protected
    */
    protected $msgCommentaire;
    
    /**
    * @brief Constructeur. Initialise les propriétés communes de la classe mère
    * @access public
    * @return voids
    */
    function __construct() {
        
        $this->titrePage = "MontréArt - Oeuvre";
        $this->descriptionPage = "Cette page affiche une oeuvre spécifique du site MontréArt";
    }
    
    /**
    * @brief Méthode qui assigne des valeurs aux propriétés de la vue
    * @param array $oeuvre
    * @param array $photos
    * @param array $commentaires
    * @param array $artistes
    * @param string $langue
    * @access public
    * @return void
    */
    public function setData($oeuvre, $commentaires, $photos, $artistes,$classement, $langue) {
        
        $this->oeuvre = $oeuvre;
        $this->commentaires = $commentaires;
        $this->photos = $photos;
        $this->artistes = $artistes;
        $this->classement = $classement;
        $this->langue = $langue;
    }
    
    /**
    * @brief Méthode qui assigne une valeur à la propriété msgPhoto
    * @param string $msg
    * @access public
    * @return void
    */
    public function setMsgPhoto($msg) {
        
        $this->msgPhoto = $msg;
    }
     /**
    * @brief Méthode qui assigne une valeur à la propriété msgCommentaire
    * @param string $msgComm
    * @access public
    * @return void
    */
    public function setMsgCommentaire($msgComm) {
        
        $this->MsgCommentaire = $msgComm;
    }
    
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
        
        if ($this->msgPhoto == "") {
            if (isset($_POST["soumettrePhotoUnique"])) {
                $msgPhoto = "<span style='color:green'>Photo envoyée !</span>";
            }
            else {
                $msgPhoto = "";
            }
        }
        else {
            $msgPhoto = $this->msgPhoto;
        }
        if (empty($this->oeuvre)) {
            echo "<p id='oeuvreNonTrouveeP'>Cette oeuvre n'a pas été trouvée dans la base de données</p>";
        }
        else {
            
            echo "<div id='backgroundOeuvreHead'>";
            echo "<div class='sliderOeuvre'>";
            if ($this->photos) {//Si des photos existent pour cette oeuvre...
                for ($i = 0; $i < count($this->photos); $i++) {
                    $imgPhoto = $this->photos[$i]['image'];
                    echo "<img src = '$imgPhoto' alt='image photo'>";
                }
            }
            else {//Image par défaut
                $imgDefaut = "images/imgDefaut".$this->langue.".png";
                echo "<img src = '$imgDefaut' alt='image photo'>";
            }
            echo "</div>"; //fin div sliderOeuvre
            $idOeuvreencours=$this->oeuvre["idOeuvre"];

            echo "<div class='infosOeuvre'>
            <div id='bordureOeuvre'></div>
            <h4 class='h4InfosOeuvre' id='TitreOeuvre'>Titre: </h4>";
        echo  "<p>".$this->oeuvre['titre']."</p>"; 
            echo "<h4 class='h4InfosOeuvre'>Classement:</h4>";
            
            if(isset($this->classement) && $this->classement!=null){
                 switch ($this->classement['moyenne']) {//Sélection de l'image d'étoile appropriée selon le vote
                            case 1:
                                $imgVote = "etoiles_1.png";
                                break;
                            case 2:
                                $imgVote = "etoiles_2.png";
                                break;
                            case 3:
                                $imgVote = "etoiles_3.png";
                                break;
                            case 4:
                                $imgVote = "etoiles_4.png";
                                break;
                            case 5:
                                $imgVote = "etoiles_5.png";
                                break;
                            default:
                                $imgVote = "etoiles_0.png";
                                break;
                        }
                 echo "<div class='ratingOeuvre'><img src = 'images/$imgVote' alt='image de classement'></div>";
            }else{
                
                echo "<div class='ratingOeuvre'><img src = 'images/etoiles_0.png' alt='image de classement'></div>";
                echo "<p>Non-classé</p>";
            }
        
        echo "<h4 class='h4InfosOeuvre'>Artiste(s) : </h4><p>";
        foreach ($this->artistes as $artiste) {
            if (isset($artiste["nomArtiste"])) {

                if (isset($artiste["prenomArtiste"])) {
                    echo  $artiste["prenomArtiste"]." ";
                }
                echo  $artiste["nomArtiste"];
            }
            else if (isset($artiste["nomCollectif"])) {
                echo $artiste["nomCollectif"];
            }
            else {
                echo "artiste inconnu";
            }
            echo "<br>";
        }
        echo "</p>";

        if (isset($this->oeuvre["nomCategorie" . $this->langue])) {
            echo "<h4 class='h4InfosOeuvre'>Catégorie : </h4>"."<p>". $this->oeuvre["nomCategorie" . $this->langue]."</p>";
        }

        if ( $this->oeuvre["parc"]) {
            echo "<h4 class='h4InfosOeuvre'>Parc : </h4>"."<p>". $this->oeuvre["parc"]."</p>";
        }
        if ( $this->oeuvre["batiment"]) {
            echo "<h4 class='h4InfosOeuvre'>Bâtiment : </h4>"."<p>". $this->oeuvre["batiment"]."</p>";
        }
        if ( $this->oeuvre["adresse"]) {
            echo "<h4 class='h4InfosOeuvre'>Adresse : </h4>"."<p>". $this->oeuvre["adresse"]."</p>";
        }
        if ( $this->oeuvre["nomArrondissement"]) {
            echo "<h4 class='h4InfosOeuvre'>Arrondissement : </h4>"."<p>". $this->oeuvre["nomArrondissement"]."</p>";
        }
        echo "<a class='boutonMoyenne' id='boutonDirection' href='?r=trajet'>Directions</a></div>";//fin div infosOeuvre
            
            
            

         
        if (isset($this->oeuvre["description" . $this->langue])) {
            echo "<div>
            <h3 class='titresPageOeuvre' id='descriptionTitreOeuvre'>Description :</h3>
            <p class='textStandard' id='texteDescriptionOeuvre'>".$this->oeuvre["description" . $this->langue]."</p></div>";
            echo "</div>";
        }//fin div description
    ?>


                <form name="formPhotoUnique" id="formPhotoUnique" action="?r=oeuvre&o=<?php echo($idOeuvreencours);?>&action=envoyerPhoto" onsubmit="return validePhotoSubmit();" method="post" enctype="multipart/form-data">
                    <h4 id="selectImageUpload">Soumettez une nouvelle image pour cette oeuvre :</h4>
                    <input class='boutonMoyenne' type="file" name="fileToUpload" id="fileToUpload">
                    <br>
                    <input class='boutonMoyenne' id="btnSoumettrePhoto" type="submit" value="Soumettre" name="soumettrePhotoUnique">
                    <br>
                    <span id="msg" class="erreur"><?php echo $msgPhoto; ?></span>
                </form>

                <div class='borderMobile'></div>
                <h3 class='titresPageOeuvre' id="h3CommentaireTitre">Commentaires :</h3>
                <?php
                if ($this->commentaires) {//Si des commentaires existent pour cette oeuvre dans la langue d'affichage...
                    for ($i = 0; $i < count($this->commentaires); $i++) {
                        echo "<div class='unCommentaire'>";
                        switch ($this->commentaires[$i]['voteCommentaire']) {//Sélection de l'image d'étoile appropriée selon le vote
                            case 1:
                                $imgVote = "etoiles_1.png";
                                break;
                            case 2:
                                $imgVote = "etoiles_2.png";
                                break;
                            case 3:
                                $imgVote = "etoiles_3.png";
                                break;
                            case 4:
                                $imgVote = "etoiles_4.png";
                                break;
                            case 5:
                                $imgVote = "etoiles_5.png";
                                break;
                            default:
                                $imgVote = "etoiles_0.png";
                                break;
                        }
                        if (isset($this->commentaires[$i]['photoProfil'])) {
                            $imgPhoto = $this->commentaires[$i]['photoProfil'];
                        }
                        else {
                            $imgPhoto = 'images/photoProfilDefaut.jpg';
                        }

                        echo "<img class='thumbnail' src = '$imgPhoto' alt='photo de profil'><br>";
                        echo "<h5 id='idUtilisateur'>".$this->commentaires[$i]["nomUsager"]."</h5>";

                        echo "<img class='ratingUtilisateur' src = 'images/$imgVote' alt='photo du vote'>";
                        echo "<p class='texteCommP'>".$this->commentaires[$i]["texteCommentaire"]."</p>"."</div>";
                        //fin div unCommentaire
                    }
                }
                else {
                    echo "<div class='unCommentaire'><p class='texteCommP'>Aucun commentaire</p></div>";
                }//fin div commentaires 
            ?>
<form method="post" name="formAjoutCommentaire" id='formAjoutCommentaire' action="?r=oeuvre&o=<?php echo($idOeuvreencours);?>&action=envoyerCommentaire"  onsubmit="return valideAjoutCommentaireOeuvre();">
                <input type="hidden" name="idOeuvreencours" value="<?php echo $idOeuvreencours ?>">
                <div class="cont">
                  <div class="stars">
                      <input class="star star-5" name='vote' id="star-5-2" type="radio" value='5'/>
                      <label class="star star-5" for="star-5-2"></label>
                      <input class="star star-4"  name='vote' id="star-4-2" type="radio" value='4'/>
                      <label class="star star-4" for="star-4-2"></label>
                      <input class="star star-3" name='vote' id="star-3-2" type="radio" checked="checked" value='3'/>
                      <label class="star star-3" for="star-3-2"></label>
                      <input class="star star-2" name='vote' id="star-2-2" type="radio" value='2'/>
                      <label class="star star-2" for="star-2-2"></label>
                      <input class="star star-1"  name='vote' id="star-1-2" type="radio" value='1'/>
                      <label class="star star-1" for="star-1-2"></label>
                  </div>
                </div>
                <textarea name='commentaireAjout' id='commentaireAjout' ></textarea>

                <input  class='boutonMoyenne' id="boutonAjouterCom" type='submit' name='ajoutCommentaire' value='Ajouter un commentaire'  >
            <br>
                    <span id="erreurCommentaire" class="erreur"><?php if (isset($this->MsgCommentaire)) {echo $this->MsgCommentaire;} ?></span>
            </form>
<?php
        }
    }
}
    
?>