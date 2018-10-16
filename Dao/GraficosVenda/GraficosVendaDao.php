<?php
include_once("../../Dao/BaseDao.php");
class GraficosVendaDao extends BaseDao
{
    Public Function GraficosVendaDao(){
        $this->conect();
    }

    Public Function SelecionaDados($codClienteFinal){
        $sql_lista = "SELECT MONTH(V.DTA_VENDA) AS MES, 
                             SUM(VP.VLR_VENDA) AS VLR_VENDA
                        FROM EN_VENDA V
                       INNER JOIN RE_VENDA_PRODUTO VP
                          ON V.COD_VENDA = VP.COD_VENDA
                       WHERE YEAR(V.DTA_VENDA) = YEAR(NOW())
                         AND V.NRO_STATUS_VENDA = 'F'
                       GROUP BY MES";
        return $this->selectDB("$sql_lista", false);
    }
}
?>
