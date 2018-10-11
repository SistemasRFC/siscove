$(function() {
    $("#indAtivo").jqxCheckBox({ width: 120, height: 25, theme: theme });
    $("#indComissaoGerencia").jqxCheckBox({ height: 25, theme: theme });
    $("#vlrMinimo").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
    $("#vlrServico").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
    $("#vlrPorcentagem").jqxNumberInput({ width: '250px', height: '25px', digits: 2,decimalSeparator:',', symbolPosition: 'right', symbol: '%', spinButtons: false });
    $( "#btnSalvar" ).click(function( event ) {
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open");   
        if ($("#dscServico").val().trim()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o nome do serviço!");
            $("#dscServico").focus();
            return false;
        }  
        if ($("#indAtivo").jqxCheckBox('val')){
            ativa = 'S';
        }else{
            ativa = 'N';
        }      
        if ($("#indComissaoGerencia").jqxCheckBox('val')){
            comissaoGerencia = 'S';
        }else{
            comissaoGerencia = 'N';
        }        
        $.post('../../Controller/Servico/ServicoController.php',
            {method: $('#method').val(),
            codServico: $("#codServico").val(),
            dscServico: $("#dscServico").val(),
            vlrServico: $("#vlrServico").val(),
            vlrMinimo: $("#vlrMinimo").val(),
            vlrPorcentagem: $("#vlrPorcentagem").val(),
            indAtivo: ativa,
            indComissaoGerencia: comissaoGerencia,
            codCfop: $("#codCfop").val(),
            codIcmsOrigem: $("#codIcmsOrigem").val(),
            codCategoriaNcm: $("#codCategoriaNcm").val(),
            codNcm: $("#codNcm").val(),
            codIcmsSituacaoTributaria: $("#codIcmsSituacaoTributaria").val(),
            codPisSituacaoTributaria: $("#codPisSituacaoTributaria").val(),
            codCofinsSituacaoTributaria: $("#codCofinsSituacaoTributaria").val()
        }, function(data){

            data = eval('('+data+')');
            if (data[0]){
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Serviço salvo com sucesso!');
                window.setTimeout(function (){
                    $( "#dialogInformacao" ).jqxWindow('close');
                    $( "#CadastroForm" ).jqxWindow('close');
                    CarregaGridServico();
                }, '2000'); 
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Servico!');
            }
        });
    });
});