<script src="js/CadUsuarioView.js"></script>
<form name="CadastroForm" method="post" action="Controller/Seguranca/UsuarioController.php">
    <input type="hidden" id="method" name="method">
    <input type="hidden" id="codUsuario" name="codUsuario">
    <table>
        <tr>
            <td>
                Login
            </td>
            <td><input type="text" id="nmeLogin" name="nmeLogin" size="35"></td>
        </tr>
        <tr>
            <td>
                Nome
            </td>
            <td><input type="text" id="nmeUsuario" name="nmeUsuario" size="35"></td>
        </tr>
        <tr>
            <td>
                CPF
            </td>
            <td><input type="text" id="nroCpf" name="nroCpf" size="20"></td>
        </tr>
        <tr>
            <td>
                Email
            </td>
            <td><input type="text" id="txtEmail" name="txtEmail" size="35"></td>
        </tr>       
        <tr>
            <td>Perfil</td>
            <td class="styleTD1" style="text-align:left;">
                <div id="codPerfil"></div>
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