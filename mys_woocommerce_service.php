<?php
/**
 * Plugin Name:   Servicios E-commerce MYS
 * Plugin URI:
 * Description:   Plugin complementario para servicios varios del E-commerce    
 * Version:       2.0.0
 * Author: Nicolas Muñoz
 * Author URI:
 * Text Domain:   servicios-mys
 *
 * @package     Motos&Servitecas_Web
 */
 
defined( 'ABSPATH' ) || die();

global $wpdb;
 
define( 'SERVICIOS_MYS_DIR', plugin_dir_path( __FILE__ ) );
define( 'SERVICIOS_MYS_PLUGIN_FILE', __FILE__ );
define( 'SERVICIOS_MYS_PLUGIN_URL', plugins_url() . '/mys_woocommerce_service' );
define( 'SERVICIOS_MYS_VERSION', '2.0.0' );
define( 'SERVICIOS_MYS_CLIENTES_TABLE', "{$wpdb->prefix}servicios_mys_clientes" );
define( 'SERVICIOS_MYS_TEXT_DOMAIN', 'servicios-mys' );

/**
 * Código que se ejecuta en la activación del plugin
 */
function servicios_mys_activate() {
    require_once SERVICIOS_MYS_DIR . 'includes/class-mys-activator.php';
	MYS_Activator::activate();
}
register_activation_hook( __FILE__, 'servicios_mys_activate' );

/**
 * Código que se ejecuta en la desactivación del plugin
 */
function servicios_mys_deactivate() {
    require_once SERVICIOS_MYS_DIR . 'includes/class-mys-deactivator.php';
	MYS_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'servicios_mys_deactivate' );
 
/**
 * Requiriendo la clase master
 */
require_once SERVICIOS_MYS_DIR . 'includes/class-mys-master.php';

/**
 * Funcion para iniciar la clase master
 */
function mys_run_master_class_plugin(){
    $master = new MYS_Master();
    $master->init();
}

mys_run_master_class_plugin();