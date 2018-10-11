$(function() {
    $( "#dialogInformacao" ).dialog({
            autoOpen: false,
            width: 450,
            show: 'explode',
            hide: 'explode',
            title: 'Mensagem',
            modal: true,
            buttons: [
                    {
                            text: "Ok",
                            id: "btnOK",
                            click: function() {
                                    $( this ).dialog( "close" );
                            }
                    }
            ]
    });
    $( "#dtaVendaInicio" ).datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });
    $( "#dtaVendaFim" ).datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });

    $( "#CadastroForm" ).dialog({
        autoOpen: true,
        width: 1000,
        height: 600,
        title: 'Relatório de vendas justificadas',
        buttons: [
                {
                    text: "Ok",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
        ],
        close: function() { window.location='../../Controller/MenuPrincipal/MenuPrincipalController.php?method=CarregaMenu'; }
    });
    $("#btnPesquisa").click(function(){
        $("#conteudo").html("<img src='../../Resources/images/carregando.gif'>");
        $.post('../../Controller/Relatorios/RelatoriosVendasController.php', {
            method: 'VendasJustificadas',
            dtaVendaInicio: $("#dtaVendaInicio").val(),
            dtaVendaFim: $("#dtaVendaFim").val()}, function(data){
            data = eval('('+data+')');

            if (data!=null){
                carregaTabela(data);
            }else{
                $( "#dialogInformacao" ).html('Erro ao efetuar abertura do caixa!');
                $( "#dialogInformacao" ).dialog( "open" );
            }
        });
    });    
});
function ReabrirVenda(codVenda){
    $( "#dialogInformacao" ).html('Aguarde Reabrindo a venda');
    $("#btnOK").hide();
    $( "#dialogInformacao" ).dialog( "open" );
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
    linha = '<table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="0"  style="border: 1px solid #000000;">';
    total = data.length;
    vlrTotal = 0;
    corLinha = 'white';
    primeira = true;
    linha = linha+'<tr>'+
                '<td><table width="100%">\n\ '+
                ' <tr><td>Código da Venda </td>\n\ '+
                ' <td>Data da Venda </td>\n\ '+
                ' <td>Cliente </td>\n\ '+
                ' <td>Veículo </td>\n\ '+
                ' <td>Vendedor </td>\n\ '+
                ' <td align="right">Valor </td>'+
                ' <td>&nbsp;</td></tr>\n\ ';
    for(var i=0;i<total;i++){
            if (corLinha == 'white'){
                corLinha = '#E8E8E8';
            }else{
                corLinha = 'white';
            }

        linha = linha+'<tr bgcolor="'+corLinha+'" class="trcor" title="'+data[i].txtJustificativa+'">'+
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
        valor = data[i].vlrTotal
        valor = valor.replace(',','');
        vlrTotalVenda = parseFloat(vlrTotalVenda)+parseFloat(valor);
    }
    linha = linha+'</table><table width="100%" style="border: 1px solid #000000"><tr bgcolor="'+corLinha+'" class="trcor">'+
                        ' <tr> '+
                        ' <td align="right">Total das Vendas'+
                        ' '+Formata(vlrTotalVenda,2,'.',',')+'</td>'+
                        ' </tr>'+
                        ' </tr></table>'+
                        '</td></tr></table>';
    $("#conteudo").html(linha);
}