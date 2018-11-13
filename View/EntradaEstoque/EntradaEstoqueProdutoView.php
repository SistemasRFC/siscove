<script src="js/EntradaEstoqueProdutoView.js"></script>
<table width="100%" align="left" border="0">
<tr>
    <td>
        <table width="100%">
            <tr>
                <td>
                  <div class="dadosProduto" style="border:1px solid;display:none;">
                  </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>
        <table width="100%" border="0" align="left" class="TabelaPai">
            <tr>
                <td>Produto</td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="codProdutoEstoque" id="codProdutoEstoque">
                    <input type="text" name="dscProdutoEstoque" id="dscProdutoEstoque" size="100">
                    <!--<input type="button" id="btIncProduto" value="...">-->
               </td>
            </tr>
            <tr>
                <td>Quantidade</td>
            </tr>
            <tr>
                <td><input type="text" name="qtdEntrada" id="qtdEntrada"></td>
            </tr>
            <tr>
                <td>Valor de custo unit&aacute;rio</td>
            </tr>
            <tr>
                <td><input type="text" name="vlrCustoUnitario" id="vlrCustoUnitario"></td>
            </tr>
            <tr>
                <td>Valor M&iacute;nimo de venda</td>
            </tr>
            <tr>
                <td><input type="text" name="vlrMinimo" id="vlrMinimo"></td>
            </tr>
            <tr>
                <td>Valor de Venda</td>
            </tr>
            <tr>
                <td><input type="text" name="vlrVenda" id="vlrVenda"></td>
            </tr>
            <tr>
                <td>
                    <input type="button" value="Salvar" id="btnSalvarProdutoEntrada" title="Insere o produto">
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr class="TabelaPai">
    <td id="tdListaProdutosEntrada">
        <div id="ListaProdutosEntrada">
        </div>
    </td>
</tr>
<tr>
    <td>
        <input class="TabelaPai" type="button" id="btnFecharEntrada" value="Fechar Entrada">
    </td>
</tr>
</table>
</BODY>
</HTML>