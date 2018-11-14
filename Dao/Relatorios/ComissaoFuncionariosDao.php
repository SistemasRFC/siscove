<?php
include_once("../../Dao/BaseDao.php");
class ComissaoFuncionariosDao extends BaseDao
{
    function ComissaoFuncionariosDao(){
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
                              (SELECT SUM(CASE WHEN PE.IND_COMISSAO_GERENCIA='S' THEN (VPE.VLR_VENDA-VPE.VLR_DESCONTO)*VPE.QTD_VENDIDA*(UFE.VLR_PORCENTAGEM_GERENCIA/100)ELSE (VPE.VLR_VENDA-VP.VLR_DESCONTO)*VPE.QTD_VENDIDA*(UFE.VLR_PORCENTAGEM_SERVICO/100) END) AS VLR_PORCENTAGEM_VENDA_TOTAL
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
                      if (filter_input(INPUT_POST, 'indGerencia', FILTER_SANITIZE_STRING)=='S'){
                         $sql .= " AND PE.IND_COMISSAO_GERENCIA = 'S'";
                      }else{
                         $sql .= " AND (COALESCE(PE.IND_COMISSAO_GERENCIA,'') = '' OR PE.IND_COMISSAO_GERENCIA='N')";
                      }
                      $sql .= "   
                                  AND VPE.COD_FUNCIONARIO = ".filter_input(INPUT_POST, 'codFuncionario', FILTER_SANITIZE_NUMBER_INT).") AS VLR_PORCENTAGEM_VENDA_TOTAL
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
                      if (filter_input(INPUT_POST, 'indGerencia', FILTER_SANITIZE_STRING)=='S'){
                         $sql .= " AND P.IND_COMISSAO_GERENCIA = 'S'";
                      }else{
                         $sql .= " AND (COALESCE(P.IND_COMISSAO_GERENCIA,'') = '' OR P.IND_COMISSAO_GERENCIA = 'N') ";
                      }
                      $sql .= "   AND VP.COD_FUNCIONARIO = ".filter_input(INPUT_POST, 'codFuncionario', FILTER_SANITIZE_NUMBER_INT)."
                       GROUP BY V.COD_VENDA,
                                V.DTA_VENDA,
                                C.DSC_CLIENTE,
                                VE.DSC_VEICULO,
                                U.NME_USUARIO_COMPLETO,
                                UF.NME_USUARIO_COMPLETO ,
                                P.DSC_PRODUTO";
        return $this->selectDB("$sql", false);
    }

}
?>
