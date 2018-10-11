<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Perfil/PerfilDao.php");
class PerfilModel extends BaseModel
{
    function PerfilModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    function ListarPerfilRestrito(){
        $dao = new PerfilDao();
        return json_encode($dao->ListarPerfilRestrito($_SESSION['cod_perfil']));
    }

    function ListarPerfilAtivo(){
        $dao = new PerfilDao();
        return json_encode($dao->ListarPerfilAtivo());
    }

    /**
     * Retorna uma Lista de perfis
     * @return JSON
     */
    function ListarPerfil(){
        $dao = new PerfilDao();
        $listaPerfil = $dao->ListarPerfil();
        $lista = BaseModel::AtualizaBooleanInArray($listaPerfil, 'IND_ATIVO', 'ATIVO');
        return json_encode($lista);
    }

    /**
     * Adiciona um perfil no banco de dados
     * Utilizado no PerfilController
     * @return int
     */
    Public Function AddPerfil(){
        $dao = new PerfilDao();
        return json_encode($dao->AddPerfil());
    }

    /**
     * Atualiza um perfil no banco de dados
     * @return int
     */
    Public Function UpdatePerfil(){
        $dao = new PerfilDao();
        return json_encode($dao->UpdatePerfil());
    }
    
    Public Function RetornaPerfilUsuarioLogado(){
        $dao = new PerfilDao();
        return json_encode($dao->RetornaPerfilUsuarioLogado($_SESSION['cod_usuario']));   
    }
 
}
?>
