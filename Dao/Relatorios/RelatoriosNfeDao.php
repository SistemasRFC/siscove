<?php
include_once("../../Dao/BaseDao.php");
class RelatoriosNfeDao extends BaseDao
{
    Public Function RelatoriosNfeDao(){
        $this->conect();
    }

    Public Function ListarNotasEmitidas($codClienteFinal){
        $sql = "SELECT V.COD_VENDA, 
                       CONCAT(V.COD_VENDA,'00',LPAD(VR.NRO_SEQUENCIAL,2,'0')) AS COD_REFERENCIA, 
                       CASE WHEN COALESCE(C.IND_TIPO_CLIENTE,'F') = 'F' THEN C.NRO_CPF ELSE C.NRO_CNPJ END AS CPF_CLIENTE, 
                       C.DSC_CLIENTE, 
                       V.DTA_VENDA,
                       SUM((VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA) AS VLR_TOTAL_VENDA, 
                       VR.DTA_EMISSAO_NOTA AS DTA_EMISSAO
                  FROM EN_VENDA_REFERENCIA VR
                 INNER JOIN EN_VENDA V
                    ON VR.COD_VENDA = V.COD_VENDA
                 INNER JOIN EN_CLIENTE C
                    ON V.COD_CLIENTE = C.COD_CLIENTE
                 INNER JOIN RE_VENDA_PRODUTO VP
                    ON V.COD_VENDA = VP.COD_VENDA
                 WHERE DTA_EMISSAO_NOTA >='".$this->Populate('dtaInicioNfe', 'D')."'
                   AND DTA_EMISSAO_NOTA <='".$this->Populate('dtaFimNfe', 'D')."'
                   AND VR.IND_STATUS_REFERENCIA = 'A'
                   AND V.COD_CLIENTE_FINAL = $codClienteFinal
                 GROUP BY COD_REFERENCIA";
        return $this->selectDB($sql, false);
    }
}
?>
