<?php
include_once("../BaseController.php");
include_once("../../Model/Vendas/FormaPagamentoVendasModel.php");
class FormaPagamentoVendasController extends BaseController
{
    function FormaPagamentoVendasController(){
      eval("\$this->".BaseController::getMethod()."();");
    }

    function ChamaView(){
        $formaPagamentoVendasForm = new FormaPagamentoVendasForm();
        $formaPagamentoVendasModel = new FormaPagamentoVendasModel();
        $produtosVendasModel = new ProdutosVendasModel();
        $modelPerfil = new PerfilModel();
        $listaTipoPagamento = $formaPagamentoVendasModel->ListarTipoPagamento();
        $dadosVenda = $produtosVendasModel->ListarDadosVenda();
        $verificaValorAbaixo = $produtosVendasModel->VerificaValoresAbaixoMinimo($formaPagamentoVendasForm->getCodVenda());
        $listaPagamentoVendas = $formaPagamentoVendasModel->ListarPagamentosVendas();
        $codPerfil = $modelPerfil->RetornaPerfilUsuarioLogado();
        $params = array('dadosVenda' => urlencode(serialize($dadosVenda)),
                        'listaTipoPagamento' => urlencode(serialize($listaTipoPagamento)),
                        'listaPagamentoVendas' => urlencode(serialize($listaPagamentoVendas)),
                        'codVenda' => urlencode(serialize($formaPagamentoVendasForm->getCodVenda())),
                        'nmeVendedor' => urlencode(serialize($dadosVenda->NME_VENDEDOR)),
                        'codVenda' => urlencode(serialize($dadosVenda->COD_VENDA)),
                        'codVeiculo' => urlencode(serialize($dadosVenda->COD_VEICULO)),
                        'dscVeiculo' => urlencode(serialize($dadosVenda->DSC_VEICULO)),
                        'codCliente' => urlencode(serialize($dadosVenda->COD_CLIENTE)),
                        'dscCliente' => urlencode(serialize($dadosVenda->DSC_CLIENTE)),
                        'dtaVenda' => urlencode(serialize($produtosVendasModel->ConverteDataBanco($dadosVenda->DTA_VENDA))),
                        'nroPlaca' => urlencode(serialize($dadosVenda->NRO_PLACA)),
                        'vlrVenda' => urlencode(serialize($dadosVenda->VLR_VENDA)),
                        'vlrDesconto' => urlencode(serialize($dadosVenda->VLR_DESCONTO)),
                        'indAbaixo' => $verificaValorAbaixo,
                        'codPerfil' => $codPerfil[0]['COD_PERFIL_W']);
        $view = $this->getPath()."/View/Vendas/".str_replace("Controller", "View", get_class($this)).".php";
        echo ($this->gen_redirect_and_form($view, $params));
    }

    function ListarTipoPagamento(){
        $formaPagamentoVendasModel = new FormaPagamentoVendasModel();
        echo $formaPagamentoVendasModel->ListarTipoPagamento();
    }

    function InserirPagamento(){
        $formaPagamentoVendasModel = new FormaPagamentoVendasModel();
        echo $formaPagamentoVendasModel->InserirPagamento();
    }

    function DeletarPagamentoVenda(){
        $formaPagamentoVendasModel = new FormaPagamentoVendasModel();
        echo $formaPagamentoVendasModel->DeletarPagamentoVenda();
    }

    function FecharVenda(){
        $formaPagamentoVendasModel = new FormaPagamentoVendasModel();
        $dado = $formaPagamentoVendasModel->FecharVenda();
        echo $dado;
    }

    Function ListarPagamentosVendasGrid(){
        $formaPagamentoVendasModel = new FormaPagamentoVendasModel();
        echo $formaPagamentoVendasModel->ListarPagamentosVendasGrid();
    }
    
    Public Function VerificaValoresAbaixoMinimo(){
        $formaPagamentoVendasModel = new FormaPagamentoVendasModel();
        echo $formaPagamentoVendasModel->VerificaValoresAbaixoMinimo();
    }
}
$FormaPagamentoVendasController = new FormaPagamentoVendasController();
?>