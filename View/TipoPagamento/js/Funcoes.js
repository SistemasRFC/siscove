function CadTipoPagamento(method, registro){
     $( "#CadastroForm" ).jqxWindow( "open" );
     $("#method").val(method);
     if (registro==0){
        $("#codTipoPagamento").val("");
        $("#dscTipoPagamento").val("");     
        $("#vlrPorcentagem").val("");   
        $("#indAtivo").jqxCheckBox('uncheck');      
     }else{
        $("#codTipoPagamento").val(registro.COD_TIPO_PAGAMENTO);
        $("#dscTipoPagamento").val(registro.DSC_TIPO_PAGAMENTO);
        $("#vlrPorcentagem").val(registro.VLR_PORCENTAGEM);        
        if (registro.IND_ATIVO=='S'){            
            $("#indAtivo").jqxCheckBox('check');
        }else{            
            $("#indAtivo").jqxCheckBox('uncheck');
        } 
    }
}
function CarregaGridTipoPagamento(){
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/TipoPagamento/TipoPagamentoController.php',
        {method: 'ListarTipoPagamento',
         parametro: $("#parametro").val()},function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaTipoPagamento(data[1]);         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}
function MontaTabelaTipoPagamento(listaTipoPagamentos){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaTipoPagamentos,
        datatype: "json",
        datafields:
        [
            { name: 'COD_TIPO_PAGAMENTO', type: 'int' },
            { name: 'DSC_TIPO_PAGAMENTO', type: 'string' },
            { name: 'IND_ATIVO', type: 'string' },
            { name: 'ATIVO', type: 'boolean' },
            { name: 'VLR_PORCENTAGEM', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 1200,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: true,
        pageable: false,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
            { text: 'TipoPagamento', datafield: 'DSC_TIPO_PAGAMENTO', columntype: 'textbox', width: 280},
            { text: 'Ativo', datafield: 'ATIVO', columntype: 'checkbox', width: 80}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadTipoPagamento('UpdateTipoPagamento',$('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex));
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}