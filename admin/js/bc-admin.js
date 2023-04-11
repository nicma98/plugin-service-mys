jQuery(document).ready(function($){
    
    function mangeClientes(){
        $(".column-delete .delete-item").each(function(index, element){
            $(element).on("click", function(e){
                
                var id_registro = $(element).data("registro_id");
    
                $($(element).parents()[1]).css("background-color", "#fdc1c1");
    
                setTimeout(function(){
                    $($(element).parents()[1]).hide("slow", function(){
                        $($(element).parents()[1]).remove();
                    });
                }, 3000);
    
                var dataSend = {
                    action: 'delete_cliente',
                    token: object_ajax.token,
                    id_registro: id_registro
                }
    
                $.ajax({
                    url: object_ajax.url,
                    method: 'post',
                    dataType: 'json',
                    data: dataSend,
                    success: function(data){
                        
                    },
                    error: function(xhr, status) {
                        console.log("Error")
                    }
                });
            });
        });
    }

    mangeClientes();

    function itemComercialHeader(){

        config_editor = {
            tinymce: {
                min_height: 150,
                toolbar1: "bold,italic,underline,link"
            }
        }

        wp.editor.initialize('aviso-comercial', config_editor);

        $('#btn-actualizar-textcomercial').on('click', function(e){
            var strContent = window.tinymce.get('aviso-comercial').getContent();
            console.log(strContent);
            $('.action-btn .loading').css("visibility","visible");
        });
    }

    //itemComercialHeader();

})