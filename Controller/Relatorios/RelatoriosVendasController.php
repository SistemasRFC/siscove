<?php
include_once("../BaseController.php");
include_once("../../Model/Relatorios/RelatoriosVendasModel.php");
class RelatoriosVendasController extends BaseController
{
    Public Function RelatoriosVendasController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    Public Function ResumoVenda(){
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

    Public Function ResumoOrcamento(){
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
        $view = $this->getPath()."/View/Relatorios/ResumoOrcamentoView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }

    Public Function ResumoServicos(){
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
        $view = $this->getPath()."/View/Relatorios/ResumoServicosView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    
    Public Function ChamaVendasFechadas(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/VendasFechadasView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    
    Public Function ChamaPagamentosRecebidos(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/PagamentosRecebidosView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    
    Public Function ChamaPagamentosRecebidosAtual(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/PagamentosRecebidosAtualView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    
    Public Function VendasFechadas(){
        $model = new RelatoriosVendasModel();
        $dadosComissao = $model->VendasFechadas();
        echo $dadosComissao;
        flush();
    }
    
    Public Function PagamentosRecebidos(){
        $model = new RelatoriosVendasModel();
        $dadosComissao = $model->PagamentosRecebidos();
        echo $dadosComissao;
        flush();
    }
    
    Public Function PagamentosRecebidosAtual(){
        $model = new RelatoriosVendasModel();
        $dadosComissao = $model->PagamentosRecebidosAtual();
        echo $dadosComissao;
        flush();
    }

    Public Function ChamaVendasAbertas(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/VendasAbertasView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    
    Public Function VendasAbertas(){
        $model = new RelatoriosVendasModel();
        $dadosComissao = $model->VendasAbertas();
        echo $dadosComissao;
        flush();
    }
    /**
     * Chama a tela de Vendas Justificadas
     */
    Public Function ChamaVendasJustificadas(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/VendasJustificadasView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    /**
     * Pesquisa uma lista de vendas com justificativa por ter produtos com descontos abaixo do valor mínimo de venda.
     */
    Public Function VendasJustificadas(){
        $model = new RelatoriosVendasModel();
        $dadosComissao = $model->VendasJustificadas();
        echo $dadosComissao;
        flush();
    }
}
$RelatoriosVendasController = new RelatoriosVendasController();
?>