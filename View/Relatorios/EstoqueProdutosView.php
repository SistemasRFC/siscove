<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Estoque de Produtos</TITLE>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">    
    <script src="js/EstoqueProdutosView.js?rdm=<?php echo time();?>"></script>
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
                                <td colspan="2" width="50%">
                                    Tipo de Produto
                                </td>
                                <td width="50%">
                                    <input type="button" id="btnPesquisar" name="btnPesquisar" value="Pesquisar"
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <div id="codTipoProduto"></div>
                                </td>
                                <td width="20%">
                                    <table>
                                        <tr>
                                            <td>
                                                <div width="50%" id="CondicaoNovo"> Novo </div>
                                            </td>
                                            <td>
                                                <div width="50%" id="CondicaoSeminovo"> Semi-novo </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="Lista"></div>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>