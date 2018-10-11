$(document).ready(function(){
    $("input[type='button']").jqxButton({theme: theme}); 
    $('#jqxTabsEntradas').jqxTabs({ width: '90%', position: 'top'});
    $('#settings div').css('margin-top', '10px');
    $("#btnDevolucaoNota").hide();
    $("#btnConsultarNota").hide();
    $('#jqxTabsEntradas').jqxTabs({ selectionTracker: true, disabled:true});
    $('#jqxTabsEntradas').jqxTabs({ animationType: 'fade' });
    $('#jqxTabsEntradas').on('selected', function (event) 
    { 
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }        
        var selectedTab = event.args.item;
        if (selectedTab==1){
            CarregaDadosEntrada();
            CarregaDadosProdutosEntrada();
        }else if (selectedTab==2){
            CarregaDadosEntrada();
            CarregaDadosPagamentoEntrada();
        }
    }); 
    $('#jqxTabsEntradas').on('unselected', function (event) { 
        var unselectedTab = event.args.item;
        if (unselectedTab==0){
            $("#btnSalvarVenda").click();
        }    
    });      
    $("#jqxTabsEntradas").focus(function(){
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    });
    
    $("#btnDevolucaoNota").click(function(){
        DevolverNota();
    });
    $("#btnConsultarNota").click(function(){
        ConsultarNota();
    });
    $("#btnEntradasFechadas").click(function(){
        $("#EntradasFechadasForm" ).jqxWindow("open");
    });
    $("#btnPesquisarEntrada").click(function(){
        CarregaListaEntradasFechadas();
    });
    
    $("input[type=text]").focus(function(){
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    });  
    CriarCombo('codFornecedor', 
               '../../Controller/Fornecedor/FornecedorController.php', 
               'method;ListarFornecedorAtivo', 
               'COD_FORNECEDOR|DSC_FORNECEDOR', 
               'DSC_FORNECEDOR', 
               'COD_FORNECEDOR');
    CriarCombo('codFornecedorPesquisa', 
               '../../Controller/Fornecedor/FornecedorController.php', 
               'method;ListarFornecedorAtivo', 
               'COD_FORNECEDOR|DSC_FORNECEDOR', 
               'DSC_FORNECEDOR', 
               'COD_FORNECEDOR');
    CriarCombo('codDeposito', 
               '../../Controller/Deposito/DepositoController.php', 
               'method;ListarDepositosAtivos', 
               'COD_DEPOSITO|DSC_DEPOSITO', 
               'DSC_DEPOSITO', 
               'COD_DEPOSITO');                
});