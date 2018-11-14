$(function() {
    $( "#dtaVendaInicio" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaVendaFim" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});                
    $("#btnPesquisa").click(function(){
        CarregaGridProduto();       
    });
});

function CarregaGridProduto(){
    $("#conteudo").html('');
    $("#conteudo").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Relatorios/RelatoriosEstoqueController.php',
        {   method: 'ListarProdutosMaisVendidos',
            dtaVendaInicio: $("#dtaVendaInicio").val(),
            dtaVendaFim: $("#dtaVendaFim").val()},function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaProdutos(data[1]);         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}

function MontaTabelaProdutos(listaProdutos){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaProdutos,
        datatype: "json",
        datafields:
        [
            { name: 'DSC_PRODUTO', type: 'string' },
            { name: 'DSC_MARCA', type: 'string' },
            { name: 'QTD_VENDA', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 1200,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: true,
        pageable: false,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
            { text: 'Produto', datafield: 'DSC_PRODUTO', columntype: 'textbox', width: 280},
            { text: 'Marca', datafield: 'DSC_MARCA', columntype: 'textbox', width: 280},
            { text: 'Qtd', datafield: 'QTD_VENDA', columntype: 'textbox', width: 80}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $("#dialogInformacao" ).jqxWindow("close");  
}
