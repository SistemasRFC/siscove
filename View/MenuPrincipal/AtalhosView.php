<?
$colunas = 8;
$i=8;
$rs_localiza = $_SESSION['ListaAtalhos'];?>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
<?for($j=0;$j<count($rs_localiza);$j++){
     if ($i==$colunas){?>
        <tr>
            <td>
     <?$i=0;}?>
        
            <a href="<?echo $rs_localiza[$j]['NME_CONTROLLER']."?method=".$rs_localiza[$j]['NME_METHOD'];?>">
                <img src="<?echo $rs_localiza[$j]['DSC_CAMINHO_IMAGEM'];?>" width="105" height="105" border="0" title="<?echo $rs_localiza[$j]['DSC_MENU_W'];?>">
            </a>
        
     <?$i++;
     if ($i==$colunas){?>
                </td>
        </tr>
     <?}
     ?>
    <?}?>
        
</table>

