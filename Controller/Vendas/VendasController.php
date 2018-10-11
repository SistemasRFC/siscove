<?php
include_once("../BaseController.php");
include_once("../../Model/Vendas/VendasModel.php");
class VendasController extends BaseController
{
    Public Function VendasController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $params = array('nroStatusVenda' => 'A');
        $view = $this->getPath()."/View/Vendas/".str_replace("Controller", "View", get_class($this)).".php";
        echo ($this->gen_redirect_and_form($view, $params)); 
    }

    Public Function ListarVendasAberto(){
        $model = new VendasModel();
        $lista = $model->ListarVendasAberto();
        echo $lista;
    }

    Public Function VerificaVendasAberto(){
        $model = new VendasModel();
        echo $model->VerificaVendasAberto();
    }

    Public Function ListarVendasCliente(){
        $model = new VendasModel();
        echo $model->ListarVendasCliente();
    }

    Public Function CarregaDadosVenda(){
        $model = new VendasModel();
        echo $model->CarregaDadosVenda();
    }

    Public Function InsertVenda(){
        $model = new VendasModel();
        echo $model->InsertVenda();
    }
    
    Public Function UpdateVenda(){
        $model = new VendasModel();
        echo $model->UpdateVenda();
    }

    Public Function CancelarVenda(){
        $model = new VendasModel();
        echo $model->CancelarVenda();
    }
    Public Function ReabrirVenda(){
        $model = new VendasModel();
        echo $model->ReabrirVenda();
    }

    /**
     * Seleciona dados da venda e direciona para a tela de Consolidação do orçamento
     */
    Public Function GerarVenda(){
        $model = new VendasModel();
        $produtosVendaModel = new ProdutosVendasModel();
        $dadosVenda = $produtosVendaModel->ListarDadosVenda();
        $dadosProdutosVenda = $produtosVendaModel->ListarProdutosVenda();
        $params = array('nmeVendedor' => urlencode(serialize($dadosVenda->NME_VENDEDOR)),
                      'codVenda' => urlencode(serialize($dadosVenda->COD_VENDA)),
                      'codVeiculo' => urlencode(serialize($dadosVenda->COD_VEICULO)),
                      'dscVeiculo' => urlencode(serialize($dadosVenda->DSC_VEICULO)),
                      'codCliente' => urlencode(serialize($dadosVenda->COD_CLIENTE)),
                      'dscCliente' => urlencode(serialize($dadosVenda->DSC_CLIENTE)),
                      'dtaVenda' => urlencode(serialize($produtosVendaModel->ConverteDataBanco($dadosVenda->DTA_VENDA))),
                      'nroPlaca' => urlencode(serialize($dadosVenda->NRO_PLACA)),
                      'nroStatusVenda' => $dadosVenda->NRO_STATUS_VENDA);

        $view = $this->getPath()."/View/Vendas/GerarVendaView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }

    Public Function ConsolidaOrcamento(){
        $model = new VendasModel();
        echo $model->ConsolidaOrcamento();
    }
}
$VendasController = new VendasController();
?>