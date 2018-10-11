<?php
include_once("../../Dao/BaseDao.php");
class RelatoriosVendasDao extends BaseDao
{
    Public Function RelatoriosVendasDao(){
        $this->conect();
    }

    Public Function DadosVenda($codClienteFinal){
        $sql_lista = "SELECT V.COD_VENDA,
                             V.DTA_VENDA,
                             C.NRO_CPF,
                             C.DSC_CLIENTE,
                             U.NME_USUARIO_COMPLETO,
                             VE.DSC_VEICULO,
                             V.NRO_PLACA,
                             C.NRO_TELEFONE_CONTATO,
                             C.NRO_TELEFONE_CELULAR
                        FROM EN_VENDA V
                        LEFT JOIN EN_CLIENTE C
                          ON V.COD_CLIENTE = C.COD_CLIENTE
                        LEFT JOIN SE_USUARIO U
                          ON V.COD_USUARIO = U.COD_USUARIO
                        LEFT JOIN EN_VEICULOS VE
                          ON V.COD_VEICULO = VE.COD_VEICULO
                       WHERE V.COD_CLIENTE_FINAL = $codClienteFinal
                         AND V.COD_VENDA = ".filter_input(INPUT_GET, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
        return $this->selectDB("$sql_lista", false);
    }

    Public Function DadosProdutosVenda(){
        $sql_lista = "SELECT P.DSC_PRODUTO,
                             VP.VLR_VENDA,
                             VP.QTD_VENDIDA,
                             VP.VLR_DESCONTO,
                             (VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA AS VLR_TOTAL,
                             U.NME_USUARIO_COMPLETO,
                             VP.TXT_OBSERVACAO,
                             COALESCE(M.DSC_MARCA,'') AS DSC_MARCA
                        FROM RE_VENDA_PRODUTO VP
                       INNER JOIN EN_PRODUTO P
                          ON VP.COD_PRODUTO = P.COD_PRODUTO
                        LEFT JOIN EN_MARCA M
                          ON P.COD_MARCA = M.COD_MARCA
                        LEFT JOIN SE_USUARIO U
                          ON VP.COD_FUNCIONARIO = U.COD_USUARIO
                       WHERE VP.COD_VENDA = ".filter_input(INPUT_GET, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
        return $this->selectDB("$sql_lista", false);
    }

    Public Function DadosPagamentosVenda($codVenda=NULL){
        $codVenda = $codVenda==NULL?filter_input(INPUT_GET, 'codVenda', FILTER_SANITIZE_NUMBER_INT):$codVenda;
        $sql_lista = "SELECT DTA_PAGAMENTO,
                             VLR_PAGAMENTO,
                             TP.DSC_TIPO_PAGAMENTO,
                             COALESCE(TP.VLR_PORCENTAGEM,0) AS VLR_PORCENTAGEM,
                             VP.VLR_PAGAMENTO - (VP.VLR_PAGAMENTO*COALESCE(TP.VLR_PORCENTAGEM,0)/100) AS VLR_PAGAMENTO_LIQUIDO
                        FROM EN_VENDA_PAGAMENTO VP
                        LEFT JOIN EN_TIPO_PAGAMENTO TP
                          ON VP.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                       WHERE VP.COD_VENDA = ".$codVenda;
        return $this->selectDB("$sql_lista", false);
    }

    Public Function DadosPagamentosResumidoVenda($codVenda=NULL){
        $codVenda = $codVenda==NULL?filter_input(INPUT_GET, 'codVenda', FILTER_SANITIZE_NUMBER_INT):$codVenda;
        $sql_lista = "SELECT SUM(CASE WHEN TP.COD_TIPO_PAGAMENTO = 5 THEN 0 ELSE VLR_PAGAMENTO END) AS VLR_PAGAMENTO,
                             TP.DSC_TIPO_PAGAMENTO,
                             COALESCE(TP.VLR_PORCENTAGEM,0) AS VLR_PORCENTAGEM,
                             SUM(CASE WHEN TP.COD_TIPO_PAGAMENTO = 5 THEN 0 ELSE VP.VLR_PAGAMENTO - (VP.VLR_PAGAMENTO*COALESCE(TP.VLR_PORCENTAGEM,0)/100) END ) AS VLR_PAGAMENTO_LIQUIDO
                        FROM EN_VENDA_PAGAMENTO VP
                        LEFT JOIN EN_TIPO_PAGAMENTO TP
                          ON VP.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                       WHERE VP.COD_VENDA = ".$codVenda. "
                       GROUP BY TP.DSC_TIPO_PAGAMENTO ";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function VendasFechadas($codClienteFinal){
        $sql_lista = "SELECT V.COD_VENDA,
                             V.DTA_VENDA,
                             COALESCE(C.DSC_CLIENTE,'') AS DSC_CLIENTE,
                             U.NME_USUARIO_COMPLETO,
                             COALESCE(VE.DSC_VEICULO,'') AS DSC_VEICULO,
                             V.NRO_PLACA,
                             SUM((VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA) AS VLR_VENDA
                        FROM EN_VENDA V
                        LEFT JOIN EN_CLIENTE C
                          ON V.COD_CLIENTE = C.COD_CLIENTE
                        LEFT JOIN SE_USUARIO U
                          ON V.COD_USUARIO = U.COD_USUARIO
                        LEFT JOIN EN_VEICULOS VE
                          ON V.COD_VEICULO = VE.COD_VEICULO
                        LEFT JOIN RE_VENDA_PRODUTO VP
                          ON V.COD_VENDA = VP.COD_VENDA
                       WHERE V.COD_CLIENTE_FINAL = $codClienteFinal
                         AND V.DTA_VENDA >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING))."'
                         AND V.DTA_VENDA <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING))."'
                         AND V.NRO_STATUS_VENDA = 'F'
                       GROUP BY V.COD_VENDA,
                             V.DTA_VENDA,
                             C.DSC_CLIENTE,
                             U.NME_USUARIO_COMPLETO,
                             VE.DSC_VEICULO,
                             V.NRO_PLACA";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function VendasAbertas($codClienteFinal){
        $sql_lista = "SELECT V.COD_VENDA,
                             V.DTA_VENDA,
                             COALESCE(C.DSC_CLIENTE,'') AS DSC_CLIENTE,
                             U.NME_USUARIO_COMPLETO,
                             COALESCE(VE.DSC_VEICULO,'') AS DSC_VEICULO,
                             V.NRO_PLACA,
                             SUM((VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA) AS VLR_VENDA
                        FROM EN_VENDA V
                        LEFT JOIN EN_CLIENTE C
                          ON V.COD_CLIENTE = C.COD_CLIENTE
                        LEFT JOIN SE_USUARIO U
                          ON V.COD_USUARIO = U.COD_USUARIO
                        LEFT JOIN EN_VEICULOS VE
                          ON V.COD_VEICULO = VE.COD_VEICULO
                        LEFT JOIN RE_VENDA_PRODUTO VP
                          ON V.COD_VENDA = VP.COD_VENDA
                       WHERE V.COD_CLIENTE_FINAL = $codClienteFinal
                         AND V.DTA_VENDA >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING))."'
                         AND V.DTA_VENDA <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING))."'
                         AND V.NRO_STATUS_VENDA = 'A'
                       GROUP BY V.COD_VENDA,
                             V.DTA_VENDA,
                             C.DSC_CLIENTE,
                             U.NME_USUARIO_COMPLETO,
                             VE.DSC_VEICULO,
                             V.NRO_PLACA";
        return $this->selectDB("$sql_lista", false);
    }

    /**
     * Retorna uma lista de vendas que foram justificadas por terem produtos abaixo do preço mínimo de venda.
     * @param Int $codClienteFinal
     * @return Array
     */
    Public Function VendasJustificadas($codClienteFinal){
        $sql_lista = "SELECT V.COD_VENDA,
                             V.DTA_VENDA,
                             COALESCE(C.DSC_CLIENTE,'') AS DSC_CLIENTE,
                             U.NME_USUARIO_COMPLETO,
                             COALESCE(VE.DSC_VEICULO,'') AS DSC_VEICULO,
                             V.NRO_PLACA,
                             SUM((VP.VLR_VENDA-VP.VLR_DESCONTO)*VP.QTD_VENDIDA) AS VLR_VENDA,
                             V.TXT_JUSTIFICATIVA
                        FROM EN_VENDA V
                        LEFT JOIN EN_CLIENTE C
                          ON V.COD_CLIENTE = C.COD_CLIENTE
                        LEFT JOIN SE_USUARIO U
                          ON V.COD_USUARIO = U.COD_USUARIO
                        LEFT JOIN EN_VEICULOS VE
                          ON V.COD_VEICULO = VE.COD_VEICULO
                        LEFT JOIN RE_VENDA_PRODUTO VP
                          ON V.COD_VENDA = VP.COD_VENDA
                       WHERE V.COD_CLIENTE_FINAL = $codClienteFinal
                         AND V.DTA_VENDA >= '".$this->ConverteDataForm($form->getDtaVendaInicio())."'
                         AND V.DTA_VENDA <= '".$this->ConverteDataForm($form->getDtaVendaFim())."'
                         AND V.NRO_STATUS_VENDA = 'F'
                         AND V.TXT_JUSTIFICATIVA <> ''
                         AND V.TXT_JUSTIFICATIVA IS NOT NULL
                       GROUP BY V.COD_VENDA,
                             V.DTA_VENDA,
                             C.DSC_CLIENTE,
                             U.NME_USUARIO_COMPLETO,
                             VE.DSC_VEICULO,
                             V.NRO_PLACA";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function PagamentosRecebidos($codClienteFinal){
        $sql_lista = "SELECT V.COD_VENDA,
                             V.DTA_VENDA,
                             VP.VLR_PAGAMENTO,
                             VP.VLR_PAGAMENTO AS VLR_TOTAL,
                             VP.DTA_PAGAMENTO,
                             VP.NRO_SEQUENCIAL,
                             TP.DSC_TIPO_PAGAMENTO
                        FROM EN_VENDA V
                       INNER JOIN EN_VENDA_PAGAMENTO VP
                          ON V.COD_VENDA = VP.COD_VENDA
                       INNER JOIN EN_TIPO_PAGAMENTO TP
                          ON VP.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                       WHERE V.COD_CLIENTE_FINAL = $codClienteFinal
                         AND VP.DTA_PAGAMENTO >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING))."'
                         AND VP.DTA_PAGAMENTO <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING))."'
                         AND V.NRO_STATUS_VENDA = 'F'";
        if (filter_input(INPUT_POST, 'codTipoPagamento', FILTER_SANITIZE_NUMBER_INT)!=0){
            $sql_lista .= " AND VP.COD_TIPO_PAGAMENTO = ".filter_input(INPUT_POST, 'codTipoPagamento', FILTER_SANITIZE_NUMBER_INT);
        }
        $sql_lista .= " GROUP BY V.COD_VENDA, VP.NRO_SEQUENCIAL
                        ORDER BY VP.DTA_PAGAMENTO";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function PagamentosRecebidosAtual($codClienteFinal){
        $sql_lista = "SELECT V.COD_VENDA,
                             V.DTA_VENDA,
                             VP.VLR_PAGAMENTO,
                             VP.VLR_PAGAMENTO AS VLR_TOTAL,
                             VP.DTA_PAGAMENTO,
                             VP.NRO_SEQUENCIAL
                        FROM EN_VENDA V
                       INNER JOIN EN_VENDA_PAGAMENTO VP
                          ON V.COD_VENDA = VP.COD_VENDA
                       WHERE V.COD_CLIENTE_FINAL = $codClienteFinal
                         AND (VP.DTA_PAGAMENTO >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING))."'
                         AND VP.DTA_PAGAMENTO <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING))."'
                         AND V.DTA_VENDA >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING))."'
                         AND V.DTA_VENDA <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING))."')
                         AND V.NRO_STATUS_VENDA = 'F'
                       GROUP BY V.COD_VENDA, VP.NRO_SEQUENCIAL
                       ORDER BY VP.DTA_PAGAMENTO";
        return $this->selectDB("$sql_lista", false);
    }
}
?>
