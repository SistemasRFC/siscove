$(function() {
    $( "#dtaMovimentacaoInicio" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaMovimentacaoFim" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    $( "#dtaMovimentacaoInicio" ).jqxDateTimeInput("clear");
    $( "#dtaMovimentacaoFim" ).jqxDateTimeInput("clear");
    $( "#indCondicaoNovo" ).jqxCheckBox({ width: 120, height: 25 });
    $( "#indCondicaoSeminovo" ).jqxCheckBox({ width: 120, height: 25 });    
    $("#btnPesquisa").click(function(){
        var pesquisa = $("#dscProduto").val();
        pesquisa = pesquisa.trim();
            if (pesquisa.length>0 && pesquisa.length<3){
                $( "#dialogInformacao" ).jqxWindow('setContent', "Digite pelo menos 3 letras!");
                $( "#dialogInformacao" ).jqxWindow("open");      
                return;
            }
        if ($( "#dtaMovimentacaoInicio" ).val() == '' && $( "#dtaMovimentacaoFim" ).val() == '' && $("#dscProduto").val() == '' && $( "#indCondicaoNovo" ).val() == '' &&$( "#indCondicaoSeminovo" ).val() == ''){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Preencha pelo menos um campo!");
            $( "#dialogInformacao" ).jqxWindow("open");      
            return;
        }
        $( "#dialogInformacao" ).jqxWindow('setContent','Aguarde!');
        $( "#dialogInformacao" ).jqxWindow('open');        
        $("#conteudo").html("<img src='../../Resources/images/carregando.gif'>");
        $.post('../../Controller/Relatorios/RelatoriosEstoqueController.php', {
            method: 'ListarHistoricoEstoque',
            dtaMovimentacaoInicio: $("#dtaMovimentacaoInicio").val(),
            dtaMovimentacaoFim: $("#dtaMovimentacaoFim").val(),
            dscProduto: $("#dscProduto").val(),
            indCondicaoNovo: $("#indCondicaoNovo").val(),
            indCondicaoSeminovo: $("#indCondicaoSeminovo").val(),
            codFuncionario: $("#codFuncionario").val()}, function(data){
            data = eval('('+data+')');

            if (data[0]){
                if (data[1]!=null){
                    MontaTabela(data[1]);
                    $( "#dialogInformacao" ).jqxWindow('close');
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setContent','Sem Dados para esta consulta!');
                }
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent','Erro ao efetuar a busca dos registros!');
            }
        });        
    });
});

function MontaTabela(data){
    $("#conteudo").html('');
    linha = '<table width="90%" class="TabelaConteudo" cellpadding="0" cellspacing="2" align="center">'+
        ' <tr>'+
        '     <td width="10%" class="TDTitulo">'+
        '         Data da Movimentação'+
        '     </td>'+
        '     <td width="10%" class="TDTitulo">'+
        '         Tipo da Movimentação'+
        '     </td>'+
        '     <td width="10%" class="TDTitulo">'+
        '         Cod.Movimentação'+
        '     </td>'+
        '     <td width="8%" class="TDTitulo">'+
        '         Cod.Produto'+
        '     </td>'+
        '     <td width="25%" class="TDTitulo">'+
        '         Produto'+
        '     </td>'+
        '     <td width="8%" class="TDTitulo">'+
        '         Marca'+
        '     </td>'+
        '     <td width="8%" class="TDTitulo">'+
        '         Tipo'+
        '     </td>'+
        '     <td width="8%" align="right" class="TDTitulo">'+
        '         Qtd. da Movimentação'+
        '     </td>'+
        ' </tr>';
    total = data.length;
    vlrTotal = 0;
    corLinha = '#E8E8E8';
    for(var i=0;i<total;i++){
        if (corLinha == 'white'){
            corLinha = '#E8E8E8';
        }else{
            corLinha = 'white';
        }
        linha = linha+'<tr bgcolor="'+corLinha+'" class="trcor">'+
            ' <td >'+data[i].DTA_MOVIMENTACAO+'</td>'+
            ' <td >'+data[i].TPO_MOVIMENTACAO+'</td>'+
            ' <td >'+data[i].COD_MOVIMENTACAO+'</td>'+
            ' <td >'+data[i].COD_PRODUTO+'</td>'+
            ' <td >'+data[i].DSC_PRODUTO+'</td>'+
            ' <td >'+data[i].DSC_MARCA+'</td>'+
            ' <td >'+data[i].IND_TIPO_PRODUTO+'</td>'+
            ' <td align="right" >'+data[i].QTD_MOVIMENTACAO+'</td>'+
        ' </tr>';
    }
    linha += ' </table>';
    $("#conteudo").html(linha);
}