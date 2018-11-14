<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
    <HEAD>
        <TITLE>Notas Emitidas - Relatório</TITLE>
        <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
        <script src="js/RelatorioNfeEmitidasView.js?rdm=<?php echo time();?>"></script>
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
                                <div id="dtaInicioNfe"></div>
                            </td>
                            <td>
                                <div id="dtaFimNfe"></div>
                            </td>
                            <td width="20%" >
                                <input type="button" id="btnPesquisaNfe" value="Pesquisar">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
            <div id="listaNotas">
            </div>
        </div>
    </body>
</html>