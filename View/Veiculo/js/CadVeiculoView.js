$(function() {
    $("#indVeiculoAtivo").jqxCheckBox({ width: 120, height: 25, theme: theme });
    $( "#btnSalvarVeiculo" ).click(function( event ) {
        SalvarVeiculo();
    });
});
