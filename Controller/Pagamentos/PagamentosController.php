<?php
include_once("../BaseController.php");
include_once("../../Model/Pagamentos/PagamentosModel.php");
class PagamentosController extends BaseController
{
    function PagamentosController(){
      eval("\$this->".BaseController::getMethod()."();");
    }

    function ChamaView(){
        $params = array();
        $view = $this->getPath()."/View/Pagamentos/".str_replace("Controller", "View", get_class($this)).".php";
        echo ($this->gen_redirect_and_form($view, $params));
    }
    
    function ListarContas(){
        $PagamentosModel = new PagamentosModel();
        echo $PagamentosModel->ListarContas();
    }
    
    function ListarPagamentos(){
        $PagamentosModel = new PagamentosModel();
        echo $PagamentosModel->ListarPagamentos();        
    }
    
    function ListarChequesRecebidos(){
        $PagamentosModel = new PagamentosModel();
        echo $PagamentosModel->ListarChequesRecebidos();
    }

    function InserirPagamento(){
        $PagamentosModel = new PagamentosModel();
        echo $PagamentosModel->InserirPagamento();
    }

    function UpdatePagamento(){
        $PagamentosModel = new PagamentosModel();
        echo $PagamentosModel->UpdatePagamento();
    }

    function InserirConta(){
        $PagamentosModel = new PagamentosModel();
        echo $PagamentosModel->InserirConta();
    }

    function UpdateConta(){
        $PagamentosModel = new PagamentosModel();
        echo $PagamentosModel->UpdateConta();
    }

    function DeletarConta(){
        $PagamentosModel = new PagamentosModel();
        echo $PagamentosModel->DeletarConta();
    }

    function DeletarPagamento(){
        $PagamentosModel = new PagamentosModel();
        echo $PagamentosModel->DeletarPagamento();
    }
    
    Function ListarMeses(){
        $meses[1] = array(array('NRO_MES_REFERENCIA' => '01',
                             'DSC_MES_REFERENCIA' => 'Janeiro'),
                       array('NRO_MES_REFERENCIA' => '02',
                             'DSC_MES_REFERENCIA' => 'Fevereiro'),
                       array('NRO_MES_REFERENCIA' => '03',
                             'DSC_MES_REFERENCIA' => 'Março'),
                       array('NRO_MES_REFERENCIA' => '04',
                             'DSC_MES_REFERENCIA' => 'Abril'),
                       array('NRO_MES_REFERENCIA' => '05',
                             'DSC_MES_REFERENCIA' => 'Maio'),
                       array('NRO_MES_REFERENCIA' => '06',
                             'DSC_MES_REFERENCIA' => 'Junho'),
                       array('NRO_MES_REFERENCIA' => '07',
                             'DSC_MES_REFERENCIA' => 'Julho'),
                       array('NRO_MES_REFERENCIA' => '08',
                             'DSC_MES_REFERENCIA' => 'Agosto'),
                       array('NRO_MES_REFERENCIA' => '09',
                             'DSC_MES_REFERENCIA' => 'Setembro'),
                       array('NRO_MES_REFERENCIA' => '10',
                             'DSC_MES_REFERENCIA' => 'Outubro'),
                       array('NRO_MES_REFERENCIA' => '11',
                             'DSC_MES_REFERENCIA' => 'Novembro'),
                       array('NRO_MES_REFERENCIA' => '12',
                             'DSC_MES_REFERENCIA' => 'Dezembro'));
        echo json_encode($meses);
    }
    
    Function ListarAnos(){
        $nroAno = date("Y")+1;
        $anos = array();
        $j=0;
        for($i=2012;$i<=$nroAno;$i++){            
            $anos[1][$j] = array('NRO_ANO_REFERENCIA' => $i);
            $j++;
        }
        echo json_encode($anos);
    }
}
$PagamentosController = new PagamentosController();
?>