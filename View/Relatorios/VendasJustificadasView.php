<html>
<HEAD>
<TITLE>Vendas Justificadas - Relatórios</TITLE>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script language="JavaScript" type="text/JavaScript"></script>
    <link href="../../Resources/css/jquery-ui-1.10.0.custom.css" rel="stylesheet">
    <script language="JavaScript" type="text/Javascript" src="../../Resources/js/jquery-1.9.0.js"></script>
    <script language="JavaScript" type="text/Javascript" src="../../Resources/js/jquery-ui-1.10.0.custom.js"></script>
    <script language="JavaScript" type="text/Javascript" src="js/VendasJustificadasView.js"></script>
    <script language="JavaScript" type="text/Javascript" src="../../Resources/js/svJavaScript.js"></script>

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
                            <td width="20%"  class="TDTitulo">
                                Data Fim
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" id="dtaVendaInicio" name="dtaVendaInicio">
                            </td>
                            <td>
                                <input type="text" id="dtaVendaFim" name="dtaVendaFim">
                            </td>
                            <td width="20%" >
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
        <div id="dialogInformacao">
        </div>
    </body>
</html>