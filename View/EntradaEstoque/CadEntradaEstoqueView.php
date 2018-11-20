<script src="js/CadEntradaEstoqueView.js"></script>
<table width="100%" align="left">
    <tr>
        <td>
            <table width="100%" align="left">
                <tr>
                  <td>Selecione o Fornecedor</td>
                </tr>
                <tr>
                    <td>
                       <div id='codFornecedor'></div>
                    </td>
                </tr>
                <tr>
                    <td>Selecione o Deposito destino</td>
                </tr>

                <tr>
                    <td>
                        <div id='codDeposito'></div>
                    </td>
                </tr>
                <tr>
                    <td>Chave da Nota Fiscal</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="nroNotaFiscal" id="nroNotaFiscal" value="" size="70">
                    </td>
                </tr>
                <tr>
                    <td>Data da Entrada</td>
                </tr>
                <tr>
                    <td>
                        <div id="dtaEntrada"></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <table width="100%" align="center" class="TabelaPai">
                <tr>
                    <td colspan="4" align="left" class="style3">
                            Observa&ccedil;&atilde;o
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="left" class="styleTD1">
                        <textarea cols="60" rows="7" name="txtObs" id="txtObs"></textarea>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>