function CadFornecedor(method, registro){
     $( "#CadastroForm" ).jqxWindow( "open" );
     $("#method").val(method);
     if (registro==0){
        $("#codFornecedor").val("");
        $("#dscFornecedor").val(""); 
        $("#nroTelefone").val(""); 
        $("#txtObs").val("");           
        $("#nroCNPJ").val("");           
        $("#nroCep").val("");           
        $("#txtLogradouro").val("");           
        $("#txtComplemento").val("");           
        $("#nmeBairro").val("");           
        $("#nmeCidade").val("");           
        $("#sglUf").val("");
        $("#nroIE").val("");           
        $("#indAtivo").jqxCheckBox('uncheck');      
     }else{
        $("#codFornecedor").val(registro.COD_FORNECEDOR);
        $("#dscFornecedor").val(registro.DSC_FORNECEDOR);
        $("#nroTelefone").val(registro.NRO_TELEFONE);
        $("#txtObs").val(registro.TXT_OBS);  
        $("#nroCNPJ").val(registro.NRO_CNPJ);           
        $("#nroCep").val(registro.NRO_CEP);           
        $("#txtLogradouro").val(registro.TXT_LOGRADOURO);           
        $("#txtComplemento").val(registro.TXT_COMPLEMENTO);           
        $("#nmeBairro").val(registro.NME_BAIRRO);           
        $("#nmeCidade").val(registro.TXT_LOCALIDADE);           
        $("#sglUf").val(registro.SGL_UF);           
        $("#nroIE").val(registro.NRO_IE);                   
        if (registro.IND_ATIVO=='S'){            
            $("#indAtivo").jqxCheckBox('check');
        }else{            
            $("#indAtivo").jqxCheckBox('uncheck');
        } 
    }
}
function CarregaGridFornecedor(){
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Fornecedor/FornecedorController.php',
        {method: 'ListarFornecedorGrid',
         parametro: $("#parametro").val()},function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaFornecedor(data[1]);         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}

function MontaTabelaFornecedor(listaFornecedor){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaFornecedor,
        datatype: "json",
        datafields:
        [
            { name: 'COD_FORNECEDOR', type: 'int' },
            { name: 'DSC_FORNECEDOR', type: 'string' },
            { name: 'NRO_TELEFONE', type: 'string' },
            { name: 'TXT_OBS', type: 'string' },
            { name: 'NRO_CNPJ', type: 'string' },
            { name: 'NRO_CEP', type: 'string' },
            { name: 'TXT_LOGRADOURO', type: 'string' },
            { name: 'TXT_COMPLEMENTO', type: 'string' },
            { name: 'NME_BAIRRO', type: 'string' },
            { name: 'TXT_LOCALIDADE', type: 'string' },
            { name: 'SGL_UF', type: 'string' },
            { name: 'NRO_IE', type: 'string' },
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
            { text: 'Fornecedor', datafield: 'DSC_FORNECEDOR', columntype: 'textbox', width: 280},
            { text: 'Telefone', datafield: 'NRO_TELEFONE', columntype: 'textbox', width: 180},
            { text: 'Ativo', datafield: 'ATIVO', columntype: 'checkbox', width: 80}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadFornecedor('UpdateFornecedor',$('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex));
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}
