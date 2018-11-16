function SalvarEntradaEstoque(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");    
    $.post('../../Controller/EntradaEstoque/EntradaEstoqueController.php',{
        method: $("#method").val(),
        nroSequencial: $("#nroSequencial").val(),
        codFornecedor: $("#codFornecedor").val(),
        codDeposito: $("#codDeposito").val(),
        dtaEntrada: $("#dtaEntrada").val(),
        nroNotaFiscal: $("#nroNotaFiscal").val(),
        txtObs: $("#txtObs").val()
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
            $("#nroSequencial").val(data[2]);
            $("#method").val('UpdateEntradaEstoque');
            $( "#dialogInformacao" ).jqxWindow('setContent', "Registro Salvo!");
            $('#jqxTabsEntradas').jqxTabs({ disabled:false });
//            $("#btnDevolucaoNota").show();
//            $("#btnConsultarNota").show();
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Registro salvo com sucesso!');
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');
                $( "#CadastroForm" ).jqxWindow('close');
                CarregaGridFornecedor();
            }, '2000');             
        }
    }); 
     
}function SalvarPagamento(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");    
    $.post('../../Controller/EntradaEstoque/EntradaEstoquePagamentosController.php',{
        method: 'InserirPagamento',
        nroSequencial: $("#nroSequencial").val(),
        dtaPagamento: $("#dtaPagamento").val(),
        codTipoPagamento: $("#codTipoPagamento").val(),
        vlrPagamento: $("#vlrPagamento").val(),
        nroSequencialVenda: $("#nroSequencialVenda").val(),
        nroCheque: $("#nroCheque").val(),
        nroBanco: $("#nroBanco").val(),
        nmeProprietario: $("#nmeProprietario").val(),
        dscMercadoria: $("#dscMercadoria").val()
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
            CarregaDadosPagamentoEntrada();
            $( "#dialogInformacao" ).jqxWindow('setContent', "Registro Salvo!");
            $('#jqxTabsEntradas').jqxTabs({ disabled:false });
            $("#btnConsultarNota").show();
            window.setTimeout($( "#dialogInformacao" ).jqxWindow("close"),2000);
        }
    }); 
     
}

function CarregaListaEntradasAbertas(){
    $("#tdListaEntradasAbertas").html('');
    $("#tdListaEntradasAbertas").html('<div id="ListaEntradasAbertas"></div>');
    $("#EntradasAbertasForm" ).jqxWindow("open");     
    $.post('../../Controller/EntradaEstoque/EntradaEstoqueController.php',{
        method:'ListarEntradasEstoqueAberto'
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
            MontaTabelaVendasAbertas(data[1]);
        }
    }); 
     
}

function MontaTabelaVendasAbertas(ListaVendasAbertas){
    var nomeGrid = 'ListaEntradasAbertas';
    var source =
    {
        localdata: ListaVendasAbertas,
        datatype: "json",
        datafields:
        [
            { name: 'NRO_SEQUENCIAL', type: 'number' },
            { name: 'NRO_NOTA_FISCAL', type: 'string' },
            { name: 'DTA_ENTRADA', type: 'string' },
            { name: 'COD_FORNECEDOR', type: 'string' },
            { name: 'DSC_FORNECEDOR', type: 'string' },
            { name: 'NRO_CNPJ', type: 'string' },
            { name: 'COD_DEPOSITO', type: 'string' },
            { name: 'DSC_DEPOSITO', type: 'string' },
            { name: 'TXT_OBSERVACAO', type: 'string' },
            { name: 'VLR_NOTA', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 950,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: false,
        pageable: false,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
          { text: 'Entrada', dataField: 'NRO_SEQUENCIAL', columntype: 'textbox', width: 80 },
          { text: 'Nota Fiscal', dataField: 'NRO_NOTA_FISCAL', columntype: 'textbox', width: 80 },
          { text: 'Data', dataField: 'DTA_ENTRADA', columntype: 'textbox', width: 180 },
          { text: 'Fornecedor', dataField: 'DSC_FORNECEDOR', columntype: 'textbox', width: 180 },
          { text: 'Depósito', dataField: 'DSC_DEPOSITO', columntype: 'textbox', width: 100 },
          { text: 'Valor Total', dataField: 'VLR_NOTA', columntype: 'textbox', width: 100 }
          
        ]
    });
    $(".jqx-grid-group-column").hide();  
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        $("#codFornecedor").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_FORNECEDOR);
        $("#codDeposito").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_DEPOSITO);
        $("#nroNotaFiscal").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_NOTA_FISCAL);
        datas = $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).DTA_ENTRADA.split('/');
        $("#dtaEntrada").val(new Date(datas[2]+', '+datas[1]+' ,'+datas[0]));
        $("#txtObs").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).TXT_OBSERVACAO);
        $("#nroSequencial").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_SEQUENCIAL);
        $("#nroCNPJ").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_CNPJ);
        $('#jqxTabsEntradas').jqxTabs('select', 0);
        $("#EntradasAbertasForm" ).jqxWindow("close");
        $('#jqxTabsEntradas').jqxTabs({ disabled:false });
        CarregaDadosEntrada();
