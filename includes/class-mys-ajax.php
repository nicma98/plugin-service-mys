<?php

/**
 * Clase que responde y maneja las peticiones Ajax
 * 
 * @package     Motos&Servitecas_Web
 */
class MYS_Ajax
{
    
    /**
     * Atributo asociado a la clase CRUD que interactua con la base de datoss
     */
    private $crud_db;

    /**
     * 
     */
    public function __construct()
    {

        $this->crud_db = new MYS_CRUD_DB();
        
    }

    public function mail_asesor_mys()
    {
        $message = "<h1>";
        $message .= "Este es un ejemplo del contenido de del mensaje de la funcion wp_mail() de WordPress";
        $message .= "</h1>";

        $headers[]= "From: Info MOTOS Y SERVITECAS <info@motosyservitecas.com.co>";

        $to = "administrativa@motosyservitecas.com.co";

        wp_mail( $to, "Tienes un contacto nuevo de un cliente", $message, $headers );

        function tipo_de_contenido_html() {
            return 'text/html';
        }

        add_filter( 'wp_mail_content_type', 'tipo_de_contenido_html' );
    }

    public function post_contacto_clientes_productos()
    {

        check_ajax_referer('mys_token','token');

        if ( isset( $_POST['action'] ) ){

            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $sku = $_POST['sku_product'];

            $result = $this->crud_db->add_cliente($nombre, $telefono, $correo, $sku);

            $this->mail_asesor_mys();

            echo $result;

            wp_die();

        }

    }

    public function post_conctacto_delete_cliente()
    {
        
        check_ajax_referer('mys_token','token');

        if ( isset( $_POST['action'] ) ){

            $id_registro = $_POST['id_registro'];

            $result = $this->crud_db->delete_cliente($id_registro);
            
            echo $result;
    
            wp_die();
            
        }     
    }
}

?>