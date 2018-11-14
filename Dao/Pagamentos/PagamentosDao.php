<?php
include_once("../../Dao/BaseDao.php");
class PagamentosDao extends BaseDao
{
    function PagamentosDao(){
        $this->conect();
    }

    function ListarContas($codClienteFinal){
        $mes = filter_input(INPUT_POST, 'comboNroMesReferencia', FILTER_SANITIZE_NUMBER_INT);
        $ano = filter_input(INPUT_POST, 'comboNroAnoReferencia', FILTER_SANITIZE_NUMBER_INT);
        $tpoDespesa = filter_input(INPUT_POST, 'comboTpoDespesa', FILTER_SANITIZE_NUMBER_INT);
        $indStatus = filter_input(INPUT_POST, 'indStatus', FILTER_SANITIZE_STRING);
        $sql = "SELECT CA.COD_CONTA,
                       COALESCE(CA.COD_CONTA_FIXA,0) AS COD_CONTA_FIXA,
                       CA.DSC_CONTA,
                       CA.DTA_VENCIMENTO,
                       CA.VLR_CONTA,
                       CA.VLR_CONTA AS VALOR_CONTA,
                       CA.TXT_OBSERVACAO,
                       CA.IND_CONTA_PAGA,
                       TC.DSC_TIPO_CONTA,
                       COALESCE(TC.COD_TIPO_CONTA, -1) AS COD_TIPO_CONTA
                  FROM EN_CONTAS_A_PAGAR CA
                  LEFT JOIN EN_TIPO_CONTA TC
                    ON CA.COD_TIPO_CONTA = TC.COD_TIPO_CONTA
                 WHERE COD_CLIENTE_FINAL = $codClienteFinal
                   AND MONTH(DTA_VENCIMENTO)= ".$mes."
                   AND YEAR(DTA_VENCIMENTO)=".$ano;        
        if ($tpoDespesa!="-1" && $tpoDespesa!=""){
            $sql .= "   AND CA.COD_TIPO_CONTA = ".$tpoDespesa;
        }        
        if ($indStatus!="-1" && $indStatus!=""){
            $sql .= "   AND IND_CONTA_PAGA = '".$indStatus."'";
        }        
        if ($tpoDespesa=="-1" || $tpoDespesa=="1"){
            $sql .= " UNION
                SELECT 0 AS COD_CONTA,
                       CF.COD_CONTA_FIXA,
                       DSC_CONTA_FIXA AS DSC_CONTA,
                       CAST(CONCAT(".$ano.",'-',".$mes.",'-',CF.NRO_DIA_CONTA_FIXA) AS DATETIME) AS DTA_VENCIMENTO,                       
                       VLR_CONTA_FIXA AS VLR_CONTA,
                       VLR_CONTA_FIXA AS VALOR_CONTA,
                       'Conta Fixa' AS TXT_OBSERVACAO,
                       'N' AS IND_CONTA_PAGA,
                       'Fixa' AS DSC_TIPO_CONTA,
                       1 AS COD_TIPO_CONTA
                  FROM EN_CONTA_FIXA CF
                  LEFT JOIN EN_CONTAS_A_PAGAR CA
                    ON CF.COD_CONTA_FIXA = CA.COD_CONTA_FIXA 
                   AND CA.COD_CLIENTE_FINAL = $codClienteFinal
                   AND MONTH(CA.DTA_VENCIMENTO)= ".$mes."
                   AND YEAR(CA.DTA_VENCIMENTO)=".$ano;
            if ($tpoDespesa!="-1" && $tpoDespesa!=""){
                $sql .= "   AND CA.COD_TIPO_CONTA = ".$tpoDespesa;
            }        
            if ($indStatus!="-1" && $indStatus!=""){
                $sql .= "   AND IND_CONTA_PAGA = '".$indStatus."'";
            }               
            $sql .= " WHERE CA.COD_CONTA_FIXA IS NULL
                        AND CF.IND_ATIVO = 'S'";
        }
        return $this->selectDB($sql, false);
    }

    function ListarPagamentos($codConta){
        $sql = "SELECT COD_CONTA,
                       COD_PAGAMENTO,
                       DTA_PAGAMENTO,
                       VLR_PAGAMENTO,
                       VLR_PAGAMENTO AS VALOR_PAGAMENTO,
                       PCAP.COD_TIPO_PAGAMENTO,
                       DSC_TIPO_PAGAMENTO,
                       NRO_CHEQUE,
                       NME_PROPRIETARIO_CHEQUE,
                       NRO_BANCO
                  FROM EN_PAGAMENTO_CONTA_A_PAGAR PCAP
                 INNER JOIN EN_TIPO_PAGAMENTO TP
                    ON PCAP.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                 WHERE COD_CONTA = $codConta";        
        return $this->selectDB($sql, false);
    }
    
