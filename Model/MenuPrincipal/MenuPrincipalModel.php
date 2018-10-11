<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/MenuPrincipal/MenuPrincipalDao.php");
class MenuPrincipalModel extends BaseModel
{
    function MenuPrincipalModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    /**
     * Carrega o menu principal
     * @param type $codUsuario
     * @param type $codMenuPai 
     */
    function carregaMenu($codMenuPai,
                         $path){
        $dao = new MenuPrincipalDao();
        $menuPai = $dao->CarregaMenu($_SESSION['cod_usuario'], $codMenuPai, $path);
        $menuFilho = array();
        if (!$menuPai[1]==null){
            for($i=0;$i<count($menuPai[1]);$i++){
                $dados = $dao->CarregaMenu($_SESSION['cod_usuario'], $menuPai[1][$i]['COD_MENU_W'], $path);
                for($j=0;$j<count($dados[1]);$j++){
                    array_push($menuFilho, $dados[1][$j]);
                }
            }
            $_SESSION['menuPai'] = $menuPai[1];
            $_SESSION['menuFilho'] = $menuFilho[1];
        }else{
            $_SESSION['menuPai'] = '';
            $_SESSION['menuFilho'] = '';
        }
    }

    function CarregaMenuNew($path){
        $dao = new MenuPrincipalDao();
        return json_encode($dao->CarregaMenuNew($_SESSION['cod_usuario'], $path));
    }

    function CarregaController($codMenu, $path){
        $dao = new MenuPrincipalDao();
        $controller = $dao->CarregaController($codMenu, $path);
        if ($controller->NME_METHOD!=''){
            return json_encode($controller->NME_CONTROLLER."?method=".$rs_localiza->NME_METHOD);
        }else{
            return json_encode('#');
        }
    }

    /**
     * Retorna uma lista de atalhos configurados no Cadastro de Menu
     */
    Public Function CarregaAtalhos($path){
        $dao = new MenuPrincipalDao();
        $_SESSION['ListaAtalhos'] = $dao->CarregaAtalhos($_SESSION['cod_usuario'], $path);
        return json_encode($_SESSION['ListaAtalhos']);
    }

    Public Function CarregaDadosUsuario(){
        $dao = new MenuPrincipalDao();
        $_SESSION['DadosUsuario'] = $dao->CarregaDadosUsuario($_SESSION['cod_usuario']);
    }
}
?>
