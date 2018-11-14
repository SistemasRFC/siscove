$(document).ready(function () {
    $("#GerarVendaForm").jqxWindow({ 
        title: 'Consolidar Orçamento',
        height: 450,
        width: 500,
        maxWidth: 1200,
        position: { x: 200, y: 100 },
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });     
    $("#OrcamentosClienteForm").jqxWindow({ 
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
    $("#OrcamentosAbertasForm").jqxWindow({ 
        title: 'Lista de vendas em aberto',
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
    $("#NovoClienteForm").jqxWindow({ 
        title: 'Cadastrar novo cliente',
        height: 450,
        width: 800,
        maxWidth: 1200,
        position: { x: 200, y: 100 },
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });       
    $("#dialogRelatorioResumoVenda").jqxWindow({ 
        title: 'Resumo da venda',
        height: 450,
        width: 800,
        maxWidth: 1200,
        position: { x: 200, y: 100 },
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });         
    $("#NovoVeiculoForm").jqxWindow({ 
        title: 'Cadastrar novo veiculo',
        height: 150,
        width: 400,
        maxWidth: 1200,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });        
    $("#AvisoOrcamentosAbertas").jqxWindow({ 
        title: 'Aviso',
        height: 250,
        width: 400,
        maxWidth: 1200,
        position: { x: 300, y: 200 },
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });       
    $("#CadastroProdutoForm").jqxWindow({ 
        title: 'Cadastro de Produtos',
        height: 450,
        width: 500,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    }); 
});