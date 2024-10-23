<?php
/**
 * Class Vue
 * @author David Lachambre
 * @version 1.0
 * @update 2015-12-15
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class Vue {

    protected $titrePage = "";
    protected $descriptionPage = "";
    protected $langue;
    private $pageActuelle;
    
    /**
    * @brief Méthode qui donne des valeurs aux propriétés globales à toutes les vues.
    * @access public
    * @return void
    */
    public function setDataGlobal($titrePage, $descriptionPage, $langue, $pageActuelle) {
        $this->titrePage = $titrePage;
        $this->descriptionPage = $descriptionPage;
        $this->langue = $langue;
        $this->pageActuelle = $pageActuelle;
    }
    /**
    * @brief Méthode qui écrit les information de meta du document HTML, incluant le doctype et la balise d'ouverture du HTML
    * @access public
    * @return void
    */
    public function afficherMeta() {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
	<head>
		<title><?php echo $this->titrePage ?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?php echo $this->descriptionPage ?>">
		<meta name="viewport" content="width=device-width">
		
        <!-- POLICES -->
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:600,400' rel='stylesheet' type='text/css'>
        
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="./css/styles.css">
        <link rel="stylesheet" type="text/css" href="js/vendor/slick-1.5.9/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="js/vendor/slick-1.5.9/slick/slick-theme.css"/>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
		
        <!-- LIBRAIRIES EXTERNES -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/vendor/slick-1.5.9/slick/slick.min.js"></script>
      
        <!-- JAVASCRIPT -->
        <script src="./js/plugins.js"></script>
		<script src="./js/encryption.js"></script>
		<script src="./js/main.js"></script>
	</head>
    <?php
                        
    }

    /**
    * @brief Méthode qui affiche l'entête (header) du document HTML
    * @access public
    * @return void
    */
    public function afficherEntete() {
        
    ?>
    <body>
        <div class="global">
            <header id="header">
                <div class="barreRecherche">
                    <div class="barreRechercheContenu">
                        <form action="?r=recherche" method="post">
                            <select name="typeRecherche" class="typeRecherche">
                                <optgroup label="text">
                                    <option value="">Chercher une oeuvre par...</option>
                                    <option value="artiste">Artiste</option>
                                    <option value="titre">Titre d'oeuvre</option>
                                    <option value="arrondissement">Arrondissement</option>
                                    <option value="categorie">Catégorie</option>
                                </optgroup>
                            </select>                    
                            <div class="deuxiemeSelectRecherche"></div>
                            <div class="submitRecherche"></div>
                        </form>
                    </div>
                </div>
                <div class="boutonRecherche">
                    <div class="flecheRecherche"></div>
                    <img class="iconeRecherche" src="./images/flecheRecherche.png" alt="fleche recherche">
                </div>
                
                
                <div class="boutonRechercheMobile">
                    <img class="iconeRechercheMobile" src="./images/flecheRecherche.png" alt="fleche recherche">
                </div>
                   
                <div class="barreRechercheMobile">
                    <div class="barreRechercheContenuMobile">
                        <form action="?r=recherche" method="post">
                            <select name="typeRechercheMobile" class="typeRechercheMobile">
                                <optgroup label="text">
                                    <option value="">Chercher une oeuvre par...</option>
                                    <option value="artiste">Artiste</option>
                                    <option value="titre">Titre d'oeuvre</option>
                                    <option value="arrondissement">Arrondissement</option>
                                    <option value="categorie">Catégorie</option>
                                </optgroup>
                            </select>                    
                            <div class="deuxiemeSelectRechercheMobile"></div>
                            <div class="submitRechercheMobile"></div>
                        </form>
                    </div>
                    <div class="flecheRechercheMobile"></div>
                </div>
                <img id="logo" src="images/logo.png" alt="logo">

                <nav id="navNormale">
<!--                    Les <a> doivent rester comme ça pour corriger un bug (enter ajoute un espace de 2 pixels entres les <a>-->
                    <a href="?r=accueil">Accueil</a><a href="?r=trajet">Trajet</a><a href="?r=soumission">Soumettre une oeuvre</a><?php if (isset($_SESSION["idUsager"])) {
                        echo '<a href="?r=profil">Profil</a>';
                        if (isset($_SESSION["idUsager"]) && $_SESSION["admin"] === "1") {
                            echo '<a href="?r=gestion">Gestion</a>';
                        }
                        echo '<a href="javascript:;" onclick="deconnexion()">Deconnexion</a>';
                    }
                    else {
                        echo '<a href="javascript:;" onclick="afficherLogin()">Se connecter</a>';
                    }
                    ?>
                </nav>
                
                <div id="navMobile">
                    <img src="images/navBouton.png" id="navBoutonMobile" alt="bouton de la nav">
                    <div id="navAMobile">
                    <a href="?r=accueil">Accueil</a>
                    <a href="?r=trajet">Trajet</a>
                    <a href="?r=soumission">Soumettre une oeuvre</a>
                    <?php if (isset($_SESSION["idUsager"])) {
                        echo '<a href="?r=profil">Profil</a>';
                        if (isset($_SESSION["idUsager"]) && $_SESSION["admin"] === "1") {
                            echo '<a href="?r=gestion">Gestion</a>';
                        }               
                        echo '<a href="javascript:;" onclick="deconnexion()">Deconnexion</a>';
                    }
                    else {
                        echo '<a href="javascript:;" onclick="afficherLogin()">Se connecter</a>';
                    }
                    ?>
                    </div>
                </div>
            </header>

            <div id="div_bgform">
                <div id="div_form">
                    <button id="fermer" onclick ="fermer()">X</button>
                    
                    <!-- Formulaire login -->
                    <form id="formLogin" method="post" name="formLogin">
                    <h2>Connectez vous</h2>

                        <input id="user" class='inputLogin' name="user" placeholder="Nom d'utilisateur" type="text">
                        <input id="pass" class='inputLogin' name="pass" placeholder="Mot de passe" type="password">
                        <input type='hidden' name='grainSel' id='grainSel' value='<?php echo $_SESSION['grainSel'];?>'>
                        <br><span class="erreur centrerTexte" id="erreurLogin"></span>
                        <button type="button" class="boutonMoyenne" onclick="validerLogin()">Envoyer</button>
                        <a href="?r=devenir_membre"><h3>Devenez Membre!</h3></a>
                    </form>
                </div>
            </div>
            <div class="dummy"><!--Ne mettez rien ici--></div>
    <?php
    }
    
    /**
    * @brief Méthode qui affiche le pied de page (footer) du document HTML et ferme la balise HTML
    * @access public
    * @return void
    */
    public function afficherPiedPage() {
    ?>
        </div>
        <footer>
            <?php
                if (!isset($_SESSION["idUsager"])) {
            ?>
                    <button class="lienPageMembre" onclick="location.href = '?r=devenir_membre';">Devenez membre!</button>
            <?php
                }
            ?>
            <div class="reseauxsociaux">
                <a target='_blank' href='https://www.facebook.com/'><img id="logofb" src="images/fblogo.png" alt="logofb"></a>
                <a target='_blank' href='https://www.instagram.com/'><img id="logoInsta" src="images/instalogo.png" alt="logoInsta"></a>
                <a target='_blank' href='https://www.pinterest.com/'><img id="logoPin" src="images/pinlogo.png" alt="logoPin"></a>
            </div>
        </footer>
    </body>

    <?php
    }
}
?>