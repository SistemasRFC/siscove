$(function() {
    $("#indContaPaga").jqxCheckBox({ width: 120, height: 25, theme: theme });
    $( "#dtaVencimento" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaPagamento" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $("#vlrPagamento").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});              
    $("#vlrPago").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});              
    $( "#btnSalvarPagamento" ).click(function( event ) {
        salvarPagamento();
    });
    $( "#btnDeletarPagamento" ).click(function( event ) {
        deletarPagamento();
    });
    $( "#btnChequeRecebido" ).click(function( event ) {
        listarChequesRecebidos();
    }); 
    $( "#btnNovoPagamento" ).click(function( event ) {
        CadPagamento('InserirPagamento', 0);
    });    
    
});

function deletarPagamento(){    
    var rowIndex = $("#ListagemPagamentosForm").jqxGrid('selectedrowindexes'); 
    var codigos = '';    
    for (i=0;i<rowIndex.length;i++){
        codigos += $('#ListagemPagamentosForm').jqxGrid('getrowdatabyid', rowIndex[i]).COD_PAGAMENTO+', ';
    }    
    codigos = codigos.substr(0,codigos.length-2);    
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");     
    $.post('../../Controller/Pagamentos/PagamentosController.php',
        {method: 'DeletarPagamento',
        codPagamento: codigos}, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Pagamento Excluído!');
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');                
                informarPagamento();
            }, '2000');                
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao excluir pagamento!');
            $( "#dialogInformacao" ).jqxWindow( "open" );
        }
    });
}
function salvarPagamento(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");  
    if ($("#dtaPagamento").val().trim()==''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Digite a data de pagamento!");
        $("#dtaPagamento").focus();
        return false;
    } 
    $.post('../../Controller/Pagamentos/PagamentosController.php',
        {method: $('#methodPagamento').val(),
        codConta: $("#codConta").val(),
        codPagamento: $("#codPagamento").val(),
        dtaPagamento: $("#dtaPagamento").val(),
        nroBanco: $("#nroBanco").val(),
        nroCheque: $("#nroCheque").val(),
        qtdParcelas: $("#qtdParcelas").val(),
        nroParcelaAtual: $("#nroParcelaAtual").val(),
        nmeProprietarioCheque: $("#nmeProprietarioCheque").val(),
        vlrPagamento: $("#vlrPagamento").val(),        
        codTipoPagamento: $("#codTipoPagamento").val()}, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Pagamento Salvo!');            
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');
                informarPagamento();
            }, '2000');                
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar pagamento!');
            $( "#dialogInformacao" ).jqxWindow( "open" );
        }
    });
}

function informarPagamento(){
    $("#methodPagamento").val('InserirPagamento');
    $("#tdGridChequesRecebidos").html('');
    $("#tdGridChequesRecebidos").html('<div id="ListagemFormChequesRecebidos"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Pagamentos/PagamentosController.php',
    {
        method: 'ListarPagamentos',
        codConta: $("#codConta").val()
    },function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaPagamentos(data[1]);                
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });    
}

function MontaTabelaPagamentos(listaPagamentos){
    var nomeGrid = 'ListagemPagamentosForm';
    var source =
    {
        localdata: listaPagamentos,
        datatype: "json",
        datafields:
        [
            { name: 'COD_CONTA', type: 'int' },
            { name: 'COD_PAGAMENTO', type: 'int' },            
            { name: 'DTA_PAGAMENTO', type: 'string' },
            { name: 'VLR_PAGAMENTO', type: 'string' },
            { name: 'VALOR_PAGAMENTO', type: 'string' },
            { name: 'COD_TIPO_PAGAMENTO', type: 'string' },
            { name: 'DSC_TIPO_PAGAMENTO', type: 'string' },
            { name: 'NRO_BANCO', type: 'string' },
            { name: 'NRO_CHEQUE', type: 'string' },
            { name: 'NME_PROPRIETARIO_CHEQUE', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 500,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: true,
        pageable: false,
        columnsresize: true,
        selectionmode: 'checkbox',
        columns: [            
            { text: 'Data', datafield: 'DTA_PAGAMENTO', columntype: 'textbox', width: 80},
            { text: 'Valor', datafield: 'VLR_PAGAMENTO', columntype: 'textbox', width: 80},
            { text: 'Tipo', datafield: 'DSC_TIPO_PAGAMENTO', columntype: 'textbox', width: 80}
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadPagamento('UpdatePagamento',$('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex));
    });
    $("#dialogInformacao" ).jqxWindow("close");
}
function CadPagamento(method, registro){     
    $( "#InformaPagamento" ).jqxWindow("open");
     $("#methodPagamento").val(method);
     if (registro==0){
        $("#codPagamento").val("");        
        $("#dtaPagamento").val("");
        $("#vlrPagamento").val("");
        $("#codTipoPagamento").val("");
        $("#nroBanco").val("1");
        $("#nroCheque").val("1");
        $("#nmeProprietarioCheque").val('');      
     }else{
        $("#codPagamento").val(registro.COD_PAGAMENTO);
        $("#dtaPagamento").val(registro.DSC_PAGAMENTO);
        $("#vlrPagamento").val(registro.VLR_PAGAMENTO);
        $("#codTipoPagamento").val(registro.COD_TIPO_PAGAMENTO);
        $("#nroBanco").val(registro.TXT_OBSERVACAO);
        $("#nroCheque").val(registro.NRO_QTD_PARCELAS);
        $("#nmeProprietarioCheque").val(registro.NRO_PARCELA_ATUAL);
    }    
}
