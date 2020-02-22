let $       = jQuery
let url     = document.currentScript.getAttribute('url');

/**
 * affichage de la modal si le siret est invalide au chargement de la page
 */
$(window).on('load' , function(){
    $("body").append('<div id="verificationEntreprise" ></div>');
    $('#verificationEntreprise').load(url, showModal);
});

/**
 * affiche la modal
 */
showModal = function (  ){
    $('#verificationSiretModal').modal('show');
}

