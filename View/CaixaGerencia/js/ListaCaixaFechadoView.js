function CarregaListaCaixasFechadosGerencia(){
    $("#listaCaixaFechados").html('');
    $("#listaCaixaFechados").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/CaixaGerencia/CaixaGerenciaController.php',{
        method: 'ListarCaixasFechadosGerencia'
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
            { name: 'COD_CAIXA_GERENCIA', type: 'int' },
            { name: 'DTA_CAIXA_GERENCIA', type: 'string' },
            { name: 'VLR_CAIXA_VENDEDOR', type: 'string' }
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
            { text: 'Data do Caixa', datafield: 'DTA_CAIXA_GERENCIA', columntype: 'textbox', width: 180},
            { text: 'Valor do Caixa', datafield: 'VLR_CAIXA_VENDEDOR', columntype: 'textbox', width: 180}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CarregaCaixaGerencia($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_CAIXA_GERENCIA);
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}

function CarregaCaixaGerencia(codCaixaGerencia){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/CaixaGerencia/CaixaGerenciaController.php',{
        method: 'ListarCaixasVendedorPorCodigo',
        codCaixaGerencia: codCaixaGerencia
    },function(data){
        data = eval('('+data+')');
        if (data[0]){
            if (data[1]!=null){
                var pagamentosVendedor = data[1];
                var pagamentosTipo = data[2];            
                MontaTabelaPagamentosGerencia(pagamentosVendedor, pagamentosTipo);
                impressao = impressao.replace("#data#", pagamentosVendedor[0].DTA_CAIXA);          
                PreparaImpresao();
                $(".FechamentoCaixa").hide();  
                $( "#dialogInformacao" ).jqxWindow("close");
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Sem registros para fechamento do caixa");
                setTimeout(function(){
                    $( "#dialogInformacao" ).jqxWindow("close");        
                },3000);
            }
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
        }
    });    
}
