$("document").ready(function(){

    $("tr td").hover().css("cursor","pointer");

    //ALTERA A ACAO DO FORMULARIO PARA EDITAR
    $(".btn-edit").click(function(){
        var id = $(this).data("id");
        $(".acao"+id).val("edit");
    });
    
    //ALTERA A ACAO DO FORMULARIO PARA EXCLUIR
    $(".btn-delete").click(function(){
        var id = $(this).data("id");
        $(".acao"+id).val("delete");
    });

    // EDITAR A PEDRA
    $(".abre-modal").click(function(){
        var id = $(this).data("id");
        var modal = $(this).data("tipo");
        if(modal == "insert"){
            $("#"+modal).modal('show');
        }else{
            $("#"+modal+id).modal('show');
        }
        AtualizarDelta(id);
    });

    // CANCELA EDIÇÃO DA PEDRA
    $(".btn-cancela").click(function(){
        var id = $(this).data("id");
        $(".span-pedra"+id).removeClass("hidden");
        $(".form-pedra"+id).addClass("hidden");
        $(".form-pedra"+id).val(0);
        AtualizarDelta(id);
    });

    $(".repedra").on("blur",function(){
        var id = $(this).data("id");
        AtualizarDelta(id);        
    });

    $(".pvpedra").on("blur",function(){
        var id = $(this).data("id");
        AtualizarDelta(id);        
    });

    function AtualizarDelta(id){
        var pv = $(".pv-pedra"+id).val();
        var re = $(".re-pedra"+id).val();

        //alert("pv = "+pv+"\n"+"re = "+re);
        
        var delta = re - pv;
        $(".delta"+id).text(delta);
        AtualizaJustificativa(id);
        
    }

    function AtualizaJustificativa(id){
        var delta = $(".delta"+id).text();
        if(delta >= 0){
            $('.idpedramotivo'+id).prop('required',false);
            $('.idpedramotivo'+id).attr('disabled','disabled');
            $('.idpedramotivo'+id).val('');
            $('.obpedra'+id).prop('required',false);
            $('.obpedra'+id).attr('disabled','disabled');
        }else{
            $('.idpedramotivo'+id).prop('required',true);
            $('.idpedramotivo'+id).removeAttr('disabled');
            $('.obpedra'+id).prop('required',true);
            $('.obpedra'+id).removeAttr('disabled');
        }
    }
    
    // ACAO DO SELECT/OPTION DO CORREDOR
    $(".corredor").change(function(){
        
        var id = $(this).data("id");
        
        $("#terminal"+id).text("Aguarde...");
        $("#cliente"+id).text("");

        if($(this).val() != ""){            
            getDados("terminal",$(this).val(),id);            
        }
    });

    // ACAO DO SELECT/OPTION DO TERMINAL
    $(".terminal").change(function(){
        
        var id = $(this).data("id");
        $("#cliente"+id).text("");

        if($(this).val() != ""){            
            getDados("cliente",$(this).val(),id);            
        }
    });

    function getDados(tabela,valor,id){
                
        $.ajax({
            url:"../../controller/pedra/pedra_gate_ajustes_controller.php",
            type:"post",
            data:"relatorio=ajustes&tabela="+tabela+"&valor="+valor,
            beforeSend:function(){
                $("#"+tabela).append("<option>Aguarde...</option>");
            },
            success:function(dados){
                
                // alert(dados.length);
                
                    $("#"+tabela+id).text("");
                    $("#"+tabela+id).append("<option value=''>Todos");
                    for(var i in dados){
                        var dado = dados[i];
                        var option = "";
                        switch(tabela){
                            case "terminal":
                                option = "<option value="+dado['idTerminal']+">"+dado['nmTerminal'];
                            break;
                            case "cliente":
                                option = "<option value="+dado['idCliente']+">"+dado['nmCliente'];
                            break;
                        }
                        $("#"+tabela+id).append(option);
                    }
                
            },
            error:function(e){
                alert(e.ResponseText);
            }
        });        
    }
    
});
   