<?
include_once("../BaseController.php"); 
include_once("../../Model/Aluno/AlunoModel.php");
class AlunoController extends BaseController
{
    function AlunoController(){
        eval("\$this->".BaseController::getMethod()."();");
    }

    /**
     * Redireciona para a Tela de  de Aluno
     */
    Public Function ChamaView(){
        $params = array();
        echo ($this->gen_redirect_and_form(BaseController::ReturnView(BaseController::getPath(), get_class($this)), $params));
    }

    Public Function ListarAluno(){
        $AlunoModel = new AlunoModel();
        echo $AlunoModel->ListarAluno();
    }
    
    Public Function InsertAluno(){
        $AlunoModel = new AlunoModel();
        echo $AlunoModel->InsertAluno();
    }

    Public Function UpdateAluno(){
        $AlunoModel = new AlunoModel();
        echo $AlunoModel->UpdateAluno();
    }	
}
$classController = new AlunoController();