    Public Function ListarChequesRecebidos(){
        $sql = " SELECT VP.NRO_CHEQUE,
                        VP.NRO_BANCO,
                        VP.NME_PROPRIETARIO,
                        VP.VLR_PAGAMENTO,
                        VP.DTA_PAGAMENTO
                   FROM EN_VENDA_PAGAMENTO VP
                   LEFT JOIN EN_PAGAMENTO_CONTA_A_PAGAR P
                     ON VP.NRO_CHEQUE = P.NRO_CHEQUE
                    AND VP.NRO_BANCO = P.NRO_BANCO
                    AND VP.NME_PROPRIETARIO = P.NME_PROPRIETARIO_CHEQUE
                  WHERE P.NRO_CHEQUE IS NULL
                    AND VP.DTA_PAGAMENTO> NOW()
                    AND VP.COD_TIPO_PAGAMENTO = 4";
        return $this->selectDB($sql, false);
    }
    
    Public Function InserirContaFixa(){
        $vlrConta = str_replace('.', '', filter_input(INPUT_POST, 'vlrConta', FILTER_SANITIZE_STRING));
        $vlrConta = str_replace(',', '.', $vlrConta);
        $sql = "INSERT INTO EN_CONTA_FIXA( DSC_CONTA_FIXA, VLR_CONTA_FIXA, IND_ATIVO, NRO_DIA_CONTA_FIXA)
                VALUES('".filter_input(INPUT_POST, 'dscConta', FILTER_SANITIZE_STRING)."',
                       '".$vlrConta."',
                       'S',
                       DAY('".$this->Populate('dtaVencimento', 'D')."'))";
        return $this->insertDB($sql);
    }
    
