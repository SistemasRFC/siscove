var DadosCliente;
var dscVeiculo;
var vlrTotalVenda;
var vlrTotalDesconto;

function VerificaValoresAbaixoMinimo(){
    $.post('../../Controller/Vendas/FormaPagamentoVendasController.php',
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
            $("#codPerfil").val(data[1][0].COD_PERFIL_W);
            if ($("#codPerfil").val()!='3' ){
                $("#btnFecharVenda").show();
                $("#btnCancelaVenda").show();
            }else{
                $("#btnFecharVenda").hide();
                $("#btnCancelaVenda").hide();
            }  
            if ($("#codPerfil").val()==2 || $("#codPerfil").val()==1){
                $("#btnHistoricoVenda").show();
            }else{
                $("#btnHistoricoVenda").hide();
            }
        }
    });
}

function VerificaVendasUsuarioLogado(){
    $.post('../../Controller/Vendas/VendasController.php',
        {method: 'VerificaVendasAberto'}, function(data){

        data = eval('('+data+')');

        if (data){
            
            $( "#AvisoVendasAbertas" ).jqxWindow("open"); 
            $(".jqx-window-header").hide();
            var i=5;
            setInterval(function(){
                if (i==0){
                    $(".jqx-window-header").show();
                    $( "#AvisoVendasAbertas" ).jqxWindow("close");
                }
                $( "#AvisoVendasAbertas" ).jqxWindow('setContent', "<div align='center' style='vertical-align: middle; display: table-cell; height: 220'>Existem vendas em aberto cadastradas com seu usuário, favor resolver pendências<br>Esta janela fechará em "+i+" segundos</div>");
                i--;
            },"1000");
        }
    });
}

function MostraVendasCliente(codCliente){
    $("#tdListaVendasCliente").html('');
    $("#tdListaVendasCliente").html('<div id="ListaVendasCliente"></div>');
    $("#ListaVendasCliente" ).html('setContent', "Aguarde!");
    $("#VendasClienteForm" ).jqxWindow("open"); 
    $.post('../../Controller/Vendas/VendasController.php',
    {method:'ListarVendasCliente',
     codClienteVenda: codCliente,
     tpoVendas: ''}, function(data){
        data = eval('('+data+')');
        if (data[0]){
            MontaTabelaVendas(data[1]);
        }
    });
}

