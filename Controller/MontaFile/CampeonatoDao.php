<?php
include_once("../../Dao/BaseDao.php");
class CampeonatoDao extends BaseDao
{
    Protected $tableName = "EN_CAMPEONATO";
    
    Protected $columns = array ("nroAnoReferencia"   => array("column" =>"NRO_ANO_REFERENCIA", "typeColumn" =>"I"));
    
    Protected $columnKey = array("codCampeonato"=> array("column" =>"COD_CAMPEONATO", "typeColumn" => "I"));
    
    Public Function CampeonatoDao(){
        $this->conect();
    }

    Public Function ListarCampeonato(){    
        return $this->MontarSelect();
    }

    Public Function UpdateCampeonato(){
        return $this->MontarUpdate();
    }

    Public Function InsertCampeonato($codLoja){
        return $this->MontarInsert($codLoja);
    }
}