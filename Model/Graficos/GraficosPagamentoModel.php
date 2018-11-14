<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Graficos/GraficosPagamentoDao.php");
class GraficosPagamentoModel extends BaseModel
{
    Public Function GraficosPagamentoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function SelecionaDados($Json=true){
        $dao = new GraficosPagamentoDao();
        $lista = $dao->SelecionaDados($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            for($i=0;$i<count($lista[1]);$i++){
                $lista[1][$i]['VLR_CONTA_ABERTA'] = number_format($lista[1][$i]['VLR_CONTA_ABERTA'],2,".","");
                $lista[1][$i]['VLR_CONTA_PAGA'] = number_format($lista[1][$i]['VLR_CONTA_PAGA'],2,".","");
                $lista[1][$i]['VLR_CONTA'] = number_format($lista[1][$i]['VLR_CONTA'],2,".","");
                $lista[1][$i]['DSC_MES'] = utf8_encode($this->meses[$lista[1][$i]['MES']-1]);
            }
            
        }        
        return json_encode($lista);
    }
}
?>
