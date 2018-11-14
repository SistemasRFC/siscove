<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/TipoConta/TipoContaDao.php");
class TipoContaModel extends BaseModel
{
    Public Function TipoContaModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        } 
    }
    
    Public Function ListarTipoConta($Json=true){
        $dao = new TipoContaDao();
        $lista = $dao->ListarTipoConta($_SESSION['cod_cliente_final']);
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
    
    Public Function ListarTipoContaAtivoPesquisa($Json=true){
        $dao = new TipoContaDao();
        $lista = $dao->ListarTipoContaAtivoPesquisa($_SESSION['cod_cliente_final']);
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }        
        
    }
    
    Public Function ListarTipoContaAtivo($Json=true){
        $dao = new TipoContaDao();
        $lista = $dao->ListarTipoContaAtivo($_SESSION['cod_cliente_final']);
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }        
        
    }
    
    Public Function AddTipoConta(){
        $dao = new TipoContaDao();
        return json_encode($dao->AddTipoConta($_SESSION['cod_cliente_final']));
    }

    Public Function UpdateTipoConta(){
        $dao = new TipoContaDao();
        return json_encode($dao->UpdateTipoConta());
    }
}
?>
