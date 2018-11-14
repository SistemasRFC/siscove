<script src="js/CadInformaPagamentoView.js?rdm=<?php echo time();?>"></script>
<input type="hidden" id="methodPagamento">
<input type="hidden" id="codPagamento">
<table width="100%" align="center">            
    <tr>
        <td>Forma de Pagamento</td>
        <td>
            <div id="codTipoPagamento"></div>
        </td>
    </tr>
    <tr id="trDadosCheque">
        <td colspan="2">
            <table>
                <tr>
                    <td>Número do Cheque</td>
                    <td>Proprietário</td>                    
                </tr>
                <tr>
                    <td><input type="text" id="nroCheque"></td>
                    <td><input type="text" id="nmeProprietario"></td>                    
                 </tr>
                <tr>
                    <td>Banco</td>
                </tr>
                <tr>
                    <td><input type="text" id="nroBanco"></td>
                    <td><input type="button" id="btnChequeRecebido" value="Cheques Recebidos"></td>
                 </tr>                 
            </table>
        </td>
    </tr>
    <tr id="trDtaPago">
        <td colspan="2">
            <table>
                <tr>
                    <td>Data do Pagamento</td>
                    <td>
                        <div id="dtaPagamento"></div>
                    </td>                     
                </tr>
                <tr>
                    <td>Valor do Pagamento</td>                   
                    <td>
                        <input type="text" id="vlrPagamento">
                    </td>
                </tr>
                <tr>
                    <td>Qtd. Parcelas</td>
                    <td>
                            <input type="text" size="30" id="qtdParcelas" value="1">
                    </td>
                </tr> 
                <tr>
                    <td>Parcela Atual</td>
                    <td>
                            <input type="text" size="30" id="nroParcelaAtual" value="1">
                    </td>
                </tr>
            </table>
        </td>        
    </tr>    
    <tr>
        <td colspan="2">            
            <table>
                <tr>
                    <td><input type="button" id="btnSalvarPagamento" value="Salvar Pagamento"></td>
                    <td><input type="button" id="btnDeletarPagamento" value="Deletar Pagamento"></td>
                    <td><input type="button" id="btnNovoPagamento" value="Novo Pagamento"></td>
                </tr>
            </table>
        </td>                     
    </tr>   
    <tr>
        <td id="tdGrid" colspan="2">
            <div id="ListagemPagamentosForm">
            </div>
        </td>
    </tr> 
</table>
