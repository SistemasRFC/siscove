<script src="js/CadTipoPagamentoView.js"></script>
<input type="hidden" name="method" id="method" value="">
<input type="hidden" name="codTipoPagamento" id="codTipoPagamento" value="">
<table width="100%" align="left">
    <tr>
        <td colspan="3">
            <table width="50%" align="left">
                <tr>
                    <td>Descrição do Tipo de Pagamento</td>

                </tr>
                <tr>
                    <td>
                        <input type="text" size="40" name="dscTipoPagamento" id="dscTipoPagamento" value="">
                    </td>
                </tr>
                <tr>
                    <td>Porcentagem de desconto</td>

                </tr>
                <tr>
                    <td>
                        <input type="text" size="40" name="vlrPorcentagem" id="vlrPorcentagem" value="">
                    </td>
                </tr>
                <tr>
                    <td><div id="indAtivo">Ativo</div></td>
                </tr>
                
            </table>
        </td>
    </tr>   
    <tr>
        <td><input type="button" id="btnSalvar" value="Salvar"></td>
    </tr>
</table>