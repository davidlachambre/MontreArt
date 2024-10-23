/**
* @file Script contenant les fonctions Javascript
* @author Jonathan Martel (jmartel@gmail.com)
* @author David Lachambre
* @author Philippe Germain
* @author Cristina Mahneke
* @version 0.1
* @update 2016-01-30
* @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
* @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
*
*/

//INITIALISATION FONCTIONS JQUERY
$(document).ready(function(){
    
    /* --------------------------------------------------------------------
    ===================== EDITION OEUVRE APPROBATION ======================
    -------------------------------------------------------------------- */
    
    $('.sliderOeuvre').slick({
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        autoplay: true,
        easing: "easeInOutCubic",
        speed: 500
    });
    
    //MODIF TITRE------------------------------------------------------------
    $("#panneauApprobation").on("click", "#titreAffichageSoumission", function(){

        //Click sur champ éditable
        if (!document.getElementById("titreModifSoumission")) {//Si l'élément n'est pas déjà présent dans le document...
            var contenu = document.getElementById("titreAffichageSoumission").innerHTML;
            var regEx = new RegExp("^(<span)", "i");//pour trouver du code html.
            var contenuFiltre = regEx.exec(contenu) ? "" : contenu;//Forme ternaire : Si l'expression est trouvée, chaîne vide. Sinon, contenu non altéré.
            document.getElementById("titreAffichageSoumission").innerHTML = "<input type='text' id='titreModifSoumission' value='" + contenuFiltre + "'><input type='button' id='boutonTitreModif' class='boutonMoyenne' value=OK><input type='button' id='boutonCancelModifTitre' class='boutonMoyenne' value=X>";
            
            //Bouton de fermeture/cancel
            $("#titreAffichageSoumission").on("click", "#boutonCancelModifTitre", function(){
                document.getElementById("titreAffichageSoumission").innerHTML = contenu;
            });
        } 
    });
    //Envoi de la requête pour une modification
    $("#panneauApprobation").on("click", "#boutonTitreModif", function(){
        
        document.getElementById("titreModifSoumission").style.border = "";
        if (document.getElementById("titreModifSoumission").value.trim() !== "") {
            var idOeuvre = document.getElementById("idOeuvreSoumise").value;
            var langue = getCookie("langue");
            var titreModifSoumission = document.getElementById("titreModifSoumission").value.trim();
            $.post("ajaxControler.php?rAjax=modifierOeuvreSoumise", {idOeuvre:idOeuvre, titreModif:titreModifSoumission}, function(reponse){
                afficherOeuvrePourApprobation(idOeuvre);
            });
        }
        else {//erreur, requête non envoyée
            document.getElementById("titreModifSoumission").style.border = "1px solid red";
            document.getElementById("titreModifSoumission").value = "";
        }
    });
    
    //MODIF ADRESSE------------------------------------------------------------
    $("#panneauApprobation").on("click", "#adresseAffichageSoumission", function(){

        //Click sur champ éditable
        if (!document.getElementById("adresseModifSoumission")) {//Si l'élément n'est pas déjà présent dans le document...
            var contenu = document.getElementById("adresseAffichageSoumission").innerHTML;
            document.getElementById("adresseAffichageSoumission").innerHTML = "<input type='text' id='adresseModifSoumission' value='" + contenu + "'><input type='button' id='boutonAdresseModif' class='boutonMoyenne' value=OK><input type='button' id='boutonCancelModifAdresse' class='boutonMoyenne' value=X>";
            
            //Bouton de fermeture/cancel
            $("#adresseAffichageSoumission").on("click", "#boutonCancelModifAdresse", function(){
                document.getElementById("adresseAffichageSoumission").innerHTML = contenu;
            });
        } 
    });
    //Envoi de la requête pour une modification
    $("#panneauApprobation").on("click", "#boutonAdresseModif", function(){
        
        document.getElementById("adresseModifSoumission").style.border = "";//reset border
        var adresse = document.getElementById("adresseModifSoumission").value.trim();
        var adresseAuthorisee = new RegExp("^[0-9]+[A-ÿ.,' \-]+$", "i");//doit avoir la forme d'adresse chiffre suivi d'un ou plusieurs noms.
        var resultat = adresseAuthorisee.exec(adresse);
        if (document.getElementById("adresseModifSoumission").value !== "" && resultat) {
            var idOeuvre = document.getElementById("idOeuvreSoumise").value;
            var langue = getCookie("langue");
            var adresseModifSoumission = document.getElementById("adresseModifSoumission").value.trim();
            $.post("ajaxControler.php?rAjax=modifierOeuvreSoumise", {idOeuvre:idOeuvre, adresseModif:adresseModifSoumission}, function(reponse){
                afficherOeuvrePourApprobation(idOeuvre);
            });
        }
        else {//erreur, requête non envoyée
            document.getElementById("adresseModifSoumission").style.border = "1px solid red";
            document.getElementById("adresseModifSoumission").value = "";
        }
    });
    
    //MODIF DESCRIPTION FR------------------------------------------------------------
    $("#panneauApprobation").on("click", "#descriptionFrAffichageSoumission", function(){

        //Click sur champ éditable
        if (!document.getElementById("descriptionFrModifSoumission")) {//Si l'élément n'est pas déjà présent dans le document...
            var contenu = document.getElementById("descriptionFrAffichageSoumission").innerHTML;
            var regEx = new RegExp("^(<span)", "i");//pour trouver du code html.
            var contenuFiltre = regEx.exec(contenu) ? "" : contenu;//Forme ternaire : Si l'expression est trouvée, chaîne vide. Sinon, contenu non altéré.
            document.getElementById("descriptionFrAffichageSoumission").innerHTML = "<input type='text' id='descriptionFrModifSoumission' value='" + contenuFiltre + "'><input type='button' id='boutonDescriptionFrModif' class='boutonMoyenne' value=OK><input type='button' id='boutonCancelModifDescriptionFR' class='boutonMoyenne' value=X>";
            
            //Bouton de fermeture/cancel
            $("#descriptionFrAffichageSoumission").on("click", "#boutonCancelModifDescriptionFR", function(){
                document.getElementById("descriptionFrAffichageSoumission").innerHTML = contenu;
            });
        } 
    });
    //Envoi de la requête pour une modification
    $("#panneauApprobation").on("click", "#boutonDescriptionFrModif", function(){
        
        var idOeuvre = document.getElementById("idOeuvreSoumise").value;
        var langue = getCookie("langue");
        var descriptionFrModifSoumission = document.getElementById("descriptionFrModifSoumission").value.trim();
        $.post("ajaxControler.php?rAjax=modifierOeuvreSoumise", {idOeuvre:idOeuvre, descriptionFrModif:descriptionFrModifSoumission}, function(reponse){
            afficherOeuvrePourApprobation(idOeuvre);
        });
    });
    
    //MODIF DESCRIPTION EN------------------------------------------------------------
    $("#panneauApprobation").on("click", "#descriptionEnAffichageSoumission", function(){

        //Click sur champ éditable
        if (!document.getElementById("descriptionEnModifSoumission")) {//Si l'élément n'est pas déjà présent dans le document...
            var contenu = document.getElementById("descriptionEnAffichageSoumission").innerHTML;
            var regEx = new RegExp("^(<span)", "i");//pour trouver du code html.
            var contenuFiltre = regEx.exec(contenu) ? "" : contenu;//Forme ternaire : Si l'expression est trouvée, chaîne vide. Sinon, contenu non altéré.
            document.getElementById("descriptionEnAffichageSoumission").innerHTML = "<input type='text' id='descriptionEnModifSoumission' value='" + contenuFiltre + "'><input type='button' id='boutonDescriptionEnModif' class='boutonMoyenne' value=OK><input type='button' id='boutonCancelModifDescriptionEN' class='boutonMoyenne' value=X>";
            
            //Bouton de fermeture/cancel
            $("#descriptionEnAffichageSoumission").on("click", "#boutonCancelModifDescriptionEN", function(){
                document.getElementById("descriptionEnAffichageSoumission").innerHTML = contenu;
            });
        } 
    });
    //Envoi de la requête pour une modification
    $("#panneauApprobation").on("click", "#boutonDescriptionEnModif", function(){
        
        var idOeuvre = document.getElementById("idOeuvreSoumise").value;
        var langue = getCookie("langue");
        var descriptionEnModifSoumission = document.getElementById("descriptionEnModifSoumission").value.trim();
        $.post("ajaxControler.php?rAjax=modifierOeuvreSoumise", {idOeuvre:idOeuvre, descriptionEnModif:descriptionEnModifSoumission}, function(reponse){
            afficherOeuvrePourApprobation(idOeuvre);
        });
    });
    
    //MODIF ARRONDISSEMENT------------------------------------------------------------
    $("#panneauApprobation").on("click", "#arrondissementAffichageSoumission", function(){

        //Click sur champ éditable
        if (!document.getElementById("arrondissementModifSoumission")) {//Si l'élément n'est pas déjà présent dans le document...
            var contenu = document.getElementById("arrondissementAffichageSoumission").innerHTML;
            var idArrondissement = document.getElementById("idArrondissementSoumis").value;
            
            $.post('ajaxControler.php?rAjax=recupererArrondissements', 
                function(reponse){
                var arrondissements = jQuery.parseJSON(reponse);
                var contenuSelect = "<select id='arrondissementModifSoumission'>";
                var selection = "";
                var langue = getCookie("langue");

                //Contenu du select
                    $(arrondissements).each(function(index, arrondissement) {
                        if (arrondissement.idArrondissement == idArrondissement) {
                            selection = "selected='selected'";
                        }
                        else {
                            selection = "";
                        }
                        contenuSelect += "<option value='" + arrondissement.idArrondissement + "' " + selection + ">" + arrondissement.nomArrondissement + "</option>";
                    });
                    contenuSelect += "</select>";
                    contenuSelect += "<input type='button' id='boutonArrondissementModif' class='boutonMoyenne' value=OK><input type='button' id='boutonCancelModifArrondissement' class='boutonMoyenne' value=X>";

                document.getElementById("arrondissementAffichageSoumission").innerHTML = contenuSelect;
            });   
            
            //Bouton de fermeture/cancel
            $("#arrondissementAffichageSoumission").on("click", "#boutonCancelModifArrondissement", function(){
                document.getElementById("arrondissementAffichageSoumission").innerHTML = contenu;
            });
        } 
    });
    //Envoi de la requête pour une modification
    $("#panneauApprobation").on("click", "#boutonArrondissementModif", function(){

        var idOeuvre = document.getElementById("idOeuvreSoumise").value;
        var langue = getCookie("langue");
        var arrondissementModif = document.getElementById("arrondissementModifSoumission").value;
        $.post("ajaxControler.php?rAjax=modifierOeuvreSoumise", {idOeuvre:idOeuvre, arrondissementModif:arrondissementModif}, function(reponse){
            afficherOeuvrePourApprobation(idOeuvre);
        });
    });
    
    //MODIF CATEGORIE------------------------------------------------------------
    $("#panneauApprobation").on("click", "#categorieAffichageSoumission", function(){

        //Click sur champ éditable
        if (!document.getElementById("categorieModifSoumission")) {//Si l'élément n'est pas déjà présent dans le document...
            var contenu = document.getElementById("categorieAffichageSoumission").innerHTML;
            var idCategorie = document.getElementById("idCategorieSoumise").value;
            $.post('ajaxControler.php?rAjax=recupererCategories', 
                function(reponse){
                var categories = jQuery.parseJSON(reponse);
                var contenuSelect = "<select id='categorieModifSoumission'>";
                var selection = "";
                var langue = getCookie("langue");

                //Contenu du select en fonction de la langue
                    $(categories).each(function(index, categorie) {
                        if (categorie.idCategorie == idCategorie) {
                            selection = "selected='selected'";
                        }
                        else {
                            selection = "";
                        }
                        if (langue == "FR") {
                            contenuSelect += "<option value='" + categorie.idCategorie + "' " + selection + ">" + categorie.nomCategorieFR + "</option>";
                        }
                        else if (langue == "EN") {
                            contenuSelect += "<option value='" + categorie.idCategorie + "' " + selection + ">" + categorie.nomCategorieEN + "</option>";
                        }
                    });
                    contenuSelect += "</select>";
                    contenuSelect += "<input type='button' id='boutonCategorieModif' class='boutonMoyenne' value=OK><input type='button' id='boutonCancelModifCategorie' class='boutonMoyenne' value=X>";

                document.getElementById("categorieAffichageSoumission").innerHTML = contenuSelect;
            });   
            
            //Bouton de fermeture/cancel
            $("#categorieAffichageSoumission").on("click", "#boutonCancelModifCategorie", function(){
                document.getElementById("categorieAffichageSoumission").innerHTML = contenu;
            });
        } 
    });
    //Envoi de la requête pour une modification
    $("#panneauApprobation").on("click", "#boutonCategorieModif", function(){

        var idOeuvre = document.getElementById("idOeuvreSoumise").value;
        var categorieModif = document.getElementById("categorieModifSoumission").value;
        $.post("ajaxControler.php?rAjax=modifierOeuvreSoumise", {idOeuvre:idOeuvre, categorieModif:categorieModif}, function(reponse){
            afficherOeuvrePourApprobation(idOeuvre);
        });
    });
    
    //MODIF PRENOM/NOM ARTISTE------------------------------------------------------------
    $("#panneauApprobation").on("click", ".artisteAffichageSoumission", function(){

        //Click sur champ éditable
        if (!document.getElementById("pArtisteModifSoumission") && !document.getElementById("nArtisteModifSoumission")) {//Si l'élément n'est pas déjà présent dans le document...
            var contenuPrenom = document.getElementById("pArtisteAffichageSoumission").innerHTML;
            var contenuNom = document.getElementById("nArtisteAffichageSoumission").innerHTML;
            var regEx = new RegExp("^(<span)", "i");//pour trouver du code html.
            var contenuPrenomFiltre = regEx.exec(contenuPrenom) ? "" : contenuPrenom;//Forme ternaire : Si l'expression est trouvée, chaîne vide. Sinon, contenu non altéré.
            var contenuNomFiltre = regEx.exec(contenuNom) ? "" : contenuNom;//Forme ternaire : Si l'expression est trouvée, chaîne vide. Sinon, contenu non altéré.
            document.getElementById("pArtisteAffichageSoumission").innerHTML = "<input type='text' id='pArtisteModifSoumission' value='" + contenuPrenomFiltre + "'>";
            document.getElementById("nArtisteAffichageSoumission").innerHTML = "<input type='text' id='nArtisteModifSoumission' value='" + contenuNomFiltre + "'><input type='button' id='boutonArtisteModif' class='boutonMoyenne' value=OK><input type='button' id='boutonCancelModifArtiste' class='boutonMoyenne' value=X>";
            
            //Bouton de fermeture/cancel
            $("#nArtisteAffichageSoumission").on("click", "#boutonCancelModifArtiste", function(){
                document.getElementById("pArtisteAffichageSoumission").innerHTML = contenuPrenom;
                document.getElementById("nArtisteAffichageSoumission").innerHTML = contenuNom;
            });
        }
    });
    //Envoi de la requête pour une modification
    $("#panneauApprobation").on("click", "#boutonArtisteModif", function(){

        document.getElementById("nArtisteModifSoumission").style.border = "";
        if (document.getElementById("nArtisteModifSoumission").value.trim() !== "" || document.getElementById("nArtisteModifSoumission").value.trim() == "" && document.getElementById("pArtisteModifSoumission").value.trim() == "") {
            var idOeuvre = document.getElementById("idOeuvreSoumise").value;
            var idArtiste = document.getElementById("idArtisteSoumis").value;
            var pArtisteModifSoumission = document.getElementById("pArtisteModifSoumission").value.trim();
            var nArtisteModifSoumission = document.getElementById("nArtisteModifSoumission").value.trim();
            $.post("ajaxControler.php?rAjax=modifierArtisteSoumis", {idOeuvre:idOeuvre, idArtiste:idArtiste, pArtisteModif:pArtisteModifSoumission, nArtisteModif:nArtisteModifSoumission}, function(reponse){
                afficherOeuvrePourApprobation(idOeuvre);
            });
        }
        else {//erreur, requête non envoyée
            document.getElementById("nArtisteModifSoumission").style.border = "1px solid red";
            document.getElementById("nArtisteModifSoumission").value = "";
        }
    });
    
    /* --------------------------------------------------------------------
    =================== EDITION COMMENTAIRE APPROBATION ===================
    -------------------------------------------------------------------- */
       
    //MODIF COMMENTAIRE------------------------------------------------------------
    $("#panneauApprobation").on("click", "#commentaireAffichageSoumission", function(){

        //Click sur champ éditable
        if (!document.getElementById("commentaireModifSoumission")) {//Si l'élément n'est pas déjà présent dans le document...
            var contenu = document.getElementById("commentaireAffichageSoumission").innerHTML;
            document.getElementById("commentaireAffichageSoumission").innerHTML = "<textarea id='commentaireModifSoumission'>" + contenu + "</textarea><input type='button' id='boutonCommentaireModif' class='boutonMoyenne' value=OK><input type='button' id='boutonCancelModifCommentaire' class='boutonMoyenne' value=X>";
            
            //Bouton de fermeture/cancel
            $("#commentaireAffichageSoumission").on("click", "#boutonCancelModifCommentaire", function(){
                document.getElementById("commentaireAffichageSoumission").innerHTML = contenu;
            });
        } 
    });
    //Envoi de la requête pour une modification
    $("#panneauApprobation").on("click", "#boutonCommentaireModif", function(){
        document.getElementById("commentaireModifSoumission").style.border = "";
        if (document.getElementById("commentaireModifSoumission").value.trim() !== "") {
            var idCommentaire = document.getElementById("idCommentaireSoumis").value;
            var langue = getCookie("langue");
            var commentaireModifSoumission = document.getElementById("commentaireModifSoumission").value;
            $.post("ajaxControler.php?rAjax=modifierCommentaireSoumis", {idCommentaire:idCommentaire, commentaireModif:commentaireModifSoumission}, function(reponse){
                afficherCommentairePourApprobation(idCommentaire);
            });
        }
        else {//erreur, requête non envoyée
            document.getElementById("commentaireModifSoumission").style.border = "1px solid red";
            document.getElementById("commentaireModifSoumission").value = "";
        }
    });
    
    //MODIF LANGUE COMMENTAIRE------------------------------------------------------------
    $("#panneauApprobation").on("click", "#langueCommentaireModif", function(){

        //Click sur champ éditable
        if (!document.getElementById("selectLangueCommentaireModif")) {//Si l'élément n'est pas déjà présent dans le document...
            var contenu = document.getElementById("langueCommentaireModif").innerHTML;

            var selectionFR = "";
            var selectionEN = "";
            
            if (contenu == "FR") {
                selectionFR = "selected='selected'";
            }
            else if (contenu == "EN") {
                selectionEN = "selected='selected'";
            }
            document.getElementById("langueCommentaireModif").innerHTML = "<select id='selectLangueCommentaireModif'><option value='1' " + selectionFR + ">FR</option><option value='2' " + selectionEN + ">EN</option></select><input type='button' id='boutonLangueCommentaireModif' class='boutonMoyenne' value=OK><input type='button' id='boutonCancelModifLangueCommentaire' class='boutonMoyenne' value=X>";
            
            //Bouton de fermeture/cancel
            $("#langueCommentaireModif").on("click", "#boutonCancelModifLangueCommentaire", function(){
                document.getElementById("langueCommentaireModif").innerHTML = contenu;
            });
        } 
    });
    //Envoi de la requête pour une modification
    $("#panneauApprobation").on("click", "#boutonLangueCommentaireModif", function(){

        var idCommentaire = document.getElementById("idCommentaireSoumis").value;
        var optionSelectionnee = document.getElementById("selectLangueCommentaireModif").value;
        var langueChoisie = "";

        if (optionSelectionnee == 1) {
            langueChoisie = "FR";
        }
        else if (optionSelectionnee == 2) {
            langueChoisie = "EN";
        }
        $.post("ajaxControler.php?rAjax=modifierCommentaireSoumis", {idCommentaire:idCommentaire, langueCommentaireModif:langueChoisie}, function(reponse){
            afficherCommentairePourApprobation(idCommentaire);
        });
    });
    
    
    /* --------------------------------------------------------------------
    ======================== ONGLETS PAGE GESTION =========================
    -------------------------------------------------------------------- */

    //ONGLET 1
    $("#lienGestion1").click(function(){

        if ($( "#Onglet-1" ).is( ":visible" )){//Si l'onglet est visible...
            $("#Onglet-1").slideToggle(500);
        }
        else {
            if ($("#Onglet-2").is(":visible") || $("#Onglet-3" ).is(":visible") || $( "#Onglet-4").is( ":visible") || $("#Onglet-5").is(":visible") || $("#Onglet-6").is(":visible") || $( "#Onglet-7" ).is( ":visible" )) {
                $("#Onglet-1").delay(400).slideToggle(500);
            }
            else {
                $("#Onglet-1").slideToggle(500);
            }

        }
        $("#Onglet-2").slideUp(450);
        $("#Onglet-3").slideUp(350);
        $("#Onglet-4").slideUp(350);
        $("#Onglet-5").slideUp(350);
        $("#Onglet-6").slideUp(350);
        $("#Onglet-7").slideUp(350);
    });
    //ONGLET 2
    $("#lienGestion2").click(function(){//Si l'onglet est visible...
        if ($( "#Onglet-2" ).is( ":visible" )) {
            $("#Onglet-2").slideToggle(500);
        }
        else {
            if ($( "#Onglet-1" ).is( ":visible" ) || $( "#Onglet-3" ).is( ":visible" ) || $( "#Onglet-4" ).is( ":visible" ) || $( "#Onglet-5" ).is( ":visible" ) || $( "#Onglet-6" ).is( ":visible" ) || $( "#Onglet-7" ).is( ":visible" )) {
                $("#Onglet-2").delay(400).slideToggle(750);
            }
            else {
                $("#Onglet-2").slideToggle(750);
            }
            //---------------------------------------------------------------------------------------------------
            //Requête Ajax pour récupérer les catégories de la BDD afin de mettre le select à jour lorsque l'onglet est ouvert.
            $.post('ajaxControler.php?rAjax=recupererCategories', 
                function(reponse){

                var categories = jQuery.parseJSON(reponse);
                var options = "<option value=''>choisir une catégorie</option>";
                var langue = getCookie("langue");

                //Choix du contenu du select en fonction de la langue
                if (langue == "FR") {
                    $(categories).each(function(index, categorie) {
                        options += '<option value="' + categorie.idCategorie + '">' + categorie.nomCategorieFR + '</option>';
                    })
                }
                else if (langue = "EN") {
                    $(categories).each(function(index, categorie) {
                        options += '<option value="' + categorie.idCategorie + '">' + categorie.nomCategorieEN + '</option>';
                    })
                }

                $("#selectCategorie").html(options);
            });
            //---------------------------------------------------------------------------------------------------
        }
        $("#Onglet-1").slideUp(350);
        $("#Onglet-3").slideUp(350);
        $("#Onglet-4").slideUp(350);
        $("#Onglet-5").slideUp(350);
        $("#Onglet-6").slideUp(350);
        $("#Onglet-7").slideUp(350);
    });
    //ONGLET 3
    $("#lienGestion3").click(function(){
        if ($( "#Onglet-3" ).is( ":visible" )) {//Si l'onglet est visible...
            $("#Onglet-3").slideToggle(500);
        }
        else {
            if ($( "#Onglet-1" ).is( ":visible" ) || $( "#Onglet-2" ).is( ":visible" ) || $( "#Onglet-4" ).is( ":visible" ) || $( "#Onglet-5" ).is( ":visible" ) || $( "#Onglet-6" ).is( ":visible" ) || $( "#Onglet-7" ).is( ":visible" )) {
                $("#Onglet-3").delay(400).slideToggle(500);
            }
            else {
                $("#Onglet-3").slideToggle(500);
            }
            //---------------------------------------------------------------------------------------------------
            //Requête Ajax pour récupérer les oeuvres de la BDD afin de mettre le select à jour lorsque l'onglet est ouvert.
            $.post('ajaxControler.php?rAjax=recupererOeuvres', 
                function(reponse){

                var oeuvres = jQuery.parseJSON(reponse);
                var options = "<option value=''>choisir une oeuvre</option>";

                $(oeuvres).each(function(index, oeuvre) {
                    options += '<option value="' + oeuvre.idOeuvre + '">' + oeuvre.titre + '</option>';
                })
                $("#selectOeuvreSupp").html(options);
            });
            //---------------------------------------------------------------------------------------------------
        }
        $("#Onglet-1").slideUp(350);
        $("#Onglet-2").slideUp(450);
        $("#Onglet-4").slideUp(350);
        $("#Onglet-5").slideUp(350);
        $("#Onglet-6").slideUp(350);
        $("#Onglet-7").slideUp(350);
    });
    //ONGLET 4
    $("#lienGestion4").click(function(){
        if ($( "#Onglet-4" ).is( ":visible" )) {//Si l'onglet est visible...
            $("#Onglet-4").slideToggle(500);
        }
        else {
            if ($( "#Onglet-1" ).is( ":visible" ) || $( "#Onglet-2" ).is( ":visible" ) || $( "#Onglet-3" ).is( ":visible" ) || $( "#Onglet-5" ).is( ":visible" ) || $( "#Onglet-6" ).is( ":visible" ) || $( "#Onglet-7" ).is( ":visible" )) {
                $("#Onglet-4").delay(400).slideToggle(500);
            }
            else {
                $("#Onglet-4").slideToggle(500);
            }
            //---------------------------------------------------------------------------------------------------
            //Requête Ajax pour récupérer les oeuvres de la BDD afin de mettre le select à jour lorsque l'onglet est ouvert.
            $.post('ajaxControler.php?rAjax=recupererOeuvres', 
                function(reponse){

                var oeuvres = jQuery.parseJSON(reponse);
                var options = "<option value=''>choisir une oeuvre</option>";

                $(oeuvres).each(function(index, oeuvre) {
                    options += '<option value="' + oeuvre.idOeuvre + '">' + oeuvre.titre + '</option>';
                })
                $("#selectOeuvreModif").html(options);
            });
            //---------------------------------------------------------------------------------------------------
        }
        $("#Onglet-1").slideUp(350);
        $("#Onglet-2").slideUp(450);
        $("#Onglet-3").slideUp(350);
        $("#Onglet-5").slideUp(350);
        $("#Onglet-6").slideUp(350);
        $("#Onglet-7").slideUp(350);
    });
    //ONGLET 5
    $("#lienGestion5").click(function(){
        if ($( "#Onglet-5" ).is( ":visible" )) {//Si l'onglet est visible...
            $("#Onglet-5").slideToggle(500);
        }
        else {
            if ($( "#Onglet-1" ).is( ":visible" ) || $( "#Onglet-2" ).is( ":visible" ) || $( "#Onglet-3" ).is( ":visible" ) || $( "#Onglet-4" ).is( ":visible" ) || $( "#Onglet-6" ).is( ":visible" ) || $( "#Onglet-7" ).is( ":visible" )) {
                $("#Onglet-5").delay(400).slideToggle(500);
            }
            else {
                $("#Onglet-5").slideToggle(500);
            }
        }
        $("#Onglet-1").slideUp(350);
        $("#Onglet-2").slideUp(450);
        $("#Onglet-3").slideUp(350);
        $("#Onglet-4").slideUp(350);
        $("#Onglet-6").slideUp(350);
        $("#Onglet-7").slideUp(350);
    });
    //ONGLET 6
    $("#lienGestion6").click(function(){
        if ($( "#Onglet-6" ).is( ":visible" )) {//Si l'onglet est visible...
            $("#Onglet-6").slideToggle(500);
        }
        else {
            if ($( "#Onglet-1" ).is( ":visible" ) || $( "#Onglet-2" ).is( ":visible" ) || $( "#Onglet-3" ).is( ":visible" ) || $( "#Onglet-4" ).is( ":visible" ) || $( "#Onglet-5" ).is( ":visible" ) || $( "#Onglet-7" ).is( ":visible" )) {
                $("#Onglet-6").delay(400).slideToggle(500);
            }
            else {
                $("#Onglet-6").slideToggle(500);
            }
            //---------------------------------------------------------------------------------------------------
            //Requête Ajax pour récupérer les catégories de la BDD afin de mettre le select à jour lorsque l'onglet est ouvert.
            $.post('ajaxControler.php?rAjax=recupererCategories', 
                function(reponse){

                var categories = jQuery.parseJSON(reponse);
                var options = "<option value=''>choisir une catégorie</option>";
                var langue = getCookie("langue");

                //Choix du contenu du select en fonction de la langue
                if (langue == "FR") {
                    $(categories).each(function(index, categorie) {
                        options += '<option value="' + categorie.idCategorie + '">' + categorie.nomCategorieFR + '</option>';
                    })
                }
                else if (langue = "EN") {
                    $(categories).each(function(index, categorie) {
                        options += '<option value="' + categorie.idCategorie + '">' + categorie.nomCategorieEN + '</option>';
                    })
                }

                $("#selectCategorieSupp").html(options);
            });
            //---------------------------------------------------------------------------------------------------
        }
        $("#Onglet-1").slideUp(350);
        $("#Onglet-2").slideUp(450);
        $("#Onglet-3").slideUp(350);
        $("#Onglet-4").slideUp(350);
        $("#Onglet-5").slideUp(350);
        $("#Onglet-7").slideUp(350);
    });
    //ONGLET 7
    $("#lienGestion7").click(function(){
        if ($( "#Onglet-7" ).is( ":visible" )) {//Si l'onglet est visible...
            $("#Onglet-7").slideToggle(500);
        }
        else {
            if ($( "#Onglet-1" ).is( ":visible" ) || $( "#Onglet-2" ).is( ":visible" ) || $( "#Onglet-3" ).is( ":visible" ) || $( "#Onglet-4" ).is( ":visible" ) || $( "#Onglet-5" ).is( ":visible" ) || $( "#Onglet-6" ).is( ":visible" )) {
                $("#Onglet-7").delay(400).slideToggle(500);
            }
            else {
                $("#Onglet-7").slideToggle(500);
            }
            rechargerOeuvresApprob();
            rechargerPhotosApprob();
            rechargerCommentairesApprob();
        }
        $("#Onglet-1").slideUp(350);
        $("#Onglet-2").slideUp(450);
        $("#Onglet-3").slideUp(350);
        $("#Onglet-4").slideUp(350);
        $("#Onglet-5").slideUp(350);
        $("#Onglet-6").slideUp(350);
    });
        //Toutes les sections sont cachées au chargement de la page.
        $("#Onglet-1").hide();
        $("#Onglet-2").hide();
        $("#Onglet-3").hide();
        $("#Onglet-4").hide();
        $("#Onglet-5").hide();
        $("#Onglet-6").hide();
        $("#Onglet-7").hide();
    
    //------------ FIN ONGLETS JQUERY PAGE GESTION -------------


    /* --------------------------------------------------------------------
    ======================== ACCORDEON PAGE GESTION =======================
    -------------------------------------------------------------------- */
    
    //ONGLET MODIF INFOS PROFIL
    $("#OngletModifProfil").hide();
    $("#modifInfosProfil").click(function(){
        $("#OngletModifProfil").slideToggle(500);
    });
    
    $( "#accordeon" ).accordion({
        active: false,
        collapsible: true,
        animate: 400,
        heightStyle: "content"
    });

    //SLIDE MENU MOBILE
    $("#navAMobile").hide();//Cache le menu mobile au chargement
    $("#navMobile").click(function(){
        $("#navAMobile").slideToggle("medium");
    });

    //SLIDE BARRE DE RECHERCHE MOBILE
    $(".boutonRechercheMobile").click(function(){
        $(".barreRechercheContenuMobile").slideToggle("medium");
    });
    
    //SLIDE BARRE DE RECHERCHE MOBILE FLÈCHE
    $(".flecheRechercheMobile").click(function(){
        $(".barreRechercheContenuMobile").slideToggle("medium");
    });
    
    //SLIDE BARRE DE RECHERCHE
    $(".barreRecherche").hide();
    $(".boutonRecherche").click(function(){
        
        $( ".barreRecherche").animate({
            width: "toggle"
        });
    });
    
    //AJAX SELECT TYPE DE RECHERCHE
    $(".barreRecherche").on("change", ".typeRecherche", function(){
        
        $.get("ajaxControler.php?rAjax=afficherSelectRecherche&typeRecherche="+this.value, function(reponse){
            //ceci est la fonction de callback
            //elle sera appelée lorsque le contenu obtenu par AJAX sera rendu du côté client
            $(".deuxiemeSelectRecherche").html(reponse);
            $(".submitRecherche").html("");//Pour corriger un bug où le bouton restait affiché si on changeait le type de recherche après son affichage.
        });
    });
    //AJAX SELECT CATEGORIE
    $(".barreRecherche").on("change", ".selectCategorie", function(){
        $.get("ajaxControler.php?rAjax=afficherBoutonRecherche&selectCategorie="+this.value, function(reponse){
            //ceci est la fonction de callback
            //elle sera appelée lorsque le contenu obtenu par AJAX sera rendu du côté client
            $(".submitRecherche").html(reponse);
        });
    });
    //AJAX SELECT ARRONDISSEMENT
    $(".barreRecherche").on("change", ".selectArrondissement", function(){
        $.get("ajaxControler.php?rAjax=afficherBoutonRecherche&selectArrondissement="+this.value, function(reponse){
            //ceci est la fonction de callback
            //elle sera appelée lorsque le contenu obtenu par AJAX sera rendu du côté client
            $(".submitRecherche").html(reponse);
        });
    });
    
    //AJAX SELECT TYPE DE RECHERCHE MOBILE

    $(".barreRechercheMobile").on("change", ".typeRechercheMobile", function(){
        
        $.get("ajaxControler.php?rAjax=afficherSelectRechercheMobile&typeRechercheMobile="+this.value, function(reponse){
            //ceci est la fonction de callback
            //elle sera appelée lorsque le contenu obtenu par AJAX sera rendu du côté client
            $(".deuxiemeSelectRechercheMobile").html(reponse);
            $(".submitRechercheMobile").html("");//Pour corriger un bug où le bouton restait affiché si on changeait le type de recherche après son affichage.
        });
    });
    //AJAX SELECT CATEGORIE MOBILE

    $(".barreRechercheMobile").on("change", ".selectCategorieMobile", function(){
        $.get("ajaxControler.php?rAjax=afficherBoutonRechercheMobile&selectCategorieMobile="+this.value, function(reponse){
            //ceci est la fonction de callback
            //elle sera appelée lorsque le contenu obtenu par AJAX sera rendu du côté client
            $(".submitRechercheMobile").html(reponse);
        });
    });
    //AJAX SELECT ARRONDISSEMENT MOBILE

    $(".barreRechercheMobile").on("change", ".selectArrondissementMobile", function(){
        $.get("ajaxControler.php?rAjax=afficherBoutonRechercheMobile&selectArrondissementMobile="+this.value, function(reponse){
            //ceci est la fonction de callback
            //elle sera appelée lorsque le contenu obtenu par AJAX sera rendu du côté client
            $(".submitRechercheMobile").html(reponse);
        });
    });
});
 /* --------------------------------------------------------------------
    =================== EDITION INFORMATION PAGE PROFIL ===================
    -------------------------------------------------------------------- */
    //ONGLET 4
    $("#lienModifProfil").click(function(){
        if ($("#Onglet-Modif").is( ":visible" )) {//Si l'onglet est visible...
            $("#Onglet-Modif").slideToggle(500);
        }
        else {
                $("#Onglet-Modif").slideToggle(500);
            }
      
        
    });
 $("#Onglet-Modif").hide();
