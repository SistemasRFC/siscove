$(function() {
    $("#VendasForm").jqxWindow({ 
        title: 'Lista de vendas deste cliente',
        height: 450,
        width: 1000,
        maxWidth: 1200,
        position: { x: 200, y: 100 },
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });  
    
    $("#dtaNascimento").jqxDateTimeInput({width: '147px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    
    $("#btnDeletarCliente").click(function( event ) {
        DeletarCliente();       
    }); 
    
    $("#btnVendasCliente").click(function( event ) {
        VendasCliente();       
    }); 
    
    $("#btnRelVendasCliente").click(function( event ) {
        window.open('../../View/Cliente/RelVendasCliente.php?codCliente='+$('#codCliente').val(),'page','left=100,top=50,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=700,height=500');               
    });  
    
    $("#nroCep").on('blur', function(){
        if ($(this).val()!=''){
            pesquisaCEP();
        }
    });    
    
    $("#nroCpf").blur(function(){
       if ((!valCpf($("#nroCpf").val()))&&($("#nroCpf").val()!='')){
            $( "#dialogInformacao" ).jqxWindow('setContent', "<h4 style='text-align:center;'>CPF Inv&aacute;lido!</h4>");
            $( "#dialogInformacao" ).jqxWindow("open");    
            $("#nroCpf").focus();
        }
    });
    
    $("#btnSalvarCliente").click(function( event ) {
        SalvarCliente();
    });     
});

function DeletarCliente(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open"); 
    $.post('../../Controller/Cliente/ClienteController.php',
        {method: 'DeleteCliente',
        codCliente: $("#codCliente").val()}, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Cliente excluído com sucesso!');
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');                
                CarregaGridCliente();
            }, '2000');  
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao excluir cliente! '+data[1]);
        }
    });    
}

function VendasCliente(){
    $("#tdListaVendaCliente").html('');
    $("#tdListaVendaCliente").html('<div id="ListaVendaCliente"></div>');
    $("#ListaVendaCliente" ).html('setContent', "Aguarde!");
    $("#VendasForm" ).jqxWindow("open");     
    $.post('../../Controller/Vendas/VendasController.php',
    {method:'ListarVendasCliente',
     codClienteVenda: $("#codCliente").val(),
     tpoVendas: ''}, function(data){
        data = eval('('+data+')');
        if (data[0]){
            MontaTabelaVendas(data[1]);
        }
    });    
}

function MontaTabelaVendas(Lista){    
    var nomeGrid = 'ListaVendaCliente';
    var source =
    {
        localdata: Lista,
        datatype: "json",
        datafields:
        [
            { name: 'COD_VENDA', type: 'number' },
            { name: 'DSC_CLIENTE', type: 'string' },
            { name: 'MES_ANO', type: 'string' },
            { name: 'NME_VENDEDOR', type: 'string' },
            { name: 'DTA_VENDA', type: 'string' },
            { name: 'VLR_VENDA', type: 'string' },
            { name: 'NRO_CPF', type: 'string' },
            { name: 'NRO_CNPJ', type: 'string' },
            { name: 'DSC_VEICULO', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 950,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: false,
        pageable: false,
        columnsresize: true,
        selectionmode: 'singlerow',
        groupable: true,
        columns: [
          { text: 'Venda', dataField: 'COD_VENDA', columntype: 'textbox', width: 80 },
          { text: '', dataField: 'MES_ANO', columntype: 'textbox', width: 80 },
          { text: 'Cliente', dataField: 'DSC_CLIENTE', columntype: 'textbox', width: 180 },
          { text: 'Vendedor', dataField: 'NME_VENDEDOR', columntype: 'textbox', width: 180 },
          { text: 'Data', dataField: 'DTA_VENDA', columntype: 'textbox', width: 100 },
          { text: 'Valor', dataField: 'VLR_VENDA', columntype: 'textbox', width: 100 },
          { text: 'CPF', dataField: 'NRO_CPF', columntype: 'textbox', width: 100 },
          { text: 'CNPJ', dataField: 'NRO_CNPJ', columntype: 'textbox', width: 100 },
          { text: 'Veiculo', dataField: 'DSC_VEICULO', columntype: 'textbox', width: 150 }
          
        ],
        groups: ['MES_ANO']
    });
    $('#'+nomeGrid).jqxGrid('hidecolumn', 'MES_ANO');
    $(".jqx-grid-group-column").hide();  
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        window.open('../../Controller/Relatorios/RelatoriosVendasController.php?codVenda='+$('#ListaVendaCliente').jqxGrid('getrowdatabyid', args.rowindex).COD_VENDA+'&method=ResumoVenda','page','left=100,top=50,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=700,height=500');        
        
    });   
}

function pesquisaCEP(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde, pesquisando CEP!");
    $( "#dialogInformacao" ).jqxWindow("open");    
    $.post('../../Controller/Cliente/ClienteController.php',
        {
            method: 'PesquisaCep',
            nroCep: $("#nroCep").val()
        },
        function(data){
            data = eval('('+data+')');
            if (data.erro){
                $( "#dialogInformacao" ).jqxWindow('setContent', "CEP não encontrado!");
                $("#txtLogradouro").val("");
                $("#txtComplemento").val("");
                $("#nmeBairro").val("");
                $("#nmeCidade").val("");
                $("#sglUf").jqxDropDownList('selectIndex', -1 ); 
                setTimeout(function(){
                    fechaDialog();
                }, 2000);
            }else{
                $("#txtLogradouro").val(data.logradouro);
                $("#txtComplemento").val(data.complemento);
                $("#nmeBairro").val(data.bairro);
                $("#nmeCidade").val(data.localidade);
                $("#sglUf").val(data.uf);
                $( "#dialogInformacao" ).jqxWindow("close");   
            }
        }
    );    
}

$(document).ready(function(){
    MontaComboTipoPessoa('comboCodTipoPessoa', 'codTipoPessoa', '-1'); 
    CriarCombo('sglUf', 
               '../../Controller/Cliente/ClienteController.php', 
               'method;ListarEstados', 
               'SGL_ESTADO|DSC_ESTADO', 
               'DSC_ESTADO', 
               'SGL_ESTADO');     
    $(".trCPF").html("");
    escondeDivById('nroCnpj');
    escondeDivById('nroCpf');
});