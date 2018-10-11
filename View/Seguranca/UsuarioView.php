<? include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
    <head>
        <title>Cadastro de Usuários</title>
        <script src="js/UsuarioView.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8; IBM850; ISO-8859-1">

    </head>
    <body>
      <table width="100%" id="CadastroMenus">
          <tr>
              <td width="100%"
                  style="text-align:left;
                   height:10%;
                   font-size:14px;
                   color:#0150D3;
                   vertical-align:middle;
                   font-family: arial, helvetica, serif;">
                  Usu&aacute;rios
              </td>
          </tr>
        <tr>
            <td>
                <input type="button" id="btnNovo" value="Novo Usu&aacute;rio">
            </td>
        </tr>          
          <tr>
              <td id="tdGrid">
                  <div id="listaUsuarios">
                  </div>
              </td>
          </tr>
      </table>
      <div id="CadUsuarios">
            <div id="windowHeader">
            </div>
            <div style="overflow: hidden;" id="windowContent">
                <? include_once "CadUsuarioView.php";?>
            </div>
      </div>
    </body>
</html>