/* --------------------------------------------------------------------
==================== VALIDATION JS / REQUÊTES AJAX ====================
-------------------------------------------------------------------- */

/**
* @brief Fonction de validation de soumission d'une photo
* @access public
* @author David Lachambre
* @return boolean
*/
function validePhotoSubmit() {
    var erreurs = false;
    var msg = "";
    
    if (document.getElementById("fileToUpload").files.length == 0) {
        msg = "Vous devez d'abord choisir un fichier.";
        erreurs = true;
    }
    else {
        if (document.getElementById("fileToUpload").files[0].size > 5000000) {
            if (msg != "") {
                msg += "<br>";
            }
            msg += "Votre fichier doit être inférieur à 5Mb.";
            erreurs = true;
        }
        if (document.getElementById("fileToUpload").files[0].type != "image/png" && document.getElementById("fileToUpload").files[0].type != "image/jpg" && document.getElementById("fileToUpload").files[0].type != "image/jpeg") {
            if (msg != "") {
                msg += "<br>";
            }
            msg += "Votre fichier doit être de type Jpeg ou Png.";
            erreurs = true;
        }
    }
    document.getElementById("msg").innerHTML = msg;
    return (!erreurs);
}

/**
* @brief Fonction de validation de soumission d'une oeuvre. Soumet la requête en Ajax si aucune erreur et transmet les erreurs, le cas échéant.
* @access public
* @author David Lachambre
* @return boolean
*/
function valideAjoutOeuvre(droitsAdmin) {
    
    if (droitsAdmin == "false") {
        droitsAdmin = false;
    }
    else if (droitsAdmin == "true") {
        droitsAdmin = true;
    }
    var erreurs = false;
    var photo = document.getElementById("fileToUpload");
    var msgErreurPhoto = "";
    var description = document.getElementById("descriptionAjout").value.trim();
    var idCategorie = document.getElementById("selectCategorie").value;
    var idArrondissement = document.getElementById("selectArrondissement").value;
    var adresse = document.getElementById("adresseAjout").value.trim();
    var titre = document.getElementById("titreAjout").value.trim();
    var prenomArtiste = document.getElementById("prenomArtisteAjout").value.trim();
    var nomArtiste = document.getElementById("nomArtisteAjout").value.trim();
    
    //-----------------------------------------
    //Réinitialisation des messgages d'erreur.
    document.getElementById("erreurTitreOeuvre").innerHTML = "";
    document.getElementById("erreurAdresseOeuvre").innerHTML = "";
    document.getElementById("erreurDescription").innerHTML = "";
    document.getElementById("erreurSelectCategorie").innerHTML = "";
    document.getElementById("erreurSelectArrondissement").innerHTML = "";
    document.getElementById("erreurPhoto").innerHTML = "";
    document.getElementById("msgAjout").innerHTML = "";

    //-----------------------------------------
    //Validation des champs.
    if (titre == "") {
        document.getElementById("erreurTitreOeuvre").innerHTML = "Veuillez entrer un titre";
        erreurs = true;
    }

    if (adresse == "") {
        document.getElementById("erreurAdresseOeuvre").innerHTML = "Veuillez entrer une adresse";
        erreurs = true;
    }
    else {
        var adresseAuthorisee = new RegExp("^[0-9]+[A-ÿ.,' \-]+$", "i");//doit avoir la forme d'adresse chiffre suivi d'un ou plusieurs noms.
        var resultat = adresseAuthorisee.exec(adresse);
        if (!resultat) {
            document.getElementById("erreurAdresseOeuvre").innerHTML = "Votre adresse doit débuter par le numéro civique, suivi du nom de la rue";
            erreurs = true;
        }
    }
    
    if (description == "") {
        document.getElementById("erreurDescription").innerHTML = "Veuillez entrer une description";
        erreurs = true;
    }

    if (idCategorie == "") {
        document.getElementById("erreurSelectCategorie").innerHTML = "Veuillez choisir une catégorie";
        erreurs = true;
    }

    if (idArrondissement == "") {
        document.getElementById("erreurSelectArrondissement").innerHTML = "Veuillez choisir un arrondissement";
        erreurs = true;
    }  
    
    if (photo.value != "") {
        var fichiersAuthorises = new RegExp("(.jpg|.jpeg|.png)$", "i");//doit se terminer par une des extensions suivantes.
        var resultat = fichiersAuthorises.exec(photo.value);
        if (!resultat) {
            msgErreurPhoto = "Seules les images de type \"JPG\" ou \"PNG\" sont acceptées.";
            erreurs = true;
        }
        if (photo.files[0].size > 5000000) {//Si plus gros que 5Mb...
            if (msgErreurPhoto != "") {
                msgErreurPhoto += "<br>";
            }
            msgErreurPhoto += "Votre image ne doit pas dépasser 5Mb.";
            erreurs = true;
        }
        document.getElementById("erreurPhoto").innerHTML = msgErreurPhoto;
    }
    
    //-----------------------------------------
    //Requête AJAX si aucune erreur.
    if (!erreurs) {
        $.post('ajaxControler.php?rAjax=ajouterOeuvre', {titre: titre, adresse: adresse, prenomArtiste: prenomArtiste, nomArtiste: nomArtiste, description: description, idCategorie: idCategorie, idArrondissement: idArrondissement, droitsAdmin: droitsAdmin}, 
            function(reponse){

            var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

            if (msgErreurs.length == 0) {//Si aucune erreur...
                
                document.getElementById("descriptionAjout").value = "";
                document.getElementById("selectCategorie").value = "";
                document.getElementById("selectArrondissement").value = "";
                document.getElementById("adresseAjout").value = "";
                document.getElementById("titreAjout").value = "";
                document.getElementById("prenomArtisteAjout").value = "";
                document.getElementById("nomArtisteAjout").value = "";
                
                $("#msgAjout").html("<span style='color:green'>Oeuvre ajoutée !</span>");
            }
            else {//Sinon indique les erreurs à l'utilisateur.
                $(msgErreurs).each(function(index, valeur) {
                    if (valeur.errRequeteAjout) {
                        $("#msgAjout").html(valeur.errRequeteAjout);
                    }
                    if (valeur.errTitre) {
                        $("#erreurTitreOeuvre").html(valeur.errTitre);
                    }
                    if (valeur.errAdresse) {
                        $("#erreurAdresseOeuvre").html(valeur.errAdresse);
                    }
                    if (valeur.errDescription) {
                        $("#erreurDescription").html(valeur.errDescription);
                    }
                    if (valeur.errCategorie) {
                        $("#erreurSelectCategorie").html(valeur.errCategorie);
                    }
                    if (valeur.errArrondissement) {
                        $("#erreurSelectArrondissement").html(valeur.errArrondissement);
                    }
                })
            }
            if (document.getElementById("fileToUpload").value != "") {//Si l'utilisateur a soumis un fichier photo...
                //Nouvelle requête Ajax pour connaître l'id de la nouvelle oeuvre créée.
                $.post('ajaxControler.php?rAjax=recupererIdOeuvre', {titre: titre, adresse: adresse}, 
                    function(idOeuvre){

                        //Soumission Ajax de la photo une fois la création de l'oeuvre complétée et l'id de l'oeuvre connue.
                        var fd = new FormData();
                        fd.append( 'fileToUpload', $('#fileToUpload')[0].files[0]);

                        $.ajax({
                            url: 'ajaxControler.php?rAjax=ajouterPhoto&idOeuvre='+idOeuvre+'&admin='+droitsAdmin,
                            data: fd,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            success: function(msgErreurs){

                                if (msgErreurs != "") {//Si erreur avec l'insertion de la photo...
                                    $("#erreurPhoto").html(msgErreurs);
                                }
                                else {
                                    document.getElementById("fileToUpload").value = "";
                                }
                            }
                        });
                });
            }
        });
    }
    return false;//Retourne toujours false pour que le formulaire ne soit pas soumit.
}