function MontaTabelaVendas(Lista){    
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
    $("#ListaVendasCliente").jqxGrid(
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
    $('#ListaVendasCliente').jqxGrid('hidecolumn', 'MES_ANO');
    $(".jqx-grid-group-column").hide();
}

function CarregaDadosVenda(){
    $.post('../../Controller/Vendas/VendasController.php',
    {method:'CarregaDadosVenda',
     codVenda: $("#codVenda").val()}, function(data){
        data = eval('('+data+')');
        if (data[0]){
            $("#nroStatusVenda").val(data[1][0].NRO_STATUS_VENDA);
            $("#codVenda").val(data[1][0].COD_VENDA);
            $("#codClienteVenda").val(data[1][0].COD_CLIENTE);
            $("#dscClienteAuto").val(data[1][0].DSC_CLIENTE);
            $("#nroCpfPesquisaAuto").val(data[1][0].NRO_CPF);
            datas = data[1][0].DTA_VENDA.split('/');
            $("#dtaVenda").val(new Date(datas[2]+', '+datas[1]+' ,'+datas[0]));
            $("#codVendedor").val(data[1][0].COD_USUARIO);
            $("#dscVeiculoAuto").val(data[1][0].DSC_VEICULO);
            $("#codVeiculoAuto").val(data[1][0].COD_VEICULO);
            $("#nroPlaca").val(data[1][0].NRO_PLACA);
            $("#txtObservacao").val(data[1][0].TXT_OBSERVACAO);   
            $(".codigo").text($("#codVenda").val());
            $(".status").text(data[1][0].DSC_STATUS_VENDA);
            $("#vlrKmRodado").val(data[1][0].VLR_KM_RODADO); 
            dscVeiculo = data[1][0].DSC_VEICULO;
            vlrTotalVenda = data[1][0].VLR_TOTAL_VENDA;
            vlrTotalDesconto = data[1][0].VLR_TOTAL_DESCONTO;
//            MontaDadosCliente(data[1][0].COD_CLIENTE, data[1][0].DSC_CLIENTE, data[1][0].NRO_CPF, data[1][0].NRO_CNPJ, data[1][0].NRO_TELEFONE_CONTATO,
//                              data[1][0].NRO_TELEFONE_CELULAR, data[1][0].TXT_LOGRADOURO, data[1][0].DSC_VEICULO, data[1][0].VLR_TOTAL_VENDA, data[1][0].VLR_TOTAL_DESCONTO);
            CarregaDadosCliente();
            $('#jqxTabsVendas').jqxTabs({ disabled:false });
            //$('#jqxTabsVendas').jqxTabs('select', 0); 
            HabilitaBotoesNFE(data[1][0].IND_STATUS_REFERENCIA);
        } 
    });
    $("#method").val('UpdateVenda');
}

function HabilitaBotoesNFE(indStatusReferencia){
    if ($("#nroStatusVenda").val()=='F'){
        $(".TabelaMae").addClass("disabledTable");
        if (indStatusReferencia=='A'){
            $("#btnNota").show();
            $("#btnCancelarNota").show();
            $("#btnReabrirVenda").show();
            $("#btnEnviarEmail").show();
        }
    }else{
        $("#btnNota").hide();
        $("#btnCancelarNota").hide();
        $("#btnReabrirVenda").hide();
        $("#btnEnviarEmail").hide();                
        $(".TabelaMae").removeClass("disabledTable");
    }    
}
function CarregaDadosCliente(){
    $.post('../../Controller/Cliente/ClienteController.php',
    {method:'CarregaDadosCliente',
     codCliente: $("#codClienteVenda").val()}, function(data){
        data = eval('('+data+')');
        if (data[0]){   
            DadosCliente = data[1][0];
            MontaDadosCliente(data[1][0].COD_CLIENTE, data[1][0].DSC_CLIENTE, data[1][0].NRO_CPF, data[1][0].NRO_CNPJ, data[1][0].NRO_TELEFONE_CONTATO,
                              data[1][0].NRO_TELEFONE_CELULAR, data[1][0].TXT_LOGRADOURO);
        }else{
            console.log(data[1]);
        }
    });
}

function MontaDadosCliente(codCliente, nmeCliente, cpf, cnpj, telefone, celular, endereco){
    dadosCliente = "<strong>Dados do Cliente</strong> <input type='button' value='Alterar Cliente' id='btnAlterarCliente' onClick='javascript:AlterarCliente();'><br>"+
                   "Nome: "+nmeCliente+"<br>"+
                   "CPF: "+cpf+"<br>"+
                   "CNPJ: "+cnpj+"<br>"+
                   "Telefone: "+telefone+"<br>"+
                   "Celular: "+celular+"<br>"+
                   "Endereço: "+endereco;
    var div = '';
    
    if ($('#jqxTabsVendas').jqxTabs('selectedItem')==0){
        div = 'dadosCliente'
    }else if ($('#jqxTabsVendas').jqxTabs('selectedItem')==1){
        div = 'dadosClienteProduto';
        dadosCliente += '<br>Veículo: '+dscVeiculo;     
    }else if ($('#jqxTabsVendas').jqxTabs('selectedItem')==2){
        div = 'dadosClientePagamento';
        dadosCliente += '<br>Veículo: '+dscVeiculo;
        dadosCliente += '<br>Valor total da venda: <label id="vlrTotalVenda">'+vlrTotalVenda+'</label>';
        dadosCliente += '<br>Valor dos descontos: '+vlrTotalDesconto;
    }    
    $("#"+div).hide();    
    $("#"+div).html(dadosCliente);      
    $("#"+div).show('slow');
    $("input[type='button']").jqxButton({theme: theme});
}

function AlterarCliente(){
    var registro = DadosCliente;
    console.log(registro);
    $("#codCliente").val(registro.COD_CLIENTE);
    $("#dscCliente").val(registro.DSC_CLIENTE);  
    $("#fone").val(registro.NRO_TELEFONE_CONTATO);
    $("#foneCelular").val(registro.NRO_TELEFONE_CELULAR); 
    $("#nroCpf").val(registro.NRO_CPF);
    $("#nroCnpj").val(registro.NRO_CNPJ); 
    $("#nroIe").val(registro.NRO_IE); 
    MostraEscondeCnpj(registro);
    if (registro.DTA_NASCIMENTO!=null){
        datas = registro.DTA_NASCIMENTO.split('/');
        $("#dtaNascimento").val(new Date(datas[2]+', '+datas[1]+' ,'+datas[0]));        
    }else{
        $("#dtaNascimento").val("");        
    }
    $("#txtEmail").val(registro.TXT_EMAIL);
    $("#nroCep").val(registro.NRO_CEP);
    $("#txtLogradouro").val(registro.TXT_LOGRADOURO);
    $("#txtComplemento").val(registro.TXT_COMPLEMENTO);
    $("#nmeBairro").val(registro.NME_BAIRRO);
    $("#nmeCidade").val(registro.TXT_LOCALIDADE);
    $("#sglUf").val(registro.SGL_UF);
    $("#txtUnidade").val(registro.TXT_UNIDADE);
    $("#codIbge").val(registro.COD_IBGE);
    $("#codGia").val(registro.COD_GIA);     
    $("#NovoClienteForm").jqxWindow("open");
}

function MostraEscondeCnpj(registro){
    if (registro.IND_TIPO_CLIENTE=='F'){
        $("#comboCodTipoPessoa").val(registro.IND_TIPO_CLIENTE);
        $("#codTipoPessoa").val(registro.IND_TIPO_CLIENTE);
        mostraDivById('nroCpf');
        $(".trCNPJ").hide();
        escondeDivById('nroCnpj');
    }else if (registro.IND_TIPO_CLIENTE=='J'){
        $("#comboCodTipoPessoa").val(registro.IND_TIPO_CLIENTE);
        $("#codTipoPessoa").val(registro.IND_TIPO_CLIENTE);
        mostraDivById('nroCnpj');
        $(".trCNPJ").show();
        escondeDivById('nroCpf');
    }else{
        $("#comboCodTipoPessoa").val("-1");
        $("#codTipoPessoa").val(registro.IND_TIPO_CLIENTE);
        escondeDivById('nroCnpj');
        $(".trCNPJ").hide();
        escondeDivById('nroCpf');            
    }      
}

function CarregaDadosProdutosVenda(){
    $("#tdListaProdutosVendidos").html('');
    $("#tdListaProdutosVendidos").html('<div id="listaGridProdutosVendidos"></div>');   
    $.post('../../Controller/Vendas/ProdutosVendasController.php',
    {method:'ListarDadosProdutosVenda',
     codVenda: $("#codVenda").val()}, function(data){
        data = eval('('+data+')');
        if (data[0]){  
            MontaTabelaProdutos(data[1]);
            totalValor = 0;
            if (data[1]!=null){
                for (i=0;i<data[1].length;i++){            
                    totalValor = parseFloat(totalValor)+parseFloat(data[1][i].VLR_SOMA_LABEL);
                }        
                totalValor = Formata(totalValor,2,'.',',');
            }
            $("#lblVlrTotalProdutosVendidos").html(totalValor);  
            CarregaDadosVenda();
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
            { name: 'TPO_PRODUTO', type: 'string' },
            { name: 'VLR_SOMA', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 1150,
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
          { text: 'Tipo', dataField: 'TPO_PRODUTO', columntype: 'textbox', width: 180 },
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
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).VLR_VENDA,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_SEQUENCIAL,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).IND_ESTOQUE,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).QTD_VENDIDA);        
        
    });      
}

