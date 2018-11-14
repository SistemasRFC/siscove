$(function() {    
    $("input[type='button']").jqxButton({theme: theme});   
    $("#CadastroForm").jqxWindow({ 
        title: 'Cadastro de Clientes',
        height: 500,
        width: 900,
        maxWidth: 1200,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });  
    $( "#btnNovo" ).click(function( event ) {
        CadCliente('AddCliente', 0);        
    });  
    $( "#btnPesquisar" ).click(function( event ) {
        var pesquisa = $("#parametro").val();
        pesquisa = pesquisa.trim();
        if (pesquisa.length<3){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite pelo menos 3 letras!");
            $( "#dialogInformacao" ).jqxWindow("open");      
            return;
        }            
        CarregaGridCliente();        
    });    
});