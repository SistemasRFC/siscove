<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/#class/#classDao.php");
class #classModel extends BaseModel
{
    public function #classModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function Listar#class($Json=true){
        $dao = new #classDao();
        $lista = $dao->Listar#class();
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function Insert#class(){
        $dao = new #classDao();        
        $result = $dao->Insert#class();
        return json_encode($result);        
    }

    Public Function Update#class(){
        $dao = new #classDao();
        $result = $dao->Update#class();
        return json_encode($result);
    }	
    
}

