<html>
    <head>
    <TITLE>Fluxo de Caixa</TITLE>
    <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <link href="../../Resources/css/jquery-ui-1.10.0.custom.css" rel="stylesheet">
    <link href="../../Resources/css/style.css" rel="stylesheet">
    <script language="JavaScript" type="text/JavaScript"></script>
    <link href="../../Resources/css/jquery-ui-1.10.0.custom.css" rel="stylesheet">
    <script src="../../Resources/js/jquery-1.9.0.js"></script>
    <script src="../../Resources/js/jquery-ui-1.10.0.custom.js"></script>
    <script src="../../Resources/js/jquery.maskMoney.js"></script>
    <script src="../../Resources/js/svJavaScript.js"></script>
    <script src="js/FluxoCaixaView.js"></script>
    <script src="../FluxoCaixa/js/AdiantamentoReceitaCaixaView.js"></script>
    </head>
    <body> 
        <input type="hidden" id="tr">
        <div id="Listagem">
            <table width="100%">
                <tr>
                    <td>
                        <table width="50%" align ="center" class="TabelaCabecalho">
                            <tr>
                                <td class="TDTituloCabecalho">
                                    Fluxo de caixa
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
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
                                    <input type="button" id="btnPesquisa" value="Pesquisar" title="Clique aqui para pesquisar">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" id="dtaVendaInicio" name="dtaVendaInicio" value="01/05/2013">
                                </td>
                                <td>
                                    <input type="text" id="dtaVendaFim" name="dtaVendaFim" value="02/05/2013">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="conteudo">
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div id="dialogAdiantamento">
            <?include_once("../FluxoCaixa/AdiantamentoReceitaCaixaView.php");?>
        </div>
        <div id="dialogInformacao">
        </div>
    </body>
</html>