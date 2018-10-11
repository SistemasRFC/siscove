<script src="js/EntradaEstoquePagamentosView.js"></script>
<table width="100%">
    <tr>
      <td>
          <table width="100%">
              <tr>
                  <td>
                    <div id="dadosPagamento" style="border:1px solid;display:none;"></div>
                </td>
              </tr>
          </table>
      </td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td>
                        Data do pagamento
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="dtaPagamento"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Tipo de Pagamento
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="codTipoPagamento"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Valor a ser pago
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="vlrPagamento" id="vlrPagamento" value="">

                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display:none;" id="cheques" style="border: 1px solid #aaaaaa;">
                            <table width="100%" align="center"
                                    cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <input type="hidden" name="nroSequencialVenda" id="nroSequencialVenda"/>
                                        <input type="button" id="btnImportaCheque" value="Importar cheque">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    N&ordm; do Cheque
                                    </td>
                                    <td>
                                    N&ordm; do Banco
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="nroCheque" id="nroCheque" value="">
                                    </td>
                                    <td>
                                        <input type="text" name="nroBanco" id="nroBanco" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Nome do Propriet&aacute;rio
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="nmeProprietario" id="nmeProprietario" value="">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="display:none;" id="mercadoria" style="">
                            <table width="100%" align="center" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        Descrição da mercadoria
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="dscMercadoria" id="dscMercadoria" value="">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <input type="button" id="btnSalvarPagamento" value="Salvar Pagamento">
        </td>
    </tr>
    <tr>
        <td id="tdListaPagamentosEntrada">
            <div id="listaPagamentosEntrada"></div>
        </td>
    </tr>
    <tr>
        <td>
            <input type="button" id="btnFecharEntrada" value="Fechar Entrada">
        </td>
    </tr>
</table>
