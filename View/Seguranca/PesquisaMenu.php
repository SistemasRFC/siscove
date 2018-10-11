<script>
$(function() {
    $('#parametro').autocomplete({
        source:'../../Controller/Seguranca/CadastroMenuController.php?method=ListarMenusGrid',
        minLength:2,
        select: function(event, ui) {

            if (ui.item.id!=0){
                $("#indAtivo1").val(ui.item.indAtivo);
                $("#codMenu").val(ui.item.id);
                $("#dscMenu").val(ui.item.value);
                $("#nmeController").val(ui.item.nmeController);
                $("#nmeMethod").val(ui.item.nmeMethod);
                $("#codMenuPai").val(ui.item.codMenuPai);
                $("#dscCaminhoImagem").val(ui.item.dscCaminhoImagem);
                if (ui.item.indAtivo=='S'){
                    $("#indAtivo").attr("checked",true);
                }else{
                    $("#indAtivo").attr("checked",false);
                }
                if (ui.item.indAtalho=='S'){
                    $("#indAtalho").attr("checked",true);
                }else{
                    $("#indAtalho").attr("checked",false);
                }
                $(this).closest("#PesquisaMenuForm").dialog("close");
            }
        }
    });
});
  </script>
<form name="pesquisaClienteForm" method="post">
<table width="70%" align="center" border="0">
<tr>
  <td>
  <table width="100%" align="center">
   <tr>
     <td>Digite a Descrição do menu</td>
   </tr>
  <tr>
    <td>
        <input type="text" size="50" name="parametro" id="parametro" value="">
    </td>
  </tr>
  </table>
  </td>
</tr>
</table>
</form>
