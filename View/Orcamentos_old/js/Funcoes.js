function VerificaValoresAbaixoMinimo(){
    $.post('../../Controller/Orcamentos/FormaPagamentoOrcamentosController.php',
    {method:'VerificaValoresAbaixoMinimo',
     codVenda: $("#codVenda").val()}, function(data){
        data = eval('('+data+')');
        $("#indAbaixo").val(data);
    });
}

function RetornaPerfilUsuarioLogado(){
    $.post('../../Controller/Seguranca/PerfilController.php',
    {method:'RetornaPerfilUsuarioLogado'}, function(data){
        data = eval('('+data+')');
        if (data[0]){
            $("#codPerfil").val(data[1][0].COD_PERFIL);
            if ($("#codPerfil").val()!='3' && $("#codPerfil").val()!='4' ){
                $("#btFecharVenda").show();
            }else{
                $("#btFecharVenda").hide();
            }                
        }
    });
}

function VerificaOrcamentosUsuarioLogado(){
    $.post('../../Controller/Orcamentos/OrcamentosController.php',
        {method: 'VerificaOrcamentosAberto'}, function(data){

        data = eval('('+data+')');

        if (data){
            
            $( "#AvisoOrcamentosAbertas" ).jqxWindow("open"); 
            $(".jqx-window-header").hide();
            var i=5;
            setInterval(function(){
                if (i==0){
                    $(".jqx-window-header").show();
                    $( "#AvisoOrcamentosAbertas" ).jqxWindow("close");
                }
                $( "#AvisoOrcamentosAbertas" ).jqxWindow('setContent', "<div align='center' style='vertical-align: middle; display: table-cell; height: 220'>Existem vendas em aberto cadastradas com seu usuário, favor resolver pendências<br>Esta janela fechará em "+i+" segundos</div>");
                i--;
            },"1000");
        }
    });
}

function MostraOrcamentosCliente(codCliente){
    $("#tdListaOrcamentosCliente").html('');
    $("#tdListaOrcamentosCliente").html('<div id="ListaOrcamentosCliente"></div>');
    $("#ListaOrcamentosCliente" ).html('setContent', "Aguarde!");
    $("#OrcamentosClienteForm" ).jqxWindow("open"); 
    $.post('../../Controller/Orcamentos/OrcamentosController.php',
    {method:'ListarOrcamentosCliente',
     codClienteVenda: codCliente}, function(data){
        data = eval('('+data+')');
        if (data[0]){
            MontaTabelaOrcamentos(data[1]);
        }
    });
}

