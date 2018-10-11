<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Estoque - Relatório</TITLE>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">    
    <script src="js/RelatorioEstoqueProdutoView.js"></script>
</head>        
    <body>
        <input type="hidden" id="tr">
        <table width="100%">
            <tr>
                <td>
                    <table width="50%" align ="center" class="TabelaCabecalho">
                        <tr>
                            <td class="TDTituloCabecalho">
                                Estoque de produtos
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="50%" align ="center" class="TabelaCabecalho">
                        <tr>
                            <td align="center">
                                <input type="button" id="btnPesquisar" name="btnPesquisar" value="Pesquisar"
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="codTipoProduto"></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table align="center" cellspacing="0" cellpadding="4" id="tabela" class="TabelaCabecalho">

                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>