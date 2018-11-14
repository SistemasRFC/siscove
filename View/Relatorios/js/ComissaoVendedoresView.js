    $(function() {
        $("input[type='button']").jqxButton({theme: theme}); 
        $( "#dtaVendaInicio" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
        $( "#dtaVendaFim" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});                
        $("#btnPesquisa").click(function(){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
            $( "#dialogInformacao" ).jqxWindow("open"); 
            if ($("#dtaVendaInicio").val()==''){
                $( "#dialogInformacao" ).jqxWindow('setContent','Selecione uma data inicial!');
                $("#dtaVendaInicio").focus();
                exit;
            }
            if ($("#dtaVendaFim").val()==''){
                $( "#dialogInformacao" ).jqxWindow('setContent','Selecione uma data final!');
                $("#dtaVendaFim").focus();
                exit;
            }
            
            if (($("#codFuncionario").val()=='0')||
                ($("#codFuncionario").val()==null)){
                $( "#dialogInformacao" ).jqxWindow('setContent','Selecione um funcionário!');
                $("#codFuncionario").focus();
                exit;
            }
            $("#conteudo").html("<img src='../../Resources/images/carregando.gif'>");
            $.post('../../Controller/Relatorios/ComissaoVendedoresController.php', { 
                method: 'DadosComissao',
                dtaVendaInicio: $("#dtaVendaInicio").val(),
                dtaVendaFim: $("#dtaVendaFim").val(),
                codFuncionario: $("#codFuncionario").val()}, function(data){
                data = eval('('+data+')');

                if (data[0]){
                    if (data[1]!=null){
                        MontaTabelaComissao(data);
                        $( "#dialogInformacao" ).jqxWindow('close');
                    }else{
                        $( "#dialogInformacao" ).jqxWindow('setContent','Sem Dados para a pesquisa!');
                    }
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setContent','Erro ao efetuar pesquisa!');
                }
            });
        })
    });

function MontaTabelaComissao(data){
    codVenda=0;
    $("#conteudo").html('');
    linha = '<table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="0" style="border: 1px solid #000000;" >';
    vlrTotal = 0;
    corLinha = 'white';
    primeira = true;
    for(var i=0;i<data[1].length;i++){
        if (corLinha = 'white'){
            corLinha = '#E8E8E8';
        }else{
            corLinha = 'white';
        }        
        if (codVenda!=data[1][i].COD_VENDA){
            linha += 
                ' <tr><td colspan="4" style="border: 1px solid #000000;">Código da Venda: '+data[1][i].COD_VENDA+'<br> '+
                ' Data da Venda: '+data[1][i].DTA_VENDA+'<br> '+
                ' Cliente: '+data[1][i].DSC_CLIENTE+'<br> '+
                ' Veículo: '+data[1][i].DSC_VEICULO+'<br> '+
                ' Vendedor: '+data[1][i].NME_VENDEDOR+'</td></tr>\n\ '+
                ' <tr>\n\ '+
                '     <td class="TDTitulo">\n\ '+
                '         Valor da Venda\n\ '+
                '     </td>\n\ '+
                '     <td align="right" class="TDTitulo">\n\ '+
                '         Porcentagem\n\ '+
                '     </td>\n\ '+
                ' </tr>\n\ ';
        }
        codVenda = data[1][i].COD_VENDA;
        linha = linha+'<tr bgcolor="'+corLinha+'" class="trcor">'+
            ' <td id="dscCliente">'+data[1][i].VLR_VENDA_TOTAL+'</td>'+
            ' <td align="right" id="dscVeiculo">'+data[1][i].VLR_PORCENTAGEM_VENDA+'</td>'+
        ' </tr>';        
    }
    linha = linha + ' <tr> '+
            ' <td colspan="4" align="right" class="TDTitulo">Total: R$ '+data[1][Object.keys(data[1]).length-1].VLR_PORCENTAGEM_VENDA_TOTAL+'</td>'+
            ' </tr>'+
    ' </table>';
//    var tmp = window.open('', 'popimpr');
//    tmp.document.write('Relatório de comissão de funcionários');
//    tmp.document.write(linha);   
    $("#conteudo").html(linha); 
}
$(document).ready(function(){
    CriarCombo('codFuncionario', 
               '../../Controller/Funcionario/FuncionarioController.php', 
               'method;ListarVendedoresAtivos', 
               'COD_FUNCIONARIO|NME_FUNCIONARIO', 
               'NME_FUNCIONARIO', 
               'COD_FUNCIONARIO');
});