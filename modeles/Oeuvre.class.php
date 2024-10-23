<?php
/**
* @brief class Oeuvre
* @author David Lachambre
* @version 1.0
* @update 2015-12-14
*/
class Oeuvre {
    
    /**
    * @var integer $id Id de l'oeuvre
    * @access private
    */
    private $id;
    
    /**
    * @var string $titre Titre de l'oeuvre
    * @access private
    */
    private $titre;
    
    /**
    * @var integer $noInterneMtl Numéro interne de l'oeuvre à la ville de Montréal
    * @access private
    */
    private $noInterneMtl;
    
    /**
    * @var string $latitude Coordonnées de latitude de l'oeuvre
    * @access private
    */
    private $latitude;
    
    /**
    * @var string $longitude Coordonnées de longitude de l'oeuvre
    * @access private
    */
    private $longitude;
    
    /**
    * @var string $parc Parc dans lequel se trouve l'oeuvre
    * @access private
    */
    private $parc;
    
    /**
    * @var string $batiment Bâtiment dans lequel se trouve l'oeuvre
    * @access private
    */
    private $batiment;
    
    /**
    * @var string $adresse Adresse se trouve l'oeuvre
    * @access private
    */
    private $adresse;
    
    /**
    * @var string $description Description de l'oeuvre
    * @access private
    */
    private $description;
    
    /**
    * @var string $idCategorie Catégorie de l'oeuvre
    * @access private
    */
    private $idCategorie;
    
    /**
    * @var string $idArrondissement Arrondissement où se trouve l'oeuvre
    * @access private
    */
    private $idArrondissement;
    
    /**
    * @var array $idArtistes Artistes ayant créé l'oeuvre
    * @access private
    */
    private $idArtistes;
    
    /**
    * @var string $authorise Détermine si l'oeuvre a passé l'étape de l'audit
    * @access private
    */
    private $authorise;
    
    /**
    * @var array $photos Photos de l'oeuvre
    * @access private
    */
    private $photos;
    
    /**
    * @var array $commentaires Commentaires liés à l'oeuvre
    * @access private
    */
    private $commentaires;

    /**
    * @var object $database Connection à la BDD
    */
    private static $database;
    
    private $nbPassesUpdater;
    private $nbPassesAjouter;
    
    function __construct() {
        
        $this->nbPassesUpdater = 0;
        $this->nbPassesAjouter = 0;
        
        if (!isset(self::$database)) {//Connection à la BDD si pas déjà connecté
            
            self::$database = BaseDeDonnees::getInstance();
        }
    }
    
    /**
    * @brief Méthode qui assigne des valeurs aux propriétés de l'oeuvre
    * @param integer $id
    * @param string $titre
    * @param integer $noInterneMtl
    * @param string $latitude
    * @param string $longitude
    * @param string $batiment
    * @param string $adresse
    * @param string $description
    * @param integer $idCollection
    * @param integer $idCategorie
    * @param integer $idArrondissement
    * @param array $idArtistes
    * @param boolean $authorise
    * @param array $photos
    * @param array $commentaires
    * @access public
    * @return void
    */
    public function setData($id, $titre, $noInterneMtl, $latitude, $longitude, $parc, $batiment, $adresse, $description, $idCategorie, $idArrondissement, $idArtistes, $authorise, $photos, $commentaires) {
        
        $this->id = $id;
        $this->titre = $titre;
        $this->noInterneMtl = $noInterneMtl;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->parc = $parc;
        $this->batiment = $batiment;
        $this->adresse = $adresse;
        $this->description = $description;
        $this->idCategorie = $idCategorie;
        $this->idArrondissement = $idArrondissement;
        $this->idArtistes = $idArtistes;
        $this->authorise = $authorise;
        $this->photos = $photos;
        $this->commentaires = $commentaires;
    }
    
    /**
    * @brief Méthode qui assigne un tableau de photos à une oeuvre
    * @param array $photos
    */
    public function setPhotos($photos) {

        $this->photos = $photos;
    }
        
    /**
    * @brief Méthode qui récupère les valeurs des propriétés de cet objet
    * @access public
    * @return array
    */
    public function getData() {
        
        $resutlat = array("id"=>$this->id, "titre"=>$this->titre, "noInterneMtl"=>$this->noInterneMtl, "latitude"=>$this->latitude, "longitude"=>$this->longitude, "parc"=>$this->parc, "batiment"=>$this->batiment, "adresse"=>$this->adresse, "description"=>$this->description, "idCategorie"=>$this->idCategorie, "idArrondissement"=>$this->idArrondissement, "idArtistes"=>$this->idArtistes, "authorise"=>$this->authorise, "photos"=>$this->photos, "commentaires"=>$this->commentaires);
        
        return $resutlat;
    }
    
    /**
    * @brief Méthode qui récupère une oeuvre authorisée dans la BD
    * @param integer $id
    * @access public
    * @return array
    */
    public function getOeuvreById($id) {
        
        self::$database->query('SELECT * FROM Oeuvres JOIN Categories ON Oeuvres.idCategorie = Categories.idCategorie JOIN Arrondissements ON Arrondissements.idArrondissement = Oeuvres.idArrondissement WHERE Oeuvres.idOeuvre = :id AND Oeuvres.authorise = true');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $id);
        
        $infoOeuvre = array();
        
