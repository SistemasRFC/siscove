<?
include_once("../BaseController.php");
include_once("../../Model/Seguranca/PermissaoModel.php");
class PermissaoController extends BaseController
{
  function PermissaoController(){
    $method = $_REQUEST['method'];
    $string =$method.'()';
    $method = "\$this->".$string.";";
    eval($method);

  }
  /**
   * Redireciona para a view indicada
   */
  function ChamaView(){
    $model = new PermissaoModel();
    $listaPerfil = $model->ListarPerfil();
    $listaMenus = $model->ListarMenus();
    if (!isset($_POST['codPerfil'])){
        $codPerfil=0;
    }else{
        $codPerfil=$_POST['codPerfil'];
    }
    $params = array('ListaPerfil' => urlencode(serialize($listaPerfil)),
                    'ListaMenus' => urlencode(serialize($listaMenus)),
                    'codPerfil' => urlencode(serialize($codPerfil)));
    $view = $this->getPath()."/View/Seguranca/".str_replace("Controller", "View", get_class($this)).".php";
    echo ($this->gen_redirect_and_form($view, $params));
  }

  Public Function ListarMenus(){
    $model = new PermissaoModel();
    echo $model->ListarMenus(true);
  }
  function AtualizaPermissoes(){
    $model = new PermissaoModel();
    echo $model->AtualizaPermissoes();
  }
}
$PermissaoController = new PermissaoController();
?>