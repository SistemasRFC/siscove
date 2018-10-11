<?
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Seguranca/CadastroMenuDao.php");
class CadastroMenuModel extends BaseModel
{
    function CadastroMenuModel(){
        ob_start();
        session_start();
    }
    /**
     * Carrega Lista de menus
     * @param type $nmeLogin
     * @param type $txtSenha
     * @return type
     */
    function ListaMenus(){
        $dao = new CadastroMenuDao();
        return $dao->ListaMenus();
    }

    function AddMenu(){
        $dao = new CadastroMenuDao();
        return json_encode($dao->AddMenu());
    }

    function UpdateMenu(){
        $dao = new CadastroMenuDao();
        return json_encode($dao->UpdateMenu());
    }

    function DeleteMenu(){
        $dao = new CadastroMenuDao();
        return json_encode($dao->DeleteMenu());
    }

    function ListarMenusAutoComplete($parametro){
        $dao = new CadastroMenuDao();
        $lista = $dao->ListarMenusAutoComplete($parametro);
        $total = count($lista);
        $i=0;
        $data = array();
        while($i<$total ) {
            $data[] = array(
                'value' => $lista[$i]['DSC_MENU_W'],
                'label' => $lista[$i]['DSC_MENU_W'],
                'id' => $lista[$i]['COD_MENU_W'],
                'nmeController' => $lista[$i]['NME_CONTROLLER'],
                'nmeMethod' => $lista[$i]['NME_METHOD'],
                'indAtivo' => $lista[$i]['IND_MENU_ATIVO_W'],
                'codMenuPai' => $lista[$i]['COD_MENU_PAI_W'],
                'indAtalho' => $lista[$i]['IND_ATALHO'],
                'dscCaminhoImagem' => $lista[$i]['DSC_CAMINHO_IMAGEM']
            );
            $i++;
        }
        if (empty($data)){
            $data[] = array(
                'value' => '',
                'label' => 'Sem dados para a pesquisa',
                'id' => 0
            );
        }
        return json_encode($data);
    }

    function ListarMenusGrid(){
        $dao = new CadastroMenuDao();
        $lista = $dao->ListarMenusGrid();
        $listaBooleanAtivoAtualizada = BaseModel::AtualizaBooleanInArray($lista, 'IND_MENU_ATIVO_W', 'ATIVO');
        $listaBooleanAtalhoAtualizada = BaseModel::AtualizaBooleanInArray($listaBooleanAtivoAtualizada, 'IND_ATALHO', 'ATALHO');
        return json_encode($listaBooleanAtalhoAtualizada);
    }
}
?>
