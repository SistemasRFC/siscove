<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Fornecedor/FornecedorDao.php");
class FornecedorModel
{
    Public Function FornecedorModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }
    
    Public Function ListarFornecedorGrid($Json=true){
        $dao = new FornecedorDao();
        $lista = $dao->ListarFornecedorGrid($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            for($i=0;$i<count($lista[1]);$i++){
                $lista = BaseModel::AtualizaBooleanInArray($lista, 'IND_ATIVO', 'ATIVO');
            }
        }
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }        
    }
    
    Public Function ListarFornecedorAtivo($Json=true){
        $dao = new FornecedorDao();
        $lista = $dao->ListarFornecedorAtivo($_SESSION['cod_cliente_final']);
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }         
    }
    
    Public Function AddFornecedor(){
        $dao = new FornecedorDao();
        return json_encode($dao->AddFornecedor($_SESSION['cod_cliente_final']));
    }

    Public Function UpdateFornecedor(){
        $dao = new FornecedorDao();
        return json_encode($dao->UpdateFornecedor());
    }
}
?>
