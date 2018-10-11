$(function() {
    $("#vlrTotalVenda").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
    $("#btnConsolidarOrcamento").click(function() {
                var selecionados = $("input:checkbox:checked.indEstoque").map(function(){
                   return this.id;
                }).get();
                //alert(selecionados);
                $("#ProdutosVendasForm").attr("action","../../Controller/Vendas/VendasController.php");
                document.ProdutosVendasForm.method.value='ConsolidaOrcamento';
                document.ProdutosVendasForm.codProdutoVenda.value=selecionados;
                $("#ProdutosVendasForm").submit();
    }); 
});
