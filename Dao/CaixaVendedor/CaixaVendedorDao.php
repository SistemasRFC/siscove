<?php
include_once("../../Dao/BaseDao.php");
class CaixaVendedorDao extends BaseDao
{
    Protected $tableName = "EN_CAIXA_VENDEDOR";
    
    Protected $columns = array ("dtaCaixa"   => array("column" =>"DTA_CAIXA", "typeColumn" =>"D"),
                                "codUsuario"   => array("column" =>"COD_USUARIO", "typeColumn" =>"I"));
    
    Protected $columnKey = array("codCaixaVendedor"=> array("column" =>"COD_CAIXA_VENDEDOR", "typeColumn" => "I"));
    
    Public Function CaixaVendedorDao(){
        $this->conect();
    }

    Public Function ListarPagamentosVendedor($codVendedor){    
        $sql = " SELECT V.COD_VENDA,
                        VP.COD_TIPO_PAGAMENTO,
                        TP.DSC_TIPO_PAGAMENTO,
                        SUM(VP.VLR_PAGAMENTO) AS VLR_PAGAMENTO,
                        CASE WHEN V.NRO_STATUS_VENDA='A' THEN 'Aberto'
                             WHEN V.NRO_STATUS_VENDA='F' THEN 'Fechado'
                        END AS DSC_STATUS_VENDA,
                        U.NME_USUARIO_COMPLETO
                   FROM EN_VENDA_PAGAMENTO VP
                  INNER JOIN EN_VENDA V
                     ON VP.COD_VENDA = V.COD_VENDA
                  INNER JOIN EN_TIPO_PAGAMENTO TP
                     ON VP.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                  INNER JOIN SE_USUARIO U
                     ON VP.COD_USUARIO = U.COD_USUARIO
                  WHERE VP.COD_USUARIO = ".$codVendedor."
                    AND V.NRO_STATUS_VENDA NOT IN ('O', 'C')
                    AND VP.NRO_SEQUENCIAL NOT IN (SELECT NRO_SEQUENCIAL_PAGAMENTO FROM EN_CAIXA_FECHAMENTO)
                    AND DATE(VP.DTA_REGISTRO) = '".$this->Populate('dtaPagamento', 'D')."'
                    AND VP.COD_TIPO_PAGAMENTO NOT IN (5)
                  GROUP BY V.COD_VENDA, VP.COD_TIPO_PAGAMENTO
                  ORDER BY V.COD_VENDA, TP.DSC_TIPO_PAGAMENTO";
        return $this->selectDB($sql, false);
    }

    Public Function ListarTiposPagamentosVendedor($codVendedor){    
        $sql = " SELECT VP.COD_TIPO_PAGAMENTO,
                        TP.DSC_TIPO_PAGAMENTO,
                        SUM(VP.VLR_PAGAMENTO) AS VLR_PAGAMENTO,
                        (SELECT SUM(VLR_PAGAMENTO) 
                           FROM EN_VENDA_PAGAMENTO VPI
                          INNER JOIN EN_VENDA VI
                             ON VPI.COD_VENDA = VI.COD_VENDA
                          WHERE DATE(VPI.DTA_REGISTRO) = '".$this->Populate('dtaPagamento', 'D')."'
                            AND VPI.COD_USUARIO = ".$codVendedor."
                            AND VI.NRO_STATUS_VENDA NOT IN ('O', 'C')
                            AND VPI.NRO_SEQUENCIAL NOT IN (SELECT NRO_SEQUENCIAL_PAGAMENTO FROM EN_CAIXA_FECHAMENTO)) AS VLR_TOTAL
                   FROM EN_VENDA_PAGAMENTO VP
                  INNER JOIN EN_TIPO_PAGAMENTO TP
                     ON VP.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                  INNER JOIN EN_VENDA V
                     ON VP.COD_VENDA = V.COD_VENDA
                  WHERE VP.COD_USUARIO = ".$codVendedor."
                    AND V.NRO_STATUS_VENDA NOT IN ('O', 'C')
                    AND VP.NRO_SEQUENCIAL NOT IN (SELECT NRO_SEQUENCIAL_PAGAMENTO FROM EN_CAIXA_FECHAMENTO)
                    AND DATE(VP.DTA_REGISTRO) = '".$this->Populate('dtaPagamento', 'D')."'
                    AND VP.COD_TIPO_PAGAMENTO NOT IN (5)
                  GROUP BY VP.COD_TIPO_PAGAMENTO
                  ORDER BY TP.DSC_TIPO_PAGAMENTO";
        return $this->selectDB($sql, false);
    }
    
    Public Function AddFechamentoCaixa($codVendedor){
        $codCaixaVendedor = $this->CatchUltimoCodigo($this->tableName, 'COD_CAIXA_VENDEDOR');
        $sql = "INSERT INTO ".$this->tableName." (COD_CAIXA_VENDEDOR, DTA_CAIXA, COD_USUARIO)
                VALUES (".$codCaixaVendedor.", NOW(), ".$codVendedor.")";
        $result = $this->insertDB($sql);
        $result[2] = $codCaixaVendedor;
        return $result;
    }

