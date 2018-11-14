<form name="menuForm" enctype="multpart/form-data" id="cadastroMenuForm" method="post" action="../../Controller/Seguranca/CadastroMenuController.php">
    <input type="hidden" id="indAtivo1" name="indAtivo1">
    <input type="hidden" id="codMenu" name="codMenu" value="0">    
    <input type="hidden" id="dscCaminhoImagem" name="dscCaminhoImagem">
    <table width="100%">
    <tr>
        <td>
            <table width="70%" align="left">
                <tr>
                    <td class="style2">Menu</td>
                </tr>
                <tr>
                    <td class="styleTD1">
                        <input name="dscMenu" id="dscMenu" size="30">
                    </td>
                </tr>
                <tr>
                    <td class="style2">Controller</td>
                </tr>
                <tr>
                    <td class="styleTD1">
                        <input name="nmeController" id="nmeController" size="50">
                        <input type="hidden" name="nmeClasse" id="nmeClasse" size="50">
                    </td>
                    <td>
                        <input type="button" id="btnListarController" value="Listar Controllers">
                    </td>
                </tr>
                <tr>
                    <td class="style2">Method</td>
                </tr>
                <tr>
                    <td class="styleTD1">
                        <input name="nmeMethod" id="nmeMethod" size="50">
                    </td>
                    <td>
                        <input type="button" id="btnListarMetodos" value="Listar Métodos">
                    </td>
                </tr>
                <tr>
                    <td class="style2">
                        <input type="checkbox" name="indAtalho" id="indAtalho">Atalho
                    </td>
                </tr>
                <tr>
                    <td class="style2">
                        <input type="checkbox" name="indAtivo" id="indAtivo">Ativo
                    </td>
                </tr>
                <tr>
                    <td class="style2">Menu Pai</td>
                </tr>
                <tr>
                    <td class="styleTD1">
                        <div id="codMenuPai"></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>    
    Selecione o arquivo:<br>
    <input type="file" name="arquivo" id="imagem" size="45" />
    <br />
    <progress value="0" max="100"></progress>
    <span id="porcentagem">0%</span>
    <br />
</form>
<table>
    <tr>
        <td>
            <input type="button" id="btnSalvar" value="Salvar">
        </td>
        <td>
            <input type="button" id="btnDeletar" value="Deletar">
        </td>
    </tr>
</table>
