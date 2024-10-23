<?php
/**
* @brief class Photo
* @author David Lachambre
* @version 1.0
* @update 2015-12-13
*/
class Photo {
    
    /**
    * @var integer $id Id de la photo.
    * @access private
    */
    private $id;
    
    /**
    * @var string $image Nom de l'image, incluant l'extension du fichier.
    * @access private
    */
    private $image;
    
    /**
    * @var boolean $authorise Détermine si l'euvre a passé l'étape de l'audit.
    * @access private
    */
    private $authorise;

    /**
    * @var object $database Connection à la BDD.
    * @access private
    */
    private static $database;
    
    function __construct() {
        
        if (!isset(self::$database)) {//Connection à la BDD si pas déjà connecté
            
            self::$database = BaseDeDonnees::getInstance();
        }
    }
    
    /**
    * @brief Méthode qui assigne des valeurs aux propriétés de la photo
    * @param integer $id
    * @param string $image
    * @param boolean $authorise
    * @return void
    */
    public function setData($id, $image, $authorise) {
        
        $this->id = $id;
        $this->image = $image;
        $this->authorise = $authorise;
    }
        
    /**
    * @brief méthode qui récupère les valeurs des propriétés de cet objet.
    * @access public
    * @return array
    */
    public function getData() {
        
        $resutlat = array("id"=>$this->id, "image"=>$this->image, "authorise"=>$this->authorise);
        
        return $resutlat;
    }
    
    /**
    * @brief méthode qui récupère toutes les photos associées à une oeuvre.
    * @param $id integer
    * @param $langue string
    * @access public
    * @return array
    */
    public function getPhotosByOeuvre($idOeuvre) {
        
        $infoPhotos = array();
        
        self::$database->query('SELECT * FROM Photos WHERE Photos.idOeuvre = :id AND Photos.authorise = true');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $idOeuvre);
        
