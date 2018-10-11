$(function() {
    $("#CadastroForm").jqxWindow({ 
        title: 'Cadastro de Marcas',
        height: 180,
        width: 500,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });  
    $( "#btnNovo" ).click(function( event ) {
        CadMarca('AddMarca', 0);        
    });  
});

$(document).ready(function(){
    CarregaGridMarca();
});