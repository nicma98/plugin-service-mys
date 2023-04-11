<?php
require_once 'class-mys-ajax.php';
require_once 'class-mys-cargador.php';
require_once 'class-mys-menus.php';

/**
 * Clase master que incluye otras clases auxiliares
 * 
 * @package     Motos&Servitecas_Web
 */
class MYS_Master
{
    /**
     * Clase cargador para los hooks de Wordpress
     */
    protected $class_cargador;

    /**
     * Clase para el manejo en la administración de Wordpress
     */
    protected $class_admin;

    /**
     * Clase para agregar menus y sub menus en el panel de Wordpress
     */
    public $class_menus;

    /**
     * Clase para manejar las peticiones Ajax Jquery
     */
    public $class_ajax;

    /**
     * Metodo contructor de la clase
     */
    public function __construct()
    {
        $this->cargar_clases();
        $this->cargar_instancias();
        $this->definir_admin_hooks();
        $this->definir_public_hooks();
    }

    /**
     * Método para requerir las clases complementarias
     */
    public function cargar_clases()
    {
        /**
         * Clase de cargador para los hooks de Wordpress
         */
        require_once SERVICIOS_MYS_DIR . 'includes/class-mys-cargador.php';

        /**
         * Clase de menús para agregar items en el panel de Wordpress
         */
        require_once SERVICIOS_MYS_DIR . 'includes/class-mys-menus.php';

        /**
         * Clase de interacción con la base de datos
         */
        require_once SERVICIOS_MYS_DIR . 'includes/class-mys-crud-db.php';

        /**
         * Clase de métodos en el panel de Wordpress
         */
        require_once SERVICIOS_MYS_DIR . 'admin/class-mys-admin.php';

        /**
         * Clase de métodos en el formulario publico
         */
        require_once SERVICIOS_MYS_DIR . 'public/class-mys-public.php';
    }

    /**
     * Método que inicializa las clases asociadas a los atributos de la clase master
     */
    private function cargar_instancias()
    {
        $this->class_cargador =     new MYS_Cargador();
        $this->class_admin =        new MYS_Admin('mys_woocommerce_service',SERVICIOS_MYS_VERSION);
        $this->class_public =       new MYS_Public('mys_woocommerce_service',SERVICIOS_MYS_VERSION);
        $this->class_ajax =         new MYS_Ajax();
    }

    /**
     * Método que agrega las funciones en los hooks de admin
     */
    private function definir_admin_hooks() {
        
        $this->class_cargador->add_list_action( 'admin_enqueue_scripts', $this->class_admin, 'enqueue_styles' );
        $this->class_cargador->add_list_action( 'admin_enqueue_scripts', $this->class_admin, 'enqueue_scripts' );
        $this->class_cargador->add_list_action( 'admin_menu', $this->class_admin, 'add_menu' );
        $this->class_cargador->add_list_action( 'admin_menu', $this->class_admin, 'add_submenu_contacto_clientes' );
        $this->class_cargador->add_list_action( 'wp_ajax_delete_cliente', $this->class_ajax, 'post_conctacto_delete_cliente');
    }

    /**
     * Método que agrega las funciones en los hooks publicos
     */
    private function definir_public_hooks()
    {
        $this->class_cargador->add_list_action( 'wp_enqueue_scripts', $this->class_public, 'enqueue_scripts' );
        $this->class_cargador->add_list_action( 'wp_enqueue_scripts', $this->class_public, 'enqueue_styles' );
        $this->class_cargador->add_list_action( 'woocommerce_before_single_product_summary', $this->class_public, 'mys_services_contacto_clientes_form', 45);
        
        $this->class_cargador->add_list_action( 'woocommerce_before_single_product', $this->class_public, 'mys_services_get_referencia_api', 0);
        
        $this->class_cargador->add_list_action( 'woocommerce_before_shop_loop_item_title', $this->class_public, 'mys_services_get_referencia_api', 0);
        
        $this->class_cargador->add_list_action( 'wp_ajax_clientes_encargo', $this->class_ajax, 'post_contacto_clientes_productos');
    }

    /**
     * Método que carga las funciones en los hooks usando la clase cargador
     */
    public function init()
    {
        $this->class_cargador->run();
    }
}