//        $("#btnDevolucaoNota").show();
//        $("#btnConsultarNota").show();
        $("#method").val('UpdateEntradaEstoque');
    });    
}

function CarregaDadosEntrada(){
    $.post('../../Controller/EntradaEstoque/EntradaEstoqueController.php',
    {method:'CarregaDadosEntradaEstoque',
     nroSequencial: $("#nroSequencial").val()}, function(data){
        data = eval('('+data+')');
        if (data[0]){
            MontaDadosEntrada(data[1][0].DSC_FORNECEDOR, 
                              data[1][0].NRO_NOTA_FISCAL, 
                              data[1][0].DTA_ENTRADA, 
                              data[1][0].VLR_NOTA, 
                              data[1][0].DSC_DEPOSITO);
            $("#nroCNPJ").val(data[1][0].NRO_CNPJ);
            $("#indEntrada").val(data[1][0].IND_ENTRADA);
            if (data[1][0].IND_ENTRADA=='F'){
                if (data[1][0].IND_STATUS_REFERENCIA=='A'){
                    $("#btnConsultarNota").show();
                    $("#btnDevolucaoNota").hide();
                    $("#btnDevolucaoNotaGarantia").hide();
                }else{
                    $("#btnDevolucaoNota").show();
                    $("#btnDevolucaoNotaGarantia").show();
                }
            }
            $("#indEntrada").change();
            $('#jqxTabsEntradas').jqxTabs({ disabled:false });
        }
    });
    $("#method").val('UpdateEntradaEstoque');
}

function MontaDadosEntrada(nmeFornecedor, nroNotaFiscal, dtaEntrada, vlrTotal, dscDeposito){    
    dadosCliente = "<strong>Dados</strong><br>"+
                   "Fornecedor: "+nmeFornecedor+"<br>"+
                   "Nota Fiscal: "+nroNotaFiscal+"<br>"+
                   "Data: "+dtaEntrada+"<br>"+
                   "Depósito: "+dscDeposito+"<br>"+
                   "Valor: "+vlrTotal;
    var div = '';
    div = 'dadosProduto';     
    $("."+div).hide();    
    $("."+div).html(dadosCliente);      
    $("."+div).show('slow');
    $("input[type='button']").jqxButton({theme: theme}); 
}

function CarregaDadosProdutosEntrada(){
    $("#tdListaProdutosEntrada").html('');
    $("#tdListaProdutosEntrada").html('<div id="ListaProdutosEntrada"></div>');   
    $.post('../../Controller/EntradaEstoque/EntradaEstoqueProdutoController.php',
    {method:'ListarDadosProdutosEntrada',
     nroSequencial: $("#nroSequencial").val()}, function(data){
        data = eval('('+data+')');
        if (data[0]){  
            CarregaDadosEntrada();
            MontaTabelaProdutos(data[1]);            
        }
    });    
}

