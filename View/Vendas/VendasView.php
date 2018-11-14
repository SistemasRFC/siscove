<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Cadastro de Venda</TITLE>
	<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script src="js/Funcoes.js?ramdom=<?php echo time();?>"></script>    
    <script src="js/DialogsView.js?ramdom=<?php echo time();?>"></script> 
    <script src="js/VendasView.js?ramdom=<?php echo time();?>"></script>
</HEAD>
<BODY>
    <input type="hidden" name="codPerfil" id="codPerfil" value="">
    <table width='100%'>
        <tr>
            <td><input type="button" id="btnNovo" value="Nova Venda">
                <input type="button" id="btnPesquisa" value="Pesquisar Venda">
                <input type="button" value="Listar Vendas Abertas" id="btnVendasAbertas">
                <input type="button" value="Consultar NFe" id="btnNota">
                <input type="button" value="Reabrir Venda" id="btnReabrirVenda">
                <!--<input type="button" value="Cancelar NFe" id="btnCancelarNota" title="Cancelar Nota">-->
                <input type="button" value="Enviar Email" id="btnEnviarEmail" title="Enviar Email">
                <input type="button" value="Historico da Venda" id="btnHistoricoVenda" title="Historico da Venda">
            </td>
        </tr> 
        <tr>
            <td>
                <div id='jqxWidget'>
                    <div id='jqxTabsVendas'>
                        <ul>
                            <li>Vendas</li>
                            <li>Produtos</li>
                            <li>Pagamentos</li>
                        </ul>
                        <div>
                            <?php include_once("CadVendasView.php");?>
                        </div>
                        <div>
                            <?php include_once("ProdutosVendasView.php");?>
                        </div>
                        <div>
                            <?php include_once("FormaPagamentoVendasView.php");?>
                        </div>

                    </div> 

                </div>  
            </td>
        </tr>
        <tr>
            <td>
                <div id="VendasClienteForm">
                      <div id="windowHeader">
                      </div>
                      <div style="overflow: hidden;" id="windowContent">
                          <table>
                              <tr>
                                  <td id="tdListaVendasCliente">
                                      <div id="ListaVendasCliente"></div>
                                  </td>
                              </tr>
                          </table>
                      </div>            
                </div>    
            </td>
        </tr>
        <tr>
            <td>
                <div id="VendasAbertasForm">
                    <div id="windowHeader1">
                    </div>
                    <div id="windowContent1">
                        <table>
                            <tr>
                                <td id="tdListaVendasAbertas">
                                    <div id="ListaVendasAbertas"></div>
                                </td>
                            </tr>
                        </table>
                    </div>            
                </div>                 
            </td>
        </tr>
        <tr>
            <td>
                <div id="CadVeiculos">
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
                <div id="dialogJustificativa">
                    <div id="windowHeader">
                    </div>
                    <div style="overflow: hidden;" id="windowContent">
                        Existem descontos abaixo do valor mínimo do produto, por favor justifique!
                        <textarea id="txtJustificativa" name="txtJustificativa" cols="50" rows="5"></textarea><br>
                        <input type="button" value="Justificar" id="btnJustificar">
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
                <div id="AvisoVendasAbertas">
                    <div id="windowHeader">
                    </div>
                    <div style="overflow: hidden;" id="windowContent">
                    </div>            
                </div>  
            </td>
        </tr>
        <tr>
            <td>
                <div id="HistoricoVendaForm">
                    <div id="windowHeader">
                    </div>
                    <div style="overflow: auto;" id="windowContent">
                        <div id="Registros"></div>
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
    </div>
</BODY>
</HTML>
