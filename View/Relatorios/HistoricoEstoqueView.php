<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>P&aacute;gina Principal</TITLE>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">    
    <script src="js/HistoricoEstoqueView.js?random=<?php echo time();?>"></script>
</head>
    <body>
        <table width="100%">
            <tr>
                <td>
                    <table width="100%" class="TabelaCabecalho">
                        <tr>
                            <td width="20%" class="TDTitulo">
                                Data Início
                            </td>
                            <td width="30%" class="TDTitulo">
                                Data Fim
                            </td>
                            <td width="30%" class="TDTitulo">
                                Descrição do Produto
                            </td>
                            <td>
                                <input type="button" id="btnPesquisa" value="Pesquisar">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="dtaMovimentacaoInicio"></div>
                            </td>
                            <td>
                                <div id="dtaMovimentacaoFim"></div>
                            </td>
                            <td>
                                <input type="text" size="30" name="dscProduto" value="" id="dscProduto" >
                            </td>
                            <td>
                                <div id="indCondicaoNovo"> Novo </div>
                            </td>
                            <td>
                                <div id="indCondicaoSeminovo"> Semi-novo </div>
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
    </body>
</html>