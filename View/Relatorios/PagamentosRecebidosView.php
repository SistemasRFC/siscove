<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
    <HEAD>
        <TITLE>Pagamentos Recebidos - Relatórios</TITLE>
        <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
        <script src="js/PagamentosRecebidosView.js?rdm=<?php echo time();?>""></script>
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
                            <td width="20%"  class="TDTitulo">
                                Tipo de Pagamento
                            </td>                            
                        </tr>
                        <tr>
                            <td>
                                <div id="dtaVendaInicio"></div>
                            </td>
                            <td>
                                <div id="dtaVendaFim"></div>
                            </td>
                            <td>
                                <div id="codTipoPagamento"></div>
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