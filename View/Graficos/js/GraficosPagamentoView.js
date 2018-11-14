$(document).ready(function(){
    CarregaGrafico();
});

function CarregaGrafico(){
//    $("#tdGrafico").html('');
//    $("#tdGrafico").html('<div id="grafico"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Graficos/GraficosPagamentoController.php',
        {
            method: 'SelecionaDados'
        },
        function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaGrafico(data[1]);         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });    
}

function MontaGrafico(data){
    var source =
    {
        localdata: data,
        datatype: "json",
        datafields:
        [
            { name: 'DSC_MES', type: 'String' },
            { name: 'VLR_CONTA_PAGA', type: 'string' },
            { name: 'VLR_CONTA_ABERTA', type: 'string' },
            { name: 'VLR_CONTA', type: 'string' }
        ]
    };    
    var dataAdapter = new $.jqx.dataAdapter(source);
    var settings = {
                title: "Pagamentos Por M\u00eas",
                description: "Estat\u00edsticas dos Pagamentos Anual",
                showLegend: true,
                enableAnimations: true,
                padding: { left: 20, top: 5, right: 20, bottom: 5 },
                titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                source: dataAdapter,
                xAxis:
                {
                    dataField: 'DSC_MES', 
                    displayText: 'M\u00eas: ',
                    gridLines: { visible: true },
                    flip: false
                },
                valueAxis:
                {
                    flip: false,
                    labels: {
                        visible: true
                    }
                },
                colorScheme: 'scheme05',
                seriesGroups:
                    [
                        {
                            type: 'column',
                            orientation: 'vertical',
                            columnsGapPercent: 500,
                            toolTipFormatSettings: { thousandsSeparator: ',' },
                            series: [
                                    { dataField: 'VLR_CONTA_PAGA', displayText: 'Valor Pago' },
                                    { dataField: 'VLR_CONTA_ABERTA', displayText: 'Valor Aberto' },
                                    { dataField: 'VLR_CONTA', displayText: 'Valor Total' }
                                ]
                        }
                    ]
            };   
    $('#grafico').jqxChart(settings);
}