function CarregaListaVendasAbertas(){
    $( "#dialogInformacao" ).jqxWindow('setContent', 'Aguarde!');
    $( "#dialogInformacao" ).jqxWindow("open");  
    $("#tdListaVendasAbertas").html('');
    $("#tdListaVendasAbertas").html('<div id="ListaVendasAbertas"></div>');
    $("#VendasAbertasForm" ).jqxWindow("open");     
    $.post('../../Controller/Vendas/VendasController.php',{
        method:'ListarVendasAberto',
        nroStatusVenda: "A",
        indAno: 'S'
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
            MontaTabelaVendasAbertas(data[1]);
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao listar vendas em aberto! Erro: '+data[1]);
        }
    }); 
     
}

function MontaTabelaVendasAbertas(ListaVendasAbertas){
    var nomeGrid = 'ListaVendasAbertas';
    var source =
    {
        localdata: ListaVendasAbertas,
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
            { name: 'DSC_VEICULO', type: 'string' },
            { name: 'VLR_KM_RODADO', type: 'string' }
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
        $("#VendasAbertasForm" ).jqxWindow("close");
        $('#jqxTabsVendas').jqxTabs('select', 0);
        
    });
    $( "#dialogInformacao" ).jqxWindow("close");  
}

function RemoveProdutoVenda(codProduto, vlrVenda, nroSequencial, indEstoque, qtdVenda){
    $.post('../../Controller/Vendas/ProdutosVendasController.php',{
        method:'DeletarProdutoVenda',
        codVenda: $("#codVenda").val(),
        nroStatusVenda: $("#nroStatusVenda").val(),
        codProdutoVenda: codProduto,
        vlrVenda: vlrVenda,
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

function CarregaTabelaPagamentos(){
    $("#tdListaPagamentosVenda").html('');
    $("#tdListaPagamentosVenda").html('<div id="ListaPagamentosVenda"></div>');       
    $.post('../../Controller/Vendas/FormaPagamentoVendasController.php',
        {method:'ListarPagamentosVendasGrid',
         codVenda: $("#codVenda").val()}, function(dado){
          dado = eval('('+dado+')');

         if (dado[0]){
             MontaTabelaPagamentos(dado[1]);
             $("#lblvlrTotalVenda").html(dado[2].VLR_TOTAL);
             VerificaValoresAbaixoMinimo();
         }
    });
}

function MontaTabelaPagamentos(ListaPagamentos){
    var nomeGrid = 'ListaPagamentosVenda';
    var source =
    {
        localdata: ListaPagamentos,
        datatype: "json",
        datafields:
        [
            { name: 'NRO_SEQUENCIAL', type: 'number' },
            { name: 'DTA_PAGAMENTO', type: 'string' },
            { name: 'VLR_PAGAMENTO', type: 'string' },
            { name: 'NRO_CHEQUE', type: 'string' },
            { name: 'NRO_BANCO', type: 'string' },
            { name: 'NME_PROPRIETARIO', type: 'string' },
            { name: 'NRO_STATUS_VENDA', type: 'string' },
            { name: 'DSC_TIPO_PAGAMENTO', type: 'string' },
            { name: 'COD_TIPO_PAGAMENTO', type: 'string' },
            { name: 'DSC_MERCADORIA', type: 'string' }
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
          { text: 'Tipo', dataField: 'DSC_TIPO_PAGAMENTO', columntype: 'textbox', width: 80 },
          { text: 'Valor', dataField: 'VLR_PAGAMENTO', columntype: 'textbox', width: 180 },
          { text: 'Nro Cheque', dataField: 'NRO_CHEQUE', columntype: 'textbox', width: 180 },
          { text: 'Banco', dataField: 'NRO_BANCO', columntype: 'textbox', width: 180 },
          { text: 'Proprietário', dataField: 'NME_PROPRIETARIO', columntype: 'textbox', width: 180 }
          
        ]
    });
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        $("#codVenda").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_VENDA);
        RemoveProdutoPagamento($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_SEQUENCIAL,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).IND_ESTOQUE,
                           $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).QTD_VENDIDA);        
        
    });      
}

