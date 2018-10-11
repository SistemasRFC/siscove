<script src="js/FormaPagamentoVendasView.js?ramdom=<?php echo time();?>"></script>   
<input type="hidden" name="indAbaixo" id="indAbaixo" value="">
<input type="hidden" name="nroSequencial" id="nroSequencial" value="">
<table width="70%" align="left" border="0" class="TabelaMae">
<tr>
    <td>Dados da Venda <label class="codigo"></label>
    <table width="100%" align="center">
    <tr>
        <td style="font-size:14px;" align="left">
            <div id="dadosClientePagamento" style="border:1px solid;display:none;">
            </div>
        </td>
    </tr>
    </table>
</td>
</tr>
<tr>
    <td>
        <table width="80%" border="0" align="left">
        <tr>
            <td>Tipo Pagamento</td>
            <td>Valor a ser pago</td>
            <td>Data do Vencimento</td>
        </tr>
        <tr>
            <td><div id='codTipoPagamento'></div></td>
            <td><input type="text" name="vlrPagamento" id="vlrPagamento" value=""></td>
            <td>
                <div id="dtaPagamento"></div>
            </td>
        </tr>
        </table>
    </td>
</tr>
<tr>
    <td>
        <div style="display:none;" id="cheques" style="border: 1px solid #aaaaaa;">
            <table width="100%" align="center"
                    cellspacing="0" cellpadding="0">
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
                    <td colspan="2">
                        <input type="text" name="nmeProprietario" id="nmeProprietario" value="" size='80' >
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
                    <td>Descrição da mercadoria</td>
                    <td>Quantidade</td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="codProdutoEstoque" id="codProdutoEstoque">
                        <div id='content'>
                        <input type="text" name="dscMercadoriaVenda" id="dscMercadoriaVenda" size="80">
                        <input type="button" id="btIncMercadoria" value="...">
                        
                        </div>                        
                        <!--<input type="text" name="dscMercadoria" id="dscMercadoria" value="" size='80'>-->
                    </td>
                    <td><input type="text" name="qtdMercadoria" id="qtdMercadoria"></td>
                </tr>
            </table>
        </div>
    </td>
</tr>
<tr>
    <td>
        <div style="display:none;" id="cartaoCredito" style="">
            <table width="100%" align="center" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                    Qtd parcelas
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="qtdParcelas" id="qtdParcelas" value="" size='10'>
                    </td>
                </tr>
            </table>
        </div>
    </td>
</tr>
<tr>
    <td>
            <table width="100%" align="center" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <input type="button" value="Salvar" id="btnSalvarPagamento" name="btnSalvar" title="Insere o pagamento nesta venda">
                    </td>
                </tr>
            </table>
    </td>
</tr>
<tr>
    <td>
        <table width="100%" border="0" align="left">
            <tr>
                <td id="tdListaPagamentosVenda">
                    <div id="ListaPagamentosVenda">

                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>
        <table>
            <tr>
                <td>
                    <table width="100%" border="0" align="left">
                        <tr>
                            <td class="TDTitulo">
                                Valor total: R$ <label id="lblvlrTotalVenda"></label>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>

<tr>
    <td>
        <table width="100%" align="center" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <input type="button" value="Fechar Venda" id="btnFecharVenda" title="Fechar venda">
                </td>
                <td>
                    <input type="button" value="Justificar pagamento" id="btnJustificarPagamento" title="Justificar pagamento">
                </td> 
                <td>
                    <input type="button" value="Resumo da Venda" id="btnResumoVenda" title="Resumo da venda">
                </td>     
                <td>
                    <input type="button" value="Resumo de Serviços" id="btnResumoServicos" title="Resumo dos Serviços">
                </td>                
            </tr>
        </table>
    </td>
</tr>
</table>
