function CadDeposito(method, registro){
     $( "#CadastroForm" ).jqxWindow( "open" );
     $("#method").val(method);
     if (registro==0){
        $("#codDeposito").val("");
        $("#dscDeposito").val("");           
        $("#indAtivo").jqxCheckBox('uncheck');      
     }else{
        $("#codDeposito").val(registro.COD_DEPOSITO);
        $("#dscDeposito").val(registro.DSC_DEPOSITO);  
        if (registro.IND_ATIVO=='S'){            
            $("#indAtivo").jqxCheckBox('check');
        }else{            
            $("#indAtivo").jqxCheckBox('uncheck');
        } 
    }
}
function CarregaGridDeposito(){
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Deposito/DepositoController.php',
        {method: 'ListarDepositos',
         parametro: $("#parametro").val()},function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaDeposito(data[1]);         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}
function MontaTabelaDeposito(listaDepositos){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaDepositos,
        datatype: "json",
        datafields:
        [
            { name: 'COD_DEPOSITO', type: 'int' },
            { name: 'DSC_DEPOSITO', type: 'string' },
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
            { text: 'Deposito', datafield: 'DSC_DEPOSITO', columntype: 'textbox', width: 280},
            { text: 'Ativo', datafield: 'ATIVO', columntype: 'checkbox', width: 80}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadDeposito('UpdateDeposito',$('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex));
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}
