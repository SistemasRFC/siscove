<? include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<HTML>
    <HEAD>
    <title>Perfis</title>
    <script src="js/PermissaoView.js"></script>
    </HEAD>
    <BODY>
        <form name="PermissaoForm" id="PermissaoForm" method="post" action="../../Controller/Seguranca/PermissaoController.php">
            <input type="hidden" value="" name="method" id="method">
            <input type="hidden" value="" name="codMenu" id="codMenu">
            <input type="hidden" value="" name="indAtivo" id="indAtivo">
            <table width="100%">
                <tr>
                    <td>
                        <table width="30%" border="0" align="left">
                            <tr>
                                <td class="style3">Perfil</td>
                                <td class="styleTD1">
                                    <div id="codPerfil"></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0" align="center">
                            <tr>
                                <td>Menus Existentes</td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="ListaMenus">

                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div id='jqxWidget' style='font-family: Verdana Arial; font-size: 12px; width: 100%; border: 1px solid #000000;'>
                                        <table width="100%" id="checkboxes">
                                        
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" id="btnSalvar" value="Salvar">
                    </td>
                </tr>
            </table>
        </form>
    </BODY>
</HTML>