function MontaTabelaProdutos(ListaProdutos){
    var nomeGrid = 'ListaProdutosEntrada';
    var source =
    {
        localdata: ListaProdutos,
        datatype: "json",
        datafields:
        [
            { name: 'COD_PRODUTO', type: 'number' },
            { name: 'DSC_PRODUTO', type: 'string' },
            { name: 'NRO_SEQUENCIAL', type: 'string' },
            { name: 'QTD_ENTRADA', type: 'string' },
            { name: 'VLR_UNITARIO', type: 'string' },
            { name: 'VLR_MINIMO', type: 'string' },
            { name: 'VLR_VENDA', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 950,
        height: 150,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: false,
        pageable: false,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
          { text: 'Código', dataField: 'COD_PRODUTO', columntype: 'textbox', width: 80 },
          { text: 'Produto', dataField: 'DSC_PRODUTO', columntype: 'textbox', width: 180 },
          { text: 'Qtd.', dataField: 'QTD_ENTRADA', columntype: 'textbox', width: 80 },
          { text: 'Valor custo', dataField: 'VLR_UNITARIO', columntype: 'textbox', width: 100 },
          { text: 'Valor mínimo', dataField: 'VLR_MINIMO', columntype: 'textbox', width: 100 },
          { text: 'Valor de venda', dataField: 'VLR_VENDA', columntype: 'textbox', width: 100 }
          
        ]
    });
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        $("#nroSequencial").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_SEQUENCIAL);
        RemoveProdutoVenda($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_PRODUTO,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_SEQUENCIAL,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).QTD_ENTRADA);        
        
    });      
}

function RemoveProdutoVenda(codProduto, nroSequencial, qtdEntrada){
    $.post('../../Controller/EntradaEstoque/EntradaEstoqueProdutoController.php',{
        method:'DeletarProdutoEntrada',
        nroSequencial: nroSequencial,
        codProdutoEstoque: codProduto,
        qtdEntrada: qtdEntrada
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
            CarregaDadosProdutosEntrada();
        }
    }); 
}

function CarregaDadosPagamentoEntrada(){
    $("#tdListaPagamentosEntrada").html('');
    $("#tdListaPagamentosEntrada").html('<div id="listaPagamentosEntrada"></div>');   
    $.post('../../Controller/EntradaEstoque/EntradaEstoquePagamentosController.php',
    {method:'ListarPagamentosEntradas',
     nroSequencial: $("#nroSequencial").val()}, function(data){
        data = eval('('+data+')');
        if (data[0]){  
            CarregaDadosEntrada();
            MontaTabelaPgamentos(data[1]);            
        }
    });    
}

function MontaTabelaPgamentos(ListaPagamentos){
    var nomeGrid = 'listaPagamentosEntrada';
    var source =
    {
        localdata: ListaPagamentos,
        datatype: "json",
        datafields:
        [
            { name: 'DTA_PAGAMENTO', type: 'string' },
            { name: 'VLR_PAGAMENTO', type: 'string' },
            { name: 'NRO_CHEQUE', type: 'string' },
            { name: 'NRO_BANCO', type: 'string' },
            { name: 'NME_PROPRIETARIO', type: 'string' },
            { name: 'DSC_TIPO_PAGAMENTO', type: 'string' },
            { name: 'COD_TIPO_PAGAMENTO', type: 'string' },
            { name: 'NRO_SEQUENCIAL', type: 'string' },
            { name: 'DSC_MERCADORIA', type: 'string' },
            { name: 'NRO_SEQUENCIAL_VENDA', type: 'string' },
            { name: 'NRO_SEQUENCIAL_PAGAMENTO', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 950,
        height: 150,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: false,
        pageable: false,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
          { text: 'Data', dataField: 'DTA_PAGAMENTO', columntype: 'textbox', width: 80 },
          { text: 'Valor', dataField: 'VLR_PAGAMENTO', columntype: 'textbox', width: 80 },
          { text: 'Tipo', dataField: 'DSC_TIPO_PAGAMENTO', columntype: 'textbox', width: 180 }
          
        ]
    });
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        RemovePagamentoVenda($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_PRODUTO,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_SEQUENCIAL_PAGAMENTO,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).QTD_ENTRADA);        
        
    });      
}

