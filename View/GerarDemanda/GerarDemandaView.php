<?php include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<script src="js/GerarDemandaView.js?rdm=<?php echo time();?>"></script>
<html>
    <head>
        <title> Solicitações </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <table width="100%" id="CadastroDemanda">
            <tr>
                <td width="100%" style="text-align:left;height:10%;font-size:18px;color:#a4bed4;vertical-align:middle;font-family: arial, helvetica, serif;border-bottom: 1px solid #a4bed4;">
                    Cadastro de Solicitações
                </td>
            </tr>
            <tr>
                <td>
                    <table width="90%">
                        <tr>
                            <td class="TDTitulo">Título</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" id="txtTitulo" />
                            </td>
                        </tr>
                        <tr>
                            <td class="TDTitulo">Descrição</td>
                        </tr>
                        <tr>
                            <td>
                                <textarea id="dscSolicitação" rows="6" cols="60"></textarea>
                            </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td>
                                <input type="button" id="btnSalvarDemanda" value="Salvar Solicitação">
                            </td>
                        </tr>
                    </table>
                </td>              
            </tr>
        </table>
    </body>
</html>
