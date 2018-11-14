<script src="js/ProdutosOrcamentosView.js?rdm=<?php echo time();?>"></script>
<input type="hidden" name="method" id="method" value="">
<input type="hidden" name="nroStatusVenda" id="nroStatusVenda" value="">
<input type="hidden" name="codVenda" id="codVenda" value="">
<style>
    .ui-autocomplete { height: 150px; overflow-y: scroll; overflow-x: hidden;}
</style>
<table width="100%" align="center" border="0">
<tr>
<td>
    Dados da Venda
    <table width="100%" align="center">
    <tr>
        <td style="font-size:14px;" align="left">
            <div id="dadosClienteProduto" style="border:1px solid;display:none;">
            </div>
        </td>
    </tr>
    </table>
</td>
</tr>
<tr>
    <td>
        <table width="100%" border="0" align="center">
            <tr>
                <td>Produto</td>          
            </tr>
            <tr>
                <td>
                    
                    <input type="hidden" name="codProdutoVenda" id="codProdutoVenda">
                    <input type="hidden" name="qtdEstoqueVenda" id="qtdEstoqueVenda">
                    <input type="hidden" name="nroSequencialVenda" id="nroSequencialVenda">
                    <div id='content'>
                    <input type="text" name="dscProdutoVenda" id="dscProdutoVenda" size="70">
                    <input type="button" id="btIncProduto" value="...">
                    <input type="checkbox" name="indEstoqueVenda" id="indEstoqueVenda" class="indestoque"><spam class="indestoque">Retirar do Estoque</spam>
                    </div>
                    
                </td>               
                
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>
        <table width="50%" border="0" align="left">
            <tr>     
                <td>Funcion&aacute;rio</td>
                <td>Qtd a vender</td>
                <td>Valor</td>
                <td>Desconto</td> 
            </tr>
            <tr>
                <td><div id="codFuncionario"></div></td>
                <td><input type="text" name="qtdVenda" id="qtdVenda"></td>
                <td><input type="text" name="vlrVenda" id="vlrVenda"></td>
                <td><input type="text" name="vlrDesconto" id="vlrDesconto" value="0"></td>                 
                <td>
                    
                    <input type="button" value="Salvar" id="btnSalvarProdutoVenda" title="Insere o produto nesta venda">
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>
        <table width="100%" border="0" align="left">
            <tr>
                <td id='tdListaProdutosVendidos'>
                    <div id="listaGridProdutosVendidos"></div>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>
        <table width="100%" border="0" align="left">
            <tr>
                <td class="TDTitulo">
                    Valor total: R$ <label id="lblVlrTotalProdutosVendidos">
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>