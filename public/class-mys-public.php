<?php
/**
 * 
 */
class MYS_Public {
    
    /**
	 * El identificador único de éste plugin
	 */
    private $plugin_name;
    
    /**
	 * Versión actual del plugin
	 */
    private $version;

    /**
     * Atributo asociado a la clase CRUD que interactua con la base de datos de SIASOFT
     */
    private $crud_db;
    
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name  = $plugin_name;
        $this->version      = $version;
    }
    
    /**
     * Archivo de estilos del formulario publico.
     */
    public function enqueue_styles() {
        
        wp_enqueue_style( $this->plugin_name, SERVICIOS_MYS_PLUGIN_URL . '/public/css/form-contact.css', array(), $this->version, 'all' );
        
    }
    
    /**
     * Script de JS para el formulario publico.
     */
    public function enqueue_scripts() {
        
        wp_enqueue_script( $this->plugin_name, SERVICIOS_MYS_PLUGIN_URL . '/public/js/post-contact.js', array( 'jquery' ), $this->version, true );

        wp_localize_script(
            $this->plugin_name,
            'object_ajax',
            [
                'url' => admin_url('admin-ajax.php'),
                'token' => wp_create_nonce('mys_token')
            ]
        );
        
    }

    /**
     * Formulario publico para los lcientes.
     */
    public function mys_services_contacto_clientes_form()
    {
        if (!empty(get_field("en_importacion")) && null !== get_field("en_importacion")){
            global $product;
            ?>
            <div class="contact-cliente-sect">
                <button id="contactoform" type="submit" name="contact-cliente" class="button alt">¡Quiero saber cuando est&eacute; disponible!</button>
                <form method="post" id="form-cliente">
                    <input type="hidden" name="id" id="id-producto" value="<?php echo $product->get_id(); ?>">
                    <div class="form-field">
                        <label for="nombre">Nombre: </label><input type="text" name="nombre" id="nombre" required="required">
                    </div>
                    <div class="form-field">
                        <label for="telefono">Tel&eacute;fono: </label><input type="tel" name="telefono" id="telefono" required="required"></br>
                    </div>
                    <div class="form-field">
                        <label for="correo">Correo electr&oacute;nico: </label><input type="email" name="correo" id="correo" required="required"></br>
                    </div>
                    <div class="form-note" id="msg-correo">
                        Verifique el <strong>Correo electr&oacute;nico</strong>.
                    </div>
                    <div class="form-button">
                        <a class="button add_to_cart_button" id="botonenviar">Enviar</a>
                    </div>
                </form>
                <div class="form-note" id="msg-progress">
                    La informaci&oacute;n ha sido enviada exitosamente, te contaremos cuando est&eacute; disponible este producto..
                </div>
            </div>
            <?php
        }
    }

    public function mys_services_get_referencia_api()
    {
        global $product;

        // Funcion para cambiar precio de las referencias
        if($product->is_type('simple') && get_field('tipo_producto')[0] == 'normal'){

            $url = 'https://reportes.siasoft.slm.cloud:51708/api/MotosServitecas/ReferenciaServiteca';

            $args_api = array("referencia" => $product->get_sku());

            $body_api = json_encode(array($args_api));

            $args = array(
                "headers" => [
                    "Content-Type" => "application/json"
                ],
                "body" => $body_api
            );
            
            $responde = wp_remote_post($url, $args);

            // Condicional para consultas vacias
            if( count(json_decode($responde['body'])) == 0) {
                return;
            }

            $ref_sia = json_decode($responde['body'])[0];

            // Creacion de la variable precio
            $precio = $ref_sia->precio;

            // Cambiar la propiedad precio del producto
            
            // Cambiar la propiedad precio del producto en la base de datos

            if ($product->is_on_sale()){
                update_post_meta( $product->get_id(), '_regular_price', $precio);
                update_post_meta( $product->get_id(), '_price', get_post_meta( $product->get_id(), '_sale_price', true));
            }else{
                $product->set_price($precio);
                update_post_meta( $product->get_id(), '_price', $precio);
                update_post_meta( $product->get_id(), '_regular_price', $precio);
            }

            // Eliminar información transitoria del producto
            wc_delete_product_transients($product->get_id());
        }

        // Funcion para consultar saldo de las referencias.
        if($product->is_type('simple') && get_field('tipo_producto')[0] == 'normal' && $product->get_manage_stock()){
            
            $url = 'https://reportes.siasoft.slm.cloud:51708/api/MotosServitecas/SaldoServiteca';

            $args_api = array(
                "referencia" => $product->get_sku(),
                "bodega" => "001"
            );

            $body_api = json_encode($args_api);

            $args = array(
                "headers" => [
                    "Content-Type" => "application/json"
                ],
                "body" => $body_api
            );
            
            $responde = wp_remote_post($url, $args);

            $stock_q = json_decode($responde['body']);

            if($stock_q == '0'){
                $product->set_stock_status('outofstock');
                update_post_meta( $product->get_id(), '_stock_status', 'outofstock');
            }else{
                $product->set_stock_status('instock');
                update_post_meta( $product->get_id(), '_stock_status', 'instock');
            }

            update_post_meta( $product->get_id(), '_stock', $stock_q);

            wc_delete_product_transients($product->get_id());

        }

        // Funcion para consultar saldo de las referencias VARIABLES.
        if($product->is_type('variable') && get_field('tipo_producto')[0] == 'normal'){
            foreach ($product->get_available_variations('objects') as $product_woo){

                $url = 'https://reportes.siasoft.slm.cloud:51708/api/MotosServitecas/SaldoServiteca';

                $args_api = array(
                    "referencia" => $product_woo->get_sku(),
                    "bodega" => "001"
                );

                $body_api = json_encode($args_api);

                echo "<pre>";
                var_dump( $body_api );
                echo "</pre>";

                $args = array(
                    "headers" => [
                        "Content-Type" => "application/json"
                    ],
                    "body" => $body_api
                );
                
                $responde = wp_remote_post($url, $args);

                $stock_q = json_decode($responde['body']);
                
                $stock_q = strval(intval($stock['saldo']));

                $product_woo->set_stock_quantity($stock_q);

                if($stock_q == '0'){
                    $product_woo->set_stock_status('outofstock');
                    update_post_meta( $product_woo->get_id(), '_stock_status', 'outofstock');
                }else{
                    $product_woo->set_stock_status('instock');
                    update_post_meta( $product_woo->get_id(), '_stock_status', 'instock');
                }

                update_post_meta( $product_woo->get_id(), '_stock', $stock_q);

                wc_delete_product_transients($product_woo->get_id());

            };
        }

        // Funcion para consultar saldo de las referencias VARIABLES.
        if($product->is_type('variable') && get_field('tipo_producto')[0] == 'normal'){
            
            foreach ($product->get_available_variations('objects') as $product_woo){

                $url = 'https://reportes.siasoft.slm.cloud:51708/api/MotosServitecas/ReferenciaServiteca';

                $args_api = array("referencia" => $product_woo->get_sku());

                $body_api = json_encode(array($args_api));

                $args = array(
                    "headers" => [
                        "Content-Type" => "application/json"
                    ],
                    "body" => $body_api
                );
                
                $responde = wp_remote_post($url, $args);

                // Condicional para consultas vacias
                if( count(json_decode($responde['body'])) == 0) {
                    return;
                }

                $ref_sia = json_decode($responde['body'])[0];

                // Creacion de la variable precio
                $precio = $ref_sia->precio;

                if ($product_woo->is_on_sale()){
                    update_post_meta( $product_woo->get_id(), '_regular_price', $precio);
                    update_post_meta( $product->get_id(), '_price', get_post_meta( $product->get_id(), '_sale_price', true));
                }else{
                    $product_woo->set_price($precio);
                    update_post_meta( $product_woo->get_id(), '_price', $precio);
                    update_post_meta( $product_woo->get_id(), '_regular_price', $precio);
                }

                // Eliminar información transitoria del producto
                wc_delete_product_transients($product_woo->get_id());
            }

        }
    }

}







