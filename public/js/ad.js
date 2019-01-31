$('#btnAjouterImage').click(function () {
    //Récupére le numéro des futurs champs
    const index = +$('#widget-counter').val();
    console.log(index)
    //Récupére le prototype des entrée pour le formulaire , le g === drapeau qui permet de le 
    //sélectionner plusieurs fois ,, le nombre trouvé sera stocké dans la variable index
    const tmpl = $('#ajouter_annonce_images').data('prototype').replace(/__name__/g, index);
    //J'injecte le code au sein de la div
    $('#ajouter_annonce_images').append(tmpl);
    //gestion boutton supprimer
    $('#widget-counter').val(index + 1);
    gestionButtonDelete();
});

function gestionButtonDelete() {
    $('button[data-action="delete"]').click(function () {
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounterImage() {
    const count = +$('#ajouter_annonce_images div.form-group').length;
    $('#widget-counter').val(count);
}
updateCounterImage();
gestionButtonDelete();