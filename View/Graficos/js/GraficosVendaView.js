$(document).ready(function(){
    CarregaGrafico();
});

function CarregaGrafico(){
//    $("#tdGrafico").html('');
//    $("#tdGrafico").html('<div id="grafico"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Graficos/GraficosVendaController.php',
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
            { name: 'VLR_VENDA', type: 'string' }
        ]
    };    
    var dataAdapter = new $.jqx.dataAdapter(source);
    var settings = {
                title: "Vendas Por M\u00eas",
                description: "Estat\u00edsticas das Vendas Anual",
                showLegend: true,
                enableAnimations: true,
                padding: { left: 20, top: 5, right: 20, bottom: 5 },
                titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                source: dataAdapter,
                xAxis:
                {
                    dataField: 'DSC_MES', 
                    displayText: 'Mes: ',
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
                                    { dataField: 'VLR_VENDA', displayText: 'Valor Mensal' }
                                ]
                        }
                    ]
            };   
    $('#grafico').jqxChart(settings);
}

