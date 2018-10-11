<?
session_start();
if (!isset($_SESSION['cod_usuario'])){
    header("Location: index.php");
}
include_once("Dao/BaseDao.php");
$bd = new BaseDao();

if (!isset($form)){
    $form='';
}
if (!isset($_POST['sql'])){
    $_POST['sql']='';
}

if ($_POST['sql']!=''){
    $rs = $bd->selectDB($_POST['sql'], false);
	$rs = $rs[1];
    $tabela = "<table border='1'><tr>";
    $cabecalho = true;
    $total = count($rs);
    $conf = false;
    foreach($rs as $k => $v){ 
        foreach($v as $kk =>$vv){

            if ($cabecalho){
                if ($conf){
                    $tabela .= "<td>".$kk."</td>";  
                    $conf = false;
                }else{
                    $conf = true;
                }            
            }
        }        
        $cabecalho=false;
    }  
    $tabela .= '</tr>';
    $conf = true;
    foreach($rs as $k => $v){
        $tabela .= '<tr>';
        foreach($v as $kk =>$vv){
            if ($conf){
                $tabela .= "<td>".$vv."</td>";  
                $conf = false;
            }else{
                $conf = true;
            }              
            
        }
        $tabela .= "</tr>";
    }
    $tabela .= "</table>";
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
    </head>
    <body>
        <form name="form" method="post">
            <textarea id="sql" name="sql" cols="100" rows="10"></textarea>
            <input type="submit" value="Gerar"></br> 
            <?if (isset($tabela)){
                echo $tabela;
            }?>
        </form>
    </body>
</html>