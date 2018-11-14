<?php

if (!isset($_SESSION)){
    session_start();
} 

if (!isset($_SESSION['cod_usuario'])){
    header("Location:../../index.php");
}
$rs_usuario = $_SESSION['DadosUsuario'];
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="../../Resources/JavaScript.js"></script>
        <link rel="stylesheet" href="../../Resources/css/style.css?random=<?php echo time();?>" type="text/css" />
        <link href="../../Resources/css/redmond/jquery-ui-1.10.3.custom.css" rel="stylesheet">
        <link rel="stylesheet" href="../../Resources/jqx/jqwidgets/styles/jqx.base.css" type="text/css" />
        <link rel="stylesheet" href="../../Resources/jqx/jqwidgets/styles/jqx.bootstrap.css" type="media" />
        <script src="../../Resources/js/jquery-1.9.0.js"></script>
        <script src="../../Resources/js/jquery-ui-1.10.0.custom.js"></script>
        <script src="../../Resources/js/jquery.maskedinput.js" type="text/javascript"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxcore.js"></script>       
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxchart.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxdata.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxinput.js"></script> 
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxbuttons.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxscrollbar.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxmenu.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxgrid.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxgrid.edit.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxgrid.sort.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxgrid.pager.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxgrid.columnsresize.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxgrid.filter.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxgrid.grouping.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxgrid.selection.js"></script> 
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxdata.js"></script> 
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxdata.export.js"></script> 
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxgrid.export.js"></script> 
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxlistbox.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxdropdownlist.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxcheckbox.js"></script> 
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxradiobutton.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxcalendar.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxnumberinput.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxmaskedinput.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxdatetimeinput.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/globalization/globalize.js"></script>        
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxwindow.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxtabs.js"></script>
        <script type="text/javascript" src="../../Resources/jqx/jqwidgets/jqxtooltip.js"></script>
        <script src="../../Resources/js/jquery.maskMoney.js"></script>
        <script src="../../View/MenuPrincipal/js/Cabecalho.js?random=<?php echo time();?>"></script>
        <script src="../../View/MenuPrincipal/js/Constantes.js?random=<?php echo time();?>"></script>
        <script src="../../View/MenuPrincipal/js/DialogsView.js"></script>
    </head>
    <body>
        <table width="100%">
            <tr>
                <td>
                    <div id="cabecalho">
                        <table width="100%" align="left" style="border:1px solid #a4bed4;">
                            <tr>
                                <td align="left" style="text-align:left; height:10%; font-size:14px;color:#000000;vertical-align:middle;font-family: arial, helvetica, serif;" width="30%">
                                    <?php echo $rs_usuario[1][0]['DSC_CLIENTE_FINAL'];?> <BR>
                                    Sistema de Vendas
                                </td>
                                <td align="left" style="text-align:left; height:10%;font-size:14px;color:#000000;vertical-align:middle;font-family: arial, helvetica, serif;">
                                    <?php
                                        echo "Usu&aacute;rio: ".$rs_usuario[1][0]['NME_USUARIO_COMPLETO'];
                                        echo "<BR>";
                                        echo"<a style=\"text-align:left;
                                                height:10%;
                                                font-size:10px;
                                                color:#0150D3;
                                                vertical-align:middle;
                                                font-family: arial, helvetica, serif;\" href=\"../../View/MenuPrincipal/MenuPrincipalView.php\">Clique aqui para p&aacute;gina inicial</a>";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div id="CriaMenu">

                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>
<div id="dialogInformacao">
  <div id="windowHeader">
  </div>
  <div style="overflow: hidden;" id="windowContent">
  </div>
</div>