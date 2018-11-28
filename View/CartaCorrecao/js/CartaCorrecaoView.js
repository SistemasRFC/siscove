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
            { name: 'COD_VENDA', type: 'string' },
            { name: 'REFERENCIA', type: 'string' },
            { name: 'DTA_NOTA', type: 'string' },
            { name: 'NME_USUARIO', type: 'string' },
            { name: 'TPO_NOTA', type: 'string' },
            { name: 'VLR_NOTA', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 750,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: true,
        pageable: true,
        columnsresize: true,
        selectionmode: 'singlerow',
        columns: [
          { text: 'Código da Venda', columntype: 'textbox', datafield: 'COD_VENDA', width: 120},
          { text: 'Referência', datafield: 'REFERENCIA', columntype: 'textbox', width: 100, cellsalign: 'right'},
          { text: 'Data', datafield: 'DTA_NOTA', columntype: 'textbox', width: 100, cellsalign: 'center', align: 'center'},
          { text: 'Tipo da Movimentação', datafield: 'TPO_NOTA', columntype: 'textbox', width: 150},
          { text: 'Valor', datafield: 'VLR_NOTA', columntype: 'textbox', width: 100, cellsalign: 'right'},
          { text: 'Usuário', datafield: 'NME_USUARIO', columntype: 'textbox', width: 170}
        ]
    });
    // EVENTS
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var $codVenda = $('#listaSequenciais').jqxGrid('getrowdatabyid', args.rowindex).COD_VENDA;
        if($('#listaSequenciais').jqxGrid('getrowdatabyid', args.rowindex).TPO_NOTA = 'VENDA'){
            window.open('../../Controller/CartaCorrecao/CartaCorrecaoController.php?codVenda='+$codVenda+'&method=ResumoVendaCartaCorrecao','page','left=250,top=120,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=850,height=600');
        } else {
            window.open('../../Controller/CartaCorrecao/CartaCorrecaoController.php?codVenda='+$codVenda+'&method=ResumoEntradaCartaCorrecao','page','left=250,top=120,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=850,height=600');
        }
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}

$(document).ready(function(){
    CarregaGridSequenciais();

});