function RemoveProdutoPagamento(nroSequencial){
    $( "#dialogInformacao" ).jqxWindow('setContent', 'Aguarde!');
    $( "#dialogInformacao" ).jqxWindow("open");     
    $.post('../../Controller/Vendas/FormaPagamentoVendasController.php',{
        method:'DeletarPagamentoVenda',
        nroSequencialVenda: nroSequencial
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Pagamento Removido com Sucesso!');
            CarregaTabelaPagamentos();
            setTimeout(function(){
                $( "#dialogInformacao" ).jqxWindow("close"); 
            },2000)
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao remover pagamento!<br>'+data[1]);
            $( "#dialogInformacao" ).jqxWindow("open");                    
        }
    });     
}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function FecharVenda(indEmiteNota){
    if (indEmiteNota=='S'){
        $( "#dialogInformacao" ).jqxWindow('setContent','Aguarde, fechando a venda e aguardando autorização da Receita Federal!');
        AutorizarNota();
    }else{
        if(indEmiteNota=='A'){
            FechaVenda();
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent','Não foi possível fechar essa venda!');
        }
        $( "#dialogInformacao" ).jqxWindow('setContent','Aguarde, fechando a venda!');
        FechaVenda();
    }
    $( "#dialogInformacao" ).jqxWindow( "open" );
}

