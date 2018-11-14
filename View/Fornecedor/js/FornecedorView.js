$(function() {
    $("#CadastroForm").jqxWindow({ 
        title: 'Cadastro de Fornecedor',
        height: 560,
        width: 700,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });  
    $( "#btnNovo" ).click(function( event ) {
        CadFornecedor('AddFornecedor', 0);        
    });  
});

$(document).ready(function(){
    CarregaGridFornecedor();
});