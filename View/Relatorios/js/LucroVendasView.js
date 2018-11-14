$(function() {
    $( "#dtaVendaInicio" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaVendaFim" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});                
    $("#btnPesquisa").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', 'Aguarde, Carregando!');
        $( "#dialogInformacao" ).jqxWindow( "open" );        
        $.post('../../Controller/Relatorios/LucroVendasController.php', {
            method: 'DadosComissao',
            dtaVendaInicio: $("#dtaVendaInicio").val(),
            dtaVendaFim: $("#dtaVendaFim").val()}, function(datai){
            data = eval('('+datai+')');            
            if (data!=null){
                codVenda=0;
                $("#conteudo").html('');
                linha = '<table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="0" >';                
                corLinha = 'white';   
                primeira = true;
                for(var i=0;i<Object.keys(data).length-1;i++){                    
                    if (codVenda!=data[i].COD_VENDA){
                        if (corLinha == 'white'){
                            corLinha = '#E8E8E8';
                        }else{
                            corLinha = 'white';
                        }
                        if (!primeira){
                            linha = linha+'</table></td></tr>';
                            linha = linha+'<tr><td><table width="100%" style="border: 1px solid #000000"><tr bgcolor="'+corLinha+'" class="trcor">'+
                                                ' <tr> '+
                                                ' <td align="right">Lucro da Venda'+
                                                ' '+data[i-1].VLR_LUCRO_VENDA+' Porcentagem da Venda: '+data[i-1].VLR_PORCENTAGEM_LUCRO_VENDA+'%</td>'+
                                                ' </tr>'+
                                                ' </tr>';                              
                            linha = linha+' <tr> '+
                                    ' <td align="right">Total da Venda'+
                                    ' '+data[i-1].VLR_TOTAL_VENDA+'</td>'+
                                    ' </tr>'+
                                    ' </tr></table></td></tr>';                        
                        }else{
                            primeira = false;
                        }
                        linha = linha+'<tr class="trcor">'+
                            '<td>\n\ '+
                            '<table width="100%" style="border: 1px solid #000000;">\n\ '+
                            ' <tr><td id="dtaVenda">C&oacute;digo da Venda: '+data[i].COD_VENDA+'</td></tr>\n\ '+
                            ' <tr><td id="dtaVenda">Data da Venda: '+data[i].DTA_VENDA+'</td></tr>\n\ '+
                            ' <tr><td id="dscCliente">Cliente: '+data[i].DSC_CLIENTE+'</td></tr>\n\ '+
                            ' <tr><td id="dscVeiculo">Ve&iacute;culo: '+data[i].DSC_VEICULO+'</td></tr>\n\ '+
                            ' <tr><td id="nmeFuncionario">Vendedor: '+data[i].NME_VENDEDOR+'</td></tr>\n\ '+
                            ' <tr><td id="nmeFuncionario">Comiss&atilde;o do Vendedor: '+data[i].VLR_COMISSAO_VENDEDOR+'</td></tr>\n\ '+
                            ' <tr><td id="nmeFuncionario">Porcentagem Pagamento: '+data[i].VLR_PORCENTAGEM_PAGAMENTO+'</td></tr>\n\ '+
                            ' <tr><td id="nmeFuncionario"><input type="button" value="Reabrir Venda" onclick="javascript:ReabrirVenda('+data[i].COD_VENDA+');"></td></tr>\n\ '+
                        ' <tr>\n\ '+
                        '     <td class="TDTitulo">\n\ '+
                        '         Funcion&aacute;rio\n\ '+
                        '     </td>\n\ '+                        
                        '     <td class="TDTitulo">\n\ '+
                        '         Produto\n\ '+
                        '     </td>\n\ '+
                        '     <td class="TDTitulo">\n\ '+
                        '         Marca\n\ '+
                        '     </td>\n\ '+
                        '     <td class="TDTitulo">\n\ '+
                        '         Valor Custo\n\ '+
                        '     </td>\n\ '+
                        '     <td class="TDTitulo">\n\ '+
                        '         Valor Comiss&atilde;o\n\ '+
                        '     </td>\n\ '+
                        '     <td class="TDTitulo">\n\ '+
                        '         Valor Imposto\n\ '+
                        '     </td>\n\ '+
                        '     <td class="TDTitulo">\n\ '+
                        '         Valor de Venda\n\ '+
                        '     </td>\n\ '+
                        '     <td class="TDTitulo">\n\ '+
                        '         Desconto\n\ '+
                        '     </td>\n\ '+
                        '     <td class="TDTitulo">\n\ '+
                        '         Valor com desconto\n\ '+
                        '     </td>\n\ '+
                        '     <td align="right" class="TDTitulo">\n\ '+
                        '         Lucro Unit&aacute;rio\n\ '+
                        '     </td>\n\ '+
                        '     <td align="right" class="TDTitulo">\n\ '+
                        '         Qtd\n\ '+
                        '     </td>\n\ '+
                        '     <td align="right" class="TDTitulo">\n\ '+
                        '         Total Venda\n\ '+
                        '     </td>\n\ '+
                        ' </tr>\n\ ';
                        vlrPorcentagemPagamento = data[i].VLR_PORCENTAGEM_PAGAMENTO;
                    }

                    codVenda = data[i].COD_VENDA;
                    linha = linha+'<tr bgcolor="'+corLinha+'" class="trcor">'+
                        ' <td id="dtaVenda">'+data[i].NME_FUNCIONARIO+'</td>'+
                        ' <td id="dtaVenda">'+data[i].DSC_PRODUTO+'</td>'+
                        ' <td id="dtaVenda">'+data[i].DSC_MARCA+'</td>'+
                        ' <td>'+data[i].VLR_CUSTO+'</td>'+
                        ' <td>'+data[i].VLR_COMISSAO_FUNCIONARIO+'</td>'+
                        ' <td>'+data[i].VLR_IMPOSTO_CALCULADO+'</td>'+                        
                        ' <td id="dscCliente">'+data[i].VLR_VENDA+'</td>'+
                        ' <td id="dscCliente">'+data[i].VLR_DESCONTO+'</td>'+
                        ' <td id="dscCliente">'+data[i].VLR_COM_DESCONTO+'</td>'+
                        ' <td align="right" id="dscVeiculo">'+data[i].VLR_LUCRO_UNITARIO+'</td>'+
                        ' <td align="right" id="dscVeiculo">'+data[i].QTD_VENDIDA+'</td>'+                        
                        ' <td align="right" id="dscVeiculo">'+data[i].VLR_VENDA_PRODUTO+'</td>'+
                    ' </tr>';

                }  
                linha = linha+'</table></td></tr>';
                linha = linha+'<tr><td><table width="100%" style="border: 1px solid #000000"><tr bgcolor="'+corLinha+'" class="trcor">'+
                                    ' <tr> '+
                                    ' <td align="right">Lucro da Venda'+
                                    ' '+data[Object.keys(data).length-2].VLR_LUCRO_VENDA+' Porcentagem da Venda: '+data[Object.keys(data).length-2].VLR_PORCENTAGEM_LUCRO_VENDA+'%</td>'+
                                    ' </tr>'+
                                    ' </tr>';                              
                linha = linha+' <tr> '+
                        ' <td align="right">Total da Venda'+
                        ' '+data[Object.keys(data).length-2].VLR_TOTAL_VENDA+'</td>'+
                        ' </tr>'+
                        ' </tr></table></td></tr>';                  
                linha = linha + ' <tr> '+
                        ' <td align="right" colspan="13">Lucro total'+
                        ' '+data[Object.keys(data).length-1].VLR_LUCRO_TOTAL+' Porcentagem das Vendas: '+data[Object.keys(data).length-1].VLR_PORCENTAGEM_LUCRO_TOTAL+'%</td>'+
                        ' </tr>';                            
                linha = linha + ' <tr> '+
                        ' <td align="right" colspan="13">Total'+
                        ' '+data[Object.keys(data).length-1].VLR_TOTAL+'</td>'+
                        ' </tr>'+
                ' </table></td></tr></table>';
                $("#conteudo").html(linha);
                $( "#dialogInformacao" ).jqxWindow( "close" );
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao efetuar abertura do caixa!');
                $( "#dialogInformacao" ).jqxWindow( "open" );
            }
        });
    })
});

function ReabrirVenda(codVenda){    
    $("#btnOK").hide();    
    $.post('../../Controller/Vendas/VendasController.php',
          {method:'ReabrirVenda',
           codVenda: codVenda}, function(data){

                if(data==1){
                    $("#btnPesquisa").click();
                    $( "#dialogInformacao" ).html('Venda reaberta com sucesso!');
                    $("#btnOK").show();
                }else{
                    $( "#dialogInformacao" ).html('Erro ao reabrir venda!');
                    $("#btnOK").show();
                }
           }
    );
}