function AutorizarNota(){
    $.post('../../Controller/Nfe/NfeController.php',
    {
        method:'AutorizarNota',
        codVenda: $("#codVenda").val()
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
//            var retorno=true;
//            while(retorno){
//                sleep('4000');
//                retorno = ConsultarNota('F');
//                sleep('2000');
//                console.log(retorno);
//            }            
            FechaVenda();
        }else{
            if (data[2]!=undefined){
                var  mensagens="";
                for (i=0;i<data[2].length;i++){
                    mensagens += data[2][i];
                }
                $( "#dialogInformacao" ).jqxWindow('setContent','Erro ao fechar venda!'+data[1]+'<br>'+mensagens);
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent','Erro ao fechar venda!'+data[1]);
            }
        }
    });
}

function FechaVenda(){
    $.post('../../Controller/Vendas/FormaPagamentoVendasController.php',
        {method:'FecharVenda',
         codVenda: $("#codVenda").val(),
         txtJustificativa: $("#txtJustificativa").val()}, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Venda Fechada!');
            CarregaDadosVenda();
            $('#jqxTabsVendas').jqxTabs('select', 0);
            setTimeout(function(){
                $( "#dialogInformacao" ).jqxWindow("close");                    
            },"3000");             
        }else{
            var mensagens = "";
            if (data[2]!=undefined){
                for (i=0;i<data[2].length;i++){
                    mensagens += data[2][i];
                }
                $( "#dialogInformacao" ).jqxWindow('setContent','Erro ao fechar venda!'+data[1]+'<br>'+mensagens);
                $( "#dialogInformacao" ).jqxWindow( "open" );
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent','Erro ao fechar venda!'+data[1]);
                $( "#dialogInformacao" ).jqxWindow( "open" );
            }
        }
    });
}

