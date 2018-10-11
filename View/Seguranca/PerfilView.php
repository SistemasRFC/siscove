<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<? include_once "../../View/MenuPrincipal/Cabecalho.php";?>
<html>
  <head>
      <title>Cadastro de Classifica&ccedil;&atilde;o</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="js/PerfilView.js"></script>

  </head>
  <body>
      <input type="hidden" id="method" name="method" value="">
      <table width="100%" id="CadastroPerfil">
          <tr>
              <td width="100%" style="text-align:left;height:10%;font-size:18px;color:#000000;vertical-align:middle;font-family: arial, helvetica, serif;border-bottom: 1px solid #000000;">
                  Cadastro de Perfil
              </td>
          </tr>
          <tr>
              <td>
                  <input type="button" id="btnNovo" value="Novo Perfil">
              </td>
          </tr>
          <tr>
              <td id='tdListaPerfil'>
                  <div id="listaPerfil"></div>
              </td>
          </tr>
      </table>
      <div id="CadPerfil">
            <div id="windowHeader">
            </div>
            <div style="overflow: hidden;" id="windowContent">
                <? include_once "CadPerfilView.php";?>
            </div>
      </div>
  </body>
</html>
