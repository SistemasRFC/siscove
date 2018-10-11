<script src="../../View/Servico/js/CadServicoView.js?rdm=<?php echo time();?>"></script>
<input type="hidden" name="method" id="method" value="">
<input type="hidden" name="codServico" id="codServico" value="">
<table width="100%" align="left">
    <tr>
        <td colspan="3">
            <table width="50%" align="left">
                <tr>
                    <td>
                        <div id='jqxWidget'>
                            <div id='jqxTabsServicos'>
                                <ul>
                                    <li>Cadastro</li>
                                    <li>Receita</li>
                                </ul>
                                <div>
                                    <?php include_once("CadDadosServicosView.php"); ?>
                                </div>
                                <div>
                                    <?php include_once("CadDadosReceitaView.php"); ?>
                                </div>
                            </div> 
                        </div>                         
                    </td>
                </tr>
            </table>
        </td>
    </tr>   
    <tr>
        <td><input type="button" id="btnSalvar" value="Salvar"></td>
    </tr>
</table>