<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Produtos Mais Vendidos - Relatório</TITLE>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">

    <link href="../../Resources/css/style.css" rel="stylesheet">
    <script language="JavaScript" type="text/JavaScript"></script>
    <script src="js/ProdutosMaisVendidosView.js?rdm=<?php echo time();?>"></script>
</head>
    <body>
        <div id="CadastroForm">
        <table width="100%">
            <tr>
                <td>
                    <table width="100%" class="TabelaCabecalho">
                        <tr>
                            <td width="20%" class="TDTitulo">
                                Data Início
                            </td>
                            <td class="TDTitulo">
                                Data Fim
                            </td>
                            <td>
                                <input type="button" id="btnPesquisa" value="Pesquisar">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="dtaVendaInicio"></div>
                            </td>
                            <td>
                                <div id="dtaVendaFim"></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td id="conteudo">

                </td>
            </tr>
        </table>
        </div>
    </body>
</html>