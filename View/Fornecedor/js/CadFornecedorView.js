$(function() {
    $("#indAtivo").jqxCheckBox({ width: 180, height: 25, theme: theme });
    $( "#btnSalvar" ).click(function( event ) {
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open");    
        if ($("#dscFornecedor").val().trim()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o nome do fornecedor!");
            $("#dscFornecedor").focus();
            return false;
        }
        if ($("#indAtivo").jqxCheckBox('val')){
            ativo = 'S';
        }else{
            ativo = 'N';
        }            
        var cep = $("#nroCep").val();
        cep = cep.replace('.','');
        cep = cep.replace('-','');
        $.post('../../Controller/Fornecedor/FornecedorController.php',
            {method: $('#method').val(),
            nroCNPJ: $("#nroCNPJ").val(),
            nroIE: $("#nroIE").val(),
            codFornecedor: $("#codFornecedor").val(),
            dscFornecedor: $("#dscFornecedor").val(),
            nroTelefone: $("#nroTelefone").val(),
            txtObs: $("#txtObs").val(),
            indAtivo: ativo,
            nroCep: cep,
            txtLogradouro: $("#txtLogradouro").val(),
            txtComplemento: $("#txtComplemento").val(),
            nmeBairro: $("#nmeBairro").val(),
            nmeCidade: $("#nmeCidade").val(),
            sglUf: $("#sglUf").val()
        }, function(data){

            data = eval('('+data+')');
            if (data[0]){
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Fornecedor salvo com sucesso!');
                window.setTimeout(function (){
                    $( "#dialogInformacao" ).jqxWindow('close');
                    $( "#CadastroForm" ).jqxWindow('close');
                    CarregaGridFornecedor();
                }, '2000');          
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Fornecedor!');
                $( "#dialogInformacao" ).jqxWindow( "open" );
            }
        });
    });
     
    $("#nroCep").on('blur', function(){
        if ($(this).val()!=''){
            pesquisaCEP();
        }
    }); 
});

function pesquisaCEP(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde, pesquisando CEP!");
    $( "#dialogInformacao" ).jqxWindow("open");    
    $.post('../../Controller/Cliente/ClienteController.php',
        {
            method: 'PesquisaCep',
            nroCep: $("#nroCep").val()
        },
        function(data){
            data = eval('('+data+')');
            if (data.erro){
                $( "#dialogInformacao" ).jqxWindow('setContent', "CEP não encontrado!");
                $("#txtLogradouro").val("");
                $("#txtComplemento").val("");
                $("#nmeBairro").val("");
                $("#nmeCidade").val("");
                $("#sglUf").jqxDropDownList('selectIndex', -1 ); 
                setTimeout(function(){
                    fechaDialog();
                }, 2000);
            }else{
                $("#txtLogradouro").val(data.logradouro);
                $("#txtComplemento").val(data.complemento);
                $("#nmeBairro").val(data.bairro);
                $("#nmeCidade").val(data.localidade);
                $("#sglUf").val(data.uf);
                $( "#dialogInformacao" ).jqxWindow("close");   
            }
        }
    );    
}