function CarregaGridSequenciais(){
    $("#tdSequenciais").html("");
    $("#tdSequenciais").html('<div id="listaSequenciais"></div>');
    $('#listaSequenciais').html("<img src='../../Resources/images/carregando.gif' width='200' height='30'>");
    $("#dialogInformacao").jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, carregando grid!<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
    $("#dialogInformacao" ).jqxWindow("open");     
    $.post('../../Controller/CartaCorrecao/CartaCorrecaoController.php',
           {
               method: 'ListarSequenciaisGrid'
           },
           function(listaSequenciais){
                listaSequenciais = eval ('('+listaSequenciais+')');
                MontaTabelaSequenciais(listaSequenciais[1]);
           }
    );
}
function MontaTabelaSequenciais(listaSequenciais){
    var nomeGrid = 'listaSequenciais';
    var source =
    {
        localdata: listaSequenciais,
        datatype: "json",
        updaterow: function (rowid, rowdata, commit) {
            commit(true);
        },
        datafields:
        [
            { name: 'COD_MOVIMENTACAO', type: 'string' },
            { name: 'NRO_SEQUENCIAL', type: 'string' },
            { name: 'DTA_NOTA', type: 'string' },
            { name: 'COD_USUARIO', type: 'string' },
            { name: 'TPO_NOTA', type: 'string' },
            { name: 'VLR_NOTA', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 800,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: true,
        pageable: true,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
          { text: 'C&oacute;digo', columntype: 'textbox', datafield: 'COD_MOVIMENTACAO', width: 80},
          { text: 'Chave da Nota', datafield: 'NRO_SEQUENCIAL', columntype: 'textbox', width: 100},
          { text: 'Data', datafield: 'DTA_NOTA', columntype: 'textbox', width: 170},
          { text: 'Tipo da Movimentação', datafield: 'TPO_NOTA', columntype: 'textbox', width: 170},
          { text: 'Valor', datafield: 'VLR_NOTA', columntype: 'textbox', width: 170},
          { text: 'Usuário', datafield: 'COD_USUARIO', columntype: 'textbox', width: 80}
        ]
    });
    // EVENTS
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        $("#codNota").val($('#listaSequenciais').jqxGrid('getrowdatabyid', args.rowindex).NRO_SEQUENCIAL);//MUDAR
        $("#dscCartaCorrecao").val('');//MUDAR
        $("#method").val("InsertCartaCorrecao");
        // $("#CartaCorrecaoForm").jqxWindow("open");
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}
$(document).ready(function(){
    CarregaGridSequenciais();

});