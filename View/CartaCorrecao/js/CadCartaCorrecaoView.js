$(function() {
    $("#btnEnviarCartaCorrecao").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', 'Aguarde, salvando carta de correção.');
        $( "#dialogInformacao" ).jqxWindow('open');
        $.post('../../Controller/CartaCorrecao/CartaCorrecaoController.php',
        {
            method: 'CartaCorrecao',
            ref: $("#notaReferencia").val(),
            dscCartaCorrecao: $("#dscCartaCorrecao").val()
        },
        function(data){
            data = eval ('('+data+')');
            if(data[0]){
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Carta enviada com sucesso!');
                window.setTimeout(function (){
                    $( "#dialogInformacao" ).jqxWindow('close');
                }, '2000');
            } else {
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao enviar a Carta!'+data[1]);
            }
        });
    });
});