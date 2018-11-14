<?php
include_once("../BaseController.php");
include_once("../../Model/Relatorios/RelatorioOperacoesModel.php");
class RelatorioOperacoesController extends BaseController
{
    Public Function RelatorioOperacoesController(){
        eval("\$this->".BaseController::getMethod()."();");
    }
    
    /**
     * Chama a tela do relatório de log do sistema
     */
    Public Function ChamaView(){
        $params = array();
        $view = $this->getPath()."/View/Relatorios/RegistroOperacoesView.php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    
    Public Function ListarRegistros (){
        $model = new RelatorioOperacoesModel();
        $registrosVenda = $model->ListarRegistrosVenda();
        $registrosProduto = $model->ListarRegistrosProduto();
        $registrosPagamento = $model->ListarRegistrosPagamento();
        $params[0] = $registrosVenda[1];
        $params[1] = $registrosProduto[1];
        $params[2] = $registrosPagamento[1];
//        $params = array('registroVenda' => urlencode(serialize($registrosVenda[1])),
//                        'registroProdutos' => urlencode(serialize($registrosProduto[1])),
//                        'registroPagamentos' => urlencode(serialize($registrosPagamento[1])));
        echo json_encode($params);
    }

}
$RelatorioOperacoesController = new RelatorioOperacoesController();
?>