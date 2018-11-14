<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Aluno/AlunoDao.php");
class AlunoModel extends BaseModel
{
    public function AlunoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarAluno($Json=true){
        $dao = new AlunoDao();
        $lista = $dao->ListarAluno($_SESSION['cod_loja']);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function InsertAluno(){
        $dao = new AlunoDao();        
        $result = $dao->InsertAluno($_SESSION['cod_loja']);
        return json_encode($result);        
    }

    Public Function UpdateAluno(){
        $dao = new AlunoDao();
        $result = $dao->UpdateAluno();
        return json_encode($result);
    }	
    
}

