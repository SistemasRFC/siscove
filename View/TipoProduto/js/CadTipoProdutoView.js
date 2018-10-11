$(function() {
    $("#indAtivo").jqxCheckBox({ width: 120, height: 25, theme: theme });
    $("#vlrMinimo").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
    $("#vlrVenda").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});    
    $( "#btnSalvar" ).click(function( event ) {
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open");   
        if ($("#dscTipoProduto").val().trim()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o nome do Tipo de Produto!");
            $("#dscTipoProduto").focus();
            return false;
        }  
        if ($("#indAtivo").jqxCheckBox('val')){
            ativa = 'S';
        }else{
            ativa = 'N';
        }            
        $.post('../../Controller/TipoProduto/TipoProdutoController.php',
            {method: $('#method').val(),
            codTipoProduto: $("#codTipoProduto").val(),
            dscTipoProduto: $("#dscTipoProduto").val(),
            vlrTipoProduto: $("#vlrTipoProduto").val(),
            indAtivo: ativa}, function(data){

            data = eval('('+data+')');
            if (data[0]){                
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Tipo de Produto salvo com sucesso!');
                window.setTimeout(function (){
                    $( "#dialogInformacao" ).jqxWindow('close');
                    $( "#CadastroForm" ).jqxWindow('close');
                    CarregaGridTipoProduto();
                }, '2000');
                
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Tipo de Produto!');
            }
        });
    });
});