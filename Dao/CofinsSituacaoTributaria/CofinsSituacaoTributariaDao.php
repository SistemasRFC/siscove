<?php
include_once("../../Dao/BaseDao.php");
class CofinsSituacaoTributariaDao extends BaseDao
{
    Protected $tableName = "EN_COFINS_SITUACAO_TRIBUTARIA";
    
    Protected $columns = array ("dscCofinsSituacaoTributaria"   => array("column" =>"DSC_COFINS_SITUACAO_TRIBUTARIA", "typeColumn" =>"S"),
                                "dscCodigo"   => array("column" =>"DSC_CODIGO", "typeColumn" =>"S"));
    
    Protected $columnKey = array("codCofinsSituacaoTributaria"=> array("column" =>"COD_COFINS_SITUACAO_TRIBUTARIA", "typeColumn" => "I"));
    
    Public Function CofinsSituacaoTributariaDao(){
        $this->conect();
    }

    Public Function ListarCofinsSituacaoTributaria(){    
        return $this->MontarSelect();
    }

    Public Function UpdateCofinsSituacaoTributaria(){
        return $this->MontarUpdate();
    }

    Public Function InsertCofinsSituacaoTributaria(){
        return $this->MontarInsert();
    }
}