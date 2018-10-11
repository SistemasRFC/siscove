$(function() {
    $("input[type='button']").jqxButton({theme: theme});
    $("#CadastroForm").jqxWindow({ 
        title: 'Cadastro de Veiculos',
        height: 150,
        width: 500,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });  
    $( "#btnNovo" ).click(function( event ) {
        CadVeiculo('AddVeiculo', 0);        
    });  
});

$(document).ready(function(){
    CarregaGridVeiculo();
});