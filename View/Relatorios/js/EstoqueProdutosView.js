$(function() {
    $( "#CondicaoNovo" ).jqxCheckBox({ width: 120, height: 25 });
    $( "#CondicaoSeminovo" ).jqxCheckBox({ width: 120, height: 25 });
    $("#btnPesquisar").click(function(){
        $("#Lista").html('<b>Sem dados para essa consulta</b>');
        $.post('../../Controller/Relatorios/RelatoriosEstoqueController.php',
            {method: 'ListarEstoque',
            codTipoProduto: $("#codTipoProduto").val(),
            CondicaoNovo: $("#CondicaoNovo").val(),
            CondicaoSeminovo: $("#CondicaoSeminovo").val()}, function(data){

            data = eval('('+data+')');
            if (data[0].listaEstoque != null){
                MontaTabela(data);
            }else{
                $("#Lista").html('Sem dados para a pesquisa');
            }
        });
    });
});
function mostraTR(codtr){
    if (codtr!=$("#tr").val()){
        $(".esconde").hide();
        $(".imagem").attr('src','../../Resources/images/plus.png');
        $("#tr").val(codtr);
    }
    if (document.getElementById(codtr).style.display == "none"){
        $("#"+codtr).show('slow');
        $("#imagem"+codtr).attr('src', '../../Resources/images/minus.png');
    }else{
        $("#"+codtr).hide('slow');
        $("#imagem"+codtr).attr('src', '../../Resources/images/plus.png');
    }
}

function MontaTabela(data){    
    listaEstoque = data[0].listaEstoque[1];
    listaEntradasEstoque = data[0].listaEntradasEstoque[1];
    console.log(listaEstoque.length);
    tabela = '<table width="50%" align="center" class="TabelaConteudo" cellpadding="0" cellspacing="2">';
    tabela += '            <tr>';
    tabela += '      <td>';
    tabela += '         &nbsp;';
    tabela += '     </td>';
    tabela += '     <td class="TDTitulo">';
    tabela += '         Produto';
    tabela += '     </td>';
    tabela += '     <td class="TDTitulo">';
    tabela += '         Fornecedor';
    tabela += '     </td>';
    tabela += '     <td class="TDTitulo">';
    tabela += '         Marca';
    tabela += '     </td>';
    tabela += '     <td class="TDTitulo">';
    tabela += '         Tipo';
    tabela += '     </td>';
    tabela += '     <td class="TDTitulo">';
    tabela += '         Total Estoque';
    tabela += '     </td>';
    tabela += ' </tr>';

    corLinha = "white";
    for(i=0;i<listaEstoque.length;i++){
        if ( corLinha == "white" ){
            corLinha="E8E8E8";
        }else{
            corLinha="white";
        }
        tabela += ' <tr bgcolor="'+corLinha+'" class="trcor">';
        tabela += '    <td><a href="javascript:mostraTR('+listaEstoque[i].COD_PRODUTO+');">';
        tabela += '           <img class="imagem" id="imagem'+listaEstoque[i].COD_PRODUTO+'" src="../../Resources/images/plus.png" width="15px" height="15px"></a></td>';
        tabela += '    <td>'+listaEstoque[i].DSC_PRODUTO+'</td>';
        tabela += '    <td>'+listaEstoque[i].DSC_FORNECEDOR+'</td>';
        tabela += '    <td>'+listaEstoque[i].DSC_MARCA+'</td>';
        tabela += '    <td>'+listaEstoque[i].IND_TIPO_PRODUTO+'</td>';
        tabela += '    <td>'+listaEstoque[i].QTD_ESTOQUE+'</td>';
        tabela += ' </tr>';
        tabela += ' <tr style="display:none;" id="'+listaEstoque[i].COD_PRODUTO+'" class="esconde">';
        tabela += '    <td>&nbsp;</td>';
        tabela += '    <td colspan="3" width="100%">';
        tabela += '         <table width="100%" style="border: 1px solid;">';
        tabela += '             <tr>';
        tabela += '                 <td class="TDTitulo">Codigo</td>';
        tabela += '                 <td class="TDTitulo">Data da Entrada</td>';
        tabela += '                 <td class="TDTitulo" align="right">Preço Custo</td>';
        tabela += '                 <td class="TDTitulo" align="right">Preço Mínimo</td>';
        tabela += '                 <td class="TDTitulo" align="right">Preço de Venda</td>';
        tabela += '                 <td class="TDTitulo" align="right">Qtd Estoque</td>';
        tabela += '             </tr>';
        for(j=0;j<listaEntradasEstoque.length;j++){
            if(listaEntradasEstoque[j].COD_PRODUTO==listaEstoque[i].COD_PRODUTO){
                tabela += ' <tr>';
                tabela += '    <td>'+listaEntradasEstoque[j].NRO_SEQUENCIAL+'</td>';
                tabela += '    <td>'+listaEntradasEstoque[j].DTA_ENTRADA+'</td>';
                tabela += '    <td align="right">'+listaEntradasEstoque[j].VLR_UNITARIO+'</td>';
                tabela += '    <td align="right">'+listaEntradasEstoque[j].VLR_MINIMO+'</td>';
                tabela += '    <td align="right">'+listaEntradasEstoque[j].VLR_VENDA+'</td>';
                tabela += '    <td align="right">'+listaEntradasEstoque[j].QTD_ESTOQUE+'</td>';
                tabela += ' </tr>';
            }
        }
        tabela += '  </table>';
        tabela += '    </td>';
        tabela += ' </tr>';
    }
    tabela +=' </table>';
    $("#Lista").html(tabela);
}


$(document).ready(function(){
    CriarCombo('codTipoProduto', 
               '../../Controller/TipoProduto/TipoProdutoController.php', 
               'method;ListarTipoProdutosAtivos', 
               'COD_TIPO_PRODUTO|DSC_TIPO_PRODUTO', 
               'DSC_TIPO_PRODUTO', 
               'COD_TIPO_PRODUTO');
});