/**
* @brief Fonction de validation de suppresion d'une oeuvre. Soumet la requête en Ajax si aucune erreur et transmet les erreurs, le cas échéant.
* @access public
* @author David Lachambre
* @return boolean
*/
function valideSupprimerOeuvre() {
    
    var erreurs = false;
    var idOeuvre = document.getElementById("selectOeuvreSupp").value;
    document.getElementById("msgSupp").innerHTML = "";
    
    //-----------------------------------------
    //Réinitialisation des messgages d'erreur.
    document.getElementById("erreurSelectSuppression").innerHTML = "";
    
    //-----------------------------------------
    //Validation des champs.
    if (idOeuvre == "") {
        document.getElementById("erreurSelectSuppression").innerHTML = "Veuillez choisir une option";
        erreurs = true;
    }
    
    //-----------------------------------------
    //Requête AJAX si aucune erreur.
    if (!erreurs) {
        $.post('ajaxControler.php?rAjax=supprimerOeuvre', {idOeuvre: idOeuvre}, 
            function(reponse){

                var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

                if (msgErreurs.length == 0) {//Si aucune erreur...
                    document.getElementById("selectOeuvreSupp").value = "";

                    $("#msgSupp").html("<span style='color:green'>Oeuvre supprimée !</span>");

                    //Requête Ajax pour récupérer les oeuvres de la BDD afin de mettre le select à jour.
                    $.post('ajaxControler.php?rAjax=recupererOeuvres', 
                        function(reponse){

                        var oeuvres = jQuery.parseJSON(reponse);
                        var options = "<option value=''>choisir une oeuvre</option>";

                        $(oeuvres).each(function(index, oeuvre) {
                            options += '<option value="' + oeuvre.idOeuvre + '">' + oeuvre.titre + '</option>';
                        })
                        $("#selectOeuvreSupp").html(options);
                    });
                }
                else {//Sinon indique les erreurs à l'utilisateur.
                    $(msgErreurs).each(function(index, valeur) {
                        if (valeur.errRequeteSupp) {
                            $("#msgSupp").html(valeur.errRequeteSupp);
                        }
                        if (valeur.errSelectOeuvreSupp) {
                            $("#erreurSelectSuppression").html(valeur.errSelectOeuvreSupp);
                        }
                    })
                }
        });
    }
    return false;//Retourne toujours false pour que le formulaire ne soit pas soumit.
}

