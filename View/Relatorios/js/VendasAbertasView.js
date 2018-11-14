$(function() {
    $( "#dtaVendaInicio" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaVendaFim" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});                
    $("#btnPesquisa").click(function(){
        $("#conteudo").html("<img src='../../Resources/images/carregando.gif'>");
        $.post('../../Controller/Relatorios/RelatoriosVendasController.php', {
            method: 'VendasAbertas',
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
function ReabrirVenda(codVenda){
    $( "#dialogInformacao" ).jqxWindow('setContent', 'Aguarde Reabrindo a venda!');
    $( "#dialogInformacao" ).jqxWindow( "open" );        
    $("#btnOK").hide();    
    $.post('../../Controller/Vendas/VendasController.php',
          {method:'ReabrirVenda',
           codVenda: codVenda}, function(data){

                if(data==1){
                    $("#btnPesquisa").click();
                    $( "#dialogInformacao" ).jqxWindow('setContent', 'Venda reaberta com sucesso!');
                    $("#btnOK").show();
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao reabrir venda!');
                    $("#btnOK").show();
                }
           }
    );
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
function carregaTabela(data){
    codVenda=0;
    vlrTotalVenda =0;
    $("#conteudo").html('');
    linha = '<table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="2" style="border: 1px solid #000000;">';
    total = data.length;
    vlrTotal = 0;
    corLinha = 'white';
    primeira = true;
    linha = linha+'<tr>'+
                ' <td class="TDTitulo"> Código da Venda </td>\n\ '+
                ' <td class="TDTitulo"> Data da Venda </td>\n\ '+
                ' <td class="TDTitulo"> Cliente </td>\n\ '+
                ' <td class="TDTitulo"> Veículo </td>\n\ '+
                ' <td class="TDTitulo"> Vendedor </td>\n\ '+
                ' <td align="right" class="TDTitulo"> Valor </td>\n\ '+
                ' <td>&nbsp;</td>\n\ '+
                '</tr> ';
    for(var i=0;i<total;i++){
            if (corLinha === 'white'){
                corLinha = '#E8E8E8';
            }else{
                corLinha = 'white';
            }

        linha = linha+'<tr bgcolor="'+corLinha+'" class="trcor">'+
            ' <td>'+data[i].codVenda+'</td>'+
            ' <td>'+data[i].dtaVenda+'</td>'+
            ' <td>'+data[i].dscCliente+'</td>'+
            ' <td>'+data[i].dscVeiculo+'</td>'+
            ' <td>'+data[i].nmeVendedor+'</td>'+
            ' <td align="right">'+data[i].vlrTotal+'</td>'+
            " <td><a href=\"javascript:java('../../Controller/Relatorios/RelatoriosVendasController.php?codVenda="+data[i].codVenda+"&method=ResumoVenda');\">"+
                      "<img src=\"../../Resources/images/import.png\" width=\"20\" height=\"20\" title=\"Visualizar esta venda\"></a></td>"+
            " <td><a href=\"javascript:ReabrirVenda("+data[i].codVenda+");\">"+
                                        "<img src=\"../../Resources/images/edit.png\" width=\"20\" height=\"20\" title=\"Reabrir esta venda\"></a></td>"+
        ' </tr>';
        valor = data[i].vlrTotal;
        valor = valor.replace(',','');
        vlrTotalVenda = parseFloat(vlrTotalVenda)+parseFloat(valor);
    }
    linha += "<tr><td align='right' colspan='8'>Total das Vendas: R$ "+Formata(vlrTotalVenda,2,'.',',')+"</td></tr>";
    linha += "</table>";
    $("#conteudo").html(linha);
}