function MontaTabelaOrcamentos(Lista){    
    var source =
    {
        dataType: "json",
        dataFields: [
            { name: 'COD_VENDA', type: 'number' },
            { name: 'DSC_CLIENTE', type: 'string' },
            { name: 'MES_ANO', type: 'string' },
            { name: 'NME_VENDEDOR', type: 'string' },
            { name: 'DTA_VENDA', type: 'string' },
            { name: 'VLR_VENDA', type: 'string' },
            { name: 'NRO_CPF', type: 'string' },
            { name: 'NRO_CNPJ', type: 'string' },
            { name: 'DSC_VEICULO', type: 'string' }
        ],
        id: 'COD_VENDA',
        localdata: Lista
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    // create Tree Grid
    $("#ListaOrcamentosCliente").jqxGrid(
    {
        width: 950,
        height: 350,
        source: dataAdapter,
        sortable: true,
        groupable: true,
        columns: [
          { text: 'Venda', dataField: 'COD_VENDA', width: 50 },
          { text: '', dataField: 'MES_ANO', width: 200 },
          { text: 'Cliente', dataField: 'DSC_CLIENTE', width: 180 },
          { text: 'Vendedor', dataField: 'NME_VENDEDOR', width: 200 },
          { text: 'Data', dataField: 'DTA_VENDA', width: 100 },
          { text: 'Valor', dataField: 'VLR_VENDA', width: 100 },
          { text: 'CPF', dataField: 'NRO_CPF', width: 100 },
          { text: 'CNPJ', dataField: 'NRO_CNPJ', width: 100 },
          { text: 'Veiculo', dataField: 'DSC_VEICULO', width: 200 }
        ],
        groups: ['MES_ANO']
    });
    $('#ListaOrcamentosCliente').jqxGrid('hidecolumn', 'MES_ANO');
    $(".jqx-grid-group-column").hide();
}

function CarregaDadosCliente(){
    $.post('../../Controller/Cliente/ClienteController.php',
    {method:'CarregaDadosCliente',
     codCliente: $("#codClienteVenda").val()}, function(data){
        data = eval('('+data+')');
        if (data[0]){   
            MontaDadosCliente(data[1][0].COD_CLIENTE, data[1][0].DSC_CLIENTE, data[1][0].NRO_CPF, data[1][0].NRO_CNPJ, data[1][0].NRO_TELEFONE_CONTATO,
                              data[1][0].NRO_TELEFONE_CELULAR, data[1][0].TXT_LOGRADOURO, '', '0', '0');
            $('#jqxTabsVendas').jqxTabs({ disabled:false });
        }else{
            console.log(data[1]);
        }
    });    
} 

function MontaDadosCliente(codCliente, nmeCliente, cpf, cnpj, telefone, celular, endereco, dscVeiculo, vlrTotalVenda, vlrTotalDesconto){    
    dadosCliente = "<strong>Dados do Cliente</strong> <input type='button' value='Orcamentos deste Cliente' id='btnOrcamentosCliente' onClick='javascript:MostraOrcamentosCliente("+codCliente+");'><br>"+
                   "Nome: "+nmeCliente+"<br>"+
                   "CPF: "+cpf+"<br>"+
                   "CNPJ: "+cnpj+"<br>"+
                   "Telefone: "+telefone+"<br>"+
                   "Celular: "+celular+"<br>"+
                   "Endereço: "+endereco;
    var div = '';
    if ($('#jqxTabsOrcamentos').jqxTabs('selectedItem')==0){
        div = 'dadosCliente'
    }else if ($('#jqxTabsOrcamentos').jqxTabs('selectedItem')==1){
        div = 'dadosClienteProduto';
        dadosCliente += '<br>Veículo: '+dscVeiculo;     
    }           
    $("#"+div).hide();    
    $("#"+div).html(dadosCliente);      
    $("#"+div).show('slow');
    $("input[type='button']").jqxButton({theme: theme}); 
}

function CarregaDadosVenda(){
    $.post('../../Controller/Orcamentos/OrcamentosController.php',
    {method:'CarregaDadosVenda',
     codVenda: $("#codVenda").val()}, function(data){
        data = eval('('+data+')');
        if (data[0]){
            $("#nroStatusVenda").val(data[1][0].NRO_STATUS_VENDA);
            $("#codVenda").val(data[1][0].COD_VENDA);
            $("#codClienteVenda").val(data[1][0].COD_CLIENTE);
            $("#dscClienteAuto").val(data[1][0].DSC_CLIENTE);
            datas = data[1][0].DTA_VENDA.split('/');
            $("#dtaVenda").val(new Date(datas[2]+', '+datas[1]+' ,'+datas[0]));
            $("#codVendedor").val(data[1][0].COD_USUARIO);
            $("#dscVeiculoAuto").val(data[1][0].DSC_VEICULO);
            $("#codVeiculoAuto").val(data[1][0].COD_VEICULO);
            $("#nroPlaca").val(data[1][0].NRO_PLACA);
            $("#txtObservacao").val(data[1][0].TXT_OBSERVACAO);   
            MontaDadosCliente(data[1][0].COD_CLIENTE, data[1][0].DSC_CLIENTE, data[1][0].NRO_CPF, data[1][0].NRO_CNPJ, data[1][0].NRO_TELEFONE_CONTATO,
                              data[1][0].NRO_TELEFONE_CELULAR, data[1][0].TXT_LOGRADOURO, data[1][0].DSC_VEICULO, data[1][0].VLR_VENDA, data[1][0].VLR_DESCONTO);
            $('#jqxTabsOrcamentos').jqxTabs({ disabled:false });
        }
    });
    $("#method").val('UpdateVenda');
}

function CarregaDadosProdutosVenda(){
    $("#tdListaProdutosVendidos").html('');
    $("#tdListaProdutosVendidos").html('<div id="listaGridProdutosVendidos"></div>');   
    $.post('../../Controller/Orcamentos/ProdutosOrcamentosController.php',
    {method:'ListarDadosProdutosVenda',
     codVenda: $("#codVenda").val()}, function(data){
        data = eval('('+data+')');
        if (data[0]){  
            CarregaDadosVenda();
            MontaTabelaProdutos(data[1]);
            totalValor = 0;
            if (data[1]!=null){
                for (i=0;i<data[1].length;i++){            
                    totalValor = parseFloat(totalValor)+parseFloat(data[1][i].VLR_SOMA_LABEL);
                }        
                totalValor = Formata(totalValor,2,'.',',');
            }
            $("#lblVlrTotalProdutosVendidos").html(totalValor);             
        }
    });    
}

function MontaTabelaProdutos(ListaProdutos){
    var nomeGrid = 'listaGridProdutosVendidos';
    var source =
    {
        localdata: ListaProdutos,
        datatype: "json",
        datafields:
        [
            { name: 'COD_PRODUTO', type: 'number' },
            { name: 'DSC_PRODUTO', type: 'string' },
            { name: 'DSC_MARCA', type: 'string' },
            { name: 'NME_FUNCIONARIO', type: 'string' },
            { name: 'VLR_VENDA', type: 'string' },
            { name: 'QTD_VENDIDA', type: 'string' },
            { name: 'VLR_DESCONTO', type: 'string' },
            { name: 'NRO_SEQUENCIAL', type: 'string' },
            { name: 'COD_VENDA', type: 'string' },
            { name: 'QTD_ESTOQUE', type: 'string' },
            { name: 'IND_ESTOQUE', type: 'string' },
            { name: 'VLR_SOMA', type: 'string' }
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
          { text: 'Marca', dataField: 'DSC_MARCA', columntype: 'textbox', width: 180 },
          { text: 'Funcionário', dataField: 'NME_FUNCIONARIO', columntype: 'textbox', width: 180 },
          { text: 'Valor', dataField: 'VLR_VENDA', columntype: 'textbox', width: 180 },
          { text: 'Qtd.', dataField: 'QTD_VENDIDA', columntype: 'textbox', width: 100 },
          { text: 'Desconto', dataField: 'VLR_DESCONTO', columntype: 'textbox', width: 100 },
          { text: 'Total', dataField: 'VLR_SOMA', columntype: 'textbox', width: 100 }
          
        ]
    });
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        $("#codVenda").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_VENDA);
        RemoveProdutoVenda($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_PRODUTO,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_SEQUENCIAL,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).IND_ESTOQUE,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).QTD_VENDIDA);        
        
    });      
}

