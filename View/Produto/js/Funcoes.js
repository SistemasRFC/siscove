function CadProduto(method, registro){    
     $( "#CadastroForm" ).jqxWindow( "open" );
     $("#method").val(method);
     $('#jqxTabsProdutos').jqxTabs('select', 0); 
     if (registro==0){
        $("#codProduto").val("");
        $("#dscProduto").val("");           
        $("#codTipoProduto").val("");          
        $("#codMarca").val("");
        $("#vlrVenda").val("0");
        $("#vlrMinimo").val("0");
        $("#nroAroPneu").val("0");        
        $("#indAtivo").jqxCheckBox('uncheck'); 
        $("#indNovo").jqxRadioButton('check');
        $('#jqxTabsProdutos').jqxTabs({ disabled:true });
        $("#codCfop").val("5102");
        $("#codIcmsOrigem").val("0");
        CarregarComboCategoriaNcm(86, 87088000);
        $("#codIcmsSituacaoTributaria").val("13");
        $("#codPisSituacaoTributaria").val("33");
        $("#codCofinsSituacaoTributaria").val("33");
     }else{
        $("#codProduto").val(registro.COD_PRODUTO);
        $("#dscProduto").val(registro.DSC_PRODUTO);  
        $("#codTipoProduto").val(registro.COD_TIPO_PRODUTO);        
        $("#codMarca").val(registro.COD_MARCA);
        $("#vlrVenda").val(registro.VLR_VENDA);
        $("#vlrMinimo").val(registro.VLR_MINIMO);
        $("#nroAroPneu").val(registro.NRO_ARO_PNEU);        
        if (registro.IND_ATIVO=='S'){            
            $("#indAtivo").jqxCheckBox('check');
        }else{            
            $("#indAtivo").jqxCheckBox('uncheck');
        }                
        if (registro.IND_TIPO_PRODUTO=='N'){            
            $("#indNovo").jqxRadioButton('check');
        }else if (registro.IND_TIPO_PRODUTO=='S'){            
            $("#indSemiNovo").jqxRadioButton('check');
        }else{
            $("#indNovo").jqxRadioButton('uncheck');
            $("#indSemiNovo").jqxRadioButton('uncheck');
        }
        $('#jqxTabsProdutos').jqxTabs({ disabled:false });
        $("#codCfop").val(registro.COD_CFOP);
        $("#codIcmsOrigem").val(registro.COD_ICMS_ORIGEM);
        CarregarComboCategoriaNcm(registro.COD_CATEGORIA_NCM, registro.COD_NCM);
//        CarregarComboNcm(registro.COD_CATEGORIA_NCM, registro.COD_NCM);
        $("#codIcmsSituacaoTributaria").val(registro.COD_ICMS_SITUACAO_TRIBUTARIA);
        $("#codPisSituacaoTributaria").val(registro.COD_PIS_SITUACAO_TRIBUTARIA);
        $("#codCofinsSituacaoTributaria").val(registro.COD_COFINS_SITUACAO_TRIBUTARIA);        
    }
}

function CarregaGridProduto(){
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Produto/ProdutoController.php',
        {method: 'ListarProduto',
         parametro: $("#parametro").val()},function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaProduto(data[1]); 
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}

function MontaTabelaProduto(listaProdutos){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaProdutos,
        datatype: "json",
        datafields:
        [
            { name: 'COD_PRODUTO', type: 'int' },
            { name: 'DSC_PRODUTO', type: 'string' },
            { name: 'NRO_ARO_PNEU', type: 'string' },
            { name: 'COD_MARCA', type: 'int' },
            { name: 'DSC_MARCA', type: 'string' },
            { name: 'VLR_VENDA', type: 'string' },
            { name: 'COD_TIPO_PRODUTO', type: 'int' },
            { name: 'VLR_MINIMO', type: 'string' },
            { name: 'IND_TIPO_PRODUTO', type: 'string' },
            { name: 'IND_ATIVO', type: 'string' },
            { name: 'COD_CFOP', type: 'string' },
            { name: 'COD_ICMS_ORIGEM', type: 'string' },
            { name: 'COD_CATEGORIA_NCM', type: 'string' },
            { name: 'COD_NCM', type: 'string' },
            { name: 'COD_ICMS_SITUACAO_TRIBUTARIA', type: 'string' },
            { name: 'COD_PIS_SITUACAO_TRIBUTARIA', type: 'string' },
            { name: 'COD_COFINS_SITUACAO_TRIBUTARIA', type: 'string' },
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
            { text: 'Produto', datafield: 'DSC_PRODUTO', columntype: 'textbox', width: 280},
            { text: 'Marca', datafield: 'DSC_MARCA', columntype: 'textbox', width: 280},
            { text: 'Ativo', datafield: 'ATIVO', columntype: 'checkbox', width: 80}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadProduto('UpdateProduto',$('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex));
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}

function SalvarProduto(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");  
    verificaCampos();
    if ($("#indNovo").val()){
        tpoProduto = 'N';
    }else if ($("#indSemiNovo").val()){
        tpoProduto = 'S';
    }else{
        tpoProduto = '';
    }
    if ($("#indAtivo").jqxCheckBox('val')){
        ativa = 'S';
    }else{
        ativa = 'N';
    }            
    $.post('../../Controller/Produto/ProdutoController.php',
        {method: $('#method').val(),
        codProduto: $("#codProduto").val(),
        dscProduto: $("#dscProduto").val(),
        codTipoProduto: $("#codTipoProduto").val(),
        codMarca: $("#codMarca").val(),
        vlrVenda: $("#vlrVenda").val(),
        vlrMinimo: $("#vlrMinimo").val(),
        nroAroPneu: $("#nroAroPneu").val(),
        indAtivo: ativa,
        tpoProduto: tpoProduto,
        codCfop: $("#codCfop").val(),
        codIcmsOrigem: $("#codIcmsOrigem").val(),
        codCategoriaNcm: $("#codCategoriaNcm").val(),
        codNcm: $("#codNcm").val(),
        codIcmsSituacaoTributaria: $("#codIcmsSituacaoTributaria").val(),
        codPisSituacaoTributaria: $("#codPisSituacaoTributaria").val(),
        codCofinsSituacaoTributaria: $("#codCofinsSituacaoTributaria").val()
    }, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $("#codProduto").val(data[2]);
            $('#jqxTabsProdutos').jqxTabs({ disabled:false });
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Produto salvo com sucesso!');
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');
            }, '2000');            
            $("#method").val("UpdateProduto");
            if ($("#parametro").val().trim()!=''){
                CarregaGridProduto();
            }
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Produto! '+data[1]);
        }
    });
}

function verificaCampos(){
    if ($("#dscProduto").val().trim()===''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o nome do produto!");
        $("#dscProduto").focus();
        return false;
    }
    if($("#codCategoriaNcm").val().trim()===''){
        $("#codCategoriaNcm").val('86');
    }
    if($("#codNcm").val().trim()===''){
        $("#codNcm").val('87088000');
    }
}