<?php
include_once("../BaseController.php");
include_once("../../Model/Seguranca/CadastroMenuModel.php");
class CadastroMenuController extends BaseController
{
    function CadastroMenuController(){
        eval("\$this->".BaseController::getMethod()."();");
    }
    /**
     * Redireciona para a view indicada
     */
    function ChamaView(){
        $model = new CadastroMenuModel();
        $lista = $model->ListaMenus();
        $params = array('ListaMenus' => urlencode(serialize($lista)));
        $view = $this->getPath()."/View/Seguranca/".str_replace("Controller", "View", get_class($this)).".php";
        echo ($this->gen_redirect_and_form($view, $params));    
    }
    /**
    * Adiciona um menu na tabela SE_MENU
    */
    function AddMenu(){
        $model = new CadastroMenuModel();
        echo $model->AddMenu();
    }

    function UpdateMenu(){
        $model = new CadastroMenuModel();
        echo $model->UpdateMenu();
    }

    function DeleteMenu(){
        $model = new CadastroMenuModel();
        echo $model->DeleteMenu();
    }

    function ListarMenusAutoComplete(){
        if ( !isset($_REQUEST['term']) )
            exit;
        $model = new CadastroMenuModel();
        $lista = $model->ListarMenusAutoComplete($_REQUEST['term']);
        echo $lista;
        flush();
    }

    Public Function ListarMenusGrid(){
        $model = new CadastroMenuModel();
        echo $model->ListarMenusGrid();
    }

    Public Function uploadArquivo(){      
        $arquivo = $_FILES['arquivo'];
        $tipos = array('jpg', 'png', 'gif', 'psd', 'bmp');
        $enviar = $this->uploadFile($arquivo, '../../Resources/images/', $tipos);
        $data['sucesso'] = false;
        if(isset($enviar['erro'])){
            $data['msg'] = $enviar['erro'];
        }else{
            $data['sucesso'] = true;
            $data['msg'] = $enviar['caminho'];
        }
        echo json_encode($data);
    }

    function uploadFile($arquivo, $pasta, $tipos, $nome = null){
        $nomeOriginal='';
        if(isset($arquivo)){
            $infos = explode(".", $arquivo["name"]);

            if(!$nome){
                for($i = 0; $i < count($infos) - 1; $i++){
                    $nomeOriginal = $nomeOriginal . $infos[$i] . ".";
                }
            }
            else{
                $nomeOriginal = $nome . ".";
            }
            $tipoArquivo = $infos[count($infos) - 1];

            $tipoPermitido = false;
            foreach($tipos as $tipo){
                if(strtolower($tipoArquivo) == strtolower($tipo)){
                    $tipoPermitido = true;
                }
            }
            if(!$tipoPermitido){
                $retorno["erro"] = "Tipo nÃ£o permitido";
            }
            else{
                if(move_uploaded_file($arquivo['tmp_name'], $pasta . $nomeOriginal . $tipoArquivo)){
                    $retorno["caminho"] = $pasta . $nomeOriginal . $tipoArquivo;
                }
                else{
                    $retorno["erro"] = "Erro ao fazer upload";
                }
            }
        }
        else{
            $retorno["erro"] = "Arquivo nao setado";
        }
        return $retorno;
    }
}
$cadastroMenuController = new CadastroMenuController();
?>