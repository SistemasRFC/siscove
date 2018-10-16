<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/GraficosVenda/GraficosVendaDao.php");
class GraficosVendaModel extends BaseModel
{
    Public Function GraficosVendaModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function SelecionaDados($Json=true){
        $dao = new GraficosVendaDao();
        $lista = $dao->SelecionaDados($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            for($i=0;$i<count($lista[1]);$i++){
                $lista[1][$i]['VLR_VENDA'] = number_format($lista[1][$i]['VLR_VENDA'],2,".","");
                $lista[1][$i]['DSC_MES'] = utf8_encode($this->meses[$lista[1][$i]['MES']-1]);
            }
            
        }        
        return json_encode($lista);
    }
}
?>
