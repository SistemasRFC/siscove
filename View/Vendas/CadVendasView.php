<script src="js/CadVendasView.js?random=<?php echo time(); ?>"></script>
<input type="hidden" name="method" id="method" value="">
<input type="hidden" name="nroStatusVenda" id="nroStatusVenda">
<input type="hidden" name="codVenda" id="codVenda" value="<?php if (isset($_GET['codVenda'])){echo $_GET['codVenda'];}else{echo 0;}?>">
<input type="hidden" name="codClienteVenda" id="codClienteVenda">
<table width="80%" align="left" border="0" class="TabelaMae">
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td colspan="2">
                        Código da venda: <label class='codigo'></label><br>
                        <b>Status da venda: <label class='status'></label></b>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Selecione o Cliente</td>
                </tr>
                <tr>
                    <td colspan="3" id='tdClienteAutoComplete'>
                        <table>
                            <tr>
                                <td>CPF</td>
                                <td>Nome</td>
                            </tr>
                            <tr>
                                <td><input type="text" name="nroCpfPesquisaAuto" id="nroCpfPesquisaAuto" value="" size="15" onkeypress="return txtBoxFormat(this, '999.999.999-99', event);"></td>
                                <td><input type="text" name="dscClienteAuto" id="dscClienteAuto" value="" size="45"></td>
                                <td><input type="button" id="btIncCliente" value="..."><br></td>
                            </tr>
                        </table>    
                    </td>
                    <td>  
                        <table>
                            <tr>
                                <td>Data da Venda</td>
                            </tr>
                            <tr>
                                <td>
                                    <div id='dtaVenda'>
                                    </div>
                                </td>
                            </tr>
                        </table>                              
                    </td>
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
                    <td>Km Rodado </td>
                </tr>
                <tr>
                    
                    <td><div id="codVendedor"></div></td>
                    <td>
                        <input type="text" id="dscVeiculoAuto" name="dscVeiculoAuto" value="" size="20">
                        <input type="hidden" id="codVeiculoAuto" name="codVeiculoAuto" value="">
                        <input type="button" id="btIncVeiculo" value="...">
                    </td>
                    <td>
                        <input type="text" name="nroPlaca" id="nroPlaca" value="">
                    </td>
                    <td>
                        <input type="text" name="vlrKmRodado" id="vlrKmRodado" value="0">
                    </td>
                </tr>
                <tr>
                    <td>
                        Valor do Imposto do Produto
                    </td>
                    <td>
                        Valor do Imposto do Serviço
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="vlrImpostoProduto" id="vlrImpostoProduto" value="0,0684">
                    </td>
                    <td>
                        <input type="text" name="vlrImpostoServico" id="vlrImpostoServico" value="0,1026">
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
                            <input type="button" value="Cancelar Venda" id="btnCancelaVenda">
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table> 