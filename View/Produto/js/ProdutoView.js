$(function() {
    $("input[type='button']").jqxButton({theme: theme});  
    $("#CadastroForm").jqxWindow({ 
        title: 'Cadastro de Produtos',
        height: 550,
        width: 600,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });  
    $( "#btnNovo" ).click(function( event ) {
        CadProduto('AddProduto', 0);        
    });      
    $( "#btnPesquisar" ).click(function( event ) {
        var pesquisa = $("#parametro").val();
        pesquisa = pesquisa.trim();
        if (pesquisa.length<3){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite pelo menos 3 letras!");
            $( "#dialogInformacao" ).jqxWindow("open");      
            return;
        }            
        CarregaGridProduto();        
    });
    $( "#btnSalvarProduto" ).click(function( event ) {
        SalvarProduto();
    });
});