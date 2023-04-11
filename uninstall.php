<?php

/**
 * Se activa cuando el plugin va a ser desinstalado
 *
 * @package     Motos&Servitecas_Web
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

function uninstall_plugin(){

	global $wpdb;

	$sql = "DROP TABLE " . SERVICIOS_MYS_CLIENTES_TABLE . ";";

	$wpdb->query($sql);

}

uninstall_plugin();


