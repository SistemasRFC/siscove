<?php
include_once("../../Dao/BaseDao.php");
class EntradaEstoquePagamentosDao extends BaseDao
{
    Public Function EntradaEstoquePagamentosDao(){
        $this->conect();
    }

    Public Function ListarPagamentosEntradas(){
        $sql = "
            SELECT DTA_PAGAMENTO,
            VLR_PAGAMENTO,
            NRO_CHEQUE,
            NRO_BANCO,
            NME_PROPRIETARIO,
            DSC_TIPO_PAGAMENTO,
            PE.COD_TIPO_PAGAMENTO,
            PE.NRO_SEQUENCIAL,
            PE.DSC_MERCADORIA,
            PE.NRO_SEQUENCIAL_VENDA,
            PE.NRO_SEQUENCIAL_PAGAMENTO
        FROM RE_PAGAMENTO_ENTRADA PE
        INNER JOIN EN_TIPO_PAGAMENTO TP
            ON PE.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
        WHERE PE.NRO_SEQUENCIAL = ".filter_input(INPUT_POST, 'nroSequencial', FILTER_SANITIZE_NUMBER_INT);
        return $this->selectDB($sql, false);
    }

    Public Function ListarChequesRecebidos($codClienteFinal){
        $sql = "
        SELECT NRO_CHEQUE,
               NRO_BANCO,
               VLR_PAGAMENTO,
               NME_PROPRIETARIO,
               NRO_SEQUENCIAL
          FROM EN_VENDA_PAGAMENTO VP
         INNER JOIN EN_VENDA V
            ON VP.COD_VENDA = V.COD_VENDA
         WHERE COD_TIPO_PAGAMENTO = 4
           AND NRO_STATUS_VENDA = 'F'
           AND VP.NRO_SEQUENCIAL NOT IN (SELECT NRO_SEQUENCIAL_VENDA FROM RE_PAGAMENTO_ENTRADA)";
        return $this->selectDB($sql, false);
    }
    
    Public Function InserirPagamento(){
        $vlrPagamento = str_replace('.', '', filter_input(INPUT_POST, 'vlrPagamento', FILTER_SANITIZE_STRING));
        $vlrPagamento = str_replace(',', '.', $vlrPagamento);
        $nroCheque = "'".filter_input(INPUT_POST, 'nroCheque', FILTER_SANITIZE_STRING)."'";
        $nroBanco = "'".filter_input(INPUT_POST, 'nroBanco', FILTER_SANITIZE_STRING)."'";
        $nroSequencialVenda = "'".filter_input(INPUT_POST, 'nroSequencialVenda', FILTER_SANITIZE_STRING)."'";
        $nroSequencialPagamento = $this->CatchUltimoCodigo('RE_PAGAMENTO_ENTRADA', 'NRO_SEQUENCIAL_PAGAMENTO');
        $sql = "INSERT INTO RE_PAGAMENTO_ENTRADA (
                NRO_SEQUENCIAL_PAGAMENTO,
                NRO_SEQUENCIAL,
                DTA_PAGAMENTO,
                COD_TIPO_PAGAMENTO,
                VLR_PAGAMENTO,
                NRO_CHEQUE,
                NRO_BANCO,
                NME_PROPRIETARIO,
                NRO_SEQUENCIAL_VENDA,
                DSC_MERCADORIA)
                VALUES(
                ".$nroSequencialPagamento.",
                ".filter_input(INPUT_POST, 'nroSequencial', FILTER_SANITIZE_STRING).", 
                '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaPagamento', FILTER_SANITIZE_STRING))."', 
                ".filter_input(INPUT_POST, 'codTipoPagamento', FILTER_SANITIZE_STRING).",
                '".$vlrPagamento."', 
                ".$nroCheque.", 
                ".$nroBanco.",
                '".filter_input(INPUT_POST, 'nmeProprietario', FILTER_SANITIZE_STRING)."',
                ".$nroSequencialVenda.",
                '".filter_input(INPUT_POST, 'dscMercadoria', FILTER_SANITIZE_STRING)."')";
        echo $sql; die;
        return $this->insertDB("$sql");

    }

    Public Function DeletarPagamentoEntrada(){
        $sql = "DELETE FROM RE_PAGAMENTO_ENTRADA
                    WHERE NRO_SEQUENCIAL_PAGAMENTO = ".filter_input(INPUT_POST, 'nroSequencialPagamento', FILTER_SANITIZE_STRING);
        return $this->insertDB("$sql");
    }

    Public Function FecharEntrada($nroSequencial=NULL){
        $nroSequencial = $nroSequencial==NULL?filter_input(INPUT_POST, 'nroSequencial', FILTER_SANITIZE_STRING):$nroSequencial;
        $sql = "UPDATE EN_ENTRADA SET IND_ENTRADA = 'F'
                    WHERE NRO_SEQUENCIAL = ".$nroSequencial;
        return $this->insertDB("$sql");
    }
}
?>
