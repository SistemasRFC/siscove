$(function() {
    $("#indAtiva").jqxCheckBox({ width: 120, height: 25, theme: theme });
    $( "#btnSalvar" ).click(function( event ) {
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open");     
        if ($("#dscMarca").val().trim()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite a descrição da marca!");
            $("#dscMarca").focus();
            return false;
        } 
        if ($("#indAtiva").jqxCheckBox('val')){
            ativa = 'S';
        }else{
            ativa = 'N';
        }            
        $.post('../../Controller/Marca/MarcaController.php',
            {method: $('#method').val(),
            codMarca: $("#codMarca").val(),
            dscMarca: $("#dscMarca").val(),
            indAtiva: ativa}, function(data){

            data = eval('('+data+')');
            if (data[0]){
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Marca salva com sucesso!');
                window.setTimeout(function (){
                    $( "#dialogInformacao" ).jqxWindow('close');
                    $( "#CadastroForm" ).jqxWindow('close');
                    CarregaGridMarca();
                }, '2000');                
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar depósito!');
                $( "#dialogInformacao" ).jqxWindow( "open" );
            }
        });
    });
});
