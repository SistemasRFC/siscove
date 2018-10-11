<?php
include_once("../../Dao/BaseDao.php");
class #classDao extends BaseDao
{
    Protected $tableName = "#dscTabela";
    
    Protected $columns = #columns;
    
    Protected $columnKey = #pk;
    
    Public Function #classDao(){
        $this->conect();
    }

    Public Function Listar#class(){    
        return $this->MontarSelect();
    }

    Public Function Update#class(){
        return $this->MontarUpdate();
    }

    Public Function Insert#class(){
        return $this->MontarInsert();
    }
}