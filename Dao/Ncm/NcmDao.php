<?php
include_once("../../Dao/BaseDao.php");
class NcmDao extends BaseDao
{
    Protected $tableName = "EN_NCM";
    
    Protected $columns = array ("dscNcm"   => array("column" =>"DSC_NCM", "typeColumn" =>"S"),
                                "codCategoriaNcm"   => array("column" =>"COD_CATEGORIA_NCM", "typeColumn" =>"I"));
    
    Protected $columnKey = array("codNcm"=> array("column" =>"COD_NCM", "typeColumn" => "I"));
    
    Public Function NcmDao(){
        $this->conect();
    }

    Public Function ListarNcm(){    
        return $this->MontarSelect(NULL, ' WHERE COD_CATEGORIA_NCM = '.$this->Populate('codCategoriaNcm', 'I'), ' ORDER BY DSC_NCM');
    }

    Public Function UpdateNcm(){
        return $this->MontarUpdate();
    }

    Public Function InsertNcm(){
        return $this->MontarInsert();
    }
}