    Public Function InserirConta($dtaVencimento, $codClienteFinal, $codContaFixa){
        $vlrConta = str_replace('.', '', filter_input(INPUT_POST, 'vlrConta', FILTER_SANITIZE_STRING));
        $vlrConta = str_replace(',', '.', $vlrConta);
        $codPagamento = $this->CatchUltimoCodigo('EN_CONTAS_A_PAGAR', 'COD_CONTA');
        $sql = "INSERT INTO EN_CONTAS_A_PAGAR (
                COD_CONTA,
                DSC_CONTA,
                DTA_VENCIMENTO,
                VLR_CONTA,
                TXT_OBSERVACAO,
                IND_CONTA_PAGA,
                COD_CLIENTE_FINAL,
                COD_TIPO_CONTA,
                COD_CONTA_FIXA)
                VALUES(
                ".$codPagamento.", 
                '".filter_input(INPUT_POST, 'dscConta', FILTER_SANITIZE_STRING)."',                
                '".$this->Populate('dtaVencimento', 'D')."', 
                '".$vlrConta."',
                '".filter_input(INPUT_POST, 'txtObservacao', FILTER_SANITIZE_STRING)."',   
                '".filter_input(INPUT_POST, 'indContaPaga', FILTER_SANITIZE_STRING)."',   
                ".$codClienteFinal.",
                '".filter_input(INPUT_POST, 'codTipoConta', FILTER_SANITIZE_STRING)."',
                ".$codContaFixa.")";                
        $result = $this->insertDB($sql);
        $result[2] = $codPagamento;
        return $result;
    }
    
    function VerificaContaFixa(){
        $sql = "SELECT COD_CONTA_FIXA
                  FROM EN_CONTAS_A_PAGAR
                 WHERE COD_CONTA = ".filter_input(INPUT_POST, 'codConta', FILTER_SANITIZE_NUMBER_INT)."
                   AND COD_CONTA_FIXA IS NOT NULL AND COD_CONTA_FIXA>0";
        return $this->selectDB($sql, false);
    }

    function UpdateConta($codContaFixa){
        $vlrConta = str_replace('.', '', filter_input(INPUT_POST, 'vlrConta', FILTER_SANITIZE_STRING));
        $vlrConta = str_replace(',', '.', $vlrConta);        
        $sql = "UPDATE EN_CONTAS_A_PAGAR
                   SET
                       DSC_CONTA = '".filter_input(INPUT_POST, 'dscConta', FILTER_SANITIZE_STRING)."',
                       DTA_VENCIMENTO = '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVencimento', FILTER_SANITIZE_STRING))."', 
                       VLR_CONTA = '".$vlrConta."',
                       TXT_OBSERVACAO = '".filter_input(INPUT_POST, 'txtObservacao', FILTER_SANITIZE_STRING)."', 
                       IND_CONTA_PAGA = '".filter_input(INPUT_POST, 'indContaPaga', FILTER_SANITIZE_STRING)."',
                       COD_TIPO_CONTA = '".filter_input(INPUT_POST, 'codTipoConta', FILTER_SANITIZE_STRING)."', 
                       COD_CONTA_FIXA = ".$codContaFixa."
                 WHERE COD_CONTA = ".filter_input(INPUT_POST, 'codConta', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB($sql);
        $result[2] = filter_input(INPUT_POST, 'codConta', FILTER_SANITIZE_NUMBER_INT);
        return $result;
    }
    
    function UpdateContaFixa($codContaFixa){
        $sql = "UPDATE EN_CONTA_FIXA
                   SET IND_ATIVO = 'N' 
                 WHERE COD_CONTA_FIXA = '".$codContaFixa."'";
        return $this->insertDB($sql);
    }
    
    function DeletarConta(){
        $sql = "DELETE FROM EN_CONTAS_A_PAGAR
                    WHERE COD_CONTA = ".filter_input(INPUT_POST, 'codConta', FILTER_SANITIZE_NUMBER_INT);
        return $this->insertDB("$sql");
    }

    function DeletarPagamento($codPagamentos){
        $sql = "DELETE FROM EN_PAGAMENTO_CONTA_A_PAGAR
                    WHERE COD_PAGAMENTO IN (".$codPagamentos.")";
        return $this->insertDB("$sql");
    }

    Public Function InserirPagamento($dtaPagamento, $codClienteFinal, $qtdParcelas, $nroParcelaAtual){
        $nroCheque = filter_input(INPUT_POST, 'nroCheque', FILTER_SANITIZE_STRING);
        if ($nroCheque==''){
            $nroCheque = 0;
        }
        $vlrPagamento = str_replace('.', '', filter_input(INPUT_POST, 'vlrPagamento', FILTER_SANITIZE_STRING));
        $vlrPagamento = str_replace(',', '.', $vlrPagamento);        
        $codPagamento = $this->CatchUltimoCodigo('EN_PAGAMENTO_CONTA_A_PAGAR', 'COD_PAGAMENTO');
        $sql = "INSERT INTO EN_PAGAMENTO_CONTA_A_PAGAR (
                COD_CONTA,
                COD_PAGAMENTO,
                DTA_PAGAMENTO,
                VLR_PAGAMENTO,
                COD_TIPO_PAGAMENTO,
                NRO_BANCO,
                NRO_CHEQUE,
                NME_PROPRIETARIO_CHEQUE,
                NRO_QTD_PARCELAS,
                NRO_PARCELA_ATUAL)
                VALUES(
                ".filter_input(INPUT_POST, 'codConta', FILTER_SANITIZE_NUMBER_INT).",
                ".$codPagamento.",                 
                '".$this->ConverteDataForm($dtaPagamento)."', 
                '".$vlrPagamento."',                
                ".filter_input(INPUT_POST, 'codTipoPagamento', FILTER_SANITIZE_NUMBER_INT).",
                '".filter_input(INPUT_POST, 'nroBanco', FILTER_SANITIZE_STRING)."',
                ".$nroCheque.",
                '".filter_input(INPUT_POST, 'nmeProprietario', FILTER_SANITIZE_STRING)."',
                $qtdParcelas, $nroParcelaAtual)";                
        $result = $this->insertDB($sql);
        $result[2] = $codPagamento;
        return $result;
    }

    function UpdatePagamento(){
        $vlrPagamento = str_replace('.', '', filter_input(INPUT_POST, 'vlrPagamento', FILTER_SANITIZE_STRING));
        $vlrPagamento = str_replace(',', '.', $vlrPagamento);          
        $nroCheque = filter_input(INPUT_POST, 'nroCheque', FILTER_SANITIZE_STRING);
        if ($nroCheque==''){
            $nroCheque = 0;
        }        
        $sql = "UPDATE EN_PAGAMENTO_CONTA_A_PAGAR
                   SET                    
                    DTA_PAGAMENTO = '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaPagamento', FILTER_SANITIZE_STRING))."', 
                    COD_TIPO_PAGAMENTO = ".filter_input(INPUT_POST, 'codTipoPagamento', FILTER_SANITIZE_NUMBER_INT).",                    
                    NRO_CHEQUE = ".$nroCheque.",
                    NME_PROPRIETARIO_CHEQUE = '".filter_input(INPUT_POST, 'nmeProprietario', FILTER_SANITIZE_STRING)."',
                    NRO_BANCO = '".filter_input(INPUT_POST, 'nroBanco', FILTER_SANITIZE_STRING)."',
                    VLR_PAGAMENTO = '".$vlrPagamento."'
              WHERE COD_PAGAMENTO = ".filter_input(INPUT_POST, 'codPagamento', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB($sql);
        $result[2] = filter_input(INPUT_POST, 'codPagamento', FILTER_SANITIZE_NUMBER_INT);
        return $result;
    }

    
}
?>
