$(function() {
    $("#vlrTotalVenda").maskMoney({symbol:"R$ ",decimal:",",thousands:"."});
    $( "#dialogInformacao" ).dialog({
            autoOpen: false,
            width: 450,
            show: 'explode',
            hide: 'explode',
            title: 'Mensagem',
            modal: true,
            buttons: [
                    {
                            text: "Ok",
                            id: "btnOK",
                            click: function() {
                                    $( this ).dialog( "close" );
                            }
                    }
            ]
    });

    $( "#CadastroForm" ).dialog({
        autoOpen: true,
        width: '90%',
        position: [0,0],
        title: 'Cadastro de Vendas',
        buttons: [
        {
            text: "Cadastro de Vendas",
            id: "btnCadVendas",
            title: "Redireciona para a tela de Cadastro de vendas",
            click: function() {
                $("#ProdutosVendasForm").attr("action","../../Controller/Vendas/VendasController.php");
                document.ProdutosVendasForm.codVenda.value='0';
                document.ProdutosVendasForm.method.value='ChamaView';
                $("#ProdutosVendasForm").submit();
            }
        },
        {
            text: "Cadastro de Orçamento",
            id: "btnCadOrcamentos",
            title: "Redireciona para a tela de Cadastro de orçamento",
            click: function() {
                $("#ProdutosVendasForm").attr("action","../../Controller/Vendas/VendasController.php");
                document.ProdutosVendasForm.method.value='ChamaView';
                $("#ProdutosVendasForm").submit();
            }
        },
        {
            text: "Consolidar Orçamento",
            id: "btnGerarVenda",
            title: "Gera uma venda a partir deste orçamento",
            click: function() {
                var selecionados = $("input:checkbox:checked.indEstoque").map(function(){
                   return this.id;
                }).get();
                //alert(selecionados);
                $("#ProdutosVendasForm").attr("action","../../Controller/Vendas/VendasController.php");
                document.ProdutosVendasForm.method.value='ConsolidaOrcamento';
                document.ProdutosVendasForm.codProdutoVenda.value=selecionados;
                $("#ProdutosVendasForm").submit();
            }
        },
        {
                text: "Resumo Orçamento",
                id: "btnResumoOrcamento",
                title: "Mostra um popup com o resumo deste orçamento.",
                click: function() {
                    if ($("#codVenda").val()!='0'){
                        window.open('../../Controller/Relatorios/RelatoriosVendasController.php?codVenda='+$("#codVenda").val()+'&method=ResumoVenda','page','left=100,top=50,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=700,height=500');
                    }else{
                        $( "#dialogInformacao" ).html('Selecione uma venda antes!');
                        $( "#dialogInformacao" ).dialog( "open" );
                    }
                }
            }],
        close: function(ev, ui) { window.location='../../Controller/MenuPrincipal/MenuPrincipalController.php?method=CarregaMenu'; }
    });
});

function deletarProduto(trId, codProduto, codVenda, nroSequencial, qtdVenda, vlrVenda, vlrDesconto, vindEstoque){
    $( "#dialogInformacao" ).html('Aguarde Removendo o produto');
    $("#btnOK").hide();
    $( "#dialogInformacao" ).dialog( "open" );
    $.post('../../Controller/Vendas/ProdutosVendasController.php',
          {method:'DeletarProdutoVenda',
           codVenda: codVenda,
           nroSequencialVenda: nroSequencial,
           codProdutoVenda: codProduto,
           qtdVenda: qtdVenda,
           indEstoqueVenda: vindEstoque,
           nroStatusVenda: $("#nroStatusVenda").val()}, function(data){

                if(data==1){
                    $("#resultado").html('');
                    $("#vlrTotalVenda").val(0);
                    $.post('../../Controller/Vendas/ProdutosVendasController.php',
                         {method:'ListarProdutosVendasGrid',
                          codVenda: codVenda}, function(dado){
                           dado = eval('('+dado+')');
                           console.log(dado);
                          if (dado!=null){
                              CarregaTabela(dado);
                          }
                    });
                    $( "#dialogInformacao" ).html('Produto removido com sucesso!');
                    $("#btnOK").show();
                }else{
                    $( "#dialogInformacao" ).html('Erro ao remover produto!');
                    $("#btnOK").show();
                }
           }
    );
}

