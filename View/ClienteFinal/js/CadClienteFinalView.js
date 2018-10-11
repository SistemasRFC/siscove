$(function() {
    $("#indAtivo").jqxCheckBox({ width: 120, height: 25, theme: theme });
    $( "#btnSalvar" ).click(function( event ) {
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde, salvando!");
        $( "#dialogInformacao" ).jqxWindow("open");   
        if ($("#indAtivo").jqxCheckBox('val')){
            ativo = 'S';
        }else{
            ativo = 'N';
        }   
        $.post('../../Controller/ClienteFinal/ClienteFinalController.php',
            {method: $("#method").val(),
            codCliente: $("#codCliente").val(),
            dscCliente: $("#dscCliente").val(),
            indAtivo: ativo
        }, function(data){
            data = eval('('+data+')');
            if (data[0]){
                CarregaGridCliente();
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Cliente salvo com sucesso!');
                $( "#CadastroForm" ).jqxWindow( "close" );
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Cliente!');                
            }
        });
    });
    
});

function deletarCliente(){        
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde, Removendo cliente!");
    $( "#dialogInformacao" ).jqxWindow("open"); 
    $.post('../../Controller/ClienteFinal/ClienteFinalController.php',
        {method:'DeleteCliente',
         codCliente: $("#codCliente").val()}, function(data){
            data = eval('('+data+')');
            if(data[0]){
                CarregaGridDespesa();
                $( "#dialogInformacao" ).html('Cliente removido com sucesso!'); 
                $( "#CadastroForm" ).jqxWindow( "close" );
            }else{
                $( "#dialogInformacao" ).html('Erro ao remover despesa!');                
            }
         }
    );
}