$(function() {
    $("#vlrTotalVenda").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});          
    //$("#qtdVenda").jqxMaskedInput({ width: 250, height: 25, mask: '[0-9][0-9][0-9].[0-9][0-9][0-9].[0-9][0-9][0-9],[0-9][0-9][0-9]'});
    $("#dscProdutoVenda").keyup(function(key){
        if ((key.keyCode!=40) && (key.keyCode!=38)){
            if ($(this).val().trim()!=''){
                CriarDivAutoComplete($(this).attr('id'), 
                                     "../../Controller/Produto/ProdutoController.php", 
                                     'ListarProdutosVendasAutoComplete',
                                     ";id|codProdutoVenda;COD_PRODUTO|tpoProdutoVenda;TIPO|dscProdutoVenda;DSC_PRODUTO|;value|vlrVenda;VLR_VENDA|nroSequencialVenda;NRO_SEQUENCIAL|qtdEstoqueVenda;QTD_ESTOQUE", 
                                     "value", 
                                     "id",
                                     null);            
            }else{
                if ( $("#divAutoComplete").length ){
                    $("#divAutoComplete").jqxWindow("destroy");
                }
            }
        }else{
            $("#listaPesquisa").jqxListBox('selectedIndex' ,0);
            $("#listaPesquisa").jqxListBox("focus");
        }
    });
    $("#dscProdutoVenda").focus(function(){
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    });   
    
    $("#btnSalvarProdutoVenda").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open");
//        if ($("#indEstoqueVenda").is(":checked")){
//            var check = 'S';
//        }else{
//            var check = 'N';
//        }
        if ($("#tpoProdutoVenda").val()=='P'){
            var check = 'S';
        }else{
            var check = 'N';
        }
        if ($("#nroSequencialVenda").val()==''){
            $("#nroSequencialVenda").val(0);
        }
        $.post('../../Controller/Vendas/ProdutosVendasController.php',
            {method:'InserirProduto',
             codVenda: $("#codVenda").val(),
             nroSequencialVenda: $("#nroSequencialVenda").val(),
             codProdutoVenda: $("#codProdutoVenda").val(),
             vlrVenda: $("#vlrVenda").val(),
             qtdVenda: $("#qtdVenda").val(),
             vlrDesconto: $("#vlrDesconto").val(),
             codFuncionario: $("#codFuncionario").val(),
             qtdEstoqueVenda: $("#qtdEstoqueVenda").val(),
             indEstoqueVenda: check, 
             txtObservacao: $("#txtObservacaoProduto").val(),            
             nroStatusVenda: $("#nroStatusVenda").val()}, function(data){

            data = eval('('+data+')');
            if (data[0]){
                CarregaDadosProdutosVenda();
                $("#dscProdutoVenda").val('');
                $("#qtdVenda").val('');
                $("#vlrVenda").val('');
                $("#nroSequencialVenda").val('');
                $("#codProdutoVenda").val('');
                $("#vlrDesconto").val('0');
                $("#qtdEstoqueVenda").val('');
                $("#codFuncionario").val('-1');
                $("#txtObservacaoProduto").val('');
                $("#indEstoqueVenda").attr('checked', false);
                $( "#dialogInformacao" ).jqxWindow('setContent', "Registro Salvo!");
                setTimeout($( "#dialogInformacao" ).jqxWindow("close"),2000);
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao inserir produto!<br>'+data[1]);
            }
        });
    }); 
    $("#btIncProduto").click(function(){
        $("#codProduto").val("");
        $("#dscProduto").val("");           
        $("#codTipoProduto").val("");          
        $("#codMarca").val("");
        $("#vlrVenda").val("0");
        $("#vlrMinimo").val("0");
        $("#nroAroPneu").val("0");        
        $("#indAtivo").jqxCheckBox('uncheck'); 
        $("#codCfop").val("5102");
        $("#codIcmsOrigem").val("0");
        CarregarComboCategoriaNcm(86, 87088000);
        $("#codIcmsSituacaoTributaria").val("13");
        $("#codPisSituacaoTributaria").val("33");
        $("#codCofinsSituacaoTributaria").val("33");        
        $("#CadastroProdutoForm").jqxWindow("open");
    });
    $( "#btnSalvarProduto" ).click(function( event ) {
        SalvarProduto();
    });
    
});