function SalvarVeiculo(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");  
    if ($("#indVeiculoAtivo").jqxCheckBox('val')){
        ativo = 'S';
    }else{
        ativo = 'N';
    }            
    $.post('../../Controller/Veiculo/VeiculoController.php',
        {method: 'AddVeiculo',
        codVeiculo: $("#codVeiculo").val(),
        dscVeiculo: $("#dscVeiculo").val(),
        indVeiculoAtivo: ativo}, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $("#codVeiculoAuto").val($("#codVeiculo").val());
            $("#dscVeiculo").val($("#dscVeiculo").val());
            $("#CadVeiculos").jqxWindow("close");
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Registro salvo com sucesso!');
            window.setTimeout($( "#dialogInformacao" ).jqxWindow( "close" ),2000);
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Registro!');
            $( "#dialogInformacao" ).jqxWindow( "open" );
        }
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
            $('#jqxTabsProdutos').jqxTabs({ disabled:false });
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
            $(".trCNPJ").hide();
            escondeDivById('nroCnpj');
        }else if ($("#"+nmeSelect).val()=='J'){
            $(".trCPF").html("CNPJ");
            mostraDivById('nroCnpj');
            $(".trCNPJ").show();
            escondeDivById('nroCpf');
        }else{
            $(".trCPF").html("");
            escondeDivById('nroCnpj');
            $(".trCNPJ").hide();
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

function mostraDivByClass(nmeDiv){
    $("."+nmeDiv).show();
}

function escondeDivByClass(nmeDiv){
    $("."+nmeDiv).hide();
}

function ReabrirVenda(codVenda){    
    $.post('../../Controller/Vendas/VendasController.php',
          {method:'ReabrirVenda',
           codVenda: codVenda}, function(data){
                data = eval('('+data+')'); 
                if(data[0]){
                    CarregaDadosVenda();
                    $( "#dialogInformacao" ).jqxWindow('setContent', 'Venda reaberta com sucesso!');
                    setTimeout(function(){
                        FecharDialog();
                    }, 2000);                    
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setContent', data[1]);   
                    $( "#dialogInformacao" ).jqxWindow('open');
                }
           }
    );
}

function CancelarNota(codVenda){
    $.post('../../Controller/Nfe/NfeController.php',
        {
            method:'CancelarNota',
            codVenda: codVenda}, function(data){
                data = eval('('+data+')'); 
                if(data[0]){
                    ReabrirVenda(codVenda);
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setContent', data[1]);   
                    $( "#dialogInformacao" ).jqxWindow('open');
                }
           }
    );    
}

function FecharDialog(){
    $( "#dialogInformacao" ).jqxWindow("close"); 
}

function SalvarCliente(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open"); 
    if ($("#codCliente").val()!='0'){
        method = "UpdateCliente";
    }else{
        method = 'AddCliente';
    }
    var cep = $("#nroCep").val();
    cep = cep.replace('.','');
    cep = cep.replace('-','');        
    $.post('../../Controller/Cliente/ClienteController.php',
        {method: method,
        codCliente: $("#codCliente").val(),
        dscCliente: $("#dscCliente").val(),
        fone: $("#fone").val(),
        foneCelular: $("#foneCelular").val(),
        nroCpf: $("#nroCpf").val(),
        nroCnpj: $("#nroCnpj").val(),
        nroIe: $("#nroIe").val(),
        dtaNascimento: $("#dtaNascimento").val(),
        txtEmail: $("#txtEmail").val(),
        codTipoPessoa: $("#codTipoPessoa").val(),
        nroCep: cep,
        txtLogradouro: $("#txtLogradouro").val(),
        txtComplemento: $("#txtComplemento").val(),
        nmeBairro: $("#nmeBairro").val(),
        nmeCidade: $("#nmeCidade").val(),
        sglUf: $("#sglUf").val(),
        codIbge: $("#codIbge").val(),
        codGia: $("#codGia").val(),
        txtUnidade: $("#txtUnidade").val()            
    }, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Cliente salvo com sucesso!');
            if ($("#codCliente").val()=='0'){
                $('#jqxTabsVendas').jqxTabs({ disabled:true });
                $("#method").val('InsertVenda');
                $('#codClienteVenda').val(data[2]);
            }
            $('#dscClienteAuto').val($("#dscCliente").val());
            $("#codVeiculoAuto").val('0');
            $("#dscVeiculoAuto").val('');
            $("#nroPlaca").val('');
            $("#txtObservacao").val('');
            $("#dtaNascimento").val(""); 
            $("#txtEmail").val(""); 
            $("#comboCodTipoPessoa").val("-1");
            $("#codTipoPessoa").val("-1");
            escondeDivById('nroCnpj');
            escondeDivById('nroCpf');
            $("#nroCep").val("");
            $("#txtLogradouro").val("");
            $("#txtComplemento").val("");
            $("#nmeBairro").val("");
            $("#nmeCidade").val("");
            $("#sglUf").val("");
            $("#codIbge").val("")
            $("#codGia").val("");
            $("#txtUnidade").val(""); 
            CarregaDadosCliente();
            window.setTimeout(function() { $( "#dialogInformacao" ).jqxWindow("close"); }, 2000);
            $("#NovoClienteForm").jqxWindow("close");
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao inserir cliente! <BR>'+data[1]);
            window.setTimeout(function() { $( "#dialogInformacao" ).jqxWindow( "close" ); }, 3000);
        }
    });    
}

