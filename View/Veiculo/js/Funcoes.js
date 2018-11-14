function CadVeiculo(method, registro){
     $( "#CadastroForm" ).jqxWindow( "open" );
     $("#method").val(method);
     if (registro==0){
        $("#codVeiculo").val("0");
        $("#dscVeiculo").val("");           
        $("#indVeiculoAtivo").jqxCheckBox('uncheck');      
     }else{
        $("#codVeiculo").val(registro.COD_VEICULO);
        $("#dscVeiculo").val(registro.DSC_VEICULO);  
        if (registro.IND_ATIVO=='S'){            
            $("#indVeiculoAtivo").jqxCheckBox('check');
        }else{            
            $("#indVeiculoAtivo").jqxCheckBox('uncheck');
        } 
    }
}
function CarregaGridVeiculo(){
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Veiculo/VeiculoController.php',
        {method: 'ListarVeiculosGrid'},function(data){
            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaVeiculo(data[1]);         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}
function MontaTabelaVeiculo(listaVeiculos){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaVeiculos,
        datatype: "json",
        datafields:
        [
            { name: 'COD_VEICULO', type: 'int' },
            { name: 'DSC_VEICULO', type: 'string' },
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
            { text: 'Veiculo', datafield: 'DSC_VEICULO', columntype: 'textbox', width: 280},
            { text: 'Ativo', datafield: 'ATIVO', columntype: 'checkbox', width: 80}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadVeiculo('UpdateVeiculo',$('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex));
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}

function SalvarVeiculo(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");  
    if ($("#indVeiculoAtivo").jqxCheckBox('val')){
        ativo = 'S';
    }else{
        ativo = 'N';
    }            
    if ($("#dscVeiculo").val().trim()==''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o Nome do Veículo!");
        $("#dscVeiculo").focus();
        return false;
    }
    $.post('../../Controller/Veiculo/VeiculoController.php',
        {method: $('#method').val(),
        codVeiculo: $("#codVeiculo").val(),
        dscVeiculo: $("#dscVeiculo").val(),
        indVeiculoAtivo: ativo}, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Registro salvo com sucesso!');
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');
                $( "#CadastroForm" ).jqxWindow('close');
                CarregaGridVeiculo();
            }, '2000');             
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Registro! '+data[1]);
            $( "#dialogInformacao" ).jqxWindow( "open" );
        }
    });
}
