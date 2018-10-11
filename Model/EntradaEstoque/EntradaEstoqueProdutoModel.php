<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/EntradaEstoque/EntradaEstoqueProdutoDao.php");
class EntradaEstoqueProdutoModel extends BaseModel
{
    Public Function EntradaEstoqueProdutoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarDadosProdutosEntrada($Json=true){
        $dao = new EntradaEstoqueProdutoDao();
        $lista = $dao->ListarDadosProdutosEntrada();
        if ($lista[0]){
            $lista = BaseModel::FormataMoedaInArray($lista, "VLR_UNITARIO|VLR_VENDA|VLR_MINIMO");
        }
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }        
    }

    Public Function InserirProduto($Json=true, $nroSequencial=NULL, $codProduto=NULL, $vlrCustoUnitario=NULL, $vlrMinimo=NULL, $vlrVenda=NULL, $qtdEntrada=NULL){
        $dao = new EntradaEstoqueProdutoDao();
        $lista = $dao->InserirProduto($nroSequencial, $codProduto, $vlrCustoUnitario, $vlrMinimo, $vlrVenda, $qtdEntrada);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function DeletarProdutoEntrada($Json=true, $nroSequencialEntrada=NULL, $codProduto=NULL){
        $dao = new EntradaEstoqueProdutoDao();
        $lista = $dao->DeletarProdutoEntrada($nroSequencialEntrada, $codProduto);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function ListarProdutosEntrada(){
        $dao = new EntradaEstoqueProdutoDao();
        $lista = $dao->ListarProdutosEntrada();
        return $lista;
    }

    Public Function BaixaEstoque($nroSequencial=NULL, $codProduto=NULL, $qtdBaixa=NULL, $txtBaixa=NULL){
        $dao = new EntradaEstoqueProdutoDao();
        $return = $dao->BaixaEstoque($nroSequencial, $codProduto, $qtdBaixa, $txtBaixa);
        return $return;
    }
}
?>
