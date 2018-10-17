<?php
include_once("../../Dao/BaseDao.php");
class GraficosVendaDao extends BaseDao
{
    Public Function GraficosVendaDao(){
        $this->conect();
    }

    Public Function SelecionaDados($codClienteFinal){
        $sql_lista = " SELECT MONTH(V.DTA_VENDA) AS MES,
                             SUM(CASE WHEN V.NRO_STATUS_VENDA = 'F' THEN (VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA ELSE 0 END) AS VLR_VENDA_FECHADA,
                             SUM(CASE WHEN V.NRO_STATUS_VENDA = 'A' THEN (VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA ELSE 0 END) AS VLR_VENDA_ABERTA,
                             SUM(CASE WHEN V.NRO_STATUS_VENDA = 'C' THEN (VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA ELSE 0 END) AS VLR_VENDA_CANCELADA,
                             SUM((VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA) AS VLR_VENDA
                        FROM EN_VENDA V
                       INNER JOIN RE_VENDA_PRODUTO VP
                          ON V.COD_VENDA = VP.COD_VENDA
                       WHERE YEAR(V.DTA_VENDA) = YEAR(NOW())
                       GROUP BY MES";
        return $this->selectDB("$sql_lista", false);
    }
}
?>
