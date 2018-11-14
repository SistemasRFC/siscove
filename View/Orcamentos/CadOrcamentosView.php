<script src="js/CadOrcamentosView.js?rdm=<?php echo time();?>"></script>
<input type="hidden" name="method" id="method" value="">
<input type="hidden" name="nroStatusVenda" id="nroStatusVenda">
<input type="hidden" name="codVenda" id="codVenda">
<input type="hidden" name="codClienteVenda" id="codClienteVenda">
<table width="70%" align="left" border="0">
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td colspan="2">Selecione o Cliente</td>
                    <td>Data da Venda</td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="dscClienteAuto" id="dscClienteAuto" value="" size="50"><input type="button" id="btIncCliente" value="..."><br></td>
                    <td><div id="dtaVenda"><div></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="dadosCliente" style="border:1px solid;display:none;">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Vendedor</td>
                    <td>Ve&iacute;culo </td>
                    <td>Placa do Ve&iacute;culo </td>
                </tr>
                <tr>
                    
                    <td><div id="codVendedor"></div></td>
                    <td>
                        <input type="text" id="dscVeiculoAuto" name="dscVeiculoAuto" value="" size="30">
                        <input type="hidden" id="codVeiculoAuto" name="codVeiculoAuto" value="">
                        <input type="button" id="btIncVeiculo" value="...">
                    </td>
                    <td>
                        <input type="text" name="nroPlaca" id="nroPlaca" value="">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    
                    
                </tr>
                <tr>
                    
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td>Observação</td>
                </tr>
                <tr>
                    <td>
                        <textarea id="txtObservacao" name="txtObservacao" cols="80" rows="6"></textarea>
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
                        <div>
                            <input type="button" value="Salvar" id="btnSalvarVenda" title="Salva a venda e redireciona para a tela de produtos.">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="button" value="Listar Orcamentos Abertas" id="btnOrcamentosAbertas">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="button" value="Gerar Venda" class="btnResumoVenda" id="btnGerarVenda">
                        </div>
                    </td>
                    <td>
                        <input type="button" value="Resumo do Orçamento" class="btnResumoVenda" id="btnResumoVenda" title="Resumo do Orçamento">
                    </td>  
                </tr>
            </table>
        </td>
    </tr>
</table> 