        if ($photosBDD = self::$database->resultset()) {
            foreach ($photosBDD as $photo) {
                $unePhoto = array("image"=>$photo["image"]);
                $infoPhotos[] = $unePhoto;
            }
        }
        return $infoPhotos;
    }
    
    /**
    * @brief Méthode qui récupère toutes les photos de la BDD.
    * @access public
    * @return array
    */
    public function getAllPhoto() {
        
        $photoAll = array();
        
        self::$database->query('SELECT * FROM Photos WHERE Photos.authorise = true');
        
               
        if ($photosBDD = self::$database->resultset()) {
            foreach ($photosBDD as $photo) {
                $unePhoto = array("image"=>$photo["image"]);
                $photoAll[] = $unePhoto;
            }
        }
        return $photoAll;
    }
    
    /**
    * @brief méthode qui récupère toutes les photos n'aillant pas encore été authorisées par l'administrateur
    * @access public
    * @return array
    */
    public function getAllPhotosPourApprobation() {
        
        $photos = array();
        
        self::$database->query('SELECT idPhoto, dateSoumissionPhoto FROM Photos WHERE Photos.authorise = false');
        
               
        if ($photosBDD = self::$database->resultset()) {
            foreach ($photosBDD as $photo) {
                $photos[] = $photo;
            }
        }
        return $photos;
    }
    
    /**
    * @brief Méthode qui récupère une photo dans la BDD en fonction du id.
    * @access public
    * @return array
    */
    public function getPhotoById($idPhoto){
        
        $infoPhoto = array();

        self::$database->query('SELECT Photos.image, Photos.idPhoto, Oeuvres.titre, Oeuvres.idOeuvre FROM photos JOIN Oeuvres ON Photos.idOeuvre = Oeuvres.idOeuvre WHERE photos.idPhoto = :idPhoto');
        self::$database->bind(':idPhoto', $idPhoto);

        if($photoBDD = self::$database->uneLigne()){
            $infoPhoto = $photoBDD;
        }
        return $infoPhoto;        
    }

    /**
    * @brief Méthode qui récupère le ID d'une photo dans la BDD en fonction du id d'une oeuvre.
    * @access public
    * @return array
    */
    public function getPhotoByIdOeuvre($idOeuvre){
        
        $infoPhoto = array();

        self::$database->query('SELECT Photos.image, Photos.idPhoto, Oeuvres.titre, Oeuvres.idOeuvre FROM photos JOIN Oeuvres ON Photos.idOeuvre = Oeuvres.idOeuvre WHERE Oeuvres.idOeuvre = :idOeuvre');
        self::$database->bind(':idOeuvre', $idOeuvre);

        if($photoBDD = self::$database->uneLigne()){
            $infoPhoto = $photoBDD;
        }
        return $infoPhoto;     
    }
    
    /**
    * @brief Méthode qui récupère la première photo trouvée dans la BDD en fonction du id d'une oeuvre.
    * @access public
    * @return array
    */
    public function getPhotoByOeuvre($idOeuvre){
        
        $infoPhoto = array();

        self::$database->query('SELECT Photos.image FROM photos WHERE Photos.idOeuvre = :idOeuvre');
        self::$database->bind(':idOeuvre', $idOeuvre);

        if($photoBDD = self::$database->uneLigne()){
            $infoPhoto = $photoBDD;
        }        
        return $infoPhoto;        
    }
    
    /**
    * @brief Méthode qui insère une photo dans la BDD.
    * @param string $id
    * @param boolean $authorise
    * @param string $typePhoto
    * @access public
    * @return string
    */
    public function ajouterPhoto($id, $authorise, $typePhoto) {
        $msgErreurs = "";
        $erreurs = false;

        if ($_FILES["fileToUpload"]["error"] != 4) {          
            
            //Condition définie par le type de photo (profil ou oeuvre)
            if ($typePhoto == "utilisateur") {
                $target_dir = "images/photoProfil/";
            }
            else if ($typePhoto == "oeuvre") {
                $target_dir = "images/photosOeuvres/";
            }
            
            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
            $nouveauNomImage = round(microtime(true)) . '.' . end($temp);      
            $target_file = $target_dir .$nouveauNomImage;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);//Pour empêcher les erreurs quand l'extension est en majuscules
            $pic=($_FILES["fileToUpload"]["name"]);

            
            if ($_FILES["fileToUpload"]["size"] > 5000000 || ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif")) {
                $erreurs = true;
                $msgErreurs = "Seuls les fichiers de type Jpeg ou Png inférieurs à 5Mb sont acceptés.<br>";
            }
            if (!$erreurs) {
                
                //Condition définie par le type de photo (profil ou oeuvre)
                if ($typePhoto == "utilisateur") {
                    self::$database->query("UPDATE utilisateurs SET photoProfil = 'images/photoProfil/$nouveauNomImage' WHERE idUtilisateur = :idUsager");
                    self::$database->bind(':idUsager', $id);
                }
                else if ($typePhoto == "oeuvre") {
                    self::$database->query("INSERT INTO photos (image, authorise, idOeuvre, dateSoumissionPhoto) VALUES ('images/photosOeuvres/$nouveauNomImage', :authorise, :idOeuvre, CURDATE())");
                    self::$database->bind(':idOeuvre', $id);
                    self::$database->bind(':authorise', $authorise);
                }

                try {
                    $result = self::$database->execute();
                    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                }
                catch(Exception $e) {
                    $erreurs = true;
                    $msgErreurs = "erreur lors de l'ajout de la photo".$e->getMessage();
                }
            }
        }
        else {
            $erreurs = true;
            $msgErreurs = "Vous devez d'abord choisir une image.";
        }
        return $msgErreurs;
    }
    
    /**
    * @brief Méthode qui accepte une soumission de photo.
    * @param string $type
    * @param integer $id
    * @access public
    * @return array
    */
    public function accepterSoumission ($id) {
        $msgErreurs = array();//Initialise les messages d'erreur à un tableau vide
        
        try {
            
            self::$database->query('UPDATE Photos SET authorise= true WHERE idPhoto = :id');
            self::$database->bind(':id', $id);
            $erreur = self::$database->execute();

            if ($erreur) {
                $msgErreurs["errRequeteApprob"] = $erreur;
            }
        }
        catch(Exception $e) {
            $msgErreurs["errRequeteApprob"] = $e->getMessage();
        }
        return $msgErreurs;
    }
    
    /**
    * @brief Méthode qui supprime une photo de la BDD.
    * @param integer $id
    * @access public
    * @return array
    */
    public function supprimerPhoto($id) {
        
        $msgErreurs = array();
        
        try {
            self::$database->query('DELETE FROM Photos WHERE idPhoto = :id');
            self::$database->bind(':id', $id);
            $erreur = self::$database->execute();
            
            if ($erreur) {
                $msgErreurs["errRequeteSupp"] = $erreur;
            }
        }
        catch(Exception $e) {
            $msgErreurs["errRequeteSupp"] = $e->getMessage();
        }
        return $msgErreurs;
    }
}
?>