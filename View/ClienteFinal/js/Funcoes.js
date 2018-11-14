function CadClienteFinal(method, codCliente, dscCliente, ativo){
     $( "#CadastroForm" ).jqxWindow( "open" );
     $("#method").val(method);
     $("#codCliente").val(codCliente);
     $("#dscCliente").val(dscCliente);     
     if (ativo){
         $("#indAtivo").jqxCheckBox('check');
     }else{
         $("#indAtivo").jqxCheckBox('uncheck');
     }
}
function CarregaGridCliente(){
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/ClienteFinal/ClienteFinalController.php',
        {method: 'ListarClienteFinal'},function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaCliente(data[1]);         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}
function MontaTabelaCliente(listaClientes){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaClientes,
        datatype: "json",
        datafields:
        [
            { name: 'COD_CLIENTE_FINAL', type: 'int' },
            { name: 'NME_CLIENTE_FINAL', type: 'string' },
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
          { text: 'Nome', datafield: 'NME_CLIENTE_FINAL', columntype: 'textbox', width: 280},
          { text: 'Ativo', datafield: 'ATIVO', columntype: 'checkbox', width: 80}
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadClienteFinal('UpdateCliente',
                   $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_CLIENTE_FINAL,
                   $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).DSC_CLIENTE_FINAL,
                   $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).ATIVO);
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}
