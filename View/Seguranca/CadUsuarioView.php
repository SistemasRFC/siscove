<form name="CadastroForm" method="post" action="Controller/Seguranca/UsuarioController.php">
    <input type="hidden" id="method" name="method">
    <input type="hidden" id="codUsuario" name="codUsuario">
    <table>
        <tr>
            <td>
                Login
            </td>
            <td><input type="text" id="nmeLogin" name="nmeLogin" size="60"></td>
        </tr>
        <tr>
            <td>
                Nome
            </td>
            <td><input type="text" id="nmeUsuario" name="nmeUsuario" size="60"></td>
        </tr>
        <tr>
            <td>
                Email
            </td>
            <td><input type="text" id="txtEmail" name="txtEmail" size="60"></td>
        </tr>       
        <tr>
            <td>Perfil</td>
            <td class="styleTD1" style="text-align:left;" id="tdcodPerfil">
                <div id="codPerfil"></div>
            </td>
        </tr>      
        <tr>
            <td>Cliente</td>
            <td class="styleTD1" style="text-align:left;" id="tdcodCliente">
                <div id="codCliente"></div>
            </td>
        </tr>      
        <tr>
            <td>Dep&oacute;sito</td>
            <td class="styleTD1" style="text-align:left;" id="tdcodLoja">
                <div id="codLoja"></div>
            </td>
        </tr>
        <tr>
            <td><div id="indAtivo"> Ativo</div></td>
        </tr> 
    </table>
    <table>
        <tr>
            <td>
                <input type="button" id="btnSalvar" value="Salvar">
            </td>
            <td>
                <input type="button" id="btnReiniciarSenha" value="Reiniciar Senha">
            </td>            
        </tr>
    </table>
</form>