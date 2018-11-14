<?php
include_once("../../Dao/BaseDao.php");
class NfeDao extends BaseDao
{
    
    Public Function NfeDao(){
        $this->conect();
    }
    
    Public Function RetornaMercadoriasVenda(){
        $sql_lista = "SELECT VP.COD_PRODUTO,
                                DSC_PRODUTO,
                                COALESCE(M.DSC_MARCA, 'Outros') AS DSC_MARCA,
                                NME_USUARIO_COMPLETO AS NME_FUNCIONARIO,
                                COALESCE(VP.VLR_VENDA,0) AS VLR_VENDA,
                                QTD_VENDIDA,
                                VP.VLR_DESCONTO,
                                VP.NRO_SEQUENCIAL,
                                P.TPO_PRODUTO,
                                IND_ESTOQUE,
                                VP.COD_VENDA,
                                V.NRO_STATUS_VENDA,
                                E.QTD_ESTOQUE,
                                VP.TXT_OBSERVACAO,
                                P.COD_CFOP,
                                P.COD_NCM,
                                P.COD_ICMS_ORIGEM,
                                P.COD_ICMS_SITUACAO_TRIBUTARIA,
                                P.COD_PIS_SITUACAO_TRIBUTARIA,
                                P.COD_COFINS_SITUACAO_TRIBUTARIA,
                                IST.DSC_CODIGO AS DSC_CODIGO_ICMS,
                                CST.DSC_CODIGO AS DSC_CODIGO_COFINS,
                                PST.DSC_CODIGO AS DSC_CODIGO_PIS
                            FROM EN_VENDA V
                            INNER JOIN RE_VENDA_PRODUTO VP
                               ON V.COD_VENDA = VP.COD_VENDA
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
                            INNER JOIN SE_USUARIO U
                                ON VP.COD_FUNCIONARIO = U.COD_USUARIO
                             LEFT JOIN EN_ESTOQUE E
                               ON VP.COD_PRODUTO = E.COD_PRODUTO
                              AND VP.NRO_SEQUENCIAL = E.NRO_SEQUENCIAL
                            WHERE VP.COD_VENDA= ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
            //echo $sql_lista; die;
        return $this->selectDB("$sql_lista", false);
    }
    
    Public Function VerificaEmailCliente(){
        $sql = "SELECT C.DSC_CLIENTE,
                       C.TXT_EMAIL,
                       V.NRO_STATUS_VENDA
                  FROM EN_CLIENTE C
                 INNER JOIN EN_VENDA V
                    ON C.COD_CLIENTE = V.COD_CLIENTE
                 WHERE V.COD_VENDA = ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
        return $this->selectDB($sql, false);
    }
    
    Public Function RegistraErros($codVenda, $erro){
        $sql = "INSERT INTO EN_ERROS_NFE (COD_VENDA, DSC_ERRO) VALUES ($codVenda, '".$erro."')";
        return $this->insertDB($sql);
    }
}