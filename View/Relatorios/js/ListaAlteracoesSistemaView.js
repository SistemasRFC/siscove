$(function() {
    $( "#dialogInformacao" ).dialog({
            autoOpen: false,
            width: 450,
            show: 'explode',
            hide: 'explode',
            title: 'Mensagem',
            modal: true,
            buttons: [
                    {
                            text: "Ok",
                            id: "btnOK",
                            click: function() {
                                    $( this ).dialog( "close" );
                            }
                    }
            ]
    });
    $( "#CadastroForm" ).dialog({
        autoOpen: true,
        width: '70%',
        position: ['center',0],
        title: '',
        close: function(ev, ui) { window.location='../../Controller/MenuPrincipal/MenuPrincipalController.php?method=CarregaMenu'; }
    });
    //$("#trcor").tooltip();
    //$(document).tooltip();

});
function EfetuarAlteracao(codAlteracao){
    $( "#dialogInformacao" ).html('Aguarde Reabrindo a venda');
    $("#btnOK").hide();
    $( "#dialogInformacao" ).dialog( "open" );
    $.post('../../Controller/AlteracoesSistema/AlteracoesSistemaController.php',
          {method:'EfetuarAlteracoes',
           codAlteracao: codAlteracao}, function(data){

                if(data==1){
                    $("#btnPesquisa").click();
                    $( "#dialogInformacao" ).html('Venda reaberta com sucesso!');
                    $("#btnOK").show();
                }else{
                    $( "#dialogInformacao" ).html('Erro ao reabrir venda!');
                    $("#btnOK").show();
                }
           }
    );
}