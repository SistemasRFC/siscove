function CadServico(method, registro){
     $( "#CadastroForm" ).jqxWindow( "open" );
     $("#method").val(method);
     $('#jqxTabsServicos').jqxTabs('select', 0);
     if (registro==0){
        $("#codServico").val("");
        $("#dscServico").val("");           
        $("#vlrServico").val("0");          
        $("#vlrMinimo").val("0");          
        $("#vlrPorcentagem").val("0");       
        $("#indAtivo").jqxCheckBox('uncheck');
        $("#indComissaoGerencia").jqxCheckBox('uncheck');
        $("#codCfop").val("5102");
        $("#codIcmsOrigem").val("0");
        CarregarComboCategoriaNcm(86, 87088000);
        $("#codIcmsSituacaoTributaria").val("13");
        $("#codPisSituacaoTributaria").val("33");
        $("#codCofinsSituacaoTributaria").val("33");        
     }else{
        $("#codServico").val(registro.COD_PRODUTO);
        $("#dscServico").val(registro.DSC_PRODUTO);  
        $("#vlrServico").val(registro.VLR_PRODUTO);  
        $("#vlrMinimo").val(registro.VLR_MINIMO);
        $("#vlrPorcentagem").val(registro.VLR_PORCENTAGEM);        
        if (registro.IND_ATIVO=='S'){            
            $("#indAtivo").jqxCheckBox('check');
        }else{            
            $("#indAtivo").jqxCheckBox('uncheck');
        }       
        if (registro.IND_COMISSAO_GERENCIA=='S'){            
            $("#indComissaoGerencia").jqxCheckBox('check');
        }else{            
            $("#indComissaoGerencia").jqxCheckBox('uncheck');
        } 
        $("#codCfop").val(registro.COD_CFOP);
        $("#codIcmsOrigem").val(registro.COD_ICMS_ORIGEM);
        
        CarregarComboCategoriaNcm(registro.COD_CATEGORIA_NCM, registro.COD_NCM)
//        CarregarComboNcm(registro.COD_CATEGORIA_NCM, registro.COD_NCM);
        $("#codIcmsSituacaoTributaria").val(registro.COD_ICMS_SITUACAO_TRIBUTARIA);
        $("#codPisSituacaoTributaria").val(registro.COD_PIS_SITUACAO_TRIBUTARIA);
        $("#codCofinsSituacaoTributaria").val(registro.COD_COFINS_SITUACAO_TRIBUTARIA);
        
    }
}
function CarregaGridServico(){
    var pesquisa = $("#parametro").val();
    pesquisa = pesquisa.trim();
    if (pesquisa.length<3){
//        $( "#dialogInformacao" ).jqxWindow('setContent', "Digite pelo menos 3 letras!");
//        $( "#dialogInformacao" ).jqxWindow("open");      
        return;
    } 
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Servico/ServicoController.php',
        {method: 'ListarServico',
         parametro: $("#parametro").val()},function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaServico(data[1]);         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}
function MontaTabelaServico(listaServicos){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaServicos,
        datatype: "json",
        datafields:
        [
            { name: 'COD_PRODUTO', type: 'int' },
            { name: 'DSC_PRODUTO', type: 'string' },
            { name: 'VLR_PRODUTO', type: 'string' },
            { name: 'VLR_MINIMO', type: 'string' },
            { name: 'IND_ATIVO', type: 'string' },
            { name: 'IND_COMISSAO_GERENCIA', type: 'string' },
            { name: 'VLR_PORCENTAGEM', type: 'string' },
            { name: 'COD_CFOP', type: 'string' },
            { name: 'COD_ICMS_ORIGEM', type: 'string' },
            { name: 'COD_CATEGORIA_NCM', type: 'string' },
            { name: 'COD_NCM', type: 'string' },
            { name: 'COD_ICMS_SITUACAO_TRIBUTARIA', type: 'string' },
            { name: 'COD_PIS_SITUACAO_TRIBUTARIA', type: 'string' },
            { name: 'COD_COFINS_SITUACAO_TRIBUTARIA', type: 'string' },
            { name: 'ATIVO', type: 'boolean' },
            { name: 'COMISSAO_GERENCIA', type: 'boolean' }
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
            { text: 'Servico', datafield: 'DSC_PRODUTO', columntype: 'textbox', width: 280},
            { text: 'Ativo', datafield: 'ATIVO', columntype: 'checkbox', width: 80},
            { text: 'Comissão', datafield: 'COMISSAO_GERENCIA', columntype: 'checkbox', width: 80}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadServico('UpdateServico',$('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex));
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}