function CarregaTabela(data){
    tabela = '<table width="100%" id="resultado"> '+
                '<tr bgcolor="#fdf5ce" style=> '+
                '    <td>Vendedor</td> '+
                '    <td>Produto</td> '+
                '    <td>Qtd.</td> '+
                '    <td>Qtd. em Estoque</td> '+
                '    <td>Vlr unitário</td> '+
                '    <td>Vlr Desconto</td> '+
                '    <td>Valor</td> '+
                '    <td>&nbsp;</td> '+
                '    <td>Retirar do Estoque</td> '+
                '</tr> ';
    valorVenda = 0;
    for(i=0;i<data.length;i++){
        id = i;
        tabela += '<input type="hidden" id="qtdEstoque'+data[i].codProduto+'S'+data[i].nroSequencial+'S'+data[i].qtdVenda+'" value="'+data[i].qtdEstoque+'">';
        tabela += '<input type="hidden" id="qtdVenda'+data[i].codProduto+'S'+data[i].nroSequencial+'S'+data[i].qtdVenda+'" value="'+data[i].qtdVenda+'">';
        tabela += '     <tr id="'+id+'">';
        tabela += '         <td>'+data[i].nmeVendedor+'</td>';
        tabela += '         <td>'+data[i].dscProduto+'</td>';
        tabela += '         <td>'+data[i].qtdVenda+'</td>';
        tabela += '         <td>'+data[i].qtdEstoque+'</td>';
        tabela += '         <td>'+data[i].vlrVenda+'</td>';
        tabela += '         <td>'+data[i].vlrDesconto+'</td>';
        tabela += '         <td>'+data[i].vlrTotal+'</td>';
        if (data[i].nroStatusVenda!='A' && data[i].nroStatusVenda!='O'){
            tabela += '         <td>&nbsp;</td>';
            desabilitaBotao()
        }else{
            tabela += "         <td><a href=\"javascript:deletarProduto("+id+", "+data[i].codProduto+", "+
                                                     " "+data[i].codVenda+","+
                                                     " "+data[i].nroSequencialVenda+","+
                                                     " "+data[i].qtdVenda+","+
                                                     " '"+data[i].vlrVenda+"',"+
                                                     " '"+data[i].vlrDesconto+"',"+
                                                     " '"+data[i].indEstoque+"');\">";
            tabela += "                  <img src='../../Resources/images/delete.png' width='20' heigh='20' alt='Remover Produto'></a></td>";
        }
        tabela += '         <td><input type="checkbox" id="'+data[i].codProduto+'S'+data[i].nroSequencial+'S'+data[i].qtdVenda+'" class="indEstoque"></td>';
        tabela += "     </tr>";
    }
    tabela += '</table> ';
    $("#vlrTotalVenda").val(data[0].vlrTotalVenda);
    $("#resultado").html(tabela);
    $(".indEstoque").click(function(){
        if (this.checked){
            if (parseInt($("#qtdEstoque"+$(this).attr("id")).val())<parseInt($("#qtdVenda"+$(this).attr("id")).val())){
                $("#dialogInformacao").html('Este item não tem em estoque!');
                $("#dialogInformacao").dialog("open");
                return false;
            }
        }
    });
}
function desabilitaBotao(button){
    $("#"+button).attr("disabled", "disabled");
    $("#"+button).css("color","gray");
}
$(document).ready(function() {
    $("#dialogInformacao").attr('style', 'text-align:center;');
    $("#btnOK").hide();
    $("#dialogInformacao").html('<img src="../../Resources/images/carregando.gif">');
    $("#dialogInformacao").dialog("open");
    $("#resultado").hide();
    if ($("#nroStatusVenda").val()=="O"){
      $("#btnPagamentos").hide();
      $("#btnResumoVenda").hide();
      $("#btnResumoOrcamento").show();
      $("#btnGerarVendas").show();
      $("#CadastroForm").dialog('option', 'title', 'Cadastro de Orçamentos');
    }else{
      $("#btnPagamentos").show();
      $("#btnResumoVenda").hide();
      $("#btnResumoOrcamento").show();
      $("#btnGerarVendas").hide();
      $("#CadastroForm").dialog('option', 'title', 'Cadastro de Vendas');
    }
    $.post('../../Controller/Vendas/ProdutosVendasController.php',
         {method:'ListarProdutosVendasGrid',
          codVenda: $("#codVenda").val()}, function(dado){
           dado = eval('('+dado+')');

          if (dado!=null && dado!=''){
              CarregaTabela(dado);
              $("#resultado").show('slow');
              $("#dialogInformacao").dialog("close");
              $("#btnOK").show();
          }else{
              $("#dialogInformacao").dialog("close");
          }
    });
    

});