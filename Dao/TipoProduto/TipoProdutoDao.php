<?php
include_once("../../Dao/BaseDao.php");
class TipoProdutoDao extends BaseDao
{
    Public Function TipoProdutoDao(){
        $this->conect();
    }
    
    Public Function ListarTipoProduto($codClienteFinal){
        $sql_lista = "SELECT COD_TIPO_PRODUTO,
                                 DSC_TIPO_PRODUTO,
                                 IND_ATIVO
                            FROM EN_TIPO_PRODUTO
                           WHERE COD_CLIENTE_FINAL = $codClienteFinal";
        return $this->selectDB("$sql_lista", false);
    }
    
    Public Function ListarTipoProdutosAtivos($codClienteFinal){
        $sql_lista = "SELECT COD_TIPO_PRODUTO,
                                 DSC_TIPO_PRODUTO
                            FROM EN_TIPO_PRODUTO
                           WHERE COD_CLIENTE_FINAL = $codClienteFinal AND IND_ATIVO = 'S'";
        return $this->selectDB("$sql_lista", false);
    }    

    Public Function AddTipoProduto($codClienteFinal){
        $sql_lista = "
        INSERT INTO EN_TIPO_PRODUTO VALUES(".$this->CatchUltimoCodigo('EN_TIPO_PRODUTO', 'COD_TIPO_PRODUTO').",
                                           '".filter_input(INPUT_POST, 'dscTipoProduto', FILTER_SANITIZE_STRING)."',
                                           $codClienteFinal,
                                           '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."')";
        $result = $this->insertDB("$sql_lista");
        return $result;

    }

    Public Function UpdateTipoProduto(){
        $sql_lista = 
         "UPDATE EN_TIPO_PRODUTO SET DSC_TIPO_PRODUTO='".filter_input(INPUT_POST, 'dscTipoProduto', FILTER_SANITIZE_STRING)."',
                                     IND_ATIVO = '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."'
           WHERE COD_TIPO_PRODUTO = ".filter_input(INPUT_POST, 'codTipoProduto', FILTER_SANITIZE_STRING);
        $result = $this->insertDB("$sql_lista");
        return $result;

    }
}
?>
