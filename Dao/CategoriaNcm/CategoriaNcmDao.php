<?php
include_once("../../Dao/BaseDao.php");
class CategoriaNcmDao extends BaseDao
{
    Protected $tableName = "EN_CATEGORIA_NCM";
    
    Protected $columns = array ("dscCategoriaNcm"   => array("column" =>"DSC_CATEGORIA_NCM", "typeColumn" =>"S"));
    
    Protected $columnKey = array("codCategoriaNcm"=> array("column" =>"COD_CATEGORIA_NCM", "typeColumn" => "I"));
    
    Public Function CategoriaNcmDao(){
        $this->conect();
    }

    Public Function ListarCategoriaNcm(){    
        return $this->MontarSelect(NULL, NULL, ' ORDER BY DSC_CATEGORIA_NCM');
    }

    Public Function UpdateCategoriaNcm(){
        return $this->MontarUpdate();
    }

    Public Function InsertCategoriaNcm(){
        return $this->MontarInsert();
    }
}