function RemoveProdutoVenda(codProduto, nroSequencial, indEstoque, qtdVenda){
    $.post('../../Controller/Orcamentos/ProdutosOrcamentosController.php',{
        method:'DeletarProdutoVenda',
        codVenda: $("#codVenda").val(),
        codProdutoVenda: codProduto,
        nroSequencialVenda: nroSequencial,
        qtdVenda: qtdVenda,
        indEstoqueVenda: indEstoque
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
            CarregaDadosProdutosVenda();
        }
    }); 
}

function CarregaListaOrcamentosAbertas(){
    $("#tdListaOrcamentosAbertas").html('');
    $("#tdListaOrcamentosAbertas").html('<div id="ListaOrcamentosAbertas"></div>');
    $("#OrcamentosAbertasForm" ).jqxWindow("open");     
    $.post('../../Controller/Orcamentos/OrcamentosController.php',{
        method:'ListarOrcamentosAberto',
        nroStatusVenda: "A"
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
            MontaTabelaOrcamentosAbertas(data[1]);
        }
    }); 
     
}
function MontaTabelaOrcamentosAbertas(ListaOrcamentosAbertas){
    var nomeGrid = 'ListaOrcamentosAbertas';
    var source =
    {
        localdata: ListaOrcamentosAbertas,
        datatype: "json",
        datafields:
        [
            { name: 'COD_VENDA', type: 'number' },
            { name: 'DSC_CLIENTE', type: 'string' },
            { name: 'MES_ANO', type: 'string' },
            { name: 'NME_VENDEDOR', type: 'string' },
            { name: 'DTA_VENDA', type: 'string' },
            { name: 'VLR_VENDA', type: 'string' },
            { name: 'NRO_CPF', type: 'string' },
            { name: 'NRO_CNPJ', type: 'string' },
            { name: 'DSC_VEICULO', type: 'string' }
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
        groupable: true,
        columns: [
          { text: 'Venda', dataField: 'COD_VENDA', columntype: 'textbox', width: 80 },
          { text: '', dataField: 'MES_ANO', columntype: 'textbox', width: 80 },
          { text: 'Cliente', dataField: 'DSC_CLIENTE', columntype: 'textbox', width: 180 },
          { text: 'Vendedor', dataField: 'NME_VENDEDOR', columntype: 'textbox', width: 180 },
          { text: 'Data', dataField: 'DTA_VENDA', columntype: 'textbox', width: 100 },
          { text: 'Valor', dataField: 'VLR_VENDA', columntype: 'textbox', width: 100 },
          { text: 'CPF', dataField: 'NRO_CPF', columntype: 'textbox', width: 100 },
          { text: 'CNPJ', dataField: 'NRO_CNPJ', columntype: 'textbox', width: 100 },
          { text: 'Veiculo', dataField: 'DSC_VEICULO', columntype: 'textbox', width: 150 }
          
        ],
        groups: ['MES_ANO']
    });
    $('#'+nomeGrid).jqxGrid('hidecolumn', 'MES_ANO');
    $(".jqx-grid-group-column").hide();  
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        $("#codVenda").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_VENDA);
        CarregaDadosVenda();
        $("#OrcamentosAbertasForm" ).jqxWindow("close");
        
    });    
}

