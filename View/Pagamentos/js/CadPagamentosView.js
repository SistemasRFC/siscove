$(function() {
    $( "#dtaVencimento" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $("#vlrPagamento").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});              
    $( "#btnSalvar" ).click(function( event ) {
        salvarConta();
    });
    $( "#btnInformarPagamento" ).click(function( event ) {
        informarPagamento();
        $( "#InformaPagamento" ).jqxWindow("open");
    });    
    $( "#btnExcluir" ).click(function( event ) {
        deletarConta();
    });
    $( "#btnChequeRecebido" ).click(function( event ) {
        listarChequesRecebidos();
    });    
});

function salvarConta(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");     
    if ($("#dscConta").val().trim()==''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Digite a descrição do Pagamento!");
        $("#dscConta").focus();
        return false;
    } 
    if ($("#dtaVencimento").val().trim()==''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Digite a data de vencimento do Pagamento!");
        $("#dtaVencimento").focus();
        return false;
    }        
    if ($("#indContaPaga").jqxCheckBox('val')){ 
        ativa = 'S';
    }else{
        ativa = 'N';
    }
    $.post('../../Controller/Pagamentos/PagamentosController.php',
        {method: $('#method').val(),
        codConta: $("#codConta").val(),
        codContaFixa: $("#codContaFixa").val(),
        dscConta: $("#dscConta").val(),
        dtaVencimento: $("#dtaVencimento").val(),
        vlrConta: $("#vlrConta").val(),        
        txtObservacao: $("#txtObservacao").val(),
        indContaPaga: ativa,
        codTipoConta: $("#codTipoConta").val()}, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Pagamento Salvo!');
            $("#codConta").val(data[2]);
            $("#btnInformarPagamento").show();
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');
                CarregaGridConta();
            }, '2000');                
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar pagamento!');
            $( "#dialogInformacao" ).jqxWindow( "open" );
        }
    });
}

function deletarConta(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");     
    $.post('../../Controller/Pagamentos/PagamentosController.php',
        {method: 'DeletarConta',
        codConta: $("#codConta").val(),
        codContaFixa: $("#codContaFixa").val(),
        codTipoConta: $("#codTipoConta").val()}, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Pagamento Excluído!');
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');
                $( "#CadastroForm" ).jqxWindow('close');
                CarregaGridConta();
            }, '2000');                
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao excluir pagamento!');
            $( "#dialogInformacao" ).jqxWindow( "open" );
        }
    });
}

function CarregaGridConta(){
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Pagamentos/PagamentosController.php',
    {
        method: 'ListarContas',
        comboNroAnoReferencia: $("#comboNroAnoReferencia").val(),
        comboNroMesReferencia: $("#comboNroMesReferencia").val(),
        comboTpoDespesa: $("#comboTpoDespesa").val(),
        indStatus: $("#comboIndStatus").val()
    },function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaContas(data[1]); 
                totalValor = 0;
                if (data[1]!=null){
                    for (i=0;i<data[1].length;i++){            
                        totalValor = parseFloat(totalValor)+parseFloat(data[1][i].VALOR_CONTA);
                    }        
                    totalValor = Formata(totalValor,2,'.',',');
                }
                $("#vlrTotal").html(totalValor); 
                $("#vlrSelecionado").html('0');                
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}
function MontaTabelaContas(listaContas){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaContas,
        datatype: "json",
        datafields:
        [
            { name: 'COD_CONTA', type: 'int' },
            { name: 'COD_CONTA_FIXA', type: 'int' },
            { name: 'DSC_CONTA', type: 'string' },
            { name: 'DTA_VENCIMENTO', type: 'string' },
            { name: 'VLR_CONTA', type: 'string' },
            { name: 'VALOR_CONTA', type: 'string' },
            { name: 'TXT_OBSERVACAO', type: 'string' },
            { name: 'IND_CONTA_PAGA', type: 'string' },
            { name: 'NRO_QTD_PARCELAS', type: 'string' },
            { name: 'NRO_PARCELA_ATUAL', type: 'string' },
            { name: 'DSC_TIPO_CONTA', type: 'string' },
            { name: 'COD_TIPO_CONTA', type: 'string' },
            { name: 'PAGO', type: 'boolean' }
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
        selectionmode: 'checkbox',
        columns: [
            { text: 'Descrição', datafield: 'DSC_CONTA', columntype: 'textbox', width: 280},
            { text: 'tipo', datafield: 'DSC_TIPO_CONTA', columntype: 'textbox', width: 200},
            { text: 'Data', datafield: 'DTA_VENCIMENTO', columntype: 'textbox', width: 80},
            { text: 'Valor', datafield: 'VLR_CONTA', columntype: 'textbox', width: 80},
            { text: 'Pago', datafield: 'PAGO', columntype: 'checkbox', width: 80}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowselect', function (event) 
    {
        selectedrowindexes = $('#'+nomeGrid).jqxGrid('selectedrowindexes');
        soma = 0;
        for (i=0;i<selectedrowindexes.length;i++){            
            soma = parseFloat(soma)+parseFloat($('#'+nomeGrid).jqxGrid('getrowdatabyid', selectedrowindexes[i]).VLR_CONTA);
        }            
        AtualizaValores(soma);
    });   
    $('#'+nomeGrid).on('rowunselect', function (event) 
    {
        selectedrowindexes = $('#'+nomeGrid).jqxGrid('selectedrowindexes');
        soma = 0;
        for (i=0;i<selectedrowindexes.length;i++){            
            soma = parseFloat(soma)+parseFloat($('#'+nomeGrid).jqxGrid('getrowdatabyid', selectedrowindexes[i]).VLR_CONTA);
        }    
        AtualizaValores(soma);
    });    
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadConta('UpdateConta',$('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex));
    });   
    $("#dialogInformacao" ).jqxWindow("close");  
}
function CadConta(method, registro){
    console.log(registro);
     $( "#CadastroForm" ).jqxWindow( "open" );
     $("#method").val(method);
     if (registro==0){
        $("#btnInformarPagamento").hide();
        $("#codConta").val("0");
        $("#codContaFixa").val("0");
        $("#dscConta").val("");
        $("#dtaVencimento").val("");
        $("#vlrConta").val("");
        $("#txtObservacao").val("");
        $("#qtdParcelas").val("1");
        $("#nroParcelaAtual").val("1");
        $("#indContaPaga").jqxCheckBox('uncheck');      
        $("#codTipoConta").val(-1);
     }else{
        $("#btnInformarPagamento").show();
        $("#codConta").val(registro.COD_CONTA);
        $("#codContaFixa").val(registro.COD_CONTA_FIXA);
        $("#dscConta").val(registro.DSC_CONTA);
        datas = registro.DTA_VENCIMENTO.split('/');
        $("#dtaVencimento").val(new Date(datas[2]+', '+datas[1]+' ,'+datas[0]));
        $("#vlrConta").val(registro.VLR_CONTA);
        $("#txtObservacao").val(registro.TXT_OBSERVACAO);
        $("#qtdParcelas").val(registro.NRO_QTD_PARCELAS);
        $("#nroParcelaAtual").val(registro.NRO_PARCELA_ATUAL);
        $("#indContaPaga").jqxCheckBox('uncheck');      
        if (registro.IND_CONTA_PAGA=='S'){            
            $("#indContaPaga").jqxCheckBox('check');
        }else{            
            $("#indContaPaga").jqxCheckBox('uncheck');
        }
        $("#codTipoConta").val(registro.COD_TIPO_CONTA);
    }    
}