/**
* @brief Fonction de validation de modification d'une oeuvre. Soumet la requête en Ajax si aucune erreur et transmet les erreurs, le cas échéant.
* @access public
* @author David Lachambre
* @return boolean
*/
function valideModifierOeuvre() {
    
    var erreurs = false;
    var titre = document.getElementById("titreModif").value.trim();
    var adresse = document.getElementById("adresseModif").value.trim();
    var description = document.getElementById("descriptionModif").value.trim();
    var idCategorie = document.getElementById("selectCategorieModif").value;
    var idArrondissement = document.getElementById("selectArrondissementModif").value;
    var idOeuvre = document.getElementById("selectOeuvreModif").value;
    
    document.getElementById("erreurTitreOeuvreModif").innerHTML = "";
    document.getElementById("erreurAdresseOeuvreModif").innerHTML = "";
    document.getElementById("erreurDescriptionModif").innerHTML = "";
    document.getElementById("erreurSelectCategorieModif").innerHTML = "";
    document.getElementById("erreurSelectArrondissementModif").innerHTML = "";
    document.getElementById("msgModif").innerHTML = "";

    if (titre == "") {
        document.getElementById("erreurTitreOeuvreModif").innerHTML = "Veuillez entrer le titre";
        erreurs = true;
    }
    if (adresse == "") {
        document.getElementById("erreurAdresseOeuvreModif").innerHTML = "Veuillez entrer l'adresse";
        erreurs = true;
    }

    if (description == "") {
        document.getElementById("erreurDescriptionModif").innerHTML = "Veuillez entrer une description";
        erreurs = true;
    }

    if (idCategorie == "") {
        document.getElementById("erreurSelectCategorieModif").innerHTML = "Veuillez choisir une catégorie";
        erreurs = true;
    }

    if (idArrondissement == "") {
        document.getElementById("erreurSelectArrondissementModif").innerHTML = "Veuillez choisir un arrondissement";
        erreurs = true;
    }
    
    //-----------------------------------------
    //Requête AJAX si aucune erreur.
    if (!erreurs) {

        $.post('ajaxControler.php?rAjax=modifierOeuvre', {idOeuvre: idOeuvre, titre: titre, adresse: adresse, description: description, idCategorie: idCategorie, idArrondissement: idArrondissement}, 
            function(reponse){

                var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

                if (msgErreurs.length == 0) {//Si aucune erreur...
                    document.getElementById("titreModif").value = "";
                    document.getElementById("adresseModif").value = "";
                    document.getElementById("descriptionModif").value = "";
                    document.getElementById("selectCategorieModif").value = "";
                    document.getElementById("selectArrondissementModif").value = "";
                    document.getElementById("selectOeuvreModif").value = "";
                    $('#formModif').html('');

                    $("#msgModif").html("<span style='color:green'>Oeuvre modifiée !</span>");
                }
                else {//Sinon indique les erreurs à l'utilisateur.
                    $(msgErreurs).each(function(index, valeur) {
                        if (valeur.errRequeteAjout) {
                            $("#msgModif").html(valeur.errRequeteAjout);
                        }
                        if (valeur.errTitre) {
                            $("#erreurTitreOeuvreModif").html(valeur.errTitre);
                        }
                        if (valeur.errAdresse) {
                            $("#erreurAdresseOeuvreModif").html(valeur.errAdresse);
                        }
                        if (valeur.errDescription) {
                            $("#erreurDescriptionModif").html(valeur.errDescription);
                        }
                        if (valeur.errCategorie) {
                            $("#erreurSelectCategorieModif").html(valeur.errCategorie);
                        }
                        if (valeur.errArrondissement) {
                            $("#erreurSelectArrondissementModif").html(valeur.errArrondissement);
                        }
                    })
                }
        });
    }
    return false;//Retourne toujours false pour que le formulaire ne soit pas soumit.
}

