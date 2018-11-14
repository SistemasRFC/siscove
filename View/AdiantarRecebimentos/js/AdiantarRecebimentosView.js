$(function() {    
    $("input[type='button']").jqxButton({theme: theme});
    $( "#dtaVendaInicio" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaVendaFim" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});  
    $( "#btnPesquisar" ).click(function( event ) {            
        CarregaGridPagamentos();        
    });     
    $( ".btnSalvar" ).click(function( event ) {            
        SalvarValores();        
    });
});