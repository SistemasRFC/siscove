<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Marca/MarcaDao.php");
class MarcaModel
{
    function MarcaModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }
    
    Public Function ListarMarcas($Json=true){
        $dao = new MarcaDao();
        $lista = $dao->ListarMarcas($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            for($i=0;$i<count($lista[1]);$i++){
                $lista = BaseModel::AtualizaBooleanInArray($lista, 'IND_ATIVA', 'ATIVA');
            }
        }
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }
    
    Public Function ListarMarcasAtivas($Json=true){
        $dao = new MarcaDao();
        $lista = $dao->ListarMarcasAtivas($_SESSION['cod_cliente_final']);
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }        
        
    }
    
    Public Function AddMarca(){
        $dao = new MarcaDao();
        return json_encode($dao->AddMarca($_SESSION['cod_cliente_final']));
    }

    Public Function UpdateMarca(){
        $dao = new MarcaDao();
        return json_encode($dao->UpdateMarca());
    }
}
?>
