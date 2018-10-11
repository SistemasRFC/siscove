<form name="menuForm" enctype="multpart/form-data" id="CadPerfilForm" method="post" action="../../Controller/Seguranca/CadastroMenuController.php">    
    <input type="hidden" id="method" name="method">    
    <table>
        <tr>
            <td>Codigo</td>
        </tr>
        <tr>
            <td><input type="text" id="codPerfil" size="10" readonly="true"></td>
        </tr>
        <tr>
            <td>Descri&ccedil;&atilde;o</td>
        </tr>
        <tr>
            <td><input type="text" id="dscPerfil"></td>
        </tr>
        <tr>
            <td><div id="indAtivo"> Perfil Ativo</div></td>
        </tr>        
        <tr>
            <td>
                <input type="button" id="btnSalvar" name="btnSalvar" value="Salvar">
            </td>
        </tr>
    </table>
</form>
