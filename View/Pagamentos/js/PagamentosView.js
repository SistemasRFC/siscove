$(function() {
    $("#CadastroForm").jqxWindow({ 
        title: 'Cadastro de Pagamentos',
        height: 240,
        width: 550,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });  
    $("#ChequesRecebidos").jqxWindow({ 
        title: 'Cheques Recebidos',
        height: 550,
        width: 550,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });  
    $("#InformaPagamento").jqxWindow({ 
        title: 'Pagamentos',
        height: 550,
        width: 550,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });      
    $( "#btnPesquisa" ).click(function( event ) {
        CarregaGridConta();
    });       
    $( "#btnNovo" ).click(function( event ) {        
        CadConta('InserirConta', 0);        
    });  
    $( "#btnExportar" ).click(function( event ) {
        $("#ListagemForm").jqxGrid('exportdata', 'xls', 'jqxGrid');        
    }); 
    
});

$(document).ready(function(){   
    $("input[type='button']").jqxButton({theme: theme});
    $("input[type='text']").jqxInput({theme: theme, width: '250px', height: '25px'});
    d = new Date();    
    mes = d.getMonth();
    mes = parseInt(mes)+1;
    if (mes<10){
        mes = '0'+mes;
    }    
    CriarCombo('codTipoPagamento', 
               '../../Controller/TipoPagamento/TipoPagamentoController.php', 
               'method;ListarTipoPagamentoAtivo', 
               'COD_TIPO_PAGAMENTO|DSC_TIPO_PAGAMENTO', 
               'DSC_TIPO_PAGAMENTO', 
               'COD_TIPO_PAGAMENTO');      
    CriarCombo('codTipoConta', 
               '../../Controller/TipoConta/TipoContaController.php', 
               'method;ListarTipoContaAtivo', 
               'COD_TIPO_CONTA|DSC_TIPO_CONTA', 
               'DSC_TIPO_CONTA', 
               'COD_TIPO_CONTA');   
    CriarCombo('comboTpoDespesa', 
               '../../Controller/TipoConta/TipoContaController.php', 
               'method;ListarTipoContaAtivoPesquisa', 
               'COD_TIPO_CONTA|DSC_TIPO_CONTA', 
               'DSC_TIPO_CONTA', 
               'COD_TIPO_CONTA');                
    CriarCombo('comboNroAnoReferencia', 
               '../../Controller/Pagamentos/PagamentosController.php', 
               'method;ListarAnos', 
               'NRO_ANO_REFERENCIA|NRO_ANO_REFERENCIA', 
               'NRO_ANO_REFERENCIA', 
               'NRO_ANO_REFERENCIA', d.getFullYear());        
    CriarCombo('comboNroMesReferencia', 
               '../../Controller/Pagamentos/PagamentosController.php', 
               'method;ListarMeses', 
               'NRO_MES_REFERENCIA|DSC_MES_REFERENCIA', 
               'DSC_MES_REFERENCIA', 
               'NRO_MES_REFERENCIA', mes);       
    
    //CarregaGridPagamento();
    $("#trDadosCheque").hide();
    $("#codTipoPagamento").change(function(){
        if ($(this).val()==4){
            $("#trDadosCheque").show();
        }else{
            $("#trDadosCheque").hide();
        }
    });
    $("body").show();
    MontaComboFixo('comboIndStatus', 'indStatus', '-1');  
});