$(function() {
    $("#indAtivo").jqxCheckBox({ width: 120, height: 25, theme: theme });
    $( "#btnSalvar" ).click(function( event ) {
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open");  
        if ($("#dscDeposito").val().trim()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o nome do depósito!");
            $("#dscDeposito").focus();
            return false;
        }
        if ($("#indAtivo").jqxCheckBox('val')){
            ativo = 'S';
        }else{
            ativo = 'N';
        }            
        $.post('../../Controller/Deposito/DepositoController.php',
            {method: $('#method').val(),
            codDeposito: $("#codDeposito").val(),
            dscDeposito: $("#dscDeposito").val(),
            indAtivo: ativo}, function(data){

            data = eval('('+data+')');
            if (data[0]){
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Depósito salvo com sucesso!');                
                window.setTimeout(function (){
                    $( "#dialogInformacao" ).jqxWindow('close');
                    $( "#CadastroForm" ).jqxWindow('close');
                    CarregaGridDeposito();
                }, '2000');         
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar depósito!'+ data[1]);
                $( "#dialogInformacao" ).jqxWindow( "open" );
            }
        });
    });
});