/**
* @brief Fonction de validation de l'ajout d'une catégorie. Soumet la requête en Ajax si aucune erreur et transmet les erreurs, le cas échéant.
* @access public
* @author David Lachambre
* @return boolean
*/
function valideAjoutCategorie() {
    
    var erreurs = false;
    var categorieFr, categorieEn;
    
    //-----------------------------------------
    //Réinitialisation des messgages d'erreur.

    document.getElementById("erreurAjoutCategorieFR").innerHTML = "";
    document.getElementById("erreurAjoutCategorieEN").innerHTML = "";
    document.getElementById("msgAjoutCat").innerHTML = "";
    
    //-----------------------------------------
    //Validation des champs.
    categorieFr = document.getElementById("categorieFrAjout").value.trim();
    if (categorieFr == "") {
        document.getElementById("erreurAjoutCategorieFR").innerHTML = "Veuillez inscrire le nom de la catégorie en français";
        erreurs = true;
    }
    
    categorieEn = document.getElementById("categorieEnAjout").value.trim();
    if (categorieEn == "") {
        document.getElementById("erreurAjoutCategorieEN").innerHTML = "Veuillez inscrire le nom de la catégorie en anglais";
        erreurs = true;
    }
    //-----------------------------------------
    //Requête AJAX si aucune erreur.
    if (!erreurs) {
        $.post('ajaxControler.php?rAjax=ajouterCategorie', {categorieFr: categorieFr, categorieEn: categorieEn}, 
            function(reponse){

                var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

                if (msgErreurs.length == 0) {//Si aucune erreur...
                    document.getElementById("categorieFrAjout").value = "";
                    document.getElementById("categorieEnAjout").value = "";
                    $("#msgAjoutCat").html("<span style='color:green'>Catégorie ajoutée !</span>");
                }
                else {//Sinon indique les erreurs à l'utilisateur.
                    $(msgErreurs).each(function(index, valeur) {
                        if (valeur.errRequeteAjoutCat) {
                            $("#msgAjoutCat").html(valeur.errRequeteAjoutCat);
                        }
                        if (valeur.errAjoutCategorieFR) {
                            $("#erreurAjoutCategorieFR").html(valeur.errAjoutCategorieFR);
                        }
                        if (valeur.errAjoutCategorieEN) {
                            $("#erreurAjoutCategorieEN").html(valeur.errAjoutCategorieEN);
                        }
                    })
                }
        });
    }
    return false;//Retourne toujours false pour que le formulaire ne soit pas soumit.
}

/**
* @brief Fonction de validation de suppresion d'une catégorie. Soumet la requête en Ajax si aucune erreur et transmet les erreurs, le cas échéant.
* @access public
* @author David Lachambre
* @return boolean
*/
function valideSuppCategorie() {
    
    var erreurs = false;
    var idCategorie;
    
    //-----------------------------------------
    //Réinitialisation des messgages d'erreur.
    document.getElementById("erreurSelectSuppCategorie").innerHTML = "";    
    document.getElementById("msgSuppCat").innerHTML = "";

    //-----------------------------------------
    //Validation des champs.
    idCategorie = document.getElementById("selectCategorieSupp").value;
    if (idCategorie == "") {
        document.getElementById("erreurSelectSuppCategorie").innerHTML = "Veuillez choisir une catégorie à supprimer";
        erreurs = true;
    }
    
    //-----------------------------------------
    //Requête AJAX si aucune erreur.
    if (!erreurs) {
        $.post('ajaxControler.php?rAjax=supprimerCategorie', {idCategorie: idCategorie}, 
            function(reponse){

                var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

                if (msgErreurs.length == 0) {//Si aucune erreur...
                    document.getElementById("selectCategorieSupp").value = "";

                    $("#msgSuppCat").html("<span style='color:green'>Catégorie supprimée !</span>");

                    //Requête Ajax pour récupérer les catégories de la BDD afin de mettre le select à jour.
                    $.post('ajaxControler.php?rAjax=recupererCategories', 
                        function(reponse){

                        var categories = jQuery.parseJSON(reponse);
                        var options = "<option value=''>choisir une catégorie</option>";
                        var langue = getCookie("langue");

                        //Choix du contenu du select en fonction de la langue
                        if (langue == "FR") {
                            $(categories).each(function(index, categorie) {
                                options += '<option value="' + categorie.idCategorie + '">' + categorie.nomCategorieFR + '</option>';
                            })
                        }
                        else if (langue = "EN") {
                            $(categories).each(function(index, categorie) {
                                options += '<option value="' + categorie.idCategorie + '">' + categorie.nomCategorieEN + '</option>';
                            })
                        }

                        $("#selectCategorieSupp").html(options);
                    });
                }
                else {//Sinon indique les erreurs à l'utilisateur.
                    $(msgErreurs).each(function(index, valeur) {
                        if (valeur.errSelectCategorieSupp) {
                            $("#erreurSelectSuppCategorie").html(valeur.errSelectCategorieSupp);
                        }
                        if (valeur.errRequeteSuppCat) {
                            $("#msgSuppCat").html(valeur.errRequeteSuppCat);
                        }
                    })
                }
        });
    }    
    return false;//Retourne toujours false pour que le formulaire ne soit pas soumit.
}

/**
* @brief Fonction de validation d'ajout commentaire oeuvre
* @access public
* @return boolean
*/
function valideAjoutCommentaireOeuvre() {
    var erreurs = false;
    document.getElementById("erreurCommentaire").innerHTML = "";
    if (document.getElementById("commentaireAjout").value.trim() == "") {
        document.getElementById("erreurCommentaire").innerHTML = "Veuillez entrer un commentaire";
        erreurs = true;
    }
    return (!erreurs);
}
/**
* @brief Fonction de validation d'ajout d'un nouveau utilisateur
* @access public
* @author David Lachambre
* @return boolean
*/
function validerFormAjoutUtilisateur(){
    var erreurs = false;
    var msg = "";
    document.getElementById("erreurNomUsager").innerHTML = "";
    document.getElementById("erreurMotPasse").innerHTML = "";
    document.getElementById("erreurPrenom").innerHTML = "";
    document.getElementById("erreurNom").innerHTML = "";
    document.getElementById("erreurCourriel").innerHTML = "";
    


    if (document.getElementById("nomUsager").value.trim() == "") {
        document.getElementById("erreurNomUsager").innerHTML = "Veuillez choisir un nom usager";
        erreurs = true;
    }

    if (document.getElementById("motPasse").value.trim() == "") {
        document.getElementById("erreurMotPasse").innerHTML = "Veuillez ecrire un mot de passe.";
        erreurs = true;
    }

    if (document.getElementById("prenom").value.trim() == "") {
        document.getElementById("erreurPrenom").innerHTML = "Veuillez entrer votre prenom";
        erreurs = true;
    }

    if (document.getElementById("nom").value == "") {
        document.getElementById("erreurNom").innerHTML = "Veuillez entrer votre nom de famille";
        erreurs = true;
    }

    if (document.getElementById("courriel").value == "") {
        document.getElementById("erreurCourriel").innerHTML = "Veuillez entrer votre courriel";
        erreurs = true;
    }else if(!document.getElementById("courriel").value == ""){
        var courriel = document.getElementById("courriel").value;
        var regex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
        if(!regex.test(courriel)){
            document.getElementById("erreurCourriel").innerHTML = "Veuillez entrer un adresse courriel valide.";
            erreurs = true;
        }
    }

    document.getElementById("msg").innerHTML = msg;
    return (!erreurs);
}
/**
* @brief methode qui commence une session pour le nouveau utilisateur, ensuite de s'enregistrer, lui envoie a sa page profil
* @access public
* @author Cristina Mahneke
*/
function loginNouveauUsager(user, pass, grainSel){
    
       passEncrypte = encrypterMotPasse(pass, grainSel);
      
        $.post('ajaxControler.php?rAjax=connexionNouveau', {passNouveau:passEncrypte, userNouveau:user}, 
            function(reponse){
            
            if (reponse) {//reponse === true
//                console.log("utilisateur authentifié");
                
                window.location.href = "?r=profil";//Sinon, valeur par défaut.
                //--------------------------------------------------------------------------
            }
            else {//reponse === false
//                console.log("erreur user/pass");
               
            }
        });
}

/**
* @brief Fonction de validation du login
* @access public
* @author David Lachambre
* @return boolean
*/
function validerLogin(){
    
    var erreurs = false;
    var msgErreur = "";
    var passEncrypte = "";
    document.formLogin.user.style.border = "";
    document.formLogin.pass.style.border = "";
    var user = document.formLogin.user.value;
    var pass = document.formLogin.pass.value;
    var grainSel = document.formLogin.grainSel.value;
        
    if (user.trim() == "") {
        document.formLogin.user.style.border = "solid 2px red";
        document.formLogin.user.value = "";
        erreurs = true;
    }

    if (pass.trim() == "") {
        document.formLogin.pass.style.border = "solid 2px red";
        document.formLogin.pass.value = "";
        erreurs = true;
    }
    if (!erreurs) {

        passEncrypte = encrypterMotPasse(pass, grainSel);

        $.post('ajaxControler.php?rAjax=connexion', {pass:passEncrypte, user:user}, 
            function(reponse){
            
            if (reponse) {//reponse === true
//                console.log("utilisateur authentifié");
                
                //--------------------------------------------------------------------------
                //Code pour renvoyer l'usager sur la page actuelle, en éliminant les paramètres $_POST et $_GET inutiles, ce qui n'est pas possible avec "location.reload".
                //--------------------------------------------------------------------------
                var urlActuel = new RegExp("(\\?r=oeuvre&o=[0-9]+|\\?r=accueil|\\?r=trajet|\\?r=soumission)", "i");//Pages pouvant être trouvées.
                var resultat = urlActuel.exec(document.URL);//Cherche le lien de la page actuelle dans l'url.
                
               if (resultat) {
                    window.location.href = resultat[1];//Si trouvé, renvoyer l'usager sur la page actuelle.
                }
                else {
                    window.location.href = "?r=accueil";//Sinon, valeur par défaut.
                }
//                console.log(resultat);
                //--------------------------------------------------------------------------
            }
            else {//reponse === false
//                console.log("erreur user/pass");
                document.formLogin.user.value = "";
                document.formLogin.pass.value = "";
                document.getElementById("erreurLogin").innerHTML = "nom et\/ou mot de passe incorrect(s)";
            }
        });
    }
}

