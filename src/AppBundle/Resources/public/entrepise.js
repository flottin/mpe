let $               = jQuery
let showSiretModal  = JSON.parse( document.currentScript.getAttribute('showSiretModal') );
let siret           = document.currentScript.getAttribute('siret');

/**
 * affichage de la modal si le siret est invalide au chargement de la page
 */
$(window).on('load' , function(){
    if( typeof showSiretModal !== 'undefined' && showSiretModal == true)  {
        $("body").append('<div id="verificationEntreprise" ></div>');
        let urlModal = "/entreprise/verification/modal/" + siret;
        $('#verificationEntreprise').load(urlModal, showModal);
    }
});

/**
 * affiche la modal
 */
showModal = function (  ){
    $('#verificationSiretModal').modal('show');
}

