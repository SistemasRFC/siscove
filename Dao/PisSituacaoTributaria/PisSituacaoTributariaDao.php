<?php
include_once("../../Dao/BaseDao.php");
class PisSituacaoTributariaDao extends BaseDao
{
    Protected $tableName = "EN_PIS_SITUACAO_TRIBUTARIA";
    
    Protected $columns = array ("dscPisSituacaoTributaria"   => array("column" =>"DSC_PIS_SITUACAO_TRIBUTARIA", "typeColumn" =>"S"),
                                "dscCodigo"   => array("column" =>"DSC_CODIGO", "typeColumn" =>"S"));
    
    Protected $columnKey = array("codPisSituacaoTributaria"=> array("column" =>"COD_PIS_SITUACAO_TRIBUTARIA", "typeColumn" => "I"));
    
    Public Function PisSituacaoTributariaDao(){
        $this->conect();
    }

    Public Function ListarPisSituacaoTributaria(){    
        return $this->MontarSelect();
    }

    Public Function UpdatePisSituacaoTributaria(){
        return $this->MontarUpdate();
    }

    Public Function InsertPisSituacaoTributaria(){
        return $this->MontarInsert();
    }
}