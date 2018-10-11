var widthTela = screen.width;
var heightTela = screen.height;
$(document).ready(function () {
    $("#VendasClienteForm").jqxWindow({ 
        title: 'Lista de vendas deste cliente',
        height: 450,
        width: 1000,
        maxWidth: 1200,
        position: {x: (widthTela/2)-(1000/2), y: (heightTela/2)-(450/2)},
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    }); 
    $("#VendasAbertasForm").jqxWindow({ 
        title: 'Lista de vendas em aberto',
        height: 450,
        width: 1000,
        maxWidth: 1200,
        position: {x: (widthTela/2)-(1000/2), y: (heightTela/2)-(450/2)},
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });      
    $("#dialogJustificativa").jqxWindow({ 
        title: 'Justificativa',
        height: 250,
        width: 500,
        maxWidth: 1200,
        animationType: 'fade',
        position: {x: (widthTela/2)-(500/2), y: (heightTela/2)-(250/2)},
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
        position: {x: (widthTela/2)-(800/2), y: (heightTela/2)-(450/2)},
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
        position: {x: (widthTela/2)-(800/2), y: (heightTela/2)-(450/2)},
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });         
    $("#AvisoVendasAbertas").jqxWindow({ 
        title: 'Aviso',
        height: 250,
        width: 400,
        maxWidth: 1200,
        position: {x: (widthTela/2)-(400/2), y: (heightTela/2)-(250/2)},
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });         
    $("#CadVeiculos").jqxWindow({ 
        title: 'Veículo',
        height: 150,
        width: 500,
        maxWidth: 1200,
        position: {x: (widthTela/2)-(500/2), y: (heightTela/2)-(150/2)},
        animationType: 'fade',
        theme: theme,
        isModal: true,
        autoOpen: false
    });       
    $("#CadastroProdutoForm").jqxWindow({ 
        title: 'Cadastro de Produtos',
        height: 550,
        width: 600,
        position: {x: (widthTela/2)-(600/2), y: (heightTela/2)-(550/2)},
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });
    $("#HistoricoVendaForm").jqxWindow({ 
        title: 'Historico da Venda',
        height: 500,
        width: 999,
        maxWidth: 1200,
        maxHeight: 700,
        position: {x: (widthTela/2)-(999/2), y: (heightTela/2)-(550/2)},
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });
});