<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Cadastro de Dep&oacute;sito</TITLE>
	<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script src="js/Funcoes.js"></script> 
    <script src="js/DepositoView.js"></script>

</script>
</HEAD>
<BODY>
    <input type="hidden" id="method">
    <table>
        <tr>
            <td><input type="button" id="btnNovo" value="Novo Depósito"></td>
        </tr>        
        <tr>
            <td>
                <div id="CadastroForm">
                      <div id="windowHeader">
                      </div>
                      <div style="overflow: hidden;" id="windowContent">
                          <?php include_once("CadDepositoView.php");?>
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