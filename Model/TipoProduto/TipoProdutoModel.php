<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/TipoProduto/TipoProdutoDao.php");
class TipoProdutoModel extends BaseModel
{
    Public Function TipoProdutoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        } 
    }
    
    Public Function ListarTipoProduto($Json=true){
        $dao = new TipoProdutoDao();
        $lista = $dao->ListarTipoProduto($_SESSION['cod_cliente_final']);
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
    
    Public Function ListarTipoProdutosAtivos($Json=true){
        $dao = new TipoProdutoDao();
        $lista = $dao->ListarTipoProdutosAtivos($_SESSION['cod_cliente_final']);
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }        
        
    }
    
    Public Function AddTipoProduto(){
        $dao = new TipoProdutoDao();
        return json_encode($dao->AddTipoProduto($_SESSION['cod_cliente_final']));
    }

    Public Function UpdateTipoProduto(){
        $dao = new TipoProdutoDao();
        return json_encode($dao->UpdateTipoProduto());
    }
}
?>
