$(function() {
    $("input[type='button']").jqxButton({theme: theme});
    $("#CadastroForm").jqxWindow({ 
        title: 'Cadastro de Tipos de Pagamentos',
        height: 200,
        width: 400,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });  
    $( "#btnNovo" ).click(function( event ) {
        CadTipoPagamento('AddTipoPagamento', 0);        
    });      
    $( "#btnPesquisar" ).click(function( event ) {
        var pesquisa = $("#parametro").val();
        pesquisa = pesquisa.trim();
        if (pesquisa.length<3){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite pelo menos 3 letras!");
            $( "#dialogInformacao" ).jqxWindow("open");      
            return;
        }            
        CarregaGridTipoPagamento();        
    });
});

$(document).ready(function(){
   CarregaGridTipoPagamento(); 
});