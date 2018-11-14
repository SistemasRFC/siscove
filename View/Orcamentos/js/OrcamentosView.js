$(document).ready(function () {   
    $("input[type='button']").jqxButton({theme: theme}); 
    $('#jqxTabsOrcamentos').jqxTabs({ width: '90%', position: 'top'});
    $('#settings div').css('margin-top', '10px');
    $('#jqxTabsOrcamentos').jqxTabs({ selectionTracker: true, disabled:true});
    $('#jqxTabsOrcamentos').jqxTabs({ animationType: 'fade' });
    $('#jqxTabsOrcamentos').on('selected', function (event) 
    { 
        var selectedTab = event.args.item;
        if (selectedTab==0){
            if ($("#codVenda").val()>0){
                CarregaDadosVenda();
            }
        }else if (selectedTab==1){
            CarregaDadosProdutosVenda();
        }
    }); 
    $('#jqxTabsOrcamentos').on('unselected', function (event) { 
        var unselectedTab = event.args.item;
        if (unselectedTab==0){
            $("#btnSalvarVenda").click();
        }    
    });      
    $("#jqxTabsOrcamentos").focus(function(){
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    });
    
    $("input[type=text]").focus(function(){
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    });      
    CriarCombo('codVendedor', 
               '../../Controller/Funcionario/FuncionarioController.php', 
               'method;ListarVendedoresAtivos', 
               'COD_FUNCIONARIO|NME_FUNCIONARIO', 
               'NME_FUNCIONARIO', 
               'COD_FUNCIONARIO');     
    CriarCombo('codFuncionario', 
               '../../Controller/Funcionario/FuncionarioController.php', 
               'method;ListarVendedoresAtivos', 
               'COD_FUNCIONARIO|NME_FUNCIONARIO', 
               'NME_FUNCIONARIO', 
               'COD_FUNCIONARIO'); 
    VerificaOrcamentosUsuarioLogado();
    RetornaPerfilUsuarioLogado();
    $(".btnResumoVenda").hide();
    $("#method").val('InsertVenda');    
});