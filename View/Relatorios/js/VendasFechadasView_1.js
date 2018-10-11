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
        linha = linha+'<tr>'+
                '<td><table width="100%"  style="border: 1px solid #000000;">\n\ '+
                ' <tr><td>Código da Venda </td>\n\ '+
                ' <td>Data da Venda </td>\n\ '+
                ' <td>Cliente </td>\n\ '+
                ' <td>Veículo </td>\n\ '+
                ' <td>Vendedor </td>\n\ '+
                ' <td align="right">Valor </td>'+
                ' <td>&nbsp;</td></tr>\n\ ';
        linha = linha+'<tr bgcolor="'+corLinha+'" class="trcor">'+
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
        linha += '<tr>';
        linha += '<td>Tipo de Pagamento</td>';
        linha += '<td>Data do Pagamento</td>';
        linha += '<td>Valor do Pagamento Bruto</td>';
        linha += '<td>Valor do Pagamento Liquido</td>';
        linha += '</tr>';
        for (var j=0; j<dadosPagamento.length; j++){
            linha += '<tr>';
            linha += '<td>'+dadosPagamento[j].DSC_TIPO_PAGAMENTO+'</td>';
            linha += '<td>'+dadosPagamento[j].DTA_PAGAMENTO+'</td>';
            linha += '<td>'+dadosPagamento[j].VLR_PAGAMENTO+'</td>';
            linha += '<td>'+dadosPagamento[j].VLR_PAGAMENTO_LIQUIDO+'</td>';
            linha += '</tr>';            
        }
        linha += '</table></td></tr>';
        valor = dadosVenda.VLR_VENDA;
        valor = valor.replace(',','');
        vlrTotalVenda = parseFloat(vlrTotalVenda)+parseFloat(valor);
    }
    linha = linha+'<table width="100%" style="border: 1px solid #000000"><tr bgcolor="'+corLinha+'" class="trcor">'+
                        ' <tr> '+
                        ' <td align="right">Total das Vendas'+
                        ' '+Formata(vlrTotalVenda,2,'.',',')+'</td>'+
                        ' </tr>'+
                        ' </tr></table>'+
                        '</td></tr></table>';
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