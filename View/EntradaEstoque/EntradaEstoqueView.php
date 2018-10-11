<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Estoque</TITLE>
	<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script src="js/Funcoes.js?rdm=<?php echo time();?>"></script>    
    <script src="js/DialogsView.js?rdm=<?php echo time();?>"></script> 
    <script src="js/EntradaEstoqueView.js?rdm=<?php echo time();?>"></script>
</HEAD>
<BODY>            
    <input type="hidden" name="method" id="method" value="AddEntradaEstoque">
    <input type="hidden" name="nroSequencial" id="nroSequencial" value="0">
    <input type="hidden" name="nroCNPJ" id="nroCNPJ" value="">
    <input type="hidden" name="txtLogradouro" id="txtLogradouro" value="">
    <input type="hidden" name="txtComplemento" id="txtComplemento" value="">
    <input type="hidden" name="nmeBairro" id="nmeBairro" value="">
    <input type="hidden" name="nmeCidade" id="nmeCidade" value="">
    <input type="hidden" name="sglUf" id="sglUf" value="">
    <input type="hidden" name="nroCep" id="nroCep" value="">
    <input type="hidden" name="nroIE" id="nroIE" value="">
    <input type="hidden" name="indEntrada" id="indEntrada" value="">
    <table width="100%">
        <tr>
            <td>
                <input type='button' id='btnDevolucaoNota' value='Devolução de Nota'>
                <input type='button' id='btnConsultarNota' value='Consultar Nota'>
                <input type='button' id='btnNovaEntrada' value='Nova Entrada'>
                <input type='button' id='btnSalvarEntrada' value='Salvar'>
                <input type='button' id='btnEntradasAbertas' value='Entradas em aberto'>
                <input type='button' id='btnEntradasFechadas' value='Entradas Fechadas'>
            </td>
        </tr>         
        <tr>
            <td>
                <div id='jqxWidget'>
                    <div id='jqxTabsEntradas'>
                        <ul>
                            <li>Entrada</li>
                            <li>Produtos</li>
                            <!--li>Pagamentos</li-->
                        </ul>
                        <div>
                            <?php include_once("CadEntradaEstoqueView.php");?>
                        </div>
                        <div>
                            <?php include_once("EntradaEstoqueProdutoView.php");?>
                        </div>
                        <!--div>
                            <?php include_once("EntradaEstoquePagamentosView.php");?>
                        </div-->
                    </div> 
                </div>               
            </td>
        </tr>
        <tr>
            <td>
                <div id="EntradasAbertasForm">
                    <div id="windowHeader1"></div>
                    <div id="windowContent1">
                        <table>
                            <tr>
                                <td id="tdListaEntradasAbertas">
                                    <div id="ListaEntradasAbertas"></div>
                                </td>
                            </tr>
                        </table>
                    </div>            
                </div>                 
            </td>
        </tr>  

        <tr>
            <td>
                <div id="ListaChequesRecebidosForm">
                    <div id="windowHeader1">
                    </div>
                    <div id="windowContent1">
                        <table>
                            <tr>
                                <td id="tdListaChequesRecebidos">
                                    <div id="ListaChequesRecebidos"></div>
                                </td>
                            </tr>
                        </table>
                    </div>            
                </div>                 
            </td>
        </tr>      
    </table>
    <div id='teste'>
    <div id='divAutoComplete'><div id="windowHeader">
                    </div>
                    <div style="overflow: hidden;" id="windowContent">
                    </div> </div>
    </div>    
    <div id="EntradasFechadasForm">
        <div id="windowHeader1">
        </div>
        <div id="windowContent1">
            <table>
                <tr>
                    <td>
                        <div id="codFornecedorPesquisa"></div>
                    </td>
                    <td>
                        <input type="button" id="btnPesquisarEntrada" value="Pesquisar">
                    </td>
                </tr>
                <tr>
                    <td id="tdListaEntradasFechadas" colspan="2">
                        <div id="ListaEntradasFechadas"></div>
                    </td>
                </tr>
            </table>
        </div>            
    </div>
</body>
</html>