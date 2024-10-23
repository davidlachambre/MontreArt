<?php

/**
* @brief class Utilisateur
* @author Cristina Mahneke
* @version 1.0
* @update 2016-02-05
*/
//require_once "lib/BDD/BaseDeDonnees.class.php";
class Utilisateur {
	 /**
    * @var integer $idUtilisateur id d'un utilisateur
    * @access private
    */ 
	private $idUtilisateur;
	
	 /**
    * @var string $nomUsager identifiant choisi par l'utilisateur
    * @access private
    */
	private $nomUsager;
	
	
	 /**
    * @var string $motPasse mot de passe de l'utilisateur
    * @access private
    */
	 private $motPasse;
	 
	 /**
    * @var string $prenom  prenom de l'utilisateur
    * @access private
    */
	 private $prenom;
	 
	  /**
    * @var string $nom nom de l'utilisateur
    * @access private
    */
	 private $nom;
	 
	   /**
    * @var string $courriel courriel electronique de l'utilisateur
    * @access private
    */
	 private $courriel;
	 
	   /**
    * @var string $descriptionProfil texte du description du profil de l'utilisateur
    * @access private
    */
	 private $descriptionProfil;
	 
	   /**
    * @var string $photoProfil chemin et nom du fichier image du profil de l'utilisateur
    * @access private
    */
	 private $photoProfil; 
	 
	  
	 
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
    * @brief Méthode qui assigne des valeurs aux propriétés de l'objet Utilisateur
     * @param string $nomUsager
    * @param string $motPasse
    * @param string $prenom
    * @param string $nom
	* @param string $courriel
	* @param string $descriptionProfil
	* @param string $photoProfil
	* @param string $administrateur
    * @access private
    * @return void
    */
	public function setData($idUtilisateur, $nomUsager, $motPasse, $prenom, $nom, $courriel, $descriptionProfil, $photoProfil, $administrateur){
		$this->idUtilisateur = $idUtilisateur;
		$this->nomUsager = $nomUsager;
		$this->motPasse = $motPasse;
		$this->prenom = $prenom;
		$this->nom = $nom;
		$this->courriel = $courriel;
		$this->descriptionProfil = $descriptionProfil;
		$this->photoProfil = $photoProfil;
		$this->administrateur = $administrateur;
	}
	
	/**
    * @brief méthode qui récupère les valeurs des propriétés de cet objet.
    * @access public
    * @return array
    */
	public function getData(){
		
		$resultat = array("idUtilisateur"=>$this->idUtilisateur, "nomUsager"=>$this->nomUsager, "motPasse"=>$this->motPasse, "prenom"=>$this->prenom, "nom"=>$this->nom, "courriel"=>$this->courriel, "descriptionProfil"=>$this->descriptionProfil, "photoProfil"=>$this->photoProfil, "administrateur"=>$this->administrateur);
		
		return $resultat;
	}
	
     /**
    * @brief Méthode qui ajoute un utilisateur à la BDD.
    * @param string $nomUsager
    * @param string $motPasse
    * @param string $prenom
    * @param string $nom
	* @param string $courriel
	* @param string $descriptionProfil
	* @param string $administrateur
    * @access private
    * @return void
    */
    public function AjouterUtilisateur($nomUsager, $motPasse, $prenom, $nom, $courriel, $descriptionProfil, $administrateur){
		$msgErreurs = $this->validerFormAjoutUtilisateur($nomUsager, $motPasse, $prenom, $nom, $courriel);
		 if (!empty($msgErreurs)) {
            return $msgErreurs;//Retourne le/les message(s) d'erreur de la validation.
        }
        else {
			try{
				
				self::$database->query('INSERT INTO utilisateurs (nomUsager, motPasse, prenom, nom, courriel, descriptionProfil, administrateur) VALUES (:nomUsager, :motPasse, :prenom, :nom, :courriel, :descriptionProfil, :administrateur)');
				self::$database->bind(':nomUsager', $nomUsager);
				self::$database->bind(':motPasse', $motPasse);
				self::$database->bind(':prenom', $prenom);
				self::$database->bind(':nom', $nom);
				self::$database->bind(':courriel', $courriel);
				self::$database->bind(':descriptionProfil', $descriptionProfil);
				self::$database->bind(':administrateur', $administrateur);
				self::$database->execute();

                //Récupération du nouvel id utilisateur
                if ($nouvelUtilisateur = $this->getUtilisateurByNomUsager($nomUsager)) {
                    $idUsager = $nouvelUtilisateur["idUtilisateur"];
                
                    //Insertion de la photo de profil si choisie
                    $photo = new Photo();
                    $msgInsertPhoto = $photo->ajouterPhoto($idUsager, true, "utilisateur");
                    if ($msgInsertPhoto != "" && $_FILES["fileToUpload"]["error"] != 4) {
                        $msgErreurs["errPhoto"] = $msgInsertPhoto;
                    }
                }
                
			}catch(Exception $e){
				 $msgErreurs["errRequeteAjout"] = $e->getMessage();
			}
        }
        return $msgErreurs;//array vide = succès. 
    }		
	
