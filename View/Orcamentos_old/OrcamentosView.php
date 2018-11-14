<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Orçamentos</TITLE>
	<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script src="js/Funcoes.js"></script>    
    <script src="js/DialogsView.js"></script> 
    <script src="js/OrcamentosView.js"></script>
</HEAD>
<BODY>
    <table width='100%'>
        <tr>
            <td><input type="button" id="btnNovo" value="Novo orçamento"></td>
        </tr> 
        <tr>
            <td>
                <div id='jqxWidget'>
                    <div id='jqxTabsOrcamentos'>
                        <ul>
                            <li>Orcamentos</li>
                            <li>Produtos</li>
                        </ul>
                        <div>
                            <?php include_once("CadOrcamentosView.php");?>
                        </div>
                        <div>
                            <?php include_once("ProdutosOrcamentosView.php");?>
                        </div>

                    </div> 

                </div>  
            </td>
        </tr>
        <tr>
            <td>
                <div id="OrcamentosClienteForm">
                      <div id="windowHeader">
                      </div>
                      <div style="overflow: hidden;" id="windowContent">
                          <table>
                              <tr>
                                  <td id="tdListaOrcamentosCliente">
                                      <div id="ListaOrcamentosCliente"></div>
                                  </td>
                              </tr>
                          </table>
                      </div>            
                </div>    
            </td>
        </tr>
        <tr>
            <td>
                <div id="OrcamentosAbertasForm">
                    <div id="windowHeader1">
                    </div>
                    <div id="windowContent1">
                        <table>
                            <tr>
                                <td id="tdListaOrcamentosAbertas">
                                    <div id="ListaOrcamentosAbertas"></div>
                                </td>
                            </tr>
                        </table>
                    </div>            
                </div>                 
            </td>
        </tr>
        <tr>
            <td>
                <div id="GerarVendaForm">
                    <div id="windowHeader1">
                    </div>
                    <div id="windowContent1">
                        <table>
                            <tr>
                                <td id="tdListaGerarVenda">
                                    <?php include_once("GerarVendaView.php");?>
                                </td>
                            </tr>
                        </table>
                    </div>            
                </div>                 
            </td>
        </tr>
        <tr>
            <td>
                <div id="NovoClienteForm">
                    <div id="windowHeader">
                    </div>
                    <div style="overflow: hidden;" id="windowContent">
                        <?php include_once("../../View/Cliente/CadClienteView.php");?>
                    </div>            
                </div>                
            </td>
        </tr>
        <tr>
            <td>
                <div id="NovoVeiculoForm">
                    <div id="windowHeader">
                    </div>
                    <div style="overflow: hidden;" id="windowContent">
                        <?php include_once("../../View/Veiculo/CadVeiculoView.php");?>
                    </div>            
                </div>                
            </td>
        </tr>   

        <tr>
            <td>
                <div id="CadastroProdutoForm">
                    <div id="windowHeader">
                    </div>
                    <div style="overflow: hidden;" id="windowContent">
                        <?php include_once("../../View/Produto/CadProdutosView.php");?>
                    </div>            
                </div>                
            </td>
        </tr>  
        <tr>
            <td>
                <div id="dialogRelatorioResumoVenda">
                    <div id="windowHeader">
                    </div>
                    <div style="overflow: hidden;" id="windowContent">
                    </div>            
                </div>  
            </td>
        </tr>
        <tr>
            <td>
                <div id="AvisoOrcamentosAbertas">
                    <div id="windowHeader">
                    </div>
                    <div style="overflow: hidden;" id="windowContent">
                    </div>            
                </div>  
            </td>
        </tr>
    </table> 
    <div id='teste'>
        <div id='divAutoComplete'><div id="windowHeader">
        </div>
        <div style="overflow: hidden;" id="windowContent">
        </div> 
    </div>    
</BODY>
</HTML>
