<?
$listaAlteracoes = (unserialize(urldecode($_POST['ListaAlteracoes'])));
?>
<html>
<HEAD>
<TITLE>P&aacute;gina Principal</TITLE>
    <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    <link href="../../Resources/css/style.css" rel="stylesheet">
    <script src="../../Resources/JavaScript.js"></script>
    <link href="../../Resources/css/jquery-ui-1.10.0.custom.css" rel="stylesheet">
    <script src="../../Resources/js/jquery-1.9.0.js"></script>
    <script src="../../Resources/js/jquery-ui-1.10.0.custom.js"></script>
    <script src="../../Resources/js/svJavaScript.js"></script>
    <script src="js/ListaAlteracoesSistemaView.js"></script>
    <script>

    </script>
</head>
    <body>
        <div id="CadastroForm">
        <table width="100%">
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td class="TDTituloCabecalho">
                                Listagem de Alterações do Sistema
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" class="TabelaConteudo" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>&nbsp;</td>
                            <td class="TDTitulo">
                                Código
                            </td>
                            <td class="TDTitulo">
                                Descrição
                            </td>
                        </tr>
                        <?
                        $corLinha = "white";
                        $i=0;
                        $total = count($listaAlteracoes);
                        $vlrTotal = 0;
                        while ($i<$total){
                            if ($corLinha=="white"){
                                $corLinha="E8E8E8";
                            }else{
                                $corLinha="white";
                            }?>
                        <tr bgcolor="<?echo $corLinha?>" class="trcor" id="#trcor" title="<?echo $listaAlteracoes[$i]['DSC_ALTERACAO']?>">

                            <?;
                            if($listaAlteracoes[$i]['IND_EFETUADO']=="N"){?>
                               <td><img src="../../Resources/images/delete.png" width="20" height="20"></td>
                            <?}else{?>
                                <td><img src="../../Resources/images/visto.png" width="20" height="20"></td>
                            <?}?>
                            <td>
                                <?echo $listaAlteracoes[$i]['COD_ALTERACAO']?>
                            </td>
                            <td>
                                <?echo $listaAlteracoes[$i]['DSC_TITULO']?>
                            </td>
                        </tr>
                        <?
                         $i++;
                         }?>
                    </table>
                </td>
            </tr>
        </table>
        </div>
        <div id="dialogInformacao">
        </div>
    </body>
</html>