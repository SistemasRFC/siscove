<?php
include_once("../../Dao/BaseDao.php");
class FormaPagamentoVendasDao extends BaseDao
{
    Public Function FormaPagamentoVendasDao(){
        $this->conect();
    }

    Public Function ListarTipoPagamento(){
        $sql = "SELECT COD_TIPO_PAGAMENTO, DSC_TIPO_PAGAMENTO FROM EN_TIPO_PAGAMENTO";
        return $this->selectDB($sql, false);

    }

    Public Function ListarPagamentosVendas(){
        $sql = "
            SELECT DTA_PAGAMENTO,
            VLR_PAGAMENTO,
            NRO_CHEQUE,
            NRO_BANCO,
            NME_PROPRIETARIO,
            DSC_TIPO_PAGAMENTO,
            VP.COD_TIPO_PAGAMENTO,
            VP.NRO_SEQUENCIAL,
            VP.DSC_MERCADORIA,
            V.NRO_STATUS_VENDA
        FROM EN_VENDA V
        INNER JOIN EN_VENDA_PAGAMENTO VP
           ON V.COD_VENDA = VP.COD_VENDA
        INNER JOIN EN_TIPO_PAGAMENTO TP
            ON VP.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
        WHERE VP.COD_VENDA = ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT)."
        ORDER BY DTA_PAGAMENTO";
        return $this->selectDB($sql, false);
    }

    Public Function SomarValoresVenda(){
        $formaPagamentoVendasform = new FormaPagamentoVendasForm();
        $sql = "
            SELECT
            SUM(VLR_PAGAMENTO) AS VLR_PAGAMENTO
        FROM EN_VENDA V
        INNER JOIN EN_VENDA_PAGAMENTO VP
           ON V.COD_VENDA = VP.COD_VENDA
        INNER JOIN EN_TIPO_PAGAMENTO TP
            ON VP.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
        WHERE VP.COD_VENDA = ".$formaPagamentoVendasform->getCodVenda().
        " GROUP BY VP.COD_VENDA";
        //echo $sql; exit;
        return $this->selectDB($sql, false);
    }

    Public Function InserirPagamento($codUsuario, $dtaPagamento, $nroSequencialVenda=NULL){
        $nroCheque = filter_input(INPUT_POST, 'nroCheque', FILTER_SANITIZE_STRING);
        $nroBanco = filter_input(INPUT_POST, 'nroBanco', FILTER_SANITIZE_STRING);
        if ($nroCheque==''){
            $nroCheque = 0;
        }
        if ($nroBanco==''){
            $nroBanco = 0;
        }
        $nroSequencial = $this->CatchUltimoCodigo('EN_VENDA_PAGAMENTO', 'NRO_SEQUENCIAL');
        $vlrPagamento = str_replace(",", "", filter_input(INPUT_POST, 'vlrPagamento', FILTER_SANITIZE_STRING));
        $sql = "INSERT INTO EN_VENDA_PAGAMENTO (
                COD_VENDA,
                NRO_SEQUENCIAL,
                DTA_PAGAMENTO,
                VLR_PAGAMENTO,
                NRO_CHEQUE,
                NRO_BANCO,
                NME_PROPRIETARIO,
                COD_TIPO_PAGAMENTO,
                DSC_MERCADORIA,
                NRO_SEQUENCIAL_ENTRADA,
                DTA_REGISTRO,
                COD_USUARIO)
                VALUES(
                ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT).", ".
                $nroSequencial.", ".
                "'".$this->ConverteDataForm($dtaPagamento)."', ".
                filter_input(INPUT_POST, 'vlrPagamento', FILTER_SANITIZE_STRING).", ".
                $nroCheque.", ".
                $nroBanco.", ".
                "'".filter_input(INPUT_POST, 'nmeProprietario', FILTER_SANITIZE_STRING)."' , ".
                filter_input(INPUT_POST, 'codTipoPagamento', FILTER_SANITIZE_NUMBER_INT).", ".
                "'".filter_input(INPUT_POST, 'dscMercadoria', FILTER_SANITIZE_STRING)."',
                '".$nroSequencialVenda."',
                NOW(),
                ".$codUsuario.")";
        $retorno = $this->insertDB($sql);
        $retorno[2] = $nroSequencial;
        return $retorno;

    }

    Public Function DeletarPagamentoVenda(){
        $sql = "DELETE FROM EN_VENDA_PAGAMENTO
                    WHERE NRO_SEQUENCIAL = ".filter_input(INPUT_POST, 'nroSequencialVenda', FILTER_SANITIZE_NUMBER_INT);
        return $this->insertDB("$sql");
    }

    Public function RegistroOperacao($codUsuario, $codVenda, $vlrPagamento, $nroSequencial, $codTipoPagamento, $tpoOperacao){
        $sql = "INSERT INTO EN_LOG_VENDA_PAGAMENTO(COD_VENDA, COD_PAGAMENTO, COD_TIPO_PAGAMENTO, VLR_PAGAMENTO, COD_USUARIO, DTA_OPERACAO, TPO_OPERACAO)
                VALUES($codVenda,
                       $nroSequencial,
                       $codTipoPagamento,
                       '$vlrPagamento',
                       $codUsuario,
                       NOW(),
                       '$tpoOperacao')";
        return $this->insertDB($sql);
    }
    
    Public Function RecuperaPagamentoVenda(){
        $sql = "SELECT VP.COD_VENDA AS COD_VENDA,
                       VP.VLR_PAGAMENTO,
                       VP.NRO_SEQUENCIAL_ENTRADA,
                       VP.COD_TIPO_PAGAMENTO AS COD_TIPO_PAGAMENTO,
                       EE.COD_PRODUTO,
                       EE.QTD_ENTRADA
                  FROM EN_VENDA_PAGAMENTO VP
                  LEFT JOIN EN_ENTRADA_ESTOQUE EE
                    ON VP.NRO_SEQUENCIAL_ENTRADA = EE.NRO_SEQUENCIAL
                 WHERE VP.NRO_SEQUENCIAL = ".filter_input(INPUT_POST, 'nroSequencialVenda', FILTER_SANITIZE_NUMBER_INT);
        return $this->selectDB($sql, false);
    }
    
    Public Function VerificaPagamentoFechamentoCaixa(){
        $sql = "SELECT COALESCE(COUNT(*),0) AS QTD
                  FROM EN_CAIXA_FECHAMENTO
                 WHERE NRO_SEQUENCIAL_PAGAMENTO = ".filter_input(INPUT_POST, 'nroSequencialVenda', FILTER_SANITIZE_NUMBER_INT);
        return $this->selectDB($sql, false);
    }
    
    Public Function FecharVenda($codUsuario){
        $sql = "UPDATE EN_VENDA SET NRO_STATUS_VENDA = 'F',
                                    DTA_FECHAMENTO = NOW(),
                                    COD_USUARIO_FECHAMENTO = $codUsuario,
                                    TXT_JUSTIFICATIVA = '".filter_input(INPUT_POST, 'txtJustificativa', FILTER_SANITIZE_STRING)."'
                    WHERE COD_VENDA = ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
        return $this->insertDB("$sql");
    }

    Public Function VerificaValoresAbaixoMinimo(){        
        $sql_lista = "SELECT V.COD_VENDA
                        FROM EN_VENDA V
                       INNER JOIN RE_VENDA_PRODUTO VP
                          ON V.COD_VENDA = VP.COD_VENDA
                       INNER JOIN EN_ENTRADA_ESTOQUE EE
                          ON VP.NRO_SEQUENCIAL = EE.NRO_SEQUENCIAL
                         AND VP.COD_PRODUTO = EE.COD_PRODUTO
                       WHERE VP.VLR_VENDA-VP.VLR_DESCONTO<EE.VLR_MINIMO
                         AND VP.COD_VENDA = ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
        $lista = $this->selectDB("$sql_lista", false);
        if (empty($lista)){
            return false;
        }else{
            return true;
        }
    }

    Public Function VerificaProdutosVenda(){
        $sql = "SELECT COALESCE(COUNT(*),0) AS QTD
                  FROM RE_VENDA_PRODUTO VP
                 INNER JOIN EN_PRODUTO P
                    ON VP.COD_PRODUTO = P.COD_PRODUTO
                 WHERE VP.COD_VENDA = ".$this->Populate('codVenda', 'I');
        return $this->selectDB($sql, false);
    }
}
?>
