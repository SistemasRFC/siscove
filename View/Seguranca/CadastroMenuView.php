<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<? include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
  <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="js/CadastroMenuView.js"></script>

  </head>
  <body>
      <input type="hidden" id="method" name="method">
      <table width="100%" id="CadastroMenus">
          <tr>
              <td width="100%"
                  style="text-align:left;
                   height:10%;
                   font-size:14px;
                   color:#0150D3;
                   vertical-align:middle;
                   font-family: arial, helvetica, serif;">
                  Cadastro de Menus
              </td>
          </tr>
          <tr>
              <td>
                  <input type="button" id="btnNovo" value="Novo Menu"> 
              </td>
          </tr>          
          <tr>
              <td id="tdMenus">
                  <div id="listaMenus"></div>
              </td>
          </tr>
      </table>
      <div id="CadMenus">
            <div id="windowHeader">
            </div>
            <div style="overflow: hidden;" id="windowContent">
                <? include_once "CadMenuView.php";?>
            </div>            
      </div>
      <div id='jqxMenu' style="display: none;">
        <ul>
            <li><a href="#">Novo</a></li>
            <li><a href="#">Editar</a></li>            
        </ul>
      </div>
  </body>
</html>
