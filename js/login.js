
//methode pour monter le formulaire login
function montrer_form() {
    document.getElementById('div_bgform').style.display = "block";
    document.getElementById('div_form').style.display = "block";
}
//methode pour cacher le formulaire
function fermer(){
    document.getElementById('div_bgform').style.display = "none";
    document.getElementById('div_form').style.display = "none";
}