function CarregaCabecalhoOrcamento(){
    $.post('../../Controller/Orcamentos/OrcamentosController.php',{
        method:'CarregaDadosVenda',
        codVenda: $("#codVenda").val()
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){  
            MontaCabecalhoOrcamento(data[1]);
            totalValor = 0;
            if (data[1]!=null){
                for (i=0;i<data[1].length;i++){            
                    totalValor = parseFloat(totalValor)+parseFloat(data[1][i].VLR_SOMA_LABEL);
                }        
                totalValor = Formata(totalValor,2,'.',',');
            }
            $("#lblVlrTotalProdutos").html(totalValor);             
        }
    });    
}

function MontaCabecalhoOrcamento(Dados){
    dadosCliente = "<strong>Dados do Cliente</strong><br>"+
                   "Nome: "+Dados[0].NME_CLIENTE+"<br>"+
                   "CPF: "+Dados[0].NRO_CPF+"<br>"+
                   "CNPJ: "+Dados[0].NRO_CNPJ+"<br>"+
                   "Telefone: "+Dados[0].NRO_TELEFONE_CONTATO+"<br>"+
                   "Celular: "+Dados[0].NRO_TELEFONE_CELULAR+"<br>"+
                   "Vendedor: "+Dados[0].NME_VENDEDOR+"<br>"+
                   "Valor: "+Dados[0].VLR_VENDA+"<br>"+
                   "Veículo: "+Dados[0].DSC_VEICULO;
    var div = 'tdDadosOrcamento';           
    $("#"+div).hide();    
    $("#"+div).html(dadosCliente);      
    $("#"+div).show('slow');    
}

function CarregaProdutosOrcamento(){
    $.post('../../Controller/Orcamentos/ProdutosOrcamentosController.php',{
        method:'ListarDadosProdutosVenda',
        codVenda: $("#codVenda").val()
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){  
            MontaProdutosOrcamento(data[1]);
            totalValor = 0;
            if (data[1]!=null){
                for (i=0;i<data[1].length;i++){            
                    totalValor = parseFloat(totalValor)+parseFloat(data[1][i].VLR_SOMA_LABEL);
                }        
                totalValor = Formata(totalValor,2,'.',',');
            }
            $("#lblVlrTotalProdutos").html(totalValor);             
        }
    });  
}

function MontaProdutosOrcamento(data){
    var dadosProdutos = "<table>";
    dadosProdutos += "<tr>";
    dadosProdutos += "<td>Nome</td>";
    dadosProdutos += "<td>Qtd.</td>";
    dadosProdutos += "<td>Desconto</td>";
    dadosProdutos += "<td>Valor</td>";
    dadosProdutos += "<td>Total</td>";
    dadosProdutos += "</tr>";
    for (i=0; i<dadosProdutos.length;i++){
        dadosProdutos += "<tr>";
        dadosProdutos += "<td>"+data[i].DSC_PRODUTO+"</td>";
        dadosProdutos += "<td>"+data[i].QTD_VENDIDA+"</td>";
        dadosProdutos += "<td>"+data[i].VLR_DESCONTO+"</td>";
        dadosProdutos += "<td>"+data[i].VLR_VENDA+"</td>";
        dadosProdutos += "<td>"+data[i].VLR_SOMA+"</td>";
        dadosProdutos += "</tr>";
    }
    dadosProdutos += "</table>";
    
    var div = 'ListaProdutosOrcamento';           
    $("#"+div).hide();    
    $("#"+div).html(dadosProdutos);      
    $("#"+div).show('slow');     
}

