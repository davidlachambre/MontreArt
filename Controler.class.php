<?php
/**
 * Class Controler
 * Gère les requêtes HTTP
 * 
 * @author Jonathan Martel
 * @author David Lachambre
 * @version 1.1
 * @update 2015-12-14
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 */

class Controler {
    
    /**
    * @var object $oVue Contient la composante vue du MVC
    * @access private
    */
    private $oVue;
    
    /**
    * @var object $oCookie Cookie du site
    * @access private
    */
    private $oCookie;
    
    /**
    * @var string $metaPageAccueil Contenu personnalisé à intégrer dans le head de la page d'accueil
    * @access private
    */
    private $metaPageAccueil;
    
    /**
    * @var string $metaPageOeuvre Contenu personnalisé à intégrer dans le head de la page d'une oeuvre
    * @access private
    */
    private $metaPageOeuvre;
    
    /**
    * @var string $langueAffichage Langue d'affichage du site
    * @access private
    */
    private $langueAffichage;
    
    /**
    * @var string $pAccueil Page accueil
    * @access private
    */
    private $pAccueil;
    
    /**
    * @var string $pOeuvre Page d'une oeuvre
    * @access private
    */
    private $pOeuvre;
    
     /**
    * @var string $pOeuvreSoumise Page d'une oeuvre pas encore approuvée - pour l'admin
    * @access private
    */
    private $pOeuvreSoumise;
    
    /**
    * @var string $pTrajet Page de trajet
    * @access private
    */
    private $pTrajet;
    
    /**
    * @var string $pSoumission Page soumission d'une oeuvre
    * @access private
    */
    private $pSoumission;
    
    /**
    * @var string $pProfil Page de profil utilisateur
    * @access private
    */
    private $pProfil;
    
    /**
    * @var string $pRecherche Page d'affichage des résultats de la recherche
    * @access private
    */
    private $pRecherche;
    
    /**
    * @var string $pAdmin Page admin (à fusionner avec gestion)
    * @access private
    */
    private $pAdmin;
    
    /**
    * @var string $pGestion Page de gestion pour l'administrateur
    * @access private
    */
    private $pGestion;
    
     /**
    * @var string $pDevenirMembre Page avec formulaire pour les utilisateurs qui vuelent s'enregistrer
    * @access private
    */
    private $pDevenirMembre;
    
    
    /**
    * @brief Constructeur, initialise les propriétés
    * @access public
    * @return void
    */
    public function __construct() {
        
        $this->pAccueil = "accueil";
        $this->pOeuvre = "oeuvre";
        $this->pOeuvreSoumise = "oeuvreSoumise";
        $this->pTrajet = "trajet";
        $this->pSoumission = "soumission";
        $this->pProfil = "profil";
        $this->pRecherche = "recherche";    
        $this->pGestion = "gestion";
         $this->pDevenirMembre = "devenir_membre";
        $this->oCookie = new Cookie();
        $this->langueAffichage = $this->oCookie->getLangue();
    }
    
