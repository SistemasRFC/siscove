function CarregaListaCaixasFechados(){
    $("#listaCaixaFechados").html('');
    $("#listaCaixaFechados").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/CaixaVendedor/CaixaVendedorController.php',{
        method: 'ListarCaixaVendedor'
    },function(data){

        data = eval('('+data+')');
        if (data[0]){
            if (data[1]!=null){
                MontaTabelaCaixasFechados(data[1]);
                $("#ListaCaixasFechadosForm").jqxWindow('open');
                $( "#dialogInformacao" ).jqxWindow("close");      
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Sem caixas para fechamento!"); 
                setTimeout(function(){
                    $( "#dialogInformacao" ).jqxWindow("close");
                },2000);
            }            

        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
        }
    });
}

function MontaTabelaCaixasFechados(listaTipoPagamentos){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaTipoPagamentos,
        datatype: "json",
        datafields:
        [
            { name: 'COD_CAIXA_VENDEDOR', type: 'int' },
            { name: 'DTA_CAIXA', type: 'string' },
            { name: 'COD_USUARIO', type: 'string' },
            { name: 'VLR_PAGAMENTO', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 400,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: true,
        pageable: false,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
            { text: 'Data do Caixa', datafield: 'DTA_CAIXA', columntype: 'textbox', width: 180},
            { text: 'Valor do Caixa', datafield: 'VLR_PAGAMENTO', columntype: 'textbox', width: 180}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CarregaCaixaVendedor($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_CAIXA_VENDEDOR);
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}

function CarregaCaixaVendedor(codCaixaVendedor){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/CaixaVendedor/CaixaVendedorController.php',{
        method: 'ListarCaixaPorCodigoVendedor',
        codCaixaVendedor: codCaixaVendedor
    },function(data){
        data = eval('('+data+')');
        if (data[0]){
            if (data[1]!=null){
                var pagamentosVendedor = data[1];
                var pagamentosTipo = data[2];            
                MontaTabelaPagamentosVendedor(pagamentosVendedor, pagamentosTipo); 
                $(".FechamentoCaixa").hide();
                impressao = impressao.replace("#data#", pagamentosVendedor[0].DTA_CAIXA);          
                PreparaImpresao();
                $(".FechamentoCaixa").hide();  
                $( "#dialogInformacao" ).jqxWindow("close");
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Sem registros para fechamento do caixa");
                $(".FechamentoCaixa").hide();
                setTimeout(function(){
                    $( "#dialogInformacao" ).jqxWindow("close");        
                },3000);
            }
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
        }
    });    
}