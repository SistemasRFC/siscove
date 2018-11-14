<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Registros</TITLE>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">    
<script src="js/RegistroOperacoesView.js?rdm=<?php echo time();?>"></script>
</head>    
    <body>
        <table align="center" width="100%">
            <tr>
                <td>
                    <table width="60%" align ="center" class="TabelaCabecalho">
                        <tr>
                            <td class="TDTituloCabecalho">
                                Registros de Operações
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="60%" align ="center" class="TabelaCabecalho">
                        <tr>
                            <td class="TDTitulo">
                                Código da Venda
                            </td>
                            <td class="TDTitulo">
                                Data
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" id="codVendaReferencia" name="codVendaReferencia">
                            </td>
                            <td>
                                <div id="dtaReferencia"></div>
                            </td>
                            <td>
                                <input type="button" id="btnPesquisaRef" name="btnPesquisaRef" value="Pesquisar">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="Registros"></div>
                </td>
            </tr>
        </table>
    </body>
</html>