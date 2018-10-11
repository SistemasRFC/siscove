$(function() {
    $("#btnPesquisar").click(function(){
        $("#Lista").html('Pesquisando');
        $.post('../../Controller/Relatorios/RelatoriosEstoqueController.php',
            {method: 'ListarEstoqueProduto',
            codTipoProduto: $("#codTipoProduto").val()}, function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabela(data[1]);
            }else{
                $("#tabela").html('Sem dados para a pesquisa');
            }
        });
    });
});

function MontaTabela(data){
    listaEstoque = data;
    tabela  = '<tr>';
    tabela += '  <td class="TDTitulo">Descrição</td>';
    tabela += '  <td class="TDTitulo">Marca</td>';
    tabela += '  <td class="TDTitulo">Qtd em estoque</td>';
    tabela += ' <td class="TDTitulo" align="right">Valor mínimo de venda</td>';
    tabela += ' <td class="TDTitulo" align="right">Valor de venda</td>';
    tabela += '</tr>';
    corLinha = 'white';
    for(i=0;i<listaEstoque.length;i++){
        if (corLinha == 'white'){
            corLinha = '#E8E8E8';
        }else{
            corLinha = 'white';
        }
        tabela += ' <tr bgcolor="'+corLinha+'" class="trcor">';
        tabela += '    <td>'+listaEstoque[i].DSC_PRODUTO+'</td>';
        tabela += '    <td>'+listaEstoque[i].DSC_MARCA+'</td>';
        tabela += '    <td>'+listaEstoque[i].QTD_ESTOQUE+'</td>';
        tabela += '    <td align="right">R$ '+listaEstoque[i].VLR_MINIMO+'</td>';
        tabela += '    <td align="right">R$ '+listaEstoque[i].VLR_PRODUTO+'</td>';
        tabela += ' </tr>';
    }
    $("#tabela").html(tabela);
}

$(document).ready(function(){
    CriarCombo('codTipoProduto', 
               '../../Controller/TipoProduto/TipoProdutoController.php', 
               'ListarTipoProdutosAtivos', 
               'COD_TIPO_PRODUTO|DSC_TIPO_PRODUTO', 
               'DSC_TIPO_PRODUTO', 
               'COD_TIPO_PRODUTO');
});