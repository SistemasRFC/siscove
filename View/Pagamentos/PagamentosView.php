<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Pagamentos</TITLE>
	<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
        
    <script src="js/Funcoes.js?rdm=<?php echo time();?>"></script> 
    <script src="js/PagamentosView.js?rdm=<?php echo time();?>"></script>
</HEAD>
<BODY style="display: none;">
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>Ano</td>
                        <td>
                            <div id="comboNroAnoReferencia"></div>
                        </td>
                        <td>Mês</td>
                        <td>
                            <div id="comboNroMesReferencia"></div>
                        </td>
                        <td>
                        Tipo de Conta
                        </td>
                        <td>
                            <div id="comboTpoDespesa"></div>
                        </td>
                        <td>
                        Status
                        </td>
                        <td>
                            <div id="comboIndStatus"></div>
                            <select name="indStatus" id="indStatus" style="display:none">
                                <option value="-1">Todos</option>
                                <option value="N">Em Aberto</option>
                                <option value="S">Despesa Paga</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <input type="button" id="btnPesquisa" value="Pesquisar">
                        </td>
                        <td>
                            <input type="button" id="btnNovo" value="Nova Conta">
                        </td>  
                        <td>
                            <input type="button" id="btnExportar" value="Exportar">
                        </td>                       
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>                
                <table>
                    <tr>
                        <td>Valor Total</td>
                        <td>Valor Selecionado</td>
                    </tr>
                    <tr>
                        <td id="vlrTotal">0</td>
                        <td id="vlrSelecionado">0</td>
                    </tr>
                </table>
            </td>
        </tr>         
        <tr>
            <td>
                <div style="overflow:visible;" id="CadastroForm">
                      <div id="windowHeader">
                      </div>
                      <div id="windowContent">
                          <?php include_once("CadPagamentosView.php");?>
                      </div>            
                </div>  
            </td>
        </tr>
        <tr>
            <td>
                <div style="overflow:visible;" id="ChequesRecebidos">
                      <div id="windowHeader">
                      </div>
                      <div id="windowContent">
                          <?php include_once("CadChequesRecebidosView.php");?>
                      </div>            
                </div>  
            </td>
        </tr>
        <tr>
            <td>
                <div style="overflow:visible;" id="InformaPagamento">
                      <div id="windowHeader">
                      </div>
                      <div id="windowContent">
                          <?php include_once("CadInformaPagamentoView.php");?>
                      </div>            
                </div>  
            </td>
        </tr>
        <tr>
            <td id="tdGrid">
                <div id="ListagemForm">
                </div>
            </td>
        </tr>
    </table>
</BODY>
</HTML>
