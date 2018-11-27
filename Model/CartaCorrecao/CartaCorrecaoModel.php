<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/CartaCorrecao/CartaCorrecaoDao.php");
class CartaCorrecaoModel extends BaseModel
{
    Public Function CartaCorrecaoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarSequenciaisGrid(){
        $dao = new CartaCorrecaoDao();
        $lista = $dao->ListarSequenciaisGrid();
        if ($json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }
}
?>