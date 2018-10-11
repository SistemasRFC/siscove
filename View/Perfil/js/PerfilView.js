$(function(){
    $("#indAtivo").jqxCheckBox({ width: 120, height: 25, theme: theme });
            
    $("#CadPerfil").jqxWindow({
        autoOpen: false,
        height: 200,
        width: 400,
        theme: theme,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        isModal: true,
        title: 'Cadastro de Perfil'
    });   
    $("#listaPerfil").jqxTooltip({
        content: 'D&ecirc; um duplo clique para editar',
        position: 'mouse',
        name: 'movieTooltip',
        theme: theme });    
    $("#btnNovo").click(function(){
        $("#method").val("AddPerfil");
        $("#codPerfil").val('');
        $("#dscPerfil").val('');           
        $("#indAtivo").jqxCheckBox('uncheck');
        $("#CadPerfil").jqxWindow("open");
    });
    $("#btnSalvar").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde, salvando Perfil!");
        $( "#dialogInformacao" ).jqxWindow("open");
        if ($("#indAtivo").jqxCheckBox('val')){
            ativo = 'S';
        }else{
            ativo = 'N';
        }        
        if ($("#tpoAtendimentoAtivo").val()){
            tpoAtendimento = 'A';
        }else if ($("#tpoAtendimentoReceptivo").val()){
            tpoAtendimento = 'R';
        }else{
            tpoAtendimento = '';
        }
        $.post('../../Controller/Perfil/PerfilController.php',
            {method: $("#method").val(),
            codPerfil: $("#codPerfil").val(),
            codPerfilAnt: $("#codPerfilAnt").val(),
            dscPerfil: $("#dscPerfil").val(),
            tpoAtendimento: tpoAtendimento,
            indAtivo: ativo}, function(data){

            data = eval('('+data+')');
            if (data[0]==1){
                $( "#dialogInformacao" ).jqxWindow('setContent', "Registro salvo com sucesso!");
                $( "#CadPerfil" ).jqxWindow("close");
                CarregaGridPerfil();
                setTimeout(function(){
                    $( "#dialogInformacao" ).jqxWindow("close");
                },"2000");
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Menu!'+data[1]);
            }
        });
    });
});

function CarregaGridPerfil(){
    $("#tdListaPerfil").html('');
    $("#tdListaPerfil").html('<div id="listaPerfil"></div>');
    $('#listaPerfil').html("<img src='../../Resources/images/carregando.gif' width='200' height='30'>");
    $("#dialogInformacao").jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, carregando detalhes!<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
    $("#dialogInformacao" ).jqxWindow("open");    
    $.post('../../Controller/Perfil/PerfilController.php',
           {
               method: 'ListarPerfil'
           },
           function(listaPerfil){
                listaPerfil = eval ('('+listaPerfil+')');
                if (listaPerfil[0]==true){
                    MontaTabelaPerfil(listaPerfil[1]);
                }else{                    
                    $( "#dialogInformacao" ).jqxWindow('setContent', 'N&atilde;o foi poss&iacute;vel executar a consulta!<br>'+listaPerfil[1]);
                    $( "#dialogInformacao" ).jqxWindow('open');
                }                
           }
    );
}

function MontaTabelaPerfil(listaPerfil){
    var nomeGrid = 'listaPerfil';
    var source =
    {
        localdata: listaPerfil,
        datatype: "json",
        updaterow: function (rowid, rowdata, commit) {
            commit(true);
        },
        datafields:
        [
            { name: 'COD_PERFIL_W', type: 'string' },
            { name: 'DSC_PERFIL_W', type: 'string' },
            { name: 'IND_ATIVO', type: 'string' },
            { name: 'ATIVO', type: 'boolean' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 685,
        source: dataAdapter,
        theme: theme,
        selectionmode: 'singlerow',
        sortable: true,
        filterable: true,
        pageable: true,        
        columnsresize: true,
        columns: [
          { text: 'C&oacute;digo', columntype: 'textbox', datafield: 'COD_PERFIL_W', width: 80},
          { text: 'Descri&ccedil;&atilde;o', datafield: 'DSC_PERFIL_W', columntype: 'textbox', width: 280},
          { text: 'Ativo', datafield: 'ATIVO', columntype: 'checkbox', width: 67 }
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    // events
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        var rows = $('#'+nomeGrid).jqxGrid('getdisplayrows');
        var rowData = rows[args.visibleindex];
        var rowID = rowData.uid;
        $("#codPerfil").val($('#listaPerfil').jqxGrid('getrowdatabyid', rowID).COD_PERFIL_W);
        $("#codPerfilAnt").val($('#listaPerfil').jqxGrid('getrowdatabyid', rowID).COD_PERFIL_W);
        $("#dscPerfil").val($('#listaPerfil').jqxGrid('getrowdatabyid', rowID).DSC_PERFIL_W);                
        if ($('#listaPerfil').jqxGrid('getrowdatabyid', rowID).IND_ATIVO=='S'){            
            $("#indAtivo").jqxCheckBox('check');
        }else{            
            $("#indAtivo").jqxCheckBox('uncheck');
        }
        
        $("#method").val("UpdatePerfil");
        $("#CadPerfil").jqxWindow("open");
    });
    $( "#dialogInformacao" ).jqxWindow("close");     
}
$(document).ready(function(){
    CarregaGridPerfil();
    $(document).on('contextmenu', function (e) {
        return false;
    });
});

