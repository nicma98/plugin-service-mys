<?php

/**
 * Ésta clase define todo lo necesario durante la activación del plugin
 *
 * @package     Motos&Servitecas_Web
 */
class MYS_Activator
{

	/**
	 * Método estático que se ejecuta al activar el plugin
	 *
	 * Creación de la tabla {$wpdb->prefix}servicios_mys_clientes
	 */
	public static function activate() {
		global $wpdb;

		$sql = "CREATE TABLE IF NOT EXISTS " . SERVICIOS_MYS_CLIENTES_TABLE . " (
			id int(11) NOT NULL AUTO_INCREMENT,
			date_stmp TIMESTAMP,
			nombre_cliente varchar(50) NOT NULL,
			telefono_cliente varchar(50) NOT NULL,
			correo_cliente varchar(50) NOT NULL,
			sku_product varchar(50) NOT NULL,
		 	PRIMARY KEY (id) 
		);";

		$wpdb->query($sql);

		// Creación de la nueva opcion de Wordpress
		add_option('server_ip_sia','45.169.253.67,8358');
		add_option('paswd_db_sia','MotosQ1w2e3r4*/*');
		add_option('user_db_sia','MotosUser');
	}

}





