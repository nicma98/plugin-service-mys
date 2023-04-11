jQuery(document).ready(function($){

    /**
     * Funcion para validar informacion del formulario
     * @returns boolean
     */
    function validaForm(){

        var status = true;

        if ( $("#form-cliente #nombre").val() == "" ){

            $("#form-cliente #nombre").addClass('no-valid');

            $("#form-cliente #nombre").on( "change", function(e){
                $("#form-cliente #nombre").removeClass('no-valid');
            })
            
            $("#form-cliente #nombre").focus();
            status = false;

        };

        if ( $("#form-cliente #telefono").val() == "" ){
            
            $("#form-cliente #telefono").addClass('no-valid');
            
            $("#form-cliente #telefono").on( "change", function(e){
                $("#form-cliente #telefono").removeClass('no-valid');
            })
            
            $("#form-cliente #telefono").focus();
            status = false;

        };

        
        var reg_correo = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

        var correo_form = $("#form-cliente #correo").val();

        if ( correo_form == "" || !reg_correo.test(correo_form) ){

            $('#form-cliente #msg-correo').show("slow", function(e){});

            $("#form-cliente #correo").addClass('no-valid');

            $("#form-cliente #correo").focus();
            status = false;

        }else{
            $("#form-cliente #correo").removeClass('no-valid');

            $('#form-cliente #msg-correo').hide("slow", function(e){});
        };

        return status;
    }
    
    $( "#contactoform" ).on("click", function(e){

        e.preventDefault();

        $("#form-cliente").toggle("slow", function(e){});

    });

    function onLoadForm(){

        $("#form-cliente #botonenviar").toggleClass("loading");

    };

    function successMsg(){

        $(".contact-cliente-sect #msg-progress").show("slow", function(){});

    }

    $( "#botonenviar" ).on("click", function(e){

        e.preventDefault();

        if( validaForm() ){

            onLoadForm();

            var nombre_cliente = $("#form-cliente #nombre").val();
            var telefono_cliente = $("#form-cliente #telefono").val();
            var correo = $("#form-cliente #correo").val();
            var id_producto = $("#form-cliente #id-producto").val();

            var dataSend = {
                action: 'clientes_encargo',
                token: object_ajax.token,
                nombre: nombre_cliente,
                telefono: telefono_cliente,
                correo: correo,
                sku_product: id_producto
            }

            $.ajax({
                url: object_ajax.url,
                method: 'post',
                dataType: 'json',
                data: dataSend,
                success: function(data){
                    onLoadForm();
                    successMsg();
                },
                error: function(xhr, status) {
                    console.log("Error");
                }
            });

        }else{
            console.log('Erro')
        }
    });
})