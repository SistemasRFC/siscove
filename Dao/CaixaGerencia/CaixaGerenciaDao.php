<?php
include_once("../../Dao/BaseDao.php");
class CaixaGerenciaDao extends BaseDao
{    
    Public Function CaixaGerenciaDao(){
        $this->conect();
    }

    Public Function ListarCaixasFechadosGerencia(){    
        $sql = " SELECT CG.COD_CAIXA_GERENCIA,
                        CG.DTA_CAIXA_GERENCIA,
                        SUM(CGV.VLR_CAIXA_VENDEDOR) AS VLR_CAIXA_VENDEDOR
                   FROM EN_CAIXA_GERENCIA CG
                  INNER JOIN EN_CAIXA_GERENCIA_VENDEDOR CGV
                     ON CG.COD_CAIXA_GERENCIA = CGV.COD_CAIXA_GERENCIA
                  GROUP BY CG.COD_CAIXA_GERENCIA";
        return $this->selectDB($sql, false);
    }

    Public Function ListarCaixasVendedor(){    
        $sql = " SELECT CF.COD_CAIXA_VENDEDOR,
                        U.NME_USUARIO_COMPLETO,
                        CV.DTA_CAIXA,
                        TP.DSC_TIPO_PAGAMENTO,
                        SUM(CF.VLR_PAGAMENTO) AS VLR_PAGAMENTO
                   FROM EN_CAIXA_VENDEDOR CV
                  INNER JOIN EN_CAIXA_FECHAMENTO CF
                     ON CV.COD_CAIXA_VENDEDOR = CF.COD_CAIXA_VENDEDOR
                  INNER JOIN SE_USUARIO U
                     ON CV.COD_USUARIO = U.COD_USUARIO
                  INNER JOIN EN_TIPO_PAGAMENTO TP
                     ON CF.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                  WHERE CV.COD_CAIXA_VENDEDOR NOT IN (SELECT COD_CAIXA_VENDEDOR FROM EN_CAIXA_GERENCIA_VENDEDOR)
                    AND DATE(CV.DTA_CAIXA) = '".$this->Populate('dtaPagamento', 'D')."'
                  GROUP BY CF.COD_CAIXA_VENDEDOR,TP.DSC_TIPO_PAGAMENTO";
        return $this->selectDB($sql, false);
    }
    
    Public Function ListarResumoCaixasVendedor(){
        $sql = " SELECT TP.DSC_TIPO_PAGAMENTO,
                        SUM(CF.VLR_PAGAMENTO) AS VLR_PAGAMENTO,
                        (SELECT SUM(CFI.VLR_PAGAMENTO)
                           FROM EN_CAIXA_FECHAMENTO CFI
                          INNER JOIN EN_CAIXA_VENDEDOR CVI
                             ON CFI.COD_CAIXA_VENDEDOR = CVI.COD_CAIXA_VENDEDOR
                          WHERE CVI.COD_CAIXA_VENDEDOR NOT IN (SELECT COD_CAIXA_VENDEDOR FROM EN_CAIXA_GERENCIA_VENDEDOR)
                            AND DATE(CVI.DTA_CAIXA) = '".$this->Populate('dtaPagamento', 'D')."') AS VLR_TOTAL
                   FROM EN_CAIXA_VENDEDOR CV
                  INNER JOIN EN_CAIXA_FECHAMENTO CF
                     ON CV.COD_CAIXA_VENDEDOR = CF.COD_CAIXA_VENDEDOR
                  INNER JOIN SE_USUARIO U
                     ON CV.COD_USUARIO = U.COD_USUARIO
                  INNER JOIN EN_TIPO_PAGAMENTO TP
                     ON CF.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                  WHERE CV.COD_CAIXA_VENDEDOR NOT IN (SELECT COD_CAIXA_VENDEDOR FROM EN_CAIXA_GERENCIA_VENDEDOR)
                    AND DATE(CV.DTA_CAIXA) = '".$this->Populate('dtaPagamento', 'D')."'
                  GROUP BY TP.DSC_TIPO_PAGAMENTO";
        return $this->selectDB($sql, false);
    }
    
    Public Function AddFechamentoCaixa($codUsuario){
        $sql = "INSERT INTO EN_CAIXA_GERENCIA (DTA_CAIXA_GERENCIA, COD_USUARIO)
                VALUES (NOW(), ".$codUsuario.")";
        return $this->insertDB($sql);
    }
    