	/**
    * @brief méthode qui récupère les donnees d'un utilisateur par son nom usager et son mot de passe
    * @access public
    * @return array
    */
	
	public function getUtilisateurByNomUsager($nomUsager){
		
		self::$database->query('SELECT * FROM utilisateurs WHERE utilisateurs.nomUsager = :nomUsager');
		self::$database->bind(':nomUsager', $nomUsager);
		
		if($Utilisateur = self::$database->uneLigne()){
			return $Utilisateur;
		}else{
			return false;
		}
	}
		/**
    * @brief méthode qui récupère les donnees d'un utilisateur par son courriel
    * @access public
    * @return array
    */
	
	public function getUtilisateurByCourriel($courriel){
		
		self::$database->query('SELECT * FROM utilisateurs WHERE utilisateurs.courriel = :courriel');
		self::$database->bind(':courriel', $courriel);
		
		if($Utilisateur = self::$database->uneLigne()){
			return $Utilisateur;
		}else{
			return false;
		}
	}
	/**
    * @brief Méthode qui valide les champs du formulaire de ajoute utilisateur
    * @param string $nomUsager
    * @param string $motPasse
    * @param string $nom
    * @param string $prenom
    * @param string $courriel
    * @access private
    * @return array
    */
    public function validerFormAjoutUtilisateur($nomUsager, $motPasse, $prenom, $nom, $courriel) {
		$msgErreurs = array();//Initialise les messages d'erreur à un tableau vide.
        
        $nomUsager = trim($nomUsager);
        if (empty($nomUsager)) {
            $msgErreurs["errNomUsager"] = "Veuillez choisir un nom usager";
        }
		$usagerExiste = $this->getUtilisateurByNomUsager($nomUsager);
		if ($usagerExiste){
			 $msgErreurs["errNomUsager"] = "Ce nom usager existe déjà dans notre base de données, veuillez choisir une autre";	
		}
        $motPasse = trim($motPasse);
        if (empty($motPasse)) {
            $msgErreurs["errMotPasse"] = "Veuillez ecrire un mot de passe.";
        }
		
		$prenom = trim($prenom);
        if (empty($prenom)) {
            $msgErreurs["errPrenom"] = "Veuillez entrer votre prenom";
        }

        $nom = trim($nom);
        if (empty($nom)) {
            $msgErreurs["errNom"] = "Veuillez entrer votre nom de famille";
        }

        $courriel = trim($courriel);
		$courrielExiste = $this->getUtilisateurByCourriel($courriel);
        if (empty($courriel)) {
            $msgErreurs["errCourriel"] = "Veuillez entrer votre courriel";
        }
		 elseif ($courrielExiste){
			$msgErreurs["errCourriel"] = "Ce courriel existe déjà dans notre base de données";
		}
		 elseif (!preg_match("^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$^",$courriel)) {
                 $msgErreurs["errCourriel"] = "Veuillez reviser le format de votre courriel.";
        }
        return $msgErreurs;
	}
    