/**
* @brief Fonction qui déconnecte l'usager du site
* @access public
* @author David Lachambre
*/
function deconnexion(){
    
    $.post('ajaxControler.php?rAjax=deconnexion',
            function(){
            window.location.href = "?r=accueil";
        });
}
/**
* @brief Fonction de validation de modification d'un utilisateur. Soumet la requête en Ajax si aucune erreur et transmet les erreurs, le cas échéant.
* @access public
* @author Philippe Germain
* @return boolean
*/
function valideModifierUtilisateur() {
    
    var erreurs = false;
    var idUtilisateur= document.getElementById("idUtilisateur").value;
    var motPasse = document.getElementById("motdepasseModif").value.trim();
    var motPasseEncrypte = "";
    if (motPasse != "") {
        motPasseEncrypte = md5(motPasse);
    }
    var prenom = document.getElementById("prenomModif").value.trim();
    var nom = document.getElementById("nomModif").value.trim();
    var description = document.getElementById("descriptionModif").value.trim();
    var photo = document.getElementById("fileToUpload");
    var msgErreurPhoto = "";
    
    document.getElementById("erreurPrenomUtilisateurModif").innerHTML = "";
    document.getElementById("erreurNomUtilisateurModif").innerHTML = "";
    document.getElementById("msgModif").innerHTML = "";

    if (prenom == "") {
        document.getElementById("erreurPrenomUtilisateurModif").innerHTML = "Veuillez entrer le nom";
        erreurs = true;
    }
    if (nom == "") {
        document.getElementById("erreurNomUtilisateurModif").innerHTML = "Veuillez entrer l'adresse";
        erreurs = true;
    }

     if (photo.value != "") {
        var fichiersAuthorises = new RegExp("(.jpg|.jpeg|.png)$", "i");//doit se terminer par une des extensions suivantes.
        var resultat = fichiersAuthorises.exec(photo.value);
        if (!resultat) {
            msgErreurPhoto = "Seules les images de type \"JPG\" ou \"PNG\" sont acceptées.";
            erreurs = true;
        }
        if (photo.files[0].size > 5000000) {//Si plus gros que 5Mb...
            if (msgErreurPhoto != "") {
                msgErreurPhoto += "<br>";
            }
            msgErreurPhoto += "Votre image ne doit pas dépasser 5Mb.";
            erreurs = true;
        }
        document.getElementById("erreurPhoto").innerHTML = msgErreurPhoto;
    } 
    //-----------------------------------------
    //Requête AJAX si aucune erreur.
    if (!erreurs) {
        $.post('ajaxControler.php?rAjax=modifierUtilisateur', {motPasse: motPasseEncrypte, prenom: prenom, nom: nom, description: description, idUtilisateur: idUtilisateur}, 
            
            function(reponse){

                var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.
            
                if (msgErreurs.length == 0) {//Si aucune erreur...
                    document.getElementById("prenomModif").value = "";
                    document.getElementById("nomModif").value = "";
                    document.getElementById("descriptionModif").value = "";
//                    $('#formModif').html('');
  
                    $("#msgModif").html("<span style='color:green'>Modification complétée !</span>");
//                    window.location.href = "?r=profil";
                    
                } 
                else {//Sinon indique les erreurs à l'utilisateur.
                    $(msgErreurs).each(function(index, valeur) {
                        if (valeur.errRequeteAjout) {
                            $("#msgModif").html(valeur.errRequeteAjout);
                        }
                        if (valeur.errTitre) {
                            $("#erreurPrenomUtilisateurModif").html(valeur.errTitre);
                        }
                        if (valeur.errAdresse) {
                            $("#erreurNomUtilisateurModif").html(valeur.errAdresse);
                        }
                        if (valeur.errDescription) {
                            $("#erreurDescriptionModif").html(valeur.errDescription);
                        }
                    })
                }
                if (document.getElementById("fileToUpload").value != "") {//Si l'utilisateur a soumis un fichier photo...
                    //Nouvelle requête Ajax pour connaître l'id de la nouvelle oeuvre créée.

                    //Soumission Ajax de la photo une fois la création de l'oeuvre complétée et l'id de l'oeuvre connue.
                    var fd = new FormData();
                    fd.append( 'fileToUpload', $('#fileToUpload')[0].files[0]);
                    
                    $.ajax({
                        url: 'ajaxControler.php?rAjax=ajouterPhotoUtilisateur&idUtilisateur='+idUtilisateur,
                        data: fd,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function(msgErreurs){

                            if (msgErreurs != "") {//Si erreur avec l'insertion de la photo...
                                $("#erreurPhoto").html(msgErreurs);
                            }
                            else {
                                document.getElementById("fileToUpload").value = "";
                            }
                            window.location.href = "?r=profil";
                        }
                    });

                }else{ window.location.href = "?r=profil";}  
        });
    }
    return false;//Retourne toujours false pour que le formulaire ne soit pas soumit.
}
/* --------------------------------------------------------------------
========================= FONCTIONS DIVERSES ==========================
-------------------------------------------------------------------- */

/**
* @brief Fonction qui récupère la valeur d'un cookie selon le nom passé en paramètre
* @access public
* @author W3Schools
* @return void
*/
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

/**
* @brief Fonction qui affiche le formulaire de modification d'une oeuvre après sélection de l'oeuvre à modifier par l'utilisateur.
* @access public
* @author David Lachambre
* @return void
*/
function afficherFormModif() {
    
    var idOeuvre = document.getElementById("selectOeuvreModif").value;
    if (idOeuvre != "") {
        
        $.post('ajaxControler.php?rAjax=afficherFormModif', {idOeuvre: idOeuvre}, 
            function(reponse){
                $('#formModif').html(reponse);
        });
    }
    else {
        $('#formModif').html('');
    }
    
}

/**
* @brief Fonction d'initialisation Google Map Page Trajet, service des directions
* @access public
* @return void
*/
function initMapTrajet() {
     
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: new google.maps.LatLng(45.512090, -73.550979),
        mapTypeId: 'roadmap',
        
    });
    directionsDisplay.setMap(map);
    
        document.getElementById('envoyerTrajetBouton').addEventListener('click', function() {
            
            document.getElementById("erreurPasTrouve").innerHTML ="";
            document.getElementById("erreurDepart").innerHTML = "";
            document.getElementById("erreurDestination").selectedIndex = "";
            document.getElementById("erreurWaypoints").selectedIndex = "";
           
            
            calculateAndDisplayRoute(directionsService, directionsDisplay);
  });
        
         
        
        
    var infoWindow = new google.maps.InfoWindow();
     var image = {
    url: 'images/User_icon_BLACK-01.png',
    // This marker is 20 pixels wide by 32 pixels high.
    scaledSize: new google.maps.Size(25, 25), // scaled size
  };
    var Lemarker = new google.maps.Marker({
        map: map,
        icon: image,        
        title:"Un MontréArtlais"
        });
    // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      Lemarker.setPosition(pos);
      marqueurPlusPresTrajet(position.coords.latitude, position.coords.longitude);
      infoWindow.setPosition(pos);
      infoWindow.setContent('Location found.');
      map.setCenter(pos);
        map.setZoom(14);
         document.getElementById("depart").value = position.coords.latitude+", "+position.coords.longitude;
         
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
    var urlAjax = 'ajaxControler.php?rAjax=googleMap';
    downloadUrl(urlAjax, function(data) {
        var markerArray='';
        var mcOptions = {gridSize: 50, maxZoom: 15};
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        var ClusterMap = [];
        for (var i = 0; i < markers.length; i++) {
            var name = markers[i].getAttribute("name");
            //    var photo = markers[i].getAttribute("photo");
            //    var urlTest = markers[i].getAttribute("urlTest");
            var url = markers[i].getAttribute("url");
            var point = new google.maps.LatLng(
            parseFloat(markers[i].getAttribute("lat")),
            parseFloat(markers[i].getAttribute("lng")));
            var image = {
                
                url : 'images/punaiseMontreart.png',
                size: new google.maps.Size(104, 104),
                scaledSize: new google.maps.Size(50, 50),
                anchor: new google.maps.Point(25, 50)
            };
            var html = "<a href='" + url + "'>" + name + "</a>";
            var marker = new google.maps.Marker({
                position: point,
                icon: image 
            });   marker.setMap(map); 
            ClusterMap.push(marker);   
            bindInfoWindow(marker, map, infoWindow, html);
         
        }var markerCluster = new MarkerClusterer(map, ClusterMap,mcOptions);
    });  
 
}
/**
* @brief Fonction de l'API Google Maps Directions pour calculer une itineraire
* @access public
* @return void
*/
function calculateAndDisplayRoute(directionsService, directionsDisplay) {
   
    document.getElementById("erreurDepart").innerHTML = "";
    document.getElementById("erreurPasTrouve").innerHTML = "";
    document.getElementById("erreurDestination").innerHTML = "";
    document.getElementById("erreurWaypoints").innerHTML = "";
    var erreurs = false;
    
    if (document.getElementById("depart").value.trim() == "") {
        document.getElementById("erreurDepart").innerHTML = "Veuillez entrer votre adresse ou localisation (adresse civique ou longitude et latitude, séparés par une virgule)";
        erreurs = true;
    }

    if (document.getElementById("fin").selectedIndex == "0") {
        document.getElementById("erreurDestination").innerHTML = "Veuillez choisir une destination";
        erreurs = true;
    }
    if (!erreurs) {
        var waypts = [];
        var checkboxArray = document.getElementById('waypoints');
        for (var i = 0; i < checkboxArray.length; i++) {
            if (checkboxArray.options[i].selected) {
                waypts.push({
                location: checkboxArray[i].value,
                stopover: true
                });
            }
        }
        var selectFin = document.getElementById('fin');
        var selectedOptFin = selectFin.options[selectFin.selectedIndex].value;
        directionsService.route({
            origin: document.getElementById('depart').value,
            destination: selectedOptFin,
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: google.maps.TravelMode.WALKING,
            language: 'fr'
        }, function(response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                var route = response.routes[0];
                var summaryPanel = document.getElementById('directions-panel');
                summaryPanel.innerHTML = ' <h2>Votre Trajet: </h2>';
                // For each route, display summary information.
                for (var i = 0; i < route.legs.length; i++) {
                    var routeSegment = i + 1;
                    summaryPanel.innerHTML += '<h4>Partie ' + routeSegment +
                    ' , Marchez à</h4><br>';
                    summaryPanel.innerHTML += route.legs[i].start_address + ' à ';
                    summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                    summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                }
            }             
        });
    }
}


/* --------------------------------------------------------------------
========================= FONCTIONS RECHERCHE =========================
-------------------------------------------------------------------- */

/**
* @brief Fonction d'autocomplete pour la recherche
* @access public
* @return void
*/
function autoComplete(rechercheVoulue, nomServeur)
{
    var MIN_LENGTH = 1;
    var url =  "ajaxControler.php?rAjax=autoComplete&rechercheVoulue=";
    
    $("#keyword").keyup(function() {
        
        var keyword = $("#keyword").val();
        if (keyword.length >= MIN_LENGTH) {
            $.get(url + rechercheVoulue, { keyword: keyword } )
            
            .done(function( data ) {
                
                $('#results').html('');
                var results = jQuery.parseJSON(data);
                
                $(results).each(function(key, value) {

                    if (rechercheVoulue=="titre") {
                        $('#results').append('<div class="item">' + "<a href=http://"+nomServeur+"/?r=oeuvre&o="+value['idOeuvre']+">"+value['titre']+"</a></div>");
                    }
                    else if (rechercheVoulue=="artiste") {
                        if (value['nomCollectif'] != null) {
                            $('#results').append('<div class="item">' + "<a href=http://"+nomServeur+"/?r=recherche&rechercheParArtiste="+value['idArtiste']+"&nomArtiste="+encodeURIComponent(value['nomCollectif'])+">"+value['nomCollectif']+"</a></div>");
                        }
                        else {
                            $('#results').append('<div class="item">' + "<a href=http://"+nomServeur+"/?r=recherche&rechercheParArtiste="+value['idArtiste']+"&nomArtiste="+encodeURIComponent(value['nomCompletArtiste'])+">"+value['nomCompletArtiste']+"</a></div>");
                        }
                    }
                })
                $("#results").show();
            });
        }
        else {
            $('#results').html('');
        }
    });
    
    $("#keyword").blur(function(){
        
        $("#results").fadeOut(500);
    })
}

