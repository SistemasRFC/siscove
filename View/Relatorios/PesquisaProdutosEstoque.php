<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
    <head>
    <TITLE>Pesquisa de Produtos</TITLE>
    <script src="js/PesquisaProdutosEstoque.js"></script>

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
                                    Pesquisa de produtos
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="40%">
                            <tr>
                                <td>
                                    Descrição do Produto: <input type="text" name="parametro" id="parametro">
                                </td>
                                <td>
                                    <input type="button" id="btnPesquisa" value="Pesquisar" title="Clique aqui para pesquisar">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="resultado">
                            
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>