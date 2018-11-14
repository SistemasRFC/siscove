$(function() {
    $( "#dtaVendaInicio" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaVendaFim" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});                
    $("#btnPesquisa").click(function(){
        $("#conteudo").html("<img src='../../Resources/images/carregando.gif'>");
        $.post('../../Controller/Relatorios/RelatoriosClientesVendasController.php', {
            method: 'QtdVendasPorCliente',
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
    $("#conteudo").html('');
    linha = '<table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="1"  style="border: 1px solid #000000;">';
    total = data.length;
    corLinha = 'white';
    linha = linha+'<tr>'+
                ' <td class="TDTitulo"> Cliente </td>\n\ '+
                ' <td class="TDTitulo"> Data da Venda </td>\n\ '+
                ' <td class="TDTitulo"> Qtd de Vendas </td>'+
                '</tr> ';
    for(var i=0;i<total;i++){
            if (corLinha === 'white'){
                corLinha = '#E8E8E8';
            }else{
                corLinha = 'white';
            }

        linha = linha+'<tr bgcolor="'+corLinha+'" class="trcor">'+
            ' <td>'+data[i].dscCliente+'</td>'+
            ' <td>'+data[i].dtaUltimaVenda+'</td>'+
            ' <td>'+data[i].qtdVendas+'</td>'+
            ' </tr>';
    }
    linha = linha+'</table>';
    $("#conteudo").html(linha);
}