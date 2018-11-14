$(document).ready(function () { 
    $("#btnNota").hide();
    $("#btnCancelarNota").hide();
    $("#btnReabrirVenda").hide();
    $("#btnEnviarEmail").hide();
    
    $("input[type='button']").jqxButton({theme: theme}); 
    
    $('#jqxTabsVendas').jqxTabs({ width: '90%', position: 'top'});
    $('#settings div').css('margin-top', '10px');
    $('#jqxTabsVendas').jqxTabs({ selectionTracker: true, disabled:true});
    $('#jqxTabsVendas').jqxTabs({ animationType: 'fade' });
    $('#jqxTabsVendas').on('selected', function (event){ 
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }        
        var selectedTab = event.args.item;
        if (selectedTab==0){
            if ($("#codVenda").val()>0){
                CarregaDadosVenda();
            }
        }else if (selectedTab==1){
            CarregaDadosProdutosVenda();
        }else if (selectedTab==2){
            CarregaDadosVenda();
            CarregaTabelaPagamentos();
        }
    }); 
    $('#jqxTabsVendas').on('unselected', function (event) { 
        var unselectedTab = event.args.item;
        if (unselectedTab==0){
            $("#btnSalvarVenda").click();            
        }   
        
    });    
    $("#jqxTabsVendas").focus(function(){
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    });
    
    $("#btnPesquisa").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent',
                                           'Digite o código da venda:\n\
                                            <br><input type="text" id="txtPesquisa" size="30">\n\
                                            <br><br> <input type="button" value="Pesquisar" id="btnDinPesquisa">');
        $( "#dialogInformacao" ).jqxWindow( "open" );
        $("#btnDinPesquisa").jqxButton({theme: theme});
        $("#btnDinPesquisa").click(function(){
            $("#codVenda").val($("#txtPesquisa").val());
            CarregaDadosVenda();
            $( "#dialogInformacao" ).jqxWindow( "close" );
            $('#jqxTabsVendas').jqxTabs('select', 0);
        });
        $("#txtPesquisa").jqxInput({theme: theme, height: 25});  
        $("#txtPesquisa").focus();
        $("#txtPesquisa").keyup(function(event){
//            console.log(event);
            if (event.keyCode==13){
                $("#btnDinPesquisa").click();
            }
        });
    });
    
    if ($("#codVenda").val()>0){
        CarregaDadosVenda();
        $('#jqxTabsVendas').jqxTabs('select', 0);
    }
    
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
               'method;ListarFuncionariosAtivos', 
               'COD_FUNCIONARIO|NME_FUNCIONARIO', 
               'NME_FUNCIONARIO', 
               'COD_FUNCIONARIO');    
    CriarCombo('codTipoPagamento', 
               '../../Controller/Vendas/FormaPagamentoVendasController.php', 
               'method;ListarTipoPagamento', 
               'COD_TIPO_PAGAMENTO|DSC_TIPO_PAGAMENTO', 
               'DSC_TIPO_PAGAMENTO', 
               'COD_TIPO_PAGAMENTO');  
    $("#method").val('InsertVenda');
    //VerificaVendasUsuarioLogado();
    RetornaPerfilUsuarioLogado();
    $("#btnNota").click(function(){
        ConsultarNota();
    });
    $("#btnCancelarNota").click(function(){
        CancelarNota();
    });    
    $("#btnEnviarEmail").click(function(){
        EnviarEmail();
    });    
    $("#btnReabrirVenda").click(function(){
        ReabrirVenda($("#codVenda").val());
    });
});
