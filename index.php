<?php
session_start();
session_unset();
?>
<html>
    <head>
        <title>Sistema de Vendas</title>
        <script src="Resources/JavaScript.js"></script>
        <link href="Resources/jquery-ui-1.10.3.custom/css/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Resources/jqx/jqwidgets/styles/jqx.base.css" type="text/css" />
        <link rel="stylesheet" href="Resources/jqx/jqwidgets/styles/jqx.bootstrap.css" type="media" />
        <script src="Resources/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
        <script src="Resources/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="Resources/jqx/jqwidgets/jqxcore.js"></script>
        <script type="text/javascript" src="Resources/jqx/jqwidgets/jqxdata.js"></script>
        <script type="text/javascript" src="Resources/jqx/jqwidgets/jqxinput.js"></script>
        <script type="text/javascript" src="Resources/jqx/jqwidgets/jqxbuttons.js"></script>
        <script type="text/javascript" src="Resources/jqx/jqwidgets/globalization/globalize.js"></script>
        <script type="text/javascript" src="Resources/jqx/jqwidgets/jqxcore.js"></script>
        <script type="text/javascript" src="Resources/jqx/jqwidgets/jqxwindow.js"></script>
        <script type="text/javascript" src="Resources/jqx/scripts/gettheme.js"></script>
        <script src="index.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=IBM850; ISO-8859-1">
    </head>
    <body>
        <div id="CadastroForm">
            <div id="windowHeader">
            </div>
            <div style="overflow: hidden;" id="windowContent">
                <form name="CadastroForm" method="post" accept-charset="UTF-8" action="Controller/Login/LoginController.php">
                    <input type="hidden" id="method" name="method">
                    <input type="hidden" id="pagina" name="pagina">
                    <input type="hidden" id="paginaError" name="paginaError">
                    <table>
                        <tr>
                            <td>
                                Login
                            </td>
                            <td>
                                <input type="text" id="nmeLogin" name="nmeLogin" class='login' placeholder="Login">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Senha
                            </td>
                            <td><input type="password" id="txtSenha" name="txtSenha" class='login' placeholder="Senha"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="button" id="btnLogin" value="Login">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
      <div id="dialogInformacao">
        <div id="windowHeader">
        </div>
        <div style="overflow: hidden;" id="windowContent">
        </div>
      </div>
    </body>
</html>