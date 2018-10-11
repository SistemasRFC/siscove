var dataAdapter_Produtos = '';
$(function() {
    $("#vlrTotalVenda").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
    $("#dscProdutoVenda").keyup(function(){ 
        if ($(this).val().trim()!=''){
            CriarDivAutoComplete($(this).attr('id'), 
                                 "../../Controller/Produto/ProdutoController.php", 
                                 'ListarProdutosVendasAutoComplete',
                                 ";id|codProdutoVenda;COD_PRODUTO|dscProdutoVenda;DSC_PRODUTO|;value|vlrVenda;VLR_VENDA|nroSequencialVenda;NRO_SEQUENCIAL|qtdEstoqueVenda;QTD_ESTOQUE", 
                                 "value", 
                                 "id");            
        }else{
            if ( $("#divAutoComplete").length ){
                $("#divAutoComplete").jqxWindow("destroy");
            }
        }
    });
    $("#dscProdutoVenda").focus(function(){
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    });            

    $("#btnResumoVenda").click(function(){
        window.open('../../Controller/Relatorios/RelatoriosVendasController.php?codVenda='+$("#codVenda").val()+'&method=ResumoOrcamento','page','left=100,top=50,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=700,height=500');
    });    
    $("#btnSalvarProdutoVenda").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open");
        if ($("#indEstoqueVenda").is(":checked")){
            var check = 'S';
        }else{
            var check = 'N';
        }
        if ($("#nroSequencialVenda").val()==''){
            $("#nroSequencialVenda").val(0);
        }

        $.post('../../Controller/Orcamentos/ProdutosOrcamentosController.php',
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
        $("#CadastroProdutoForm").jqxWindow("open");
    });
    $( "#btnSalvarProduto" ).click(function( event ) {
        SalvarProduto();
    });
    
});
