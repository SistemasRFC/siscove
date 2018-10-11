<?php
include_once("../BaseController.php");
include_once("../../Model/Cliente/ClienteModel.php");
class ClienteController extends BaseController
{
    Public Function ClienteController(){
      eval("\$this->".BaseController::getMethod()."();");
    }
  
    Public Function ChamaView(){
      $view = $this->getPath()."/View/Cliente/".str_replace("Controller", "View", get_class($this)).".php";
      header("Location: ".$view);
    }

    Public Function ListarClienteGrid(){
      $model = new ClienteModel();
      echo $model->ListarClienteGrid();
    }

    Public Function ListarClienteAutoComplete(){
      $model = new ClienteModel();
      echo $model->ListarClienteAutoComplete();
    }

    Public Function ListarClienteCpfAutoComplete(){
      $model = new ClienteModel();
      echo $model->ListarClienteCpfAutoComplete();
    }

    Public Function CarregaDadosCliente(){
      $model = new ClienteModel();
      echo $model->CarregaDadosCliente();
    }

    Public Function AddCliente(){
      $model = new ClienteModel();
      echo $model->AddCliente();
    }
    
    Public Function UpdateCliente(){
      $model = new ClienteModel();
      echo $model->UpdateCliente();
    }

    Public Function DeleteCliente(){
      $model = new ClienteModel();
      echo $model->DeleteCliente();
    }
    
    Public Function ListarVendasPorCliente(){
      $model = new ClienteModel();
      echo $model->ListarVendasPorCliente();
    }
    
    Public Function ListarEstados(){
      $model = new ClienteModel();
      echo $model->ListarEstados();
    }
    
    Public Function PesquisaCep(){
        $ch = curl_init();
        $cep = str_replace('.', '', filter_input(INPUT_POST, 'nroCep', FILTER_SANITIZE_STRING));
        $cep = str_replace('-', '', $cep);
        $url = "http://viacep.com.br/ws/".$cep."/json/";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $body = curl_exec($ch);
        echo $body;
    }
}
$clienteController = new ClienteController();
?>