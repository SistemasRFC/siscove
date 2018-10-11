<?php
include_once("../../Dao/BaseDao.php");
class RelatorioOperacoesDao extends BaseDao
{
    function RelatorioOperacoesDao(){
        $this->conect();
    }

    function ListarRegistrosVenda(){
        $sql = "SELECT LV.COD_OPERACAO,
                       LV.COD_VENDA,
                       U.NME_USUARIO AS COD_USUARIO,
                       LV.DTA_OPERACAO,
                       CASE WHEN LV.TPO_OPERACAO = 'I' THEN 'Inserção'
                            WHEN LV.TPO_OPERACAO = 'U' THEN 'Alteração'
                            WHEN LV.TPO_OPERACAO = 'C' THEN 'Cancelamento'
                            WHEN LV.TPO_OPERACAO = 'F' THEN 'Fechamento'
                       END AS TPO_OPERACAO
                   FROM EN_LOG_VENDA LV
                  INNER JOIN SE_USUARIO U
                    ON LV.COD_USUARIO = U.COD_USUARIO
                  WHERE 1=1";
         if($this->Populate('codVenda', 'I')!=null){
             $sql.=" AND COD_VENDA = ".$this->Populate('codVenda', 'I');
         }
         if($this->Populate('dtaReferencia', 'D')!=null){
             $sql.=" AND LV.DTA_OPERACAO BETWEEN '".$this->Populate('dtaReferencia', 'D')." 00:00:00' AND '".$this->Populate('dtaReferencia', 'D')." 23:59:59'";
         }
             $sql.=" ORDER BY LV.COD_VENDA, LV.DTA_OPERACAO";
        return $this->selectDB($sql,false);
    }
    
    function ListarRegistrosProduto(){
        $sql = "SELECT LVP.COD_OPERACAO,
                       LVP.COD_VENDA,
                       P.DSC_PRODUTO,
                       LVP.QTD_PRODUTO,
                       COALESCE(LVP.VLR_PRODUTO,0) AS VLR_PRODUTO,
                       U.NME_USUARIO AS COD_USUARIO,
                       LVP.DTA_OPERACAO,
                       CASE WHEN LVP.TPO_OPERACAO = 'I' THEN 'Inserção'
                            WHEN LVP.TPO_OPERACAO = 'D' THEN 'Exclusão'
                       END AS TPO_OPERACAO
                  FROM EN_LOG_VENDA_PRODUTO LVP
                 INNER JOIN EN_PRODUTO P
                    ON LVP.COD_PRODUTO = P.COD_PRODUTO
                 INNER JOIN SE_USUARIO U
                    ON LVP.COD_USUARIO = U.COD_USUARIO
                 WHERE 1=1";
         if($this->Populate('codVenda', 'I')!=null){
             $sql.=" AND LVP.COD_VENDA = ".$this->Populate('codVenda', 'I');
         }
         if($this->Populate('dtaReferencia', 'D')!=null){
             $sql.=" AND LVP.DTA_OPERACAO BETWEEN '".$this->Populate('dtaReferencia', 'D')." 00:00:00' AND '".$this->Populate('dtaReferencia', 'D')." 23:59:59'";
         }
             $sql.=" ORDER BY LVP.COD_VENDA, LVP.DTA_OPERACAO";
        return $this->selectDB($sql,false);
    }
    
    function ListarRegistrosPagamento(){
        $sql = "SELECT LVP.COD_OPERACAO,
                       LVP.COD_VENDA,
                       LVP.COD_PAGAMENTO,
                       TP.DSC_TIPO_PAGAMENTO AS DSC_TIPO_PAGAMENTO,
                       COALESCE(LVP.VLR_PAGAMENTO,0) AS VLR_PAGAMENTO,
                       U.NME_USUARIO AS COD_USUARIO,
                       LVP.DTA_OPERACAO,
                       CASE WHEN LVP.TPO_OPERACAO = 'I' THEN 'Inserção'
                            WHEN LVP.TPO_OPERACAO = 'D' THEN 'Exclusão'
                       END AS TPO_OPERACAO
                  FROM EN_LOG_VENDA_PAGAMENTO LVP
                 INNER JOIN EN_TIPO_PAGAMENTO TP
                    ON LVP.COD_TIPO_PAGAMENTO = TP.COD_TIPO_PAGAMENTO
                 INNER JOIN SE_USUARIO U
                    ON LVP.COD_USUARIO = U.COD_USUARIO
                 WHERE 1=1";
        if($this->Populate('codVenda', 'I')!=null){
            $sql.=" AND LVP.COD_VENDA = ".$this->Populate('codVenda', 'I');
        }
        if($this->Populate('dtaReferencia', 'D')!=null){
            $sql.=" AND LVP.DTA_OPERACAO BETWEEN '".$this->Populate('dtaReferencia', 'D')." 00:00:00' AND '".$this->Populate('dtaReferencia', 'D')." 23:59:59'";
        }
             $sql.=" ORDER BY LVP.COD_VENDA, LVP.DTA_OPERACAO";
        return $this->selectDB($sql,false);
    }
}
?>