    Public Function AddPagamentosFechamentoCaixa($codCaixaGerencia){
        $sql = " INSERT INTO EN_CAIXA_GERENCIA_VENDEDOR (COD_CAIXA_GERENCIA, COD_CAIXA_VENDEDOR, VLR_CAIXA_VENDEDOR)
                 SELECT ".$codCaixaGerencia.", 
                       CV.COD_CAIXA_VENDEDOR,
                       SUM(CF.VLR_PAGAMENTO)
                   FROM EN_CAIXA_VENDEDOR CV
                  INNER JOIN EN_CAIXA_FECHAMENTO CF
                     ON CV.COD_CAIXA_VENDEDOR = CF.COD_CAIXA_VENDEDOR
                  INNER JOIN SE_USUARIO U
                     ON CV.COD_USUARIO = U.COD_USUARIO
                  INNER JOIN EN_TIPO_PAGAMENTO TP
                     ON CF.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                  WHERE CV.COD_CAIXA_VENDEDOR NOT IN (SELECT COD_CAIXA_VENDEDOR FROM EN_CAIXA_GERENCIA_VENDEDOR)
                    AND DATE(CV.DTA_CAIXA) = '".$this->Populate('dtaPagamento', 'D')."'
                  GROUP BY CV.COD_CAIXA_VENDEDOR";
        return $this->insertDB($sql);
    }
    
    Public Function RetornaUltimoFechamento($codCaixaGerencia){
        $sql = " SELECT COD_CAIXA_GERENCIA,
                        DTA_CAIXA_GERENCIA
                   FROM EN_CAIXA_GERENCIA
                  WHERE COD_CAIXA_GERENCIA = ".$codCaixaGerencia;
        return $this->selectDB($sql, false);
    }

    Public Function ListarCaixasVendedorPorCodigo(){    
        $sql = " SELECT CF.COD_CAIXA_VENDEDOR,
                        U.NME_USUARIO_COMPLETO,
                        CV.DTA_CAIXA,
                        TP.DSC_TIPO_PAGAMENTO,
                        SUM(CF.VLR_PAGAMENTO) AS VLR_PAGAMENTO
                   FROM EN_CAIXA_GERENCIA_VENDEDOR CGV
                  INNER JOIN EN_CAIXA_VENDEDOR CV
                     ON CGV.COD_CAIXA_VENDEDOR = CV.COD_CAIXA_VENDEDOR
                  INNER JOIN EN_CAIXA_FECHAMENTO CF
                     ON CV.COD_CAIXA_VENDEDOR = CF.COD_CAIXA_VENDEDOR
                  INNER JOIN SE_USUARIO U
                     ON CV.COD_USUARIO = U.COD_USUARIO
                  INNER JOIN EN_TIPO_PAGAMENTO TP
                     ON CF.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                  WHERE CGV.COD_CAIXA_GERENCIA = ".$this->Populate('codCaixaGerencia')."
                  GROUP BY CF.COD_CAIXA_VENDEDOR,TP.DSC_TIPO_PAGAMENTO";
        return $this->selectDB($sql, false);
    }  
    
    Public Function ListarResumoCaixasVendedorPorCodigo(){
        $sql = " SELECT TP.DSC_TIPO_PAGAMENTO,
                        SUM(CF.VLR_PAGAMENTO) AS VLR_PAGAMENTO,
                        (SELECT SUM(VLR_PAGAMENTO) 
                           FROM EN_CAIXA_FECHAMENTO CFI
                          INNER JOIN EN_CAIXA_GERENCIA_VENDEDOR CGVI
                             ON CFI.COD_CAIXA_VENDEDOR = CGVI.COD_CAIXA_VENDEDOR
                          WHERE CGVI.COD_CAIXA_GERENCIA = ".$this->Populate('codCaixaGerencia').") AS VLR_TOTAL
                   FROM EN_CAIXA_GERENCIA_VENDEDOR CGV
                  INNER JOIN EN_CAIXA_VENDEDOR CV
                     ON CGV.COD_CAIXA_VENDEDOR = CV.COD_CAIXA_VENDEDOR
                  INNER JOIN EN_CAIXA_FECHAMENTO CF
                     ON CV.COD_CAIXA_VENDEDOR = CF.COD_CAIXA_VENDEDOR
                  INNER JOIN SE_USUARIO U
                     ON CV.COD_USUARIO = U.COD_USUARIO
                  INNER JOIN EN_TIPO_PAGAMENTO TP
                     ON CF.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                  WHERE CGV.COD_CAIXA_GERENCIA = ".$this->Populate('codCaixaGerencia')."
                  GROUP BY TP.DSC_TIPO_PAGAMENTO";
        return $this->selectDB($sql, false);
    }
    
}