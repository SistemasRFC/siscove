<script src="../../View/Produto/js/CadDadosProdutoView.js?rdm=<?php echo time();?>"></script>
<table width="100%" align="left">
    <tr>
        <td colspan="3">
            <table width="50%" align="left">
                <tr>
                    <td>Digite o nome do Produto</td>

                </tr>
                <tr>
                    <td>
                        <input type="text" size="40" name="dscProduto" id="dscProduto" value="">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    <div id="indNovo">Novo</div>
                                </td>
                                <td>
                                    <div id="indSemiNovo">Semi-Novo</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>                
                <tr>
                    <td>Selecione a marca</td>
                </tr>
                <tr>
                    <td>
                        <div id="codMarca"></div>
                    </td>
                </tr>
                <tr>
                    <td>Tipo de Produto</td>
                </tr>
                <tr>
                    <td>
                        <div id="codTipoProduto"></div>
                    </td>
                </tr>
                <tr class="nroPneu">
                    <td>Aro</td>

                </tr>
                <tr class="nroPneu">
                    <td>
                        <input type="text" size="15" name="nroAroPneu" id="nroAroPneu" value="0">
                    </td>
                </tr>
                <tr>
                    <td>Preço de Venda</td>

                </tr>
                <tr>
                    <td>
                         <input type="text" size="15" name="vlrVenda" id="vlrVenda" value="0">
                    </td>
                </tr>
                <tr>
                    <td>Preço Mínimo</td>

                </tr>
                <tr>
                    <td>
                         <input type="text" size="40" name="vlrMinimo" id="vlrMinimo" value="0">
                    </td>
                </tr>
                <tr>
                    <td><div id="indAtivo">Ativo</div></td>
                </tr>                
            </table>
        </td>
    </tr>  
</table>