    /**
    * @brief méthode qui connecte l'utilisateur
    * @access public
    * @return 
    */
	public function connexionUtilisateur($nomUsager, $motPasseSoumis){

		self::$database->query('SELECT motPasse FROM Utilisateurs WHERE nomUsager = :nomUsager');
        self::$database->bind(':nomUsager', $nomUsager);
		
		if($utilisateur = self::$database->uneLigne()) {

            $motDePasseGrainSel = md5($_SESSION["grainSel"] . $utilisateur["motPasse"]);
            
            if ($motDePasseGrainSel === $motPasseSoumis) {
                
                self::$database->query('SELECT nomUsager, idUtilisateur, administrateur FROM Utilisateurs WHERE nomUsager = :nomUsager');
                self::$database->bind(':nomUsager', $nomUsager);
                
                $utilisateur = self::$database->uneLigne();
                return $utilisateur;
            }
            else {
                return false;
            }
		}
        else {
			return false;
		}
	}
    /**
    * @brief Méthode pour compter le nombre d'oeuvre visité
    * @param string $type
    * @param integer $idUtilisateur
    * @access public
    * @return boolean
    */
     public function countVisiteOeuvre($idUtilisateur){
        self::$database->query('SELECT COUNT(*) FROM visitent WHERE idUtilisateur = :idUtilisateur');

        self::$database->bind(':idUtilisateur', $idUtilisateur);
        

       if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $idOeuvre = $oeuvreBDD;
        }else $idOeuvre = 0;
        return $idOeuvre;
    }
    /**
    * @brief Méthode qui récupère une oeuvre authorisée dans la BD
    * @param integer $id
    * @access public
    * @return array
    */
    public function getUtilisateurById($idUtilisateur) {
        
        self::$database->query('SELECT * FROM utilisateurs WHERE idUtilisateur = :utilisateur');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':utilisateur', $idUtilisateur);
        
        $infoUtilisateur = array();
        
        if ($utilisateurBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $infoUtilisateur = $utilisateurBDD;
        }
        return $infoUtilisateur;
    }
        /**
    * @brief Méthode qui modifie le contenu d'un utilisateur
    * @param integer $idUtilisateur
    * @param string $nomUsager
    * @param string $motPasse
    * @param string $prenom
    * @param string $nom
    * @param string $courriel
    * @param string $descriptionProfil
    * @param string $photoProfil
    * @param string $administrateur
    * @access public
    * @return void
    */
    public function modifierUtilisateur($motPasse, $prenom, $nom, $descriptionProfil,$idUtilisateur) {
 
        $msgErreurs = $this->validerFormUtilisateur($prenom, $nom, $descriptionProfil);//Validation des champs obligatoires.
        
        if ($msgErreurs === null) {
            return $msgErreurs;//Retourne le/les message(s) d'erreur de la validation.
        }
        else {
            try {
                if ($motPasse == "") {
//                    return "test2";
                    self::$database->query('UPDATE utilisateurs SET prenom= :prenom, nom= :nom, descriptionProfil= :descriptionProfil WHERE idUtilisateur = :idUtilisateur');      
                    self::$database->bind(':prenom', $prenom);       
                    self::$database->bind(':nom', $nom);
                    self::$database->bind(':descriptionProfil', $descriptionProfil);
                    self::$database->bind(':idUtilisateur', $idUtilisateur);
                }
                else {
                    self::$database->query('UPDATE utilisateurs SET motPasse= :motPasse, prenom= :prenom, nom= :nom, descriptionProfil= :descriptionProfil WHERE idUtilisateur = :idUtilisateur');
                    self::$database->bind(':motPasse', $motPasse);       
                    self::$database->bind(':prenom', $prenom);       
                    self::$database->bind(':nom', $nom);
                    self::$database->bind(':descriptionProfil', $descriptionProfil);
                    self::$database->bind(':idUtilisateur', $idUtilisateur);
                }        
                self::$database->execute();
                
              
            }
            catch(Exception $e) {
                $msgErreurs["errRequeteModif"] = $e->getMessage();
            }
        }
        return $msgErreurs;//array vide = succès. 
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
    private function validerFormUtilisateur($prenom, $nom, $descriptionProfil) {
        
        $msgErreurs = array();//Initialise les messages d'erreur à un tableau vide.
        
        $prenom = trim($prenom);
        if (empty($prenom)) {
            $msgErreurs["errTitre"] = "Veuillez entrer un titre";
        }
        $nom = trim($nom);
        if (empty($nom)) {
            $msgErreurs["errAdresse"] = "Veuillez entrer une adresse";
        }
        $descriptionProfil = trim($descriptionProfil);
        if (empty($descriptionProfil)) {
            $msgErreurs["errDescription"] = "Veuillez entrer une description";
        }
        return $msgErreurs;
    }
        /**
    * @brief Méthode qui récupère les artistes d'une oeuvre.
    * @param int $idOeuvre
    * @access public
    * @return array
    */
    public function getOeuvresVisiter ($idUtilisateur) {
        
        $infoVisite = array();
        
        self::$database->query('SELECT * FROM oeuvres JOIN visitent ON visitent.idOeuvre = oeuvres.idOeuvre WHERE visitent.idUtilisateur = :idUtilisateur');
        self::$database->bind(':idUtilisateur', $idUtilisateur);
        
        if ($lignes = self::$database->resultset()) {
              foreach ($lignes as $oeuvres) {
                $uneOeuvre = array("titre"=>$oeuvres["titre"], "idOeuvre"=>$oeuvres["idOeuvre"]);
                $infoVisite[] = $uneOeuvre;
            }
           
        } return $infoVisite;
    }
}//fin class Utilisateur
?>