function ConsultarNota(acao){
    $.post('../../Controller/Nfe/NfeController.php',
        {
            method: 'ConsultarNota',
            codVenda: $("#codVenda").val()
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

function EnviarEmail(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde Enviando email!");
    $( "#dialogInformacao" ).jqxWindow( "open" );
    $.post('../../Controller/Nfe/NfeController.php',
        {
            method: 'EnviarEmail',
            codVenda: $("#codVenda").val()
        }, function(data){
            data = eval('('+data+')');
            if (data[0]){
                $( "#dialogInformacao" ).jqxWindow('setContent', data[1]);
                setTimeout(function(){
                    $( "#dialogInformacao" ).jqxWindow( "close" );
                },2000);
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', data[1]);
            }
                
    }); 
}

function CarregaHistoricoVenda(codVenda){
    $( "#dialogInformacao" ).jqxWindow('setContent', 'Aguarde!');
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Relatorios/RelatorioOperacoesController.php',{
        method:'ListarRegistros',
        codVenda: codVenda
    }, function(data){
        data = eval('('+data+')');
        if(codVenda == 0){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Selecione uma venda!');
        }else{
            if(data[0]== null && data[1]== null && data[2]==null){
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Essa venda não possui histórico!');
            }
            if (data[0]!= null || data[1]!= null || data[2]!=null){
                $("#HistoricoVendaForm" ).jqxWindow("open");
                MontaTabelaLog(data);
            }
        }
        setTimeout(function(){
            $( "#dialogInformacao" ).jqxWindow("close");    
        },3000);
    }); 
     
}

function MontaTabelaLog(data){
    $("#Registros").html('');
    tabela = '<table align="center" width="95%" class="TabelaConteudo" style="border: 1px solid #000000;"';
    var registro;
    corLinha = 'white';
    primeira = true;
    if (data[0]!=null){
    tabela += '<tr>';
        tabela += '<td>';
            tabela += '<table align="center" width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2" style="border: 1px solid #000000;">';
                tabela += '<tr>';
                tabela += '<td colspan="5" align="center" class="TDTituloCabecalho"> Log de Vendas </td>';
                tabela += '</tr>';
                tabela += '<tr>';
                tabela += '     <td width="18%" class="TDTitulo">';
                tabela += '         Número da Operação';
                tabela += '     </td>';
                tabela += '     <td width="17%" class="TDTitulo">';
                tabela += '         Código da Venda';
                tabela += '     </td>';
                tabela += '     <td width="23%" class="TDTitulo">';
                tabela += '         Usuário';
                tabela += '     </td>';
                tabela += '     <td width="22%" class="TDTitulo">';
                tabela += '         Data da Operação';
                tabela += '     </td>';
                tabela += '     <td width="20%" class="TDTitulo">';
                tabela += '         Tipo de Operação';
                tabela += '     </td>';
                tabela += ' </tr>';
                registro = data[0];
                for(var i=0;i<registro.length;i++){
                    if ( corLinha === "white" ){
                        corLinha="E8E8E8";
                    }else{
                        corLinha="white";
                    }
                tabela += ' <tr bgcolor="'+corLinha+'" class="trcor">';
                tabela += '    <td>'+registro[i].COD_OPERACAO+'</td>';
                tabela += '    <td>'+registro[i].COD_VENDA+'</td>';
                tabela += '    <td>'+registro[i].COD_USUARIO+'</td>';
                tabela += '    <td>'+registro[i].DTA_OPERACAO+'</td>';
                tabela += '    <td align="right">'+registro[i].TPO_OPERACAO+'</td>';
                tabela += ' </tr>';
                }
            tabela += '  </table>';
        tabela += '</td>';
    tabela += '</tr>';
    }
    if (data[1]!=null){
    tabela += '<tr>';
        tabela += '<td>';
            tabela += '<table align="center" width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2" style="border: 1px solid #000000;">';
            tabela += '<tr>';
            tabela += '<td colspan="8" align="center" class="TDTituloCabecalho"> Log de Produtos </td>';
            tabela += '</tr>';
            tabela += '<tr>';
            tabela += '     <td width="9%" class="TDTitulo">';
            tabela += '         Número da Operação';
            tabela += '     </td>';
            tabela += '     <td width="10%" class="TDTitulo">';
            tabela += '         Cod. Venda';
            tabela += '     </td>';
            tabela += '     <td width="17%" class="TDTitulo">';
            tabela += '         Produto';
            tabela += '     </td>';
            tabela += '     <td width="11%" class="TDTitulo">';
            tabela += '         Qtd. Produto';
            tabela += '     </td>';
            tabela += '     <td width="9%" class="TDTitulo">';
            tabela += '         Valor';
            tabela += '     </td>';
            tabela += '     <td width="15%" class="TDTitulo">';
            tabela += '         Usuário';
            tabela += '     </td>';
            tabela += '     <td width="15%" class="TDTitulo">';
            tabela += '         Data da Operação';
            tabela += '     </td>';
            tabela += '     <td width="14%" class="TDTitulo">';
            tabela += '         Tipo de Operação';
            tabela += '     </td>';
            tabela += ' </tr>';
            registro = data[1];
            for(var i=0;i<registro.length;i++){
                if ( corLinha === "white" ){
                    corLinha="E8E8E8";
                }else{
                    corLinha="white";
                }
            tabela += ' <tr bgcolor="'+corLinha+'" class="trcor">';
            tabela += '    <td>'+registro[i].COD_OPERACAO+'</td>';
            tabela += '    <td>'+registro[i].COD_VENDA+'</td>';
            tabela += '    <td>'+registro[i].DSC_PRODUTO+'</td>';
            tabela += '    <td>'+registro[i].QTD_PRODUTO+'</td>';
            tabela += '    <td>R$ '+registro[i].VLR_PRODUTO+'</td>';
            tabela += '    <td>'+registro[i].COD_USUARIO+'</td>';
            tabela += '    <td>'+registro[i].DTA_OPERACAO+'</td>';
            tabela += '    <td align="right">'+registro[i].TPO_OPERACAO+'</td>';
            tabela += ' </tr>';
            }
            tabela += '  </table>';
        tabela += '</td>';    
    tabela += '</tr>';
    }
    if (data[2]!=null){
    tabela += '<tr>';
        tabela += '<td>';
            tabela += '<table align="center" width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2" style="border: 1px solid #000000;">';
            tabela += '<tr>';
            tabela += '<td colspan="8" align="center" class="TDTituloCabecalho"> Log de Pagamentos </td>';
            tabela += '</tr>';
            tabela += '<tr>';
            tabela += '     <td width="10%" class="TDTitulo">';
            tabela += '         Número da Operação';
            tabela += '     </td>';
            tabela += '     <td width="10%" class="TDTitulo">';
            tabela += '         Cod. Venda';
            tabela += '     </td>';
            tabela += '     <td width="14%" class="TDTitulo">';
            tabela += '         Cod. Pagamento';
            tabela += '     </td>';
            tabela += '     <td width="12%" class="TDTitulo">';
            tabela += '         Forma de Pagamento';
            tabela += '     </td>';
            tabela += '     <td width="9%" class="TDTitulo">';
            tabela += '         Valor';
            tabela += '     </td>';
            tabela += '     <td width="16%" class="TDTitulo">';
            tabela += '         Usuário';
            tabela += '     </td>';
            tabela += '     <td width="15%" class="TDTitulo">';
            tabela += '         Data da Operação';
            tabela += '     </td>';
            tabela += '     <td width="15%" class="TDTitulo">';
            tabela += '         Tipo de Operação';
            tabela += '     </td>';
            tabela += ' </tr>';
            registro = data[2];
            for(var i=0;i<registro.length;i++){
                if ( corLinha === "white" ){
                    corLinha="E8E8E8";
                }else{
                    corLinha="white";
                }
            tabela += ' <tr bgcolor="'+corLinha+'" class="trcor">';
            tabela += '    <td>'+registro[i].COD_OPERACAO+'</td>';
            tabela += '    <td>'+registro[i].COD_VENDA+'</td>';
            tabela += '    <td>'+registro[i].COD_PAGAMENTO+'</td>';
            tabela += '    <td>'+registro[i].DSC_TIPO_PAGAMENTO+'</td>';
            tabela += '    <td>R$ '+registro[i].VLR_PAGAMENTO+'</td>';
            tabela += '    <td>'+registro[i].COD_USUARIO+'</td>';
            tabela += '    <td>'+registro[i].DTA_OPERACAO+'</td>';
            tabela += '    <td align="right">'+registro[i].TPO_OPERACAO+'</td>';
            tabela += ' </tr>';
            }
            tabela += '  </table>';
        tabela += '</td>';
    tabela += '</tr>';
    }
    $("#Registros").html(tabela);
}



function CarregaHistoricoVenda(){
    $.post('../../Controller/EntradaEstoque/EntradaEstoqueController.php',{
        method:'CartaCorrecao',
        nroSequencial: $("#nroSequencial").val()
    }, function(data){
        data = eval('('+data+')');
    }); 
     
}