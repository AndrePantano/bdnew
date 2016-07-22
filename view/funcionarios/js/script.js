$("document").ready(function(){

    $("tr td").hover().css("cursor","pointer");

    //ALTERA A ACAO DO FORMULARIO PARA EDITAR
    $("#btn-edit").click(function(){
        $("#acao").val("edit");
    });
    
    //ALTERA A ACAO DO FORMULARIO PARA EXCLUIR
    $("#btn-delete").click(function(){
        $("#acao").val("delete");
    });

    //ALTERA A ACAO DO FORMULARIO PARA EDITAR
    $("#btn-senha").click(function(){
        $("#acao").val("senha");
    });

    $(".linha").click(function(){
        $(location).attr("href",'edit.php?funcionario=' + $(this).data("id"));
    });
});