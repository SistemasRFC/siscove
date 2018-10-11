<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Funcionario/FuncionarioDao.php");
include_once("../../Model/Seguranca/PerfilModel.php");
class FuncionarioModel extends BaseModel
{
    Public Function FuncionarioModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarFuncionarioGrid($Json=true){
        $dao = new FuncionarioDao();
        $lista = $dao->ListarFuncionarioGrid($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            for($i=0;$i<count($lista[1]);$i++){
                $lista = BaseModel::AtualizaBooleanInArray($lista, 'IND_ATIVO', 'ATIVO');
            }
        }        
        return json_encode($lista);
    }

    Public Function ListarFuncionariosAtivos($Json=true){
        $dao = new FuncionarioDao();
        $lista = $dao->ListarFuncionariosAtivos($_SESSION['cod_cliente_final']);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }        
    }

    Public Function ListarVendedoresAtivos($Json=true){
        $dao = new FuncionarioDao();
        $lista = $dao->ListarVendedoresAtivos($_SESSION['cod_cliente_final']);       
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function ListarFuncionarioComissaoVendedores(){
        $dao = new FuncionarioDao();
        $modelPerfil = new PerfilModel();
        $codPerfil = $modelPerfil->RetornaPerfilUsuarioLogado();
        if ($codPerfil[0]['COD_PERFIL_W']==4 && $parametro==null){
            $parametro = "COD_USUARIO = ".$_SESSION['cod_usuario'];
        }
        return $dao->ListarFuncionario($_SESSION['cod_cliente_final'],
                                       $parametro);
    }

    Public Function AddFuncionario($codClienteFinal=null){
        if ($codClienteFinal==null){
            $codClienteFinal = $_SESSION['cod_cliente_final'];
        }
        $dao = new FuncionarioDao();
        $result = json_encode($dao->AddFuncionario($codClienteFinal));
        return $result;
    }

    Public Function UpdateFuncionario(){
        $dao = new FuncionarioDao();
        return json_encode($dao->UpdateFuncionario());
    }
}
?>
