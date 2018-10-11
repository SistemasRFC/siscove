$(function() {
    $( "#dtaVendaInicio" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaVendaFim" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});                
    $("#btnPesquisa").click(function(){
        $("#conteudo").html("<img src='../../Resources/images/carregando.gif'>");
        $.post('../../Controller/Relatorios/RelatoriosVendasController.php', {
            method: 'VendasFechadas',
            dtaVendaInicio: $("#dtaVendaInicio").val(),
            dtaVendaFim: $("#dtaVendaFim").val()}, function(data){
            data = eval('('+data+')');

            if (data!=null){
                carregaTabela(data);
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao efetuar abertura do caixa!');
                $( "#dialogInformacao" ).jqxWindow( "open" );
            }
        });
    });    
});
function carregaTabela(data){
    $("#conteudo").html('');
    linha = '<table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="0"  style="border: 1px solid #000000;">';
    corLinha = 'white';
    primeira = true;
    vlrTotalVenda=0;
    
    for(var i=0;i<data.length-1;i++){
        dadosVenda = data[i].VENDAS;
        dadosPagamento = data[i].PAGAMENTOS;
        if (corLinha == 'white'){
            corLinha = '#E8E8E8';
        }else{
            corLinha = 'white';
        }
        linha += '<tr><td colspan="8"><br></td></tr>';
        linha += '<tr>';
        linha += '<td><table width="100%"  style="border: 1px solid #000000;">\n ';
        linha += ' <tr bgcolor="'+corLinha+'" width="10%"><td class="TDTitulo">Código da Venda </td>\n ';
        linha += ' <td class="TDTitulo" width="10%">Data da Venda </td>\n ';
        linha += ' <td class="TDTitulo" width="20%">Cliente </td>\n ';
        linha += ' <td class="TDTitulo" width="20%">Veículo </td>\n ';
        linha += ' <td class="TDTitulo" width="25%">Vendedor </td>\n ';
        linha += ' <td align="right" class="TDTitulo" width="5%">Valor </td>';
        linha += ' <td class="TDTitulo" width="5%">&nbsp</td>\n ';
        linha += ' <td class="TDTitulo" width="5%">&nbsp</td></tr> ';
        linha += '<tr class="trcor">'+
            ' <td>'+dadosVenda.COD_VENDA+'</td>'+
            ' <td>'+dadosVenda.DTA_VENDA+'</td>'+
            ' <td>'+dadosVenda.DSC_CLIENTE+'</td>'+
            ' <td>'+dadosVenda.DSC_VEICULO+'</td>'+
            ' <td>'+dadosVenda.NME_USUARIO_COMPLETO+'</td>'+
            ' <td align="right">'+dadosVenda.VLR_VENDA+'</td>'+
            " <td><a href=\"javascript:java('../../Controller/Relatorios/RelatoriosVendasController.php?codVenda="+dadosVenda.COD_VENDA+"&method=ResumoVenda');\">"+
                      "<img src=\"../../Resources/images/import.png\" width=\"20\" height=\"20\" title=\"Visualizar esta venda\"></a></td>"+
            " <td><a href=\"javascript:ReabrirVenda("+dadosVenda.COD_VENDA+");\">"+
                                        "<img src=\"../../Resources/images/edit.png\" width=\"20\" height=\"20\" title=\"Reabrir esta venda\"></a></td>"+
        ' </tr>';
        linha += '<tr><td colspan="8"><table width="70%">';
        linha += '<tr bgcolor="'+corLinha+'">';
        linha += '<td class="TDTitulo">Tipo de Pagamento</td>';
        linha += '<td align="right" class="TDTitulo">Valor do Pagamento Bruto</td>';
        linha += '<td align="right" class="TDTitulo">Valor do Pagamento Liquido</td>';
        linha += '</tr>';
        for (var j=0; j<dadosPagamento.length; j++){
            linha += '<tr>';
            linha += '<td>'+dadosPagamento[j].DSC_TIPO_PAGAMENTO+'</td>';
            linha += '<td align="right">'+dadosPagamento[j].VLR_PAGAMENTO+'</td>';
            linha += '<td align="right">'+dadosPagamento[j].VLR_PAGAMENTO_LIQUIDO+'</td>';
            linha += '</tr>';            
        }
        linha += '</table></td></tr></table></td></tr>';
        valor = dadosVenda.VLR_VENDA;
        valor = valor.replace(',','');
        vlrTotalVenda = parseFloat(vlrTotalVenda)+parseFloat(valor);
    }
//    linha = linha+'<table width="100%" style="border: 1px solid #000000"><tr bgcolor="'+corLinha+'" class="trcor">'+
//                        ' <tr> '+
//                        ' <td align="right">Total das Vendas'+
//                        ' '+Formata(vlrTotalVenda,2,'.',',')+'</td>'+
//                        ' </tr>'+
//                        ' </tr></table>'+
//                        '</td></tr></table>';
    var dadosTotal = data[data.length-1].TOTAL_PAGAMENTOS;
    linha += '<table  style="border: 1px solid #000000;" align="center">';
    linha += '<tr bgcolor="'+corLinha+'">';
    linha += '<td colspan="4" class="TDTitulo" align="center">Total de Pagamentos por Tipo</td></tr>';
    linha += '<tr>';
    linha += '<td class="TDTitulo">Total em</td>';
    linha += '<td class="TDTitulo">Valor Bruto</td>';
    linha += '<td class="TDTitulo">Valor Percentual Descontado</td>';
    linha += '<td class="TDTitulo">Valor Líquido</td>';
    linha += '</tr>';
    var vlrTotalVendaBruto=0;
    var vlrTotalVendaLiquido=0;
    corLinha = 'white';
    for (var i=0; i<dadosTotal.length; i++){
        if (corLinha == '#E8E8E8'){
            corLinha = 'white';
        }else{
            corLinha = '#E8E8E8';
        }        
        linha += '<tr bgcolor="'+corLinha+'">';
        linha += '<td>'+dadosTotal[i].DSC_TIPO_PAGAMENTO+'</td>';
        linha += '<td align="right">'+dadosTotal[i].VLR_PAGAMENTO_BRUTO+'</td>';
        linha += '<td align="right">'+dadosTotal[i].VLR_PORCENTAGEM+'</td>';
        linha += '<td align="right">'+dadosTotal[i].VLR_PAGAMENTO_LIQUIDO+'</td>';
        linha += '</tr>';
        valorBruto = dadosTotal[i].VLR_PAGAMENTO_BRUTO;
        valorBruto = valorBruto.replace('.','');
        valorBruto = valorBruto.replace(',','.');
        vlrTotalVendaBruto = parseFloat(vlrTotalVendaBruto)+parseFloat(valorBruto);   
        valorLiquido = dadosTotal[i].VLR_PAGAMENTO_LIQUIDO;
        valorLiquido = valorLiquido.replace('.','');
        valorLiquido = valorLiquido.replace(',','.');
        vlrTotalVendaLiquido = parseFloat(vlrTotalVendaLiquido)+parseFloat(valorLiquido);          
    }
    linha += '<tr>';
    linha += '<td class="TDTitulo">Total Geral</td>';
    linha += '<td class="TDTitulo" align="right">'+Formata(vlrTotalVendaBruto,2,'.',',')+'</td>';
    linha += '<td class="TDTitulo" align="right">-</td>';
    linha += '<td class="TDTitulo" align="right">'+Formata(vlrTotalVendaLiquido,2,'.',',')+'</td>';
    linha += '</tr>';    
    linha += '</table>';
    $("#conteudo").html(linha);
}
function ReabrirVenda(codVenda){    
    $.post('../../Controller/Vendas/VendasController.php',
          {method:'ReabrirVenda',
           codVenda: codVenda}, function(data){
                data = eval('('+data+')'); 
                if(data[0]){
                    $( "#dialogInformacao" ).jqxWindow('setContent', 'Venda reaberta com sucesso!');
                    $( "#dialogInformacao" ).jqxWindow('open');
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setContent', data[1]);   
                    $( "#dialogInformacao" ).jqxWindow('open');
                }
           }
    );
}
function CancelarNota(codVenda){
    $.post('../../Controller/Nfe/NfeController.php',
        {
            method:'CancelarNota',
            codVenda: codVenda}, function(data){
                data = eval('('+data+')'); 
                if(data[0]){
                    ReabrirVenda(codVenda);
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setContent', data[1]);   
                    $( "#dialogInformacao" ).jqxWindow('open');
                }
           }
    );    
}

function FecharDialog(){
    $( "#dialogInformacao" ).jqxWindow('close');
}

function java(dochtml) {
var left=(window.screen.width/2)-(1000/2);
var top = ((window.screen.height/2)-50)-(700/2);
	if(navigator.appName == "Netscape") {
		var sec = window.open(dochtml,'','scrollbars=yes,toolbars=no,status=no,menubar=no,resizable=yes,height=700,width=1000,top='+top+',left='+left);
		sec.focus();
	}
	else {
		var new_window = window.open(dochtml,'','resizable=yes,width=1000,height=700, left='+ left +', top='+ top +',toolbars=no,menubar=no,status=no,scrollbars=1');
		new_window.focus;
	}
}