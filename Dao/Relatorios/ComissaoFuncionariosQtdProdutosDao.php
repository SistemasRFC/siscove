<?php
include_once("../../Dao/BaseDao.php");
class ComissaoFuncionariosQtdProdutosDao extends BaseDao
{
    function ComissaoFuncionariosQtdProdutosDao(){
        $this->conect();
    }

    function DadosComissao($codClienteFinal){
        $sql_lista = "SELECT V.COD_VENDA,
                             V.DTA_VENDA,
                             COALESCE(C.DSC_CLIENTE,'') AS DSC_CLIENTE,
                             COALESCE(VE.DSC_VEICULO,'') AS DSC_VEICULO,
                             U.NME_USUARIO_COMPLETO AS NME_VENDEDOR,
                              UF.NME_USUARIO_COMPLETO AS NME_FUNCIONARIO,
                             P.DSC_PRODUTO,
                             VP.QTD_VENDIDA,
                             VP.VLR_VENDA,
                             VP.VLR_DESCONTO,
                             QTD_VENDIDA * (VP.VLR_VENDA) AS VLR_VENDA_TOTAL,
                             QTD_VENDIDA * (VP.VLR_VENDA-VP.VLR_DESCONTO) AS VLR_VENDA_TOTAL_COM_DESCONTO,
                             (VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA*(UF.VLR_PORCENTAGEM_GERENCIA/100) AS VLR_PORCENTAGEM_VENDA
                        FROM EN_VENDA V
                       INNER JOIN RE_VENDA_PRODUTO VP
                          ON V.COD_VENDA = VP.COD_VENDA
                       INNER JOIN EN_PRODUTO P
                          ON VP.COD_PRODUTO = P.COD_PRODUTO
                        LEFT JOIN EN_CLIENTE C
                          ON V.COD_CLIENTE = C.COD_CLIENTE
                        LEFT JOIN EN_VEICULOS VE
                          ON V.COD_VEICULO = VE.COD_VEICULO
                        LEFT JOIN SE_USUARIO U
                          ON V.COD_USUARIO = U.COD_USUARIO
                        LEFT JOIN SE_USUARIO UF
                          ON VP.COD_FUNCIONARIO = UF.COD_USUARIO
                       WHERE P.TPO_PRODUTO = 'S'
                         AND P.IND_COMISSAO_GERENCIA = 'S'
                         AND (V.DTA_VENDA >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING))."'
                         AND V.DTA_VENDA <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING))."')
                         AND V.COD_CLIENTE_FINAL = $codClienteFinal
                         AND V.NRO_STATUS_VENDA NOT IN ('C', 'O')
                       GROUP BY V.COD_VENDA, VP.COD_PRODUTO";        
        return $this->selectDB("$sql_lista", false);
    }

}
?>
