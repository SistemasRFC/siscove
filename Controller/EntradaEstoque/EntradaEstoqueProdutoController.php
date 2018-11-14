<?php
include_once("../BaseController.php");
include_once("../../Model/EntradaEstoque/EntradaEstoqueProdutoModel.php");
class EntradaEstoqueProdutoController extends BaseController
{
    Public Function EntradaEstoqueProdutoController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ListarDadosProdutosEntrada(){
        $model = new EntradaEstoqueProdutoModel();
        echo $model->ListarDadosProdutosEntrada();
    }

    Public Function InserirProduto(){
        $model = new EntradaEstoqueProdutoModel();
        echo $model->InserirProduto();
    }

    Public Function DeletarProdutoEntrada(){
        $entradaEstoqueProdutoModel = new EntradaEstoqueProdutoModel();
        echo $entradaEstoqueProdutoModel->DeletarProdutoEntrada();
    }

    Public Function BaixaEstoque(){
        $entradaEstoqueProdutoModel = new EntradaEstoqueProdutoModel();
        echo $entradaEstoqueProdutoModel->BaixaEstoque();
    }
}
$entradaEstoqueProdutoController = new EntradaEstoqueProdutoController();
?>