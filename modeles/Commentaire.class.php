<?php
/**
* @brief class Commentaire
* @author David Lachambre
* @version 1.0
* @update 2015-12-14
*/
class Commentaire {
    
    /**
    * @var string $id Id du commentaire
    * @access private
    */
    private $id;
    
    /**
    * @var string $texte Texte du commentaire
    * @access private
    */
    private $texte;
    
    /**
    * @var string $vote Vote de l'utilisateur ayant laissé le commentaire
    * @access private
    */
    private $vote;
    
    /**
    * @var string $langue Langue originale du commentaire
    * @access private
    */
    private $langue;
    
    /**
    * @var string $authorise Détermine si le commentaire a passé l'étape de l'audit
    * @access private
    */
    private $authorise;

    /**
    * @var object Connection à la BDD
    */
    private static $database;
    
	function __construct() {
		
        if (!isset(self::$database)) {
            
            self::$database = BaseDeDonnees::getInstance();
        }
	}
    
    /**
    * @brief Méthode qui assigne des valeurs aux propriétés du commentaire
    * @param integer $id
    * @param string $texte
    * @param integer $vote
    * @param string $langue
    * @param boolean $authorise
    * @return void
    */
    public function setData($id, $texte, $vote, $langue, $authorise) {
        
		$this->id = $id;
		$this->texte = $texte;
		$this->vote = $vote;
		$this->langue = $langue;
		$this->authorise = $authorise;
	}
		
	/**
    * @brief Méthode qui récupère les valeurs des propriétés de cet objet
    * @access public
    * @return array
    */
	public function getData() {
        
        $resultat = array("id"=>$this->id, "texte"=>$this->texte, "vote"=>$this->vote, "langue"=>$this->langue, "authorise"=>$this->authorise);
        
        return $resultat;
	}
    
    /**
    * @brief Méthode qui récupère tous les commentaires associés à une oeuvre
    * @param $id integer
    * @param $langue string
    * @access public
    * @return array
    */
    public function getCommentairesByOeuvre($idOeuvre, $langue) {
        
        $infoCommentaires = array();
        
        self::$database->query('SELECT * FROM Commentaires JOIN Utilisateurs ON Utilisateurs.idUtilisateur = Commentaires.idUtilisateur WHERE Commentaires.idOeuvre = :id AND Commentaires.authorise = true AND Commentaires.langueCommentaire = :langue');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $idOeuvre);
        self::$database->bind(':langue', $langue);
        
