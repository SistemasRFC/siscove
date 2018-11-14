<?php
include_once("../../Dao/BaseDao.php");
class CfopDao extends BaseDao
{
    Protected $tableName = "EN_CFOP";
    
    Protected $columns = array ("dscCfop"   => array("column" =>"DSC_CFOP", "typeColumn" =>"S"),
                                "dscAplicacao"   => array("column" =>"DSC_APLICACAO", "typeColumn" =>"S"));
    
    Protected $columnKey = array("codCfop"=> array("column" =>"COD_CFOP", "typeColumn" => "I"));
    
    Public Function CfopDao(){
        $this->conect();
    }

    Public Function ListarCfop(){
        $sql = "SELECT COD_CFOP,
                       CONCAT(COD_CFOP, ' - ', DSC_CFOP) AS DSC_CFOP,
                       CONCAT(COD_CFOP, ' - ', DSC_APLICACAO) AS DSC_APLICACAO
                  FROM EN_CFOP
                 WHERE COALESCE(DSC_APLICACAO,'') <> '' 
                 ORDER BY DSC_CFOP";
        return $this->selectDB($sql, false);
    }

    Public Function UpdateCfop(){
        return $this->MontarUpdate();
    }

    Public Function InsertCfop(){
        return $this->MontarInsert();
    }
}