function RemovePagamentoVenda(codProduto, nroSequencial){
    $.post('../../Controller/EntradaEstoque/EntradaEstoquePagamentosController.php',{
        method:'DeletarPagamentoEntrada',
        nroSequencialPagamento: nroSequencial
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
            CarregaDadosPagamentoEntrada();
        }
    }); 
}

function CarregaChequesRecebidos(){
    $("#tdListaChequesRecebidos").html('');
    $("#tdListaChequesRecebidos").html('<div id="ListaChequesRecebidos"></div>');   
    $.post('../../Controller/EntradaEstoque/EntradaEstoquePagamentosController.php',
    {method:'ListarChequesRecebidos'}, function(data){
        data = eval('('+data+')');
        if (data[0]){  
            MontaTabelaChequesRecebidos(data[1]);            
        }
    });    
}

function MontaTabelaChequesRecebidos(ListaChequesRecebidos){
    var nomeGrid = 'ListaChequesRecebidos';
    var source =
    {
        localdata: ListaChequesRecebidos,
        datatype: "json",
        datafields:
        [
            { name: 'NRO_CHEQUE', type: 'number' },
            { name: 'NRO_BANCO', type: 'string' },
            { name: 'VLR_PAGAMENTO', type: 'string' },
            { name: 'NME_PROPRIETARIO', type: 'string' },
            { name: 'NRO_SEQUENCIAL', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 950,
        height: 350,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: false,
        pageable: false,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
          { text: 'Cheque', dataField: 'NRO_CHEQUE', columntype: 'textbox', width: 80 },
          { text: 'Banco', dataField: 'NRO_BANCO', columntype: 'textbox', width: 80 },
          { text: 'Proprietário', dataField: 'NME_PROPRIETARIO', columntype: 'textbox', width: 180 },
          { text: 'Valor', dataField: 'VLR_PAGAMENTO', columntype: 'textbox', width: 80 }
          
        ]
    });
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        $("#nroSequencialVenda").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_SEQUENCIAL);
        $("#nroCheque").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_CHEQUE);
        $("#nroBanco").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_BANCO);
        $("#nmeProprietario").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NME_PROPRIETARIO);
        $("#vlrPagamento").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).VLR_PAGAMENTO);
        $("#ListaChequesRecebidosForm").jqxWindow('close');
    });      
}

function VerificaEntradaFechada(){
    if ($("#indEntrada").val()!='A'){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Esta Entrada já foi fechada!");
        $( "#dialogInformacao" ).jqxWindow("open");   
        return true;
    }    
    return false;
}
function FecharEntrada(){
    if (VerificaEntradaFechada()) return;
    $.post('../../Controller/EntradaEstoque/EntradaEstoquePagamentosController.php',
    {method:'FecharEntrada',
     nroSequencial: $("#nroSequencial").val()}, function(data){
        data = eval('('+data+')');
        if (data[0]){  
            CarregaDadosEntrada();
            $( "#dialogInformacao" ).jqxWindow('setContent', "Entrada fechada com sucesso!");
            $( "#dialogInformacao" ).jqxWindow("open");      
        }
    });      
}

