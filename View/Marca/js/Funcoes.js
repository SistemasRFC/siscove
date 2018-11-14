function CadMarca(method, registro){
     $( "#CadastroForm" ).jqxWindow( "open" );
     $("#method").val(method);
     if (registro==0){
        $("#codMarca").val("");
        $("#dscMarca").val("");           
        $("#indAtiva").jqxCheckBox('uncheck');      
     }else{
        $("#codMarca").val(registro.COD_MARCA);
        $("#dscMarca").val(registro.DSC_MARCA);  
        if (registro.IND_ATIVA=='S'){            
            $("#indAtiva").jqxCheckBox('check');
        }else{            
            $("#indAtiva").jqxCheckBox('uncheck');
        } 
    }
}
function CarregaGridMarca(){
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Marca/MarcaController.php',
        {method: 'ListarMarcas',
         parametro: $("#parametro").val()},function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaMarca(data[1]);         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}
function MontaTabelaMarca(listaMarcas){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaMarcas,
        datatype: "json",
        datafields:
        [
            { name: 'COD_MARCA', type: 'int' },
            { name: 'DSC_MARCA', type: 'string' },
            { name: 'IND_ATIVA', type: 'string' },
            { name: 'ATIVA', type: 'boolean' }
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
            { text: 'Marca', datafield: 'DSC_MARCA', columntype: 'textbox', width: 280},
            { text: 'Ativo', datafield: 'ATIVA', columntype: 'checkbox', width: 80}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadMarca('UpdateMarca',$('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex));
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}
