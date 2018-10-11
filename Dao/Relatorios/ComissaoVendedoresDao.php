<?php
include_once("../../Dao/BaseDao.php");
class ComissaoVendedoresDao extends BaseDao
{
    function ComissaoVendedoresDao(){
        $this->conect();
    }

    Public Function DadosComissao($codClienteFinal){
        $sql = "SELECT V.COD_VENDA,
                             V.DTA_VENDA,
                             COALESCE(C.DSC_CLIENTE,'') AS DSC_CLIENTE,
                             COALESCE(VE.DSC_VEICULO,'') AS DSC_VEICULO,
                             U.NME_USUARIO_COMPLETO AS NME_VENDEDOR,
                             SUM(VP.VLR_PAGAMENTO) AS VLR_VENDA_TOTAL,
                             SUM(VP.VLR_PAGAMENTO)*(U.VLR_PORCENTAGEM_VENDA/100) AS VLR_PORCENTAGEM_VENDA,
                             (SELECT SUM(VPE.VLR_PAGAMENTO*(UE.VLR_PORCENTAGEM_VENDA/100))
                                FROM EN_VENDA VE
                                LEFT JOIN SE_USUARIO UE
                                  ON VE.COD_USUARIO = UE.COD_USUARIO
                                LEFT JOIN EN_VENDA_PAGAMENTO VPE
                                  ON VE.COD_VENDA = VPE.COD_VENDA
                                 AND VPE.COD_TIPO_PAGAMENTO NOT IN (5)
                               WHERE VE.DTA_VENDA >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING))."'
                                 AND VE.DTA_VENDA <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING))."'
                                 AND VE.COD_CLIENTE_FINAL = $codClienteFinal
                                 AND VE.NRO_STATUS_VENDA IN ('F')
                                 AND VE.COD_USUARIO = ".filter_input(INPUT_POST, 'codFuncionario', FILTER_SANITIZE_NUMBER_INT).") AS VLR_PORCENTAGEM_VENDA_TOTAL                               
                        FROM EN_VENDA V
                        LEFT JOIN EN_CLIENTE C
                          ON V.COD_CLIENTE = C.COD_CLIENTE
                        LEFT JOIN EN_VEICULOS VE
                          ON V.COD_VEICULO = VE.COD_VEICULO
                        LEFT JOIN SE_USUARIO U
                          ON V.COD_USUARIO = U.COD_USUARIO
                        LEFT JOIN EN_VENDA_PAGAMENTO VP
                          ON V.COD_VENDA = VP.COD_VENDA
                         AND VP.COD_TIPO_PAGAMENTO NOT IN (5)
                       WHERE V.DTA_VENDA >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING))."'
                         AND V.DTA_VENDA <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING))."'
                         AND V.COD_CLIENTE_FINAL = $codClienteFinal
                         AND V.NRO_STATUS_VENDA IN ('F')
                         AND V.COD_USUARIO = ".filter_input(INPUT_POST, 'codFuncionario', FILTER_SANITIZE_NUMBER_INT)."
                       GROUP BY V.COD_VENDA,
                                V.DTA_VENDA,
                                C.DSC_CLIENTE,
                                VE.DSC_VEICULO,
                                U.NME_USUARIO_COMPLETO"; 
        //echo $sql; die;
        return $this->selectDB("$sql", false);
    }

}
?>
