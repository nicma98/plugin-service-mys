<?php

/**
 * La funcionalidad específica de administración del plugin.
 *
 * @link       http://misitioweb.com
 * @since      1.0.0
 *
 * @package    Beziercode_blank
 * @subpackage Beziercode_blank/admin
 */

/**
 * Define el nombre del plugin, la versión y dos métodos para
 * Encolar la hoja de estilos específica de administración y JavaScript.
 * 
 * @since      1.0.0
 * @package    Beziercode-Blank
 * @subpackage Beziercode-Blank/admin
 * @author     Gilbert Rodríguez <email@example.com>
 * 
 * @property string $plugin_name
 * @property string $version
 */
class MYS_Admin {
    
    /**
	 * El identificador único de éste plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name  El nombre o identificador único de éste plugin
	 */
    private $plugin_name;
    
    /**
	 * Versión actual del plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version  La versión actual del plugin
	 */
    private $version;

    /**
     * 
     */
    private $menu_admin;

    /**
     * 
     */
    private $crud_db;
    
    /**
     * @param string $plugin_name nombre o identificador único de éste plugin.
     * @param string $version La versión actual del plugin.
     */
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;  
        $this->menu_admin = new MYS_Menus();
        $this->crud_db = new MYS_CRUD_DB();
        
    }
    
    /**
	 * Registra los archivos de hojas de estilos del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function enqueue_styles() {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en BC_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El BC_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
		 */
		wp_enqueue_style( $this->plugin_name, SERVICIOS_MYS_PLUGIN_URL . '/admin/css/bc-admin.css', array(), $this->version, 'all' );
        
    }
    
    /**
	 * Registra los archivos Javascript del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function enqueue_scripts() {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en BC_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El BC_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
		 */
        wp_enqueue_editor();
        wp_enqueue_script( $this->plugin_name, SERVICIOS_MYS_PLUGIN_URL . '/admin/js/bc-admin.js', ['jquery'], $this->version, true );
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
     * Funcion para registrar menu principal
     */
    public function add_menu()
    {
        $this->menu_admin->add_menu_page(
            __('Servicios MYS','servicios-mys'),
            __('Servicios MYS','servicios-mys'),
            'manage_options',
            'servicios-mys',
            [$this, 'control_display_menu'],
            '',
            15
        );

        $this->menu_admin->run();
    }

    /**
     * Funcion para usar vista de pagina admin
     */
    public function control_display_menu()
    {
        require_once SERVICIOS_MYS_DIR . 'admin/partials/mys-admin-display.php';
    }

    /**
     * Funcion para el sub menu de contacto clientes
     */
    public function add_submenu_contacto_clientes()
    {
        $this->menu_admin->add_submenu_page(
            'servicios-mys',
            __('Contacto clientes','servicios-mys'),
            __('Contacto clientes','servicios-mys'),
            'manage_options',
            'clientes-mys',
            [$this, 'control_display_submenu_contacto_clientes'],
        );

        $this->menu_admin->run();
    }

    /**
     * 
     */
    public function control_display_submenu_contacto_clientes()
    {
        require_once SERVICIOS_MYS_DIR . 'admin/partials/mys-admin-display-clientes.php';
    }

    /**
     * 
     */
    public function get_list_clientes()
    {
        return $this->crud_db->get_clientes();
    }
    
}