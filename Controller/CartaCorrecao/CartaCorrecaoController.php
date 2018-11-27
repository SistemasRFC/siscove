<?php
include_once("../BaseController.php");
include_once("../../Model/CartaCorrecao/CartaCorrecaoModel.php");
class CartaCorrecaoController extends BaseController
{
    Public Function CartaCorrecaoController(){
      eval("\$this->".BaseController::getMethod()."();");
    }
  
    Public Function ChamaView(){
      $view = $this->getPath()."/View/CartaCorrecao/".str_replace("Controller", "View", get_class($this)).".php";
      header("Location: ".$view);
    }

    Public Function ListarSequenciaisGrid(){
        $model = new CartaCorrecaoModel();
        echo $model->ListarSequenciaisGrid();
    }

    Public Function ResumoVendaCartaCorrecao(){
        $model = new RelatoriosVendasModel();
        $dadosVenda = $model->DadosVenda();
        $dadosProdutosVenda = $model->DadosProdutosVenda();
        $dadosPagamentosVenda = $model->DadosPagamentosVenda();
        $params[0] = array('dadosVenda' => $dadosVenda[1]);
        $params[1] = array('dadosProdutosVenda' => $dadosProdutosVenda[1]);
        $params[2] = array('dadosPagamentosVenda' => $dadosPagamentosVenda[1]);
        $params = array('dadosVenda' => urlencode(serialize($dadosVenda[1])),
                        'dadosProdutosVenda' => urlencode(serialize($dadosProdutosVenda[1])),
                        'dadosPagamentosVenda' => urlencode(serialize($dadosPagamentosVenda[1])));
        $view = $this->getPath()."/View/Relatorios/ResumoVendaView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }

}
$cartaCorrecaoController = new CartaCorrecaoController();
?>