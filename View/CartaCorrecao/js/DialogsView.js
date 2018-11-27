var widthTela = screen.width;
var heightTela = screen.height;
$(document).ready(function () {
    $("#CartaCorrecaoForm").jqxWindow({ 
        title: 'Carta de Correção',
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
});