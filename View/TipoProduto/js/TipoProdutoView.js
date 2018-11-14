$(function() {
    $("input[type='button']").jqxButton({theme: theme});
    $("#CadastroForm").jqxWindow({ 
        title: 'Cadastro de Tipos de Produtos',
        height: 170,
        width: 500,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });  
    $( "#btnNovo" ).click(function( event ) {
        CadTipoProduto('AddTipoProduto', 0);        
    });      
    $( "#btnPesquisar" ).click(function( event ) {
        var pesquisa = $("#parametro").val();
        pesquisa = pesquisa.trim();
        if (pesquisa.length<3){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite pelo menos 3 letras!");
            $( "#dialogInformacao" ).jqxWindow("open");      
            return;
        }            
        CarregaGridTipoProduto();        
    });
});

$(document).ready(function(){
   CarregaGridTipoProduto(); 
});