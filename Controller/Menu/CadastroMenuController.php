<?php
include_once("../BaseController.php");
include_once("../../Model/Menu/CadastroMenuModel.php");
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
        $view = $this->getPath()."/View/Menu/".str_replace("Controller", "View", get_class($this)).".php";
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

    function ListaMenus(){
        $model = new CadastroMenuModel();
        echo $model->ListaMenus();
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
    
    Public Function ListarMetodos(){
        $pastaAtual = filter_input(INPUT_POST, 'pastaAtual');
        $classe = filter_input(INPUT_POST, 'classe');
        $pasta = getcwd();
        $novo = explode('\\', $pasta);
        $pasta='';
        for ($i=0;$i<count($novo)-1;$i++){
            $pasta.=$novo[$i].'\\';
        }          
        $arquivo = $pasta.$pastaAtual.'\\'.$classe;        
        if (file_exists($arquivo)){
            $file = fopen($arquivo, 'r');
            $linha='';
            while (!feof($file)){
                $linha = fgets($file, 4096);
                $linha = trim($linha);                
                $pos = strpos(strtoupper($linha), strtoupper('function'));                
                if ($pos!==FALSE){
                    $methodo=substr($linha,$pos+strlen('function')+1);
                    $methodo=str_replace('{','',str_replace(')','',str_replace('(', ' ',$methodo)));
                    $methodo = explode(' ', $methodo);
                    $methods[]['dscMetodo'] = $methodo[0];
                }
                
            }
            fclose($file);
        }else{
            echo "cade o arquivo".$arquivo;
        }
        echo json_encode($methods);
    }
    
    Public Function ListarController(){
        $pasta = getcwd();        
        $novo = explode('\\', $pasta);
        $pasta='';
        for ($i=0;$i<count($novo)-1;$i++){
            $pasta.=$novo[$i].'\\';
        }         
        if (filter_input(INPUT_POST, 'pasta')!=''){
            $pasta = $pasta.filter_input(INPUT_POST, 'pasta').'\\';
        }               
        $pasta = $this->PegarArquivosPasta($pasta);
        echo json_encode($pasta);
    }

    Public Function PegarArquivosPasta($pasta){
        //echo $pasta; exit;
        $diretorio = $pasta;
        $ponteiro  = opendir($diretorio);
        while ($nome_itens = readdir($ponteiro)) {
            $itens[] = $nome_itens;
        }
        sort($itens);
        $i=0;
        foreach ($itens as $listar) {
                $arquivosPasta[$i]['nmeArquivo'] = $listar;
                $arquivosPasta[$i]['dscTipo'] = filetype($pasta.$listar);
                if (filetype($pasta.$listar)=="dir"){
                    $arquivosPasta[$i]['dscTamanho'] = "0";
                }else{
                    $arquivosPasta[$i]['dscTamanho'] = filesize($pasta.$listar);
                }
                $arquivosPasta[$i]['dtaAlteracao'] = date ("d/m/Y H:i:s", filemtime($pasta.$listar));
                $i++;
        }
        return $arquivosPasta;
    }
}
$cadastroMenuController = new CadastroMenuController();
?>