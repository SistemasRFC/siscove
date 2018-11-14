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
                return false;
            }
            if ($("#dtaVendaFim").val()==''){
                $( "#dialogInformacao" ).jqxWindow('setContent','Selecione uma data final!');
                $("#dtaVendaFim").focus();
                return false;
            }
            $("#conteudo").html("<img src='../../Resources/images/carregando.gif'>");
            $.post('../../Controller/Relatorios/ComissaoFuncionariosQtdProdutosController.php', {
                method: 'DadosComissao',
                dtaVendaInicio: $("#dtaVendaInicio").val(),
                dtaVendaFim: $("#dtaVendaFim").val()}, function(data){
                data = eval('('+data+')');

                if (data[0]){
                    if (data[1]!=null){
                        MontaTabelaComissao(data);
                        $( "#dialogInformacao" ).jqxWindow('close');
                    }else{
                        $( "#dialogInformacao" ).jqxWindow('setContent','Sem Dados para a pesquisa!');
                    }
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setContent','Erro ao efetuar abertura do caixa!');
                }
            });
        })
    });

function MontaTabelaComissao(data){
    codVenda=0;
    $("#conteudo").html('');
    linha = '<table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="0" style="border: 1px solid #000000;" >';
    vlrTotal = 0;
    vlrTotalVendas = 0;
    vlrTotalVendasComDesconto = 0;
    corLinha = 'white';
    primeira = true;
    linha += ' <tr><td><table width="100%">\n\ '+
    ' <tr>\n\ '+
    '     <td class="TDTitulo">\n\ '+
    '         Venda\n\ '+
    '     </td>\n\ '+    
    '     <td class="TDTitulo">\n\ '+
    '         Serviço\n\ '+
    '     </td>\n\ '+
    '     <td class="TDTitulo">\n\ '+
    '         Funcionário\n\ '+
    '     </td>\n\ '+
    '     <td class="TDTitulo">\n\ '+
    '         Valor\n\ '+
    '     </td>\n\ '+
    '     <td class="TDTitulo">\n\ '+
    '         Desconto\n\ '+
    '     </td>\n\ '+
    '     <td class="TDTitulo">\n\ '+
    '         Valor Com Desconto\n\ '+
    '     </td>\n\ '+
    '     <td align="right" class="TDTitulo">\n\ '+
    '         Porcentagem\n\ '+
    '     </td>\n\ '+
    ' </tr>\n\ ';    
    for(var i=0;i<data[1].length;i++){        
        if (corLinha === 'white'){
            corLinha = '#E8E8E8';
        }else{
            corLinha = 'white';
        }
        codVenda = data[1][i].COD_VENDA;
        linha = linha+'<tr bgcolor="'+corLinha+'" class="trcor">'+
            ' <td>'+data[1][i].COD_VENDA+'</td>'+
            ' <td id="dtaVenda">'+data[1][i].DSC_PRODUTO+'</td>'+
            ' <td>'+data[1][i].NME_FUNCIONARIO+'</td>'+
            ' <td id="dscCliente" align="right">'+data[1][i].VLR_VENDA_TOTAL+'</td>'+
            ' <td id="dscCliente" align="right">'+data[1][i].VLR_DESCONTO+'</td>'+
            ' <td id="dscCliente" align="right">'+data[1][i].VLR_VENDA_TOTAL_COM_DESCONTO+'</td>'+
            ' <td align="right" id="dscVeiculo">'+Formata(data[1][i].VLR_PORCENTAGEM_VENDA,2,',','.')+'</td>'+
        ' </tr>';
        vlrTotal = parseFloat(vlrTotal)+parseFloat(data[1][i].VLR_PORCENTAGEM_VENDA);
        vlrTotalVendas = parseFloat(vlrTotalVendas)+parseFloat(data[1][i].VLR_VENDA_TOTAL);
        vlrTotalVendasComDesconto = parseFloat(vlrTotalVendasComDesconto)+parseFloat(data[1][i].VLR_VENDA_TOTAL);
    }
    linha = linha + ' <tr> '+
            ' <td colspan="4" align="right"><b>Total de vendas:</b> R$ '+Formata(vlrTotalVendas,2,',','.')+'</td>'+            
            ' <td colspan="2" align="right"><b>Total com desconto:</b> R$ '+Formata(vlrTotalVendasComDesconto,2,',','.')+'</td>'+                
            ' <td align="right"><b>Total de comissões:</b> R$ '+Formata(vlrTotal,2,',','.')+'</td>'+
            ' </tr>'+
    ' </table></td></tr></table>';
    //var tmp = window.open('http://siscove.webhop.net', 'popimpr');
    //tmp.document.write('Relatório de comissão de funcionários');
    //tmp.document.write(linha);
    //tmp.window.print();
    //tmp.window.close();            
    $("#conteudo").html(linha);    
}