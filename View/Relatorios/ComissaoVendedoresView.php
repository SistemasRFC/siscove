<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Comissão de Vendedores - Relatório</TITLE>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">    
    <script src="js/ComissaoVendedoresView.js?rdm=<?php echo time();?>"></script>
</head> 
    <body>
        <table width="100%">
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="20%">
                                Data Início
                            </td>
                            <td>
                                Data Fim
                            </td>                            
                            <td>
                                Funcionário
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
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="button" id="btnPesquisa" value="Pesquisar">
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
