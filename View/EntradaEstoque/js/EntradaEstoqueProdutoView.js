$(function() {
    $("#vlrCustoUnitario").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
    $("#vlrMinimo").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
    $("#vlrVenda").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
    $("#dscProdutoEstoque").keyup(function(){ 
        if ($(this).val().trim()!=''){
            CriarDivAutoComplete($(this).attr('id'), 
                                 "../../Controller/Produto/ProdutoController.php", 
                                 'ListarProdutosAutoComplete',
                                 ";id|codProdutoEstoque;COD_PRODUTO|dscProdutoEstoque;DSC_PRODUTO|;value", 
                                 "value", 
                                 "id");            
        }else{
            if ( $("#divAutoComplete").length ){
                $("#divAutoComplete").jqxWindow("destroy");
            }
        }
    });
    $("#dscProdutoEstoque").focus(function(){
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    }); 
    $("#vlrCustoUnitario").blur(function(){
        vlrMinimo = $(this).val();        
        while(vlrMinimo.indexOf(".") >= 0) {
            vlrMinimo = vlrMinimo.replace(".","");
        }
        vlrMinimo = vlrMinimo.replace(',','.');
        vlrMinimo = parseFloat(vlrMinimo)*parseFloat(0.25)+parseFloat(vlrMinimo);
        $("#vlrMinimo").val(Formata(vlrMinimo, 2, ',', '.'));        
        vlrVenda = $(this).val();
        while(vlrVenda.indexOf(".") >= 0) {
            vlrVenda = vlrVenda.replace(".","");
        }
        vlrVenda = vlrVenda.replace(',','.');
        vlrVenda = parseFloat(vlrVenda)*parseFloat(0.35)+parseFloat(vlrVenda);
        $("#vlrVenda").val(Formata(vlrVenda, 2, ',', '.')); 
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
    $("#btnSalvarProdutoEntrada").click(function(){
        if (VerificaEntradaFechada()) return;
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

        $.post('../../Controller/EntradaEstoque/EntradaEstoqueProdutoController.php',
            {method:'InserirProduto',
             nroSequencial: $("#nroSequencial").val(),
             codProdutoEstoque: $("#codProdutoEstoque").val(),
             vlrVenda: $("#vlrVenda").val(),
             qtdEntrada: $("#qtdEntrada").val(),
             vlrMinimo: $("#vlrMinimo").val(),
             vlrCustoUnitario: $("#vlrCustoUnitario").val()}, function(data){

            data = eval('('+data+')');
            if (data[0]){
                CarregaDadosProdutosEntrada();
                $("#codProdutoEstoque").val('');
                $("#dscProdutoEstoque").val('');
                $("#vlrVenda").val('');
                $("#qtdEntrada").val('');
                $("#vlrMinimo").val('');
                $("#vlrCustoUnitario").val('');
                $( "#dialogInformacao" ).jqxWindow('setContent', "Registro Salvo!");
                setTimeout($( "#dialogInformacao" ).jqxWindow("close"),2000);
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao inserir produto!<br>'+data[1]);
            }
        });
    }); 
    $( "#btnSalvarProduto" ).click(function( event ) {
        SalvarProduto();
    });
    $("#btnFecharEntrada").click(function(){
        FecharEntrada();
    });    
});