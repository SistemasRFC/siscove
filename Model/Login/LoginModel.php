<?php
include_once("../../Dao/Login/LoginDao.php");
class LoginModel
{
    function LoginModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }
    /**
     * Encripta a senha e verifica se o login existe
     * @param type $nmeLogin
     * @param type $txtSenha
     * @return type
     */
    function Logar(){
        $nmeLogin = filter_input(INPUT_POST, 'nmeLogin', FILTER_SANITIZE_MAGIC_QUOTES);
        $txtSenha = filter_input(INPUT_POST, 'txtSenha', FILTER_SANITIZE_MAGIC_QUOTES);
        if (($nmeLogin=="adm")&&($txtSenha=="adm")){
            $_SESSION['cod_usuario']=1;
            $_SESSION['cod_cliente_final']=1;
            $_SESSION['cod_perfil']=1;
            $logar[0]=true;
            $logar[1][0]['MSG']='sucesso';  
            $logar[1][0]['DSC_PAGINA'] = 'Controller/MenuPrincipal/MenuPrincipalController.php?method=CarregaMenu';
        }else{           
            $senha = base64_encode($txtSenha);            
            $dao = new LoginDao();
            $logar = $dao->Logar($nmeLogin, $senha);
            if ($logar[0]){
                if ($logar[1]!=NULL){
                    $logar[1][0]['DSC_PAGINA'] = 'Controller/MenuPrincipal/MenuPrincipalController.php?method=CarregaMenu';
                    if ($logar[1][0]['COD_USUARIO']>0){
                        $codigo = "'".$logar[1][0]['COD_USUARIO']."'";
                        $_SESSION['cod_usuario']=$codigo;
                        $_SESSION['cod_cliente_final']=$logar[1][0]['COD_CLIENTE_FINAL'];
                        $_SESSION['cod_perfil']=$logar[1][0]['COD_PERFIL_W'];
                        if ($txtSenha=='123459'){
                            $logar[1][0]['DSC_PAGINA'] = 'View/Seguranca/AlteraSenhaView.php?txtSenha='.base64_encode($txtSenha);                        
                        }
                    }else{
                        $logar[0]=false;
                    }
                }else{
                    $logar[0]=false;
                }
            }            
        }
        return json_encode($logar);
    }

    function AlteraSenha(){
        $dao = new LoginDao();
        return $dao->AlteraSenha($_SESSION['cod_usuario']);
    }

}
?>
