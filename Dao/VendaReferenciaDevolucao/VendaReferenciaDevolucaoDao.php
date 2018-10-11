<?php
include_once("../../Dao/BaseDao.php");
class VendaReferenciaDevolucaoDao extends BaseDao
{
    Protected $tableName = "EN_VENDA_REFERENCIA_DEVOLUCAO";
    
    Protected $columns = array ("codVenda"   => array("column" =>"COD_VENDA", "typeColumn" =>"I"),
                                "indStatusReferencia"   => array("column" =>"IND_STATUS_REFERENCIA", "typeColumn" =>"S"),
                                "dtaEmissaoNota"   => array("column" =>"DTA_EMISSAO_NOTA", "typeColumn" =>"D"));
    
    Protected $columnKey = array("nroSequencial"=> array("column" =>"NRO_SEQUENCIAL", "typeColumn" => "I"));
    
    Public Function VendaReferenciaDevolucaoDao(){
        $this->conect();
    }

    Public Function ListarVendaReferenciaDevolucao(){    
        return $this->MontarSelect();
    }

    Public Function UpdateVendaReferenciaDevolucao($nroSequencial, $indStatus, $codUsuario){
        $sql = "UPDATE EN_VENDA_REFERENCIA_DEVOLUCAO 
                   SET IND_STATUS_REFERENCIA = '$indStatus',
                       COD_USUARIO = $codUsuario,
                       DTA_EMISSAO_NOTA = NOW()
                 WHERE NRO_SEQUENCIAL = ".$nroSequencial;
        return $this->insertDB($sql);
    }

    Public Function InsertVendaReferenciaDevolucao($codUsuario){
        $nroSequencial = $this->CatchUltimoCodigo('EN_VENDA_REFERENCIA_DEVOLUCAO', 'NRO_SEQUENCIAL');
        $sql = "INSERT INTO EN_VENDA_REFERENCIA_DEVOLUCAO(NRO_SEQUENCIAL, COD_VENDA, IND_STATUS_REFERENCIA, DTA_EMISSAO_NOTA, COD_USUARIO)
                VALUES (".$nroSequencial.", ".$this->Populate('codVenda', 'I').",'A', NOW(), $codUsuario)";
        $result = $this->insertDB($sql);
        $result[2] = $nroSequencial;
        return $result;
    }
    
    Public Function RetornaVendaReferenciaDevolucao(){
        $sql = "SELECT COALESCE(NRO_SEQUENCIAL,0) AS NRO_SEQUENCIAL,
                       COD_VENDA,
                       DTA_EMISSAO_NOTA,
                       IND_STATUS_REFERENCIA
                  FROM EN_VENDA_REFERENCIA_DEVOLUCAO 
                 WHERE COD_VENDA = ".$this->Populate('codVenda', 'I')."
                   AND IND_STATUS_REFERENCIA IN ('A', 'E')
                   AND NRO_SEQUENCIAL = (SELECT MAX(NRO_SEQUENCIAL) FROM EN_VENDA_REFERENCIA_DEVOLUCAO WHERE COD_VENDA = ".$this->Populate('codVenda', 'I').")";
        return $this->selectDB($sql, false);
    }
    
    Public Function RetornaUltimaReferencia(){
        $sql = "SELECT COALESCE(NRO_SEQUENCIAL,0) AS NRO_SEQUENCIAL,
                       COD_VENDA,
                       DTA_EMISSAO_NOTA,
                       IND_STATUS_REFERENCIA
                  FROM EN_VENDA_REFERENCIA_DEVOLUCAO 
                 WHERE COD_VENDA = ".$this->Populate('codVenda', 'I')."
                   AND NRO_SEQUENCIAL = (SELECT MAX(NRO_SEQUENCIAL) FROM EN_VENDA_REFERENCIA_DEVOLUCAO WHERE COD_VENDA = ".$this->Populate('codVenda', 'I').")";
//        echo $sql; die;
        return $this->selectDB($sql, false);
    }
    
    Public Function RemoveReferencia($nroSequencial){
        $sql = "DELETE FROM EN_VENDA_REFERENCIA_DEVOLUCAO WHERE NRO_SEQUENCIAL = ".$nroSequencial;
        return $this->insertDB($sql);
    }
}