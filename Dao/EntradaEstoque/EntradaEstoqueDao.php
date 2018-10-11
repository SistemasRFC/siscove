<?php
include_once("../../Dao/BaseDao.php");
class EntradaEstoqueDao extends BaseDao
{
    Public Function EntradaEstoqueDao(){
        $this->conect();
    }

    Public Function ListarEntradasEstoqueAberto($codClienteFinal){
        $sql_lista = "SELECT E.NRO_SEQUENCIAL,
                             NRO_NOTA_FISCAL,
                             DTA_ENTRADA,
                             E.COD_FORNECEDOR,
                             F.DSC_FORNECEDOR,
                             F.NRO_CNPJ,
                             E.COD_DEPOSITO,
                             D.DSC_DEPOSITO,
                             E.TXT_OBSERVACAO,
                             COALESCE(SUM(EE.VLR_UNITARIO*EE.QTD_ENTRADA),0) AS VLR_NOTA
                        FROM EN_ENTRADA E
                        LEFT JOIN EN_FORNECEDOR F
                          ON E.COD_FORNECEDOR = F.COD_FORNECEDOR
                        LEFT JOIN EN_DEPOSITO D
                          ON E.COD_DEPOSITO = D.COD_DEPOSITO
                        LEFT JOIN EN_ENTRADA_ESTOQUE EE
                          ON E.NRO_SEQUENCIAL = EE.NRO_SEQUENCIAL
                       WHERE IND_ENTRADA = 'A'
                         AND E.COD_CLIENTE_FINAL = $codClienteFinal
                       GROUP BY E.NRO_SEQUENCIAL,
                             NRO_NOTA_FISCAL,
                             DTA_ENTRADA,
                             E.COD_FORNECEDOR,
                             F.DSC_FORNECEDOR,
                             E.COD_DEPOSITO,
                             D.DSC_DEPOSITO,
                             E.TXT_OBSERVACAO";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function ListarEntradasEstoqueFechadas($codClienteFinal){
        $sql_lista = "SELECT E.NRO_SEQUENCIAL,
                             NRO_NOTA_FISCAL,
                             DTA_ENTRADA,
                             E.COD_FORNECEDOR,
                             F.DSC_FORNECEDOR,
                             F.NRO_CNPJ,
                             F.NRO_IE,
                             F.TXT_LOGRADOURO,
                             F.TXT_COMPLEMENTO,
                             F.NME_BAIRRO,
                             F.TXT_LOCALIDADE,
                             F.SGL_UF,
                             F.NRO_CEP,
                             E.COD_DEPOSITO,
                             D.DSC_DEPOSITO,
                             E.TXT_OBSERVACAO,
                             COALESCE(SUM(EE.VLR_UNITARIO*EE.QTD_ENTRADA),0) AS VLR_NOTA
                        FROM EN_ENTRADA E
                        LEFT JOIN EN_FORNECEDOR F
                          ON E.COD_FORNECEDOR = F.COD_FORNECEDOR
                        LEFT JOIN EN_DEPOSITO D
                          ON E.COD_DEPOSITO = D.COD_DEPOSITO
                        LEFT JOIN EN_ENTRADA_ESTOQUE EE
                          ON E.NRO_SEQUENCIAL = EE.NRO_SEQUENCIAL
                       WHERE IND_ENTRADA <> 'A'
                         AND E.COD_CLIENTE_FINAL = $codClienteFinal
                         AND E.COD_FORNECEDOR = ".$this->Populate('codFornecedor', 'I')."
                       GROUP BY E.NRO_SEQUENCIAL,
                             NRO_NOTA_FISCAL,
                             DTA_ENTRADA,
                             E.COD_FORNECEDOR,
                             F.DSC_FORNECEDOR,
                             E.COD_DEPOSITO,
                             D.DSC_DEPOSITO,
                             E.TXT_OBSERVACAO";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function CarregaDadosEntradaEstoque($codClienteFinal){
        $sql_lista = "SELECT E.NRO_SEQUENCIAL,
                             NRO_NOTA_FISCAL,
                             DTA_ENTRADA,
                             E.IND_ENTRADA,
                             NOW() AS DTA_EMISSAO,
                             E.COD_FORNECEDOR,
                             F.DSC_FORNECEDOR,
                             F.NRO_CNPJ,
                             F.NRO_IE,
                             F.TXT_LOGRADOURO,
                             F.TXT_COMPLEMENTO,
                             F.NME_BAIRRO,
                             F.TXT_LOCALIDADE,
                             F.SGL_UF,
                             F.NRO_CEP,
                             E.COD_DEPOSITO,
                             D.DSC_DEPOSITO,
                             E.TXT_OBSERVACAO,
                             COALESCE(SUM(EE.VLR_UNITARIO*EE.QTD_ENTRADA),0) AS VLR_NOTA,
                             COALESCE(VRD.IND_STATUS_REFERENCIA,'') AS IND_STATUS_REFERENCIA
                        FROM EN_ENTRADA E
                        LEFT JOIN EN_FORNECEDOR F
                          ON E.COD_FORNECEDOR = F.COD_FORNECEDOR
                        LEFT JOIN EN_DEPOSITO D
                          ON E.COD_DEPOSITO = D.COD_DEPOSITO
                        LEFT JOIN EN_ENTRADA_ESTOQUE EE
                          ON E.NRO_SEQUENCIAL = EE.NRO_SEQUENCIAL
                        LEFT JOIN EN_VENDA_REFERENCIA_DEVOLUCAO VRD
                          ON E.NRO_SEQUENCIAL = VRD.COD_VENDA
                         AND VRD.IND_STATUS_REFERENCIA = 'A'
                       WHERE E.NRO_SEQUENCIAL = ".filter_input(INPUT_POST, 'nroSequencial', FILTER_SANITIZE_NUMBER_INT)."
                         AND E.COD_CLIENTE_FINAL = $codClienteFinal
                       GROUP BY E.NRO_SEQUENCIAL,
                             NRO_NOTA_FISCAL,
                             DTA_ENTRADA,
                             E.COD_FORNECEDOR,
                             F.DSC_FORNECEDOR,
                             E.COD_DEPOSITO,
                             D.DSC_DEPOSITO,
                             E.TXT_OBSERVACAO";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function AddEntradaEstoque($codUsuario, $codClienteFinal, $nroNotaFiscal=NULL, $dtaEntrada=NULL, $codFornecedor=NULL, $codDeposito=NULL, $txtObs=NULL){
        $nroNotaFiscal = $nroNotaFiscal==NULL?filter_input(INPUT_POST, 'nroNotaFiscal', FILTER_SANITIZE_STRING):$nroNotaFiscal;
        $codFornecedor = $codFornecedor==NULL?filter_input(INPUT_POST, 'codFornecedor', FILTER_SANITIZE_NUMBER_INT):$codFornecedor;
        $codDeposito = $codDeposito==NULL?filter_input(INPUT_POST, 'codDeposito', FILTER_SANITIZE_NUMBER_INT):$codDeposito;
        $dtaEntrada = $dtaEntrada==NULL?"'".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaEntrada', FILTER_SANITIZE_STRING))."'":$dtaEntrada;
        $txtObs = $txtObs==NULL?filter_input(INPUT_POST, 'txtObs', FILTER_SANITIZE_STRING):$txtObs;
        $nroSequencial = $this->CatchUltimoCodigo('EN_ENTRADA', 'NRO_SEQUENCIAL');
        $sql_lista = "
        INSERT INTO EN_ENTRADA (
            NRO_SEQUENCIAL,
            NRO_NOTA_FISCAL,
            DTA_ENTRADA,
            COD_FORNECEDOR,
            COD_DEPOSITO,
            COD_USUARIO,
            TXT_OBSERVACAO,
            IND_ENTRADA,
            COD_CLIENTE_FINAL)
        VALUES(".$nroSequencial.",
               '".$nroNotaFiscal."',
               ".$dtaEntrada.",
               ".$codFornecedor.",
               ".$codDeposito.",
               ".$codUsuario.",
               '".$txtObs."',
               'A',
               $codClienteFinal)";
        $result = $this->insertDB("$sql_lista");
        $result[2] = $nroSequencial;
        return $result;

    }

