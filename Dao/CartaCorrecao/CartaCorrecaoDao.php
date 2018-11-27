<?php
include_once("../../Dao/BaseDao.php");
class CartaCorrecaoDao extends BaseDao
{
    Public Function CartaCorrecaoDao(){
        $this->conect();
    }

    Public Function ListarSequenciaisGrid(){
        $sql = "";
        return $this->selectDB($sql, false);
    }
}
?>