/**
* @brief Fonction d'autocomplete pour la recherche mobile
* @access public
* @return void
*/
function autoCompleteMobile(rechercheVoulue, nomServeur)
{
    var MIN_LENGTH = 1;
    var url =  "ajaxControler.php?rAjax=autoComplete&rechercheVoulue=";
    
    $("#keywordMobile").keyup(function() {
        
        var keyword = $("#keywordMobile").val();
        if (keyword.length >= MIN_LENGTH) {
            $.get(url + rechercheVoulue, { keyword: keyword } )
            
            .done(function( data ) {

                $('#resultsMobile').html('');
                var results = jQuery.parseJSON(data);
                
                $(results).each(function(key, value) {

                    if (rechercheVoulue=="titre") {
                        $('#resultsMobile').append('<div class="itemMobile">' + "<a href=http://"+nomServeur+"/?r=oeuvre&o="+value['idOeuvre']+">"+value['titre']+"</a></div>");
                    }
                    if (rechercheVoulue=="artiste") {
                        if (value['nomCollectif'] != null) {
                            $('#resultsMobile').append('<div class="itemMobile">' + "<a href=http://"+nomServeur+"/?r=recherche&rechercheParArtiste="+value['idArtiste']+"&nomArtiste="+encodeURIComponent(value['nomCollectif'])+">"+value['nomCollectif']+"</a></div>");
                        }
                        else {
                            $('#resultsMobile').append('<div class="itemMobile">' + "<a href=http://"+nomServeur+"/?r=recherche&rechercheParArtiste="+value['idArtiste']+"&nomArtiste="+encodeURIComponent(value['nomCompletArtiste'])+">"+value['nomCompletArtiste']+"</a></div>");
                        }
                    }
                })
                $("#resultsMobile").show();
            });
        }
        else {
            $('#resultsMobile').html('');
        }
    });
    
    $("#keywordMobile").blur(function(){
        
        $("#resultsMobile").fadeOut(500);
    })
}

/* --------------------------------------------------------------------
======================== FONCTIONS GOOGLE API =========================
-------------------------------------------------------------------- */

/**
* @brief Fonction d'initialisation Google Map
* @access public
* @return void
*/
function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: new google.maps.LatLng(45.512090, -73.550979),
        mapTypeId: 'roadmap'
         
    });
  
    var infoWindow = new google.maps.InfoWindow();
    var image = {
    url: 'images/User_icon_BLACK-01.png',
    scaledSize: new google.maps.Size(25, 25), // scaled size
  };
        var Lemarker = new google.maps.Marker({
        map: map,
        icon: image,        
        title:"Un MontréArtlais"
        }); 
    var positionTimer = navigator.geolocation.getCurrentPosition(
                function (position) {
                  map.panTo(new google.maps.LatLng(
                    position.coords.latitude,
                    position.coords.longitude
                ));
                    map.setZoom(15);
                });
    // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      }; 
        Lemarker.setPosition(pos); // Marqueur de la geolocalisation
        trouveMarqueurPlusPres(position.coords.latitude, position.coords.longitude); // fonction 
       // map.setCenter(pos);
        // map.setZoom(14);
        //map.panTo(pos);
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    },{enableHighAccuracy: true, maximumAge: 100, timeout: 60000 });
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }  
    downloadUrl("ajaxControler.php?rAjax=googleMap", function(data) {
        var markerArray='';
        var mcOptions = {gridSize: 50, maxZoom: 15};
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        var ClusterMap = [];
        for (var i = 0; i < markers.length; i++) {
            var name = markers[i].getAttribute("name");
            //    var photo = markers[i].getAttribute("photo");
            //    var urlTest = markers[i].getAttribute("urlTest");
            var url = markers[i].getAttribute("url");
            var point = new google.maps.LatLng(
            parseFloat(markers[i].getAttribute("lat")),
            parseFloat(markers[i].getAttribute("lng")));
            var image = {
                
                url : 'images/punaiseMontreart.png',
                size: new google.maps.Size(104, 104),
                scaledSize: new google.maps.Size(50, 50),
                anchor: new google.maps.Point(25, 50)
            };
            var html = "<a href='" + url + "'>" + name + "</a>";
            var marker = new google.maps.Marker({
                position: point,
                icon: image 
            });   marker.setMap(map); 
            ClusterMap.push(marker);   
            bindInfoWindow(marker, map, infoWindow, html);
         
        }var markerCluster = new MarkerClusterer(map, ClusterMap,mcOptions);
    });  
}

/**
* @brief fonction pour rayon d'un cercle
* @access public
* @return rayon
*/
function rad(x) {return x*Math.PI/180;}
/**
* @brief Haversine pour calculer la distance entre deux point sur une sphere selon leurs point cardinaux
* @access public
* @return void
* @author https://en.wikipedia.org/wiki/Haversine_formula
*/
function trouveMarqueurPlusPres(lat, lng) {
    var R = 6371; // rayon de la terre en km
    var distances = [];
    var closest = -1;
    
  
     downloadUrl("ajaxControler.php?rAjax=googleMap", function(data) {

        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
         
    for( i=0;i<markers.length; i++ ) {
        var mlat = parseFloat(markers[i].getAttribute("lat"));
        var mlng = parseFloat(markers[i].getAttribute("lng"));
        var dLat  = rad(mlat - lat);
        var dLong = rad(mlng - lng);   
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong/2) * Math.sin(dLong/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c;
        distances[i] = d;

        if ( closest == -1 || d < distances[closest] ) {
            closest = i; 
        }
    }
         document.getElementById("distanceMarqueur").innerHTML = "Vous êtes à " + distances[closest].toFixed(2) + " km de distance de l'oeuvre" + markers[closest].getAttribute("name");
       if (distances[closest]<= 0.50){
                    if(markers[closest].getAttribute("idOeuvre") != null){
                                Date.prototype.yyyymmdd = function() {        //function pour avoir la date d'aujourd'hui 

                                var yyyy = this.getFullYear().toString();                                    
                                var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based         
                                var dd  = this.getDate().toString();             

                                return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]);
                           };  

                        d = new Date();
                        var idOeuvre=markers[closest].getAttribute("idOeuvre");
                        var laDate =d.yyyymmdd();
                        var idUtilisateur=2;
                        $.post('ajaxControler.php?rAjax=visiteOeuvres',{idOeuvre, idUtilisateur ,laDate });
                  }
            }
     });  
}

/**
* @brief Haversine pour calculer la distance entre deux point sur une sphere selon leurs point cardinaux  et instructions pour generer les inputs pour le calcule d'un itinairaire
* @access public
* @return void
* @author https://en.wikipedia.org/wiki/Haversine_formula
*/
function marqueurPlusPresTrajet(lat, lng) {
    var R = 6371; // rayon de la terre en km
    var distances = [];
    var closest = -1;
    
  
     downloadUrl("ajaxControler.php?rAjax=googleMap", function(data) {

        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        var select = document.getElementById("fin");
        var selectMultiple = document.getElementById("waypoints");
    for( i=0;i<markers.length; i++ ) {
        var mlat = parseFloat(markers[i].getAttribute("lat"));
        var mlng = parseFloat(markers[i].getAttribute("lng"));
        var dLat  = rad(mlat - lat);
        var dLong = rad(mlng - lng);   
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong/2) * Math.sin(dLong/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c;
        distances[i] = d;
         
        if ( closest == -1 || d < distances[closest] ) {
            closest = i;
         var opt = document.createElement('option');
            opt.value = markers[i].getAttribute("lat")+','+markers[i].getAttribute("lng");
            opt.innerHTML = markers[i].getAttribute("name");
            select.appendChild(opt);
        var optMult = document.createElement('option');
            optMult.value = markers[i].getAttribute("lat")+','+markers[i].getAttribute("lng");
            optMult.innerHTML = markers[i].getAttribute("name");
            selectMultiple.appendChild(optMult);
        }
    }
         document.getElementById("distanceMarqueur").innerHTML = "Vous êtes à " + distances[closest].toFixed(2) + " km de distance de l'oeuvre " + markers[closest].getAttribute("name");
         
        
});
    
}
/**
* @brief Fonction de mise en page pour la Google Map
* @access public
* @return void
*/
function bindInfoWindow(marker, map, infoWindow, html) {
     
  google.maps.event.addListener(marker, 'click', function() {

    infoWindow.setContent(html);
    infoWindow.open(map, marker);
  });
}

/**
* @brief Fonction Ajax pour la Google Map
* @access public
* @return void
*/
function downloadUrl(url,callback) {
     
    var request = window.ActiveXObject ?
    new ActiveXObject('Microsoft.XMLHTTP') :
    new XMLHttpRequest;

    request.onreadystatechange = function() {

        if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
        }
    };
    request.open('GET', url, true);
    request.send(null);
}
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
}

//-----fonction bidon----------
function doNothing() {}

//fonction pour monter le formulaire login
function afficherLogin() {
    document.getElementById('div_bgform').style.display = "block";
    document.getElementById('div_form').style.display = "block";
}
//fonction pour cacher le formulaire
function fermer(){
    document.getElementById('div_bgform').style.display = "none";
    document.getElementById('div_form').style.display = "none";
}

//fonction pour cacher le formulaire
function fermerApprob(){
    document.getElementById('bgPanneauApprobation').style.display = "none";
    document.getElementById('panneauApprobation').style.display = "none";
}


/* --------------------------------------------------------------------
======================= FONCTIONS PAGE GESTION ========================
-------------------------------------------------------------------- */

/**
* @brief Fonction qui mets à jour les oeuvres de la BDD avec les oeuvres de la ville et mets à jour l'affichage dans la page de gestion.
* @access public
* @author David Lachambre
* @return void
*/
function updateOeuvresVille() {
    
    $("#msgUpdateDate").html("<span style='color:green'>En traitement...</span>");
    
    $.post('ajaxControler.php?rAjax=updateOeuvresVille',
        function(reponse){

            var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

            if (msgErreurs.length == 0) {//Si aucune erreur...

                $("#msgUpdateDate").html("<span style='color:green'>Mise à jour complétée !</span>");

                //Récupération de la nouvelle date de mise à jour.
                $.post('ajaxControler.php?rAjax=updateDate',
                    function(reponse){
                        var tableauDate = jQuery.parseJSON(reponse);

                        var date = "Dernière mise à jour : Le " + tableauDate["dateDernierUpdate"] + " à " + tableauDate["heureDernierUpdate"];
                        $("#affichageDate").html(date);
                    });
            }
            else {//Sinon indique les erreurs à l'utilisateur.
                $(msgErreurs).each(function(index, valeur) {
                    if (valeur.errUrl) {
                        $("#msgUpdateDate").html(valeur.errUrl);
                    }
                })
            }
    });
    return false;
}

