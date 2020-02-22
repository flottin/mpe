let $               = jQuery
let showSiretModal  = JSON.parse( document.currentScript.getAttribute('showSiretModal') );
let siret           = document.currentScript.getAttribute('siret');

displaySiretModal = function() {
    if( typeof showSiretModal !== 'undefined')  {
        if (showSiretModal == true) {
            $("body").append('<div id="verificationEntreprise" ></div>');
            let urlModal = "/entreprise/verification/modal/" + siret;
            $('#verificationEntreprise').load(urlModal,
                function () {
                    $('#verificationSiretModal').modal('show')
                }
            );
        }
    }
}

$(window).on('load' , function(){
    displaySiretModal();
});