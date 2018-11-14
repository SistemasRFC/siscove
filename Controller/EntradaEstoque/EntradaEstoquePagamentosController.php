<?php
include_once("../BaseController.php");
include_once("../../Model/EntradaEstoque/EntradaEstoquePagamentosModel.php");
class EntradaEstoquePagamentosController extends BaseController
{
    Public Function EntradaEstoquePagamentosController(){
        eval("\$this->".BaseController::getMethod()."();");
    }
    
    Public Function ListarPagamentosEntradas(){
        $entradaEstoquePagamentosModel = new EntradaEstoquePagamentosModel();
        echo $entradaEstoquePagamentosModel->ListarPagamentosEntradas();
    }

    Public Function ListarChequesrecebidos(){
        $entradaEstoquePagamentosModel = new EntradaEstoquePagamentosModel();
        echo $entradaEstoquePagamentosModel->ListarChequesRecebidos();
    }
    Public Function InserirPagamento(){
        $entradaEstoquePagamentosModel = new EntradaEstoquePagamentosModel();
        echo $entradaEstoquePagamentosModel->InserirPagamento();
    }

    Public Function DeletarPagamentoEntrada(){
        $entradaEstoquePagamentosModel = new EntradaEstoquePagamentosModel();
        $dado = $entradaEstoquePagamentosModel->DeletarPagamentoEntrada();
        echo $dado;
    }

    Public Function FecharEntrada(){
        $entradaEstoquePagamentosModel = new EntradaEstoquePagamentosModel();
        echo $entradaEstoquePagamentosModel->FecharEntrada();
    }
}
$EntradaEstoquePagamentosController = new EntradaEstoquePagamentosController();
?>