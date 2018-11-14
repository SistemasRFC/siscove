<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Adiantamento de Recebimentos</TITLE>
	<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <script src="js/Funcoes.js"></script> 
    <script src="js/AdiantarRecebimentosView.js"></script>
</HEAD>
<BODY>
    <table width='100%'>
        <tr>
            <td>
                <table>
                    <tr>
                        <td width="20%" class="TDTitulo">
                            Data Início
                        </td>
                        <td width="20%"  class="TDTitulo">
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
                        <td width="20%" >
                            <input type="button" id="btnPesquisar" value="Pesquisar">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>   
            <tr>
                <td width="20%" >
                    <input type="button" class="btnSalvar"  value="Salvar">
                </td>
            </tr>            
        <tr>
            <td id="tdGrid">
                <div id="ListagemForm">
                </div>
            </td>
        </tr>

            <tr>
                <td width="20%" >
                    <input type="button" class="btnSalvar"  value="Salvar">
                </td>
            </tr>         
    </table>
</BODY>
</HTML>
