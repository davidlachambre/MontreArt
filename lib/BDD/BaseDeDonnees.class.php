<?php

// http://culttt.com/2012/10/01/roll-your-own-pdo-php-class/


/**
 * @brief class BaseDeDonnees
 * @version 1.0
 */
class BaseDeDonnees {

    private $hote = HOTE;
    private $utilisateur = UTILISATEUR;
    private $pass = PASS;
    private $nombd = BDD;
    private $database;
    private $erreur;
    // variable pour la requête à exécuter
    private $instruction;
    private static $_instance = null;

    /*
	Obtenir l'instance de la classe.
	@return instance
    @author Jonathan Martel
	*/
	public static function getInstance() {
		if(!self::$_instance) 
		{ // Si aucun instance, creer l'instance
			self::$_instance = new self();
		}
		return self::$_instance;
	}
    
    /**
     * @brief Constructeur privé
     */
    private function __construct() {
        // Set DSN
        $dsn = 'mysql:host=' . $this->hote . ';dbname=' . $this->nombd;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT => true, // Pour des connexions persistantes
            // qui ne sont pas fermées à la fin du script
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION   // PDO lancera une exception PDOException 
            // en cas d'erreur
        );
        // Créer une nouvelle instance de PDO
        try {
            $this->database = new PDO($dsn, $this->utilisateur, $this->pass, $options);
        }
        // Capturer le erreurs éventuelles
        catch (PDOException $e) {
            $this->erreur = $e->getMessage();
        }
    }

    /**
     * @brief Empêche le clonage de l'objet
     */
    // 
    private function __clone() {
        
    }
    
    /**
     * @brief  Fonction pour Préparer la requête
     * @param string $requete la requête à préparer.
     */
    // 
    public function query($requete) {
        $this->database->query("SET NAMES 'utf8'");//Pour affichage des caractères spéciaux correct.
        $this->instruction = $this->database->prepare($requete);
    }

    /**
     * @brief  Fonction pour lier les paramètres de la requête aux valeurs
     * @param string $param est le marqueur qui sera utiisé dans la requête SQL.
     * @param string $value est la valeur que l'on veut attribuer au paramètre (marqueur)
     * @param string $type est le type du paramètre, exemple string.
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->instruction->bindValue($param, $value, $type);
    }

    /**
     * @brief Méthode qui exécute la requête préparée.
     */
    public function execute() {
        try {
            $resultat = $this->instruction->execute();
        }
        catch(PDOException $e) {
            $msgErreur = "Erreur de traitement : " . $e->getMessage();
            return $msgErreur;
        }
    }

    /**
     * @brief Cette  fonction retourne un tableau de lignes qui contiennent le résultat de la requête.
     * @return array tableau associatif contenant le resultat de la requête
     */
    public function resultset() {
        $this->execute();
        return $this->instruction->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @brief  La méthode uneLigne retourne une enregistrement.
     * @return array une ligne de resultat de la requête
     */
    public function uneLigne() {
        $this->execute();
        return $this->instruction->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @brief nbLignes retourne le nombre de lignes affectées par delete, update ou insert.
     * @return integer  nombre de lignes affectées
     */
    public function nbLignes() {
        return $this->instruction->rowCount();
    }

    /**
     * @brief nbLignes retourne l'ID du dernier enregistrement inséré. 
     * @return integer id du dernier enregistrement
     */
    public function dernierId() {
        return $this->database->lastInsertId();
    }

}