        if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $infoOeuvre = $oeuvreBDD;
        }
        return $infoOeuvre;
    }
    
    /**
    * @brief Méthode qui récupère une oeuvre (authorisée ou non) dans la BD
    * @param integer $id
    * @access public
    * @return array
    */
    public function getAnyOeuvreById($id) {
        
        self::$database->query('SELECT * FROM Oeuvres JOIN Categories ON Oeuvres.idCategorie = Categories.idCategorie JOIN Arrondissements ON Arrondissements.idArrondissement = Oeuvres.idArrondissement WHERE Oeuvres.idOeuvre = :id');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $id);
        
        $infoOeuvre = array();
        
        if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $infoOeuvre = $oeuvreBDD;
        }
        return $infoOeuvre;
    }
    
    /**
    * @brief Méthode qui récupère une oeuvre à approuver dans la BD
    * @param integer $id
    * @access public
    * @return array
    */
    public function getOeuvrePourApprobation($id) {
        
        self::$database->query('SELECT Oeuvres.idOeuvre, Oeuvres.titre, Oeuvres.adresse, Oeuvres.descriptionFR, Oeuvres.descriptionEN, Artistes.prenomArtiste, Artistes.nomArtiste, Artistes.idArtiste, Arrondissements.nomArrondissement, Arrondissements.idArrondissement, Categories.nomCategorieFR, Categories.nomCategorieEN, Categories.idCategorie FROM Oeuvres JOIN Categories ON Oeuvres.idCategorie = Categories.idCategorie JOIN Arrondissements ON Arrondissements.idArrondissement = Oeuvres.idArrondissement JOIN OeuvresArtistes ON Oeuvres.idOeuvre = OeuvresArtistes.idOeuvre JOIN Artistes ON OeuvresArtistes.idArtiste = Artistes.idArtiste WHERE Oeuvres.idOeuvre = :id');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $id);
        
        $infoOeuvre = array();
        
        if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $infoOeuvre = $oeuvreBDD;
        }
        return $infoOeuvre;
    }
    
    /**
    * @brief Méthode qui récupère toutes les oeuvres avec une photo.
    * @access public
    * @return array
    */
    public function getAllOeuvresWithPhoto() {
    $oeuvres = array();
    self::$database->query('SELECT * FROM oeuvres join photos on photos.idOeuvre = oeuvres.idOeuvre');
        if ($lignes = self::$database->resultset()) {
            foreach ($lignes as $ligne) {
                $oeuvres[] = $ligne;
            }
            return $oeuvres;
        }
    }
    
    /**
    * @brief Méthode qui supprime une oeuvre de la BDD.
    * @param integer $id
    * @access public
    * @return array
    */
    public function supprimerOeuvre($id) {
        
        $msgErreurs = $this->validerFormSuppOeuvre($id);//Validation des champs obligatoires.
        
        if (!empty($msgErreurs)) {
            return $msgErreurs;//Retourne le/les message(s) d'erreur de la validation.
        }
        else {
            try {
                self::$database->query('DELETE FROM Oeuvres WHERE idOeuvre = :id');
                self::$database->bind(':id', $id);
                $erreur = self::$database->execute();
                
                if ($erreur) {
                    $msgErreurs["errRequeteApprob"] = $erreur;
                }
            }
            catch(Exception $e) {
                $msgErreurs["errRequeteSupp"] = $e->getMessage();
            }
        }
        return $msgErreurs;
    }
    
    /**
    * @brief Méthode qui valide les champs obligatoires lors d'une suppression d'oeuvre.
    * @param string $id
    * @access private
    * @return array
    */
    private function validerFormSuppOeuvre($id) {
        
        $msgErreurs = array();//Initialise les messages d'erreur à un tableau vide.
        
        if (empty($id)) {
            $msgErreurs["errSelectOeuvreSupp"] = "Veuillez choisir une oeuvre à supprimer";
        }
        return $msgErreurs;
    }
    
    /**
    * @brief Méthode qui récupère les oeuvres du Json de la ville de Montréal et met à jour la BDD.
    * @access public
    * @return void
    */
    public function updaterOeuvresVille() {
        
        $msgErreurs = array();
        
        $jsonVilleMtl = @file_get_contents("http://donnees.ville.montreal.qc.ca/dataset/2980db3a-9eb4-4c0e-b7c6-a6584cb769c9/resource/18705524-c8a6-49a0-bca7-92f493e6d329/download/oeuvresdonneesouvertes.json");
        
        if ($jsonVilleMtl) {
            
            $oeuvresVilleMtl = json_decode($jsonVilleMtl, true);
            
            foreach ($oeuvresVilleMtl as $oeuvreVilleMtl) {

                if (isset($oeuvreVilleMtl["NoInterne"])) {
                    $this->noInterneMtl = $oeuvreVilleMtl["NoInterne"];
                    $oeuvreMtlBDD = $this->getOeuvreByNoInterne($oeuvreVilleMtl["NoInterne"]);

                    $this->getFKOeuvreByName($oeuvreVilleMtl);

                    if (empty($oeuvreMtlBDD)) {
                        $action = "ajouter";
                        $this->nbPassesAjouter++;
                    }
                    else {
                        $action = "updater";
                        $this->nbPassesUpdater++;
                    }
                    $this->insererUpdaterOeuvreVille($oeuvreVilleMtl, $action);
                }
            }
            $this->changerDateUpdate();
        }
        else {
            $msgErreurs["errUrl"] = "Le fichier de la ville de Montréal n'a pas été trouvé.";
        }
        return $msgErreurs;
    }
    
    /**
    * @brief Méthode qui récupère les foreign key associées à l'oeuvre à insérer / updater.
    * @param array $oeuvre
    * @access private
    * @return void
    */
    private function getFKOeuvreByName($oeuvre) {
        
        //Catégories
        $categorie = new Categorie();
        $idCategorie = false;
        if (isset($oeuvre["SousCategorieObjet"])) {
            $idCategorie = $categorie->getCategorieIdByName($oeuvre["SousCategorieObjet"]);//Récupère l'ID en fonction des noms passés en paramètres
        }
        else if (isset($oeuvre["SousCategorieObjetAng"])) {
            $idCategorie = $categorie->getCategorieIdByName($oeuvre["SousCategorieObjetAng"]);//Récupère l'ID en fonction des noms passés en paramètres
        }
        if (!$idCategorie) {//Si la catégorie n'existe pas...
            $categorie->ajouterCategorie($oeuvre["SousCategorieObjet"], $oeuvre["SousCategorieObjetAng"]);//Fait l'insertion si non trouvé dans la BDD
            $idCategorie = $categorie->getCategorieIdByName($oeuvre["SousCategorieObjet"]);//Récupère l'ID en fonction des noms passés en paramètres
        }
        $this->idCategorie = $idCategorie;//Mets à jour la propriété avec l'ID trouvé

        //Arrondissements

        $arrondissement = new Arrondissement();
        $idArrondissement = false;
        if (isset($oeuvre["Arrondissement"])) {
            $idArrondissement = $arrondissement->getArrondissementIdByName($oeuvre["Arrondissement"]);//Récupère l'ID en fonction des noms passés en paramètres
        }
        if (!$idArrondissement) {//Si larrondissement n'existe pas...
            $arrondissement->ajouterArrondissement($oeuvre["Arrondissement"], $oeuvre["Arrondissement"]);//Fait l'insertion si non trouvé dans la BDD
            $idArrondissement = $arrondissement->getArrondissementIdByName($oeuvre["Arrondissement"]);//Récupère l'ID en fonction des noms passés en paramètres
        }
        $this->idArrondissement = $idArrondissement;//Mets à jour la propriété avec l'ID trouvé

        //Artistes
        $artisteVide = new Artiste();
        foreach ($oeuvre["Artistes"] as $artiste) {

            $idArtiste = false;
            $idArtiste = $artisteVide->getArtisteIdByName($artiste["Prenom"], $artiste["Nom"], $artiste["NomCollectif"]);//Récupère l'ID en fonction des noms passés en paramètres

            if (!$idArtiste) {//Si l'artiste n'existe pas...
                $artisteVide->ajouterArtiste($artiste["Prenom"], $artiste["Nom"], $artiste["NomCollectif"]);//Fait l'insertion si non trouvé dans la BDD
                $idArtiste = $artisteVide->getArtisteIdByName($artiste["Prenom"], $artiste["Nom"], $artiste["NomCollectif"]);//Récupère l'ID en fonction des noms passés en paramètres
            }
            $idArtistes[] = $idArtiste;//Tableau de tous les artistes de l'eouvre

        }
        $this->idArtistes = $idArtistes;//Mets à jour la propriété avec les ID trouvés
    }
    
    /**
    * @brief Méthode qui insert ou update les oeuvres de la ville dans la BDD en fonction de l'action passée en paramètre.
    * @param array $oeuvre
    * @param string $action
    * @access private
    * @return void
    */
    private function insererUpdaterOeuvreVille($oeuvre, $action) {

        if ($action === "ajouter") {//Requête pour insérer une oeuvre
        self::$database->query('INSERT INTO Oeuvres (titre, noInterneMtl, latitude, longitude, parc, batiment, adresse, descriptionFR, descriptionEN, authorise, idCategorie, idArrondissement) VALUES (:titre, :noInterneMtl, :latitude, :longitude, :parc, :batiment, :adresse, :descriptionFR, :descriptionEN, :authorise, :idCategorie, :idArrondissement)');

        self::$database->bind(':descriptionFR', "Aucune description disponible");
        self::$database->bind(':descriptionEN', "No description available.");
        self::$database->bind(':authorise', true);

        }
        else if ($action === "updater") {//Requête pour mettre à jour une oeuvre
            self::$database->query('UPDATE Oeuvres SET titre=:titre, latitude=:latitude, longitude=:longitude, parc=:parc, batiment=:batiment, adresse=:adresse, idCategorie=:idCategorie, idArrondissement=:idArrondissement WHERE noInterneMtl = :noInterneMtl');
        }

        self::$database->bind(':titre', $oeuvre["Titre"]);
        self::$database->bind(':noInterneMtl', $oeuvre["NoInterne"]);
        self::$database->bind(':latitude', $oeuvre["CoordonneeLatitude"]);
        self::$database->bind(':longitude', $oeuvre["CoordonneeLongitude"]);
        self::$database->bind(':parc', $oeuvre["Parc"]);
        self::$database->bind(':batiment', $oeuvre["Batiment"]);
        self::$database->bind(':adresse', $oeuvre["AdresseCivique"]);
        self::$database->bind(':idCategorie', $this->idCategorie);
        self::$database->bind(':idArrondissement', $this->idArrondissement);

        self::$database->execute();

        if ($action === "ajouter") {

            $idOeuvre = $this->getOeuvreIdByNoInterne($this->noInterneMtl);//aller chercher id oeuvre insérée

            $artiste = new Artiste();
            $artiste->lierArtistesOeuvre($idOeuvre, $this->idArtistes);//Lier les artistes à l'oeuvre
        }
    }
    
    /**
    * @brief Méthode qui récupère les oeuvres de la ville présentes dans la BDD.
    * @param string $noInterneMtl
    * @access private
    * @return array
    */
    private function getOeuvreByNoInterne($noInterneMtl) {
        
        $oeuvreMtlBDD = array();

        self::$database->query('SELECT * FROM oeuvres JOIN Categories ON Oeuvres.idCategorie = Categories.idCategorie JOIN Arrondissements ON Arrondissements.idArrondissement = Oeuvres.idArrondissement WHERE Oeuvres.noInterneMtl = :noInterneMtl');

        //Lie les paramètres aux valeurs
        self::$database->bind(':noInterneMtl', $noInterneMtl);

        if ($oeuvre = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $oeuvreMtlBDD = $oeuvre; 
        }
        return $oeuvreMtlBDD;
    }
    
    /**
    * @brief Méthode qui change la date de la dernière mise à jour des données de la ville.
    * @access private
    * @return void
    */
    private function changerDateUpdate() {
        
        self::$database->query('SELECT idUpdate FROM UpdateListeOeuvresVille');
        
        if ($date = self::$database->uneLigne()) {
            self::$database->query('UPDATE UpdateListeOeuvresVille SET dateDernierUpdate=CURDATE(), heureDernierUpdate=CURTIME() WHERE UpdateListeOeuvresVille.idUpdate = 1');
            self::$database->execute();
        }
        else {
            self::$database->query('INSERT INTO UpdateListeOeuvresVille (dateDernierUpdate, heureDernierUpdate) VALUES (CURDATE(), CURTIME())');
            self::$database->execute();
        }
    }
    
    /**
    * @brief Méthode qui renvoi la date et l'heure de la dernière mise à jour des données de la ville.
    * @access public
    * @return array
    */
    public function getDateDernierUpdate() {
        
        $date = array();
            
        self::$database->query('SELECT * FROM UpdateListeOeuvresVille');
        
        if ($dateBDD = self::$database->uneLigne()) {
            $date = $dateBDD;
        }
        return $date;
    }
    
    /**
    * @brief Méthode qui affiche les résultats du test unitaire pour la fonctionalité du Json.
    * @access public
    * @return void
    */
    public function afficherTestJson() {
        //Test pour déterminer si toutes les oeuvres ont été insérées dans la BDD.
        if (($this->nbPassesUpdater + $this->nbPassesAjouter) > 0) {
            echo "<p>Le contenu doit être rechargé une fois pour voir les résultats :</p>";
            echo "<br>";
            echo "Nombre d'oeuvres du Json présentes dans la BDD Montreart : " . $this->nbPassesUpdater;
            echo "<br>";
            echo "Nombre d'oeuvres du Json manquantes dans la BDD Montreart : " . $this->nbPassesAjouter;
            echo "<br>";
            echo "Nombre total d'oeuvres dans le Json de la ville : " . ($this->nbPassesUpdater + $this->nbPassesAjouter);
        }
    }
        
    /**
    * @brief Méthode qui cherche les oeuvres en fonction du titre partiel passé en paramètre.
    * @param string $keyword
    * @access public
    * @return array
    */
    public function chercheParTitre($keyword) {
    
        $infoOeuvres = array();
            
        self::$database->query("SELECT titre, idOeuvre FROM oeuvres WHERE titre LIKE :keyword and authorise = true");

        $keyword = '%'.$keyword.'%';

        self::$database->bind(':keyword', $keyword);
        $results = array();

       if ($oeuvreBDD = self::$database->resultset()) {//Si trouvé dans la BDD
            foreach ($oeuvreBDD as $oeuvre) {
                $infoOeuvres[] = $oeuvre;
            }
        }
        return $infoOeuvres;
    }
    
    /**
    * @brief Méthode qui cherche toutes les oeuvres par catégorie.
    * @param integer $id
    * @access public
    * @return array
    */
    public function getAllOeuvresByCategorie ($id) {
        $infoOeuvres = array();
        
        self::$database->query('SELECT * FROM Oeuvres JOIN Categories ON Oeuvres.idCategorie = Categories.idCategorie JOIN OeuvresArtistes ON OeuvresArtistes.idOeuvre = Oeuvres.idOeuvre JOIN Artistes ON OeuvresArtistes.idArtiste = Artistes.idArtiste WHERE Oeuvres.authorise = true AND Categories.idCategorie = :id GROUP BY Oeuvres.idOeuvre');
            
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $id);
        
        if ($oeuvres = self::$database->resultset()) {
            foreach ($oeuvres as $oeuvre) {
                $infoOeuvres[] = $oeuvre;
            }
        }
        return $infoOeuvres;
    }
    
    /**
    * @brief Méthode qui cherche toutes les oeuvres par arrondissement.
    * @param integer $id
    * @access public
    * @return array
    */
    public function getAllOeuvresByArrondissement ($id) {
        $infoOeuvres = array();
        
        self::$database->query('SELECT * FROM Oeuvres JOIN Categories ON Oeuvres.idCategorie = Categories.idCategorie JOIN OeuvresArtistes ON OeuvresArtistes.idOeuvre = Oeuvres.idOeuvre JOIN Artistes ON OeuvresArtistes.idArtiste = Artistes.idArtiste JOIN Arrondissements ON Arrondissements.idArrondissement = Oeuvres.idArrondissement WHERE Oeuvres.authorise = true AND Arrondissements.idArrondissement = :id GROUP BY Oeuvres.idOeuvre');
            
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $id);
        
        if ($oeuvres = self::$database->resultset()) {
            foreach ($oeuvres as $oeuvre) {
                $infoOeuvres[] = $oeuvre;
            }
        }
        return $infoOeuvres;
    }
    
    /**
    * @brief Méthode qui cherche toutes les oeuvres par artiste.
    * @param integer $id
    * @access public
    * @return array
    */
    public function getAllOeuvresByArtiste ($id) {
        $infoOeuvres = array();
        
        self::$database->query('SELECT * FROM Oeuvres JOIN Categories ON Oeuvres.idCategorie = Categories.idCategorie JOIN OeuvresArtistes ON OeuvresArtistes.idOeuvre = Oeuvres.idOeuvre JOIN Artistes ON OeuvresArtistes.idArtiste = Artistes.idArtiste JOIN Arrondissements ON Arrondissements.idArrondissement = Oeuvres.idArrondissement WHERE Oeuvres.authorise = true AND Artistes.idArtiste = :id GROUP BY Oeuvres.idOeuvre');
            
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $id);
        
        if ($oeuvres = self::$database->resultset()) {
            foreach ($oeuvres as $oeuvre) {
                $infoOeuvres[] = $oeuvre;
            }
        }
        return $infoOeuvres;
    }
    
    /**
    * @brief Méthode qui cherche toutes les oeuvres authorisées ou non.
    * @access public
    * @return array
    */
    public function getAllOeuvres() 
    {
                
        $infoOeuvres = array();
        
        self::$database->query('SELECT * FROM Oeuvres ORDER BY titre');
        
        if ($oeuvres = self::$database->resultset()) {
            foreach ($oeuvres as $oeuvre) {
                $infoOeuvres[] = $oeuvre;
            }
        }
        return $infoOeuvres;
    }
    
    /**
    * @brief Méthode qui cherche toutes les oeuvres.
    * @access public
    * @return array
    */
    public function getAllOeuvresMap() 
    {
                
        $infoOeuvres = array();
        
        self::$database->query('SELECT * FROM Oeuvres where latitude IS NOT null and longitude IS NOT null and authorise = true');
        
        if ($oeuvres = self::$database->resultset()) {
            foreach ($oeuvres as $oeuvre) {
                $infoOeuvres[] = $oeuvre;
            }
        }
        return $infoOeuvres;
    }
      /**
    * @brief fonction qui cherche et calcule les 9 oeuvres les plus proches en fonction de la localisation de l'utilisateur ou d'un point de depart initial.
    * @param float $center_lat la latitude du point de depart
    * @param float $center_lng la longitude du point de depart
    * @access public
    * @return array
    */
    public function getOeuvresProximite($center_lat, $center_lng){
      
        $infoOeuvres = array();
        
        self::$database->query("SELECT titre, latitude, longitude,(3959 * acos( cos( radians(:center_lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(:center_lng) ) + sin( radians(:center_lat) ) * sin( radians( latitude ) ) ) ) AS distance FROM oeuvres HAVING distance < 10 ORDER BY distance LIMIT 0 , 9");
        
         self::$database->bind(':center_lat', $center_lat);
         self::$database->bind(':center_lng', $center_lng);
        
        if ($oeuvres = self::$database->resultset()) {
            foreach ($oeuvres as $oeuvre) {
                $infoOeuvres[] = $oeuvre;
            }
        }
        return $infoOeuvres;
        
    }
    /**
    * @brief Méthode qui cherche toutes les oeuvres par catégorie.
    * @param integer $noInterneMtl
    * @access public
    * @return string
    */
    public function getOeuvreIdByNoInterne($noInterneMtl) {
        
        $idOeuvre = "";
        
        self::$database->query("SELECT idOeuvre FROM Oeuvres WHERE noInterneMtl = :noInterneMtl");
        self::$database->bind(':noInterneMtl', $noInterneMtl);
        

       if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $idOeuvre = $oeuvreBDD['idOeuvre'];
        }
        return $idOeuvre;
    }
    
    /**
    * @brief méthode qui récupère toutes les oeuvres n'aillant pas encore été authorisées par l'administrateur
    * @access public
    * @return array
    */
    public function getAllOeuvresPourApprobation() {
        
        $oeuvres = array();
        
        self::$database->query('SELECT idOeuvre, dateSoumissionOeuvre FROM Oeuvres WHERE Oeuvres.authorise = false');
        
               
        if ($oeuvresBDD = self::$database->resultset()) {
            foreach ($oeuvresBDD as $oeuvre) {
                $oeuvres[] = $oeuvre;
            }
        }
        return $oeuvres;
    }
    
    /**
    * @brief Méthode qui ajoute une oeuvre dans la BDD.
    * @param string $titre
    * @param string $adresse
    * @param string $prenomArtiste
    * @param string $nomArtiste
    * @param string $description
    * @param string $categorie
    * @param string $arrondissement
    * @param boolean $authorise
    * @param string $langue
    * @access public
    * @return void
    */
    //http://www.cylman.com/geocoder-une-adresse-en-php-obtenir-sa-latitude-et-sa-longitude_qr29.html
    public function ajouterOeuvre($titre, $adresse, $prenomArtiste, $nomArtiste, $description, $categorie, $arrondissement, $authorise, $langue) {
  
        if ($prenomArtiste == "") {
            $prenomArtiste = null;
        }
        if ($nomArtiste == "") {
            $nomArtiste = null;
        }
        
        $msgErreurs = array();//Validation des champs obligatoires.
        $idArtistes = array();
        //pour transformer les adresses en géolocalisation
        $coords=array();
        $base_url="http://maps.googleapis.com/maps/api/geocode/xml?";
        $request_url = $base_url . "address=" . urlencode($adresse).'&sensor=false';
        $xml = simplexml_load_file($request_url) or die("url not loading");
        $coords['lat']=$coords['lon']='';
        $coords['status'] = $xml->status ;
        $msgErreurs = $this->validerFormOeuvre($titre, $adresse, $description, $categorie, $arrondissement);//Validation des champs obligatoires.
        if($coords['status']=='OK')
            {
             $latitude = $xml->result->geometry->location->lat ;
             $longitude = $xml->result->geometry->location->lng ;
            }else{
                    $latitude = null;
                    $longitude = null;
                }
        //fin
        if (!empty($msgErreurs)) {
            return $msgErreurs;//Retourne le/les message(s) d'erreur de la validation.
        }
        else {
            try {
                $artiste = new Artiste();

                $idArtisteAjoute = $artiste->getArtisteIdByName($prenomArtiste, $nomArtiste, null);
                
                if (!$idArtisteAjoute) {
                    $artiste->ajouterArtiste($prenomArtiste, $nomArtiste, null);
                    $idArtisteAjoute = $artiste->getArtisteIdByName($prenomArtiste, $nomArtiste, null);
                }
                $idArtistes[] = $idArtisteAjoute;

                self::$database->query('INSERT INTO Oeuvres ( titre, noInterneMtl, latitude, longitude, parc, batiment, adresse, descriptionFR, descriptionEN, authorise, idCategorie, idArrondissement, dateSoumissionOeuvre) VALUES (:titre, null, :latitude, :longitude, null, null, :adresse, :descriptionFR, :descriptionEN, :authorise, :idCategorie, :idArrondissement, CURDATE())');

                if ($langue == "FR") {
                    self::$database->bind(':descriptionFR', $description);
                    self::$database->bind(':descriptionEN', "");
                }
                else if ($langue == "EN") {
                    self::$database->bind(':descriptionEN', $description);
                    self::$database->bind(':descriptionFR', "");
                }
                self::$database->bind(':authorise', $authorise);        
                self::$database->bind(':titre', $titre);       
                self::$database->bind(':adresse', $adresse);       
                self::$database->bind(':idCategorie', $categorie);
                self::$database->bind(':idArrondissement', $arrondissement);
                self::$database->bind(':latitude', $latitude);
                self::$database->bind(':longitude', $longitude);
                self::$database->execute();
            
                $idOeuvre = $this->getIdOeuvreByTitreandAdresse($titre, $adresse);//aller chercher id oeuvre insérée

                $artiste->lierArtistesOeuvre($idOeuvre, $idArtistes);//Lier les artistes à l'oeuvre

                if (isset($_FILES["fileToUpload"])) {
                    
                    $photo = new Photo();
                    $msgInsertPhoto = $photo->ajouterPhoto($id, true, "oeuvre");
                    if ($msgInsertPhoto != "" && $_FILES["fileToUpload"]["error"] != 4) {
                        $msgErreurs["errPhoto"] = $msgInsertPhoto;
                    }
                }                
            }
            catch(Exception $e) {
                $msgErreurs["errRequeteAjout"] = $e->getMessage();
            }
        }
        return $msgErreurs;//array vide = succès.  
    }
    /**
    * @brief Méthode qui modifie le contenu d'une oeuvre.
    * @param integer $idOeuvre
    * @param string $titre
    * @param string $adresse
    * @param string $description
    * @param string $categorie
    * @param string $arrondissement
    * @param string $langue
    * @access public
    * @return void
    */
    public function modifierOeuvre($idOeuvre, $titre, $adresse, $description, $categorie, $arrondissement, $langue) {
        $coords=array();
        $base_url="http://maps.googleapis.com/maps/api/geocode/xml?";
        $request_url = $base_url . "address=" . urlencode($adresse).'&sensor=false';
        $xml = simplexml_load_file($request_url) or die("url not loading");
        $coords['lat']=$coords['lon']='';
        $coords['status'] = $xml->status ;
        $msgErreurs = $this->validerFormOeuvre($titre, $adresse, $description, $categorie, $arrondissement);//Validation des champs obligatoires.
        if($coords['status']=='OK')
            {
             $latitude = $xml->result->geometry->location->lat ;
             $longitude = $xml->result->geometry->location->lng ;
            }else{
                    $latitude = null;
                    $longitude = null;
                }
        if (!empty($msgErreurs)) {
            return $msgErreurs;//Retourne le/les message(s) d'erreur de la validation.
        }
        else {
            try {
                self::$database->query('UPDATE Oeuvres SET titre= :titre, adresse= :adresse, descriptionFR= :descriptionFR, descriptionEN= :descriptionEN, idCategorie= :idCategorie, idArrondissement= :idArrondissement,  latitude= :latitude, longitude=:longitude WHERE idOeuvre = :idOeuvre');

                if ($langue == "FR") {
                    self::$database->bind(':descriptionFR', $description);   
                    self::$database->bind(':descriptionEN', null);   
                }
                else if ($langue == "EN") {
                    self::$database->bind(':descriptionFR', null);   
                    self::$database->bind(':descriptionEN', $description);   
                }
                self::$database->bind(':titre', $titre);       
                self::$database->bind(':adresse', $adresse);       
                self::$database->bind(':idCategorie', $categorie);
                self::$database->bind(':idArrondissement', $arrondissement);
                self::$database->bind(':idOeuvre', $idOeuvre);
                self::$database->bind(':latitude', $latitude);
                self::$database->bind(':longitude', $longitude);
                self::$database->execute();
            }
            catch(Exception $e) {
                $msgErreurs["errRequeteModif"] = $e->getMessage();
            }
        }
        return $msgErreurs;//array vide = succès. 
    }
    
    /**
    * @brief Méthode qui insert une oeuvre de la ville dans la BDD.
    * @param integer $idOeuvre
    * @param string $titre
    * @param string $adresse
    * @param string $description
    * @param string $categorie
    * @param string $arrondissement
    * @access public
    * @return void
    */
    public function modifierOeuvreSoumise($idOeuvre, $elementModif) {
        $coords=array();
        $base_url="http://maps.googleapis.com/maps/api/geocode/xml?";
        $request_url = $base_url . "address=" . urlencode($elementModif["adresse"]).'&sensor=false';
        $xml = simplexml_load_file($request_url) or die("url not loading");
        $coords['lat']=$coords['lon']='';
        $coords['status'] = $xml->status ;
               if($coords['status']=='OK')
            {
             $latitude = $xml->result->geometry->location->lat ;
             $longitude = $xml->result->geometry->location->lng ;
            }else{
                    $latitude = null;
                    $longitude = null;
                }
        if ($idArtiste == "") {
            $idArtiste = null;
        }
        $msgErreurs = array();
        if (isset($elementModif["titre"])) {
            try {
                self::$database->query('UPDATE Oeuvres SET titre= :titre WHERE idOeuvre = :idOeuvre');
                self::$database->bind(':titre', $elementModif["titre"]);                
                self::$database->bind(':idOeuvre', $idOeuvre);                
                self::$database->execute();
            }
            catch(Exception $e) {
                $msgErreurs["errModifTitre"] = $e->getMessage();
            }
            return $msgErreurs;//array vide = succès.
        }
        else if (isset($elementModif["adresse"])) {
            try {
                self::$database->query('UPDATE Oeuvres SET adresse= :adresse, latitude= :latitude, longitude= :longitude WHERE idOeuvre = :idOeuvre');
                self::$database->bind(':adresse', $elementModif["adresse"]); 
                self::$database->bind(':latitude', $latitude);
                self::$database->bind(':longitude', $longitude);  
                self::$database->bind(':idOeuvre', $idOeuvre); 
                self::$database->execute();
            }
            catch(Exception $e) {
                $msgErreurs["errModifAdresse"] = $e->getMessage();
            }
            return $msgErreurs;//array vide = succès.
        }
        else if (isset($elementModif["descriptionFR"])) {
            try {
                self::$database->query('UPDATE Oeuvres SET descriptionFR= :descriptionFR WHERE idOeuvre = :idOeuvre');
                self::$database->bind(':descriptionFR', $elementModif["descriptionFR"]);
                self::$database->bind(':idOeuvre', $idOeuvre);
                self::$database->execute();
            }
            catch(Exception $e) {
                $msgErreurs["errModifDescriptionFR"] = $e->getMessage();
            }
            return $msgErreurs;//array vide = succès.
        }
        else if (isset($elementModif["descriptionEN"])) {
            try {
                self::$database->query('UPDATE Oeuvres SET descriptionEN= :descriptionEN WHERE idOeuvre = :idOeuvre');
                self::$database->bind(':descriptionEN', $elementModif["descriptionEN"]);
                self::$database->bind(':idOeuvre', $idOeuvre);
                self::$database->execute();
            }
            catch(Exception $e) {
                $msgErreurs["errModifDescriptionEN"] = $e->getMessage();
            }
            return $msgErreurs;//array vide = succès.
        }
        else if (isset($elementModif["idArrondissement"])) {
            try {
                self::$database->query('UPDATE Oeuvres SET idArrondissement= :idArrondissement WHERE idOeuvre = :idOeuvre');
                self::$database->bind(':idArrondissement', $elementModif["idArrondissement"]);
                self::$database->bind(':idOeuvre', $idOeuvre);
                self::$database->execute();
            }
            catch(Exception $e) {
                $msgErreurs["errModifArrondissement"] = $e->getMessage();
            }
            return $msgErreurs;//array vide = succès.
        }
        else if (isset($elementModif["idCategorie"])) {
            try {
                self::$database->query('UPDATE Oeuvres SET idCategorie= :idCategorie WHERE idOeuvre = :idOeuvre');
                self::$database->bind(':idCategorie', $elementModif["idCategorie"]);
                self::$database->bind(':idOeuvre', $idOeuvre);
                self::$database->execute();
            }
            catch(Exception $e) {
                $msgErreurs["errModifCategorie"] = $e->getMessage();
            }
            return $msgErreurs;//array vide = succès.
        }
    }
    
    /**
    * @brief Méthode qui valide les champs obligatoires lors d'une modification ou d'un ajout d'oeuvre.
    * @param string $titre
    * @param string $adresse
    * @param string $description
    * @param string $categorie
    * @param string $arrondissement
    * @access private
    * @return array
    */
    private function validerFormOeuvre($titre, $adresse, $description, $categorie, $arrondissement) {
        
        $msgErreurs = array();//Initialise les messages d'erreur à un tableau vide.
        
        $titre = trim($titre);
        if (empty($titre)) {
            $msgErreurs["errTitre"] = "Veuillez entrer un titre";
        }
        $adresse = trim($adresse);
        if (empty($adresse)) {
            $msgErreurs["errAdresse"] = "Veuillez entrer une adresse";
        }
        else if (!preg_match("/^[0-9]+[A-ÿ.,' \-]+$/",$adresse)) {
                $msgErreurs["errAdresse"] = "L'adresse doit commencer par le numéro civique, suivi du nom de la rue";
        }
        $description = trim($description);
        if (empty($description)) {
            $msgErreurs["errDescription"] = "Veuillez entrer une description";
        }

        $categorie = trim($categorie);
        if (empty($categorie)) {
            $msgErreurs["errCategorie"] = "Veuillez entrer une catégorie";
        }

        $arrondissement = trim($arrondissement);
        if (empty($arrondissement)) {
            $msgErreurs["errArrondissement"] = "Veuillez entrer un arrondissement";
        }
        return $msgErreurs;
    }
    
    /**
    * @brief Méthode qui récupère l'id d'une oeuvre en fonction de son titre et son adresse.
    * @param string $titre
    * @param string $adresse
    * @access public
    * @return string
    */
    public function getIdOeuvreByTitreandAdresse($titre,$adresse) {
        
        $idOeuvre = "";
        
        self::$database->query("SELECT idOeuvre FROM Oeuvres WHERE titre = :titre and adresse = :adresse");
        self::$database->bind(':titre', $titre);
         self::$database->bind(':adresse', $adresse);
        

       if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $idOeuvre = $oeuvreBDD['idOeuvre'];
        }
        return $idOeuvre;
    }
    
    /**
    * @brief Méthode qui ajoute une oeuvre dans la BDD.
    * @param string $titre
    * @param string $adresse
    * @param string $prenomArtiste
    * @param string $nomArtiste
    * @param string $description
    * @param string $categorie
    * @param string $arrondissement
    * @param boolean $authorise
    * @param string $langue
    * @access public
    * @return void
    */
    public function ajouterOeuvrePourTest($titre, $adresse, $prenomArtiste, $nomArtiste, $description, $categorie, $arrondissement, $authorise, $langue) {
  
        $artiste = new Artiste();
        $idArtistes = array();
        $artiste->ajouterArtiste($prenomArtiste, $nomArtiste, null);
        $idArtisteAjoute = $artiste->getArtisteIdByName($prenomArtiste, $nomArtiste, null);
        $idArtistes[] = $idArtisteAjoute;
        
        self::$database->query('INSERT INTO Oeuvres ( titre, noInterneMtl, latitude, longitude, parc, batiment, adresse, descriptionFR, descriptionEN, authorise, idCategorie, idArrondissement) VALUES (:titre, null, null, null, null, null, :adresse, :descriptionFR, :descriptionEN, :authorise, :idCategorie, :idArrondissement)');

        if ($langue == "FR") {
            self::$database->bind(':descriptionFR', $description.$langue);
            self::$database->bind(':descriptionEN', "");
        }
        else if ($langue == "EN") {
            self::$database->bind(':descriptionEN', $description.$langue);
            self::$database->bind(':descriptionFR', "");
        }
        self::$database->bind(':authorise', $authorise);        
        self::$database->bind(':titre', $titre);       
        self::$database->bind(':adresse', $adresse);       
        self::$database->bind(':idCategorie', $categorie);
        self::$database->bind(':idArrondissement', $arrondissement);
        self::$database->execute();

        $idOeuvre = $this->getIdOeuvreByTitreandAdresse($titre, $adresse);//aller chercher id oeuvre insérée
        
        $artiste->lierArtistesOeuvre($idOeuvre, $idArtistes);//Lier les artistes à l'oeuvre
    }
    
    /**
    * @brief Méthode qui accepte une soumission d'oeuvre.
    * @param string $type
    * @param integer $id
    * @access public
    * @return array
    */
    public function accepterSoumission ($id) {
        $msgErreurs = array();//Initialise les messages d'erreur à un tableau vide.
        
        try {
            self::$database->query('UPDATE Oeuvres SET authorise= true WHERE idOeuvre = :id');
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
    * @brief Méthode pour vérifier si une personne a deja visiter une oeuvre
    * @param string $type
    * @param integer $idOeuvre, $idUtilisateur
    * @access public
    * @return boolean
    */
     public function aVisiteOeuvre($idOeuvre, $idUtilisateur){
        self::$database->query('SELECT * FROM visitent WHERE idOeuvre = :idOeuvre and idUtilisateur = :idUtilisateur');

        self::$database->bind(':idOeuvre', $idOeuvre);
        self::$database->bind(':idUtilisateur', $idUtilisateur);
        

       if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $idOeuvre = false;
        }else $idOeuvre = true;
        return $idOeuvre;
    }
      /**
    * @brief Méthode pour insérer une oeuvre dans la bdd
    * @param string $type
    * @param integer $idOeuvre, $idUtilisateur, $laDate
    * @access public    
    */
    public function visiteOeuvre($idOeuvre, $idUtilisateur, $laDate){
        self::$database->query('INSERT INTO visitent (idOeuvre, idUtilisateur, dateVisite) VALUES (:idOeuvre, :idUtilisateur, :laDate)');

        self::$database->bind(':idOeuvre', $idOeuvre);
        self::$database->bind(':idUtilisateur', $idUtilisateur);
        self::$database->bind(':laDate', $laDate);

        self::$database->execute();  
    }
}
?>