function CarregaDadosProdutosOrcamento(){
    $("#tdListaProdutosVendidos").html('');
    $("#tdListaProdutosVendidos").html('<div id="listaGridProdutosVendidos"></div>');   
    $.post('../../Controller/Orcamentos/ProdutosOrcamentosController.php',
    {method:'ListarDadosProdutosVenda',
     codVenda: $("#codVenda").val()}, function(data){
        data = eval('('+data+')');
        if (data[0]){  
            CarregaDadosVenda();
            MontaTabelaProdutos(data[1]);
            totalValor = 0;
            if (data[1]!=null){
                for (i=0;i<data[1].length;i++){            
                    totalValor = parseFloat(totalValor)+parseFloat(data[1][i].VLR_SOMA_LABEL);
                }        
                totalValor = Formata(totalValor,2,'.',',');
            }
            $("#lblVlrTotalProdutos").html(totalValor);             
        }
    });    
}

function MontaDadosProdutosOrcamento(ListaProdutos){
    var nomeGrid = 'listaGridProdutosVendidos';
    var source =
    {
        localdata: ListaProdutos,
        datatype: "json",
        datafields:
        [
            { name: 'COD_PRODUTO', type: 'number' },
            { name: 'DSC_PRODUTO', type: 'string' },
            { name: 'NME_FUNCIONARIO', type: 'string' },
            { name: 'VLR_VENDA', type: 'string' },
            { name: 'QTD_VENDIDA', type: 'string' },
            { name: 'VLR_DESCONTO', type: 'string' },
            { name: 'NRO_SEQUENCIAL', type: 'string' },
            { name: 'COD_VENDA', type: 'string' },
            { name: 'QTD_ESTOQUE', type: 'string' },
            { name: 'IND_ESTOQUE', type: 'string' },
            { name: 'VLR_SOMA', type: 'string' }
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
          { text: 'Funcionário', dataField: 'NME_FUNCIONARIO', columntype: 'textbox', width: 180 },
          { text: 'Valor', dataField: 'VLR_VENDA', columntype: 'textbox', width: 180 },
          { text: 'Qtd.', dataField: 'QTD_VENDIDA', columntype: 'textbox', width: 100 },
          { text: 'Desconto', dataField: 'VLR_DESCONTO', columntype: 'textbox', width: 100 },
          { text: 'Total', dataField: 'VLR_SOMA', columntype: 'textbox', width: 100 }
          
        ]
    });
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        $("#codVenda").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_VENDA);
        RemoveProdutoVenda($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_PRODUTO,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_SEQUENCIAL,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).IND_ESTOQUE,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).QTD_VENDIDA);        
        
    });      
}

function SalvarProduto(){
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
            $("#codProdutoVenda").val(data[2][0].COD_PRODUTO);
            $("#dscProdutoVenda").val($("#dscProduto").val());
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

function MontaComboTipoPessoa(nmeCombo, nmeSelect, seleciona){
    $("#"+nmeCombo).jqxDropDownList({ width: '157px', height: '25px'});
    $("#"+nmeCombo).jqxDropDownList('loadFromSelect', nmeSelect);  
    $("#"+nmeSelect).val(seleciona);
    var index = $("#"+nmeSelect)[0].selectedIndex;
    $("#"+nmeCombo).jqxDropDownList('selectIndex', index);
    $("#"+nmeCombo).jqxDropDownList('ensureVisible', index);    
    
    $("#"+nmeCombo).on('select', function (event) {
        var args = event.args;
        // select the item in the 'select' tag.
        var index = args.item.index;
        $("#"+nmeSelect).val(args.item.value);
        if ($("#"+nmeSelect).val()=='F'){
            $(".trCPF").html("CPF");
            mostraDivById('nroCpf');
            escondeDivById('nroCnpj');
        }else if ($("#"+nmeSelect).val()=='J'){
            $(".trCPF").html("CNPJ");
            mostraDivById('nroCnpj');
            escondeDivById('nroCpf');
        }else{
            $(".trCPF").html("");
            escondeDivById('nroCnpj');
            escondeDivById('nroCpf');            
        }
        
    });  
    $("#"+nmeSelect).on('change', function (event) {
        updating = true;
        $("#"+nmeSelect).val(seleciona);

        var index = $("#"+nmeSelect)[0].selectedIndex;
        $("#"+nmeCombo).jqxDropDownList('selectIndex', index);
        $("#"+nmeCombo).jqxDropDownList('ensureVisible', index);
        updating = false;
    });    
}

function mostraDivById(nmeDiv){
    $("#"+nmeDiv).show();
}

function escondeDivById(nmeDiv){
    $("#"+nmeDiv).hide();
}