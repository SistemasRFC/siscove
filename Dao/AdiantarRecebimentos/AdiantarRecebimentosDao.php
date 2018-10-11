<?php
include_once("../../Dao/BaseDao.php");
class AdiantarRecebimentosDao extends BaseDao
{
    Public Function AdiantarRecebimentosDao(){
        $this->conect();
    }
    
    Public Function ListarAdiantarRecebimentos($codClienteFinal){
        $sql_lista = "SELECT VP.COD_VENDA,
                             NRO_SEQUENCIAL,
                             DTA_PAGAMENTO,
                             DTA_VENDA,
                             VLR_PAGAMENTO,
                             C.DSC_CLIENTE,
                             C.NRO_CPF,
                             TP.DSC_TIPO_PAGAMENTO
                        FROM EN_VENDA_PAGAMENTO VP
                       INNER JOIN EN_VENDA V
                          ON VP.COD_VENDA = V.COD_VENDA
                       INNER JOIN EN_TIPO_PAGAMENTO TP
                          ON VP.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                       INNER JOIN EN_CLIENTE C
                          ON V.COD_CLIENTE = C.COD_CLIENTE
                       WHERE VP.COD_TIPO_PAGAMENTO IN (3,6)
                         AND V.COD_CLIENTE_FINAL = ".$codClienteFinal."
                         AND VP.DTA_PAGAMENTO >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING))."'
                         AND VP.DTA_PAGAMENTO <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING))."'
                         AND NRO_SEQUENCIAL NOT IN (SELECT NRO_SEQUENCIAL
                                                      FROM EN_ADIANTAMENTO_RECEITA)
                       ORDER BY DTA_PAGAMENTO" ;
        return $this->selectDB("$sql_lista", false);
    }
    
    Public Function AddAdiantarRecebimentos($values){
        $sql = "INSERT INTO EN_ADIANTAMENTO_RECEITA (NRO_SEQUENCIAL, DTA_ADIANTAMENTO, VLR_ADIANTAMENTO, TXT_OBSERVACAO, COD_CLIENTE_FINAL) ".$values;
        return $this->insertDB($sql);
    }
}
?>
