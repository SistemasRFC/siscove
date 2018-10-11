<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
<HEAD>
<TITLE>Pagamentos</TITLE>
	<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
        
    <script src="js/Funcoes.js?rdm=<?php echo time();?>"></script> 
    <script src="js/CadChequesRecebidosView.js?rdm=<?php echo time();?>"></script>
</HEAD>
<BODY>
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <input type="button" id="btnPesquisaCheques" value="Pesquisar Cheques">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>         
        <tr>
            <td id="tdGridChequesRecebidos">
                <div id="ListagemFormChequesRecebidos">
                </div>
            </td>
        </tr>
    </table>
</BODY>
</HTML>
