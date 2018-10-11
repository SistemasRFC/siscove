<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Menu/MenuDao.php");
class MenuModel extends BaseModel
{
    public function MenuModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarMenu($Json=true){
        $dao = new MenuDao();
        $lista = $dao->ListarMenu($_SESSION['cod_loja']);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function InsertMenu(){
        $dao = new MenuDao();        
        $result = $dao->InsertMenu($_SESSION['cod_loja']);
        return json_encode($result);        
    }

    Public Function UpdateMenu(){
        $dao = new MenuDao();
        $result = $dao->UpdateMenu();
        return json_encode($result);
    }	
    
}

