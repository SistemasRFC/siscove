$(function() {
    $("#indAtivo").jqxCheckBox({ height: 25, theme: theme });
    $( "#btnSalvar" ).click(function( event ) {
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde, salvando!");
        $( "#dialogInformacao" ).jqxWindow("open");    
        if ($("#nmeFuncionario").val().trim()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o nome do funcionário!");
            $("#nmeFuncionario").focus();
            return false;
        }
        if ($("#vlrPorcentagemServico").val().trim()==''){
            $("#vlrPorcentagemServico").val('0');
        }
        if ($("#vlrPorcentagemVenda").val().trim()==''){
            $("#vlrPorcentagemVenda").val('0');
        }
        if ($("#vlrPorcentagemGerencia").val().trim()==''){
            $("#vlrPorcentagemGerencia").val('0');
        }
        if ($("#indAtivo").jqxCheckBox('val')){
            ativo = 'S';
        }else{
            ativo = 'N';
        }   
        $.post('../../Controller/Funcionario/FuncionarioController.php',
            {method: $("#method").val(),
             nmeFuncionario: $("#nmeFuncionario").val(),
             codFuncionario: $("#codFuncionario").val(),
             nroTelefone: $("#nroTelefone").val(),
             txtEmail: $("#txtEmail").val(),
             vlrPorcentagemServico: $("#vlrPorcentagemServico").val(),
             vlrPorcentagemVenda: $("#vlrPorcentagemVenda").val(),
             vlrPorcentagemGerencia: $("#vlrPorcentagemGerencia").val(),
             codDeposito: $("#codDeposito").val(),
             codPerfil: $("#codPerfil").val(),
             indAtivo: ativo}, function(data){

            data = eval('('+data+')');
            if (data[0]){
                CarregaGridFuncionario();                
                $( "#CadastroForm" ).jqxWindow('close');
                if ($("#method").val()=='AddFuncionario'){
                    $( "#dialogInformacao" ).jqxWindow('setContent', 'Funcionário salvo com sucesso!<br>O usuário para acesso é: '+data[3]+'.<BR>A senha para acesso é 123459');
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setContent', 'Funcionário salvo com sucesso!');
                }
                    //$( "#dialogInformacao" ).jqxWindow('close');
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar funcionário!');
            }
        });
    });
    
});