        if ($commentairesBDD = self::$database->resultset()) {
            foreach ($commentairesBDD as $commentaire) {
                $unCommentaire = array("texteCommentaire"=>$commentaire["texteCommentaire"], "voteCommentaire"=>$commentaire["voteCommentaire"], "nomUsager"=>$commentaire["nomUsager"], "photoProfil"=>$commentaire["photoProfil"]);
                $infoCommentaires[] = $unCommentaire;
            }
        }
        return $infoCommentaires;
    }
    
    /**
    * @brief Méthode qui récupère un commentaire dans la BDD en fonction du id.
    * @access public
    * @return array
    */
    public function getCommentaireById($idCommentaire){
        
        $infoCommentaire = array();

        self::$database->query('SELECT Oeuvres.titre, Oeuvres.idOeuvre, Commentaires.idCommentaire, Commentaires.texteCommentaire, Commentaires.voteCommentaire, Commentaires.langueCommentaire FROM Commentaires JOIN Oeuvres ON Commentaires.idOeuvre = Oeuvres.idOeuvre WHERE Commentaires.idCommentaire = :idCommentaire');
        self::$database->bind(':idCommentaire', $idCommentaire);

        if($commentaireBDD = self::$database->uneLigne()){
            $infoCommentaire = $commentaireBDD;
        }
        return $infoCommentaire;        
    }
    
    /**
    * @brief Méthode qui récupère un commentaire dans la BDD en fonction du id.
    * @access public
    * @return array
    */
    public function ajoutCommentairesByOeuvre($idOeuvre, $langue, $texte, $vote, $idUtilisateur, $authorise) {
        $msgUtilisateur = "";
        $erreurs = false;


        if (isset($_POST["ajoutCommentaire"])) {      
           if (!empty($_POST["commentaireAjout"])){

                self::$database->query('INSERT INTO Commentaires ( texteCommentaire, voteCommentaire, langueCommentaire, authorise, idOeuvre, idUtilisateur, dateSoumissionCommentaire) VALUES (:texte, :vote, :langue, :authorise, :id, :idUtilisateur, CURDATE())');

                //Lie les paramètres aux valeurs
                self::$database->bind(':id', $idOeuvre);
                self::$database->bind(':langue', $langue);
                self::$database->bind(':texte', $texte);
                self::$database->bind(':vote', $vote);
                self::$database->bind(':idUtilisateur', $idUtilisateur);
                self::$database->bind(':authorise', $authorise);
                self::$database->execute();
                $msgUtilisateur = "<span style='color:green'>Commentaire envoyé !</span>";       
            }
            else {

             $msgUtilisateur = "ne laissez rien en blanc";
            }
        }
     return $msgUtilisateur;
    }
    
    /**
    * @brief méthode qui récupère tous les commentaires n'aillant pas encore été authorisés par l'administrateur
    * @access public
    * @return array
    */
    public function getAllCommentairesPourApprobation() {
        
        $commentaires = array();
        
        self::$database->query('SELECT idCommentaire, dateSoumissionCommentaire FROM Commentaires WHERE Commentaires.authorise = false');
        
               
        if ($commentairesBDD = self::$database->resultset()) {
            foreach ($commentairesBDD as $commentaire) {
                $commentaires[] = $commentaire;
            }
        }
        return $commentaires;
    }
    
    /**
    * @brief Méthode qui accepte une soumission commentaire.
    * @param string $type
    * @param integer $id
    * @access public
    * @return array
    */
    public function accepterSoumission ($id) {
        $msgErreurs = array();//Initialise les messages d'erreur à un tableau vide
        
        try {
            self::$database->query('UPDATE Commentaires SET authorise= true WHERE idCommentaire = :id');
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
    * @brief Méthode qui supprime un commentaire de la BDD.
    * @param integer $id
    * @access public
    * @return array
    */
    public function supprimerCommentaire($id) {
        
        $msgErreurs = array();
        
        try {
            self::$database->query('DELETE FROM Commentaires WHERE idCommentaire = :id');
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
        
    /**
    * @brief Méthode qui modifie un commentaire dans la BDD.
    * @param integer $idCommentaire
    * @param array $elementModif
    * @access public
    * @return array
    */
    public function modifierCommentaireSoumis($idCommentaire, $elementModif) {
        
        $msgErreurs = array();
        
        if (isset($elementModif["texteCommentaire"])) {
            try {
                self::$database->query('UPDATE Commentaires SET texteCommentaire= :texteCommentaire WHERE idCommentaire = :idCommentaire');
                self::$database->bind(':texteCommentaire', $elementModif["texteCommentaire"]);
                self::$database->bind(':idCommentaire', $idCommentaire);
                self::$database->execute();
            }
            catch(Exception $e) {
                $msgErreurs["errModifTexteCommentaire"] = $e->getMessage();
            }
        }
        else if (isset($elementModif["langueCommentaire"])) {
            try {
                self::$database->query('UPDATE Commentaires SET langueCommentaire= :langueCommentaire WHERE idCommentaire = :idCommentaire');
                self::$database->bind(':langueCommentaire', $elementModif["langueCommentaire"]);
                self::$database->bind(':idCommentaire', $idCommentaire);
                self::$database->execute();
            }
            catch(Exception $e) {
                $msgErreurs["errModifLangueCommentaire"] = $e->getMessage();
            }
        }
        return $msgErreurs;//array vide = succès.
    }
	
	/**
    * @brief fonction qui retourne une array avec les oeuvres les plus populaires selon les commentaires
    * @access public
    * @return array
    */
	public function getOeuvresPopulaires(){
		$oeuvresPopulaires = array();
			self::$database->query('SELECT idOeuvre FROM commentaires WHERE authorise=1 GROUP BY idOeuvre HAVING AVG(voteCommentaire)>3');
			
			 if ($oeuvresBDD = self::$database->resultset()) {
				foreach($oeuvresBDD as $unOeuvre){
					$oeuvresPopulaires[] = $unOeuvre;
				}
        }
        return $oeuvresPopulaires;
	}
	
	/**
    * @brief fonction qui retourne une array avec la moyenne de classement par oeuvre
    * @access public
    * @return array
    */
	public function getClassementOeuvre($idOeuvre){
		$oeuvre = array();
			self::$database->query('SELECT idOeuvre, ROUND(AVG(voteCommentaire),0) AS moyenne FROM commentaires WHERE authorise = 1 AND idOeuvre = :idOeuvre GROUP BY idOeuvre');
			self::$database->bind(':idOeuvre', $idOeuvre);
			 if ($oeuvreBDD = self::$database->uneLigne()) {
				$oeuvre = $oeuvreBDD;
        }
        return $oeuvre;
	}
	
	
}    
?>