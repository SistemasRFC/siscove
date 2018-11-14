<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
    <TITLE>Pesquisa de Produtos</TITLE>
    <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">    
    <script src="js/PesquisaProdutosEstoqueGerente.js?rdm=<?php echo time();?>"></script>
</head>
<body>
    <input type="hidden" id="tr">
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
    <div id="BaixaEstoque">
        <input type="hidden" id="nroSequencial" name="nroSequencial">
        <input type="hidden" id="codProdutoEstoque" name="codProdutoEstoque">
        Qtd Baixa: <input type="text" id="qtdBaixa" name="qtdBaixa"><br>
        Observação:<br>
        <textarea name="txtBaixa" id="txtBaixa" cols="50" rows="5"></textarea>
    </div>
</body>
</html>