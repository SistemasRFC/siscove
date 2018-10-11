<?php
include_once("../../Dao/BaseDao.php");
class IcmsSituacaoTributariaDao extends BaseDao
{
    Protected $tableName = "EN_ICMS_SITUACAO_TRIBUTARIA";
    
    Protected $columns = array ("dscIcmsSituacaoTributaria"   => array("column" =>"DSC_ICMS_SITUACAO_TRIBUTARIA", "typeColumn" =>"S"),
                                "dscCodigo"   => array("column" =>"DSC_CODIGO", "typeColumn" =>"S"));
    
    Protected $columnKey = array("codIcmsSituacaoTributaria"=> array("column" =>"COD_ICMS_SITUACAO_TRIBUTARIA", "typeColumn" => "I"));
    
    Public Function IcmsSituacaoTributariaDao(){
        $this->conect();
    }

    Public Function ListarIcmsSituacaoTributaria(){    
        return $this->MontarSelect();
    }

    Public Function UpdateIcmsSituacaoTributaria(){
        return $this->MontarUpdate();
    }

    Public Function InsertIcmsSituacaoTributaria(){
        return $this->MontarInsert();
    }
}