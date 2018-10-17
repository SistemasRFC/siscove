<?php
include_once("../../Dao/BaseDao.php");
class GraficosPagamentoDao extends BaseDao
{
    Public Function GraficosPagamentoDao(){
        $this->conect();
    }

    Public Function SelecionaDados($codClienteFinal){
        $sql_lista = "SELECT MONTH(DTA_VENCIMENTO) AS MES,
                             SUM(CASE WHEN IND_CONTA_PAGA = 'N' THEN VLR_CONTA ELSE 0 END) AS VLR_CONTA_ABERTA,
                             SUM(CASE WHEN IND_CONTA_PAGA = 'S' THEN VLR_CONTA ELSE 0 END) AS VLR_CONTA_PAGA,
                             SUM(VLR_CONTA) AS VLR_CONTA
                        FROM EN_CONTAS_A_PAGAR
                       WHERE YEAR(DTA_VENCIMENTO) = YEAR(NOW())
                       GROUP BY MES";
        return $this->selectDB("$sql_lista", false);
    }
}
?>
