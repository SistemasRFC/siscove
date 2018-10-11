<?
include_once("../BaseController.php");
include_once("../../Model/Relatorios/RelatoriosFluxoCaixaModel.php");
class RelatoriosFluxoCaixaController extends BaseController
{
  function RelatoriosFluxoCaixaController(){
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
      $view = $this->getPath()."/View/Relatorios/RelatoriosFluxoCaixaView.php";
      echo ($this->gen_redirect_and_form($view, $params));
  }
  function BuscaFluxo(){
      $model = new RelatoriosFluxoCaixaModel();
      $lista = $model->BuscaFluxo();
      echo $lista;
      flush();
  }

}
$RelatoriosFluxoCaixaController = new RelatoriosFluxoCaixaController();
?>