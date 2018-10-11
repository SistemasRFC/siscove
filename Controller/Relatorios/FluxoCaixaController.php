<?
include_once("../BaseController.php");
include_once("../../Model/Relatorios/FluxoCaixaModel.php");
class FluxoCaixaController extends BaseController
{
  function FluxoCaixaController(){
    $this->verificaSessao();
    if (!isset($_REQUEST['method'])){
        $method = $_POST['method'];
    }else{
        $method = $_REQUEST['method'];
    }
    $string =$method.'()';
    $method = "\$this->".$string.";";
    eval($method); 
  }

  function ChamaView(){
      $params = array();
      $view = $this->getPath()."/View/Relatorios/FluxoCaixaView.php";
      echo ($this->gen_redirect_and_form($view, $params));
  }
  function BuscaFluxo(){
      $model = new FluxoCaixaModel();
      $lista = $model->BuscaFluxo();
      echo $lista;
      flush();
  }

}
$FluxoCaixaController = new FluxoCaixaController();
?>