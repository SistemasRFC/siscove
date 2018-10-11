$(function() {
    $("#vlrTotalVenda").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
    $("#btnConsolidarOrcamento").click(function() {
        ConsolidarOrcamento();
    }); 
});

function ConsolidarOrcamento(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");      
    $.post('../../Controller/Vendas/VendasController.php',
    {
        method:'ConsolidaOrcamento',
        codVenda: $("#codVenda").val()
    }, function(data){
        data = eval('('+data+')');
        if (data[0]){
            window.location.href=data[1];
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', "Erro! "+data[1]);
        }
    });    
}