<?php
include_once("../../Dao/BaseDao.php");
class IcmsOrigemDao extends BaseDao
{
    Protected $tableName = "EN_ICMS_ORIGEM";
    
    Protected $columns = array ("dscIcmsOrigem"   => array("column" =>"DSC_ICMS_ORIGEM", "typeColumn" =>"S"));
    
    Protected $columnKey = array("codIcmsOrigem"=> array("column" =>"COD_ICMS_ORIGEM", "typeColumn" => "I"));
    
    Public Function IcmsOrigemDao(){
        $this->conect();
    }

    Public Function ListarIcmsOrigem(){    
        return $this->MontarSelect();
    }

    Public Function UpdateIcmsOrigem(){
        return $this->MontarUpdate();
    }

    Public Function InsertIcmsOrigem(){
        return $this->MontarInsert();
    }
}