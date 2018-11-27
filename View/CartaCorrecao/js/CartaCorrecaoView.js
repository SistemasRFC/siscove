function CarregaGridSequenciais(){
    $("#tdSequenciais").html("");
    $("#tdSequenciais").html('<div id="listaSequenciais"></div>');
    $('#listaSequenciais').html("<img src='../../Resources/images/carregando.gif' width='200' height='30'>");
    $("#dialogInformacao").jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, carregando grid!<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
    $("#dialogInformacao" ).jqxWindow("open");     
    $.post('../../Controller/Menu/CadastroMenuController.php', //MUDAR
           {
               method: 'ListarSequenciaisGrid' //MUDAR
           },
           function(listaSequenciais){
                listaSequenciais = eval ('('+listaSequenciais+')');
                MontaTabelaSequenciais(listaSequenciais[1]);
           }
    );
}
function MontaTabelaSequenciais(listaSequenciais){
    var nomeGrid = 'listaSequenciais';
    var contextLista = $("#jqxLista").jqxMenu({ width: '120px', autoOpenPopup: false, mode: 'popup', theme: theme });
    var source =
    {
        localdata: listaSequenciais,
        datatype: "json",
        updaterow: function (rowid, rowdata, commit) {
            commit(true);
        },
        datafields:
        [
            { name: 'COD_NOTA', type: 'string' },//MUDAR
            { name: 'COD_SEQUENCIAL', type: 'string' },//MUDAR
            { name: 'DTA_NOTA', type: 'string' },//MUDAR
            { name: 'TPO_NOTA', type: 'string' },//MUDAR
            { name: 'VLR_NOTA', type: 'string' }//MUDAR
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
          { text: 'C&oacute;digo', columntype: 'textbox', datafield: 'COD_NOTA', width: 80},//MUDAR
          { text: 'Chave da Nota', datafield: 'COD_SEQUENCIAL', columntype: 'textbox', width: 180},//MUDAR
          { text: 'data', datafield: 'DTA_NOTA', columntype: 'textbox', width: 180},//MUDAR
          { text: 'tipo', datafield: 'TPO_NOTA', columntype: 'textbox', width: 180},//MUDAR
          { text: 'valor', datafield: 'VLR_NOTA', columntype: 'textbox', width: 180}//MUDAR
        ]
    });
    // EVENTS
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        $("#codNota").val($('#listaSequenciais').jqxGrid('getrowdatabyid', args.rowindex).COD_NOTA);
        $("#dscCartaCorrecao").val('');
        $("#method").val("InsertCarta");
        $("#CartaCorrecaoForm").jqxWindow("open");
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}