/**
* @brief Fonction qui récupère l'oeuvre choisie et affiche son contenu dans un panneau de style pop-up
* @access public
* @author David Lachambre
* @param idOeuvre integer
* @return void
*/
function afficherOeuvrePourApprobation(idOeuvre) {
    
    $.post('ajaxControler.php?rAjax=recupererUneOeuvre', {idOeuvre:idOeuvre},
        function(reponse){
        var oeuvre = jQuery.parseJSON(reponse);
        var langue = getCookie("langue");
        var contenu = "";
        var type = "\"oeuvre\"";
        
        //Vérification des champs null
        if (oeuvre.descriptionFR != null && oeuvre.descriptionFR != "") {
            var descriptionFR = oeuvre.descriptionFR;
        }
        else {
            var descriptionFR = "<span style='color:grey'>vide</span>";
        }
        
        if (oeuvre.descriptionEN != null && oeuvre.descriptionEN != "") {
            var descriptionEN = oeuvre.descriptionEN;
        }
        else {
            var descriptionEN = "<span style='color:grey'>vide</span>";
        }
        
        if (oeuvre.prenomArtiste != null && oeuvre.prenomArtiste != "") {
            var prenomArtiste = oeuvre.prenomArtiste;
        }
        else {
            var prenomArtiste = "<span style='color:grey'>vide</span>";
        }
        
        if (oeuvre.nomArtiste != null && oeuvre.nomArtiste != "") {
            var nomArtiste = oeuvre.nomArtiste;
        }
        else {
            var nomArtiste = "<span style='color:grey'>vide</span>";
        }
        
        if (langue = "FR") {
            if (oeuvre.nomCategorieFR != null) {
                var nomCategorie = oeuvre.nomCategorieFR;
            }
        }
        else if (langue = "EN") {
            if (oeuvre.nomCategorieEN != null) {
                var nomCategorie = oeuvre.nomCategorieEN;
            }
        }
        
        contenu += "<button id='fermer' onclick ='fermerApprob()'>X</button>";
        contenu += "<div id='divPanneauApprobation'>";
        contenu += "<h2>L'oeuvre <a target = '_blank' href='?r=oeuvre&o=" + oeuvre.idOeuvre + "&approbation=true'>" + oeuvre.titre + "</a></h2>";
        contenu += "<input type='hidden' id='idOeuvreSoumise' value='" + oeuvre.idOeuvre + "'>";
        contenu += "<input type='hidden' id='idCategorieSoumise' value='" + oeuvre.idCategorie + "'>";
        contenu += "<input type='hidden' id='idArrondissementSoumis' value='" + oeuvre.idArrondissement + "'>";
        contenu += "<input type='hidden' id='idArtisteSoumis' value='" + oeuvre.idArtiste + "'>";
        contenu += "<p>Titre : <span style='color:green' id='titreAffichageSoumission'>" + oeuvre.titre + "</span><br>";
        contenu += "Adresse : <span style='color:green' id='adresseAffichageSoumission'>" + oeuvre.adresse + "</span><br>";
        contenu += "Description en français : <span style='color:green' id='descriptionFrAffichageSoumission'>" + descriptionFR + "</span><br>";
        contenu += "Description en anglais : <span style='color:green' id='descriptionEnAffichageSoumission'>" + descriptionEN + "</span><br>";
        contenu += "Arrondissement : <span style='color:green' id='arrondissementAffichageSoumission'>" + oeuvre.nomArrondissement + "</span><br>";
        contenu += "Catégorie : <span style='color:green' id='categorieAffichageSoumission'>" + nomCategorie + "</span><br>";
        contenu += "Prénom de l'artiste : <span style='color:green' id='pArtisteAffichageSoumission' class='artisteAffichageSoumission'>" + prenomArtiste + "</span><br>";
        contenu += "Nom de l'artiste : <span style='color:green' id='nArtisteAffichageSoumission' class='artisteAffichageSoumission'>" + nomArtiste + "</span><br>";
        contenu += "</p>";
        contenu += "<input class='boutonHover boutonRefuser' type='button' name='boutonRefuserSoumission' value='Refuser' onclick ='refuserSoumissions(" + type + ", " + oeuvre.idOeuvre + ")'>";
        contenu += "<input class='boutonHover boutonAccepter' type='button' name='boutonAccepterSoumission' value='Accepter' onclick ='accepterSoumissions(" + type + ", " + oeuvre.idOeuvre + ")'>";
        contenu += "<div id='msgErreurApprobation'></div>";
        contenu += "</div>";
        
        document.getElementById('bgPanneauApprobation').style.display = "block";
        document.getElementById('panneauApprobation').style.display = "block";
        document.getElementById("panneauApprobation").innerHTML = contenu;
    });
}

/**
* @brief Fonction qui récupère la photo choisie et affiche son contenu dans un panneau de style pop-up
* @access public
* @author David Lachambre
* @param idPhoto integer
* @return void
*/
function afficherPhotoPourApprobation(idPhoto) {
    
    $.post('ajaxControler.php?rAjax=recupererUnePhoto', {idPhoto:idPhoto},
        function(reponse){
        var photo = jQuery.parseJSON(reponse);
        var contenu = "";
        var type = "\"photo\"";
        var regEx = new RegExp("^[\\w\\W\\s\\S.]*\/([\\w\\W\\s\\S.]+.[a-z]{3,4})$", "i");//pour trouver le nom du fichier.
        var alt = regEx.exec(photo.image) ? "photo soumise par un utilisateur" + regEx.exec(photo.image)[1] : "photo soumise par un utilisateur";//Forme ternaire : Si l'expression est trouvée, alt devient le résultat de l'expression. Sinon, alt devient le texte par défaut.
        
        contenu += "<button id='fermer' onclick ='fermerApprob()'>X</button>";
        contenu += "<div id='divPanneauApprobation'>";
        contenu += "<h2>Photo pour l'oeuvre <a target = '_blank' href='?r=oeuvre&o=" + photo.idOeuvre + "&approbation=true'>" + photo.titre + "</a></h2>";
        contenu += "<img src='../" + photo.image + "' alt='" + alt + "'><br>";
        contenu += "<input class='boutonHover boutonRefuser' type='button' name='boutonRefuserSoumission' value='Refuser' onclick ='refuserSoumissions(" + type + ", " + photo.idPhoto + ")'>";
        contenu += "<input class='boutonHover boutonAccepter' type='button' name='boutonAccepterSoumission' value='Accepter' onclick ='accepterSoumissions(" + type + ", " + photo.idPhoto + ")'>";
        contenu += "<div id='msgErreurApprobation'></div>";
        contenu += "</div>";
        
        document.getElementById('bgPanneauApprobation').style.display = "block";
        document.getElementById('panneauApprobation').style.display = "block";
        document.getElementById("panneauApprobation").innerHTML = contenu;
    });
}

/**
* @brief Fonction qui récupère la photo choisie et affiche son contenu dans un panneau de style pop-up
* @access public
* @author David Lachambre
* @param idPhoto integer
* @return void
*/
function afficherCommentairePourApprobation(idCommentaire) {
    
    $.post('ajaxControler.php?rAjax=recupererUnCommentaire', {idCommentaire:idCommentaire},
        function(reponse){
        var commentaire = jQuery.parseJSON(reponse);
        var contenu = "";
        var type = "\"commentaire\"";
        
        contenu += "<button id='fermer' onclick ='fermerApprob()'>X</button>";
        contenu += "<div id='divPanneauApprobation'>";
        contenu += "<h2>Commentaire pour l'oeuvre <a target = '_blank' href='?r=oeuvre&o=" + commentaire.idOeuvre + "&approbation=true'>" + commentaire.titre + "</a></h2>";
        contenu += "<input type='hidden' id='idCommentaireSoumis' value='" + commentaire.idCommentaire + "'>";
        contenu += "<p id='commentaireAffichageSoumission'>" + commentaire.texteCommentaire + "</p>";
        contenu += "<p>Langue d'origine : <span style='color:green' id='langueCommentaireModif'>" + commentaire.langueCommentaire + "</span></p>";
        contenu += "<input class='boutonHover boutonRefuser' type='button' name='boutonRefuserSoumission' value='Refuser' onclick ='refuserSoumissions(" + type + ", " + commentaire.idCommentaire + ")'>";
        contenu += "<input class='boutonHover boutonAccepter' type='button' name='boutonAccepterSoumission' value='Accepter' onclick ='accepterSoumissions(" + type + ", " + commentaire.idCommentaire + ")'>";
        contenu += "</div id='msgErreurApprobation'></div>";
        contenu += "</div>";
        
        document.getElementById('bgPanneauApprobation').style.display = "block";
        document.getElementById('panneauApprobation').style.display = "block";
        document.getElementById("panneauApprobation").innerHTML = contenu;
    });
}

/**
* @brief Fonction qui accepte une soumission et recharge la liste des soumissions à authoriser
* @param type string
* @param id integer
* @access public
* @author David Lachambre
* @return void
*/
function accepterSoumissions(type, id) {

    switch (type) {
        case "oeuvre":
            var requete = "accepterSoumissionOeuvre";
            break;
        case "photo":
            var requete = "accepterSoumissionPhoto";
            break;
        case "commentaire":
            var requete = "accepterSoumissionCommentaire";
            break;
    }
    
    $.post('ajaxControler.php?rAjax=' + requete, {id: id},
        function(reponse){
        
        var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

        if (msgErreurs.length == 0) {//Si aucune erreur...

            rechargerOeuvresApprob();
            rechargerPhotosApprob();
            rechargerCommentairesApprob();
        }
        else {//Sinon indique les erreurs à l'utilisateur.
            $(msgErreurs).each(function(index, valeur) {

                if (valeur.errRequeteApprob) {
                    $("#msgErreurApprobation").html(valeur.errRequeteApprob);
                }
            })
        }
    });
}

/**
* @brief Fonction qui refuse/supprime une soumission et recharge la liste des soumissions à authoriser
* @param type string
* @param id integer
* @access public
* @author David Lachambre
* @return void
*/
function refuserSoumissions(type, id) {

    switch (type) {
        case "oeuvre":
            var requete = "refuserSoumissionOeuvre";
            break;
        case "photo":
            var requete = "refuserSoumissionPhoto";
            break;
        case "commentaire":
            var requete = "refuserSoumissionCommentaire";
            break;
    }
    
    $.post('ajaxControler.php?rAjax=' + requete, {id: id},
        function(reponse){
        
        var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

        if (msgErreurs.length == 0) {//Si aucune erreur...
            
            rechargerOeuvresApprob();
            rechargerPhotosApprob();
            rechargerCommentairesApprob();
        }
        else {//Sinon indique les erreurs à l'utilisateur.
            $(msgErreurs).each(function(index, valeur) {
                if (valeur.errRequeteSupp) {
                    $("#msgErreurApprobation").html(valeur.errRequeteSupp);
                }
            })
        }
    });
}

/**
* @brief Fonction qui mets à jour dans la page gestion la liste des oeuvres à approuver
* @access public
* @author David Lachambre
* @return void
*/
function rechargerOeuvresApprob() {
    $.post('ajaxControler.php?rAjax=updateLiensApprobOeuvres', 
        function(reponse){

        var soumissions = jQuery.parseJSON(reponse);
        var oeuvresApprob = "";

        for (var i = 1; i <= soumissions.length; i++) {
            oeuvresApprob += '<a href="javascript:;"; onclick="afficherOeuvrePourApprobation(' + soumissions[i-1]['idOeuvre'] + ')">Oeuvre ' + i + ' <span>Soumise le ' + soumissions[i-1]['dateSoumissionOeuvre'] + '</span></a>';
        }
        $("#contenuSoumissionOeuvres").html(oeuvresApprob);
        $("#nbOeuvresEnAttente").html("En attente : " + soumissions.length);
        fermerApprob();
    });
}

/**
* @brief Fonction qui mets à jour dans la page gestion la liste des photos à approuver
* @access public
* @author David Lachambre
* @return void
*/
function rechargerPhotosApprob() {
    $.post('ajaxControler.php?rAjax=updateLiensApprobPhotos', 
        function(reponse){

        var soumissions = jQuery.parseJSON(reponse);
        var photosApprob = "";

        for (var i = 1; i <= soumissions.length; i++) {
            photosApprob += '<a href="javascript:;"; onclick="afficherPhotoPourApprobation(' + soumissions[i-1]['idPhoto'] + ')">Photo ' + i + ' <span>Soumise le ' + soumissions[i-1]['dateSoumissionPhoto'] + '</span></a>';
        }
        $("#contenuSoumissionPhotos").html(photosApprob);
        $("#nbPhotosEnAttente").html("En attente : " + soumissions.length);
        fermerApprob();
    });
}

/**
* @brief Fonction qui mets à jour dans la page gestion la liste des commentaires à approuver
* @access public
* @author David Lachambre
* @return void
*/
function rechargerCommentairesApprob() {
    $.post('ajaxControler.php?rAjax=updateLiensApprobCommentaires', 
        function(reponse){

        var soumissions = jQuery.parseJSON(reponse);
        var commentairesApprob = "";

        for (var i = 1; i <= soumissions.length; i++) {
            commentairesApprob += '<a href="javascript:;"; onclick="afficherCommentairePourApprobation(' + soumissions[i-1]['idCommentaire'] + ')">Commentaire ' + i + ' <span>Soumise le ' + soumissions[i-1]['dateSoumissionCommentaire'] + '</span></a>';
        }
        $("#contenuSoumissionCommentaires").html(commentairesApprob);
        $("#nbCommentairesEnAttente").html("En attente : " + soumissions.length);
        fermerApprob();
    });
}