function SalvarProduto(){
    if (VerificaEntradaFechada()) return;
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");   
    if ($("#dscProduto").val().trim()==''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o nome do produto!");
        $("#dscProduto").focus();
        return false;
    }  
    if ($("#indAtivo").jqxCheckBox('val')){
        ativa = 'S';
    }else{
        ativa = 'N';
    }            
    $.post('../../Controller/Produto/ProdutoController.php',
        {method: $('#method').val(),
        codProduto: $("#codProduto").val(),
        dscProduto: $("#dscProduto").val(),
        codTipoProduto: $("#codTipoProduto").val(),
        codMarca: $("#codMarca").val(),
        vlrVenda: $("#vlrVenda").val(),
        vlrMinimo: $("#vlrMinimo").val(),
        nroAroPneu: $("#nroAroPneu").val(),
        indAtivo: ativa}, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Produto salvo com sucesso!');
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');
                $( "#CadastroForm" ).jqxWindow('close');
            }, '2000');                
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Produto! '+data[1]);
        }
    });
}

function SalvarProduto(){
    alert(123);
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");   
    if ($("#dscProduto").val().trim()==''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o nome do produto!");
        $("#dscProduto").focus();
        return false;
    }  
    if ($("#indAtivo").jqxCheckBox('val')){
        ativa = 'S';
    }else{
        ativa = 'N';
    }            
    $.post('../../Controller/Produto/ProdutoController.php',
        {method: 'AddProduto',
        codProduto: $("#codProduto").val(),
        dscProduto: $("#dscProduto").val(),
        codTipoProduto: $("#codTipoProduto").val(),
        codMarca: $("#codMarca").val(),
        vlrVenda: $("#vlrVenda").val(),
        vlrMinimo: $("#vlrMinimo").val(),
        nroAroPneu: $("#nroAroPneu").val(),
        indAtivo: ativa}, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $("#codProdutoEstoque").val(data[2][0].COD_PRODUTO);
            $("#dscProdutoEstoque").val($("#dscProduto").val());
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Produto salvo com sucesso!');
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');
                $( "#CadastroProdutoForm" ).jqxWindow('close');
            }, '2000');                
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Produto! '+data[1]);
        }
    });
}

function DevolverNota(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");   
    if ($("#nroCNPJ").val().trim()==''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Este fornecedor não possui CNPJ!");
        return false;
    }
    if ($("#txtLogradouro").val().trim() == '' || $("#txtComplemento").val().trim() == '' || $("#nmeBairro").val().trim() == '' || $("#nmeCidade").val().trim() == '' || $("#sglUf").val().trim() == '' || $("#nroCep").val().trim() == ''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Este fornecedor não possui endereço ou está incompleto!");
        return false;
    }
    if ($("#nroIE").val().trim() == ''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Este fornecedor não possui inscrição estadual!");
        return false;
    }
    $.post('../../Controller/EntradaEstoque/EntradaEstoqueController.php',
        {method: 'DevolverNota',
        codVenda: $("#nroSequencial").val(),
        nroSequencial: $("#nroSequencial").val()
        }, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Nota Devolvida com sucesso!');
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');
            }, '2000');
            CarregaDadosEntrada();
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao Devolver Nota! '+data[1]);
        }
    });
}

