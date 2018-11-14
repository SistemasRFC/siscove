$(function() {
    $( "#dtaPagamento" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme}); 
    $("#vlrPagamento").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
    $('#codTipoPagamento').change(function() {
        if ($("#codTipoPagamento").val()==4){
            $("#cheques").css("border", "1px solid #990000");
            $("#cheques").css("display", "block");
            $("#mercadoria").css("display", "none");
        }else if ($("#codTipoPagamento").val()==5){
            $("#mercadoria").css("border", "1px solid #990000");
            $("#mercadoria").css("display", "block");
            $("#cheques").css("display", "none");

        }else{
            $("#mercadoria").css("display", "none");
            $("#cheques").css("display", "none");
        }
    });
    $("#btnImportaCheque").click(function(){
        CarregaChequesRecebidos();
        $("#ListaChequesRecebidosForm").jqxWindow('open');
    });
    $("#btnSalvarPagamento").click(function(){
        SalvarPagamento();
    });
    $("#btnFecharEntrada").click(function(){
        FecharEntrada();
    });
});