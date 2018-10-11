<?
include_once("../BaseController.php"); 
include_once("../../Model/Menu/MenuModel.php");
class MenuController extends BaseController
{
    function MenuController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
     * Redireciona para a Tela de  de Menu
     */
    Public Function ChamaView(){
        $params = array();
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Public Function ListarMenu(){
        $MenuModel = new MenuModel();
        echo $MenuModel->ListarMenu();
    }
    
    Public Function InsertMenu(){
        $MenuModel = new MenuModel();
        echo $MenuModel->InsertMenu();
    }

    Public Function UpdateMenu(){
        $MenuModel = new MenuModel();
        echo $MenuModel->UpdateMenu();
    }	
}
$classController = new MenuController();