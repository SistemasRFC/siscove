$(function() {
    
});
function listarChequesRecebidos(){
    $("#tdGridChequesRecebidos").html('');
    $("#tdGridChequesRecebidos").html('<div id="ListagemFormChequesRecebidos"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Pagamentos/PagamentosController.php',
    {
        method: 'ListarChequesRecebidos'
    },function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaChequesRecebidos(data[1]);                
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}
function MontaTabelaChequesRecebidos(listaPagamentos){
    var nomeGrid = 'ListagemFormChequesRecebidos';
    var source =
    {
        localdata: listaPagamentos,
        datatype: "json",
        datafields:
        [
            { name: 'NRO_CHEQUE', type: 'string' },
            { name: 'NRO_BANCO', type: 'string' },
            { name: 'NME_PROPRIETARIO', type: 'string' },
            { name: 'VLR_PAGAMENTO', type: 'string' },
            { name: 'DTA_PAGAMENTO', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 540,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: true,
        pageable: false,
        columnsresize: true,
        selectionmode: 'single',
        columns: [
            { text: 'N&ordm; do Cheque', datafield: 'NRO_CHEQUE', columntype: 'textbox', width: 80},
            { text: 'N&ordm; do Banco', datafield: 'NRO_BANCO', columntype: 'textbox', width: 80},
            { text: 'Proprietário do Cheque', datafield: 'NME_PROPRIETARIO', columntype: 'textbox', width: 180},
            { text: 'Valor', datafield: 'VLR_PAGAMENTO', columntype: 'textbox', width: 80},
            { text: 'Data', datafield: 'DTA_PAGAMENTO', columntype: 'textbox', width: 80}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event){
        var args = event.args;
        $("#nroCheque").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_CHEQUE);
        $("#nroBanco").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NRO_BANCO);
        $("#nmeProprietario").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NME_PROPRIETARIO);
        $("#nmeProprietario").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).NME_PROPRIETARIO);  
        $("#vlrPagamento").val($('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex).VLR_PAGAMENTO);  
        $("#ChequesRecebidos").jqxWindow("close");
    });
    $("#dialogInformacao" ).jqxWindow("close"); 
    $("#ChequesRecebidos").jqxWindow("open");
}

$(document).ready(function(){
    $("input[type='button']").jqxButton({theme: theme});
    $("input[type='text']").jqxInput({theme: theme, width: '250px', height: '25px'});
});