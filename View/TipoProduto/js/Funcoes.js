function CadTipoProduto(method, registro){
     $( "#CadastroForm" ).jqxWindow( "open" );
     $("#method").val(method);
     if (registro==0){
        $("#codTipoProduto").val("");
        $("#dscTipoProduto").val("");        
        $("#indAtivo").jqxCheckBox('uncheck');      
     }else{
        $("#codTipoProduto").val(registro.COD_TIPO_PRODUTO);
        $("#dscTipoProduto").val(registro.DSC_TIPO_PRODUTO);        
        if (registro.IND_ATIVO=='S'){            
            $("#indAtivo").jqxCheckBox('check');
        }else{            
            $("#indAtivo").jqxCheckBox('uncheck');
        } 
    }
}
function CarregaGridTipoProduto(){
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/TipoProduto/TipoProdutoController.php',
        {method: 'ListarTipoProduto',
         parametro: $("#parametro").val()},function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaTipoProduto(data[1]);         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}
function MontaTabelaTipoProduto(listaTipoProdutos){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaTipoProdutos,
        datatype: "json",
        datafields:
        [
            { name: 'COD_TIPO_PRODUTO', type: 'int' },
            { name: 'DSC_TIPO_PRODUTO', type: 'string' },
            { name: 'IND_ATIVO', type: 'string' },
            { name: 'ATIVO', type: 'boolean' }
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
            { text: 'TipoProduto', datafield: 'DSC_TIPO_PRODUTO', columntype: 'textbox', width: 280},
            { text: 'Ativo', datafield: 'ATIVO', columntype: 'checkbox', width: 80}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadTipoProduto('UpdateTipoProduto',$('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex));
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}