function CarregaListaProdutosEntrada(){
    $("#DevolucaoNotaGarantiaForm").jqxWindow("open");
    $("#tdListaProdutosEntradaDevolucao").html('');
    $("#tdListaProdutosEntradaDevolucao").html('<div id="ListaProdutosEntradaDevolucao"></div>');
    $.post('../../Controller/EntradaEstoque/EntradaEstoqueProdutoController.php',
    {
        method:'ListarDadosProdutosEntrada',
        nroSequencial: $("#nroSequencial").val()
    }, function(ListaProduto){
        ListaProduto = eval('('+ListaProduto+')');
        lista = "<table width='100%' style='margin: 1;text-align: left;border-collapse: collapse;'>";
        lista += "<tr style='background-color: #cccccc;padding: 8px;'>\n\
                    <th style='border: 1px solid #aaaaaa;'>Produto</th>\n\
                    <th style='border: 1px solid #aaaaaa;'>Marca</th>\n\
                    <th style='border: 1px solid #aaaaaa;'>Quantidade a ser devolvida</th>\n\
                  </tr>";
        for (i=0;i<ListaProduto[1].length;i++){
            lista += "<tr>\n\
                        <td style='border: 1px solid #aaaaaa;font-size: 15px;padding: 5px;text-align: left;width: 39%;'>"+ListaProduto[1][i].DSC_PRODUTO+"</td>\n\
                        <td style='border: 1px solid #aaaaaa;font-size: 15px;padding: 5px;text-align: left;width: 20%;'>"+ListaProduto[1][i].DSC_MARCA+"</td>\n\
                        <td style='border: 1px solid #aaaaaa;width: 41%;'>\n\
                            <input type='text' style='border: 2px solid #aaaaaa; width: 100%;border-radius: 3px;' placeholder='Informe a quantidade' class='qtdProdutoDevolucao' name='qtdProdutoDevolucao' id='"+ListaProduto[1][i].COD_PRODUTO+"'>\n\
                            <input type='hidden' id='qtdProdutoDevolucao' value='"+ListaProduto[1][i].QTD_ENTRADA+"'>\n\
                        </td>\n\
                      </tr>";
        }
        lista += '</table>';
        $("#ListaProdutosEntradaDevolucao").html(lista);
    }); 
     
}

function DevolverNotaGarantia(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");   
    if ($("#nroCNPJ").val().trim()==''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Este fornecedor não possui CNPJ!");
        return false;
    }
    if ($("#txtLogradouro").val().trim() == '' || $("#txtComplemento").val().trim() == '' || $("#nmeBairro").val().trim() == '' || $("#nmeCidade").val().trim() == '' || $("#sglUf").val().trim() == '' || $("#nroCep").val().trim() == ''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Este fornecedor não possui endereço ou está incompleto!");
        return false;
    }
    if ($("#nroIE").val().trim() == ''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Este fornecedor não possui inscrição estadual!");
        return false;
    }
    var codProdutos = "";
    $('.qtdProdutoDevolucao').each(function(index, value){
        var id = value.id;
        if(value.value !== ''){
            if(value.value <= $('#qtdProdutoDevolucao').val()){
                codProdutos = codProdutos+id+"|"+value.value+";";
            }
        } 
    });
    $.post('../../Controller/EntradaEstoque/EntradaEstoqueController.php',
        {method: 'DevolverNotaGarantia', // tem q criar ainda
        codVenda: $("#nroSequencial").val(), // ta certo isso?
        nroSequencial: $("#nroSequencial").val(),
        codProdutos: codProdutos
        //produtos que serão devolvidos e as quantidades(array)
        }, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Nota Devolvida com sucesso!');
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');
            }, '2000');
            CarregaDadosEntrada();
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao Devolver Nota! '+data[1]);
        }
    });
}

function ConsultarNota(acao){
    $.post('../../Controller/EntradaEstoque/EntradaEstoqueController.php',
        {
            method: 'ConsultarNota',
            codVenda: $("#nroSequencial").val(),
            nroSequencial: $("#nroSequencial").val()
        }, function(data){
            data = eval('('+data+')');
            if (data != null){
                if (!data[0]){
                    if(acao=='F'){
                        return data;
                    }else{
                        $( "#dialogInformacao" ).jqxWindow('setContent', data[1]);
                        $( "#dialogInformacao" ).jqxWindow( "open" );
                    }
                }else{
                    if(acao=='F'){
                        FechaVenda();
                        return false;
                    }else{
                        window.open(data[1].nmeCaminhoDanfe, '_blank');
                    }
                }
            }else{
                return true;
            }
    }); 
}

function CarregaListaEntradasFechadas(){
    $("#tdListaEntradasFechadas").html('');
    $("#tdListaEntradasFechadas").html('<div id="ListaEntradasFechadas"></div>');
    $("#EntradasFechadasForm" ).jqxWindow("open");     
    $.post('../../Controller/EntradaEstoque/EntradaEstoqueController.php',{
        method:'ListarEntradasEstoqueFechadas',
        codFornecedor: $("#codFornecedorPesquisa").val()
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
            MontaTabelaVendasFechadas(data[1]);
        }
    }); 
     
}

