<?php
include_once("../../Dao/BaseDao.php");
class ComissaoPorProdutosDao extends BaseDao
{
    function ComissaoPorProdutosDao(){
        $this->conect();
    }

    function DadosComissao($codClienteFinal){
        $sql = " SELECT V.COD_VENDA,
                        V.DTA_VENDA,
                        COALESCE(C.DSC_CLIENTE,'') AS DSC_CLIENTE,
                        COALESCE(VE.DSC_VEICULO,'') AS DSC_VEICULO,
                        U.NME_USUARIO_COMPLETO AS NME_VENDEDOR,
                        UF.NME_USUARIO_COMPLETO AS NME_FUNCIONARIO,
                        P.DSC_PRODUTO,
                        SUM((VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA) AS VLR_VENDA_TOTAL,
                        SUM(
                        CASE WHEN P.IND_COMISSAO_GERENCIA='S' 
                             THEN (VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA*(UF.VLR_PORCENTAGEM_GERENCIA/100)
                             ELSE (VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA*(UF.VLR_PORCENTAGEM_SERVICO/100)
                        END) AS VLR_PORCENTAGEM_VENDA,
                        (SELECT SUM(CASE WHEN PE.IND_COMISSAO_GERENCIA='S'
                                         THEN (VPE.VLR_VENDA-VPE.VLR_DESCONTO)*VPE.QTD_VENDIDA*(UFE.VLR_PORCENTAGEM_GERENCIA/100)
                                         ELSE (VPE.VLR_VENDA-VP.VLR_DESCONTO)*VPE.QTD_VENDIDA*(UFE.VLR_PORCENTAGEM_SERVICO/100) 
                                    END) AS VLR_PORCENTAGEM_VENDA_TOTAL
                   FROM EN_VENDA VE
                   LEFT JOIN SE_USUARIO UE
                     ON VE.COD_USUARIO = UE.COD_USUARIO
                   LEFT JOIN RE_VENDA_PRODUTO VPE
                     ON VE.COD_VENDA = VPE.COD_VENDA
                   LEFT JOIN SE_USUARIO UFE
                     ON VPE.COD_FUNCIONARIO = UFE.COD_USUARIO
                  INNER JOIN EN_PRODUTO PE
                     ON VPE.COD_PRODUTO = PE.COD_PRODUTO
                  WHERE (VE.DTA_VENDA >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING))."'
                    AND VE.DTA_VENDA <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING))."')
                    AND VE.COD_CLIENTE_FINAL = $codClienteFinal
                    AND VE.NRO_STATUS_VENDA NOT IN ('C', 'O')";        
        $sql .= "   AND VPE.COD_PRODUTO IN (".filter_input(INPUT_POST, 'codProduto', FILTER_SANITIZE_STRING).")) AS VLR_PORCENTAGEM_VENDA_TOTAL
                   FROM EN_VENDA V
                   LEFT JOIN EN_CLIENTE C
                     ON V.COD_CLIENTE = C.COD_CLIENTE
                   LEFT JOIN EN_VEICULOS VE
                     ON V.COD_VEICULO = VE.COD_VEICULO
                   LEFT JOIN SE_USUARIO U
                     ON V.COD_USUARIO = U.COD_USUARIO
                   LEFT JOIN RE_VENDA_PRODUTO VP
                     ON V.COD_VENDA = VP.COD_VENDA
                   LEFT JOIN SE_USUARIO UF
                     ON VP.COD_FUNCIONARIO = UF.COD_USUARIO
                  INNER JOIN EN_PRODUTO P
                     ON VP.COD_PRODUTO = P.COD_PRODUTO
                 WHERE (V.DTA_VENDA >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING))."'
                   AND V.DTA_VENDA <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING))."')
                   AND V.COD_CLIENTE_FINAL = $codClienteFinal
                   AND V.NRO_STATUS_VENDA NOT IN ('C', 'O')";
        $sql .= "  AND VP.COD_PRODUTO IN (".filter_input(INPUT_POST, 'codProduto', FILTER_SANITIZE_STRING).")
                 GROUP BY V.COD_VENDA,
                          V.DTA_VENDA,
                          C.DSC_CLIENTE,
                          VE.DSC_VEICULO,
                          U.NME_USUARIO_COMPLETO,
                          UF.NME_USUARIO_COMPLETO ,
                          P.DSC_PRODUTO
                 ORDER BY V.DTA_VENDA, P.DSC_PRODUTO";
//        echo $sql; die;
        return $this->selectDB("$sql", false);
    }

}
?>
