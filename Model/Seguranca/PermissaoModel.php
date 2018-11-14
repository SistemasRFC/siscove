<?
include_once("../../Dao/Seguranca/PermissaoDao.php");
class PermissaoModel
{
    function PermissaoModel(){
        ob_start();
        session_start();
    }

    function ListarPerfil(){
        $dao = new PermissaoDao();
        return $dao->ListarPerfil();
    }

    function ListarMenus($json=false){
        $dao = new PermissaoDao();
        if ($json){
            return json_encode($dao->ListarMenus());
        }else{
            return $dao->ListarMenus();
        }
    }

    function AtualizaPermissoes(){
        $dao = new PermissaoDao();        
        $dao->RemovePermissoes('0');
        $array = explode("|", $_POST['C']);
        for ($i=0;$i<count($array)-1;$i++){
            $registro=explode(';',$array[$i]);            
            if ($registro[1]=='S'){
                $atualizado = $dao->AddPermissao($registro[0]);
            }else{
                $atualizado = $dao->RemovePermissoes($registro[0]);
            }
        }
        return json_encode($atualizado);
    }
}
?>
