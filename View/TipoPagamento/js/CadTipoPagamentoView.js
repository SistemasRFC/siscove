$(function() {
    $("#indAtivo").jqxCheckBox({ width: 120, height: 25, theme: theme });    
    $("#vlrPorcentagem").maskMoney({symbol:"% ",decimal:",",thousands:"."});    
    $( "#btnSalvar" ).click(function( event ) {
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open");   
        if ($("#dscTipoPagamento").val().trim()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o nome do Tipo de Pagamento!");
            $("#dscTipoPagamento").focus();
            return false;
        }  
        if ($("#indAtivo").jqxCheckBox('val')){
            ativa = 'S';
        }else{
            ativa = 'N';
        }            
        $.post('../../Controller/TipoPagamento/TipoPagamentoController.php',
            {method: $('#method').val(),
            codTipoPagamento: $("#codTipoPagamento").val(),
            dscTipoPagamento: $("#dscTipoPagamento").val(),
            vlrPorcentagem: $("#vlrPorcentagem").val(),
            indAtivo: ativa}, function(data){

            data = eval('('+data+')');
            if (data[0]){                
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Tipo de Pagamento salvo com sucesso!');
                window.setTimeout(function (){
                    $( "#dialogInformacao" ).jqxWindow('close');
                    $( "#CadastroForm" ).jqxWindow('close');
                    CarregaGridTipoPagamento();
                }, '2000');
                
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Tipo de Pagamento!');
            }
        });
    });
});