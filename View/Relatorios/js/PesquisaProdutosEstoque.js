$(function() {
    $("input[type='button']").jqxButton({theme: theme});
    $("#btnPesquisa").click(function(){
       $( "#dialogInformacao" ).jqxWindow('setContent', 'Aguarde, realizando a pesquisa de produtos!');
       $( "#dialogInformacao" ).jqxWindow( "open" );
       $.post('../../Controller/Relatorios/RelatoriosEstoqueController.php', {
            method: 'PesquisaProdutoEstoque',
            parametro: $("#parametro").val()}, function(data){
            data = eval('('+data+')');
            if ((data[0].listaEstoque[1] != null) || (data[0].listaProdutosEstoque[1])) {
                MontaTabela(data);
               $( "#dialogInformacao" ).jqxWindow('close');
            }else{
               $( "#dialogInformacao" ).jqxWindow('setContent', 'Sem dados para a pesquisa!');
               $("#btnOK").show();
            }
        });
    });
});

function MontaTabela(data) {    
    console.log(data[0].listaEstoque);
    listaEstoque = data[0].listaEstoque[1];
    listaProdutosEstoque = data[0].listaProdutosEstoque[1];
    tabela =  '<table width="100%" align="center" class="TabelaConteudo" cellpadding="0" cellspacing="0">';
    tabela += '   <tr>';
    tabela += '      <td class="TDTitulo">&nbsp;</td>';
    tabela += '      <td class="TDTitulo">Produto</td>';
    tabela += '      <td class="TDTitulo">Marca</td>';
    tabela += '      <td class="TDTitulo">Total Estoque</td>';
    tabela += '   </tr>';
    corLinha = "white";
    i=0;
    total = listaEstoque.length;
    vlrTotal = 0;                
    while (i<total){
        if (corLinha=="white"){
            corLinha="E8E8E8";
        }else{
            corLinha="white";
        }
        tabela += '   <tr bgcolor="'+corLinha+'" class="trcor">';
        tabela += '         <td><a href="javascript:mostraTR('+listaEstoque[i].COD_PRODUTO+')">';
        tabela += '         <img class="imagem" id="imagem'+listaEstoque[i].COD_PRODUTO+'" src="../../Resources/images/plus.png" width="15px" height="15px"></a></td>';
        tabela += '         <td>'+listaEstoque[i].DSC_PRODUTO+'</td>';
        tabela += '         <td>'+listaEstoque[i].DSC_MARCA+'</td>';
        tabela += '         <td>'+listaEstoque[i].QTD_ESTOQUE+'</td>';
        tabela += '     </tr>';
        tabela += '     <tr style="display:none;" id="'+listaEstoque[i].COD_PRODUTO+'" class="esconde">';
        tabela += '         <td>&nbsp;</td>';
        tabela += '         <td colspan="3" width="100%">';
        tabela += '             <table width="100%" style="border: 1px solid;">';
        tabela += '                 <tr>';
        tabela += '                     <td class="TDTitulo">Data da Entrada</td>';
        tabela += '                     <td class="TDTitulo" align="right">Preço Mínimo</td>';
        tabela += '                     <td class="TDTitulo" align="right">Preço de Venda</td>';
        tabela += '                     <td class="TDTitulo" align="right">Qtd Estoque</td>';
        tabela += '                 </tr>';
        j=0;
        conti = listaProdutosEstoque.length;
        while (j<conti){
            if(listaEstoque[i].COD_PRODUTO==listaProdutosEstoque[j].COD_PRODUTO){
                tabela += '             <tr>';
                tabela += '                 <td>'+listaProdutosEstoque[j].DTA_ENTRADA+'</td>';
                tabela += '                 <td align="right">'+listaProdutosEstoque[j].VLR_MINIMO+'</td>';
                tabela += '                 <td align="right">'+listaProdutosEstoque[j].VLR_VENDA+'</td>';
                tabela += '                 <td align="right">'+listaProdutosEstoque[j].QTD_ESTOQUE+'</td>';
                tabela += '             </tr>';
            }
            j++;
        }
        tabela += '        </table>';
        tabela += '         </td>';
        tabela += '     </tr>';
        i++;
    }
    tabela += '</table>';
    $("#resultado").html(tabela);    
}

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