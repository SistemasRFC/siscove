<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Tipo de Pagamento - Cadastro</TITLE>
	<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script src="js/Funcoes.js"></script> 
    <script src="js/TipoPagamentoView.js"></script>
</HEAD>
<BODY>
    <table>
        <tr>
            <td><input type="button" id="btnNovo" value="Novo tipo de pagamento"></td>
        </tr>        
        <tr>
            <td>
                <div id="CadastroForm">
                      <div id="windowHeader">
                      </div>
                      <div style="overflow: hidden;" id="windowContent">
                          <?php include_once("CadTipoPagamentoView.php");?>
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