    Public Function UpdateEntradaEstoque(){
        $sql_lista ="
        UPDATE EN_ENTRADA SET
            NRO_NOTA_FISCAL = '".filter_input(INPUT_POST, 'nroNotaFiscal', FILTER_SANITIZE_STRING)."',
            DTA_ENTRADA = '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaEntrada', FILTER_SANITIZE_STRING))."',
            COD_FORNECEDOR = ".filter_input(INPUT_POST, 'codFornecedor', FILTER_SANITIZE_NUMBER_INT).",
            COD_DEPOSITO = ".filter_input(INPUT_POST, 'codDeposito', FILTER_SANITIZE_NUMBER_INT).",
            TXT_OBSERVACAO = '".filter_input(INPUT_POST, 'txtObs', FILTER_SANITIZE_STRING)."'
         WHERE NRO_SEQUENCIAL = ".filter_input(INPUT_POST, 'nroSequencial', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB("$sql_lista");
        $result[2] = filter_input(INPUT_POST, 'nroSequencial', FILTER_SANITIZE_NUMBER_INT);
        return $result;
    }

    Public Function DeletarEntradaEstoque($nroSequencialEntrada){
        $sql = "DELETE FROM EN_ENTRADA WHERE NRO_SEQUENCIAL = ".$nroSequencialEntrada;
        return $this->insertDB($sql);
    }
    
    Public Function RetornaMercadoriasVenda(){
        $sql_lista = "SELECT VP.COD_PRODUTO,
                                DSC_PRODUTO,
                                COALESCE(M.DSC_MARCA, 'Outros') AS DSC_MARCA,
                                COALESCE(VP.VLR_UNITARIO,0) AS VLR_VENDA,
                                QTD_ENTRADA,
                                VP.NRO_SEQUENCIAL,
                                P.TPO_PRODUTO,
                                VP.NRO_SEQUENCIAL AS COD_VENDA,
                                V.IND_ENTRADA AS NRO_STATUS_VENDA,
                                V.TXT_OBSERVACAO,
                                P.COD_CFOP,
                                P.COD_NCM,
                                P.COD_ICMS_ORIGEM,
                                P.COD_ICMS_SITUACAO_TRIBUTARIA,
                                P.COD_PIS_SITUACAO_TRIBUTARIA,
                                P.COD_COFINS_SITUACAO_TRIBUTARIA,
                                IST.DSC_CODIGO AS DSC_CODIGO_ICMS,
                                CST.DSC_CODIGO AS DSC_CODIGO_COFINS,
                                PST.DSC_CODIGO AS DSC_CODIGO_PIS
                            FROM EN_ENTRADA V
                            INNER JOIN EN_ENTRADA_ESTOQUE VP
                               ON V.NRO_SEQUENCIAL = VP.NRO_SEQUENCIAL
                            INNER JOIN EN_PRODUTO P
                               ON VP.COD_PRODUTO = P.COD_PRODUTO
                             LEFT JOIN EN_ICMS_SITUACAO_TRIBUTARIA IST
                               ON P.COD_ICMS_SITUACAO_TRIBUTARIA = IST.COD_ICMS_SITUACAO_TRIBUTARIA
                             LEFT JOIN EN_COFINS_SITUACAO_TRIBUTARIA CST
                               ON P.COD_COFINS_SITUACAO_TRIBUTARIA = CST.COD_COFINS_SITUACAO_TRIBUTARIA
                             LEFT JOIN EN_PIS_SITUACAO_TRIBUTARIA PST
                               ON P.COD_PIS_SITUACAO_TRIBUTARIA = PST.COD_PIS_SITUACAO_TRIBUTARIA                               
                             LEFT JOIN EN_MARCA M
                               ON P.COD_MARCA = M.COD_MARCA
                            WHERE VP.NRO_SEQUENCIAL= ".filter_input(INPUT_POST, 'nroSequencial', FILTER_SANITIZE_NUMBER_INT);
//            echo $sql_lista; die;
        return $this->selectDB("$sql_lista", false);
    }    
    Public Function RegistraErrosDevolucao($codVenda, $erro){
        $sql = "INSERT INTO EN_ERROS_DEVOLUCAO_NFE (COD_VENDA, DSC_ERRO) VALUES ($codVenda, '".$erro."')";
        return $this->insertDB($sql);
    }
}
?>
