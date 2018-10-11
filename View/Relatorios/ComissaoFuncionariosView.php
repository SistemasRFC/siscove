<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Comissão de Funcionários - Relatório</TITLE>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">    
    <script src="js/ComissaoFuncionariosView.js?rdm=<?php echo time();?>"></script>
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
                            <td class="TDTitulo">
                                Data Fim
                            </td>
                            <td class="TDTitulo">
                                Funcionário
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
                            <td>
                                <div id="codFuncionario"></div>
                                <input type="checkbox" id="indGerencia"> Gerência
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
        <div id="dialogInformacao">
        </div>
    </body>
</html>