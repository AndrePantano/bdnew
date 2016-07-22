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

    $(".linha").click(function(){
        $(location).attr("href",'edit.php?cliente=' + $(this).data("id"));
    });
});