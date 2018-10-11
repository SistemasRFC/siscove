function CadFuncionario(method, registro){
    $( "#CadastroForm" ).jqxWindow( "open" );
    $("#method").val(method);
    if (registro==0){
        $("#codFuncionario").val(0);
        $("#nmeFuncionario").val('');
        $("#nroTelefone").val('');
        $("#txtEndereco").val('');
        $("#vlrPorcentagemServico").val(0);
        $("#vlrPorcentagemVenda").val(0);  
        $("#vlrPorcentagemGerencia").val(0);       
        $("#codPerfil").val(-1);
        $("#codDeposito").val(-1);
        $("#indAtivo").jqxCheckBox('uncheck');      
    }else{
        $("#codFuncionario").val(registro.COD_FUNCIONARIO);
        $("#nmeFuncionario").val(registro.NME_FUNCIONARIO);
        $("#nroTelefone").val(registro.NRO_TEL_CELULAR);
        $("#txtEndereco").val(registro.TXT_ENDERECO);
        $("#vlrPorcentagemServico").val(registro.VLR_PORCENTAGEM_SERVICO);
        $("#vlrPorcentagemVenda").val(registro.VLR_PORCENTAGEM_VENDA);       
        $("#vlrPorcentagemGerencia").val(registro.VLR_PORCENTAGEM_GERENCIA);  
        $("#codPerfil").val(registro.COD_PERFIL_W);
        $("#codDeposito").val(registro.COD_DEPOSITO);     
        if (registro.IND_ATIVO=='S'){            
            $("#indAtivo").jqxCheckBox('check');
        }else{            
            $("#indAtivo").jqxCheckBox('uncheck');
        } 
   }     
}
function CarregaGridFuncionario(){
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $.post('../../Controller/Funcionario/FuncionarioController.php',
        {method: 'ListarFuncionarioGrid'},function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaFuncionario(data[1]);         
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}
function MontaTabelaFuncionario(listaFuncionarios){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaFuncionarios,
        datatype: "json",
        datafields:
        [
            { name: 'COD_FUNCIONARIO', type: 'int' },
            { name: 'NME_FUNCIONARIO', type: 'string' },
            { name: 'TXT_EMAIL', type: 'string' },
            { name: 'NRO_TEL_CELULAR', type: 'string' },
            { name: 'VLR_PORCENTAGEM_SERVICO', type: 'string' },
            { name: 'VLR_PORCENTAGEM_VENDA', type: 'string' },
            { name: 'VLR_PORCENTAGEM_GERENCIA', type: 'string' },
            { name: 'NME_USUARIO', type: 'string' },
            { name: 'COD_PERFIL_W', type: 'string' },
            { name: 'DTA_INATIVO', type: 'string' },
            { name: 'COD_DEPOSITO', type: 'string' },
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
          { text: 'Nome', datafield: 'NME_FUNCIONARIO', columntype: 'textbox', width: 280},
          { text: 'Ativo', datafield: 'ATIVO', columntype: 'checkbox', width: 80}
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadFuncionario('UpdateFuncionario', $('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex));
    });  
}

function MontaComboDeposito(){    
    var source =
    {
        datatype: "json",
        type: "POST",
        datafields: [
            { name: 'COD_DEPOSITO', type: 'string'},
            { name: 'DSC_DEPOSITO', type: 'string'}
        ],
        cache: false,
        url: '../../Controller/Deposito/DepositoController.php',
        data:{method: 'ListarDepositosAtivosCombo'}
    };    
    var dataAdapter = new $.jqx.dataAdapter(source);    
    $("#codDeposito").jqxDropDownList(
    {
        source: dataAdapter,
        theme: theme,
        width: 200,
        height: 25,
        selectedIndex: 0,
        displayMember: 'DSC_DEPOSITO',
        valueMember: 'COD_DEPOSITO'
    });                
}

function MontaComboPerfil(){    
    var source =
    {
        datatype: "json",
        type: "POST",
        datafields: [
            { name: 'COD_PERFIL_W', type: 'string'},
            { name: 'DSC_PERFIL_W', type: 'string'}
        ],
        cache: false,
        url: '../../Controller/Perfil/PerfilController.php',
        data:{method: 'ListarPerfilAtivo'}
    };    
    var dataAdapter = new $.jqx.dataAdapter(source);    
    $("#codPerfil").jqxDropDownList(
    {
        source: dataAdapter,
        theme: theme,
        width: 200,
        height: 25,
        selectedIndex: 0,
        displayMember: 'DSC_PERFIL_W',
        valueMember: 'COD_PERFIL_W'
    });                
}