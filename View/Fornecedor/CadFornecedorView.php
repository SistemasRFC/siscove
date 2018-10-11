<script src="js/CadFornecedorView.js"></script>
<input type="hidden" name="method" id="method" value="">
<input type="hidden" id="codFornecedor" name="codFornecedor" value="">
<table width="100%" align="center">
    <tr>
        <td>
            <table width="40%" align="left">
                <tr>
                    <td>Digite o cnpj do Fornecedor</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" size="50" name="nroCNPJ" id="nroCNPJ" value="">
                    </td>
                </tr>
                <tr>
                    <td>Digite a IE do Fornecedor</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" size="50" name="nroIE" id="nroIE" value="">
                    </td>
                </tr>
                <tr>
                    <td>Digite o nome do Fornecedor</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" size="50" name="dscFornecedor" id="dscFornecedor" value="">
                    </td>
                </tr>
                <tr>
                    <td>Telefone</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" size="13" maxlength="13" name="nroTelefone" id="nroTelefone" value="" onkeypress="return txtBoxFormat(this, '(99)9999-9999', event);">
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>CEP</td>
                                <td>Logradouro</td>
                                <td>Complemento</td>
                                <td>Bairro</td>
                            </tr>
                            <tr>
                                <td><input type="text" size="10" maxlength="10" name="nroCep" id="nroCep" value="" onkeypress="return txtBoxFormat(this, '99.999-999', event);"></td>
                                <td><input type="text" size="19" id="txtLogradouro"></td>
                                <td><input type="text" size="19" id="txtComplemento"></td>
                                <td><input type="text" size="20" id="nmeBairro"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>Cidade</td>
                                <td>UF</td>
                            </tr>
                            <tr>
                                <td><input type="text" id="nmeCidade"></td>
                                <td><input type="text" id="sglUf"></td>
                            </tr>
                        </table>
                    </td>
                </tr>                 
                <tr>
                    <td colspan="4" align="left" class="style3">
                        Observa&ccedil;&atilde;o
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="left" class="styleTD1">
                        <textarea cols="50" rows="7" name="txtObs" id="txtObs"></textarea>
                    </td>
                </tr>
               <tr>
                    <td><div id="indAtivo"> Fornecedor Ativo</div></td>
                </tr>
            </table>
        </td>
    </tr>     
    <tr>
        <td><input type="button" id="btnSalvar" value="Salvar"></td>
    </tr>
</table>