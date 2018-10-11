$(function() {
    $("#indNovo").jqxRadioButton({ width: 150, height: 25, checked: true, theme: theme});
    $("#indSemiNovo").jqxRadioButton({ height: 25, checked: false, theme: theme});    
    $("#indAtivo").jqxCheckBox({ width: 120, height: 25, theme: theme });
    $("#vlrMinimo").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
    $("#vlrVenda").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});    

    $("#codTipoProduto").change(function(){
        if ($(this).val()==1 || $(this).val()==2){
            $(".nroPneu").show();
        }else{
            $(".nroPneu").hide();
        }
    });    
});