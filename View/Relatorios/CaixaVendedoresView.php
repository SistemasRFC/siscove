<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
    <HEAD>
        <TITLE>Caixa Vendedores - Relatórios</TITLE>
        <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
        <script src="js/CaixaVendedoresView.js"></script>
    </head>
    <body>
        <div id="CadastroForm">
        <table width="100%">
            <tr>
                <td>
                    <table width="100%" class="TabelaCabecalho">
                        <tr>
                            <td width="20%" class="TDTitulo">
                                Data
                            </td>
                            <td class="TDTitulo">
                                Funcionário
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="dtaCaixa"></div>
                            </td>
                            <td>
                                <div id="codFuncionario"></div>
                            </td>
                            <td>
                                <input type="button" id="btnPesquisa" value="Pesquisar">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
            <div id="conteudo">
            </div>
        </div>
    </body>
</html>