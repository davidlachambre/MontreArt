<h2>Test unitaire - ajout commentaire BDD</h2>
<div id="contenu">

<?php

   $commentaire = new Commentaire();
  

    if (isset($_GET["testajoutCommentaire"])) {      
           if (!empty($_GET["commentaireAjout"])){
         $commentaire->ajoutCommentairesByOeuvre(1, 'FR', $_GET['commentaireAjout'],$_GET['vote'], 1, false); 
         // $commentaire->ajoutCommentairesByOeuvre($_GET["o"], $this->langueAffichage, $_GET['Commentaire'],$_GET['vote']);
              
     }
         else {
            echo "ne laissez rien en blanc";
        }
    }    
?>   
    
    <form method="get" name="formTestAjoutCommentaire" >                

                <textarea name='commentaireAjout' placeholder="Commentaire (obligatoire)"></textarea>
                <div class="cont">
                  <div class="stars">
                      <input class="star star-5" name='vote' id="star-5-2" type="radio" name="star" value='5'/>
                      <label class="star star-5" for="star-5-2"></label>
                      <input class="star star-4"  name='vote'id="star-4-2" type="radio" name="star" value='4'/>
                      <label class="star star-4" for="star-4-2"></label>
                      <input class="star star-3" name='vote' id="star-3-2" type="radio" name="star" checked="checked" value='3'/>
                      <label class="star star-3" for="star-3-2"></label>
                      <input class="star star-2" name='vote' id="star-2-2" type="radio" name="star" value='2'/>
                      <label class="star star-2" for="star-2-2"></label>
                      <input class="star star-1"  name='vote' id="star-1-2" type="radio" name="star" value='1'/>
                      <label class="star star-1" for="star-1-2"></label>
                  </div>
                </div>
                <input  type='submit' name='testajoutCommentaire' value='Ajouter'>
            </form>
</div>