<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Cadastro de Veiculo</TITLE>
	<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script src="js/Funcoes.js"></script> 
    <script src="js/VeiculoView.js"></script>
</HEAD>
<BODY>
    <input type="hidden" name="method" id="method" value="">
    <table>
        <tr>
            <td><input type="button" id="btnNovo" value="Novo Veículo"></td>
        </tr>        
        <tr>
            <td>
                <div id="CadastroForm">
                      <div id="windowHeader">
                      </div>
                      <div style="overflow: hidden;" id="windowContent">
                          <?php include_once("CadVeiculoView.php");?>
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
