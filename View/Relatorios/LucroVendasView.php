<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
    <TITLE>Lucro das Vendas - Relatório</TITLE>
    <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script src="js/LucroVendasView.js?rdm=<?php echo time();?>"></script>
<!--    <script src="../../Resources/js/jquery.number.min.js?rdm=<?php echo time();?>"></script>-->
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