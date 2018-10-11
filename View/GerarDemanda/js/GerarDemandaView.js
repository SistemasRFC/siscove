$(function() {
    $("#btnSalvarDemanda").click(function(){
        inserirDemanda();
    });
});

function inserirDemanda(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde, salvando!");
    $( "#dialogInformacao" ).jqxWindow("open");    
    $.post(URL_SISTEMA_DEMANDAS+'/Dispatch.php',
        {   method: 'InsertDemandas',
            controller: 'Demandas',
            dscDemanda: $("#txtTitulo").val(),            
            codSistema: 2,
            codSistemaOrigem: COD_SISTEMA_ORIGEM,
            codResponsaveis: '',
            codSituacao: 1,
            indPrioridade: '',
            tpoDemanda: '',
            verificaPermissao: 'N'
        }, function(data){

        data = eval('('+data+')');
        if (data[0]){
            inserirDescricao(data[2]);
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Demanda salva com sucesso!');
            setTimeout(function(){
                $("#txtTitulo").val('');
                $("#dscSolicitação").val('');
                $( "#dialogInformacao" ).jqxWindow('close');
            },"3000");
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar demanda!');
        }
    });
}

function inserirDescricao(codDemanda){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde, salvando!");
    $( "#dialogInformacao" ).jqxWindow("open");  
    $.post(URL_SISTEMA_DEMANDAS+'/Dispatch.php',
        {   method: 'InsertDescricaoDemandas',
            controller: 'DescricaoDemandas',
            txtDescricao: $("#dscSolicitação").val(),            
            tpoDescricao: 'R',
            codDemanda: codDemanda,
            codSistemaOrigem: COD_SISTEMA_ORIGEM,
            verificaPermissao: 'N'
        }, function(data){

        data = eval('('+data+')');
        if (!data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar descrição!');
        }
    });
}