<?php
include_once("../../Dao/BaseDao.php");
class CartaCorrecaoDao extends BaseDao
{
    Public Function CartaCorrecaoDao(){
        $this->conect();
    }

    Public Function ListarSequenciaisGrid(){
        $sql = "SELECT COD_MOVIMENTACAO,
                       NRO_SEQUENCIAL,
                       DTA_NOTA,
                       COD_USUARIO,
                       TPO_NOTA,
                       VLR_NOTA
                  FROM (
                SELECT '' AS COD_MOVIMENTACAO,
                       E.NRO_SEQUENCIAL AS NRO_SEQUENCIAL,
                       E.DTA_ENTRADA AS DTA_NOTA,
                       E.COD_USUARIO AS COD_USUARIO,
                       'ENTRADA ESTOQUE' AS TPO_NOTA,
                       COALESCE(SUM(EE.VLR_UNITARIO*EE.QTD_ENTRADA),0) AS VLR_NOTA
                  FROM EN_ENTRADA E
                  LEFT JOIN EN_ENTRADA_ESTOQUE EE
                    ON E.NRO_SEQUENCIAL = EE.NRO_SEQUENCIAL
                 WHERE E.IND_ENTRADA = 'F'
                   AND NRO_NOTA_FISCAL <> ''
                 GROUP BY E.NRO_SEQUENCIAL
                UNION
                SELECT V.COD_VENDA AS COD_MOVIMENTACAO,
                       VP.NRO_SEQUENCIAL AS NRO_SEQUENCIAL,
                       VR.DTA_EMISSAO_NOTA AS DTA_NOTA,
                       VR.COD_USUARIO AS COD_USUARIO,
                       'VENDA' AS TPO_NOTA,
                       VPG.VLR_PAGAMENTO AS VLR_NOTA
                  FROM EN_VENDA V
                 INNER JOIN EN_VENDA_REFERENCIA VR
                    ON V.COD_VENDA = VR.COD_VENDA
                   AND VR.IND_STATUS_REFERENCIA = 'A'
                  LEFT JOIN RE_VENDA_PRODUTO VP
                    ON V.COD_VENDA = VP.COD_VENDA
                 INNER JOIN EN_VENDA_PAGAMENTO VPG
                    ON V.COD_VENDA = VPG.COD_VENDA
                 WHERE V.NRO_STATUS_VENDA = 'F'
                 GROUP BY V.COD_VENDA) AS X";

        return $this->selectDB($sql, false);
    }
}
?>