function MontaTabelaVendasFechadas(ListaEntradasFechadas){
    var nomeGrid = 'ListaEntradasFechadas';
    var source =
    {
        localdata: ListaEntradasFechadas,
        datatype: "json",
        datafields:
        [
            { name: 'NRO_SEQUENCIAL', type: 'number' },
            { name: 'NRO_NOTA_FISCAL', type: 'string' },
            { name: 'DTA_ENTRADA', type: 'string' },
            { name: 'COD_FORNECEDOR', type: 'string' },
            { name: 'DSC_FORNECEDOR', type: 'string' },
            { name: 'NRO_CNPJ', type: 'string' },
            { name: 'NRO_IE', type: 'string' },
            { name: 'TXT_LOGRADOURO', type: 'string' },
            { name: 'TXT_COMPLEMENTO', type: 'string' },
            { name: 'NME_BAIRRO', type: 'string' },
            { name: 'TXT_LOCALIDADE', type: 'string' },
            { name: 'SGL_UF', type: 'string' },
            { name: 'NRO_CEP', type: 'string' },
            { name: 'COD_DEPOSITO', type: 'string' },
            { name: 'DSC_DEPOSITO', type: 'string' },
            { name: 'TXT_OBSERVACAO', type: 'string' },
            { name: 'VLR_NOTA', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 950,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: false,
        pageable: false,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
          { text: 'Entrada', dataField: 'NRO_SEQUENCIAL', columntype: 'textbox', width: 80 },
          { text: 'Nota Fiscal', dataField: 'NRO_NOTA_FISCAL', columntype: 'textbox', width: 80 },
          { text: 'Data', dataField: 'DTA_ENTRADA', columntype: 'textbox', width: 180 },
          { text: 'Fornecedor', dataField: 'DSC_FORNECEDOR', columntype: 'textbox', width: 180 },
          { text: 'Depósito', dataField: 'DSC_DEPOSITO', columntype: 'textbox', width: 100 },
          { text: 'Valor Total', dataField: 'VLR_NOTA', columntype: 'textbox', width: 100 }
          
        ]
    });
    $(".jqx-grid-group-column").hide();  
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        $("#codFornecedor").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_FORNECEDOR);
        $("#codDeposito").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_DEPOSITO);
        $("#nroNotaFiscal").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_NOTA_FISCAL);
        datas = $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).DTA_ENTRADA.split('/');
        $("#dtaEntrada").val(new Date(datas[2]+', '+datas[1]+' ,'+datas[0]));
        $("#txtObs").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).TXT_OBSERVACAO);
        $("#nroSequencial").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_SEQUENCIAL);
        $("#nroCNPJ").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_CNPJ);
        $("#nroIE").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_IE);
        $("#txtLogradouro").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).TXT_LOGRADOURO);
        $("#txtComplemento").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).TXT_COMPLEMENTO);
        $("#nmeBairro").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NME_BAIRRO);
        $("#nmeCidade").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).TXT_LOCALIDADE);
        $("#sglUf").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).SGL_UF);
        $("#nroCep").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_CEP);
        $('#jqxTabsEntradas').jqxTabs('select', 0);
        $("#EntradasFechadasForm" ).jqxWindow("close");
        $('#jqxTabsEntradas').jqxTabs({ disabled:false });
        CarregaDadosEntrada();
        $("#method").val('UpdateEntradaEstoque');
    });    
}

$(function(){
    $("#indEntrada").change(function(){
        if ($(this).val()=='F'){
            $(".TabelaPai").addClass("disabledTable");
        }else{
            $(".TabelaPai").removeClass("disabledTable");
            $("#btnConsultarNota").hide();
            $("#btnDevolucaoNota").hide();
            $("#btnDevolucaoNotaGarantia").hide();
        }
    });
});