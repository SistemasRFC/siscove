<?php
ob_start();
ini_set('display_errors', true);
error_reporting(E_ALL & ~E_WARNING & ~ E_DEPRECATED);
require_once getenv("CONSTANTES");

class BaseController
{
    public static $defaultPath = "siscove";
    /**
     *Construtor da BaseController 
     */
    public function BaseController(){    

    }
    
    Public function gen_redirect_and_form($page, $data, $host="")
    {
            $ret = '<html><body onLoad="javascript:submitform();">';
            $ret .= '<script type="text/javascript">
                        function submitform()
                        {
                            document.formReq.submit();
                        }
                    </script>';
            $ret .= '  <form name = "formReq" method="POST" action="'.$page.'">';
            $i=0;
            foreach ($data as $k => $dados) {
              $ret .= '    <input type="hidden" name="'.$k.'" value="'.$dados.'"/>';
              $i++;
            }
            $ret .= '  </form>';
            $ret .= '</body></html>';
            
            return $ret;
    }
    
    /**
     * Retorna a url Base
     * @return String
     */
    Public Static function getPath(){        
        return 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']."/".static::$defaultPath;
    }

    /**
     * Retorna o method passado por par�metro via get ou post
     * @return String
     */
    Public Static Function getMethod(){
        if (!filter_input(INPUT_POST, 'method')){
            return filter_input(INPUT_GET, 'method');
        }else{
            return filter_input(INPUT_POST, 'method');
        }
    }
    
    /**
     * Retorna o nome da view a ser chamada
     * @param String $class
     * @return String
     */
    Public Static Function ReturnView($path, $class){        
        return $path."/View/".str_replace("Controller", "", $class)."/".str_replace("Controller", "View", $class).".php";
    }
    
}
$base = new BaseController();
?>