    Public Function AddPagamentosFechamentoCaixa($codCaixaVendedor, $codVendedor){       
        $sql = " INSERT INTO EN_CAIXA_FECHAMENTO (COD_CAIXA_VENDEDOR, NRO_SEQUENCIAL_PAGAMENTO, VLR_PAGAMENTO, COD_TIPO_PAGAMENTO)
                 SELECT ".$codCaixaVendedor.",
                        VP.NRO_SEQUENCIAL,
                        VP.VLR_PAGAMENTO AS VLR_PAGAMENTO,
                        VP.COD_TIPO_PAGAMENTO
                   FROM EN_VENDA_PAGAMENTO VP
                  INNER JOIN EN_TIPO_PAGAMENTO TP
                     ON VP.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                  INNER JOIN EN_VENDA V
                     ON VP.COD_VENDA = V.COD_VENDA
                  WHERE VP.COD_USUARIO = ".$codVendedor."
                    AND V.NRO_STATUS_VENDA NOT IN ('O', 'C')
                    AND VP.NRO_SEQUENCIAL NOT IN (SELECT NRO_SEQUENCIAL_PAGAMENTO FROM EN_CAIXA_FECHAMENTO)
                    AND DATE(VP.DTA_REGISTRO) = '".$this->Populate('dtaPagamento', 'D')."'
                    AND VP.COD_TIPO_PAGAMENTO NOT IN (5)
                  GROUP BY VP.NRO_SEQUENCIAL, VP.COD_TIPO_PAGAMENTO"; 
        return $this->insertDB($sql);
    }
    
    Public Function ListarCaixaVendedor($codVendedor){
        $sql = "SELECT COD_CAIXA_VENDEDOR,
                       DTA_CAIXA,
                       COD_USUARIO,
                       (SELECT SUM(VLR_PAGAMENTO)
                          FROM EN_CAIXA_FECHAMENTO CF
                         WHERE CF.COD_CAIXA_VENDEDOR = CV.COD_CAIXA_VENDEDOR) AS VLR_PAGAMENTO
                  FROM EN_CAIXA_VENDEDOR CV
                 WHERE COD_USUARIO = ".$codVendedor;
        return $this->selectDB($sql, false);
    }
    
    Public Function RetornaUltimoFechamento($codCaixaVendedor){
        $sql = " SELECT COD_CAIXA_VENDEDOR,
                        DTA_CAIXA
                   FROM EN_CAIXA_VENDEDOR
                  WHERE COD_CAIXA_VENDEDOR = ".$codCaixaVendedor;
        return $this->selectDB($sql, false);
    }

    Public Function ListarCaixaPorCodigoVendedor(){    
        $sql = " SELECT VP.COD_VENDA,
                        CF.COD_TIPO_PAGAMENTO,
                        CV.DTA_CAIXA,
                        TP.DSC_TIPO_PAGAMENTO,
                        SUM(CF.VLR_PAGAMENTO) AS VLR_PAGAMENTO,
                        CASE WHEN V.NRO_STATUS_VENDA='A' THEN 'Aberto'
                             WHEN V.NRO_STATUS_VENDA='F' THEN 'Fechado'
                        END AS DSC_STATUS_VENDA,
                        U.NME_USUARIO_COMPLETO
                   FROM EN_CAIXA_FECHAMENTO CF
                  INNER JOIN EN_CAIXA_VENDEDOR CV
                     ON CF.COD_CAIXA_VENDEDOR = CV.COD_CAIXA_VENDEDOR
                  INNER JOIN EN_VENDA_PAGAMENTO VP
                     ON CF.NRO_SEQUENCIAL_PAGAMENTO = VP.NRO_SEQUENCIAL
                  INNER JOIN EN_VENDA V
                     ON VP.COD_VENDA = V.COD_VENDA
                  INNER JOIN EN_TIPO_PAGAMENTO TP
                     ON CF.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                  INNER JOIN SE_USUARIO U
                     ON CV.COD_USUARIO = U.COD_USUARIO
                  WHERE CF.COD_CAIXA_VENDEDOR = ".$this->Populate('codCaixaVendedor', 'I')."    
                  GROUP BY V.COD_VENDA, VP.COD_TIPO_PAGAMENTO
                  ORDER BY V.COD_VENDA, TP.DSC_TIPO_PAGAMENTO";
        return $this->selectDB($sql, false);
    }

    Public Function ListarTiposCaixaPorCodigoVendedor($codVendedor){    
        $sql = " SELECT CF.COD_TIPO_PAGAMENTO,
                        TP.DSC_TIPO_PAGAMENTO,
                        SUM(CF.VLR_PAGAMENTO) AS VLR_PAGAMENTO,
                        (SELECT SUM(VLR_PAGAMENTO) FROM EN_CAIXA_FECHAMENTO WHERE COD_CAIXA_VENDEDOR = ".$this->Populate('codCaixaVendedor', 'I').") AS VLR_TOTAL
                   FROM EN_CAIXA_FECHAMENTO CF
                  INNER JOIN EN_CAIXA_VENDEDOR CV
                     ON CF.COD_CAIXA_VENDEDOR = CV.COD_CAIXA_VENDEDOR
                  INNER JOIN EN_VENDA_PAGAMENTO VP
                     ON CF.NRO_SEQUENCIAL_PAGAMENTO = VP.NRO_SEQUENCIAL
                  INNER JOIN EN_VENDA V
                     ON VP.COD_VENDA = V.COD_VENDA
                  INNER JOIN EN_TIPO_PAGAMENTO TP
                     ON CF.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                  WHERE CF.COD_CAIXA_VENDEDOR = ".$this->Populate('codCaixaVendedor', 'I')."    
                  GROUP BY VP.COD_TIPO_PAGAMENTO
                  ORDER BY TP.DSC_TIPO_PAGAMENTO";
        return $this->selectDB($sql, false);
    }  
}