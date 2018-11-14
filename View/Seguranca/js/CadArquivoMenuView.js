$(function() {
    $("#btnDeletarArquivo").click(function(){
        DeleteMenuArquivo(); 
    });     
    $("#btnNovoArquivo").click(function(){
        $("#codArquivo").val(0);
        $("#dscArquivo").val('');
        $("#nroPrioridade").val('');
        $("#methodArquivo").val('addArquivo');
        $("#CadArquivoMenus").jqxWindow("open");
    });    
    $("#btnSalvarArquivo").click(function(){
        $("#dialogInformacao").jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, salvando!<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
        $("#dialogInformacao" ).jqxWindow("open");    
        $.post('../../Controller/Seguranca/CadastroMenuController.php',
            {method: $("#methodArquivo").val(),
            codMenu: $("#codMenu").val(),
            codArquivo: $("#codArquivo").val(),
            dscArquivo: $("#dscArquivo").val(),
            nroPrioridade: $("#nroPrioridade").val()
        }, function(result){                            
            result = eval('('+result+')');
            if (result[0]==true){              
                MontaTabelaArquivoMenu($("#codMenu").val());
                $( "#CadArquivoMenus" ).jqxWindow("close");
            }else{                                
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar!'+result[1]);
            }
        });
    });
    
});

function MontaTabelaArquivoMenu(codMenu){
    var theme = 'energyblue';
    var nomeGrid = 'listaArquivoMenu';    
    var source =
    {
        datatype: "json",
        type: "post",
        updaterow: function (rowid, rowdata, commit) {
            commit(true);
        },
        datafields:
        [
            { name: 'COD_ARQUIVO', type: 'string' },
            { name: 'DSC_ARQUIVO', type: 'string' },
            { name: 'NRO_PRIORIDADE', type: 'string' }
        ],
        url: '../../Controller/Seguranca/CadastroMenuController.php',
        data:{
            method: 'ListaArquivoMenuGrid',
            codMenu: codMenu
        }
        
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 400,
        height: 150,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: true,
        pageable: true,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
          { text: 'Descri&ccedil;&atilde;o', datafield: 'DSC_ARQUIVO', columntype: 'textbox', width: 280}
        ]
    });
    // events
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        $("#codArquivo").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).COD_ARQUIVO);
        $("#dscArquivo").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).DSC_ARQUIVO);
        $("#nroPrioridade").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_PRIORIDADE);
        $("#methodArquivo").val("UpdateArquivo");        
        $("#CadArquivoMenus").jqxWindow("open");
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}

function DeleteMenuArquivo(){    
    $("#dialogInformacao").jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, removendo menu<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
    $("#dialogInformacao" ).jqxWindow("open");    
    $.post('../../Controller/Seguranca/CadastroMenuController.php',
        {method: 'DeleteMenuArquivo',
        codArquivo: $("#codArquivo").val()}, function(result){                            
        result = eval('('+result+')');
        if (result[0]==true){              
            MontaTabelaArquivoMenu($("#codMenu").val());
            $( "#CadArquivoMenus" ).jqxWindow("close");
        }else{                                
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao deletar Menu!'+result[1]);
        }
    });
}