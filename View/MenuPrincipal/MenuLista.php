<table width="100%">
    <tr>
        <td>
            <?
            if ($_SESSION['menuPai']!=''){
                $rs_localiza = $_SESSION['menuPai'];
                $total = count($rs_localiza);
                echo "<ul class=\"mlddm\">";
                for($i=0; $i<$total; $i++){
                      if ($rs_localiza[$i]['NME_METHOD']!=''){
                          echo "<li style=\"padding:0px;\"><a href=\"".$rs_localiza[$i]['NME_CONTROLLER']."?method=".$rs_localiza[$i]['NME_METHOD']."\">".$rs_localiza[$i]['DSC_MENU_W']."</a>";
                      }else{
                          echo "<li style=\"padding:0px;\"><a href=\"javascript:return false;\">".$rs_localiza[$i]['DSC_MENU_W']."</a>";
                      }
                      $rs_localiza_sub = $_SESSION['menuFilho'];
                      $totalSub = count($rs_localiza_sub);
                      If (empty($rs_localiza_sub)){
                          echo "</li>";
                      }else{
                            $criouUL=false;
                            for($j=0; $j<$totalSub; $j++){
                                $novoTotal = count($rs_localiza_sub[$j]);
                                for ($h=0; $h<$novoTotal; $h++){
                                    if ($rs_localiza[$i]["COD_MENU_W"]==$rs_localiza_sub[$j][$h]["COD_MENU_PAI_W"]){
                                        if (!$criouUL){
                                            echo "<ul>";
                                            $criouUL=true;
                                        }
                                        echo "<li><a href=\"".$rs_localiza_sub[$j][$h]['NME_CONTROLLER']."?method=".$rs_localiza_sub[$j][$h]['NME_METHOD']."\">".$rs_localiza_sub[$j][$h]['DSC_MENU_W']."</a></li>";
                                    }
                                }
                                if ($criouUL){
                                    echo "</ul>";
                                    $criouUL=false;
                                }

                            }
                            echo "</li>";

                      }

                }
                echo "</ul>";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <table width="20%" align="left" border="0" cellpadding="0" cellspacing="0">
                <tr style="background-image: url(../../Resources/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png);
                           background-size: 100px 30px;">
                    <td>
                        <?include_once("AtalhosView.php");?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>