    /**
    * @brief Traite la requête GET
    * @access public
    * @return void
    */
     public function gerer() {
         
        session_start();//Initialisation de la session utilisateur.
        if(!isset($_SESSION["grainSel"])) {
            $nombreAleatoire = rand(1, 1000);
            $_SESSION["grainSel"] = $nombreAleatoire;
        }
        
        switch ($_GET['r']) {//requête
            case $this->pAccueil:
                $this->accueil();
                break;
            case $this->pOeuvre:
                $this->oeuvre();
                break;
            case $this->pOeuvreSoumise:
                $this->oeuvreSoumise();
                break;
            case $this->pTrajet:
                $this->trajet();
                break;
            case $this->pSoumission:
                $this->soumission();
                break;
            case $this->pProfil:
                $this->profil();
                break;
            case $this->pRecherche:
                $this->recherche();
                break;
            case $this->pGestion:
                $this->gestion();
                break;
            case $this->pDevenirMembre:
                $this->devenirMembre();
                break;
            default:
                $this->accueil();
                break;
        }
    }
    
    
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page d'accueil
    * @access private
    * @return void
    */
    private function accueil() {
        
        $commentaire = new Commentaire ();
        $photoOeuvreVedette = "";
        
        if ($oeuvresPopulaires = $commentaire->getOeuvresPopulaires()) {
            $nbOeuvresPopulaires = count($oeuvresPopulaires);
            $noAleatoire = rand(1,$nbOeuvresPopulaires);
            $oeuvreVedette = array();
            $oeuvreVedette[] = $oeuvresPopulaires[$noAleatoire-1];
            $photo = new Photo();
            $photoOeuvreVedette = $photo->getPhotoByIdOeuvre($oeuvreVedette[0]["idOeuvre"]);
        }
        
        $this->oVue = new VueAccueil();  
        $this->oVue->setDataGlobal("Accueil", "Page d'accueil", $this->langueAffichage, $this->pAccueil); 
        $this->oVue->setData($photoOeuvreVedette);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page d'une oeuvre
    * @access private
    * @return void
    */
    private function oeuvre() {
        
        $oeuvre = new Oeuvre();
        if (isset($_GET["approbation"])) {
            $oeuvreAffichee = $oeuvre->getAnyOeuvreById($_GET["o"]);
        }
        else {
            $oeuvreAffichee = $oeuvre->getOeuvreById($_GET["o"]);
        }
        
        $commentaire = new Commentaire();
        $commentairesOeuvre = $commentaire->getCommentairesByOeuvre($_GET["o"], $this->langueAffichage);
        
        $classement = $commentaire-> getClassementOeuvre($_GET["o"]);
                
        $photo = new Photo();
        $photosOeuvre = $photo->getPhotosByOeuvre($_GET["o"], false);
        
        if (isset($_GET['action']) && $_GET['action'] == 'envoyerPhoto') {
            $msgInsertPhoto = $photo->ajouterPhoto($_GET["o"], false, "oeuvre");
        }
        else {
            $msgInsertPhoto = null;
        }
        if (isset($_GET['action']) && $_GET['action'] == 'envoyerCommentaire') {
            
            if (isset($_SESSION["idUsager"])) {
                $usager = $_SESSION["idUsager"];
            }
            else {
                $usager = 1;//id usager anonyme
            }

            $msgInsertCommentaire = $commentaire->ajoutCommentairesByOeuvre($_POST['idOeuvreencours'], $this->langueAffichage, $_POST['commentaireAjout'],$_POST['vote'], $usager, false); 
        }
        else {
            $msgInsertCommentaire = null;
        }    
        $artiste = new Artiste();
        $artistesOeuvre = $artiste->getArtistesbyOeuvreId ($_GET["o"]);
        
        $this->oVue = new VueOeuvre();
        $this->oVue->setDataGlobal('oeuvre', "page d'une oeuvre", $this->langueAffichage, $this->pOeuvre);
        $this->oVue->setData($oeuvreAffichee, $commentairesOeuvre, $photosOeuvre, $artistesOeuvre,$classement, $this->langueAffichage);
        $this->oVue->setMsgPhoto($msgInsertPhoto);
        $this->oVue->setMsgCommentaire($msgInsertCommentaire);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page d'une oeuvre qui n'a pas encore été approuvée - pour les utilisateurs admin
    * @access private
    * @return void
    */
    private function oeuvreSoumise() {
        
        $oeuvre = new Oeuvre();
        $oeuvreAffichee = $oeuvre->getAnyOeuvreById($_GET["o"]);
        
        $commentaire = new Commentaire();
        $commentairesOeuvre = $commentaire->getCommentairesByOeuvre($_GET["o"], $this->langueAffichage);
                
        $photo = new Photo();
        $photosOeuvre = $photo->getPhotosByOeuvre($_GET["o"], false);
 
        $artiste = new Artiste();
        $artistesOeuvre = $artiste->getArtistesbyOeuvreId ($_GET["o"]);
        
        $this->oVue = new VueOeuvreSoumise();
        $this->oVue->setDataGlobal('oeuvreSoumise', "page d'une oeuvre soumise", $this->langueAffichage, $this->pOeuvreSoumise);
        $this->oVue->setData($oeuvreAffichee, $commentairesOeuvre, $photosOeuvre, $artistesOeuvre, $this->langueAffichage);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }

    /**
    * @brief Méthode qui appelle la vue d'affichage de la page de trajet
    * @access private
    * @return void
    */
    private function trajet() {
        
        $this->oVue = new VueTrajet();
        $this->oVue->setDataGlobal('trajet', "page de création d'un trajet", $this->langueAffichage, $this->pTrajet);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page de soumission
    * @access private
    * @return void
    */
    private function soumission() {
        
        $oeuvre = new Oeuvre();
        $arrondissement = new Arrondissement();
        $categorie = new Categorie();
        
        //Ajout d'une oeuvre.
        $authorise = false;
        
        //Essaie l'ajout et récupère les messages d'erreur si présents.
        $msgErreurs = array();
        if (isset($_POST["boutonAjoutOeuvre"])) {
            $msgErreurs = $oeuvre->AjouterOeuvre($_POST['titreAjout'], $_POST['adresseAjout'], $_POST['prenomArtisteAjout'], $_POST['nomArtisteAjout'], $_POST['descriptionAjout'], $_POST["selectCategorie"], $_POST["selectArrondissement"], $authorise, $this->langueAffichage);
        }
        
        $oeuvresBDD = $oeuvre->getAllOeuvres();
        $arrondissementsBDD = $arrondissement->getAllArrondissements();
        $categorieBDD = $categorie->getAllCategories($this->langueAffichage);
        
        $this->oVue = new VueSoumission();
        $this->oVue->setDataGlobal('soumission', "page de soumission d'oeuvre", $this->langueAffichage, $this->pSoumission);
        $this->oVue->setData($oeuvresBDD, $arrondissementsBDD, $categorieBDD, $msgErreurs);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page de profil
    * @access private
    * @return void
    */
    private function profil() {
        $msgErreurs = array();
        $utilisateur = new Utilisateur();
        $nbrOeuvreVisite='';
        $profilUtilisateur="";
        $oeuvreVisiter="";
        $informationsAModifier = "";

        if (isset($_SESSION["idUsager"])){
            //Affichage du nombre d'oeuvre visité
            $nbrOeuvreVisite = $utilisateur->countVisiteOeuvre($_SESSION["idUsager"]);
            //Affichage du profil utilisateur
            $profilUtilisateur = $utilisateur->getUtilisateurById($_SESSION["idUsager"]);
            $informationsAModifier = $profilUtilisateur; 
            $oeuvreVisiter = $utilisateur->getOeuvresVisiter($_SESSION["idUsager"]);      
        }
        $this->oVue = new VueProfil();
        $this->oVue->setDataGlobal('profil', "page de profil utilisateur", $this->langueAffichage, $this->pProfil);
        $this->oVue->setData($nbrOeuvreVisite,$profilUtilisateur,$informationsAModifier,$msgErreurs,$oeuvreVisiter);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page gestion
    * @access private
    * @return void
    */
    private function gestion() {
        
        $oeuvre = new Oeuvre();
        $arrondissement = new Arrondissement();
        $categorie = new Categorie();
        $photo = new Photo();
        $commentaire = new Commentaire();
        $msgErreurs = array();
        $oeuvreAjouter = '';
        
        //Mise à jour des oeuvres de la ville de Montréal
        if (isset($_POST["misAJour"])) {
            $msgErreurs = $oeuvre->updaterOeuvresVille();
        }
        
        //Affichage de la date de dernière mise à jour des oeuvres de la ville.
        $date = $oeuvre->getDateDernierUpdate();
        
        //Suppression d'une oeuvre.
        if (isset($_POST["boutonSuppOeuvre"])) {
            $msgErreurs = $oeuvre->supprimerOeuvre($_POST["selectOeuvreSupp"]);
        }
        
        //Ajout d'une oeuvre.
        $authorise = true;

        //Essaie l'ajout et récupère les messages d'erreur si présents.
        if (isset($_POST["boutonAjoutOeuvre"])) {
            $msgErreurs = $oeuvre->AjouterOeuvre($_POST['titreAjout'], $_POST['adresseAjout'], $_POST['prenomArtisteAjout'], $_POST['nomArtisteAjout'], $_POST['descriptionAjout'], $_POST["selectCategorie"], $_POST["selectArrondissement"], $authorise, $this->langueAffichage);
        }
        
        //Modification d'une oeuvre.
        if (isset($_POST["selectOeuvreModif"]) && $_POST["selectOeuvreModif"] != "") {
            $oeuvreAModifier = $oeuvre->getOeuvreById($_POST['selectOeuvreModif']);
        }
        else {
            $oeuvreAModifier = "";
        }
        
        //Tente la modif et récupère les messages d'erreur si présents.
        if (isset($_POST["boutonModifOeuvre"])) {
            $msgErreurs = $oeuvre->modifierOeuvre($_POST["selectOeuvreModif"], $_POST["titreModif"], $_POST["adresseModif"], $_POST["descriptionModif"], $_POST["selectCategorieModif"], $_POST["selectArrondissementModif"], $this->langueAffichage);
        }
        
        //Ajout d'une catégorie
        if (isset($_POST["boutonAjoutCategorie"])) {
            $msgErreurs = $categorie->ajouterCategorie($_POST["categorieFrAjout"], $_POST["categorieEnAjout"]);
        }
        
        //Suppression d'une catégorie
        if (isset($_POST["boutonSuppCategorie"])) {
            $msgErreurs = $categorie->supprimerCategorie($_POST["selectCategorieSupp"]);
        }
        
        //Soumissions des utilisateurs pour approbation par l'administrateur
        $oeuvresApprobation = $oeuvre->getAllOeuvresPourApprobation();
        $photosApprobation = $photo->getAllPhotosPourApprobation();
        $commentairesApprobation = $commentaire->getAllCommentairesPourApprobation();
        
        $oeuvresBDD = $oeuvre->getAllOeuvres();
        $arrondissementsBDD = $arrondissement->getAllArrondissements();
        $categorieBDD = $categorie->getAllCategories($this->langueAffichage);
        
        $this->oVue = new VueGestion();
        $this->oVue->setDataGlobal("Gestion", "page de gestion par l'administrateur", $this->langueAffichage, $this->pGestion);
        $this->oVue->setData($date, $oeuvreAModifier,$oeuvreAjouter, $oeuvresBDD, $arrondissementsBDD, $categorieBDD, $msgErreurs, $oeuvresApprobation, $photosApprobation, $commentairesApprobation);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    /**
    * @brief Méthode qui affiche les résultats de la recherche utilisateur
    * @access private
    * @return void
    */
    private function recherche() {
        
        $oeuvres = array();
        $typeRecherche = "";
        $nomRecherche = "";
            
        if (isset($_POST["boutonRecherche"])) {
            
            if (isset($_POST["selectArrondissement"]) && $_POST["selectArrondissement"] != "") {
                $oeuvre = new Oeuvre();
                $oeuvres = $oeuvre->getAllOeuvresByArrondissement($_POST["selectArrondissement"]); 
                $typeRecherche = "par arrondissement";
                $arrondissement = new Arrondissement();
                $nomRecherche = $arrondissement->getArrondissementNameById($_POST["selectArrondissement"]);
            }
            else if (isset($_POST["selectCategorie"]) && $_POST["selectCategorie"] != "") {
                $oeuvre = new Oeuvre();
                $oeuvres = $oeuvre->getAllOeuvresByCategorie($_POST["selectCategorie"]);
                $typeRecherche = "par catégorie";
                $categorie = new Categorie();
                $nomRecherche = $categorie->getCategorieNameById($_POST["selectCategorie"]);
            }
        }
        else if (isset($_GET["rechercheParArtiste"])) {
            $oeuvre = new Oeuvre();
            $oeuvres = $oeuvre->getAllOeuvresByArtiste($_GET["rechercheParArtiste"]);
            $typeRecherche = "par artiste";
            $nomRecherche = $_GET["nomArtiste"];
        }
        else if (isset($_POST["boutonRechercheMobile"])) {
            
            if (isset($_POST["selectArrondissementMobile"]) && $_POST["selectArrondissementMobile"] != "") {
                $oeuvre = new Oeuvre();
                $oeuvres = $oeuvre->getAllOeuvresByArrondissement($_POST["selectArrondissementMobile"]); 
                $typeRecherche = "par arrondissement";
                $arrondissement = new Arrondissement();
                $nomRecherche = $arrondissement->getArrondissementNameById($_POST["selectArrondissementMobile"]);
            }
            else if (isset($_POST["selectCategorieMobile"]) && $_POST["selectCategorieMobile"] != "") {
                $oeuvre = new Oeuvre();
                $oeuvres = $oeuvre->getAllOeuvresByCategorie($_POST["selectCategorieMobile"]);
                $typeRecherche = "par catégorie";
                $categorie = new Categorie();
                $nomRecherche = $categorie->getCategorieNameById($_POST["selectCategorieMobile"]);
            }
        }
        else if (isset($_GET["rechercheParArtisteMobile"])) {
            $oeuvre = new Oeuvre();
            $oeuvres = $oeuvre->getAllOeuvresByArtiste($_GET["rechercheParArtisteMobile"]);
            $typeRecherche = "par artiste";
            $nomRecherche = $_GET["nomArtiste"];
        }
        if (isset($oeuvres)) {
            $photo = new Photo();
            $oeuvresTemp = array();
            foreach ($oeuvres as $oeuvre) {
                if ($photoOeuvre = $photo->getPhotoByOeuvre($oeuvre["idOeuvre"])) {
                    $oeuvre["photo"] = $photoOeuvre["image"];
                }
                $oeuvresTemp[] = $oeuvre;
            }
            $oeuvres = $oeuvresTemp;
        }
        
        $this->oVue = new VueRecherche();
        $this->oVue->setDataGlobal('recherche', 'page de recherche', $this->langueAffichage, $this->pRecherche);
        $this->oVue->setData($oeuvres, $typeRecherche, $nomRecherche);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    /**
    * @brief Méthode qui affiche la page pour la demande d'adhésion d'un nouveau membre
    * @access private
    * @return void
    */
    private function devenirMembre(){
       
        $utilisateur = new Utilisateur();
        $droits = false;
        $msgErreurs = array();
        $msgAjout = "";
        if (isset($_POST['boutonAjoutUtilisateur'])){
            
             $msgErreurs = $utilisateur->validerFormAjoutUtilisateur($_POST['nomUsager'], md5($_POST['motPasse']), $_POST['prenom'], $_POST['nom'], $_POST['courriel']);
             
           if($msgErreurs == null){                                                             
            $msgErreurs = $utilisateur->AjouterUtilisateur($_POST['nomUsager'], md5($_POST['motPasse']), $_POST['prenom'], $_POST['nom'], $_POST['courriel'], $_POST['descriptionProfil'], $droits);
           }
        }

        $this->oVue = new VueDevenirMembre();
        $this->oVue->setDataGlobal('devenirMembre', 'page avec formulaire pour devenir membre', $this->langueAffichage, $this->pDevenirMembre);
        $this->oVue->setData($msgErreurs, $msgAjout);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    // Placer les méthodes du controleur ici.
}
?>