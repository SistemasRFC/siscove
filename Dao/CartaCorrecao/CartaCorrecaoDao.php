<?php
include_once("../../Dao/BaseDao.php");
class CartaCorrecaoDao extends BaseDao
{
    Public Function CartaCorrecaoDao(){
        $this->conect();
    }

    Public Function ListarSequenciaisGrid(){
        $sql = " SELECT COD_VENDA,
                        REFERENCIA,
                        DTA_NOTA,
                        COD_USUARIO,
                        TPO_NOTA,
                        VLR_NOTA
                   FROM (
                 SELECT VRD.COD_VENDA AS COD_VENDA,
                        CONCAT('D', VRD.COD_VENDA, '00', VRD.NRO_SEQUENCIAL) AS REFERENCIA,
                        DATE_FORMAT(VRD.DTA_EMISSAO_NOTA, '%d/%m/%Y') AS DTA_NOTA,
                        VRD.COD_USUARIO AS COD_USUARIO,
                        'ENTRADA ESTOQUE' AS TPO_NOTA,
                        FORMAT(COALESCE(SUM(EE.VLR_UNITARIO*EE.QTD_ENTRADA),0), 2, 'de_DE') AS VLR_NOTA
                   FROM EN_ENTRADA E
                  INNER JOIN EN_VENDA_REFERENCIA_DEVOLUCAO VRD
                     ON E.NRO_SEQUENCIAL = VRD.COD_VENDA
                    AND VRD.IND_STATUS_REFERENCIA = 'A'
                   LEFT JOIN EN_ENTRADA_ESTOQUE EE
                     ON E.NRO_SEQUENCIAL = EE.NRO_SEQUENCIAL
                  WHERE E.IND_ENTRADA = 'F'
                  GROUP BY VRD.COD_VENDA
                 UNION
                 SELECT V.COD_VENDA AS COD_VENDA,
                        CONCAT(VR.COD_VENDA, '00', VR.NRO_SEQUENCIAL) AS REFERENCIA,
                        DATE_FORMAT(VR.DTA_EMISSAO_NOTA, '%d/%m/%Y') AS DTA_NOTA,
                        VR.COD_USUARIO AS COD_USUARIO,
                        'VENDA' AS TPO_NOTA,
                        FORMAT(SUM(VPG.VLR_PAGAMENTO), 2, 'de_DE') AS VLR_NOTA
                   FROM EN_VENDA V
                  INNER JOIN EN_VENDA_REFERENCIA VR
                     ON V.COD_VENDA = VR.COD_VENDA
                    AND VR.IND_STATUS_REFERENCIA = 'A'
                  INNER JOIN EN_VENDA_PAGAMENTO VPG
                     ON V.COD_VENDA = VPG.COD_VENDA
                  WHERE V.NRO_STATUS_VENDA = 'F'
                  GROUP BY V.COD_VENDA) AS X";

        return $this->selectDB($sql, false);
    }

    Public Function DadosEntrada(){
        $sql = " SELECT E.NRO_SEQUENCIAL,
                        E.DTA_ENTRADA,
                        F.NRO_CNPJ,
                        F.NME_FORNECEDOR
                   FROM EN_ENTRADA E
                  INNER JOIN EN_FORNECEDOR F
                     ON E.COD_FORNECEDOR = F.COD_FORNECEDOR
                  INNER JOIN EN_VENDA_REFERENCIA_DEVOLUCAO VRD
                     ON E.NRO_SEQUENCIAL = VRD.COD_VENDA
                  WHERE VRD.COD_VENDA = ".filter_input(INPUT_GET, 'codVenda', FILTER_SANITIZE_NUMBER_INT);

        return $this->selectDB($sql, false);
    }

    Public Function DadosProdutosEntrada(){
        $sql = " SELECT P.DSC_PRODUTO,
                        M.DSC_MARCA,
                        EE.VLR_UNITARIO,
                        EE.QTD_ENTRADA,
                        (EE.VLR_UNITARIO*EE.QTD_ENTRADA) AS VALOR_TOTAL
                   FROM EN_ENTRADA_ESTOQUE EE
                  INNER JOIN EN_PRODUTO P
                     ON EE.COD_PRODUTO = P.COD_PRODUTO
                  INNER JOIN EN_MARCA M
                     ON P.COD_MARCA = M.COD_MARCA
                  INNER JOIN EN_ENTRADA E
                     ON EE.NRO_SEQUENCIAL = E.NRO_SEQUENCIAL
                  INNER JOIN EN_VENDA_REFERENCIA_DEVOLUCAO VRD
                     ON E.NRO_SEQUENCIAL = VRD.COD_VENDA
                  WHERE VRD.COD_VENDA = ".filter_input(INPUT_GET, 'codVenda', FILTER_SANITIZE_NUMBER_INT);

        return $this->selectDB($sql, false);
    }
}
?>