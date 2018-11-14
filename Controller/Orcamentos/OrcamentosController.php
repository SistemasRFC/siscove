<?php
include_once("../BaseController.php");
include_once("../../Model/Orcamentos/OrcamentosModel.php");
class OrcamentosController extends BaseController
{
    Public Function OrcamentosController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ChamaView(){
        $params = array('nroStatusVenda' => 'A');
        $view = $this->getPath()."/View/Orcamentos/".str_replace("Controller", "View", get_class($this)).".php";
        echo ($this->gen_redirect_and_form($view, $params)); 
    }

    Public Function ListarOrcamentosAberto(){
        $model = new OrcamentosModel();
        $lista = $model->ListarOrcamentosAberto();
        echo $lista;
    }

    Public Function VerificaOrcamentosAberto(){
        $model = new OrcamentosModel();
        echo $model->VerificaOrcamentosAberto();
    }

    Public Function ListarOrcamentosCliente(){
        $model = new OrcamentosModel();
        echo $model->ListarOrcamentosCliente();
    }

    Public Function CarregaDadosVenda(){
        $model = new OrcamentosModel();
        echo $model->CarregaDadosVenda();
    }

    Public Function InsertVenda(){
        $model = new OrcamentosModel();
        echo $model->InsertVenda();
    }
    
    Public Function UpdateVenda(){
        $model = new OrcamentosModel();
        echo $model->UpdateVenda();
    }

    Public Function CancelarVenda(){
        $model = new OrcamentosModel();
        echo $model->CancelarVenda();
    }
    Public Function ReabrirVenda(){
        $model = new OrcamentosModel();
        echo $model->ReabrirVenda();
    }

    /**
     * Seleciona dados da venda e direciona para a tela de Consolidação do orçamento
     */
    Public Function GerarVenda(){
        $model = new OrcamentosModel();
        $produtosVendaModel = new ProdutosOrcamentosModel();
        $dadosVenda = $produtosVendaModel->ListarDadosProdutosVenda();
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

        $view = $this->getPath()."/View/Orcamentos/GerarVendaView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }

    Public Function ConsolidaOrcamento(){
        $model = new OrcamentosModel();
        if ($model->ConsolidaOrcamento()){
            $this->ChamaView();
        }
    }
}
$OrcamentosController = new OrcamentosController();
?>