<script src="js/CadFuncionarioView.js?rdm=<?php echo time();?>"></script>
<input type="hidden" name="method" id="method" value="">
<input type="hidden" name="codFuncionario" id="codFuncionario" value="">
<table width="100%" align="left" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="70%" align="left">
                <tr>
                    <td>Digite o nome do Funcion&aacute;rio</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" size="50" name="nmeFuncionario" id="nmeFuncionario" value="">
                    </td>
                </tr>
                <tr>
                    <td>Telefone</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" size="20" maxlength="13" name="nroTelefone" id="nroTelefone" value="" onkeypress="return txtBoxFormat(this, '(99)9999-9999', event);">
                    </td>
                </tr>
                <tr>
                    <td>Email</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" size="50" name="txtEmail" id="txtEmail" value="">
                    </td>
                </tr>
                <tr>
                    <td>Porcentagem Servi&ccedil;o</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" size="10" name="vlrPorcentagemServico" id="vlrPorcentagemServico" value="">
                    </td>
                </tr>
                <tr>
                    <td>Porcentagem Venda</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" size="10" name="vlrPorcentagemVenda" id="vlrPorcentagemVenda" value="">
                    </td>
                </tr>
                <tr>
                    <td>Porcentagem Gerência</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" size="10" name="vlrPorcentagemGerencia" id="vlrPorcentagemGerencia" value="">
                    </td>
                </tr>
                <tr>
                    <td>Dep&oacute;sito</td>
                </tr>
                <tr>
                    <td class="styleTD1" style="text-align:left;">
                        <div id="codDeposito"></div>
                    </td>
                </tr>
                <tr>
                    <td>Perfil</td>
                </tr>
                <tr>
                    <td class="styleTD1" style="text-align:left;">
                        <div id="codPerfil"></div>
                    </td>
                </tr>
                <tr>
                    <td><div id="indAtivo"> Funcion&aacute;rio Ativo</div></td>
                </tr>
            </table>
        </td>
    </tr>     
    <tr>
        <td><input type="button" id="btnSalvar" value="Salvar"></td>
    </tr>
</table>