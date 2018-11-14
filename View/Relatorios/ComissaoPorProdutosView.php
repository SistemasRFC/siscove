<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Seleção de Produtos</TITLE>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">    
    <script src="js/ComissaoPorProdutosView.js?rdm=<?php echo time();?>"></script>
</head> 
    <body>
        <input type="hidden" id="codProdutosSelecionados">
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
                        </tr>
                        <tr>
                            <td>
                                <div id="dtaVendaInicio"></div>
                            </td> 
                            <td>
                                <div id="dtaVendaFim"></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>           
            <tr>
                <td>
                    <table width="100%">            
                        <tr>
                            <td>
                                Lista de Produtos
                            </td>
                            <td>
                                <br>
                            </td>
                            <td>
                                Produtos Selecionados
                            </td>                            
                        </tr>
                        <tr>
                            <td>
                                <div id="listaProdutos"></div>
                            </td>
                            <td>
                                <input type="button" id="btnSeleciona" value=">>>>>>>>">
                            </td> 
                            <td>
                                <div id="listaProdutosSelecionados"></div>
                            </td>                            
                        </tr>                        
                    </table>
                </td>
            </tr>           
            <tr>
                <td>
                    <table width="100%">  

                       <tr>
                            <td>
                                <input type="button" id="btnPesquisa" value="Pesquisar">
                            </td>
                            <td>
                                <input type="button" id="btnLimparSelecao" value="Limpar Seleção">
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
