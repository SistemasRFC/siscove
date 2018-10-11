<script src="js/CadPagamentosView.js?rdm=<?php echo time();?>"></script>
<input type="hidden" name="method" id="method" value="">
<input type="hidden" name="codConta" id="codConta" value="">
<input type="hidden" name="codContaFixa" id="codContaFixa" value="">
<table width="100%" align="center">            
    <tr>
        <td>Descrição do Pagamento</td>
        <td>
            <input type="text" size="30" name="dscConta" id="dscConta" value="">
        </td>
    </tr>
    <tr>
        <td>Data do Vencimento</td>
        <td>
            <div id="dtaVencimento"></div>
        </td>
    </tr>
    <tr>
        <td>Tipo de conta</td>
        <td>
            <div id="codTipoConta"></div>
        </td>
    </tr>    
    <tr>
        <td>Valor do Pagamento</td>
        <td>
            <input type="text" size="30" id="vlrConta" value="">
        </td>
    </tr>     
    <tr>        
        <td>
            <div id="indContaPaga">Conta Paga</div>
        </td>
    </tr>    
    <tr>
        <td><input type="button" id="btnSalvar" value="Salvar"></td>
        <td><input type="button" id="btnInformarPagamento" value="Informar Pagamento"></td>
        <td><input type="button" id="btnExcluir" value="Excluir Conta"></td>
    </tr> 
</table>
