$(function() {
    $( "#dtaEntrada" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme});
    $("#btnSalvarEntrada").click(function(){
        SalvarEntradaEstoque();
    });
    $("#btnNovaEntrada").click(function(){
        $("#method").val('AddEntradaEstoque');
        $("#codFornecedor").val(-1);
        $("#codDeposito").val(-1);
        $("#nroNotaFiscal").val('');
        $("#dtaEntrada").val('');
        $("#indEntrada").val('');
        $("#txtObs").val('');
        $("#nroSequencial").val('');
        $("#btnDevolucaoNota").hide();
        $("#btnDevolucaoNotaGarantia").hide();
        $("#btnConsultarNota").hide();
        $("#dadosProduto").hide();
        $('#jqxTabsEntradas').jqxTabs('select', 0);
        $(".TabelaPai").removeClass("disabledTable");
    });
    $("#btnEntradasAbertas").click(function(){
        CarregaListaEntradasAbertas();
    });
});