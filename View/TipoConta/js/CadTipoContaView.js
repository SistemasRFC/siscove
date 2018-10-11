$(function() {
    $("#indAtivo").jqxCheckBox({ width: 120, height: 25, theme: theme });    
    $("#vlrPorcentagem").maskMoney({symbol:"% ",decimal:",",thousands:"."});    
    $( "#btnSalvar" ).click(function( event ) {
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open");   
        if ($("#dscTipoConta").val().trim()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o nome do Tipo de Conta!");
            $("#dscTipoConta").focus();
            return false;
        }  
        if ($("#indAtivo").jqxCheckBox('val')){
            ativa = 'S';
        }else{
            ativa = 'N';
        }            
        $.post('../../Controller/TipoConta/TipoContaController.php',
            {method: $('#method').val(),
            codTipoConta: $("#codTipoConta").val(),
            dscTipoConta: $("#dscTipoConta").val(),
            indAtivo: ativa}, function(data){

            data = eval('('+data+')');
            if (data[0]){                
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Tipo de Conta salvo com sucesso!');
                window.setTimeout(function (){
                    $( "#dialogInformacao" ).jqxWindow('close');
                    $( "#CadastroForm" ).jqxWindow('close');
                    CarregaGridTipoConta();
                }, '2000');
                
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Tipo de Conta!');
            }
        });
    });
});